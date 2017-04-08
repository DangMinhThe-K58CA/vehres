@extends('layouts.app')
@section('css')
<link href= {{ asset("/css/homes/index.css") }} rel="stylesheet">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/3/w3.css">
@endsection
@section('content')
    <div class="col-md-12">
        <div class="w3-sidebar w3-bar-block w3-card-2 w3-animate-left" style="display:none" id="mySidebar">
            <div id="mySidebarContent">
            </div>
        </div>

        <div id="main">
            <div class="container">
                <div class="iframe-container">
                    <div id="homeMap"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDMJ2EHO5n2HJ1Pwxi2hflbjIoxKXegIyc&callback=initMaps"></script>
@endsection
