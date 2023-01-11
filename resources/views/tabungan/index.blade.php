@extends('adminlte::page')

@section('title', 'Tabungan Siswa')

@section('content_header')
    <h1>Tabungan Siswa</h1>
@stop

@section('content')
    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    Rekap Saldo Tabungan Siswa
                </h3>
            </div>
            <div class="card-body">
                <table class="table table-striped table-hover" id="jenis">
                    <thead>
                        <tr>
                            <th width="5%" class="text-center">No.</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Saldo Tabungan</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </section>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        let table;

        $(function() {
            table = $('#jenis').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('tabungan.index') }}",
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
                        render: function(data) {
                            return '<p class="mg-b-0">' + data + '.</p>';
                        },
                        className: 'text-center'
                    },
                    {
                        data: 'id_tabungan',
                        name: 'id_tabungan',
                        // render: function(data, type, row, meta) {
                        //     return row.thn_ajaran + '/' + (parseInt(row.thn_ajaran) + 1);
                        // }
                    },
                    {
                        data: 'id_tabungan',
                        name: 'id_tabungan',
                        // render: function(data, type, row, meta) {
                        //     return row.thn_ajaran + '/' + (parseInt(row.thn_ajaran) + 1);
                        // }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        className: 'text-right',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
        })
    </script>
@stop
