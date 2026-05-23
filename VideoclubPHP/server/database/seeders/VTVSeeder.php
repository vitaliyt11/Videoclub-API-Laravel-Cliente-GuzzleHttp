<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\GeneroVTV;
use App\Models\PeliculaVTV;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VTVSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Desactivamos las claves foráneas por que generan conflicto
        Schema::disableForeignKeyConstraints();
        if (User::where('email','VTV1@email.VTV1')->count()==0)
        {
            $user1= new User();
            $user1->name='VTV1';
            $user1->password=Hash::make('VTV1');
            $user1->email='VTV1@email.VTV1';
            $user1->email_verified_at=now();
            $user1->save();
        }
        if (User::where('email','VTV2@email.VTV2')->count()==0)
        {
            $user2= new User();
            $user2->name='VTV2';
            $user2->password=Hash::make('VTV2');
            $user2->email='VTV2@email.VTV2';
            $user2->email_verified_at=now();
            $user2->save();
        }
        if (GeneroVTV::where('nombre','animación')->count()==0)
        {
            $gen1= new GeneroVTV();
            $gen1->nombre='animación';
            $gen1->descripcion='Películas de animación, tanto tradicionales como por computadora.';
            $gen1->save();
        }
        if (GeneroVTV::where('nombre','drama')->count()==0)
        {
            $gen2= new GeneroVTV();
            $gen2->nombre='drama';
            $gen2->descripcion='Películas centradas en el desarrollo emocional y conflictos de los personajes.';
            $gen2->save();
        }
        if (GeneroVTV::where('nombre','ciencia ficción-fantasía')->count()==0)
        {
            $gen3= new GeneroVTV();
            $gen3->nombre='ciencia ficción-fantasía';
            $gen3->descripcion='Películas con elementos tecnológicos, futuristas o fantásticos.';
            $gen3->save();
        }
        if (GeneroVTV::where('nombre','comedia')->count()==0)
        {
            $gen4= new GeneroVTV();
            $gen4->nombre='comedia';
            $gen4->descripcion='Películas destinadas a provocar risa y entretenimiento ligero.';
            $gen4->save();
        }
        if (GeneroVTV::where('nombre','otros')->count()==0)
        {
            $gen5= new GeneroVTV();
            $gen5->nombre='otros';
            $gen5->descripcion='Películas o documentales de otros géneros.';
            $gen5->save();
        }
        if (PeliculaVTV::where('titulo','Marvel')->count()==0)
        {
            $pel1= new PeliculaVTV();
            $pel1->titulo='Marvel';
            $pel1->argumento='Marvel 1.';
            $pel1->direccion='Marvel 1';
            $pel1->duracion=150;
            $pel1->genero=3;
            $pel1->anio=2026;
            $pel1->save();
        }
        if (PeliculaVTV::where('titulo','Marvel 2')->count()==0)
        {
            $pel2= new PeliculaVTV();
            $pel2->titulo='Marvel 2';
            $pel2->argumento='Marvel 2.';
            $pel2->direccion='Marvel 2';
            $pel2->duracion=160;
            $pel2->genero=3;
            $pel2->anio=2025;
            $pel2->save();
        }
        if (PeliculaVTV::where('titulo','DC 1')->count()==0)
        {
            $pel3= new PeliculaVTV();
            $pel3->titulo='DC 1';
            $pel3->argumento='DC 1.';
            $pel3->direccion='DC 1';
            $pel3->duracion=100;
            $pel3->genero=1;
            $pel3->anio=2020;
            $pel3->save();
        }
        if (PeliculaVTV::where('titulo','DC 2')->count()==0)
        {
            $pel3= new PeliculaVTV();
            $pel3->titulo='DC 2';
            $pel3->argumento='DC 2.';
            $pel3->direccion='DC 2';
            $pel3->duracion=200;
            $pel3->genero=1;
            $pel3->anio=2010;
            $pel3->save();
        }
        //Volvemos a activar las claves foráneas
        Schema::enableForeignKeyConstraints();

    }
}
