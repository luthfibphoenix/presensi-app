<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Siswa extends Authenticatable
{
    public $timestamps = false;

    protected $fillable = [
        'nama',
        'kelas_id',
        'user_id',
        'username',
        'password',
    ];

    protected $hidden = ['password'];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function getAuthIdentifierName(): string
    {
        return 'id';
    }

    public function getAuthPassword(): string
    {
        return $this->password;
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function catatan()
    {
        return $this->hasMany(CatatanSiswa::class, 'siswa_id');
    }
}
