<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class sacp extends Model
{
    protected $table = 'sacp';

    public $timestamps = false;

    protected $fillable = [
        'clave_procedimiento',
        'titulo',
        'fecha_emision',
        'revision',
        'nivel_riesgo',
    ];

    // 👇 IMPORTANTE: no castear fechas aquí porque pueden venir como "ene-24"
    // protected $casts = [
    //     'fecha_emision' => 'date',
    // ];
}
