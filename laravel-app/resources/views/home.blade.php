@extends('layout')

{{-- Legacy index.php sets no $pageTitle/$pageDescription, so the layout's
     default metadata (same strings as includes/header.php) applies. --}}

@section('content')
<main id="main">
    <section class="service-page-missing section-shell" aria-labelledby="page-title">
        <p class="eyebrow">In migration</p>
        <h1 id="page-title">Home<br><em>page.</em></h1>
        <p>This page’s content moves over from the legacy Core PHP site in the next migration phase.</p>
        <a class="button button-dark" href="{{ route('services.index') }}">View services <span aria-hidden="true">→</span></a>
    </section>
</main>
@endsection
