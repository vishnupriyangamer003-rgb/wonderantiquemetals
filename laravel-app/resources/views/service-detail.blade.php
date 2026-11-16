@extends('layout')

@section('title', $pageTitle)
@section('description', $pageDescription)

@section('content')
<main id="main">
    <nav class="service-chips section-shell" aria-label="Services">
        <ul>
            @foreach ($services as $key => $item)
                <li>
                    <a href="{{ route('services.show', ['slug' => $key]) }}"@if ($key === $slug) aria-current="page"@endif>{{ $item['title'] }}</a>
                </li>
            @endforeach
        </ul>
    </nav>

    <article class="service-page-layout section-shell" aria-labelledby="service-title">
        <figure class="service-page-layout__visual">
            <img src="{{ asset($service['image']) }}" alt="{{ $service['alt'] }}" width="1920" height="1280" fetchpriority="high">
        </figure>
        <div class="service-page-layout__copy">
            <p class="eyebrow">{{ $service['number'] . ' · ' . $service['eyebrow'] }}</p>
            <h1 id="service-title">{{ $service['title'] }}</h1>
            <p class="service-page-layout__lead">{{ $service['summary'] }}</p>
            @foreach ($service['details'] as $paragraph)
                <p>{{ $paragraph }}</p>
            @endforeach
        </div>
    </article>
</main>
@endsection
