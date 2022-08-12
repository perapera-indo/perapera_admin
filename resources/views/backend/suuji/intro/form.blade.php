@extends('layouts.master')
@php
    $title = @$data ? 'Edit' : 'Add New';
@endphp
@section('title', 'Suuji Introduction '.$title)
@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{ $title }} Suuji Introduction</h4>
                    <br>
                    <form class="forms-sample"
                          action="{{ @$data ? route('suuji.intro.update', $data->id) : route('suuji.intro.store') }}"
                          method="POST" enctype="multipart/form-data">
                        @csrf
                        @if(@$data)
                            <input type="hidden" name="_method" value="put">
                        @endif

                        <div class="form-group">
                            <label for="room">Room</label>
                            <select name="room" id="room" class="form-control select2" required>
                                <option value="">Select Room</option>
                                @foreach (@$rooms as $room)
                                    <option value="{{ $room->id }}"
                                        {{ $room->id == @$data->room ? 'selected' : '' }}>
                                        {{ $room->title }}</option>
                                @endforeach
                            </select>
                            {!! $errors->first('room', '<label class="help-block error-validation">:message</label>') !!}
                        </div>

                        <div class="form-group">
                            <label for="page">Page</label>
                            <input type="number" class="form-control {{ hasErrorField($errors,'page') }}"
                                   id="page" name="page" value="{{ old('page',@$data->page) }}"
                                   placeholder="Page" min="1" required>
                            {!! $errors->first('page', '<label class="help-block error-validation">:message</label>') !!}
                        </div>

                        <button type="submit" class="btn btn-info btn-fw btn-lg mr-2">Submit</button>
                        <a href="{{ route('suuji.intro.index') }}" class="btn btn-secondary btn-fw btn-lg">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
