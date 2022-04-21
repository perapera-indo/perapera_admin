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
                            action="{{ @$data ? route('master-ability-courses.update', $data->id) : route('master-ability-courses.store') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @if (@$data)
                                <input type="hidden" name="_method" value="put">
                            @endif
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control {{ hasErrorField($errors, 'name') }}"
                                            id="name" name="name" value="{{ old('name', @$data->name) }}"
                                            placeholder="Name" required>
                                        {!! $errors->first('name', '<label class="help-block error-validation">:message</label>') !!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="learning_time">Learning Time</label>
                                        <input type="number" class="form-control {{ hasErrorField($errors, 'learning_time') }}"
                                            id="learning_time" name="learning_time" value="{{ old('learning_time', @$data->learning_time) }}"
                                            placeholder="Learning Time" required>
                                        {!! $errors->first('learning_time', '<label class="help-block error-validation">:message</label>') !!}
                                    </div>
                                </div>
                                </div>
                                <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="master_group_id">Group</label>
                                        <select name="master_group_id" id="master_group_id" class="form-control"
                                            required>
                                            <option value="">Select Group</option>
                                            @foreach (@$groups as $group)
                                                <option value="{{ $group->id }}"
                                                    {{ $group->id == @$data->master_group_id ? 'selected' : '' }}>
                                                    {{ $group->name }}</option>
                                            @endforeach
                                        </select>
                                        {!! $errors->first('master_group_id', '<label class="help-block error-validation">:message</label>') !!}

                                    </div>
                                </div>
                                <div class="col-md-6">
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
                            <a href="{{ route('master-ability-courses.index') }}"
                                class="btn btn-secondary btn-fw btn-lg">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
