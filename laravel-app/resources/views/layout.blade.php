@php
    // Inline @section('title', ...) values are escaped once when the section is
    // stored, so these are echoed raw below to avoid double-escaping. The
    // defaults mirror the legacy includes/header.php htmlspecialchars() fallbacks.
    $metaTitle = $__env->yieldContent(
        'title',
        'Wonder Antique Metals — Precious Metals &amp; Market Services'
    );
    $metaDescription = $__env->yieldContent(
        'description',
        'Explore technical and market support for precious metals, antique items, and rare materials.'
    );
@endphp
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{!! $metaDescription !!}">
    <meta name="theme-color" content="#f3f0e8">
    <meta name="author" content="Wonder Antique Metals">
    <meta name="robots" content="index, follow">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Wonder Antique Metals">
    <meta property="og:title" content="{!! $metaTitle !!}">
    <meta property="og:description" content="{!! $metaDescription !!}">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="{!! $metaTitle !!}">
    <meta name="twitter:description" content="{!! $metaDescription !!}">
    <title>{!! $metaTitle !!}</title>
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('assets/images/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <script src="{{ asset('assets/js/main.js') }}" defer></script>
</head>
<body>
    <div class="site-preloader" data-site-preloader aria-hidden="true">
        <div class="site-preloader__content">
            <div class="site-preloader__mark"><span>W</span></div>
            <p class="site-preloader__name">Wonder <em>Antique Metals</em></p>
            <p class="site-preloader__caption">A considered view of value</p>
            <span class="site-preloader__rule" aria-hidden="true"></span>
        </div>
    </div>
    <a class="skip-link" href="#main">Skip to content</a>
    <div class="announcement">
        <span>Precious metals · Antique items · Rare materials</span>
        <span class="announcement__right">Integrity · Expertise <span aria-hidden="true">✳</span></span>
    </div>
    <header class="site-header">
        <div class="site-header__inner">
            <a class="brand" href="{{ route('home') }}" aria-label="Wonder Antique Metals home">
                <img src="{{ asset('assets/images/logo.png') }}" alt="Wonder Antique Metals">
            </a>
            <button class="menu-toggle" type="button" aria-expanded="false" aria-controls="primary-navigation">
                <span class="menu-toggle__label">Menu</span>
                <span class="menu-toggle__icon" aria-hidden="true"><i></i><i></i></span>
            </button>
            <nav class="site-nav" id="primary-navigation" aria-label="Main navigation">
                <a class="site-nav__page-link" href="{{ route('home') }}">Home</a>
                <a class="site-nav__page-link" href="{{ route('about') }}">About</a>
                <details class="nav-dropdown">
                    <summary>
                        Antiques
                        <span class="nav-dropdown__indicator" aria-hidden="true">▾</span>
                    </summary>
                    <div class="nav-dropdown__menu">
                        <a href="{{ route('services.show', ['slug' => 'acquisition']) }}">Acquisition Services</a>
                        <a href="{{ route('services.show', ['slug' => 'assaying']) }}">Assaying Services</a>
                        <a href="{{ route('services.show', ['slug' => 'auction']) }}">Auction Services</a>
                        <a href="{{ route('services.show', ['slug' => 'monetization']) }}">Monetization</a>
                        <a href="{{ route('services.index') }}">Services</a>
                        <a href="{{ route('services.show', ['slug' => 'regulatory']) }}">Regulatory Services</a>
                    </div>
                </details>
                <details class="nav-dropdown">
                    <summary>
                        Appraisals
                        <span class="nav-dropdown__indicator" aria-hidden="true">▾</span>
                    </summary>
                    <div class="nav-dropdown__menu">
                        <a href="{{ route('appraisals.index') }}">Antique Appraisals</a>
                        <a href="{{ route('appraisals.terms') }}">Terms &amp; Conditions</a>
                        <a href="{{ route('appraisals.procedure') }}">Procedure</a>
                        <a href="{{ route('appraisals.fees') }}">Fee Structure</a>
                    </div>
                </details>
                <a class="site-nav__page-link" href="{{ route('contact') }}">Contact</a>
            </nav>
        </div>
    </header>

    @yield('content')

    <footer class="site-footer">
        <div class="site-footer__main">
            <div class="site-footer__identity">
                <a class="footer-brand" href="{{ route('home') }}">Wonder<br><em>Antique Metals</em></a>
                <p class="site-footer__statement">Technical and market support across precious metals, antique items, and rare materials, connecting assessment, regulatory guidance, acquisition, auction services, and monetization.</p>
            </div>
            <nav class="site-footer__links" aria-label="Quick links">
                <span class="footer-label">Quick links</span>
                <a href="{{ route('home') }}">Home</a>
                <a href="{{ route('about') }}">About</a>
                <a href="{{ route('services.index') }}">Services</a>
                <a href="{{ route('contact') }}">Contact</a>
            </nav>
            <div class="site-footer__links">
                <span class="footer-label">Our services</span>
                <a href="{{ route('services.show', ['slug' => 'regulatory']) }}">Regulatory support</a>
                <a href="{{ route('services.show', ['slug' => 'assaying']) }}">Assaying &amp; assessment</a>
                <a href="{{ route('services.show', ['slug' => 'acquisition']) }}">Acquisition</a>
                <a href="{{ route('services.show', ['slug' => 'auction']) }}">Auction services</a>
                <a href="{{ route('services.show', ['slug' => 'monetization']) }}">Monetization</a>
            </div>
            <address class="site-footer__contact" id="contact" aria-label="Company contact information">
                <span class="footer-label">Company information</span>
                <span>Phone: +91 00000 00000</span>
                <a href="mailto:hello@example.com">Email: hello@example.com</a>
                <span>12 Example Street, Karur, Tamil Nadu 639001, India</span>
                <a class="back-to-top" href="#main" aria-label="Back to top" title="Back to top">
                    <span aria-hidden="true">↑</span>
                </a>
            </address>
        </div>
        <div class="site-footer__bottom">
            <span>© {{ date('Y') }} Wonder Antique Metals</span>
            <span>Integrity · Professionalism · Expertise</span>
        </div>
    </footer>
</body>
</html>
