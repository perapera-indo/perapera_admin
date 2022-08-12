@extends('layouts.master')
@section('title', 'Suuji Modules List')
@section('content')
    <style>
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
                            @isPermitted('suuji.module.create')
                                <a href="{{ route('suuji.module.create') }}" type="button" class="btn btn-outline-info btn-rounded btn-fw btn-sm">
                                    <i class="mdi mdi-plus-circle btn-icon-prepend"></i> Tambah
                                </a>
                            @endisPermitted
                            <div class="pull-right">
                                <a href="{{ route('suuji.module.test.index') }}" type="button" class="btn btn-outline-info btn-rounded btn-fw btn-sm">
                                    Manage Test
                                </a>
                                <a href="{{ route('suuji.module.question.index') }}" type="button" class="btn btn-outline-info btn-rounded btn-fw btn-sm">
                                    Manage Question
                                </a>
                            </div>
                        </div>
                        <h4 class="card-title text-center table-title">List Suuji Modules</h4>
                        <br>
                        <div class="col-md-12">
                            {!! $dataTable->table(['class'=>'table table-hover table-responsive-lg','id' => 'suuji-modules-dt'], true) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    {!! $dataTable->scripts() !!}
@endsection
