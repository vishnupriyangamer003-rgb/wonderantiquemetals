@extends('admin.layout')

@php $isNew = ! $item->exists; $v = fn ($k, $d = '') => old($k, $item->{$k} ?? $d); @endphp
@section('title', $isNew ? 'Add team member' : 'Edit team member')
@section('heading', $isNew ? 'Add team member' : 'Edit team member')
@section('sub', 'Name, role, a short bio and an optional photo.')
@section('actions')<a class="adm-btn" href="{{ route('admin.team.index') }}">Back</a>@endsection

@section('content')
<form class="adm-card adm-card--narrow adm-stack" method="post" enctype="multipart/form-data" action="{{ $isNew ? route('admin.team.store') : route('admin.team.update', $item->id) }}">
    @csrf
    @unless ($isNew) @method('PUT') @endunless
    <div class="adm-field"><label for="f-name">Name <span class="req">*</span></label><input type="text" id="f-name" name="name" value="{{ $v('name') }}" maxlength="100" required></div>
    <div class="adm-field"><label for="f-role">Role <span class="req">*</span></label><input type="text" id="f-role" name="role" value="{{ $v('role') }}" maxlength="100" required></div>
    <div class="adm-field"><label for="f-bio">Short bio</label><textarea id="f-bio" name="bio" rows="4" maxlength="500">{{ $v('bio') }}</textarea></div>
    @include('admin._image', ['name' => 'image', 'label' => 'Photo', 'current' => $item->image])
    <div class="adm-field adm-w-xs"><label for="f-sort">Order</label><input type="number" id="f-sort" name="sort_order" value="{{ $v('sort_order', 0) }}" min="0" max="9999"></div>
    <label class="adm-check"><input type="checkbox" name="active" value="1" @checked(old('active', $item->active ?? true))> Show on website</label>
    <div class="adm-savebar"><button class="adm-btn" type="button" data-reset>Reset</button><button class="adm-btn adm-btn--primary" type="submit">Save</button></div>
</form>
@endsection
