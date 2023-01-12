<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Tahun;
use App\Models\KelasSiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Support\Renderable;
use App\Http\Requests\StoreKelasSiswaRequest;
use App\Http\Requests\UpdateKelasSiswaRequest;

class KelasSiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return Renderable
     */
    public function index(Request $request)
    {
        $tahun = Tahun::all();
        $kelas = Kelas::all();

        if ($request->ajax()) {
            $data = KelasSiswa::select('kelas_siswa.*', 'siswa.nis', 'siswa.nama as nama_siswa', DB::raw('UPPER(siswa.jk) as jk'), 'kelas.nama as nama_kelas')
                ->leftJoin('siswa', 'siswa.id_siswa', 'kelas_siswa.id_siswa')
                ->leftJoin('kelas', 'kelas.id_kelas', 'kelas_siswa.id_kelas')
                ->where('kelas_siswa.thn_ajaran', $request->thn_ajaran)
                ->where('kelas_siswa.id_kelas', $request->id_kelas)
                ->orderBy('siswa.nama', 'asc')
                ->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '<a href="javascript:void(0)" id="delete" data-id="' . $row->id_kelas_siswa . '" class="btn btn-danger btn-sm">Delete</a>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('kelas-siswa.index', compact('kelas', 'tahun'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Renderable
     */
    public function create()
    {
        $tahun = Tahun::orderBy('thn_ajaran', 'desc')->get();
        $kelas = Kelas::orderBy('nama', 'asc')->get();
        $siswa = Siswa::orderBy('nama', 'asc')->get();

        return view('kelas-siswa.create', compact('tahun', 'kelas', 'siswa'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreKelasSiswaRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreKelasSiswaRequest $request)
    {
        DB::beginTransaction();

        try {
            foreach ($request->siswa as $siswa) {
                KelasSiswa::updateOrCreate([
                    'thn_ajaran' => $request->thn_ajaran,
                    'id_siswa' => $siswa
                ], [
                    'thn_ajaran' => $request->thn_ajaran,
                    'id_kelas' => $request->kelas,
                    'id_siswa' => $siswa
                ]);
            }
            DB::commit();

            return redirect()->route('kelas-siswa.index')->with('success', 'Berhasil menyimpan kelas siswa!');
        } catch (\Throwable $th) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Gagal menyimpan kelas siswa. Silahkan ulangi kembali! ' . $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\KelasSiswa  $kelasSiswa
     * @return \Illuminate\Http\Response
     */
    public function show(KelasSiswa $kelasSiswa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\KelasSiswa  $kelasSiswa
     * @return \Illuminate\Http\Response
     */
    public function edit(KelasSiswa $kelasSiswa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateKelasSiswaRequest  $request
     * @param  \App\Models\KelasSiswa  $kelasSiswa
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateKelasSiswaRequest $request, KelasSiswa $kelasSiswa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return void
     */
    public function destroy(Request $request)
    {
        $siswa = KelasSiswa::findOrFail($request->id);
        $siswa->delete();
    }
}
