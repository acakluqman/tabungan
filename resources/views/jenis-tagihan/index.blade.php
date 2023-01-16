@extends('adminlte::page')

@section('title', 'Jenis Tagihan')

@section('content_header')
    <h1>Jenis Tagihan</h1>
@stop

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    @can('jenis-tagihan.create')
                        <div class="card-header">
                            <h3 class="card-title">
                                <a href="{{ route('jenis-tagihan.create') }}" class="btn btn-primary">
                                    <i class="fas fa-fw fa-plus"></i> Tambah Jenis Tagihan
                                </a>
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
                        <table class="table table-striped table-hover" id="jenistagihan">
                            <thead>
                                <tr>
                                    <th style="width: 5%" class="text-center">No.</th>
                                    <th>Tahun Ajaran</th>
                                    <th>Nama Tagihan</th>
                                    <th>Jumlah Tagihan</th>
                                    <th>Periode Tagihan</th>
                                    <th style="width: 10%"></th>
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

        $(function() {
            table = $('#jenistagihan').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('jenis-tagihan.index') }}",
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
                        name: 'nama',                    },
                    {
                        data: 'jml_tagihan',
                        name: 'jml_tagihan',
                        render: function(data, type, row, meta) {
                            return 'Rp. ' + row.tagihan;
                        }
                    },
                    {
                        data: 'periode',
                        name: 'periode',
                        render: function(data, type, row, meta) {
                            if (row.periode == 'bulanan') {
                                return 'Bulanan';
                            } else {
                                return 'Sekali Bayar';
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

            $('#thn_ajaran').select2({
                minimumResultsForSearch: Infinity
            })

            $('#thn_ajaran').on('change', function() {
                $('#jenistagihan').DataTable().ajax.reload();
            })

            $('#jenistagihan').on('click', '#delete', function(e) {
                console.log($(this).data('id'));

                swal.fire({
                    title: "Lanjutkan hapus jenis tagihan ini?",
                    text: "Data jenis tagihan akan dihapus dari sistem. Lanjutkan?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#DD6B55',
                    confirmButtonText: 'Ya, lanjutkan',
                    cancelButtonText: 'Batalkan',
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: "{{ route('jenis-tagihan.destroy') }}",
                            method: 'post',
                            data: {
                                id: $(this).data('id'),
                                _token: "{{ csrf_token() }}",
                                _method: 'delete',
                            },
                            success: function(data, textStatus, xhr) {
                                swal.fire({
                                    title: 'Berhasil',
                                    text: 'Berhasil hapus data jenis tagihan!',
                                    type: 'success'
                                });

                                $('#jenistagihan').DataTable().ajax.reload();
                            },
                            complete: function(xhr, textStatus) {
                                if (xhr.status != 200) {
                                    var result = JSON.parse(xhr.responseText);
                                    swal.fire({
                                        title: 'Oops...',
                                        text: 'Gagal menghapus data jenis tagihan! Error: ' +
                                            result.message,
                                        type: 'error'
                                    });
                                }
                            }
                        });
                    }
                });
            });
        })
    </script>
@stop
