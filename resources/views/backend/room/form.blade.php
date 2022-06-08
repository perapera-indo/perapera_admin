@extends('layouts.master')
@php
    $title = @$data ? 'Edit' : 'Add New';
@endphp
@section('title', 'Room '.$title)
@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{ $title }} Room</h4>
                    <br>
                    <form class="forms-sample"
                          action="{{ @$data ? route('room.update', $data->id) : route('room.store') }}"
                          method="POST" enctype="multipart/form-data">
                        @csrf
                        @if(@$data)
                            <input type="hidden" name="_method" value="put">
                        @endif

                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control {{ hasErrorField($errors,'title') }}"
                                   id="title" name="title" value="{{ old('title',@$data->title) }}"
                                   placeholder="Title" required>
                            {!! $errors->first('title', '<label class="help-block error-validation">:message</label>') !!}
                        </div>

                        <div class="form-group">
                            <label for="desc">Description</label>
                            <textarea class="form-control" name="desc" id="desc" rows="4"
                                placeholder="desc" required
                                value="">{{ old('desc') ?? @$data->desc }}</textarea>

                            {!! $errors->first('desc', '<label class="help-block error-validation">:message</label>') !!}
                        </div>

                        <div class="form-group">
                            <div class="input-group col-xs-12">
                                <label for="path">Upload Image / Video</label>
                                <input type="file" class="form-control {{ hasErrorField($errors,'path') }} dropify" data-errors-position="outside" name="path" data-default-file="{{ @get_file(@$data->path) }}"
                                    data-allowed-file-extensions="jpg jpeg png gif mp4 mkv webm flv">
                            </div>
                            {!! $errors->first('path', '<label class="help-block error-validation">:message</label>') !!}
                        </div>

                        <button type="submit" class="btn btn-info btn-fw btn-lg mr-2">Submit</button>
                        <a href="{{ route('room.index') }}" class="btn btn-secondary btn-fw btn-lg">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
