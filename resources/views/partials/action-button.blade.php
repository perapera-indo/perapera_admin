@if( isset( $create_url ) )

    <a href="{!! empty( $create_url ) ? 'javascript:void(0)' : $create_url !!}" class="btn btn-primary btn-xs {!! empty( $create_url ) ? 'disabled' : '' !!}" title="Create" data-button="create">
        <i class="material-icons">forward</i>
    </a>
@endif

{{--@if( isset( $show_url ) )--}}
    {{--<a href="{!! empty( $show_url ) ? 'javascript:void(0)' : $show_url !!}" class="btn btn-info btn-xs {!! empty( $show_url ) ? 'disabled' : '' !!}" title="Show" data-button="show">--}}
        {{--<i class="material-icons">visibility</i>--}}
    {{--</a>--}}
{{--@endif--}}

@if( isset( $show_url ) )
    <a href="{!! empty( $show_url ) ? 'javascript:void(0)' : $show_url !!}" class="btn btn-info btn-xs {!! empty( $show_url ) ? 'disabled' : '' !!}" title="Show" data-button="Show">
        <i class="material-icons">visibility</i>
    </a>
@endif

@if( isset( $availability_url ) )
    <a href="{!! empty( $availability_url ) ? 'javascript:void(0)' : $availability_url !!}" class="btn btn-info btn-xs {!! empty( $availability_url ) ? 'disabled' : '' !!}" title="Availability" data-button="Availability">
        <i class="material-icons">date_range</i>
    </a>
@endif

@if( isset( $show_url2 ) )
    <a href="{!! empty( $show_url2 ) ? 'javascript:void(0)' : $show_url2 !!}" class="btn btn-success btn-xs {!! empty( $show_url2 ) ? 'disabled' : '' !!}" title="Show" data-button="show">
        <i class="fa fa-eye fa-fw"></i>
    </a>
@endif

@if( isset( $print_pdf ) )
    <a href="{!! empty( $print_pdf ) ? 'javascript:void(0)' : $print_pdf !!}" class="btn btn-warning btn-xs {!! empty( $print_pdf ) ? 'disabled' : '' !!}" title="Print/PDF" data-button="print">
        <i class="fa fa-print fa-fw"></i>
    </a>
@endif

@if (isset( $detail_url ))
    <a href="javascript:void(0)" id="detailData" class="btn btn-info detailData btn-xs {!! empty( $detail_url ) ? 'disabled' : '' !!}" title="Detail" data-href="{!! empty( $detail_url ) ? 'javascript:void(0)' : $detail_url !!}" data-button="Detail">
        <i class="fa fa-info fa-fw"></i>
    </a>
@endif

@if( isset( $edit_url ) && checkPermissionAccessByUrl($edit_url,null,(isset($__route_name))?$__route_name:null) )
    <a href="{!! empty( $edit_url ) ? 'javascript:void(0)' : $edit_url !!}" class="btn btn-success btn-xs {!! empty( $edit_url ) ? 'disabled' : '' !!}" title="Edit" data-button="edit">
        <i class="material-icons">edit</i>
    </a>
@endif

@if( isset( $add_url ) && checkPermissionAccessByUrl($add_url,null,(isset($__route_name_add))?$__route_name_add:null) )
    <a href="{!! empty( $add_url ) ? 'javascript:void(0)' : $add_url !!}" class="btn btn-success btn-xs {!! empty( $add_url ) ? 'disabled' : '' !!}" title="Add" data-button="add">
        <i class="mdi mdi-arrow-right-bold-circle"></i>
    </a>
@endif

@if( isset( $translate_url ) )
    <a href="{!! empty( $translate_url ) ? 'javascript:void(0)' : $translate_url !!}" class="btn btn-primary btn-xs {!! empty( $translate_url ) ? 'disabled' : '' !!}" title="Translate" data-button="Transalate">
        <i class="material-icons">translate</i>
    </a>
@endif

@if( isset( $reset_password ) )
    <a href="{!! empty( $reset_password ) ? 'javascript:void(0)' : $reset_password !!}" class="btn btn-warning btn-xs {!! empty( $reset_password ) ? 'disabled' : '' !!}" title="Reset" data-button="reset">
        <i class="material-icons">data_usage</i>
    </a>
@endif
@if( isset( $delete_url ) && checkPermissionAccessByUrl($delete_url,'delete',(isset($__route_name_delete))?$__route_name_delete:null))
    <a href="javascript:void(0)" id="deleteData" class="deleteData btn btn-danger btn-xs {!! empty( $delete_url ) ? 'disabled' : '' !!}" title="Delete" data-toggle="tooltip" data-original-title="Delete" data-href="{!! empty( $delete_url ) ? 'javascript:void(0)' : $delete_url !!}" data-button="delete">
        <i class="material-icons">delete</i>
    </a>
