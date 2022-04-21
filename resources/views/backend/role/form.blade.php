@extends('layouts.master')
@php
    $title = @$data ? 'Edit' : 'Add New';
@endphp
@section('title', 'Role '.$title)
@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{ $title }} Role</h4>
                    <br>
                    <form class="forms-sample"
                          action="{{ @$data ? route('role.update',['id' => $data->id]) : route('role.store') }}"
                          method="POST" enctype="multipart/form-data">
                        @csrf
                        @if(@$data)
                            <input type="hidden" name="_method" value="put">
                        @endif
                        <div class="form-group">
                            <label for="first_name">Name</label>
                            <input type="text" class="form-control {{ hasErrorField($errors,'name') }}"
                                   id="name" name="name" value="{{ old('first_name',@$data->name) }}"
                                   placeholder="Name">
                            {!! $errors->first('name', '<label class="help-block error-validation">:message</label>') !!}
                        </div>
                        <button type="submit" class="btn btn-info btn-fw btn-lg mr-2">Submit</button>
                        <a href="{{ route('role.index') }}" class="btn btn-secondary btn-fw btn-lg">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
