@extends('adminlte::page')

@section('title', 'Rekap Tabungan Siswa')

@section('content_header')
    <h1>Rekap Tabungan Siswa</h1>
@stop

@section('content')
    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    Rekap Tabungan Siswa: {{ $siswa->nama }}
                </h3>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-striped table-hover" id="jenis">
                    <thead>
                        <tr>
                            <th style="width: 5%;" class="text-center">No.</th>
                            <th style="width: 20%;">Tanggal Transaksi</th>
                            <th style="width: 20%;">Petugas</th>
                            <th>Keterangan</th>
                            <th style="width: 15%;">Nominal</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </section>
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
            table = $('#jenis').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('tabungan.show', ['id' => $siswa->id_siswa]) }}",
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
                        className: 'text-center align-middle',
                        render: function(data) {
                            return data + '.';
                        },
                    },
                    {
                        data: 'tipe',
                        name: 'tipe',
                        render: function(data, type, row, meta) {
                            if (row.tipe == 'debit') {
                                return '<span class="badge bg-success">DEBIT</span><br/>' + row
                                    .tgl_tx;
                            } else {
                                return '<span class="badge bg-danger">KREDIT</span><br/>' + row
                                    .tgl_tx;
                            }
                        }
                    },
                    {
                        data: 'petugas',
                        name: 'petugas',
                    },
                    {
                        data: 'keterangan',
                        name: 'keterangan',
                        render: function(data, type, row, meta) {
                            return row.keterangan ? row.keterangan : '-';
                        }
                    },
                    {
                        data: 'nominal',
                        name: 'nominal',
                        className: 'text-right',
                        orderable: false,
                        render: function(data, type, row, meta) {
                            return parseFloat(row.nominal).toLocaleString('id-ID', {
                                style: 'currency',
                                currency: 'IDR',
                            });
                        }
                    },
                ]
            });
        })
    </script>
@stop
