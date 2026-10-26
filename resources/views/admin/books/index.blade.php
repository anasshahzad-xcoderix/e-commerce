@extends('layouts.dashboard')
@section('title', 'Books')
@section('page-title', 'Books')
@section('page-sub', 'Books ki list')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/books.css') }}">
@endpush

@section('content')
<div class="book-wrap">

    <div class="book-head">
        <a href="{{ route('admin.books.create') }}" class="btn-primary">+ New book</a>
    </div>

    @if(session('success'))
        <div class="alert-ok">{{ session('success') }}</div>
    @endif

    <table class="book-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Publish date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($books as $book)
                <tr>
                    <td>{{ $book->name }}</td>
                    <td>{{ \Illuminate\Support\Str::limit($book->description, 60) }}</td>
                    <td>{{ $book->published_at?->format('d M Y') ?? '-' }}</td>
                    <td class="actions">
                        <a href="{{ route('admin.books.edit', $book) }}" class="btn-edit">Edit</a>
                        <form method="POST" action="{{ route('admin.books.destroy', $book) }}" data-confirm="Is book ko delete karein?">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete">Delete</button>
                            <td>
    @if($book->image)
        <img src="{{ asset('storage/' . $book->image) }}" alt="" style="width:48px;height:48px;object-fit:cover;border-radius:8px;">
    @else
        -
    @endif
</td>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4">no book right now.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="book-pagination">{{ $books->links() }}</div>

</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/books.js') }}"></script>
@endpush



