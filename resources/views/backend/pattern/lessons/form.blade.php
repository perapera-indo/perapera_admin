@extends('layouts.master')
@php
$title = @$data ? 'Edit' : 'Add New';
@endphp
@section('title', 'Pattern Lesson ' . $title)
@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ $title }} Pattern Lesson</h4>
                        <br>
                        <form class="forms-sample"
                            action="{{ @$data ? route('pattern-lessons.update', $data->id) : route('pattern-lessons.store') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @if (@$data)
                                <input type="hidden" name="_method" value="put">
                            @endif
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control {{ hasErrorField($errors, 'name') }}"
                                            id="name" name="name" value="{{ old('name', @$data->name) }}"
                                            placeholder="Name" required>
                                        {!! $errors->first('name', '<label class="help-block error-validation">:message</label>') !!}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="pattern_chapter_id">Chapters</label>
                                        <select name="pattern_chapter_id" id="pattern_chapter_id" class="form-control"
                                            required>
                                            <option value="">Select Chapters</option>
                                            @foreach (@$chapters as $chapter)
                                                <option value="{{ $chapter->id }}"
                                                    {{ $chapter->id == @$data->pattern_chapter_id ? 'selected' : '' }}>
                                                    {{ $chapter->name }}</option>
                                            @endforeach
                                        </select>
                                        {!! $errors->first('pattern_chapter_id', '<label class="help-block error-validation">:message</label>') !!}

                                    </div>
                                </div>
                                <div class="col-md-4">
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

                                <div class="col-md-12">
                                    <br />
                                    <h4 class="card-title">{{ $title }} Add Detail Pattern Lesson</h4>
                                    <br />

                                    {{-- <div class="row"> --}}
                                    <div class="form-group">
                                        <label for="title">Title Detail</label>
                                        <input type="text" class="form-control {{ hasErrorField($errors, 'title') }}"
                                            id="title" name="title" value="{{ old('title', @$data->title) }}"
                                            placeholder="Title" required>
                                        {!! $errors->first('title', '<label class="help-block error-validation">:message</label>') !!}
                                        {{-- </div> --}}

                                        <div class="row">
                                            <div class="col-md-6" id="dynamic_field">
                                                <br />
                                                <h4 class="d-inline card-title">Highlight</h4>
                                                <span class="d-inline pull-right form-group">
                                                    <i class="btn btn-sm btn-success mdi mdi-plus-box" id="add"></i>
                                                </span>

                                                <div class="form-group">
                                                    <input type="text"
                                                        class="form-control {{ hasErrorField($errors, 'highlight') }}"
                                                        id="highlight" name="highlight[]"
                                                        value="{{ old('highlight', @$data->highlight) }}"
                                                        placeholder="highlight" required>
                                                    {!! $errors->first('highlight', '<label class="help-block error-validation">:message</label>') !!}
                                                </div>
                                            </div>

                                            <div class="col-md-6" id="formula_field">
                                                <br />
                                                <h4 class="d-inline card-title">Formula</h4>
                                                <span class="d-inline pull-right form-group">
                                                    <i class="btn btn-sm btn-success mdi mdi-plus-box" id="addfrml"></i>
                                                </span>

                                                <div class="form-group">
                                                    <input type="text"
                                                        class="form-control {{ hasErrorField($errors, 'content') }}"
                                                        id="content" name="content[]"
                                                        value="{{ old('content', @$data->content) }}"
                                                        placeholder="content" required>
                                                    {!! $errors->first('content', '<label class="help-block error-validation">:message</label>') !!}
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>


                            <span class="form-group">
                                <br>
                                <button type="submit" class="btn btn-info btn-fw btn-lg mr-2">Submit</button>
                                <a href="{{ route('pattern-lessons.index') }}"
                                    class="btn btn-secondary btn-fw btn-lg">Cancel</a>
                            </span>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            var i = 1;
            $('#add').click(function() {
                    i++;
                    $('#dynamic_field').append('<div class="input-group form-group" id="rowfld'+i+'"> <input type="text" name="highlight[]" class="form-control" placeholder="Highlight" aria-label="Highlight" aria-describedby="basic-addon2" required> <div class="input-group-append"> <button class="btn btn-sm btn-danger mdi mdi-minus-box btn_remove" type="button" id="'+i+'"></button> </div> </div>');
            });

            $(document).on('click', '.btn_remove', function(){
                var button_id = $(this).attr("id");
                $('#rowfld'+button_id+'').remove();
            });

            $('#addfrml').click(function() {
                    i++;
                    $('#formula_field').append('<div class="input-group form-group" id="rowfrml'+i+'"> <input type="text" name="content[]" class="form-control" placeholder="Formula Content" aria-label="Formula Content" aria-describedby="basic-addon2" required> <div class="input-group-append"> <button class="btn btn-sm btn-danger mdi mdi-minus-box btn_removefrml" type="button" id="'+i+'"></button> </div> </div>');
            });

            $(document).on('click', '.btn_removefrml', function(){
                var button_id = $(this).attr("id");
                $('#rowfrml'+button_id+'').remove();
            });

            $('#addjpn').click(function() {
                    i++;
                    $('#textjpn').append('<span id="rowjpn'+i+'"><div class="form-group" > <textarea class="form-control" rows="3" name="answer[0][answer_jpn]" placeholder="answer japan" required>{{ old('answer[text_kanji]') ?? @$answers->text_kanji }}</textarea> </div> <div class="form-group"> <textarea class="form-control" rows="3" name="answer[answer_idn]" placeholder="answer indonesia" required>{{ old('answer[text_idn]') ?? @$answers->text_idn }}</textarea> </div> <div class="form-group"> <textarea class="form-control" rows="3" name="answer[answer_idn]" placeholder="answer indonesia" required>{{ old('answer[text_hiragana]') ?? @$answers->text_hiragana }}</textarea> </div> <div class="form-group"> <input type="checkbox" data-toggle="tooltip" data-placement="top" title="is highlighted" name="answer[is_highlighted]" value="1"> {{-- {{ ($type == "new" ? "checked" : @$answers[0]->is_true == true) ? "checked" : "" }}> --}} </div> <button class="btn btn-sm btn-danger mdi mdi-minus-box btn_removejpn" type="button" id="'+i+'"></button><hr> </span>');
            });

            $(document).on('click', '.btn_removejpn', function(){
                var button_id = $(this).attr("id");
                $('#rowjpn'+button_id+'').remove();
            });

            $('#addrmj').click(function() {
                    i++;
                    $('#textrmj').append('<span id="rowrmj'+i+'"><div class="form-group"> <textarea class="form-control" rows="3" name="answer[text]" placeholder="answer indonesia" required>{{ old("answer[text]") ?? @$answers->text_hiragana }}</textarea> </div> <div class="form-group">  <input type="checkbox" data-toggle="tooltip" data-placement="top" title="is highlighted" name="answer[is_highlighted]" value="1"> {{-- {{ ($type == "new"? "checked" : @$answers[0]->is_true == true) ? "checked" : "" }}> --}} </div> <button class="btn btn-sm btn-danger mdi mdi-minus-box btn_removermj" type="button" id="'+i+'"></button> <hr> </span>');
            });

            $(document).on('click', '.btn_removermj', function(){
                var button_id = $(this).attr("id");
                $('#rowrmj'+button_id+'').remove();
            });
        });
    </script>
@endsection
