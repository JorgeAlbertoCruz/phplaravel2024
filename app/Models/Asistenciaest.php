<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asistenciaest extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'asistencia_est';
    protected $fillable = [

        'estudiante_id',
        'grupo_id',
        'fecha',
        'hora_entrada',
    ];

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }

    public function grupo()
    {
        return $this->belongsTo(Grupo::class);
    }
}
