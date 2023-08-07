<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CidadesController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\MedicoController;

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

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('logout', 'logout')->middleware('auth:api');
    Route::post('refresh', 'refresh');
    Route::post('register', 'register');
});

Route::controller(PacienteController::class)->group(function () {
    Route::post('pacientes', 'create');
    Route::put('pacientes/{paciente}', 'update');
    Route::get('medicos/{medico}/pacientes', 'listPatientForDoctor');
});

Route::controller(MedicoController::class)->group(function () {
    Route::post('medicos', 'create')->middleware('auth:api');
    Route::get('medicos', 'list');
    Route::post('medicos/{medico}/pacientes', 'createDoctorPatient')->middleware('auth:api');
    Route::get('cidades/{cidade}/medicos', 'listDoctorForCity');
});

Route::controller(CidadesController::class)->group(function () {
    Route::get('cidades', 'list');
});
