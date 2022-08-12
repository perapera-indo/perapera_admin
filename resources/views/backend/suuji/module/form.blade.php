@extends('layouts.master')
@php
    $title = @$data ? 'Edit' : 'Add New';
@endphp
@section('title', 'Suuji Module '.$title)
@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{ $title }} Suuji Module</h4>
                    <br>
                    <form class="forms-sample"
                          action="{{ @$data ? route('suuji.module.update', $data->id) : route('suuji.module.store') }}"
                          method="POST" enctype="multipart/form-data">
                        @csrf
                        @if(@$data)
                            <input type="hidden" name="_method" value="put">
                        @endif

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Module Name</label>
                                    <input type="text" class="form-control {{ hasErrorField($errors,'name') }}"
                                           id="name" name="name" value="{{ old('name',@$data->name) }}"
                                           placeholder="Module Name" required>
                                    {!! $errors->first('name', '<label class="help-block error-validation">:message</label>') !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="order">Order</label>
                                    <input type="number" class="form-control {{ hasErrorField($errors,'order') }}"
                                           id="order" name="order" value="{{ old('order',@$data->order) }}"
                                           placeholder="Order" min="1" required>
                                    {!! $errors->first('order', '<label class="help-block error-validation">:message</label>') !!}
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-info btn-fw btn-lg mr-2">Submit</button>
                        <a href="{{ route('suuji.module.index') }}" class="btn btn-secondary btn-fw btn-lg">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
