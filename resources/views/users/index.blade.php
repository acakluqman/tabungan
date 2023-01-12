@extends('adminlte::page')

@section('title', 'Data Pengguna')

@section('content_header')
    <h1>Data Pengguna</h1>
@stop

@section('content')
    <section class="content">
        <div class="card">
            @can('users.create')
                <div class="card-header">
                    <h3 class="card-title">
                        <a href="{{ route('users.create') }}" class="btn btn-primary">
                            <i class="fas fa-fw fa-plus"></i> Tambah Pengguna
                        </a>
                    </h3>
                </div>
            @endcan
            <div class="card-body table-responsive">
                <table class="table table-stripped table-hover" id="users">
                    <thead>
                        <tr>
                            <th style="width: 5%" class="text-center">No.</th>
                            <th>Username</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th></th>
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
            table = $('#users').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('users.index') }}",
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
                        data: 'username',
                        name: 'username',
                        render: function(data, type, row, meta) {
                            return '<a href="./users/' + row.id_user + '/show">' + row
                                .username + '</a>';
                        }
                    },
                    {
                        data: 'nama',
                        name: 'nama',
                    },
                    {
                        data: 'email',
                        name: 'email',
                    },
                    {
                        data: 'role',
                        name: 'role',
                        render: function(data, type, row, meta) {
                            if (row.role) {
                                if (row.role.id == 1) {
                                    return '<span class="badge bg-primary">' + row.role.name +
                                        '</span>';
                                } else if (row.role.id == 2) {
                                    return '<span class="badge bg-success">' + row.role.name +
                                        '</span>';
                                } else {
                                    return '<span class="badge bg-warning">' + row.role.name +
                                        '</span>';
                                }
                            }
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

            $('#users').on('click', '#delete', function(e) {
                swal.fire({
                    title: "Lanjutkan hapus pengguna?",
                    text: "Data pengguna akan dihapus dari sistem. Lanjutkan?",
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
                                    text: 'Berhasil hapus data user dari sistem!',
                                    type: 'success'
                                })

                                $('#users').DataTable().draw();
                            }
                        });
                    }
                });
            });
        })
    </script>
@stop
