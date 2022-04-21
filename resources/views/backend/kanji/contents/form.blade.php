@extends('layouts.master')
@php
$title = @$data ? 'Edit' : 'Tambah';
@endphp
@section('title', 'Kanji Konten ' . $title)
@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ $title }} Kanji Kontent</h4>
                        <br>
                        <form class="forms-sample"
                            action="{{ @$data ? route('kanji-contents-update', [$data->kanji_chapter_id, $data->id]) : route('kanji-contents-store', request()->route('id')) }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @if (@$data)
                                <input type="hidden" name="_method" value="put">
                            @endif
                            <div class="row">

                                <input type="hidden" name="kanji_chapter_id" value="{{ request()->route('id') }}">
                                @if ($type != 'new')
                                    <input type="hidden" name="pattern_lesson_detail_id" value="{{ $data->id }}">
                                @endif

                                <div class="col-md-6 offset-md-3">
                                    <div class="form-group">
                                        <label for="first_name">Nama</label>
                                        <input type="text" class="form-control {{ hasErrorField($errors, 'name') }}"
                                            id="name" name="name" value="{{ old('name', @$data->name) }}"
                                            placeholder="Name">
                                        {!! $errors->first('name', '<label class="help-block error-validation">:message</label>') !!}
                                    </div>
                                    <div class="form-group input-group">
                                        <label for="exampleInputFile2">Gambar</label>
                                        <input type="file"
                                            class="form-control {{ hasErrorField($errors, 'image') }} dropify"
                                            data-errors-position="outside" name="image"
                                            data-default-file="{{ env('CLOUD_S3_URL') . @$data->image }}"
                                            data-height="200" data-max-file-size="2M"
                                            data-allowed-file-extensions="jpg jpeg png gif"
                                            {{ $type == 'new' ? 'required' : '' }}>
                                    </div>
                                    {!! $errors->first('image', '<label class="help-block error-validation">:message</label>') !!}


                                </div>

                            </div>

                            <button type="submit" class="btn btn-info btn-fw btn-lg mr-2">Submit</button>
                            <a href="{{ route('kanji-contents-index', request()->route('id')) }}"
                                class="btn btn-secondary btn-fw btn-lg">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
