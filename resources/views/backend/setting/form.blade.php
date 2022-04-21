@extends('layouts.master')
@section('title', 'Setting Edit')
@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Edit Setting</h4>
                    <br>
                    <form class="forms-sample"
                          action="{{ route('settings.update',['id' => $data->id]) }}"
                          method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="_method" value="put">
                        <div class="form-group">
                            <label for="application_name">Application Name</label>
                            <input type="text" class="form-control {{ hasErrorField($errors,'application_name') }}"
                                   id="application_name" name="application_name" value="{{ old('application_name',@$data->application_name) }}"
                                   placeholder="Name">
                            {!! $errors->first('application_name', '<label class="help-block error-validation">:message</label>') !!}
                        </div>

                        <div class="form-group">
                            <div class="input-group col-xs-12">
                                <label for="exampleInputFile">Upload Logo</label>
                                <input type="file" class="form-control {{ hasErrorField($errors,'logo') }} dropify" data-errors-position="outside" name="logo" data-default-file="{{ get_file($data->logo) }}"
                                       data-height="200" data-max-file-size="2M" data-allowed-file-extensions="jpg jpeg png gif">
                            </div>
                            {!! $errors->first('logo', '<label class="help-block error-validation">:message</label>') !!}
                        </div>

                        <div class="form-group">
                            <div class="input-group col-xs-12">
                                <label for="exampleInputFile">Upload Favicon</label>
                                <input type="file" class="form-control {{ hasErrorField($errors,'favicon') }} dropify" data-errors-position="outside" name="favicon" data-default-file="{{ get_file($data->favicon) }}"
                                       data-height="100" data-max-file-size="2M" data-allowed-file-extensions="jpg jpeg png gif">
                            </div>
                            {!! $errors->first('favicon', '<label class="help-block error-validation">:message</label>') !!}
                        </div>

                        {{--<div class="form-group">--}}
                            {{--<label>Upload Logo</label>--}}
                            {{--<input type="file" name="logo" class="file-upload-default">--}}
                            {{--<div class="input-group col-xs-12">--}}
                                {{--<input type="text" class="form-control {{ hasErrorField($errors,'logo') }} file-upload-info" disabled placeholder="Upload Logo">--}}
                                {{--<span class="input-group-append">--}}
                                    {{--<button class="file-upload-browse btn btn-outline-info btn-icon-text" type="button">Upload</button>--}}
                                {{--</span>--}}
                            {{--</div>--}}
                            {{--{!! $errors->first('logo', '<label class="help-block error-validation">:message</label>') !!}--}}
                        {{--</div>--}}
                        {{--<div class="form-group">--}}
                            {{--<label>Upload Favicon</label>--}}
                            {{--<input type="file" name="favicon" class="file-upload-default">--}}
                            {{--<div class="input-group col-xs-12">--}}
                                {{--<input type="text" class="form-control {{ hasErrorField($errors,'favicon') }} file-upload-info" disabled placeholder="Upload Favicon">--}}
                                {{--<span class="input-group-append">--}}
                                    {{--<button class="file-upload-browse btn btn-outline-info btn-icon-text" type="button">Upload</button>--}}
                                {{--</span>--}}
                            {{--</div>--}}
                            {{--{!! $errors->first('favicon', '<label class="help-block error-validation">:message</label>') !!}--}}
                        {{--</div>--}}

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Allow Public Register</label>
                            <div class="col-sm-4">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="allow_public_register"
                                               id="allow_public_register_1" value="true" {{ @$data->allow_public_register ? 'checked' : '' }}> True
                                        <i class="input-helper"></i>
                                    </label>
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="allow_public_register" id="allow_public_register_2"
                                               value="false" {{ @!$data->allow_public_register ? 'checked' : '' }}> False
                                        <i class="input-helper"></i>
                                    </label>
                                </div>
                            </div>
                            {!! $errors->first('allow_public_register', '<label class="help-block error-validation">:message</label>') !!}
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Allow Full Sidebar</label>
                            <div class="col-sm-4">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="allow_full_sidebar" id="allow_full_sidebar_1"
                                               value="true" {{ @$data->allow_full_sidebar ? 'checked' : '' }}> True
                                        <i class="input-helper"></i>
                                    </label>
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="allow_full_sidebar" id="allow_full_sidebar_2"
                                               value="false" {{ @!$data->allow_full_sidebar ? 'checked' : '' }}> False
                                        <i class="input-helper"></i>
                                    </label>
                                </div>
                            </div>
                            {!! $errors->first('allow_full_sidebar', '<label class="help-block error-validation">:message</label>') !!}
                        </div>

                        <button type="submit" class="btn btn-info btn-fw btn-lg mr-2">Submit</button>
                        <a href="{{ route('settings.index') }}" class="btn btn-secondary btn-fw btn-lg">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
