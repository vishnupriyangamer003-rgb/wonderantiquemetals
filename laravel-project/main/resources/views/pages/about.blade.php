@extends('layout')

@section('title', 'About Wonder Antique Metals | A Connected Market Perspective')

@section('content')
<main id="main">
    <section class="about-hero section-shell" aria-labelledby="about-title">
        <div class="about-hero__copy">
            <p class="eyebrow">About Wonder Antique Metals</p>
            <h1 id="about-title">Welcome to<br><em>Wonder Antique Metals</em></h1>
            <p class="about-hero__intro">WONDER is a worldwide company and have a strong network and ratifying its business activities in USA, UK, Germany, France, Malaysia and India in particular and also we do other part of the world like Romania, Russia, Poland, Korea, Israel, Singapore, Canada and Australia in general.</p>
        </div>
        <figure class="about-hero__visual">
            <img
                src="{{ asset('assets/images/pocket-watch-slide.jpg') }}"
                alt="Vintage pocket watches and antique objects arranged for display"
                width="1920"
                height="1280"
                fetchpriority="high">
        </figure>
    </section>

    <section class="about-perspective" id="approach" aria-labelledby="about-perspective-title">
        <div class="about-perspective__inner section-shell">
            <div class="about-perspective__copy">
                <p class="eyebrow eyebrow--light">Our commitment</p>
                <h2 id="about-perspective-title">Integrity, Professionalism &amp; Expertise</h2>
                <p>WONDER ANTIQUE METALS is committed to serve its customers with Integrity, Professionalism and the Expertise and dedicated to promote advance technology for the global excellence and abundance.</p>
            </div>
            <ul class="about-perspective__list" aria-label="Key activities and sectors">
                <li><span>01</span>Regulatory</li>
                <li><span>02</span>Assaying</li>
                <li><span>03</span>Acquisition</li>
                <li><span>04</span>Auctioning</li>
                <li><span>05</span>Precious Metals</li>
                <li><span>06</span>Antique Items</li>
                <li><span>07</span>Rare Metals</li>
            </ul>
        </div>
    </section>

    <section class="about-principles section-shell" id="principles" aria-labelledby="about-principles-title">
        <div class="section-heading">
            <div>
                <p class="eyebrow">Our syndicate &amp; solutions</p>
                <h2 id="about-principles-title">A global syndicate<br><em>of professionals.</em></h2>
            </div>
            <p class="section-heading__copy">WONDER ANTIQUE METALS is a syndicate and a group of reputed (investors, producers, refiners, fabricators, metallurgists, scientists, users, and financial institutions) professional that supports regulatory, assaying, acquisition and auctioning of precious metals, antique items and also super natural rare metals in the international markets. WONDER ANTIQUE METALS team is dedicated and focused to provide custom field solutions and expert in quality assessment and technical examining services.</p>
        </div>
        <div class="standards-grid">
            <article class="standard-card">
                <span class="card-number">01 / REPUTED GROUP</span>
                <h3>Diverse Syndicate</h3>
                <p>Investors, producers, refiners, fabricators, metallurgists, scientists, users, and financial institutions.</p>
            </article>
            <article class="standard-card">
                <span class="card-number">02 / CORE SERVICES</span>
                <h3>Comprehensive Support</h3>
                <p>Regulatory, assaying, acquisition, and auctioning of precious metals, antiques, and super natural rare metals.</p>
            </article>
            <article class="standard-card">
                <span class="card-number">03 / FIELD EXPERTISE</span>
                <h3>Custom Solutions</h3>
                <p>Dedicated team providing tailored field solutions, quality assessment, and technical examining services.</p>
            </article>
        </div>
    </section>

    @if ($siteTeam->isNotEmpty())
    <section class="about-team" id="team" aria-labelledby="about-team-title">
        <div class="section-shell">
            <div class="section-heading">
                <div>
                    <p class="eyebrow">Our team</p>
                    <h2 id="about-team-title">The people behind<br><em>the work.</em></h2>
                </div>
                <p class="section-heading__copy">A dedicated team providing field solutions, quality assessment, and technical examining services.</p>
            </div>
            <div class="team-grid">
                @foreach ($siteTeam as $m)
                <article class="team-card">
                    <span class="team-card__avatar" aria-hidden="true">{{ mb_strtoupper(mb_substr(trim($m->name), 0, 1)) }}</span>
                    <h3>{{ $m->name }}</h3>
                    <span class="team-card__role">{{ $m->role }}</span>
                    @if ($m->bio)<p>{{ $m->bio }}</p>@endif
                </article>
                @endforeach
            </div>
        </div>
    </section>
    @endif

</main>
@endsection
