<?php

namespace App\Http\Requests\PendudukMeninggal;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePendudukMeninggalRequest extends FormRequest
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
            'agama_id' => ['numeric', 'required', 'exists:agama,id'],
            'darah_id' => ['numeric', 'nullable', 'exists:darah,id'],
            'pekerjaan_id' => ['numeric', 'required', 'exists:pekerjaan,id'],
            'status_perkawinan_id' => ['numeric', 'required', 'exists:status_perkawinan,id'],
            'kewarganegaraan' => ['required', 'in:1,2,3'],
            'pendidikan_id' =>  ['numeric', 'required', 'exists:pendidikan,id'],
            'nik' => ['numeric', 'required', 'digits:16', 'starts_with:3509', 'unique:penduduk_meninggal,nik,' . $this->penduduk_meninggal->id],
            'nama' => ['string', 'required', 'max:100'],
            'tempat_lahir' => ['string', 'required', 'max:100'],
            'tanggal_lahir' => ['date_format:Y-m-d', 'required'],
            'jenis_kelamin' => ['required', 'in:l,p'],
            'nama_ayah' =>  ['string', 'nullable', 'max:100'],
            'nama_ibu' =>  ['string', 'nullable', 'max:100'],
            'foto_ktp' => ['mimes:jpg,jpeg,png', 'nullable', 'max:1000'],
            'alamat' => ['string', 'required', 'max:255'],
            'tanggal_kematian' => ['date_format:Y-m-d', 'required'],
            'jam_kematian' => ['date_format:H:i', 'nullable'],
            'tempat_kematian' => ['string', 'max:100', 'nullable'],
            'sebab_kematian' => ['string', 'max:100', 'nullable'],
            'tempat_pemakaman' => ['string', 'max:100', 'nullable'],
        ];
    }
}
