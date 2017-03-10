@extends('layouts.app')
@section('css')
<link href= {{ asset("/css/homes/index.css") }} rel="stylesheet">
@endsection
@section('content')
    <div class="container col-sm-10 col-sm-offset-1">
        <div class="iframe-container">
            <div id="homeMap"></div>
        </div>
    </div>
@endsection

@section('javascript')
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDMJ2EHO5n2HJ1Pwxi2hflbjIoxKXegIyc&callback=initMaps"></script>
@endsection
