@extends('admin.layout')

@section('title', 'Fee structure')
@section('heading', 'Fee structure')
@section('sub', 'Rows of the fee table on the Fee Structure page. Notes are edited under Appraisals → Fee Structure → Sections.')
@section('actions')<a class="adm-btn adm-btn--primary" href="{{ route('admin.fees.create') }}">@include('admin._icon', ['name' => 'plus']) Add fee</a>@endsection

@section('content')
<div class="adm-cards">
    @forelse ($items as $item)
        <article class="adm-tile adm-tint-{{ ['pink', 'yellow', 'blue', 'purple'][$loop->index % 4] }} @unless ($item->active) is-off @endunless">
            <div class="adm-tile__body">
                <span class="adm-pill">#{{ $item->sort_order }}@unless ($item->active) · Hidden @endunless</span>
                <h3>{{ $item->item }}</h3>
                <p class="adm-muted">Qty {{ $item->qty }} · {{ $item->amount }}</p>
                @include('admin._actions', ['key' => 'fees', 'item' => $item])
            </div>
        </article>
    @empty
        <p class="adm-empty">No fee rows yet.</p>
    @endforelse
</div>
@endsection
