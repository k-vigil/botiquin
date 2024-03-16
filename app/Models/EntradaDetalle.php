<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EntradaDetalle extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'entrada_detalles';
    protected $fillable = [
        'cantidad',
        'costo',
        'precio',
        'medicamento_presentacion_id',
        'lote_id',
        'entrada_id'
    ];

    public function entrada()
    {
        return $this->belongsTo(Entrada::class);
    }

    public function medicamento_presentacion()
    {
        return $this->belongsTo(MedicamentoPresentacion::class);
    }

    public function lote()
    {
        return $this->belongsTo(Lote::class);
    }
}
