<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Laboratorio;
use App\Models\Lote;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportesController extends Controller
{
    public function index()
    {
        return view('reportes.index');
    }

    public function reporteMedicamentosPorVencer(Request $request)
    {
        $request->validate([
            'fecha' => 'required',
        ]);

        $fecha = $request->get('fecha');

        $data = DB::select("
        select
            l.nombre as lab,
            lot.codigo as lote,
            mp.codigo,
            mp.descripcion,
            mp.registro_dnm,
            pres.nombre as pres,
            lot.vencimiento as vencimiento
        from stocks as s
        left join lotes as lot on s.lote_id = lot.id
        left join medicamentos_presentaciones as mp on s.medicamento_presentacion_id = mp.id
        left join medicamentos as med on mp.medicamento_id = med.id
        left join laboratorios as l on med.laboratorio_id = l.id
        left join presentaciones as pres on mp.presentacion_id = pres.id
        where lot.vencimiento <= '$fecha'
        ");

        $pdf = Pdf::loadView('reportes/pdfs/vencimientos', [
            'data' => $data,
            'fecha' => $fecha
        ]);

        return $pdf->download();
    }

    public function reporteMedicamentosPorCategoria(Request $request)
    {
        $request->validate([
            'categoria' => 'required',
        ]);

        $catId = $request->get('categoria');
        $categoria = Categoria::find($catId);

        $data = DB::select("
        select
            l.nombre as lab,
            lot.codigo as lote,
            mp.codigo,
            mp.descripcion,
            mp.registro_dnm,
            pres.nombre as pres,
            s.cantidad,
            s.precio,
            lot.vencimiento as vencimiento
        from stocks as s
        left join lotes as lot on s.lote_id = lot.id
        left join medicamentos_presentaciones as mp on s.medicamento_presentacion_id = mp.id
        left join medicamentos as med on mp.medicamento_id = med.id
        left join laboratorios as l on med.laboratorio_id = l.id
        left join presentaciones as pres on mp.presentacion_id = pres.id
        left join categorias as cat on med.categoria_id = cat.id
        where cat.id = $catId
        ");

        $pdf = Pdf::loadView('reportes/pdfs/porcategoria', [
            'data' => $data,
            'categoria' => $categoria->nombre
        ]);

        return $pdf->download();
    }

    public function reporteMedicamentosPorLaboratorio(Request $request)
    {
        $request->validate([
            'laboratorio' => 'required',
        ]);

        $labId = $request->get('laboratorio');
        $laboratorio = Laboratorio::find($labId);

        $data = DB::select("
        select
            l.nombre as lab,
            lot.codigo as lote,
            mp.codigo,
            mp.descripcion,
            mp.registro_dnm,
            pres.nombre as pres,
            s.cantidad,
            s.precio,
            lot.vencimiento as vencimiento
        from stocks as s
        left join lotes as lot on s.lote_id = lot.id
        left join medicamentos_presentaciones as mp on s.medicamento_presentacion_id = mp.id
        left join medicamentos as med on mp.medicamento_id = med.id
        left join laboratorios as l on med.laboratorio_id = l.id
        left join presentaciones as pres on mp.presentacion_id = pres.id
        left join categorias as cat on med.categoria_id = cat.id
        where l.id = $labId
        ");

        $pdf = Pdf::loadView('reportes/pdfs/porlaboratorio', [
            'data' => $data,
            'laboratorio' => $laboratorio->nombre
        ]);

        return $pdf->download();
    }

    public function reporteMedicamentosPorLote(Request $request)
    {
        $request->validate([
            'lote' => 'required',
        ]);

        $loteId = $request->get('lote');
        $lote = Lote::find($loteId);

        $data = DB::select("
        select
            l.nombre as lab,
            lot.codigo as lote,
            mp.codigo,
            mp.descripcion,
            mp.registro_dnm,
            pres.nombre as pres,
            s.cantidad,
            s.precio,
            lot.vencimiento as vencimiento
        from stocks as s
        left join lotes as lot on s.lote_id = lot.id
        left join medicamentos_presentaciones as mp on s.medicamento_presentacion_id = mp.id
        left join medicamentos as med on mp.medicamento_id = med.id
        left join laboratorios as l on med.laboratorio_id = l.id
        left join presentaciones as pres on mp.presentacion_id = pres.id
        left join categorias as cat on med.categoria_id = cat.id
        where lot.id = $loteId
        ");

        $pdf = Pdf::loadView('reportes/pdfs/porlote', [
            'data' => $data,
            'lote' => "$lote->codigo $lote->fabricacion - $lote->vencimiento"
        ]);

        return $pdf->download();
    }

    public function reporteInventario(Request $request)
    {
        $data = DB::select("
        select
            l.nombre as lab,
            lot.codigo as lote,
            mp.codigo,
            mp.descripcion,
            mp.registro_dnm,
            pres.nombre as pres,
            s.cantidad,
            s.precio,
            lot.vencimiento as vencimiento
        from stocks as s
        left join lotes as lot on s.lote_id = lot.id
        left join medicamentos_presentaciones as mp on s.medicamento_presentacion_id = mp.id
        left join medicamentos as med on mp.medicamento_id = med.id
        left join laboratorios as l on med.laboratorio_id = l.id
        left join presentaciones as pres on mp.presentacion_id = pres.id
        left join categorias as cat on med.categoria_id = cat.id
        ");

        $pdf = Pdf::loadView('reportes/pdfs/inventario', [
            'data' => $data
        ]);

        return $pdf->download();
    }
}
