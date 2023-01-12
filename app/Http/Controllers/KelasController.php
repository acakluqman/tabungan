<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\Kelas;
use App\Models\Tahun;
use App\Models\KelasSiswa;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\Support\Renderable;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Renderable
     */
    public function index(Request $request)
    {
        $tahun = Tahun::orderBy('thn_ajaran', 'desc')->get();

        if ($request->ajax()) {
            $data = Kelas::where('thn_ajaran', $request->thn_ajaran)->orderBy('nama', 'asc')->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('jml_siswa', function ($row) {
                    return KelasSiswa::where('id_kelas', $row->id_kelas)->count();
                })
                ->addColumn('action', function ($row) {
                    return '<a href="javascript:void(0)" data-id="' . $row->id_kelas . '" id="edit" class="btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" data-id="' . $row->id_kelas . '" id="delete" class="btn btn-danger btn-sm">Delete</a>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('kelas.index', compact('tahun'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
    }


    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        try {
            Kelas::create([
                'thn_ajaran' => $request->thn,
                'nama' => Str::upper($request->nama),
            ]);

            return redirect()->back()->with('success', 'Berhasil menambahkan data kelas!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Gagal menambahkan data kelas. Silahkan ulangi kembali! Error: ' . $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return JsonResponse
     */
    public function show(Request $request)
    {
        $kelas = [];
        if ($request->ajax()) {
            $kelas = Kelas::where('id_kelas', $request->id)
                ->first();
        }

        return response()->json($kelas);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function edit(Kelas $kelas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @param int $id
     * @param  \Illuminate\Http\Request  $request
     *
     * @return RedirectResponse
     */
    public function update(Request $request)
    {
        $kelas = Kelas::findOrFail($request->id);

        $kelas->update([
            'thn_ajaran' => $request->thn,
            'nama' => Str::upper($request->nama),
        ]);

        return redirect()->back()->with('success', 'Berhasil memperbarui data kelas.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return void
     */
    public function destroy(Request $request)
    {
        $kelas = Kelas::findOrFail($request->id);
        $kelas->delete();
    }
}
