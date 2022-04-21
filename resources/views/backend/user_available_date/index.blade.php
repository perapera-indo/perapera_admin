@extends('layouts.master')
@section('title', 'Bank List')
@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        @isPermitted('user-availability-date.create')
                            @if($canCreateNew)
                                <div class="form-group">
                                    <a href="{{ route('user-availability-date.index') }}" type="button" class="btn btn-outline-primary btn-rounded btn-fw btn-sm">
                                        <i class="mdi  mdi-format-list-bulleted btn-icon-prepend"></i> List
                                    </a>

                                    <a href="{{ route('user-availability-date.create') }}" type="button" class="btn btn-outline-info btn-rounded btn-fw btn-sm">
                                        <i class="mdi mdi-plus-circle btn-icon-prepend"></i> Tambah
                                    </a>
                                </div>
                            @endif
                        @endisPermitted

                        <h4 class="card-title text-center table-title">List Calendar {{ $role }}</h4>
                        <br>
                        <div class="col-md-12">
                            {!! $calendar->calendar() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    {!! $calendar->script() !!}
@endsection
