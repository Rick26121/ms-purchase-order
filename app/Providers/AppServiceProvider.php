<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\TasaCambioService;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Registrar filtro para el menú de AdminLTE
        $this->app->resolving('adminlte', function ($adminlte, $app) {
            $tasaService = app(TasaCambioService::class);
            $tasaUsd = $tasaService->getTasa('usd');
            
            // Modificar el menú dinámicamente
            $menu = $adminlte['menu'];
            
            foreach ($menu as &$item) {
                // Busca el item que quieres modificar (por texto o URL)
                if (isset($item['url']) && $item['url'] === 'admin/pages') {
                    $item['label'] = $tasaUsd;
                    break; // Opcional: salir después de encontrar el item
                }
            }
            
            $adminlte['menu'] = $menu;
        });
    }
}