@extends('layout')

@section('title', 'Services | Wonder Antique Metals')
@section('description', 'Explore regulatory support, assaying and assessment, acquisition, auction services, and monetization at Wonder Antique Metals.')

@section('content')
<main id="main">
    <section class="service-page-missing section-shell" aria-labelledby="page-title">
        <p class="eyebrow">In migration</p>
        <h1 id="page-title">Our<br><em>Services.</em></h1>
        <p>This page’s content moves over from the legacy Core PHP site in the next migration phase. The five individual service pages are already available.</p>
        <a class="button button-dark" href="{{ route('services.show', ['slug' => 'regulatory']) }}">First service <span aria-hidden="true">→</span></a>
    </section>
</main>
@endsection
