@extends('adminlte::page')

@section('title', 'Riwayat Transaksi Siswa')

@section('content_header')
    <h1>Riwayat Transaksi Siswa</h1>
@stop

@section('content')
    <section class="content">
        <div class="card">
            <div class="card-body table-responsive">
                <table class="table table-striped table-hover" id="transaksi">
                    <thead>
                        <tr>
                            <th style="width: 5%">No.</th>
                            <th>Tagihan</th>
                            <th>Jumlah Tagihan</th>
                            <th>Total Bayar</th>
                            <th>Tanggal</th>
                            <th>Petugas</th>
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
            table = $('#transaksi').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('transaksi.siswa') }}",
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
                        data: 'nama_tagihan',
                        name: 'nama_tagihan',
                        // render: function(data, type, row, meta) {
                        //     return row.thn_ajaran + '/' + (parseInt(row.thn_ajaran) + 1);
                        // }
                    },
                    {
                        data: 'jml_tagihan',
                        name: 'jml_tagihan',
                        render: function(data, type, row, meta) {
                            return parseFloat(row.jml_tagihan).toLocaleString('id-ID', {
                                style: 'currency',
                                currency: 'IDR',
                            });
                        }
                    },
                    {
                        data: 'total_bayar',
                        name: 'total_bayar',
                        render: function(data, type, row, meta) {
                            return parseFloat(row.total_bayar).toLocaleString('id-ID', {
                                style: 'currency',
                                currency: 'IDR',
                            });
                        }
                    },
                    {
                        data: 'tgl_tx',
                        name: 'tgl_tx',
                    },
                    {
                        data: 'nama_petugas',
                        name: 'nama_petugas',
                    },
                ]
            });
        })
    </script>
@stop
