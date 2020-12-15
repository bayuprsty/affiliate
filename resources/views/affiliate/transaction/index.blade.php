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
                        <div class="col-md-2">
                                <select name="status_id" class="form-control form-control-sm" id="status_id">
                                    <option value="all">-- Select Status --</option>
                                    <option value="1">ON PROGRESS</option>
                                    <option value="2">SUCCESS</option>
                                    <option value="3">CANCELED</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <div class="input-group">
                                    <input type="date" class="form-control form-control-sm" id="dateStart">
                                </div>
                            </div>
                            <div class="col-md-1 text-center">
                                to
                            </div>
                            <div class="col-md-2">
                                <div class="input-group">
                                    <input type="date" class="form-control form-control-sm" id="dateEnd">
                                </div>
                            </div>
                            <div class="col-md-2 text-center">
                                <button class="btn btn-primary btn-sm" id="searchData">Search</button>
                                <button class="btn btn-light btn-sm" id="resetData">Reset</button>
                            </div>
                            <div class="col text-right">
                                <button class="btn btn-success btn-sm" id="exportData">Export</button>
                            </div>
                        </div>
                        <hr>
                        <div class="col-md-12">
                            <table class="table table-hover table-outline" id="transactionAff_list" style="font-size: 13px;">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Customer Name</th>
                                        <th>Sign Up Date</th>
                                        <th>Vendor</th>
                                        <th>Product/Services</th>
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
</main>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        var transactionAffList = $('#transactionAff_list').DataTable({
            processing: true,
            serverside: true,
            bLengthChange : false,
            searching: false,
            ajax: {
                url: "{{ route('datatableTransactionAffiliate') }}",
                data: function(d) {
                    d.status = $('#status_id').val();
                    d.dateStart = $('#dateStart').val();
                    d.dateEnd = $('#dateEnd').val();
                }
            },
            columnDefs: [
                { orderable: false, targets: [0, 5, 6, 7, 8] },
            ],
            columns: [
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                },
                {data: 'customer_name', name: 'customer_name'},
                {data: 'signup_date', name: 'signup_date'},
                {data: 'vendor_name', name: 'vendor_name'},
                {data: 'product_service', name: 'product_service'},
                {data: 'transaction_date', name: 'transaction_date'},
                {data: 'amount', name: 'amount'},
                {data: 'commission', name: 'commission'},
                {data: 'status', name: 'status'},
            ],
            drawCallback: function() {
                $('[data-toggle="tooltip"]').tooltip();
            },
            initComplete: function () {  
                $("#transactionAff_list").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
            },
        });

        $('#searchData').click(function() {
            transactionAffList.ajax.reload();
        });

        $('#resetData').click(function() {
            $('#status_id').val('');
            $('#dateStart').val('');
            $('#dateEnd').val('');
            transactionAffList.ajax.reload();
        });

        $('body').on('click', '#exportData', function() {
            if(transactionAffList.rows().data().length == 0) {
                $.notify("Can't export as PDF. Data is Empty", {type:"warning"});
                return false;
            }
            
            status = $('#status_id').val() ? $('#status_id').val() : 'all';
            dateStart = $('#dateStart').val() ? $('#dateStart').val() : 'all';
            dateEnd = $('#dateEnd').val() ? $('#dateEnd').val() : 'all';

            window.open("downloadPdfTransaction/" + status + "/" + dateStart + "/" + dateEnd, "_blank");
        });
    });
</script>
@endsection