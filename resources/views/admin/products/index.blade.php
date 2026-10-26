@extends('layouts.dashboard')
@section('title', 'Products')
@section('page-title', 'Products')
@section('page-sub', 'List of Products')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/products.css') }}">
@endpush

@section('content')
<div class="admin-wrap">

    <div class="admin-head">
        <a href="{{ route('admin.products.create') }}" class="btn-primary">+ New Products</a>
    </div>

    @if(session('success'))
        <div class="alert-ok">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert-err">{{ session('error') }}</div>
    @endif

    <div class="table-scroll">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Collection</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr>
                        <td>
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="thumb">
                            @else
                                <x-icon name="{{ $product->art ?? 'mug' }}" class="thumb-icon" />
                            @endif
                        </td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category->name ?? '-' }}</td>
                        <td>Rs {{ number_format($product->price) }}</td>
                        <td>{{ $product->stock }}</td>
                        <td class="actions">
                            <a href="{{ route('admin.products.edit', $product) }}" class="btn-edit">Edit</a>
                            <form method="POST" action="{{ route('admin.products.destroy', $product) }}" data-confirm="Is products should be deleted?">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="empty">No products right now</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="admin-pagination">
        {{ $products->links() }}
    </div>

</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/products.js') }}"></script>
@endpush