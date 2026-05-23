<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VTVGenerosControllerAPI;
use App\Http\Controllers\VTVPeliculasControllerAPI;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//Endpoint para listar los géneros de VTV
Route::get('/listarGenerosVTV', [VTVGenerosControllerAPI::class, 'listarGenerosVTV']);
//Endpoint para listar las películas de VTV
Route::get('/listarPeliculasVTV', [VTVPeliculasControllerAPI::class, 'listarPeliculasVTV']);
//Endpoint para crear la película
Route::post('/crearPeliculaVTV', [VTVPeliculasControllerAPI::class, 'crearPeliculaVTV']);
//Endpoint para modificar el argumento de la película
Route::put('/modificarArgumentoPeliculaVTV/{pelicula}', [VTVPeliculasControllerAPI::class, 'modificarArgumentoPeliculaVTV']);
//Endpoint para borrar una película
Route::delete('/borrarPeliculaVTV/{id}', [VTVPeliculasControllerAPI::class, 'borrarPeliculaVTV']);