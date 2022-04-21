<div id="delete-modal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Konfirmasi</h4>
                </div>
                <div class="modal-body">
                    <p id="text-body-confirm">{!! trans('label.delete_confirmation') !!}</p>
                </div>
                <div class="modal-footer">
                    {!! Form::open(['id' => 'destroy', 'method' => 'delete']) !!}
                        <a id="delete-modal-cancel" href="#" class="btn btn-default pull-left" data-dismiss="modal">
                            <i class="fa fa-times m-right-10"></i> Cancel
                        </a>
                        <button class="btn btn-success" id="submit" type="submit">
                            <i class="fa fa-check m-right-10"></i> Lanjutkan
                        </button>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

<div id="delete-modal-empty" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Konfirmasi</h4>
            </div>
            <div class="modal-body">
                <p id="text-body-confirm">Anda yakin akan menghapus gambar ini?</p>
            </div>
            <div class="modal-footer">
                <a id="delete-modal-cancel" href="#" class="btn btn-default pull-left" data-dismiss="modal">
                    <i class="fa fa-times m-right-10"></i> Cancel
                </a>
                <button class="btn btn-success" id="submit-empty" type="submit">
                    <i class="fa fa-check m-right-10"></i> Lanjutkan
                </button>
            </div>
        </div>
    </div>
</div>
