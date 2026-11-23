<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body style="margin:0;padding:24px;background:#f3f0e8;font:15px/1.6 'Helvetica Neue',Arial,sans-serif;color:#292621;">
    <div style="max-width:520px;margin:0 auto;background:#fff;border:1px solid rgba(41,38,33,.14);border-radius:14px;padding:32px 28px;">
        <p style="margin:0 0 6px;font-size:12px;letter-spacing:.18em;text-transform:uppercase;color:#a64c38;">Wonder Antique Metals</p>
        <h1 style="margin:0 0 14px;font:400 26px/1.25 'Bodoni 72','Didot','Times New Roman',serif;">Login PIN</h1>
        <p style="margin:0 0 12px;">A sign-in was requested by:</p>
        <table role="presentation" style="margin:0 0 18px;border-collapse:collapse;">
            <tr><td style="padding:2px 14px 2px 0;color:#777166;">Name</td><td><strong>{{ $name }}</strong></td></tr>
            <tr><td style="padding:2px 14px 2px 0;color:#777166;">Phone</td><td><strong>{{ $phone }}</strong></td></tr>
            <tr><td style="padding:2px 14px 2px 0;color:#777166;">Email</td><td><strong>{{ $email }}</strong></td></tr>
        </table>
        <p style="margin:0 0 22px;text-align:center;">
            <span style="display:inline-block;padding:16px 26px;background:#292621;color:#f3f0e8;font-size:34px;letter-spacing:.32em;font-weight:700;border-radius:10px;">{{ $code }}</span>
        </p>
        <p style="margin:0;color:#777166;font-size:13px;">
            Share this PIN with the client so they can sign in. It is the same PIN every time this person signs in.
            The sign-in step stays open for {{ $minutes }} minute{{ $minutes === 1 ? '' : 's' }}.
            If you did not expect this request, you can ignore this email.
        </p>
    </div>
</body>
</html>
