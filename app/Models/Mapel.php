<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'nama_mapel',
    ];
}
