@extends('admin.layout')

@php $isNew = ! $item->exists; $v = fn ($k, $d = '') => old($k, $item->{$k} ?? $d); @endphp
@section('title', $isNew ? 'Add testimonial' : 'Edit testimonial')
@section('heading', $isNew ? 'Add testimonial' : 'Edit testimonial')
@section('sub', 'A short client quote with the name and place.')
@section('actions')<a class="adm-btn" href="{{ route('admin.testimonials.index') }}">Back</a>@endsection

@section('content')
<form class="adm-card adm-card--narrow adm-stack" method="post" action="{{ $isNew ? route('admin.testimonials.store') : route('admin.testimonials.update', $item->id) }}">
    @csrf
    @unless ($isNew) @method('PUT') @endunless
    <div class="adm-field"><label for="f-name">Name <span class="req">*</span></label><input type="text" id="f-name" name="name" value="{{ $v('name') }}" maxlength="100" required></div>
    <div class="adm-field"><label for="f-loc">Place</label><input type="text" id="f-loc" name="location" value="{{ $v('location') }}" maxlength="100"></div>
    <div class="adm-field"><label for="f-quote">Quote <span class="req">*</span></label><textarea id="f-quote" name="quote" rows="5" maxlength="800" required>{{ $v('quote') }}</textarea></div>
    <div class="adm-field adm-w-xs"><label for="f-sort">Order</label><input type="number" id="f-sort" name="sort_order" value="{{ $v('sort_order', 0) }}" min="0" max="9999"></div>
    <label class="adm-check"><input type="checkbox" name="active" value="1" @checked(old('active', $item->active ?? true))> Show on website</label>
    <div class="adm-savebar"><button class="adm-btn" type="button" data-reset>Reset</button><button class="adm-btn adm-btn--primary" type="submit">Save</button></div>
</form>
@endsection
