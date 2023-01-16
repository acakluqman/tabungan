<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\Siswa;
use App\Models\Transaksi;
use Nette\Utils\DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreTransaksiRequest;
use App\Models\JenisTagihan;
use Illuminate\Contracts\Support\Renderable;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Transaksi::latest()->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->make(true);
        }

        return view('transaksi.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        $siswa = Siswa::orderBy('nama', 'asc')->get();

        return view('transaksi.create', compact('siswa'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreTransaksiRequest  $request
     * @return RedirectResponse
     */
    public function store(StoreTransaksiRequest $request)
    {
        $tagihan = JenisTagihan::find($request->id_tagihan);

        Transaksi::creat([
            'id_tagihan' => $tagihan->id_tagihan,
            'total_tagihan' => $tagihan->jml_tagihan,
            'total_bayar' => $request->total_bayar,
            'tgl_transaksi' => new DateTime(),
            'id_petugas' => Auth::user()->id_user,
        ]);
        return redirect()->back()->with('success', 'Berhasil menyimpan transaksi!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaksi  $transaksi
     * @return Renderable
     */
    public function show(Transaksi $transaksi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaksi  $transaksi
     * @return Renderable
     */
    public function edit(Transaksi $transaksi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaksi $transaksi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaksi $transaksi)
    {
        //
    }
}
