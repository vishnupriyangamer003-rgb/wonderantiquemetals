@php
    $metaTitle = trim($__env->yieldContent('title')) ?: ($site['meta_title'] ?? '') ?: 'Wonder Antique Metals — Precious Metals & Market Services';
    $metaDescription = trim($__env->yieldContent('description')) ?: ($site['meta_description'] ?? '') ?: 'Explore technical and market support for precious metals, antique items, and rare materials.';
    $metaKeywords = $site['meta_keywords'] ?? '';
    $logo = ($site['logo'] ?? '') ?: 'assets/images/logo.png';
    $favicon = ($site['favicon'] ?? '') ?: 'assets/images/favicon.png';
    $addressLines = array_values(array_filter(array_map('trim', preg_split('~\R~', $site['address'] ?? ''))));
    $waNumber = preg_replace('~\D+~', '', $site['whatsapp'] ?? '');
    $socials = array_filter(['Facebook' => $site['facebook'] ?? '', 'Instagram' => $site['instagram'] ?? '', 'X' => $site['x'] ?? '', 'LinkedIn' => $site['linkedin'] ?? '', 'YouTube' => $site['youtube'] ?? '']);
@endphp
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $metaDescription }}">
    @if ($metaKeywords !== '')
    <meta name="keywords" content="{{ $metaKeywords }}">
    @endif
    @php
        $gaId = trim($site['google_analytics_id'] ?? '');
        $gaId = preg_match('~^(G|GT|AW|UA)-[A-Z0-9-]{4,20}$~i', $gaId) ? $gaId : '';
        $gsv = trim($site['google_site_verification'] ?? '');
        $gsv = preg_match('~^[A-Za-z0-9_-]{20,100}$~', $gsv) ? $gsv : '';
    @endphp
    @if ($gsv !== '')
    <meta name="google-site-verification" content="{{ $gsv }}">
    @endif
    @if ($gaId !== '')
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $gaId }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', @json($gaId));
    </script>
    @endif
    <meta name="theme-color" content="#f3f0e8">
    <meta name="author" content="Wonder Antique Metals">
    <meta name="robots" content="index, follow">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Wonder Antique Metals">
    <meta property="og:title" content="{{ $metaTitle }}">
    <meta property="og:description" content="{{ $metaDescription }}">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="{{ $metaTitle }}">
    <meta name="twitter:description" content="{{ $metaDescription }}">
    <title>{{ $metaTitle }}</title>
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset($favicon) }}">
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
                <img src="{{ asset($logo) }}" alt="Wonder Antique Metals">
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
                        @foreach ($siteServices as $navService)
                            <a href="{{ route('services.show', $navService->slug) }}">{{ $navService->title }}</a>
                        @endforeach
                        <a href="{{ route('services.index') }}">All services</a>
                    </div>
                </details>
                <details class="nav-dropdown">
                    <summary>
                        Appraisals
                        <span class="nav-dropdown__indicator" aria-hidden="true">▾</span>
                    </summary>
                    <div class="nav-dropdown__menu">
                        @foreach ($siteAppraisals as $navAppraisal)
                            <a href="{{ $navAppraisal->url }}">{{ $navAppraisal->nav_label }}</a>
                        @endforeach
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
                @foreach ($siteServices as $footService)
                    <a href="{{ route('services.show', $footService->slug) }}">{{ $footService->title }}</a>
                @endforeach
            </div>
            <address class="site-footer__contact" id="contact" aria-label="Company contact information">
                <span class="footer-label">Company information</span>
                @if (!empty($site['phone']))
                    <span>Phone: {{ $site['phone'] }}</span>
                @endif
                @if ($waNumber !== '')
                    <a href="https://wa.me/{{ $waNumber }}" target="_blank" rel="noopener noreferrer">WhatsApp: {{ $site['whatsapp'] }}</a>
                @endif
                @if (!empty($site['email']))
                    <a href="mailto:{{ $site['email'] }}">Email: {{ $site['email'] }}</a>
                @endif
                @if ($addressLines)
                    <span>{{ implode(', ', $addressLines) }}</span>
                @endif
                @foreach ($socials as $label => $url)
                    <a href="{{ $url }}" target="_blank" rel="noopener noreferrer">{{ $label }}</a>
                @endforeach
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
