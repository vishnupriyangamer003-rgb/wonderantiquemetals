@extends('layout')

@section('title', $service->title.' | Wonder Antique Metals')
@section('description', $service->summary)

@section('content')
<main id="main">
    <nav class="service-chips section-shell" aria-label="Services">
        <ul>
            @foreach ($siteServices as $item)
                <li>
                    <a href="{{ route('services.show', $item->slug) }}"@if ($item->slug === $service->slug) aria-current="page"@endif>{{ $item->title }}</a>
                </li>
            @endforeach
        </ul>
    </nav>

    <article class="service-page-layout section-shell" aria-labelledby="service-title">
        @if ($service->image)
        <figure class="service-page-layout__visual">
            <img src="{{ asset($service->image) }}" alt="{{ $service->alt }}" width="1920" height="1280" fetchpriority="high">
        </figure>
        @endif
        <div class="service-page-layout__copy">
            <p class="eyebrow">{{ $service->number }} · {{ $service->eyebrow }}</p>
            <h1 id="service-title">{{ $service->title }}</h1>
            <p class="service-page-layout__lead">{{ $service->summary }}</p>
            @foreach ($service->details ?? [] as $paragraph)
                <p>{{ $paragraph }}</p>
            @endforeach
        </div>
    </article>
</main>
@endsection