<?php

namespace App\Http\Controllers;

use App\DataTables\UsersDataTable;
use App\Events\LogUserActivity;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\UserStoreRequest;
use App\Http\Requests\Users\UserUpdateRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UsersDataTable $usersDataTable)
    {
        return $usersDataTable->render('users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $rw = auth()->user()->rt->rw;
        $roles = Role::all()->pluck('name', 'id');
        $rt = $rw->rt->pluck('nomor', 'id');

        return view('users.create', compact('rw', 'roles', 'rt'));
    }

    /** 
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {
        $validated = $request->validated();
        $validated['password'] =  Hash::make($request->password);

        if ($request->hasFile('avatar')) {
            $validated['avatar'] = $request->file('avatar')->store('public/avatars');
        }

        $user = User::create($validated);
        $user->assignRole($request->role);
        event(new LogUserActivity("Tambah Pengguna $user->name [$user->role]", __CLASS__));

        return redirect()->route('users.index')->withSuccess('Berhasil menambahkan pengguna');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $rw = auth()->user()->rt->rw;
        $roles = Role::all()->pluck('name', 'id');
        $rt = $rw->rt->pluck('nomor', 'id');

        return view('users.edit', compact('user', 'rw', 'roles', 'rt'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $validated = $request->validated();
        $validated['password'] = $request->filled('password') ? Hash::make($request->password) : $user->password;

        if ($request->hasFile('avatar')) {
            $validated['avatar'] = $request->file('avatar')->store('public/avatars');
            Storage::disk('public')->delete($user->avatar);
        }

        $user->update($validated);
        $user->syncRoles($request->role);
        event(new LogUserActivity("Update Pengguna $user->name [$user->role]", __CLASS__));

        return back()->withSuccess('Pengguna berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        event(new LogUserActivity("Hapus Pengguna $user->name [$user->role]", __CLASS__));
        $user->delete();
        return response()->json(['status' => true], 204);
    }
}
