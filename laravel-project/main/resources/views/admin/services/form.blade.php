@extends('admin.layout')

@php
    $isNew = ! $item->exists;
    $v = fn ($k, $d = '') => old($k, $item->{$k} ?? $d);
    $details = old('details', implode("\n\n", $item->details ?? []));
@endphp
@section('title', $isNew ? 'Add service' : 'Edit service')
@section('heading', $isNew ? 'Add service' : 'Edit service')
@section('sub', 'The page address is built from the short name (slug).')
@section('actions')<a class="adm-btn" href="{{ route('admin.services.index') }}">Back</a>@endsection

@section('content')
<form class="adm-card adm-stack" method="post" enctype="multipart/form-data" action="{{ $isNew ? route('admin.services.store') : route('admin.services.update', $item->id) }}">
    @csrf
    @unless ($isNew) @method('PUT') @endunless
    @include('admin._image', ['name' => 'image', 'label' => 'Service image', 'current' => $item->image])
    <div class="adm-grid">
        <div class="adm-field adm-span"><label for="f-alt">Image description (for accessibility)</label><input type="text" id="f-alt" name="alt" value="{{ $v('alt') }}" maxlength="200"></div>
        <div class="adm-field"><label for="f-title">Title <span class="req">*</span></label><input type="text" id="f-title" name="title" value="{{ $v('title') }}" maxlength="150" required></div>
        <div class="adm-field adm-w-sm"><label for="f-slug">Slug <span class="req">*</span></label><input type="text" id="f-slug" name="slug" value="{{ $v('slug') }}" maxlength="80" pattern="[a-z0-9]+(-[a-z0-9]+)*" placeholder="antique-clocks" required><small>Lowercase letters, numbers and dashes.</small></div>
        <div class="adm-field adm-w-xs"><label for="f-number">Number</label><input type="text" id="f-number" name="number" value="{{ $v('number') }}" maxlength="8" placeholder="06"></div>
        <div class="adm-field"><label for="f-eyebrow">Label</label><input type="text" id="f-eyebrow" name="eyebrow" value="{{ $v('eyebrow') }}" maxlength="60" placeholder="Market"></div>
        <div class="adm-field adm-w-xs"><label for="f-sort">Order</label><input type="number" id="f-sort" name="sort_order" value="{{ $v('sort_order', 0) }}" min="0" max="9999"></div>
        <div class="adm-field adm-span"><label for="f-summary">Short summary <span class="req">*</span></label><textarea id="f-summary" name="summary" rows="3" maxlength="600" required>{{ $v('summary') }}</textarea></div>
        <div class="adm-field adm-span"><label for="f-details">Details</label><textarea id="f-details" name="details" rows="9" maxlength="6000">{{ $details }}</textarea><small>Separate paragraphs with a blank line.</small></div>
    </div>
    <label class="adm-check"><input type="checkbox" name="active" value="1" @checked(old('active', $item->active ?? true))> Show on website</label>
    <div class="adm-savebar"><button class="adm-btn" type="button" data-reset>Reset</button><button class="adm-btn adm-btn--primary" type="submit">Save</button></div>
</form>
@endsection
