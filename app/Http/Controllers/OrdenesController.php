<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proveedor;
use App\Models\Unidad;
use App\Models\MetodoP;
use App\Models\Sucursal;
use App\Models\OrdenCompra;
use App\Models\Responsable;
use App\Models\Tipofactura;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use App\Models\ExchangeRate;
use Illuminate\Support\Facades\Http;

class OrdenesController extends Controller
{
    public function inicio()
    {
        $proveedores = Proveedor::all();
        $unidades = Unidad::all(); 
        return view('orden_compra.create_orden', compact('proveedores', 'unidades'));
    }

    public function menu()
    {
        
        $unidades = Unidad::all(); 
        $metodos = metodoP::all();

        return view('orden_compra.menu', compact( 'unidades', 'metodos'));
    }

    public function crear()
    {
        return view('ordenes.crear');
    }

    /**
     * Buscar proveedores con autocomplete
     */
    public function buscarProveedores(Request $request): JsonResponse
    {
        $search = $request->get('search');
        
        $proveedores = Proveedor::where('nombre', 'LIKE', "%{$search}%")
            ->orWhere('rif', 'LIKE', "%{$search}%")
            ->limit(10)
            ->get(['id_proveedor', 'nombre', 'rif']);

        return response()->json($proveedores);
    }

    /**
     * Buscar sucursales con autocomplete
     */
    public function buscarSucursales(Request $request): JsonResponse
    {
        $search = $request->get('search');
        
        $sucursales = Sucursal::where('nombre', 'LIKE', "%{$search}%")
            ->limit(10)
            ->get(['id', 'nombre']);

        return response()->json($sucursales);
    }

    /**
     * Obtener información detallada de un proveedor
     */
    public function getProveedor($id): JsonResponse
    {
        try {
            $proveedor = Proveedor::find($id);

            if (!$proveedor) {
                return response()->json([
                    'success' => false,
                    'message' => 'Proveedor no encontrado'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'rif' => $proveedor->rif,
                    'telefono' => $proveedor->telefono,
                    'correo' => $proveedor->correo,
                    'direccion' => $proveedor->direccion,
                    'nombre' => $proveedor->nombre
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error al obtener proveedor: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error interno del servidor'
            ], 500);
        }
    }

    /**
     * Obtener todas las sucursales
     */
    public function obtenerSucursales(): JsonResponse
    {
        try {
            $sucursales = Sucursal::select('id', 'nombre', 'direccion', 'telefono')->get();

            return response()->json([
                'success' => true,
                'data' => $sucursales
            ]);

        } catch (\Exception $e) {
            Log::error('Error al obtener sucursales: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener sucursales'
            ], 500);
        }
    }

