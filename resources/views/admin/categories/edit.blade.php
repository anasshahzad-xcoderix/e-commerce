@extends('layouts.dashboard')
@section('title', 'Edit collection')
@section('page-title', 'Edit collection')
@section('page-sub', $category->name)

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/categories.css') }}">
@endpush

@section('content')
<div class="cat-wrap">
    <form method="POST" action="{{ route('admin.categories.update', $category) }}" class="cat-form">
        @method('PUT')
        @include('admin.categories._form', ['submit' => 'Update'])
    </form>
</div>
@endsection