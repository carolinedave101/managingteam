@extends('emails.layout')

@section('subject', $subject)

@section('content')
    <p style="margin:0 0 16px;font-size:16px;">Hi <strong>{{ $userName }}</strong>,</p>

    @foreach ($bodyLines as $line)
        @if ($line)
            <p style="margin:0 0 12px;">{!! $line !!}</p>
        @endif
    @endforeach

    @if ($actionText && $actionUrl)
        <div style="text-align:center;margin:28px 0 8px;">
            <a href="{{ $actionUrl }}" class="btn-primary" style="display:inline-block;padding:12px 28px;border-radius:8px;color:#ffffff !important;text-decoration:none;font-weight:600;font-size:14px;background:{{ $accentGradient ?? 'linear-gradient(135deg, #e11d48, #db2777, #9333ea)' }};">
                {{ $actionText }}
            </a>
        </div>
    @endif

    <div class="email-divider" style="height:1px;background:linear-gradient(to right, transparent, #e2e8f0, transparent);margin:24px 0;"></div>

    <p style="margin:0;font-size:13px;color:#64748b;">
        Cheers,<br>
        <strong>{{ $celebrityName }} Management Team</strong>
    </p>
@endsection
