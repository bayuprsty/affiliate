<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link href="{{ asset('sbadmin2-theme/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
        <link href="{{ asset('sbadmin2-theme/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css">
        <!-- Custom styles for this template-->
        <link href="{{ asset('sbadmin2-theme/css/sb-admin-2.min.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('sbadmin2-theme/css/bootstrap-social.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
    </head>
    <body class="bg-gradient-light">
        <div class="row py-5">
            <div class="col-md-12 text-center">
                <h1>Redirecting ...</h1>
                <img src="/uploads/spinner.gif" />
            </div>
        </div>

        <script src="{{ asset('sbadmin2-theme/vendor/jquery/jquery.min.js')}}"></script>
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(document).ready(function() {
                $.ajax({
                    url: "{{ route('ajax.setClick') }}",
                    method: "POST",
                    datatype: "JSON",
                    data: {value: "{{ $sharedValue }}"},
                    success: function (res) {
                        // window.location.assign(res.url);
                    }
                });
            })
        </script>
    </body>
</html>