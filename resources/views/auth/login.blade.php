@extends('layouts.master_blank')
@section('title', 'Login')

@section('content')
    <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth">
            <div class="row flex-grow">
                <div class="col-lg-4 mx-auto">
                    <div class="auth-form-light text-left p-5">
                        <div class="brand-logo">
                            @if(@getSettings()->logo != '')
                                <img src="{{ @get_file(getSettings()->logo,'original') }}" class="css-class" style="width:16vw">
                            @else
                                {{ Html::image('images/logo-perapera-blue.jpg', 'logo', array('class' => 'css-class','style' => 'width:23vw')) }}
                            @endif
                        </div>
                        {{-- <h4>Hello! let's get started</h4>
                        <h6 class="font-weight-light">Sign in to continue.</h6> --}}
                        <form class="pt-3" method="post" action="{{ route('postLogin') }}">
                            @csrf
                            {{ csrf_field() }}
                            <div class="form-group">
                                <input type="email" name="email" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Username">
                                @error('email')
                                    <p class="text-danger text-center">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" class="form-control form-control-lg" id="exampleInputPassword1" placeholder="Password">
                                @error('password')
                                    <p class="text-danger text-center">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mt-3">
                                <button type="submit" class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn">SIGN IN</button>
                            </div>
                            <div class="my-2 d-flex justify-content-between align-items-center">
                                <div class="form-check">
                                    <label class="form-check-label text-muted">
                                        <input type="checkbox" name="remember" id="remember" class="form-check-input" {{ old('remember') ? 'checked' : '' }}>
                                        Keep me signed in
                                        <i class="input-helper"></i>
                                    </label>
                                </div>
                                @if (Route::has('password.request'))
                                    <a class="auth-link text-black" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                            {{--<div class="mb-2">--}}
                                {{--<button type="button" class="btn btn-block btn-facebook auth-form-btn">--}}
                                    {{--<i class="mdi mdi-facebook mr-2"></i>Connect using facebook </button>--}}
                            {{--</div>--}}
                            @if(@getSettings()->allow_public_register)
                                <div class="text-center mt-4 font-weight-light"> Don't have an account? <a href="{{ route('register') }}" class="text-primary">Create</a>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
    </div>
@endsection
