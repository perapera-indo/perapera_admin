@extends('layouts.master')
@php
    $title = @$data ? 'Edit' : 'Add New';
@endphp
@section('title', 'User '.$title)
@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{ $title }} User</h4>
                    <br>
                    <form class="forms-sample"
                          action="{{ @$data ? route('user.update', $data->user_id) : route('user.store') }}"
                          method="POST" enctype="multipart/form-data">
                        @csrf
                        @if(@$data)
                            <input type="hidden" name="_method" value="put">
                        @endif
                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <input type="text" class="form-control {{ hasErrorField($errors,'first_name') }}"
                                   id="first_name" name="first_name" value="{{ old('first_name',@$data->first_name) }}"
                                   placeholder="First Name">
                            {!! $errors->first('first_name', '<label class="help-block error-validation">:message</label>') !!}
                        </div>
                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input type="text" class="form-control {{ hasErrorField($errors,'last_name') }}"
                                   id="last_name" name="last_name" value="{{ old('last_name',@$data->last_name) }}"
                                   placeholder="Last Name">
                            {!! $errors->first('last_name', '<label class="help-block error-validation">:message</label>') !!}
                        </div>
                        <div class="form-group">
                            <label for="email">Email address</label>
                            <input type="email" class="form-control {{ hasErrorField($errors,'email') }}"
                                   id="email" name="email" value="{{ old('email',@$data->email) }}" placeholder="Email">
                            {!! $errors->first('email', '<label class="help-block error-validation">:message</label>') !!}
                        </div>
                        <div class="form-group">
                            <label>Role </label>
                                <select name="role" class="form-control select2 {{ hasErrorField($errors,'role') }}" id="role">
                                    <option value="">Choose</option>
                                    @foreach($roles as $j => $role)
                                        @php
                                            $selected = '';
                                            if($role->slug == old('role')){
                                                $selected = 'selected';
                                            } else if(@$data->role_slug == $role->slug){
                                                $selected = 'selected';
                                            }

                                        @endphp
                                        <option value="{{ $role->slug }}" {{ $selected }}>{{ ucwords($role->name) }}</option>
                                    @endforeach
                                </select>
                            {!! $errors->first('role', '<label class="help-block error-validation" id="msg_role">:message</label>') !!}
                        </div>

                        {{--<div class="form-group">--}}
                            {{--<label>File upload</label>--}}
                            {{--<input type="file" name="user_image" class="file-upload-default">--}}
                            {{--<div class="input-group col-xs-12">--}}
                                {{--<input type="text" class="form-control {{ hasErrorField($errors,'image') }} file-upload-info" disabled placeholder="Upload Image">--}}
                                {{--<span class="input-group-append">--}}
                                    {{--<button class="file-upload-browse btn btn-outline-info btn-icon-text" type="button">Upload</button>--}}
                                {{--</span>--}}
                            {{--</div>--}}
                            {{--{!! $errors->first('image', '<label class="help-block error-validation">:message</label>') !!}--}}
                        {{--</div>--}}

                        <div class="form-group">
                            <div class="input-group col-xs-12">
                                <label for="exampleInputFile">Upload Image</label>
                                <input type="file" class="form-control {{ hasErrorField($errors,'user_image') }} dropify" data-errors-position="outside" name="user_image" data-default-file="{{ @get_file(@$data->user_image) }}"
                                       data-height="200" data-max-file-size="2M" data-allowed-file-extensions="jpg jpeg png gif">
                            </div>
                            {!! $errors->first('user_image', '<label class="help-block error-validation">:message</label>') !!}
                        </div>

                        <button type="submit" class="btn btn-info btn-fw btn-lg mr-2">Submit</button>
                        <a href="{{ route('user.index') }}" class="btn btn-secondary btn-fw btn-lg">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('#password_check').click(function(){
               let $this = $(this);

               if($this.hasClass('checked')){
                   $this.removeClass('checked');
                   $('#manual_password').addClass('hidden');
               }else{
                   $this.addClass('checked');
                   $('#manual_password').removeClass('hidden');
               }
            });
        });
    </script>
@endsection
