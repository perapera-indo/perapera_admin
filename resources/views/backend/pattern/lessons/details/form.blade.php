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
                            action="{{ @$data ? route('pattern-lesson-details.update', $data->id) : route('lesson-detail-post', request()->route('id') ) }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @if (@$data)
                                <input type="hidden" name="_method" value="put">
                            @endif
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="title">Title Detail</label>
                                        <textarea class="form-control" rows="3" name="title" placeholder="Title"
                                            required>{{ old('title') }}</textarea>
                                        {!! $errors->first('title', '<label class="help-block error-validation">:message</label>') !!}
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6" id="dynamic_field">
                                            <br />
                                            <h4 class="d-inline card-title">Highlight</h4>
                                            <span class="d-inline pull-right form-group">
                                                <i class="btn btn-sm btn-success mdi mdi-plus-box" id="add"></i>
                                            </span>

                                            <div class="form-group">
                                                <input type="text"
                                                    class="form-control {{ hasErrorField($errors, 'highlights') }}"
                                                    id="highlights" name="highlights[]"
                                                    value="{{ old('highlights[]') }}"
                                                    placeholder="highlights" required>
                                                {!! $errors->first('highlights', '<label class="help-block error-validation">:message</label>') !!}
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
                                                    class="form-control {{ hasErrorField($errors, 'formulas') }}"
                                                    id="formulas" name="formulas[]"
                                                    value="{{ old('formulas[]') }}" placeholder="formula"
                                                    required>
                                                {!! $errors->first('formulas', '<label class="help-block error-validation">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" name="pattern_lesson_id" value="{{ request()->route('id') }}">

                                {{-- <div class="col-md-12">
                                    <br />
                                            <h4 class="d-inline card-title">Example</h4>
                                            <hr/>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group input-group">
                                                <label for="exampleInputFile2">Color Image</label>
                                                <input type="file" class="form-control {{ hasErrorField($errors,'color_image_url') }} dropify" data-errors-position="outside" name="color_image_url" data-default-file="{{ env('CLOUD_S3_URL') . @$data->color_image_url }}"
                                                       data-height="100" data-max-file-size="2M" data-allowed-file-extensions="jpg jpeg png gif">
                                            </div>
                                            {!! $errors->first('color_image_url', '<label class="help-block error-validation">:message</label>') !!}
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="description">Description</label>
                                                <textarea class="form-control" name="description" id="description" rows="6"
                                                    placeholder="description" required
                                                    value="">{{ old('description') ?? @$data->description }}</textarea>

                                                {!! $errors->first('description', '<label class="help-block error-validation">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <br />
                                            <h4 class="d-inline card-title">Text Japan</h4>
                                            <span class="d-inline pull-right form-group">
                                                <i class="btn btn-sm btn-success mdi mdi-plus-box" id="addjpn"></i>
                                            </span>

                                            <div class="form-group" id="textjpn">
                                                <div class="form-group">
                                                    <textarea class="form-control" rows="3" name="answer[0][answer_jpn]"
                                                        placeholder="answer japan"
                                                        required>{{ old('answer[text_kanji]') ?? @$answers->text_kanji }}</textarea>
                                                </div>
                                                <div class="form-group">
                                                    <textarea class="form-control" rows="3" name="answer[answer_idn]"
                                                        placeholder="answer indonesia"
                                                        required>{{ old('answer[text_idn]') ?? @$answers->text_idn }}</textarea>
                                                </div>
                                                <div class="form-group">
                                                    <textarea class="form-control" rows="3" name="answer[answer_idn]"
                                                        placeholder="answer indonesia"
                                                        required>{{ old('answer[text_hiragana]') ?? @$answers->text_hiragana }}</textarea>
                                                </div>
                                                <div class="form-group">
                                                    <input type="checkbox" data-toggle="tooltip" data-placement="top"
                                                        title="is highlighted" name="answer[is_highlighted]" value="1">

                                                </div>
                                                <hr>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <br />
                                            <h4 class="d-inline card-title">Text Romanji</h4>

                                            <span class="d-inline pull-right form-group">
                                                <i class="btn btn-sm btn-success mdi mdi-plus-box" id="addrmj"></i>
                                            </span>

                                            <div class="form-group" id="textrmj">
                                                <div class="form-group">
                                                    <textarea class="form-control" rows="3" name="answer[text]"
                                                        placeholder="answer indonesia"
                                                        required>{{ old('answer[text]') ?? @$answers->text_hiragana }}</textarea>
                                                </div>
                                                <div class="form-group">
                                                    <input type="checkbox" data-toggle="tooltip" data-placement="top"
                                                        title="is highlighted" name="answer[is_highlighted]" value="1">

                                                </div>
                                                <hr>
                                        </div>
                                    </div>

                                </div> --}}

                            </div>


                            <span class="form-group">
                                <br>
                                <button type="submit" class="btn btn-info btn-fw btn-lg mr-2">Submit</button>
                                <a href="{{ route('pattern-lesson-details.index') }}"
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
                    '"> <input type="text" name="highlights[]" class="form-control" placeholder="Highlight" aria-label="Highlight" aria-describedby="basic-addon2" required> <div class="input-group-append"> <button class="btn btn-sm btn-danger mdi mdi-minus-box btn_remove" type="button" id="' +
                    i + '"></button> </div> </div>');
            });

            $(document).on('click', '.btn_remove', function() {
                var button_id = $(this).attr("id");
                $('#rowfld' + button_id + '').remove();
            });

            $('#addfrml').click(function() {
                i++;
                $('#formula_field').append('<div class="input-group form-group" id="rowfrml' + i +
                    '"> <input type="text" name="formulas[]" class="form-control" placeholder="Formula Content" aria-label="Formula Content" aria-describedby="basic-addon2" required> <div class="input-group-append"> <button class="btn btn-sm btn-danger mdi mdi-minus-box btn_removefrml" type="button" id="' +
                    i + '"></button> </div> </div>');
            });

            $(document).on('click', '.btn_removefrml', function() {
                var button_id = $(this).attr("id");
                $('#rowfrml' + button_id + '').remove();
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
