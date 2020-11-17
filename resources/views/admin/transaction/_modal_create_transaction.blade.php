<div class="modal fade" id="modal-create-transaction" role="dialog" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><button class="btn btn-light btn-sm" data-dismiss="modal"><i class="fa fa-chevron-left"></i></button> &ensp;Tambah Transaction</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="transactionCreateForm">
                    <fieldset id="transactionFieldset">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Username Affiliate</label>
                            <div class="col-sm-9">
                                <select name="user_id" class="form-control form-control-sm" style="width: 100%;" id="username_aff" required></select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Vendor Name</label>
                            <div class="col-sm-9">
                                <select name="vendor_id" class="form-control form-control-sm" id="vendor_id" required>
                                    <option value="">-- Select Vendor --</option>
                                    @foreach($vendor as $value)
                                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Customer Name</label>
                            <div class="col-sm-9">
                                <input type="text" name="customer_name" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Email</label>
                            <div class="col-sm-9">
                                <input type="email" name="email" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Nomor Telepon</label>
                            <div class="col-sm-9">
                                <input type="text" name="no_telepon" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Date</label>
                            <div class="col-sm-9">
                                <input type="date" name="date" class="form-control" required>
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
                            <label class="col-sm-3 col-form-label">Amount</label>
                            <div class="col-sm-9">
                                <input type="text" id="amount" name="amount" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Commission ?</label>
                            <div class="col-sm-9">
                                <div class="form-check form-check-inline mr-1">
                                    <input type="radio" name="addCommission" class="form-check-input" value="1" checked>
                                    <label class="form-check-label">Ya</label>
                                    &emsp;
                                    <input type="radio" name="addCommission" class="form-check-input" value="0">
                                    <label class="form-check-label">Tidak</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row" id="commissionShow">
                            <label class="col-sm-3 col-form-label">Commission</label>
                            <div class="col-sm-9">
                                <input type="text" name="commission" class="form-control" id="commission">
                                <i style="font-size: 12px; color: red">* Jika di kosongi maka akan diisi otomatis oleh system sesuai dengan komisi dari product service</i>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12 text-center">
                                <button class="btn btn-primary btn-sm" id="button-store">Simpan</button>
                                
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