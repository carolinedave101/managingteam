<?php

namespace App\Filament\Admin\Resources\Messages\Pages;

use App\Filament\Admin\Resources\Messages\MessageResource;
use App\Models\Message;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditMessage extends EditRecord
{
    protected static string $resource = MessageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('reply')
                ->label('Reply')
                ->icon('heroicon-o-arrow-uturn-left')
                ->color('primary')
                ->modalHeading('Reply to Message')
                ->modalDescription('Your reply will be sent to the original sender and added to this message thread as the management team.')
                ->form([
                    Textarea::make('content')
                        ->required()
                        ->label('Your Reply')
                        ->helperText('Type your reply as the management team. This will be visible to the fan in their message thread.'),
                ])
                ->modalSubmitActionLabel('Send Reply')
                ->action(function (array $data) {
                    $parent = $this->record;

                    Message::create([
                        'celebrity_id' => $parent->celebrity_id,
                        'sender_id' => auth()->id(),
                        'receiver_id' => $parent->sender_id,
                        'parent_id' => $parent->id,
                        'subject' => $parent->subject,
                        'content' => $data['content'],
                        'is_read' => false,
                        'reference_type' => $parent->reference_type,
                        'reference_id' => $parent->reference_id,
                    ]);

                    $parent->update(['is_read' => true]);

                    Notification::make()
                        ->title('Reply sent')
                        ->body('Your reply has been added to the message thread.')
                        ->success()
                        ->send();
                }),
            DeleteAction::make(),
        ];
    }
}
