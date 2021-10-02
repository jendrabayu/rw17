<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenggunaanBangunan extends Model
{
    use HasFactory;

    protected $table = 'penggunaan_bangunan';

    protected $fillable = ['nama'];

    public function rumah()
    {
        return $this->hasMany(Rumah::class);
    }
}
