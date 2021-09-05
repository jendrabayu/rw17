<?php

namespace App\Http\Requests\PendudukDomisili;

use Illuminate\Foundation\Http\FormRequest;

class StorePendudukDomisiliRequest extends FormRequest
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
            'agama_id' => ['numeric', 'required', 'exists:agama,id'],
            'darah_id' => ['numeric', 'nullable', 'exists:darah,id'],
            'pekerjaan_id' => ['numeric', 'required', 'exists:pekerjaan,id'],
            'status_perkawinan_id' => ['numeric', 'required', 'exists:status_perkawinan,id'],
            'pendidikan_id' =>  ['numeric', 'nullable', 'exists:pendidikan,id'],
            'kewarganegaraan' => ['in:1,2,3', 'required'],
            'nik' => ['numeric', 'required', 'digits:16', 'unique:penduduk_domisili,nik'],
            'nama' => ['string', 'required', 'max:100'],
            'tempat_lahir' => ['string', 'required', 'max:100'],
            'tanggal_lahir' => ['date', 'required', 'before:' . date('Y-m-d')],
            'jenis_kelamin' => ['in:l,p', 'required'],
            'alamat' => ['string', 'required', 'max:200'],
            'alamat_asal' => ['string', 'nullable', 'max:200'],
            'foto_ktp' => ['mimes:jpg,jpeg,png', 'nullable', 'max:1000'],
            'no_hp'  => ['string', 'nullable', 'max:15', 'starts_with:+62,62,08'],
            'email' =>  ['email', 'nullable', 'max:50']
        ];
    }
}
