@extends('layouts.dashboard')
@section('title', 'New catrgory')
@section('page-title', 'New categoty')
@section('page-sub', 'Add Category')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/categories.css') }}">
@endpush

@section('content')
<div class="cat-wrap">
    @include('admin.categories._form', [
        'action' => route('admin.categories.store'),
        'submit' => 'Save',
    ])
</div>
@endsection