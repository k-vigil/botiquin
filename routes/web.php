<?php

use App\Http\Controllers\CategoriasController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EntradasController;
use App\Http\Controllers\LaboratoriosController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LotesController;
use App\Http\Controllers\MedicamentosController;
use App\Http\Controllers\PresentacionesController;
use App\Http\Controllers\ReportesController;
use App\Http\Controllers\SalidasController;
use App\Http\Controllers\StocksController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::match(['GET', 'POST'], '/', [LoginController::class, 'login'])->name('login');

Route::middleware(['auth'])->group(function () {
    Route::get('/logout', [LoginController::class, 'logout']);
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/laboratorios', [LaboratoriosController::class, 'index']);
    Route::get('/categorias', [CategoriasController::class, 'index']);
    Route::get('/presentaciones', [PresentacionesController::class, 'index']);
    Route::get('/medicamentos', [MedicamentosController::class, 'index']);
    Route::get('/lotes', [LotesController::class, 'index']);
    Route::get('/entradas', [EntradasController::class, 'index']);
    Route::get('/stocks', [StocksController::class, 'index']);
    Route::get('/salidas', [SalidasController::class, 'index']);
    Route::get('/reportes', [ReportesController::class, 'index']);
    Route::post('/reportes/vencimientos', [ReportesController::class, 'reporteMedicamentosPorVencer']);
    Route::post('/reportes/porlaboratorio', [ReportesController::class, 'reporteMedicamentosPorLaboratorio']);
    Route::post('/reportes/porcategoria', [ReportesController::class, 'reporteMedicamentosPorCategoria']);
    Route::post('/reportes/porlote', [ReportesController::class, 'reporteMedicamentosPorLote']);
    Route::post('/reportes/inventario', [ReportesController::class, 'reporteInventario']);
});
