@extends('layouts.admin')

@section('title')
    <title>Contact Admin</title>
@endsection

@section('content')
<main class="main">
    <div class="container-fluid" style="padding: 0px 0px 0px 0px;">
        <div class="animated fadeIn">
            <div class="col-md-12">
                <div class="card shadow mb-2">
                    <div class="card-header bg-info">
                        <span class="text-xl font-weight-bold text-white text-uppercase mb-1">Contact to Admin</span>
                    </div>
                    <div class="card-body">
                        <div class="col-md-12">
                            <form class="form-horizontal" id="sendAdminForm">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Username</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="username" value="{{ $userAffiliate->username }}" class="form-control form-control-sm">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Nama Depan</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="nama_depan" value="{{ $userAffiliate->nama_depan }}" class="form-control form-control-sm">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Nama Belakang</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="nama_belakang" value="{{ $userAffiliate->nama_belakang }}" class="form-control form-control-sm">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">No HP</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="no_telepon" value="{{ $userAffiliate->no_telepon }}" class="form-control form-control-sm">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Email</label>
                                    <div class="col-sm-9">
                                        <input type="email" name="email" value="{{ $userAffiliate->email }}" class="form-control form-control-sm" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Subject</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="subject" placeholder="Subject" class="form-control form-control-sm">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Body</label>
                                    <div class="col-sm-9">
                                        <textarea name="message" class="form-control form-control-sm" rows="10"></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12 text-center">
                                        <button class="btn btn-primary btn-xs" id="send-email">Send</button>
                                    </div>
                                </div>
                            </form>
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
        $('body').on('click', '#send-email', function(event) {
            event.preventDefault();

            $.ajax({
                url: "{{ route('affiliate.sendContact') }}",
                method: 'POST',
                datatype: 'JSON',
                data: $('#sendAdminForm').serialize(),
                success: function(res) {
                    if (res.code == 200) {
                        location.reload();
                        $.notify(res.message, "success");
                    } else {
                        $.notify(res.message, "error");
                    }
                }
            })
        })
    })
</script>
@endsection