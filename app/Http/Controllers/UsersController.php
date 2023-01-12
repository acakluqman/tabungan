<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Contracts\Support\Renderable;

class UsersController extends Controller
{
    /**
     * Display all users
     *
     * @return Renderable
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::whereHas('roles')->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('role', function ($row) {
                    return ['id' => $row->roles[0]['id'], 'name' => Str::ucfirst($row->roles[0]['name'])];
                })
                ->addColumn('action', function ($row) {
                    return '<a href="' . route('users.edit', $row->id_user) . '" class="btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" id="delete" data-id="' . $row->id_user . '" class="btn btn-danger btn-sm">Delete</a>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('users.index');
    }

    /**
     * Show form for creating user
     *
     * @return Renderable
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created user
     *
     * @param User $user
     * @param StoreUserRequest $request
     *
     * @return RedirectResponse
     */
    public function store(StoreUserRequest $request)
    {
        DB::beginTransaction();

        try {
            $user = User::create([
                'username' => strtolower($request->username),
                'nama' => ucwords(strtolower($request->nama)),
                'email' => strtolower($request->email),
                'password' => Hash::make($request->password)
            ]);

            $role = Role::findById($request->id_role);
            $user->assignRole([$role->id]);

            DB::commit();

            return redirect()->route('users.index')
                ->with('success', 'User berhasil ditambahkan!');
        } catch (\Throwable $th) {
            DB::rollBack();

            return redirect()->route('users.index')
                ->with('error', 'Gagal menambahkan pengguna. Silahkan ulangi kembali! ' . $th->getMessage());
        }
    }

    /**
     * Show user data
     *
     * @param User $user
     *
     * @return Renderable
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * Edit user data
     *
     * @param User $user
     *
     * @return Renderable
     */
    public function edit(User $user)
    {
        return view('users.edit', [
            'user' => $user,
            'userRole' => $user->roles->pluck('id')->toArray(),
            'roles' => Role::whereNotIn('id', [3])->oldest()->get()
        ]);
    }

    /**
     * Update user data
     *
     * @param User $user
     * @param UpdateUserRequest $request
     *
     * @return RedirectResponse
     */
    public function update($id, UpdateUserRequest $request)
    {
        $user = User::findOrFail($id);
        $user->update([
            'username' => strtolower($request->username),
            'nama' => ucwords(strtolower($request->nama)),
            'email' => strtolower($request->email),
        ]);

        $user->syncRoles($request->get('id_role'));

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Delete user data
     *
     * @param Request $request
     *
     * @return void
     */
    public function destroy(Request $request)
    {
        $user = User::findOrFail($request->id);
        $user->delete();
    }
}
