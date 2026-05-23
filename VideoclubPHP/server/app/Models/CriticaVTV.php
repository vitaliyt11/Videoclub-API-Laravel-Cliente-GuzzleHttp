<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CriticaVTV extends Model
{
    use HasFactory;

    // Asociación de la tabla con el modelo.
    protected $table = 'criticas';

    // Definición de los atributos asignables en masa.
    protected $fillable = ['comentario', 'pelicula', 'fecha', 'valoracion'];

    public function user()
    {
        return $this->belongsTo(User::class, 'usuario');
    }
    public function pelicula()
    {
        return $this->belongsTo(PeliculaVTV::class, 'pelicula');
    }
}
