<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
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
            $data = User::with("roles")->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('role', function ($row) {
                    return ['id' => $row->roles[0]['id'], 'name' => Str::ucfirst($row->roles[0]['name'])];
                })
                ->addColumn('action', function ($row) {
                    return '<a href="javascript:void(0)" id="edit" data-id="' . $row->id_user . '" class="btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" id="delete" data-id="' . $row->id_user . '" class="btn btn-danger btn-sm">Delete</a>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('users.index');
    }

    /**
     * Show form for creating user
     *
     * @return \Illuminate\Http\Response
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
     * @return \Illuminate\Http\Response
     */
    public function store(User $user, StoreUserRequest $request)
    {
        //For demo purposes only. When creating user or inviting a user
        // you should create a generated random password and email it to the user
        $user->create(array_merge($request->validated(), [
            'password' => 'test'
        ]));

        return redirect()->route('users.index')
            ->withSuccess(__('User created successfully.'));
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
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('users.edit', [
            'user' => $user,
            'userRole' => $user->roles->pluck('name')->toArray(),
            'roles' => Role::latest()->get()
        ]);
    }

    /**
     * Update user data
     *
     * @param User $user
     * @param UpdateUserRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update(User $user, UpdateUserRequest $request)
    {
        $user->update($request->validated());

        $user->syncRoles($request->get('role'));

        return redirect()->route('users.index')
            ->withSuccess(__('User updated successfully.'));
    }

    /**
     * Delete user data
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        $user = User::findOrFail($request->id);
        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'Berhasil menghapus data user!');
    }
}
