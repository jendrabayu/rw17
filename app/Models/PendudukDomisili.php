<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class PendudukDomisili extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'penduduk_domisili';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'rt_id',
        'agama_id',
        'darah_id',
        'pekerjaan_id',
        'status_perkawinan_id',
        'pendidikan_id',
        'kewarganegaraan',
        'nik',
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'alamat_asal',
        'foto_ktp',
        'no_hp',
        'email',
    ];

    protected $casts  = [
        // 'tanggal_lahir' => 'date'
    ];


    public const FILE_TYPES = ['xlsx', 'xls', 'csv'];

    /**
     * Get the penduduk for the penduduk.
     */
    public function rt()
    {
        return $this->belongsTo(Rt::class);
    }

    /**
     * Get the penduduk for the penduduk.
     */
    public function agama()
    {
        return $this->belongsTo(Agama::class);
    }

    /**
     * Get the penduduk for the penduduk.
     */
    public function darah()
    {
        return $this->belongsTo(Darah::class)->withDefault();
    }

    /**
     * Get the penduduk for the penduduk.
     */
    public function pekerjaan()
    {
        return $this->belongsTo(Pekerjaan::class)->withDefault();
    }

    /**
     * Get the penduduk for the penduduk.
     */
    public function statusPerkawinan()
    {
        return $this->belongsTo(StatusPerkawinan::class);
    }

    /**
     * Get the penduduk for the penduduk.
     */
    public function pendidikan()
    {
        return $this->belongsTo(Pendidikan::class)->withDefault();
    }

    public function getJenisKelaminTextAttribute()
    {
        if ($this->attributes['jenis_kelamin'] === 'l') {
            return 'Laki-Laki';
        } else {
            return 'Perempuan';
        }
    }

    public function getKewarganegaraanTextAttribute()
    {
        if ($this->attributes['kewarganegaraan'] === '1') {
            return 'Warga Negara Indonesia';
        } else if ($this->attributes['kewarganegaraan'] ===  '2') {
            return 'Warga Negara Asing';
        } else {
            return 'Dua Kewarganegaraan';
        }
    }


    public function getUsiaAttribute()
    {
        return Carbon::parse($this->tanggal_lahir)->age;
    }
}
