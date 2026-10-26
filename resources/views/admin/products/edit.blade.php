@extends('layouts.app')
@section('title', 'Product edit')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/products.css') }}">
@endpush

@section('content')
<div class="admin-wrap">
    <h1>Add Products</h1>
    @include('admin.products._form', [
        'action' => route('admin.products.update', $product),
        'method' => 'PUT',
    ])
    <p><a href="{{ route('admin.products.index') }}">← Back to List</a></p>
</div>
@endsection