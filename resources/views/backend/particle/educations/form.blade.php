@extends('layouts.master')
@php
$title = @$data ? 'Edit' : 'Add New';
@endphp
@section('title', 'Particle Education ' . $title)
@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ $title }} Particle Education</h4>
                        <br>
                        <form class="forms-sample"
                            action="{{ @$data ? route('particle-educations.update', $data->id) : route('particle-educations.store') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @if (@$data)
                                <input type="hidden" name="_method" value="put">
                            @endif
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="title">Title</label>
                                        <input type="text" class="form-control {{ hasErrorField($errors, 'title') }}"
                                            id="title" name="title" value="{{ old('title', @$data->title) }}"
                                            placeholder="Title">
                                        {!! $errors->first('title', '<label class="help-block error-validation">:message</label>') !!}
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea class="form-control" name="description" id="description" rows="4"
                                            placeholder="description" required
                                            value="">{{ old('description') ?? @$data->description }}</textarea>

                                        {!! $errors->first('description', '<label class="help-block error-validation">:message</label>') !!}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="letter_jpn">Letter Japan</label>
                                        <input type="text" class="form-control {{ hasErrorField($errors, 'letter_jpn') }}"
                                            id="letter_jpn" name="letter_jpn"
                                            value="{{ old('letter_jpn', @$data->letter_jpn) }}" placeholder="letter jpn">
                                        {!! $errors->first('letter_jpn', '<label class="help-block error-validation">:message</label>') !!}
                                    </div>
                                    <div class="form-group">
                                        <label for="letter_romanji">Letter Romanji</label>
                                        <input type="text"
                                            class="form-control {{ hasErrorField($errors, 'letter_romanji') }}"
                                            id="letter_romanji" name="letter_romanji"
                                            value="{{ old('letter_romanji', @$data->letter_romanji) }}"
                                            placeholder="letter romanji">
                                        {!! $errors->first('letter_romanji', '<label class="help-block error-validation">:message</label>') !!}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="particle_education_chapter_id">Education</label>
                                            <select name="particle_education_chapter_id" id="particle_education_chapter_id" class="form-control"
                                                required>
                                                <option value="">Select Education</option>
                                                @foreach (@$educations as $edu)
                                                    <option value="{{ $edu->id }}"
                                                        {{ $edu->id == @$data->particle_education_chapter_id ? 'selected' : '' }}>
                                                        {{ $edu->title }}</option>
                                                @endforeach
                                            </select>
                                            {!! $errors->first('particle_education_chapter_id', '<label class="help-block error-validation">:message</label>') !!}

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
                            <a href="{{ route('particle-educations.index') }}"
                                class="btn btn-secondary btn-fw btn-lg">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
