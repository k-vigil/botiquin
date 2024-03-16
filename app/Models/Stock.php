<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stock extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'stocks';
    protected $fillable = [
        'cantidad',
        'precio',
        'medicamento_presentacion_id',
        'lote_id',
    ];

    public function medicamento_presentacion()
    {
        return $this->belongsTo(MedicamentoPresentacion::class);
    }

    public function lote()
    {
        return $this->belongsTo(Lote::class);
    }
}
