<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Orangtua extends Authenticatable
{
    use Notifiable;

    protected $table = 'orangtuas';

    protected $fillable = [
        'siswa_id',
        'nama',
        'hubungan',
        'no_hp',
        'username',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
