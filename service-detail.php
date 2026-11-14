<?php
$services = [
    'regulatory' => [
        'number' => '01',
        'eyebrow' => 'Guidance',
        'title' => 'Regulatory support',
        'summary' => 'Navigate changing compliance requirements, documentation, and export logistics with guidance for precious-metal and antique transactions.',
        'image' => 'assets/images/antique-collection-slide.jpg',
        'alt' => 'Antique jewelry and small decorative objects arranged across a vintage market display',
        'details' => [
            'Rules affecting precious metals and antique items keep changing, and they differ from one country to another. Documentation requirements and penalties for getting them wrong have become more demanding, so understanding them early can prevent delays and avoidable cost.',
            'We help you see which local and international requirements may apply to your assets, and how transport, customs, and export paperwork fit into a transaction. Where specialist input is needed, we point you to the right people.',
            'This is general guidance and not legal advice. Regulatory understanding also supports the other services we offer, from assessment through to sale.',
        ],
    ],
    'assaying' => [
        'number' => '02',
        'eyebrow' => 'Technical',
        'title' => 'Assaying & assessment',
        'summary' => 'Professional testing and quality assessment of metals, stones, and antique items, with findings explained clearly.',
        'image' => 'assets/images/pocket-watch-slide.jpg',
        'alt' => 'Vintage pocket watches and antique objects arranged for display',
        'details' => [
            'Assaying gives you a clear, evidence-based view of what an item is made of and its condition. Professional testing and quality assessment of metals, stones, and antique pieces helps confirm what you hold before any decision about its value is made.',
            'We explain our findings in plain language, so you understand what was examined, what it shows, and how it relates to the market for similar items.',
            'Assessment is the starting point of a connected route that can continue into regulatory review, acquisition, auction, or sale.',
        ],
    ],
    'acquisition' => [
        'number' => '03',
        'eyebrow' => 'Market',
        'title' => 'Acquisition',
        'summary' => 'Valuation, negotiation, and completion support to help you find suitable buyers or sellers for precious metals, gemstones, and antiques.',
        'image' => 'assets/images/antique-metals-banner.jpg',
        'alt' => 'Ornate antique mantel clock displayed between decorative vases in a shop window',
        'details' => [
            'Acquisition begins with understanding what is on offer. We look at technical quality and market context together, so opportunities in precious metals, gemstones, antiques, and rare materials can be weighed on more than price alone.',
            'Our support covers valuation, negotiation, and completion, and helps identify suitable buyers or sellers so that a transaction can be pursued towards the best available outcome. Regulatory and tax points that can affect a deal are considered alongside.',
            'Because assessment, acquisition, and auction are connected, one team can follow an asset from first examination to a completed sale.',
        ],
    ],
    'auction' => [
        'number' => '04',
        'eyebrow' => 'Exchange',
        'title' => 'Auction services',
        'summary' => 'Online, offline, and on-site auctions for antiques, rare materials, collectibles, and consignments, from planning to completion.',
        'image' => 'assets/images/antique-display-slide.jpg',
        'alt' => 'Vintage and antique jewelry and decorative objects arranged together',
        'details' => [
            'A well-prepared lot is easier to understand and easier to value. We prepare metal and antique assets for auction with attention to condition, history, and the qualities that make each piece distinctive.',
            'Auctions can be held online, offline, or on site, and can suit estates, antiques, rare materials, collectibles, and consignments. We support the process from planning through to completion.',
            'Market context guides how an item is presented and when it is offered, whether it is a single piece or a wider collection.',
        ],
    ],
    'monetization' => [
        'number' => '05',
        'eyebrow' => 'Value',
        'title' => 'Monetization',
        'summary' => 'Convert precious metals, stones, and antique assets into value through one connected route of assessment, approvals, and sale.',
        'image' => 'assets/images/antique-collection-slide.jpg',
        'alt' => 'Antique jewelry and small decorative objects arranged across a vintage market display',
        'details' => [
            'Realizing value from precious-metal holdings or unique assets usually starts with knowing exactly what you have. Assessment and regulatory understanding come first, so that the route you choose is an informed one.',
            'From there we discuss practical options for turning precious metals, stones, and antique assets into value, whether through direct sale, auction, or a considered combination of both.',
            'Assaying, approvals, sales, and auction support work together, so each step builds on the one before it and you can weigh the trade-offs before deciding on next steps.',
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

    <section class="service-page-about" aria-labelledby="service-about-title">
        <div class="service-page-about__inner section-shell">
            <h2 id="service-about-title">About this service</h2>
            <?php foreach ($service['details'] as $paragraph) : ?>
                <p><?php echo $e($paragraph); ?></p>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="service-page-related" aria-labelledby="service-related-title">
        <div class="service-page-related__inner section-shell">
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
