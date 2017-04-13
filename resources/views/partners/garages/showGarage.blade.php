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
    <label>{{ $garage->name }}</label>
@stop

@section('content')
<div id="showGarageField">
    <div class="modal-content">
        <div class="modal-header">
            {{--<button type="button" class="closeModalBtn close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>--}}
            @if($garage->status === 0)
                <a class="close" href="{{ action('Partner\GarageController@garageMaps', ['id' => $garage->id]) }}" title="open in maps">
                    <i class="fa fa-map-o" style="font-size:24px;color:#0a568c"></i>
                </a>
            @else
                <a class="closeModalBtn close" title="open in maps" href="{{ action('Home\GarageController@show', ['id' => $garage->id]) }}" target="_blank">
                    <i class="fa fa-map-o" style="font-size:24px;color:#0a568c"></i>
                </a>
            @endif
            <div class="col-md-4">
                <h4 class="modal-title" id="showGarageLabel">{{ trans('admin.garages.show_garage') }}</h4>
            </div>
            <div class="col-md-8">
                @include('layouts.alertMessage')
            </div>
        </div>
        {!! Form::open(['action' => ['Partner\GarageController@update', $garage->id], 'enctype' => 'multipart/form-data', 'method' => 'PUT', 'id' => 'updateGarageForm']) !!}
        <div class="modal-body">
            <div id="viewsGarageField">
                <div class="control-group">
                    {!! Form::label('name', trans('admin.garages.name')) !!}
                    <div class="controls">
                        {!! Form::text('name', $garage->name, ['class' => 'form-control name', 'id' => 'name', 'disabled']) !!}
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        {!! Form::label('type', 'Garage type') !!}
                        <div class="controls">
                            {!! Form::select('type', [
                                config('common.garage.type.car') => 'Car garage',
                                config('common.garage.type.motor') => 'Motor garage',
                                config('common.garage.type.bike') => 'Bike garage',
                             ], $garage->type, ['id' => 'garageType','disabled']) !!}
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    {!! Form::label('avatar', trans('admin.garages.avatar')) !!}
                    <div class="controls">
                        {!! Html::image($garage->avatar, null, ['class'=> 'img-responsive avatar', 'width' => '100%']) !!}
                    </div>
                </div>
                <div class="control-group" id="selectAdministrationUnit">
                    <div class="controls" id="choseProvince">
                        {!! Form::label('province', 'Province') !!}
                        <div class="controls">
                            {!! Form::select('province_id', $provinces, $garage->province_id, ['disabled']) !!}
                        </div>
                    </div>
                    <div class="controls" id="choseDistrict">
                        {!! Form::label('district', 'District') !!}
                        <div class="controls" id="districtsField">
                            @if($garage->district_id !== null)
                                {!! Form::select('district_id', $districts, $garage->district_id, ['disabled']) !!}
                            @else
                                <p>No data</p>
                            @endif
                        </div>
                    </div>
                    <div class="controls" id="choseWard">
                        {!! Form::label('ward', 'Ward') !!}
                        <div class="controls" id="wardsField">
                            @if($garage->ward_id !== null)
                            {!! Form::select('ward_id', $wards, $garage->ward_id, ['disabled']) !!}
                            @else
                                <p>No data</p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    {!! Form::label('address', trans('admin.garages.address')) !!}
                    <div class="controls">
                        {!! Form::text('address', $garage->address, ['class' => 'form-control', 'disabled']) !!}
                    </div>
                </div>
                <div class="control-group">
                    {!! Form::label('phone_number', trans('admin.garages.phone_number')) !!}
                    <div class="controls">
                        {!! Form::text('phone_number', $garage->phone_number, ['class' => 'form-control', 'disabled']) !!}
                    </div>
                </div>
                <div class="control-group">
                    {!! Form::label('website', trans('admin.garages.website')) !!}
                    <div class="controls">
                        {!! Form::text('website', $garage->website, ['class' => 'form-control', 'disabled']) !!}
                    </div>
                </div>
                <div class="control-group">
                    {!! Form::label('working_time', trans('admin.garages.working_time')) !!}
                    <div class="controls">
                        {!! Form::text('working_time', $garage->working_time, ['class' => 'form-control', 'disabled']) !!}
                    </div>
                </div>
                <div class="control-group">
                    {!! Form::label('short_description', trans('admin.garages.short_description')) !!}
                    <div class="controls">
                        {!! Form::text('short_description', $garage->short_description, ['class' => 'form-control', 'disabled']) !!}
                    </div>
                </div>
                <div class="control-group">
                    {!! Form::label('description', trans('admin.garages.description')) !!}
                    <div class="controls">
                        {!! Form::textarea('description', $garage->description, ['class' => 'form-control', 'disabled']) !!}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                @if($garage->status === 0)
                    <button class="btn btn-primary" id="enableEditBtn">Enable Edit</button>
                @else
                @endif
                <button type="button" class="closeModalBtn btn btn-danger" data-dismiss="modal" id="clear">Cancel</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
    <br/>
</div>
@stop
