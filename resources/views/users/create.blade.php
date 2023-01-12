@extends('adminlte::page')

@section('title', 'Tambah Pengguna')

@section('content_header')
    <h1>Tambah Pengguna</h1>
@stop

@section('content')
    <section class="content">
        <div class="card">
            <div class="card-body table-responsive">
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('users.store') }}" method="post">
                    @method('post')
                    @csrf
                    <div class="form-group row">
                        <label for="username" class="col-sm-2 col-form-label">Username</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" id="username" name="username"
                                value="{{ old('username') }}" placeholder="Username Pengguna" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="nama" class="col-sm-2 col-form-label">Nama Pengguna</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" id="nama" name="nama"
                                value="{{ old('nama') }}" placeholder="Nama Pengguna" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-sm-2 col-form-label">Alamat Email</label>
                        <div class="col-sm-5">
                            <input type="email" class="form-control" id="email" name="email"
                                value="{{ old('email') }}" placeholder="Alamat Email" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password" class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-5">
                            <input type="password" class="form-control" id="password" name="password"
                                value="{{ old('password') }}" placeholder="Password" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="confirm" class="col-sm-2 col-form-label">Konfirmasi Password</label>
                        <div class="col-sm-5">
                            <input type="password" class="form-control" id="confirm" name="confirm" value=""
                                placeholder="Konfirmasi Password" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="role" class="col-sm-2 col-form-label">Role</label>
                        <div class="col-sm-5">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="id_role" id="id_role1" value="1">
                                <label class="form-check-label">Admin</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="id_role" id="id_role2" value="2"
                                    checked>
                                <label class="form-check-label">Petugas</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="submit" class="col-sm-2 col-form-label">&nbsp;</label>
                        <div class="col-sm-5">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@stop
