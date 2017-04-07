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
    @include('layouts.appStyle')
    @yield('css')

</head>
<body>
<div id="app" data-asset-url="{{ asset('') }}">
    <!-- Top Nav bar -->
    @include('layouts.topNav')

    <!-- Alert Message -->
    @include('layouts.alertMessage')

    <!-- Content -->
    <div class="pageContent">
        @yield('content')
    </div>

</div>

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
        ]); ?>
    </script>

    <!-- App script -->
    @include('layouts.appScript')

    @yield('javascript')

</body>
</html>
