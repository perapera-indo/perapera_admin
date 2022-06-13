@extends('layouts.master')
@section('title', 'Bunpou Chapters List')
@section('content')
    <style>
        .select2-container--bootstrap4 .select2-selection--single {
            height: calc(2.25rem + 2px) !important;
        }
        .select2-container--bootstrap4 .select2-selection--single .select2-selection__rendered {
            line-height: 2.25rem !important;
        }
        .float-right {
            width: 25%;
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
    </style>
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            @isPermitted('bunpou.chapter.create')
                                <a href="{{ route('bunpou.chapter.create',$data->id) }}" type="button" class="btn btn-outline-info btn-rounded btn-fw btn-sm">
                                    <i class="mdi mdi-plus-circle btn-icon-prepend"></i> Tambah
                                </a>
                            @endisPermitted
                            <div class="float-right">
                                <div class="row">
                                    <div class="col-md-3 d-flex align-items-center justify-content-center">
                                        <label>Module : </label>
                                    </div>
                                    <div class="col">
                                        <select class="form-control select2" id="module">
                                            @foreach (@$modules as $module)
                                                <option value="{{ $module->id }}"
                                                    {{ $module->id == @$data->id ? 'selected' : '' }}>
                                                    {{ $module->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h4 class="card-title text-center table-title">List Bunpou Chapters</h4>
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
        const url = "{{ url('admin/bunpou/chapter') }}/"
        const module = $("#module")
        module.on("change", (e)=>{
            var id = module.val()
            window.location.href = url + id
        })
    </script>
@endsection
