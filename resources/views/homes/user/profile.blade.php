@extends('layouts.app')
@section('javascript')
    {{--<script src={{ asset('/js/users/profile.js') }}></script>--}}
    {{--<script src={{ asset('/js/helpers/FormValidator.js') }}></script>--}}
@endsection
@section('css')

@endsection
@section('content')
    <div class="col-md-10 col-md-offset-1">
        <section class="panel">
            <header class="panel-heading tab-bg-info">
                <ul class="nav nav-tabs">
                    <li class="{{ count($errors->all()) === 0 ? 'active' : ''}}">
                        <a data-toggle="tab" href="#profile">
                            <i class="icon-user"></i>
                            {{ trans('layout.information') }}
                        </a>
                    </li>
                    <li class="{{ count($errors->all()) > 0 && session('tabStatus') === config('common.user.task_bar_status.update_profile') ? 'active' : ''}}">
                        <a data-toggle="tab" href="#edit-profile">
                            <i class="icon-envelope"></i>
                            {{ trans('layout.update_profile') }}
                        </a>
                    </li>
                    <li class="{{ count($errors->all()) > 0 && session('tabStatus') === config('common.user.task_bar_status.change_password') ? 'active' : ''}}">
                        <a data-toggle="tab" href="#change-password">
                            <i class="icon-envelope"></i>
                            {{ trans('layout.reset_password') }}
                        </a>
                    </li>
                </ul>
            </header>
            <div class="panel-body">
                <div class="tab-content">
                    <!-- profile -->
                    <div id="profile" class="col-md-12 tab-pane {{ count($errors->all()) === 0 ? 'active' : ''}}">
                        <div class="panel">
                            <div class="col-md-12"><br/></div>
                            <div class="col-md-4">
                                <img src= {{ asset( Auth::user()->avatar ) }} width="100%" />
                            </div>
                            <div class="col-md-7 col-md-offset-1 panel-body bio-graph-info">
                                <h1 style="color:#000066">{{  Auth::user()->name }}</h1>
                                <div class="row">
                                    <div class="bio-row">
                                        <p><span>{{ trans('layout.email') }} </span>: {{ Auth::user()->email }} </p>
                                    </div>
                                    <div class="bio-row">
                                        <p><span>{{ trans('layout.about_me') }}: </span> {{ Auth::user()->description }} </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <section>
                            <div class="row">
                            </div>
                        </section>
                    </div>
                    <!-- edit-profile -->
                    <div id="edit-profile" class="tab-pane col-md-11 col-md-offset-1 {{ count($errors->all()) > 0 && session('tabStatus') === config('common.user.task_bar_status.update_profile') ? 'active' : ''}}">
                        <div class="panel">
                            <div class="row">
                                <div class="col-md-10 col-md-offset-1">
                                    <div class="panel panel-default">
                                        <div class="panel-heading"></div>
                                        <div class="panel-body">
                                            <form enctype="multipart/form-data" class="form-horizontal" role="form" method="POST" action="{{ action('Home\UserController@update', ['user' => 'update']) }}">
                                                {!! csrf_field() !!}
                                                {!! method_field('PATCH') !!}
                                                <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                                                    <label for="name" class="col-md-4 control-label">{{ trans('layout.name') }}</label>

                                                    <div class="col-md-6">
                                                        <input id="name" type="text" class="form-control" placeholder="{{ trans('layout.enter_your_name') }}" name="name" value="{{ $errors->has('name') ? old('name') : Auth::user()->name }}" autofocus>

                                                        @if ($errors->has('name'))
                                                            <span class="help-block">
                                                                <strong>{{ $errors->first('name') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="email" class="col-md-4 control-label">{{ trans('layout.email_address') }}</label>

                                                    <div class="col-md-6">
                                                        <input id="email" type="email" class="form-control" name="email" value="{{ Auth::user()->email }}" disabled>
                                                    </div>
                                                </div>

                                                <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                                    <label for="description" class="col-md-4 control-label">{{ trans('layout.about_you') }}:</label>

                                                    <div class="col-md-6">
                                                        <textarea id="description" class="form-control" name="description" placeholder="{{ trans('layout.about_yourself') }}">{{ $errors->has('description') ? old('description') : Auth::user()->description }}</textarea>
                                                        @if ($errors->has('description'))
                                                            <span class="help-block">
                                                                <strong>{{ $errors->first('description') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="form-group{{ $errors->has('avatar') ? ' has-error' : '' }}">
                                                    <label for="description" class="col-md-4 control-label">{{ trans('layout.upload_avatar') }}:</label>

                                                    <div class="col-md-10 col-md-offset-1">
                                                        <div id="previewField" class="col-md-6 col-md-offset-4 col-md-offset-right-2 hidden">
                                                            <img id="profilePreview" src="#" alt="Profile image"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-md-offset-right-4 col-md-offset-4">
                                                        <br/>
                                                        <input type="file" id = "avatar" name="avatar" accept="image/*">
                                                        @if ($errors->has('avatar'))
                                                            <span class="help-block">
                                                                <strong>{{ $errors->first('avatar') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="col-md-2 col-md-offset-4">
                                                        <input type="button" value="{{ trans('layout.cancel') }}" class="btn btn-danger" onclick="window.location.reload();">
                                                    </div>
                                                    <div class="col-md-2 col-md-offset-right-4">
                                                        <button name ="updateProfile" type="submit" class="btn btn-primary">
                                                            {{ trans('layout.update') }}
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Change password -->
                    <div id="change-password" class="tab-pane col-md-8 col-md-offset-2 col-md-offset-right-2 {{ count($errors->all()) > 0 && session('tabStatus') === config('common.user.task_bar_status.change_password') ? 'active' : ''}}">
                        <div class="panel">
                            <div class="row">
                                <div class="panel panel-default">
                                    <div class="panel-heading"></div>
                                    <div class="panel-body">
                                        <form enctype="multipart/form-data" class="form-horizontal" role="form" method="POST" action="{{ action('Home\UserController@update', ['user' => 'update']) }}">
                                            {!! csrf_field() !!}
                                            {!! method_field('PATCH') !!}
                                            <div class="form-group{{ $errors->has('currentPassword') ? ' has-error' : '' }}">
                                                <label for="currentPassword" class="col-md-4 control-label">{{ trans('layout.current_password') }}</label>

                                                <div class="col-md-6">
                                                    <input id="currentPassword" type="password" class="form-control" name="currentPassword" autofocus required>

                                                    @if ($errors->has('currentPassword'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('currentPassword') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group{{ $errors->has('newPassword') ? ' has-error' : '' }}">
                                                <label for="newPassword" class="col-md-4 control-label">{{ trans('layout.new_password') }}</label>

                                                <div class="col-md-6">
                                                    <input id="newPassword" type="password" class="form-control" name="newPassword" required>

                                                    @if ($errors->has('newPassword'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('newPassword') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group{{ $errors->has('confirmPassword') ? ' has-error' : '' }}">
                                                <label for="currentPassword" class="col-md-4 control-label">{{ trans('layout.confirm_password') }}</label>

                                                <div class="col-md-6">
                                                    <input id="newPassword" type="password" class="form-control" name="confirmPassword" required>

                                                    @if ($errors->has('confirmPassword'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('confirmPassword') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-md-2 col-md-offset-4">
                                                    <input type="button" value="{{ trans('layout.cancel') }}" class="btn btn-danger" onclick="window.location.reload();">
                                                </div>
                                                <div class="col-md-2 col-md-offset-right-4">
                                                    <button name ="changePassword" type="submit" class="btn btn-primary">
                                                        {{ trans('layout.update') }}
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End of Change password -->
                </div>
            </div>
        </section>
    </div>
    <script>

    </script>
@endsection
