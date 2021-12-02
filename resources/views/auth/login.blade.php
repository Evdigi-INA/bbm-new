@extends('layouts.auth')
@section('title')
    {{ __('Login') }}
@endsection
@section('content')
    	    <!-- begin login -->
            <div class="login login-v2" data-pageload-addclass="animated fadeIn">
                <!-- begin brand -->
                <div class="login-header">
                    <div class="brand">
                        <span class="logo"></span>@yield('title')
                        <small>Sign in to start your session</small>
                    </div>
                    <div class="icon">
                        <i class="fa fa-sign-in"></i>
                    </div>
                </div>
                <!-- end brand -->
                <div class="login-content">
                    <form  method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group m-b-20">
                            <input type="text" id="email" type="email"  class="form-control input-lg @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Email Address" required  autocomplete="email" autofocus />
                            @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                        <div class="form-group m-b-20">
                            <input id="password" type="password" class="form-control input-lg @error('password') is-invalid @enderror" name="password" placeholder="Password" required  autocomplete="current-password" />
                            @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                        <div class="login-buttons">
                            <button type="submit" class="btn btn-success btn-block btn-lg">Sign me in</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- end login -->
@endsection
