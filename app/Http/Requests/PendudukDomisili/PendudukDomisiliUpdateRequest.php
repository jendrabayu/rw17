<?php

namespace App\Http\Requests\PendudukDomisili;

use Illuminate\Foundation\Http\FormRequest;

class PendudukDomisiliUpdateRequest extends FormRequest
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
            'agama_id' => ['required', 'numeric', 'exists:agama,id'],
            'darah_id' => ['nullable', 'numeric',  'exists:darah,id'],
            'pekerjaan_id' => ['required', 'numeric', 'exists:pekerjaan,id'],
            'status_perkawinan_id' => ['required', 'numeric', 'exists:status_perkawinan,id'],
            'pendidikan_id' =>  ['nullable', 'numeric', 'exists:pendidikan,id'],
            'kewarganegaraan' => ['required', 'in:1,2,3'],
            'nik' => ['required', 'numeric', 'digits:16', 'unique:penduduk_domisili,nik,' . $this->penduduk_domisili->id],
            'nama' => ['required', 'string',  'max:150'],
            'tempat_lahir' => ['required', 'string', 'max:255'],
            'tanggal_lahir' => ['required', 'date_format:Y-m-d', 'before_or_equal:' . date('Y-m-d')],
            'jenis_kelamin' => ['required', 'in:l,p'],
            'alamat' => ['required', 'string',  'max:255'],
            'alamat_asal' => ['nullable', 'string', 'max:255'],
            'foto_ktp' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
            'no_hp'  => ['nullable', 'string',  'max:15', 'starts_with:+62,62,08'],
            'email' =>  ['nullable', 'email', 'max:100']
        ];
    }

    public function attributes()
    {
        return [
            'rt_id' => 'RT',
            'agama_id' => 'agama',
            'darah_id' => 'golongan darah',
            'pekerjaan_id' => 'pekerjaan',
            'status_perkawinan_id' => 'status perkawinan',
            'pendidikan_id' => 'pendidikan',
            'nik' => 'NIK',
            'no_hp'  => 'No. Hp / WhatsApp',
        ];
    }
}
