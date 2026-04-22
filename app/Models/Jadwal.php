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

    public static function jamMap()
    {
        return [
            1  => '07:00', 2  => '07:45', 3  => '08:30', 4  => '09:15',
            5  => '10:00', 6  => '10:45', 7  => '11:30', 8  => '12:15',
            9  => '13:00', 10 => '13:45', 11 => '14:30', 12 => '15:15',
        ];
    }

    public function qrSessions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(QrSession::class, 'jadwal_id');
    }

    public static function getWaktu($jamKe)
    {
        return self::jamMap()[$jamKe] ?? sprintf('%02d:00', 6 + (int)$jamKe);
    }
}
