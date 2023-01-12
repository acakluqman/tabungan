@extends('adminlte::page')

@section('title', 'Tagihan Siswa')

@section('content_header')
    <h1>Tagihan Siswa</h1>
@stop

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    @can('tagihan.create')
                        <div class="card-header">
                            <h3 class="card-title">
                                <a href="{{ route('tagihan.create') }}" class="btn btn-primary">
                                    <i class="fas fa-fw fa-plus"></i> Buat Tagihan
                                </a>
                            </h3>
                        </div>
                    @endcan
                    <div class="card-body table-responsive">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="thn_ajaran" class="control-label">Tahun Ajaran</label>
                                <select name="thn_ajaran" id="thn_ajaran" class="form-control">
                                    <option value="">dfdfg</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="id_jenis_tagihan" class="control-label">Jenis Tagihan</label>
                                <select name="id_jenis_tagihan" id="id_jenis_tagihan" class="form-control">
                                    <option value="">dfdfg</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="status" class="control-label">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="">dfdfg</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-primary"><i class="fas fa-search"></i> Filter</button>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            Data Tagihan Siswa
                        </h3>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-striped table-hover" id="tagihan">
                            <thead>
                                <tr>
                                    <th width="5%" class="text-center">No.</th>
                                    <th>Nama Siswa</th>
                                    <th>Kelas</th>
                                    <th>Nama Tagihan</th>
                                    <th>Jumlah Tagihan</th>
                                    <th>Jatuh Tempo</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
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
            table = $('#tagihan').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('tagihan.index') }}",
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
                        data: 'id_tagihan',
                        name: 'id_tagihan',
                        // render: function(data, type, row, meta) {
                        //     return row.thn_ajaran + '/' + (parseInt(row.thn_ajaran) + 1);
                        // }
                    },
                    {
                        data: 'id_tagihan',
                        name: 'id_tagihan',
                        // render: function(data, type, row, meta) {
                        //     return row.thn_ajaran + '/' + (parseInt(row.thn_ajaran) + 1);
                        // }
                    },
                    {
                        data: 'id_tagihan',
                        name: 'id_tagihan',
                        // render: function(data, type, row, meta) {
                        //     return row.thn_ajaran + '/' + (parseInt(row.thn_ajaran) + 1);
                        // }
                    },
                    {
                        data: 'id_tagihan',
                        name: 'id_tagihan',
                        // render: function(data, type, row, meta) {
                        //     return row.thn_ajaran + '/' + (parseInt(row.thn_ajaran) + 1);
                        // }
                    },
                    {
                        data: 'id_tagihan',
                        name: 'id_tagihan',
                        // render: function(data, type, row, meta) {
                        //     return row.thn_ajaran + '/' + (parseInt(row.thn_ajaran) + 1);
                        // }
                    },
                    {
                        data: 'id_tagihan',
                        name: 'id_tagihan',
                        // render: function(data, type, row, meta) {
                        //     return row.thn_ajaran + '/' + (parseInt(row.thn_ajaran) + 1);
                        // }
                    },
                ]
            });
        })
    </script>
@stop
