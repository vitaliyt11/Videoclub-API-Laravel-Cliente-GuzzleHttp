<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneroVTV extends Model
{
    use HasFactory;

    // Asociación de la tabla con el modelo.
    protected $table = 'generos';

    // Definición de los atributos asignables en masa.
    protected $fillable = ['nombre', 'descripcion', 'usuario'];

    public function peliculas()
    {
        return $this->hasMany(PeliculaVTV::class);
    }
}
