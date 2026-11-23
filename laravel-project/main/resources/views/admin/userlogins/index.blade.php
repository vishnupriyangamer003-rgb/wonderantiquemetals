@extends('admin.layout')

@section('title', 'User logins')
@section('heading', 'User logins')
@section('sub', 'Registered website users, login credentials and sign-in history.')
@section('actions')
<form method="post" action="{{ route('admin.userlogins.reset') }}" data-confirm="Every website visitor will be signed out and must log in again." data-confirm-label="Yes, reset all">
    @csrf
    <button class="adm-btn adm-btn--primary" type="submit">Reset all sessions</button>
</form>
@endsection

@section('content')
<div class="adm-card">
    @if ($items->isEmpty())
        <p class="adm-empty">No user logins yet.</p>
    @else
        <div class="adm-table-wrap">
            <table class="adm-table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Email</th>
                        <th scope="col">Password</th>
                        <th scope="col">Date</th>
                        <th scope="col">Time</th>
                        <th scope="col" style="text-align:center;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td>{{ $items->firstItem() + $loop->index }}</td>
                            <td class="adm-table__user">{{ $item->username }}</td>
                            <td>{{ $item->phone ?: '—' }}</td>
                            <td>{{ $item->email ?: '—' }}</td>
                            <td>
                                @if (!empty($item->password))
                                    <div class="adm-pass-cell" data-pass-cell>
                                        <span class="adm-pass-dots" data-pass-dots>••••</span>
                                        <span class="adm-pass-plain" data-pass-plain hidden>{{ $item->password }}</span>
                                        <button type="button" class="adm-pass-eye" data-pass-cell-toggle title="Show password" aria-label="Show password" aria-pressed="false">
                                            <span data-eye-on>@include('admin._icon', ['name' => 'eye'])</span>
                                            <span data-eye-off hidden>@include('admin._icon', ['name' => 'eye-off'])</span>
                                        </button>
                                    </div>
                                @else
                                    <span class="adm-muted">—</span>
                                @endif
                            </td>
                            <td>{{ $item->login_at ? $item->login_at->format('d M Y') : ($item->created_at ? $item->created_at->format('d M Y') : '—') }}</td>
                            <td>{{ $item->login_at ? $item->login_at->format('h:i:s A') . ' IST' : '—' }}</td>
                            <td style="text-align:center;">
                                <div class="adm-actions" style="justify-content:center;margin:0;">
                                    <button type="button"
                                            class="adm-icon-btn"
                                            data-login-history
                                            data-name="{{ $item->username }}"
                                            data-phone="{{ $item->phone ?: '—' }}"
                                            data-email="{{ $item->email ?: '—' }}"
                                            data-password="{{ $item->password ?? '' }}"
                                            data-history='@json($item->history ?? [])'
                                            title="Login history"
                                            aria-label="Login history">
                                        @include('admin._icon', ['name' => 'clock'])
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if ($items->hasPages())
            <nav class="adm-pager" aria-label="User logins pages">
                @if ($items->onFirstPage())
                    <span class="adm-pager__link is-off">← Previous</span>
                @else
                    <a class="adm-pager__link" href="{{ $items->previousPageUrl() }}">← Previous</a>
                @endif
                <span class="adm-pager__info">Page {{ $items->currentPage() }} of {{ $items->lastPage() }}</span>
                @if ($items->hasMorePages())
                    <a class="adm-pager__link" href="{{ $items->nextPageUrl() }}">Next →</a>
                @else
                    <span class="adm-pager__link is-off">Next →</span>
                @endif
            </nav>
        @endif
    @endif
</div>
@endsection
