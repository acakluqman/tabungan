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

            <div class="card-body table-responsive">
                <form action="" id="form" method="post">
                    @method('post')
                    @csrf
                    <div class="form-group row">
                        <label for="id_siswa" class="col-sm-2 col-form-label">Siswa</label>
                        <div class="col-sm-3">
                            <select class="form-control" name="id_siswa" id="id_siswa">
                                <option value="">Pilih Siswa</option>
                                @foreach ($siswa as $sis)
                                    <option value="{{ $sis->id_siswa }}">{{ $sis->nis . ' - ' . $sis->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="jenis_transaksi" class="col-sm-2 col-form-label">Tagihan</label>
                        <div class="col-sm-3">
                            <div class="form-check pt-2">
                                <input class="form-check-input" type="checkbox" name="bayar_semua" id="bayar_semua"
                                    value="">
                                <label class="form-check-label">Bayar Semua</label>
                            </div>
                            <div class="form-check pt-2">
                                <input class="form-check-input" type="checkbox" name="id_tagihan[]" id="id_tagihan"
                                    value="">
                                <label class="form-check-label">Nama Tagihan (Rp. 143545) <span class="text-muted">Jatuh tempo: </span></label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="saldo" class="col-sm-2 col-form-label">Saldo Tabungan</label>
                        <div class="col-sm-3">
                            <h5 class="pt-1" id="saldo_tabungan">Rp. 0</h5>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="total_tagihan" class="col-sm-2 col-form-label">Total Tagihan</label>
                        <div class="col-sm-3">
                            <h5 class="pt-1" id="total_tagihan">Rp. 0</h5>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="bayar" class="col-sm-2 col-form-label">Total Bayar</label>
                        <div class="col-sm-3">
                            <input type="number" class="form-control" name="total" id="total"
                                placeholder="Masukkan Nominal Total yang Dibayar" inputmode="numeric">
                            <div class="form-check pt-2">
                                <input class="form-check-input" type="checkbox" name="ambil_tabungan" id="ambil_tabungan"
                                    value="1">
                                <label class="form-check-label">Ambil dari saldo tabungan</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="submit" class="col-sm-2 col-form-label">&nbsp;</label>
                        <div class="col-sm-5">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                            <a href="{{ route('transaksi.index') }}" class="btn btn-danger"><i
                                    class="fas fa-arrow-left"></i>
                                Kembali
                            </a>
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
            $('#id_siswa').select2();
        })
    </script>
@stop
