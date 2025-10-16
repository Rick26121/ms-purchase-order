<?php
// app/Services/TasaCambioService.php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Exception;

class TasaCambioService
{
    private $apiUrl = 'https://api.dolarvzla.com/public/exchange-rate';

    public function obtenerTasas()
    {
        try {
            return Cache::remember('tasas_cambio', 300, function () {
                $response = Http::timeout(10)->get($this->apiUrl);
                
                if ($response->successful()) {
                    $data = $response->json();
                    return $data['current'] ?? null;
                }
                
                throw new Exception('Error en la respuesta de la API');
            });
        } catch (Exception $e) {
            \Log::error('Error obteniendo tasas: ' . $e->getMessage());
            return null;
        }
    }

    public function getTasa($moneda = 'usd')
    {
        $tasas = $this->obtenerTasas();
        
        if (!$tasas) {
            return 'Error';
        }

        return match($moneda) {
            'usd' => number_format($tasas['usd'], 2),
            'eur' => number_format($tasas['eur'], 2),
            default => 'Error'
        };
    }
}