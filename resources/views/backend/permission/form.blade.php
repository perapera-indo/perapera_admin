@extends('layouts.master')
@section('title', 'Permission Edit')
@section('content')
<div class="content-wrapper">
    <form action="{{ route('permission.update',$role->id) }}" method="post">
        @csrf
        <input type="hidden" name="_method" value="PUT">
        <div class="row">
            {{--@foreach($allRoutes as $key => $routes)--}}
                {{--<div class="col-12 grid-margin stretch-card">--}}
                {{--<div class="card">--}}
                    {{--<div class="card-body">--}}
                        {{--<div class="col-md-12 form-inline">--}}
                            {{--<div class="col-md-4 form-inline">--}}
                                {{--<div class="">--}}
                                    {{--<label for="">{{ ucfirst($key) }} Management</label>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="col-md-8">--}}
                                {{--<div class="form-inline">--}}
                                    {{--@foreach($routes as $routeMethod => $val)--}}
                                        {{--<div class="form-check role-checker form-check-primary">--}}
                                            {{--<label class="form-check-label">--}}
                                                {{--<input type="checkbox" class="form-check-input"> {{ $val['methodAction'] }} <i class="input-helper"></i></label>--}}
                                        {{--</div> &nbsp;--}}
                                    {{--@endforeach--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--@endForeach--}}
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title text-center table-title">{{ $role->name }} Permission</h4>
                        <br>
                        @if(@!$type || @$type == 'basic')
                            <a href="{{ route('permission.edit',$role->id) }}?type=advance"><p>Advance View</p></a>
                        @elseif(@$type || @$type == 'advance')
                            <a href="{{ route('permission.edit',$role->id) }}?type=basic"><p>Basic View</p></a>
                        @endif
                        <br>
                        <table class="table table-responsive-lg no-footer">
                            <tbody>
                            @foreach($allRoutes as $key => $routes)
                                <tr class="border-top-bottom {{ $routes[array_key_first($routes)]['hidden'] == 'true' ? 'hidden' : '' }}">
                                    <td>{{ delimiterToSpace($key) }} Access</td>
                                    @foreach($routes as $routeMethod => $val)
                                            @if(camelCaseToSpace((permissionAlias($val['methodAction'])) == 'Create') && (@!$type || @$type == 'basic'))
                                                <td class="{{ $val['hidden'] == 'true' ? 'hidden' : '' }}">
                                                    <div class="form-check role-checker form-check-primary">
                                                        <label class="form-check-label label-keep-all">
                                                            <input type="hidden" name="permissions[{{ ($key) }}.owned]" value="{{ $val['hidden'] == 'true' ? 'true' : 'false' }}">
                                                            <input type="checkbox" name="permissions[{{ ($key) }}.owned]"
                                                                   {{ @$permissionList[$key.'.owned'] == true ? 'checked' : '' }}
                                                                   value="true" class="form-check-input"> Owned
                                                            <i class="input-helper"></i>
                                                        </label>
                                                    </div>
                                                </td>
                                            @elseif(camelCaseToSpace(permissionAlias($val['methodAction'])) == 'Create' && @$type == 'advance')
                                                <td class="{{ $val['hidden'] == 'true' ? 'hidden' : '' }}">
                                                    <label class="form-check-label label-keep-all">
                                                        <input type="hidden" name="permissions[{{ ($key) }}.owned]" value="{{ $val['hidden'] == 'true' ? 'true' : 'false' }}">
                                                        <input type="checkbox" name="permissions[{{ ($key) }}.owned]"
                                                               {{ @$permissionList[$key.'.owned'] == true ? 'checked' : '' }}
                                                               value="true" class="form-check-input"> Owned
                                                        <i class="input-helper"></i>
                                                    </label>
                                                </td>
                                            @endif
                                        <td class="{{ $val['hidden'] == 'true' ? 'hidden' : '' }}">
                                            @if(@!$type || @$type == 'basic' )
                                            <div class="form-check role-checker form-check-primary">
                                                <label class="form-check-label label-keep-all">
                                                    <input type="hidden" name="permissions[{{$val['routeName']}}]" value="{{ $val['hidden'] == 'true' ? 'true' : 'false' }}">
                                                    <input type="checkbox" name="permissions[{{$val['routeName']}}]"
                                                           {{ @$permissionList[$val['routeName']] == true ? 'checked' : '' }}
                                                           value="true" class="form-check-input">
                                                    {{ camelCaseToSpace(permissionAlias($val['methodAction'])) }}
                                                    <i class="input-helper"></i>
                                                </label>
                                            </div>
                                            @else
                                               <label class="form-check-label label-keep-all">
                                               <input type="hidden" name="permissions[{{$val['routeName']}}]" value="{{ $val['hidden'] == 'true' ? 'true' : 'false' }}">
                                               <input type="checkbox" name="permissions[{{$val['routeName']}}]"
                                                      {{ @$permissionList[$val['routeName']] == true ? 'checked' : '' }}
                                                      value="true" class="form-check-input">
                                                   {{ camelCaseToSpace(permissionAlias($val['methodAction'])) }}
                                                   <i class="input-helper"></i>
                                               </label>
                                            @endif
                                        </td>
                                    @endforeach

                                    @if($max > count($routes))
                                        @php
                                            $count = $max - count($routes);
                                        @endphp
                                        @for ($i=0;$i < $count;$i++)
                                            <td> </td>
                                        @endfor
                                    @endif

                                </tr>
                            @endForeach
                            </tbody>
                        </table>
                        <br>
                        <br>
                        <div class="">
                            <button type="submit" class="btn btn-info btn-fw btn-lg mr-2">Submit</button>
                            <a href="{{ route('permission.index') }}" class="btn btn-secondary btn-fw btn-lg">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
