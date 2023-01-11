@extends('adminlte::page')

@section('title', 'Edit Siswa')

@section('content_header')
    <h1>Edit Siswa</h1>
@stop

@section('content')
    <section class="content">
        <div class="card">
            <div class="card-body">
                @dump($siswa)
            </div>
        </div>
    </section>
@stop
