@extends('adminlte::page')

@section('title', 'Edit Pengguna')

@section('content_header')
    <h1>Edit Pengguna</h1>
@stop

@section('content')
    <section class="content">
        <div class="card">
            <div class="card-body">
                <div class="form-group row">
                    <label for="username" class="col-sm-2 col-form-label">Username</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" id="username" value="{{ $user->username }}"
                            placeholder="Username" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" id="nama" value="{{ $user->nama }}"
                            placeholder="Nama Pengguna" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="email" class="col-sm-2 col-form-label">Alamat Email</label>
                    <div class="col-sm-5">
                        <input type="email" class="form-control" id="email" value="{{ $user->email }}"
                            placeholder="Alamat Email" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="password" class="col-sm-2 col-form-label">Password Baru</label>
                    <div class="col-sm-5">
                        <input type="password" class="form-control" id="password" value=""
                            placeholder="Password Baru" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="confirm" class="col-sm-2 col-form-label">Konfirmasi Password</label>
                    <div class="col-sm-5">
                        <input type="password" class="form-control" id="confirm" value=""
                            placeholder="Konfirmasi Password" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="submit" class="col-sm-2 col-form-label">&nbsp;</label>
                    <div class="col-sm-5">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                        <a href="{{ route('users.index') }}" class="btn btn-danger"><i class="fas fa-arrow-left"></i>
                            Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
