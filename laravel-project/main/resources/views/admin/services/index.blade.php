@extends('admin.layout')

@section('title', 'Services')
@section('heading', 'Services (Antiques)')
@section('sub', 'Each service becomes a page and appears in the Antiques menu and footer.')
@section('actions')<a class="adm-btn adm-btn--primary" href="{{ route('admin.services.create') }}">@include('admin._icon', ['name' => 'plus']) Add service</a>@endsection

@section('content')
@php $tints = ['yellow', 'pink', 'purple', 'blue', 'grey']; @endphp
<div class="adm-cards">
    @forelse ($items as $item)
        <article class="adm-tile adm-tint-{{ $tints[$loop->index % 5] }} @unless ($item->active) is-off @endunless">
            @if ($item->image)<img class="adm-tile__img" src="{{ asset($item->image) }}" alt="" loading="lazy">@endif
            <div class="adm-tile__body">
                <span class="adm-pill">{{ $item->number }} · /services/{{ $item->slug }}@unless ($item->active) · Hidden @endunless</span>
                <h3>{{ $item->title }}</h3>
                <p>{{ \Illuminate\Support\Str::limit($item->summary, 110) }}</p>
                @include('admin._actions', ['key' => 'services', 'item' => $item])
            </div>
        </article>
    @empty
        <p class="adm-empty">No services yet.</p>
    @endforelse
</div>
@endsection
