<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('title', 'Admin') · Wonder Antique Metals</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/images/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/admin.css') }}?v={{ @filemtime(public_path('assets/admin/admin.css')) }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.8/dist/sweetalert2.all.min.js" defer></script>
    <script src="{{ asset('assets/admin/admin.js') }}?v={{ @filemtime(public_path('assets/admin/admin.js')) }}" defer></script>
</head>
<body class="adm">
@php
    $nav = [
        ['admin.settings', 'Company info', 'building', 'admin.settings*'],
        ['admin.banners.index', 'Banners', 'image', 'admin.banners*'],
        ['admin.services.index', 'Services', 'grid', 'admin.services*'],
        ['admin.appraisals.index', 'Appraisals', 'clipboard', 'admin.appraisals*'],
        ['admin.team.index', 'Team members', 'user', 'admin.team*'],
        ['admin.account', 'Login details', 'user', 'admin.account*'],
    ];
@endphp
<div class="adm-shell">
    <aside class="adm-rail" id="adm-rail" aria-label="Admin navigation">
        <a class="adm-logo" href="{{ route('admin.settings') }}" aria-label="Dashboard"><span>W</span></a>
        <nav class="adm-nav">
            @foreach ($nav as [$route, $label, $icon, $match])
                <a href="{{ route($route) }}" class="adm-nav__link @if (request()->routeIs($match)) is-active @endif" title="{{ $label }}" aria-label="{{ $label }}" @if (request()->routeIs($match)) aria-current="page" @endif>
                    @include('admin._icon', ['name' => $icon])
                    <span class="adm-nav__label">{{ $label }}</span>
                </a>
            @endforeach
        </nav>
        <div class="adm-rail__foot">
            <form method="post" action="{{ route('admin.logout') }}" data-confirm="You will need to sign in again to manage the website." data-confirm-label="Yes, log out">
                @csrf
                <button class="adm-nav__link" type="submit" title="Log out" aria-label="Log out">
                    @include('admin._icon', ['name' => 'logout'])
                    <span class="adm-nav__label">Log out</span>
                </button>
            </form>
        </div>
    </aside>

    <main class="adm-main">
        <header class="adm-top">
            <button class="adm-burger" type="button" aria-label="Menu" aria-controls="adm-rail" aria-expanded="false" data-rail-toggle>
                @include('admin._icon', ['name' => 'menu'])
            </button>
            <div>
                <h1>@yield('heading')</h1>
                <p>@yield('sub')</p>
            </div>
            <div class="adm-top__actions">@yield('actions')</div>
        </header>

        @if (session('status'))
            <div class="adm-flash adm-flash--ok" role="status" data-flash="ok">{{ session('status') }}</div>
        @endif
        @if ($errors->any())
            <div class="adm-flash adm-flash--err" role="alert" data-flash="err">
                <strong>Please fix the following:</strong>
                <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
        @endif

        @yield('content')
    </main>
</div>
</body>
</html>
