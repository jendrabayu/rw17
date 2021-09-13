<?php

namespace App\Http\Requests\Penduduk;

use Illuminate\Foundation\Http\FormRequest;

class PendudukUpdateRequest extends FormRequest
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
            'keluarga_id' => ['numeric', 'required', 'exists:keluarga,id'],
            'agama_id' => ['numeric', 'required', 'exists:agama,id'],
            'darah_id' => ['numeric', 'nullable', 'exists:darah,id'],
            'pekerjaan_id' => ['numeric', 'required', 'exists:pekerjaan,id'],
            'status_perkawinan_id' => ['numeric', 'required', 'exists:status_perkawinan,id'],
            'pendidikan_id' =>  ['numeric', 'required', 'exists:pendidikan,id'],
            'status_hubungan_dalam_keluarga_id' => ['numeric', 'required', 'exists:status_hubungan_dalam_keluarga,id'],
            'kewarganegaraan' => ['required'],
            'nik' => ['numeric', 'required', 'digits:16', 'starts_with:3509', 'unique:penduduk,nik,' . $this->penduduk->id],
            'nama' => ['string', 'required', 'max:100'],
            'tempat_lahir' => ['string', 'required', 'max:100'],
            'tanggal_lahir' => ['date', 'required', 'before:' . date('Y-m-d')],
            'jenis_kelamin' => ['required'],
            'no_paspor' => ['string', 'nullable', 'max:100'],
            'no_kitas_kitap'  => ['string', 'nullable', 'max:100'],
            'nama_ayah' =>  ['string', 'nullable', 'max:100'],
            'nama_ibu' =>  ['string', 'nullable', 'max:100'],
            'foto_ktp' => ['mimes:jpg,jpeg,png', 'nullable', 'max:1000'],
            'no_hp'  => ['string', 'nullable', 'max:15', 'starts_with:+62,62,08'],
            'email' =>  ['email', 'nullable', 'max:50']
        ];
    }

    public function attributes()
    {
        return [
            'keluarga_id' => 'keluarga',
            'agama_id' => 'agama',
            'darah_id' => 'golongan darah',
            'pekerjaan_id' => 'pekerjaan',
            'status_perkawinan_id' => 'status perkawinan',
            'pendidikan_id' => 'pendidikan',
            'status_hubungan_dalam_keluarga_id' => 'status hubungan dalam keluarga',
            'nik' => 'NIK',
            'nama' => 'nama lengkap',
            'no_paspor' => 'nomor paspor',
            'no_kitas_kitap'  => 'nomor KITAS / KITAP',
            'no_hp'  => 'No. Hp / WhatsApp',
        ];
    }
}
