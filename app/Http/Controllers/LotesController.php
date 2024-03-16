<?php

namespace App\Http\Controllers;

use App\Models\Lote;
use Exception;
use Illuminate\Http\Request;

class LotesController extends Controller
{
    public function index()
    {
        return view('lotes.index');
    }

    public function listarLotes()
    {
        $lista = Lote::all();

        return response()->json($lista);
    }

    public function obtenerLote($id)
    {
        $lote = Lote::find($id);

        if ($lote == null)
            throw new Exception('No se encontro coincidencia');

        return response()->json($lote);
    }

    public function registrarLote(Request $request)
    {
        $request->validate([
            'codigo' => 'required',
            'fabricacion' => 'required',
            'vencimiento' => 'required'
        ]);

        $lote = new Lote();
        $lote->codigo = $request->get('codigo');
        $lote->fabricacion = $request->get('fabricacion');
        $lote->vencimiento = $request->get('vencimiento');
        $lote->descripcion = $request->get('descripcion');

        if (!$lote->save())
            throw new Exception('Hubo un error. No se pudo guardar');

        return response()->json(true);
    }

    public function editarLote($id, Request $request)
    {
        $lote = Lote::find($id);

        if ($lote == null)
            throw new Exception('No se encontro coincidencia');

        $lote->codigo = $request->get('codigo');
        $lote->fabricacion = $request->get('fabricacion');
        $lote->vencimiento = $request->get('vencimiento');
        $lote->descripcion = $request->get('descripcion');

        if (!$lote->save())
            throw new Exception('Hubo un error. No se pudo actualizar');

        return response()->json(true);
    }

    public function eliminarLote($id)
    {
        $lote = Lote::find($id);

        if ($lote == null)
            throw new Exception('No se encontro coincidencia');

        if (!$lote->delete())
            throw new Exception('Hubo un error. No se pudo eliminar');

        return response()->json(true);
    }
}
