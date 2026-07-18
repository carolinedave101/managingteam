<?php

namespace App\Filament\Admin\Pages;

use App\Models\SystemConfig;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Mail;

class MailSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-envelope';

    protected static ?int $navigationSort = 2;

    protected string $view = 'filament.admin.pages.mail-settings';

    public ?array $data = [];

    public static function getNavigationGroup(): ?string
    {
        return 'System';
    }

    public static function getNavigationLabel(): string
    {
        return 'Mail Settings';
    }

    public function mount(): void
    {
        $record = SystemConfig::where('key', 'mail.settings')->first();
        $this->form->fill($record?->value ?? []);
    }

    public function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Section::make('SMTP Server')
                    ->description('Changes take effect immediately. The system auto-retries on port failure (587 → 465 → log).')
                    ->schema([
                        TextInput::make('host')
                            ->label('SMTP Host')
                            ->placeholder('mail.managingteam.info')
                            ->helperText('Your outgoing mail server hostname.'),
                        TextInput::make('port')
                            ->label('SMTP Port')
                            ->numeric()
                            ->placeholder('587')
                            ->default(587)
                            ->helperText('Primary port. If it fails, the system retries on 465 (SSL), then falls back to logging.'),
                        TextInput::make('username')
                            ->label('Username')
                            ->placeholder('support@managingteam.info')
                            ->helperText('The full email address for SMTP authentication.'),
                        TextInput::make('password')
                            ->label('Password')
                            ->password()
                            ->helperText('The SMTP account password.'),
                    ]),
                Section::make('Sender Details')
                    ->description('Appears in the "From" field of all outgoing emails.')
                    ->schema([
                        TextInput::make('from_address')
                            ->label('From Address')
                            ->email()
                            ->placeholder('support@managingteam.info')
                            ->helperText('The email address recipients see as the sender.'),
                        TextInput::make('from_name')
                            ->label('From Name')
                            ->placeholder('Celebrity Management Team')
                            ->helperText('The name alongside the email address.'),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        SystemConfig::updateOrCreate(
            ['key' => 'mail.settings'],
            ['value' => $data],
        );

        Notification::make()
            ->title('Mail settings saved!')
            ->body('SMTP configuration updated and applied. The system will retry alternate ports if the primary fails.')
            ->success()
            ->send();
    }

    public function sendTest(): void
    {
        $this->save();

        $admin = auth()->user();

        try {
            Mail::raw(
                'This is a test email from Celebrity Management Portal. If you received this, your mail configuration is working correctly.',
                fn ($msg) => $msg->to($admin->email)->subject('Test Email — Mail Configuration Check'),
            );

            Notification::make()
                ->title('Test email sent!')
                ->body("Check {$admin->email} inbox (and spam) for the test message.")
                ->success()
                ->send();
        } catch (\Throwable $e) {
            Notification::make()
                ->title('Test email failed')
                ->body($e->getMessage())
                ->danger()
                ->persistent()
                ->send();
        }
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Save Settings')
                ->submit('save')
                ->keyBindings(['mod+s']),
            Action::make('sendTest')
                ->label('Send Test Email')
                ->submit('sendTest')
                ->color('gray')
                ->icon('heroicon-o-paper-airplane'),
        ];
    }
}
