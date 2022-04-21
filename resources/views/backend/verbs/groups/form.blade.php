@extends('layouts.master')
@php
$title = @$data ? 'Edit' : 'Tambah';
@endphp
@section('title', 'Verb Group ' . $title)
@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ $title }} Verb Group</h4>
                        <br>
                        <form class="forms-sample"
                            action="{{ @$data ? route('verb-groups.update', $data->id) : route('verb-groups.store') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @if (@$data)
                                <input type="hidden" name="_method" value="put">
                            @endif
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control {{ hasErrorField($errors, 'name') }}"
                                            id="name" name="name" value="{{ old('name', @$data->name) }}"
                                            placeholder="Name">
                                        {!! $errors->first('name', '<label class="help-block error-validation">:message</label>') !!}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="master_verb_level_id">Level</label>
                                        <select name="master_verb_level_id" id="master_verb_level_id" class="form-control"
                                            required>
                                            <option value="">Select Verb Level</option>
                                            @foreach (@$levels as $level)
                                                <option value="{{ $level->id }}"
                                                    {{ $level->id == @$data->master_verb_level_id ? 'selected' : '' }}>
                                                    {{ $level->name }}</option>
                                            @endforeach
                                        </select>
                                        {!! $errors->first('master_verb_level_id', '<label class="help-block error-validation">:message</label>') !!}

                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="parent_id">Parent</label>
                                        <select name="parent_id" id="parent_id" class="form-control">
                                            <option value="">Select Verb Group Parent</option>
                                            @foreach (@$parents as $parent)
                                                <option value="{{ $parent->id }}"
                                                    {{ $parent->id == @$data->parent_id ? 'selected' : '' }}>
                                                    {{ $parent->name }}</option>
                                            @endforeach
                                        </select>
                                        {!! $errors->first('parent_id', '<label class="help-block error-validation">:message</label>') !!}

                                    </div>
                                </div>
                                <div class="col-md-3">
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
                            <a href="{{ route('verb-groups.index') }}" class="btn btn-secondary btn-fw btn-lg">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
