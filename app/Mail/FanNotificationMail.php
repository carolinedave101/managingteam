<?php

namespace App\Mail;

use App\Models\Celebrity;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FanNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public Celebrity $celebrity;

    public User $user;

    public string $subjectText;

    public array $bodyLines;

    public ?string $actionText;

    public ?string $actionUrl;

    public function __construct(
        Celebrity $celebrity,
        User $user,
        string $subject,
        array $bodyLines,
        ?string $actionText = null,
        ?string $actionUrl = null,
    ) {
        $this->celebrity = $celebrity;
        $this->user = $user;
        $this->subjectText = $subject;
        $this->bodyLines = $bodyLines;
        $this->actionText = $actionText;
        $this->actionUrl = $actionUrl;
    }

    public function build()
    {
        $theme = $this->celebrity->config['theme'] ?? [];
        $accent = $theme['primary_color'] ?? '#e11d48';
        $secondary = $theme['secondary_color'] ?? '#9333ea';

        return $this
            ->from('support@managingteam.info', $this->celebrity->name)
            ->to($this->user->email, $this->user->name)
            ->subject($this->subjectText)
            ->view('emails.fan-notification')
            ->with([
                'subject' => $this->subjectText,
                'celebrityName' => $this->celebrity->name,
                'tagline' => $this->celebrity->config['site_content']['hero_subtitle'] ?? 'Fan Community',
                'accentGradient' => "linear-gradient(135deg, {$accent}, {$secondary})",
                'accentColor' => $accent,
                'portalUrl' => $this->celebrity->getPortalUrl(),
                'userName' => $this->user->name,
                'userEmail' => $this->user->email,
                'bodyLines' => $this->bodyLines,
                'actionText' => $this->actionText,
                'actionUrl' => $this->actionUrl,
            ]);
    }
}
