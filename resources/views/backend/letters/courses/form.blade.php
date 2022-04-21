@extends('layouts.master')
@php
$title = @$data ? 'Edit' : 'Tambah';
@endphp
@section('title', 'Edukasi Huruf ' . $title)
@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ $title }} Versi Test</h4>
                        <br>
                        <form class="forms-sample"
                            action="{{ @$data ? route('letter-courses.update', $data->id) : route('letter-courses.store') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @if (@$data)
                                <input type="hidden" name="_method" value="put">
                            @endif
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="title">Nama</label>
                                        <input type="text" class="form-control {{ hasErrorField($errors, 'title') }}"
                                            id="title" name="title" value="{{ old('title', @$data->title) }}"
                                            placeholder="Nama">
                                        {!! $errors->first('title', '<label class="help-block error-validation">:message</label>') !!}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="test_time">Waktu Test</label>
                                        <input type="number" name="test_time" id="test_time" class="form-control"
                                            value="{{ old('test_time') ?? @$data->test_time }}" required>
                                        {!! $errors->first('test_time', '<label class="help-block error-validation">:message</label>') !!}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="letter_category_id">Tipe Huruf</label>
                                        <select name="letter_category_id" id="letter_category_id" class="form-control"
                                            required>
                                            <option value="">Pilih Tipe Huruf</option>
                                            @foreach (@$letterCats as $cat)
                                                <option value="{{ $cat->id }}"
                                                    {{ $cat->id == @$data->letter_category_id ? 'selected' : '' }}>
                                                    {{ $cat->name }}</option>
                                            @endforeach
                                        </select>
                                        {!! $errors->first('letter_category_id', '<label class="help-block error-validation">:message</label>') !!}

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
                                {{-- <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="letter_type">Tipe Huruf</label>
                                        <select name="letter_type" id="letter_type" class="form-control">
                                            <option {{ @$data->letter_type == "hiragana" ? 'selected' : '' }} value="1"> Hiragana
                                            </option>
                                            <option {{ @$data->letter_type == "katakana" ? 'selected' : '' }} value="0"> Katakana
                                            </option>
                                        </select>
                                        {!! $errors->first('letter_type', '<label class="help-block error-validation">:message</label>') !!}
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
                                </div> --}}


                            </div>

                            <button type="submit" class="btn btn-info btn-fw btn-lg mr-2">Submit</button>
                            <a href="{{ route('letter-courses.index') }}"
                                class="btn btn-secondary btn-fw btn-lg">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
