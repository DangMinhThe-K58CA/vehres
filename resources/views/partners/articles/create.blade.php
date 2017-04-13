@extends('partners.layouts.master')

@section('css')
    <link href= {{ asset("/css/homes/article/animate.min.css") }} rel="stylesheet">
    <link href= {{ asset("/css/homes/article/bootstrap.css") }} rel="stylesheet">
    <link href= {{ asset("/css/homes/article/chocolat.css") }} rel="stylesheet">
    <link href= {{ asset("/css/homes/article/component.css") }} rel="stylesheet">
    <link href= {{ asset("/css/homes/article/style.css") }} rel="stylesheet">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/3/w3.css">
@endsection

@section('javascript')
    <script src="{{asset('/templateEditor/ckeditor/ckeditor.js')}}"></script>
    <script src="{{asset('/templateEditor/ckeditor/adapters/jquery.js')}}"></script>
@endsection

@section('tag')
    <label>Write new article</label>
@stop
@section('content')
    <div class="technology">
        <div class="container">
            <div class="col-md-10 technology-left">
                <div class="modal-content">
                    <div class="agileinfo">
                        <div class="modal-header">
                            <a class="close closeModalBtn" title="Cancel">
                                <i class="fa fa-times" style="font-size:24px;color:#332ecb"></i>
                            </a>
                            @include('layouts.alertMessage')
                            <div class="col-md-8">
                                <h4 class="modal-title" id="showGarageLabel">Write article</h4>
                            </div>
                        </div>
                        <div class="modal-body">
                            {!! Form::open(['action' => ['Partner\ArticleController@store'], 'enctype' => 'multipart/form-data', 'method' => 'POST', 'id' => 'createArticleForm']) !!}
                            <div class="control-group {{ $errors->has('title') ? ' has-error' : '' }} {{ $errors->has('title') ? ' has-error' : '' }}">
                                {!! Form::label('title', 'Title') !!}
                                <div class="controls">
                                    {!! Form::text('title', null, ['placeholder' => 'article title', 'class' => 'form-control title', 'id' => 'title', 'required']) !!}
                                    @if ($errors->has('title'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('title') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="control-group">
                                {!! Form::label('type', 'Type') !!}
                                <div class="controls">
                                    {!! Form::select('type', [1 => 'news', 2 => 'tip'], 1, ['class' => 'form-control type', 'style' => 'width:10%']) !!}
                                </div>
                            </div>
                            <div class="control-group">
                                {!! Form::label('avatar', trans('admin.garages.avatar')) !!}
                                <div class="controls">
                                    <div id="previewAvatarField">
                                        {!! Html::image(null, null, ['class'=> 'hidden img-responsive avatar', 'width' => '100%', 'id' => 'previewAvatar']) !!}
                                    </div>
                                    <div class="controls {{ $errors->has('avatar') ? ' has-error' : '' }}">
                                        {!! Form::file('avatar', ['class'=> 'img-responsive', 'id' => 'changeAvatar', 'required']) !!}
                                        @if ($errors->has('avatar'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('avatar') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="control-group {{ $errors->has('short_description') ? ' has-error' : '' }} {{ $errors->has('short_description') ? ' has-error' : '' }}">
                                {!! Form::label('short_description', trans('admin.garages.short_description')) !!}
                                <div class="controls">
                                    {!! Form::text('short_description', null, ['placeholder' => 'Summary content', 'class' => 'form-control', 'required']) !!}
                                    @if ($errors->has('short_description'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('short_description') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="control-group {{ $errors->has('content') ? ' has-error' : '' }} {{ $errors->has('content') ? ' has-error' : '' }}">
                                {!! Form::label('content', 'Content') !!}
                                <div class="controls textAreaForEditorField">
                                    {!! Form::textarea('content', null, ['placeholder' => 'Content', 'class' => 'form-control', 'id' => 'contentEditor', 'required']) !!}
                                    @if ($errors->has('content'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('content') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary" id="creatingBtn">Update</button>
                                <button type="button" class="closeModalBtn btn btn-danger" data-dismiss="modal" id="close">Cancel</button>
                            </div>
                            {!! Form::close() !!}
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
@endsection
