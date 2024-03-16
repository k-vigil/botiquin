<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function obtenerCostoTotalEnEntradas()
    {
        $data = DB::select("
            select
                sum((cantidad * costo)) as total
            from entrada_detalles as ed
        ")[0];

        return response()->json($data);
    }

    public function obtenerCostoTotalEnSalidas()
    {
        $data = DB::select("
            select
                sum((cantidad * precio)) as total
            from salida_detalles as sd
        ")[0];

        return response()->json($data);
    }

    public function obtenerMedicamentosConLimiteDeStockMinimo()
    {
        $data = DB::select("
            select
                l.nombre as lab,
                mp.codigo,
                mp.descripcion,
                s.cantidad,
                mp.stock_min
            from stocks as s
            left join medicamentos_presentaciones as mp on s.medicamento_presentacion_id = mp.id
            left join medicamentos as m on mp.medicamento_id = m.id
            left join laboratorios as l on m.laboratorio_id = l.id
            where s.cantidad < mp.stock_min
        ");

        return response()->json($data);
    }

    public function obtenerTopMedicamentosMasVendidos()
    {
        $data = DB::select("
            select
                mp.codigo,
                mp.descripcion,
                sum(sd.cantidad) as total
            from salida_detalles as sd
            left join stocks as s on sd.stock_id = s.id
            left join medicamentos_presentaciones as mp on s.medicamento_presentacion_id = mp.id
            group by mp.codigo, mp.descripcion
            order by total desc
            limit 3
        ");

        return response()->json($data);
    }
}
