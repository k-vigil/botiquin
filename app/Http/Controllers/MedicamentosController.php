<?php

namespace App\Http\Controllers;

use App\Models\Medicamento;
use App\Models\MedicamentoPresentacion;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class MedicamentosController extends Controller
{
    public function index()
    {
        return view('medicamentos.index');
    }

    public function listarMedicamentos()
    {
        $lista = Medicamento::with(['laboratorio', 'categoria'])
            ->get();

        return response()->json($lista);
    }

    public function obtenerMedicamento($id)
    {
        $medicamento = Medicamento::with(['laboratorio', 'categoria', 'variantes.presentacion'])
            ->where('id', $id)
            ->first();

        if ($medicamento == null)
            throw new Exception('No se encontro coincidencia');

        return response()->json($medicamento);
    }

    public function registrarMedicamento(Request $request)
    {
        $request->validate([
            "nombre" => "required",
            "laboratorio_id" => "required",
            "categoria_id" => "required"
        ]);

        try {
            DB::beginTransaction();

            $medicamento = new Medicamento();
            $medicamento->nombre = $request->get("nombre");
            $medicamento->descripcion = $request->get("descripcion");
            $medicamento->laboratorio_id = $request->get("laboratorio_id");
            $medicamento->categoria_id = $request->get("categoria_id");

            if (!$medicamento->save())
                throw new Exception('Hubo un error. No se pudo registrar el medicamento');

            $variantes = $request->get("presentaciones");

            foreach ($variantes as $i) {

                $variante = new MedicamentoPresentacion();
                $variante->codigo = $i['codigo'];
                $variante->descripcion = $i['descripcion'];
                $variante->composicion = $i['composicion'];
                $variante->registro_dnm = $i['registroDnm'];
                $variante->stock_min = $i['stockMin'];
                $variante->presentacion_id = $i['presentacion'];
                $variante->medicamento_id = $medicamento->id;

                if (!$variante->save())
                    throw new Exception('Hubo un error. No se pudo registrar una variante');
            }

            return DB::commit();
            return response()->json(true);
        } catch (Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function eliminarMedicamento($id)
    {
        $medicamento = Medicamento::find($id);

        if ($medicamento == null)
            throw new Exception('No se encontro coincidencia');

        if (!$medicamento->delete())
            throw new Exception('Hubo un error. No se pudo eliminar');

        return response()->json(true);
    }

    public function listarVariantes()
    {
        $lista = MedicamentoPresentacion::all();

        return response()->json($lista);
    }

    public function registrarVariantes(Request $request)
    {
        $request->validate([
            "medicamento_id" => "required",
            "presentaciones" => "required",
        ]);

        try {
            DB::beginTransaction();

            $medicamentoId = $request->get("medicamento_id");
            $variantes = $request->get("presentaciones");

            foreach ($variantes as $i) {

                $variante = new MedicamentoPresentacion();
                $variante->codigo = $i['codigo'];
                $variante->descripcion = $i['descripcion'];
                $variante->composicion = $i['composicion'];
                $variante->registro_dnm = $i['registroDnm'];
                $variante->stock_min = $i['stockMin'];
                $variante->presentacion_id = $i['presentacion'];
                $variante->medicamento_id = $medicamentoId;

                if (!$variante->save())
                    throw new Exception('Hubo un error. No se pudo registrar una variante');
            }

            return DB::commit();
            return response()->json(true);
        } catch (Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
