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
            'rt_id' => ['numeric', 'required', 'exists:rt,id'],
            'nomor' => ['numeric', 'required', 'digits:16', 'starts_with:3509', 'unique:keluarga,nomor'],
            'alamat' => ['string', 'required', 'max:200'],
            'foto_kk' => ['mimes:jpg,jpeg,png', 'nullable', 'max:1000']
        ];
    }

    public function attributes()
    {
        return [
            'rt_id' => 'RT',
            'nomor' => 'nomor kartu keluarga',
            'foto_kk' => 'foto kartu keluarga'
        ];
    }
}
