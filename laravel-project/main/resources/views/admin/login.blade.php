<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign in · Wonder Antique Metals</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/images/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/admin.css') }}?v={{ @filemtime(public_path('assets/admin/admin.css')) }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.8/dist/sweetalert2.all.min.js" defer></script>
    <script src="{{ asset('assets/admin/admin.js') }}?v={{ @filemtime(public_path('assets/admin/admin.js')) }}" defer></script>
</head>
<body class="adm adm-login">
    <main class="adm-login__shell">
        <section class="adm-login__art" aria-label="Wonder Antique Metals">
            <div class="adm-login__brand">
                <span class="adm-logo" aria-hidden="true"><span>W</span></span>
                <span class="adm-login__brandname">Wonder <em>Antique Metals</em></span>
            </div>
            @include('admin._antiques')
            <p class="adm-login__tagline">A considered view of value.<br><span>Manage your antiques, services and content in one place.</span></p>
        </section>

        <section class="adm-login__panel">
            <h1>Welcome back</h1>
            <p class="adm-muted">Sign in to manage the website.</p>

            @if ($errors->any())
                <div class="adm-flash adm-flash--err" role="alert" data-flash="err">{{ $errors->first() }}</div>
            @endif

            <form method="post" action="{{ route('admin.login.submit') }}" autocomplete="on">
                @csrf
                <div class="adm-field">
                    <label for="f-username">Username</label>
                    <div class="adm-has-icon adm-input">
                        <span class="adm-in-icon">@include('admin._icon', ['name' => 'user'])</span>
                        <input type="text" id="f-username" name="username" value="{{ old('username') }}" autocomplete="username" maxlength="100" required autofocus>
                    </div>
                </div>
                @include('admin._password', ['name' => 'password', 'label' => 'Password', 'value' => '', 'autocomplete' => 'current-password', 'icon' => 'lock'])
                <button class="adm-btn adm-btn--primary adm-btn--block" type="submit">Sign in</button>
            </form>
            <p class="adm-login__note">@include('admin._icon', ['name' => 'lock']) Authorised staff only</p>
        </section>
    </main>
</body>
</html>
