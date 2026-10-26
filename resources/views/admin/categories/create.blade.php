@extends('layouts.dashboard')
@section('title', 'New collection')
@section('page-title', 'New collection')
@section('page-sub', 'Add category')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/categories.css') }}">
@endpush

@section('content')
<div class="cat-wrap">
    <form method="POST" action="{{ route('admin.categories.store') }}" class="cat-form">
        @include('admin.categories._form', ['submit' => 'Save'])
    </form>
</div>
@endsection 