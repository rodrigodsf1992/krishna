<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medico;
use App\Models\Paciente;
use App\Models\MedicoPaciente;
use App\Models\Cidades;

class MedicoController extends Controller
{

    public function list()
    {
        $medicos = Medico::get();

        return response()->json($medicos, 200);
    }

    public function listDoctorForCity($cidadeId)
    {
        $medicos = Medico::where('cidade_id', '=', $cidadeId)->get();

        return response()->json($medicos, 200);
    }

    public function create(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:100',
            'especialidade' => 'required|string|max:20',
            'cidade_id' => 'required|integer|max:20',
        ]);

        $city = Cidades::find($request->cidade_id);
        if (!$city) {
            return response()->json([
                'message' => 'City ​​does not exist',
            ], 401);
        }

        $doctor = Medico::create([
            'nome' => $request->nome,
            'especialidade' => $request->especialidade,
            'cidade_id' => $city->id,
        ]);

        return response()->json($doctor, 201);
    }

    public function createDoctorPatient(Request $request)
    {
        $this->middleware('auth:api');
        $request->validate([
            'medico_id' => 'required|integer|max:20',
            'paciente_id' => 'required|integer|max:20',
        ]);

        $paciente = Paciente::find($request->paciente_id);
        $medico = Medico::find($request->medico_id);
        if (!$paciente || !$medico) {
            return response()->json([
                'message' => 'Doctor or patient do not exist',
            ], 401);
        }

        $medicoPaciente = MedicoPaciente::create([
            'medico_id' => $medico->id,
            'paciente_id' => $paciente->id,
        ]);

        return response()->json([
            'medico' => $medico,
            'paciente' => $paciente
        ], 201);
    }

}
