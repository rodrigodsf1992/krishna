<?php

namespace App\Http\Controllers;

use App\Models\Cidades;

class CidadesController extends Controller
{

    public function list()
    {
        $cidades = Cidades::get();

        return response()->json($cidades, 200);
    }
}
