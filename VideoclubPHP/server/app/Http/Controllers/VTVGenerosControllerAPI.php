<?php
namespace App\Http\Controllers;

use App\Models\GeneroVTV; 
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VTVGenerosControllerAPI extends Controller
{
    public function listarGenerosVTV(): JsonResponse
    {
        return response()->json(
            GeneroVTV::select('id', 'nombre', 'descripcion')->get()
        );
    }
}
?>