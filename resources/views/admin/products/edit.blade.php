@extends('layouts.dashboard')
@section('title', 'Edit product')

@section('content')
    <div class="page-head">
        <h1>Edit product</h1>
        <p>EDIT PRODUCT</p>
    </div>

    @include('admin.products._form', [
        'action' => route('admin.products.update', $product),
        'method' => 'PUT',
        'submit' => 'Update',
    ])
@endsection