@extends('layouts.app')
@section('javascript')
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('css/homes/myWorld.css') }}">
@endsection
@section('content')
    <div class="col-md-10 col-md-offset-1" id="myWorldField" align="center">
        <img src="{{ asset(config('common.error.404.image')) }}">
        <h1 class="errorMessage">{{ $exception->getMessage() }}</h1>
    </div>
@endsection
