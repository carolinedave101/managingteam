@extends('emails.layout')

@section('subject', $subject)

@section('content')
    <p style="margin:0 0 16px;font-size:16px;">Hi <strong>{{ $userName }}</strong>,</p>

    <div style="margin:0 0 20px;padding:20px;background:#f8fafc;border-radius:10px;border-left:4px solid {{ $accentColor ?? '#e11d48' }};font-size:15px;line-height:1.7;color:#334155;">
        {!! $body !!}
    </div>

    <p style="margin:0 0 8px;font-size:13px;color:#64748b;">
        Best regards,<br>
        <strong>{{ $celebrityName }} Team</strong>
    </p>

    <div class="email-divider" style="height:1px;background:linear-gradient(to right, transparent, #e2e8f0, transparent);margin:24px 0;"></div>

    <p style="margin:0;font-size:12px;color:#94a3b8;">
        To reply to this message, log in to your {{ $celebrityName }} portal and send a message.
    </p>
@endsection
