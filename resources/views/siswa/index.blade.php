@extends('adminlte::page')

@section('title', 'Data Siswa')

@section('content_header')
    <h1>Data Siswa</h1>
@stop

@section('content')
    <section class="content">
        <div class="card">
            @can('users.create')
                <div class="card-header">
                    <h3 class="card-title">
                        <a href="{{ route('users.create') }}" class="btn btn-primary">
                            <i class="fas fa-fw fa-plus"></i> Tambah Siswa
                        </a>
                    </h3>
                </div>
            @endcan
            <div class="card-body">
                <table class="table table-striped table-hover" id="users">
                    <thead>
                        <tr>
                            <th width="5%" class="text-center">No.</th>
                            <th>NIS</th>
                            <th>Nama</th>
                            <th>Alamat</th>
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
            table = $('#users').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('siswa.index') }}",
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
                        data: 'nis',
                        name: 'nis'
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'alamat',
                        name: 'alamat'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
        })
    </script>
@stop
