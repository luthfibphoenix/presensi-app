<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JurnalPresensi extends Model
{
    protected $fillable = [
        'jurnal_id',
        'nama_siswa',
        'status',
    ];

    public function jurnal()
    {
        return $this->belongsTo(JurnalMengajar::class, 'jurnal_id');
    }
}
