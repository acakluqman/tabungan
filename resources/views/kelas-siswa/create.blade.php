@extends('adminlte::page')

@section('title', 'Atur Kelas Siswa')

@section('content_header')
    <h1>Atur Kelas Siswa</h1>
@stop

@section('content')
    <section class="content">
        <div class="card">
            <div class="card-body">
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('kelas-siswa.store') }}" method="post">
                    @method('post')
                    @csrf
                    <div class="form-group row">
                        <label for="thn_ajaran" class="col-sm-2 col-form-label">Tahun Ajaran</label>
                        <div class="col-sm-3">
                            <select name="thn_ajaran" id="thn_ajaran" class="form-control">
                                @foreach ($tahun as $th)
                                    <option value="{{ $th->thn_ajaran }}">
                                        {{ $th->thn_ajaran . '/' . ($th->thn_ajaran + 1) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="kelas" class="col-sm-2 col-form-label">Kelas</label>
                        <div class="col-sm-3">
                            <select name="kelas" id="kelas" class="form-control">
                                @foreach ($kelas as $kl)
                                    <option value="{{ $kl->id_kelas }}">
                                        {{ $kl->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="siswa" class="col-sm-2 col-form-label">Siswa</label>
                        <div class="col-sm-10">
                            <select name="siswa[]" id="siswa" class="form-control" multiple>
                                @foreach ($siswa as $sw)
                                    <option value="{{ $sw->id_siswa }}">
                                        {{ $sw->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="submit" class="col-sm-2 col-form-label">&nbsp;</label>
                        <div class="col-sm-5">
                            <a href="{{ route('kelas-siswa.index') }}" class="btn btn-danger"><i
                                    class="fas fa-arrow-left"></i> Kembali</a>
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@stop

@section('js')
    <script>
        $(function() {
            $('#thn_ajaran').select2({
                placeholder: 'Pilih Tahun Ajaran'
            });
            $('#kelas').select2({
                placeholder: 'Pilih Kelas'
            });
            $('#siswa').select2({
                placeholder: 'Pilih Siswa'
            });
        })
    </script>
@stop