    /**
     * Crear una orden de compra (solo cabecera)
     */
    public function crearOrden(Request $request): JsonResponse
    {
        $userId = Auth::id();

        if (!$userId) {
            Log::error('Intento de crear orden sin usuario autenticado.');
            return response()->json([
                'success' => false,
                'message' => 'Error de autenticación. Debe iniciar sesión.'
            ], 401);
        }
        
        try {
            Log::info('Datos recibidos para crear orden:', $request->all());

            $validated = $request->validate([
                'id_sucursal' => 'required|integer|exists:sucursales,id',
                'proveedor_id' => 'required|integer|exists:proveedores,id_proveedor',
                'fecha' => 'required|date',
                'moneda' => 'required|in:usd,eur,bs',
                'tasa' => 'required|numeric|min:0',
                'aplicarIva' => 'required|boolean',
                'aplicarIvaDeduccion' => 'boolean' // 🔹 NUEVO CAMPO
            ]);

            Log::info('Datos validados para crear orden:', $validated);

            // Determinar tipo de IVA
            $aplicarIva = $validated['aplicarIva'] ? 1 : 0;
            $aplicarIvaDeduccion = isset($validated['aplicarIvaDeduccion']) ? ($validated['aplicarIvaDeduccion'] ? 1 : 0) : 0;

            // Crear orden inicial (sin productos todavía)
            $datosOrden = [
                'sucursal' => $validated['id_sucursal'],
                'proveedores' => $validated['proveedor_id'],
                'totalGeneral' => 0, // Inicial en 0
                'tasa_dia' => $validated['tasa'],
                'moneda' => $validated['moneda'],
                'iva' => $aplicarIva, // Solo 0 o 1
                'iva_deduccion' => $aplicarIvaDeduccion, // 🔹 NUEVO: 1 si es con deducción
                'totalbs' => 0, // Inicial en 0
                'usuario' => $userId,
               // 'fecha_orden' => $validated['fecha'],
                'estatus' => 'pendiente',
                'visible' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ];

            $ordenId = DB::table('ordenes_compras')->insertGetId($datosOrden);

            Log::info("Orden creada exitosamente ID: {$ordenId} - Sin productos aún. IVA Deducción: {$aplicarIvaDeduccion}");

            return response()->json([
                'success' => true,
                'message' => 'Orden de compra creada correctamente. Ahora puede agregar productos.',
                'orden_id' => $ordenId,
                'data' => $datosOrden
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Error de validación en crear orden: ' . json_encode($e->errors()));
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
            
        } catch (\Exception $e) {
            Log::error('Error en crear orden: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'Error interno: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Agregar producto a una orden existente
     */
    public function agregarProductoOrden(Request $request): JsonResponse
    {
        $userId = Auth::id();

        if (!$userId) {
            return response()->json([
                'success' => false,
                'message' => 'Error de autenticación'
            ], 401);
        }
        
        try {
            Log::info('Datos recibidos para agregar producto:', $request->all());

            $validated = $request->validate([
                'orden_id' => 'required|integer|exists:ordenes_compras,id',
                'producto' => 'required|string|max:255',
                'cantidad' => 'required|numeric|min:1',
                'precio' => 'required|numeric|min:0',
                'id_unidad' => 'required|integer|exists:unidades,id_unidad'
            ]);

            // Verificar que la orden exista y esté en estatus pendiente
            $orden = DB::table('ordenes_compras')
                ->where('id', $validated['orden_id'])
                ->where('estatus', 'pendiente')
                ->first();

            if (!$orden) {
                return response()->json([
                    'success' => false,
                    'message' => 'Orden no encontrada o no está en estado pendiente'
                ], 404);
            }

            // Buscar o crear el producto
            $productoExistente = DB::table('productos')
                ->where('nombre', $validated['producto'])
                ->first();

            if ($productoExistente) {
                // Actualizar precio si existe
                DB::table('productos')
                    ->where('id', $productoExistente->id)
                    ->update([
                        'precio' => $validated['precio'],
                        'updated_at' => now()
                    ]);
                $productoId = $productoExistente->id;
            } else {
                // Crear nuevo producto
                $productoId = DB::table('productos')->insertGetId([
                    'nombre' => $validated['producto'],
                    'precio' => $validated['precio'],
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            // Insertar en detalles_o
            DB::table('detalles_o')->insert([
                'ordenes' => $validated['orden_id'],
                'producto' => $productoId,
                'unidad' => $validated['id_unidad'],
                'cantidad' => $validated['cantidad'],
                'precio' => $validated['precio']
                
            ]);

            // Recalcular totales de la orden (con el nuevo campo iva_deduccion)
            $this->recalcularOrden($validated['orden_id']);

            Log::info("Producto agregado exitosamente a orden ID: {$validated['orden_id']}");

            return response()->json([
                'success' => true,
                'message' => 'Producto agregado correctamente a la orden',
                'orden_id' => $validated['orden_id'],
                'producto_id' => $productoId,
                'detalle' => [
                    'producto' => $validated['producto'],
                    'cantidad' => $validated['cantidad'],
                    'precio' => $validated['precio'],
                    'subtotal' => $validated['cantidad'] * $validated['precio']
                ]
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Error de validación en agregar producto: ' . json_encode($e->errors()));
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
            
        } catch (\Exception $e) {
            Log::error('Error en agregar producto: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'Error interno: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Recalcular totales de una orden (actualizado para manejar iva_deduccion)
     */
    private function recalcularOrden($ordenId)
    {
        try {
            // Obtener todos los detalles de la orden
            $detalles = DB::table('detalles_o as d')
                ->join('productos as p', 'd.producto', '=', 'p.id')
                ->where('d.ordenes', $ordenId)
                ->select('d.cantidad', 'd.precio', 'p.precio as precio_actual')
                ->get();

            // Calcular total general
            $totalGeneral = 0;
            foreach ($detalles as $detalle) {
                $totalGeneral += $detalle->cantidad * $detalle->precio;
            }

            // Obtener datos de la orden para cálculos
            $orden = DB::table('ordenes_compras')->where('id', $ordenId)->first();
            
            if (!$orden) {
                return false;
            }

            // 🔹 CÁLCULOS ACTUALIZADOS: Manejar IVA normal vs IVA con deducción
            $totalConIva = $totalGeneral; // Inicializar
            
            if ($orden->iva == 1 && $orden->iva_deduccion == 0) {
                // IVA Normal (16%)
                $ivaPorcentaje = 0.16;
                $montoIva = $totalGeneral * $ivaPorcentaje;
                $totalConIva = $totalGeneral + $montoIva;
                
            } elseif ($orden->iva == 0 && $orden->iva_deduccion == 1) {
                // 🔹 NUEVO: IVA con Deducción (16% - 75%)
                // 1. Calcular IVA normal (16%)
                $ivaNormal = $totalGeneral * 0.16;
                
                // 2. Calcular deducción (75% del IVA)
                $montoDeduccion = $ivaNormal * 0.75;
                
                // 3. Calcular IVA neto (IVA normal - deducción)
                $montoIva = $ivaNormal - $montoDeduccion;
                
                // 4. Calcular total con IVA neto
                $totalConIva = $totalGeneral + $montoIva;
                
            } else {
                // Sin IVA
                $montoIva = 0;
                $totalConIva = $totalGeneral;
            }

            // Calcular total en Bs
            $totalBs = $totalConIva * $orden->tasa_dia;

            // Actualizar la orden con los nuevos totales
            DB::table('ordenes_compras')
                ->where('id', $ordenId)
                ->update([
                    'totalGeneral' => $totalGeneral,
                    'totalbs' => $totalBs,
                    'updated_at' => now()
                ]);

            Log::info("Orden ID: {$ordenId} recalculada. Total General: {$totalGeneral}, Total Bs: {$totalBs}, IVA Deducción: {$orden->iva_deduccion}");

            return true;

        } catch (\Exception $e) {
            Log::error('Error al recalcular orden: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Guardar orden completa (con todos los productos a la vez) - ACTUALIZADO
     */
        public function guardarOrdenCompleta(Request $request): JsonResponse
{
    $userId = Auth::id();

    if (!$userId) {
        return response()->json([
            'success' => false,
            'message' => 'Error de autenticación'
        ], 401);
    }
    
    try {
        Log::info('Datos recibidos para orden completa:', $request->all());

        // 🔹 VALIDACIÓN - modo_calculo SOLO para el cálculo
        $validated = $request->validate([
            'id_sucursal' => 'required|integer|exists:sucursales,id',
            'proveedor_id' => 'required|integer|exists:proveedores,id_proveedor',
            'fecha' => 'required|date',
            'moneda' => 'required|in:usd,eur,bs',
            'tasa' => 'required|numeric|min:0',
            'aplicarIva' => 'required|boolean',
            'aplicarIvaDeduccion' => 'boolean',
            'modo_calculo' => 'required|integer|in:0,1', // 🔹 SOLO para cálculo interno
            'observacion' => 'nullable|string|max:500',
            'productos' => 'required|array|min:1',
            'productos.*.producto' => 'required|string|max:255',
            'productos.*.cantidad' => 'required|numeric|min:0.01',
            'productos.*.precio' => 'required|numeric|min:0',
            'productos.*.id_unidad' => 'required|integer|exists:unidades,id_unidad'
        ]);

        // Variables básicas
        $aplicarIva = $validated['aplicarIva'] ? 1 : 0;
        $aplicarIvaDeduccion = isset($validated['aplicarIvaDeduccion']) ? ($validated['aplicarIvaDeduccion'] ? 1 : 0) : 0;
        $observacion = $validated['observacion'] ?? null;
        $modoCalculo = $validated['modo_calculo']; // 0 o 1 - SOLO para cálculo
        $tasa = $validated['tasa'];
        
        // 🔹 PASO 1: CALCULAR TOTALES SEGÚN MODO (USANDO modo_calculo)
        $totalGeneral = 0; // En DÓLARES siempre
        
        foreach ($validated['productos'] as $itemProducto) {
            $precio = $itemProducto['precio'];
            $cantidad = $itemProducto['cantidad'];
            
            if ($modoCalculo == 0) {
                // 🔹 MODO 0: USD → BS (precio viene en dólares)
                // Subtotal en dólares = precio (USD) × cantidad
                $subtotalDolares = $precio * $cantidad;
                $totalGeneral += $subtotalDolares;
                
            } else {
                // 🔹 MODO 1: Directo BS (precio viene en bolívares)
                // Convertir precio BS a USD: precio / tasa
                $precioEnDolares = $precio / $tasa;
                $subtotalDolares = $precioEnDolares * $cantidad;
                $totalGeneral += $subtotalDolares;
            }
        }

        // 🔹 PASO 2: CALCULAR IVA
        $totalConIva = $totalGeneral;
        $montoIva = 0;
        
        if ($aplicarIva == 1 && $aplicarIvaDeduccion == 0) {
            // IVA Normal (16%)
            $montoIva = $totalGeneral * 0.16;
            $totalConIva = $totalGeneral + $montoIva;
            
        } elseif ($aplicarIva == 0 && $aplicarIvaDeduccion == 1) {
            // IVA con Deducción (16% - 75%)
            $ivaNormal = $totalGeneral * 0.16;
            $montoDeduccion = $ivaNormal * 0.75;
            $montoIva = $ivaNormal - $montoDeduccion;
            $totalConIva = $totalGeneral + $montoIva;
        }

        // 🔹 PASO 3: CALCULAR TOTAL EN BOLÍVARES
        $totalBs = $totalConIva * $tasa;

        // 🔹 LOG de cálculo
        Log::info('Cálculo realizado', [
            'modo_usado' => $modoCalculo,
            'total_dolares' => $totalGeneral,
            'total_con_iva_dolares' => $totalConIva,
            'total_bolivares' => $totalBs,
            'tasa' => $tasa
        ]);

        // 🔹 PASO 4: CREAR ORDEN EN BD - SIN GUARDAR modo_calculo
        $datosOrden = [
            'sucursal' => $validated['id_sucursal'],
            'proveedores' => $validated['proveedor_id'],
            'totalGeneral' => $totalGeneral, // En dólares
            'tasa_dia' => $tasa,
            'moneda' => $validated['moneda'],
            'iva' => $aplicarIva,
            'iva_deduccion' => $aplicarIvaDeduccion,
            'totalbs' => $totalBs, // En bolívares
            'usuario' => $userId,
            'observacion' => $observacion,
            'estatus' => '0',
            'visible' => 1,
            // 🔹 NO se guarda modo_calculo en BD
            'created_at' => now(),
            'updated_at' => now()
        ];

        $ordenId = DB::table('ordenes_compras')->insertGetId($datosOrden);

        // 🔹 PASO 5: PROCESAR PRODUCTOS
        $detallesInsertados = [];
        
        foreach ($validated['productos'] as $itemProducto) {
            $precioUsuario = $itemProducto['precio'];
            $cantidad = $itemProducto['cantidad'];
            
            // 🔹 Determinar qué precio guardar en BD
            // SIEMPRE guardamos precio en DÓLARES en la BD
            $precioParaBD = $precioUsuario; // Por defecto
            
            if ($modoCalculo == 1) {
                // Si modo es 1, el precio viene en bolívares
                // Convertir a dólares para guardar en BD
                $precioParaBD = $precioUsuario / $tasa;
            }
            
            // Buscar o crear producto
            $productoExistente = DB::table('productos')
                ->where('nombre', $itemProducto['producto'])
                ->first();

            if ($productoExistente) {
                $productoId = $productoExistente->id;
                DB::table('productos')
                    ->where('id', $productoId)
                    ->update([
                        'precio' => $precioParaBD, // Guardar en dólares
                        'updated_at' => now()
                    ]);
            } else {
                $productoId = DB::table('productos')->insertGetId([
                    'nombre' => $itemProducto['producto'],
                    'precio' => $precioParaBD, // Guardar en dólares
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            // Insertar detalle - precio SIEMPRE en dólares
            DB::table('detalles_o')->insert([
                'ordenes' => $ordenId,
                'producto' => $productoId,
                'unidad' => $itemProducto['id_unidad'],
                'cantidad' => $cantidad,
                'precio' => $precioParaBD, // 🔹 SIEMPRE en dólares
                
            ]);

            // Calcular subtotal para respuesta
            if ($modoCalculo == 0) {
                $subtotalDolares = $cantidad * $precioUsuario;
                $subtotalBs = $subtotalDolares * $tasa;
            } else {
                $subtotalBs = $cantidad * $precioUsuario;
                $subtotalDolares = $subtotalBs / $tasa;
            }

            $detallesInsertados[] = [
                'producto_id' => $productoId,
                'nombre' => $itemProducto['producto'],
                'cantidad' => $cantidad,
                'precio_usuario' => $precioUsuario,
                'precio_bd' => $precioParaBD,
                'subtotal_dolares' => $subtotalDolares,
                'subtotal_bs' => $subtotalBs
            ];
        }

        Log::info("Orden guardada ID: {$ordenId} - Total BS: {$totalBs}");

        return response()->json([
            'success' => true,
            'message' => 'Orden de compra guardada correctamente',
            'orden_id' => $ordenId,
            'usuario_id' => $userId,
            // 🔹 Devolver modo_calculo usado (solo para referencia frontend)
            'modo_calculo_usado' => $modoCalculo,
            'total_general' => $totalGeneral,
            'total_con_iva' => $totalConIva,
            'total_bs' => $totalBs,
            'monto_iva' => $montoIva,
            'iva_deduccion' => $aplicarIvaDeduccion,
            'productos' => $detallesInsertados
        ]);

    } catch (\Illuminate\Validation\ValidationException $e) {
        Log::error('Error de validación: ' . json_encode($e->errors()));
        return response()->json([
            'success' => false,
            'message' => 'Error de validación',
            'errors' => $e->errors()
        ], 422);
        
    } catch (\Exception $e) {
        Log::error('Error interno: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Error interno: ' . $e->getMessage()
        ], 500);
    }
}
    /**
     * Obtener detalles de una orden
     */
    public function obtenerDetallesOrden($ordenId): JsonResponse
    {
        try {
            Log::info("Obteniendo detalles de orden ID: {$ordenId}");

            // Obtener la orden
            $orden = DB::table('ordenes_compras as oc')
                ->leftJoin('responsable as r', 'oc.responsable', '=', 'r.id')
                ->leftJoin('sucursales as s', 'oc.sucursal', '=', 's.id')
                ->leftJoin('proveedores as p', 'oc.proveedores', '=', 'p.id_proveedor')
                ->leftJoin('users as u', 'oc.usuario', '=', 'u.id')
                ->where('oc.id', $ordenId)
                ->select([
                    'oc.*',
                    'r.nombre as responsable_nombre',
                    's.nombre as sucursal_nombre',
                    's.direccion as sucursal_direccion',
                    's.telefono as sucursal_telefono',
                    'p.nombre as proveedor_nombre',
                    'p.rif as proveedor_rif',
                    'p.telefono as proveedor_telefono',
                    'p.correo as proveedor_correo',
                    'p.direccion as proveedor_direccion',
                    'u.name as usuario_nombre'
                ])
                ->first();

            if (!$orden) {
                return response()->json([
                    'success' => false,
                    'message' => 'Orden no encontrada'
                ], 404);
            }

            // Obtener productos de la orden
            $productos = DB::table('detalles_o as d')
                ->join('productos as p', 'd.producto', '=', 'p.id')
                ->join('unidades as u', 'd.unidad', '=', 'u.id_unidad')
                ->where('d.ordenes', $ordenId)
                ->select([
                    'd.id as detalle_id',
                    'd.cantidad',
                    'd.precio',
                    'p.id as producto_id',
                    'p.nombre as producto_nombre',
                    'u.id_unidad',
                    'u.abreviatura as unidad_abreviatura',
                    'u.nombre as unidad_nombre',
                    DB::raw('(d.cantidad * d.precio) as subtotal')
                ])
                ->get();

            // 🔹 ACTUALIZADO: Calcular IVA según tipo (normal o con deducción)
            $totalGeneral = (float) $orden->totalGeneral;
            $aplicaIVA = (bool) $orden->iva;
            $aplicaIvaDeduccion = (bool) $orden->iva_deduccion; // 🔹 NUEVO
            
            $montoIva = 0;
            $totalConIva = $totalGeneral;
            
            if ($aplicaIVA && !$aplicaIvaDeduccion) {
                // IVA Normal (16%)
                $montoIva = $totalGeneral * 0.16;
                $totalConIva = $totalGeneral + $montoIva;
                
            } elseif (!$aplicaIVA && $aplicaIvaDeduccion) {
                // IVA con Deducción (16% - 75%)
                $ivaNormal = $totalGeneral * 0.16;
                $montoDeduccion = $ivaNormal * 0.75;
                $montoIva = $ivaNormal - $montoDeduccion;
                $totalConIva = $totalGeneral + $montoIva;
            }

            $response = [
                'orden' => $orden,
                'productos' => $productos,
                'calculos' => [
                    'total_general' => $totalGeneral,
                    'aplica_iva' => $aplicaIVA,
                    'iva_deduccion' => $aplicaIvaDeduccion, // 🔹 NUEVO
                    'monto_iva' => $montoIva,
                    'total_con_iva' => $totalConIva,
                    'total_bs' => (float) $orden->totalbs,
                    'tasa_dia' => (float) $orden->tasa_dia
                ]
            ];

            return response()->json([
                'success' => true,
                'data' => $response,
                'message' => 'Detalles de orden obtenidos correctamente'
            ]);

        } catch (\Exception $e) {
            Log::error('Error al obtener detalles de orden: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error interno: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener orden por ID para plantilla (actualizado para manejar iva_deduccion)
     */
public function obtenerOrdenPorId($id)
{
    try {
       

        // Validar ID
        if (!is_numeric($id) || $id <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'ID de orden inválido',
                'data' => null
            ], 400);
        }

        // Obtener la orden con todos los detalles en una sola consulta optimizada
        $ordenCompleta = DB::select("
            SELECT DISTINCT
                o.id AS orden_id,
                o.totalGeneral,
                o.iva,
                o.iva_deduccion, -- 🔹 NUEVO: Campo agregado
                o.tasa_dia,
                o.totalbs,
                o.moneda,
                o.observacion, -- 🔹 AQUÍ ESTÁ EL CAMPO
                o.estatus,
                o.created_at,
                re.nombre as Responsable,
                DATE(o.created_at) AS fecha,
                -- Sucursal
                s.id AS sucursal_id,
                s.nombre AS sucursal_nombre,
                s.direccion AS sucursal_direccion,
                s.telefono AS sucursal_telefono,
                -- Proveedor
                p.id_proveedor AS proveedor_id,
                p.nombre AS proveedor_nombre,
                p.rif AS proveedor_rif,
                p.direccion AS proveedor_direccion,
                p.telefono AS proveedor_telefono,
                p.correo AS proveedor_correo,
                -- Información de bancos y pago móvil
                b.pagomovil AS pago_movil,
                b.bancos1 AS banco_1,
                b.bancos2 AS banco_2,
                -- Usuario
                u.id AS usuario_id,
                u.name AS usuario_nombre,
                -- Producto
                pr.id AS producto_id,
                pr.nombre AS producto_nombre,
                -- Unidad
                un.id_unidad AS unidad_id,
                un.abreviatura AS unidad_abreviatura,
                un.nombre AS unidad_nombre,
                -- Detalles
                d.id AS detalle_id,
                d.cantidad,
                d.precio,
                (d.cantidad * d.precio) AS subtotal_producto
            FROM ordenes_compras o
            inner join responsable re ON o.responsable = re.id
            INNER JOIN detalles_o d ON o.id = d.ordenes
            LEFT JOIN sucursales s ON o.sucursal = s.id
            LEFT JOIN proveedores p ON o.proveedores = p.id_proveedor
            LEFT JOIN productos pr ON d.producto = pr.id
            LEFT JOIN unidades un ON d.unidad = un.id_unidad
            LEFT JOIN users u ON o.usuario = u.id
            LEFT JOIN bancos b ON b.id_proveedor = p.id_proveedor
            WHERE o.id = ? and o.visible = 1
            ORDER BY o.id DESC, d.id;
        ", [$id]);

        // Verificar si se encontró la orden
        if (empty($ordenCompleta)) {
            return response()->json([
                'success' => false,
                'message' => 'Orden de compra no encontrada',
                'data' => null
            ], 404);
        }

        // Extraer información de la orden (primer registro)
        $primerRegistro = $ordenCompleta[0];
        
        // Calcular datos para la plantilla (actualizado para manejar iva_deduccion)
        $totalGeneral = (float) $primerRegistro->totalGeneral;
        $aplicaIVA = (bool) $primerRegistro->iva;
        $aplicaIvaDeduccion = (bool) $primerRegistro->iva_deduccion; // 🔹 NUEVO
        
        $montoIva = 0;
        $totalConIva = $totalGeneral;
        
        if ($aplicaIVA && !$aplicaIvaDeduccion) {
            // IVA Normal (16%)
            $montoIva = $totalGeneral * 0.16;
            $totalConIva = $totalGeneral + $montoIva;
            
        } elseif (!$aplicaIVA && $aplicaIvaDeduccion) {
            // IVA con Deducción (16% - 75%)
            $ivaNormal = $totalGeneral * 0.16;
            $montoDeduccion = $ivaNormal * 0.75;
            $montoIva = $ivaNormal - $montoDeduccion;
            $totalConIva = $totalGeneral + $montoIva;
        }
        
        // 🔹 OBTENER TASA CON 4 DECIMALES DIRECTAMENTE DE LA BASE DE DATOS
        $tasaDia = round((float) $primerRegistro->tasa_dia, 4);
        $totalBS = (float) $primerRegistro->totalbs;
        $fechaOrden = Carbon::parse($primerRegistro->created_at)->format('d/m/Y');
        
        // Calcular subtotal de productos
        $subtotalProductos = 0;
        foreach ($ordenCompleta as $item) {
            $subtotalProductos += (float) $item->subtotal_producto;
        }

        // Preparar información de bancos
        $bancos = [];
        if ($primerRegistro->banco_1) {
            $bancos[] = $primerRegistro->banco_1;
        }
        if ($primerRegistro->banco_2) {
            $bancos[] = $primerRegistro->banco_2;
        }

        // Preparar productos
        $productos = array_map(function($item) {
            return (object) [
                'detalle_id' => $item->detalle_id,
                'cantidad' => $item->cantidad,
                'precio' => $item->precio,
                'producto_id' => $item->producto_id,
                'producto_nombre' => $item->producto_nombre,
                'unidad_abreviatura' => $item->unidad_abreviatura,
                'unidad_nombre' => $item->unidad_nombre,
                'subtotal' => $item->subtotal_producto
            ];
        }, $ordenCompleta);

        // 🔹 PREPARAR DATOS PARA LA VISTA - AGREGADO OBSERVACION
        $viewData = [
            'orden' => (object) [
                'id' => $primerRegistro->orden_id,
                'totalGeneral' => $totalGeneral,
                'tasa_dia' => $tasaDia, // 🔹 YA TIENE 4 DECIMALES
                'moneda' => $primerRegistro->moneda,
                'iva' => $montoIva,
                'iva_deduccion' => $aplicaIvaDeduccion,
                'totalbs' => $totalBS,
                'observacion' => $primerRegistro->observacion, // 🔹 AQUÍ SE AGREGA
                'fecha_orden' => $primerRegistro->created_at,
                'estatus' => $primerRegistro->estatus,
                'created_at' => $primerRegistro->created_at,
                'responsable' => $primerRegistro->Responsable,
                
                'sucursal' => (object) [
                    'id' => $primerRegistro->sucursal_id,
                    'nombre' => $primerRegistro->sucursal_nombre,
                    'direccion' => $primerRegistro->sucursal_direccion,
                    'telefono' => $primerRegistro->sucursal_telefono,
                ],
                
                'proveedor' => (object) [
                    'id' => $primerRegistro->proveedor_id,
                    'nombre' => $primerRegistro->proveedor_nombre,
                    'rif' => $primerRegistro->proveedor_rif,
                    'direccion' => $primerRegistro->proveedor_direccion,
                    'telefono' => $primerRegistro->proveedor_telefono,
                    'correo' => $primerRegistro->proveedor_correo,
                ],
                
                'usuario' => (object) [
                    'id' => $primerRegistro->usuario_id ?? 0,
                    'name' => $primerRegistro->usuario_nombre ?? 'Sistema',
                ],
                
                // Agregar información de bancos y pago móvil
                'bancos_info' => (object) [
                    'pago_movil' => $primerRegistro->pago_movil ?? null,
                    'banco_1' => $primerRegistro->banco_1 ?? null,
                    'banco_2' => $primerRegistro->banco_2 ?? null,
                    'titular' => $primerRegistro->titular_banco ?? null,
                    'cedula' => $primerRegistro->cedula_titular ?? null,
                    'telefono' => $primerRegistro->telefono_banco ?? null,
                    'lista_bancos' => $bancos,
                ],
            ],
            
            'productos' => $productos,
            
            'calculos' => [
                'numeroOrden' => $primerRegistro->orden_id,
                'fechaEmision' => $fechaOrden,
                'fechaOriginal' => $primerRegistro->created_at,
                'tasa' => number_format($tasaDia, 4, ',', '.'), // 🔹 4 DECIMALES CON FORMATO
                'tasa_numero' => $tasaDia, // 🔹 AGREGADO: Tasa como número para cálculos
                'subtotalProductos' => number_format($subtotalProductos, 4, ',', '.'), // CAMBIADO A 4 DECIMALES
                'subtotal' => number_format($totalGeneral - $montoIva, 4, ',', '.'), // CAMBIADO A 4 DECIMALES
                'iva' => number_format($montoIva, 4, ',', '.'), // CAMBIADO A 4 DECIMALES
                'iva_porcentaje' => $aplicaIVA ? 16 : ($aplicaIvaDeduccion ? 4 : 0),
                'totalUSD' => number_format($totalConIva, 4, ',', '.'), // CAMBIADO A 4 DECIMALES
                'totalBS' => number_format($totalBS, 4, ',', '.'), // CAMBIADO A 4 DECIMALES
                'aplicaIVA' => $aplicaIVA,
                'aplicaIvaDeduccion' => $aplicaIvaDeduccion,
                'observacion' => $primerRegistro->observacion ?? '',
                'totalGeneral' => number_format($totalGeneral, 4, ',', '.'), // AGREGADO CON 4 DECIMALES
                'montoIva' => number_format($montoIva, 4, ',', '.'), // AGREGADO CON 4 DECIMALES
            ],
        ];

        Log::info("Datos preparados para plantilla ID: {$id} - IVA Deducción: {$aplicaIvaDeduccion} - Observación: " . ($primerRegistro->observacion ? 'Sí' : 'No') . " - Tasa: {$tasaDia}");

        // Retornar la vista con los datos
        return view('plantilla.orden', $viewData);

    } catch (\Exception $e) {
        Log::error('Error al obtener orden para plantilla: ' . $e->getMessage());
        Log::error('Stack trace: ' . $e->getTraceAsString());
        
        return view('errors.orden', [
            'error' => 'Error al cargar la orden: ' . $e->getMessage(),
            'ordenId' => $id
        ]);
    }
}

    /**
     * Buscar orden por ID
     */
    public function buscarOrden(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'orden_id' => 'required|integer|min:1'
            ]);

            $ordenId = $request->input('orden_id');
            
            Log::info("Buscando orden por ID: {$ordenId}");

            $orden = DB::table('ordenes_compras as oc')
                ->leftJoin('sucursales as s', 'oc.sucursal', '=', 's.id')
                ->leftJoin('proveedores as p', 'oc.proveedores', '=', 'p.id_proveedor')
                ->leftJoin('users as u', 'oc.usuario', '=', 'u.id')
                ->where('oc.id', $ordenId)
                ->select([
                    'oc.*',
                    's.nombre as sucursal_nombre',
                    'p.nombre as proveedor_nombre',
                    'p.rif as proveedor_rif',
                    'u.name as usuario_nombre'
                ])
                ->first();

            if (!$orden) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se encontró ninguna orden con el ID ' . $ordenId,
                    'data' => null
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Orden encontrada',
                'data' => $orden
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors(),
                'data' => null
            ], 422);
            
        } catch (\Exception $e) {
            Log::error('Error en buscarOrden: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error interno: ' . $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    /**
     * Obtener todas las órdenes
     */
    public function index(): JsonResponse
    {
        try {
            $ordenes = DB::table('ordenes_compras as oc')
                ->leftJoin('sucursales as s', 'oc.sucursal', '=', 's.id')
                ->leftJoin('proveedores as p', 'oc.proveedores', '=', 'p.id_proveedor')
                ->select([
                    'oc.id as "N° Control"',
                    's.nombre as "Sucursal"',
                    'p.nombre as "Proveedor"',
                    'oc.tasa_dia',
                    'oc.iva',
                    'oc.iva_deduccion', // 🔹 NUEVO: Mostrar en la lista
                    'oc.totalbs',
                    'oc.totalGeneral',
                    'oc.created_at as "Fecha Creacion"',
                    'oc.estatus'
                ])
                ->where('oc.visible', 1)
                ->orderBy('oc.id', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $ordenes,
                'message' => 'Órdenes de compra obtenidas correctamente',
                'count' => $ordenes->count()
            ]);

        } catch (\Exception $e) {
            Log::error('Error en index ordenes: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener las órdenes de compra: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Cambiar estatus de una orden
     */
    public function cambiarEstatus(Request $request): JsonResponse
    {
        Log::info('📥 Request recibido para cambiar estatus', $request->all());

        try {
            $request->validate([
                'id' => 'required|integer|exists:ordenes_compras,id',
                'estatus' => 'required|string|in:pendiente,aprobado,rechazado,procesado,completado'
            ]);

            $ordenId = $request->id;
            $nuevoEstatus = $request->estatus;

            Log::info("Buscando orden ID: {$ordenId}");

            $orden = DB::table('ordenes_compras')->where('id', $ordenId)->first();
            
            if (!$orden) {
                Log::warning("Orden no encontrada ID: {$ordenId}");
                return response()->json([
                    'success' => false,
                    'message' => 'Orden de compra no encontrada'
                ], 404);
            }

            $estatusAnterior = $orden->estatus;
            
            Log::info("Orden encontrada. Estatus actual: {$estatusAnterior}, Nuevo estatus: {$nuevoEstatus}");

            // Actualizar el estatus
            DB::table('ordenes_compras')
                ->where('id', $ordenId)
                ->update([
                    'estatus' => $nuevoEstatus,
                    'updated_at' => now()
                ]);

            Log::info("  Estatus actualizado correctamente para orden ID: {$ordenId}");

            return response()->json([
                'success' => true,
                'message' => 'Estatus actualizado correctamente',
                'data' => [
                    'id' => $ordenId,
                    'estatus_anterior' => $estatusAnterior,
                    'nuevo_estatus' => $nuevoEstatus,
                    'fecha_actualizacion' => now()
                ]
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
            
        } catch (\Exception $e) {
            Log::error('  Error al cambiar estatus: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error interno: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Eliminar (ocultar) una orden
     */
    public function destroy($id): JsonResponse
    {
        try {
            $orden = DB::table('ordenes_compras')->where('id', $id)->first();

            if (!$orden) {
                return response()->json([
                    'success' => false,
                    'message' => 'Orden de compra no encontrada'
                ], 404);
            }

            // Marcamos como no visible
            DB::table('ordenes_compras')
                ->where('id', $id)
                ->update(['visible' => 0, 'updated_at' => now()]);

            return response()->json([
                'success' => true,
                'message' => 'Orden de compra eliminada correctamente'
            ]);

        } catch (\Exception $e) {
            Log::error('Error al eliminar orden: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar la orden de compra: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Eliminar un producto de una orden
     */
    public function eliminarProductoOrden(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'orden_id' => 'required|string|max:20'
            ]);

            $ordenCodigo = $request->orden_id; // Código como "CZ000046"
            
            // Extraer el ID numérico del código
            $ordenId = intval(preg_replace('/[^0-9]/', '', $ordenCodigo));
            
            if ($ordenId <= 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'ID de orden inválido'
                ], 400);
            }

            // Verificar que la orden existe
            $orden = DB::table('ordenes_compras')
                ->where('id', $ordenId)
                ->first();

            if (!$orden) {
                return response()->json([
                    'success' => false,
                    'message' => 'La orden no existe'
                ], 404);
            }

            // Verificar si ya está eliminada lógicamente
            if (isset($orden->visible) && $orden->visible == 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'La orden ya está eliminada'
                ], 400);
            }

            // Eliminación lógica: actualizar columna visible a 0
            $actualizado = DB::table('ordenes_compras')
                ->where('id', $ordenId)
                ->update(['visible' => 0]);

            if (!$actualizado) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se pudo actualizar la orden'
                ], 500);
            }

            return response()->json([
                'success' => true,
                'message' => 'Orden eliminada lógicamente correctamente',
                'orden_id' => $ordenId,
                'orden_codigo' => $ordenCodigo
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
            
        } catch (\Exception $e) {
            Log::error('Error al eliminar orden: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error interno: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualizar un producto de una orden
     */
    public function actualizarProductoOrden(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'orden_id' => 'required|integer|exists:ordenes_compras,id',
                'detalle_id' => 'required|integer|exists:detalles_o,id',
                'producto' => 'required|string|max:255',
                'cantidad' => 'required|numeric|min:1',
                'precio' => 'required|numeric|min:0',
                'id_unidad' => 'required|integer|exists:unidades,id_unidad'
            ]);

            // Verificar que el detalle pertenezca a la orden
            $detalle = DB::table('detalles_o')
                ->where('id', $validated['detalle_id'])
                ->where('ordenes', $validated['orden_id'])
                ->first();

            if (!$detalle) {
                return response()->json([
                    'success' => false,
                    'message' => 'El detalle no pertenece a la orden especificada'
                ], 404);
            }

            // Buscar o crear producto
            $productoExistente = DB::table('productos')
                ->where('nombre', $validated['producto'])
                ->first();

            if ($productoExistente) {
                DB::table('productos')
                    ->where('id', $productoExistente->id)
                    ->update([
                        'precio' => $validated['precio'],
                        'updated_at' => now()
                    ]);
                $productoId = $productoExistente->id;
            } else {
                $productoId = DB::table('productos')->insertGetId([
                    'nombre' => $validated['producto'],
                    'precio' => $validated['precio'],
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            // Actualizar el detalle
            DB::table('detalles_o')
                ->where('id', $validated['detalle_id'])
                ->update([
                    'producto' => $productoId,
                    'unidad' => $validated['id_unidad'],
                    'cantidad' => $validated['cantidad'],
                    'precio' => $validated['precio'],
                    
                ]);

            // Recalcular la orden
            $this->recalcularOrden($validated['orden_id']);

            return response()->json([
                'success' => true,
                'message' => 'Producto actualizado correctamente',
                'orden_id' => $validated['orden_id']
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
            
        } catch (\Exception $e) {
            Log::error('Error al actualizar producto de orden: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error interno: ' . $e->getMessage()
            ], 500);
        }
    }

    public function obtenerResponsables(): JsonResponse
    {
        try {
            $responsables = Responsable::all();

            return response()->json([
                'success' => true,
                'data' => $responsables,
            ]);

        } catch (\Exception $e) {
            Log::error('Error al obtener responsables: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener los responsables: ' . $e->getMessage()
            ], 500);
        }
    }

    public function obtenertipof(): JsonResponse
    {
        try {
            $responsables = tipoFactura::all();

            return response()->json([
                'success' => true,
                'data' => $responsables,
            ]);

        } catch (\Exception $e) {
            Log::error('Error al obtener responsables: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener los responsables: ' . $e->getMessage()
            ], 500);
        }
    }

public function gestion_ordenes(Request $request): JsonResponse
{
    Log::info('📥 Request recibido en gestion_ordenes:', $request->all());

    try {
        //   VALIDACIÓN COMPLETA con todos los campos
        $validated = $request->validate([
            'id' => 'required|integer|exists:ordenes_compras,id',
            'responsable_id' => 'required|integer|exists:responsable,id',
            'numero_documento' => 'required|string|max:50',
            'fecha_factura' => 'required|date_format:Y-m-d',
            'tipo_factura_id' => 'required|integer|exists:tipo_factura,id',
            'metodo_pago_id' => 'required|integer|exists:metodopago,id', //   AÑADIDO
            'codigo_referencia' => 'nullable|string|max:100', //   AÑADIDO
            'estatus' => 'required|string|in:pendiente,aprobado,rechazado'
        ]);

        Log::info('  Validación exitosa:', $validated);

        // Mapear el estatus de texto a valores numéricos
        $estatusNumerico = match($validated['estatus']) {
            'pendiente' => 0,
            'aprobado' => 1,
            'rechazado' => 3,
            default => 0
        };

        DB::beginTransaction();

        // 1. CREAR O ACTUALIZAR LA FACTURA
        $facturaId = null;
        
        $facturaExistente = DB::table('factura')
            ->where('orden_compra', $validated['id'])
            ->first();
        
        //  PREPARAR DATOS COMPLETOS PARA FACTURA
        $datosFactura = [
            'numero' => $validated['numero_documento'],
            'tipo' => $validated['tipo_factura_id'],
            'fecha_factura' => $validated['fecha_factura'],
            'metodo' => $validated['metodo_pago_id'], //  GUARDAR MÉTODO
            'fecha_registro' => now(),
        ];
        
        //  GUARDAR REFERENCIA SI EXISTE
        if (!empty($validated['codigo_referencia']) && trim($validated['codigo_referencia']) !== '') {
            $datosFactura['n_referencia'] = $validated['codigo_referencia'];
            
            //  ASIGNAR tipo_pago = 2 CUANDO HAY CÓDIGO DE REFERENCIA
            $datosFactura['tipo_pago'] = 1;
        }else 
        {
        
            $datosFactura['tipo_pago'] = 2;
        }
        
        if ($facturaExistente) {
            DB::table('factura')
                ->where('id', $facturaExistente->id)
                ->update($datosFactura);
            $facturaId = $facturaExistente->id;
        } else {
            $datosFactura['orden_compra'] = $validated['id'];
            $facturaId = DB::table('factura')->insertGetId($datosFactura);
        }

        // 2. ACTUALIZAR LA ORDEN DE COMPRA
        $ordenActualizada = DB::table('ordenes_compras')
            ->where('id', $validated['id'])
            ->update([
                'responsable' => $validated['responsable_id'],
                'estatus' => $estatusNumerico,
                'updated_at' => now()
            ]);

        if (!$ordenActualizada) {
            throw new \Exception('No se pudo actualizar la orden de compra');
        }

        DB::commit();

        Log::info("  Orden actualizada ID: {$validated['id']} - Factura ID: {$facturaId}");

        return response()->json([
            'success' => true,
            'message' => 'Orden y factura procesadas exitosamente',
            'data' => [
                'orden_id' => $validated['id'],
                'factura_id' => $facturaId,
                'estatus' => $validated['estatus'],
                'estatus_numerico' => $estatusNumerico,
                'numero_documento' => $validated['numero_documento'],
                'fecha_factura' => $validated['fecha_factura'],
                'responsable_id' => $validated['responsable_id'],
                'tipo_factura_id' => $validated['tipo_factura_id'],
                'metodo_pago_id' => $validated['metodo_pago_id'], //   INCLUIR EN RESPUESTA
                'codigo_referencia' => $validated['codigo_referencia'] ?? null, //   INCLUIR EN RESPUESTA
                'tipo_pago_asignado' => !empty($validated['codigo_referencia']) ? 2 : null //   NUEVO CAMPO PARA CONFIRMACIÓN
            ]
        ]);

    } catch (\Illuminate\Validation\ValidationException $e) {
        Log::error('  Error de validación en gestion_ordenes:', $e->errors());
        return response()->json([
            'success' => false,
            'message' => 'Error de validación',
            'errors' => $e->errors()
        ], 422);
        
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('  Error en gestion_ordenes: ' . $e->getMessage());
        Log::error('  Trace: ' . $e->getTraceAsString());
        
        return response()->json([
            'success' => false,
            'message' => 'Error al procesar la gestión: ' . $e->getMessage()
        ], 500);
    }
}

    /*    public function actualizarOrdenesConTasaActual()
{
    try {
        // Configurar opciones para la solicitud HTTP con clave API
        $arrContextOptions = [
            "ssl" => [
                "verify_peer" => false,
                "verify_peer_name" => false,
            ],
            "http" => [
                "method" => "GET",
                "header" => "x-dolarvzla-key: 6903262079dd3cdc048844aeb171e47a60669f6578abad0f2e8a0e40b395a274\r\n"
            ]
        ];
        
        $context = stream_context_create($arrContextOptions);
        $json = file_get_contents('https://api.dolarvzla.com/public/exchange-rate', false, $context);
        
        if (!$json) {
            throw new \Exception('No se pudo obtener datos de la API');
        }
        
        $data = json_decode($json, true);
        
        if (!isset($data['current']['usd'])) {
            throw new \Exception('Estructura de datos inválida');
        }
        
        $tasaActual = $data['current']['usd'];
        
        // Obtener todas las órdenes activas
        $ordenes = OrdenCompra::obtenerOrdenesActivas();
        
        $actualizadas = 0;
        $detalles = [];
        
        foreach ($ordenes as $orden) {
            // Calcular el nuevo total en bolívares (actualizado para manejar iva_deduccion)
            $nuevoTotalbs = $orden->totalGeneral * $tasaActual;
            
            // 🔹 ACTUALIZADO: Manejar IVA normal vs IVA con deducción
            if ($orden->iva == 1 && $orden->iva_deduccion == 0) {
                // IVA Normal (16%)
                $nuevoTotalbs = $nuevoTotalbs * 1.16;
            } elseif ($orden->iva == 0 && $orden->iva_deduccion == 1) {
                // IVA con Deducción (16% - 75% = 4% neto)
                $nuevoTotalbs = $nuevoTotalbs * 1.04;
            }
            
            // Guardar para mostrar detalles
            $detalles[] = [
                'id' => $orden->id,
                'tasa_anterior' => $orden->tasa_dia,
                'totalGeneral' => $orden->totalGeneral,
                'iva' => $orden->iva,
                'iva_deduccion' => $orden->iva_deduccion, // 🔹 NUEVO
                'totalbs_anterior' => $orden->totalbs,
                'totalbs_nuevo' => round($nuevoTotalbs, 2),
                'diferencia' => round($nuevoTotalbs - $orden->totalbs, 2)
            ];
            
            // Actualizar directamente sin validación
            $orden->tasa_dia = $tasaActual;
            $orden->totalbs = round($nuevoTotalbs, 2);
            $orden->saveQuietly();
            
            $actualizadas++;
        }
        
        return response()->json([
            'success' => true,
            'message' => "Se actualizaron {$actualizadas} órdenes correctamente",
            'tasa_usada' => $tasaActual,
            'tasa_formateada' => number_format($tasaActual, 4),
            'detalles' => $detalles
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error en el proceso: ' . $e->getMessage()
        ], 500);
    }
}*/


public function actualizarOrdenesConTasaActual()
{
    try {
        // Cambiar a tu propia API
        $apiUrl = 'http://192.168.101.12:8004/tasas';
        
        $arrContextOptions = [
            "ssl" => [
                "verify_peer" => false,
                "verify_peer_name" => false,
            ],
            "http" => [
                "method" => "GET",
                // Removido el header de la API anterior ya que tu API no lo necesita
            ]
        ];
        
        $context = stream_context_create($arrContextOptions);
        $json = file_get_contents($apiUrl, false, $context);
        
        if (!$json) {
            throw new \Exception('No se pudo obtener datos de la API');
        }
        
        $data = json_decode($json, true);
        
        // Verificar la estructura de tu API
        if (!isset($data['status']) || $data['status'] !== 'success' || !isset($data['dolar'])) {
            throw new \Exception('Estructura de datos inválida o API no disponible');
        }
        
        // Convertir a float para asegurar el tipo numérico
        $tasaActual = (float) $data['dolar'];
        
        // Obtener todas las órdenes activas
        $ordenes = OrdenCompra::obtenerOrdenesActivas();
        
        $actualizadas = 0;
        $detalles = [];
        
        foreach ($ordenes as $orden) {
            // Calcular el nuevo total en bolívares (actualizado para manejar iva_deduccion)
            $nuevoTotalbs = $orden->totalGeneral * $tasaActual;
            
            // 🔹 ACTUALIZADO: Manejar IVA normal vs IVA con deducción
            if ($orden->iva == 1 && $orden->iva_deduccion == 0) {
                // IVA Normal (16%)
                $nuevoTotalbs = $nuevoTotalbs * 1.16;
            } elseif ($orden->iva == 0 && $orden->iva_deduccion == 1) {
                // IVA con Deducción (16% - 75% = 4% neto)
                $nuevoTotalbs = $nuevoTotalbs * 1.04;
            }
            
            // Guardar para mostrar detalles
            $detalles[] = [
                'id' => $orden->id,
                'tasa_anterior' => $orden->tasa_dia,
                'totalGeneral' => $orden->totalGeneral,
                'iva' => $orden->iva,
                'iva_deduccion' => $orden->iva_deduccion, // 🔹 NUEVO
                'totalbs_anterior' => $orden->totalbs,
                'totalbs_nuevo' => round($nuevoTotalbs, 2),
                'diferencia' => round($nuevoTotalbs - $orden->totalbs, 2)
            ];
            
            // Actualizar directamente sin validación
            $orden->tasa_dia = $tasaActual;
            $orden->totalbs = round($nuevoTotalbs, 2);
            $orden->saveQuietly();
            
            $actualizadas++;
        }
        
        // 🔹 NUEVO: También podemos obtener el euro si lo necesitas
        $tasaEuro = isset($data['euro']) ? (float) $data['euro'] : null;
        $fuente = isset($data['fuente']) ? $data['fuente'] : 'Desconocida';
        
        return response()->json([
            'success' => true,
            'message' => "Se actualizaron {$actualizadas} órdenes correctamente",
            'tasa_usada' => $tasaActual,
            'tasa_formateada' => number_format($tasaActual, 4),
            'tasa_euro' => $tasaEuro,
            'tasa_euro_formateada' => $tasaEuro ? number_format($tasaEuro, 4) : null,
            'fuente' => $fuente,
            'detalles' => $detalles
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error en el proceso: ' . $e->getMessage(),
            'api_url' => 'http://192.168.101.12:8004/tasas'
        ], 500);
    }
}
    
    // OPCIÓN 2: Función que recibe la tasa como parámetro
    public function actualizarOrdenesConTasaPersonalizada(Request $request)
    {
        $request->validate([
            'tasa_dia' => 'required|numeric|min:0'
        ]);
        
        try {
            $tasa = $request->tasa_dia;
            $ordenes = OrdenCompra::obtenerOrdenesActivas();
            
            $actualizadas = 0;
            
            foreach ($ordenes as $orden) {
                $nuevoTotalbs = $orden->totalGeneral * $tasa;
                
                // 🔹 ACTUALIZADO: Manejar IVA normal vs IVA con deducción
                if ($orden->iva == 1 && $orden->iva_deduccion == 0) {
                    // IVA Normal (16%)
                    $nuevoTotalbs = $nuevoTotalbs * 1.16;
                } elseif ($orden->iva == 0 && $orden->iva_deduccion == 1) {
                    // IVA con Deducción (16% - 75% = 4% neto)
                    $nuevoTotalbs = $nuevoTotalbs * 1.04;
                }
                
                OrdenCompra::where('id', $orden->id)->update([
                    'tasa_dia' => $tasa,
                    'totalbs' => round($nuevoTotalbs, 2)
                ]);
                
                $actualizadas++;
            }
            
            return response()->json([
                'success' => true,
                'message' => "Se actualizaron {$actualizadas} órdenes correctamente",
                'tasa_usada' => $tasa
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error en el proceso: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * 🔹 NUEVO: Actualizar orden completa (para edición)
     */
    public function actualizarOrdenCompleta(Request $request): JsonResponse
    {
        $userId = Auth::id();

        if (!$userId) {
            return response()->json([
                'success' => false,
                'message' => 'Error de autenticación'
            ], 401);
        }
        
        try {
            Log::info('Datos recibidos para actualizar orden completa:', $request->all());

            $validated = $request->validate([
                'orden_id' => 'required|integer|exists:ordenes_compras,id',
                'id_sucursal' => 'required|integer|exists:sucursales,id',
                'proveedor_id' => 'required|integer|exists:proveedores,id_proveedor',
                'fecha' => 'required|date',
                'moneda' => 'required|in:usd,eur,bs',
                'tasa' => 'required|numeric|min:0',
                'aplicarIva' => 'required|boolean',
                'aplicarIvaDeduccion' => 'boolean', // 🔹 NUEVO CAMPO
                'estado' => 'sometimes|string|in:PENDIENTE,PROCESADA,COMPLETADA,CANCELADA',
                'productos' => 'required|array|min:1'
            ]);

            // Determinar tipo de IVA
            $aplicarIva = $validated['aplicarIva'] ? 1 : 0;
            $aplicarIvaDeduccion = isset($validated['aplicarIvaDeduccion']) ? ($validated['aplicarIvaDeduccion'] ? 1 : 0) : 0;

            DB::beginTransaction();

            // Paso 1: Actualizar cabecera de la orden
            $datosOrden = [
                'sucursal' => $validated['id_sucursal'],
                'proveedores' => $validated['proveedor_id'],
                'tasa_dia' => $validated['tasa'],
                'moneda' => $validated['moneda'],
                'iva' => $aplicarIva,
                'iva_deduccion' => $aplicarIvaDeduccion, // 🔹 NUEVO
                'fecha_orden' => $validated['fecha'],
                'updated_at' => now()
            ];

            if (isset($validated['estado'])) {
                $datosOrden['estatus'] = $validated['estado'];
            }

            DB::table('ordenes_compras')
                ->where('id', $validated['orden_id'])
                ->update($datosOrden);

            // Paso 2: Procesar productos
            $totalGeneral = 0;

            foreach ($validated['productos'] as $itemProducto) {
                if (isset($itemProducto['accion']) && $itemProducto['accion'] === 'eliminar') {
                    // Eliminar producto
                    DB::table('detalles_o')
                        ->where('id', $itemProducto['detalle_id'])
                        ->delete();
                    continue;
                }

                // Buscar o crear producto
                $productoExistente = DB::table('productos')
                    ->where('nombre', $itemProducto['producto'])
                    ->first();

                if ($productoExistente) {
                    $productoId = $productoExistente->id;
                } else {
                    $productoId = DB::table('productos')->insertGetId([
                        'nombre' => $itemProducto['producto'],
                        'precio' => $itemProducto['precio'],
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }

                if (isset($itemProducto['detalle_id']) && is_numeric($itemProducto['detalle_id'])) {
                    // Actualizar detalle existente
                    DB::table('detalles_o')
                        ->where('id', $itemProducto['detalle_id'])
                        ->update([
                            'producto' => $productoId,
                            'unidad' => $itemProducto['id_unidad'],
                            'cantidad' => $itemProducto['cantidad'],
                            'precio' => $itemProducto['precio'],
                            'updated_at' => now()
                        ]);
                } else {
                    // Crear nuevo detalle
                    DB::table('detalles_o')->insert([
                        'ordenes' => $validated['orden_id'],
                        'producto' => $productoId,
                        'unidad' => $itemProducto['id_unidad'],
                        'cantidad' => $itemProducto['cantidad'],
                        'precio' => $itemProducto['precio'],
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }

                // Acumular total
                $subtotal = $itemProducto['cantidad'] * $itemProducto['precio'];
                $totalGeneral += $subtotal;
            }

            // Paso 3: Calcular totales finales
            $totalConIva = $totalGeneral;
            $montoIva = 0;
            
            if ($aplicarIva == 1 && $aplicarIvaDeduccion == 0) {
                // IVA Normal (16%)
                $montoIva = $totalGeneral * 0.16;
                $totalConIva = $totalGeneral + $montoIva;
                
            } elseif ($aplicarIva == 0 && $aplicarIvaDeduccion == 1) {
                // 🔹 NUEVO: IVA con Deducción (16% - 75%)
                $ivaNormal = $totalGeneral * 0.16;
                $montoDeduccion = $ivaNormal * 0.75;
                $montoIva = $ivaNormal - $montoDeduccion;
                $totalConIva = $totalGeneral + $montoIva;
            }

            // Calcular total en Bs
            $totalBs = $totalConIva * $validated['tasa'];

            // Actualizar orden con totales reales
            DB::table('ordenes_compras')
                ->where('id', $validated['orden_id'])
                ->update([
                    'totalGeneral' => $totalGeneral,
                    'totalbs' => $totalBs,
                    'updated_at' => now()
                ]);

            DB::commit();

            Log::info("Orden completa actualizada ID: {$validated['orden_id']} - IVA Deducción: {$aplicarIvaDeduccion}");

            return response()->json([
                'success' => true,
                'message' => 'Orden de compra actualizada correctamente',
                'orden_id' => $validated['orden_id'],
                'total_general' => $totalGeneral,
                'total_con_iva' => $totalConIva,
                'total_bs' => $totalBs,
                'monto_iva' => $montoIva,
                'iva_deduccion' => $aplicarIvaDeduccion
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error en actualizar orden completa: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'Error interno: ' . $e->getMessage()
            ], 500);
        }
    }




 public function actualizarProducto(Request $request, $detalleId)
    {
        try {
            Log::info("Actualizando producto ID: {$detalleId}", $request->all());

            // Validar datos
            $validator = Validator::make($request->all(), [
                'nombre' => 'required|string|max:255',
                'cantidad' => 'required|numeric|min:0.01',
                'precio' => 'required|numeric|min:0',
                'id_unidad' => 'required|exists:unidades,id_unidad'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error de validación',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Verificar que el detalle existe
            $detalle = DB::table('detalles_o')->where('id', $detalleId)->first();
            
            if (!$detalle) {
                return response()->json([
                    'success' => false,
                    'message' => 'Producto no encontrado'
                ], 404);
            }

            // Actualizar el producto
            DB::table('detalles_o')
                ->where('id', $detalleId)
                ->update([
                    'cantidad' => $request->cantidad,
                    'precio' => $request->precio,
                    'unidad' => $request->id_unidad,
                    'updated_at' => now()
                ]);

            // Actualizar el nombre del producto en la tabla productos
            DB::table('productos')
                ->where('id', $detalle->producto)
                ->update([
                    'nombre' => $request->nombre,
                    'updated_at' => now()
                ]);

            // Recalcular totales de la orden
            $this->recalcularTotalesOrden($detalle->ordenes);

            return response()->json([
                'success' => true,
                'message' => 'Producto actualizado correctamente',
                'data' => [
                    'detalle_id' => $detalleId,
                    'cantidad' => $request->cantidad,
                    'precio' => $request->precio,
                    'unidad' => $request->id_unidad
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error al actualizar producto: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error interno: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Eliminar un producto de la orden
     */
    public function eliminarProducto(Request $request, $detalleId)
    {
        try {
            Log::info("Eliminando producto ID: {$detalleId}");

            // Verificar que el detalle existe
            $detalle = DB::table('detalles_o')->where('id', $detalleId)->first();
            
            if (!$detalle) {
                return response()->json([
                    'success' => false,
                    'message' => 'Producto no encontrado'
                ], 404);
            }

            $ordenId = $detalle->ordenes;

            // Eliminar el detalle
            DB::table('detalles_o')->where('id', $detalleId)->delete();

            // Recalcular totales de la orden
            $this->recalcularTotalesOrden($ordenId);

            return response()->json([
                'success' => true,
                'message' => 'Producto eliminado correctamente',
                'data' => [
                    'orden_id' => $ordenId,
                    'detalle_id' => $detalleId
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error al eliminar producto: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error interno: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Agregar un nuevo producto a la orden
     */
    public function agregarProducto(Request $request)
    {
        try {
            Log::info("Agregando nuevo producto a orden", $request->all());

            // Validar datos
            $validator = Validator::make($request->all(), [
                'orden_id' => 'required|exists:ordenes_compras,id',
                'nombre' => 'required|string|max:255',
                'cantidad' => 'required|numeric|min:0.01',
                'precio' => 'required|numeric|min:0',
                'id_unidad' => 'required|exists:unidades,id_unidad'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error de validación',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Verificar que la orden existe
            $orden = DB::table('ordenes_compras')->where('id', $request->orden_id)->first();
            
            if (!$orden) {
                return response()->json([
                    'success' => false,
                    'message' => 'Orden no encontrada'
                ], 404);
            }

            // Crear o buscar el producto
            $producto = DB::table('productos')
                ->where('nombre', $request->nombre)
                ->first();

            $productoId = null;
            
            if ($producto) {
                // Producto existe, usar su ID
                $productoId = $producto->id;
                
                // Actualizar el nombre por si acaso
                DB::table('productos')
                    ->where('id', $productoId)
                    ->update([
                        'nombre' => $request->nombre,
                        'updated_at' => now()
                    ]);
            } else {
                // Crear nuevo producto
                $productoId = DB::table('productos')->insertGetId([
                    'nombre' => $request->nombre,
                    'descripcion' => '',
                    'estatus' => 1,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            // Insertar el detalle
            $detalleId = DB::table('detalles_o')->insertGetId([
                'ordenes' => $request->orden_id,
                'producto' => $productoId,
                'cantidad' => $request->cantidad,
                'precio' => $request->precio,
                'unidad' => $request->id_unidad,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Recalcular totales de la orden
            $this->recalcularTotalesOrden($request->orden_id);

            return response()->json([
                'success' => true,
                'message' => 'Producto agregado correctamente',
                'data' => [
                    'detalle_id' => $detalleId,
                    'producto_id' => $productoId,
                    'orden_id' => $request->orden_id
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error al agregar producto: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error interno: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Recalcular totales de la orden
     */
    public function eliminarProductoModal(Request $request): JsonResponse
{
    try {
        // Solo validar lo esencial
        $request->validate([
            'detalle_id' => 'required|integer|exists:detalles_o,id',
            'orden_id' => 'required|integer|exists:ordenes_compras,id'
        ]);

        $detalleId = $request->detalle_id;
        $ordenId = $request->orden_id;

        // Verificar que el detalle pertenece a la orden
        $detalle = DB::table('detalles_o')
            ->where('id', $detalleId)
            ->where('ordenes', $ordenId)
            ->first();

        if (!$detalle) {
            return response()->json([
                'success' => false,
                'message' => 'El producto no pertenece a esta orden'
            ], 404);
        }

        // Eliminar el producto
        DB::table('detalles_o')
            ->where('id', $detalleId)
            ->delete();

        // Recalcular la orden
        $this->recalcularOrdenSimple($ordenId);

        return response()->json([
            'success' => true,
            'message' => 'Producto eliminado correctamente',
            'detalle_id' => $detalleId
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error: ' . $e->getMessage()
        ], 500);
    }
}

/**
 * Función simple para recalcular
 */
private function recalcularOrdenSimple($ordenId)
{
    // Calcular nuevo subtotal
    $subtotal = DB::table('detalles_o')
        ->where('ordenes', $ordenId)
        ->select(DB::raw('COALESCE(SUM(cantidad * precio), 0) as subtotal'))
        ->value('subtotal');

    // Actualizar la orden
    DB::table('ordenes_compras')
        ->where('id', $ordenId)
        ->update([
            'totalGeneral' => $subtotal
            // Agrega más campos si necesitas
        ]);
}

    /**
     * Actualizar totales de la orden (para llamada desde JavaScript)
     */
    public function actualizarTotalesOrden(Request $request, $ordenId)
    {
        try {
            Log::info("Actualizando totales de orden ID: {$ordenId}");

            $this->recalcularTotalesOrden($ordenId);

            return response()->json([
                'success' => true,
                'message' => 'Totales actualizados correctamente',
                'data' => [
                    'orden_id' => $ordenId
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error al actualizar totales: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error interno: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Endpoint para debug - verificar datos recibidos
     */
    public function debugEndpoint(Request $request)
    {
        try {
            Log::info("DEBUG - Datos recibidos:", $request->all());
            
            return response()->json([
                'success' => true,
                'message' => 'Datos recibidos correctamente',
                'data_received' => $request->all(),
                'headers' => $request->headers->all(),
                'method' => $request->method(),
                'full_url' => $request->fullUrl()
            ]);

        } catch (\Exception $e) {
            Log::error('Error en debug endpoint: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }








}