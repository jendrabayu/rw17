<?php

namespace App\Http\Requests\Penduduk;

use Illuminate\Foundation\Http\FormRequest;

class PendudukStoreRequest extends FormRequest
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
            'keluarga_id' => ['required', 'numeric', 'exists:keluarga,id'],
            'agama_id' => ['required', 'numeric', 'exists:agama,id'],
            'darah_id' => ['nullable', 'numeric', 'exists:darah,id'],
            'pekerjaan_id' => ['required', 'numeric', 'exists:pekerjaan,id'],
            'status_perkawinan_id' => ['required', 'numeric', 'exists:status_perkawinan,id'],
            'pendidikan_id' =>  ['required', 'numeric', 'exists:pendidikan,id'],
            'status_hubungan_dalam_keluarga_id' => ['required', 'numeric',  'exists:status_hubungan_dalam_keluarga,id'],
            'kewarganegaraan' => ['required', 'in:1,2,3'],
            'nik' => ['required', 'numeric', 'digits:16', 'starts_with:3509', 'unique:penduduk,nik'],
            'nama' => ['required', 'string',  'max:150'],
            'tempat_lahir' => ['required', 'string', 'max:255'],
            'tanggal_lahir' => ['required', 'date_format:Y-m-d',  'before_or_equal:' . date('Y-m-d')],
            'jenis_kelamin' => ['required', 'in:l,p'],
            'no_paspor' => ['nullable', 'string',  'max:30'],
            'no_kitas_kitap'  => ['nullable', 'string',  'max:30'],
            'nama_ayah' =>  ['nullable', 'string',  'max:150'],
            'nama_ibu' =>  ['nullable', 'string',  'max:150'],
            'foto_ktp' => ['nullable', 'mimes:jpg,jpeg,png',  'max:1024'],
            'no_hp'  => ['nullable', 'string',  'max:15', 'starts_with:+62,62,08'],
            'email' =>  ['nullable', 'email',  'max:100']
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
            'no_paspor' => 'nomor paspor',
            'no_kitas_kitap'  => 'nomor KITAS / KITAP',
            'no_hp'  => 'No. Hp / WhatsApp',
        ];
    }
}
