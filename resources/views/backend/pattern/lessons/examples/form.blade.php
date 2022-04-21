@extends('layouts.master')
@php
$title = @$data ? 'Edit' : 'Add New';
@endphp
@section('title', 'Pattern Lesson Detail Example' . $title)
@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ $title }} Pattern Lesson Detail Example</h4>
                        <br>
                        <form class="forms-sample"
                            action="{{ @$data ? route('pattern-lesson-details.update', $data->id) : route('lesson-detail-example-post', [request()->route('id'), request()->route('did')]) }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @if (@$data)
                                <input type="hidden" name="_method" value="put">
                            @endif
                            <div class="row">
                                {{-- <div class="col-md-12">
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
                                </div> --}}

                                <input type="hidden" name="pattern_lesson_id" value="{{ request()->route('id') }}">
                                <input type="hidden" name="pattern_lesson_detail_id"
                                    value="{{ request()->route('did') }}">

                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group input-group">
                                                <label for="exampleInputFile2">Image</label>
                                                <input type="file"
                                                    class="form-control {{ hasErrorField($errors, 'img') }} dropify"
                                                    data-errors-position="outside" name="img"
                                                    data-default-file="{{ env('CLOUD_S3_URL') . @$data->img }}"
                                                    data-height="100" data-max-file-size="2M"
                                                    data-allowed-file-extensions="jpg jpeg png gif">
                                            </div>
                                            {!! $errors->first('img', '<label class="help-block error-validation">:message</label>') !!}
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="text_idn">Text Indonesia</label>
                                                <textarea class="form-control" name="text_idn" id="text_idn" rows="6"
                                                    placeholder="Text Indonesia" required
                                                    value="">{{ old('text_idn') ?? @$data->text_idn }}</textarea>

                                                {!! $errors->first('text_idn', '<label class="help-block error-validation">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <br />
                                            <h4 class="d-inline card-title">Text Example Japan</h4>
                                            <span class="d-inline pull-right form-group">
                                                <i class="btn btn-sm btn-success mdi mdi-plus-box" id="addjpn"></i>
                                            </span>
                                            @php
                                                $i = 0;
                                            @endphp
                                            <div class="form-group" id="textjpn">
                                                <div class="form-group">
                                                    <textarea class="form-control" rows="3"
                                                        name="example_japans[{{ $i }}][text_kanji]"
                                                        placeholder="Text Kanji"
                                                        required>{{ old('example_japans[][text_kanji]') }}</textarea>
                                                </div>
                                                <div class="form-group">
                                                    <textarea class="form-control" rows="3"
                                                        name="example_japans[{{ $i }}][text_idn]"
                                                        placeholder="Text Indonesia"
                                                        required>{{ old('example_japans[][text_idn]') }}</textarea>
                                                </div>
                                                <div class="form-group">
                                                    <textarea class="form-control" rows="3"
                                                        name="example_japans[{{ $i }}][text_hiragana]"
                                                        placeholder="Text Hiragana"
                                                        required>{{ old('example_japans[][text_hiragana]') }}</textarea>
                                                </div>
                                                <div class="form-group">
                                                    <input type="checkbox" data-toggle="tooltip" data-placement="top"
                                                        class="jpcheckbox" title="is highlighted"
                                                        name="example_japans[{{ $i }}][is_highlighted]"
                                                        value="1" checked>
                                                </div>
                                                <hr>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <br />
                                            <h4 class="d-inline card-title">Text Example Romanji</h4>

                                            <span class="d-inline pull-right form-group">
                                                <i class="btn btn-sm btn-success mdi mdi-plus-box" id="addrmj"></i>
                                            </span>
                                            @php
                                                $r = 0;
                                            @endphp
                                            <div class="form-group" id="textrmj">
                                                <div class="form-group">
                                                    <textarea class="form-control" rows="3" name="example_romanjis[{{$r}}][text]"
                                                        placeholder="Text Hiragana"
                                                        required>{{ old('example_romanjis[text]') }}</textarea>
                                                </div>
                                                <div class="form-group">
                                                    <input type="checkbox" data-toggle="tooltip" data-placement="top"
                                                        class="rmjcheckbox" title="is highlighted"
                                                        name="example_romanjis[{{$r}}][is_highlighted]" value="1" checked>

                                                </div>
                                                <hr>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <span class="form-group">
                                    <br>
                                    <button type="submit" class="btn btn-info btn-fw btn-lg mr-2">Submit</button>
                                    <a href="{{ route('lesson-detail-example-post', [request()->route('id'), request()->route('did')]) }}"
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

            $('#addjpn').click(function() {
                i++;
                $('#textjpn').append('<span id="rowjpn' + i +
                    '"><div class="form-group" > <textarea class="form-control" rows="3" name="example_japans[' +
                    i +
                    '][text_kanji]" placeholder="Text Kanji" required>{{ old('example_japans[][text_kanji]') }}</textarea> </div> <div class="form-group"> <textarea class="form-control" rows="3" name="example_japans[' +
                    i +
                    '][text_idn]" placeholder="Text Indonesia" required>{{ old('example_japans[text_idn]') }}</textarea> </div> <div class="form-group"> <textarea class="form-control" rows="3" name="example_japans[' +
                    i +
                    '][text_hiragana]" placeholder="Text Hiragana" required>{{ old('example_japans[][text_hiragana]') }}</textarea> </div> <div class="form-group"> <input type="checkbox" class="jpcheckbox" data-toggle="tooltip" data-placement="top" title="is highlighted" name="example_japans[' +
                    i +
                    '][is_highlighted]" value="1">  </div> <button class="btn btn-sm btn-danger mdi mdi-minus-box btn_removejpn" type="button" id="' +
                    i + '"></button><hr> </span>');
            });

            $(document).on('click', '.btn_removejpn', function() {
                var button_id = $(this).attr("id");
                $('#rowjpn' + button_id + '').remove();
            });

            $('#addrmj').click(function() {
                i++;
                $('#textrmj').append('<span id="rowrmj' + i +
                    '"><div class="form-group"> <textarea class="form-control" rows="3" name="example_romanjis[' +
                    i +
                    '][text]" placeholder="Text Hiragana" required>{{ old('example_romanjis[][text]') }}</textarea> </div> <div class="form-group">  <input type="checkbox"  data-toggle="tooltip" data-placement="top" class="rmjcheckbox" title="is highlighted" name="example_romanjis[' +
                    i +
                    '][is_highlighted]" value="1"> </div> <button class="btn btn-sm btn-danger mdi mdi-minus-box btn_removermj" type="button" id="' +
                    i + '"></button> <hr> </span>');
            });

            $(document).on('click', '.btn_removermj', function() {
                var button_id = $(this).attr("id");
                $('#rowrmj' + button_id + '').remove();
            });

            $(document).on('click', 'input[type="checkbox"].jpcheckbox', function() {
                $('input[type="checkbox"].jpcheckbox').not(this).prop('checked', false);
            });

            $(document).on('click', 'input[type="checkbox"].rmjcheckbox', function() {
                $('input[type="checkbox"].rmjcheckbox').not(this).prop('checked', false);
            });
        });

    </script>
@endsection
