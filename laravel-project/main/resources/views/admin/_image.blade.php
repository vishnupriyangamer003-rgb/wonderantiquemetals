{{-- Image upload with live preview. Vars: $name, $label, $current (path|null), $required (bool) --}}
<div class="adm-field adm-upload" data-upload data-max-kb="2048">
    <label for="f-{{ $name }}">{{ $label }}@if (!empty($required)) <span class="req">*</span>@endif</label>
    <div class="adm-upload__box">
        <img class="adm-upload__preview" data-preview src="{{ $current ? asset($current) : '' }}" alt="" @if (! $current) hidden @endif>
        <div class="adm-upload__empty" data-empty @if ($current) hidden @endif>
            @include('admin._icon', ['name' => 'image'])
            <span>No image selected</span>
        </div>
        <div class="adm-upload__controls">
            <input type="file" id="f-{{ $name }}" name="{{ $name }}" accept="image/jpeg,image/png,image/webp" data-input>
            <small>JPG, PNG or WEBP · max 2 MB · up to 6000 px</small>
            <p class="adm-upload__error" data-error role="alert" hidden></p>
        </div>
    </div>
</div>
