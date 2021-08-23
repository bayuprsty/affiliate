<div class="modal fade" id="modal-request-withdrawal" role="dialog" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><button class="btn btn-light btn-sm" data-dismiss="modal"><i class="fa fa-chevron-left"></i></button> &ensp; Withdraw Requests</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="withdrawalRequestForm">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Balance</label>
                        <div class="col-sm-9">
                            <input type="text" id="commissionBalance" class="form-control" value="@currency($balance)" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Withdraw Amount</label>
                        <div class="col-sm-9">
                            <input type="text" id="withdrawAmount" name="amount" class="form-control">
                            <span>*minimal withdraw adalah @currency($minimumPayout[0]->minimum_payout)</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12 text-center">
                            <button class="btn btn-primary btn-xs" id="button-submit">Request Withdraw</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>