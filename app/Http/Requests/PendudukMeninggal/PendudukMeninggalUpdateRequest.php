<?php

namespace App\Http\Requests\PendudukMeninggal;

use Illuminate\Foundation\Http\FormRequest;

class PendudukMeninggalUpdateRequest extends FormRequest
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
            'agama_id' => ['required', 'numeric', 'exists:agama,id'],
            'darah_id' => ['nullable', 'numeric', 'exists:darah,id'],
            'pekerjaan_id' => ['required', 'numeric', 'exists:pekerjaan,id'],
            'status_perkawinan_id' => ['required', 'numeric', 'exists:status_perkawinan,id'],
            'kewarganegaraan' => ['required', 'in:1,2,3'],
            'pendidikan_id' =>  ['required', 'numeric', 'exists:pendidikan,id'],
            'nik' => ['required', 'numeric',  'digits:16', 'starts_with:3509', 'unique:penduduk_meninggal,nik,' . $this->penduduk_meninggal->id],
            'nama' => ['required', 'string', 'max:150'],
            'tempat_lahir' => ['required', 'string',  'max:255'],
            'tanggal_lahir' => ['required', 'date_format:Y-m-d'],
            'jenis_kelamin' => ['required', 'in:l,p'],
            'nama_ayah' =>  ['nullable', 'string', 'max:150'],
            'nama_ibu' =>  ['nullable', 'string',  'max:150'],
            'foto_ktp' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
            'alamat' => ['required', 'string', 'max:255'],
            'tanggal_kematian' => ['required', 'date_format:Y-m-d', 'before_or_equal:' . date('Y-m-d')],
            'jam_kematian' => ['nullable', 'date_format:H:i'],
            'tempat_kematian' => ['nullable', 'string', 'max:255'],
            'sebab_kematian' => ['nullable', 'string', 'max:255'],
            'tempat_pemakaman' => ['nullable', 'string', 'max:255'],
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
            'nik' => 'NIK',
        ];
    }
}
