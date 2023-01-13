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
                            <div class="col-md-2">
                                <label for="thn_ajaran" class="control-label">Tahun Ajaran</label>
                                <select name="thn_ajaran" id="thn_ajaran" class="form-control">
                                    @foreach ($tahun as $th)
                                        <option value="{{ $th->thn_ajaran }}">
                                            {{ 'TA ' . $th->thn_ajaran . '/' . ($th->thn_ajaran + 1) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="id_jenis_tagihan" class="control-label">Jenis Tagihan</label>
                                <select name="id_jenis_tagihan" id="id_jenis_tagihan" class="form-control">
                                    <option value="">Semua Jenis Tagihan</option>
                                    @foreach ($jenis as $jns)
                                        <option value="{{ $jns->id_jenis_tagihan }}">{{ $jns->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="status" class="control-label">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="">Semua Status</option>
                                    <option value="1">Belum Bayar</option>
                                    <option value="2">Sudah Bayar</option>
                                </select>
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
                ajax: {
                    url: "{{ route('tagihan.index') }}",
                    data: function(d) {
                        d.thn_ajaran = $('#thn_ajaran').val();
                        d.id_jenis_tagihan = $('#id_jenis_tagihan').val();
                        d.status = $('#status').val();
                    }
                },
                language: {
                    processing: 'Loading...',
                    searchPlaceholder: 'Cari',
                    sSearch: '',
                    lengthMenu: '_MENU_',
                    zeroRecords: 'Tidak ada data yang dapat ditampilkan',
                    info: 'Halaman _PAGE_ dari _PAGES_' ,
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
                        data: 'nama_siswa',
                        name: 'nama_siswa',
                        render: function(data, type, row, meta) {
                            return row.nis + '<br/>' + row.nama_siswa;
                        }
                    },
                    {
                        data: 'kelas',
                        name: 'kelas',
                        className: 'text-center'
                    },
                    {
                        data: 'nama_tagihan',
                        name: 'nama_tagihan'
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

            $('#thn_ajaran, #status').select2({
                minimumResultsForSearch: Infinity
            });

            $('#id_jenis_tagihan').select2();

            $('#thn_ajaran, #id_jenis_tagihan, #status').on('change', function() {
                $('#tagihan').DataTable().ajax.reload();
            })
        })
    </script>
@stop
