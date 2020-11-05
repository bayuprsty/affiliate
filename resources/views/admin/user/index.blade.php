@extends('layouts.admin')

@section('title')
    <title>Management Users</title>
@endsection

@section('content')
<main class="main">
    <div class="container-fluid" style="padding: 0px 0px 0px 0px;">
        <div class="animated fadeIn">
            <div class="col-md-12">
                <div class="card shadow mb-4">
                    <div class="card-header bg-info">
                        <span class="text-xl font-weight-bold text-white text-uppercase mb-1">Management Users</span>
                    </div>
                    <div class="card-body">
                        <div class="col-md-12">
                            <table class="table table-hover" id="user_list" style="font-size: 14px;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Username</th>
                                        <th>Nama Lengkap</th>
                                        <th>No Telepon</th>
                                        <th>Email</th>
                                        <th>Nomor KTP</th>
                                        <th>Role</th>
                                        <th>Join Date</th>
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
</main>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        var komisiList = $('#user_list').DataTable({
            processing: true,
            serverside: true,
            bLengthChange: false,
            ajax: {
                url: "{{ route('datatableUserAdmin') }}",
            },
            columnDefs: [
                { orderable: false, targets: [0, 2, 3, 4, 5, 7, 8] },
                { searchable: false, targets: [0, 3, 6, 8, 7] },
            ],
            columns: [
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                },  
                {data: 'username', name: 'username'},
                {data: 'nama_lengkap', name: 'nama_lengkap'},
                {data: 'no_telepon', name: 'no_telepon'},
                {data: 'email', name: 'email'},
                {data: 'ktp', name: 'ktp'},
                {data: 'role', name: 'role'},
                {data: 'join_date', name: 'join_date'},
                {
                    data: 'action',
                    name: 'action'
                }
            ],
        });
    });
</script>
@endsection