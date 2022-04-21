@extends('layouts.master')
@php
    $title = @$data ? 'Edit' : 'Add New';
@endphp
@section('title', 'User Availability '.$title)
@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{ $title }} User Availability</h4>
                    <br>
                    <form class="forms-sample"
                          action="{{ @$data ? route('user-availability-date.update',['id' => $data->id]) : route('user-availability-date.store') }}"
                          method="POST" enctype="multipart/form-data">
                        @csrf
                        @if(@$data)
                            <input type="hidden" name="_method" value="put">
                        @endif
                        <div class="form-group">
                            <label for="first_name">Name</label>
                            <input type="text" class="form-control {{ hasErrorField($errors,'name') }}"
                                   id="name" name="name" value="{{ user_info('first_name').' '.user_info('last_name') }}"
                                   placeholder="Name" readonly>
                            {!! $errors->first('name', '<label class="help-block error-validation">:message</label>') !!}
                        </div>

                        <div class="form-group">
                            @php
                                $date = null;
                                if(@$data->start_date){
                                    $date = create_date_from_format(@$data->start_date,'Y-m-d H:i:s')->format('d-m-Y H:i');
                                }
                            @endphp
                            <label for="name">Start Date</label>
                            <input type="text" name="start_date" class="form-control {{ hasErrorField($errors,'deadline') }} datetimepicker" id="start_date" autocomplete="off"
                                   value="{{ old('start_date',$date) }}" placeholder="Enter Date">
                            {!! $errors->first('start_date', '<label class="help-block error-validation" id="msg_start_date">:message</label>') !!}
                        </div>

                        <div class="form-group">
                            @php
                                $date = null;
                                if(@$data->end_date){
                                    $date = create_date_from_format(@$data->end_date,'Y-m-d H:i:s')->format('d-m-Y H:i');
                                }
                            @endphp
                            <label for="name">End Date</label>
                            <input type="text" name="end_date" class="form-control {{ hasErrorField($errors,'end_date') }} datetimepicker" id="end_date" autocomplete="off"
                                   value="{{ old('end_date',$date) }}" placeholder="Enter Date">
                            {!! $errors->first('end_date', '<label class="help-block error-validation" id="msg_end_date">:message</label>') !!}
                        </div>

                        <button type="submit" class="btn btn-info btn-fw btn-lg mr-2">Submit</button>
                        <a href="{{ route($role.'.availability.index') }}" class="btn btn-secondary btn-fw btn-lg">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
