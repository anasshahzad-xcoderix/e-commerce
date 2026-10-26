@extends('layouts.app')
@section('title', $title)

@section('content')
    @include('sections.' . $section)
@endsection