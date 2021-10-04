<?php

namespace App\Http\Requests\Keluarga;

use Illuminate\Foundation\Http\FormRequest;

class KeluargaStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->hasRole(['rt', 'rw']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'rt_id' => ['required', 'numeric', 'exists:rt,id'],
            'nomor' => ['required', 'numeric',  'digits:16', 'starts_with:3509', 'unique:keluarga,nomor'],
            'alamat' => ['required', 'string',  'max:255'],
            'foto_kk' => ['nullable', 'mimes:jpg,jpeg,png',  'max:1024'],
            'rumah_id' => ['nullable', 'numeric', 'exists:rumah,id']
        ];
    }

    public function attributes()
    {
        return [
            'rt_id' => 'RT',
            'nomor' => 'nomor kartu keluarga',
            'foto_kk' => 'foto kartu keluarga',
            'rumah_id' => 'rumah'
        ];
    }
}
