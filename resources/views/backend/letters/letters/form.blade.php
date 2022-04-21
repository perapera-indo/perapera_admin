@extends('layouts.master')
@php
$title = @$data ? 'Edit' : 'Tambah';
@endphp
@section('title', 'Letter ' . $title)
@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ $title }} Huruf</h4>
                        <br>
                        <form class="forms-sample"
                            action="{{ @$data ? route('letters.update', $data->id) : route('letters.store') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @if (@$data)
                                <input type="hidden" name="_method" value="put">
                            @endif
                            <div class="row">
                                <div class="col-md-6">

                                    <div class="form-group">
                                        <label for="letter">Letter</label>
                                        <input type="text" name="letter" id="letter" class="form-control"
                                            value="{{ old('letter') ?? @$data->letter }}" required>

                                        {!! $errors->first('letter', '<label class="help-block error-validation">:message</label>') !!}
                                    </div>

                                    <div class="form-group">
                                        <label for="romanji">Romanji</label>
                                        <input type="text" name="romanji" id="romanji" class="form-control"
                                            value="{{ old('romanji') ?? @$data->romanji }}" required>

                                        {!! $errors->first('romanji', '<label class="help-block error-validation">:message</label>') !!}
                                    </div>

                                    <div class="form-group">
                                        <label for="total_stroke">Total Stoke</label>
                                        <input type="number" name="total_stroke" id="total_stroke" class="form-control"
                                            value="{{ old('total_stroke') ?? @$data->total_stroke }}" required>


                                        {!! $errors->first('total_stroke', '<label class="help-block error-validation">:message</label>') !!}
                                    </div>

                                    <div class="form-group">
                                        <label for="category">Category</label>
                                        <select name="category" id="category" class="form-control" required>
                                            <option value="">Select Category</option>
                                            @foreach (@$letterCats as $cat)
                                                <option value="{{ $cat->id }}"
                                                    {{ $cat->id == @$data->letter_category_id ? 'selected' : '' }}>
                                                    {{ $cat->name }}</option>
                                            @endforeach
                                        </select>
                                        {!! $errors->first('category', '<label class="help-block error-validation">:message</label>') !!}

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
                                        <label for="exampleInputFile">Image</label>
                                        <input type="file" class="form-control {{ hasErrorField($errors,'image_url') }} dropify" data-errors-position="outside" name="image_url" data-default-file="{{ env('CLOUD_S3_URL') . @$data->image_url }}"
                                               data-height="150" data-max-file-size="5M" data-allowed-file-extensions="jpg jpeg png gif">
                                    </div>
                                    {!! $errors->first('image_url', '<label class="help-block error-validation">:message</label>') !!}

                                    <div class="form-group input-group">
                                        <label for="exampleInputFile2">Color Image</label>
                                        <input type="file" class="form-control {{ hasErrorField($errors,'color_image_url') }} dropify" data-errors-position="outside" name="color_image_url" data-default-file="{{ env('CLOUD_S3_URL') . @$data->color_image_url }}"
                                               data-height="150" data-max-file-size="5M" data-allowed-file-extensions="jpg jpeg png gif">
                                    </div>
                                    {!! $errors->first('color_image_url', '<label class="help-block error-validation">:message</label>') !!}
                                </div>
                            </div>

                            <button type="submit" class="btn btn-info btn-fw btn-lg mr-2">Submit</button>
                            <a href="{{ request()->route('letter_category_id') == 1 ? route('letter-hiragana-list')  : route('letter-katakana-list')  }}"
                                class="btn btn-secondary btn-fw btn-lg">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
