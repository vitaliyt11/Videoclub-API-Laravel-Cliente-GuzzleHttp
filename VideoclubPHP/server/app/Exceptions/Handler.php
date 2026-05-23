<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     *Función para personalizar mensaje error interno de laravel.
     */
    public function render($request, Throwable $exception)
    {
        //Capturar excepción de modelo no encontrado
        if ($exception instanceof ModelNotFoundException) {

            //Retornar respuesta JSON personalizada con código 404
            return response()->json([
                'error' => [["No se encontró la película solicitada."]],
                'code' => 404
            ], Response::HTTP_NOT_FOUND);
        }

        return parent::render($request, $exception);
    }
}
