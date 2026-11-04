@extends('layouts.dashboard')
@section('title', 'New product')

@section('content')
    <div class="page-head">
        <h1>New product</h1>
        <p>ADD PRODUCT</p>
    </div>

    @include('admin.products._form', [
        'action' => route('admin.products.store'),
        'submit' => 'Save',
    ])
@endsection