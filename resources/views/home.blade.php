@extends('layouts.app')

@section('title', 'Home')

@section('content')
    @include('sections.hero')
    @include('sections.features')
    @include('sections.best-sellers')
    @include('sections.categories')
    @include('sections.shop')
    @include('sections.delivery-promo')
    @include('sections.daily-sale')
    @include('sections.benefits')
    @include('sections.makers')
    @include('sections.reviews')
    @include('sections.image-story')
    @include('sections.faq')
    @include('sections.newsletter')
@endsection 