<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @php
        $appName = config('app.name', 'Project');
        // $settingAppName = "@getSettings()->application_name";
        $settingAppName = "";
        if($settingAppName != ''){
            $appName = $settingAppName;
        }
    @endphp
    <title>{{ $settingAppName }} - @yield('title')</title>
    <!-- plugins:css -->
    {!! Html::style('assets/backend/vendors/mdi/css/materialdesignicons.min.css') !!}
    {!! Html::style('assets/backend/vendors/css/vendor.bundle.base.css') !!}
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    {!! Html::style('assets/backend/css/style.css') !!}
    {!! Html::style('assets/backend/css/custom.css') !!}
    <!-- End layout styles -->
    {{-- @if(@getSettings()->favicon != '')
        <link rel="shortcut icon" href="{{ @get_file(@getSettings()->favicon,'original') }}" />
    @else --}}
        <link rel="shortcut icon" href="{{ URL::to('/') }}/images/favicon.png" />
    {{-- @endif --}}
</head>
<body>
<div class="container-scroller">
    @yield('content')
</div>
<!-- container-scroller -->
<!-- plugins:js -->
{!! Html::script('assets/backend/vendors/js/vendor.bundle.base.js') !!}
<!-- endinject -->
</body>
</html>
