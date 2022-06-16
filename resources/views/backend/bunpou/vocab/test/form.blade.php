@extends('layouts.master')
@php
    $title = @$data ? 'Edit' : 'Add New';
@endphp
@section('title', 'Bunpou Vocabulary Versi Test '.$title)
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
                        <h4 class="card-title">{{ $title }} Bunpou Vocabulary Versi Test</h4>
                        <br>
                        <form class="forms-sample" isEdit="{{ ($title=='Add New')? 'false' : 'true' }}" id="form-question"
                            action="{{ @$data ? route('bunpou.vocabulary.test.update', $data->id) : route('bunpou.vocabulary.test.store') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @if(@$data)
                                <input type="hidden" name="_method" value="put">
                            @endif

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="module">Module</label>
                                        <select id="module" class="form-control select2">
                                            @foreach (@$modules as $module)
                                                <option value="{{ $module->id }}"
                                                    {{ $module->chapter_count==null ? "disabled" : "" }}>
                                                    {{ $module->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="chapter">Chapter</label>
                                        <select name="chapter" id="chapter" class="form-control select2" required>
                                        </select>
                                        {!! $errors->first('chapter', '<label class="help-block error-validation">:message</label>') !!}
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="title">Title</label>
                                        <input type="text" class="form-control {{ hasErrorField($errors,'title') }}"
                                               id="title" name="title" value="{{ old('title',@$data->title) }}"
                                               placeholder="Title" required>
                                        {!! $errors->first('title', '<label class="help-block error-validation">:message</label>') !!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="time">Test Time</label>
                                        <input type="number" class="form-control {{ hasErrorField($errors,'time') }}"
                                               id="time" name="time" value="{{ old('time',@$data->time) }}"
                                               placeholder="Test Time" min="1" required>
                                        {!! $errors->first('time', '<label class="help-block error-validation">:message</label>') !!}
                                    </div>
                                </div>
                            </div>

                            <button type="submit" id="button-validate" class="btn btn-info btn-fw btn-lg mr-2">Submit</button>
                            <a href="{{ route('bunpou.vocabulary.test.index') }}" class="btn btn-secondary btn-fw btn-lg">Cancel</a>
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
            $(document).on("click", ".select2-results__option[aria-disabled='true']", ()=>{
                toastr.error("This module has no chapter")
            })

            if(hasClass("#module","select2-hidden-accessible") && hasClass("#chapter","select2-hidden-accessible")){
                let module = $("#module")
                let chapter = $("#chapter")
                let ajaxCount = 0
                module.on("change", ()=>{
                    $.ajax({
                        url: `{{ url('admin/bunpou/chapter') }}/${module.val()}/module`,
                        beforeSend: ()=>{
                            chapter.html("")
                        },
                        success: (res)=>{
                            res.forEach((v,i)=>{
                                chapter.append(`<option value="${v.id}">${v.name}</option>`)
                            })
                            var defValue = "{{ isset($chapter) ? $chapter->id : '' }}"
                            if(
                                (ajaxCount==0 && defValue=="" && "{{$title}}"=="Add New")
                                ||
                                (ajaxCount>0 && defValue=="" && "{{$title}}"=="Add New")
                                ||
                                (ajaxCount>0 && defValue!="" && "{{$title}}"=="Edit")
                            ){
                                defValue = chapter.find("option:first-child").attr("value")
                            }
                            chapter.val(defValue).trigger("change")
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
                            .attr("title","This module has no chapter")
                    }, 500);
                })

                var defValue = "{{ isset($chapter) ? $chapter->module : '' }}"
                if(defValue==""){
                    defValue = module.find("option:first-child:not(:disabled)").attr("value")
                }
                module.val(defValue).trigger("change")
            }
        });
    </script>
@endsection
