<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @php
        $appName = config('app.name', 'Project');
        $settingAppName = @getSettings()->application_name;
        if($settingAppName != ''){
            $appName = $settingAppName;
        }
    @endphp
    <title>{{ $settingAppName }} - @yield('title')</title>
    <!-- plugins:css -->
    {!! Html::style('assets/backend/vendors/mdi/css/materialdesignicons.min.css') !!}
    {!! Html::style('assets/backend/vendors/css/vendor.bundle.base.css') !!}
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    {!! Html::style('assets/backend/css/style.css') !!}
    {!! Html::style('assets/backend/css/custom.css') !!}
    {{--{!! Html::style('assets/backend/vendors/datatables/datatables.bootsrap4.css') !!}--}}
    {!! Html::style('assets/backend/vendors/select2/css/select2.min.css') !!}
    {!! Html::style('assets/backend/vendors/jquery-confirm/jquery-confirm.min.css') !!}
    {!! Html::style('assets/backend/vendors/toastr/toastr.min.css') !!}
    {!! Html::style('assets/backend/vendors/select2-bootstrap4-theme/select2-bootstrap4.css') !!}
    {!! Html::script('assets/backend/vendors/moment/moment-with-locales.min.js') !!}
    {!! Html::script('assets/backend/vendors/moment/moment-timezone-with-data.js') !!}
    {!! Html::style('assets/backend/vendors/daterangepicker/daterangepicker.css') !!}
    {!! Html::style('assets/backend/vendors/summernote/summernote.css') !!}
    {!! Html::style('assets/backend/vendors/summernote/summernote-bs4.css') !!}
    {{--<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css"/>--}}
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css"/>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css"/>
    {!! Html::script('assets/backend/vendors/moment/moment-timezone-with-data.js') !!}
    <!-- End layout styles -->
    @if(@getSettings()->favicon != '')
        <link rel="shortcut icon" href="{{ @get_file(@getSettings()->favicon,'original') }}" />
    @else
        <link rel="shortcut icon" href="{{ URL::to('/') }}/images/favicon.png" />
    @endif
</head>
<body class="{{ @getSettings()->allow_full_sidebar == true ? '' : 'sidebar-icon-only' }}">
<div class="container-scroller">
    @include('flash::message')
    @include('layouts.navbar')
    <div class="container-fluid page-body-wrapper">
        @include('layouts.sidebar')
        <div class="main-panel">
            @yield('content')
        </div>
    </div>
</div>
<!-- container-scroller -->
<!-- plugins:js -->
{!! Html::script('assets/backend/vendors/js/vendor.bundle.base.js') !!}
<!-- endinject -->
<!-- Plugin js for this page -->
<!-- End plugin js for this page -->
<!-- inject:js -->
{!! Html::script('assets/backend/js/off-canvas.js') !!}
{!! Html::script('assets/backend/js/hoverable-collapse.js') !!}
{!! Html::script('assets/backend/js/misc.js') !!}
{!! Html::script('assets/backend/js/file-upload.js') !!}
{!! Html::script('assets/backend/js/helper.js') !!}
<!-- endinject -->
<!-- Custom js for this page -->
{{--{!! Html::script('assets/backend/vendors/datatables/jquery.dataTables.min.js') !!}--}}
{{--{!! Html::script('assets/backend/vendors/datatables/dataTables.bootstrap4.js') !!}--}}
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js"></script>
{!! Html::script('assets/backend/vendors/select2/js/select2.full.min.js') !!}
{!! Html::script('assets/backend/vendors/jquery-confirm/jquery-confirm.min.js') !!}
{!! Html::script('assets/backend/vendors/toastr/toastr.min.js') !!}
{!! Html::script('assets/backend/vendors/daterangepicker/daterangepicker.js') !!}
{!! Html::script('assets/backend/vendors/summernote/summernote.js') !!}
{!! Html::script('assets/backend/vendors/summernote/summernote-bs4.js') !!}
<!-- End custom js for this page -->
<script>
    $('.select2').select2({
        placeholder: 'Please Select',
        theme: 'bootstrap4',
        width: '100%',
        allowClear: true   // Shows an X to allow the user to clear the value.
    });

    $('.datetimepicker').daterangepicker({
        autoUpdateInput:false,
        singleDatePicker: true,
        timePicker:true,
        timePicker24Hour: true,
        showDropdowns: true,
        defaultValue:null,
        minDate: moment.tz('Asia/Jakarta').add(1,'days').format('DD/MM/YYYY hh:mm'),
        showWeekNumbers:true,
        maxDate: moment().tz('Asia/Jakarta').add(1,'years'),
        locale: {
            format: 'DD-MM-YYYY H:mm'
        }
    });

    $('.datetimepicker').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD-MM-YYYY H:mm'));
    });

    $('.datetimepicker').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });

    $(document).ready(function () {

        $('.summernote').summernote({
            height: 200
        });

        $('.dropify').dropify();

        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        $('.select2.form-control-danger').parent().find('.select2.select2-container').addClass('form-control-danger');
        $('.summernote.form-control-danger').parent().find('.note-editor.note-frame').addClass('form-control-danger');

        @if(Session::has('success'))
            toastr.success("{!! session('success') !!}");
        @endif
        @if(Session::has('error'))
            toastr.error("{!! session('error') !!}");
        @endif

        $(document).on('click','.deleteData',function () {
            let $this = $(this);
            let url = $this.attr('data-href');
            let token = $('meta[name="csrf-token"]').attr('content');

            let data = {
                _token : token,
                _method : 'DELETE'
            };

            $.confirm({
                title: 'Confirmation!',
                theme: 'material',
                content: 'Are you sure to delete this data ?',
                buttons: {
                    confirm: function () {
                        AjaxHandler.post(
                            url,
                            data,
                            function (res) {
                                if(res==false || res=="false"){
                                    toastr.error( 'failed delete' );
                                    return
                                }

                                $this.closest('tr').slideUp(500, function () {
                                    $(this).closest('tr').remove();
                                    toastr.success( 'success deleted' );
                                })
                            },
                            function () {
                                toastr.error( 'failed delete' );
                            }
                        );
                    },
                    cancel: function () {

                    }
                }
            });
        });

        $(document).on('click','.doneData',function () {
            let $this = $(this);
            let url = $this.attr('data-href');
            let token = $('meta[name="csrf-token"]').attr('content');

            let data = {
                _token : token,
                _method : 'POST'
            };

            $.confirm({
                title: 'Confirmation!',
                theme: 'material',
                content: 'Are you sure to set done this task ?',
                buttons: {
                    confirm: function () {
                        AjaxHandler.post(
                            url,
                            data,
                            function () {
                                toastr.success( 'success updated' );
                                // location.reload();
                                $this.remove();
                            },
                            function () {
                                toastr.error( 'failed update' );
                            }
                        );
                    },
                    cancel: function () {

                    }
                }
            });
        });

        $(document).on('click','.doneDataFinance',function () {
            let $this = $(this);
            let url = $this.attr('data-href');
            let token = $('meta[name="csrf-token"]').attr('content');

            let data = {
                _token : token,
                _method : 'PATCH'
            };

            $.confirm({
                title: 'Confirmation!',
                theme: 'material',
                content: 'Are you sure to set done this task ?',
                buttons: {
                    confirm: function () {
                        AjaxHandler.post(
                            url,
                            data,
                            function () {
                                toastr.success( 'success updated' );
                                $this.closest('tr').find('td').eq(6).text('done');
                                $this.remove();
                            },
                            function () {
                                toastr.error( 'failed update' );
                            }
                        );
                    },
                    cancel: function () {

                    }
                }
            });
        });

        $(document).on('click','.deactivateRecord',function () {
            let $this = $(this);
            let url = $this.attr('data-href');
            let token = $('meta[name="csrf-token"]').attr('content');

            let data = {
                _token : token,
                _method : 'PUT',
                id : $this.attr('data-id'),
            };

            $.confirm({
                title: 'Confirmation!',
                theme: 'material',
                content: 'Are you sure to deactivate this data ?',
                buttons: {
                    confirm: function () {
                        AjaxHandler.post(
                            url,
                            data,
                            function () {
                                toastr.success( 'Deactivated Successfully' );
                                window.location.reload();
                            },
                            function () {
                                toastr.error( 'failed deactivated' );
                            }
                        );
                    },
                    cancel: function () {

                    }
                }
            });
        });

        $(document).on('click','.activateRecord',function () {
            let $this = $(this);
            let url = $this.attr('data-href');
            let token = $('meta[name="csrf-token"]').attr('content');

            let data = {
                _token : token,
                _method : 'PUT',
                id : $this.attr('data-id'),
            };

            $.confirm({
                title: 'Confirmation!',
                theme: 'material',
                content: 'Are you sure to activate this data ?',
                buttons: {
                    confirm: function () {
                        AjaxHandler.post(
                            url,
                            data,
                            function () {
                                toastr.success( 'Activated Successfully' );
                                window.location.reload();
                            },
                            function () {
                                toastr.error( 'failed Activated' );
                            }
                        );
                    },
                    cancel: function () {

                    }
                }
            });
        });

        $('[data-toggle="tooltip"]').tooltip()
    });


    const asyncIntervals = [];
    const runAsyncInterval = async (cb, interval, intervalIndex) => {
        await cb(intervalIndex)
        if (asyncIntervals[intervalIndex]) {
            setTimeout(() => runAsyncInterval(cb, interval, intervalIndex), interval)
        }
    };
    const setAsyncInterval = (cb, interval) => {
        if (cb && typeof cb === "function") {
            const intervalIndex = asyncIntervals.length
            asyncIntervals.push(true)
            runAsyncInterval(cb, interval, intervalIndex)
            return intervalIndex
        } else {
            throw new Error('Callback must be a function')
        }
    };
    const clearAsyncInterval = (intervalIndex) => {
        if (asyncIntervals[intervalIndex]) {
            asyncIntervals[intervalIndex] = false
        }
    };

    const onExist = (str,complete=()=>{},limit=5000)=>{
        const interval = 100
        let current = 0
        let id = setAsyncInterval(async (index) => {
            if(current>=limit){
                clearAsyncInterval(index)
                return
            }

            current+=interval

            if($(str).length<=0){ return }

            complete()

            clearAsyncInterval(index)
        }, interval)
    }

    const hasClass = (str,cls,limit=5000)=>{
        const interval = 100
        let res = false
        let current = 0
        let id = setAsyncInterval(async (index) => {
            if(current>=limit){
                clearAsyncInterval(index)
                return false
            }
            current+=interval
            if(!$(str).hasClass(cls)){ return false }
            clearAsyncInterval(index)
            res = true
            return true
        }, interval)
        return res
    }

    const setCustomFilterDatatable = (params)=>{
        let siModule = setInterval(() => {
            let section = params.section,
                filter = params.filter,
                cloned = ""

            // check if section exist
            if(section.length<=0){ return }

            // clone original
            cloned = filter.clone().removeClass("hidden")

            // remove original
            filter.remove()

            // paste cloned
            section.html(cloned)

            typeof params.complete == "function" ? params.complete(cloned,section) :()=>{}

            clearInterval(siModule)
        }, 100)
    }

    const resizeSelect2FilterDatatable = (select, section)=>{
        var parent = parseInt(section.css("width").replaceAll("px"))
        var text = parseInt(select.prev().css("width").replaceAll("px"))
        var right = parseInt(section.css("padding-right").replaceAll("px"))
        select.next()
            .css("width",(parent-text-right)+"px")
            .css("max-width",(parent-text-right)+"px")
    }

    const triggerFilterOrDrawDatatable = (table,select,state,stateKey)=>{
        var table = $(`#${table}`)
        var options = select.find("option:not(:disabled)")
        var value = state!=null && state[stateKey]!=null ? state[stateKey] : $(options[0]).attr("value")
        select.val(value).trigger('change')
        if(select.val()==null && options.length>0){
            select.val($(options[0]).attr("value")).trigger('change')
        }else if(options.length<=0 || select.val()!=value){
            table.DataTable().search($(`#${table.attr("id")}_filter input`).val()).draw()
        }
    }

    $.fn.dataTable.ext.errMode = function ( settings, helpPage, message ) {
        toastr.error(message,"Error",{timeOut: 10000})
    }
</script>
@yield('scripts')
</body>
</html>
