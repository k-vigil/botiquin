<?php

namespace App\Http\Controllers;

use App\Models\Presentacion;
use Exception;
use Illuminate\Http\Request;

class PresentacionesController extends Controller
{
    public function index()
    {
        return view('presentaciones.index');
    }

    public function listarPresentaciones()
    {
        $lista = Presentacion::all();

        return response()->json($lista);
    }

    public function obtenerPresentacion($id)
    {
        $presentacion = Presentacion::find($id);

        if ($presentacion == null)
            throw new Exception('No se encontro coincidencia');

        return response()->json($presentacion);
    }

    public function registrarPresentacion(Request $request)
    {
        $request->validate([
            'nombre' => 'required'
        ]);

        $presentacion = new Presentacion();
        $presentacion->nombre = $request->get('nombre');
        $presentacion->descripcion = $request->get('descripcion');

        if (!$presentacion->save())
            throw new Exception('Hubo un error. No se pudo guardar');

        return response()->json(true);
    }

    public function editarPresentacion($id, Request $request)
    {
        $presentacion = Presentacion::find($id);

        if ($presentacion == null)
            throw new Exception('No se encontro coincidencia');

        $presentacion->nombre = $request->get('nombre');
        $presentacion->descripcion = $request->get('descripcion');

        if (!$presentacion->save())
            throw new Exception('Hubo un error. No se pudo actualizar');

        return response()->json(true);
    }

    public function eliminarPresentacion($id)
    {
        $presentacion = Presentacion::find($id);

        if ($presentacion == null)
            throw new Exception('No se encontro coincidencia');

        if (!$presentacion->delete())
            throw new Exception('Hubo un error. No se pudo eliminar');

        return response()->json(true);
    }
}
