<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MedicamentoPresentacion extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'medicamentos_presentaciones';
    protected $fillable = [
        'codigo',
        'descripcion',
        'composicion',
        'registro_dnm',
        'stock_min',
        'medicamento_id',
        'presentacion_id'
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function laboratorio()
    {
        return $this->belongsTo(Laboratorio::class);
    }

    public function medicamento()
    {
        return $this->belongsTo(Medicamento::class);
    }

    public function presentacion()
    {
        return $this->belongsTo(Presentacion::class);
    }

    public function entradaDetalle()
    {
        return $this->hasMany(EntradaDetalle::class);
    }
}
