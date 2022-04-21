@extends('layouts.master')
@php
$title = @$data ? 'Edit' : 'Add New';
@endphp
@section('title', 'Kanji Education ' . $title)
@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ $title }} Kanji Education</h4>
                        <br>
                        <form class="forms-sample"
                            action="{{ @$data ? route('kanji-educations.update', $data->id) : route('kanji-educations.store') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @if (@$data)
                                <input type="hidden" name="_method" value="put">
                            @endif
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="kun_yomi">Kun Yomi</label>
                                        <input type="text" class="form-control {{ hasErrorField($errors, 'kun_yomi') }}"
                                            id="kun_yomi" name="kun_yomi" value="{{ old('kun_yomi', @$data->kun_yomi) }}"
                                            placeholder="kun yomi" required>
                                        {!! $errors->first('kun_yomi', '<label class="help-block error-validation">:message</label>') !!}
                                    </div>
                                    <div class="form-group">
                                        <label for="on_yomi">On Yomi</label>
                                        <input type="text" class="form-control {{ hasErrorField($errors, 'on_yomi') }}"
                                            id="on_yomi" name="on_yomi" value="{{ old('on_yomi', @$data->on_yomi) }}"
                                            placeholder="on yomi" required>
                                        {!! $errors->first('on_yomi', '<label class="help-block error-validation">:message</label>') !!}
                                    </div>
                                    <div class="form-group">
                                        <label for="scratches">Scratches</label>
                                        <input type="number" class="form-control {{ hasErrorField($errors, 'scratches') }}"
                                            id="scratches" name="scratches" value="{{ old('scratches', @$data->scratches) }}"
                                            placeholder="Scratches" required>
                                        {!! $errors->first('scratches', '<label class="help-block error-validation">:message</label>') !!}
                                    </div>

                                    <div class="form-group">
                                        <label for="kanji_chapter_id">Chapter</label>
                                        <select name="kanji_chapter_id" id="kanji_chapter_id" class="form-control">
                                            <option value="">Select Chapter</option>
                                            @foreach ($chapters as $chapter)
                                                <option value="{{ $chapter->id }}"
                                                    {{ $chapter->id == @$data->kanji_chapter_id ? 'selected' : '' }}>
                                                    {{ $chapter->name }}</option>
                                            @endforeach
                                        </select>
                                        {!! $errors->first('kanji_chapter_id', '<label class="help-block error-validation">:message</label>') !!}
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
                                <div class="col-md-6">
                                    <div class="form-group input-group">
                                        <label for="img_writing">Image Writing</label>
                                        <input type="file" class="form-control {{ hasErrorField($errors,'img_writing') }} dropify" data-errors-position="outside" name="img_writing" data-default-file="{{ env('CLOUD_S3_URL') . @$data->img_writing }}"
                                               data-height="200" data-max-file-size="2M" data-allowed-file-extensions="jpg jpeg png gif"  {{ ($type == 'new' ? 'required' : '') }}>
                                    </div>
                                    {!! $errors->first('img_writing', '<label class="help-block error-validation">:message</label>') !!}

                                    <div class="form-group input-group">
                                        <label for="img_illustration">Image Ilustration</label>
                                        <input type="file" class="form-control {{ hasErrorField($errors,'img_illustration') }} dropify" data-errors-position="outside" name="img_illustration" data-default-file="{{ env('CLOUD_S3_URL') . @$data->img_illustration }}"
                                               data-height="200" data-max-file-size="2M" data-allowed-file-extensions="jpg jpeg png gif"  {{ ($type == 'new' ? 'required' : '') }}>
                                    </div>
                                    {!! $errors->first('img_illustration', '<label class="help-block error-validation">:message</label>') !!}
                                </div>
                            </div>

                            <button type="submit" class="btn btn-info btn-fw btn-lg mr-2">Submit</button>
                            <a href="{{ route('kanji-educations.index') }}"
                                class="btn btn-secondary btn-fw btn-lg">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
