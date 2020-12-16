<div class="modal fade" id="modal-lead-process" role="dialog" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><button class="btn btn-light btn-sm" data-dismiss="modal"><i class="fa fa-chevron-left"></i></button> &ensp;Lead Process</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="leadProsesForm">
                    <fieldset id="prosesLeadFieldset">
                        <input type="hidden" name="lead_id" id="leadId">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Username Aff</label>
                            <div class="col-sm-9">
                                <input type="text" id="usernameAffiliate" class="form-control" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Customer Name</label>
                            <div class="col-sm-9">
                                <input type="text" id="customerName" class="form-control" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Product/Services</label>
                            <div class="col-sm-9">
                                <select name="service_commission_id" id="productService" class="form-control" required>
                                    
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Date</label>
                            <div class="col-sm-9">
                                <input type="date" name="transaction_date" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Amount</label>
                            <div class="col-sm-9">
                                <input type="text" id="amount" name="amount" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Commission</label>
                            <div class="col-sm-9">
                                <input type="text" id="commission" class="form-control" name="commission">
                                <i style="font-size: 12px; color: red">* Jika di kosongi maka akan diisi otomatis oleh system sesuai dengan komisi dari product service</i>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12 text-center">
                                <button class="btn btn-warning btn-xs" id="button-submit">Simpan</button>
                                
                                <div id="loader" style="float: right; display: none;">
                                    <img src="/uploads/spinner.gif" witdth="35px" height="35px"/>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>