@extends('layouts.master')
@php
    $title = @$data ? 'Edit' : 'Add New';
@endphp
@section('title', 'Bunpou Introduction '.$title)
@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{ $title }} Bunpou Introduction</h4>
                    <br>
                    <form class="forms-sample"
                          action="{{ @$data ? route('bunpou.vocabulary.update', $data->id) : route('bunpou.vocabulary.store') }}"
                          method="POST" enctype="multipart/form-data">
                        @csrf
                        @if(@$data)
                            <input type="hidden" name="_method" value="put">
                        @endif

                        <input type="hidden" name="chapter" value="<?=$chapter->id?>">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="word_jpn">Kata Jepang</label>
                                    <input type="text" class="form-control {{ hasErrorField($errors,'word_jpn') }}"
                                           id="word_jpn" name="word_jpn" value="{{ old('word_jpn',@$data->word_jpn) }}"
                                           placeholder="Kata Jepang" required>
                                    {!! $errors->first('word_jpn', '<label class="help-block error-validation">:message</label>') !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="word_romaji">Kata Romaji</label>
                                    <input type="text" class="form-control {{ hasErrorField($errors,'word_romaji') }}"
                                           id="word_romaji" name="word_romaji" value="{{ old('word_romaji',@$data->word_romaji) }}"
                                           placeholder="Kata Romaji" required>
                                    {!! $errors->first('word_romaji', '<label class="help-block error-validation">:message</label>') !!}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="word_idn">Kata Indonesia</label>
                                    <input type="text" class="form-control {{ hasErrorField($errors,'word_idn') }}"
                                           id="word_idn" name="word_idn" value="{{ old('word_idn',@$data->word_idn) }}"
                                           placeholder="Kata Indonesia" required>
                                    {!! $errors->first('word_idn', '<label class="help-block error-validation">:message</label>') !!}
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
                        <a href="{{ route('bunpou.vocabulary.index',$chapter->id) }}" class="btn btn-secondary btn-fw btn-lg">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
