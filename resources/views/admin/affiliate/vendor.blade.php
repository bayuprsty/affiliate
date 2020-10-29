@extends('layouts.admin')

@section('title')
    <title>Affiliate</title>
@endsection

@section('content')
<main class="main">
    <div class="container-fluid" style="padding: 0px 0px 0px 0px;">
        <div class="animated fadeIn">
            <div class="col-md-12">
                <div class="card shadow mb-2">
                    <div class="card-header bg-info">
                        <span class="text-xl font-weight-bold text-white text-uppercase mb-1">Affiliate</span>
                    </div>
                    <div class="card-body">
                        <div class="col-md-12">
                            <table class="table table-hover table-outline" id="affiliate_vendor_list" style="font-size: 13px;">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Username Affiliate</th>
                                        <th>Vendor</th>
                                        <th>Commission</th>
                                        <th>Click</th>
                                        <th>SignUp</th>
                                        <th>Conversions</th>
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
    @extends('admin.affiliate._modal_detail_affiliate')
</main>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        var affiliateVendorList = $('#affiliate_vendor_list').DataTable({
            processing: true,
            serverside: true,
            bLengthChange : false,
            dom: '<"toolbar">frtip',
            initComplete: function(){
                $("div.toolbar")
                    .html('<a href="{{ route("affiliate.index") }}" style="float: left;" class="btn btn-primary btn-sm" style="margin-left: 15px;">Data Per Affiliate</a>');           
            },
            ajax: {
                url: "{{ route('datatableAffiliateVendorAdmin') }}",
            },
            columnDefs: [
                { orderable: false, targets: [0, 3, 4, 5, 6, 7] },
            ],
            columns: [
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                },  
                {data: 'username', name: 'username'},
                {data: 'vendor_name', name: 'vendor_name'},
                {data: 'commission', name: 'commission'},
                {data: 'click', name: 'click'},
                {data: 'signup', name: 'signup'},
                {data: 'conversion', name: 'conversion'},
                {data: 'action', name: 'action'}
            ],
        });

        $('body').on('click', '#detailAffiliateVendor', function() {
            var id_user = $(this).attr('data-id');
            var id_vendor = $(this).attr('data-vendor');
            
            $.ajax({
                url: "{{ route('affiliate.detailVendor') }}", // dimunculkan semua user dengan semua vendor
                method: "GET",
                datatype: "JSON",
                data:{
                    user_id: id_user,
                    vendor_id: id_vendor
                },
                success: function(res) {
                    $('#modal-detail-affiliate').modal('show');
                    $('#id').html(res.detail.user_id);
                    $('#balance').html(res.detail.balance);
                    $('#click').html(res.detail.click);

                    $('#username').html(res.detail.username_aff);
                    $('#commission').html(res.detail.commission);
                    $('#signup').html(res.detail.signup);

                    $('#no_telepon').html(res.detail.no_telepon);
                    $('#transaction').html(res.detail.transaction_count);
                    $('#conversion').html(res.detail.conversion);

                    $('#email').html(res.detail.email);

                    generateTransactionAffiliate(id_user, id_vendor);
                }
            })
        });
    });

    function generateTransactionAffiliate(id_user, id_vendor) {
        $('#detail_transaction_affiliate').DataTable().destroy();

        var detailTransactionAffiliate = $('#detail_transaction_affiliate').DataTable({
            processing: true,
            serverside: true,
            bLengthChange : false,
            searching: false,
            ajax: {
                url: "{{ route('datatableDetailAffiliateAdmin') }}",
                data: function(d) {
                    d.user_id = id_user,
                    d.vendor_id = id_vendor
                }
            },
            columnDefs: [
                { orderable: false, targets: [0, 4, 5, 6, 7] },
            ],
            columns: [
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                },  
                {data: 'customer_name', name: 'customer_name'},
                {data: 'product_service', name: 'product_service'},
                {data: 'vendor_name', name: 'vendor_name'},
                {data: 'transaction_date', name: 'transaction_date'},
                {data: 'amount', name: 'amount'},
                {data: 'commission', name: 'commission'},
                {data: 'status', name: 'status'}
            ],
        });
    }
</script>
@endsection