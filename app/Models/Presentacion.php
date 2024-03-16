<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Presentacion extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'presentaciones';
    protected $fillable = [
        'nombre',
        'descripcion'
    ];

    public function variantes()
    {
        return $this->hasMany(MedicamentoPresentacion::class);
    }
}
