@extends('adminlte::page')

@section('title', 'Transaksi Tabungan')

@section('content_header')
    <h1>Transaksi Tabungan</h1>
@stop

@section('content')
    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    Transaksi Tabungan
                </h3>
            </div>
            <div class="card-body">
                <form action="{{ route('tabungan.store') }}" name="form" id="form" method="post">
                    @method('post')
                    @csrf

                    <div class="form-group row">
                        <label for="tipe" class="col-sm-2 col-form-label">Jenis Transaksi</label>
                        <div class="col-sm-5">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="tipe" id="tipedebit" value="debit"
                                    checked required>
                                <label class="form-check-label">Setoran</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="tipe" id="tipekredit" value="kredit"
                                    required>
                                <label class="form-check-label">Penarikan</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="siswa" class="col-sm-2 col-form-label">Nama Siswa</label>
                        <div class="col-sm-5">
                            <select class="form-control" name="siswa" id="siswa">
                                @foreach ($siswa as $sis)
                                    <option value="{{ $sis->id_siswa }}">
                                        {{ $sis->nis . ' - ' . $sis->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="saldo" class="col-sm-2 col-form-label">Saldo Tabungan Siswa</label>
                        <div class="col-sm-5 pt-1">
                            <h5 id="saldo">Rp. 0</h5>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="nominal" class="col-sm-2 col-form-label">Nominal Transaksi</label>
                        <div class="col-sm-5">
                            <input type="number" class="form-control" name="nominal" id="nominal"
                                placeholder="Nominal Transaksi" value="{{ old('nominal') }}" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="keterangan" class="col-sm-2 col-form-label">Keterangan</label>
                        <div class="col-sm-5">
                            <textarea class="form-control" name="keterangan" id="keterangan" placeholder="Keterangan (Opsional)"></textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="submit" class="col-sm-2 col-form-label">&nbsp;</label>
                        <div class="col-sm-5">
                            <a href="{{ route('tabungan.index') }}" class="btn btn-danger">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
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
            var id_siswa = $('#siswa').find(':selected').val();
            var tipe = $("input[type='radio'][name='tipe']:checked").val();

            $('#siswa').select2({
                placeholder: 'Pilih Siswa...'
            });

            getSaldo(id_siswa);
        })

        $("#siswa").change(function(e) {
            e.preventDefault();
            var id_siswa = $(this).val();

            getSaldo(id_siswa);
        });

        function getSaldo(id_siswa) {
            $.ajax({
                url: "{{ route('tabungan.saldo') }}",
                method: 'post',
                data: {
                    id: id_siswa,
                    _token: "{{ csrf_token() }}",
                    _method: 'post',
                },
                success: function(result) {
                    var saldosiswa = parseFloat(result.saldo).toLocaleString('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                    });

                    $('#saldo').html(saldosiswa);
                },
            })
        }
    </script>
@stop
