@extends('layouts.master')
@php
$title = @$data ? 'Edit' : 'Add New';
@endphp
@section('title', 'Verb Mini ' . $title)
@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ $title }} Verb Mini Question</h4>
                        <br>
                        <form class="forms-sample"
                            action="{{ @$data ? route('verb-mini-questions.update', $data->id) : route('verb-mini-questions.store') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @if (@$data)
                                <input type="hidden" name="_method" value="put">
                            @endif
                            {{-- <div class="row"> --}}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="verb_mini_course_id">Pick Verb Mini Course</label>
                                        <select name="verb_mini_course_id" id="verb_mini_course_id" class="form-control" required>
                                            <option value="">Select Verb Mini Course</option>
                                            @foreach ($courses as $course)
                                                <option value="{{ $course->id }}"
                                                    {{ $course->id == @$data->verb_mini_course_id ? 'selected' : '' }}>
                                                    {{ $course->title }} | {{$course->level_name}}</option>
                                            @endforeach
                                        </select>
                                        {!! $errors->first('verb_mini_course_id', '<label class="help-block error-validation">:message</label>') !!}
                                    </div>
                                </div>

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

                            <div class="form-group">
                                <label for="question_jpn">Question Japan</label>
                                <textarea class="form-control" name="question_jpn" id="question_jpn" rows="4"
                                    placeholder="Question Japan" required
                                    value="">{{ old('question_jpn') ?? @$data->question_jpn }}</textarea>

                                {!! $errors->first('question_jpn', '<label class="help-block error-validation">:message</label>') !!}
                            </div>

                            <div class="form-group">
                                <label for="question_romanji">Question Romanji</label>
                                <textarea class="form-control" name="question_romanji" id="question_romanji" rows="3"
                                    placeholder="Question Romanji" required
                                    value="">{{ old('question_romanji') ?? @$data->question_romanji }}</textarea>

                                {!! $errors->first('question_romanji', '<label class="help-block error-validation">:message</label>') !!}
                            </div>

                            <div class="form-group">
                                <label for="question_idn">Question Indonesia</label>
                                <textarea class="form-control" name="question_idn" id="question_idn" rows="3"
                                    placeholder="Question Indonesia" required
                                    value="">{{ old('question_idn') ?? @$data->question_idn }}</textarea>

                                {!! $errors->first('question_idn', '<label class="help-block error-validation">:message</label>') !!}
                            </div>

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
                                                    <textarea class="form-control" rows="3" name="answer[0][answer_jpn]"
                                                        placeholder="answer japan"
                                                        required>{{ old('answer[0][answer_jpn]') ?? @$answers[0]->answer_jpn }}</textarea>
                                                </div>
                                                <div class="form-group">
                                                    <textarea class="form-control" rows="3" name="answer[0][answer_idn]"
                                                        placeholder="answer indonesia"
                                                        required>{{ old('answer[0][answer_idn]') ?? @$answers[0]->answer_idn }}</textarea>
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
                                                    <textarea class="form-control" rows="3" name="answer[1][answer_jpn]"
                                                        placeholder="answer japan"
                                                        required>{{ old('answer[1][answer_jpn]') ?? @$answers[1]->answer_jpn }}</textarea>
                                                </div>
                                                <div class="form-group">
                                                    <textarea class="form-control" rows="3" name="answer[1][answer_idn]"
                                                        placeholder="answer indonesia"
                                                        required>{{ old('answer[1][answer_idn]') ?? @$answers[1]->answer_idn }}</textarea>
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
                                                    <textarea class="form-control" rows="3" name="answer[2][answer_jpn]"
                                                        placeholder="answer japan"
                                                        required>{{ old('answer[2][answer_jpn]') ?? @$answers[2]->answer_jpn }}</textarea>
                                                </div>
                                                <div class="form-group">
                                                    <textarea class="form-control" rows="3" name="answer[2][answer_idn]"
                                                        placeholder="answer indonesia"
                                                        required>{{ old('answer[2][answer_idn]') ?? @$answers[2]->answer_idn }}</textarea>
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
                                                    <textarea class="form-control" rows="3" name="answer[3][answer_jpn]"
                                                        placeholder="answer japan"
                                                        required>{{ old('answer[3][answer_jpn]') ?? @$answers[3]->answer_jpn }}</textarea>
                                                </div>
                                                <div class="form-group">
                                                    <textarea class="form-control" rows="3" name="answer[3][answer_idn]"
                                                        placeholder="answer indonesia"
                                                        required>{{ old('answer[3][answer_idn]') ?? @$answers[3]->answer_idn }}</textarea>
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
                            <a href="{{ route('verb-mini-questions.index') }}"
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
