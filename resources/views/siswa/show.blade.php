@extends('adminlte::page')

@section('title', 'Detail Siswa')

@section('content_header')
    <h1>Detail Siswa</h1>
@stop

@section('content')
    <section class="content">
        <div class="card">
            <div class="card-body table-responsive">
                @dump($siswa)
            </div>
        </div>
    </section>
@stop
