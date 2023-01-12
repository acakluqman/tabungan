<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\Siswa;
use App\Models\Tahun;
use App\Models\Tabungan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Support\Renderable;

class TabunganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Renderable
     */
    public function index(Request $request)
    {
        $tahun = Tahun::where('is_aktif', 1)
            ->first();

        if ($request->ajax()) {
            $data = Siswa::select('siswa.id_siswa', 'siswa.nama', 'siswa.nis', 'siswa.jk', DB::raw('kelas.nama as nama_kelas'))
                ->join('kelas_siswa', 'kelas_siswa.id_siswa', 'siswa.id_siswa')
                ->leftJoin('kelas', 'kelas.id_kelas', 'kelas_siswa.id_kelas')
                ->where('kelas_siswa.thn_ajaran', $tahun->thn_ajaran)
                ->orderBy('siswa.nama', 'asc')
                ->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('debit', function ($row) {
                    return Tabungan::where('id_siswa', $row->id_siswa)->where('tipe', 'debit')->sum('nominal');
                })
                ->addColumn('kredit', function ($row) {
                    return Tabungan::where('id_siswa', $row->id_siswa)->where('tipe', 'kredit')->sum('nominal');
                })
                ->addColumn('action', function ($row) {
                    return '<a href="javascript:void(0)" id="edit" data-id="' . $row->id_tabungan . '" class="btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" id="delete" data-id="' . $row->id_tabungan . '" class="btn btn-danger btn-sm">Delete</a>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('tabungan.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return Renderable
     */
    public function show($id, Request $request)
    {
        $siswa = Siswa::find($id);

        if ($request->ajax()) {
            $data = Tabungan::select('tabungan.*', DB::raw('users.nama as petugas'))
                ->where('tabungan.id_siswa', $id)
                ->leftJoin('users', 'users.id_user', 'tabungan.id_petugas')
                ->orderBy('tabungan.id_tabungan', 'desc')
                ->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('tgl_tx', function ($row) {
                    return Carbon::parse($row->tgl_transaksi)->isoFormat('D MMM Y HH:mm:ss');
                })
                ->make(true);
        }
        return view('tabungan.show', compact('siswa'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tabungan  $tabungan
     * @return \Illuminate\Http\Response
     */
    public function edit(Tabungan $tabungan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tabungan  $tabungan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tabungan $tabungan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tabungan  $tabungan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tabungan $tabungan)
    {
        //
    }
}
