<html>
    <head>
        <title>PDF Lead</title>
        <link href="{{ asset('sbadmin2-theme/css/sb-admin-2.min.css') }}" rel="stylesheet">
    </head>
    <body>
        <table class="table table-bordered" style="font-size: 13px;">
            <tr>
                <th>No</th>
                <th>Username Aff</th>
                <th>Username Cust</th>
                <th>Vendor</th>
                <th>Email</th>
                <th>No Telepon</th>
                <th>Date</th>
                <th>Status</th>
            </tr>
            <?= $no = 1; ?>
            @foreach($lead as $value)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $value->user->username }}</td>
                <td>{{ $value->customer_name }}</td>
                <td>{{ $value->vendor->name }}</td>
                <td>{{ $value->email }}</td>
                <td>{{ $value->no_telepon }}</td>
                <td>{{ $value->date }}</td>
                <td>
                    @if ($value->status == 1)
                        <span class="badge badge-primary">ON PROCESS</span>
                    @elseif ($value->status == 2)
                        <span class="badge badge-success">SUCCESS</span>
                    @else
                        <span class="badge badge-danger">CANCELED</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </table>
    </body>
</html>