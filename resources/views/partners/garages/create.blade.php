@extends('partners.layouts.master')

@section('tag')
    <label>Create New Garage</label>
@stop

@section('content')
    <div id="showGarageField">
        <div class="modal-content">
            <div class="modal-header">
                {{--<button type="button" class="closeModalBtn close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>--}}
                <div class="col-md-4">
                    <h4 class="modal-title" id="showGarageLabel">Your garage information</h4>
                </div>
                <div class="col-md-8">
                    <div name="validation-errors">
                        @include('layouts.alertMessage')
                    </div>
                </div>
            </div>
            {!! Form::open(['action' => ['Partner\GarageController@store'], 'enctype' => 'multipart/form-data', 'method' => 'POST', 'id' => 'updateGarageForm']) !!}
            <div class="modal-body">
                <div id="newGarageField">
                    <div class="control-group {{ $errors->has('name') ? ' has-error' : '' }} {{ $errors->has('name') ? ' has-error' : '' }}">
                        {!! Form::label('name', trans('admin.garages.name')) !!}
                        <div class="controls">
                            {!! Form::text('name', null,['class' => 'form-control', 'id' => 'name', 'placeholder' => 'Garage name', 'required']) !!}
                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
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
                                 ]) !!}
                            </div>
                        </div>
                    </div>
                    <div class="control-group {{ $errors->has('avatar') ? ' has-error' : '' }}">
                        <div id="previewAvatarField">
                            {!! Html::image(null, null, ['class'=> 'hidden img-responsive avatar', 'id' => 'previewAvatar']) !!}
                        </div>
                        {!! Form::label('avatar', trans('admin.garages.avatar')) !!}
                        <div class="controls">
                            {!! Form::file('avatar', ['class'=> 'img-responsive', 'id' => 'changeAvatar', 'required']) !!}
                            @if ($errors->has('avatar'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('avatar') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="control-group" id="selectAdministrationUnit">
                        <div class="controls" id="choseProvince">
                            {!! Form::label('province', 'Chose province') !!}
                            <div class="controls">
                                {!! Form::select('province_id', $provinces) !!}
                            </div>
                        </div>
                        <div class="controls" id="choseDistrict">
                            {!! Form::label('province', 'Chose district') !!}
                            <div class="controls" id="districtsField">
                                {!! Form::select('district_id', $districts) !!}
                            </div>
                        </div>
                        <div class="controls" id="choseWard">
                            {!! Form::label('province', 'Chose ward') !!}
                            <div class="controls" id="wardsField">
                                {!! Form::select('ward_id', $wards) !!}
                            </div>
                        </div>
                    </div>
                    <div class="control-group {{ $errors->has('address') ? ' has-error' : '' }}">
                        {!! Form::label('address', trans('admin.garages.address')) !!}
                        <div class="controls">
                            {!! Form::text('address', null, ['class' => 'form-control', 'placeholder' => 'Garage address', 'required']) !!}
                            @if ($errors->has('address'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('address') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="control-group {{ $errors->has('phone_number') ? ' has-error' : '' }}">
                        {!! Form::label('phone_number', trans('admin.garages.phone_number')) !!}
                        <div class="controls">
                            {!! Form::text('phone_number', null, ['class' => 'form-control', 'placeholder' => '04xxxxxxxx', 'required']) !!}
                            @if ($errors->has('phone_number'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('phone_number') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="control-group {{ $errors->has('website') ? ' has-error' : '' }}">
                        {!! Form::label('website', trans('admin.garages.website')) !!}
                        <div class="controls">
                            {!! Form::text('website', null, ['class' => 'form-control', 'placeholder' => 'www.garagewebsite.com.vn', 'required']) !!}
                            @if ($errors->has('website'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('website') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="control-group {{ $errors->has('working_time') ? ' has-error' : '' }}">
                        {!! Form::label('working_time', trans('admin.garages.working_time')) !!}
                        <div class="controls">
                            {!! Form::text('working_time', null, ['class' => 'form-control', 'placeholder' => '7:45 AM - 17:45 PM', 'required']) !!}
                            @if ($errors->has('working_time'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('working_time') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="control-group {{ $errors->has('short_description') ? ' has-error' : '' }}">
                        {!! Form::label('short_description', trans('admin.garages.short_description')) !!}
                        <div class="controls">
                            {!! Form::text('short_description', null, ['class' => 'form-control', 'placeholder' => 'Say something', 'required']) !!}
                            @if ($errors->has('short_description'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('short_description') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="control-group {{ $errors->has('description') ? ' has-error' : '' }}">
                        {!! Form::label('description', trans('admin.garages.description')) !!}
                        <div class="controls">
                            {!! Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => 'About garage', 'required']) !!}
                            @if ($errors->has('description'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('description') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" id="addGarageBtn">Update</button>
                    <button type="button" class="closeModalBtn btn btn-danger" data-dismiss="modal" id="clear">Cancel</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
        <br/>
    </div>
@stop
