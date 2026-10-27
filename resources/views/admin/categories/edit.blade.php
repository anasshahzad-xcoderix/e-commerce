@extends('layouts.dashboard')
@section('title', 'Edit collection')
@section('page-title', 'Edit collection')
@section('page-sub', $category->name)

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/categories.css') }}">
@endpush

@section('content')
<div class="cat-wrap">
    @include('admin.categories._form', [
        'action' => route('admin.categories.update', $category),
        'method' => 'PUT',
        'submit' => 'Update',
    ])
</div>
@endsection