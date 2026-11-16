@extends('admin.layout')

@section('title', 'Appraisals')
@section('heading', 'Appraisals')
@section('sub', 'Appraisal pages shown in the Appraisals menu. The page with slug "appraisals" is the main appraisals page.')
@section('actions')<a class="adm-btn adm-btn--primary" href="{{ route('admin.appraisals.create') }}">@include('admin._icon', ['name' => 'plus']) Add page</a>@endsection

@section('content')
@php $tints = ['yellow', 'purple', 'blue', 'pink']; @endphp
<div class="adm-cards">
    @forelse ($items as $item)
        <article class="adm-tile adm-tint-{{ $tints[$loop->index % 4] }} @unless ($item->active) is-off @endunless">
            <div class="adm-tile__body">
                <span class="adm-pill">{{ $item->slug === 'appraisals' ? '/appraisals' : '/appraisals/'.$item->slug }}@unless ($item->active) · Hidden @endunless</span>
                <h3>{{ $item->nav_label }}</h3>
                <p>{{ \Illuminate\Support\Str::limit($item->lead, 110) }}</p>
                @include('admin._actions', ['key' => 'appraisals', 'item' => $item])
            </div>
        </article>
    @empty
        <p class="adm-empty">No appraisal pages yet.</p>
    @endforelse
</div>
@endsection
