@extends('layouts.app')
@section('title', 'New product')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/products.css') }}">
@endpush

@section('content')
<div class="admin-wrap">
    <h1>New product</h1>
    @include('admin.products._form', ['action' => route('admin.products.store')])
    <p><a href="{{ route('admin.products.index') }}">← Back to List</a></p>
</div>
@endsection