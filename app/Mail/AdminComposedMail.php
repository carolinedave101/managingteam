<?php

namespace App\Mail;

use App\Models\Celebrity;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminComposedMail extends Mailable
{
    use Queueable, SerializesModels;

    public Celebrity $celebrity;

    public User $fan;

    public string $subjectText;

    public string $bodyHtml;

    public function __construct(Celebrity $celebrity, User $fan, string $subject, string $bodyHtml)
    {
        $this->celebrity = $celebrity;
        $this->fan = $fan;
        $this->subjectText = $subject;
        $this->bodyHtml = $bodyHtml;
    }

    public function build()
    {
        $theme = $this->celebrity->config['theme'] ?? [];
        $accent = $theme['primary_color'] ?? '#e11d48';
        $secondary = $theme['secondary_color'] ?? '#9333ea';

        return $this
            ->from('support@managingteam.info', $this->celebrity->name)
            ->to($this->fan->email, $this->fan->name)
            ->subject($this->subjectText)
            ->view('emails.admin-composed')
            ->with([
                'subject' => $this->subjectText,
                'celebrityName' => $this->celebrity->name,
                'tagline' => 'Official Communication',
                'accentGradient' => "linear-gradient(135deg, {$accent}, {$secondary})",
                'accentColor' => $accent,
                'portalUrl' => $this->celebrity->getPortalUrl(),
                'userName' => $this->fan->name,
                'body' => $this->bodyHtml,
            ]);
    }
}
