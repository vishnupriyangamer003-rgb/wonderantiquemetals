<?php
require_once __DIR__ . '/includes/header.php';
?>

<main id="main">
    <section class="hero section-shell" aria-labelledby="hero-title">
        <div class="hero-copy">
            <p class="eyebrow"><span class="eyebrow-dot" aria-hidden="true"></span> Wonder Antique Metals</p>
            <h1 id="hero-title">The beauty<br>of time,<br><em>recast.</em></h1>
            <p class="hero-intro">A considered collection of antique metalwork, chosen for its character, craft, and the stories it carries forward.</p>
            <div class="hero-actions">
                <a class="button button-dark" href="#collection">Explore the collection <span aria-hidden="true">↗</span></a>
                <a class="text-link" href="#story">Our approach <span aria-hidden="true">→</span></a>
            </div>
            <p class="hero-note">Objects with a past. Pieces for the future.</p>
        </div>

        <div class="hero-art" aria-label="Decorative antique-inspired medallion artwork">
            <div class="hero-art__frame">
                <div class="medallion" aria-hidden="true">
                    <span class="medallion__outer"></span>
                    <span class="medallion__inner"></span>
                    <span class="medallion__initial">W</span>
                    <span class="medallion__star medallion__star--top">✳</span>
                    <span class="medallion__star medallion__star--bottom">✳</span>
                </div>
                <span class="hero-art__caption">Collected with care<br>kept for generations</span>
                <span class="hero-art__index">No. 01 — Objects &amp; ornament</span>
            </div>
            <span class="hero-art__side-note" aria-hidden="true">A study in permanence</span>
        </div>
    </section>

    <section class="intro-strip" aria-label="Our point of view">
        <div class="intro-strip__inner">
            <span>Material</span><i aria-hidden="true"></i>
            <span>Memory</span><i aria-hidden="true"></i>
            <span>Meaning</span>
        </div>
    </section>

    <section class="collection section-shell" id="collection" aria-labelledby="collection-title">
        <div class="section-heading">
            <div>
                <p class="eyebrow">A collection in conversation</p>
                <h2 id="collection-title">Made to endure.<br><em>Meant to be kept.</em></h2>
            </div>
            <p class="section-heading__copy">From finely worked details to expressive forms, every piece invites a closer look. Discover objects selected for their enduring materials and unmistakable presence.</p>
        </div>

        <div class="collection-grid">
            <article class="collection-card collection-card--one">
                <div class="collection-card__art" aria-hidden="true">
                    <span class="artifact artifact--vessel"></span>
                    <span class="artifact-label">I</span>
                </div>
                <div class="collection-card__meta">
                    <div><span class="card-number">01 / FORM</span><h3>Sculptural forms</h3></div>
                    <a href="#contact" aria-label="Enquire about sculptural forms">↗</a>
                </div>
            </article>
            <article class="collection-card collection-card--two">
                <div class="collection-card__art" aria-hidden="true">
                    <span class="artifact artifact--rosette"></span>
                    <span class="artifact-label">II</span>
                </div>
                <div class="collection-card__meta">
                    <div><span class="card-number">02 / DETAIL</span><h3>Architectural details</h3></div>
                    <a href="#contact" aria-label="Enquire about architectural details">↗</a>
                </div>
            </article>
            <article class="collection-card collection-card--three">
                <div class="collection-card__art" aria-hidden="true">
                    <span class="artifact artifact--sun"></span>
                    <span class="artifact-label">III</span>
                </div>
                <div class="collection-card__meta">
                    <div><span class="card-number">03 / OBJECT</span><h3>Everyday heirlooms</h3></div>
                    <a href="#contact" aria-label="Enquire about everyday heirlooms">↗</a>
                </div>
            </article>
        </div>
        <a class="text-link collection-link" href="#contact">Ask about the collection <span aria-hidden="true">→</span></a>
    </section>

    <section class="story" id="story" aria-labelledby="story-title">
        <div class="story__ornament" aria-hidden="true">W</div>
        <div class="story__content">
            <p class="eyebrow eyebrow--light">Our point of view</p>
            <h2 id="story-title">The marks of time<br>are <em>part of the beauty.</em></h2>
            <div class="story__bottom">
                <p>We believe the best objects are never just things. Their patina, workmanship, and quiet imperfections tell a story that no new piece can repeat.</p>
                <a class="button button-light" href="#contact">Get in touch <span aria-hidden="true">↗</span></a>
            </div>
        </div>
    </section>

    <section class="contact section-shell" id="contact" aria-labelledby="contact-title">
        <div>
            <p class="eyebrow">Begin a conversation</p>
            <h2 id="contact-title">Looking for<br><em>something lasting?</em></h2>
        </div>
        <div class="contact__aside">
            <p>Start with the collection and discover objects selected for their enduring materials, thoughtful details, and unmistakable presence.</p>
            <a class="button button-dark" href="#collection">Explore the collection <span aria-hidden="true">↗</span></a>
        </div>
    </section>
</main>

<?php
require_once __DIR__ . '/includes/footer.php';
?>
