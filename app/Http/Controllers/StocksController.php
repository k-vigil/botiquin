<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;

class StocksController extends Controller
{
    public function index()
    {
        return view('stocks.index');
    }

    public function listarStocks()
    {
        $lista = Stock::with(['medicamento_presentacion.medicamento.laboratorio', 'lote'])
            ->where('cantidad', '>', 0)
            ->get();

        return response()->json($lista);
    }
}
