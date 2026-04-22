<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    protected $fillable = [
        'user_id',
        'nama_siswa',
        'kelas',
        'mata_pelajaran',
        'semester',
        'nilai',
        'komponen',
        'tanggal',
        'keterangan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
