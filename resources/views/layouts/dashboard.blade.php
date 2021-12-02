<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>@yield('title') - {{ config('app.name') }}</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- style --}}
    @include('layouts._dashboard.style')

    @stack('custom-css')
</head>

<body>
    <div id="page-loader" class="fade in"><span class="spinner"></span></div>
    <div id="page-container" class="fade page-sidebar-fixed page-header-fixed">
        {{-- header --}}
        @include('layouts._dashboard.header')
        {{-- sidebar --}}
        @include('layouts._dashboard.sidebar')

        {{-- content --}}
        @yield('content')

        <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade"
            data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
    </div>
    {{-- script --}}
    @include('layouts._dashboard.script')
    @include('sweetalert::alert')
</body>

</html>
