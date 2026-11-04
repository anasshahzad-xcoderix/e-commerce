@extends('layouts.dashboard')
@section('title', 'New category')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/products.css') }}">
@endpush

@section('content')
<div class="admin-wrap">
    <div class="page-head">
        <h1>New category</h1>
        <p>ADD CATEGORY</p>
    </div>

    @include('admin.categories._form', [
        'action' => route('admin.categories.store'),
        'submit' => 'Save',
    ])
</div>
@endsection