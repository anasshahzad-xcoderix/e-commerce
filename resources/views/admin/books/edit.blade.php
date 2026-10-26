@extends('layouts.dashboard')
@section('title', 'Edit book')
@section('page-title', 'Edit book')
@section('page-sub', $book->name)

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/books.css') }}">
@endpush

@section('content')
<div class="book-wrap">
    @include('admin.books._form', [
        'action' => route('admin.books.update', $book),
        'method' => 'PUT',
        'submit' => 'Update',
    ])
</div>
@endsection