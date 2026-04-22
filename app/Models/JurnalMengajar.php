<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JurnalMengajar extends Model
{
    protected $fillable = [
        'user_id',
        'tanggal',
        'mata_pelajaran',
        'kelas',
        'jam_mulai',
        'jam_selesai',
        'ringkasan_materi',
        'semester',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function presensi()
    {
        return $this->hasMany(JurnalPresensi::class, 'jurnal_id');
    }
}
