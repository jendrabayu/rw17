<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Penduduk extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'penduduk';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'keluarga_id',
        'agama_id',
        'darah_id',
        'pekerjaan_id',
        'status_perkawinan_id',
        'pendidikan_id',
        'status_hubungan_dalam_keluarga_id',
        'kewarganegaraan',
        'nik',
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'no_paspor',
        'no_kitas_kitap',
        'nama_ayah',
        'nama_ibu',
        'foto_ktp',
        'no_hp',
        'email'
    ];

    protected $casts  = [
        'tanggal_lahir' => 'date'
    ];

    protected $appends = ['jenis_kelamin_text', 'usia'];

    public const FILE_TYPES = ['xlsx', 'xls', 'csv'];

    public function keluarga()
    {
        return $this->belongsTo(Keluarga::class);
    }

    public function agama()
    {
        return $this->belongsTo(Agama::class);
    }

    public function darah()
    {
        return $this->belongsTo(Darah::class)->withDefault();
    }

    public function pekerjaan()
    {
        return $this->belongsTo(Pekerjaan::class);
    }

    public function statusPerkawinan()
    {
        return $this->belongsTo(StatusPerkawinan::class);
    }

    public function pendidikan()
    {
        return $this->belongsTo(Pendidikan::class);
    }

    public function statusHubunganDalamKeluarga()
    {
        return $this->belongsTo(StatusHubunganDalamKeluarga::class);
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

    public  function scopeFilter($query)
    {
        $penduduk = $query->with([
            'keluarga.rt.rw',
            'agama',
            'pekerjaan',
            'pendidikan',
            'statusPerkawinan',
            'statusHubunganDalamKeluarga',
            'darah',
        ]);

        $penduduk->when(request()->has('agama'), function ($q) {
            return $q->whereHas('agama', function ($q) {
                $q->where('id', request()->get('agama'));
            });
        });

        $penduduk->when(request()->has('pekerjaan'), function ($q) {
            return $q->whereHas('pekerjaan', function ($q) {
                $q->where('id', request()->get('pekerjaan'));
            });
        });

        $penduduk->when(request()->has('darah'), function ($q) {
            return $q->whereHas('darah', function ($q) {
                $q->where('id', request()->get('darah'));
            });
        });

        $penduduk->when(request()->has('pendidikan'), function ($q) {
            return $q->whereHas('pendidikan', function ($q) {
                $q->where('id', request()->get('pendidikan'));
            });
        });

        $penduduk->when(request()->has('status_perkawinan'), function ($q) {
            return $q->whereHas('statusPerkawinan', function ($q) {
                $q->where('id', request()->get('status_perkawinan'));
            });
        });

        $penduduk->when(request()->has('status_hubungan_dalam_keluarga'), function ($q) {
            return $q->whereHas('statusHubunganDalamKeluarga', function ($q) {
                $q->where('id', request()->get('status_hubungan_dalam_keluarga'));
            });
        });

        $penduduk->when(request()->has('jenis_kelamin'), function ($q) {
            return $q->where('jenis_kelamin', request()->get('jenis_kelamin'));
        });

        $penduduk->when(request()->has('age_min') &&  request()->has('age_max'), function ($q) {
            $age_min =  request()->get('age_min');
            $age_max =  request()->get('age_max');
            if ($age_min && $age_max && $age_min <= $age_max) {
                $age_min = Carbon::now()->subYears($age_min)->format('Y-m-d');
                $age_max = Carbon::now()->subYears($age_max)->format('Y-m-d');
                return $q->whereBetween('tanggal_lahir', [$age_max, $age_min]);
            }
        });

        return $penduduk;
    }
}
