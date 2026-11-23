@extends('admin.layout')

@php $isNew = ! $item->exists; $v = fn ($k, $d = '') => old($k, $item->{$k} ?? $d); @endphp
@section('title', $isNew ? 'Add fee' : 'Edit fee')
@section('heading', $isNew ? 'Add fee' : 'Edit fee')
@section('sub', 'One row of the fee table. The amount can be text, e.g. 12,500.00 or 2%.')
@section('actions')<a class="adm-btn" href="{{ route('admin.fees.index') }}">Back</a>@endsection

@section('content')
<form class="adm-card adm-card--narrow adm-stack" method="post" action="{{ $isNew ? route('admin.fees.store') : route('admin.fees.update', $item->id) }}">
    @csrf
    @unless ($isNew) @method('PUT') @endunless
    <div class="adm-field"><label for="f-item">Service / item <span class="req">*</span></label><input type="text" id="f-item" name="item" value="{{ $v('item') }}" maxlength="200" required></div>
    <div class="adm-field adm-w-xs"><label for="f-qty">Qty</label><input type="text" id="f-qty" name="qty" value="{{ $v('qty', '1') }}" maxlength="20"></div>
    <div class="adm-field"><label for="f-amount">Amount / rate <span class="req">*</span></label><input type="text" id="f-amount" name="amount" value="{{ $v('amount') }}" maxlength="40" required></div>
    <div class="adm-field adm-w-xs"><label for="f-sort">Order</label><input type="number" id="f-sort" name="sort_order" value="{{ $v('sort_order', 0) }}" min="0" max="9999"></div>
    <label class="adm-check"><input type="checkbox" name="active" value="1" @checked(old('active', $item->active ?? true))> Show on website</label>
    <div class="adm-savebar"><button class="adm-btn" type="button" data-reset>Reset</button><button class="adm-btn adm-btn--primary" type="submit">Save</button></div>
</form>
@endsection
