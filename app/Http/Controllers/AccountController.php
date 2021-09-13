<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AccountController extends Controller
{
    public function profile()
    {
        return view('accounts.profile', ['user' => auth()->user()]);
    }

    public function password()
    {
        return view('accounts.password');
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $validated = $this->validate($request, [
            'name' => ['required', 'string',  'max:32'],
            'username' =>  ['required', 'alpha_dash',  'max:64', 'unique:users,username,' . $user->id],
            'email' => ['required', 'email',  'max:64', 'unique:users,email,' . $user->id],
            'no_hp' =>  ['nullable', 'string',  'max:15', 'starts_with:+62,62,08'],
            'alamat' => ['nullable', 'string',  'max:255'],
            'avatar' => ['nullable', 'mimes:jpg,jpeg,png',  'max:1024'],
        ], [], [
            'name' => 'nama'
        ]);

        if ($request->hasFile('avatar')) {
            $validated['avatar'] = $request->file('avatar')->store('public/avatars');
            Storage::disk('public')->delete($user->avatar);
        }

        $user->update($validated);
        return back()->withSuccess('Profil Anda berhasil diupdate');
    }

    public function updatePassword(Request $request)
    {
        $this->validate($request, [
            'current_password' => ['required', 'current_password'],
            'password' => ['string', 'required', 'min:3', 'max:12', 'confirmed'],
        ], [], [
            'current_password' => 'password sekarang',
            'password' => 'password baru'
        ]);

        auth()->user()->update(['password' => Hash::make($request->get('password'))]);

        return back()->withSuccess('Password Anda berhasil diubah');
    }
}
