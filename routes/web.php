<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrdenesController;
use Illuminate\Support\Facades\Http;
Route::get('/', function () {
    return view('principal');
});


// Obtener información de un proveedor (ruta nombrada)
Route::get('/ordenes/proveedor/{id}', [OrdenesController::class, 'getProveedor'])->name('ordenes.proveedor');

// Opcional: búsqueda de proveedores
Route::get('/ordenes/buscarProveedores', [OrdenesController::class, 'buscarProveedores']);
#proveedores 
route::get('/consultar/sucursales',[OrdenesController::class, 'obtenerSucursales']);


// Crear Orden
Route::get('/ordenes/crear', [OrdenesController::class, 'inicio'])->name('ordenes.crear');
// Guardar Orden
Route::post('/ordenes/guardar', [OrdenesController::class, 'guardar'])->name('ordenes.guardar');
//listado menu
Route::get('/ordenes/menu', [OrdenesController::class, 'menu'])->name('ordenes.menu');
//listado ordenes
Route::get('/ordenes-compras/{id}', [OrdenesController::class, 'show'])->name('ordenes-compras.mostrarid');

Route::get('/ordenes-compras/filtrar/buscar', [OrdenesController::class, 'filtrar'])->name('ordenes-compras.filtro');
Route::get('/ordenes-listado', [OrdenesController::class, 'index'])->name('ordenes-compras.datos');



Route::post('/ordenes/cambiar-estatus', [OrdenesController::class, 'cambiarEstatus'])
    ->name('ordenes-compras.cambiar-estatus');
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
