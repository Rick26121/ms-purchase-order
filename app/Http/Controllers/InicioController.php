<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrdenCompra;
use App\Models\Proveedor;
use App\Models\Reportes;
use Carbon\Carbon;


class InicioController extends Controller
{
   public function inicio()
    {
        $totalOrdenes = OrdenCompra::count();
        $ordenesHoy = OrdenCompra::whereDate('created_at', Carbon::today())->count();
        $porcentajeordenes = Reportes::calcularPorcentajePendientesHoy();
        $proveedores = Proveedor::count();

        return view('principal', compact('totalOrdenes', 'ordenesHoy','porcentajeordenes', 'proveedores'));
    }
}
