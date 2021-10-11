<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'rt_id',
        'name',
        'username',
        'email',
        'no_hp',
        'alamat',
        'avatar',
        'password',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['role'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the user's role.
     *
     * @return string
     */
    public function getRoleAttribute()
    {
        if ($this->roles->isNotEmpty()) {
            return $this->roles->first()->name;
        }

        return null;
    }

    public function getAvatarUrlAttribute()
    {
        if (empty($this->avatar)) {
            return asset('assets/img/avatar/avatar-1.png');
        }

        return Storage::url($this->avatar);
    }

    /**
     * Get the rt for the rt.
     */
    public function rt()
    {
        return $this->belongsTo(Rt::class);
    }

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }
}
