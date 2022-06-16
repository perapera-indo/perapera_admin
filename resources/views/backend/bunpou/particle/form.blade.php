@extends('layouts.master')
@php
    $title = @$data ? 'Edit' : 'Add New';
@endphp
@section('title', 'Bunpou Particle '.$title)
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
                    <h4 class="card-title">{{ $title }} Bunpou Particle</h4>
                    <br>
                    <form class="forms-sample"
                          action="{{ @$data ? route('bunpou.particle.update', $data->id) : route('bunpou.particle.store') }}"
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
                                    <label for="letter_jpn">Huruf Jepang</label>
                                    <input type="text" class="form-control {{ hasErrorField($errors,'letter_jpn') }}"
                                           id="letter_jpn" name="letter_jpn" value="{{ old('letter_jpn',@$data->letter_jpn) }}"
                                           placeholder="Huruf Jepang" required>
                                    {!! $errors->first('letter_jpn', '<label class="help-block error-validation">:message</label>') !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="letter_romaji">Huruf Romaji</label>
                                    <input type="text" class="form-control {{ hasErrorField($errors,'letter_romaji') }}"
                                           id="letter_romaji" name="letter_romaji" value="{{ old('letter_romaji',@$data->letter_romaji) }}"
                                           placeholder="Huruf Romaji" required>
                                    {!! $errors->first('letter_romaji', '<label class="help-block error-validation">:message</label>') !!}
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
                                    <label for="order">Order</label>
                                    <input type="number" class="form-control {{ hasErrorField($errors,'order') }}"
                                           id="order" name="order" value="{{ old('order',@$data->order) }}"
                                           placeholder="Order" min="1" required>
                                    {!! $errors->first('order', '<label class="help-block error-validation">:message</label>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" rows="3" name="description" placeholder="Description"
                                    >{{ @$data->description ?  @$data->description : old('description', @$data->name)}}</textarea>
                                    {!! $errors->first('description', '<label class="help-block error-validation">:message</label>') !!}
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-info btn-fw btn-lg mr-2">Submit</button>
                        <a href="{{ route('bunpou.particle.index') }}" class="btn btn-secondary btn-fw btn-lg">Cancel</a>
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
