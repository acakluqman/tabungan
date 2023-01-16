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
                    <div class="card-body table-responsive">
                        <div class="row">
                            <div class="col-md-2">
                                <label for="nis" class="control-label">NIS</label>
                                <input type="text" class="form-control" name="nis" id="nis"
                                    value="{{ $siswa->nis }}" readonly>
                            </div>
                            <div class="col-md-4">
                                <label for="nama" class="control-label">Nama Siswa</label>
                                <input type="text" class="form-control" name="nama" id="nama"
                                    value="{{ $siswa->nama }}" readonly>
                            </div>
                            <div class="col-md-3">
                                <label for="thn_ajaran" class="control-label">Tahun Ajaran</label>
                                <input class="form-control" type="text"
                                    value="{{ $tahun->thn_ajaran . '/' . ($tahun->thn_ajaran + 1) }}" readonly>
                            </div>
                            <div class="col-md-3">
                                <label for="kelas" class="control-label">Kelas</label>
                                <input type="text" class="form-control" value="{{ $kelas->nama }}" readonly>
                            </div>
                        </div>
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
                                    <th style="width: 5%;">No.</th>
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
            table = $('#tagihan').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('tagihan.siswa') }}",
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
                        data: 'nama',
                        name: 'nama'
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
                        data: 'tgl_jatuh_tempo',
                        name: 'tgl_jatuh_tempo',
                        render: function(data, type, row, meta) {
                            return row.tgl_jatuh_tempo_parse;
                        }
                    },
                    {
                        data: 'id_status_tagihan',
                        name: 'id_status_tagihan',
                        render: function(data, type, row, meta) {
                            if (row.id_status_tagihan == 1) {
                                return '<span class="text-warning">Belum Bayar</span>';
                            } else {
                                return '<span class="text-success">Sudah Bayar</span>';
                            }
                        }
                    },
                ]
            });
        })
    </script>
@stop
