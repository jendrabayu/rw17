<?php

namespace App\Http\Requests\Rumah;

use Illuminate\Foundation\Http\FormRequest;

class RumahStoreRequest extends FormRequest
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
            'rt_id' => ['required', 'numeric',  'exists:rt,id'],
            'alamat' => ['required', 'string',  'max:255'],
            'nomor' => ['required', 'string',  'max:20'],
            'tipe_bangunan' => ['nullable', 'string', 'max:20'],
            'penggunaan_bangunan' => ['nullable', 'string', 'max:255'],
            'kontruksi_bangunan' => ['nullable', 'string', 'max:255'],
            'keterangan' => ['nullable', 'string', 'max:255'],
            'keluarga_id' => ['nullable', 'array'],
            'keluarga_id.*' => ['numeric', 'exists:keluarga,id', 'unique:rumah_keluarga,keluarga_id'],
            'penduduk_domisili_id' => ['nullable', 'array'],
            'penduduk_domisili_id.*' => ['numeric', 'exists:penduduk_domisili,id'],
        ];
    }

    public function attributes()
    {
        return [
            'rt_id' => 'RT',
            'nomor' => 'nomor rumah',
            'keluarga_id' => 'keluarga',
            'keluarga_id.*' => 'keluarga',
            'penduduk_domisili_id' => 'Penduduk Domisili'
        ];
    }
}
