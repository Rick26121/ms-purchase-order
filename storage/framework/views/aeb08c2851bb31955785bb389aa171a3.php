<?php $layoutHelper = app('JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper'); ?>
<?php $preloaderHelper = app('JeroenNoten\LaravelAdminLte\Helpers\PreloaderHelper'); ?>

<?php $__env->startSection('adminlte_css'); ?>
    <?php echo $__env->yieldPushContent('css'); ?>
    <?php echo $__env->yieldContent('css'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('classes_body', $layoutHelper->makeBodyClasses()); ?>

<?php $__env->startSection('body_data', $layoutHelper->makeBodyData()); ?>

<?php $__env->startSection('body'); ?>
    <div class="wrapper">

        
        <?php if($preloaderHelper->isPreloaderEnabled()): ?>
            <?php echo $__env->make('adminlte::partials.common.preloader', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php endif; ?>

        
        <?php if($layoutHelper->isLayoutTopnavEnabled()): ?>
            <?php echo $__env->make('adminlte::partials.navbar.navbar-layout-topnav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php else: ?>
            <?php echo $__env->make('adminlte::partials.navbar.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php endif; ?>

        
        <?php if(!$layoutHelper->isLayoutTopnavEnabled()): ?>
            <?php echo $__env->make('adminlte::partials.sidebar.left-sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php endif; ?>

        
        <?php if(empty($iFrameEnabled)): ?>
            <?php echo $__env->make('adminlte::partials.cwrapper.cwrapper-default', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php else: ?>
            <?php echo $__env->make('adminlte::partials.cwrapper.cwrapper-iframe', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php endif; ?>

        
        <?php if (! empty(trim($__env->yieldContent('footer')))): ?>
            <?php echo $__env->make('adminlte::partials.footer.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php endif; ?>

        
        <?php if($layoutHelper->isRightSidebarEnabled()): ?>
            <?php echo $__env->make('adminlte::partials.sidebar.right-sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php endif; ?>

    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('adminlte_js'); ?>
    <?php echo $__env->yieldPushContent('js'); ?>
    <?php echo $__env->yieldContent('js'); ?>
    
    
    <script>
    /*async function actualizarTasaMenu() {
        try {
            const response = await fetch('https://api.dolarvzla.com/public/exchange-rate');
            const data = await response.json();
            
            if (data && data.current && data.current.usd) {
                const tasaUSD = data.current.usd.toFixed(2);
                
                // Buscar el item del menú y actualizar el label
                const menuItems = document.querySelectorAll('.nav-sidebar .nav-item a.nav-link');
                
                menuItems.forEach(item => {
                    // Buscar por texto "USD" o por icono de dollar
                    if (item.innerHTML.includes('fa-dollar-sign') || 
                        item.textContent.includes('USD') || 
                        item.textContent.includes('Tasa')) {
                        
                        let badge = item.querySelector('.badge');
                        if (!badge) {
                            // Crear badge si no existe
                            badge = document.createElement('span');
                            badge.className = 'badge badge-success right';
                            item.appendChild(badge);
                        }
                        badge.textContent = tasaUSD;
                    }
                });
            }
        } catch (error) {
            console.error('Error obteniendo tasa:', error);
            
            // Mostrar error en el menú
            const menuItems = document.querySelectorAll('.nav-sidebar .nav-item a.nav-link');
            menuItems.forEach(item => {
                if (item.innerHTML.includes('fa-dollar-sign') || 
                    item.textContent.includes('USD')) {
                    
                    let badge = item.querySelector('.badge');
                    if (badge) {
                        badge.textContent = 'Error';
                    }
                }
            });
        }
    }
     





    // Ejecutar cuando el DOM esté listo
    document.addEventListener('DOMContentLoaded', function() {
        actualizarTasaMenu();
        
        // Actualizar cada 5 minutos
        setInterval(actualizarTasaMenu, 300000);
    });*/ 
//temporal 
async function actualizarTasaMenu() {
    try {
        // Usar tu propia API
        const response = await fetch('http://192.168.101.12:8004/tasas');
        
        // Verificar si la respuesta es exitosa
        if (!response.ok) {
            throw new Error(`Error HTTP: ${response.status}`);
        }
        
        const data = await response.json();
        
        // Verificar la estructura de tu API
        if (data && data.status === 'success' && data.dolar) {
            const tasaUSD = parseFloat(data.dolar).toFixed(2);
            
            // Buscar el item del menú y actualizar el label
            const menuItems = document.querySelectorAll('.nav-sidebar .nav-item a.nav-link');
            
            menuItems.forEach(item => {
                // Buscar por texto "USD" o por icono de dollar
                if (item.innerHTML.includes('fa-dollar-sign') || 
                    item.textContent.includes('USD') || 
                    item.textContent.includes('Tasa')) {
                    
                    let badge = item.querySelector('.badge');
                    if (!badge) {
                        // Crear badge si no existe
                        badge = document.createElement('span');
                        badge.className = 'badge badge-success right';
                        item.appendChild(badge);
                    }
                    badge.textContent = tasaUSD;
                }
            });
            
            return tasaUSD; // Opcional: retornar la tasa para uso posterior
        } else {
            throw new Error('Estructura de datos inesperada');
        }
    } catch (error) {
        console.error('Error obteniendo tasa:', error);
        
        // Mostrar error en el menú
        const menuItems = document.querySelectorAll('.nav-sidebar .nav-item a.nav-link');
        menuItems.forEach(item => {
            if (item.innerHTML.includes('fa-dollar-sign') || 
                item.textContent.includes('USD') || 
                item.textContent.includes('Tasa')) {
                
                let badge = item.querySelector('.badge');
                if (!badge) {
                    badge = document.createElement('span');
                    badge.className = 'badge badge-danger right';
                    item.appendChild(badge);
                } else {
                    badge.className = 'badge badge-danger right';
                }
                badge.textContent = 'Error';
            }
        });
        
        return null;
    }
}
// Función para actualizar periódicamente (cada 5 minutos)
function iniciarActualizacionTasa() {
    // Ejecutar inmediatamente
    actualizarTasaMenu();
    
    // Actualizar cada 5 minutos (300000 ms)
    setInterval(actualizarTasaMenu, 5 * 60 * 1000);
}

// Llamar cuando la página cargue
document.addEventListener('DOMContentLoaded', iniciarActualizacionTasa);






    </script>
    
<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/vendor/jeroennoten/laravel-adminlte/src/../resources/views/page.blade.php ENDPATH**/ ?>