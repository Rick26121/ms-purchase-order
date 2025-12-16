<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proveedor;
use App\Models\Unidad;
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
        return view('orden_compra.menu');
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
                'aplicarIva' => 'required|boolean'
            ]);

            Log::info('Datos validados para crear orden:', $validated);

            // Crear orden inicial (sin productos todavía)
            // Los totales se calcularán cuando se agreguen los productos
            $datosOrden = [
                'sucursal' => $validated['id_sucursal'],
                'proveedores' => $validated['proveedor_id'],
                'totalGeneral' => 0, // Inicial en 0
                'tasa_dia' => $validated['tasa'],
                'moneda' => $validated['moneda'],
                'iva' => $validated['aplicarIva'] ? 1 : 0, // Solo 0 o 1
                'totalbs' => 0, // Inicial en 0
                'usuario' => $userId,
                'fecha_orden' => $validated['fecha'],
                'estatus' => 'pendiente',
                'visible' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ];

            $ordenId = DB::table('ordenes_compras')->insertGetId($datosOrden);

            Log::info("Orden creada exitosamente ID: {$ordenId} - Sin productos aún");

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
                'precio' => $validated['precio'],
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Recalcular totales de la orden
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
     * Recalcular totales de una orden
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

            // Calcular IVA (si aplica)
            $ivaPorcentaje = $orden->iva ? 0.16 : 0; // 16% si aplica IVA
            $montoIva = $totalGeneral * $ivaPorcentaje;
            $totalConIva = $totalGeneral + $montoIva;

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

            Log::info("Orden ID: {$ordenId} recalculada. Total General: {$totalGeneral}, Total Bs: {$totalBs}");

            return true;

        } catch (\Exception $e) {
            Log::error('Error al recalcular orden: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Guardar orden completa (con todos los productos a la vez)
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

            $validated = $request->validate([
                'id_sucursal' => 'required|integer|exists:sucursales,id',
                'proveedor_id' => 'required|integer|exists:proveedores,id_proveedor',
                'fecha' => 'required|date',
                'moneda' => 'required|in:usd,eur,bs',
                'tasa' => 'required|numeric|min:0',
                'aplicarIva' => 'required|boolean',
                'productos' => 'required|array|min:1',
                'productos.*.producto' => 'required|string|max:255',
                'productos.*.cantidad' => 'required|numeric|min:1',
                'productos.*.precio' => 'required|numeric|min:0',
                'productos.*.id_unidad' => 'required|integer|exists:unidades,id_unidad'
            ]);

            // Paso 1: Crear orden (cabecera)
            $datosOrden = [
                'sucursal' => $validated['id_sucursal'],
                'proveedores' => $validated['proveedor_id'],
                'totalGeneral' => 0, // Temporal
                'tasa_dia' => $validated['tasa'],
                'moneda' => $validated['moneda'],
                'iva' => $validated['aplicarIva'] ? 1 : 0,
                'totalbs' => 0, // Temporal
                'usuario' => $userId,
                
                'estatus' => '0',
                'visible' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ];

            $ordenId = DB::table('ordenes_compras')->insertGetId($datosOrden);

            // Paso 2: Procesar productos y agregar a detalles
            $detallesInsertados = [];
            $totalGeneral = 0;

            foreach ($validated['productos'] as $itemProducto) {
                // Buscar o crear producto
                $productoExistente = DB::table('productos')
                    ->where('nombre', $itemProducto['producto'])
                    ->first();

                if ($productoExistente) {
                    DB::table('productos')
                        ->where('id', $productoExistente->id)
                        ->update([
                            'precio' => $itemProducto['precio'],
                            'updated_at' => now()
                        ]);
                    $productoId = $productoExistente->id;
                } else {
                    $productoId = DB::table('productos')->insertGetId([
                        'nombre' => $itemProducto['producto'],
                        'precio' => $itemProducto['precio'],
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }

                // Agregar a detalles
                DB::table('detalles_o')->insert([
                    'ordenes' => $ordenId,
                    'producto' => $productoId,
                    'unidad' => $itemProducto['id_unidad'],
                    'cantidad' => $itemProducto['cantidad'],
                    'precio' => $itemProducto['precio'],
                    
                ]);

                // Acumular total
                $subtotal = $itemProducto['cantidad'] * $itemProducto['precio'];
                $totalGeneral += $subtotal;

                $detallesInsertados[] = [
                    'producto_id' => $productoId,
                    'nombre' => $itemProducto['producto'],
                    'cantidad' => $itemProducto['cantidad'],
                    'precio' => $itemProducto['precio'],
                    'subtotal' => $subtotal
                ];
            }

            // Paso 3: Calcular totales finales
            $ivaPorcentaje = $validated['aplicarIva'] ? 0.16 : 0;
            $montoIva = $totalGeneral * $ivaPorcentaje;
            $totalConIva = $totalGeneral + $montoIva;
            $totalBs = $totalConIva * $validated['tasa'];

            // Actualizar orden con totales reales
            DB::table('ordenes_compras')
                ->where('id', $ordenId)
                ->update([
                    'totalGeneral' => $totalGeneral,
                    'totalbs' => $totalBs,
                    'updated_at' => now()
                ]);

            Log::info("Orden completa guardada ID: {$ordenId}");

            return response()->json([
                'success' => true,
                'message' => 'Orden de compra guardada correctamente',
                'orden_id' => $ordenId,
                'total_general' => $totalGeneral,
                'total_con_iva' => $totalConIva,
                'total_bs' => $totalBs,
                'monto_iva' => $montoIva,
                'productos' => $detallesInsertados
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Error de validación en guardar orden completa: ' . json_encode($e->errors()));
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
            
        } catch (\Exception $e) {
            Log::error('Error en guardar orden completa: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
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
                ->leftJoin('sucursales as s', 'oc.sucursal', '=', 's.id')
                ->leftJoin('proveedores as p', 'oc.proveedores', '=', 'p.id_proveedor')
                ->leftJoin('users as u', 'oc.usuario', '=', 'u.id')
                ->where('oc.id', $ordenId)
                ->select([
                    'oc.*',
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

            // Calcular IVA real
            $totalGeneral = (float) $orden->totalGeneral;
            $aplicaIVA = (bool) $orden->iva;
            $ivaPorcentaje = $aplicaIVA ? 16 : 0;
            $montoIva = $totalGeneral * ($ivaPorcentaje / 100);
            $totalConIva = $totalGeneral + $montoIva;

            $response = [
                'orden' => $orden,
                'productos' => $productos,
                'calculos' => [
                    'total_general' => $totalGeneral,
                    'aplica_iva' => $aplicaIVA,
                    'iva_porcentaje' => $ivaPorcentaje,
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
     * Obtener orden por ID para plantilla
     */


public function obtenerOrdenPorId($id)
{
    try {
        Log::info("Consultando orden ID: {$id} para plantilla");

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
                o.tasa_dia,
                o.totalbs,
                o.moneda,
                o.estatus,
                o.created_at,
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
                -- Información adicional de bancos (si existe)
                
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
            INNER JOIN detalles_o d ON o.id = d.ordenes
            LEFT JOIN sucursales s ON o.sucursal = s.id
            LEFT JOIN proveedores p ON o.proveedores = p.id_proveedor
            LEFT JOIN productos pr ON d.producto = pr.id
            LEFT JOIN unidades un ON d.unidad = un.id_unidad
            LEFT JOIN users u ON o.usuario = u.id
            LEFT JOIN bancos b ON b.id_proveedor = p.id_proveedor
            WHERE o.id = ?
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
        
        // Calcular datos para la plantilla
        $totalGeneral = (float) $primerRegistro->totalGeneral;
        $aplicaIVA = (bool) $primerRegistro->iva;
        $ivaPorcentaje = $aplicaIVA ? 16 : 0;
        $montoIva = $totalGeneral * ($ivaPorcentaje / 100);
        $totalConIva = $totalGeneral + $montoIva;
        $tasaDia = (float) $primerRegistro->tasa_dia;
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

        // Preparar datos para la vista
        $viewData = [
            'orden' => (object) [
                'id' => $primerRegistro->orden_id,
                'totalGeneral' => $totalGeneral,
                'tasa_dia' => $tasaDia,
                'moneda' => $primerRegistro->moneda,
                'iva' => $montoIva,
                'totalbs' => $totalBS,
                'fecha_orden' => $primerRegistro->created_at,
                'estatus' => $primerRegistro->estatus,
                'created_at' => $primerRegistro->created_at,
                
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
                    'lista_bancos' => $bancos, // Lista de bancos
                ],
            ],
            
            'productos' => $productos,
            
            'calculos' => [
                'numeroOrden' => $primerRegistro->orden_id,
                'fechaEmision' => $fechaOrden,
                'fechaOriginal' => $primerRegistro->created_at,
                'tasa' => number_format($tasaDia, 2, ',', '.'),
                'subtotalProductos' => number_format($subtotalProductos, 2, ',', '.'),
                'subtotal' => number_format($totalGeneral - $montoIva, 2, ',', '.'),
                'iva' => number_format($montoIva, 2, ',', '.'),
                'ivaPorcentaje' => $ivaPorcentaje,
                'totalUSD' => number_format($totalConIva, 2, ',', '.'),
                'totalBS' => number_format($totalBS, 2, ',', '.'),
                'aplicaIVA' => $aplicaIVA,
            ],
        ];

        Log::info("Datos preparados para plantilla ID: {$id} - " . count($productos) . " productos encontrados");

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
                'oc.totalbs',
                'oc.totalGeneral',
                'oc.created_at as "Fecha Creacion"',
                'oc.estatus'
            ])
            // El WHERE 1 no es necesario en Laravel ya que siempre es true
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

            Log::info("✅ Estatus actualizado correctamente para orden ID: {$ordenId}");

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
            Log::error('❌ Error al cambiar estatus: ' . $e->getMessage());
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
                'orden_id' => 'required|integer|exists:ordenes_compras,id',
                'detalle_id' => 'required|integer|exists:detalles_o,id'
            ]);

            $ordenId = $request->orden_id;
            $detalleId = $request->detalle_id;

            // Verificar que el detalle pertenezca a la orden
            $detalle = DB::table('detalles_o')
                ->where('id', $detalleId)
                ->where('ordenes', $ordenId)
                ->first();

            if (!$detalle) {
                return response()->json([
                    'success' => false,
                    'message' => 'El detalle no pertenece a la orden especificada'
                ], 404);
            }

            // Eliminar el detalle
            DB::table('detalles_o')->where('id', $detalleId)->delete();

            // Recalcular la orden
            $this->recalcularOrden($ordenId);

            return response()->json([
                'success' => true,
                'message' => 'Producto eliminado de la orden correctamente',
                'orden_id' => $ordenId
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
            
        } catch (\Exception $e) {
            Log::error('Error al eliminar producto de orden: ' . $e->getMessage());
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
                'updated_at' => now()
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
        // Validar los datos recibidos
        $validated = $request->validate([
            'id' => 'required|integer|exists:ordenes_compras,id',
            'responsable_id' => 'required|integer|exists:responsable,id',
            'numero_documento' => 'required|string|max:50',
            'tipo_factura_id' => 'required|integer|exists:tipo_factura,id',
            'estatus' => 'required|string|in:pendiente,aprobado,rechazado'
        ]);

        // Mapear el estatus de texto a valores numéricos
        $estatusNumerico = match($validated['estatus']) {
            'pendiente' => 0,
            'aprobado' => 1,
            'rechazado' => 3,
            default => 0
        };

        DB::beginTransaction(); // Iniciar transacción

        // 1. CREAR O ACTUALIZAR LA FACTURA
        $facturaId = null;
        
        // Verificar si ya existe una factura para esta orden
        $facturaExistente = DB::table('factura')
            ->where('orden_compra', $validated['id'])
            ->first();
        
        if ($facturaExistente) {
            // Actualizar factura existente
            DB::table('factura')
                ->where('id', $facturaExistente->id)
                ->update([
                    'numero' => $validated['numero_documento'],
                    'tipo' => $validated['tipo_factura_id'],
                    'fecha_registro' => now()
                ]);
            $facturaId = $facturaExistente->id;
        } else {
            // Crear nueva factura
            $facturaId = DB::table('factura')->insertGetId([
                'numero' => $validated['numero_documento'],
                'tipo' => $validated['tipo_factura_id'],
                'orden_compra' => $validated['id'], // Relacionar con la orden
                'fecha_registro' => now(),
                
            ]);
        }

        // 2. ACTUALIZAR LA ORDEN DE COMPRA con el responsable, estatus y relacionar con factura
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

        DB::commit(); // Confirmar transacción

        Log::info("✅ Orden actualizada ID: {$validated['id']} - Factura ID: {$facturaId} - Estatus: {$validated['estatus']} ({$estatusNumerico})");

        return response()->json([
            'success' => true,
            'message' => 'Orden y factura procesadas exitosamente',
            'data' => [
                'orden_id' => $validated['id'],
                'factura_id' => $facturaId,
                'estatus' => $validated['estatus'],
                'estatus_numerico' => $estatusNumerico,
                'numero' => $validated['numero_documento'],
                'responsable_id' => $validated['responsable_id'],
                'tipo_factura_id' => $validated['tipo_factura_id']
            ]
        ]);

    } catch (\Illuminate\Validation\ValidationException $e) {
        Log::error('❌ Error de validación en gestion_ordenes:', $e->errors());
        return response()->json([
            'success' => false,
            'message' => 'Error de validación',
            'errors' => $e->errors()
        ], 422);
        
    } catch (\Exception $e) {
        DB::rollBack(); // Revertir transacción en caso de error
        Log::error('❌ Error en gestion_ordenes: ' . $e->getMessage());
        Log::error('❌ Trace: ' . $e->getTraceAsString());
        
        return response()->json([
            'success' => false,
            'message' => 'Error al procesar la gestión: ' . $e->getMessage()
        ], 500);
    }

}

    public function actualizarOrdenesConTasaActual()
{
    try {
        // Deshabilitar verificación SSL temporalmente
        $arrContextOptions = [
            "ssl" => [
                "verify_peer" => false,
                "verify_peer_name" => false,
            ],
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
            // Calcular el nuevo total en bolívares
            $nuevoTotalbs = $orden->totalGeneral * $tasaActual;
            
            // Si iva es igual a 1, sumar el 16%
            if ($orden->iva == 1) {
                $nuevoTotalbs = $nuevoTotalbs * 1.16;
            }
            
            // Guardar para mostrar detalles
            $detalles[] = [
                'id' => $orden->id,
                'tasa_anterior' => $orden->tasa_dia,
                'totalGeneral' => $orden->totalGeneral,
                'iva' => $orden->iva,
                'totalbs_anterior' => $orden->totalbs,
                'totalbs_nuevo' => round($nuevoTotalbs, 2),
                'diferencia' => round($nuevoTotalbs - $orden->totalbs, 2)
            ];
            
            // Actualizar el registro
            OrdenCompra::where('id', $orden->id)->update([
                'tasa_dia' => $tasaActual,
                'totalbs' => round($nuevoTotalbs, 2)
            ]);
            
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
                
                if ($orden->iva == 1) {
                    $nuevoTotalbs = $nuevoTotalbs * 1.16;
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


}











