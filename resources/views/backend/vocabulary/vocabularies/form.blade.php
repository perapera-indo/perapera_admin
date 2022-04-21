@extends('layouts.master')
@php
$title = @$data ? 'Edit' : 'Tambah';
@endphp
@section('title', 'Kosakata ' . $title)
@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ $title }}  Kosakata</h4>
                        <br>
                        <form class="forms-sample"
                            action="{{ @$data ? route('vocabularies.update', $data->id) : route('vocabularies.store') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @if (@$data)
                                <input type="hidden" name="_method" value="put">
                            @endif

                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="word_jpn">Kata Jepang</label>
                                        <input type="text" name="word_jpn" id="word_jpn" class="form-control"
                                            value="{{ old('word_jpn') ?? @$data->word_jpn }}" required>

                                        {!! $errors->first('word_jpn', '<label class="help-block error-validation">:message</label>') !!}
                                    </div>

                                    <div class="form-group">
                                        <label for="word_romaji">Kata Romaji</label>
                                        <input type="text" name="word_romaji" id="word_romaji" class="form-control"
                                            value="{{ old('word_romaji') ?? @$data->word_romaji }}" required>

                                        {!! $errors->first('word_romaji', '<label class="help-block error-validation">:message</label>') !!}
                                    </div>
                                    <div class="form-group">
                                        <label for="word_idn">Kata Indonesia</label>
                                        <input type="text" name="word_idn" id="word_idn" class="form-control"
                                            value="{{ old('word_idn') ?? @$data->word_idn }}" required>

                                        {!! $errors->first('word_idn', '<label class="help-block error-validation">:message</label>') !!}
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="category">Pilih Bab</label>
                                        <select name="vocabulary_chapter_id" id="vocabulary_chapter_id" class="form-control"
                                            required>
                                            <option value="">Pilih Bab</option>
                                            @foreach ($chapters as $chapter)
                                                <option value="{{ $chapter->id }}"
                                                    {{ @$chapter->id == @$data->vocabulary_chapter_id ? 'selected' : '' }}>
                                                    {{ $chapter->name }}</option>
                                            @endforeach
                                        </select>
                                        {!! $errors->first('vocabulary_chapter_id', '<label class="help-block error-validation">:message</label>') !!}
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
                            </div>

                            <button type="submit" class="btn btn-info btn-fw btn-lg mr-2">Submit</button>
                            <a href="{{ route('vocabularies.index') }}" class="btn btn-secondary btn-fw btn-lg">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
