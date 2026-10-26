@extends('layouts.app')

@section('title', 'Home')

@section('content')
    @include('sections.hero')
    @include('sections.features')
    @include('sections.categories')
    @include('sections.shop')
    @include('sections.daily-sale')
    @include('sections.benefits')
    @include('sections.makers')
    @include('sections.reviews')
    @include('sections.faq')
    @include('sections.newsletter')
@endsection 