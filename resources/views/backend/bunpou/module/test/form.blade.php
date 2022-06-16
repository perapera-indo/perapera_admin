@extends('layouts.master')
@php
    $title = @$data ? 'Edit' : 'Add New';
@endphp
@section('title', 'Bunpou Module Versi Test '.$title)
@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{ $title }} Bunpou Module Versi Test</h4>
                    <br>
                    <form class="forms-sample"
                          action="{{ @$data ? route('bunpou.module.test.update', $data->id) : route('bunpou.module.test.store') }}"
                          method="POST" enctype="multipart/form-data">
                        @csrf
                        @if(@$data)
                            <input type="hidden" name="_method" value="put">
                        @endif

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" class="form-control {{ hasErrorField($errors,'title') }}"
                                           id="title" name="title" value="{{ old('title',@$data->title) }}"
                                           placeholder="Title" required>
                                    {!! $errors->first('title', '<label class="help-block error-validation">:message</label>') !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="module">Module</label>
                                    <select name="module" id="module" class="form-control select2" required>
                                        <option value="">Select Room</option>
                                        @foreach (@$modules as $module)
                                            <option value="{{ $module->id }}"
                                                {{ $module->id == @$data->module ? 'selected' : '' }}>
                                                {{ $module->name }}</option>
                                        @endforeach
                                    </select>
                                    {!! $errors->first('module', '<label class="help-block error-validation">:message</label>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="time">Test Time</label>
                                    <input type="number" class="form-control {{ hasErrorField($errors,'time') }}"
                                           id="time" name="time" value="{{ old('time',@$data->time) }}"
                                           placeholder="Test Time" min="1" required>
                                    {!! $errors->first('time', '<label class="help-block error-validation">:message</label>') !!}
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-info btn-fw btn-lg mr-2">Submit</button>
                        <a href="{{ route('bunpou.module.test.index') }}" class="btn btn-secondary btn-fw btn-lg">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
