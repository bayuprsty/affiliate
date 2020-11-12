@extends('layouts.admin')

@section('title')
    <title>Dashboard</title>
@endsection

@section('content')
<main class="main">
    <div class="container-fluid" style="padding: 0px 0px 0px 0px;">
        <div class="animated fadeIn">
            <div class="col-md-12">
                <div class="card shadow mb-2">
                    <div class="card-header bg-info">
                        <span class="text-xl font-weight-bold text-white text-uppercase mb-1">Dashboard</span>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-4 col-md-6 mb-4">
                                <div class="card border-left-primary shadow h-100 py-2">
                                    <div class="card-body text-center">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xl font-weight-bold text-primary text-uppercase mb-1">Vendor</div>
                                                <br/>
                                                <div class="h4 mb-0 font-weight-bold text-gray-800">{{ $vendor }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-6 mb-4">
                                <div class="card border-left-danger shadow h-100 py-2">
                                    <div class="card-body text-center">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xl font-weight-bold text-primary text-uppercase mb-1">Affiliate</div>
                                                <br/>
                                                <div class="h4 mb-0 font-weight-bold text-gray-800">{{ $affiliate }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-6 mb-4">
                                <div class="card border-left-success shadow h-100 py-2">
                                    <div class="card-body text-center">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xl font-weight-bold text-primary text-uppercase mb-1">Total Commission Affiliate</div>
                                                <br/>
                                                <div class="h4 mb-0 font-weight-bold text-gray-800">@currency($commission)</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>   
                        </div>
                        <div class="row">
                            <div class="col-xl-4 col-md-6 mb-4">
                                <div class="card border-left-info shadow h-100 py-2">
                                    <div class="card-body text-center">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xl font-weight-bold text-primary text-uppercase mb-1">Withdraw Request</div>
                                                <div class="text-xl font-weight-bold text-primary text-uppercase mb-1">( {{ $withdrawal['count_request'] }} )</div>
                                                <br/>
                                                <div class="h4 mb-0 font-weight-bold text-gray-800">@currency($withdrawal['request_amount'])</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-6 mb-4">
                                <div class="card border-left-dark shadow h-100 py-2">
                                    <div class="card-body text-center">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xl font-weight-bold text-primary text-uppercase mb-1">Withdraw Paid</div>
                                                <div class="text-xl font-weight-bold text-primary text-uppercase mb-1">( {{ $withdrawal['count_paid'] }} )</div>
                                                <br/>
                                                <div class="h4 mb-0 font-weight-bold text-gray-800">@currency($withdrawal['paid_amount'])</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-6 mb-4">
                                <div class="card border-left-light shadow h-100 py-2">
                                    <div class="card-body text-center">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xl font-weight-bold text-primary text-uppercase mb-1">Withdraw Un-Paid</div>
                                                <div class="text-xl font-weight-bold text-primary text-uppercase mb-1">( {{ $withdrawal['count_unpaid'] }} )</div>
                                                <br/>
                                                <div class="h4 mb-0 font-weight-bold text-gray-800">@currency($withdrawal['unpaid_amount'])</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-4 col-md-6 mb-4">
                                <div class="card border-left-warning shadow h-100 py-2">
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
                            <div class="col-xl-4 col-md-6 mb-4">
                                <div class="card border-left-primary shadow h-100 py-2">
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
                            <div class="col-xl-4 col-md-6 mb-4">
                                <div class="card border-left-secondary shadow h-100 py-2">
                                    <div class="card-body text-center">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xl font-weight-bold text-primary text-uppercase mb-1">Conversion</div>
                                                <br/>
                                                <div class="h4 mb-0 font-weight-bold text-gray-800">{{ $conversion }} %</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card shadow mb-4">
                                    <div class="card-header bg-primary">
                                        <span class="text-xl font-weight-bold text-white text-uppercase mb-1">Top 10 Affiliate</span>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <select name="filter_periode" id="filter_periode" class="form-control form-control-sm">
                                                    <option value=""> All Periode </option>
                                                    <option value="7"> 7 Hari Terakhir </option>
                                                    <option value="14"> 14 Hari Terakhir </option>
                                                    <option value="21"> 21 Hari Terakhir </option>
                                                    <option value="31"> 31 Hari Terakhir </option>
                                                    <option value="365"> 365 Hari Terakhir </option>
                                                    <option value="custom">Custom Range Date</option>
                                                </select>
                                            </div>
                                            <div class="col-md-9" style="visibility: hidden" id="date_range">
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="input-group">
                                                            <input type="date" class="form-control form-control-sm" id="dateStart" placeholder="dd / mm / yyyy">
                                                        </div>
                                                    </div>
                                                    to
                                                    <div class="col">
                                                        <div class="input-group">
                                                            <input type="date" class="form-control form-control-sm" id="dateEnd" placeholder="dd / mm / yyyy">
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <button class="btn btn-primary btn-sm" id="filter">Filter</button>
                                                        <button class="btn btn-light btn-sm" id="resetData">Reset</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <table class="table table-responsive-sm table-hover table-outline mb-0" id="top_affiliate_list">
                                            <thead class="light">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Name</th>
                                                    <th>Balance</th>
                                                    <th>Commission</th>
                                                    <th>Click</th>
                                                    <th>SignUp</th>
                                                    <th>Conversions</th>
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
</main>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        var topAffiliateList = $('#top_affiliate_list').DataTable({
            processing: true,
            serverside: true,
            bLengthChange : false,
            searching: false,
            ordering: false,
            paging: false,
            info: false,
            ajax: {
                url: "{{ route('datatableTopAffiliate') }}",
                data: function(d) {
                    d.filter_periode = $('#filter_periode').val();
                    d.dateStart = $('#dateStart').val();
                    d.dateEnd = $('#dateEnd').val();
                },
            },
            columns: [
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                },  
                {data: 'username', name: 'username'},
                {data: 'balance', name: 'balance'},
                {data: 'commission', name: 'commission'},
                {data: 'click', name: 'click'},
                {data: 'signup', name: 'signup'},
                {data: 'conversion', name: 'conversion'}
            ],
        });

        $('#filter_periode').on('change', function() {
            if ($(this).val() !== 'custom') {
                $('#date_range').css('visibility', 'hidden');
                topAffiliateList.ajax.reload(); 
            } else {
                $('#date_range').css('visibility', 'visible');
            }
        })

        $('body').on('click', '#filter', function() {
            topAffiliateList.ajax.reload();
        });
    });
</script>
@endsection