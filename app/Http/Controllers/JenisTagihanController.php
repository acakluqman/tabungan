<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\Tahun;
use App\Models\JenisTagihan;
use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;

class JenisTagihanController extends Controller
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
            $data = JenisTagihan::where('thn_ajaran', $request->thn_ajaran)->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('tagihan', function ($row) {
                    return number_format($row->jml_tagihan);
                })
                ->addColumn('action', function ($row) {
                    return '<a href="' . route('jenis-tagihan.edit', $row->id_jenis_tagihan) . '" class="btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" id="delete" data-id="' . $row->id_jenis_tagihan . '" class="btn btn-danger btn-sm">Delete</a>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('jenis-tagihan.index', compact('tahun'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Renderable
     */
    public function create()
    {
        $tahun = Tahun::orderBy('thn_ajaran', 'desc')->get();

        return view('jenis-tagihan.create', compact('tahun'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        JenisTagihan::create([
            'thn_ajaran' => $request->thn_ajaran,
            'nama' => $request->nama,
            'jml_tagihan' => $request->jml_tagihan,
            'periode' => $request->periode,
            'tgl_jatuh_tempo' => $request->periode == 'bulanan' ? 15 : null,
        ]);

        return redirect()->route('jenis-tagihan.index')->with('success', 'Berhasil menambahkan jenis tagihan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Renderable
     */
    public function edit($id)
    {
        $tahun = Tahun::orderBy('thn_ajaran', 'desc')->get();
        $jenistagihan = JenisTagihan::find($id);

        return view('jenis-tagihan.edit', compact('tahun', 'jenistagihan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id, Request $request)
    {
        $jenis = JenisTagihan::findOrFail($id);

        $jenis->update([
            'thn_ajaran' => $request->thn_ajaran,
            'nama' => $request->nama,
            'jml_tagihan' => $request->jml_tagihan,
        ]);

        return redirect()->back()->with('success', 'Berhasil memperbarui jenis tagihan!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     *
     * @return void
     */
    public function destroy(Request $request)
    {
        $jenis = JenisTagihan::findOrFail($request->id);
        $jenis->delete();
    }
}
