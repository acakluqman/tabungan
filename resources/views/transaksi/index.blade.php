@extends('adminlte::page')

@section('title', 'Riwayat Transaksi')

@section('content_header')
    <h1>Riwayat Transaksi</h1>
@stop

@section('content')
    <section class="content">
        <div class="card">
            @can('transaksi.create')
                <div class="card-header">
                    <h3 class="card-title">
                        <a href="{{ route('transaksi.create') }}" class="btn btn-primary">
                            <i class="fas fa-fw fa-plus"></i> Transaksi Baru
                        </a>
                        <button type="button" data-toggle="modal" data-target="#modal-laporan" class="btn btn-danger">Cetak
                            Laporan</button>
                    </h3>
                </div>
            @endcan
            <div class="card-body table-responsive">
                <table class="table table-striped table-hover" id="transaksi">
                    <thead>
                        <tr>
                            <th style="width: 5%">No.</th>
                            <th>Nama Siswa</th>
                            <th>Nama Transaksi</th>
                            <th>Total Tagihan</th>
                            <th>Jumlah Dibayar</th>
                            <th>Tanggal Transaksi</th>
                            <th>Petugas</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </section>

    <div class="modal fade" id="modal-laporan">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cetak Laporan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('transaksi.download') }}" id="form" method="post">
                    @method('post')
                    @csrf
                    <div class="modal-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="tahun" class="control-label">Tahun</label>
                                <select style="width: 100%;" name="tahun" id="tahun" class="form-control">
                                    @for ($i = date('Y'); $i >= date('Y') - 3; $i--)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="bulan" class="control-label">Bulan</label>
                                <select style="width: 100%;" name="bulan" id="bulan" class="form-control">
                                    @for ($m = 1; $m <= 12; $m++)
                                        <option value="{{ $m }}">
                                            {{ \Carbon\Carbon::parse(date('F', mktime(0, 0, 0, $m, 1, date('Y'))))->isoFormat('MMMM') }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Cetak</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        table.dataTable tbody td {
            vertical-align: middle !important;
        }
    </style>
@stop

@section('js')
    <script>
        let table;

        $(function() {
            $('#tahun, #bulan').select2({
                minimumResultsForSearch: Infinity
            });

            table = $('#transaksi').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('transaksi.index') }}",
                language: {
                    processing: 'Loading...',
                    searchPlaceholder: 'Cari',
                    sSearch: '',
                    lengthMenu: '_MENU_',
                    zeroRecords: 'Tidak ada data yang dapat ditampilkan',
                    info: 'Halaman _PAGE_ dari _PAGES_',
                    infoFiltered: '(difilter dari _MAX_ data)'
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        className: 'text-center',
                        render: function(data) {
                            return data + '.';
                        },
                    },
                    {
                        data: 'nis',
                        name: 'nis',
                        render: function(data, type, row, meta) {
                            return row.nis + '<br>' + row.nama_siswa;
                        }
                    },
                    {
                        data: 'nama_tagihan',
                        name: 'nama_tagihan',
                    },
                    {
                        data: 'total_tagihan_parse',
                        name: 'total_tagihan_parse',
                    },
                    {
                        data: 'total_bayar_parse',
                        name: 'total_bayar_parse',
                    },
                    {
                        data: 'tgl_transaksi_parse',
                        name: 'tgl_transaksi_parse'
                    },
                    {
                        data: 'nama_petugas',
                        name: 'nama_petugas'
                    },
                ]
            });
        })
    </script>
@stop
