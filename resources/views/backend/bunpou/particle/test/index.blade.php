@extends('layouts.master')
@section('title', "Bunpou Particle Versi Test List")
@section('content')
    <style>
        .select2-container--bootstrap4 .select2-selection--single {
            height: calc(2.25rem + 2px) !important;
        }
        .select2-container--bootstrap4 .select2-selection--single .select2-selection__rendered {
            line-height: 2.25rem !important;
        }
        .select2-container .select2-selection {
            border-radius: 0.2rem !important;
        }
        .select2-container {
            display: inline-block;
            min-width: 100px;
        }
        .select2-container input {
            width: 90% !important;
        }
        .select2-results__option[aria-disabled="true"] {
            background-color: #e9ecef;
        }
        .select2-container--bootstrap4 .select2-dropdown .select2-results__option[aria-selected=true] {
            background-color: #b66dff;
            color: white;
        }
        .select2-container li {
            max-width: 100%;
            overflow: hidden;
            word-wrap: normal !important;
            white-space: normal;
        }

        .pagination {
            overflow-x: auto;
        }
    </style>
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            @isPermitted('bunpou.particle.test.create')
                                <a href="{{ route('bunpou.particle.test.create') }}" type="button" class="btn btn-outline-info btn-rounded btn-fw btn-sm">
                                    <i class="mdi mdi-plus-circle btn-icon-prepend"></i> Tambah
                                </a>
                            @endisPermitted
                            <div class="pull-right">
                                <a href="{{ route('bunpou.particle.index') }}" type="button" class="btn btn-outline-info btn-rounded btn-fw btn-sm">
                                    Back To Manage Particle
                                </a>
                                <a href="{{ route('bunpou.particle.detail.index') }}" type="button" class="btn btn-outline-info btn-rounded btn-fw btn-sm">
                                    Manage Particle Detail
                                </a>
                                <a href="{{ route('bunpou.particle.question.index') }}" type="button" class="btn btn-outline-info btn-rounded btn-fw btn-sm">
                                    Manage Question
                                </a>
                            </div>
                        </div>
                        <h4 class="card-title text-center table-title">List Bunpou Particle Versi Test</h4>
                        <br>
                        <div class="col-md-12">
                            {!! $dataTable->table(['class'=>'table table-hover table-responsive-lg'], true) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="dataTables_filter pull-left hidden">
        <label class="d-flex align-items-center justify-content-center">
            <span>Module :</span>
            &nbsp;
            <select class="form-control" id="{!! $dataTable->getTableId() !!}-module">
                @foreach (@$modules as $module)
                    <option value="{{ $module->id }}"
                        {{ $module->id == @$data->id ? 'selected' : '' }}
                        {{ $module->chapter_count==null ? "disabled" : "" }}>
                        {{ $module->name }}</option>
                @endforeach
            </select>
        </label>
    </div>

    <div class="dataTables_filter pull-left hidden">
        <label class="d-flex align-items-center justify-content-center">
            <span>Chapter :</span>
            &nbsp;
            <select class="form-control" id="{!! $dataTable->getTableId() !!}-chapter"></select>
        </label>
    </div>
@endsection
@section('scripts')
    {!! $dataTable->scripts() !!}

    <script>
        $(document).ready(()=>{
            const dtId = "{!! $dataTable->getTableId() !!}"
            const prevState = JSON.parse(localStorage.getItem(`DataTables_${dtId}_${location.pathname}`))

            setCustomFilterDatatable({
                section : $(".section-chapter"),
                filter : $(`#${dtId}-chapter`).closest("div"),
                complete : (filter,section)=>{
                    let dt = $(`#${dtId}`).DataTable()
                    let select = filter.find("select")

                    select.select2({
                        placeholder: 'Please Select',
                        theme: 'bootstrap4',
                        width: 'resolve',
                        allowClear: true,
                        dropdownParent: select.parent()
                    }).on("change", (e)=>{
                        dt.search($(`#${dtId}_filter input`).val()).draw()
                    })

                    resizeSelect2FilterDatatable(select,section)

                    if(prevState!=null && prevState.chapter!=null){
                        select.val(prevState.chapter).trigger('change')
                    }
                }
            })

            setCustomFilterDatatable({
                section : $(".section-module"),
                filter : $(`#${dtId}-module`).closest("div"),
                complete : (filter,section)=>{
                    let dt = $(`#${dtId}`).DataTable()
                    let select = filter.find("select")

                    select.select2({
                        placeholder: 'Please Select',
                        theme: 'bootstrap4',
                        width: 'resolve',
                        allowClear: true,
                        dropdownParent: select.parent()
                    }).on('select2:open', function (e) {
                        setTimeout(() => {
                            $(".select2-results__option[aria-disabled='true']")
                                .attr("title","This module has no chapter")
                        }, 500);
                    }).on("change", (e)=>{
                        let chapter = $(`#${dtId}-chapter`)
                        let value = select.val()

                        chapter.html("")

                        if(value==null){ return }

                        $.ajax({
                            url: `{{ url('admin/bunpou/chapter') }}/${value}/module`,
                            beforeSend: ()=>{
                                chapter.html("")
                            },
                            success: (res)=>{
                                res.forEach((v,i)=>{
                                    chapter.append(`<option value="${v.id}">${v.name}</option>`)
                                })

                                triggerFilterOrDrawDatatable(dtId,chapter,prevState,"chapter")
                            },
                            error: (res)=>{
                                toastr.error("Error Occured")
                            },
                        })
                    })
                    .val(prevState!=null && prevState.module!=null ? prevState.module : $(select.find("option:not(:disabled)")[0]).attr("value"))
                    .trigger('change')

                    resizeSelect2FilterDatatable(select,section)
                }
            })

            $(document).on("click", ".section-module .select2-results__option[aria-disabled='true']", ()=>{
                toastr.error("his module has no chapter")
            })
        })
    </script>
@endsection
