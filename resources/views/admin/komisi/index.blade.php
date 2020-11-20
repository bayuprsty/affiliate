@extends('layouts.admin')

@section('title')
    <title>Komisi</title>
@endsection

@section('content')
<main class="main">
    <div class="container-fluid" style="padding: 0px 0px 0px 0px;">
        <div class="animated fadeIn">
            <div class="col-md-12">
                <div class="card shadow mb-4">
                    <div class="card-header bg-info">
                        <span class="text-xl font-weight-bold text-white text-uppercase mb-1">Setting Komisi</span>
                    </div>
                    <div class="card-body">
                        <div class="col-md-12">
                            <table class="table table-hover" id="komisi_list" style="font-size: 14px;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Vendor</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Commission</th>
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
    @extends('admin.komisi._modal_commission')
</main>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        var komisiList = $('#komisi_list').DataTable({
            processing: true,
            serverside: true,
            bLengthChange: false,
            dom: '<"toolbar">frtip',
            initComplete: function(){
                $("div.toolbar")
                    .html('<button style="float: left;" id="createCommission" class="btn btn-primary btn-sm" style="margin-left: 15px;"><i class="fa fa-plus"></i> Komisi</button>');           
            },
            ajax: {
                url: "{{ route('datatableKomisiAdmin') }}",
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
                {data: 'vendor_id', name: 'vendor'},
                {data: 'title', name: 'title'},
                {data: 'description', name: 'description'},
                {data: 'commission', name: 'commission'},
                {
                    data: 'action',
                    name: 'action'
                }
            ],
            order: [[1, 'ASC']]
        });

        $('body').on('click', '#createCommission', function() {
            $('#modal-commission').modal('show');
            $('#commissionForm').trigger('reset');
            $('#button-submit').removeClass().addClass('btn btn-primary btn-xs');
            $('#button-submit').attr("data-id", "");
            $('#button-submit').html('Simpan');
        });

        $('body').on('click', '#editCommission', function() {
            var id = $(this).attr('data-id');
            var url = "{{ route('komisi.edit') }}";

            $.ajax({
                url: url,
                method: 'GET',
                dataType: 'JSON',
                data: {id: id},
                success: function(response) {
                    $('#modal-commission').modal('show');
                    $('#idCommission').val(response.id);
                    $('#vendorList').val(response.vendor_id).change();
                    $('#commissionTitle').val(response.title);
                    $('#commissionDescription').val(response.description);
                    $("input[name=commission_type_id][value=" + response.commission_type_id + "]").prop('checked', true);
                    $('#commissionValue').val(response.commission_value);
                    $('#button-submit').removeClass().addClass('btn btn-warning btn-xs');
                    $('#button-submit').html('Update');
                    $('#button-submit').attr("data-id", id);
                }
            });
        });

        $('body').on('click', '#deleteCommission', function() {
            var conf = confirm("Are you sure delete this data ?");
            if (conf) {
                var id = $(this).attr('data-id');

                $.ajax({
                    url: "{{ route('komisi.destroy') }}",
                    method: 'POST',
                    datatype: 'JSON',
                    data: {id: id},
                    success: function(res) {
                        if (res.code == 200) {
                            $.notify(res.message, 'success');
                            komisiList.ajax.reload();
                        } else {
                            $.notify(res.message, 'error');
                        }
                    }
                })
            }
        });

        $('body').on('click', '#button-submit', function() {
            event.preventDefault();
            var id = $(this).attr('data-id');

            if (id) {
                $.ajax({
                    url: "{{ route('komisi.update') }}",
                    method: 'POST',
                    datatype: 'JSON',
                    data: $('#commissionForm').serialize(),
                    success: function(res) {
                        if (res.code == 200) {
                            $('#modal-commission').modal('hide');
                            $.notify(res.message, 'success');
                            komisiList.ajax.reload();
                        } else {
                            $.notify(res.message, 'error');
                        }
                    }
                });
            } else {
                $.ajax({
                    url: "{{ route('komisi.store') }}",
                    method: 'POST',
                    datatype: 'JSON',
                    data: $('#commissionForm').serialize(),
                    success: function(res) {
                        if (res.code == 200) {
                            $('#modal-commission').modal('hide');
                            $.notify(res.message, 'success');
                            komisiList.ajax.reload();
                        } else {
                            $.notify(res.message, 'error');
                        }
                    }
                });
            }
        });
    });
</script>
@endsection