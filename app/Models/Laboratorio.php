<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Laboratorio extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'laboratorios';
    protected $fillable = [
        'nombre'
    ];

    public function medicamentos()
    {
        return $this->hasMany(Medicamento::class);
    }
}
