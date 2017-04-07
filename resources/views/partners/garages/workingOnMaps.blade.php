@extends('partners.layouts.master')

@section('tag')
    @if ($garage->status == config('common.garage.status.activated'))
        <a href="{{ action('Partner\GarageController@index', ['status' => config('common.garage.status.activated')]) }}">
            {{ trans('admin.garages.activated_garages') }}
        </a>
        <i class="fa fa-angle-right"></i>
    @else
        <a href="{{ action('Partner\GarageController@index', ['status' => config('common.garage.status.unactivated')]) }}">
            Unactivated Garages
        </a>
        <i class="fa fa-angle-right"></i>
    @endif
    <a href="{{ action('Partner\GarageController@show', ['id' => $garage->id]) }}">
        {{ $garage->name }}
    </a>
    <i class="fa fa-angle-right"></i>
    <label>Working on maps</label>
@endsection

@section('content')
    <div id="showGarageField">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="closeModalBtn close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <div class="col-md-4">
                    <h4 class="modal-title" id="showGarageLabel">Garage in maps</h4>
                </div>
            </div>

            <div id="main">
                <div class="container">
                    <div class="iframe-container">
                        <div id="partnerGarageMaps" data-asset-url="{{ asset('') }}" data-garage="{{ json_encode($garage) }}"></div>
                    </div>
                </div>
            </div>

        </div>
        <br/>
    </div>
@endsection

@section('javascript')
    <script src="{{ asset('js/partnerApp.js') }}"></script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDMJ2EHO5n2HJ1Pwxi2hflbjIoxKXegIyc&callback=window.partnerMaps.init"></script>
@endsection
