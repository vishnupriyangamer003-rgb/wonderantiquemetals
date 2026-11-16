@extends('layout')

@section('title', 'Contact | Wonder Antique Metals')
@section('description', 'Contact Wonder Antique Metals in Karur District, Tamil Nadu. Sample address, phone, email, and opening hours are shown for layout preview.')

@section('content')
<main id="main">
    <section class="contact-hero section-shell" aria-labelledby="contact-title">
        <div class="contact-hero__heading">
            <p class="eyebrow">Contact · Karur District</p>
            <h1 id="contact-title">Let’s<br><em>connect.</em></h1>
        </div>
        <div class="contact-hero__copy">
            <p>For enquiries about precious metals, antique items, and rare materials, get in touch using the details below.</p>
        </div>
    </section>

    <section class="contact-details section-shell" id="contact-details" aria-label="Contact information">
        <div class="contact-details__grid">
            <article class="contact-card">
                <span class="card-number">01 / ADDRESS</span>
                <h3>Visit us</h3>
                <address>{!! implode('<br>', array_map('e', array_values(array_filter(array_map('trim', preg_split('~\R~', $site['address'] ?? '')))))) !!}</address>
            </article>
            <article class="contact-card">
                <span class="card-number">02 / REACH OUT</span>
                <h3>Phone &amp; email</h3>
                <p><span>Phone</span><br>{{ $site['phone'] ?? '' }}</p>
                @if (!empty($site['whatsapp']))
                <p><span>WhatsApp</span><br><a href="https://wa.me/{{ preg_replace('~\D+~', '', $site['whatsapp']) }}" target="_blank" rel="noopener noreferrer">{{ $site['whatsapp'] }}</a></p>
                @endif
                <p><span>Email</span><br><a href="mailto:{{ $site['email'] ?? '' }}">{{ $site['email'] ?? '' }}</a></p>
            </article>
            <article class="contact-card">
                <span class="card-number">03 / VISITING HOURS</span>
                <h3>Opening hours</h3>
                <dl class="contact-hours">
                    <div><dt>{{ $site['hours_weekday_label'] ?? '' }}</dt><dd>{{ $site['hours_weekday'] ?? '' }}</dd></div>
                    <div><dt>{{ $site['hours_sunday_label'] ?? '' }}</dt><dd>{{ $site['hours_sunday'] ?? '' }}</dd></div>
                </dl>
            </article>
        </div>
    </section>

    @php
        $mapQuery = trim($site['google_map_query'] ?? '');
        $mapLabel = trim($site['google_map_label'] ?? '') ?: $mapQuery;
        [$mapA, $mapB] = array_pad(array_map('trim', explode(',', $mapLabel, 2)), 2, '');
    @endphp
    @if ($mapQuery !== '')
    <section class="contact-map" id="contact-map" aria-labelledby="contact-map-title">
        <div class="contact-map__inner section-shell">
            <div class="contact-map__heading">
                <div>
                    <p class="eyebrow eyebrow--light">Find the district</p>
                    <h2 id="contact-map-title">{{ $mapB !== '' ? $mapA.',' : $mapA }}@if ($mapB !== '')<br><em>{{ $mapB }}.</em>@endif</h2>
                </div>
                <p>The map shows {{ $mapA }} as a general area. The street address above is sample information, not a verified business location.</p>
            </div>
            <div class="contact-map__frame">
                <iframe
                    title="Map showing {{ $mapQuery }}"
                    src="https://www.google.com/maps?q={{ urlencode($mapQuery) }}&amp;output=embed"
                    width="1200"
                    height="450"
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                    allowfullscreen></iframe>
            </div>
            <a class="contact-map__link" href="https://www.google.com/maps/search/?api=1&amp;query={{ urlencode($mapQuery) }}" target="_blank" rel="noopener noreferrer">Open {{ $mapA }} in Google Maps <span aria-hidden="true">↗</span></a>
        </div>
    </section>
    @endif
</main>
@endsection
