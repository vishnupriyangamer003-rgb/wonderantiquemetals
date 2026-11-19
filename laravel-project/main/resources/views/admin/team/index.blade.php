@extends('admin.layout')

@section('title', 'Team members')
@section('heading', 'Team members')
@section('sub', 'Shown on the About page. Only publish details you have permission to use.')
@section('actions')<a class="adm-btn adm-btn--primary" href="{{ route('admin.team.create') }}">@include('admin._icon', ['name' => 'plus']) Add team member</a>@endsection

@section('content')
@php $tints = ['pink', 'yellow', 'blue', 'purple']; @endphp
<div class="adm-cards">
    @forelse ($items as $item)
        <article class="adm-tile adm-tint-{{ $tints[$loop->index % 4] }} @unless ($item->active) is-off @endunless">
            <div class="adm-tile__body">
                <span class="adm-pill">#{{ $item->sort_order }}@unless ($item->active) · Hidden @endunless</span>
                <h3>{{ $item->name }}</h3>
                <p class="adm-muted">{{ $item->role }}</p>
                <p>{{ \Illuminate\Support\Str::limit($item->bio, 130) }}</p>
                @include('admin._actions', ['key' => 'team', 'item' => $item])
            </div>
        </article>
    @empty
        <p class="adm-empty">No team members yet.</p>
    @endforelse
</div>
@endsection
