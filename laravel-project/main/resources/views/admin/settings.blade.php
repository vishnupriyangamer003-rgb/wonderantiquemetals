@extends('admin.layout')

@section('title', 'Company info')
@section('heading', 'Company information')
@section('sub', 'Contact details, browser title and social links shown across the website.')

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
            <div class="adm-field"><label for="f-email">Email</label><input type="text" id="f-email" name="email" value="{{ $v('email') }}" maxlength="300" placeholder="e.g. info@domain.com, contact@domain.com"><small>Separate multiple email addresses with a comma.</small></div>
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
        <h2>Browser title</h2>
        <div class="adm-grid">
            <div class="adm-field adm-span"><label for="f-mt">Meta title</label><input type="text" id="f-mt" name="meta_title" value="{{ $v('meta_title') }}" maxlength="200"><small>Shown in the browser tab on pages without their own title.</small></div>
        </div>
    </section>

    <section class="adm-card adm-tint-grey">
        <h2>Google</h2>
        <div class="adm-grid">
            <div class="adm-field adm-span"><label for="f-gme">Google Map embed code or link</label><textarea id="f-gme" name="google_map_embed" rows="4" maxlength="2000" spellcheck="false" placeholder="&lt;iframe src=&quot;https://www.google.com/maps/embed?pb=...&quot; ...&gt;&lt;/iframe&gt;">{{ $v('google_map_embed') }}</textarea><small>In Google Maps choose Share, then Embed a map, and paste the whole code (or just the link) here. Only the map address is kept. Leave empty to hide the map on the Contact page.</small></div>
            <div class="adm-field"><label for="f-gml">Map heading</label><input type="text" id="f-gml" name="google_map_label" value="{{ $v('google_map_label') }}" maxlength="120" placeholder="Karur District, Tamil Nadu"><small>Shown above the map. Put a comma to split the heading in two lines.</small></div>
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
