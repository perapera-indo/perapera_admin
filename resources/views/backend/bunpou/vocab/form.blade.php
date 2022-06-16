@extends('layouts.master')
@php
    $title = @$data ? 'Edit' : 'Add New';
@endphp
@section('title', 'Bunpou Vocabulary '.$title)
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
                    <h4 class="card-title">{{ $title }} Bunpou Vocabulary</h4>
                    <br>
                    <form class="forms-sample"
                          action="{{ @$data ? route('bunpou.vocabulary.update', $data->id) : route('bunpou.vocabulary.store') }}"
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
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>
                                        Image
                                        @if($title!="Add New" && $data->image!=null)
                                            <a href="{{ asset($data->image) }}" target="_blank" class="pull-right">Current Image</a>
                                        @endif
                                    </label>
                                    <input type="file" class="form-control" name="image" accept="image/*"/>
                                    {!! $errors->first('image', '<label class="help-block error-validation">:message</label>') !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>
                                        Audio
                                        @if($title!="Add New" && $data->audio!=null)
                                            <a href="{{ asset($data->audio) }}" target="_blank" class="pull-right">Current Audio</a>
                                        @endif
                                    </label>
                                    <input type="file" class="form-control" name="audio" accept="audio/*"/>
                                    {!! $errors->first('audio', '<label class="help-block error-validation">:message</label>') !!}
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-info btn-fw btn-lg mr-2">Submit</button>
                        <a href="{{ route('bunpou.vocabulary.index') }}" class="btn btn-secondary btn-fw btn-lg">Cancel</a>
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
                    defValue = $(module.find("option:not(:disabled)")[0]).attr("value")
                }
                module.val(defValue).trigger("change")
            }
        });
    </script>
@endsection
