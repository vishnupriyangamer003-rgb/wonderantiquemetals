@extends('admin.layout')

@section('title', 'Testimonials')
@section('heading', 'Testimonials')
@section('sub', 'Shown on the About page. Only publish quotes you have permission to use.')
@section('actions')<a class="adm-btn adm-btn--primary" href="{{ route('admin.testimonials.create') }}">@include('admin._icon', ['name' => 'plus']) Add testimonial</a>@endsection

@section('content')
@php $tints = ['pink', 'yellow', 'blue', 'purple']; @endphp
<div class="adm-cards">
    @forelse ($items as $item)
        <article class="adm-tile adm-tint-{{ $tints[$loop->index % 4] }} @unless ($item->active) is-off @endunless">
            <div class="adm-tile__body">
                <span class="adm-pill">#{{ $item->sort_order }}@unless ($item->active) · Hidden @endunless</span>
                <h3>{{ $item->name }}</h3>
                <p class="adm-muted">{{ $item->location }}</p>
                <p>“{{ \Illuminate\Support\Str::limit($item->quote, 130) }}”</p>
                @include('admin._actions', ['key' => 'testimonials', 'item' => $item])
            </div>
        </article>
    @empty
        <p class="adm-empty">No testimonials yet.</p>
    @endforelse
</div>
@endsection
