@extends('admin.layout')

@section('title', 'User logins')
@section('heading', 'User logins')
@section('sub', 'Every successful sign-in to the website, with the username and the date and time of the login.')
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
                        <th scope="col">Username</th>
                        <th scope="col">Date</th>
                        <th scope="col">Time</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td>{{ $items->firstItem() + $loop->index }}</td>
                            <td class="adm-table__user">{{ $item->username }}</td>
                            <td>{{ $item->login_at->format('d M Y') }}</td>
                            <td>{{ $item->login_at->format('h:i:s A') }}</td>
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
