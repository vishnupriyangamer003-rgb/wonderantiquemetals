<?php
require_once __DIR__ . '/includes/header.php';
?>

<main id="main">
    <section class="home-carousel" data-carousel aria-roledescription="carousel" aria-label="Featured Wonder Antique Metals services">
        <div class="home-carousel__slides">
            <article class="home-carousel__slide" data-carousel-slide role="group" aria-roledescription="slide" aria-label="Slide 1 of 3">
                <img
                    class="home-carousel__image"
                    src="assets/images/antique-collection-slide.jpg"
                    alt="Antique jewelry and small decorative objects arranged across a vintage market display"
                    width="1920"
                    height="1280"
                    fetchpriority="high">
                <div class="home-carousel__content">
                    <p class="home-carousel__eyebrow">Antique objects · Precious metals</p>
                    <h2>The value<br>of a story.</h2>
                    <p>A considered approach to antique objects, precious metals, and rare materials.</p>
                    <a class="button button-light" href="#services">Explore our services <span aria-hidden="true">↗</span></a>
                </div>
                <a class="home-carousel__credit" href="https://www.pexels.com/photo/choice-of-retro-decor-items-and-jewelry-5865376/" target="_blank" rel="noopener noreferrer">Photo by Rachel Claire / Pexels</a>
            </article>
            <article class="home-carousel__slide" data-carousel-slide role="group" aria-roledescription="slide" aria-label="Slide 2 of 3" hidden>
                <img
                    class="home-carousel__image"
                    src="assets/images/pocket-watch-slide.jpg"
                    alt="Vintage pocket watches and antique objects arranged for display"
                    width="1920"
                    height="1280"
                    loading="lazy">
                <div class="home-carousel__content">
                    <p class="home-carousel__eyebrow">Technical insight · Market perspective</p>
                    <h2>Expertise<br>you can rely on.</h2>
                    <p>Careful assessment and clear communication help bring each asset into focus.</p>
                    <a class="button button-light" href="#standards">Our standards <span aria-hidden="true">↗</span></a>
                </div>
                <a class="home-carousel__credit" href="https://www.pexels.com/photo/display-of-antique-items-6795489/" target="_blank" rel="noopener noreferrer">Photo by Freitas Junior / Pexels</a>
            </article>
            <article class="home-carousel__slide" data-carousel-slide role="group" aria-roledescription="slide" aria-label="Slide 3 of 3" hidden>
                <img
                    class="home-carousel__image"
                    src="assets/images/antique-display-slide.jpg"
                    alt="Vintage and antique items including jewelry and decorative pieces displayed together"
                    width="1920"
                    height="1280"
                    loading="lazy">
                <div class="home-carousel__content">
                    <p class="home-carousel__eyebrow">Acquisition · Auction · Monetization</p>
                    <h2>Make your<br>next move.</h2>
                    <p>Explore thoughtful routes for distinctive metal and antique assets.</p>
                    <a class="button button-light" href="#services">See our services <span aria-hidden="true">↗</span></a>
                </div>
                <a class="home-carousel__credit" href="https://www.pexels.com/photo/antiques-on-display-in-a-store-5865384/" target="_blank" rel="noopener noreferrer">Photo by Rachel Claire / Pexels</a>
            </article>
        </div>
        <div class="home-carousel__controls" role="group" aria-label="Banner slide controls">
            <span class="home-carousel__status" aria-live="off" aria-atomic="true">01 / 03</span>
            <button class="home-carousel__button" type="button" data-carousel-prev aria-label="Previous slide">
                <span aria-hidden="true">←</span>
            </button>
            <button class="home-carousel__button" type="button" data-carousel-next aria-label="Next slide">
                <span aria-hidden="true">→</span>
            </button>
        </div>
    </section>

    <section class="hero section-shell" aria-labelledby="hero-title">
        <div class="hero-copy">
            <p class="eyebrow"><span class="eyebrow-dot" aria-hidden="true"></span> Integrity · Professionalism · Expertise</p>
            <h1 id="hero-title">Precious<br>metals.<br><em>Expertise.</em></h1>
            <p class="hero-intro">Technical and market support across precious metals, antique items, and rare materials—from assessment and acquisition to auction and monetization.</p>
            <div class="hero-actions">
                <a class="button button-dark" href="#services">Explore our services <span aria-hidden="true">↗</span></a>
                <a class="text-link" href="about.php">Who we are <span aria-hidden="true">→</span></a>
            </div>
            <p class="hero-note">A considered view of value, quality, and opportunity.</p>
        </div>

        <div class="hero-art hero-art--photo">
            <figure class="hero-banner">
                <img
                    class="hero-banner__image"
                    src="assets/images/antique-metals-banner.jpg"
                    alt="Ornate antique mantel clock displayed between decorative vases in a shop window"
                    width="1800"
                    height="1200"
                    fetchpriority="high">
                <figcaption class="hero-banner__caption">
                    <span class="hero-banner__eyebrow">Antique metalwork</span>
                    <span class="hero-banner__headline">Value with<br>a history.</span>
                </figcaption>
                <a
                    class="hero-banner__credit"
                    href="https://www.pexels.com/photo/vintage-clock-in-an-antique-shop-window-16470625/"
                    target="_blank"
                    rel="noopener noreferrer">Photo by Ömer Derinyar / Pexels</a>
            </figure>
            <span class="hero-art__side-note" aria-hidden="true">A connected market view</span>
        </div>
    </section>

    <section class="story" id="about" aria-labelledby="about-title">
        <div class="story__ornament" aria-hidden="true">W</div>
        <div class="story__content">
            <p class="eyebrow eyebrow--light">About Wonder Antique Metals</p>
            <h2 id="about-title">A market shaped by<br><em>many perspectives.</em></h2>
            <div class="story__bottom">
                <p>Precious-metal work connects commercial and technical disciplines. Investment, production, refining, fabrication, metallurgy, research, and end use all bring a different perspective to the value of an asset.</p>
                <a class="button button-light" href="#standards">Our principles <span aria-hidden="true">↗</span></a>
            </div>
        </div>
    </section>

    <section class="intro-strip" aria-label="Our service areas">
        <div class="intro-strip__inner">
            <span>Regulatory</span><i aria-hidden="true"></i>
            <span>Assaying</span><i aria-hidden="true"></i>
            <span>Acquisition</span><i aria-hidden="true"></i>
            <span>Auction</span><i aria-hidden="true"></i>
            <span>Monetization</span>
        </div>
    </section>

    <section class="services section-shell" id="services" aria-labelledby="services-title">
        <div class="services-overview">
            <div class="services-overview__copy">
                <p class="eyebrow">How we help</p>
                <h2 id="services-title">Our Services</h2>
                <p class="services-overview__text">Our work spans five connected areas—regulatory guidance, assaying, acquisition, auction, and monetization. We bring technical and market perspective to precious-metal and antique assets, from initial assessment through next steps.</p>
            </div>
            <figure class="services-overview__image">
                <img
                    src="assets/images/antique-display-slide.jpg"
                    alt="Vintage and antique jewelry and decorative objects arranged together"
                    width="1920"
                    height="1280"
                    loading="lazy">
                <figcaption>
                    <a href="https://www.pexels.com/photo/antiques-on-display-in-a-store-5865384/" target="_blank" rel="noopener noreferrer">Photo by Rachel Claire / Pexels</a>
                </figcaption>
            </figure>
        </div>

        <div class="services-grid">
            <article class="service-card">
                <div class="service-card__top"><span class="card-number">01 / GUIDANCE</span><span class="service-card__seal" aria-hidden="true">R</span></div>
                <h3>Regulatory support</h3>
                <p>Understand the regulatory considerations that can shape precious-metal activity and transactions.</p>
            </article>
            <article class="service-card">
                <div class="service-card__top"><span class="card-number">02 / TECHNICAL</span><span class="service-card__seal" aria-hidden="true">A</span></div>
                <h3>Assaying &amp; assessment</h3>
                <p>Careful examination and quality assessment help build a clearer picture of the material in question.</p>
            </article>
            <article class="service-card" id="acquisition-products">
                <div class="service-card__top"><span class="card-number">03 / MARKET</span><span class="service-card__seal" aria-hidden="true">A</span></div>
                <h3>Acquisition</h3>
                <p>Evaluate acquisition opportunities across precious metals and distinctive antique items.</p>
            </article>
            <article class="service-card">
                <div class="service-card__top"><span class="card-number">04 / EXCHANGE</span><span class="service-card__seal" aria-hidden="true">A</span></div>
                <h3>Auction services</h3>
                <p>Prepare metal and antique assets for auction with attention to their qualities and market context.</p>
            </article>
            <article class="service-card">
                <div class="service-card__top"><span class="card-number">05 / VALUE</span><span class="service-card__seal" aria-hidden="true">M</span></div>
                <h3>Monetization</h3>
                <p>Consider practical routes to realize value from precious-metal holdings and unique assets.</p>
            </article>
        </div>
    </section>

    <section class="guarantee" aria-labelledby="guarantee-title">
        <div class="guarantee__inner section-shell">
            <div class="guarantee__seal" aria-hidden="true">✓</div>
            <div class="guarantee__content">
                <p class="eyebrow">Our Commitment</p>
                <h2 id="guarantee-title">Our Guarantee</h2>
                <p>We approach each engagement with professional care, communicate clearly, and work toward agreed timelines. If our service falls short of your expectations, contact us so we can understand your concerns and discuss a constructive next step.</p>
            </div>
        </div>
    </section>

    <section class="standards section-shell" id="standards" aria-labelledby="standards-title">
        <div class="section-heading">
            <div>
                <p class="eyebrow">Why choose us</p>
                <h2 id="standards-title">Integrity in every step.<br><em>Expertise in every detail.</em></h2>
            </div>
            <p class="section-heading__copy">We aim to bring sound technical examination, professional service, and clear communication to every engagement.</p>
        </div>
        <div class="standards-grid">
            <article class="standard-card">
                <span class="card-number">01 / PRINCIPLE</span>
                <h3>Integrity</h3>
                <p>Open communication and considered handling of each opportunity.</p>
            </article>
            <article class="standard-card">
                <span class="card-number">02 / PRACTICE</span>
                <h3>Professionalism</h3>
                <p>Careful coordination, dependable follow-through, and respect for agreed timelines.</p>
            </article>
            <article class="standard-card">
                <span class="card-number">03 / KNOW-HOW</span>
                <h3>Expertise</h3>
                <p>Technical assessment and market understanding brought together in one view.</p>
            </article>
        </div>
    </section>

    <section class="next-step section-shell" aria-labelledby="next-step-title">
        <div>
            <p class="eyebrow">Precious metals · Antique assets · Rare materials</p>
            <h2 id="next-step-title">Find the right path<br><em>for your asset.</em></h2>
        </div>
        <a class="button button-dark" href="#services">Review our services <span aria-hidden="true">↗</span></a>
    </section>
</main>

<?php
require_once __DIR__ . '/includes/footer.php';
?>
