@extends('layouts.master')
@php
$title = @$data ? 'Edit' : 'Add New';
@endphp
@section('title', 'Pattern Lesson Detail' . $title)
@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ $title }} Pattern Lesson Detail</h4>
                        <br>
                        <form class="forms-sample"
                            action="{{ @$data ? route('lesson-detail-update', [$data->pattern_lesson_id, $data->id]) : route('lesson-detail-post', request()->route('id')) }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @if (@$data)
                                <input type="hidden" name="_method" value="put">
                            @endif
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="hidden" name="id" value="{{ $data->id }}">
                                    <div class="form-group">
                                        <label for="title">Title Detail</label>
                                        <textarea class="form-control" rows="3" name="title" placeholder="Title"
                                            required>{{ old('title') ?? @$data->lesson_title }}</textarea>
                                        {!! $errors->first('title', '<label class="help-block error-validation">:message</label>') !!}
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6" id="dynamic_field">
                                            <br />
                                            <h4 class="d-inline card-title">Highlight</h4>
                                            <span class="d-inline pull-right form-group">
                                                <i class="btn btn-sm btn-success mdi mdi-plus-box" id="add"></i>
                                            </span>

                                            @foreach ($highlights as $key => $item)
                                                <div class="input-group form-group" id="rowfld{{ $key }}">
                                                    <input type="text" name="highlights[{{ $key }}][title]"
                                                        class="form-control" placeholder="Highlight" aria-label="Highlight"
                                                        value="{{ $item['title_highlight'] }}"
                                                        aria-describedby="basic-addon2" required>
                                                    <div class="input-group-append">
                                                        <button class="btn btn-sm btn-danger mdi mdi-minus-box btn_remove"
                                                            type="button" id="{{ $key }}"
                                                            {{ count($highlights) <= 1 ? 'disabled' : '' }}>
                                                        </button>
                                                    </div>
                                                    <input type="hidden" name="highlights[{{ $key }}][id]"
                                                        value="{{ $item['id'] }}">
                                                </div>
                                            @endforeach

                                        </div>

                                        <div class="col-md-6" id="formula_field">
                                            <br />
                                            <h4 class="d-inline card-title">Formula</h4>
                                            <span class="d-inline pull-right form-group">
                                                <i class="btn btn-sm btn-success mdi mdi-plus-box" id="addfrml"></i>
                                            </span>

                                            @foreach ($formulas as $key => $item)
                                                <div class="input-group form-group" id="rowfrml{{ $key }}">
                                                    <input type="text" name="formulas[{{ $key }}][content]"
                                                        class="form-control" value="{{ $item['content'] }}"
                                                        placeholder="Formula Content" aria-label="Formula Content"
                                                        aria-describedby="basic-addon2" required>
                                                    <div class="input-group-append">
                                                        <button
                                                            class="btn btn-sm btn-danger mdi mdi-minus-box btn_removefrml"
                                                            type="button" id="{{ $key }}" {{ count($formulas) <= 1 ? 'disabled' : '' }}>
                                                        </button>
                                                    </div>
                                                    <input type="hidden" name="formulas[{{ $key }}][id]"
                                                        value="{{ $item['id'] }}">
                                                </div>
                                            @endforeach

                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" name="pattern_lesson_id" value="{{ $data->pattern_lesson_id }}">

                            </div>


                            <span class="form-group">
                                <br>
                                <button type="submit" class="btn btn-info btn-fw btn-lg mr-2">Submit</button>
                                <a href="{{ route('lesson-detail-index',$data->pattern_lesson_id) }}"
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
                $('#dynamic_field').append('<div class="input-group form-group" id="rowfld' + i +
                    '"> <input type="text" name="highlights[' + i +
                    '][title]" class="form-control" placeholder="Highlight" aria-label="Highlight" aria-describedby="basic-addon2" required> <div class="input-group-append"> <button class="btn btn-sm btn-danger mdi mdi-minus-box btn_remove" type="button" id="' +
                    i + '"></button> </div> </div>  <input type="hidden" name="highlights[' + i +
                    '][id]" value="">');

                if ($(".btn_remove").length > 1) {
                    $(".btn_remove").removeAttr('disabled');
                }
            });

            $(document).on('click', '.btn_remove', function() {
                var button_id = $(this).attr("id");
                $('#rowfld' + button_id + '').remove();

                if ($(".btn_remove").length <= 1) {
                    $(".btn_remove").attr('disabled', 'disabled');
                }

            });

            $('#addfrml').click(function() {
                i++;
                $('#formula_field').append('<div class="input-group form-group" id="rowfrml' + i +
                    '"> <input type="text" name="formulas[' + i +
                    '][content]" class="form-control" placeholder="Formula Content" aria-label="Formula Content" aria-describedby="basic-addon2" required> <div class="input-group-append"> <button class="btn btn-sm btn-danger mdi mdi-minus-box btn_removefrml" type="button" id="' +
                    i + '"></button> </div> </div> <input type="hidden" name="formulas[' + i +
                    '][id]" value="">');

                if ($(".btn_removefrml").length > 1) {
                    $(".btn_removefrml").removeAttr('disabled');
                }
            });

            $(document).on('click', '.btn_removefrml', function() {
                var button_id = $(this).attr("id");
                $('#rowfrml' + button_id + '').remove();

                if ($(".btn_removefrml").length <= 1) {
                    $(".btn_removefrml").attr('disabled', 'disabled');
                }
            });

            $('#addjpn').click(function() {
                i++;
                $('#textjpn').append('<span id="rowjpn' + i +
                    '"><div class="form-group" > <textarea class="form-control" rows="3" name="answer[0][answer_jpn]" placeholder="answer japan" required>{{ old('answer[text_kanji]') ?? @$answers->text_kanji }}</textarea> </div> <div class="form-group"> <textarea class="form-control" rows="3" name="answer[answer_idn]" placeholder="answer indonesia" required>{{ old('answer[text_idn]') ?? @$answers->text_idn }}</textarea> </div> <div class="form-group"> <textarea class="form-control" rows="3" name="answer[answer_idn]" placeholder="answer indonesia" required>{{ old('answer[text_hiragana]') ?? @$answers->text_hiragana }}</textarea> </div> <div class="form-group"> <input type="checkbox" data-toggle="tooltip" data-placement="top" title="is highlighted" name="answer[is_highlighted]" value="1"> {{-- {{ ($type == "new" ? "checked" : @$answers[0]->is_true == true) ? "checked" : "" }}> --}} </div> <button class="btn btn-sm btn-danger mdi mdi-minus-box btn_removejpn" type="button" id="' +
                    i + '"></button><hr> </span>');
            });

            $(document).on('click', '.btn_removejpn', function() {
                var button_id = $(this).attr("id");
                $('#rowjpn' + button_id + '').remove();
            });

            $('#addrmj').click(function() {
                i++;
                $('#textrmj').append('<span id="rowrmj' + i +
                    '"><div class="form-group"> <textarea class="form-control" rows="3" name="answer[text]" placeholder="answer indonesia" required>{{ old('answer[text]') ?? @$answers->text_hiragana }}</textarea> </div> <div class="form-group">  <input type="checkbox" data-toggle="tooltip" data-placement="top" title="is highlighted" name="answer[is_highlighted]" value="1"> {{-- {{ ($type == "new"? "checked" : @$answers[0]->is_true == true) ? "checked" : "" }}> --}} </div> <button class="btn btn-sm btn-danger mdi mdi-minus-box btn_removermj" type="button" id="' +
                    i + '"></button> <hr> </span>');
            });

            $(document).on('click', '.btn_removermj', function() {
                var button_id = $(this).attr("id");
                $('#rowrmj' + button_id + '').remove();
            });
        });

    </script>
@endsection
