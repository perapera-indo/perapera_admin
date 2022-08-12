@extends('layouts.master')
@php
    $title = @$data ? 'Edit' : 'Add New';
@endphp
@section('title', 'Bunpou Particle Detail '.$title)
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
                        <h4 class="card-title">{{ $title }} Bunpou Particle Detail</h4>
                        <br>
                        <form class="forms-sample" isEdit="{{ ($title=='Add New')? 'false' : 'true' }}" id="form-question"
                            action="{{ @$data ? route('bunpou.particle.detail.update', $data->id) : route('bunpou.particle.detail.store') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @if(@$data)
                                <input type="hidden" name="_method" value="put">
                            @endif

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="order">Order</label>
                                        <input type="number" class="form-control {{ hasErrorField($errors,'order') }}"
                                            id="order" name="order" value="{{ old('order',@$data->order) }}"
                                            placeholder="Order" min="1" required>
                                        {!! $errors->first('order', '<label class="help-block error-validation">:message</label>') !!}
                                    </div>
                                </div>
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
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="chapter">Chapter</label>
                                        <select id="chapter" class="form-control select2">
                                        </select>
                                        {!! $errors->first('chapter', '<label class="help-block error-validation">:message</label>') !!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="particle">Particle</label>
                                        <select name="particle" id="particle" class="form-control select2" required>
                                        </select>
                                        {!! $errors->first('particle', '<label class="help-block error-validation">:message</label>') !!}
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="sentence_idn">Kalimat Indonesia</label>
                                        <textarea class="form-control" name="sentence_idn" id="sentence_idn" rows="4" placeholder="Kalimat Indonesia"
                                            required value="">{{ old('sentence_idn') ?? @$data->sentence_idn }}</textarea>

                                        {!! $errors->first('sentence_idn', '<label class="help-block error-validation">:message</label>') !!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="sentence_romaji">Kalimat Romaji</label>
                                        <textarea class="form-control" name="sentence_romaji" id="sentence_romaji" rows="4" placeholder="Kalimat Romaji"
                                            required value="">{{ old('sentence_romaji') ?? @$data->sentence_romaji }}</textarea>

                                        {!! $errors->first('sentence_romaji', '<label class="help-block error-validation">:message</label>') !!}
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="sentence_jpn">Kalimat Jepang</label>
                                        <textarea class="form-control" name="sentence_jpn" id="sentence_jpn" rows="4" placeholder="Kalimat Jepang"
                                            required value="">{{ old('sentence_jpn') ?? @$data->sentence_jpn }}</textarea>

                                        {!! $errors->first('sentence_jpn', '<label class="help-block error-validation">:message</label>') !!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="formula">Formula</label>
                                        <textarea class="form-control" name="formula" id="formula" rows="4" placeholder="Formula"
                                            value="">{{ old('formula') ?? @$data->formula }}</textarea>

                                        {!! $errors->first('formula', '<label class="help-block error-validation">:message</label>') !!}
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="sentence_description">Description</label>
                                        <textarea class="form-control my-editor" name="sentence_description" id="sentence_description" rows="4" placeholder="Description"
                                            value="">{{ old('sentence_description') ?? @$data->sentence_description }}</textarea>

                                        {!! $errors->first('sentence_description', '<label class="help-block error-validation">:message</label>') !!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>
                                            Image
                                            @if($title!="Add New" && $data->sentence_img!=null)
                                                <a href="{{ asset($data->sentence_img) }}" target="_blank" class="pull-right">Current Image</a>
                                            @endif
                                        </label>
                                        <input type="file" class="form-control" name="sentence_img" accept="image/*"/>
                                        {!! $errors->first('sentence_img', '<label class="help-block error-validation">:message</label>') !!}
                                    </div>
                                </div>
                            </div>

                            <button type="submit" id="button-validate" class="btn btn-info btn-fw btn-lg mr-2">Submit</button>
                            <a href="{{ route('bunpou.particle.detail.index') }}" class="btn btn-secondary btn-fw btn-lg">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
    <script>
        $(document).ready(()=>{
            var editor_config = {
                path_absolute: "/",
                selector: "textarea.my-editor",
                plugins: [
                    "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                    "searchreplace wordcount visualblocks visualchars code fullscreen",
                    "insertdatetime media nonbreaking save table contextmenu directionality",
                    "emoticons template paste textcolor colorpicker textpattern"
                ],
                toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
                relative_urls: false,
                file_browser_callback: function(field_name, url, type, win) {
                    var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName(
                        'body')[0].clientWidth;
                    var y = window.innerHeight || document.documentElement.clientHeight || document
                        .getElementsByTagName('body')[0].clientHeight;

                    var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
                    if (type == 'image') {
                        cmsURL = cmsURL + "&type=Images";
                    } else {
                        cmsURL = cmsURL + "&type=Files";
                    }

                    tinyMCE.activeEditor.windowManager.open({
                        file: cmsURL,
                        title: 'Filemanager',
                        width: x * 0.8,
                        height: y * 0.8,
                        resizable: "yes",
                        close_previous: "no"
                    });
                }
            };

            tinymce.init(editor_config);

            onExist(".mce-close", ()=>{
                $(".mce-close").click()
            }, 10000)
        })
    </script>
    <script>
        $(document).ready(function() {
            $(document).on("click", "#select2-module-results .select2-results__option[aria-disabled='true']", ()=>{
                toastr.error("This module has no chapter")
            }).on("click", "#select2-chapter-results .select2-results__option[aria-disabled='true']", ()=>{
                toastr.error("This chapter has no particle")
            })

            if( hasClass("#module","select2-hidden-accessible")
                && hasClass("#chapter","select2-hidden-accessible")
                && hasClass("#particle","select2-hidden-accessible")
            ){}else{ return }

            let module = $("#module")
            let chapter = $("#chapter")
            let particle = $("#particle")
            let ajaxModuleCount = 0
            let ajaxChapterCount = 0

            module.on("change", ()=>{
                $.ajax({
                    url: `{{ url('admin/bunpou/chapter') }}/${module.val()}/module`,
                    beforeSend: ()=>{
                        chapter.html("")
                    },
                    success: (res)=>{
                        res.forEach((v,i)=>{
                            chapter.append(`<option value="${v.id}" ${v.particle_count==null ? "disabled" : ""}>${v.name}</option>`)
                        })
                        var defValue = "{{ isset($chapter) ? $chapter->id : '' }}"
                        if(
                            (ajaxModuleCount==0 && defValue=="" && "{{$title}}"=="Add New")
                            ||
                            (ajaxModuleCount>0 && defValue=="" && "{{$title}}"=="Add New")
                            ||
                            (ajaxModuleCount>0 && defValue!="" && "{{$title}}"=="Edit")
                        ){
                            defValue = $(chapter.find("option:not(:disabled)")[0]).attr("value")
                        }
                        chapter.val(defValue).trigger("change")
                    },
                    error: (res)=>{
                        if(ajaxModuleCount==0 && "{{$title}}"=="Add New"){ return }
                        toastr.error("Error Occured")
                    },
                    complete: ()=>{
                        ajaxModuleCount++
                    }
                })
            }).on('select2:open', function (e) {
                setTimeout(() => {
                    $(".select2-results__option[aria-disabled='true']")
                        .attr("title","This module has no chapter")
                }, 500);
            })

            chapter.on("change", ()=>{
                $.ajax({
                    url: `{{ url('admin/bunpou/particle') }}/${chapter.val()}/chapter`,
                    beforeSend: ()=>{
                        particle.html("")
                    },
                    success: (res)=>{
                        res.forEach((v,i)=>{
                            particle.append(`<option value="${v.id}">${v.title}</option>`)
                        })
                        var defValue = "{{ isset($particle) ? $particle->id : '' }}"
                        if(
                            (ajaxChapterCount==0 && defValue=="" && "{{$title}}"=="Add New")
                            ||
                            (ajaxChapterCount>0 && defValue=="" && "{{$title}}"=="Add New")
                            ||
                            (ajaxChapterCount>0 && defValue!="" && "{{$title}}"=="Edit")
                        ){
                            defValue = $(particle.find("option:not(:disabled)")[0]).attr("value")
                        }
                        particle.val(defValue).trigger("change")
                    },
                    error: (res)=>{
                        if(ajaxChapterCount==0 && "{{$title}}"=="Add New"){ return }
                        toastr.error("Error Occured")
                    },
                    complete: ()=>{
                        ajaxChapterCount++
                    }
                })
            }).on('select2:open', function (e) {
                setTimeout(() => {
                    $(".select2-results__option[aria-disabled='true']")
                        .attr("title","This chapter has no particle")
                }, 500);
            })

            var defValue = "{{ isset($chapter) ? $chapter->module : '' }}"
            if(defValue==""){
                defValue = $(module.find("option:not(:disabled)")[0]).attr("value")
            }
            module.val(defValue).trigger("change")
        });
    </script>
@endsection
