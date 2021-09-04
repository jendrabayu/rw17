<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keluarga extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'keluarga';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get the penduduk for the penduduk.
     */
    public function penduduk()
    {
        return $this->hasMany(Penduduk::class);
    }

    /**
     * The roles that belong to the user.
     */
    public function rumah()
    {
        return $this->belongsToMany(Rumah::class);
    }

    public function rt()
    {
        return $this->belongsTo(Rt::class);
    }
}
