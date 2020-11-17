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

                      	<form id="registerForm" class="form-horizontal" enctype="multipart/form-data">
                            <fieldset>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Username <i class="text-xs text-danger">*</i></label>
                                            <div class="col-sm-9">
                                                <input class="form-control form-control-sm {{ $errors->has('username') ? ' is-invalid' : '' }}" 
                                                        type="text" 
                                                        name="username"
                                                        value="{{ old('username') }}"
                                                        required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Password <i class="text-xs text-danger">*</i></label>
                                            <div class="col-sm-9">
                                                <input class="form-control form-control-sm" 
                                                    type="password" 
                                                    name="password"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Ulangi Password <i class="text-xs text-danger">*</i></label>
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
                                                Nama Depan <i class="text-xs text-danger">*</i>
                                            </label>
                                            <div class="col-sm-9">
                                                <input type="text" name="nama_depan" placeholder="Nama Depan" class="form-control form-control-sm" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Nama Belakang <i class="text-xs text-danger">*</i></label>
                                            <div class="col-sm-9">
                                                <input type="text" name="nama_belakang" placeholder="Nama Belakang" class="form-control form-control-sm" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">No Telepon <i class="text-xs text-danger">*</i></label>
                                            <div class="col-sm-9">
                                                <input type="text" name="no_telepon" placeholder="No Telepon" class="form-control form-control-sm" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Email <i class="text-xs text-danger">*</i></label>
                                            <div class="col-sm-9">
                                                <input type="email" name="email" placeholder="ex: xxxx@gmail.com" class="form-control form-control-sm" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Jenis Kelamin <i class="text-xs text-danger">*</i></label>
                                            <div class="col-sm-9">
                                                @foreach($gender as $value)
                                                <div class="form-check form-check-inline mr-1" id="genderList">
                                                    <input type="radio" name="gender_id" class="form-check-input" value="{{ $value->id }}" required>
                                                    <label class="form-check-label">{{ $value->name }}</label>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Alamat <i class="text-xs text-danger">*</i></label>
                                            <div class="col-sm-9">
                                                <textarea type="text" name="jalan" placeholder="Jalan" class="form-control form-control-sm" rows="4" required></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label"></label>
                                            <div class="col-sm-3">
                                                <input type="text" name="provinsi" placeholder="Provinsi" class="form-control form-control-sm" required>
                                            </div>
                                            <div class="col-sm-3">
                                                <input type="text" name="kabupaten_kota" placeholder="Kabupaten / Kota" class="form-control form-control-sm" required>
                                            </div>
                                            <div class="col-sm-3">
                                                <input type="text" name="kecamatan" placeholder="Kecamatan" class="form-control form-control-sm" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label"></label>
                                            <div class="col-sm-3">
                                                <input type="text" name="kodepos" placeholder="Kodepos" class="form-control form-control-sm" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">
                                                Nomor KTP <i class="text-xs text-danger">*</i>
                                            </label>
                                            <div class="col-sm-9">
                                                <input type="text" name="ktp" placeholder="Nomor KTP" class="form-control form-control-sm" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">
                                                Upload Foto KTP <i class="text-xs text-danger">*</i>
                                            </label>
                                            <div class="col-sm-9">
                                                <input type="file" name="foto_ktp" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Rekening <i class="text-xs text-danger">*</i></label>
                                            <div class="col-sm-9">
                                                <input type="text" name="nama_bank" placeholder="Bank" class="form-control form-control-sm" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label"></label>
                                            <div class="col-sm-9">
                                                <input type="text" name="nomor_rekening" placeholder="Nomor Rekening" class="form-control form-control-sm" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label"></label>
                                            <div class="col-sm-9">
                                                <input type="text" name="atasnama_bank" placeholder="Rekening Atas Nama" class="form-control form-control-sm" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <span class="text-xs text-danger font-weight-bold">
                                    NB : Pastikan data yang diinputkan sudah benar semua.
                                    <br/>
                                    Karena jika ingin melakukan perubahan data silahkan menghubungi ADMIN dengan cara kirim email ke affiliate.system.dvnt@gmail.com
                                </span>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary btn-sm px-3">Register</button>
                                        &nbsp;
                                        <a href="{{ route('login') }}" class="btn btn-danger btn-sm px-3">Back to Login</a>
                                        
                                        <div id="loader" style="float: right; display: none;">
                                            <img src="/uploads/spinner.gif" witdth="35px" height="35px"/>
                                        </div>
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
        
        $('body').on('submit', '#registerForm', function(e) {
            e.preventDefault();

            var formData = new FormData(this);

            $.ajax({
                url: "{{ route('auth.register') }}",
                method: "POST",
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $(fieldset).attr('disabled', true);
                    $('#loader').show();
                },
                success: function (res) {
                    if (res.code == 200) {
                        $.notify(res.message, "success");
                        window.location.assign(res.data.link);
                    }
                }
            })
        });
    })
</script>
@endsection