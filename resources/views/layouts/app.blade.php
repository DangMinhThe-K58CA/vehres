<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Vehicle Rescuer') }}</title>
    <!-- Styles -->
{{--<link href= {{ asset("/css/app.css") }} rel="stylesheet">--}}

<!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
        ]); ?>
    </script>
{{--    <script src={{asset("/bowers/jquery/jquery.min.js")}}></script>--}}
{{--    <script src={{asset("/bowers/bootstrap/js/bootstrap.min.js")}}></script>--}}
{{--    <script src={{asset("/bowers/jquery-validation/jquery.validate.min.js")}}></script>--}}
{{--    <script src={{asset("/bowers/select2/js/select2.full.min.js")}}></script>--}}
{{--    <script src={{asset("/js/helpers/CookieHelper.js")}}></script>--}}
    <script src={{asset("/js/app.js")}}></script>
    <link href= {{ asset("/css/app.css") }} rel="stylesheet">
{{--    <link href= {{ asset("/bowers/bootstrap/css/bootstrap.min.css") }} rel="stylesheet">--}}
{{--    <link href= {{ asset("/bowers/select2/css/select2.min.css") }} rel="stylesheet">--}}
    {{--<link href= {{ asset("/bowers/select2/css/select2.css") }} rel="stylesheet">--}}
    <link href= {{ asset("/bowers/font-awesome/css/font-awesome.min.css") }} rel="stylesheet">
{{--    <link href= {{ asset("/css/plugins/smart-admin.css") }} rel="stylesheet">--}}
    @yield('css')
    @yield('javascript')
</head>
<body>
<div id="app">
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">
                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Vehicle Rescuer') }}
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    &nbsp;
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">{{ trans('layout.login') }}</a></li>
                        <li><a href="{{ url('/register') }}">{{ trans('layout.register') }}</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                <img class="img-circle" alt="{{ asset(Auth::user()->avatar) }}" width="35" height="35" src={{ asset("/uploads/images/users/avatar/" . Auth::user()->avatar) }} >
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    @if(Gate::allows('is-admin'))
                                        <a href="{{ url('/admin') }}">
                                            <i class="fa fa-bus" style="font-size:20px;color:#0a568c"></i>
                                            {{ trans('layout.administration') }}
                                        </a>
                                    @elseif(Gate::allows('is-partner'))
                                        <a href="{{ url('/partner') }}">
                                            <i class="fa fa-handshake-o" style="font-size:20px;color:#0a568c"></i>
                                            {{ trans('layout.partner') }}
                                        </a>
                                    @endif
                                </li>
                                <li>
                                    <a href="{{ url('/home/myWorld') }}">
                                        <i class="fa fa-globe" style="font-size:20px;color:#0a568c" aria-hidden="true"></i>
                                        {{ trans('layout.myWorld') }}
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('/home/user') }}">
                                        <i class="fa fa-user-circle-o" style="font-size:20px;color:#0a568c"></i>
                                        {{ trans('layout.profile') }}
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('/logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <i class="fa fa-sign-out" style="font-size:20px;color:#0a568c"></i>
                                        {{ trans('layout.logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
    <nav>
        <div name="validation-errors" class="col-lg-6 col-lg-offset-3">
            @if (session('success'))
                <div class="form-horizontal">
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                </div>
            @endif
            @if (session('error'))
                <div class="form-horizontal">
                    <div class="alert alert-warning">
                        {{ session('error') }}
                    </div>
                </div>
            @endif
            @if (count($errors->all()) > 0)
                @foreach($errors->all() as $error)
                    <div class="alert alert-danger">
                        {{ $error }}
                    </div>
                @endforeach
            @endif
        </div>
    </nav>
    @yield('content')
</div>
</body>
</html>
