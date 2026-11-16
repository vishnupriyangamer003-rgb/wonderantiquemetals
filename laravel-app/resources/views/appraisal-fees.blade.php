@extends('layout')

@section('title', 'Appraisal Fee Structure | Wonder Antique Metals')
@section('description', 'Request current appraisal fees based on the scope of the work required.')

@section('content')
<main id="main">
    <section class="service-page-missing section-shell" aria-labelledby="page-title">
        <p class="eyebrow">In migration</p>
        <h1 id="page-title">Appraisal<br><em>Fee Structure.</em></h1>
        <p>This page’s content moves over from the legacy Core PHP site in the next migration phase.</p>
        <a class="button button-dark" href="{{ route('appraisals.index') }}">Appraisals overview <span aria-hidden="true">→</span></a>
    </section>
</main>
@endsection
