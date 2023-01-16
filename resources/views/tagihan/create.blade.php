@extends('adminlte::page')

@section('title', 'Buat Tagihan Siswa')

@section('content_header')
    <h1>Buat Tagihan Siswa</h1>
@stop

@section('content')
    <section class="content">
        <div class="card">
            <div class="card-body">
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('tagihan.store') }}" id="form" method="post">
                    @method('post')
                    @csrf
                    <div class="form-group row">
                        <label for="thn_ajaran" class="col-sm-2 col-form-label">Tahun Ajaran</label>
                        <div class="col-sm-2">
                            <select class="form-control" name="thn_ajaran" id="thn_ajaran">
                                @foreach ($tahun as $row)
                                    <option value="{{ $row->thn_ajaran }}">
                                        {{ $row->thn_ajaran . '/' . ($row->thn_ajaran + 1) }}
                                        {{ $row->is_aktif ? ' - Aktif' : '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="id_jenis_tagihan" class="col-sm-2 col-form-label">Jenis Tagihan</label>
                        <div class="col-sm-5">
                            <select class="form-control" name="id_jenis_tagihan" id="id_jenis_tagihan"
                                onchange="generatePeriode()" required></select>
                        </div>
                    </div>

                    <div id="periode"></div>

                    <div class="form-group row">
                        <label for="tagihan" class="col-sm-2 col-form-label">Ditagihkan Kepada</label>
                        <div class="col-sm-5">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="tagihan" id="tagihan1" value="1"
                                    checked>
                                <label class="form-check-label">Semua Siswa</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="tagihan" id="tagihan2" value="2">
                                <label class="form-check-label">Pilih Siswa</label>
                            </div>
                        </div>
                    </div>

                    <div id="result"></div>

                    <div class="form-group row">
                        <label for="submit" class="col-sm-2 col-form-label">&nbsp;</label>
                        <div class="col-sm-5">
                            <a href="{{ route('tagihan.index') }}" class="btn btn-danger">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@stop

@section('js')
    <script>
        var thn_ajaran = $('#thn_ajaran').val();
        var tagihan = $('input[name=tagihan]:checked', '#form').val();

        $(function() {
            $('#thn_ajaran').select2();
            $('#id_jenis_tagihan').select2();

            $('#form input').on('change', function() {
                var tagihan = $('input[name=tagihan]:checked', '#form').val();

                getTagihan(tagihan);
            });

            getTagihan(tagihan);
            getJenisTagihan(thn_ajaran)
        })

        $('#thn_ajaran').on('change', function() {
            getJenisTagihan($(this).val())
        })

        function generatePeriode() {
            var periode = $("#id_jenis_tagihan option:selected").data('periode');
            var html = "";

            if (periode == 'sekali_bayar') {
                $('#periode').empty();

                html += '<div class="form-group row">';
                html += '<label for="tgl_jatuh_tempo" class="col-sm-2 col-form-label">Tanggal Jatuh Tempo</label>';
                html += '<div class="col-sm-5">';
                html += '<input type="date" class="form-control" name="tgl_jatuh_tempo" id="tgl_jatuh_tempo" required>';
                html += '</div>';
                html += '</div>';

                $('#periode').html(html);
            } else {
                $('#periode').empty();
            }
        }

        function getTagihan(tagihan) {
            var html = "";
            if (tagihan == "1") {
                $('#result').empty();
            } else if (tagihan == "2") {
                $('#result').empty();

                html += '<div class="form-group row">';
                html += '<label for="id_siswa" class="col-sm-2 col-form-label">Pilih Siswa</label>';
                html += '<div class="col-sm-5">';
                html += '<select class="form-control" name="id_siswa[]" id="id_siswa" multiple="" required></select>';
                html += '</div>';
                html += '</div>';

                $('#result').html(html);
                $('#id_siswa').select2({
                    placeholder: "Pilih Siswa",
                    minimumInputLength: 3,
                    multiple: true,
                    ajax: {
                        url: "{{ route('tagihan.create') }}",
                        dataType: 'json',
                        quietMillis: 100,
                        method: 'get',
                        data: function(params) {
                            return {
                                q: $.trim(params.term),
                                thn_ajaran: thn_ajaran,
                                data: 'siswa',
                                _token: "{{ csrf_token() }}",
                                _method: 'get',
                            };
                        },
                        processResults: function(data) {
                            return {
                                results: data
                            };
                        },
                    }
                });
            }
        }

        function getJenisTagihan(thn_ajaran) {
            $.ajax({
                url: "{{ route('tagihan.create') }}",
                method: 'get',
                dataType: 'json',
                data: {
                    thn_ajaran: thn_ajaran,
                    data: 'jenis_tagihan',
                    _token: "{{ csrf_token() }}",
                    _method: 'get',
                },
                success: function(data) {
                    if (data) {
                        $('#id_jenis_tagihan').empty();
                        $.each(data, function(key, jenis) {
                            $('select[name="id_jenis_tagihan"]').append(
                                '<option value="' +
                                jenis.id_jenis_tagihan + '" data-periode="' + jenis.periode + '">' +
                                jenis.nama +
                                '</option>');
                        });
                    } else {
                        $('#id_jenis_tagihan').empty();
                    }
                }
            });
        }
    </script>
@stop
