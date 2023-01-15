<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\User;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreSiswaRequest;
use App\Http\Requests\UpdateSiswaRequest;
use Illuminate\Contracts\Support\Renderable;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Renderable
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Siswa::latest()->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '<a href="' . route('siswa.edit', ['id' => $row->id_siswa]) . '" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" data-id="' . $row->id_user . '" id="delete" class="btn btn-danger btn-sm">Delete</a>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('siswa.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Renderable
     */
    public function create()
    {
        return view('siswa.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return RedirectResponse
     */
    public function store(StoreSiswaRequest $request)
    {
        DB::beginTransaction();
        try {
            $user = User::create([
                'username' => $request->nis,
                'nama' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $siswa = Siswa::create([
                'nis' => $request->nis,
                'nama' => $request->nama,
                'jk' => $request->jk,
                'alamat' => $request->alamat,
                'id_user' => $user->id_user,
            ]);

            $role = Role::findById(3);
            $user->assignRole([$role->id]);

            DB::commit();

            return redirect()->back()->with('success', 'Berhasil menyimpan data siswa');
        } catch (\Throwable $th) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Gagal menyimpan data siswa. Silahkan ulangi kembali! Error: ' . $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function show(Siswa $siswa)
    {
        return view('siswa.show', compact('siswa'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Siswa  $siswa
     * @return Renderable
     */
    public function edit($id)
    {
        $siswa = Siswa::findOrFail($id);
        $user = User::findOrFail($siswa->id_user);

        return view('siswa.edit', compact('siswa', 'user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     * @param UpdateSiswaRequest $request
     * @return RedirectResponse
     */
    public function update($id, UpdateSiswaRequest $request)
    {
        DB::beginTransaction();
        try {
            $siswa = Siswa::find($id);

            Siswa::where('id_siswa', $id)
                ->update([
                    'nis' => $request->nis,
                    'nama' => $request->nama,
                    'alamat' => $request->alamat,
                    'jk' => $request->jk
                ]);

            // $user = User::where('id_user', $siswa->id_user)
            //     ->update([
            //         'nama' => $request->nama,
            //         'email' => $request->email
            //     ]);

            DB::commit();

            return redirect()->back()->with('success', 'Berhasil menyimpan data siswa');
        } catch (\Throwable $th) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Gagal menyimpan data siswa. Silahkan ulangi kembali! Error: ' . $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request $request
     * @return void
     */
    public function destroy(Request $request)
    {
        $user = User::findOrFail($request->id);
        $user->delete();
    }
}
