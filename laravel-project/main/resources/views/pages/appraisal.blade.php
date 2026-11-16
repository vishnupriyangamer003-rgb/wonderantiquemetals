@extends('layout')

@section('title', $appraisal->meta_title)
@section('description', $appraisal->meta_description ?? '')

@section('content')
<main id="main">
    <section class="appraisal-page section-shell" aria-labelledby="appraisal-title">
        <div class="appraisal-page__inner">
            @if ($appraisal->eyebrow)<p class="eyebrow">{{ $appraisal->eyebrow }}</p>@endif
            <h1 id="appraisal-title">{{ $appraisal->heading }}@if ($appraisal->heading_em)<br><em>{{ $appraisal->heading_em }}</em>@endif</h1>
            @if ($appraisal->lead)<p class="appraisal-page__lead">{{ $appraisal->lead }}</p>@endif
            <div class="appraisal-page__content">
                @foreach ($appraisal->sections ?? [] as $i => $section)
                <section class="appraisal-page__section" aria-labelledby="appraisal-section-{{ $i }}">
                    <h2 id="appraisal-section-{{ $i }}">{{ $section['heading'] ?? '' }}</h2>
                    <div>
                        <p>{{ $section['text'] ?? '' }}</p>
                    </div>
                </section>
                @endforeach
            </div>
            @if ($appraisal->button_label)
            <a class="button button-dark appraisal-page__action" href="{{ route('contact') }}">{{ $appraisal->button_label }} <span aria-hidden="true">↗</span></a>
            @endif
        </div>
    </section>
</main>
@endsection