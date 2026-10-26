@extends('layouts.dashboard')
@section('title', 'Categories')
@section('page-title', 'Categories')
@section('page-sub', 'Categories list')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/categories.css') }}">
@endpush

@section('content')
<div class="cat-wrap">

    <div class="cat-head">
        <a href="{{ route('admin.categories.create') }}" class="btn-primary">+ New Categories
</a>
    </div>

    @if(session('success'))
        <div class="alert-ok">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert-err">{{ session('error') }}</div>
    @endif

    <table class="cat-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Slug</th>
                <th>Products</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $category)
                <tr>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->slug }}</td>
                    <td>{{ $category->products_count }}</td>
                    <td class="actions">
                        <a href="{{ route('admin.categories.edit', $category) }}" class="btn-edit">Edit</a>
                        <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" data-confirm="do you delete the products?">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4">no collection right now.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="cat-pagination">{{ $categories->links() }}</div>

</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/categories.js') }}"></script>
@endpush