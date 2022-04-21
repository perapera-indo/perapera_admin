@extends('layouts.master')
@php
$title = @$data ? 'Edit' : 'Tambah';
@endphp
@section('title', 'Bab Kosakata ' . $title)
@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ $title }} Bab Kosakata</h4>
                        <br>
                        <form class="forms-sample"
                            action="{{ @$data ? route('vocabulary-chapters.update', $data->id) : route('vocabulary-chapters.store') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @if (@$data)
                                <input type="hidden" name="_method" value="put">
                            @endif

                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Nama</label>
                                        <input type="text" name="name" id="name" class="form-control"
                                            value="{{ old('name') ?? @$data->name }}" required>

                                        {!! $errors->first('name', '<label class="help-block error-validation">:message</label>') !!}
                                    </div>

                                    <div class="form-group">
                                        <label for="category">Pilih Group</label>
                                        <select name="master_group_id" id="master_group_id" class="form-control" required>
                                            <option value="">Pilih Group</option>
                                            @foreach ($groups as $group)
                                                <option value="{{ $group->id }}"
                                                    {{ @$group->id == @$data->master_group_id ? 'selected' : '' }}>
                                                    {{ $group->name }}</option>
                                            @endforeach
                                        </select>
                                        {!! $errors->first('master_group_id', '<label class="help-block error-validation">:message</label>') !!}
                                    </div>

                                    <div class="form-group">
                                        <label for="is_active">Status</label>
                                        <select name="is_active" id="status" class="form-control">
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
                                        <label for="exampleInputFile">Ilustrasi</label>
                                        <input type="file"
                                            class="form-control {{ hasErrorField($errors, 'img') }} dropify"
                                            data-errors-position="outside" name="img"
                                            data-default-file="{{ env('CLOUD_S3_URL') . @$data->img }}" data-height="150"
                                            data-max-file-size="3M" data-allowed-file-extensions="jpg jpeg png gif">
                                    </div>
                                    {!! $errors->first('img', '<label class="help-block error-validation">:message</label>') !!}
                                </div>

                            </div>

                            <button type="submit" class="btn btn-info btn-fw btn-lg mr-2">Submit</button>
                            <a href="{{ route('vocabulary-chapters.index') }}"
                                class="btn btn-secondary btn-fw btn-lg">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
