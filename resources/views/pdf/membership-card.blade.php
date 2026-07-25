<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Membership Card - {{ $card->user->name }}</title>
    <style>
        @page {
            margin: 0;
            padding: 0;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'DejaVu Sans', 'Helvetica', 'Arial', sans-serif;
            background: #f1f5f9;
            padding: 40px;
        }
        .card-wrapper {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
        }
        .card {
            width: 100%;
            border-radius: 20px;
            overflow: hidden;
            position: relative;
            box-shadow: 0 20px 40px -12px rgba(0,0,0,0.35);
            page-break-inside: avoid;
        }
        .card-inner {
            padding: 0;
            position: relative;
        }
        .card-header {
            padding: 20px 28px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid rgba(255,255,255,0.15);
        }
        .card-header .label {
            font-size: 10px;
            letter-spacing: 3px;
            text-transform: uppercase;
            font-weight: 700;
            opacity: 0.7;
        }
        .card-header .celeb-name {
            font-size: 11px;
            letter-spacing: 2px;
            text-transform: uppercase;
            font-weight: 600;
            opacity: 0.6;
        }
        .card-body {
            padding: 28px 28px 20px;
        }
        .member-name {
            font-size: 24px;
            font-weight: 800;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }
        .member-id {
            font-size: 18px;
            font-weight: 700;
            letter-spacing: 3px;
            font-family: 'DejaVu Sans Mono', monospace;
            margin-bottom: 16px;
            opacity: 0.85;
        }
        .tier-badge {
            display: inline-block;
            padding: 4px 14px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            border: 1.5px solid rgba(255,255,255,0.35);
            margin-bottom: 20px;
        }
        .benefits-section {
            border-top: 1px solid rgba(255,255,255,0.12);
            padding-top: 16px;
            margin-top: 4px;
        }
        .benefits-title {
            font-size: 9px;
            letter-spacing: 2px;
            text-transform: uppercase;
            font-weight: 700;
            opacity: 0.6;
            margin-bottom: 8px;
        }
        .benefits-list {
            list-style: none;
            padding: 0;
            display: flex;
            flex-wrap: wrap;
            gap: 4px 12px;
        }
        .benefits-list li {
            font-size: 10px;
            padding: 0;
            opacity: 0.85;
            line-height: 1.6;
        }
        .benefits-list li:before {
            content: "✦ ";
            opacity: 0.5;
        }
        .card-footer {
            padding: 12px 28px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid rgba(255,255,255,0.08);
        }
        .card-footer .date-item {
            text-align: center;
        }
        .card-footer .date-label {
            font-size: 8px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            font-weight: 600;
            opacity: 0.5;
        }
        .card-footer .date-value {
            font-size: 10px;
            font-weight: 600;
            opacity: 0.8;
        }
        .bottom-bar {
            height: 6px;
            width: 100%;
        }

        .watermark {
            position: absolute;
            bottom: 80px;
            right: 28px;
            font-size: 8px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            opacity: 0.2;
            transform: rotate(-90deg);
            transform-origin: bottom right;
        }

        .footer-note {
            text-align: center;
            margin-top: 24px;
            font-size: 9px;
            color: #94a3b8;
            letter-spacing: 0.5px;
        }

        @media print {
            body { background: none; padding: 20px; }
            .card { box-shadow: none; border: 1px solid #ddd; }
            .footer-note { display: none; }
        }
    </style>
</head>
<body>
    @php
        $celeb = $card->celebrity;
        $theme = $celeb->config['theme'] ?? [];
        $primary = $theme['primary_color'] ?? '#ec4899';
        $secondary = $theme['secondary_color'] ?? '#8b5cf6';
    @endphp

    <div class="card-wrapper">
        <div class="card" style="background:linear-gradient(135deg, {{ $primary }}ee, {{ $secondary }}dd);color:#fff;">
            <div class="card-inner" style="padding:28px 32px 20px;display:flex;flex-direction:column;gap:18px;">
                <div style="display:flex;justify-content:space-between;align-items:flex-start;">
                    <div style="display:flex;flex-direction:column;gap:10px;">
                        <div style="background:linear-gradient(135deg,#fbbf24,#d97706);border-radius:6px;width:50px;height:38px;position:relative;overflow:hidden;box-shadow:inset 0 1px 2px rgba(255,255,255,0.4),0 2px 4px rgba(0,0,0,0.2);">
                            <div style="position:absolute;top:8px;left:10px;right:10px;height:3px;border-radius:2px;background:rgba(255,255,255,0.25);"></div>
                            <div style="position:absolute;bottom:8px;left:12px;right:12px;height:3px;border-radius:2px;background:rgba(255,255,255,0.15);"></div>
                            <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);width:14px;height:14px;border-radius:50%;border:2px solid rgba(255,255,255,0.2);"></div>
                        </div>
                    </div>
                    <div style="text-align:right;">
                        <div style="width:46px;height:32px;border-radius:6px;background:rgba(255,255,255,0.15);border:1px solid rgba(255,255,255,0.1);display:flex;align-items:center;justify-content:center;">
                            <span style="font-size:11px;font-weight:800;letter-spacing:2px;color:rgba(255,255,255,0.7);">MT</span>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="member-id">{{ $card->card_number }}</div>
                </div>

                <div style="display:flex;justify-content:space-between;align-items:flex-end;">
                    <div>
                        <div style="font-size:8px;letter-spacing:2px;text-transform:uppercase;opacity:0.4;margin-bottom:2px;">Card Holder</div>
                        <div style="font-size:16px;font-weight:700;letter-spacing:0.5px;">{{ $card->user->name }}</div>
                    </div>
                    <div style="text-align:right;">
                        <div style="font-size:8px;letter-spacing:2px;text-transform:uppercase;opacity:0.4;margin-bottom:2px;">Valid Thru</div>
                        <div style="font-size:14px;font-weight:700;font-family:'DejaVu Sans Mono',monospace;">{{ $card->expires_at?->format('m/y') ?? '--' }}</div>
                    </div>
                    <div style="text-align:right;">
                        <div style="font-size:8px;letter-spacing:2px;text-transform:uppercase;opacity:0.4;margin-bottom:2px;">Tier</div>
                        <div style="font-size:12px;font-weight:700;text-transform:uppercase;">{{ $card->tier }}</div>
                    </div>
                </div>

                <div style="display:flex;justify-content:space-between;align-items:center;margin-top:4px;">
                    <div style="display:flex;align-items:center;gap:6px;">
                        <span style="display:inline-block;width:6px;height:6px;border-radius:50%;{{ $card->is_active ? 'background:#34d399;' : 'background:#fbbf24;' }}"></span>
                        <span style="font-size:9px;font-weight:700;letter-spacing:1px;text-transform:uppercase;{{ $card->is_active ? 'color:#6ee7b7;' : 'color:#fde68a;' }}">{{ $card->is_active ? 'Active' : 'Pending' }}</span>
                    </div>
                    <span style="font-size:9px;letter-spacing:2px;text-transform:uppercase;opacity:0.4;">{{ $celeb->name }}</span>
                </div>

                <div class="bottom-bar" style="height:4px;width:100%;background:linear-gradient(90deg,{{ $primary }},{{ $secondary }});border-radius:2px;margin-top:2px;"></div>

                <div style="border-top:1px solid rgba(255,255,255,0.1);padding-top:14px;display:flex;justify-content:space-between;font-size:8px;opacity:0.5;letter-spacing:0.5px;">
                    <span>Issued: {{ $card->issued_at?->format('d M Y') ?? '—' }}</span>
                    <span>Status: {{ $card->is_active ? 'Active' : 'Pending' }}</span>
                    <span>Expires: {{ $card->expires_at?->format('d M Y') ?? 'Lifetime' }}</span>
                </div>
            </div>
        </div>

        <div class="footer-note">
            This card is the property of {{ $celeb->name }} Management Team. Non-transferable.
        </div>
    </div>
</body>
</html>
