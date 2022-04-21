@extends('layouts.master')
@php
$title = @$data ? 'Edit' : 'Add New';
@endphp
@section('title', 'Verb Sentence ' . $title)
@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ $title }} Verb Sentence</h4>
                        <br>
                        <form class="forms-sample"
                            action="{{ @$data ? route('verb-sentences.update', $data->id) : route('verb-sentences.store') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @if (@$data)
                                <input type="hidden" name="_method" value="put">
                            @endif

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="sentence_jpn">Sentence Japan</label>
                                        <input type="text" name="sentence_jpn" id="sentence_jpn" class="form-control"
                                            value="{{ old('sentence_jpn') ?? @$data->sentence_jpn }}" required>
                                        {!! $errors->first('sentence_jpn', '<label class="help-block error-validation">:message</label>') !!}
                                    </div>

                                    <div class="form-group">
                                        <label for="sentence_romanji">Sentence Romanji</label>
                                        <input type="text" name="sentence_romanji" id="sentence_romanji"
                                            class="form-control"
                                            value="{{ old('sentence_romanji') ?? @$data->sentence_romanji }}" required>
                                        {!! $errors->first('sentence_romanji', '<label class="help-block error-validation">:message</label>') !!}
                                    </div>

                                    <div class="form-group">
                                        <label for="sentence_idn">Sentence Indonesia</label>
                                        <input type="text" name="sentence_idn" id="sentence_idn" class="form-control"
                                            value="{{ old('sentence_idn') ?? @$data->sentence_idn }}" required>
                                        {!! $errors->first('sentence_idn', '<label class="help-block error-validation">:message</label>') !!}
                                    </div>

                                    <div class="form-group">
                                        <label for="sentence_jpn_highlight">Sentence Japan Highlight</label>
                                        <input type="text" name="sentence_jpn_highlight" id="sentence_jpn_highlight"
                                            class="form-control"
                                            value="{{ old('sentence_jpn_highlight') ?? @$data->sentence_jpn_highlight }}"
                                            required>
                                        {!! $errors->first('sentence_jpn_highlight', '<label class="help-block error-validation">:message</label>') !!}
                                    </div>

                                    <div class="form-group">
                                        <label for="sentence_romaji_highlight">Sentence Romanji Highlight</label>
                                        <input type="text" name="sentence_romaji_highlight" id="sentence_romaji_highlight"
                                            class="form-control"
                                            value="{{ old('sentence_romaji_highlight') ?? @$data->sentence_romaji_highlight }}"
                                            required>
                                        {!! $errors->first('sentence_romaji_highlight', '<label class="help-block error-validation">:message</label>') !!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="verb_change_id">Verbs Change</label>
                                        <select name="verb_change_id" id="verb_change_id" class="form-control">
                                            <option value="">Select Verbs Change</option>
                                            @foreach ($changes as $change)
                                                <option value="{{ $change->id }}"
                                                    {{ $change->id == @$data->verb_change_id ? 'selected' : '' }}>
                                                    {{ $change->name }}</option>
                                            @endforeach
                                        </select>
                                        {!! $errors->first('verb_change_id', '<label class="help-block error-validation">:message</label>') !!}
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

                                    <div class="form-group input-group">
                                        <label for="exampleInputFile2">Sentence Image</label>
                                        <input type="file" class="form-control {{ hasErrorField($errors,'sentence_img') }} dropify" data-errors-position="outside" name="sentence_img" data-default-file="{{ env('CLOUD_S3_URL') . @$data->sentence_img }}"
                                               data-height="200" data-max-file-size="2M" data-allowed-file-extensions="jpg jpeg png gif">
                                    </div>
                                    {!! $errors->first('sentence_img', '<label class="help-block error-validation">:message</label>') !!}
                                </div>
                            </div>

                            {{-- <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="word_romanji">Word Romanji</label>
                                        <input type="text" name="word_romanji" id="word_romanji" class="form-control"
                                            value="{{ old('word_romanji') ?? @$data->word_romanji }}" required>

                                        {!! $errors->first('word_romanji', '<label class="help-block error-validation">:message</label>') !!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="word_idn">Word Indonesia</label>
                                        <input type="text" name="word_idn" id="word_idn" class="form-control"
                                            value="{{ old('word_idn') ?? @$data->word_idn }}" required>

                                        {!! $errors->first('word_idn', '<label class="help-block error-validation">:message</label>') !!}
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="word_romanji_highlight">Word Romanji Highlight</label>
                                        <input type="text" name="word_romanji_highlight" id="word_romanji_highlight"
                                            class="form-control"
                                            value="{{ old('word_romanji_highlight') ?? @$data->word_romanji_highlight }}"
                                            required>
                                        {!! $errors->first('word_romanji_highlight', '<label class="help-block error-validation">:message</label>') !!}
                                    </div>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="category">Pick Verb Group</label>
                                        <select name="master_verb_group_id" id="master_verb_group_id" class="form-control"
                                            required>
                                            <option value="">Select Verb Group</option>
                                            @foreach ($groups as $group)
                                                <option value="{{ $group->id }}"
                                                    {{ @$group->id == @$data->master_verb_group_id ? 'selected' : '' }}>
                                                    {{ $group->name }}</option>
                                            @endforeach
                                        </select>
                                        {!! $errors->first('master_verb_group_id', '<label class="help-block error-validation">:message</label>') !!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="is_active">Status</label>
                                        <select name="is_active" id="status" class="form-control">
                                            <option {{ @$data->is_active == 1 ? 'selected' : '' }} value="1"> active
                                            </option>
                                            <option {{ @$data->is_active == 0 ? 'selected' : '' }} value="0"> inactive
                                            </option>
                                        </select>
                                    </div>
                                    {!! $errors->first('is_active', '<label class="help-block error-validation">:message</label>') !!}
                                </div>
                            </div> --}}
                            {{-- </div> --}}

                            <button type="submit" class="btn btn-info btn-fw btn-lg mr-2">Submit</button>
                            <a href="{{ route('verb-sentences.index') }}" class="btn btn-secondary btn-fw btn-lg">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
