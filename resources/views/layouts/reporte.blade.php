<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Buscar Órdenes por Fecha
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="max-w-md mx-auto">
                        <form action="{{ route('ordenes.fechas') }}" method="POST" class="space-y-6">
                            @csrf
                            
                            <div>
                                <x-input-label for="fecha_inicio" :value="__('Fecha Inicio:')" />
                                <x-text-input type="date" id="fecha_inicio" name="fecha_inicio" 
                                    class="mt-1 block w-full" value="{{ $fechaHoy }}" required />
                            </div>
                            
                            <div>
                                <x-input-label for="fecha_fin" :value="__('Fecha Fin:')" />
                                <x-text-input type="date" id="fecha_fin" name="fecha_fin" 
                                    class="mt-1 block w-full" value="{{ $fechaHoy }}" required />
                            </div>
                            
                            <div>
                                <x-input-label :value="__('Filtrar por estado:')" />
                                <div class="space-y-3 mt-2">
                                    <label class="flex items-center space-x-3 cursor-pointer">
                                        <input type="radio" name="estado" value="todas" checked 
                                            class="text-blue-600 focus:ring-blue-500">
                                        <span class="text-gray-700 dark:text-gray-300">
                                            <i class="bi bi-files text-blue-500"></i> Todas las órdenes
                                        </span>
                                    </label>
                                    <label class="flex items-center space-x-3 cursor-pointer">
                                        <input type="radio" name="estado" value="aprobadas" 
                                            class="text-green-600 focus:ring-green-500">
                                        <span class="text-gray-700 dark:text-gray-300">
                                            <i class="bi bi-check-circle text-green-500"></i> Solo órdenes aprobadas
                                        </span>
                                    </label>
                                    <label class="flex items-center space-x-3 cursor-pointer">
                                        <input type="radio" name="estado" value="pendientes" 
                                            class="text-yellow-600 focus:ring-yellow-500">
                                        <span class="text-gray-700 dark:text-gray-300">
                                            <i class="bi bi-clock text-yellow-500"></i> Solo órdenes pendientes
                                        </span>
                                    </label>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-3 mt-4">
                                <x-secondary-button type="button" onclick="setToday()" class="w-full">
                                    <i class="bi bi-calendar-day"></i> Hoy
                                </x-secondary-button>
                                <x-secondary-button type="button" onclick="setYesterday()" class="w-full">
                                    <i class="bi bi-calendar-minus"></i> Ayer
                                </x-secondary-button>
                                <x-secondary-button type="button" onclick="setWeek()" class="w-full">
                                    <i class="bi bi-calendar-week"></i> Esta Semana
                                </x-secondary-button>
                                <x-secondary-button type="button" onclick="setMonth()" class="w-full">
                                    <i class="bi bi-calendar-month"></i> Este Mes
                                </x-secondary-button>
                            </div>
                            
                            <div class="mt-6">
                                <x-primary-button class="w-full justify-center">
                                    <i class="bi bi-search"></i> Generar Reporte
                                </x-primary-button>
                            </div>
                        </form>
                        
                        <div class="mt-6 space-y-3">
                            <x-secondary-link href="{{ route('ordenes.hoy') }}" class="w-full justify-center">
                                <i class="bi bi-calendar-day"></i> Ver Órdenes de Hoy
                            </x-secondary-link>
                            <x-secondary-link href="{{ route('reportes.menu') }}" class="w-full justify-center">
                                <i class="bi bi-arrow-left"></i> Volver al Menú
                            </x-secondary-link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @push('scripts')
    <script>
        function setToday() {
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('fecha_inicio').value = today;
            document.getElementById('fecha_fin').value = today;
        }
        
        function setYesterday() {
            const yesterday = new Date();
            yesterday.setDate(yesterday.getDate() - 1);
            const dateStr = yesterday.toISOString().split('T')[0];
            document.getElementById('fecha_inicio').value = dateStr;
            document.getElementById('fecha_fin').value = dateStr;
        }
        
        function setWeek() {
            const today = new Date();
            const startOfWeek = new Date(today);
            startOfWeek.setDate(today.getDate() - today.getDay());
            const endOfWeek = new Date(today);
            endOfWeek.setDate(today.getDate() + (6 - today.getDay()));
            
            document.getElementById('fecha_inicio').value = startOfWeek.toISOString().split('T')[0];
            document.getElementById('fecha_fin').value = endOfWeek.toISOString().split('T')[0];
        }
        
        function setMonth() {
            const today = new Date();
            const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
            const lastDay = new Date(today.getFullYear(), today.getMonth() + 1, 0);
            
            document.getElementById('fecha_inicio').value = firstDay.toISOString().split('T')[0];
            document.getElementById('fecha_fin').value = lastDay.toISOString().split('T')[0];
        }
        
        // Inicializar
        document.addEventListener('DOMContentLoaded', function() {
            setToday();
        });
    </script>
    @endpush
</x-app-layout>