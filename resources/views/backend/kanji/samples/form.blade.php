@extends('layouts.master')
@php
$title = @$data ? 'Edit' : 'Add New';
@endphp
@section('title', 'Kanji Sample ' . $title)
@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ $title }} Kanji Sample</h4>
                        <br>
                        <form class="forms-sample"
                            action="{{ @$data ? route('kanji-samples.update', $data->id) : route('kanji-samples.store') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @if (@$data)
                                <input type="hidden" name="_method" value="put">
                            @endif
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="sample_kanji">Contoh Kanji</label>
                                        <input type="text" class="form-control {{ hasErrorField($errors, 'sample_kanji') }}"
                                            id="sample_kanji" name="sample_kanji" value="{{ old('sample_kanji', @$data->sample_kanji) }}"
                                            placeholder="Contoh Kanji">
                                        {!! $errors->first('sample_kanji', '<label class="help-block error-validation">:message</label>') !!}
                                    </div>
                                    <div class="form-group">
                                        <label for="sample_hiragana">Contoh Hiragana</label>
                                        <input type="text" class="form-control {{ hasErrorField($errors, 'sample_hiragana') }}"
                                            id="sample_hiragana" name="sample_hiragana" value="{{ old('sample_hiragana', @$data->sample_hiragana) }}"
                                            placeholder="Contoh Hiragana">
                                        {!! $errors->first('sample_hiragana', '<label class="help-block error-validation">:message</label>') !!}
                                    </div>
                                    <div class="form-group">
                                        <label for="sample_idn">Contoh Indonesia</label>
                                        <input type="text" class="form-control {{ hasErrorField($errors, 'sample_idn') }}"
                                            id="sample_idn" name="sample_idn" value="{{ old('sample_idn', @$data->sample_idn) }}"
                                            placeholder="Contoh Indonesia">
                                        {!! $errors->first('sample_idn', '<label class="help-block error-validation">:message</label>') !!}
                                    </div>


                                </div>
                                <div class="col-md-6">
                                     <div class="form-group">
                                        <label for="kanji_education_id">Master Education</label>
                                        <select name="kanji_education_id" id="kanji_education_id" class="form-control">
                                            <option value="">Select Master Education</option>
                                            @foreach ($educations as $education)
                                                <option value="{{ $education->id }}"
                                                    {{ $education->id == @$data->kanji_education_id ? 'selected' : '' }}>
                                                    {{ $education->kun_yomi }} / {{$education->on_yomi }}</option>
                                            @endforeach
                                        </select>
                                        {!! $errors->first('kanji_education_id', '<label class="help-block error-validation">:message</label>') !!}
                                    </div>
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

                            <button type="submit" class="btn btn-info btn-fw btn-lg mr-2">Submit</button>
                            <a href="{{ route('kanji-samples.index') }}"
                                class="btn btn-secondary btn-fw btn-lg">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
