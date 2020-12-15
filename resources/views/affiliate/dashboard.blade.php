@extends('layouts.admin')

@section('title')
    <title>Dashboard</title>
@endsection

@section('content')
<main class="main">
    <div class="container-fluid" style="padding:0px 0px 0px 0px;">
        <div class="animated fadeIn">
            <div class="col-md-12">
                <div class="card shadow mb-2">
                    <div class="card-header bg-info">
                        <span class="text-xl font-weight-bold text-white text-uppercase mb-1">Dashboard</span>
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
                            <div class="col-md-2 mb-4">
                                <div class="card border-left-danger shadow h-100 py-2">
                                    <div class="card-body text-center">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xl font-weight-bold text-primary text-uppercase mb-1">Click</div>
                                                <br/>
                                                <div class="h4 mb-0 font-weight-bold text-gray-800">{{ $click }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 mb-4">
                                <div class="card border-left-dark shadow h-100 py-2">
                                    <div class="card-body text-center">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xl font-weight-bold text-primary text-uppercase mb-1">SignUp</div>
                                                <br/>
                                                <div class="h4 mb-0 font-weight-bold text-gray-800">{{ $lead }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-4">
                                <div class="card border-left-warning shadow h-100 py-2">
                                    <div class="card-body text-center">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-sm-center font-weight-bold text-primary text-uppercase mb-1">Conversion</div>
                                                <br/>
                                                <div class="h4 mb-0 font-weight-bold text-gray-800">{{ $conversion }} %</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 mb-4">
                                <div class="card border-left-secondary shadow h-100 py-2">
                                    <div class="card-body text-center">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xl font-weight-bold text-primary text-uppercase mb-1">Leads</div>
                                                <br/>
                                                <div class="h4 mb-0 font-weight-bold text-gray-800">{{ $lead }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-4">
                                <div class="card border-left-info shadow h-100 py-2">
                                    <div class="card-body text-center">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xl font-weight-bold text-primary text-uppercase mb-1">Transactions</div>
                                                <br/>
                                                <div class="h4 mb-0 font-weight-bold text-gray-800">{{ $transaction }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header bg-primary">
                                        <span class="text-xl font-weight-bold text-white text-uppercase mb-1">All Click</span>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-responsive-sm table-hover table-outline mb-0" id="user_click_table">
                                            <thead class="light">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Store</th>
                                                    <th>Media</th>
                                                    <th>Count</th>
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
</main>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        var userClickTable = $('#user_click_table').DataTable({
            processing: true,
            serverside: true,
            bLengthChange : false,
            searching: false,
            ajax: {
                url: "{{ route('datatableClickAffiliate') }}",
            },
            columnDefs: [
                { orderable: false, targets: [0, 1, 2, 3] },
            ],
            columns: [
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                },  
                {data: 'vendor_id', name: 'vendor_id'},
                {data: 'media_id', name: 'media_id'},
                {data: 'click', name: 'click'}
            ],
            initComplete: function () {  
                $("#user_click_table").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
            },
        });

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
                    } else {
                        $.notify(res.message, "error");
                    }
                }
            })
        });
    })
</script>
@endsection