@extends('layouts.master')
@php
$title = @$data ? 'Edit' : 'Tambah';
@endphp
@section('title', 'Partikel Detail' . $title)
@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ $title }} Partikel Detail</h4>
                        <br>
                        <form class="forms-sample"
                            action="{{ @$data ? route('particle-education-details.update', $data->id) : route('particle-education-details.store') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @if (@$data)
                                <input type="hidden" name="_method" value="put">
                            @endif
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="sentence_jpn">Sentence Japan</label>
                                        <textarea class="form-control" name="sentence_jpn" id="sentence_jpn" rows="4"
                                            placeholder="sentence Japan" required
                                            value="">{{ old('sentence_jpn') ?? @$data->sentence_jpn }}</textarea>
                                        {!! $errors->first('sentence_jpn', '<label class="help-block error-validation">:message</label>') !!}
                                    </div>

                                    <div class="form-group">
                                        <label for="sentence_romanji">Sentence Romanji</label>
                                        <textarea class="form-control" name="sentence_romanji" id="sentence_romanji"
                                            rows="4" placeholder="sentence romanji" required
                                            value="">{{ old('sentence_romanji') ?? @$data->sentence_romanji }}</textarea>
                                        {!! $errors->first('sentence_romanji', '<label class="help-block error-validation">:message</label>') !!}
                                    </div>

                                    <div class="form-group">
                                        <label for="sentence_idn">Sentence Indonesia</label>
                                        <textarea class="form-control" name="sentence_idn" id="sentence_idn" rows="4"
                                            placeholder="sentence Indonesia" required
                                            value="">{{ old('sentence_idn') ?? @$data->sentence_idn }}</textarea>
                                        {!! $errors->first('sentence_idn', '<label class="help-block error-validation">:message</label>') !!}
                                    </div>

                                    <div class="form-group">
                                        <label for="particle_education_id">Particle Education</label>
                                        <select name="particle_education_id" id="particle_education_id" class="form-control"
                                            required>
                                            <option value="">Select Particle Education</option>
                                            @foreach ($educations as $education)
                                                <option value="{{ $education->id }}"
                                                    {{ $education->id == @$data->particle_education_id ? 'selected' : '' }}>
                                                    {{ $education->title }}</option>
                                            @endforeach
                                        </select>
                                        {!! $errors->first('particle_education_id', '<label class="help-block error-validation">:message</label>') !!}
                                    </div>


                                </div>
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-6">

                                            <div class="form-group">
                                                <label for="formula">Formula</label>
                                                <textarea class="form-control" name="formula" id="formula" rows="4"
                                                    placeholder="formula" required
                                                    value="">{{ old('formula') ?? @$data->formula }}</textarea>

                                                {!! $errors->first('formula', '<label class="help-block error-validation">:message</label>') !!}
                                            </div>

                                            <div class="form-group">
                                                <label for="is_active">Status</label>
                                                <select name="is_active" id="is_active" class="form-control">
                                                    <option {{ @$data->is_active == 1 ? 'selected' : '' }} value="1">
                                                        active
                                                    </option>
                                                    <option {{ @$data->is_active == 0 ? 'selected' : '' }} value="0">
                                                        inactive
                                                    </option>
                                                </select>
                                                {!! $errors->first('is_active', '<label class="help-block error-validation">:message</label>') !!}
                                            </div>

                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group input-group">
                                                <label for="exampleInputFile">Gambar</label>
                                                <input type="file"
                                                    class="form-control {{ hasErrorField($errors, 'sentence_img') }} dropify"
                                                    data-errors-position="outside" name="sentence_img"
                                                    data-default-file="{{ env('CLOUD_S3_URL') . @$data->sentence_img }}"
                                                    data-height="150" data-max-file-size="4M"
                                                    data-allowed-file-extensions="jpg jpeg png gif"
                                                    {{ @$type == 'new' ? 'required' : '' }}>
                                            </div>
                                            {!! $errors->first('sentence_img', '<label class="help-block error-validation">:message</label>') !!}
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="sentence_description">Sentence Description</label>
                                                <textarea class="form-control my-editor" name="sentence_description"
                                                    id="sentence_description" rows="4" placeholder="sentence Description"
                                                    value="">{{ old('sentence_description') ?? @$data->sentence_description }}</textarea>
                                                {!! $errors->first('sentence_description', '<label class="help-block error-validation">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                {{-- <textarea name="content" class="form-control my-editor"></textarea> --}}
                            </div>

                            <button type="submit" class="btn btn-info btn-fw btn-lg mr-2">Submit</button>
                            <a href="{{ route('particle-education-details.index') }}"
                                class="btn btn-secondary btn-fw btn-lg">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
    <script>
        var editor_config = {
            path_absolute: "/",
            selector: "textarea.my-editor",
            plugins: [
                "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars code fullscreen",
                "insertdatetime media nonbreaking save table contextmenu directionality",
                "emoticons template paste textcolor colorpicker textpattern"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
            relative_urls: false,
            file_browser_callback: function(field_name, url, type, win) {
                var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName(
                    'body')[0].clientWidth;
                var y = window.innerHeight || document.documentElement.clientHeight || document
                    .getElementsByTagName('body')[0].clientHeight;

                var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
                if (type == 'image') {
                    cmsURL = cmsURL + "&type=Images";
                } else {
                    cmsURL = cmsURL + "&type=Files";
                }

                tinyMCE.activeEditor.windowManager.open({
                    file: cmsURL,
                    title: 'Filemanager',
                    width: x * 0.8,
                    height: y * 0.8,
                    resizable: "yes",
                    close_previous: "no"
                });
            }
        };

        tinymce.init(editor_config);
    </script>
@endsection
