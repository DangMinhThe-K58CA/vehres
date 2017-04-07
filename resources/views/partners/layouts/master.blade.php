<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Style -->
    @include('partners.layouts.navStyle')
</head>
<body>
    <div id="wrapper">
        <!-- Navbar top and left -->
        @include('partners.layouts.navTopBar')
        <!-- content -->
        <div id="page-wrapper" class="gray-bg dashbard-1">
            <div class="content-main">
                <!--banner-->
                <div class="banner">
                    <h2>
                    <a href="{{ route('partner') }}">Partner</a>
                    <i class="fa fa-angle-right"></i>
                    @yield('tag')
                    </h2>
                </div>
                <!--//banner-->
                <!-- content -->
                <div class="grid-form">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts-->
    @include('partners.layouts.navScript')

    @yield('javascript')

</body>
</html>

