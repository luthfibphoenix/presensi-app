<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'mata_pelajaran',
        'kelas',
        'semester',
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
