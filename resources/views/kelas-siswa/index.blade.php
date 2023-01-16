@extends('adminlte::page')

@section('title', 'Data Kelas Siswa')

@section('content_header')
    <h1>Data Kelas Siswa</h1>
@stop

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    @can('kelas-siswa.create')
                        <div class="card-header">
                            <h3 class="card-title">
                                <a href="{{ route('kelas-siswa.create') }}" class="btn btn-primary">
                                    <i class="fas fa-fw fa-plus"></i> Atur Kelas Siswa
                                </a>
                            </h3>
                        </div>
                    @endcan

                    <div class="card-body table-responsive" id="filter">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="thn_ajaran" class="control-label">Tahun Ajaran</label>
                                <select name="thn_ajaran" id="thn_ajaran" class="form-control">
                                    @foreach ($tahun as $th)
                                        <option value="{{ $th->thn_ajaran }}">
                                            {{ $th->thn_ajaran . '/' . ($th->thn_ajaran + 1) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="kelas" class="control-label">Kelas</label>
                                <select name="kelas" id="kelas" class="form-control">
                                    @foreach ($kelas as $kl)
                                        <option value="{{ $kl->id_kelas }}">
                                            {{ 'Kelas ' . $kl->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-body table-responsive">
                        <table class="table table-striped table-hover" id="tkelas">
                            <thead>
                                <tr>
                                    <th style="width: 5%">No.</th>
                                    <th>NIS</th>
                                    <th>Nama Siswa</th>
                                    <th>LP</th>
                                    <th>Kelas</th>
                                    @can(['kelas-siswa.destroy'])
                                        <th style="width: 10%"></th>
                                    @endcan
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

@section('js')
    <script>
        let table;
        var kelas_action = "{{ Gate::check('kelas-siswa.destroy') ? 1 : 0 }}";

        $(function() {
            table = $('#tkelas').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('kelas-siswa.index') }}",
                    type: 'get',
                    data: function(d) {
                        d.thn_ajaran = $('#thn_ajaran').val();
                        d.id_kelas = $('#kelas').val();
                    }
                },
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
                    },
                    {
                        data: 'nama_siswa',
                        name: 'nama_siswa',
                    },
                    {
                        data: 'jk',
                        name: 'jk',
                        className: 'text-center',
                    },
                    {
                        data: 'nama_kelas',
                        name: 'nama_kelas',
                        render: function(data, type, row, meta) {
                            return 'Kelas ' + row.nama_kelas;
                        },
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        className: 'text-center',
                        visible: parseInt(kelas_action)
                    }
                ]
            });

            $('#tkelas').on('click', '#delete', function(e) {
                swal.fire({
                    title: "Lanjutkan hapus siswa?",
                    text: "Data siswa akan dihapus dari kelas tersebut. Lanjutkan?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#DD6B55',
                    confirmButtonText: 'Ya, lanjutkan',
                    cancelButtonText: 'Batalkan',
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: "{{ route('kelas-siswa.destroy') }}",
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
                                    text: 'Berhasil hapus siswa dari kelas!',
                                    type: 'success'
                                })

                                $('#tkelas').DataTable().draw();
                            }
                        });
                    }
                });
            });
        })

        $("#kelas, #thn_ajaran").on("change", function() {
            $('#tkelas').DataTable().ajax.reload();
        })
    </script>
@stop
