<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Siswa;
use App\Models\Tagihan;
use App\Models\Tabungan;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        $saldo_tabungan = $jml_tagihan = $total_tagihan = $jml_transaksi = $jml_siswa = $jml_pengguna = 0;

        if ($user->isSiswa()) {
            $siswa = Siswa::where('id_user', $user->id_user)->first();

            // saldo tabungan
            $debit = Tabungan::where('id_siswa', $siswa->id_siswa)->where('tipe', 'debit')->sum('nominal');
            $kredit = Tabungan::where('id_siswa', $siswa->id_siswa)->where('tipe', 'kredit')->sum('nominal');
            $saldo_tabungan = number_format((intval($debit) - intval($kredit)), 0, '.', '.');

            // tagihan
            $jml_tagihan = Tagihan::where('id_siswa', $siswa->id_siswa)->where('id_status_tagihan', 1)->whereDate('tgl_tagihan', '<=', Carbon::today())->count();
            $tagihan = Tagihan::select('jenis_tagihan.jml_tagihan')
                ->leftJoin('jenis_tagihan', 'jenis_tagihan.id_jenis_tagihan', 'tagihan.id_jenis_tagihan')
                ->where('tagihan.id_siswa', $siswa->id_siswa)
                ->where('tagihan.id_status_tagihan', 1)
                ->whereDate('tagihan.tgl_tagihan', '<=', Carbon::today())
                ->sum('jenis_tagihan.jml_tagihan');
            $total_tagihan = number_format($tagihan, 0, '.', '.');

            $jml_transaksi = Transaksi::leftJoin('tagihan', 'tagihan.id_tagihan', 'transaksi.id_tagihan')
                ->where('tagihan.id_siswa', $siswa->id_siswa)
                ->count();
        } elseif ($user->isAdmin() || $user->isPetugas()) {
            // saldo tabungan
            $debit = Tabungan::where('tipe', 'debit')->sum('nominal');
            $kredit = Tabungan::where('tipe', 'kredit')->sum('nominal');
            $saldo_tabungan = number_format((intval($debit) - intval($kredit)), 0, '.', '.');

            // tagihan
            $jml_tagihan = Tagihan::where('id_status_tagihan', 1)->whereDate('tgl_tagihan', '<=', Carbon::today())->count();
            $tagihan = Tagihan::select('jenis_tagihan.jml_tagihan')
                ->leftJoin('jenis_tagihan', 'jenis_tagihan.id_jenis_tagihan', 'tagihan.id_jenis_tagihan')
                ->where('tagihan.id_status_tagihan', 1)
                ->whereDate('tagihan.tgl_tagihan', '<=', Carbon::today())
                ->sum('jenis_tagihan.jml_tagihan');
            $total_tagihan = number_format($tagihan, 0, '.', '.');

            $jml_siswa = Siswa::all()->count();
            $jml_pengguna = User::all()->count();
        }

        return view('home', compact('saldo_tabungan', 'jml_tagihan', 'total_tagihan', 'jml_transaksi', 'jml_siswa', 'jml_pengguna'));
    }
}
