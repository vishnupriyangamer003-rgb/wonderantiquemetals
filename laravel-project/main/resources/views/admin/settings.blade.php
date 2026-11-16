@extends('admin.layout')

@section('title', 'Company info')
@section('heading', 'Company information')
@section('sub', 'Contact details, search meta and social links shown across the website.')

@section('content')
@php $v = fn ($k, $d = '') => old($k, $s[$k] ?? $d); @endphp
<form method="post" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" class="adm-stack">
    @csrf
    @method('PUT')

    <section class="adm-card adm-tint-yellow">
        <h2>Contact</h2>
        <div class="adm-grid">
            <div class="adm-field adm-w-sm"><label for="f-phone">Phone</label><input type="text" id="f-phone" name="phone" value="{{ $v('phone') }}" maxlength="60" inputmode="tel"></div>
            <div class="adm-field adm-w-sm"><label for="f-whatsapp">WhatsApp number</label><input type="text" id="f-whatsapp" name="whatsapp" value="{{ $v('whatsapp') }}" maxlength="60" inputmode="tel" placeholder="+91 98765 43210"><small>Used for the wa.me link. Include the country code.</small></div>
            <div class="adm-field"><label for="f-email">Email</label><input type="email" id="f-email" name="email" value="{{ $v('email') }}" maxlength="150"></div>
            <div class="adm-field adm-span"><label for="f-address">Address</label><textarea id="f-address" name="address" rows="3" maxlength="400">{{ $v('address') }}</textarea><small>One line per row.</small></div>
        </div>
    </section>

    <section class="adm-card adm-tint-blue">
        <h2>Opening hours</h2>
        <div class="adm-grid">
            <div class="adm-field adm-w-sm"><label for="f-hwl">Row 1 days</label><input type="text" id="f-hwl" name="hours_weekday_label" value="{{ $v('hours_weekday_label') }}" maxlength="60"></div>
            <div class="adm-field adm-w-sm"><label for="f-hw">Row 1 hours</label><input type="text" id="f-hw" name="hours_weekday" value="{{ $v('hours_weekday') }}" maxlength="60"></div>
            <div class="adm-field adm-w-sm"><label for="f-hsl">Row 2 days</label><input type="text" id="f-hsl" name="hours_sunday_label" value="{{ $v('hours_sunday_label') }}" maxlength="60"></div>
            <div class="adm-field adm-w-sm"><label for="f-hs">Row 2 hours</label><input type="text" id="f-hs" name="hours_sunday" value="{{ $v('hours_sunday') }}" maxlength="60"></div>
        </div>
    </section>

    <section class="adm-card adm-tint-purple">
        <h2>Search meta</h2>
        <div class="adm-grid">
            <div class="adm-field adm-span"><label for="f-mt">Meta title</label><input type="text" id="f-mt" name="meta_title" value="{{ $v('meta_title') }}" maxlength="200"></div>
            <div class="adm-field adm-span"><label for="f-md">Meta description</label><textarea id="f-md" name="meta_description" rows="3" maxlength="400">{{ $v('meta_description') }}</textarea></div>
            <div class="adm-field adm-span"><label for="f-mk">Meta keywords</label><input type="text" id="f-mk" name="meta_keywords" value="{{ $v('meta_keywords') }}" maxlength="300" placeholder="antiques, precious metals, assaying"></div>
        </div>
    </section>

    <section class="adm-card adm-tint-grey">
        <h2>Google</h2>
        <div class="adm-grid">
            <div class="adm-field"><label for="f-gmq">Map location</label><input type="text" id="f-gmq" name="google_map_query" value="{{ $v('google_map_query') }}" maxlength="200" placeholder="Karur District, Tamil Nadu, India"><small>Place or address searched on Google Maps. Leave empty to hide the map on the Contact page.</small></div>
            <div class="adm-field"><label for="f-gml">Map heading</label><input type="text" id="f-gml" name="google_map_label" value="{{ $v('google_map_label') }}" maxlength="120" placeholder="Karur District, Tamil Nadu"><small>Shown above the map. Put a comma to split the heading in two lines.</small></div>
            <div class="adm-field adm-w-sm"><label for="f-gaid">Analytics ID</label><input type="text" id="f-gaid" name="google_analytics_id" value="{{ $v('google_analytics_id') }}" maxlength="30" placeholder="G-XXXXXXXXXX" autocomplete="off" spellcheck="false"><small>Google Analytics 4 measurement ID. Empty = no tracking.</small></div>
            <div class="adm-field"><label for="f-gsv">Search Console verification code</label><input type="text" id="f-gsv" name="google_site_verification" value="{{ $v('google_site_verification') }}" maxlength="100" placeholder="content value of the google-site-verification tag" autocomplete="off" spellcheck="false"><small>Only the code, not the whole meta tag.</small></div>
        </div>
    </section>

    <section class="adm-card adm-tint-pink">
        <h2>Social media links</h2>
        <div class="adm-grid">
            @foreach (['facebook' => 'Facebook', 'instagram' => 'Instagram', 'x' => 'X (Twitter)', 'linkedin' => 'LinkedIn', 'youtube' => 'YouTube'] as $k => $label)
                <div class="adm-field"><label for="f-{{ $k }}">{{ $label }}</label><input type="url" id="f-{{ $k }}" name="{{ $k }}" value="{{ $v($k) }}" maxlength="300" placeholder="https://"></div>
            @endforeach
        </div>
    </section>

    <section class="adm-card">
        <h2>Brand images</h2>
        <div class="adm-grid">
            @include('admin._image', ['name' => 'logo', 'label' => 'Logo', 'current' => $s['logo'] ?? null])
            @include('admin._image', ['name' => 'favicon', 'label' => 'Favicon', 'current' => $s['favicon'] ?? null])
        </div>
    </section>

    <div class="adm-savebar"><button class="adm-btn" type="button" data-reset>Reset</button><button class="adm-btn adm-btn--primary" type="submit">Save changes</button></div>
</form>
@endsection
