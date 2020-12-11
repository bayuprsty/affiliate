<div class="modal fade" id="modal-detail-affiliate" role="dialog" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <div class="modal-title">
                    <button class="btn btn-success btn-sm" data-dismiss="modal">
                        <i class="fa fa-chevron-left"></i>
                    </button>&ensp;
                    <span class="text-xl font-weight-bold text-white text-uppercase mb-1">Detail</span>
                </div>
            </div>
            <div class="modal-body">
                <table class="table table-responsive-sm" style="font-size: 13px;">
                    <tr>
                        <td>ID</td>
                        <td><b id="id"></b></td>
                        <td>Balance</td>
                        <td><strong id="balance"></strong></td>
                        <td>Click</td>
                        <td><b id="click"></b></td>
                    </tr>
                    <tr>
                        <td>Username Aff</td>
                        <td><span id="username"></span></td>
                        <td>Commission</td>
                        <td><span id="commission"></span></td>
                        <td>SignUp</td>
                        <td><span id="signup"></span></td>
                    </tr>
                    <tr>
                        <td>No Telepon</td>
                        <td><span id="no_telepon"></span></td>
                        <td>Total Transaction</td>
                        <td><span id="transaction"></span></td>
                        <td>Conversion</td>
                        <td><span id="conversion"></span></td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td><span id="email"></span></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </table>
                <div class="row" style="font-size: 13px;">
                    <div class="col-md-12">
                        <div class="card shadow mb-4">
                            <div class="card-header bg-info">
                                <span class="text-xl font-weight-bold text-white text-uppercase mb-1">Detail Transaksi</span>
                            </div>
                            <div class="card-body" style="overflow-y: scroll; max-height: 200px;">
                                <table class="table table-responsive-sm table-hover table-outline mb-0" style="font-size: 13px;" id="detail_transaction_affiliate">
                                    <thead class="light">
                                        <tr>
                                            <th>No</th>
                                            <th>Customer Name</th>
                                            <th>Product/Service</th>
                                            <th>Vendor</th>
                                            <th>Date</th>
                                            <th>Amount</th>
                                            <th>Commission</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>