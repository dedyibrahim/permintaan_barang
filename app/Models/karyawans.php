<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class karyawans extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'id_nik',
        'department'
    ];
}
