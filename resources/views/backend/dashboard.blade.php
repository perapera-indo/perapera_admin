@extends('layouts.master')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard')
@section('page_description', 'STUD Dashboard')

@section('content')
    <div class="content-wrapper">
        <div class="row" id="proBanner">
            <div class="col-12" style="display: none">
                <span class="d-flex align-items-center purchase-popup">
                  {{--<p>Like what you see? Check out our premium version for more.</p>--}}
                  {{--<a href="https://github.com/BootstrapDash/PurpleAdmin-Free-Admin-Template" target="_blank" class="btn ml-auto download-button">Download Free Version</a>--}}
                  {{--<a href="https://www.bootstrapdash.com/product/purple-bootstrap-4-admin-template/" target="_blank" class="btn purchase-button">Upgrade To Pro</a>--}}
                  <i class="mdi mdi-close" id="bannerClose"></i>
                </span>
            </div>
        </div>
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white mr-2">
                  <i class="mdi mdi-home"></i>
                </span> Dashboard </h3>
            <nav aria-label="breadcrumb">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">
                        <span></span>Overview <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Project Status</h4>
                        <div class="col-md-12">
                            {{-- {!! $dataTable->table(['class'=>'table table-hover table-responsive-lg','id' => 'app'], true) !!} --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    {!! Html::script('assets/backend/js/dashboard.js') !!}
    {!! Html::script('assets/backend/js/todolist.js') !!}
    {!! Html::script('assets/backend/vendors/chart.js/Chart.min.js') !!}
    {{-- {!! $dataTable->scripts() !!} --}}
@endsection
