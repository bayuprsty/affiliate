@extends('layouts.admin')

@section('title')
    <title>Vendor</title>
@endsection

@section('content')
<main class="main">
    <div class="container-fluid" style="padding: 0px 0px 0px 0px;">
        <div class="animated fadeIn">
            <div class="col-md-12">
                <div class="card shadow mb-4">
                    <div class="card-header bg-info">
                        <span class="text-xl font-weight-bold text-white text-uppercase mb-1">Vendor</span>
                    </div>
                    <div class="card-body">
                        <div class="col-md-12">
                            <table class="table table-hover" id="vendor_list" style="font-size: 14px;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>No Telepon</th>
                                        <th>Link</th>
                                        <th>Email</th>
                                        <th>Alamat</th>
                                        <th>Nomor Rekening</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
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
    $('document').ready(function() {
        var vendorList = $('#vendor_list').DataTable( {
            processing: true,
            serverside: true,
            bLengthChange : false,
            dom: '<"toolbar">frtip',
            initComplete: function(){
                $("div.toolbar")
                    .html('<a href="{{ route("vendor.add") }}" class="btn btn-primary btn-sm" style="float: left"><i class="fa fa-plus"></i> Vendor</a>');           
            },
            ajax: {
                url: "{{ route('datatableVendorAdmin') }}",
            },
            columnDefs: [
                { orderable: false, targets: [0, 2, 3, 4, 5, 6, 7] },
                { searchable: false, targets: [0, 2, 3, 4, 5, 6, 7] },
            ],
            columns: [
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                },  
                {data: 'name', name: 'name'},
                {data: 'no_telepon', name: 'no_telepon'},
                {data: 'link', name: 'link'},
                {data: 'email', name: 'email'},
                {
                    data: 'alamat',
                    name: 'alamat'
                },
                {data: 'nomor_rekening', name: 'nomor_rekening'},
                {
                    data: 'action',
                    name: 'action'
                }
            ],
        } );

        $('body').on('click', '#button-delete', function(e) {
            var id = $(this).attr('data-id');

            $.ajax({
                url: "{{ route('vendor.destroy') }}",
                method: "POST",
                datatype: "JSON",
                data: {id: id},
                success: function(res) {
                    if (res.code == 200) {
                        $.notify(res.message, "success");
                        vendorList.ajax.reload();
                    } else {
                        $.notify(res.message, "error");
                    }
                }
            })
        })
    })
</script>
@endsection