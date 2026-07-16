@extends('emails.layout')

@section('subject', $subject)

@section('content')
    <p style="margin:0 0 16px;font-size:16px;">Hello Admin,</p>

    <p style="margin:0 0 12px;">
        <strong>{{ $actionType }}</strong> &mdash; {{ $celebrityName }} ({{ $celebritySlug }})
    </p>

    @foreach ($bodyLines as $line)
        <p style="margin:0 0 12px;">{!! $line !!}</p>
    @endforeach

    @if ($fanName)
        <p style="margin:8px 0 12px;padding:12px 16px;background:#f8fafc;border-radius:8px;font-size:13px;color:#475569;">
            <strong>Fan:</strong> {{ $fanName }} &lt;{{ $fanEmail }}&gt;
        </p>
    @endif

    @if ($actionUrl)
        <div style="text-align:center;margin:28px 0 8px;">
            <a href="{{ $actionUrl }}" style="display:inline-block;padding:12px 28px;border-radius:8px;color:#ffffff !important;text-decoration:none;font-weight:600;font-size:14px;background:linear-gradient(135deg, #2563eb, #7c3aed);">
                View in Admin Panel
            </a>
        </div>
    @endif

    <div class="email-divider" style="height:1px;background:linear-gradient(to right, transparent, #e2e8f0, transparent);margin:24px 0;"></div>

    <p style="margin:0;font-size:13px;color:#64748b;">
        This is an automated notification from your Celebrity Management Portal.
    </p>
@endsection
