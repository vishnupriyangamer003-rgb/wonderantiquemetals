@extends('layout')

@section('title', 'Antique Appraisals | Wonder Antique Metals')
@section('description', 'Learn about the appraisal approach for antique objects, precious metals, and rare materials.')

@section('content')
<main id="main">
    <section class="service-page-missing section-shell" aria-labelledby="page-title">
        <p class="eyebrow">In migration</p>
        <h1 id="page-title">Antique<br><em>Appraisals.</em></h1>
        <p>This page’s content moves over from the legacy Core PHP site in the next migration phase.</p>
        <a class="button button-dark" href="{{ route('appraisals.terms') }}">Appraisal terms <span aria-hidden="true">→</span></a>
    </section>
</main>
@endsection