@endif
@if( !empty( $cancel_order ) )
    <a
        href="javascript:void(0)"
        id="cancel_order"
        class="btn btn-danger btn-xs {!! empty( $cancel_order ) ? 'disabled' : '' !!}"
        title="Cancel Order"
        data-order-id="{!! empty( $order_id ) ? '0' : $order_id !!}"
        data-comment="{!! empty( $comment ) ? '' : $comment !!}"
        data-button="delete"
    >
        <i class="fa fa-trash-o fa-fw"></i>
    </a>
@endif
@if( isset( $status ) )
    <label class="switch">
        <input type="checkbox" {!! ($status == 1 || $status != null) ? 'checked' : '' !!} id="updateStatus" data-href="{!! $updateStatus_url !!}" data-button="{!! ($status != null)?$status:0 !!}">
        <div class="slider round" data-href="{!! $updateStatus_url !!}" data-button="{!! ($status != null)?$status:0 !!}"></div>
    </label>
@endif
@if( isset( $permission_url ) )
    <a href="{{$permission_url}}" class="btn btn-success permission-role btn-xs" title="Manage Permission">
        <i class="fa fa-exchange fa-fw"></i>
    </a>
@endif
@if( isset( $accept_url ) )
    @if (@!$user->completed)
        <a href="javascript:void(0)" id="acceptData" class="btn btn-success activation-user btn-xs {!! empty( $accept_url ) ? 'disabled' : '' !!}" title="Accept" data-href="{!! empty( $accept_url ) ? 'javascript:void(0)' : $accept_url !!}" data-button="Accept">
            <i class="fa fa-check-square fa-fw"></i>
        </a>
    @endif
@endif
@if (isset( $approve_url ))
    <a href="{!! empty( $approve_url ) ? 'javascript:void(0)' : $approve_url !!}" class="btn btn-success btn-xs {!! empty( $approve_url ) ? 'disabled' : '' !!}" title="Edit" data-button="edit">
        <i class="material-icons">check</i>
    </a>
@endif

@if (isset( $actived_again ))
    <a href="{{ $actived_again }}" class="btn btn-warning app-dec btn-xs {!! empty( $actived_again ) ? 'disabled' : '' !!}" title="Actived Again" data-href="{!! empty( $actived_again ) ? 'javascript:void(0)' : $actived_again !!}" data-button="Actived Again">
        <i class="fa fa-check-square fa-fw"></i>
    </a>
@endif
@if (isset( $deactive_product_agent ))
    <a href="javascript:void(0)" id="deactiveProduct" class="btn btn-warning app-dec btn-xs {!! empty( $deactive_product_agent ) ? 'disabled' : '' !!}" title="Deactive Product" data-href="{!! empty( $deactive_product_agent ) ? 'javascript:void(0)' : $deactive_product_agent !!}"
    data-master-id="{!! empty( $id_product ) ? 'javascript:void(0)' : $id_product !!}"  data-button="Deactive Product">
        <i class="fa fa-check-square fa-fw"></i>
    </a>
@endif
@if( isset( $decline_url ) )
    <a href="javascript:void(0)" id="declineData" class="btn btn-danger app-dec btn-xs {!! empty( $decline_url ) ? 'disabled' : '' !!}" title="Decline" data-href="{!! empty( $decline_url ) ? 'javascript:void(0)' : $decline_url !!}" data-button="Decline">
        <i class="fa fa-close fa-fw"></i>
    </a>
@endif
@if( isset( $reset ) )
    <a href="javascript:void(0)" id="resetData" class="btn btn-primary btn-xs {!! empty( $reset ) ? 'disabled' : '' !!}" title="Reset Password" data-href="{!! empty( $reset ) ? 'javascript:void(0)' : $reset !!}" data-button="Reset Password">
        <i class="fa fa-refresh fa-fw"></i>
    </a>
@endif
@if( isset( $custom_show ) )
<a href="{!! empty( $custom_show['show_url'] ) ? 'javascript:void(0)' : $custom_show['show_url'] !!}" class="btn btn-success btn-xs {!! empty( $custom_show['show_url'] ) ? 'disabled' : '' !!}" title="Show" data-button="show">
    <i class="fa fa-search fa-fw"></i> {!! empty( $custom_show['extra_caption'] ) ? "" : $custom_show['extra_caption'] !!}
</a>
@endif
@if( isset( $reset_url ) )
    <a href="javascript:void(0)" id="resetData" class="btn btn-danger btn-xs {{ empty( $reset_url ) ? 'disabled' : '' }}" title="Reset Scheduler" data-href="{{ empty( $reset_url ) ? 'javascript:void(0)' : $reset_url }}" data-button="reset">
        <i class="fa fa-refresh fa-fw"></i>
    </a>
