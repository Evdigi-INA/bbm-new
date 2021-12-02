
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>{{ config('app.name') }} - @yield('title') </title>
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
	{{-- style --}}
    @include('layouts._auth.style')
</head>
<body class="pace-top">
	<div id="page-loader" class="fade in"><span class="spinner"></span></div>
	<div class="login-cover">
	    <div class="login-cover-image"><img src="{{ asset('vendor/assets/img/login-bg/bg-1.jpg') }}" data-id="login-cover-image" alt="" /></div>
	    <div class="login-cover-bg"></div>
	</div>
	<div id="page-container" class="fade">
        {{-- form login --}}
        @yield('content')
        {{-- login BG --}}
        @include('layouts._auth.loginBg')
	</div>
{{-- script --}}
@include('layouts._auth.script')
</body>
</html>
