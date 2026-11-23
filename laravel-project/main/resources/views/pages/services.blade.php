@extends('layout')

@section('title', 'Services | Wonder Antique Metals')

@section('content')
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
                src="{{ asset('assets/images/services-hero.jpg') }}"
                alt="Vintage and antique jewelry and decorative objects arranged together"
                width="1920"
                height="1280"
                fetchpriority="high">
        </figure>
    </section>

    <nav class="service-index" id="service-index" aria-label="Service areas">
        <div class="service-index__inner section-shell">
            <p>{{ ['Zero', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine', 'Ten'][$siteServices->count()] ?? $siteServices->count() }} connected service areas</p>
            <ol>
                @foreach ($siteServices as $s)
                <li><a href="#service-{{ $s->slug }}"><span>{{ $s->number }}</span> {{ \Illuminate\Support\Str::before($s->title, ' ') }}</a></li>
                @endforeach
            </ol>
        </div>
    </nav>

    <section class="service-details" aria-label="Service details">
        @foreach ($siteServices as $s)
        <article class="service-detail" id="service-{{ $s->slug }}">
            <div class="service-detail__number" aria-hidden="true">{{ $s->number }}</div>
            <div class="service-detail__copy">
                <p class="eyebrow">{{ $s->eyebrow }}</p>
                <h2>{{ $s->title }}</h2>
                <p>{{ $s->summary }}</p>
                <a class="text-link" href="{{ route('services.show', $s->slug) }}">Read more <span aria-hidden="true">→</span></a>
            </div>
        </article>
        @endforeach
    </section>

</main>
@endsection
