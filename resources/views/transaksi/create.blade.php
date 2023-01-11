@extends('adminlte::page')

@section('title', 'Transaksi Baru')

@section('content_header')
    <h1>Transaksi Baru</h1>
@stop

@section('content')
    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    Transaksi Baru
                </h3>
            </div>

            <div class="card-body">
                <form action="" id="form" method="post">
                    @method('post')
                    @csrf
                    <div class="form-group row">
                        <label for="id_siswa" class="col-sm-2 col-form-label">Siswa</label>
                        <div class="col-sm-3">
                            <select class="form-control" name="id_siswa" id="id_siswa">
                                <option value="">Pilih Siswa</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="jenis_transaksi" class="col-sm-2 col-form-label">Jenis Transaksi</label>
                        <div class="col-sm-3">
                            <select class="form-control" name="jenis_transaksi" id="jenis_transaksi">
                                <option value="">Tagihan Keuangan Sekolah</option>
                                <option value="">Tabungan</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="submit" class="col-sm-2 col-form-label">&nbsp;</label>
                        <div class="col-sm-5">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                            <a href="{{ route('transaksi.index') }}" class="btn btn-danger"><i class="fas fa-arrow-left"></i>
                                Kembali</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@stop

@section('js')
    <script></script>
@stop
