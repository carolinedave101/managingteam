@extends('emails.layout')

@section('subject', $subject)

@section('content')
    <div style="margin:0 0 16px;font-size:15px;line-height:1.7;color:#334155;">
        {!! $body !!}
    </div>

    @if ($portalUrl)
        <div style="text-align:center;margin:28px 0 8px;">
            <a href="{{ $portalUrl }}" class="btn-primary" style="display:inline-block;padding:12px 28px;border-radius:8px;color:#ffffff !important;text-decoration:none;font-weight:600;font-size:14px;background:{{ $accentGradient ?? 'linear-gradient(135deg, #e11d48, #db2777, #9333ea)' }};">
                Visit {{ $celebrityName }}'s Portal
            </a>
        </div>
    @endif

    <div class="email-divider" style="height:1px;background:linear-gradient(to right, transparent, #e2e8f0, transparent);margin:24px 0;"></div>

    <p style="margin:0 0 4px;font-size:13px;color:#64748b;">
        Cheers,<br>
        <strong>{{ $celebrityName }} Management Team</strong>
    </p>
    <p style="margin:8px 0 0;font-size:11px;color:#94a3b8;">
        You're receiving this because you're part of the {{ $celebrityName }} fan community.
        If you'd prefer not to receive future emails, reply with "UNSUBSCRIBE".
    </p>
@endsection