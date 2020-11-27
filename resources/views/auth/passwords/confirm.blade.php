@extends('layouts.auth')

@section('title')
    <title>Forgot Password</title>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-header bg-info">
                    <span class="text-xl font-weight-bold text-white text-uppercase mb-1">Forgot Password</span>
                </div>

                <div class="card-body">
                    <form class="form form-horizontal" id="sendEmailForm">
                        <fieldset>
                            <label>Email</label>
                            <input type="email" id="email_confirm" class="form-control" required>
                            <i class="text-xs text-danger font-weight-bold">*Silahkan gunakan email yang sudah terdaftar di Affiliate System</i>
                            <hr>
                            <div class="m-0">
                                <button type="submit" class="btn btn-primary">Confirm</button>
                                <a href="{{ route('login') }}" class="btn btn-success">Back to Login</a>
                                <div id="loader" style="float: right; display: none;">
                                    <img src="/uploads/spinner.gif" width="35px" height="35px"/>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        var fieldset = $(this).find('fieldset');

        $('body').on('submit', '#sendEmailForm', function(e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('forgot.sendEmail') }}",
                method: "POST",
                datatype: "JSON",
                data: {email: $('#email_confirm').val()},
                beforeSend: function() {
                    $(fieldset).attr('disabled', true);
                    $('#loader').show();
                },
                success: function(res) {
                    if (res.code == 200) {
                        $.notify(res.message, "success");
                    } else {
                        $.notify(res.message, "error");
                        $(fieldset).attr('disabled', false);
                    }

                    $('#loader').hide();
                }
            })
        })
    })
</script>
@endsection