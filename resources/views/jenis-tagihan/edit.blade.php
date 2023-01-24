@extends('adminlte::page')

@section('title', 'Perbarui Jenis Tagihan')

@section('content_header')
    <h1>Perbarui Jenis Tagihan</h1>
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

                <form action="{{ route('jenis-tagihan.update', ['id' => $jenistagihan->id_jenis_tagihan]) }}" method="post">
                    @method('patch')
                    @csrf
                    <input type="hidden" name="id" id="id" value="{{ $jenistagihan->id_jenis_tagihan }}" readonly>
                    <div class="form-group row">
                        <label for="thn_ajaran" class="col-sm-2 col-form-label">Tahun Ajaran</label>
                        <div class="col-sm-2">
                            <select class="form-control" name="thn_ajaran" id="thn_ajaran">
                                @foreach ($tahun as $th)
                                    <option value="{{ $th->thn_ajaran }}"
                                        {{ $jenistagihan->thn_ajaran == $th->thn_ajaran ? 'selected' : '' }}>
                                        {{ 'TA ' . $th->thn_ajaran . '/' . ($th->thn_ajaran + 1) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="nama" class="col-sm-2 col-form-label">Nama Tagihan</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="nama" id="nama"
                                value="{{ $jenistagihan->nama }}" placeholder="Nama Tagihan" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="jml_tagihan" class="col-sm-2 col-form-label">Jumlah Tagihan</label>
                        <div class="col-sm-5">
                            <input type="number" class="form-control" name="jml_tagihan" id="jml_tagihan"
                                placeholder="Jumlah Tagihan" value="{{ (float) $jenistagihan->jml_tagihan }}" required
                                inputmode="number">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="periode" class="col-sm-2 col-form-label">Periode Tagihan</label>
                        <div class="col-sm-5">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="periode" id="bulanan" value="bulanan"
                                    {{ $jenistagihan->periode == 'bulanan' ? 'checked' : '' }}>
                                <label class="form-check-label">Bulanan</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="periode" id="sekali_bayar"
                                    value="sekali_bayar" {{ $jenistagihan->periode == 'sekali_bayar' ? 'checked' : '' }}>
                                <label class="form-check-label">Sekali Bayar</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="submit" class="col-sm-2 col-form-label">&nbsp;</label>
                        <div class="col-sm-5">
                            <a href="{{ route('jenis-tagihan.index') }}" class="btn btn-danger">Kembali</a>
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
        $(function() {})

        $('#thn_ajaran').select2({
            minimumResultsForSearch: Infinity
        });
    </script>
@stop
