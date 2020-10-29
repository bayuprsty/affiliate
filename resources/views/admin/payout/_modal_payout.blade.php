<div class="modal fade" id="modal-payout" role="dialog" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><button class="btn btn-light btn-sm" data-dismiss="modal"><i class="fa fa-chevron-left"></i></button> &ensp;Tambah Minimum Payout</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="payoutForm">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Minimum Payout</label>
                        <div class="col-sm-9">
                            <input type="text" id="minimumPayout" name="minimum_payout" placeholder="Minimum Payout" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12 text-center">
                            <input type="hidden" name="idPayout" id="idPayout">
                            <button class="btn btn-primary btn-xs" id="button-submit" data-id=""></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>