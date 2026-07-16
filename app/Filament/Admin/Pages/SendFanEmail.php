<?php

namespace App\Filament\Admin\Pages;

use App\Mail\AdminComposedMail;
use App\Models\Celebrity;
use App\Models\Message;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Mail;

class SendFanEmail extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedEnvelope;

    protected static ?int $navigationSort = 4;

    protected string $view = 'filament.admin.pages.send-fan-email';

    public ?array $data = [];

    public static function getNavigationGroup(): ?string
    {
        return 'Fan Management';
    }

    public static function getNavigationLabel(): string
    {
        return 'Send Fan Email';
    }

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Section::make('Compose Email')
                    ->description('Send an email to a fan. The email will be branded with their linked celebrity\'s theme.')
                    ->schema([
                        Select::make('fan_id')
                            ->label('Fan')
                            ->placeholder('Search for a fan by name or email...')
                            ->searchable()
                            ->required()
                            ->options(fn () => User::where('role', 'fan')
                                ->with('celebrities')
                                ->get()
                                ->mapWithKeys(fn ($user) => [
                                    $user->id => $user->name.' ('.$user->email.') — '.($user->celebrities->first()?->name ?? 'No celebrity'),
                                ])
                                ->toArray()),
                        Select::make('celebrity_id')
                            ->label('Celebrity')
                            ->options(fn () => Celebrity::pluck('name', 'id'))
                            ->required()
                            ->searchable()
                            ->helperText('The email will use this celebrity\'s branding.'),
                        TextInput::make('subject')
                            ->label('Subject')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Enter email subject...'),
                        RichEditor::make('body')
                            ->label('Message')
                            ->required()
                            ->helperText('Write your message to the fan. HTML formatting is supported.'),
                    ]),
            ])
            ->statePath('data');
    }

    public function send(): void
    {
        $data = $this->form->getState();

        $fan = User::find($data['fan_id']);
        $celebrity = Celebrity::find($data['celebrity_id']);

        if (! $fan || ! $celebrity) {
            Notification::make()
                ->title('Invalid fan or celebrity selected.')
                ->danger()
                ->send();

            return;
        }

        Mail::send(new AdminComposedMail(
            celebrity: $celebrity,
            fan: $fan,
            subject: $data['subject'],
            bodyHtml: $data['body'],
        ));

        Message::create([
            'celebrity_id' => $celebrity->id,
            'sender_id' => auth()->id(),
            'receiver_id' => $fan->id,
            'subject' => $data['subject'],
            'content' => strip_tags($data['body']),
        ]);

        Notification::make()
            ->title('Email sent successfully!')
            ->body("Your message to {$fan->name} has been sent and logged.")
            ->success()
            ->send();

        $this->form->fill();
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('send')
                ->label('Send Email')
                ->submit('send')
                ->keyBindings(['mod+s']),
        ];
    }
}
