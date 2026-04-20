<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Izin extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'siswa_id',
        'tanggal',
        'alasan',
        'status',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
