@extends('layouts.admin')

@section('title')
    <title>Detail Profile</title>
@endsection

@section('content')
<main class="main">
    <div class="container-fluid" style="padding: 0px 0px 0px 0px;">
        <div class="animated fadeIn">
            <div class="col-md-12">
                <div class="card shadow mb-4">
                    <div class="card-header bg-info">
                        <span class="text-xl font-weight-bold text-white text-uppercase mb-1">Detail Profile</span>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Username</label>
                                    <div class="col-sm-8">
                                        {{ $user->username }}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Nama Depan</label>
                                    <div class="col-sm-8">
                                        {{ $user->nama_depan }}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">nama Belakang</label>
                                    <div class="col-sm-8">
                                        {{ $user->nama_belakang }}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">No Telepon</label>
                                    <div class="col-sm-8">
                                        {{ $user->no_telepon }}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Email</label>
                                    <div class="col-sm-8">
                                        {{ $user->email }}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Jenis Kelamin</label>
                                    <div class="col-sm-8">
                                        {{ $user->gender_id ? $user->gender->name : '' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Alamat</label>
                                    <div class="col-sm-6">
                                        {{ $user->jalan }}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"></label>
                                    <div class="col-sm-3">
                                        {{ $user->provinsi }}
                                    </div>
                                    <div class="col-sm-3">
                                        {{ $user->kabupaten_kota }}
                                    </div>
                                    <div class="col-sm-3">
                                        {{ $user->kecamatan }}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"></label>
                                    <div class="col-sm-3">
                                        {{ $user->kodepos }}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Nomor KTP</label>
                                    <div class="col-sm-6">
                                        {{ $user->ktp }}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Foto KTP</label>
                                    <div class="col-sm-6">
                                        <img src="/uploads/avatar/{{ $user->avatar }}" alt="" class="img-fluid" style="width: 300px; height: 200px; border-radius: 5%;">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Rekening</label>
                                    <div class="col-sm-6">
                                        {{ $user->nama_bank }}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"></label>
                                    <div class="col-sm-6">
                                        {{ $user->nomor_rekening }}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"></label>
                                    <div class="col-sm-6">
                                        {{ $user->atasnama_bank }}
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
                                    @can('isAdmin')
                                        @if($user->id == Auth::id())
                                            <a href="{{ route('user.editProfile') }}" class="btn btn-warning btn-xs">Edit</a>
                                        @else
                                            <a href="{{ route('user.editUser', $user->id) }}" class="btn btn-warning btn-xs">Edit</a>
                                        @endif
                                    @endcan
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection