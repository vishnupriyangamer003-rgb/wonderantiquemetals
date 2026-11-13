<?php
$pageTitle = 'About Wonder Antique Metals | A Connected Market Perspective';
$pageDescription = 'Learn how Wonder Antique Metals brings technical assessment and market context to precious metals, antique items, and rare materials.';
require_once __DIR__ . '/includes/header.php';
?>

<main id="main">
    <section class="about-hero section-shell" aria-labelledby="about-title">
        <div class="about-hero__copy">
            <p class="eyebrow">About Wonder Antique Metals</p>
            <h1 id="about-title">A clearer<br><em>perspective.</em></h1>
            <p class="about-hero__intro">We bring market context and technical understanding to precious metals, antique items, and rare materials—helping clients understand an asset and consider informed next steps.</p>
        </div>
        <figure class="about-hero__visual">
            <img
                src="assets/images/pocket-watch-slide.jpg"
                alt="Vintage pocket watches and antique objects arranged for display"
                width="1920"
                height="1280"
                fetchpriority="high">
        </figure>
    </section>

    <section class="about-perspective" id="approach" aria-labelledby="about-perspective-title">
        <div class="about-perspective__inner section-shell">
            <div class="about-perspective__copy">
                <p class="eyebrow eyebrow--light">Our perspective</p>
                <h2 id="about-perspective-title">Value is part of a larger story.</h2>
                <p>Investment, production, refining, fabrication, research, and end use each bring a different perspective to a material. We consider how technical quality and market context connect, rather than looking at an asset in isolation.</p>
            </div>
            <ul class="about-perspective__list" aria-label="Perspectives that inform our work">
                <li><span>01</span>Investment</li>
                <li><span>02</span>Production</li>
                <li><span>03</span>Refining</li>
                <li><span>04</span>Fabrication</li>
                <li><span>05</span>Metallurgy</li>
                <li><span>06</span>Research</li>
                <li><span>07</span>End use</li>
            </ul>
        </div>
    </section>

    <section class="about-principles section-shell" id="principles" aria-labelledby="about-principles-title">
        <div class="section-heading">
            <div>
                <p class="eyebrow">What guides us</p>
                <h2 id="about-principles-title">A considered way<br><em>of working.</em></h2>
            </div>
            <p class="section-heading__copy">Integrity, professionalism, and expertise guide how we assess opportunities and communicate throughout the process.</p>
        </div>
        <div class="standards-grid">
            <article class="standard-card">
                <span class="card-number">01 / PRINCIPLE</span>
                <h3>Integrity</h3>
                <p>Clear communication and considered handling help build trust at every stage.</p>
            </article>
            <article class="standard-card">
                <span class="card-number">02 / PRACTICE</span>
                <h3>Professionalism</h3>
                <p>Careful coordination and respect for agreed timelines keep work moving clearly.</p>
            </article>
            <article class="standard-card">
                <span class="card-number">03 / KNOW-HOW</span>
                <h3>Expertise</h3>
                <p>Technical assessment and market understanding come together in one view.</p>
            </article>
        </div>
    </section>

    <section class="about-testimonials" id="testimonials" aria-labelledby="about-testimonials-title">
        <div class="section-shell">
            <div class="section-heading">
                <div>
                    <p class="eyebrow">Illustrative testimonials</p>
                    <h2 id="about-testimonials-title">A considered experience.</h2>
                </div>
                <p class="section-heading__copy">Fictional example quotes and India-based names—replace these with verified client feedback before publishing.</p>
            </div>
            <div class="about-testimonials__viewport" data-testimonial-carousel role="group" aria-roledescription="carousel" aria-label="Client testimonials; focus or hover to pause" tabindex="0">
                <div class="about-testimonials__track">
                    <article class="about-testimonial" role="group" aria-roledescription="slide" aria-label="Testimonial 1 of 4">
                        <blockquote>
                            <p>I appreciated how clearly the assessment process was explained and how easy it was to understand the next steps.</p>
                        </blockquote>
                        <div class="about-testimonial__author">
                            <strong>Ananya Iyer</strong>
                            <span>Chennai, Tamil Nadu</span>
                        </div>
                    </article>
                    <article class="about-testimonial" role="group" aria-roledescription="slide" aria-label="Testimonial 2 of 4">
                        <blockquote>
                            <p>The communication was organized, and the team took time to understand the history of the pieces I brought in.</p>
                        </blockquote>
                        <div class="about-testimonial__author">
                            <strong>Rohan Mehta</strong>
                            <span>Mumbai, Maharashtra</span>
                        </div>
                    </article>
                    <article class="about-testimonial" role="group" aria-roledescription="slide" aria-label="Testimonial 3 of 4">
                        <blockquote>
                            <p>I received clear guidance on the available options, which helped me decide what to do next.</p>
                        </blockquote>
                        <div class="about-testimonial__author">
                            <strong>Kavita Rao</strong>
                            <span>Bengaluru, Karnataka</span>
                        </div>
                    </article>
                    <article class="about-testimonial" role="group" aria-roledescription="slide" aria-label="Testimonial 4 of 4">
                        <blockquote>
                            <p>The team explained each step clearly and answered my questions, making it easier to consider the options.</p>
                        </blockquote>
                        <div class="about-testimonial__author">
                            <strong>Priya Nair</strong>
                            <span>Kochi, Kerala</span>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </section>

    <section class="next-step section-shell" aria-labelledby="about-next-step-title">
        <div>
            <p class="eyebrow">Start a conversation</p>
            <h2 id="about-next-step-title">Bring your questions<br><em>into focus.</em></h2>
        </div>
        <a class="button button-dark" href="index.php#contact">Contact us <span aria-hidden="true">↗</span></a>
    </section>
</main>

<?php
require_once __DIR__ . '/includes/footer.php';
?>
