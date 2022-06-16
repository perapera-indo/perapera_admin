@extends('layouts.master')
@php
    $title = @$question ? 'Edit' : 'Add New';
@endphp
@section('title', 'Bunpou Module Test Question '.$title)
@section('content')
    <style>
        input[type='file'].form-control {
            height: 38px;
            padding: 0.5rem 0.81rem;
        }

        .form-group label {
            width: 100%;
        }

        .select2-results__option[aria-disabled="true"] {
            background-color: #c0c4c8;
        }
    </style>
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ $title }} Bunpou Module Test Question</h4>
                        <br>
                        <form class="forms-sample" isEdit="{{ ($title=='Add New')? 'false' : 'true' }}" id="form-question"
                            action="{{ @$question ? route('bunpou.module.question.update', $question->id) : route('bunpou.module.question.store') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @if(@$question)
                                <input type="hidden" name="_method" value="put">
                            @endif

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="order">Question Number</label>
                                        <input type="number" class="form-control {{ hasErrorField($errors,'order') }}"
                                            id="order" name="order" value="{{ old('order',@$question->order) }}"
                                            placeholder="Question Number" min="1" required>
                                        {!! $errors->first('order', '<label class="help-block error-validation">:message</label>') !!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="time">Time</label>
                                        <input type="number" class="form-control {{ hasErrorField($errors,'time') }}"
                                            id="time" name="time" value="{{ old('time',@$question->time) }}"
                                            placeholder="Time" min="1" required>
                                        {!! $errors->first('time', '<label class="help-block error-validation">:message</label>') !!}
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="module">Module</label>
                                        <select id="module" class="form-control select2">
                                            @foreach (@$modules as $module)
                                                <option value="{{ $module->id }}"
                                                    {{ $module->test_count==null ? "disabled" : "" }}>
                                                    {{ $module->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="test">Module Versi Test</label>
                                        <select name="test" id="test" class="form-control select2" required>
                                        </select>
                                        {!! $errors->first('test', '<label class="help-block error-validation">:message</label>') !!}
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="question">Question</label>
                                        <textarea class="form-control" name="question" id="question" rows="4" placeholder="Question"
                                            required value="">{{ old('question') ?? @$question->question }}</textarea>

                                        {!! $errors->first('question', '<label class="help-block error-validation">:message</label>') !!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>
                                            Image
                                            @if($title!="Add New" && $question->image!=null)
                                                <a href="{{ asset($question->image) }}" target="_blank" class="pull-right">Current Image</a>
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
                                            @if($title!="Add New" && $question->audio!=null)
                                                <a href="{{ asset($question->audio) }}" target="_blank" class="pull-right">Current Audio</a>
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
                                                        {{ ($title == 'Add New' ? 'checked' : @$answers[0]->is_true == true) ? 'checked' : '' }}>
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
                                                        @if($title!="Add New" && $answers[0]->image!=null)
                                                            <a href="{{ asset($answers[0]->image) }}" target="_blank" class="pull-right">Current Image</a>
                                                        @endif
                                                    </label>
                                                    <input type="file" class="form-control" accept="image/*" name="answer[0][image]"/>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>
                                                        Audio
                                                        @if($title!="Add New" && $answers[0]->audio!=null)
                                                            <a href="{{ asset($answers[0]->audio) }}" target="_blank" class="pull-right">Current Audio</a>
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
                                                        @if($title!="Add New" && $answers[1]->image!=null)
                                                            <a href="{{ asset($answers[1]->image) }}" target="_blank" class="pull-right">Current Image</a>
                                                        @endif
                                                    </label>
                                                    <input type="file" class="form-control" accept="image/*" name="answer[1][image]"/>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>
                                                        Audio
                                                        @if($title!="Add New" && $answers[1]->audio!=null)
                                                            <a href="{{ asset($answers[1]->audio) }}" target="_blank" class="pull-right">Current Audio</a>
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
                                                        @if($title!="Add New" && $answers[2]->image!=null)
                                                            <a href="{{ asset($answers[2]->image) }}" target="_blank" class="pull-right">Current Image</a>
                                                        @endif
                                                    </label>
                                                    <input type="file" class="form-control" accept="image/*" name="answer[2][image]"/>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>
                                                        Audio
                                                        @if($title!="Add New" && $answers[2]->audio!=null)
                                                            <a href="{{ asset($answers[2]->audio) }}" target="_blank" class="pull-right">Current Audio</a>
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
                                                        @if($title!="Add New" && $answers[3]->image!=null)
                                                            <a href="{{ asset($answers[3]->image) }}" target="_blank" class="pull-right">Current Image</a>
                                                        @endif
                                                    </label>
                                                    <input type="file" class="form-control" accept="image/*" name="answer[3][image]"/>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>
                                                        Audio
                                                        @if($title!="Add New" && $answers[3]->audio!=null)
                                                            <a href="{{ asset($answers[3]->audio) }}" target="_blank" class="pull-right">Current Audio</a>
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

                            <button type="button" id="button-validate" class="btn btn-info btn-fw btn-lg mr-2">Submit</button>
                            <button type="submit" class="hidden" id="button-submit"></button>
                            <a href="{{ route('bunpou.module.question.index') }}" class="btn btn-secondary btn-fw btn-lg">Cancel</a>
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

            $(document).on("click", ".select2-results__option[aria-disabled='true']", ()=>{
                toastr.error("This module has no test")
            })

            if(hasClass("#module","select2-hidden-accessible") && hasClass("#test","select2-hidden-accessible")){
                let module = $("#module")
                let test = $("#test")
                let ajaxCount = 0
                module.on("change", ()=>{
                    $.ajax({
                        url: `{{ url('admin/bunpou/module/test') }}/${module.val()}/module`,
                        beforeSend: ()=>{
                            test.html("")
                        },
                        success: (res)=>{
                            res.forEach((v,i)=>{
                                test.append(`<option value="${v.id}">${v.title}</option>`)
                            })
                            var defValue = "{{ isset($test) ? $test->id : '' }}"
                            if(
                                (ajaxCount==0 && defValue=="" && "{{$title}}"=="Add New")
                                ||
                                (ajaxCount>0 && defValue=="" && "{{$title}}"=="Add New")
                                ||
                                (ajaxCount>0 && defValue!="" && "{{$title}}"=="Edit")
                            ){
                                defValue = test.find("option:first-child").attr("value")
                            }
                            test.val(defValue).trigger("change")
                        },
                        error: (res)=>{
                            toastr.error("Error Occured")
                        },
                        complete: ()=>{
                            ajaxCount++
                        }
                    })
                }).on('select2:open', function (e) {
                    setTimeout(() => {
                        $(".select2-results__option[aria-disabled='true']")
                            .attr("title","This module has no test")
                    }, 500);
                })

                var defValue = "{{ isset($test) ? $test->module : '' }}"
                if(defValue==""){
                    defValue = module.find("option:first-child:not(:disabled)").attr("value")
                }
                module.val(defValue).trigger("change")
            }
        });
    </script>
@endsection
