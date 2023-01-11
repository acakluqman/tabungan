@extends('adminlte::page')

@section('title', 'Jenis Tagihan')

@section('content_header')
    <h1>Jenis Tagihan</h1>
@stop

@section('content')
    <section class="content">
        <div class="card">
            @can('jenis-tagihan.create')
                <div class="card-header">
                    <h3 class="card-title">
                        <a href="{{ route('kelas.create') }}" class="btn btn-primary">
                            <i class="fas fa-fw fa-plus"></i> Tambah Jenis Tagihan
                        </a>
                    </h3>
                </div>
            @endcan
            <div class="card-body">
                <table class="table table-striped table-hover" id="jenis">
                    <thead>
                        <tr>
                            <th width="5%" class="text-center">No.</th>
                            <th>Tahun Ajaran</th>
                            <th>Nama Tagihan</th>
                            <th>Jumlah Tagihan</th>
                            <th></th>
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
                ajax: "{{ route('kelas.index') }}",
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
                        data: 'thn_ajaran',
                        name: 'thn_ajaran',
                        render: function(data, type, row, meta) {
                            return row.thn_ajaran + '/' + (parseInt(row.thn_ajaran) + 1);
                        }
                    },
                    {
                        data: 'nama',
                        name: 'nama',
                        className: 'text-center',
                        render: function(data, type, row, meta) {
                            return 'Kelas ' + row.nama;
                        }
                    },
                    {
                        data: 'jml_siswa',
                        name: 'jml_siswa',
                        className: 'text-center',
                        render: function(data, type, row, meta) {
                            return row.jml_siswa + ' Siswa';
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        className: 'text-center',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
        })
    </script>
@stop
