@extends('layouts.master')
@php
$title = @$data ? 'Edit' : 'Tambah';
@endphp
@section('title', 'Particle Pertanyaan Mini ' . $title)
@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ $title }} Particle Pertanyaan Mini</h4>
                        <br>
                        <form class="forms-sample"
                            action="{{ @$data ? route('particle-mini-course-questions.update', $data->id) : route('particle-mini-course-questions.store') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @if (@$data)
                                <input type="hidden" name="_method" value="put">
                            @endif
                            {{-- <div class="row"> --}}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="particle_mini_course_id">Pilih Particle Mini Test</label>
                                        <select name="particle_mini_course_id" id="particle_mini_course_id" class="form-control" required>
                                            <option value="">Pilih Particle Mini Test</option>
                                            @foreach ($courses as $course)
                                                <option value="{{ $course->id }}"
                                                    {{ $course->id == @$data->particle_mini_course_id ? 'selected' : '' }}>
                                                    {{ $course->title }} | {{$course->chapter_title}}</option>
                                            @endforeach
                                        </select>
                                        {!! $errors->first('particle_mini_course_id', '<label class="help-block error-validation">:message</label>') !!}
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
                                <label for="question_jpn">Pertanyaan Jepang</label>
                                <textarea class="form-control" name="question_jpn" id="question_jpn" rows="4"
                                    placeholder="Pertanyaan Jepang" required
                                    value="">{{ old('question_jpn') ?? @$data->question_jpn }}</textarea>

                                {!! $errors->first('question_jpn', '<label class="help-block error-validation">:message</label>') !!}
                            </div>

                            <div class="form-group">
                                <label for="question_romanji">Pertanyaan Romanji</label>
                                <textarea class="form-control" name="question_romanji" id="question_romanji" rows="3"
                                    placeholder="Pertanyaan Romanji" required
                                    value="">{{ old('question_romanji') ?? @$data->question_romanji }}</textarea>

                                {!! $errors->first('question_romanji', '<label class="help-block error-validation">:message</label>') !!}
                            </div>

                            <div class="form-group">
                                <label for="question_idn">Pertanyaan Indonesia</label>
                                <textarea class="form-control" name="question_idn" id="question_idn" rows="3"
                                    placeholder="Pertanyaan Indonesia" required
                                    value="">{{ old('question_idn') ?? @$data->question_idn }}</textarea>

                                {!! $errors->first('question_idn', '<label class="help-block error-validation">:message</label>') !!}
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="card">
                                            <div class="card-header info">Jawaban A
                                                <span class="float-right">
                                                    <input type="checkbox" data-toggle="tooltip" data-placement="top"
                                                        title="Choose as answer" name="answer[0][is_true]" value="1"
                                                        {{ ($type == 'new' ? 'checked' : @$answers[0]->is_true == true) ? 'checked' : '' }}>
                                                </span>
                                            </div>
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <textarea class="form-control" rows="3" name="answer[0][answer_jpn]"
                                                        placeholder="Jawaban"
                                                        required>{{ old('answer[0][answer_jpn]') ?? @$answers[0]->answer_jpn }}</textarea>
                                                </div>
                                                {{-- <div class="form-group">
                                                    <textarea class="form-control" rows="3" name="answer[0][answer_romanji]"
                                                        placeholder="answer romanji"
                                                        required>{{ old('answer[0][answer_romanji]') ?? @$answers[0]->answer_romanji }}</textarea>
                                                </div>
                                                <div class="form-group">
                                                    <textarea class="form-control" rows="3" name="answer[0][answer_idn]"
                                                        placeholder="answer indonesia"
                                                        required>{{ old('answer[0][answer_idn]') ?? @$answers[0]->answer_idn }}</textarea>
                                                </div> --}}
                                            </div>
                                        </div>
                                        <input id="answer[0][id]" name="answer[0][id]" type="hidden"
                                            value="{{ @$answers[0]->id }}">
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="card">
                                            <div class="card-header info">Jawaban B
                                                <span class="float-right">
                                                    <input type="checkbox" data-toggle="tooltip" data-placement="top"
                                                        title="Choose as answer" name="answer[1][is_true]" value="1"
                                                        {{ @$answers[1]->is_true == true ? 'checked' : '' }}>
                                                </span>
                                            </div>
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <textarea class="form-control" rows="3" name="answer[1][answer_jpn]"
                                                        placeholder="Jawaban"
                                                        required>{{ old('answer[1][answer_jpn]') ?? @$answers[1]->answer_jpn }}</textarea>
                                                </div>
                                                {{-- <div class="form-group">
                                                    <textarea class="form-control" rows="3" name="answer[1][answer_romanji]"
                                                        placeholder="answer romanji"
                                                        required>{{ old('answer[1][answer_romanji]') ?? @$answers[1]->answer_romanji }}</textarea>
                                                </div>
                                                <div class="form-group">
                                                    <textarea class="form-control" rows="3" name="answer[1][answer_idn]"
                                                        placeholder="answer indonesia"
                                                        required>{{ old('answer[1][answer_idn]') ?? @$answers[1]->answer_idn }}</textarea>
                                                </div> --}}
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
                                            <div class="card-header info">Jawaban C
                                                <span class="float-right">
                                                    <input type="checkbox" data-toggle="tooltip" data-placement="top"
                                                        title="Choose as answer" name="answer[2][is_true]" value="1"
                                                        {{ @$answers[2]->is_true == true ? 'checked' : '' }}>
                                                </span>
                                            </div>
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <textarea class="form-control" rows="3" name="answer[2][answer_jpn]"
                                                        placeholder="Jawaban"
                                                        required>{{ old('answer[2][answer_jpn]') ?? @$answers[2]->answer_jpn }}</textarea>
                                                </div>
                                                {{-- <div class="form-group">
                                                    <textarea class="form-control" rows="3" name="answer[2][answer_romanji]"
                                                        placeholder="answer romanji"
                                                        required>{{ old('answer[2][answer_romanji]') ?? @$answers[2]->answer_romanji }}</textarea>
                                                </div>
                                                <div class="form-group">
                                                    <textarea class="form-control" rows="3" name="answer[2][answer_idn]"
                                                        placeholder="answer indonesia"
                                                        required>{{ old('answer[2][answer_idn]') ?? @$answers[2]->answer_idn }}</textarea>
                                                </div> --}}
                                            </div>
                                        </div>
                                        <input id="answer[2][id]" name="answer[2][id]" type="hidden"
                                            value="{{ @$answers[2]->id }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="card">
                                            <div class="card-header info">Jawaban D
                                                <span class="float-right">
                                                    <input type="checkbox" data-toggle="tooltip" data-placement="top"
                                                        title="Choose as answer" name="answer[3][is_true]" value="1"
                                                        {{ @$answers[3]->is_true == true ? 'checked' : '' }}>
                                                </span>
                                            </div>
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <textarea class="form-control" rows="3" name="answer[3][answer_jpn]"
                                                        placeholder="Jawaban"
                                                        required>{{ old('answer[3][answer_jpn]') ?? @$answers[3]->answer_jpn }}</textarea>
                                                </div>
                                                {{-- <div class="form-group">
                                                    <textarea class="form-control" rows="3" name="answer[3][answer_romanji]"
                                                        placeholder="answer romanji"
                                                        required>{{ old('answer[3][answer_romanji]') ?? @$answers[3]->answer_romanji }}</textarea>
                                                </div>
                                                <div class="form-group">
                                                    <textarea class="form-control" rows="3" name="answer[3][answer_idn]"
                                                        placeholder="answer indonesia"
                                                        required>{{ old('answer[3][answer_idn]') ?? @$answers[3]->answer_idn }}</textarea>
                                                </div> --}}
                                            </div>
                                        </div>
                                        <input id="answer[3][id]" name="answer[3][id]" type="hidden"
                                            value="{{ @$answers[3]->id }}">
                                    </div>
                                </div>
                            </div>
                            {{-- </div> --}}

                            <button type="submit" class="btn btn-info btn-fw btn-lg mr-2">Submit</button>
                            <a href="{{ route('particle-mini-course-questions.index') }}"
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
