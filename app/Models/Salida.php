<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Salida extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'salidas';
    protected $fillable = [
        'fecha',
        'descripcion',
        'estado'
    ];

    public function detalles()
    {
        return $this->hasMany(SalidaDetalle::class);
    }
}
