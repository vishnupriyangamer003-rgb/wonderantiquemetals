@extends('layout')

@section('title', 'Appraisal Procedure | Wonder Antique Metals')
@section('description', 'See the general steps for discussing and arranging an appraisal.')

@section('content')
<main id="main">
    <section class="service-page-missing section-shell" aria-labelledby="page-title">
        <p class="eyebrow">In migration</p>
        <h1 id="page-title">Appraisal<br><em>Procedure.</em></h1>
        <p>This page’s content moves over from the legacy Core PHP site in the next migration phase.</p>
        <a class="button button-dark" href="{{ route('appraisals.index') }}">Appraisals overview <span aria-hidden="true">→</span></a>
    </section>
</main>
@endsection
