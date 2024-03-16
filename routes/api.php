<?php

use App\Http\Controllers\CategoriasController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EntradasController;
use App\Http\Controllers\LaboratoriosController;
use App\Http\Controllers\LotesController;
use App\Http\Controllers\MedicamentosController;
use App\Http\Controllers\PresentacionesController;
use App\Http\Controllers\SalidasController;
use App\Http\Controllers\StocksController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/dashboard/costo/entradas', [DashboardController::class, 'obtenerCostoTotalEnEntradas']);
Route::get('/dashboard/costo/salidas', [DashboardController::class, 'obtenerCostoTotalEnSalidas']);
Route::get('/dashboard/stock', [DashboardController::class, 'obtenerMedicamentosConLimiteDeStockMinimo']);
Route::get('/dashboard/top', [DashboardController::class, 'obtenerTopMedicamentosMasVendidos']);

Route::get('/laboratorios', [LaboratoriosController::class, 'listarLaboratorios']);
Route::get('/laboratorios/{id}', [LaboratoriosController::class, 'obtenerLaboratorio']);
Route::post('/laboratorios', [LaboratoriosController::class, 'registrarLaboratorio']);
Route::put('/laboratorios/{id}', [LaboratoriosController::class, 'editarLaboratorio']);
Route::delete('/laboratorios/{id}', [LaboratoriosController::class, 'eliminarLaboratorio']);

Route::get('/categorias', [CategoriasController::class, 'listarCategorias']);
Route::get('/categorias/{id}', [CategoriasController::class, 'obtenerCategoria']);
Route::post('/categorias', [CategoriasController::class, 'registrarCategoria']);
Route::put('/categorias/{id}', [CategoriasController::class, 'editarCategoria']);
Route::delete('/categorias/{id}', [CategoriasController::class, 'eliminarCategoria']);

Route::get('/presentaciones', [PresentacionesController::class, 'listarPresentaciones']);
Route::get('/presentaciones/{id}', [PresentacionesController::class, 'obtenerPresentacion']);
Route::post('/presentaciones', [PresentacionesController::class, 'registrarPresentacion']);
Route::put('/presentaciones/{id}', [PresentacionesController::class, 'editarPresentacion']);
Route::delete('/presentaciones/{id}', [PresentacionesController::class, 'eliminarPresentacion']);

Route::get('/medicamentos', [MedicamentosController::class, 'listarMedicamentos']);
Route::get('/medicamentos/variantes', [MedicamentosController::class, 'listarVariantes']);
Route::get('/medicamentos/{id}', [MedicamentosController::class, 'obtenerMedicamento']);
Route::post('/medicamentos', [MedicamentosController::class, 'registrarMedicamento']);
Route::delete('/medicamentos/{id}', [MedicamentosController::class, 'eliminarMedicamento']);
Route::post('/medicamentos/variantes', [MedicamentosController::class, 'registrarVariantes']);

Route::get('/lotes', [LotesController::class, 'listarLotes']);
Route::get('/lotes/{id}', [LotesController::class, 'obtenerLote']);
Route::post('/lotes', [LotesController::class, 'registrarLote']);
Route::put('/lotes/{id}', [LotesController::class, 'editarLote']);
Route::delete('/lotes/{id}', [LotesController::class, 'eliminarLote']);

Route::get('/entradas', [EntradasController::class, 'listarEntradas']);
Route::delete('/entradas/anular/{id}', [EntradasController::class, 'anularEntrada']);
Route::get('/entradas/{id}', [EntradasController::class, 'obtenerEntrada']);
Route::post('/entradas', [EntradasController::class, 'registrarEntrada']);

Route::get('/stocks', [StocksController::class, 'listarStocks']);

Route::get('/salidas', [SalidasController::class, 'listarSalidas']);
Route::delete('/salidas/anular/{id}', [SalidasController::class, 'anularSalida']);
Route::get('/salidas/{id}', [SalidasController::class, 'obtenerSalida']);
Route::post('/salidas', [SalidasController::class, 'registrarSalida']);
