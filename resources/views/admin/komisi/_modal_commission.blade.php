<div class="modal fade" id="modal-commission" role="dialog" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><button class="btn btn-light btn-sm" data-dismiss="modal"><i class="fa fa-chevron-left"></i></button> &ensp;Tambah Services</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="commissionForm">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Vendor</label>
                        <div class="col-sm-9">
                            <select name="vendor_id" id="vendorList" class="form-control form-control-sm" required>
                                <option value="0">-- Select Vendor --</option>
                                @foreach($vendor as $value)
                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Title</label>
                        <div class="col-sm-9">
                            <input type="text" id="commissionTitle" name="title" placeholder="Title" class="form-control form-control-sm" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Description</label>
                        <div class="col-sm-9">
                            <input type="text" id="commissionDescription" name="description" placeholder="Description" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Service Link</label>
                        <div class="col-sm-9">
                            <input type="text" id="commissionServiceLink" name="service_link" placeholder="Service Link" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Comission</label>
                        <div class="col-sm-9">
                            @foreach($commissionType as $value)
                            <div class="form-check form-check-inline mr-1" id="commissionTypeList">
                                <input type="radio" name="commission_type_id" class="form-check-input" value="{{ $value->id }}">
                                <label class="form-check-label">{{ $value->name }}</label>
                            </div>
                            @endforeach
                        </div>
                        <label class="col-sm-3 col-form-label"></label>
                        <div class="col-sm-9">
                            <input type="text" id="commissionValue" name="commission_value" placeholder="Commission Value" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12 text-center">
                            <input type="hidden" name="idCommission" id="idCommission">
                            <button class="btn btn-primary btn-xs" id="button-submit" data-id=""></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>