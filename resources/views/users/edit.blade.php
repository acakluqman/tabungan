@extends('adminlte::page')

@section('title', 'Edit Pengguna')

@section('content_header')
    <h1>Edit Pengguna</h1>
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

                <form action="{{ route('users.update', ['id' => $user->id_user]) }}" method="post">
                    @method('patch')
                    @csrf
                    <div class="form-group row">
                        <label for="username" class="col-sm-2 col-form-label">Username</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" name="username" id="username" value="{{ $user->username }}"
                                placeholder="Username" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="nama" id="nama" value="{{ $user->nama }}"
                                placeholder="Nama Pengguna" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-sm-2 col-form-label">Alamat Email</label>
                        <div class="col-sm-5">
                            <input type="email" class="form-control" name="email" id="email" value="{{ $user->email }}"
                                placeholder="Alamat Email" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="role" class="col-sm-2 col-form-label">Role</label>
                        <div class="col-sm-5">
                            @foreach ($roles as $role)
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="id_role"
                                        id="id_role_{{ $role->id }}" value="{{ $role->id }}"
                                        {{ $role->id == $userRole[0] ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ ucfirst($role->name) }}</label>
                                </div>
                            @endforeach
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
                </form>
            </div>
        </div>
    </section>
@stop
