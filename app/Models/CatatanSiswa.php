<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatatanSiswa extends Model
{
    protected $fillable = [
        'guru_id',
        'siswa_id',
        'judul',
        'isi',
        'kategori',
    ];

    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }
}
