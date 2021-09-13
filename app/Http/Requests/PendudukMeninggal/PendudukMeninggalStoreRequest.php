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
            'rt_id' => ['numeric', 'required', 'exists:rt,id'],
            'penduduk_id' => ['numeric', 'required', 'exists:penduduk,id'],
            'tanggal_kematian' => ['date_format:Y-m-d', 'required'],
            'jam_kematian' => ['date_format:H:i', 'nullable', 'before_or_equal:' . date('Y-m-d')],
            'tempat_kematian' => ['string', 'max:100', 'nullable'],
            'sebab_kematian' => ['string', 'max:100', 'nullable'],
            'tempat_pemakaman' => ['string', 'max:100', 'nullable']
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
