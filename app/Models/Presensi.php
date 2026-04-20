<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'nama_siswa',
        'kelas',
        'tanggal',
        'status',
    ];
}
