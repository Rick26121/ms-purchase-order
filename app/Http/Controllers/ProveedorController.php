<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProveedorController extends Controller
{
    // Método para listar proveedores
    public function listarProve(Request $request)
    {
        $search = $request->get('search');
        
        $proveedor = Proveedor::when($search, function($query, $search) {
                return $query->where('nombre', 'like', "%{$search}%")
                            ->orWhere('rif', 'like', "%{$search}%")
                            ->orWhere('correo', 'like', "%{$search}%");
            })
            ->orderBy('id_proveedor', 'asc')
            ->paginate(13);
        
        if ($search) {
            $proveedor->appends(['search' => $search]);
        }
        
        if ($request->ajax()) {
            $tabla = view('proveedor.partials.tabla', compact('proveedor'))->render();
            $pagination = $proveedor->links()->toHtml();
            
            return response()->json([
                'tabla' => $tabla,
                'pagination' => $pagination
            ]);
        }
        
        return view('proveedor.proveedor', compact('proveedor'));
    }

    // Método para obtener un proveedor CON sus datos bancarios 
    public function obtenerProveedor($id)
    {
        try {
            // Usar query manual para evitar problemas con Eloquent
            $proveedor = DB::table('proveedores')->where('id_proveedor', $id)->first();
            
            if (!$proveedor) {
                return response()->json([
                    'success' => false,
                    'error' => 'Proveedor no encontrado'
                ], 404);
            }
            
            // Obtener datos bancarios
            $bancos = DB::table('bancos')->where('id_proveedor', $id)->first();
            
            // Convertir a array y agregar bancos
            $proveedorArray = (array) $proveedor;
            $proveedorArray['bancos'] = $bancos ? (array) $bancos : null;
            
            return response()->json([
                'success' => true,
                'data' => $proveedorArray
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en obtenerProveedor: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Error interno del servidor'
            ], 500);
        }
    }

    // Método para ver detalles
    public function verProveedor($id)
    {
        try {
            Log::info('=== INICIANDO verProveedor ID: ' . $id . ' ===');
            
            //  Obtener proveedor
            $proveedor = DB::table('proveedores')->where('id_proveedor', $id)->first();
            
            if (!$proveedor) {
                Log::warning('Proveedor no encontrado ID: ' . $id);
                return response()->json([
                    'success' => false,
                    'error' => 'Proveedor no encontrado'
                ], 404);
            }
            
            Log::info('Proveedor encontrado: ' . $proveedor->nombre);
            
            //  Obtener datos bancarios
            $bancos = DB::table('bancos')->where('id_proveedor', $id)->first();
            
            Log::info('Datos bancarios encontrados: ' . ($bancos ? 'SÍ' : 'NO'));
            
            //  Preparar respuesta
            $response = [
                'success' => true,
                'data' => [
                    'id_proveedor' => $proveedor->id_proveedor,
                    'nombre' => $proveedor->nombre,
                    'rif' => $proveedor->rif,
                    'correo' => $proveedor->correo,
                    'telefono' => $proveedor->telefono,
                    'direccion' => $proveedor->direccion,
                    'fecha_registro' => $proveedor->fecha_registro,
                    'bancos' => $bancos ? [
                        'id_Banco' => $bancos->id_Banco,
                        'pagomovil' => $bancos->pagomovil,
                        'bancos1' => $bancos->bancos1,
                        'bancos2' => $bancos->bancos2
                    ] : null
                ]
            ];
            
            Log::info('=== FINALIZANDO verProveedor ===');
            
            return response()->json($response);
            
        } catch (\Exception $e) {
            Log::error('ERROR en verProveedor ID ' . $id . ': ' . $e->getMessage());
            Log::error('Traza: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'error' => 'Error interno del servidor',
                'debug' => $e->getMessage()
            ], 500);
        }
    }

    // Método para guardar nuevo proveedor 
    public function guardarProve(Request $request)
    {
        Log::info('=== INICIANDO guardarProve ===');
        Log::info('Datos recibidos: ' . json_encode($request->all()));
        
        $request->validate([
            // Datos del proveedor (obligatorios)
            'nombre' => 'required|string|min:3|max:255',
            'tipo_rif' => 'required|string|size:1|in:J,V,G,E',
            'numero_rif' => 'required|string|min:6|max:20|regex:/^\d+(-\d+)?$/',
            'correo' => 'nullable|email|max:255',
            'telefono' => 'required|string|min:10|max:20',
            'direccion' => 'nullable|string|max:500',
            
            // Datos bancarios 
            'pagomovil' => 'nullable|string|max:500',
            'bancos1' => 'nullable|string|max:500',
            'bancos2' => 'nullable|string|max:500',
        ]);

        $rifCompleto = strtoupper($request->tipo_rif . '-' . $request->numero_rif);
        
        // Verificar si el RIF ya existe
        $rifExistente = DB::table('proveedores')->where('rif', $rifCompleto)->first();
        if ($rifExistente) {
            return response()->json([
                'success' => false,
                'errors' => ['numero_rif' => ['Este RIF ya está registrado.']]
            ], 422);
        }

        try {
            DB::beginTransaction();
            
            Log::info('Creando proveedor...');
            //  Crear proveedor
            $idProveedor = DB::table('proveedores')->insertGetId([
                'nombre' => $request->nombre,
                'rif' => $rifCompleto,
                'correo' => $request->correo,
                'telefono' => $request->telefono,
                'direccion' => $request->direccion,
                'fecha_registro' => now(),
            ]);
            
            Log::info('Proveedor creado ID: ' . $idProveedor);
            
            if ($request->pagomovil || $request->bancos1 || $request->bancos2) {
                Log::info('Creando datos bancarios...');
                DB::table('bancos')->insert([
                    'id_proveedor' => $idProveedor,
                    'pagomovil' => $request->pagomovil,
                    'bancos1' => $request->bancos1,
                    'bancos2' => $request->bancos2,
                ]);
                Log::info('Datos bancarios creados');
            } else {
                Log::info('No se crearon datos bancarios (opcionales)');
            }
            
            DB::commit();
            
            Log::info('=== TRANSACCIÓN COMPLETADA ===');
            
            return response()->json([
                'success' => true,
                'message' => 'Proveedor creado exitosamente.'
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error en guardarProve: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al crear el proveedor: ' . $e->getMessage()
            ], 500);
        }
    }

    // Método para actualizar proveedor 
    public function actualizarProve(Request $request, $id)
    {
        Log::info('=== INICIANDO actualizarProve ID: ' . $id . ' ===');
        Log::info('Datos recibidos: ' . json_encode($request->all()));
        
        // Verificar que el proveedor existe
        $proveedor = DB::table('proveedores')->where('id_proveedor', $id)->first();
        if (!$proveedor) {
            return response()->json([
                'success' => false,
                'error' => 'Proveedor no encontrado'
            ], 404);
        }

        $request->validate([
            // Datos del proveedor
            'nombre' => 'required|string|min:3|max:255',
            'tipo_rif' => 'required|string|size:1|in:J,V,G,E',
            'numero_rif' => 'required|string|min:6|max:20|regex:/^\d+(-\d+)?$/',
            'correo' => 'nullable|email|max:255',
            'telefono' => 'required|string|min:10|max:20',
            'direccion' => 'nullable|string|max:500',
            
            // Datos bancarios 
            'pagomovil' => 'nullable|string|max:500',
            'bancos1' => 'nullable|string|max:500',
            'bancos2' => 'nullable|string|max:500',
        ]);

        $rifCompleto = strtoupper($request->tipo_rif . '-' . $request->numero_rif);
        
        // Verificar si el RIF ya existe para otro proveedor
        $rifExistente = DB::table('proveedores')
            ->where('rif', $rifCompleto)
            ->where('id_proveedor', '!=', $id)
            ->first();
            
        if ($rifExistente) {
            return response()->json([
                'success' => false,
                'errors' => ['numero_rif' => ['Este RIF ya está registrado por otro proveedor.']]
            ], 422);
        }

        try {
            DB::beginTransaction();
            
            Log::info('Actualizando proveedor...');
            // 1. Actualizar proveedor
            DB::table('proveedores')->where('id_proveedor', $id)->update([
                'nombre' => $request->nombre,
                'rif' => $rifCompleto,
                'correo' => $request->correo,
                'telefono' => $request->telefono,
                'direccion' => $request->direccion,
            ]);
            
            // 2. Manejar datos bancarios 
            $bancosExistente = DB::table('bancos')->where('id_proveedor', $id)->first();
            
            // Si hay datos bancarios en la solicitud
            if ($request->pagomovil || $request->bancos1 || $request->bancos2) {
                if ($bancosExistente) {
                    Log::info('Actualizando datos bancarios existentes...');
                    // Actualizar existente
                    DB::table('bancos')->where('id_proveedor', $id)->update([
                        'pagomovil' => $request->pagomovil,
                        'bancos1' => $request->bancos1,
                        'bancos2' => $request->bancos2,
                    ]);
                } else {
                    Log::info('Creando nuevos datos bancarios...');
                    // Crear nuevo
                    DB::table('bancos')->insert([
                        'id_proveedor' => $id,
                        'pagomovil' => $request->pagomovil,
                        'bancos1' => $request->bancos1,
                        'bancos2' => $request->bancos2,
                    ]);
                }
                Log::info('Datos bancarios procesados');
            } else {
                // Si no hay datos bancarios en la solicitud
                if ($bancosExistente) {
                    Log::info('Limpiando datos bancarios existentes...');
                    // Limpiar campos pero mantener el registro
                    DB::table('bancos')->where('id_proveedor', $id)->update([
                        'pagomovil' => null,
                        'bancos1' => null,
                        'bancos2' => null,
                    ]);
                } else {
                    Log::info('No hay datos bancarios para procesar');
                }
            }
            
            DB::commit();
            
            Log::info('=== ACTUALIZACIÓN COMPLETADA ===');
            
            return response()->json([
                'success' => true,
                'message' => 'Proveedor actualizado exitosamente.'
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error en actualizarProve: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el proveedor: ' . $e->getMessage()
            ], 500);
        }
    }
}