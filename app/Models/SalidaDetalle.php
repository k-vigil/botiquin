<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalidaDetalle extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'salida_detalles';
    protected $fillable = [
        'cantidad',
        'precio',
        'stock_id',
        'salida_id'
    ];

    public function salida()
    {
        return $this->belongsTo(Salida::class);
    }

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }
}
