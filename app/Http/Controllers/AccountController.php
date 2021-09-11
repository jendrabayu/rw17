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
            'name' => ['string', 'required', 'max:50'],
            'username' =>  ['alpha_dash', 'required', 'max:25', 'unique:users,username,' . $user->id],
            'email' => ['string', 'required', 'max:25', 'unique:users,email,' . $user->id],
            'no_hp' =>  ['string', 'nullable', 'max:15', 'starts_with:+62,62,08'],
            'alamat' => ['string', 'nullable', 'max:150'],
            'avatar' => ['mimes:jpg,jpeg,png', 'nullable', 'max:1000'],
        ]);

        if ($request->hasFile('avatar')) {
            $validated['avatar'] = $request->file('avatar')->store('public/avatars');
            Storage::disk('public')->delete($user->avatar);
        }

        $user->update($validated);
        return back()->with('success', 'Profil Anda berhasil diupdate');
    }

    public function updatePassword(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['string', 'required', 'min:3', 'max:12', 'confirmed'],
        ]);

        $user->update(['password' => Hash::make($request->get('password'))]);

        return back()->with('success', 'Password Anda berhasil diubah');
    }
}
