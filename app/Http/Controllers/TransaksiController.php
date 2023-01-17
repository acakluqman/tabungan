<?php

namespace App\Http\Controllers;

use PDF;
use DateTime;
use Exception;
use DataTables;
use Carbon\Carbon;
use App\Models\Siswa;
use App\Models\Tagihan;
use App\Models\Tabungan;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
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
            $data = Transaksi::select('siswa.nis', DB::raw('siswa.nama as nama_siswa'), DB::raw('jenis_tagihan.nama as nama_tagihan'), 'transaksi.total_tagihan', 'transaksi.total_bayar', 'transaksi.tgl_transaksi', DB::raw('users.nama as nama_petugas'))
                ->leftJoin('tagihan', 'tagihan.id_tagihan', 'transaksi.id_tagihan')
                ->leftJoin('siswa', 'siswa.id_siswa', 'tagihan.id_siswa')
                ->leftJoin('jenis_tagihan', 'jenis_tagihan.id_jenis_tagihan', 'tagihan.id_jenis_tagihan')
                ->leftJoin('users', 'users.id_user', 'transaksi.id_petugas')
                ->orderBy('transaksi.id_transaksi', 'desc')
                ->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('tgl_transaksi_parse', function ($row) {
                    return Carbon::parse($row->tgl_transaksi)->isoFormat('D MMMM Y');
                })
                ->addColumn('total_tagihan_parse', function ($row) {
                    return 'Rp ' . number_format($row->total_tagihan, 0, '.', '.');
                })
                ->addColumn('total_bayar_parse', function ($row) {
                    return 'Rp ' . number_format($row->total_bayar, 0, '.', '.');
                })
                ->make(true);
        }

        return view('transaksi.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create(Request $request)
    {
        $siswa = Siswa::orderBy('nama', 'asc')->get();

        if ($request->ajax()) {
            if ($request->data == 'saldo_tabungan') {
                $debit = Tabungan::where('id_siswa', $request->id_siswa)->where('tipe', 'debit')->sum('nominal');
                $kredit = Tabungan::where('id_siswa', $request->id_siswa)->where('tipe', 'kredit')->sum('nominal');

                $saldo = (intval($debit) - intval($kredit));

                return response()->json(['saldo' => $saldo]);
            }
            if ($request->data == 'tagihan') {
                $arr_tagihan = [];
                $tagihan = Tagihan::select('tagihan.*', 'jenis_tagihan.nama', 'jenis_tagihan.jml_tagihan')
                    ->leftJoin('jenis_tagihan', 'jenis_tagihan.id_jenis_tagihan', 'tagihan.id_jenis_tagihan')
                    ->where('tagihan.id_siswa', $request->id_siswa)
                    ->whereDate('tagihan.tgl_tagihan', '<=', Carbon::today())
                    ->where('tagihan.id_status_tagihan', 1)
                    ->orderBy('tagihan.tgl_tagihan', 'desc')
                    ->get();

                $total_tagihan = 0;
                foreach ($tagihan as $row) {
                    $total_tagihan += $row->jml_tagihan;
                    $arr_tagihan[] = [
                        'id_tagihan' => $row->id_tagihan,
                        'id_jenis_tagihan' => $row->id_jenis_tagihan,
                        'id_siswa' => $row->id_siswa,
                        'tgl_tagihan' => Carbon::parse($row->tgl_tagihan)->isoFormat('D MMMM Y'),
                        'tgl_jatuh_tempo' => Carbon::parse($row->tgl_jatuh_tempo)->isoFormat('D MMMM Y'),
                        'id_status_tagihan' => $row->id_status_tagihan,
                        'nama' => $row->nama,
                        'jml_tagihan' => $row->jml_tagihan,
                    ];
                }

                return response()->json(['total_tagihan' => $total_tagihan, 'tagihan' => $arr_tagihan]);
            }
        }

        return view('transaksi.create', compact('siswa'));
    }

    /**
     *
     * Store a newly created resource in storage.
     *
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            foreach ($request->id_tagihan as $id_tagihan) {
                if ($request->ambil_tabungan) {
                    $debit = Tabungan::where('id_siswa', $request->id_siswa)->where('tipe', 'debit')->sum('nominal');
                    $kredit = Tabungan::where('id_siswa', $request->id_siswa)->where('tipe', 'kredit')->sum('nominal');
                    $saldo = (intval($debit) - intval($kredit));

                    $tagihan = Tagihan::select('tagihan.id_tagihan', 'jenis_tagihan.nama', 'jenis_tagihan.jml_tagihan')
                        ->leftJoin('jenis_tagihan', 'jenis_tagihan.id_jenis_tagihan', 'tagihan.id_jenis_tagihan')
                        ->where('tagihan.id_tagihan', $id_tagihan)
                        ->first();

                    if ($saldo >= $tagihan->jml_tagihan) {
                        Tabungan::create([
                            'tipe' => 'kredit',
                            'id_siswa' => $request->id_siswa,
                            'nominal' => $tagihan->jml_tagihan,
                            'keterangan' => 'Kredit untuk pembayaran tagihan siswa ' . $tagihan->nama,
                            'tgl_transaksi' => new \DateTime(),
                            'id_petugas' => Auth::user()->id_user
                        ]);

                        Transaksi::create([
                            'id_tagihan' => $tagihan->id_tagihan,
                            'total_tagihan' => $tagihan->jml_tagihan,
                            'total_bayar' => $tagihan->jml_tagihan,
                            'tgl_transaksi' => new \DateTime(),
                            'id_petugas' => Auth::user()->id_user
                        ]);
                    } else {
                        Tabungan::create([
                            'tipe' => 'kredit',
                            'id_siswa' => $request->id_siswa,
                            'nominal' => $saldo,
                            'keterangan' => 'Kredit untuk pembayaran tagihan siswa ' . $tagihan->nama,
                            'tgl_transaksi' => new \DateTime(),
                            'id_petugas' => Auth::user()->id_user
                        ]);

                        Transaksi::create([
                            'id_tagihan' => $tagihan->id_tagihan,
                            'total_tagihan' => $tagihan->jml_tagihan,
                            'total_bayar' => $tagihan->jml_tagihan,
                            'tgl_transaksi' => new \DateTime(),
                            'id_petugas' => Auth::user()->id_user
                        ]);
                    }
                }

                Tagihan::where('id_tagihan', $id_tagihan)
                    ->update(['id_status_tagihan' => 2, 'updated_at' => new \DateTime()]);
            }
            DB::commit();

            return redirect()->back()->with('success', 'Berhasil menyimpan transaksi');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menyimpan transaksi. Silahkan ulangi kembali! Error: ' . $e->getMessage());
        }
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

    public function transaksiSiswa(Request $request)
    {
        $user = Auth::user();
        $siswa = Siswa::where('id_user', $user->id_user)->first();

        if ($request->ajax()) {
            $data = Transaksi::select('transaksi.*', 'tagihan.*', DB::raw('jenis_tagihan.nama as nama_tagihan'), 'jenis_tagihan.jml_tagihan', DB::raw('users.nama as nama_petugas'))
                ->leftJoin('tagihan', 'tagihan.id_tagihan', 'transaksi.id_tagihan')
                ->leftJoin('jenis_tagihan', 'jenis_tagihan.id_jenis_tagihan', 'tagihan.id_jenis_tagihan')
                ->leftJoin('users', 'users.id_user', 'transaksi.id_petugas')
                ->where('tagihan.id_siswa', $siswa->id_siswa)
                ->orderBy('transaksi.created_at', 'desc')
                ->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('tgl_tx', function ($row) {
                    return Carbon::parse($row->tgl_transaksi)->isoFormat('D MMM Y HH:mm:ss');
                })
                ->make(true);
        }
        return view('transaksi.siswa');
    }

    public function download(Request $request)
    {
        $periode = Carbon::parse($request->tahun.'-'.$request->bulan)->isoFormat('MMMM Y');

        $transaksi = Transaksi::select('siswa.nis', DB::raw('siswa.nama as nama_siswa'), 'jenis_tagihan.nama as nama_tagihan', 'transaksi.*', DB::raw('users.nama as nama_petugas'))
            ->leftJoin('tagihan', 'tagihan.id_tagihan', 'transaksi.id_tagihan')
            ->leftJoin('jenis_tagihan', 'jenis_tagihan.id_jenis_tagihan', 'tagihan.id_jenis_tagihan')
            ->leftJoin('siswa', 'siswa.id_siswa', 'tagihan.id_siswa')
            ->leftJoin('users', 'users.id_user', 'transaksi.id_petugas')
            ->whereYear('transaksi.tgl_transaksi', '=', $request->tahun)
            ->whereMonth('transaksi.tgl_transaksi', '=', $request->bulan)
            ->orderBy('transaksi.id_transaksi', 'desc')
            ->get();


        $pdf = PDF::loadview('transaksi.download', ['transaksi' => $transaksi, 'periode' => $periode])->setPaper('a4', 'landscape');

        return $pdf->stream();
    }
}
