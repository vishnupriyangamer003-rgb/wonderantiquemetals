<?php
$services = [
    'regulatory' => [
        'number' => '01',
        'eyebrow' => 'Guidance',
        'title' => 'Regulatory support',
        'summary' => 'Understand the regulatory considerations that can shape precious-metal activity and transactions.',
        'image' => 'assets/images/antique-collection-slide.jpg',
        'alt' => 'Antique jewelry and small decorative objects arranged across a vintage market display',
        'points' => [
            'Regulatory considerations that can shape precious-metal activity.',
            'How those considerations apply to transactions and holdings.',
            'Clear communication of next steps before you proceed.',
        ],
    ],
    'assaying' => [
        'number' => '02',
        'eyebrow' => 'Technical',
        'title' => 'Assaying & assessment',
        'summary' => 'Careful examination and quality assessment help build a clearer picture of the material in question.',
        'image' => 'assets/images/pocket-watch-slide.jpg',
        'alt' => 'Vintage pocket watches and antique objects arranged for display',
        'points' => [
            'Careful examination of the material in question.',
            'Quality assessment that supports a clearer picture of value.',
            'Technical findings explained in plain terms.',
        ],
    ],
    'acquisition' => [
        'number' => '03',
        'eyebrow' => 'Market',
        'title' => 'Acquisition',
        'summary' => 'Evaluate acquisition opportunities across precious metals and distinctive antique items.',
        'image' => 'assets/images/antique-metals-banner.jpg',
        'alt' => 'Ornate antique mantel clock displayed between decorative vases in a shop window',
        'points' => [
            'Opportunities across precious metals and rare materials.',
            'Distinctive antique items and their market context.',
            'A considered view of quality and opportunity.',
        ],
    ],
    'auction' => [
        'number' => '04',
        'eyebrow' => 'Exchange',
        'title' => 'Auction services',
        'summary' => 'Prepare metal and antique assets for auction with attention to their qualities and market context.',
        'image' => 'assets/images/antique-display-slide.jpg',
        'alt' => 'Vintage and antique jewelry and decorative objects arranged together',
        'points' => [
            'Preparing metal and antique assets for auction.',
            'Attention to the qualities that set each asset apart.',
            'Market context to inform how an asset is presented.',
        ],
    ],
    'monetization' => [
        'number' => '05',
        'eyebrow' => 'Value',
        'title' => 'Monetization',
        'summary' => 'Consider practical routes to realize value from precious-metal holdings and unique assets.',
        'image' => 'assets/images/antique-collection-slide.jpg',
        'alt' => 'Antique jewelry and small decorative objects arranged across a vintage market display',
        'points' => [
            'Practical routes to realize value from holdings.',
            'Options for precious metals and unique assets.',
            'Thoughtful next steps once value is understood.',
        ],
    ],
];

$slug = $_GET['service'] ?? '';
$slug = is_string($slug) ? $slug : '';
$found = array_key_exists($slug, $services);

if (!$found) {
    http_response_code(404);
    $pageTitle = 'Service not found | Wonder Antique Metals';
    $pageDescription = 'The requested service could not be found. Explore all Wonder Antique Metals services.';
    require_once __DIR__ . '/includes/header.php';
    ?>

<main id="main">
    <section class="service-page-missing section-shell" aria-labelledby="service-missing-title">
        <p class="eyebrow">404</p>
        <h1 id="service-missing-title">Service<br><em>not found.</em></h1>
        <p>We couldn’t find that service. Please choose one from our services overview.</p>
        <a class="button button-dark" href="services.php">All services <span aria-hidden="true">→</span></a>
    </section>
</main>

    <?php
    require_once __DIR__ . '/includes/footer.php';
    return;
}

$service = $services[$slug];
$keys = array_keys($services);
$index = array_search($slug, $keys, true);
$prevSlug = $keys[($index + count($keys) - 1) % count($keys)];
$nextSlug = $keys[($index + 1) % count($keys)];

$e = static function (string $value): string {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
};

$pageTitle = $service['title'] . ' | Wonder Antique Metals';
$pageDescription = $service['summary'];
require_once __DIR__ . '/includes/header.php';
?>

<main id="main">
    <section class="service-page-hero section-shell" aria-labelledby="service-title">
        <div class="service-page-hero__copy">
            <nav class="service-page-crumbs" aria-label="Breadcrumb">
                <a href="services.php">Services</a> <span aria-hidden="true">/</span> <span aria-current="page"><?php echo $e($service['title']); ?></span>
            </nav>
            <p class="eyebrow"><?php echo $e($service['number'] . ' · ' . $service['eyebrow']); ?></p>
            <h1 id="service-title"><?php echo $e($service['title']); ?></h1>
            <p class="service-page-hero__intro"><?php echo $e($service['summary']); ?></p>
            <a class="service-page-round" href="index.php#contact">Get in touch <span aria-hidden="true">→</span></a>
        </div>
        <figure class="service-page-hero__visual">
            <img src="<?php echo $e($service['image']); ?>" alt="<?php echo $e($service['alt']); ?>" width="1920" height="1280" fetchpriority="high">
        </figure>
    </section>

    <section class="service-page-overview" aria-labelledby="service-overview-title">
        <div class="service-page-overview__inner section-shell">
            <p class="service-page-label" aria-hidden="true">Section 1.</p>
            <div>
                <h2 id="service-overview-title">Overview</h2>
                <p><?php echo $e($service['summary']); ?> Our work brings technical and market perspective to precious-metal and antique assets, from initial assessment through next steps.</p>
            </div>
        </div>
    </section>

    <section class="service-page-points" aria-labelledby="service-points-title">
        <div class="service-page-points__inner section-shell">
            <p class="service-page-label" aria-hidden="true">Section 2.</p>
            <h2 id="service-points-title">What we consider</h2>
            <ol>
                <?php foreach ($service['points'] as $i => $point) : ?>
                    <li><span><?php echo str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT); ?></span> <?php echo $e($point); ?></li>
                <?php endforeach; ?>
            </ol>
        </div>
    </section>

    <section class="service-page-related" aria-labelledby="service-related-title">
        <div class="service-page-related__inner section-shell">
            <p class="service-page-label" aria-hidden="true">Section 3.</p>
            <h2 id="service-related-title">Connected services</h2>
            <ul>
                <?php foreach ($services as $key => $item) : ?>
                    <?php if ($key === $slug) { continue; } ?>
                    <li>
                        <a href="service-detail.php?service=<?php echo $e($key); ?>">
                            <span><?php echo $e($item['number']); ?></span>
                            <strong><?php echo $e($item['title']); ?></strong>
                            <em aria-hidden="true">→</em>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </section>

    <nav class="service-page-pager" aria-label="Service navigation">
        <div class="service-page-pager__inner section-shell">
            <a href="service-detail.php?service=<?php echo $e($prevSlug); ?>" rel="prev"><span aria-hidden="true">←</span> <?php echo $e($services[$prevSlug]['title']); ?></a>
            <a href="service-detail.php?service=<?php echo $e($nextSlug); ?>" rel="next"><?php echo $e($services[$nextSlug]['title']); ?> <span aria-hidden="true">→</span></a>
        </div>
    </nav>
</main>

<?php
require_once __DIR__ . '/includes/footer.php';
?>
