<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CandidatosController;
use App\Http\Controllers\CategoriasController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\NotificaciónController;
use App\Http\Controllers\SalarioController;
use App\Http\Controllers\VacantesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->group(function() {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/logout', [AuthController::class, 'logout']);

    //Crear Una Vacante
    Route::post('/vacante/create', [VacantesController::class, 'store']);
    Route::post('/image', [ImageController::class, 'store']);

    //Vacantes creadas
    Route::get('/vacantes', [VacantesController::class, 'getVacantesUser']);

    //Editar Vacante
    Route::get('/vacante/{vacante}/edit', [VacantesController::class, 'edit']);
    Route::put('/vacante/{vacante}', [VacantesController::class, 'update']);

    //Eliminar Vacante
    Route::delete('/vacante/delete/{vacante}', [VacantesController::class, 'delete']);

    //Subir CV para postular
    Route::post('/postular/vacante/{vacante}', [VacantesController::class, 'uploadCV']);

    //Notificación
    Route::get('/notificationes', NotificaciónController::class);

    //Candidatos de una Vacante
    Route::get('/candidatos/{vacante}', [CandidatosController::class, 'index']);
    Route::get('/candidato/{candidato}/download-pdf-file',[CandidatosController::class, 'downloadpdffile']);
});
 //Obteniendo Información para Formulario
 Route::get('/salarios', [SalarioController::class, 'getSalarios']);
 Route::get('/categorias', [CategoriasController::class, 'getCategorias']);

//Autenticación
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

//Get all vacantes
Route::get('/vacantes', [VacantesController::class,  'index']);
//Show Vacante
Route::get('/vacantes/{vacante}', [VacantesController::class, 'show']);

