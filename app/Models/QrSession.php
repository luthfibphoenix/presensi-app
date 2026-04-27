<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QrSession extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'jadwal_id',
        'guru_id',
        'tanggal',
        'token',
        'expired_at',
    ];

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class);
    }

    public function jurnal()
    {
        return $this->hasOne(JurnalMengajar::class, 'qr_session_id');
    }
}
