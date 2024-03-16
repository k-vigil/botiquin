<?php

namespace App\Http\Controllers;

use App\Models\Entrada;
use App\Models\EntradaDetalle;
use App\Models\MovimientoMedicamento;
use App\Models\Stock;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class EntradasController extends Controller
{
    public function index()
    {
        return view('entradas.index');
    }

    public function listarEntradas()
    {
        $lista = Entrada::all();

        return response()->json($lista);
    }

    public function obtenerEntrada($id)
    {
        $entrada = Entrada::with(['detalles.medicamento_presentacion', 'detalles.lote'])
            ->where('id', $id)
            ->first();

        if ($entrada == null)
            throw new Exception('No se econtro coincidencia');

        return response()->json($entrada);
    }

    public function registrarEntrada(Request $request)
    {
        $request->validate([
            "descripcion" => "required",
            "fecha" => "required",
        ]);

        try {
            DB::beginTransaction();

            $entrada = new Entrada();
            $entrada->descripcion = $request->get('descripcion');
            $entrada->fecha = $request->get('fecha');
            $entrada->estado = 'Realizado';

            if (!$entrada->save())
                throw new Exception("Hubo un error. No se pudo registrar la entrada");

            $detalles = $request->get('detalles');

            foreach ($detalles as $i) {

                $detalle = new EntradaDetalle();
                $detalle->cantidad = $i['cantidad'];
                $detalle->costo = $i['costo'];
                $detalle->precio = $i['precio'];
                $detalle->medicamento_presentacion_id = $i['medicamento_id'];
                $detalle->lote_id = $i['lote_id'];
                $detalle->entrada_id = $entrada->id;

                if (!$detalle->save())
                    throw new Exception('Hubo un error. No se pudo guardar el detalle de la entrada');

                $stock = Stock::where([
                    'medicamento_presentacion_id' => $i['medicamento_id'],
                    'lote_id' => $i['lote_id']
                ])
                    ->first();

                if ($stock != null) {
                    $stock->cantidad += $i['cantidad'];
                    $stock->precio = $i['precio'];

                    if (!$stock->save())
                        throw new Exception('Hubo un error. No se pudo actualizar el stock del medicamento');
                } else {
                    $stock = new Stock();
                    $stock->cantidad = $i['cantidad'];
                    $stock->precio = $i['precio'];
                    $stock->medicamento_presentacion_id = $i['medicamento_id'];
                    $stock->lote_id = $i['lote_id'];

                    if (!$stock->save())
                        throw new Exception('Hubo un error. No se pudo actualizar el stock del medicamento');
                }

                // movimiento en kardex
                // $lote = DB::table('lotes')
                //     ->where('id', $i['lote_id'])
                //     ->first();

                // $ultimoRegistro = DB::table('movimientos_medicamentos')
                //     ->where('medicamento_presentacion_id', $i['medicamento_id'])
                //     ->latest()
                //     ->first();

                // $subt = (float)$i['cantidad'] * (float)$i['costo'];

                // $mm = new MovimientoMedicamento();
                // $mm->fecha = $entrada->fecha;
                // $mm->descripcion = $entrada->descripcion;
                // $mm->lote = "$lote->codigo";
                // $mm->tipo = "Entrada";
                // $mm->cantidad = $i['cantidad'];
                // $mm->valor = $subt;

                // if (is_null($ultimoRegistro)) {
                //     $mm->saldo_cantidad = $i['cantidad'];
                //     $mm->saldo_valor = $subt;
                //     $mm->costo_prom = $subt / (float)$i['cantidad'];
                // } else {
                //     // costo-promedio-ponderado
                //     $cpp = ((float)$ultimoRegistro->saldo_valor + $subt) / ((float)$ultimoRegistro->saldo_cantidad + (float)$i['cantidad']);
                //     $mm->saldo_cantidad = (float)$ultimoRegistro->saldo_cantidad + (float)$i['cantidad'];

                //     $saldo = ((float)$ultimoRegistro->saldo_valor + (float)$subt);

                //     if ($saldo < 0)
                //         $saldo = 0;

                //     $mm->saldo_valor = $saldo;
                //     $mm->costo_prom = $cpp;
                // }

                // $mm->costo_unit = $i['costo'];
                // $mm->medicamento_presentacion_id = $i['medicamento_id'];
                // $mm->referencia = "e-$entrada->id";

                // if (!$mm->save())
                //     throw new Exception('No se pudo guardar el movimiento en kardex');
            }

            return DB::commit();
            return response()->json(true);
        } catch (Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function anularEntrada($id)
    {
        $entrada = Entrada::find($id);

        if ($entrada == null)
            throw new Exception('No se econtro coincidencia');

        $entrada->estado = 'Anulado';

        if (!$entrada->save())
            throw new Exception('No se pudo anular la entrada');

        $detalles = EntradaDetalle::where([
            'entrada_id' => $entrada->id
        ])
            ->get();

        if (count($detalles) == 0)
            throw new Exception('No se econtraron detalles para esta entrada');

        foreach ($detalles as $i) {
            $stock = Stock::where([
                'medicamento_presentacion_id' => $i->medicamento_presentacion_id,
                'lote_id' => $i->lote_id
            ])->first();

            if ($stock == null)
                continue;

            $stock->cantidad -= $i->cantidad;

            if (!$stock->save())
                throw new Exception('No se pudo disminuir el stock');

            // DB::table('movimientos_medicamentos')
            //     ->where([
            //         'medicamento_presentacion_id' => $i->medicamento_presentacion_id,
            //         'referencia' => "e-$entrada->id"
            //     ])
            //     ->delete();
        }

        return response()->json(true);
    }
}
