<?php

namespace App\Mail;

use App\Models\Celebrity;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CampaignMail extends Mailable
{
    use Queueable, SerializesModels;

    public Celebrity $celebrity;

    public string $recipientEmail;

    public ?string $recipientName;

    public string $subjectText;

    public string $bodyHtml;

    public function __construct(
        Celebrity $celebrity,
        string $recipientEmail,
        ?string $recipientName,
        string $subject,
        string $bodyHtml,
    ) {
        $this->celebrity = $celebrity;
        $this->recipientEmail = $recipientEmail;
        $this->recipientName = $recipientName;
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
            ->to($this->recipientEmail, $this->recipientName ?? 'Fan')
            ->subject($this->subjectText)
            ->view('emails.campaign')
            ->with([
                'subject' => $this->subjectText,
                'celebrityName' => $this->celebrity->name,
                'tagline' => $this->celebrity->config['site_content']['hero_subtitle'] ?? 'Fan Community',
                'accentGradient' => "linear-gradient(135deg, {$accent}, {$secondary})",
                'accentColor' => $accent,
                'portalUrl' => $this->celebrity->getPortalUrl(),
                'userName' => $this->recipientName,
                'body' => $this->bodyHtml,
            ]);
    }
}