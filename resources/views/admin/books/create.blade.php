@extends('layouts.dashboard')
@section('title', 'New book')
@section('page-title', 'New book')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/books.css') }}">
@endpush

@section('content')
<div class="book-wrap">
    @include('admin.books._form', [
        'action' => route('admin.books.store'),
        'submit' => 'Save',
    ])
</div>
@endsection
