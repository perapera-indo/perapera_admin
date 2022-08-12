@extends('layouts.master')
@section('title', 'Introduction')
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
                        @isPermitted('suuji.intro.create')
                        <div class="form-group">
                            <a href="{{ route('suuji.intro.create') }}" type="button" class="btn btn-outline-info btn-rounded btn-fw btn-sm">
                                <i class="mdi mdi-plus-circle btn-icon-prepend"></i> Tambah
                            </a>
                        </div>
                        @endisPermitted
                        <h4 class="card-title text-center table-title">Introduction</h4>
                        <br>
                        <div class="col-md-12">
                            {!! $dataTable->table(['class'=>'table table-hover table-responsive-lg'], true) !!}
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
