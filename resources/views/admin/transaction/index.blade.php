@extends('layouts.admin')

@section('title')
    <title>Transaction</title>
@endsection

@section('content')
<main class="main">
    <div class="container-fluid" style="padding: 0px 0px 0px 0px;">
        <div class="animated fadeIn">
            <div class="col-md-12">
                <div class="card shadow mb-2">
                    <div class="card-header bg-info">
                        <span class="text-xl font-weight-bold text-white text-uppercase mb-1">Transaction</span>
                    </div>
                    <div class="card-body">
                        <div class="row" style="margin: 0 auto">
                            <div class="col">
                                <select name="status_id" class="form-control form-control-sm" id="status_id">
                                    <option value="all">All Status</option>
                                    <option value="1">ON PROGRESS</option>
                                    <option value="2">SUCCESS</option>
                                    <option value="3">CANCELED</option>
                                </select>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <input type="date" class="form-control form-control-sm" id="dateStart">
                                </div>
                            </div>
                            to
                            <div class="col">
                                <div class="form-group">
                                    <input type="date" class="form-control form-control-sm" id="dateEnd">
                                </div>
                            </div>
                            <div class="col">
                                <button class="btn btn-dark btn-sm" id="searchData">Search</button>
                                <button class="btn btn-light btn-sm" id="resetData">Reset</button>
                            </div>
                            <div class="col text-right">
                                <button class="btn btn-success btn-sm" id="exportData">Export</button>
                                <button class="btn btn-warning btn-sm" id="add-transaction"><i class="fa fa-plus"></i> Transaction</button>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <table class="table table-hover table-outline" id="transaction_list" style="font-size: 13px;">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Username Aff</th>
                                        <th>Username Cust</th>
                                        <th>Vendor</th>
                                        <th>Product/Services</th>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Commission</th>
                                        <th>Created By</th>
                                        <th>Status</th>
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
    @extends('admin.transaction._modal_create_transaction')
    @extends('admin.transaction._modal_cancel')
</main>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        var transactionList = $('#transaction_list').DataTable({
            processing: true,
            serverside: true,
            bLengthChange : false,
            searching: false,
            ajax: {
                url: "{{ route('datatableTransactionAdmin') }}",
                data: function(d) {
                    d.status = $('#status_id').val();
                    d.dateStart = $('#dateStart').val();
                    d.dateEnd = $('#dateEnd').val();
                }
            },
            columnDefs: [
                { orderable: false, targets: [5, 6, 7, 8] },
                { targets: [0], visible: false },
            ],
            columns: [ 
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                },
                {data: 'username_aff', name: 'username_aff'},
                {data: 'customer_name', name: 'customer_name'},
                {data: 'vendor_name', name: 'vendor_name'},
                {data: 'product_service', name: 'product_service'},
                {data: 'transaction_date', name: 'transaction_date'},
                {data: 'amount', name: 'amount'},
                {data: 'commission', name: 'commission'},
                {data: 'created_by', name: 'created_by'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action'}
            ],
            drawCallback: function() {
                $('[data-toggle="tooltip"]').tooltip();
            },
        });

        $('#searchData').click(function() {
            transactionList.ajax.reload();
        });

        $('#resetData').click(function() {
            $('#status_id').val('all');
            $('#dateStart').val('');
            $('#dateEnd').val('');
            transactionList.ajax.reload();
        });

        $('body').on('click', '#exportData', function() {
            if(transactionList.rows().data().length == 0) {
                $.notify("Can't export as PDF. Data is Empty", {type:"warning"});
                return false;
            }
            
            status = $('#status_id').val() ? $('#status_id').val() : 'all';
            dateStart = $('#dateStart').val() ? $('#dateStart').val() : 'all';
            dateEnd = $('#dateEnd').val() ? $('#dateEnd').val() : 'all';

            window.open("downloadPdf/" + status + "/" + dateStart + "/" + dateEnd, "_blank");
        });

        $('body').on('click', '#add-transaction', function() {
            $('#transactionCreateForm').trigger("reset");
            $('#modal-create-transaction').modal('show');
        });

        $('#username_aff').select2({
            placeholder: '-- Select User Affiliate --',
            ajax: {
                url: "{{ route('ajax.getUserAffiliate') }}",
                datatype: "JSON",
                delay: 250,
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                id: item.id,
                                text: item.id + ' - ' + item.nama
                            }
                        })
                    }
                }
            }
        });

        $('#vendor_id').on('change', function() {
            var vendor_id = $(this).val();
            
            $.ajax({
                url: "{{ route('ajax.getProductService') }}",
                datatype: "JSON",
                data: {id_vendor: vendor_id},
                success: function(res) {
                    $('#productService').html(res.service).trigger("change");
                }
            })
        });

        $('input:radio[name="addCommission"]').on('change', function() {
            var show = $(this).val();
            
            if (show == 1) {
                $('#commissionShow').css("visibility", "visible");
            } else {
                $('#commissionShow').css("visibility", "hidden");
            }
        });

        $('#productService').on('change', function() {
            var service_id = $(this).val();
            var amount = $('#amount').val();
            
            if (amount > 0 && service_id !== '') {
                $.ajax({
                    url: "{{ route('ajax.setCommission') }}",
                    type: 'GET',
                    datatype: 'JSON',
                    data: {service_id: service_id, amount: amount},
                    success: function(response) {
                        $('#commission').val(response.commission);
                    }
                });
            } else {
                $('#commission').val(0);
            }
        });

        $('#amount').keyup(function() {
            var service_id = $('#productService').val();
            var amount = $(this).val();
            
            if (service_id !== '' && amount > 0) {
                $.ajax({
                    url: "{{ route('ajax.setCommission') }}",
                    type: 'GET',
                    dataType: 'JSON',
                    data: {service_id: service_id, amount: amount},
                    success: function(response) {
                        $('#commission').val(response.commission);
                    }
                });
            } else {
                $('#commission').val(0);
            }
        });

        $('body').on('click', '#button-store', function(e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('transaction.store') }}",
                method: "POST",
                datatype: "JSON",
                data: $('#transactionCreateForm').serialize(),
                success: function(res) {
                    if (res.code == 200) {
                        $('#modal-create-transaction').modal('hide');
                        $.notify(res.message, "success");
                        transactionList.ajax.reload();
                    } else {
                        $.notify(res.message, "error");
                    }
                }
            })
        });

        $('body').on('click', '#cancelTransaction', function() {
            var id = $(this).attr('data-id');

            $('#modal-cancel-transaction').modal('show');
            $('#idTransaction').val(id);
        });

        $('body').on('click', '#button-cancel', function(e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('transaction.cancel') }}",
                method: "POST",
                datatype: "JSON",
                data: $('#transactionCancelForm').serialize(),
                success: function(res) {
                    if (res.code == 200) {
                        $('#modal-cancel-transaction').modal('hide');
                        $.notify(res.message, "success");
                        transactionList.ajax.reload();
                    } else {
                        $.notify(res.message, "error");
                    }
                }
            });
        });
    });
</script>
@endsection