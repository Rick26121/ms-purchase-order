<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrdenCompra;
use Carbon\Carbon;
class ReportesController extends Controller
{
    public function generarReporte()
    {
        // 1. TOTAL DE ÓRDENES DE COMPRA
        $totalOrdenes = OrdenCompra::count();
        $ordenesHoy = OrdenCompra::whereDate('created_at', Carbon::today())->count();
        // Lógica para generar el reporte
        return view('reportes.menu', compact('totalOrdenes', 'ordenesHoy'));
    }





}
