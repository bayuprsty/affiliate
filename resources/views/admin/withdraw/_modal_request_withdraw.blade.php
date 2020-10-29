<div class="modal fade" id="modal-request-withdrawal" role="dialog" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><button class="btn btn-light btn-sm" data-dismiss="modal"><i class="fa fa-chevron-left"></i></button> &ensp;Tambah Minimum Payout</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="payoutForm">
                    <input type="hidden" name="withdrawal_id" id="withdrawalId">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Transaction ID</label>
                        <div class="col-sm-9">
                            <input type="text" id="transactionId" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nomor Rekening</label>
                        <div class="col-sm-9">
                            <input type="text" id="nomorRekening" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Atas Nama</label>
                        <div class="col-sm-9">
                            <input type="text" id="atasNama" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Total Harus Dibayarkan</label>
                        <div class="col-sm-9">
                            <input type="text" id="total" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Membayarkan</label>
                        <div class="col-sm-9">
                            <input type="text" name="payout" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12 text-center">
                            <button class="btn btn-warning btn-xs" id="button-submit">PAYOUT</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>