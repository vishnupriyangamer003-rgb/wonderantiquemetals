@extends('layout')


@section('content')
<main id="main">
    <section class="home-carousel" data-carousel aria-roledescription="carousel" aria-label="Featured Wonder Antique Metals services">
                <div class="home-carousel__slides">
            @foreach ($siteBanners as $banner)
            <article class="home-carousel__slide" data-carousel-slide role="group" aria-roledescription="slide" aria-label="Slide {{ $loop->iteration }} of {{ $siteBanners->count() }}"@if (! $loop->first) hidden @endif>
                <img
                    class="home-carousel__image"
                    src="{{ asset($banner->image) }}"
                    alt="{{ $banner->alt }}"
                    width="1920"
                    height="1280"
                    @if ($loop->first) fetchpriority="high" @else loading="lazy" @endif>
                <div class="home-carousel__content">
                    @if ($banner->eyebrow)<p class="home-carousel__eyebrow">{{ $banner->eyebrow }}</p>@endif
                    <h2>{!! nl2br(e($banner->title)) !!}</h2>
                    @if ($banner->text)<p>{{ $banner->text }}</p>@endif
                    @if ($banner->button_label && $banner->button_url)
                    <a class="button button-light" href="{{ $banner->button_url }}">{{ $banner->button_label }} <span aria-hidden="true">↗</span></a>
                    @endif
                </div>
            </article>
            @endforeach
        </div>
        <div class="home-carousel__controls" role="group" aria-label="Banner slide controls">
            <span class="home-carousel__status" data-carousel-status aria-live="off" aria-atomic="true">01 / {{ str_pad((string) $siteBanners->count(), 2, '0', STR_PAD_LEFT) }}</span>
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
                <a class="text-link" href="{{ route('about') }}">Who we are <span aria-hidden="true">→</span></a>
            </div>
            <p class="hero-note">A considered view of value, quality, and opportunity.</p>
        </div>

        <div class="hero-art hero-art--photo">
            <figure class="hero-banner">
                <img
                    class="hero-banner__image"
                    src="{{ asset('assets/images/antique-metals-banner.jpg') }}"
                    alt="Ornate antique mantel clock displayed between decorative vases in a shop window"
                    width="1800"
                    height="1200"
                    fetchpriority="high">
                <figcaption class="hero-banner__caption">
                    <span class="hero-banner__eyebrow">Antique metalwork</span>
                    <span class="hero-banner__headline">Value with<br>a history.</span>
                </figcaption>
            </figure>
            <span class="hero-art__side-note" aria-hidden="true">A connected market view</span>
        </div>
    </section>

    <section class="story" id="about" aria-labelledby="about-title">
        <div class="story__ornament" aria-hidden="true">W</div>
        <div class="story__content">
            <p class="eyebrow eyebrow--light">About WONDER ANTIQUE METALS</p>
            <h2 id="about-title">Welcome To<br><em>WONDER ANTIQUE METALS</em></h2>
            <div class="story__bottom">
                <p>WONDER is a worldwide company and have a strong network and ratifying its business activities in USA, UK, Germany, France and India in particular and also we do other part of the world like Romania, Russia, Poland, Korea, Israel, Singapore, Canada and Australia in general.</p>
                <p>WONDER ANTIQUE METALS is committed to serve its customers with Integrity, Professionalism and the Expertise and dedicated to promote advance technology for the global excellence and abundance.</p>
                <p>WONDER ANTIQUE METALS is a syndicate and a group of reputed (investors, producers, refiners, fabricators, metallurgists, scientists, users, and financial institutions) professional that supports regulatory, assaying, acquisition and auctioning of precious metals, antique items and also super natural rare metals in the international markets. WONDER ANTIQUE METALS team is dedicated and focused to provide custom field solutions and expert in quality assessment and technical examining services.</p>
            </div>
        </div>
    </section>

    <section class="intro-strip" aria-label="Antique and appraisal service areas">
        <div class="intro-strip__inner">
            <span>Regulatory</span><i aria-hidden="true"></i>
            <span>Assaying</span><i aria-hidden="true"></i>
            <span>Acquisition</span><i aria-hidden="true"></i>
            <span>Auction</span><i aria-hidden="true"></i>
            <span>Monetization</span><i aria-hidden="true"></i>
            <span>Appraisals</span>
        </div>
    </section>

    <section class="services section-shell" id="services" aria-labelledby="services-title">
        <div class="services-overview">
            <div class="services-overview__copy">
                <p class="eyebrow">Antiques</p>
                <h2 id="services-title">Antique Services</h2>
                <p class="services-overview__text">Explore regulatory guidance, assaying, acquisition, auction, and monetization for antique and precious-metal assets. Our appraisal pages explain the process, terms, and fee information.</p>
                <a class="text-link services-overview__link" href="{{ route('services.index') }}">Explore all services <span aria-hidden="true">→</span></a>
            </div>
            <figure class="services-overview__image">
                <img
                    src="{{ asset('assets/images/antique-display-slide.jpg') }}"
                    alt="Vintage and antique jewelry and decorative objects arranged together"
                    width="1920"
                    height="1280"
                    loading="lazy">
            </figure>
        </div>

                <div class="services-grid">
            @foreach ($siteServices as $card)
            <article class="service-card">
                <div class="service-card__top"><span class="card-number">{{ $card->number }} / {{ strtoupper($card->eyebrow) }}</span><span class="service-card__seal" aria-hidden="true">{{ strtoupper(mb_substr($card->title, 0, 1)) }}</span></div>
                <h3>{{ $card->title }}</h3>
                <p>{{ $card->summary }}</p>
                <a class="text-link service-card__link" href="{{ route('services.show', $card->slug) }}" aria-label="Read more about {{ strtolower($card->title) }}">Read more <span aria-hidden="true">→</span></a>
            </article>
            @endforeach
        </div>

        <section class="appraisal-overview" aria-labelledby="appraisal-overview-title">
            <div class="appraisal-overview__copy">
                <p class="eyebrow">Appraisals</p>
                <h3 id="appraisal-overview-title">Antique Appraisals</h3>
                <p>Learn what an appraisal considers, how the process works, and how to request current terms and fee information. Scope and charges are discussed with you before work begins.</p>
                <a class="text-link" href="{{ route('appraisals.index') }}">Explore antique appraisals <span aria-hidden="true">→</span></a>
            </div>
            <nav class="appraisal-overview__links" aria-label="Appraisal information">
                <span class="appraisal-overview__label">More information</span>
                @foreach ($siteAppraisals->where('slug', '!=', 'appraisals') as $ap)
                <a href="{{ $ap->url }}">{{ $ap->nav_label }} <span aria-hidden="true">↗</span></a>
                @endforeach
            </nav>
        </section>
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
        <a class="button button-dark" href="{{ route('contact') }}">Contact us <span aria-hidden="true">↗</span></a>
    </section>
</main>
@endsection
