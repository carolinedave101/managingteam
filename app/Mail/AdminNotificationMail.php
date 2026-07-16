<?php

namespace App\Mail;

use App\Models\Celebrity;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public Celebrity $celebrity;

    public ?User $fan;

    public string $actionType;

    public array $bodyLines;

    public ?string $actionUrl;

    public function __construct(
        Celebrity $celebrity,
        string $actionType,
        array $bodyLines,
        ?User $fan = null,
        ?string $actionUrl = null,
    ) {
        $this->celebrity = $celebrity;
        $this->actionType = $actionType;
        $this->bodyLines = $bodyLines;
        $this->fan = $fan;
        $this->actionUrl = $actionUrl;
    }

    public function build()
    {
        return $this
            ->from('support@managingteam.info', "{$this->celebrity->name} — ManagingTeam")
            ->subject("[Admin] {$this->actionType} — {$this->celebrity->name}")
            ->view('emails.admin-notification')
            ->with([
                'subject' => "[Admin] {$this->actionType} — {$this->celebrity->name}",
                'celebrityName' => $this->celebrity->name,
                'celebritySlug' => $this->celebrity->slug,
                'tagline' => 'Admin Notification',
                'accentGradient' => 'linear-gradient(135deg, #2563eb, #7c3aed, #db2777)',
                'portalUrl' => config('app.url'),
                'actionType' => $this->actionType,
                'bodyLines' => $this->bodyLines,
                'actionUrl' => $this->actionUrl,
                'fanName' => $this->fan?->name,
                'fanEmail' => $this->fan?->email,
            ]);
    }
}
