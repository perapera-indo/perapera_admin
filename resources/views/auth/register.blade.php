@extends('layouts.master_blank')
@section('title', 'Register')

@section('content')
    <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth">
            <div class="row flex-grow">
                <div class="col-lg-4 mx-auto">
                    <div class="auth-form-light text-left p-5">
                        <div class="brand-logo">
                            @if(@getSettings()->logo != '')
                                <img src="{{ get_file(@getSettings()->logo,'original') }}" class="css-class">
                            @else
                                {{ Html::image('images/logo.svg', 'logo', array('class' => 'css-class','style' => 'width:16vw')) }}
                            @endif
                        </div>
                        <h4>New here?</h4>
                        <h6 class="font-weight-light">Signing up is easy. It only takes a few steps</h6>
                        <form class="pt-3" method="POST" action="{{ route('register') }}">
                            <input type="hidden" name="from_register" value="true">
                            @csrf
                            <div class="form-group">
                                <input type="text" class="form-control form-control-lg" name="first_name" value="{{ old('first_name') }}" id="first_name" placeholder="First Name">
                                @error('first_name')
                                    <p class="text-danger text-center">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-lg" name="last_name" value="{{ old('last_name') }}" id="last_name" placeholder="Last Name">
                                @error('last_name')
                                    <p class="text-danger text-center">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control form-control-lg" id="email" name="email" value="{{ old('email') }}" placeholder="Email">
                                @error('email')
                                    <p class="text-danger text-center">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" class="form-control form-control-lg" id="password" placeholder="Password">
                                @error('password')
                                    <p class="text-danger text-center">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="password" name="password_confirmation" class="form-control form-control-lg" id="password_confirmation" placeholder="Password Confirmation">
                                @error('password_confirmation')
                                    <p class="text-danger text-center">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mt-3">
                                <button type="submit" class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn">SIGN UP</button>
                            </div>
                            <div class="text-center mt-4 font-weight-light"> Already have an account? <a href="{{ route('login') }}" class="text-primary">Login</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
    </div>
@endsection
