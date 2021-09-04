<?php

namespace App\Http\Requests\Rumah;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRumahRequest extends FormRequest
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
        $keluarga_ids =
            $this->rumah->keluarga->map(function ($keluarga) {
                return $keluarga->id;
            })->toArray();
        return [
            'rt_id' => ['numeric', 'required', 'exists:rt,id'],
            'alamat' => ['string', 'required', 'max:200'],
            'nomor' => ['string', 'required', 'max:20'],
            'tipe_bangunan' => ['string', 'nullable', 'max:20'],
            'penggunaan_bangunan' => ['string', 'nullable', 'max:100'],
            'kontruksi_bangunan' => ['string', 'nullable', 'max:100'],
            'keterangan' => ['string', 'nullable', 'max:255'],
            'keluarga_id' => ['required', 'array'],
            'keluarga_id.*' => ['numeric', 'exists:keluarga,id', Rule::unique('rumah_keluarga', 'keluarga_id')->where(function ($q) use ($keluarga_ids) {
                return $q->whereNotIn('keluarga_id', $keluarga_ids);
            })],
        ];
    }

    public function attributes()
    {
        return [
            'rt_id' => 'RT',
            'nomor' => 'nomor rumah',
            'keluarga_id' => 'keluarga',
            'keluarga_id.*' => 'keluarga',
        ];
    }
}
