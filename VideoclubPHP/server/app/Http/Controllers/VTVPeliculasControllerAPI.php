<?php

namespace App\Http\Controllers;

use App\Models\PeliculaVTV;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VTVPeliculasControllerAPI extends Controller
{
    /*
    * Función para listar todas las películas en formato JSON
    */
    public function listarPeliculasVTV(): JsonResponse
    {
        return response()->json(
            PeliculaVTV::select('id', 'titulo', 'genero', 'duracion', 'anio', 'direccion', 'argumento')->get()
        );
    }
    /*
    * Función para crear película
    */
    public function crearPeliculaVTV(Request $request)
    {
        $resultado = null;
        //Si se recibe genero en lugar de genero_id lo convertimos para la validación
        if ($request->has('genero') && !$request->has('genero_id')) {
            $request->merge(['genero_id' => $request->input('genero')]);
        }

        //Validación de los datos usando Validator
        $validator = Validator::make($request->all(), [
            'titulo'    => ['required', 'string', 'min:2', 'max:60'],
            'genero_id' => ['required', 'integer', 'exists:generos,id'],
            'duracion'  => ['required', 'integer', 'min:1', 'max:500'],
            'anio'      => ['required', 'integer', 'min:1965', 'max:' . date('Y')],
            'direccion' => ['required', 'string', 'min:2', 'max:100'],
            'argumento' => ['required', 'string', 'min:10', 'max:255'],
        ], [
            //Mensajes de errores esepecíficos
            'anio.max' => 'El año de la película no puede ser superior al actual.',
            'genero_id.exists' => 'El género seleccionado no es válido.',
        ]);
        //Si hay errores devolverlos con código 422
        if ($validator->fails()) {
            $resultado = response()->json($validator->errors(), 422);
        } else {
            //Comprobar que no exista la película en la base de datos
            $existe = PeliculaVTV::where('titulo', $request->titulo)
                ->where('anio', $request->anio)
                ->where('direccion', $request->direccion)
                ->exists();
            //Si existe devolver error 422 con mensaje de error
            if ($existe) {
                $resultado = response()->json(['error' => ['Ya existe una película en la base de datos con el mismo título, año y dirección.']], 422);
            } else {
                // Crear la película en la base de datos de manera explícita (evitando errores de asignación masiva sin $fillable)
                $pelicula = new PeliculaVTV();
                $pelicula->titulo = $request->titulo;
                $pelicula->genero = $request->genero_id; // Se guarda en 'genero' como se utiliza al listar
                $pelicula->duracion = $request->duracion;
                $pelicula->anio = $request->anio;
                $pelicula->direccion = $request->direccion;
                $pelicula->argumento = $request->argumento;
                $pelicula->save();

                //Devolver el ID de la película creada con código 200
                $resultado = response()->json($pelicula->id, 200);
            }
        }

        //Devolver el resultado de la operación
        return $resultado;
    }
    /*
    * Función para modificar argumento de la película
    */
    public function modificarArgumentoPeliculaVTV(PeliculaVTV $pelicula, Request $request)
    {
        $resultado = null;
        if (!$request->isJson()) {
            $resultado = response()->json(['error' => 'Los datos enviados deben ser JSON.'], 403);
        } else {
            //Validación de los datos usando Validator
            $validator = Validator::make($request->all(), [
                'argumento' => ['required', 'string', 'min:10', 'max:255'],
            ]);
            //Si hay errores devolverlos con código 402
            if ($validator->fails()) {
                $resultado = response()->json($validator->errors(), 402);
            } else {
                if ($pelicula->argumento == $request->argumento) {
                //Devolvemos código de resultado operación con código 200
                $resultado = response()->json(['resultado' => 0], 200);
                } else {
                //Modificar el argumento de la película y guardarla en la base de datos
                $pelicula->argumento = $request->argumento;
                $pelicula->save();

                //Devolvemos código de resultado operación con código 200
                $resultado = response()->json(['resultado' => 1], 200);
                }
            }
        }
        //Devolver el resultado de la operación
        return $resultado;
    }
    /*
    * Función para borrar una película
    */
    public function borrarPeliculaVTV($id, Request $request)
    {
        $resultado = null;
        
        // Buscar la película manualmente sin autobinding
        $pelicula = PeliculaVTV::find($id);
        
        //Devolvemos error 404 si no existe la película
        if (!$pelicula) {
            $resultado = response()->json([
                'error' => ['No existe ninguna película con ID= ' . $id],
            ], 404);
        } else {
            //Eliminar la película
            $pelicula->delete();
            
            //Retornar confirmación con código 200
            $resultado = response()->json([
                'resultado' => 1,
            ], 200);
        }
        return $resultado;
    }
}
