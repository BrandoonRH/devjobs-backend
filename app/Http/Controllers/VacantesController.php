<?php

namespace App\Http\Controllers;

use App\Http\Requests\VacanteEditRequest;
use App\Http\Requests\VacanteRequest;
use App\Models\Vacante;
use App\Notifications\NuevoCandidato;
use Illuminate\Http\Request;

class VacantesController extends Controller
{
    public function index()
    {
        $vacantes = [];

            foreach (Vacante::all() as $vacante) {
                $vacantes[] = [
                    "vacante" => $vacante,
                    "salario" => $vacante->salario->salario,
                    "categoria" => $vacante->categoria->categoria,
                ];
                unset($vacante['salario']);
                unset($vacante['categoria']);
             }

        return [
             "vacantes" => $vacantes
        ];
    }
    public function store(VacanteRequest $request)
    {
            $data = $request->validated();
             //Crear la Vacante
            Vacante::create([
                'titulo' => $data['titulo'],
                'salario_id' => $data['salario'],
                'categoria_id' => $data['categoria'],
                'empresa' => $data['empresa'],
                'ultimo_dia' => $data['ultimo_dia'],
                'descripcion' => $data['descripcion'],
                'imagen' => $data['imagen'],
                'user_id' => auth()->user()->id,
            ]);

            return response()->json(['message' => 'Vacante Creada']);
    }

    public function getVacantesUser()
    {
        $vacantes = Vacante::where('user_id', auth()->user()->id)->get();

        return [
            'vacantes' => $vacantes
        ];

    }

    public function show(Vacante $vacante)
    {
        return [
            "vacante" => $vacante,
            "salario" => $vacante->salario->salario,
            "categoria" => $vacante->categoria->categoria
        ];
    }

    public function edit(Vacante $vacante)
    {
        $this->authorize('update', $vacante);
        return $vacante;
    }

    public function update( VacanteEditRequest $request, $id)
    {
        //$this->authorize('update');
        $data = $request->validated();
        $vacanteEdit = Vacante::find($id);

        // Verificar si hay una nueva imagen y la imagen anterior no es nula
        if ($data['imagen'] && $vacanteEdit->imagen) {
            $rutaImagen = public_path('uploads/' . $vacanteEdit->imagen);
            if (file_exists($rutaImagen)) {
                unlink($rutaImagen);
            }
        }

        //Asignar Valores Nuevos
        $vacanteEdit->titulo = $data['titulo'];
        $vacanteEdit->salario_id = $data['salario'];
        $vacanteEdit->categoria_id = $data['categoria'];
        $vacanteEdit->empresa = $data['empresa'];
        $vacanteEdit->ultimo_dia = $data['ultimo_dia'];
        $vacanteEdit->descripcion = $data['descripcion'];
        $vacanteEdit->imagen = $data['imagen'] ?? $vacanteEdit->imagen;

        //Actualizar la Vacante
        $vacanteEdit->save();

            return [
                "message" => "Vacante Editada"
            ];
    }

    public function  delete(Vacante $vacante)
    {

        $rutaImagen = public_path('uploads/' . $vacante->imagen);
        if (file_exists($rutaImagen)) {
            unlink($rutaImagen);
        }
        $vacante->delete();
        return [
            "message" => "Vacante Eliminada"
        ];

    }

    public function uploadCV(Request $request, Vacante $vacante)
    {
        $request->validate([
            'cv' => 'required|mimes:pdf|max:2048',
        ]);

        if ($request->file('cv')->isValid()) {
            $cvPath = $request->file('cv')->store('cvs', 'public');

            // Obtén el nombre del archivo con su extensión
            $cvFileName = basename($cvPath);

            $vacante->candidatos()->create([
                'user_id' => auth()->user()->id,
                'cv' => $cvFileName
            ]);

            //crear Notificación
            $vacante->reclutador->notify(New NuevoCandidato($vacante->id, $vacante->titulo, auth()->user()->id));

            return response()->json(['message' => 'Postulación Exitosa!'], 200);
        }

        return response()->json(['error' => 'Error'], 400);
    }

}//Fin del Controlador
