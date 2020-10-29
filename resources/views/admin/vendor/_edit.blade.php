@extends('layouts.admin')

@section('title')
    <title>Edit Vendor</title>
@endsection

@section('content')
<main class="main">
    <div class="container-fluid" style="padding: 0px 0px 0px 0px;">
        <div class="animated fadeIn">
            <div class="col-md-12">
                <div class="card shadow mb-4">
                    <div class="card-header bg-info">
                        <a href="{{ route('vendor.index') }}" class="btn btn-info btn-sm"><i class="fa fa-chevron-left"></i></a> &ensp;
                        <span class="text-xl font-weight-bold text-white text-uppercase mb-1">Edit Vendor</span>
                    </div>
                    <div class="card-body">
                        <div class="col-md-12">
                            <form class="form-horizontal" id="vendorForm">
                                <input type="hidden" name="idVendor" value="{{ $vendor->id }}">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Vendor Name</label>
                                    <div class="col-sm-6">
                                        <input type="text" name="name" placeholder="Vendor Name" class="form-control form-control-sm" value="{{ $vendor->name }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Link</label>
                                    <div class="col-sm-6">
                                        <input type="text" name="link" placeholder="Link" class="form-control form-control-sm" value="{{ $vendor->link }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Link Embed</label>
                                    <div class="col-sm-6">
                                        <input type="text" name="link_embed" placeholder="Link Embed" class="form-control form-control-sm" value="{{ $vendor->link_embed }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Marketing Text</label>
                                    <div class="col-sm-6">
                                        <input type="text" name="marketing_text" placeholder="Marketing Text" class="form-control form-control-sm" value="{{ $vendor->marketing_text }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">No Telepon</label>
                                    <div class="col-sm-6">
                                        <input type="text" name="no_telepon" placeholder="No Telepon" class="form-control form-control-sm" value="{{ $vendor->no_telepon }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Email</label>
                                    <div class="col-sm-6">
                                        <input type="email" name="email" placeholder="Email" class="form-control form-control-sm" required value="{{ $vendor->email }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Alamat</label>
                                    <div class="col-sm-6">
                                        <input type="text" name="jalan" placeholder="Jalan" class="form-control form-control-sm" value="{{ $vendor->jalan }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"></label>
                                    <div class="col-sm-3">
                                        <input type="text" name="provinsi" placeholder="Provinsi" class="form-control form-control-sm" value="{{ $vendor->provinsi }}">
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="text" name="kabupaten_kota" placeholder="Kabupaten / Kota" class="form-control form-control-sm" value="{{ $vendor->kabupaten_kota }}">
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="text" name="kecamatan" placeholder="Kecamatan" class="form-control form-control-sm" value="{{ $vendor->kecamatan }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"></label>
                                    <div class="col-sm-3">
                                        <input type="text" name="kodepos" placeholder="Kodepos" class="form-control form-control-sm" value="{{ $vendor->kodepos }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Nomor Rekening</label>
                                    <div class="col-sm-6">
                                        <input type="text" name="nomor_rekening" placeholder="Nomor Rekening" class="form-control form-control-sm" value="{{ $vendor->nomor_rekening }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12 text-center">
                                        <button class="btn btn-primary btn-xs" id="update-button">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
@section('js')
<script>
    $(document).ready(function() {
        $('body').on('click', '#update-button', function() {
            event.preventDefault();

            $.ajax({
                url: "{{ route('vendor.update') }}",
                method: "POST",
                datatype: "JSON",
                data: $('#vendorForm').serialize(),
                success: function(res) {
                    if (res.code == 200) {
                        window.location.href = "{{ route('vendor.index') }}";
                        $.notify(res.message, "success");
                    }
                }
            });
        })
    })
</script>
@endsection