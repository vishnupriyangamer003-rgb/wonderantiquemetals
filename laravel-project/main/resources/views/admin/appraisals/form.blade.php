@extends('admin.layout')

@php
    $isNew = ! $item->exists;
    $v = fn ($k, $d = '') => old($k, $item->{$k} ?? $d);
    $headings = old('section_heading', array_column($item->sections ?? [], 'heading'));
    $texts = old('section_text', array_column($item->sections ?? [], 'text'));
    if (! $headings) { $headings = ['']; $texts = ['']; }
@endphp
@section('title', $isNew ? 'Add appraisal page' : 'Edit appraisal page')
@section('heading', $isNew ? 'Add appraisal page' : 'Edit appraisal page')
@section('sub', 'Heading, intro and any number of titled sections.')
@section('actions')<a class="adm-btn" href="{{ route('admin.appraisals.index') }}">Back</a>@endsection

@section('content')
<form class="adm-card adm-stack" method="post" action="{{ $isNew ? route('admin.appraisals.store') : route('admin.appraisals.update', $item->id) }}">
    @csrf
    @unless ($isNew) @method('PUT') @endunless
    <div class="adm-grid">
        <div class="adm-field"><label for="f-nav">Menu name <span class="req">*</span></label><input type="text" id="f-nav" name="nav_label" value="{{ $v('nav_label') }}" maxlength="80" required></div>
        <div class="adm-field adm-w-sm"><label for="f-slug">Slug <span class="req">*</span></label><input type="text" id="f-slug" name="slug" value="{{ $v('slug') }}" maxlength="80" pattern="[a-z0-9]+(-[a-z0-9]+)*" required><small>Lowercase letters, numbers and dashes.</small></div>
        <div class="adm-field adm-span"><label for="f-mt">Browser title <span class="req">*</span></label><input type="text" id="f-mt" name="meta_title" value="{{ $v('meta_title') }}" maxlength="200" required></div>
        <div class="adm-field adm-span"><label for="f-md">Meta description</label><textarea id="f-md" name="meta_description" rows="2" maxlength="400">{{ $v('meta_description') }}</textarea></div>
        <div class="adm-field adm-span"><label for="f-eb">Small heading</label><input type="text" id="f-eb" name="eyebrow" value="{{ $v('eyebrow') }}" maxlength="150"></div>
        <div class="adm-field"><label for="f-h">Heading <span class="req">*</span></label><input type="text" id="f-h" name="heading" value="{{ $v('heading') }}" maxlength="120" required></div>
        <div class="adm-field"><label for="f-hem">Heading (italic part)</label><input type="text" id="f-hem" name="heading_em" value="{{ $v('heading_em') }}" maxlength="120"></div>
        <div class="adm-field adm-span"><label for="f-lead">Intro</label><textarea id="f-lead" name="lead" rows="3" maxlength="600">{{ $v('lead') }}</textarea></div>
        <div class="adm-field"><label for="f-bl">Button label</label><input type="text" id="f-bl" name="button_label" value="{{ $v('button_label') }}" maxlength="80"></div>
        <div class="adm-field adm-w-xs"><label for="f-sort">Order</label><input type="number" id="f-sort" name="sort_order" value="{{ $v('sort_order', 0) }}" min="0" max="9999"></div>
    </div>

    <h2>Sections</h2>
    <div class="adm-stack" data-sections>
        @foreach ($headings as $i => $heading)
            <div class="adm-section" data-section>
                <div class="adm-field"><label>Section title</label><input type="text" name="section_heading[]" value="{{ $heading }}" maxlength="150"></div>
                <div class="adm-field"><label>Section text</label><textarea name="section_text[]" rows="3" maxlength="3000">{{ $texts[$i] ?? '' }}</textarea></div>
                <button class="adm-btn adm-btn--danger-ghost" type="button" data-remove-section>Remove section</button>
            </div>
        @endforeach
    </div>
    <button class="adm-btn" type="button" data-add-section>@include('admin._icon', ['name' => 'plus']) Add section</button>

    <label class="adm-check"><input type="checkbox" name="active" value="1" @checked(old('active', $item->active ?? true))> Show on website</label>
    <div class="adm-savebar"><button class="adm-btn" type="button" data-reset>Reset</button><button class="adm-btn adm-btn--primary" type="submit">Save</button></div>
</form>
@endsection
