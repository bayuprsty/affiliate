<html>
    <head>
        <link href="{{ asset('sbadmin2-theme/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
        <link href="{{ asset('sbadmin2-theme/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css">
        <!-- Custom styles for this template-->
        <link href="{{ asset('sbadmin2-theme/css/sb-admin-2.min.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('sbadmin2-theme/css/bootstrap-social.css') }}">
    </head>
    <body>
        <span>Hello</span>
        <br/>
        <span>Please Click The Button Below to verify your email address</span>
        <br>
        <a href="{{ $link_verify }}" class="btn btn-primary" target="_blank">Verify Email Address</a>
    </body>
</html>