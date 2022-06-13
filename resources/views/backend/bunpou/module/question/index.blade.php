@extends('layouts.master')
@section('title', "List question in ". $data->title ." Test")
@section('content')
    <style>
        .select2-container--bootstrap4 .select2-selection--single {
            height: calc(2.25rem + 2px) !important;
        }
        .select2-container--bootstrap4 .select2-selection--single .select2-selection__rendered {
            line-height: 2.25rem !important;
        }
        .float-right {
            width: 20%;
        }
        .float-right .row > div {
            padding: 0;
        }
        .float-right .row > div:last-child {
            padding-right: 40px;
        }
        .float-right .row > div:first-child label {
            margin: 0;
        }
        .card-title {
            text-transform: none !important;
        }
        .select2-results__option[aria-disabled="true"] {
            background-color: #c0c4c8;
        }
    </style>
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            @isPermitted('bunpou.module.question.create',$data->id)
                                <a href="{{ route('bunpou.module.question.create',$data->id) }}" type="button" class="btn btn-outline-info btn-rounded btn-fw btn-sm">
                                    <i class="mdi mdi-plus-circle btn-icon-prepend"></i> Tambah
                                </a>
                            @endisPermitted
                            <div class="float-right">
                                <div class="row">
                                    <div class="col-md-3 d-flex align-items-center justify-content-center">
                                        <label>Test : </label>
                                    </div>
                                    <div class="col">
                                        <select class="form-control select2" id="test">
                                            @foreach (@$test as $t)
                                                <option value="{{ $t->id }}"
                                                    {{ $t->id == @$data->id ? 'selected' : '' }}>
                                                    {{ $t->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="float-right">
                                <div class="row">
                                    <div class="col-md-3 d-flex align-items-center justify-content-center">
                                        <label>Module : </label>
                                    </div>
                                    <div class="col">
                                        <select class="form-control select2" id="module">
                                            @foreach (@$modules as $module)
                                                <option value="{{ $module->id }}"
                                                    {{ $module->id == @$data->module ? 'selected' : '' }}
                                                    {{ $module->test_count==null ? "disabled" : "" }}
                                                    >
                                                    {{ $module->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h4 class="card-title text-center table-title">List question in {{$data->title}} Test</h4>
                        <br>
                        <div class="col-md-12">
                            {!! $dataTable->table(['class'=>'table table-hover table-responsive-lg','id' => 'app'], true) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    {!! $dataTable->scripts() !!}

    <script>
        $(document).ready(()=>{
            const url = "{{ url('admin/bunpou/module/question') }}/"
            const test = $("#test")
            test.on("change", (e)=>{
                var id = test.val()
                window.location.href = url + id
            })

            const module = $("#module")
            const pk = {{ $data->id }}
            module.on("change", (e)=>{
                var id = module.val()
                window.location.href = url + pk + "?module=" + id
            })

            module.on('select2:open', function (e) {
                setTimeout(() => {
                    $(".select2-results__option[aria-disabled='true']")
                        .attr("title","This module has no test")
                }, 500);
            })

            $(document).on("click", ".select2-results__option[aria-disabled='true']", ()=>{
                alert("This module has no test")
            })
        })
    </script>
@endsection
