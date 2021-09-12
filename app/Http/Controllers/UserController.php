<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\UserStoreRequest;
use App\Http\Requests\Users\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
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
    public function index(Request $request)
    {
        $users = User::query();
        $users->when($request->has('role'), function ($q) use ($request) {
            return $q->whereHas('roles', function ($q) use ($request) {
                $q->where('name', $request->get('role'));
            });
        });
        $users = $users->latest()->get()->load('rt');

        return view('users.index', compact('users'));
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

    /** Route::resource('users', \App\Http\Controllers\Rw\UserController::class)->except('show');
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
        $validated['password'] = !is_null($request->password) ? Hash::make($request->password) : $user->password;

        if ($request->hasFile('avatar')) {
            $validated['avatar'] = $request->file('avatar')->store('public/avatars');
            Storage::disk('public')->delete($user->avatar);
        }

        $user->update($validated);
        $user->syncRoles($request->role);

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
        $user->delete();
        return back()->withSuccess('Pengguna berhasil dihapus');
    }
}
