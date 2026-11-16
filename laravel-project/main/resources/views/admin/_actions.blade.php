{{-- Row actions. Vars: $key (banners|services|...), $item --}}
<div class="adm-actions">
    <a class="adm-icon-btn" href="{{ route('admin.'.$key.'.edit', $item->id) }}" title="Edit" aria-label="Edit">@include('admin._icon', ['name' => 'edit'])</a>
    <form method="post" action="{{ route('admin.'.$key.'.toggle', $item->id) }}">
        @csrf
        @method('PATCH')
        <button class="adm-icon-btn" type="submit" title="{{ $item->active ? 'Hide from website' : 'Show on website' }}" aria-label="{{ $item->active ? 'Hide' : 'Show' }}">@include('admin._icon', ['name' => $item->active ? 'eye' : 'eye-off'])</button>
    </form>
    <form method="post" action="{{ route('admin.'.$key.'.destroy', $item->id) }}" data-confirm="Delete this item permanently?">
        @csrf
        @method('DELETE')
        <button class="adm-icon-btn adm-icon-btn--danger" type="submit" title="Delete" aria-label="Delete">@include('admin._icon', ['name' => 'trash'])</button>
    </form>
</div>
