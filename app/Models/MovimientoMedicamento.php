<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovimientoMedicamento extends Model
{
    use HasFactory;

    protected $table = 'movimientos_medicamentos';
    protected $fillable = [
        'fecha',
        'descripcion',
        'lote',
        'tipo',
        'cantidad',
        'valor',
        'saldo_cantidad',
        'saldo_valor',
        'costo_prom',
        'costo_unit',
        'referencia',
        'medicamento_presentacion_id'
    ];
}
