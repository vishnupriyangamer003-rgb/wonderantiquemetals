@extends('layout')

@section('title', 'Appraisal Terms & Conditions | Wonder Antique Metals')
@section('description', 'Review the general information about appraisal terms before arranging an appraisal.')

@section('content')
<main id="main">
    <section class="service-page-missing section-shell" aria-labelledby="page-title">
        <p class="eyebrow">In migration</p>
        <h1 id="page-title">Appraisal<br><em>Terms.</em></h1>
        <p>This page’s content moves over from the legacy Core PHP site in the next migration phase.</p>
        <a class="button button-dark" href="{{ route('appraisals.index') }}">Appraisals overview <span aria-hidden="true">→</span></a>
    </section>
</main>
@endsection
