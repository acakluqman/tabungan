@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <div class="row">
        {{-- role siswa --}}
        @if (Auth::user()->hasRole('siswa'))
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>Rp. {{ $saldo_tabungan }}</h3>
                        <p>Saldo Tabungan</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-fw fa-wallet"></i>
                    </div>
                    <a href="{{ route('tabungan.siswa') }}" class="small-box-footer">Tabungan Siswa <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">

                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>Rp. {{ $total_tagihan }}</h3>
                        <p>Total Tagihan ({{ $jml_tagihan }})</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-fw fa-money-bill"></i>
                    </div>
                    <a href="{{ route('tagihan.siswa') }}" class="small-box-footer">
                        Tagihan Siswa <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $jml_transaksi }}</h3>
                        <p>Riwayat Transaksi</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-fw fa-cash-register"></i>
                    </div>
                    <a href="{{ route('transaksi.siswa') }}" class="small-box-footer">
                        Riwayat Transaksi <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        @endif
    </div>
@stop
