@extends('admin.layout')

@php $isNew = ! $item->exists; $v = fn ($k, $d = '') => old($k, $item->{$k} ?? $d); @endphp
@section('title', $isNew ? 'Add banner' : 'Edit banner')
@section('heading', $isNew ? 'Add banner' : 'Edit banner')
@section('sub', 'Use a wide image (about 1920 × 1280). Press Enter in the title for a line break.')
@section('actions')<a class="adm-btn" href="{{ route('admin.banners.index') }}">Back</a>@endsection

@section('content')
<form class="adm-card adm-stack" method="post" enctype="multipart/form-data" action="{{ $isNew ? route('admin.banners.store') : route('admin.banners.update', $item->id) }}">
    @csrf
    @unless ($isNew) @method('PUT') @endunless
    @include('admin._image', ['name' => 'image', 'label' => 'Banner image', 'current' => $item->image, 'required' => $isNew])
    <div class="adm-grid">
        <div class="adm-field adm-span"><label for="f-alt">Image description (for accessibility)</label><input type="text" id="f-alt" name="alt" value="{{ $v('alt') }}" maxlength="200"></div>
        <div class="adm-field"><label for="f-eyebrow">Small heading</label><input type="text" id="f-eyebrow" name="eyebrow" value="{{ $v('eyebrow') }}" maxlength="150"></div>
        <div class="adm-field adm-w-xs"><label for="f-sort">Order</label><input type="number" id="f-sort" name="sort_order" value="{{ $v('sort_order', 0) }}" min="0" max="9999"></div>
        <div class="adm-field adm-span"><label for="f-title">Title <span class="req">*</span></label><textarea id="f-title" name="title" rows="2" maxlength="200" required>{{ $v('title') }}</textarea></div>
        <div class="adm-field adm-span"><label for="f-text">Text</label><textarea id="f-text" name="text" rows="3" maxlength="500">{{ $v('text') }}</textarea></div>
        <div class="adm-field"><label for="f-bl">Button label</label><input type="text" id="f-bl" name="button_label" value="{{ $v('button_label') }}" maxlength="60"></div>
        <div class="adm-field"><label for="f-bu">Button link</label><input type="text" id="f-bu" name="button_url" value="{{ $v('button_url') }}" maxlength="300" placeholder="/services"><small>Starts with / or https://</small></div>
    </div>
    <label class="adm-check"><input type="checkbox" name="active" value="1" @checked(old('active', $item->active ?? true))> Show on website</label>
    <div class="adm-savebar"><button class="adm-btn" type="button" data-reset>Reset</button><button class="adm-btn adm-btn--primary" type="submit">Save</button></div>
</form>
@endsection
