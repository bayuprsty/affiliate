@extends('layouts.auth')

@section('title')
    <title>Verify Email</title>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-header bg-info">
                    <span class="text-xl font-weight-bold text-white text-uppercase mb-1">Verify Your Email Address</span>
                </div>

                <div class="card-body">
                    <fieldset>
                        <span>Before proceeding, please check your email for a verification link</span><br/>
                        <span>If you did not receive the email</span>
                        <form class="form-horizontal d-inline" id="resendConfirmationForm">
                            <input type="hidden" id="user_id" value="{{ $id }}">
                            <input type="hidden" id="code_verify" value="{{ $code_verify }}">
                            <button id="resend" class="btn btn-link p-0 m-0">Click here to request another</button>.
                        </form>
                        <br/><br/>
                        <a href="{{ route('login') }}" class="btn btn-success btn-sm">Back To Login</a>

                        <div id="loader" style="float: right; display: none;">
                            <img src="/uploads/spinner.gif" witdth="35px" height="35px"/>
                        </div>
                    </fieldset>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        $('body').on('click', '#resend', function(e) {
            e.preventDefault();

            var fieldset = $(this).find('fieldset');

            $.ajax({
                url: "{{ route('verification.resend') }}",
                method: "POST",
                datatype: "JSON",
                data: {id: $('#user_id').val(), verify_code: $('#code_verify').val()},
                beforeSend: function() {
                    $(fieldset).attr('disabled', true);
                    $('#loader').show();
                },
                success: function(res) {
                    if (res.code == 200) {
                        $.notify(res.message, "success");
                        $(fieldset).attr('disabled', false);
                        $('#loader').hide();
                    }
                }
            })
        })
    })
</script>
@endsection
