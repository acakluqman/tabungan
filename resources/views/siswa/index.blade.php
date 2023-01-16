@extends('adminlte::page')

@section('title', 'Data Siswa')

@section('content_header')
    <h1>Data Siswa</h1>
@stop

@section('content')
    <section class="content">
        <div class="card">
            @can('siswa.create')
                <div class="card-header">
                    <h3 class="card-title">
                        <a href="{{ route('siswa.create') }}" class="btn btn-primary">
                            <i class="fas fa-fw fa-plus"></i> Tambah Siswa
                        </a>
                    </h3>
                </div>
            @endcan
            <div class="card-body table-responsive">
                <table class="table table-striped table-hover" id="siswa">
                    <thead>
                        <tr>
                            <th style="width: 5%;" class="text-center">No.</th>
                            <th>NIS</th>
                            <th>Nama</th>
                            <th style="width: 5%;">LP</th>
                            <th>Alamat</th>
                            @can(['siswa.update', 'siswa.destroy'])
                                <th style="width: 10%;"></th>
                            @endcan
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
        var siswa_action = "{{ Gate::check('siswa.update') || Gate::check('siswa.destroy') ? 1 : 0 }}";

        $(function() {
            table = $('#siswa').DataTable({
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
                        data: 'jk',
                        name: 'jk',
                        className: 'text-center'
                    },
                    {
                        data: 'alamat',
                        name: 'alamat'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        visible: parseInt(siswa_action)
                    },
                ]
            });
        })

        $('#siswa').on('click', '#delete', function(e) {
            swal.fire({
                title: "Lanjutkan hapus siswa?",
                text: "Data siswa akan dihapus dari sistem. Lanjutkan?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Ya, lanjutkan',
                cancelButtonText: 'Batalkan',
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "{{ route('users.destroy') }}",
                        method: 'post',
                        data: {
                            id: $(this).data('id'),
                            _token: "{{ csrf_token() }}",
                            _method: 'delete',
                        },
                        success: function(data) {
                            console.log(data)
                            swal.fire({
                                title: 'Berhasil',
                                text: 'Berhasil hapus data siswa dari sistem!',
                                type: 'success'
                            })

                            $('#siswa').DataTable().draw();
                        }
                    });
                }
            });
        });
    </script>
@stop
