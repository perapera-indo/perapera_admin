@extends('layouts.master')
@php
    $title = @$data ? 'Edit' : 'Create';
@endphp
@section('title', 'User '.$title)
@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Change Password</h4>
                        <br>
                        <form class="forms-sample"
                              action="{{ route('account.post_change_password')}}"
                              method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="_method" value="put">
                            <div class="form-group">
                                <label for="old_password">Old Password</label>
                                <input type="password" class="form-control {{ hasErrorField($errors,'old_password') }}"
                                       id="password" name="old_password" value="{{ old('old_password') }}" placeholder="Old Password">
                                {!! $errors->first('old_password', '<label class="help-block error-validation">:message</label>') !!}
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control {{ hasErrorField($errors,'password') }}"
                                       id="password" name="password" value="{{ old('password') }}" placeholder="Password">
                                {!! $errors->first('password', '<label class="help-block error-validation">:message</label>') !!}
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation">Password Confirmation</label>
                                <input type="password" class="form-control {{ hasErrorField($errors,'password') }}"
                                       id="password_confirmation" value="{{ old('password_confirmation') }}"
                                       name="password_confirmation" placeholder="Password Confirmation">
                                {!! $errors->first('password_confirmation', '<label class="help-block error-validation">:message</label>') !!}
                            </div>
                            <button type="submit" class="btn btn-info btn-fw btn-lg mr-2">Submit</button>
                            <a href="{{ route('dashboard') }}" class="btn btn-secondary btn-fw btn-lg">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
