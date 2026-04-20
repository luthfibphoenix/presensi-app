<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'nama_kelas',
        'kode_kelas',
    ];
}
