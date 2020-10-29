@extends('layouts.admin')

@section('title')
    <title>Edit Profile</title>
@endsection

@section('content')
<main class="main">
    <div class="container-fluid" style="padding: 0px 0px 0px 0px;">
        <div class="animated fadeIn">
            <div class="col-md-12">
                <div class="card shadow mb-4">
                    <div class="card-header bg-info">
                        <span class="text-xl font-weight-bold text-white text-uppercase mb-1">Profile</span>
                    </div>
                    <div class="card-body">
                        <form class="form-horizontal" enctype="multipart/form-data" id="profileForm">
                            <div class="row">
                                <div class="col-md-9">
                                    <input type="hidden" name="idUser" value="{{ $user->id }}">
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">Username</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="username" placeholder="Username" class="form-control form-control-sm" value="{{ $user->username }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">Nama Depan</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="nama_depan" placeholder="Nama Depan" class="form-control form-control-sm" value="{{ $user->nama_depan }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">nama Belakang</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="nama_belakang" placeholder="Nama Belakang" class="form-control form-control-sm" value="{{ $user->nama_belakang }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">No Telepon</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="no_telepon" placeholder="No Telepon" class="form-control form-control-sm" value="{{ $user->no_telepon }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">Email</label>
                                        <div class="col-sm-8">
                                            <input type="email" name="email" placeholder="Email" class="form-control form-control-sm" required value="{{ $user->email }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">Jenis Kelamin</label>
                                        <div class="col-sm-8">
                                            @foreach($gender as $value)
                                            <div class="form-check form-check-inline mr-1" id="genderList">
                                                <input type="radio" name="gender_id" class="form-check-input" value="{{ $value->id }}" {{ ($user->gender_id == $value->id) ? 'checked' : '' }}>
                                                <label class="form-check-label">{{ $value->name }}</label>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="text-center">
                                        <img src="/uploads/avatar/{{ $user->avatar }}" alt="" class="img-fluid" style="width: 200px; height: 200px; border-radius: 50%;">
                                    </div>
                                    <br>
                                    <input type="file" name="avatar" class="form-control-sm">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Alamat</label>
                                        <div class="col-sm-6">
                                            <input type="text" name="jalan" placeholder="Jalan" class="form-control form-control-sm" value="{{ $user->jalan }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label"></label>
                                        <div class="col-sm-3">
                                            <input type="text" name="provinsi" placeholder="Provinsi" class="form-control form-control-sm" value="{{ $user->provinsi }}">
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="text" name="kabupaten_kota" placeholder="Kabupaten / Kota" class="form-control form-control-sm" value="{{ $user->kabupaten_kota }}">
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="text" name="kecamatan" placeholder="Kecamatan" class="form-control form-control-sm" value="{{ $user->kecamatan }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label"></label>
                                        <div class="col-sm-3">
                                            <input type="text" name="kodepos" placeholder="Kodepos" class="form-control form-control-sm" value="{{ $user->kodepos }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Nomor KTP</label>
                                        <div class="col-sm-6">
                                            <input type="text" name="ktp" placeholder="Nomor KTP" class="form-control form-control-sm" value="{{ $user->ktp }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Rekening</label>
                                        <div class="col-sm-6">
                                            <input type="text" name="nama_bank" placeholder="Nama Bank" class="form-control form-control-sm" value="{{ $user->nama_bank }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label"></label>
                                        <div class="col-sm-6">
                                            <input type="text" name="nomor_rekening" placeholder="Nomor Rekening" class="form-control form-control-sm" value="{{ $user->nomor_rekening }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label"></label>
                                        <div class="col-sm-6">
                                            <input type="text" name="atasnama_bank" placeholder="Atasnama Rekening" class="form-control form-control-sm" value="{{ $user->atasnama_bank }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Join Date</label>
                                        <div class="col-sm-6">
                                            <span>{{ $user->join_date }}</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-12 text-center">
                                            <button type="submit" class="btn btn-primary btn-xs">Update</button>
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
        $('body').on('submit', '#profileForm', function(event) {
            event.preventDefault();

            var formData = new FormData(this);

            $.ajax({
                url: "{{ route('user.update') }}",
                method: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(res) {
                    if (res.code == 200) {
                        window.location.href = "{{ route('user.detail') }}";
                        $.notify(res.message, "success");
                    }
                }
            });
        })
    })
</script>
@endsection