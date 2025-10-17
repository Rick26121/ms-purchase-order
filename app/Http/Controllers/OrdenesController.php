<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proveedor;
   use App\Models\Unidad;
use Illuminate\Support\Facades\DB;
use App\Models\OrdenCompra;
use App\Models\Sucursal;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
class OrdenesController extends Controller
{


public function inicio()
{
    $proveedores = Proveedor::all();
    $unidades = Unidad::all(); 
        return view('orden_compra.create_orden', compact('proveedores', 'unidades'));
}

    public function buscarProveedores(Request $request)
    {
        $search = $request->get('search');
        
        $proveedores = Proveedor::where('nombre', 'LIKE', "%{$search}%")
            ->orWhere('rif', 'LIKE', "%{$search}%")
            ->limit(10)
            ->get();

        return response()->json($proveedores);
    }

#sucursales 
   public function buscarSucursales(Request $request)
    {
        $search = $request->get('search');
        
        $sucursales = sucursales::where('nombre', 'LIKE', "%{$search}%")
            ->orWhere('nombre', 'LIKE', "%{$search}%")
            ->limit(10)
            ->get();

        return response()->json($sucursales);
    }




    public function getProveedor($id)
    {
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
                'correo' => $proveedor->correo
            ]
        ]);
    }

# solicitar informacion de la unidad
# solicitar informacion de la unidad
public function guardar(Request $request)
{
    // 1. 🔑 OBTENER EL ID DEL USUARIO LOGEADO
    $userId = Auth::id();

    // Verificación de seguridad
    if (!$userId) {
        \Log::error('Intento de guardar orden sin usuario autenticado.');
        return response()->json([
            'success' => false,
            'message' => 'Error de autenticación. Debe iniciar sesión.'
        ], 401);
    }
    
    try {
        // 🔹 Log para depuración
        \Log::info('Datos recibidos en guardar:', $request->all());

        // ✅ Validación CORREGIDA - usar id_unidad en lugar de unidad_id
        $validated = $request->validate([
            'id_sucursal' => 'required|integer|exists:sucursales,id',
            'proveedor_id' => 'required|integer|exists:proveedores,id_proveedor',
            'fecha' => 'required|date',
            'moneda' => 'required|in:usd,eur',
            'tasa' => 'required|numeric|min:0',
            'aplicarIva' => 'required|boolean',
            'productos' => 'required|array|min:1',
            'productos.*.producto' => 'required|string|max:255',
            'productos.*.cantidad' => 'required|numeric|min:1',
            'productos.*.precio' => 'required|numeric|min:0',
            'productos.*.id_unidad' => 'required|integer|exists:unidades,id_unidad'
        ]);

        \Log::info('Datos validados:', $validated);

        // 🔹 Guardar productos
        $productosConIds = [];
        foreach ($validated['productos'] as $itemProducto) {
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

            $productosConIds[] = [
                'id' => $productoId,
                'nombre' => $itemProducto['producto'],
                'cantidad' => $itemProducto['cantidad'],
                'precio' => $itemProducto['precio'],
                'id_unidad' => $itemProducto['id_unidad'] // 👈 Usar id_unidad
            ];
        }

        // 🔹 Calcular totales
        $totalGeneral = 0;
        foreach ($productosConIds as $producto) {
            $totalGeneral += $producto['cantidad'] * $producto['precio'];
        }

        $totalConIva = $validated['aplicarIva'] ? $totalGeneral * 1.16 : $totalGeneral;
        $totalBs = $totalConIva * $validated['tasa'];
        $montoIva = $validated['aplicarIva'] ? $totalGeneral * 0.16 : 0;
        $cantidadTotal = array_sum(array_column($productosConIds, 'cantidad'));
        $primerProductoId = $productosConIds[0]['id'];
        $primerProductoUnidadId = $productosConIds[0]['id_unidad'];

        // 🔹 Datos para la tabla ordenes_compras
        $datosOrden = [
            'sucursal' => $validated['id_sucursal'],
            'producto' => $primerProductoId,
            'cantidad' => $cantidadTotal,
            'unidad' => $primerProductoUnidadId,
            'totalGeneral' => $totalGeneral,
            'tasa_dia' => $validated['tasa'],
            'moneda' => $validated['moneda'],
            'iva' => $montoIva,
            'totalbs' => $totalBs,
            'proveedores' => $validated['proveedor_id'],
            'fecha_orden' => $validated['fecha'],
            
            // 2. 🎯 GUARDAR EL ID DEL USUARIO REGISTRADO
            'usuario' => $userId, // <-- CAMBIO CLAVE: Guarda el ID del usuario logeado
            
            'created_at' => now(),
            'updated_at' => now()
        ];

        $ordenId = DB::table('ordenes_compras')->insertGetId($datosOrden);

        return response()->json([
            'success' => true,
            'message' => 'Orden de compra guardada correctamente',
            'orden_id' => $ordenId,
            'producto_id' => $primerProductoId
        ]);

    } catch (\Exception $e) {
        \Log::error('Error en guardar orden:', ['error' => $e->getMessage()]);
        return response()->json([
            'success' => false,
            'message' => 'Error: ' . $e->getMessage()
        ], 500);
    }
}



