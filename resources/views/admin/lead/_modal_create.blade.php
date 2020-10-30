<div class="modal fade" id="modal-create-lead" role="dialog" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><button class="btn btn-light btn-sm" data-dismiss="modal"><i class="fa fa-chevron-left"></i></button> &ensp;Tambah Lead</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="leadCreateForm">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Username Affiliate</label>
                        <div class="col-sm-9">
                            <select name="user_id" class="form-control form-control-sm" style="width: 100%;" id="username_aff" required></select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Vendor Name</label>
                        <div class="col-sm-9">
                            <select name="vendor_id" class="form-control form-control-sm" required>
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
                        <div class="col-sm-12 text-center">
                            <button class="btn btn-warning btn-xs" id="button-store">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>