@extends('layouts.master')
@php
    $title = @$data ? 'Edit' : 'Add New';
@endphp
@section('title', $module->name.' Test '.$title)
@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{ $title }} {{$module->name}} Test</h4>
                    <br>
                    <form class="forms-sample"
                          action="{{ @$data ? route('bunpou.module.test.update', $data->id) : route('bunpou.module.test.store',$module->id) }}"
                          method="POST" enctype="multipart/form-data">
                        @csrf
                        @if(@$data)
                            <input type="hidden" name="_method" value="put">
                        @endif

                        <input type="hidden" name="module" value="<?=$module->id?>">

                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control {{ hasErrorField($errors,'title') }}"
                                   id="title" name="title" value="{{ old('title',@$data->title) }}"
                                   placeholder="Title" required>
                            {!! $errors->first('title', '<label class="help-block error-validation">:message</label>') !!}
                        </div>

                        <div class="form-group">
                            <label for="time">Test Time</label>
                            <input type="number" class="form-control {{ hasErrorField($errors,'time') }}"
                                   id="time" name="time" value="{{ old('time',@$data->time) }}"
                                   placeholder="Test Time" min="1" required>
                            {!! $errors->first('time', '<label class="help-block error-validation">:message</label>') !!}
                        </div>

                        <div class="form-group">
                            <label for="order">Order</label>
                            <input type="number" class="form-control {{ hasErrorField($errors,'order') }}"
                                   id="order" name="order" value="{{ old('order',@$data->order) }}"
                                   placeholder="Order" min="1" required>
                            {!! $errors->first('order', '<label class="help-block error-validation">:message</label>') !!}
                        </div>

                        <button type="submit" class="btn btn-info btn-fw btn-lg mr-2">Submit</button>
                        <a href="{{ route('bunpou.module.index') }}" class="btn btn-secondary btn-fw btn-lg">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
