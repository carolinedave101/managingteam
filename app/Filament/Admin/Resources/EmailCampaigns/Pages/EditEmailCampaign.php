<?php

namespace App\Filament\Admin\Resources\EmailCampaigns\Pages;

use App\Filament\Admin\Resources\EmailCampaigns\EmailCampaignResource;
use App\Livewire\CampaignProcessor;
use App\Services\CampaignProcessingService;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditEmailCampaign extends EditRecord
{
    protected static string $resource = EmailCampaignResource::class;

    public function getView(): string
    {
        return 'filament.admin.resources.email-campaigns.edit-email-campaign';
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('launch')
                ->label('Launch Campaign')
                ->icon('heroicon-o-play')
                ->color('success')
                ->visible(fn () => $this->record->status === 'draft' && $this->record->total_recipients > 0)
                ->requiresConfirmation()
                ->modalHeading('Launch Email Campaign')
                ->modalDescription('This will start sending emails to all recipients. The campaign will respect the rate limits (50/hour, 1,000/day). Continue?')
                ->action(function () {
                    $this->record->update(['status' => 'sending']);

                    Notification::make()
                        ->title('Campaign launched!')
                        ->body('Emails will begin sending according to the rate limits.')
                        ->success()
                        ->send();
                }),

            Action::make('sendTest')
                ->label('Send Test')
                ->icon('heroicon-o-paper-airplane')
                ->color('gray')
                ->visible(fn () => in_array($this->record->status, ['draft', 'paused', 'sending']))
                ->modalHeading('Send Test Email')
                ->modalDescription('Send a preview of this campaign to one or more email addresses. No limits apply — this is just for testing.')
                ->modalSubmitActionLabel('Send Test')
                ->form([
                    Textarea::make('test_emails')
                        ->label('Test Email Address(es)')
                        ->required()
                        ->placeholder('manager@example.com, team@example.com')
                        ->helperText('Enter one or more email addresses separated by commas.'),
                ])
                ->action(function (array $data, CampaignProcessingService $service) {
                    $result = $service->sendTest($this->record, $data['test_emails']);

                    $notif = Notification::make()
                        ->title("Test sent — {$result['sent']} delivered, {$result['failed']} failed")
                        ->body($result['failed'] > 0 ? 'Some test emails failed. Check the logs for details.' : 'All test emails were sent successfully.');

                    $result['failed'] > 0 ? $notif->warning()->send() : $notif->success()->send();
                }),

            Action::make('pause')
                ->label('Pause')
                ->icon('heroicon-o-pause')
                ->color('warning')
                ->visible(fn () => $this->record->status === 'sending')
                ->requiresConfirmation()
                ->action(function () {
                    $this->record->update(['status' => 'paused']);

                    Notification::make()
                        ->title('Campaign paused')
                        ->body('No more emails will be sent until you resume.')
                        ->warning()
                        ->send();
                }),

            Action::make('resume')
                ->label('Resume')
                ->icon('heroicon-o-play')
                ->color('success')
                ->visible(fn () => $this->record->status === 'paused')
                ->action(function () {
                    $this->record->update(['status' => 'sending']);

                    Notification::make()
                        ->title('Campaign resumed')
                        ->body('Email sending will continue.')
                        ->success()
                        ->send();
                }),

            Action::make('back')
                ->label('Back to List')
                ->icon('heroicon-o-arrow-left')
                ->color('gray')
                ->url(EmailCampaignResource::getUrl('index')),

            DeleteAction::make()
                ->label('Delete Campaign')
                ->icon('heroicon-o-trash')
                ->color('danger')
                ->modalHeading('Delete Campaign')
                ->modalDescription('Are you sure you want to delete this campaign? This action cannot be undone. All recipients and statistics will be permanently removed.')
                ->modalSubmitActionLabel('Yes, Delete Campaign'),
        ];
    }

    protected function getFormActions(): array
    {
        return [];
    }

    public function getRelationManagers(): array
    {
        return [];
    }

    public function getCampaign(): \App\Models\EmailCampaign
    {
        return $this->record;
    }

    public function getRecipientsByStatus(string $status): int
    {
        return $this->record->recipients()->where('status', $status)->count();
    }
}