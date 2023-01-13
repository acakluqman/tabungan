<?php

namespace App\Http\Controllers;

use DataTables;
use Carbon\Carbon;
use App\Models\Tahun;
use App\Models\Tagihan;
use App\Models\JenisTagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TagihanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $tahun = Tahun::orderBy('thn_ajaran', 'desc')->get();
        $jenis = JenisTagihan::all();

        if ($request->ajax()) {
            $data = Tagihan::select('tagihan.*', DB::raw('jenis_tagihan.nama as nama_tagihan'), 'jenis_tagihan.jml_tagihan', 'siswa.nis', DB::raw('siswa.nama as nama_siswa'), DB::raw('kelas.nama as kelas'))
                ->leftJoin('jenis_tagihan', 'jenis_tagihan.id_jenis_tagihan', 'tagihan.id_jenis_tagihan')
                ->leftJoin('siswa', 'siswa.id_siswa', 'tagihan.id_siswa')
                ->leftJoin('kelas_siswa', 'kelas_siswa.id_siswa', 'siswa.id_siswa')
                ->leftJoin('kelas', 'kelas.id_kelas', 'kelas_siswa.id_kelas')
                ->where('kelas_siswa.thn_ajaran', $request->thn_ajaran)
                ->when($request->id_jenis_tagihan, function ($query) use ($request) {
                    $query->where('tagihan.id_jenis_tagihan', $request->id_jenis_tagihan);
                })
                ->when($request->status, function ($query) use ($request) {
                    $query->where('tagihan.id_status_tagihan', $request->status);
                })
                ->whereDate('tagihan.tgl_tagihan', '<=', Carbon::today())
                ->orderBy('tagihan.tgl_tagihan', 'desc')
                ->orderBy('kelas.nama', 'asc')
                ->orderBy('siswa.nama', 'asc')
                ->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('tgl_jatuh_tempo_parse', function ($row) {
                    return Carbon::parse($row->tgl_jatuh_tempo)->isoFormat('D MMMM Y');
                })
                ->addColumn('action', function ($row) {
                    return '<a href="javascript:void(0)" id="edit" data-id="' . $row->id_tagihan . '" class="btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" id="delete" data-id="' . $row->id_tagihan . '" class="btn btn-danger btn-sm">Delete</a>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('tagihan.index', compact('tahun', 'jenis'));
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
     * @param  \App\Models\Tagihan  $tagihan
     * @return \Illuminate\Http\Response
     */
    public function show(Tagihan $tagihan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tagihan  $tagihan
     * @return \Illuminate\Http\Response
     */
    public function edit(Tagihan $tagihan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tagihan  $tagihan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tagihan $tagihan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tagihan  $tagihan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tagihan $tagihan)
    {
        //
    }
}
