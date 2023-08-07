<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paciente;
use App\Models\Medico;

class PacienteController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function create(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:100',
            'cpf' => 'required|string|max:20',
            'celular' => 'required|string|max:20',
        ]);

        $paciente = Paciente::create([
            'nome' => $request->nome,
            'cpf' => $request->cpf,
            'celular' => $request->celular,
        ]);

        return response()->json($paciente, 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'string|max:100',
            'cpf' => 'string|max:20',
            'celular' => 'string|max:20',
        ]);

        $paciente = Paciente::find($id);
        $paciente->fill($request->input());
        $paciente->save();

        return response()->json($paciente, 200);
    }

    public function listPatientForDoctor($medicoId)
    {
        $medico = Medico::find($medicoId);
        if (!$medico) {
            return response()->json([
                'message' => 'Doctor do not exist',
            ], 401);
        }

        $pacientes = Paciente::join('medico_paciente', 'medico_paciente.paciente_id', '=', 'paciente.id')
                            ->where('medico_id', $medicoId)
                            ->get();

        return response()->json($pacientes, 200);
    }

}
