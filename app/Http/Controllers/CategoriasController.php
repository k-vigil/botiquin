<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Exception;
use Illuminate\Http\Request;

class CategoriasController extends Controller
{
    public function index()
    {
        return view('categorias.index');
    }

    public function listarCategorias()
    {
        $lista = Categoria::all();

        return response()->json($lista);
    }

    public function obtenerCategoria($id)
    {
        $categoria = Categoria::find($id);

        if ($categoria == null)
            throw new Exception('No se encontro coincidencia');

        return response()->json($categoria);
    }

    public function registrarCategoria(Request $request)
    {
        $request->validate([
            'nombre' => 'required'
        ]);

        $categoria = new Categoria();
        $categoria->nombre = $request->get('nombre');
        $categoria->descripcion = $request->get('descripcion');

        if (!$categoria->save())
            throw new Exception('Hubo un error. No se pudo guardar');

        return response()->json(true);
    }

    public function editarCategoria($id, Request $request)
    {
        $categoria = Categoria::find($id);

        if ($categoria == null)
            throw new Exception('No se encontro coincidencia');

        $categoria->nombre = $request->get('nombre');
        $categoria->descripcion = $request->get('descripcion');

        if (!$categoria->save())
            throw new Exception('Hubo un error. No se pudo actualizar');

        return response()->json(true);
    }

    public function eliminarCategoria($id)
    {
        $categoria = Categoria::find($id);

        if ($categoria == null)
            throw new Exception('No se encontro coincidencia');

        if (!$categoria->delete())
            throw new Exception('Hubo un error. No se pudo eliminar');

        return response()->json(true);
    }
}
