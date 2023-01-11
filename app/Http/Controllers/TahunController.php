<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTahunRequest;
use DataTables;
use Carbon\Carbon;
use App\Models\Tahun;
use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;

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
        if ($request->is_aktif) {
            Tahun::where('is_aktif', 1)->first()->update(['is_aktif' => 0]);
        }

        Tahun::create($request->validated());

        return redirect()
            ->route('tahun.index')
            ->with('success', 'Berhasi simpan tahun ajaran!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tahun  $tahun
     * @return \Illuminate\Http\Response
     */
    public function show(Tahun $tahun)
    {
        //
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
     * @param  \App\Models\Tahun  $tahun
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tahun $tahun)
    {
        //
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
