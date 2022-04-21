@extends('layouts.master')
@section('title', 'Pattern Lessons Detail List')
@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title text-center table-title">Daftar Contoh Detail Pola</h4>
                        @isPermitted('lesson-detail-example-add', [request()->route('id'), request()->route('did')])
                        <div class="form-group">
                            <a href="{{ route('lesson-detail-example-add', [request()->route('id'), request()->route('did')]) }}" type="button" class="btn btn-outline-info btn-rounded btn-fw btn-sm">
                                <i class="mdi mdi-plus-circle btn-icon-prepend"></i> Tambah
                            </a>
                            <a href="{{ route('lesson-detail-index',request()->route('id')) }}" type="button" class="btn btn-outline-info btn-rounded btn-fw btn-sm float-right">
                                <i class="mdi mdi-arrow-left-bold-circle-outline"></i> Back
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
