<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permintaans extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_permintaan',
        'id_nik',
        'tgl_permintaan'
    ];
}
