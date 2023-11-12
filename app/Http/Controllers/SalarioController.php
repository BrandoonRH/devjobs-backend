<?php

namespace App\Http\Controllers;

use App\Models\Salario;
use Illuminate\Http\Request;

class SalarioController extends Controller
{
    public function getSalarios()
    {
            $salarios = Salario::all();
            return [
                'salarios' => $salarios
            ];
    }
}
