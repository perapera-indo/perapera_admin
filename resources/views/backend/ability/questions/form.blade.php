@extends('layouts.master')
@php
$title = @$data ? 'Edit' : 'Add New';
@endphp
@section('title', 'Ability ' . $title)
@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ $title }} Ability Question</h4>
                        <br>
                        <form class="forms-sample"
                            action="{{ @$data ? route('ability-course-questions.update', $data->id) : route('ability-course-questions.store') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @if (@$data)
                                <input type="hidden" name="_method" value="put">
                            @endif

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="question_jpn">Question Japan</label>
                                        <textarea class="form-control" name="question_jpn" id="question_jpn" rows="6"
                                            placeholder="question japan" required
                                            value="">{{ old('question_jpn') ?? @$data->question_jpn }}</textarea>

                                        {!! $errors->first('question_jpn', '<label class="help-block error-validation">:message</label>') !!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group input-group">
                                        <label for="exampleInputFile">Image</label>
                                        <input type="file"
                                            class="form-control {{ hasErrorField($errors, 'question_img') }} dropify"
                                            data-errors-position="outside" name="question_img"
                                            data-default-file="{{ env('CLOUD_S3_URL') . @$data->question_img }}"
                                            data-height="100" data-max-file-size="4M"
                                            data-allowed-file-extensions="jpg jpeg png gif"
                                            {{ @$type == 'new' ? 'required' : '' }}>
                                    </div>
                                    {!! $errors->first('question_img', '<label class="help-block error-validation">:message</label>') !!}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
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
                                <input type="hidden" name="ability_course_question_group_id" value="{{ request()->route('id') }}">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="is_active">Status</label>
                                        <select name="is_active" id="status" class="form-control">
                                            <option {{ @$data->is_active == 1 ? 'selected' : '' }} value="1">
                                                active
                                            </option>
                                            <option {{ @$data->is_active == 0 ? 'selected' : '' }} value="0">
                                                inactive
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="card">
                                            <div class="card-header info">Answer A
                                                <span class="float-right">
                                                    <input type="checkbox" data-toggle="tooltip" data-placement="top"
                                                        title="Choose as answer" name="answer[0][is_true]" value="1"
                                                        {{ ($type == 'new' ? 'checked' : @$answers[0]->is_true == true) ? 'checked' : '' }}>
                                                </span>
                                            </div>
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <textarea class="form-control" rows="3" name="answer[0][answer]"
                                                        placeholder="answer japan"
                                                        required>{{ old('answer[0][answer]') ?? @$answers[0]->answer }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <input id="answer[0][id]" name="answer[0][id]" type="hidden"
                                            value="{{ @$answers[0]->id }}">
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="card">
                                            <div class="card-header info">Answer B
                                                <span class="float-right">
                                                    <input type="checkbox" data-toggle="tooltip" data-placement="top"
                                                        title="Choose as answer" name="answer[1][is_true]" value="1"
                                                        {{ @$answers[1]->is_true == true ? 'checked' : '' }}>
                                                </span>
                                            </div>
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <textarea class="form-control" rows="3" name="answer[1][answer]"
                                                        placeholder="answer japan"
                                                        required>{{ old('answer[1][answer]') ?? @$answers[1]->answer }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <input id="answer[1][id]" name="answer[1][id]" type="hidden"
                                            value="{{ @$answers[1]->id }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="card">
                                            <div class="card-header info">Answer C
                                                <span class="float-right">
                                                    <input type="checkbox" data-toggle="tooltip" data-placement="top"
                                                        title="Choose as answer" name="answer[2][is_true]" value="1"
                                                        {{ @$answers[2]->is_true == true ? 'checked' : '' }}>
                                                </span>
                                            </div>
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <textarea class="form-control" rows="3" name="answer[2][answer]"
                                                        placeholder="answer japan"
                                                        required>{{ old('answer[2][answer]') ?? @$answers[2]->answer }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <input id="answer[2][id]" name="answer[2][id]" type="hidden"
                                            value="{{ @$answers[2]->id }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="card">
                                            <div class="card-header info">Answer D
                                                <span class="float-right">
                                                    <input type="checkbox" data-toggle="tooltip" data-placement="top"
                                                        title="Choose as answer" name="answer[3][is_true]" value="1"
                                                        {{ @$answers[3]->is_true == true ? 'checked' : '' }}>
                                                </span>
                                            </div>
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <textarea class="form-control" rows="3" name="answer[3][answer]"
                                                        placeholder="answer japan"
                                                        required>{{ old('answer[3][answer]') ?? @$answers[3]->answer }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <input id="answer[3][id]" name="answer[3][id]" type="hidden"
                                            value="{{ @$answers[3]->id }}">
                                    </div>
                                </div>
                            </div>
                            {{-- </div> --}}

                            <button type="submit" class="btn btn-info btn-fw btn-lg mr-2">Submit</button>
                            <a href="{{ route('ability-course-questions.index') }}"
                                class="btn btn-secondary btn-fw btn-lg">Cancel</a>
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
            $(document).on('click', 'input[type="checkbox"]', function() {
                $('input[type="checkbox"]').not(this).prop('checked', false);
            });
        });

    </script>
@endsection
