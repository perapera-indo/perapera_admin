@extends('layouts.master')
@php
    $title = "Detail";
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
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control {{ hasErrorField($errors,'title') }}"
                                id="title" name="title" value="{{ old('title',@$data->title) }}"
                                placeholder="Title" readonly>
                    </div>

                    <div class="form-group">
                        <label for="desc">Description</label>
                        <textarea class="form-control" name="desc" id="desc" rows="4"
                            placeholder="desc" readonly
                            value="">{{ old('desc') ?? @$data->desc }}</textarea>

                        {!! $errors->first('desc', '<label class="help-block error-validation">:message</label>') !!}
                    </div>

                    <div class="row">
                        @if ($type=="image")
                            <div class="col-md-12">
                                <label for="path">Uploaded {{ ucfirst($type) }}</label>
                            </div>
                            <div class="col-md-12">
                                <img src="{{ asset($data->path) }}" style="max-height:300px;" />
                            </div>
                        @elseif ($type=="video")
                            <div class="col-md-12">
                                <label for="path">Uploaded {{ ucfirst($type) }}</label>
                            </div>
                            <div class="col-md-12">
                                <video controls style="max-height:300px;">
                                    <source src="{{ asset($data->path) }}" type="{{$mimetype}}">
                                </video>
                            </div>
                        @else
                            <div class="col-md-12">
                                <label for="path">No Image/Video Uploaded</label>
                            </div>
                        @endif
                    </div>

                    <br/>
                    <br/>
                    <a href="{{ route('room.index') }}" class="btn btn-info btn-fw btn-lg">Back</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
