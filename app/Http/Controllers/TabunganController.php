<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\Tabungan;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

class TabunganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Renderable
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Tabungan::latest()->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '<a href="javascript:void(0)" id="edit" data-id="' . $row->id_tabungan . '" class="btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" id="delete" data-id="' . $row->id_tabungan . '" class="btn btn-danger btn-sm">Delete</a>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('tabungan.index');
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tabungan  $tabungan
     * @return \Illuminate\Http\Response
     */
    public function show(Tabungan $tabungan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tabungan  $tabungan
     * @return \Illuminate\Http\Response
     */
    public function edit(Tabungan $tabungan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tabungan  $tabungan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tabungan $tabungan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tabungan  $tabungan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tabungan $tabungan)
    {
        //
    }
}
