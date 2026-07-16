<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('subject', 'ManagingTeam')</title>
    <style>
        .email-body { margin: 0; padding: 0; background-color: #f4f4f8; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; }
        .email-container { max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,0.08); }
        .email-header { padding: 32px 40px 24px; text-align: center; }
        .email-header h1 { margin: 0; font-size: 22px; font-weight: 700; letter-spacing: -0.3px; }
        .email-body-content { padding: 0 40px 32px; font-size: 15px; line-height: 1.6; color: #334155; }
        .email-body-content p { margin: 0 0 16px; }
        .btn-primary { display: inline-block; padding: 12px 28px; border-radius: 8px; color: #ffffff !important; text-decoration: none; font-weight: 600; font-size: 14px; }
        .email-footer { padding: 24px 40px; text-align: center; font-size: 12px; color: #94a3b8; border-top: 1px solid #e2e8f0; }
        .email-footer p { margin: 4px 0; }
        .email-divider { height: 1px; background: linear-gradient(to right, transparent, #e2e8f0, transparent); margin: 24px 0; }
        @media only screen and (max-width: 480px) {
            .email-container { border-radius: 0; }
            .email-header { padding: 24px 20px 16px; }
            .email-body-content { padding: 0 20px 24px; }
            .email-footer { padding: 16px 20px; }
        }
    </style>
</head>
<body class="email-body" style="margin:0;padding:0;background-color:#f4f4f8;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#f4f4f8;padding:24px 0;">
        <tr>
            <td align="center">
                <table class="email-container" width="600" cellpadding="0" cellspacing="0" border="0" style="max-width:600px;background-color:#ffffff;border-radius:12px;overflow:hidden;box-shadow:0 2px 12px rgba(0,0,0,0.08);">
                    <tr>
                        <td class="email-header" style="padding:32px 40px 24px;text-align:center;background:{{ $accentGradient ?? 'linear-gradient(135deg, #e11d48, #db2777, #9333ea)' }};">
                            <h1 style="margin:0;font-size:22px;font-weight:700;letter-spacing:-0.3px;color:#ffffff;">
                                {{ $celebrityName ?? 'ManagingTeam' }}
                            </h1>
                            <p style="margin:6px 0 0;font-size:13px;color:rgba(255,255,255,0.85);">
                                {{ $tagline ?? 'Fan Community Portal' }}
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td class="email-body-content" style="padding:0 40px 32px;font-size:15px;line-height:1.6;color:#334155;">
                            @yield('content')
                        </td>
                    </tr>
                    <tr>
                        <td class="email-footer" style="padding:24px 40px;text-align:center;font-size:12px;color:#94a3b8;border-top:1px solid #e2e8f0;">
                            <p style="margin:4px 0;">&copy; {{ date('Y') }} {{ $celebrityName ?? 'ManagingTeam' }}. All rights reserved.</p>
                            <p style="margin:4px 0;">{{ $portalUrl ?? '' }}</p>
                            <p style="margin:4px 0;font-size:11px;color:#cbd5e1;">
                                This email was sent to you as a member of {{ $celebrityName ?? '' }}'s fan community.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
