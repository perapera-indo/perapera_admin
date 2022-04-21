@extends('layouts.master')
@php
$title = @$data ? 'Edit' : 'Add New';
@endphp
@section('title', 'Ability Course Chapter ' . $title)
@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ $title }} Ability Course Chapter</h4>
                        <br>
                        <form class="forms-sample"
                            action="{{ @$data ? route('ability-course-chapters.update', $data->id) : route('ability-course-chapters.store') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @if (@$data)
                                <input type="hidden" name="_method" value="put">
                            @endif
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="name">name</label>
                                        <input type="text" class="form-control {{ hasErrorField($errors, 'name') }}"
                                            id="name" name="name" value="{{ old('name', @$data->name) }}"
                                            placeholder="Name" required>
                                        {!! $errors->first('name', '<label class="help-block error-validation">:message</label>') !!}
                                    </div>

                                    <div class="form-group">
                                        <label for="chapter_desc">Chapter Description</label>
                                        <textarea class="form-control" rows="3"
                                            name="chapter_desc"
                                            placeholder="Chapter Description"
                                            required>{{ @$data->chapter_desc ?  @$data->chapter_desc : old('chapter_desc', @$data->name)}}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="master_group_id">Master Group</label>
                                        <select name="master_group_id" id="master_group_id" class="form-control"
                                            required>
                                            <option value="">Select Master Group</option>
                                            @foreach (@$groups as $group)
                                                <option value="{{ $group->id }}"
                                                    {{ $group->id == @$data->master_group_id ? 'selected' : '' }}>
                                                    {{ $group->name }}</option>
                                            @endforeach
                                        </select>
                                        {!! $errors->first('master_group_id', '<label class="help-block error-validation">:message</label>') !!}

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
                            <a href="{{ route('ability-course-chapters.index') }}"
                                class="btn btn-secondary btn-fw btn-lg">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
