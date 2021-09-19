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
            'rt_id' => ['required', 'numeric',  'exists:rt,id'],
            'name' => ['required', 'string', 'max:64'],
            'username' =>  ['required', 'alpha_dash',  'max:32', 'unique:users,username,' . $this->user->id],
            'email' => ['required', 'email',  'max:64', 'unique:users,email,' . $this->user->id],
            'no_hp' =>  ['nullable', 'string',  'max:15',  'starts_with:+62,62,08'],
            'alamat' => ['nullable', 'string',  'max:255'],
            'avatar' => ['mimes:jpg,jpeg,png',  'max:1024'],
            'password' => ['nullable', 'string', 'min:3', 'max:12'],
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
