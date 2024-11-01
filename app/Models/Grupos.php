<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grupos extends Model
{
    use HasFactory;

    protected $table = 'grupos';
    public $timestamps = false;
    protected $fillable = [
        'nombre_grupo', 
        'materia', 
        'fecha_clase', 
        'profesor', 
        'horario_clase', 
        'horario_clase_final', 
        'horario_registro', 
        'qr_code',
    ];
}