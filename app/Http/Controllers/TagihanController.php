<?php

namespace App\Http\Controllers;

use Throwable;
use DataTables;
use Carbon\Carbon;
use App\Models\Siswa;
use App\Models\Tahun;
use App\Models\Tagihan;
use Carbon\CarbonPeriod;
use App\Models\KelasSiswa;
use App\Models\JenisTagihan;
use Illuminate\Http\Request;
use InvalidArgumentException;
use Psy\Readline\Hoa\Exception;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Support\Renderable;

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
     */
    public function create(Request $request)
    {
        $tahun = Tahun::orderBy('thn_ajaran', 'desc')->get();

        if ($request->ajax()) {
            if ($request->data == 'jenis_tagihan') {
                $jenis = JenisTagihan::where('thn_ajaran', $request->thn_ajaran)
                    ->orderBy('nama', 'asc')
                    ->get();

                return response()->json($jenis);
            }
            if ($request->data == 'siswa') {
                $result = [];

                $siswa = KelasSiswa::select('siswa.id_siswa', 'siswa.nis', 'siswa.nama as nama_siswa', DB::raw('kelas.nama as nama_kelas'))
                    ->leftJoin('siswa', 'siswa.id_siswa', 'kelas_siswa.id_siswa')
                    ->leftJoin('kelas', 'kelas.id_kelas', 'kelas_siswa.id_kelas')
                    ->where('siswa.nama', 'like', '%' . $request->q . '%')
                    ->where('kelas_siswa.thn_ajaran', $request->thn_ajaran)
                    ->orderBy('kelas.nama', 'asc')
                    ->orderBy('siswa.nama', 'asc')
                    ->limit(25)
                    ->get();

                foreach ($siswa as $res) {
                    $result[] = ['id' => $res->id_siswa, 'text' => $res->nis . ' - ' . $res->nama_siswa . ' (Kelas ' . $res->nama_kelas . ')'];
                }

                return response()->json($result);
            }
            if ($request->data == 'periode') {
                $result = [];
                $tahun = Tahun::where('is_aktif', 1)->first()->toArray();
                $periode = CarbonPeriod::create($tahun['tgl_mulai'], '1 month', $tahun['tgl_selesai']);

                return response()->json($periode);
            }
        }

        return view('tagihan.create', compact('tahun'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $tahun = Tahun::where('thn_ajaran', $request->thn_ajaran)->first();
        $jenis = JenisTagihan::where('id_jenis_tagihan', $request->id_jenis_tagihan)->first();
        $periode = CarbonPeriod::create($tahun->tgl_mulai, '1 month', $tahun->tgl_selesai);

        if ($request->tagihan == 1) {
            $siswa = KelasSiswa::select('siswa.id_siswa')
                ->leftJoin('siswa', 'siswa.id_siswa', 'kelas_siswa.id_siswa')
                ->leftJoin('kelas', 'kelas.id_kelas', 'kelas_siswa.id_kelas')
                ->where('kelas_siswa.thn_ajaran', $request->thn_ajaran)
                ->orderBy('kelas.nama', 'asc')
                ->orderBy('siswa.nama', 'asc')
                ->get();

            if (!$siswa->count())
                return redirect()->back()->with('error', 'Tidak dapat membuat tagihan. Pastikan siswa telah mempunyai kelas di tahun ajaran tersebut!');

            DB::beginTransaction();

            try {
                foreach ($siswa as $sis) {
                    if ($jenis->periode == "bulanan") {
                        foreach ($periode as $per) {
                            Tagihan::create([
                                'id_jenis_tagihan' => $request->id_jenis_tagihan,
                                'id_siswa' => $sis->id_siswa,
                                'tgl_tagihan' => Carbon::parse($per->format('Y-m-d'))->firstOfMonth()->format('Y-m-d'),
                                'tgl_jatuh_tempo' => Carbon::parse($per->format('Y-m-' . trim($jenis->tgl_jatuh_tempo)))->format('Y-m-d'),
                                'id_status_tagihan' => 1,
                            ]);
                        }
                    } else {
                        Tagihan::create([
                            'id_jenis_tagihan' => $request->id_jenis_tagihan,
                            'id_siswa' => $sis->id_siswa,
                            'tgl_tagihan' => Carbon::now()->format('Y-m-d'),
                            'tgl_jatuh_tempo' => Carbon::parse($request->tgl_jatuh_tempo)->format('Y-m-d'),
                            'id_status_tagihan' => 1
                        ]);
                    }
                }

                DB::commit();

                return redirect()->back()->with('success', 'Berhasil membuat tagihan!');
            } catch (Exception $e) {
                DB::rollBack();

                return redirect()->back()->with('error', 'Gagal membuat tagihan. Silahkan ulangi kembali! Error: ' . $e->getMessage());
            }
        } elseif ($request->tagihan == 2) {
            DB::beginTransaction();
            try {
                foreach ($request->id_siswa as $siswa) {
                    if ($jenis->periode == "bulanan") {
                        foreach ($periode as $per) {
                            Tagihan::create([
                                'id_jenis_tagihan' => $request->id_jenis_tagihan,
                                'id_siswa' => $siswa,
                                'tgl_tagihan' => Carbon::parse($per->format('Y-m-d'))->firstOfMonth()->format('Y-m-d'),
                                'tgl_jatuh_tempo' => Carbon::parse($per->format('Y-m-' . trim($jenis->tgl_jatuh_tempo)))->format('Y-m-d'),
                                'id_status_tagihan' => 1
                            ]);
                        }
                    } else {
                        Tagihan::create([
                            'id_jenis_tagihan' => $request->id_jenis_tagihan,
                            'id_siswa' => $siswa,
                            'tgl_tagihan' => Carbon::now()->format('Y-m-d'),
                            'tgl_jatuh_tempo' => Carbon::parse($request->tgl_jatuh_tempo)->format('Y-m-d'),
                            'id_status_tagihan' => 1
                        ]);
                    }
                }

                DB::commit();

                return redirect()->back()->with('success', 'Berhasil membuat tagihan!');
            } catch (Exception $e) {
                DB::rollBack();

                return redirect()->back()->with('error', 'Gagal membuat tagihan. Silahkan ulangi kembali! Error: ' . $e->getMessage());
            }
        }
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

    public function tagihanSiswa(Request $request)
    {
        $user = Auth::user();
        $siswa = Siswa::where('id_user', $user->id_user)->first();
        $tahun = Tahun::where('is_aktif', 1)->first();
        $kelas = KelasSiswa::select('kelas.nama')
            ->leftJoin('kelas', 'kelas.id_kelas', 'kelas_siswa.id_kelas')
            ->where('kelas_siswa.id_siswa', $siswa->id_siswa)
            ->where('kelas_siswa.thn_ajaran', $tahun->thn_ajaran)
            ->first();

        if ($request->ajax()) {
            $data = Tagihan::select('tagihan.*', 'jenis_tagihan.nama', 'jenis_tagihan.jml_tagihan')
                ->leftJoin('jenis_tagihan', 'jenis_tagihan.id_jenis_tagihan', 'tagihan.id_jenis_tagihan')
                ->where('tagihan.id_siswa', $siswa->id_siswa)
                ->whereDate('tagihan.tgl_tagihan', '<=', Carbon::today())
                ->orderBy('tagihan.tgl_tagihan', 'desc')
                ->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('tgl_jatuh_tempo_parse', function ($row) {
                    return Carbon::parse($row->tgl_jatuh_tempo)->isoFormat('D MMMM Y');
                })
                ->make(true);
        }

        return view('tagihan.siswa', compact('user', 'siswa', 'tahun', 'kelas'));
    }
}
