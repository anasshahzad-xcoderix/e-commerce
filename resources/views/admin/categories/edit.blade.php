@extends('layouts.dashboard')
@section('title', 'Edit category')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/products.css') }}">
@endpush

@section('content')
<div class="admin-wrap">
    <div class="page-head">
        <h1>Edit category</h1>
        <p>EDIT CATEGORY</p>
    </div>

    @include('admin.categories._form', [
        'action' => route('admin.categories.update', $category),
        'method' => 'PUT',
        'submit' => 'Update',
    ])
</div>
@endsection