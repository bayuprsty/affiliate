@extends('layouts.admin')

@section('title')
    <title>Change Password</title>
@endsection

@section('content')
<main class="main">
    <div class="container-fluid" style="padding: 0px 0px 0px 0px;">
        <div class="animated fadeIn">
            <div class="col-md-12">
                <div class="card shadow mb-4">
                    <div class="card-header bg-info">
                        <span class="text-xl font-weight-bold text-white text-uppercase mb-1">Change Password</span>
                    </div>
                    <div class="card-body">
                        <form class="form-horizontal" id="changePasswordForm">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">Password Lama</label>
                                        <div class="col-sm-8">
                                            <input type="password" name="old_password" placeholder="Password Lama" class="form-control form-control-sm" required>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">Password Baru</label>
                                        <div class="col-sm-8">
                                            <input type="password" name="password" placeholder="Password Baru" class="form-control form-control-sm" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">Ulangi Password Baru</label>
                                        <div class="col-sm-8">
                                            <input type="password" name="password_confirmation" placeholder="Ulangi Password Baru" class="form-control form-control-sm" required>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group row">
                                        <div class="col-sm-12 text-center">
                                            <button type="submit" class="btn btn-primary btn-xs">Change Password</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
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
        $('body').on('submit', '#changePasswordForm', function(event) {
            event.preventDefault();

            var formData = new FormData(this);

            $.ajax({
                url: "{{ route('user.storePassword') }}",
                method: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(res) {
                    if (res.code == 200) {
                        $.notify(res.message, "success");
                        $('#changePasswordForm').trigger('reset');
                    } else {
                        $.notify(res.message, "error");
                    }
                }
            });
        })
    })
</script>
@endsection