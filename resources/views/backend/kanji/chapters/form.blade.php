@extends('layouts.master')
@php
$title = @$data ? 'Edit' : 'Add New';
@endphp
@section('title', 'Kanji Chapter ' . $title)
@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ $title }} Kanji Chapter</h4>
                        <br>
                        <form class="forms-sample"
                            action="{{ @$data ? route('kanji-chapters.update', $data->id) : route('kanji-chapters.store') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @if (@$data)
                                <input type="hidden" name="_method" value="put">
                            @endif
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="first_name">Name</label>
                                        <input type="text" class="form-control {{ hasErrorField($errors, 'name') }}"
                                            id="name" name="name" value="{{ old('name', @$data->name) }}"
                                            placeholder="Name">
                                        {!! $errors->first('name', '<label class="help-block error-validation">:message</label>') !!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="master_group_id">Master Group</label>
                                        <select name="master_group_id" id="master_group_id" class="form-control">
                                            <option value="">Select Master Group</option>
                                            @foreach ($groups as $group)
                                                <option value="{{ $group->id }}"
                                                    {{ $group->id == @$data->master_group_id ? 'selected' : '' }}>
                                                    {{ $group->name }}</option>
                                            @endforeach
                                        </select>
                                        {!! $errors->first('master_group_id', '<label class="help-block error-validation">:message</label>') !!}
                                    </div>
                                </div>
                                {{-- <div class="col-md-6">
                                    <div class="form-group input-group">
                                        <label for="exampleInputFile2">Image</label>
                                        <input type="file" class="form-control {{ hasErrorField($errors,'image') }} dropify" data-errors-position="outside" name="image" data-default-file="{{ env('CLOUD_S3_URL') . @$data->image }}"
                                               data-height="200" data-max-file-size="2M" data-allowed-file-extensions="jpg jpeg png gif"  {{ ($type == 'new' ? 'required' : '') }}>
                                    </div>
                                    {!! $errors->first('image', '<label class="help-block error-validation">:message</label>') !!}
                                </div> --}}
                            </div>

                            <button type="submit" class="btn btn-info btn-fw btn-lg mr-2">Submit</button>
                            <a href="{{ route('kanji-chapters.index') }}"
                                class="btn btn-secondary btn-fw btn-lg">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
