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
                            <table class="table table-hover table-outline" id="affiliate_list" style="font-size: 13px;">
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
        var affiliateList;
        var detailTransactionAffiliate;

        dataAffiliateList();

        $('body').on('click', '#vendor-button', function() {
            affiliateList.destroy();
            dataVendorList();
        });

        $('body').on('click', '#affiliate-button', function() {
            affiliateList.destroy();
            dataAffiliateList();
        });

        $('body').on('click', '#detailAffiliate', function() {
            var id_user = $(this).attr('data-id');
            var id_vendor = $(this).attr('data-vendor');
            
            $.ajax({
                url: "{{ route('affiliate.detail') }}",
                method: "GET",
                datatype: "JSON",
                data:{
                    user_id: id_user,
                    vendor_id: id_vendor,
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

        function dataAffiliateList() {
            affiliateList = $('#affiliate_list').DataTable({
                processing: true,
                serverside: true,
                bLengthChange : false,
                dom: '<"toolbar">frtip',
                initComplete: function(){
                    $("div.toolbar")
                        .html('<button id="vendor-button" style="float: left;" class="btn btn-primary btn-sm" style="margin-left: 15px;">Data Per Vendor</button>');
                    $("#affiliate_list").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");
                },
                ajax: {
                    url: "{{ route('datatableAffiliateAdmin') }}",
                },
                columnDefs: [
                    { orderable: false, targets: [0, 3, 4, 5, 6, 7] },
                ],
                columns: [
                    {
                        title: 'No',
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                    },  
                    {
                        title: 'Username Aff',
                        data: 'username',
                        name: 'username'
                    },
                    {
                        title: 'Balance',
                        data: 'balance',
                        name: 'balance'
                    },
                    {
                        title: 'Commission',
                        data: 'commission',
                        name: 'commission'
                    },
                    {
                        title: 'Click',
                        data: 'click',
                        name: 'click'
                    },
                    {
                        title: 'Signup',
                        data: 'signup',
                        name: 'signup'
                    },
                    {
                        title: 'Conversion',
                        data: 'conversion',
                        name: 'conversion'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    }
                ],
            });
        }

        function dataVendorList() {
            affiliateList = $('#affiliate_list').DataTable({
                processing: true,
                serverside: true,
                bLengthChange : false,
                dom: '<"toolbar">frtip',
                initComplete: function(){
                    $("div.toolbar")
                        .html('<button id="affiliate-button" style="float: left;" class="btn btn-primary btn-sm" style="margin-left: 15px;">Data Per User</button>');           
                    $("#affiliate_list").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");
                },
                ajax: {
                    url: "{{ route('datatableAffiliateVendorAdmin') }}",
                },
                columnDefs: [
                    { orderable: false, targets: [0, 3, 4, 5, 6, 7] },
                ],
                columns: [
                    {
                        title: 'No',
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                    },  
                    {
                        title: 'Username',
                        data: 'username',
                        name: 'username'
                    },
                    {
                        title: 'Vendor',
                        data: 'vendor_name',
                        name: 'vendor_name'
                    },
                    {
                        title: 'Commission',
                        data: 'commission',
                        name: 'commission'
                    },
                    {
                        title: 'Click',
                        data: 'click',
                        name: 'click'
                    },
                    {
                        title: 'Signup',
                        data: 'signup',
                        name: 'signup'
                    },
                    {
                        title: 'Conversion',
                        data: 'conversion',
                        name: 'conversion'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    }
                ],
            });
        }

        function generateTransactionAffiliate(id_user, id_vendor) {
            $('#detail_transaction_affiliate').DataTable().destroy();
            
            detailTransactionAffiliate = $('#detail_transaction_affiliate').DataTable({
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
    });
</script>
@endsection