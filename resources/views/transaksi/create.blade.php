@extends('adminlte::page')

@section('title', 'Transaksi Baru')

@section('content_header')
    <h1>Transaksi Baru</h1>
@stop

@section('content')
    <section class="content">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('transaksi.store') }}" id="form" method="post">
                    @method('post')
                    @csrf
                    <div class="form-group row">
                        <label for="id_siswa" class="col-md-2 col-form-label">Siswa</label>
                        <div class="col-md-5">
                            <select class="form-control" name="id_siswa" id="id_siswa">
                                <option value="">Pilih Siswa</option>
                                @foreach ($siswa as $sis)
                                    <option value="{{ $sis->id_siswa }}">{{ $sis->nis . ' - ' . $sis->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="jenis_transaksi" class="col-md-2 col-form-label">Tagihan</label>
                        <div class="col-md-5">
                            <div id="tagihan"></div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="total_tagihan_belum_bayar" class="col-md-2 col-form-label">Total Tagihan Belum
                            Bayar</label>
                        <div class="col-md-3">
                            <h5 class="pt-1" id="total_tagihan_belum_bayar">Rp. 0</h5>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="saldo" class="col-md-2 col-form-label">Saldo Tabungan</label>
                        <div class="col-md-3">
                            <input type="hidden" name="saldo_tabungan_int" id="saldo_tabungan_int" readonly>
                            <h5 class="pt-1" id="saldo_tabungan">Rp. 0</h5>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="total_tagihan" class="col-md-2 col-form-label">Total Tagihan</label>
                        <div class="col-md-3">
                            <h5 class="pt-1" id="total_tagihan">Rp. 0</h5>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="bayar" class="col-md-2 col-form-label">Kredit dari Saldo Tabungan</label>
                        <div class="col-md-5">
                            <input type="number" class="form-control" name="bayar" id="bayar"
                                placeholder="Masukkan Nominal Total yang Dibayar" inputmode="numeric" readonly>
                            <div class="form-check pt-2">
                                <input class="form-check-input" type="checkbox" name="ambil_tabungan" id="ambil_tabungan"
                                    value="1" disabled>
                                <label class="form-check-label">Ambil dari saldo tabungan</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="kurang_bayar" class="col-md-2 col-form-label">Kurang Bayar</label>
                        <div class="col-md-5">
                            <input type="number" class="form-control" name="kurang_bayar" id="kurang_bayar"
                                placeholder="Masukkan Nominal" inputmode="numeric" disabled>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="submit" class="col-md-2 col-form-label">&nbsp;</label>
                        <div class="col-sm-5">
                            <a href="{{ route('transaksi.index') }}" class="btn btn-danger">Kembali</a>
                            <button type="submit" id="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@stop

@section('js')
    <script>
        var id_siswa = $('#id_siswa').find(':selected').val();
        var atabungan = document.getElementById('ambil_tabungan');

        $(function() {
            $('#id_siswa').select2({
                placeholder: 'Pilih Siswa...'
            });

            getTagihan(id_siswa);
            getSaldo(id_siswa);
        })

        $("#id_siswa").change(function(e) {
            e.preventDefault();
            var id_siswa = $(this).val();

            getTagihan(id_siswa);
            getSaldo(id_siswa);
        });

        function getTagihan(id_siswa) {
            $.ajax({
                url: "{{ route('transaksi.create') }}",
                method: 'get',
                data: {
                    id_siswa: id_siswa,
                    data: 'tagihan',
                    _token: "{{ csrf_token() }}",
                    _method: 'get',
                },
                success: function(data) {
                    var html = "";
                    $('#tagihan').empty();

                    if (data) {
                        var total_tagihan_siswa = parseFloat(data.total_tagihan).toLocaleString('id-ID', {
                            style: 'currency',
                            currency: 'IDR',
                        });
                        $.each(data.tagihan, function(key, tagihan) {
                            var jml_tagihan = parseFloat(tagihan.jml_tagihan).toLocaleString('id-ID', {
                                style: 'currency',
                                currency: 'IDR',
                            });

                            html += '<div class="form-check pt-2">';
                            html +=
                                '<input class="form-check-input" type="checkbox" name="id_tagihan[]" data-id="' +
                                tagihan.jml_tagihan + '" id="id_tagihan" value="' +
                                tagihan.id_tagihan + '">';
                            html += '<label class="form-check-label">';
                            html += tagihan.nama +
                                ' (' + jml_tagihan + ')<br/><span class="text-muted">Jatuh Tempo: ' +
                                tagihan.tgl_jatuh_tempo + '</span>';
                            html += '</label>';
                            html += '</div>';
                        });

                        $('#tagihan').html(html);
                        $('#total_tagihan_belum_bayar').html(total_tagihan_siswa);

                        getSelectedTagihan();
                    }
                }
            });
        }

        function getSelectedTagihan() {
            $('#form input[id=id_tagihan]').change(function() {
                document.getElementById('bayar').value = '';
                document.getElementById('ambil_tabungan').checked = false;
                document.getElementById('kurang_bayar').value = '';
                document.getElementById('kurang_bayar').disabled = true;

                var selected_tagihan = $("input[id=id_tagihan]:checked");
                var ambil_tabungan = document.getElementById('ambil_tabungan');
                var total_tagihan = 0;

                $.each(selected_tagihan, function(key, tagihan) {
                    var tag = tagihan.getAttribute('data-id');

                    total_tagihan = parseInt(total_tagihan) + parseInt(
                        tag);
                })

                ambil_tabungan.addEventListener('change', (event) => {
                    if (event.currentTarget.checked) {
                        var saldo_tabungan_tersisa = $('#saldo_tabungan_int').val();
                        if (total_tagihan < saldo_tabungan_tersisa) {
                            var total_tagihan_harus_bayar = total_tagihan;
                            $('#kurang_bayar').val();
                            document.getElementById('kurang_bayar').disabled = true;
                        } else {
                            var total_tagihan_harus_bayar = saldo_tabungan_tersisa;
                            var kurang_bayar = total_tagihan - saldo_tabungan_tersisa;
                            $('#kurang_bayar').val(kurang_bayar);
                            document.getElementById('kurang_bayar').disabled = false;
                        }

                        $('#bayar').val(total_tagihan_harus_bayar);
                    }
                })

                var total_tagihan_html = parseFloat(total_tagihan).toLocaleString(
                    'id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                    });

                $('#total_tagihan').html(total_tagihan_html);
            })
        }

        function getSaldo(id_siswa) {
            $.ajax({
                url: "{{ route('transaksi.create') }}",
                method: 'get',
                data: {
                    id_siswa: id_siswa,
                    data: 'saldo_tabungan',
                    _token: "{{ csrf_token() }}",
                    _method: 'get',
                },
                success: function(result) {
                    var selected_tagihan = $("input[id=id_tagihan]:checked");
                    var saldo = parseInt(result.saldo);
                    var saldosiswa = parseFloat(saldo).toLocaleString('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                    });

                    if (saldo > 0) {
                        document.getElementById("ambil_tabungan").disabled = false;
                    }

                    $('#saldo_tabungan_int').val(saldo);
                    $('#saldo_tabungan').html(saldosiswa);
                },
            })
        }
    </script>
@stop
