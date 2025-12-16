<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Http\Controllers\OrdenesController;

// Comando inspire existente
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

use Illuminate\Support\Facades\Cache;

Schedule::call(function () {
    $horaVzla = now()->timezone('America/Caracas');
    $hoy = $horaVzla->format('Y-m-d');
    $horaActual = $horaVzla->format('H:i');
    
    // Verificar si son las 6:00 AM EXACTAS
    if ($horaActual === '06:00') {
        
        // Clave única para hoy
        $clave = 'ordenes_6am_' . $hoy;
        
        // Verificar si YA se ejecutó hoy
        if (!Cache::has($clave)) {
            try {
                \Log::info('🔄 Ejecutando actualización programada 6:00 AM');
                
                $controller = app(OrdenesController::class);
                $controller->actualizarOrdenesConTasaActual();
                
                // Marcar como ejecutado por 26 horas (más de un día por seguridad)
                Cache::put($clave, true, now()->addHours(26));
                
                \Log::info('✅ Actualización 6:00 AM completada: ' . $horaVzla);
            } catch (\Exception $e) {
                \Log::error('🔥 Error a las 6:00 AM: ' . $e->getMessage());
            }
        } else {
            \Log::warning('⚠️ Tarea 6:00 AM ya ejecutada hoy');
        }
    }
})
->everyMinute() // Verificar cada minuto para precisión
->timezone('America/Caracas')
->name('actualizar-ordenes-6am')
->description('Ejecutar solo a las 6:00 AM exactas, una vez diaria');