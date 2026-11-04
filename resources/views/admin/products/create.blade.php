@extends('layouts.dashboard')
@section('title', 'New product')

@section('content')
<div class="admin-wrap">
    <div class="admin-head">
        <div>
            <h1>New product</h1>
            <p>ADD PRODUCT</p>
        </div>
    </div>

    @include('admin.products._form', [
        'action' => route('admin.products.store'),
        'submit' => 'Save',
    ])
</div>
@endsection
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/products.css') }}">
@endpush