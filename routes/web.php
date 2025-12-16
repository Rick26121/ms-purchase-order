<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrdenesController;
use App\Http\Controllers\ReportesController;
// ==========================================================
// GRUPO DE RUTAS PROTEGIDAS (REQUIEREN INICIO DE SESIÓN)
// ==========================================================
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    // --- RUTA RAÍZ AHORA PROTEGIDA ---
    Route::get('/', function () {
        return view('principal');
    })->name('principal');

    // --- RUTA DEL DASHBOARD DE JETSTREAM ---
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // ==========================================================
    // RUTAS PARA LA VISTA DE CREAR ORDEN
    // ==========================================================
    
    // Vista para crear orden
    Route::get('/ordenes/crear', [OrdenesController::class, 'inicio'])->name('ordenes.crear');
    
    // Menú de órdenes
    Route::get('/ordenes/menu', [OrdenesController::class, 'menu'])->name('ordenes.menu');
    
    // Vista para crear nueva orden (alternativa)
    Route::get('/ordenes/crear-vista', [OrdenesController::class, 'crear'])->name('ordenes.crear-vista');

    // ==========================================================
    // RUTAS PARA DATOS (AJAX/API)
    // ==========================================================
    
    // Obtener información de un proveedor
    Route::get('/ordenes/proveedor/{id}', [OrdenesController::class, 'getProveedor'])->name('ordenes.proveedor');

    // Búsqueda de proveedores
    Route::get('/ordenes/buscarProveedores', [OrdenesController::class, 'buscarProveedores']);
    
    // Búsqueda de sucursales
    Route::get('/ordenes/buscarSucursales', [OrdenesController::class, 'buscarSucursales']);
    
    // Obtener todas las sucursales
    Route::get('/consultar/sucursales', [OrdenesController::class, 'obtenerSucursales']);

    // ==========================================================
    // RUTAS PARA GUARDAR ÓRDENES (POST)
    // ==========================================================
    
    // Guardar Orden Completa (método tradicional)
    Route::post('/ordenes/guardar', [OrdenesController::class, 'guardar'])->name('ordenes.guardar');
    
    // Guardar Orden Completa (alternativa - usando el nuevo método)
    Route::post('/guardar-orden-completa', [OrdenesController::class, 'guardarOrdenCompleta'])->name('ordenes.guardar-completa');
    
    // Crear Orden Vacía (solo cabecera)
    Route::post('/crear-orden', [OrdenesController::class, 'crearOrden'])->name('ordenes.crear-vacia');
    
    // Agregar producto a orden existente
    Route::post('/agregar-producto-orden', [OrdenesController::class, 'agregarProductoOrden'])->name('ordenes.agregar-producto');
    
    // Actualizar producto de orden (NUEVA)
    Route::put('/actualizar-producto-orden', [OrdenesController::class, 'actualizarProductoOrden'])->name('ordenes.actualizar-producto');
    
    // Eliminar producto de orden
    Route::delete('/eliminar-producto-orden', [OrdenesController::class, 'eliminarProductoOrden'])->name('ordenes.eliminar-producto');
    
    // Cambiar estatus de la orden
    Route::post('/ordenes/cambiar-estatus', [OrdenesController::class, 'cambiarEstatus'])->name('ordenes.cambiar-estatus');

    // ==========================================================
    // RUTAS PARA CONSULTAR ÓRDENES (GET)
    // ==========================================================
    
    // Obtener detalles de una orden (JSON) - PARA EL MODAL
    Route::get('/ordenes/detalles/{id}', [OrdenesController::class, 'obtenerDetallesOrden'])
        ->where('id', '[0-9]+')
        ->name('ordenes.detalles');
    
    // Listado de todas las órdenes (JSON) - PARA LA TABLA PRINCIPAL
    Route::get('/ordenes-listado', [OrdenesController::class, 'index'])
        ->name('ordenes-compras.datos');
    
    // Buscar orden por parámetros (usando query string)
    Route::get('/ordenes/buscar-orden', [OrdenesController::class, 'buscarOrden'])
        ->name('ordenes.buscar-orden');
    
    // Filtrar órdenes
    Route::get('/ordenes-compras/filtrar/buscar', [OrdenesController::class, 'filtrar'])
        ->name('ordenes-compras.filtro');
    
    // Vista HTML de orden (PLANTILLA PARA IMPRIMIR)
    Route::get('/orden-compras/plantilla/{id}', [OrdenesController::class, 'obtenerOrdenPorId'])
        ->where('id', '[0-9]+')
        ->name('ordenes.plantilla');
    
    // ==========================================================
    // RUTAS PARA EDITAR/ELIMINAR
    // ==========================================================
    
    // Editar orden (redirección a formulario de edición)
    Route::get('/ordenes-compras/{id}/editar', function($id) {
        return redirect()->route('ordenes.crear')->with('editar_orden', $id);
    })->name('ordenes.editar');
    
    // Eliminar (ocultar) una orden
    Route::delete('/ordenes-compras/{id}', [OrdenesController::class, 'destroy'])
        ->where('id', '[0-9]+')
        ->name('ordenes.eliminar');

    // ==========================================================
    // RUTAS OBSOLETAS/DUPLICADAS QUE DEBES ELIMINAR
    // ==========================================================
    // Elimina estas rutas porque están duplicadas o no existen:
    // - '/ordenes/consulta/{id}' (duplicado)
    // - '/ordenes-compras/{id}' (no existe método show)
    // - '/orden/{id}' (duplicado)
    // - '/orden/{id}/detalles' (ya tenemos '/ordenes/detalles/{id}')

    


//responsable 
route::get('/responsable', [OrdenesController::class, 'obtenerResponsables'])->name('ordenes.responsable');
//tipofactura
route::get('/tipofactura', [OrdenesController::class, 'obtenertipof'])->name('ordenes.tipofactura');

route::post('/gestion-ordenes', [OrdenesController::class, 'gestion_ordenes'])->name('ordenes.gestion');
Route::get('/obtener-ordenes/{id}', [OrdenesController::class, 'updateconsulta'])->name('ordenes.obtenerupdate');

route::get('/reporte', [ReportesController::class, 'generarReporte'])->name('reportes.generar');



// actulizacion automaticas 
// En routes/api.php para API
Route::get('/actualizar-ordenes', [OrdenesController::class, 'actualizarOrdenesConTasaActual']);

// O si quieres poder enviar una tasa personalizada
Route::post('/actualizar-ordenes', [OrdenesController::class, 'actualizarOrdenesConTasaPersonalizada']);

// En routes/web.php para web
Route::get('/actualizar-ordenes', [OrdenesController::class, 'actualizarOrdenesConTasaActual']);


});
