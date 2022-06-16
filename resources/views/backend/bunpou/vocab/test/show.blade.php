@extends('layouts.master')
@php
    $title = "Detail";
@endphp
@section('title', 'Module '.$title)
@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{ $title }} Module</h4>
                    <br>
                    <div class="form-group">
                        <label for="name">Module Name</label>
                        <input type="text" class="form-control {{ hasErrorField($errors,'name') }}"
                                id="name" name="name" value="{{ old('name',@$data->name) }}"
                                placeholder="Module Name" readonly>
                    </div>

                    <div class="form-group">
                        <label for="order">Order</label>
                        <input type="text" class="form-control {{ hasErrorField($errors,'order') }}"
                                id="order" name="order" value="{{ old('order',@$data->order) }}"
                                placeholder="Order" readonly>
                    </div>

                    <br/>
                    <br/>
                    <a href="{{ route('bunpou.module.index') }}" class="btn btn-info btn-fw btn-lg">Back</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
