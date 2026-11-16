@extends('admin.layout')

@section('title', 'Login details')
@section('heading', 'Login details')
@section('sub', 'Change your username and password. The password is shown so you can check it; use the eye to hide it.')

@section('content')
<form class="adm-card adm-card--narrow adm-stack" method="post" action="{{ route('admin.account.update') }}">
    @csrf
    @method('PUT')
    <div class="adm-field adm-w-sm">
        <label for="f-username">Username</label>
        <input type="text" id="f-username" name="username" value="{{ old('username', $admin->username) }}" autocomplete="username" minlength="3" maxlength="60" required>
        <small>Letters, numbers, dot, dash and underscore.</small>
    </div>
    @include('admin._password', ['name' => 'password', 'label' => 'Password', 'value' => old('password', $admin->password), 'autocomplete' => 'new-password', 'class' => 'adm-w-sm'])
    <div class="adm-savebar adm-savebar--start"><button class="adm-btn" type="button" data-reset>Reset</button><button class="adm-btn adm-btn--primary" type="submit">Save</button></div>
</form>
@endsection
