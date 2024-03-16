<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Medicamento extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'medicamentos';
    protected $fillable = [
        'nombre',
        'descripcion',
        'categoria_id',
        'laboratorio_id'
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function laboratorio()
    {
        return $this->belongsTo(Laboratorio::class);
    }

    public function variantes()
    {
        return $this->hasMany(MedicamentoPresentacion::class);
    }
}
