<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriasController extends Controller
{
    public function getCategorias()
    {
        $categorias = Categoria::all();
        return [
            'categorias' => $categorias
        ];
    }
}
