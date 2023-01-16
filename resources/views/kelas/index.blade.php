@extends('adminlte::page')

@section('title', 'Data Kelas')

@section('content_header')
    <h1>
        Data Kelas</h1>
@stop

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    @can('kelas.create')
                        <div class="card-header">
                            <h3 class="card-title">
                                <button class="btn btn-primary" data-toggle="modal" data-target="#modal-tambah">
                                    <i class="fas fa-fw fa-plus"></i> Tambah Kelas
                                </button>
                            </h3>
                        </div>
                    @endcan
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="thn_ajaran" class="control-label">Tahun Ajaran</label>
                                <select name="thn_ajaran" id="thn_ajaran" class="form-control">
                                    @foreach ($tahun as $th)
                                        <option value="{{ $th->thn_ajaran }}">
                                            {{ 'TA ' . $th->thn_ajaran . '/' . ($th->thn_ajaran + 1) }}
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
                        <table class="table table-striped table-hover" id="kelas">
                            <thead>
                                <tr>
                                    <th style="width: 5%" class="text-center">No.</th>
                                    <th>Tahun Ajaran</th>
                                    <th>Nama Kelas</th>
                                    <th>Jumlah Siswa</th>
                                    @can(['kelas.update', 'kelas.destroy'])
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

    @can('kelas.create')
        <div class="modal fade" id="modal-tambah">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Kelas</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('kelas.store') }}" id="form" method="post">
                        @method('post')
                        @csrf
                        <div class="modal-body">
                            <div class="form-group row">
                                <label for="thn_ajaran" class="control-label">Tahun Ajaran</label>
                                <select class="form-control" style="width: 100%;" name="thn" id="thn">
                                    @foreach ($tahun as $th)
                                        <option value="{{ $th->thn_ajaran }}">
                                            {{ 'TA ' . $th->thn_ajaran . '/' . ($th->thn_ajaran + 1) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group row">
                                <label for="nama" class="control-label">Nama Kelas</label>
                                <input type="text" class="form-control" name="nama" id="nama"
                                    placeholder="Nama Kelas" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endcan
    @can('tahun.update')
        <div class="modal fade" id="modal-edit">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Perbarui Ajaran Baru</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('kelas.update') }}" id="form" method="post">
                        @method('patch')
                        @csrf
                        <div class="modal-body">
                            <div id="loader">
                                <div class="d-flex justify-content-center">
                                    <span class="fa-stack fa-md">
                                        <i class="fas fa-spinner fa-spin fa-stack-2x fa-fw"></i>
                                    </span>
                                </div>
                            </div>
                            <div id="form-edit">
                                <div class="form-group">
                                    <label for="thn_ajaran" class="control-label">Tahun Ajaran</label>
                                    <input type="hidden" name="id" id="id" readonly>
                                    <select class="form-control" style="width: 100%;" name="thn" id="thn">
                                        @foreach ($tahun as $th)
                                            <option value="{{ $th->thn_ajaran }}">
                                                {{ $th->thn_ajaran . '/' . ($th->thn_ajaran + 1) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="nama" class="control-label">Nama Kelas</label>
                                    <input type="text" class="form-control" name="nama" id="nama" value=""
                                        placeholder="Nama Kelas" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success">Perbarui</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endcan
@stop

@section('js')
    <script>
        let table;
        var kelas_action = "{{ Gate::check('kelas.update') || Gate::check('kelas.destroy') ? 1 : 0 }}";

        $(function() {
            table = $('#kelas').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('kelas.index') }}",
                    data: function(d) {
                        d.thn_ajaran = $('#thn_ajaran').val();
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
                        searchable: false,
                        visible: parseInt(kelas_action)
                    },
                ]
            });

            $('#thn_ajaran').on('change', function() {
                $('#kelas').DataTable().ajax.reload();
            })
        })

        $('#thn_ajaran, #thn').select2({
            minimumResultsForSearch: Infinity
        });

        $('#kelas').on('click', '#edit', function(e) {
            e.preventDefault();
            var loader = document.getElementById('loader');;
            var form = document.getElementById('form-edit');

            $('#modal-edit').modal('show');

            loader.style.display = 'block';
            form.style.display = 'none';

            $.ajax({
                url: "{{ route('kelas.show') }}",
                method: 'post',
                data: {
                    id: $(this).data('id'),
                    _token: "{{ csrf_token() }}",
                    _method: 'post',
                },
                success: function(data, textStatus, xhr) {
                    if (data) {
                        loader.style.display = 'none';
                        form.style.display = 'block';

                        $('#form-edit #id').val(data.id_kelas);
                        $('#form-edit #thn_ajaran').val(data.thn_ajaran);
                        $('#form-edit #nama').val(data.nama);
                    }
                },
            });
        });

        $('#kelas').on('click', '#delete', function(e) {
            swal.fire({
                title: "Lanjutkan hapus kelas ini?",
                text: "Data kelas akan dihapus dari sistem. Lanjutkan?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Ya, lanjutkan',
                cancelButtonText: 'Batalkan',
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "{{ route('kelas.destroy') }}",
                        method: 'post',
                        data: {
                            id: $(this).data('id'),
                            _token: "{{ csrf_token() }}",
                            _method: 'delete',
                        },
                        success: function(data, textStatus, xhr) {
                            swal.fire({
                                title: 'Berhasil',
                                text: 'Berhasil hapus data kelas!',
                                type: 'success'
                            });

                            $('#kelas').DataTable().ajax.reload();
                        },
                        complete: function(xhr, textStatus) {
                            if (xhr.status != 200) {
                                var result = JSON.parse(xhr.responseText);
                                swal.fire({
                                    title: 'Oops...',
                                    text: 'Gagal menghapus data kelas! Error: ' +
                                        result.message,
                                    type: 'error'
                                });
                            }
                        }
                    });
                }
            });
        });
    </script>
@stop
