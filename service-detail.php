<?php
$services = [
    'regulatory' => [
        'number' => '01',
        'eyebrow' => 'Guidance',
        'title' => 'Regulatory support',
        'summary' => 'Understand the regulatory considerations that can shape precious-metal activity and transactions.',
        'image' => 'assets/images/antique-collection-slide.jpg',
        'alt' => 'Antique jewelry and small decorative objects arranged across a vintage market display',
        'details' => [
            'Regulations affecting precious metals and antique items change over time and differ from one country to another. Understanding them early helps avoid delays, avoidable costs, and surprises once a transaction is under way.',
            'We help you see which considerations may apply to your assets, including documentation and movement across borders, and we point you toward the right specialists where needed. This is general guidance and not legal advice.',
        ],
    ],
    'assaying' => [
        'number' => '02',
        'eyebrow' => 'Technical',
        'title' => 'Assaying & assessment',
        'summary' => 'Careful examination and quality assessment help build a clearer picture of the material in question.',
        'image' => 'assets/images/pocket-watch-slide.jpg',
        'alt' => 'Vintage pocket watches and antique objects arranged for display',
        'details' => [
            'Assaying and assessment give a clear, evidence-based view of what an item is made of and its condition. Examination of metals, stones, and antique pieces helps confirm quality before any decision about value is made.',
            'We explain findings in plain language, so you understand what was examined, what it shows, and how it relates to the wider market for similar items.',
        ],
    ],
    'acquisition' => [
        'number' => '03',
        'eyebrow' => 'Market',
        'title' => 'Acquisition',
        'summary' => 'Evaluate acquisition opportunities across precious metals and distinctive antique items.',
        'image' => 'assets/images/antique-metals-banner.jpg',
        'alt' => 'Ornate antique mantel clock displayed between decorative vases in a shop window',
        'details' => [
            'Acquisition begins with understanding what is being offered. We look at technical quality and market context together, so opportunities in precious metals, antique items, and rare materials can be weighed on more than price alone.',
            'Because assessment, acquisition, and later sale are connected, our support can follow an asset through each stage, helping you consider suitable buyers or sellers and the practical points of completing a transaction.',
        ],
    ],
    'auction' => [
        'number' => '04',
        'eyebrow' => 'Exchange',
        'title' => 'Auction services',
        'summary' => 'Prepare metal and antique assets for auction with attention to their qualities and market context.',
        'image' => 'assets/images/antique-display-slide.jpg',
        'alt' => 'Vintage and antique jewelry and decorative objects arranged together',
        'details' => [
            'A well-prepared lot is easier to understand and easier to value. We help prepare metal and antique assets for auction, with attention to condition, history, and the qualities that make each piece distinctive.',
            'Market context guides how an item is presented and when it may be offered, whether it is a single piece or a wider collection.',
        ],
    ],
    'monetization' => [
        'number' => '05',
        'eyebrow' => 'Value',
        'title' => 'Monetization',
        'summary' => 'Consider practical routes to realize value from precious-metal holdings and unique assets.',
        'image' => 'assets/images/antique-collection-slide.jpg',
        'alt' => 'Antique jewelry and small decorative objects arranged across a vintage market display',
        'details' => [
            'Realizing value from precious-metal holdings or unique assets usually starts with knowing exactly what you have. Assessment and regulatory understanding come first, so that the route you choose is informed.',
            'From there we discuss practical options, such as sale, auction, or a considered mix, and help you weigh their trade-offs before you decide on next steps.',
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
