<?php

namespace DWES06_VTV;

use GuzzleHttp\Client as GClientVTV;
use Exception;

class VTV_Operaciones
{
    //Mensaje de error
    public const ERROR_SERVICIO_WEB = 'Error en el servicio web de VTV';
    //Función para obtener la lista de géneros llamando al ENDPOINT de listado de géneros del servicio web
    public static function VTV_OperacionObtenerListaDeGeneros(GClientVTV $cliente)
    {
        $resultado = null;
        try {
            $operacion = $cliente->get('listarGenerosVTV');
            if ($operacion->getStatusCode() != 200) {
                return ['error' => [self::ERROR_SERVICIO_WEB]];
            }
            $listaDeGeneros = json_decode($operacion->getBody()->getContents(), true);
            $generos = [];
            foreach ($listaDeGeneros as $genero) {
                $generos[intval($genero['id'])] = $genero;
            }
            $resultado = $generos;
        } catch (Exception $e) {
            $resultado = ['error' => [['Excepción al conectar con el servicio web']]];
        }
        return $resultado;
    }
    //Función para obtener la lista de películas llamando al ENDPOINT de listado de películas del servicio web
    public static function VTV_OperacionListarPelicula(GClientVTV $cliente)
    {
        $resultado = null;
        try {
            $operacion = $cliente->get('listarPeliculasVTV');
            if ($operacion->getStatusCode() != 200) {
                return ['error' => [self::ERROR_SERVICIO_WEB]];
            }
            $listaDePeliculas = json_decode($operacion->getBody()->getContents(), true);
            $peliculas = [];
            foreach ($listaDePeliculas as $pelicula) {
                $peliculas[intval($pelicula['id'])] = $pelicula;
            }
            $resultado = $peliculas;
        } catch (Exception $e) {
            $resultado = ['error' => [['Excepción al conectar con el servicio web']]];
        }
        return $resultado;
    }
    //Función para crear una película llamando al ENDPOINT de creación de película del servicio web
    public static function VTV_OperacionCrearPelicula(GClientVTV $cliente, array $datos)
    {
        $resultado = null;
        try {
            $operacion = $cliente->post('crearPeliculaVTV', [
                'json' => [
                    'titulo' => $datos[1],
                    'genero' => intval($datos[2]),
                    'direccion' => $datos[3],
                    'duracion' => intval($datos[4]),
                    'argumento' => $datos[5],
                    'anio' => intval($datos[6])
                ]
            ]);
            //En función del código de estado de la respuesta, procesar el resultado o los errores
            if ($operacion->getStatusCode() == 422) {
                $resultado = ['error' => json_decode($operacion->getBody()->getContents(), true)];
            } elseif ($operacion->getStatusCode() == 200) {
                $resultado = json_decode($operacion->getBody()->getContents(), true);
            } else {
                $resultado = ['error' => ['Error al crear la película.']];
            }
        } catch (Exception $e) {
            //Captura de errores no esperados
            $resultado = ['error' => [['Excepción al conectar con el servicio web']]];
        }
        //Devolvemos el resultado de la operación
        return $resultado;
    }
    //Función para modificar el argumento de una película llamando al ENDPOINT de modificación de argumento de película del servicio web
    public static function VTV_OperacionModificarArgumento(GClientVTV $cliente, array $datos)
    {
        $resultado = null;
        $datosEnviar = [];
        $idPelicula = intval($datos[1]);
        $datosEnviar['argumento'] = $datos[2];
        try {
            $operacion = $cliente->put('modificarArgumentoPeliculaVTV/' . $idPelicula, [
                'json' => $datosEnviar
            ]);
            //En función del código de estado de la respuesta, procesar el resultado o los errores
            if ($operacion->getStatusCode() == 422) {
                $resultado = ['error' => json_decode($operacion->getBody()->getContents(), true)];
            } elseif ($operacion->getStatusCode() == 200) {
                $resultado = json_decode($operacion->getBody()->getContents(), true);
            } elseif ($operacion->getStatusCode() == 402) {
                $resultado = ['error' => json_decode($operacion->getBody()->getContents(), true)];
            } elseif ($operacion->getStatusCode() == 403) {
                $resultado = ['error' => json_decode($operacion->getBody()->getContents(), true)];
            } elseif ($operacion->getStatusCode() == 404) {
                $resultado = ['error' => json_decode($operacion->getBody()->getContents(), true)];
            } else {
                $resultado = json_decode($operacion->getBody()->getContents(), true);
            }
        } catch (Exception $e) {
            //Captura de errores no esperados
            $resultado = ['error' => [['Excepción al conectar con el servicio web']]];
        }
        return $resultado;
    }
    //Función para borrar una película llamando al ENDPOINT de borrado de película del servicio web
    public static function VTV_OperacionBorrarPelicula(GClientVTV $cliente, array $datos)
    {
        $resultado = null;
        $idPelicula = intval($datos[1]);
        try {
            $operacion = $cliente->delete('borrarPeliculaVTV/' . $idPelicula);
            //En función del código de estado de la respuesta, procesar el resultado o los errores
            if ($operacion->getStatusCode() == 200) {
                $resultado = json_decode($operacion->getBody()->getContents(), true);
            } elseif ($operacion->getStatusCode() == 404) {
                $resultado = ['error' => json_decode($operacion->getBody()->getContents(), true)];
            } else {
                $resultado = ['error' => ['Error al borrar la película.']];
            }
        } catch (Exception $e) {
            //Captura de errores no esperados
            $resultado = ['error' => [['Excepción al conectar con el servicio web']]];
        }
        return $resultado;
    }
};
