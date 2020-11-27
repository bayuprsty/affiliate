@extends('layouts.auth')

@section('title')
    <title>Reset Password</title>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-header bg-info">
                    <span class="text-xl font-weight-bold text-white text-uppercase mb-1">Reset Password</span>
                </div>

                <div class="card-body">
                    <form class="form form-horizontal" id="resetPasswordForm">
                        <fieldset>
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required>
                            <br>
                            <label>Ulangi Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                            <input type="hidden" name="id" value="{{ $id }}">
                            <input type="hidden" name="code_verify" value="{{ $code_verify }}">
                            <hr>
                            <div class="m-0 text-center">
                                <button type="submit" class="btn btn-primary">Reset Password</button>
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

        $('body').on('submit', '#resetPasswordForm', function(e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('reset.save') }}",
                method: "POST",
                data: new FormData(this),
                contentType: false,
                processData: false,
                success: function(res) {
                    if (res.code == 200) {
                        $.notify(res.message, "success");
                        window.location.assign("{{ route('login') }}");
                    } else {
                        $.notify(res.message, "error");
                    }
                }
            })
        })
    })
</script>
@endsection