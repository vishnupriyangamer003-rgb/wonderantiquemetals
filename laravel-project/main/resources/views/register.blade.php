<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#f3f0e8">
    <title>Register · Wonder Antique Metals</title>
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

        <p class="gate__eyebrow">New user</p>
        <h1 id="gate-title">Register</h1>
        <p class="gate__lead">Enter your details. The admin will give you your pincode.</p>

        <form method="post" action="{{ route('register.store') }}" autocomplete="on" novalidate>
            @csrf
            <div class="gate__field">
                <label for="f-name">Name</label>
                <input type="text" id="f-name" name="name" value="{{ old('name') }}"
                       autocomplete="name" minlength="2" maxlength="100" required autofocus>
                @error('name')<span class="gate__fielderr">{{ $message }}</span>@enderror
            </div>
            <div class="gate__field">
                <label for="f-phone">Phone number</label>
                <input type="tel" id="f-phone" name="phone" value="{{ old('phone') }}"
                       autocomplete="tel" inputmode="tel" maxlength="20" placeholder="+91 98765 43210" required>
                @error('phone')<span class="gate__fielderr">{{ $message }}</span>@enderror
            </div>
            <div class="gate__field">
                <label for="f-email">Email</label>
                <input type="email" id="f-email" name="email" value="{{ old('email') }}"
                       autocomplete="email" maxlength="150" required>
                @error('email')<span class="gate__fielderr">{{ $message }}</span>@enderror
            </div>
            <button class="gate__btn" type="submit">Register</button>
        </form>

        <p class="gate__meta">Already have a pincode? <a href="{{ route('login') }}">Sign in</a></p>
        <p class="gate__meta">Wonder Antique Metals · Authorised visitors only</p>
    </section>
</main>
</body>
</html>
