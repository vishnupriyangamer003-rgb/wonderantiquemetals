{{-- Password input with show/hide eye. Vars: $name, $label, $value, $autocomplete, optional $class, optional $icon --}}
<div class="adm-field {{ $class ?? '' }}">
    <label for="f-{{ $name }}">{{ $label }}</label>
    <div class="adm-pass @if (!empty($icon)) adm-has-icon @endif" data-pass>
        @if (!empty($icon))<span class="adm-in-icon">@include('admin._icon', ['name' => $icon])</span>@endif
        <input type="password" id="f-{{ $name }}" name="{{ $name }}" value="{{ $value ?? '' }}" autocomplete="{{ $autocomplete ?? 'current-password' }}" maxlength="100" required>
        <button type="button" class="adm-pass__eye" data-pass-toggle aria-label="Show password" aria-pressed="false">
            <span data-eye-on>@include('admin._icon', ['name' => 'eye'])</span>
            <span data-eye-off hidden>@include('admin._icon', ['name' => 'eye-off'])</span>
        </button>
    </div>
</div>
