<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrdenesController;
// use Illuminate\Support\Facades\Http; // Esta línea no es necesaria aquí, se usa dentro del controlador

// ==========================================================
// RUTA PÚBLICA (SOLO ACCESIBLE SIN INICIAR SESIÓN)
// Dejamos este espacio para cualquier ruta que DEBA ser pública,
// pero hemos movido la ruta '/' al grupo protegido.
// ==========================================================
// NOTA: La ruta '/' fue movida al grupo protegido más abajo.


// ==========================================================
// GRUPO DE RUTAS PROTEGIDAS (REQUIEREN INICIO DE SESIÓN)
// El 'auth:sanctum' es el middleware CLAVE.
// Si el usuario no tiene una sesión válida, será redirigido a /login.
// ==========================================================
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    // --- RUTA RAÍZ AHORA PROTEGIDA ---
    // Si el usuario no está logueado y es redirigido aquí, el middleware 'auth' lo enviará a /login.
    Route::get('/', function () {
        return view('principal');
    })->name('principal'); // Le asignamos un nombre si lo necesitas.

    // --- RUTA DEL DASHBOARD DE JETSTREAM ---
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // --- TUS RUTAS DE ÓRDENES DE COMPRA Y PROVEEDORES ---

    // Obtener información de un proveedor (ruta nombrada)
    Route::get('/ordenes/proveedor/{id}', [OrdenesController::class, 'getProveedor'])->name('ordenes.proveedor');

    // Opcional: búsqueda de proveedores
    Route::get('/ordenes/buscarProveedores', [OrdenesController::class, 'buscarProveedores']);
    
    // Proveedores
    Route::get('/consultar/sucursales', [OrdenesController::class, 'obtenerSucursales']);

    // Crear Orden
    Route::get('/ordenes/crear', [OrdenesController::class, 'inicio'])->name('ordenes.crear');
    
    // Guardar Orden (POST)
    Route::post('/ordenes/guardar', [OrdenesController::class, 'guardar'])->name('ordenes.guardar');
    
    // Listado menu
    Route::get('/ordenes/menu', [OrdenesController::class, 'menu'])->name('ordenes.menu');
    
    // Listado ordenes
    Route::get('/ordenes-compras/{id}', [OrdenesController::class, 'show'])->name('ordenes-compras.mostrarid');

    Route::get('/ordenes-compras/filtrar/buscar', [OrdenesController::class, 'filtrar'])->name('ordenes-compras.filtro');
    
    // Listado de datos de órdenes
    Route::get('/ordenes-listado', [OrdenesController::class, 'index'])->name('ordenes-compras.datos');

    // Cambiar estatus de la orden (POST)
    Route::post('/ordenes/cambiar-estatus', [OrdenesController::class, 'cambiarEstatus'])
        ->name('ordenes-compras.cambiar-estatus');
});
