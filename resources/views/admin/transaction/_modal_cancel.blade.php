<div class="modal fade" id="modal-cancel-transaction" role="dialog" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><button class="btn btn-light btn-sm" data-dismiss="modal"><i class="fa fa-chevron-left"></i></button> &ensp;Cancel Transaction</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="transactionCancelForm">
                    <input type="hidden" name="id_transaction" id="idTransaction">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Alasan</label>
                        <div class="col-sm-9">
                            <textarea type="text" name="cancel_reason" class="form-control" rows="5"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12 text-center">
                            <button class="btn btn-warning btn-xs" id="button-cancel">Proses</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>