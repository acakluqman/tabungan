@extends('adminlte::page')

@section('title', 'Tabungan Siswa')

@section('content_header')
    <h1>Tabungan Siswa</h1>
@stop

@section('content')
    <section class="content">
        <div class="card">
            @can('transaksi.create')
                <div class="card-header">
                    <h3 class="card-title">
                        <a href="{{ route('tabungan.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Transaksi Baru</a>
                    </h3>
                </div>
            @endcan
            <div class="card-body table-responsive">
                <table class="table table-striped table-hover" id="jenis">
                    <thead>
                        <tr>
                            <th style="width: 5%;" class="text-center">No.</th>
                            <th>NIS</th>
                            <th>Nama Siswa</th>
                            <th style="width: 5%;">LP</th>
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
                        className: 'text-center',
                        render: function(data) {
                            return '<p class="mg-b-0">' + data + '.</p>';
                        },
                    },
                    {
                        data: 'nis',
                        name: 'nis',
                        render: function(data, type, row, meta) {
                            return '<a href="/tabungan/' + row.id_siswa + '/show">' + row.nis +
                                '</a>';
                        }
                    },
                    {
                        data: 'nama',
                        name: 'nama',
                    },
                    {
                        data: 'jk',
                        name: 'jk',
                    },
                    {
                        data: 'nama_kelas',
                        name: 'nama_kelas',
                        render: function(data, type, row, meta) {
                            return 'Kelas ' + row.nama_kelas;
                        }
                    },
                    {
                        data: 'saldo',
                        name: 'saldo',
                        className: 'text-right',
                        render: function(data, type, row, meta) {
                            return parseFloat(parseFloat(row.debit) - parseFloat(row
                                .kredit)).toLocaleString('id-ID', {
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
