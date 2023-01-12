<?php

namespace App\Http\Controllers;

use DataTables;
use Carbon\Carbon;
use App\Models\Tahun;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreTahunRequest;
use Illuminate\Contracts\Support\Renderable;

class TahunController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Renderable
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $tahun = Tahun::orderBy('thn_ajaran', 'desc')->get();

            return Datatables::of($tahun)
                ->addIndexColumn()
                ->addColumn('tgl_efektif', function ($row) {
                    return Carbon::parse($row->tgl_mulai)->isoFormat('D MMMM Y') . ' s.d. ' . Carbon::parse($row->tgl_selesai)->isoFormat('D MMMM Y');
                })
                ->addColumn('action', function ($row) {
                    return '<a href="javascript:void(0)" id="edit" data-id="' . $row->thn_ajaran . '" class="btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" id="delete" data-id="' . $row->thn_ajaran . '" class="btn btn-danger btn-sm">Delete</a>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('tahun.index');
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
     * @param  StoreTahunRequest  $request
     * @return RedirectResponse
     */
    public function store(Tahun $tahun, StoreTahunRequest $request)
    {
        DB::beginTransaction();
        try {
            if ($request->is_aktif) {
                Tahun::where('is_aktif', 1)->first()->update(['is_aktif' => 0]);
            }

            Tahun::create($request->validated());

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();

            return redirect()
                ->back()
                ->with('error', 'Gagal menyimpan tahun ajaran! Error: ' . $th->getMessage());
        }

        return redirect()
            ->route('tahun.index')
            ->with('success', 'Berhasi simpan tahun ajaran!');
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
        $tahun = [];
        if ($request->ajax()) {
            $tahun = Tahun::where('thn_ajaran', $request->id)->first();
        }

        return response()->json($tahun);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tahun  $tahun
     * @return \Illuminate\Http\Response
     */
    public function edit(Tahun $tahun)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return RedirectResponse
     */
    public function update(Request $request)
    {
        DB::beginTransaction();

        try {
            if ($request->is_aktif) {
                Tahun::where('is_aktif', 1)->first()->update(['is_aktif' => 0]);
            }

            Tahun::where('thn_ajaran', $request->thn_ajaran)
                ->update([
                    'tgl_mulai' => $request->tgl_mulai,
                    'tgl_selesai' => $request->tgl_selesai,
                    'is_aktif' => $request->is_aktif
                ]);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();

            return redirect()
                ->back()
                ->with('error', 'Gagal memperbarui data tahun ajaran! Error: ' . $th->getMessage());
        }

        return redirect()->back()->with('success', 'Berhasil memperbarui data tahun ajaran!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request $request
     * @return RedirectResponse
     */
    public function destroy(Request $request)
    {
        $tahun = Tahun::findOrFail($request->id);
        $tahun->delete();

        return redirect()->route('tahun.index')
            ->with('success', 'Berhasil menghapus data tahun ajaran!');
    }
}
