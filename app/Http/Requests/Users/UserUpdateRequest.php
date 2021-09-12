<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->hasRole('rw');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'rt_id' => ['numeric', 'required', 'exists:rt,id'],
            'name' => ['string', 'required', 'max:64'],
            'username' =>  ['alpha_dash', 'required', 'max:25', 'unique:users,username,' . $this->user->id],
            'email' => ['email', 'required', 'max:64', 'unique:users,email,' . $this->user->id],
            'no_hp' =>  ['string', 'nullable', 'max:15', 'starts_with:+62,62,08'],
            'alamat' => ['string', 'nullable', 'max:255'],
            'avatar' => ['mimes:jpg,jpeg,png', 'nullable', 'max:1000'],
            'password' => ['string', 'nullable', 'min:3', 'max:12'],
            'role' => ['numeric', 'required']
        ];
    }


    public function attributes()
    {
        return [
            'rt_id' => 'RT',
            'name' => 'nama',
        ];
    }
}
