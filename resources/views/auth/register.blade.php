@extends('layouts.auth')

@section('title')
    <title>Register Account</title>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card-group">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body">
                        <h1>Register</h1>
                        <p class="text-muted">Create Your Affiliate Account</p>

                      	<form class="form-horizontal" id="registerForm">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Username</label>
                                        <div class="col-sm-9">
                                            <input class="form-control form-control-sm {{ $errors->has('username') ? ' is-invalid' : '' }}" 
                                                    type="text" 
                                                    name="username"
                                                    value="{{ old('username') }}"
                                                    required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Passowrd</label>
                                        <div class="col-sm-9">
                                            <input class="form-control form-control-sm" 
                                                type="password" 
                                                name="password"
                                                required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Ulangi Passowrd</label>
                                        <div class="col-sm-9">
                                            <input class="form-control form-control-sm" 
                                                type="password" 
                                                name="password_confirmation"
                                                required>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">
                                            Nama Depan
                                        </label>
                                        <div class="col-sm-9">
                                            <input type="text" name="nama_depan" placeholder="Nama Depan" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Nama Belakang</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="nama_belakang" placeholder="Nama Belakang" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">No Telepon</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="no_telepon" placeholder="No Telepon" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Email</label>
                                        <div class="col-sm-9">
                                            <input type="email" name="email" placeholder="ex: xxxx@gmail.com" class="form-control form-control-sm" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Jenis Kelamin</label>
                                        <div class="col-sm-9">
                                            @foreach($gender as $value)
                                            <div class="form-check form-check-inline mr-1" id="genderList">
                                                <input type="radio" name="gender_id" class="form-check-input">
                                                <label class="form-check-label">{{ $value->name }}</label>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Alamat</label>
                                        <div class="col-sm-9">
                                            <textarea type="text" name="jalan" placeholder="Jalan" class="form-control form-control-sm" rows="4"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label"></label>
                                        <div class="col-sm-3">
                                            <input type="text" name="provinsi" placeholder="Provinsi" class="form-control form-control-sm">
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="text" name="kabupaten_kota" placeholder="Kabupaten / Kota" class="form-control form-control-sm">
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="text" name="kecamatan" placeholder="Kecamatan" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label"></label>
                                        <div class="col-sm-3">
                                            <input type="text" name="kodepos" placeholder="Kodepos" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">
                                            Nomor KTP
                                        </label>
                                        <div class="col-sm-9">
                                            <input type="text" name="ktp" placeholder="Nomor KTP" class="form-control form-control-sm">
                                            <i class="text-xs text-danger">* required</i>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Rekening</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="nama_bank" placeholder="Bank" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label"></label>
                                        <div class="col-sm-9">
                                            <input type="text" name="nomor_rekening" placeholder="Nomor Rekening" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label"></label>
                                        <div class="col-sm-9">
                                            <input type="text" name="atasnama_bank" placeholder="Rekening Atas Nama" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <button class="btn btn-info px-3" id="register-button">Register</button>
                                </div>
                            </div>
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
        $('body').on('click', '#register-button', function(e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('auth.register') }}",
                method: "POST",
                datatype: "JSON",
                data: $('#registerForm').serialize(),
                success: function (res) {
                    if (res.code == 200) {
                        $.notify(res.message, "success");
                        window.location.href = "{{ route('login') }}";
                    } else {
                        $.notify(res.message, "error");
                    }
                }
            });
        });
    });
</script>
@endsection