<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rt extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'rt';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get the rw for the rw.
     */
    public function rw()
    {
        return $this->belongsTo(Rw::class);
    }

    /**
     * Get the user for the users.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the user for the users.
     */
    public function keluarga()
    {
        return $this->hasMany(Keluarga::class);
    }

    public function rumah()
    {
        return $this->hasMany(Rumah::class, 'rt_id');
    }

    public function pendudukDomisili()
    {
        return $this->hasMany(PendudukDomisili::class);
    }

    public function pendudukMeninggal()
    {
        return $this->hasMany(PendudukMeninggal::class);
    }
}
