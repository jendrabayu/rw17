<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rumah extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'rumah';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $fillable = ['rt_id', 'alamat',  'nomor', 'tipe_bangunan', 'penggunaan_bangunan', 'kontruksi_bangunan', 'keterangan'];

    /**
     * The roles that belong to the user.
     */
    public function keluarga()
    {
        return $this->belongsToMany(Keluarga::class, 'rumah_keluarga', 'rumah_id', 'keluarga_id');
    }

    public function rt()
    {
        return $this->belongsTo(Rt::class, 'rt_id');
    }
}
