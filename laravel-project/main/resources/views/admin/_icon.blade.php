<svg class="adm-icon" viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
@switch($name)
    @case('building')<path d="M4 21V5a1 1 0 0 1 1-1h9a1 1 0 0 1 1 1v16M15 9h4a1 1 0 0 1 1 1v11M3 21h18M8 8h3M8 12h3M8 16h3"/>@break
    @case('image')<rect x="3" y="4" width="18" height="16" rx="3"/><circle cx="9" cy="10" r="1.6"/><path d="m21 16-5-5-8 8"/>@break
    @case('grid')<rect x="4" y="4" width="7" height="7" rx="2"/><rect x="13" y="4" width="7" height="7" rx="2"/><rect x="4" y="13" width="7" height="7" rx="2"/><rect x="13" y="13" width="7" height="7" rx="2"/>@break
    @case('clipboard')<rect x="6" y="4" width="12" height="17" rx="2"/><path d="M9 4h6v3H9zM9 12h6M9 16h4"/>@break
    @case('quote')<path d="M5 17c0-4 1-7 4-9M13 17c0-4 1-7 4-9M5 17h4v-4H5zM13 17h4v-4h-4z"/>@break
    @case('user')<circle cx="12" cy="8" r="3.5"/><path d="M5 20c0-3.6 3-6 7-6s7 2.4 7 6"/>@break
    @case('currency')<circle cx="12" cy="12" r="9"/><path d="M15 9.5c-.6-1-1.6-1.5-3-1.5-1.7 0-3 .8-3 2s1.3 1.8 3 2 3 .8 3 2-1.3 2-3 2c-1.4 0-2.4-.5-3-1.5M12 6v2M12 16v2"/>@break
    @case('users')<circle cx="9" cy="8" r="3"/><path d="M3 20c0-3 2.7-5 6-5s6 2 6 5"/><circle cx="17" cy="9" r="2.5"/><path d="M17 14c2.5 0 4.5 1.6 4.5 4"/>@break
    @case('activity')<path d="M3 12h4l3-8 4 16 3-8h4"/>@break
    @case('clock')<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>@break
    @case('key')<circle cx="8" cy="15" r="4"/><path d="M11 12l9-9M16 7l3 3M14 9l2 2"/>@break
    @case('globe')<circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3c3 3 3 15 0 18M12 3c-3 3-3 15 0 18"/>@break
    @case('logout')<path d="M10 4H6a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h4M15 8l4 4-4 4M19 12H9"/>@break
    @case('lock')<rect x="5" y="11" width="14" height="10" rx="3"/><path d="M8 11V8a4 4 0 0 1 8 0v3M12 15v2"/>@break
    @case('menu')<path d="M4 7h16M4 12h16M4 17h16"/>@break
    @case('plus')<path d="M12 5v14M5 12h14"/>@break
    @case('edit')<path d="M4 20h4L19 9l-4-4L4 16zM13 7l4 4"/>@break
    @case('trash')<path d="M5 7h14M10 11v6M14 11v6M6 7l1 13h10l1-13M9 7V4h6v3"/>@break
    @case('eye')<path d="M2 12s4-7 10-7 10 7 10 7-4 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/>@break
    @case('eye-off')<path d="M3 3l18 18M10.6 6.2A9.8 9.8 0 0 1 12 6c6 0 10 6 10 6a17 17 0 0 1-3.2 3.7M6.5 7.6C3.6 9.5 2 12 2 12s4 7 10 7c1.5 0 2.9-.4 4.1-1M9.9 9.9a3 3 0 0 0 4.2 4.2"/>@break
@endswitch
</svg>
