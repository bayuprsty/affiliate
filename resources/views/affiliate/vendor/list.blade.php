@extends('layouts.admin')

@section('title')
    <title>Dashboard</title>
@endsection

@section('content')
<main class="main">
    <div class="container-fluid" style="padding: 0px 0px 0px 0px">
        <div class="animated fadeIn">
            <div class="col-md-12">
                <div class="card shadow mb-2">
                    <div class="card-header bg-info">
                        <span class="text-xl font-weight-bold text-white text-uppercase mb-1">Vendor List</span>
                    </div>
                    <div class="card-body">
                        <div class="col-md-12">
                            <table class="table table-condensed" id="affiliate_vendor_list" style="font-size: 12px;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Vendor</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Commission</th>
                                        <th></th>
                                        <th></th>
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
    $(document).ready(function() {
        var vendorList = $('#affiliate_vendor_list').DataTable( {
            processing: true,
            serverside: true,
            bLengthChange : false,
            searching: false,
            ajax: {
                url: "{{ route('datatableVendorAffiliate') }}",
            },
            columnDefs: [
                { orderable: false, targets: [0, 3, 4, 5, 6] },
            ],
            columns: [
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                },  
                {data: 'vendor_id', name: 'vendor_id'},
                {data: 'title', name: 'title'},
                {data: 'description', name: 'description'},
                {data: 'commission', name: 'commission'},
                {data: 'link', name: 'link'},
                {data: 'action', name: 'action'}
            ],
            order: [[1, 'ASC']],
        } );
    });

    function copyLink (id) {
        $('#link'+ id +'').select();
        document.execCommand('copy');
    }
</script>
@endsection