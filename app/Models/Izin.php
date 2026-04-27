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
        'bukti',
        'status',
        'tipe',
        'petugas_piket',
        'approved_by',
        'latitude',
        'longitude',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
