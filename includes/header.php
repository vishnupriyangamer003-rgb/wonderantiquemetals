<?php
$metaTitle = htmlspecialchars(
    $pageTitle ?? 'Wonder Antique Metals — Precious Metals & Market Services',
    ENT_QUOTES,
    'UTF-8'
);
$metaDescription = htmlspecialchars(
    $pageDescription ?? 'Explore technical and market support for precious metals, antique items, and rare materials.',
    ENT_QUOTES,
    'UTF-8'
);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?php echo $metaDescription; ?>">
    <meta name="theme-color" content="#f3f0e8">
    <meta name="author" content="Wonder Antique Metals">
    <meta name="robots" content="index, follow">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Wonder Antique Metals">
    <meta property="og:title" content="<?php echo $metaTitle; ?>">
    <meta property="og:description" content="<?php echo $metaDescription; ?>">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="<?php echo $metaTitle; ?>">
    <meta name="twitter:description" content="<?php echo $metaDescription; ?>">
    <title><?php echo $metaTitle; ?></title>
    <link rel="icon" type="image/png" sizes="96x96" href="assets/images/favicon.png">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="assets/js/main.js" defer></script>
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
            <a class="brand" href="index.php" aria-label="Wonder Antique Metals home">
                <img src="assets/images/logo.png" alt="Wonder Antique Metals">
            </a>
            <button class="menu-toggle" type="button" aria-expanded="false" aria-controls="primary-navigation">
                <span class="menu-toggle__label">Menu</span>
                <span class="menu-toggle__icon" aria-hidden="true"><i></i><i></i></span>
            </button>
            <nav class="site-nav" id="primary-navigation" aria-label="Main navigation">
                <a class="site-nav__page-link" href="index.php">Home</a>
                <a class="site-nav__page-link" href="about.php">About</a>
                <details class="nav-dropdown">
                    <summary>
                        Antiques
                        <span class="nav-dropdown__indicator" aria-hidden="true">▾</span>
                    </summary>
                    <div class="nav-dropdown__menu">
                        <a href="service-detail.php?service=acquisition">Acquisition Services</a>
                        <a href="service-detail.php?service=assaying">Assaying Services</a>
                        <a href="service-detail.php?service=auction">Auction Services</a>
                        <a href="service-detail.php?service=monetization">Monetization</a>
                        <a href="services.php">Services</a>
                        <a href="service-detail.php?service=regulatory">Regulatory Services</a>
                    </div>
                </details>
                <details class="nav-dropdown">
                    <summary>
                        Appraisals
                        <span class="nav-dropdown__indicator" aria-hidden="true">▾</span>
                    </summary>
                    <div class="nav-dropdown__menu">
                        <a href="antique-appraisals.php">Antique Appraisals</a>
                        <a href="appraisal-terms.php">Terms &amp; Conditions</a>
                        <a href="appraisal-procedure.php">Procedure</a>
                        <a href="appraisal-fees.php">Fee Structure</a>
                    </div>
                </details>
                <a class="site-nav__page-link" href="contact.php">Contact</a>
            </nav>
        </div>
    </header>
