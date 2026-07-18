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
            ->subject("[{$this->celebrity->name} Management] {$this->actionType}")
            ->view('emails.admin-notification')
            ->with([
                'subject' => "[{$this->celebrity->name} Management] {$this->actionType}",
                'celebrityName' => $this->celebrity->name,
                'celebritySlug' => $this->celebrity->slug,
                'tagline' => "{$this->celebrity->name} Management Team",
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
