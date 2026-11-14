<?php
$pageTitle = 'Services | Wonder Antique Metals';
$pageDescription = 'Explore regulatory support, assaying and assessment, acquisition, auction services, and monetization at Wonder Antique Metals.';
require_once __DIR__ . '/includes/header.php';
?>

<main id="main">
    <section class="services-page-hero section-shell" aria-labelledby="services-page-title">
        <div class="services-page-hero__copy">
            <p class="eyebrow">Integrity · Professionalism · Expertise</p>
            <h1 id="services-page-title">Our<br><em>Services.</em></h1>
            <p class="services-page-hero__intro">Our work spans five connected areas—regulatory guidance, assaying, acquisition, auction, and monetization. We bring technical and market perspective to precious-metal and antique assets, from initial assessment through next steps.</p>
            <a class="button button-dark" href="#service-index">Explore the services <span aria-hidden="true">↓</span></a>
        </div>
        <figure class="services-page-hero__visual">
            <img
                src="assets/images/antique-display-slide.jpg"
                alt="Vintage and antique jewelry and decorative objects arranged together"
                width="1920"
                height="1280"
                fetchpriority="high">
            <figcaption>
                <a href="https://www.pexels.com/photo/antiques-on-display-in-a-store-5865384/" target="_blank" rel="noopener noreferrer">Photo by Rachel Claire / Pexels</a>
            </figcaption>
        </figure>
    </section>

    <nav class="service-index" id="service-index" aria-label="Service areas">
        <div class="service-index__inner section-shell">
            <p>Five connected service areas</p>
            <ol>
                <li><a href="#service-regulatory"><span>01</span> Regulatory</a></li>
                <li><a href="#service-assaying"><span>02</span> Assaying</a></li>
                <li><a href="#service-acquisition"><span>03</span> Acquisition</a></li>
                <li><a href="#service-auction"><span>04</span> Auction</a></li>
                <li><a href="#service-monetization"><span>05</span> Monetization</a></li>
            </ol>
        </div>
    </nav>

    <section class="service-details" aria-label="Service details">
        <article class="service-detail" id="service-regulatory">
            <div class="service-detail__number" aria-hidden="true">01</div>
            <div class="service-detail__copy">
                <p class="eyebrow">Guidance</p>
                <h2>Regulatory support</h2>
                <p>Understand the regulatory considerations that can shape precious-metal activity and transactions.</p>
                <a class="text-link" href="service-detail.php?service=regulatory">Read more <span aria-hidden="true">→</span></a>
            </div>
        </article>
        <article class="service-detail" id="service-assaying">
            <div class="service-detail__number" aria-hidden="true">02</div>
            <div class="service-detail__copy">
                <p class="eyebrow">Technical</p>
                <h2>Assaying &amp; assessment</h2>
                <p>Careful examination and quality assessment help build a clearer picture of the material in question.</p>
                <a class="text-link" href="service-detail.php?service=assaying">Read more <span aria-hidden="true">→</span></a>
            </div>
        </article>
        <article class="service-detail" id="service-acquisition">
            <div class="service-detail__number" aria-hidden="true">03</div>
            <div class="service-detail__copy">
                <p class="eyebrow">Market</p>
                <h2>Acquisition</h2>
                <p>Evaluate acquisition opportunities across precious metals and distinctive antique items.</p>
                <a class="text-link" href="service-detail.php?service=acquisition">Read more <span aria-hidden="true">→</span></a>
            </div>
        </article>
        <article class="service-detail" id="service-auction">
            <div class="service-detail__number" aria-hidden="true">04</div>
            <div class="service-detail__copy">
                <p class="eyebrow">Exchange</p>
                <h2>Auction services</h2>
                <p>Prepare metal and antique assets for auction with attention to their qualities and market context.</p>
                <a class="text-link" href="service-detail.php?service=auction">Read more <span aria-hidden="true">→</span></a>
            </div>
        </article>
        <article class="service-detail" id="service-monetization">
            <div class="service-detail__number" aria-hidden="true">05</div>
            <div class="service-detail__copy">
                <p class="eyebrow">Value</p>
                <h2>Monetization</h2>
                <p>Consider practical routes to realize value from precious-metal holdings and unique assets.</p>
                <a class="text-link" href="service-detail.php?service=monetization">Read more <span aria-hidden="true">→</span></a>
            </div>
        </article>
    </section>

</main>

<?php
require_once __DIR__ . '/includes/footer.php';
?>
