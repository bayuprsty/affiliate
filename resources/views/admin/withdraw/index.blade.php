@extends('layouts.admin')

@section('title')
    <title>Withdrawal Request</title>
@endsection

@section('content')
<main class="main">
    <div class="container-fluid" style="padding: 0px 0px 0px 0px;">
        <div class="animated fadeIn">
            <div class="col-md-12">
                <div class="card shadow mb-4">
                    <div class="card-header bg-info">
                        <span class="text-xl font-weight-bold text-white text-uppercase mb-1">Withdrawal Request</span>
                    </div>
                    <div class="card-body">
                        <div class="col-md-12">
                            <table class="table table-hover" id="withdrawal_list" style="font-size: 14px;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Transaction ID</th>
                                        <th>Affiliate Username</th>
                                        <th>Total Request</th>
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
    @extends('admin.withdraw._modal_request_withdraw')
</main>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        var withdrawalList = $('#withdrawal_list').DataTable({
            processing: true,
            serverside: true,
            bLengthChange: false,
            ajax: {
                url: "{{ route('datatableWithdrawAdmin') }}",
            },
            columnDefs: [
                { orderable: false, targets: [0, 3, 4, 5] },
                { searchable: false, targets: [0, 3, 4, 5] },
            ],
            columns: [
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                },  
                {data: 'id', name: 'id'},
                {data: 'user_id', name: 'user_id'},
                {data: 'total', name: 'total'},
                {data: 'status', name: 'status'},
                {
                    data: 'action',
                    name: 'action'
                }
            ],
            order: [[1, 'ASC']]
        });

        $('body').on('click', '#prosesWithdrawal', function() {
            var id = $(this).attr('data-id');
            var url = "{{ route('withdraw.proses') }}";

            $.ajax({
                url: url,
                method: 'GET',
                dataType: 'JSON',
                data: {id: id},
                success: function(response) {
                    $('#modal-request-withdrawal').modal('show');
                    $('#withdrawalId').val(response.request.id);
                    $('#transactionId').val(response.request.id);
                    $('#nomorRekening').val(response.user.nomor_rekening);
                    $('#atasNama').val(response.user.nama_depan);
                    $('#total').val(response.request.total);
                }
            })
        });

        $('body').on('click', '#button-submit', function() {
            $.ajax({
                url: "{{ route('withdraw.payout') }}",
                method: 'POST',
                datatype: 'JSON',
                data: $('#payoutForm').serialize(),
                success: function(res) {
                    if (res.code == 200) {
                        $('#modal-request-withdrawal').modal('hide');
                        $.notify(res.message, "success");
                        withdrawalList.ajax.reload();
                    } else {
                        $.notify(res.message, "error");
                    }
                }
            })
        })
    });
</script>
@endsection