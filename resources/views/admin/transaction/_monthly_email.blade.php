<!DOCTYPE html>
<html>
    <head>
        <style type="text/css">
            .container {
                width: 70%;
                text-align: center;
                margin: auto;
                font-family: sans-serif;
            }
            
            .header, .footer {
                text-align: center;
                background-color: #1cc88a
            }
            
            .header-container, .footer-container {
                margin: auto;
                padding: 1rem 0.5rem;
                color: #ffffff;
            }
            
            .header-container img, .footer-container p {
                vertical-align: middle;
            }
            
            .content {
                padding: 2rem 1rem;
                text-align: center;
                border: 1px solid #1cc88a;
            }

            .table {
                width: 100%;
                margin-bottom: 1rem;
                color: #858796;
                text-align: left;
            }

            .table th, .table td {
                padding: 0.75rem;
                vertical-align: top;
                border-top: 1px solid #e3e6f0;
            }

            .table thead th {
                vertical-align: bottom;
                border-bottom: 2px solid #e3e6f0;
            }

            .table tbody + tbody {
                border-top: 2px solid #e3e6f0;
            }
            
            @media screen and (max-width: 640px) {
                .container {
                    width: 100%;
                    border-radius: 10%;
                }
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <div class="header-container">
                    <h1>Davinti Affiliate System</h1>
                </div>
            </div>
            <div class="content">
                <h2>Hello {{ $nama_lengkap }}</h2>
                <br/>
                <h4>This is your transaction monthly report on {{ $month }}</h4>
                <br/>
                <table class="table">
                    <tr>
                        <td>Total Lead</td>
                        <td>:</td>
                        <td>{{ $lead }}</td>
                    </tr>
                    <tr>
                        <td>Total Transaction</td>
                        <td>:</td>
                        <td>{{ $transaction }}</td>
                    </tr>
                    <tr>
                        <td>No Telepon</td>
                        <td>:</td>
                        <td>{{ $no_telepon }}</td>
                    </tr>
                    <tr>
                        <td>Transaction Date</td>
                        <td>:</td>
                        <td>{{ $transaction_date }}</td>
                    </tr>
                    <tr>
                        <td>Amount</td>
                        <td>:</td>
                        <td>{{ $amount }}</td>
                    </tr>
                    <tr>
                        <td>Your Comission</td>
                        <td>:</td>
                        <td> @currency($commission) </td>
                    </tr>
                </table>
            </div>
            <div class="footer">
                <div class="footer-container">
                    <h2>Thank You</h2>
                </div>
            </div>
        </div>
    </body>
</html>
Hello {{ $nama_lengkap }}<br/>
This is your transaction monthly report on {{ $month }}<br/>
<br/>
Total Lead : {{ $lead }}<br/>
Total Transaction : {{ $transaction }}<br/>
<br/>
Your Commission : @currency($commission)<br/>
<br/>
Thanks for your Contribution