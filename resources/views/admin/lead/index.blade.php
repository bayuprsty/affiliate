@extends('layouts.admin')

@section('title')
    <title>Lead</title>
@endsection

@section('content')
<main class="main">
    <div class="container-fluid" style="padding: 0px 0px 0px 0px;">
        <div class="animated fadeIn">
            <div class="col-md-12">
                <div class="card shadow mb-4">
                    <div class="card-header bg-info">
                        <span class="text-xl font-weight-bold text-white text-uppercase mb-1">Lead</span>
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
                                    <input type="date" class="form-control form-control-sm" id="dateStart" placeholder="dd / mm / yyyy">
                                </div>
                            </div>
                            <div class="col-md-1 text-center">
                                to
                            </div>
                            <div class="col-md-2">
                                <div class="input-group">
                                    <input type="date" class="form-control form-control-sm" id="dateEnd" placeholder="dd / mm / yyyy">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-primary btn-sm" id="searchData">Search</button>
                                <button class="btn btn-light btn-sm" id="resetData">Reset</button>
                            </div>
                            <div class="col text-right">
                                <button class="btn btn-success btn-sm" id="exportData">Export</button>
                                <button class="btn btn-warning btn-sm" id="add-lead"><i class="fa fa-plus"></i> Lead</button>
                            </div>
                        </div>
                        <hr>
                        <div class="col-md-12">
                            <table class="table table-hover table-outline" id="lead_list" style="font-size: 13px;">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Username Aff</th>
                                        <th>Username Cust</th>
                                        <th>Vendor</th>
                                        <th>Email</th>
                                        <th>No Telepon</th>
                                        <th>Date</th>
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
    @extends('admin.lead._modal_proses_lead')
    @extends('admin.lead._modal_create')
</main>
@endsection

@section('js')
<script type="text/javascript">
    $(document).ready(function() {
        var prosesLeadFieldset = document.getElementById('prosesLeadFieldset');

        var leadList = $('#lead_list').DataTable( {
            processing: true,
            serverside: true,
            bLengthChange : false,
            searching: false,
            ajax: {
                url: "{{ route('datatableLeadAdmin') }}",
                data: function(d) {
                    d.status = $('#status_id').val();
                    d.dateStart = $('#dateStart').val();
                    d.dateEnd = $('#dateEnd').val();
                }
            },
            columnDefs: [
                { orderable: false, targets: [0, 4, 5, 6, 7, 8] },
            ],
            columns: [
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                },  
                {data: 'user_id', name: 'user_id'},
                {data: 'customer_name', name: 'customer_name'},
                {data: 'vendor_id', name: 'vendor_id'},
                {data: 'email', name: 'email'},
                {data: 'no_telepon', name: 'no_telepon'},
                {data: 'date', name: 'date'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action'}
            ],
            initComplete: function () {  
                $("#lead_list").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
            },
        } );

        $('#searchData').click(function() {
            leadList.ajax.reload();
        });

        $('#resetData').click(function() {
            $('#status_id').val('all');
            $('#dateStart').val('');
            $('#dateEnd').val('');
            leadList.ajax.reload();
        });

        $('body').on('click', '#exportData', function() {
            if(leadList.rows().data().length == 0) {
                $.notify("Can't export as PDF. Data is Empty", {type:"warning"});
                return false;
            }
            
            status = $('#status_id').val() ? $('#status_id').val() : 'all';
            dateStart = $('#dateStart').val() ? $('#dateStart').val() : 'all';
            dateEnd = $('#dateEnd').val() ? $('#dateEnd').val() : 'all';

            window.open("downloadPdf/" + status + "/" + dateStart + "/" + dateEnd, "_blank");
        });

        $('body').on('click', '#add-lead', function() {
            $('#modal-create-lead').modal('show');
            
            $('#username_aff').empty();
            $('#username_aff').select2('data', '');
            $('#vendor_aff').trigger("reset");
        })

        $('body').on('click', '#leadProcess', function() {
            var id = $(this).attr('data-id');
            var url = "{{ route('lead.detail') }}";

            $('#leadProsesForm').trigger("reset");

            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'JSON',
                data: {id: id},
                success: function(response) {
                    $('#modal-lead-process').modal('show');
                    $('#leadId').val(response.lead.id);
                    $('#usernameAffiliate').val(response.user.username);
                    $('#customerName').val(response.lead.customer_name);
                    $('#productService').html(response.service).trigger("change");
                }
            });
        });

        $('body').on('click', '#button-submit', function() {
            event.preventDefault();

            $.ajax({
                url: "{{ route('lead.proses') }}",
                method: 'POST',
                datatype: "JSON",
                data: $('#leadProsesForm').serialize(),
                beforeSend: function () {
                    $(prosesLeadFieldset).attr('disabled', true);
                    $('#loader').show();
                },
                success: function(res) {
                    if (res.code == 200) {
                        $('#modal-lead-process').modal('hide');
                        $.notify(res.message, "success");

                        $(prosesLeadFieldset).attr('disabled', false);
                        $('#loader').hide();
                        
                        leadList.ajax.reload();
                    } else {
                        $.notify(res.message, "error");
                        
                        $(prosesLeadFieldset).attr('disabled', false);
                        $('#loader').hide();
                    }
                }
            })
        });

        $('body').on('click', '#button-store', function() {
            event.preventDefault();

            $.ajax({
                url: "{{ route('lead.store') }}",
                method: 'POST',
                datatype: "JSON",
                data: $('#leadCreateForm').serialize(),
                success: function(res) {
                    if (res.code == 200) {
                        $('#modal-create-lead').modal('hide');
                        $.notify(res.message, "success");
                        leadList.ajax.reload();
                    } else {
                        $.notify(res.message, "error");
                    }
                }
            })
        });

        //////////////////////////////////////////////// AJAX GET VALUE ///////////////////////////////////////////
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
    });
</script>
@endsection