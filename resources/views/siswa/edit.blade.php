@extends('adminlte::page')

@section('title', 'Edit Siswa')

@section('content_header')
    <h1>Edit Siswa</h1>
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

                <form action="{{ route('siswa.update', ['id' => $siswa->id_siswa]) }}" method="post">
                    @method('patch')
                    @csrf
                    <input type="hidden" name="id_siswa" value="{{ $siswa->id_siswa }}" readonly>
                    <input type="hidden" name="id_user" value="{{ $siswa->id_user }}" readonly>
                    <div class="form-group row">
                        <label for="nis" class="col-sm-2 col-form-label">NIS</label>
                        <div class="col-sm-5">
                            <input type="number" class="form-control" id="nis" name="nis"
                                value="{{ $siswa->nis }}" placeholder="NIS" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="nama" class="col-sm-2 col-form-label">Nama Siswa</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" id="nama" name="nama"
                                value="{{ $siswa->nama }}" placeholder="Nama Siswa" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-sm-2 col-form-label">Alamat Email</label>
                        <div class="col-sm-5">
                            <input type="email" class="form-control" id="email" name="email"
                                value="{{ $user->email }}" placeholder="Email" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" id="alamat" name="alamat"
                                value="{{ $siswa->alamat }}" placeholder="Alamat Siswa" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="jk" class="col-sm-2 col-form-label">Jenis Kelamin</label>
                        <div class="col-sm-5">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="jk" id="jkl" value="L"
                                    {{ $siswa->jk == 'L' ? 'checked' : '' }}>
                                <label class="form-check-label">Laki-Laki</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="jk" id="jkp" value="P"
                                    {{ $siswa->jk == 'P' ? 'checked' : '' }}>
                                <label class="form-check-label">Perempuan</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="submit" class="col-sm-2 col-form-label">&nbsp;</label>
                        <div class="col-sm-5">
                            <a href="{{ route('siswa.index') }}" class="btn btn-danger">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@stop
