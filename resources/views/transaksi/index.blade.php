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
                            <th>Jenis Transaksi</th>
                            <th>Tanggal Transaksi</th>
                            <th>Petugas</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </section>
@stop

@section('js')
    <script>
        let table;

        $(function() {
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
                            return '<p class="mg-b-0">' + data + '.</p>';
                        },
                    },
                    {
                        data: 'id_transaksi',
                        name: 'id_transaksi',
                        // render: function(data, type, row, meta) {
                        //     return row.thn_ajaran + '/' + (parseInt(row.thn_ajaran) + 1);
                        // }
                    },
                    {
                        data: 'id_transaksi',
                        name: 'id_transaksi',
                        // render: function(data, type, row, meta) {
                        //     return row.thn_ajaran + '/' + (parseInt(row.thn_ajaran) + 1);
                        // }
                    },
                    {
                        data: 'id_transaksi',
                        name: 'id_transaksi',
                        // render: function(data, type, row, meta) {
                        //     return row.thn_ajaran + '/' + (parseInt(row.thn_ajaran) + 1);
                        // }
                    },
                    {
                        data: 'id_transaksi',
                        name: 'id_transaksi',
                        // render: function(data, type, row, meta) {
                        //     return row.thn_ajaran + '/' + (parseInt(row.thn_ajaran) + 1);
                        // }
                    },
                    {
                        data: 'id_transaksi',
                        name: 'id_transaksi',
                        // render: function(data, type, row, meta) {
                        //     return row.thn_ajaran + '/' + (parseInt(row.thn_ajaran) + 1);
                        // }
                    },
                ]
            });
        })
    </script>
@stop
