@extends('admin.layout')

@section('title', 'Banners')
@section('heading', 'Banners')
@section('sub', 'Slides shown at the top of the home page, in the order below.')
@section('actions')<a class="adm-btn adm-btn--primary" href="{{ route('admin.banners.create') }}">@include('admin._icon', ['name' => 'plus']) Add banner</a>@endsection

@section('content')
<div class="adm-cards">
    @forelse ($items as $item)
        <article class="adm-tile @unless ($item->active) is-off @endunless">
            <img class="adm-tile__img" src="{{ asset($item->image) }}" alt="" loading="lazy">
            <div class="adm-tile__body">
                <span class="adm-pill">#{{ $item->sort_order }}@unless ($item->active) · Hidden @endunless</span>
                <h3>{{ str_replace("\n", ' ', $item->title) }}</h3>
                <p>{{ $item->eyebrow }}</p>
                @include('admin._actions', ['key' => 'banners', 'item' => $item])
            </div>
        </article>
    @empty
        <p class="adm-empty">No banners yet. Add your first one.</p>
    @endforelse
</div>
@endsection