@endif
@if( isset( $restart_url ) )
    <a href="javascript:void(0)" id="resetData" class="btn btn-danger btn-xs {{ empty( $restart_url ) ? 'disabled' : '' }}" title="Reset Alert" data-href="{{ empty( $restart_url ) ? 'javascript:void(0)' : $restart_url }}" data-button="reset">
        <i class="fa fa-refresh fa-fw"></i>
    </a>
@endif
@if( isset( $deactive_url ) )
    @if (@$user->completed)
        <a href="javascript:void(0)" id="deactiveData" class="btn btn-danger deactive-user btn-xs {!! empty( $deactive_url ) ? 'disabled' : '' !!}" title="Deactive" data-href="{!! empty( $deactive_url ) ? 'javascript:void(0)' : $deactive_url !!}" data-button="Deactive">
            <i class="fa fa-power-off fa-fw"></i>
        </a>
    @endif
@endif
@if( isset( $create_routes ) )
<a
    href="{!! empty( $create_routes ) ? 'javascript:void(0)' : $create_routes !!}"
    class="btn btn-success btn-xs {!! empty( $create_routes ) ? 'disabled' : '' !!}"
    title="{{ trans('dbo.create_routes') }}"
    data-button="create-routes"
>
    <i class="fa fa-road fa-fw"></i>
</a>
@endif
@if( isset( $assign_url ) && checkPermissionAccessByUrl($assign_url,'GET') )
    <a href="{!! empty( $assign_url ) ? 'javascript:void(0)' : $assign_url !!}" class="btn btn-primary btn-xs {!! empty( $assign_url ) ? 'disabled' : '' !!}" title="Assign Translator" data-button="edit">
        <i class="material-icons">translate</i>
    </a>
@endif
@if( isset( $assign_review_url ) && checkPermissionAccessByUrl($assign_review_url,'GET') )
    <a href="{!! empty( $assign_review_url ) ? 'javascript:void(0)' : $assign_review_url !!}" class="btn btn-warning btn-xs {!! empty( $assign_review_url ) ? 'disabled' : '' !!}" title="Assign Review" data-button="edit">
        <i class="material-icons">assignment</i>
    </a>
@endif

@if( isset( $done_url ) )
    <a href="{!! empty( $done_url ) ? 'javascript:void(0)' : $done_url !!}" class="btn btn-success btn-xs {!! empty( $done_url ) ? 'disabled' : '' !!}" title="Done" data-button="Done">
        <i class="material-icons">check_circle</i>
    </a>
@endif

@if (isset( $done_translator_url ))
    <a href="javascript:void(0)" id="doneData" class="doneData btn btn-success btn-xs {!! empty( $done_translator_url ) ? 'disabled' : '' !!}" title="Delete" data-toggle="tooltip" data-original-title="Done" data-href="{!! empty( $done_translator_url ) ? 'javascript:void(0)' : $done_translator_url !!}" data-button="done">
        <i class="material-icons">check</i>
    </a>
@endif

@if (isset( $done_reviewer_url ))
    <a href="javascript:void(0)" id="doneData" class="doneData btn btn-success btn-xs {!! empty( $done_reviewer_url ) ? 'disabled' : '' !!}" title="Delete" data-toggle="tooltip" data-original-title="Done" data-href="{!! empty( $done_reviewer_url ) ? 'javascript:void(0)' : $done_reviewer_url !!}" data-button="done">
        <i class="material-icons">check</i>
    </a>
@endif

@if( isset( $download_url ) )
    <a href="{!! empty( $download_url ) ? 'javascript:void(0)' : $download_url !!}" class="btn btn-primary btn-xs {!! empty( $download_url ) ? 'disabled' : '' !!}" title="Download" data-button="Download">
        <i class="material-icons">cloud_download</i>
    </a>
@endif

@if (isset( $send_invoice_url ))
    <a href="javascript:void(0)" id="doneData" class="sendInvoiceData btn btn-success btn-xs {!! empty( $send_invoice_url ) ? 'disabled' : '' !!}" title="Invoice" data-toggle="tooltip" data-original-title="Invoice" data-href="{!! empty( $send_invoice_url ) ? 'javascript:void(0)' : $send_invoice_url !!}" data-button="invoice">
        <i class="material-icons">receipt</i>
    </a>
@endif

@if (isset( $done_finance_url ))
    <a href="javascript:void(0)" id="doneDataFinance" class="doneDataFinance btn btn-success btn-xs {!! empty( $done_finance_url ) ? 'disabled' : '' !!}" title="Done" data-toggle="tooltip" data-original-title="Done" data-href="{!! empty( $done_finance_url ) ? 'javascript:void(0)' : $done_finance_url !!}" data-button="done">
        <i class="material-icons">check</i>
    </a>
@endif