public function menu(){

    return view('orden_compra.menu');
}

    public function index()
    {
        try {
            $ordenesCompras = OrdenCompra::with([
                'sucursal:id,nombre',
                'producto:id,nombre',
                'proveedor:id_proveedor,nombre',
                'unidad:id_unidad,abreviatura'
            ])
            ->select([
                'id',
                'sucursal',
                'producto',
                'proveedores',
                'cantidad',
                'unidad',
                'totalGeneral',
                'tasa_dia',
                'moneda',
                'iva',
                'totalbs',
                'fecha_orden',
                'estatus',
                'visible'
            ])
            ->where('visible', true)
            ->get();

            return response()->json([
                'success' => true,
                'data' => $ordenesCompras,
                'message' => 'Órdenes de compra obtenidas correctamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener las órdenes de compra: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener una orden de compra específica
     */
    public function show($id)
    {
        try {
            $ordenCompra = OrdenCompra::with([
                'sucursal:id,nombre',
                'producto:id,nombre',
                'proveedor:id_proveedor,nombre',
                'unidad:id_unidad,abreviatura'
            ])->find($id);

            if (!$ordenCompra) {
                return response()->json([
                    'success' => false,
                    'message' => 'Orden de compra no encontrada'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $ordenCompra,
                'message' => 'Orden de compra obtenida correctamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener la orden de compra: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener órdenes de compra con filtros
     */
    public function filtrar(Request $request)
    {
        try {
            $query = OrdenCompra::with([
                'sucursal:id,nombre',
                'producto:id,nombre',
                'proveedor:id_proveedor,nombre',
                'unidad:id_unidad,abreviatura'
            ]);

            // Filtro por estatus
            if ($request->has('estatus') && $request->estatus) {
                $query->where('estatus', $request->estatus);
            }

            // Filtro por sucursal
            if ($request->has('sucursal') && $request->sucursal) {
                $query->where('sucursal', $request->sucursal);
            }

            // Filtro por proveedor
            if ($request->has('proveedor') && $request->proveedor) {
                $query->where('proveedores', $request->proveedor);
            }

            // Filtro por fecha
            if ($request->has('fecha_desde') && $request->fecha_desde) {
                $query->where('fecha_orden', '>=', $request->fecha_desde);
            }

            if ($request->has('fecha_hasta') && $request->fecha_hasta) {
                $query->where('fecha_orden', '<=', $request->fecha_hasta);
            }

            $ordenesCompras = $query->get();

            return response()->json([
                'success' => true,
                'data' => $ordenesCompras,
                'message' => 'Órdenes de compra filtradas correctamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al filtrar las órdenes de compra: ' . $e->getMessage()
            ], 500);
        }
    }




public function obtenerSucursales()
{
    $sucursales = Sucursal::select('id', 'nombre')->get();

    return response()->json([
        'success' => true,
        'data' => $sucursales
    ]);
}

# cambio de estado 
  public function cambiarEstatus(Request $request): JsonResponse
    {
        Log::info('📥 Request recibido para cambiar estatus', $request->all());

        try {
            // Validación básica
            if (!$request->has('id')) {
                return response()->json([
                    'success' => false,
                    'message' => 'ID de orden no proporcionado'
                ], 400);
            }

            if (!$request->has('estatus')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Estatus no proporcionado'
                ], 400);
            }

            $ordenId = $request->id;
            $nuevoEstatus = $request->estatus;

            Log::info("Buscando orden ID: {$ordenId}");

            // Buscar la orden
            $orden = OrdenCompra::find($ordenId);
            
            if (!$orden) {
                Log::warning("Orden no encontrada ID: {$ordenId}");
                return response()->json([
                    'success' => false,
                    'message' => 'Orden de compra no encontrada'
                ], 404);
            }

            Log::info("Orden encontrada. Estatus actual: {$orden->estatus}, Nuevo estatus: {$nuevoEstatus}");

            // Actualizar el estatus
            $orden->estatus = $nuevoEstatus;
            $orden->save();

            Log::info("✅ Estatus actualizado correctamente para orden ID: {$ordenId}");

            $mensaje = $nuevoEstatus == 1 
                ? 'Orden aprobada correctamente' 
                : 'Orden marcada como en proceso correctamente';

            return response()->json([
                'success' => true,
                'message' => $mensaje,
                'data' => [
                    'id' => $orden->id,
                    'estatus_anterior' => $orden->estatus, // Este sería el nuevo, pero para debug
                    'nuevo_estatus' => $nuevoEstatus
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('❌ Error al cambiar estatus: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Error interno: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mostrar formulario para crear nueva orden
     */
    public function crear()
    {
        return view('ordenes.crear'); // Ajusta según tu vista
    }
}
