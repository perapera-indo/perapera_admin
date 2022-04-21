@extends('layouts.master')
@section('title', 'Question List')
@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title text-center table-title">Daftar Pertanyaan</h4>
                        @isPermitted('ability-questions.create')
                        <div class="form-group">
                            <a href="{{ route('ability-questions.create', request()->route('id')) }}" type="button" class="btn btn-outline-info btn-rounded btn-fw btn-sm">
                                <i class="mdi mdi-plus-circle btn-icon-prepend"></i> Tambah
                            </a>
                            <a href="{{ route('ability-course-question-groups.index') }}" type="button" class="btn btn-outline-info btn-rounded btn-fw btn-sm pull-right">
                                <i class="mdi mdi mdi-arrow-left"></i> Back
                            </a>
                        </div>
                        @endisPermitted
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
