<html>
    <head>
        <title>PDF Transaction</title>
        <link href="{{ asset('sbadmin2-theme/css/sb-admin-2.min.css') }}" rel="stylesheet">
    </head>
    <body>
        <table class="table table-bordered" style="font-size: 13px;">
            <tr>
                <th>No</th>
                <th>Username Aff</th>
                <th>Username Cust</th>
                <th>Vendor</th>
                <th>Sign Up Date</th>
                <th>Product/Service</th>
                <th>Date</th>
                <th>Amount</th>
                <th>Commission</th>
                <th>Status</th>
            </tr>
            <?= $no = 1; ?>
            @foreach($transaction as $value)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $value->lead->user->username }}</td>
                <td>{{ $value->lead->customer_name }}</td>
                <td>{{ $value->lead->vendor->name }}</td>
                <td>{{ $value->lead->date }}</td>
                <td>{{ $value->service_commission->title }}</td>
                <td>{{ $value->date }}</td>
                <td>@currency($value->amount)</td>
                <td>@currency($value->commission)</td>
                <td>
                    @if ($value->lead->status == 1)
                        <span class="badge badge-primary">ON PROCESS</span>
                    @elseif ($value->lead->status == 2)
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