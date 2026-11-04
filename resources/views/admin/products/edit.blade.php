@extends('layouts.dashboard')
@section('title', 'Edit product')

@section('content')
<div class="admin-wrap">
    <div class="admin-head">
        <div>
            <h1>Edit product</h1>
            <p>EDIT PRODUCT</p>
        </div>
    </div>

    @include('admin.products._form', [
        'action' => route('admin.products.update', $product),
        'method' => 'PUT',
        'submit' => 'Update',
    ])
</div>
@endsection