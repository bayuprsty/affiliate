@extends('layouts.admin')

@section('title')
    <title>My Wallet</title>
@endsection

@section('content')
<main class="main">
    <div class="container-fluid" style="padding: 0px 0px 0px 0px;">
        <div class="animated fadeIn">
            <div class="col-md-12">
                <div class="card shadow mb-2">
                    <div class="card-header bg-info">
                        <span class="text-xl font-weight-bold text-white text-uppercase mb-1">My Wallet</span>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-6 col-md-6 mb-4">
                                <div class="card border-left-success shadow h-100 py-2">
                                    <div class="card-body text-center">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xl font-weight-bold text-primary text-uppercase mb-1">Available Commission Balance</div>
                                                <br/>
                                                <div class="h4 mb-0 font-weight-bold text-gray-800">@currency($balance)</div>
                                            </div>
                                        </div>
                                        <hr>
                                        <button class="btn btn-primary" id="requestWithdrawal">Request Withdrawal</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6 mb-4">
                                <div class="card border-left-primary shadow h-100 py-2">
                                    <div class="card-body text-center">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xl font-weight-bold text-primary text-uppercase mb-1">Total Amount Withdraw</div>
                                                <br/>
                                                <div class="h4 mb-0 font-weight-bold text-gray-800">@currency($withdrawalApproved)</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card shadow mb-2">
                                    <div class="card-header bg-primary">
                                        <span class="text-xl font-weight-bold text-white text-uppercase mb-1">Withdraw Request List</span>
                                    </div>
                                    <div class="card-body">
                                        <table id="withdraw_request" class="table table-hover" style="font-size: 13px">
                                            <thead class="light">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Date</th>
                                                    <th>Transaction ID</th>
                                                    <th>Total</th>
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
            </div>
        </div>
    </div>
    @extends('affiliate.wallet._modal_request_withdrawal')
    @extends('affiliate.wallet._modal_detail_withdrawal')
</main>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        var withdrawRequestList = $('#withdraw_request').DataTable( {
            processing: true,
            serverside: true,
            bLengthChange : false,
            searching: false,
            ajax: {
                url: "{{ route('datatableWalletAffiliate') }}"
            },
            columnDefs: [
                { orderable: false, targets: [0, 5] }
            ],
            columns: [
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                },  
                {data: 'date', name: 'date'},
                {data: 'id', name: 'id'},
                {data: 'total', name: 'total'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action'}
            ],
            initComplete: function () {  
                $("#withdraw_request").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
            },
        } );

        $('body').on('click', '#requestWithdrawal', function() {
            $('#modal-request-withdrawal').modal('show');
        });

        $('body').on('click', '#button-submit', function(event) {
            event.preventDefault();

            $.ajax({
                url: "{{ route('affiliate.withdraw') }}",
                method: "POST",
                datatype: 'JSON',
                data: $('#withdrawalRequestForm').serialize(),
                success: function(res) {
                    if (res.code == 200) {
                        $('#modal-request-withdrawal').modal('hide');
                        $.notify(res.message, "success");
                        withdrawRequestList.ajax.reload();
                    } else {
                        $.notify(res.message, "error");
                    }
                }
            })
        });

        $('body').on('click', '#detailWithdrawal', function() {
            var id = $(this).attr('data-id');
            
            $.ajax({
                url: "{{ route('affiliate.detailWithdraw') }}",
                method: "GET",
                datatype: "JSON",
                data: {id: id},
                success: function(res) {
                    $('#modal-detail-request').modal('show');
                    $('#date-request').html(res.withdrawal.date);
                    $('#transaction-id').html(res.withdrawal.id);
                    $('#total-request').html(res.withdrawal.total);
                    $('#status').html(res.status);
                }
            })
        })
    });
</script>
@endsection