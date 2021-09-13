<?php

namespace App\Http\Requests\PendudukMeninggal;

use Illuminate\Foundation\Http\FormRequest;

class PendudukMeninggalStoreRequest extends FormRequest
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
            'penduduk_id' => ['required', 'numeric',  'exists:penduduk,id'],
            'tanggal_kematian' => ['required', 'date_format:Y-m-d', 'before_or_equal:' . date('Y-m-d')],
            'jam_kematian' => ['nullable', 'date_format:H:i'],
            'tempat_kematian' => ['nullable', 'string', 'max:255'],
            'sebab_kematian' => ['nullable', 'string', 'max:255'],
            'tempat_pemakaman' => ['nullable', 'string', 'max:255']
        ];
    }

    public function attributes()
    {
        return [
            'rt_id' => 'RT',
            'penduduk_id' => 'penduduk'
        ];
    }
}
