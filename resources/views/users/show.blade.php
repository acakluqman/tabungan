@extends('adminlte::page')

@section('title', 'Detail Pengguna')

@section('content_header')
    <h1>Detail Pengguna</h1>
@stop

@section('content')
    <section class="content">
        <div class="card">
            <div class="card-header">
                <a href="{{ route('users.edit', $user) }}" class="btn float-right btn-success"><i
                        class="fas fa-pencil-alt"></i> Edit
                    Pengguna</a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <label for="username" class="control-label">Username</label>
                        <p>{{ $user->username }}</p>
                    </div>
                    <div class="col-md-6">
                        <label for="nama" class="control-label">Nama Pengguna</label>
                        <p>{{ $user->nama }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="email" class="control-label">Alamat Email</label>
                        <p>{{ $user->Email }}</p>
                    </div>
                    <div class="col-md-6">
                        <label for="role" class="control-label">Role / Hak Akses</label>
                        <p>
                            @foreach ($user->roles as $role)
                                {{ ucfirst($role->name) }}
                            @endforeach
                        </p>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('users.index') }}" class="btn btn-danger"><i class="fas fa-arrow-left"></i> Kembali</a>
            </div>
        </div>
    </section>
@stop
