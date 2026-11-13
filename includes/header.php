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
                <a href="index.php">Home</a>
                <a href="about.php">About</a>
                <a href="index.php#services">Services</a>
                <details class="nav-dropdown">
                    <summary>
                        Acquisition products
                        <span class="nav-dropdown__indicator" aria-hidden="true">▾</span>
                    </summary>
                    <div class="nav-dropdown__menu">
                        <a href="index.php#product-precious-metals">Precious metals</a>
                        <a href="index.php#product-antique-jewelry">Antique jewelry</a>
                        <a href="index.php#product-vintage-timepieces">Vintage timepieces</a>
                        <a href="index.php#product-decorative-metalwork">Decorative metalwork</a>
                        <a href="index.php#product-rare-materials">Rare materials</a>
                    </div>
                </details>
                <a class="nav-cta" href="index.php#contact">Contact <span aria-hidden="true">↗</span></a>
            </nav>
        </div>
    </header>
