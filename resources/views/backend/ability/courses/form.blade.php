@extends('layouts.master')
@php
$title = @$data ? 'Edit' : 'Add New';
@endphp
@section('title', 'Ability Course ' . $title)
@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ $title }} Ability Course</h4>
                        <br>
                        <form class="forms-sample"
                            action="{{ @$data ? route('ability-courses.update', $data->id) : route('ability-courses.store') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @if (@$data)
                                <input type="hidden" name="_method" value="put">
                            @endif
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="title">Title</label>
                                        <input type="text" class="form-control {{ hasErrorField($errors, 'title') }}"
                                            id="title" name="title" value="{{ old('title', @$data->title) }}"
                                            placeholder="Title">
                                        {!! $errors->first('title', '<label class="help-block error-validation">:message</label>') !!}
                                    </div>

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
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="ability_course_chapter_id">Ability Course Chapter</label>
                                        <select name="ability_course_chapter_id" id="ability_course_chapter_id" class="form-control"
                                            required>
                                            <option value="">Select Ability Course Chapter</option>
                                            @foreach (@$chapters as $chapter)
                                                <option value="{{ $chapter->id }}"
                                                    {{ $chapter->id == @$data->ability_course_chapter_id ? 'selected' : '' }}>
                                                    {{ $chapter->name }}</option>
                                            @endforeach
                                        </select>
                                        {!! $errors->first('ability_course_chapter_id', '<label class="help-block error-validation">:message</label>') !!}

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
                            <a href="{{ route('ability-courses.index') }}"
                                class="btn btn-secondary btn-fw btn-lg">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
