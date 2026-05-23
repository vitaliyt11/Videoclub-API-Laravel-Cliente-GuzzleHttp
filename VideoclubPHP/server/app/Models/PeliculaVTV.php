<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeliculaVTV extends Model
{
    use HasFactory;

    // Asociación de la tabla con el modelo.
    protected $table = 'peliculas';

    // Definición de los atributos asignables en masa.
    protected $fillable = ['titulo', 'genero', 'duracion', 'direccion', 'argumento', 'anio'];

    public function criticas()
    {
        return $this->hasMany(CriticaVTV::class, 'pelicula');
    }
    public function genero()
    {
        return $this->belongsTo(GeneroVTV::class);
    }
}
