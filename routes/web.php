<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CotizacionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\ProductoController;
use App\Http\Middleware\CheckEmpresaSession;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Empresa;

Route::get('/', function () {
    return view('login');
})->name('login');



Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('salir');


Route::middleware(['auth', CheckEmpresaSession::class])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::post('/seleccionar-empresa', [EmpresaController::class, 'seleccionar'])->name('guardar.empresa');

    /* clientes */
    Route::get('clientes', [ClienteController::class, 'index'])->name('clientes.index');
    Route::post('clientes', [ClienteController::class, 'store'])->name('clientes.store');
    Route::put('clientes/{id}', [ClienteController::class, 'update'])->name('clientes.update');
    Route::delete('clientes/{id}', [ClienteController::class, 'destroy'])->name('clientes.destroy');

    /* productos */
    Route::get('productos', [ProductoController::class, 'index'])->name('productos.index');
    Route::post('productos', [ProductoController::class, 'store'])->name('productos.store');
    Route::put('productos/{id}', [ProductoController::class, 'update'])->name('productos.update');
    Route::delete('productos/{id}', [ProductoController::class, 'destroy'])->name('productos.destroy');
    Route::patch('/productos/{producto}/imagen', [ProductoController::class, 'editarfoto'])->name('productos.editarfoto');

    /* cotizaciones */
    Route::get('crear-cotizacion', [CotizacionController::class, 'creando'])->name('cotizaciones.creando');

});
