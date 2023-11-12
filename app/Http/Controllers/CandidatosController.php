<?php

namespace App\Http\Controllers;

use App\Models\Candidato;
use App\Models\Vacante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CandidatosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Vacante $vacante)
    {
            $candidatos = [];

            foreach ($vacante->candidatos()->get() as $candidato) {
                $candidatos[] = [
                    "candidato" => $candidato,
                    "user" => $candidato->user
                ];
                unset($candidato['user']); // Elimina la clave 'user' del objeto $candidato para evitar duplicados
            }

        return [
            "candidatos" => $candidatos
       ];
    }

    /**
     * Show the form for creating a new resource.
     */
    public function downloadpdffile(Candidato $candidato)
    {
        $rutaArchivo = storage_path("app/public/cvs/{$candidato->cv}");

        if (Storage::exists("public/cvs/{$candidato->cv}") && file_exists($rutaArchivo)) {
            return response()->file($rutaArchivo, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $candidato->cv . '"',
            ]);
        } else {
            abort(404, 'Archivo no encontrado');
        }
    }

}
