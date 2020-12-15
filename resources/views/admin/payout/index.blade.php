@extends('layouts.admin')

@section('title')
    <title>Setting Min Payout</title>
@endsection

@section('content')
<main class="main">
    <div class="container-fluid" style="padding: 0px 0px 0px 0px;">
        <div class="animated fadeIn">
            <div class="col-md-12">
                <div class="card shadow mb-4">
                    <div class="card-header bg-info">
                        <span class="text-xl font-weight-bold text-white text-uppercase mb-1">Setting Minimum Payout</span>
                    </div>
                    <div class="card-body">
                        <div class="col-md-12">
                            <table class="table table-hover" id="payout_list" style="font-size: 12px;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Minimum Payout</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @extends('admin.payout._modal_payout')
</main>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        var payoutList = $('#payout_list').DataTable({
            processing: true,
            serverside: true,
            bLengthChange: false,
            ajax: {
                url: "{{ route('datatablePayoutAdmin') }}",
            },
            columnDefs: [
                { orderable: false, targets: [0, 2] },
                { searchable: false, targets: [0, 2] },
            ],
            columns: [
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                },  
                {data: 'minimum_payout', name: 'minimum_payout'},
                {
                    data: 'action',
                    name: 'action'
                }
            ],
            order: [[1, 'ASC']],
            initComplete: function () {  
                $("#payout_list").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
            },
        });

        $('body').on('click', '#createPayout', function() {
            $('#modal-payout').modal('show');
            $('#payoutForm').trigger('reset');
            $('#button-submit').removeClass().addClass('btn btn-primary btn-xs');
            $('#button-submit').html('Simpan');
        });

        $('body').on('click', '#editPayout', function() {
            var id = $(this).attr('data-id');
            var url = "{{ route('payout.edit') }}";

            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'JSON',
                data: {id: id},
                success: function(response) {
                    $('#modal-payout').modal('show');
                    $('#idPayout').val(response.id);
                    $('#minimumPayout').val(response.minimum_payout);
                    $('#button-submit').removeClass().addClass('btn btn-warning btn-xs');
                    $('#button-submit').html('Update');
                    $('#button-submit').attr('data-id', id);
                }
            })
        });

        $('body').on('click', '#button-submit', function() {
            event.preventDefault();
            var id = $(this).attr('data-id');

            if (id) {
                $.ajax({
                    url: "{{ route('payout.update') }}",
                    method: 'POST',
                    datatype: 'JSON',
                    data: $('#payoutForm').serialize(),
                    success: function(res) {
                        if (res.code == 200) {
                            $('#modal-payout').modal('hide');
                            $.notify(res.message, "success", {
                                globalPosition: 'top center'
                            });
                            payoutList.ajax.reload();
                        } else {
                            $.notify(res.message, 'error');
                        }
                    }
                });
            } else {
                $.ajax({
                    url: "{{ route('payout.store') }}",
                    method: 'POST',
                    datatype: 'JSON',
                    data: $('#payoutForm').serialize(),
                    success: function(res) {
                        if (res.code == 200) {
                            $('#modal-payout').modal('hide');
                            $.notify(res.message, 'success');
                            payoutList.ajax.reload();
                        } else {
                            $.notify(res.message, 'error');
                        }
                    }
                });
            }
        });

        $('body').on('click', '#deleteButton', function() {
            var id = $(this).attr('data-id')
            $.ajax({
                url: "{{ route('payout.destroy') }}",
                method: 'POST',
                datatype: 'JSON',
                data: { id: id},
                success: function(res) {
                    if (res.code == 200) {
                        $.notify(res.message, 'success', {
                            position: 'top'
                        });
                        payoutList.ajax.reload();
                    } else {
                        $.notify(res.message, 'error');
                    }
                }
            });
        });
    });
</script>
@endsection