<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\OrdenesController;

class ActualizarOrdenes extends Command
{
    protected $signature = 'ordenes:actualizar';
    protected $description = 'Actualiza órdenes con tasa actual a las 6:00 AM hora Venezuela';

    public function handle()
    {
        $this->info('Iniciando actualización de órdenes...');
        
        // Llamar al método del controlador
        $controller = app(OrdenesController::class);
        $controller->actualizarOrdenesConTasaActual();
        
        $this->info('✅ Órdenes actualizadas correctamente');
        
        return Command::SUCCESS;
    }
}