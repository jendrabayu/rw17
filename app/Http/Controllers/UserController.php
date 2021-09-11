<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
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
    public function store(Request $request)
    {
        $validated = $this->validate($request, [
            'rt_id' => ['numeric', 'required', 'exists:rt,id'],
            'name' => ['string', 'required', 'max:50'],
            'username' =>  ['alpha_dash', 'required', 'max:25', 'unique:users,username'],
            'email' => ['string', 'required', 'max:25', 'unique:users,email'],
            'no_hp' =>  ['string', 'nullable', 'max:15', 'starts_with:+62,62,08'],
            'alamat' => ['string', 'nullable', 'max:150'],
            'avatar' => ['mimes:jpg,jpeg,png', 'nullable', 'max:1000'],
            'password' => ['string', 'required', 'min:3', 'max:12'],
            'role' => ['numeric', 'required']
        ]);

        if ($request->hasFile('avatar')) {
            $validated['avatar'] = $request->file('avatar')->store('public/avatars');
        }

        $validated['password'] =  Hash::make($request->password);

        unset($validated['role']);
        $user = User::create($validated);
        $role = Role::findById($request->role);
        $user->assignRole($role);

        return redirect()->route('users.index')->with('success', 'Berhasil menambahkan pengguna baru');
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
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $this->validate($request, [
            'rt_id' => ['numeric', 'required', 'exists:rt,id'],
            'name' => ['string', 'required', 'max:50'],
            'username' =>  ['alpha_dash', 'required', 'max:25', 'unique:users,username,' . $user->id],
            'email' => ['string', 'required', 'max:25', 'unique:users,email,' . $user->id],
            'no_hp' =>  ['string', 'nullable', 'max:15', 'starts_with:+62,62,08'],
            'alamat' => ['string', 'nullable', 'max:150'],
            'avatar' => ['mimes:jpg,jpeg,png', 'nullable', 'max:1000'],
            'password' => ['string', 'nullable', 'min:3', 'max:12'],
            'role' => ['numeric', 'required']
        ]);

        $validated['password'] = $request->password ? Hash::make($request->password) : $user->password;
        unset($validated['role']);

        if ($request->hasFile('avatar')) {
            $validated['avatar'] = $request->file('avatar')->store('public/avatars');
            Storage::disk('public')->delete($user->avatar);
        }

        $user->update($validated);
        $user->syncRoles($request->role);

        return back()->with('success', 'Data pengguna berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return back()->with('success', 'Pengguna berhasil dihapus');
    }
}
