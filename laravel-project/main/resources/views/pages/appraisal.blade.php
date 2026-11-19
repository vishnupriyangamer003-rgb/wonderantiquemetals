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

            @php
                $appraisalImages = [
                    'appraisals' => 'assets/images/antique-appraisals.jpg',
                    'terms' => 'assets/images/appraisal-terms.jpg',
                    'procedure' => 'assets/images/appraisal-procedure.jpg',
                    'fees' => 'assets/images/appraisal-fees.jpg',
                ];
                $appraisalImage = $appraisalImages[$appraisal->slug] ?? null;
            @endphp
            @if ($appraisalImage)
            <figure class="appraisal-page__visual">
                <img src="{{ asset($appraisalImage) }}" alt="{{ $appraisal->heading }} {{ $appraisal->heading_em }}" width="1200" height="600" fetchpriority="high">
            </figure>
            @endif

            @if ($appraisal->slug === 'fees' && $feeItems->isNotEmpty())
                <div class="appraisal-table-wrap">
                    <table class="appraisal-table" aria-label="Appraisal Fee Structure">
                        <thead>
                            <tr>
                                <th scope="col">Service / Item</th>
                                <th scope="col" class="text-center">Qty</th>
                                <th scope="col" class="text-right">Amount / Rate</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($feeItems as $row)
                            <tr>
                                <td>{{ $row->item }}</td>
                                <td class="text-center">{{ $row->qty }}</td>
                                <td class="text-right">{{ $row->amount }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            <div class="appraisal-page__content">
                @foreach ($appraisal->sections ?? [] as $i => $section)
                <section class="appraisal-page__section" aria-labelledby="appraisal-section-{{ $i }}">
                    <h2 id="appraisal-section-{{ $i }}">{{ $section['heading'] ?? '' }}</h2>
                    <div>
                        @php
                            $text = trim($section['text'] ?? '');
                            $hasBullets = str_contains($text, "\n- ") || str_starts_with($text, "- ");
                        @endphp
                        @if ($hasBullets)
                            <ul class="appraisal-list">
                                @foreach (preg_split('~\R~', $text) as $line)
                                    @php $trimmed = trim(preg_replace('~^[-*•]\s*~', '', trim($line))); @endphp
                                    @if ($trimmed !== '')
                                        <li>{{ $trimmed }}</li>
                                    @endif
                                @endforeach
                            </ul>
                        @else
                            @foreach (preg_split('~\R{2,}~', $text) as $p)
                                <p>{!! nl2br(e(trim($p))) !!}</p>
                            @endforeach
                        @endif
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
