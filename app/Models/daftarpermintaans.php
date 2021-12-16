<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class daftarpermintaans extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_daftar_permintaan',
        'id_barang',
        'id_permintaan',
        'qty',
        'keterangan',
    ];
}
