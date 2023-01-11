@extends('adminlte::page')

@section('title', 'Tahun Ajaran')

@section('content_header')
    <h1>Tahun Ajaran</h1>
@stop

@section('content')
    <section class="content">
        <div class="card">
            @can('kelas.create')
                <div class="card-header">
                    <h3 class="card-title">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#modal-tambah">
                            <i class="fas fa-fw fa-plus"></i> Tambah
                        </button>
                    </h3>
                </div>
            @endcan
            <div class="card-body">
                <table class="table table-striped table-hover" id="tahun">
                    <thead>
                        <tr>
                            <th style="width: 5%">No.</th>
                            <th>Tahun Ajaran</th>
                            <th>Tanggal Efektif</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </section>

    @can('tahun.create')
        <div class="modal fade" id="modal-tambah">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Tahun Ajaran Baru</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('tahun.store') }}" id="form" method="post">
                        @method('post')
                        @csrf
                        <div class="modal-body">
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="thn_ajaran" class="control-label">Tahun Ajaran</label>
                                    <input type="number" class="form-control" name="thn_ajaran" id="thn_ajaran"
                                        min="{{ date('Y') - 5 }}" max="{{ date('Y') + 1 }}" step="1"
                                        placeholder="Tahun Ajaran" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="thn_ajaran2" class="control-label">Tahun Ajaran</label>
                                    <input type="text" class="form-control" name="thn_ajaran2" id="thn_ajaran2"
                                        placeholder="Tahun Ajaran" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="tgl_mulai" class="control-label">Tanggal Mulai</label>
                                <input type="date" class="form-control" name="tgl_mulai" id="tgl_mulai" value=""
                                    placeholder="Tanggal Mulai" required>
                            </div>
                            <div class="form-group">
                                <label for="tgl_selesai" class="control-label">Tanggal Selesai</label>
                                <input type="date" class="form-control" name="tgl_selesai" id="tgl_selesai" value=""
                                    placeholder="Tanggal Selesai" required>
                            </div>
                            <div class="form-group">
                                <label for="status" class="control-label">Status</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="is_aktif" id="status1" value="1"
                                        checked="">
                                    <label class="form-check-label">Aktif</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="is_aktif" id="status1"
                                        value="0">
                                    <label class="form-check-label">Tidak Aktif</label>
                                </div>
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

    @can('tahun.delete')
    @endcan
@stop

@section('js')
    <script>
        let table;

        $(function() {
            table = $('#tahun').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('tahun.index') }}",
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
                        data: 'thn_ajaran',
                        name: 'thn_ajaran',
                        render: function(data, type, row, meta) {
                            return row.thn_ajaran + '/' + (parseInt(row.thn_ajaran) + 1);
                        }
                    },
                    {
                        data: 'tgl_efektif',
                        name: 'tgl_efektif'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        className: 'text-center',
                        render: function(data, type, row, meta) {
                            if (row.is_aktif == 1) {
                                return '<span class="badge bg-success">Aktif</span>';
                            } else {
                                return '<span class="badge bg-danger">Tidak Aktif</span>';
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

            $('#form #thn_ajaran').on('blur', function() {
                var tahun = parseInt($(this).val());

                if (Number.isInteger(tahun)) {
                    $('#form #thn_ajaran2').val(parseInt(tahun) + 1);
                }
            })

            $('#tahun').on('click', '#delete', function(e) {
                console.log($(this).data('id'));

                swal.fire({
                    title: "Lanjutkan hapus tahun ajaran?",
                    text: "Data tahun ajaran akan dihapus dari sistem. Lanjutkan?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#DD6B55',
                    confirmButtonText: 'Ya, lanjutkan',
                    cancelButtonText: 'Batalkan',
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: "{{ route('tahun.destroy') }}",
                            method: 'post',
                            data: {
                                id: $(this).data('id'),
                                _token: "{{ csrf_token() }}",
                                _method: 'delete',
                            },
                            success: function(data) {
                                swal.fire({
                                    title: 'Berhasil',
                                    text: 'Berhasil hapus data tahun ajaran!',
                                    type: 'success'
                                });

                                $('#tahun').DataTable().ajax.reload();
                            }
                        });
                    }
                });
            });
        })
    </script>
@stop
