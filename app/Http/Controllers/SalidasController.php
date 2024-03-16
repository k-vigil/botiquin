<?php

namespace App\Http\Controllers;

use App\Models\MovimientoMedicamento;
use App\Models\Salida;
use App\Models\SalidaDetalle;
use App\Models\Stock;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class SalidasController extends Controller
{
    public function index()
    {
        return view('salidas.index');
    }

    public function listarSalidas()
    {
        $lista = Salida::all();

        return response()->json($lista);
    }

    public function obtenerSalida($id)
    {
        $entrada = Salida::with(['detalles.stock.medicamento_presentacion'])
            ->where('id', $id)
            ->first();

        if ($entrada == null)
            throw new Exception('No se econtro coincidencia');

        return response()->json($entrada);
    }

    public function registrarSalida(Request $request)
    {
        $request->validate([
            "descripcion" => "required",
            "fecha" => "required",
        ]);

        try {
            DB::beginTransaction();

            $salida = new Salida();
            $salida->descripcion = $request->get('descripcion');
            $salida->fecha = $request->get('fecha');
            $salida->estado = 'Realizado';

            if (!$salida->save())
                throw new Exception("Hubo un error. No se pudo registrar la salida");

            $detalles = $request->get('detalles');

            foreach ($detalles as $i) {

                $detalle = new SalidaDetalle();
                $detalle->cantidad = $i['cantidad'];
                $detalle->precio = $i['precio'];
                $detalle->stock_id = $i['stock_id'];
                $detalle->salida_id = $salida->id;

                if (!$detalle->save())
                    throw new Exception('Hubo un error. No se pudo guardar el detalle de la entrada');

                $stock = Stock::find($i['stock_id']);
                $stock->cantidad -= $i['cantidad'];

                if (!$stock->save())
                    throw new Exception('Hubo un error. No se pudo actualizar el stock del medicamento');

                // movimiento en kardex
                // $stock = DB::table('stocks')
                //     ->where('id', $i['stock_id'])
                //     ->first();

                // $lote = DB::table('lotes')
                //     ->where('id', $stock->lote_id)
                //     ->first();

                // $ultimoRegistro = DB::table('movimientos_medicamentos')
                //     ->where('medicamento_presentacion_id', $stock->medicamento_presentacion_id)
                //     ->latest()
                //     ->first();

                // $subt = (float)$i['cantidad'] * (float)$ultimoRegistro->costo_prom;
                // $saldoCantidad = (float)$ultimoRegistro->saldo_cantidad - (float)$i['cantidad'];
                // $cpp = 0;  // costo-promedio-ponderado

                // if ($saldoCantidad > 0)
                //     $cpp = ((float)$ultimoRegistro->saldo_valor - $subt) / ((float)$ultimoRegistro->saldo_cantidad - (float)$i['cantidad']);

                // $mm = new MovimientoMedicamento();
                // $mm->fecha = $salida->fecha;
                // $mm->descripcion = $salida->descripcion;
                // $mm->lote = $lote->codigo;
                // $mm->tipo = 'Salida';
                // $mm->cantidad = $i['cantidad'];
                // $mm->valor = $subt;
                // $mm->saldo_cantidad = (float)$ultimoRegistro->saldo_cantidad - (float)$i['cantidad'];
                // $mm->saldo_valor = (float)$ultimoRegistro->saldo_valor - (float)$subt;
                // $mm->costo_unit = $i['precio'];
                // $mm->costo_prom = $cpp;
                // $mm->medicamento_presentacion_id = $stock->medicamento_presentacion_id;
                // $mm->referencia = "s-$salida->id";

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

    public function anularSalida($id)
    {
        $salida = Salida::find($id);

        if ($salida == null)
            throw new Exception('No se econtro coincidencia');

        $salida->estado = 'Anulado';

        if (!$salida->save())
            throw new Exception('No se pudo anular la salida');

        $detalles = SalidaDetalle::where([
            'salida_id' => $salida->id
        ])
            ->get();

        if (count($detalles) == 0)
            throw new Exception('No se econtraron detalles para esta entrada');

        foreach ($detalles as $i) {
            $stock = Stock::find($i->stock_id);

            if ($stock == null)
                continue;

            $stock->cantidad += $i->cantidad;

            if (!$stock->save())
                throw new Exception('No se pudo disminuir el stock');

            // DB::table('movimientos_medicamentos')
            //     ->where([
            //         'medicamento_presentacion_id' => $stock->medicamento_presentacion_id,
            //         'referencia' => "e-$salida->id"
            //     ])
            //     ->delete();
        }

        return response()->json(true);
    }
}
