<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#f3f0e8">
    <title>Sign in · Wonder Antique Metals</title>
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('assets/images/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <style>
        .gate { min-height: 100vh; display: grid; place-items: center; padding: 40px 20px; background: var(--paper, #f3f0e8); }
        .gate__card {
            width: 100%; max-width: 460px; background: #fff;
            border: 1px solid var(--line, rgba(41, 38, 33, .18));
            border-radius: 4px; padding: 46px 38px 38px;
            box-shadow: 0 24px 60px rgba(41, 38, 33, .10);
        }
        .gate__brand { display: flex; align-items: center; gap: 12px; margin-bottom: 30px; }
        .gate__brand img { height: 44px; width: auto; }
        .gate__brand span { font: 400 20px/1.2 var(--serif, "Bodoni 72", "Didot", serif); }
        .gate__brand span em { font-style: italic; color: var(--rust, #a64c38); }
        .gate__eyebrow { margin: 0 0 8px; font-size: 11px; letter-spacing: .22em; text-transform: uppercase; color: var(--rust, #a64c38); }
        .gate h1 { margin: 0 0 10px; font: 400 30px/1.2 var(--serif, "Bodoni 72", "Didot", serif); }
        .gate__lead { margin: 0 0 26px; color: var(--muted, #777166); font-size: 14.5px; }
        .gate__field { display: grid; gap: 7px; margin-bottom: 20px; }
        .gate__field label { font-size: 12px; letter-spacing: .14em; text-transform: uppercase; font-weight: 700; }
        .gate__field input {
            width: 100%; padding: 14px 15px; font: inherit; color: inherit;
            background: var(--paper, #f3f0e8);
            border: 1px solid var(--line, rgba(41, 38, 33, .18)); border-radius: 3px;
        }
        .gate__field input:focus { outline: 2px solid var(--rust, #a64c38); outline-offset: 1px; border-color: transparent; }
        .gate__code { text-align: center; font-size: 34px; letter-spacing: .42em; text-transform: uppercase; font-weight: 700; }
        .gate__btn {
            display: inline-flex; align-items: center; justify-content: center; gap: 10px;
            width: 100%; min-height: 50px; padding: 0 18px; border: 0; cursor: pointer;
            font: 600 15px/1 inherit; letter-spacing: .14em; text-transform: uppercase;
            background: var(--ink, #292621); color: var(--paper, #f3f0e8);
            transition: background-color 180ms ease, transform 180ms ease;
        }
        .gate__btn:hover, .gate__btn:focus-visible { background: var(--rust, #a64c38); transform: translateY(-2px); }
        .gate__btn--ghost { background: transparent; color: var(--ink, #292621); border: 1px solid var(--line, rgba(41, 38, 33, .18)); }
        .gate__btn--ghost:hover, .gate__btn--ghost:focus-visible { background: var(--paper, #f3f0e8); color: var(--ink, #292621); }
        .gate__errors { margin: 0 0 18px; padding: 12px 15px; background: #fde4e2; color: #b3261e; border-radius: 3px; font-size: 14px; }
        .gate__status { margin: 0 0 18px; padding: 12px 15px; background: #dff3e8; color: #1f7a4d; border-radius: 3px; font-size: 14px; }
        .gate__meta { margin: 18px 0 0; font-size: 13px; color: var(--muted, #777166); text-align: center; }
        .gate__meta a { color: var(--rust, #a64c38); }
        .gate__steps { display: flex; gap: 8px; margin-bottom: 26px; }
        .gate__step { flex: 1; height: 3px; background: var(--line, rgba(41, 38, 33, .18)); }
        .gate__step.is-on { background: var(--rust, #a64c38); }
        @media (max-width: 480px) { .gate__card { padding: 34px 22px 28px; } }
    </style>
</head>
<body>
<main class="gate">
    <section class="gate__card" aria-labelledby="gate-title">
        <div class="gate__brand">
            <img src="{{ asset('assets/images/logo.png') }}" alt="Wonder Antique Metals">
            <span>Wonder <em>Antique Metals</em></span>
        </div>

        <div class="gate__steps" aria-hidden="true">
            <span class="gate__step is-on"></span>
            <span class="gate__step {{ $step === 'otp' ? 'is-on' : '' }}"></span>
        </div>

        @if ($errors->any())
            <div class="gate__errors" role="alert">{{ $errors->first() }}</div>
        @endif
        @if (session('status'))
            <div class="gate__status" role="status">{{ session('status') }}</div>
        @endif

        @if ($step === 'username')
            <p class="gate__eyebrow">Members area</p>
            <h1 id="gate-title">Sign in</h1>
            <p class="gate__lead">Enter your username and we'll send a one-time login code.</p>

            <form method="post" action="{{ route('login.send') }}" autocomplete="on">
                @csrf
                <div class="gate__field">
                    <label for="f-username">Username</label>
                    <input type="text" id="f-username" name="username" value="{{ old('username') }}"
                           autocomplete="username" maxlength="100" required autofocus>
                </div>
                <button class="gate__btn" type="submit">Send login code</button>
            </form>
        @else
            <p class="gate__eyebrow">Step 2 of 2</p>
            <h1 id="gate-title">Enter your code</h1>
            <p class="gate__lead">
                Enter the 4-digit code for <strong>{{ $username }}</strong>.
                @if ($expiresIn > 0)
                    It expires in <span data-countdown="{{ $expiresIn }}">{{ intdiv($expiresIn, 60) }}:{{ str_pad((string) ($expiresIn % 60), 2, '0', STR_PAD_LEFT) }}</span>.
                @else
                    It has expired.
                @endif
            </p>

            <form method="post" action="{{ route('login.verify') }}" autocomplete="one-time-code">
                @csrf
                <div class="gate__field">
                    <label for="f-code">Login code</label>
                    <input type="text" inputmode="numeric" pattern="[0-9]{4}" id="f-code" name="code"
                           class="gate__code" value="{{ old('code') }}"
                           autocomplete="one-time-code" maxlength="4" required autofocus>
                </div>
                <button class="gate__btn" type="submit">Sign in</button>
            </form>

            <p class="gate__meta">
                <a href="{{ route('login') }}">← Use a different username</a>
            </p>
            <form method="post" action="{{ route('login.resend') }}">
                @csrf
                <button class="gate__btn gate__btn--ghost" type="submit" style="margin-top:10px;">Resend code</button>
            </form>
        @endif

        <p class="gate__meta">Wonder Antique Metals · Authorised visitors only</p>
    </section>
</main>
<script>
    (function () {
        var el = document.querySelector('[data-countdown]');
        if (!el) return;
        var left = parseInt(el.getAttribute('data-countdown'), 10) || 0;
        setInterval(function () {
            if (left <= 0) { el.textContent = 'expired'; return; }
            left -= 1;
            var m = Math.floor(left / 60), s = left % 60;
            el.textContent = m + ':' + String(s).padStart(2, '0');
        }, 1000);
    })();
</script>
</body>
</html>
