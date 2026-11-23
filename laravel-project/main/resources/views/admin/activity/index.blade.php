@extends('admin.layout')

@section('title', 'Activity log')
@section('heading', 'Activity log')
@section('sub', 'What admins did in this panel: sign-ins, content changes and settings, with the date and time.')

@section('content')
<div class="adm-card">
    @if ($items->isEmpty())
        <p class="adm-empty">No activity recorded yet.</p>
    @else
        <div class="adm-table-wrap">
            <table class="adm-table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Admin</th>
                        <th scope="col">Action</th>
                        <th scope="col">Details</th>
                        <th scope="col">Date</th>
                        <th scope="col">Time</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td>{{ $items->firstItem() + $loop->index }}</td>
                            <td class="adm-table__user">{{ $item->admin_name }}</td>
                            <td>{{ ucfirst($item->action) }}</td>
                            <td>{{ $item->description }}</td>
                            <td>{{ $item->created_at->format('d M Y') }}</td>
                            <td>{{ $item->created_at->format('h:i:s A') }} IST</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if ($items->hasPages())
            <nav class="adm-pager" aria-label="Activity log pages">
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
