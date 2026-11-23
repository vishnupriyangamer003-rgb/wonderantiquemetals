@extends('layout')

@section('title', 'Page not found | Wonder Antique Metals')

@section('content')
<main id="main">
    <section class="service-page-missing section-shell" aria-labelledby="service-missing-title">
        <p class="eyebrow">404</p>
        <h1 id="service-missing-title">Page<br><em>not found.</em></h1>
        <p>We couldn’t find that page. Please choose one from our services overview.</p>
        <a class="button button-dark" href="{{ route('services.index') }}">All services <span aria-hidden="true">→</span></a>
    </section>
</main>
@endsection
