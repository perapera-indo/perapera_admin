@extends('layouts.master')
@section('title', 'Bunpou Module Versi Test List')
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
            max-width: 100%;
        }
        .select2-container input {
            width: 90% !important;
        }
        .select2-container li {
            max-width: 100%;
            overflow: hidden;
            word-wrap: normal !important;
            white-space: normal;
        }
        .select2-results__option[aria-disabled="true"] {
            background-color: #e9ecef;
        }
        .select2-container--bootstrap4 .select2-dropdown .select2-results__option[aria-selected=true] {
            background-color: #b66dff;
            color: white;
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
                            @isPermitted('bunpou.module.test.create')
                                <a href="{{ route('bunpou.module.test.create') }}" type="button" class="btn btn-outline-info btn-rounded btn-fw btn-sm">
                                    <i class="mdi mdi-plus-circle btn-icon-prepend"></i> Tambah
                                </a>
                            @endisPermitted
                            <div class="pull-right">
                                <a href="{{ route('bunpou.module.index') }}" type="button" class="btn btn-outline-info btn-rounded btn-fw btn-sm">
                                    Back To Manage Module
                                </a>
                                <a href="{{ route('bunpou.module.question.index') }}" type="button" class="btn btn-outline-info btn-rounded btn-fw btn-sm">
                                    Manage Question
                                </a>
                            </div>
                        </div>
                        <h4 class="card-title text-center table-title">List Bunpou Module Versi Test</h4>
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
            <span>Module: </span>
            <select class="form-control" id="{!! $dataTable->getTableId() !!}-module">
                @foreach (@$modules as $module)
                    <option value="{{ $module->id }}"
                        {{ $module->id == @$data->id ? 'selected' : '' }}>
                        {{ $module->name }}</option>
                @endforeach
            </select>
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
                        dropdownParent: select.parent(),
                    }).on("change", (e)=>{
                        dt.search($(`#${dtId}_filter input`).val()).draw()
                    })

                    if(prevState!=null && prevState.module){
                        select.val(prevState.module).trigger('change')
                    }

                    resizeSelect2FilterDatatable(select,section)
                }
            })
        })
    </script>
@endsection
