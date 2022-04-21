@extends('layouts.master')
@php
$title = @$data ? 'Edit' : 'Add New';
@endphp
@section('title', 'Question Group ' . $title)
@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ $title }} Question Group</h4>
                        <br>
                        <form class="forms-sample"
                            action="{{ @$data ? route('ability-course-question-groups.update', $data->id) : route('ability-course-question-groups.store') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @if (@$data)
                                <input type="hidden" name="_method" value="put">
                            @endif
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="question_jpn">Question Japan</label>
                                        <input type="text"
                                            class="form-control {{ hasErrorField($errors, 'question_jpn') }}"
                                            id="question_jpn" name="question_jpn"
                                            value="{{ old('question_jpn', @$data->question_jpn) }}"
                                            placeholder="Question Japan" required>
                                        {!! $errors->first('question_jpn', '<label class="help-block error-validation">:message</label>') !!}
                                    </div>

                                    <div class="form-group input-group">
                                        <label for="exampleInputFile2">Image</label>
                                        <input type="file"
                                            class="form-control {{ hasErrorField($errors, 'question_img') }} dropify"
                                            data-errors-position="outside" name="question_img"
                                            data-default-file="{{ env('CLOUD_S3_URL') . @$data->question_img }}"
                                            data-height="100" data-max-file-size="2M"
                                            data-allowed-file-extensions="jpg jpeg png gif">
                                    </div>
                                    {!! $errors->first('img', '<label class="help-block error-validation">:message</label>') !!}

                                    <div class="form-group">
                                        <label>Sound</label>
                                        <input type="file" name="question_sound" class="file-upload-default"
                                            data-max-file-size="5M"
                                            data-default-file="{{ env('CLOUD_S3_URL') . @$data->question_sound }}">
                                        <div class="input-group">
                                            <input type="text" class="form-control file-upload-info" disabled=""
                                                placeholder="{{ @$data->question_sound ? @$data->question_sound : 'Upload Sound' }}"
                                                data-max-file-size="5M"
                                                data-default-file="{{ env('CLOUD_S3_URL') . @$data->question_sound }}">
                                            <span class="input-group-append">
                                                <button class="file-upload-browse btn btn-gradient-primary"
                                                    type="button">Choose</button>
                                            </span>
                                        </div>
                                        {!! $errors->first('question_sound', '<label class="help-block error-validation">:message</label>') !!}
                                    </div>

                                    @if (@$data->question_sound)
                                        <div class="form-group">
                                            <label>Listen here</label>
                                            <br>
                                            <audio controls>
                                                <source src="{{ env('CLOUD_S3_URL') . @$data->question_sound }}"
                                                    type="audio/mpeg">
                                            </audio>
                                        </div>
                                    @endif

                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="ability_course_id">Ability Course</label>
                                        <select name="ability_course_id" id="ability_course_id" class="form-control"
                                            required>
                                            <option value="">Select Ability Course</option>
                                            @foreach (@$courses as $course)
                                                <option value="{{ $course->id }}"
                                                    {{ $course->id == @$data->ability_course_id ? 'selected' : '' }}>
                                                    {{ $course->title }}</option>
                                            @endforeach
                                        </select>
                                        {!! $errors->first('ability_course_id', '<label class="help-block error-validation">:message</label>') !!}

                                    </div>

                                    <div class="form-group">
                                        <label for="is_active">Status</label>
                                        <select name="is_active" id="is_active" class="form-control">
                                            <option {{ @$data->is_active == 1 ? 'selected' : '' }} value="1"> active
                                            </option>
                                            <option {{ @$data->is_active == 0 ? 'selected' : '' }} value="0"> inactive
                                            </option>
                                        </select>
                                        {!! $errors->first('is_active', '<label class="help-block error-validation">:message</label>') !!}
                                    </div>
                                </div>

                            </div>

                            <button type="submit" class="btn btn-info btn-fw btn-lg mr-2">Submit</button>
                            <a href="{{ route('ability-course-question-groups.index') }}"
                                class="btn btn-secondary btn-fw btn-lg">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
