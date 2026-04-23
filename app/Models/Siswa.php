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
        'nis',
        'nisn',
        'jk',
        'tempat_lahir',
        'tgl_lahir',
        'nik',
        'agama',
        'alamat',
        'nama_ayah',
        'nama_ibu',
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
