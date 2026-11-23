<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#f3f0e8">
    <title>Sign in · Wonder Antique Metals</title>
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('assets/images/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    @include('_gate-style')
</head>
<body>
<main class="gate">
    <section class="gate__card" aria-labelledby="gate-title">
        <div class="gate__brand">
            <img src="{{ asset('assets/images/logo.png') }}" alt="Wonder Antique Metals">
            <span>Wonder <em>Antique Metals</em></span>
        </div>

        @if ($errors->any())
            <div class="gate__errors" role="alert">{{ $errors->first() }}</div>
        @endif
        @if (session('status'))
            <div class="gate__status" role="status">{{ session('status') }}</div>
        @endif

        <p class="gate__eyebrow">Members area</p>
        <h1 id="gate-title">Sign in</h1>
        <p class="gate__lead">Enter your 4-digit pincode to continue.</p>

        <form method="post" action="{{ route('login.attempt') }}" autocomplete="off">
            @csrf
            <div class="gate__field">
                <label for="f-pin">Enter pincode</label>
                <input type="password" inputmode="numeric" pattern="[0-9]{4}" id="f-pin" name="pin"
                       class="gate__code" autocomplete="one-time-code" maxlength="4" required autofocus>
            </div>
            <button class="gate__btn" type="submit">Sign in</button>
        </form>

        <p class="gate__meta">New here? <a href="{{ route('register') }}">Register</a></p>
        <p class="gate__meta">Wonder Antique Metals · Authorised visitors only</p>
    </section>
</main>
</body>
</html>
