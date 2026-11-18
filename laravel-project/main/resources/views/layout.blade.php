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

                @if (!empty($site['phone']) || $waNumber !== '')
                <div class="footer-contact-sec">
                    <span class="footer-contact-heading">Direct contact</span>
                    @if (!empty($site['phone']))
                        <div class="footer-contact-item">
                            <span>Phone:</span>
                            <a href="tel:{{ preg_replace('~[^\d+]~', '', $site['phone']) }}">{{ $site['phone'] }}</a>
                        </div>
                    @endif
                    @if ($waNumber !== '')
                        <div class="footer-contact-item">
                            <span>WhatsApp:</span>
                            <a href="https://wa.me/{{ $waNumber }}" target="_blank" rel="noopener noreferrer">{{ $site['whatsapp'] }}</a>
                        </div>
                    @endif
                </div>
                @endif

                @php
                    $footerEmails = array_values(array_filter(array_map('trim', preg_split('~[\r\n,]+~', $site['email'] ?? ''))));
                @endphp
                @if (!empty($footerEmails))
                <div class="footer-contact-sec">
                    <span class="footer-contact-heading">Email inquiries</span>
                    @foreach ($footerEmails as $fEmail)
                        <div class="footer-contact-item">
                            <a href="mailto:{{ $fEmail }}">{{ $fEmail }}</a>
                        </div>
                    @endforeach
                </div>
                @endif

                @php
                    $rawAddress = trim($site['address'] ?? '');
                    $officeCards = [];
                    if (preg_match('~(Head Office|Corporate Office)~i', $rawAddress)) {
                        $parts = preg_split('~(?=(?:Head|Corporate)\s+Office)~i', $rawAddress, -1, PREG_SPLIT_NO_EMPTY);
                        foreach ($parts as $part) {
                            $pTrim = trim($part);
                            if ($pTrim === '') continue;
                            if (preg_match('~^([^:\-\n\r]+(?::\-|:|-))\s*(.*)$~is', $pTrim, $m)) {
                                $cardTitle = trim(preg_replace('~[:\-\s]+$~', '', $m[1]));
                                $cardBody = trim($m[2]);
                            } else {
                                $cardTitle = '';
                                $cardBody = $pTrim;
                            }
                            $cLines = array_values(array_filter(array_map('trim', preg_split('~\R~', $cardBody))));
                            $officeCards[] = [
                                'title' => $cardTitle,
                                'text' => implode(', ', $cLines),
                            ];
                        }
                    } else {
                        $cLines = array_values(array_filter(array_map('trim', preg_split('~\R~', $rawAddress))));
                        if (!empty($cLines)) {
                            $officeCards[] = [
                                'title' => '',
                                'text' => implode(', ', $cLines),
                            ];
                        }
                    }
                @endphp

                @foreach ($socials as $label => $url)
                    <a href="{{ $url }}" target="_blank" rel="noopener noreferrer">{{ $label }}</a>
                @endforeach

                <a class="back-to-top" href="#main" aria-label="Back to top" title="Back to top">
                    <span aria-hidden="true">↑</span>
                </a>
            </address>
        </div>

        @if (!empty($officeCards))
        <div class="site-footer__locations" aria-label="Office locations">
            <span class="footer-label">{{ count($officeCards) > 1 ? 'Locations' : 'Location' }}</span>
            <div class="footer-offices-grid{{ count($officeCards) > 1 ? ' has-multiple' : '' }}">
                @foreach ($officeCards as $card)
                    <div class="footer-office-card">
                        @if (!empty($card['title']))
                            <strong>{{ $card['title'] }}</strong>
                        @endif
                        <span>{{ $card['text'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        <div class="site-footer__bottom">
            <span>© {{ date('Y') }} Wonder Antique Metals</span>
            <span>Integrity · Professionalism · Expertise</span>
        </div>
    </footer>
</body>
</html>
