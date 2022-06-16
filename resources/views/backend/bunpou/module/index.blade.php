@extends('layouts.master')
@section('title', 'Bunpou Modules List')
@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            @isPermitted('bunpou.module.create')
                                <a href="{{ route('bunpou.module.create') }}" type="button" class="btn btn-outline-info btn-rounded btn-fw btn-sm">
                                    <i class="mdi mdi-plus-circle btn-icon-prepend"></i> Tambah
                                </a>
                            @endisPermitted
                            <div class="pull-right">
                                <a href="{{ route('bunpou.module.test.index') }}" type="button" class="btn btn-outline-info btn-rounded btn-fw btn-sm">
                                    Manage Test
                                </a>
                                <a href="{{ route('bunpou.module.question.index') }}" type="button" class="btn btn-outline-info btn-rounded btn-fw btn-sm">
                                    Manage Question
                                </a>
                            </div>
                        </div>
                        <h4 class="card-title text-center table-title">List Bunpou Modules</h4>
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
@endsection
