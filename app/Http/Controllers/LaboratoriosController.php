<?php

namespace App\Http\Controllers;

use App\Models\Laboratorio;
use Exception;
use Illuminate\Http\Request;

class LaboratoriosController extends Controller
{
    public function index()
    {
        return view('laboratorios.index');
    }

    public function listarLaboratorios()
    {
        $lista = Laboratorio::all();

        return response()->json($lista);
    }

    public function obtenerLaboratorio($id)
    {
        $laboratorio = Laboratorio::find($id);

        if ($laboratorio == null)
            throw new Exception('No se encontro coincidencia');

        return response()->json($laboratorio);
    }

    public function registrarLaboratorio(Request $request)
    {
        $request->validate([
            'nombre' => 'required'
        ]);

        $laboratorio = new Laboratorio();
        $laboratorio->nombre = $request->get('nombre');

        if (!$laboratorio->save())
            throw new Exception('Hubo un error. No se pudo guardar');

        return response()->json(true);
    }

    public function editarLaboratorio($id, Request $request)
    {
        $laboratorio = Laboratorio::find($id);

        if ($laboratorio == null)
            throw new Exception('No se encontro coincidencia');

        $laboratorio->nombre = $request->get('nombre');

        if (!$laboratorio->save())
            throw new Exception('Hubo un error. No se pudo actualizar');

        return response()->json(true);
    }

    public function eliminarLaboratorio($id)
    {
        $laboratorio = Laboratorio::find($id);

        if ($laboratorio == null)
            throw new Exception('No se encontro coincidencia');

        if (!$laboratorio->delete())
            throw new Exception('Hubo un error. No se pudo eliminar');

        return response()->json(true);
    }
}
