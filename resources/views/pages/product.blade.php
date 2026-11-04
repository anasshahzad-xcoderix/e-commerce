@extends('layouts.app')
@section('title', $product->name)

@section('content')
    @include('sections.product-detail')
@endsection