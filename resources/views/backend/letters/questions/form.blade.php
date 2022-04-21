@extends('layouts.master')
@php
$title = @$data ? 'Edit' : 'Tambah';
@endphp
@section('title', 'Pertanyaan ' . $title)
@section('content')
    <style>
        input[type='file'].form-control {
            height: 38px;
            padding: 0.5rem 0.81rem;
        }

        .form-group label {
            width: 100%;
        }
    </style>
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ $title }} Pertanyaan</h4>
                        <br>
                        <form class="forms-sample" id="form-question" isEdit="{{ ($type=='new')? 'false' : 'true' }}"
                            action="{{ @$data ? route('letter-questions.update', $data->id) : route('letter-questions.store') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @if (@$data)
                                <input type="hidden" name="_method" value="put">
                            @endif
                            {{-- <div class="row"> --}}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="letter_course_id">Versi Test</label>
                                        <select name="letter_course_id" id="letter" class="form-control" required>
                                            <option value="">Pilih Versi Test</option>
                                            @foreach ($courses as $let)
                                                <option value="{{ $let->id }}"
                                                    {{ $let->id == @$data->letter_course_id ? 'selected' : '' }}>
                                                    {{ $let->title }} | {{$let->name}}</option>
                                            @endforeach
                                        </select>
                                        {!! $errors->first('letter_course_id', '<label class="help-block error-validation">:message</label>') !!}
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="is_active">Status</label>
                                        <select name="is_active" id="status" class="form-control">
                                            <option {{ @$data->is_active == 1 ? 'selected' : '' }} value="1">
                                                active
                                            </option>
                                            <option {{ @$data->is_active == 0 ? 'selected' : '' }} value="0">
                                                inactive
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="question">Question</label>
                                        <textarea class="form-control" name="question" id="question" rows="4" placeholder="Question"
                                            required value="">{{ old('question') ?? @$data->question }}</textarea>

                                        {!! $errors->first('question', '<label class="help-block error-validation">:message</label>') !!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>
                                            Image
                                            @if($type!="new" && $data->image!=null)
                                                <a href="{{ asset('uploads/images/'.$data->image) }}" target="_blank" class="pull-right">Current Image</a>
                                            @endif
                                        </label>
                                        <input type="file" class="form-control" name="question-image" accept="image/*"/>
                                        {!! $errors->first('question-image', '<label class="help-block error-validation">:message</label>') !!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>
                                            Audio
                                            @if($type!="new" && $data->audio!=null)
                                                <a href="{{ asset('uploads/audios/'.$data->audio) }}" target="_blank" class="pull-right">Current Audio</a>
                                            @endif
                                        </label>
                                        <input type="file" class="form-control" name="question-audio" accept="audio/*"/>
                                        {!! $errors->first('question-audio', '<label class="help-block error-validation">:message</label>') !!}
                                    </div>
                                </div>
                            </div>
                            <hr/>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="question">Jawaban A</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <input type="radio" data-toggle="tooltip" data-placement="top"
                                                        title="Choose as answer" name="answer[0][is_true]" value="1"
                                                        {{ ($type == 'new' ? 'checked' : @$answers[0]->is_true == true) ? 'checked' : '' }}>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control" name="answer[0][answer]"
                                                value="{{ old('answer[0][answer]') ?? @$answers[0]->answer }}"
                                                placeholder="answer">
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>
                                                        Image
                                                        @if($type!="new" && $answers[0]->image!=null)
                                                            <a href="{{ asset('uploads/images/'.$answers[0]->image) }}" target="_blank" class="pull-right">Current Image</a>
                                                        @endif
                                                    </label>
                                                    <input type="file" class="form-control" accept="image/*" name="answer[0][image]"/>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>
                                                        Audio
                                                        @if($type!="new" && $answers[0]->audio!=null)
                                                            <a href="{{ asset('uploads/audios/'.$answers[0]->audio) }}" target="_blank" class="pull-right">Current Audio</a>
                                                        @endif
                                                    </label>
                                                    <input type="file" class="form-control" accept="audio/*" name="answer[0][audio]"/>
                                                </div>
                                            </div>
                                        </div>
                                        <input id="answer[0][id]" name="answer[0][id]" type="hidden"
                                            value="{{ @$answers[0]->id }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="question">Jawaban B</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <input type="radio" data-toggle="tooltip" data-placement="top"
                                                        title="Choose as answer" name="answer[1][is_true]" value="1"
                                                        {{ @$answers[1]->is_true == true ? 'checked' : '' }}>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control" name="answer[1][answer]"
                                                value="{{ old('answer[1][answer]') ?? @$answers[1]->answer }}"
                                                placeholder="answer">
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>
                                                        Image
                                                        @if($type!="new" && $answers[1]->image!=null)
                                                            <a href="{{ asset('uploads/images/'.$answers[1]->image) }}" target="_blank" class="pull-right">Current Image</a>
                                                        @endif
                                                    </label>
                                                    <input type="file" class="form-control" accept="image/*" name="answer[1][image]"/>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>
                                                        Audio
                                                        @if($type!="new" && $answers[1]->audio!=null)
                                                            <a href="{{ asset('uploads/audios/'.$answers[1]->audio) }}" target="_blank" class="pull-right">Current Audio</a>
                                                        @endif
                                                    </label>
                                                    <input type="file" class="form-control" accept="audio/*" name="answer[1][audio]"/>
                                                </div>
                                            </div>
                                        </div>
                                        <input id="answer[1][id]" name="answer[1][id]" type="hidden"
                                            value="{{ @$answers[1]->id }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="question">Jawaban C</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <input type="radio" data-toggle="tooltip" data-placement="top"
                                                        title="Choose as answer" name="answer[2][is_true]" value="1"
                                                        {{ @$answers[2]->is_true == true ? 'checked' : '' }}>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control" name="answer[2][answer]"
                                                value="{{ old('answer[2][answer]') ?? @$answers[2]->answer }}"
                                                placeholder="answer">
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>
                                                        Image
                                                        @if($type!="new" && $answers[2]->image!=null)
                                                            <a href="{{ asset('uploads/images/'.$answers[2]->image) }}" target="_blank" class="pull-right">Current Image</a>
                                                        @endif
                                                    </label>
                                                    <input type="file" class="form-control" accept="image/*" name="answer[2][image]"/>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>
                                                        Audio
                                                        @if($type!="new" && $answers[2]->audio!=null)
                                                            <a href="{{ asset('uploads/audios/'.$answers[2]->audio) }}" target="_blank" class="pull-right">Current Audio</a>
                                                        @endif
                                                    </label>
                                                    <input type="file" class="form-control" accept="audio/*" name="answer[2][audio]"/>
                                                </div>
                                            </div>
                                        </div>
                                        <input id="answer[2][id]" name="answer[2][id]" type="hidden"
                                            value="{{ @$answers[2]->id }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="question">Jawaban D</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <input type="radio" data-toggle="tooltip" data-placement="top"
                                                        title="Choose as answer" name="answer[3][is_true]" value="1"
                                                        {{ @$answers[3]->is_true == true ? 'checked' : '' }}>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control" name="answer[3][answer]"
                                                value="{{ old('answer[3][answer]') ?? @$answers[3]->answer }}"
                                                placeholder="answer">
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>
                                                        Image
                                                        @if($type!="new" && $answers[3]->image!=null)
                                                            <a href="{{ asset('uploads/images/'.$answers[3]->image) }}" target="_blank" class="pull-right">Current Image</a>
                                                        @endif
                                                    </label>
                                                    <input type="file" class="form-control" accept="image/*" name="answer[3][image]"/>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>
                                                        Audio
                                                        @if($type!="new" && $answers[3]->audio!=null)
                                                            <a href="{{ asset('uploads/audios/'.$answers[3]->audio) }}" target="_blank" class="pull-right">Current Audio</a>
                                                        @endif
                                                    </label>
                                                    <input type="file" class="form-control" accept="audio/*" name="answer[3][audio]"/>
                                                </div>
                                            </div>
                                        </div>
                                        <input id="answer[3][id]" name="answer[3][id]" type="hidden"
                                            value="{{ @$answers[3]->id }}">
                                    </div>
                                </div>
                            </div>
                            {{-- </div> --}}

                            <button type="button" id="button-validate" class="btn btn-info btn-fw btn-lg mr-2">Submit</button>
                            <button type="submit" class="hidden" id="button-submit"></button>
                            <a href="{{ route('letter-questions.index') }}"
                                class="btn btn-secondary btn-fw btn-lg">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $(document).on('click', 'input[type="radio"]', function() {
                $('input[type="radio"]').not(this).prop('checked', false);
            });

            $("#button-validate").on("click", (e)=>{
                const form = $("#form-question")

                if(form.attr("isEdit")=="false"){
                    const targets = form.find("input[type='radio']")
                    for(var i=0; i<targets.length; i++){
                        var target = $(targets[i]).parents(".form-group"),
                            text = target.find("input[type='text']"),
                            image = target.find("input[name$='[image]']"),
                            audio = target.find("input[name$='[audio]']")

                        text.prop("required",false)

                        if(text.val()==image.val() && image.val()==audio.val() && audio.val()==""){
                            text.prop("required",true)
                        }
                    }
                }

                $("#button-submit").click()
            })
        });
    </script>
@endsection
