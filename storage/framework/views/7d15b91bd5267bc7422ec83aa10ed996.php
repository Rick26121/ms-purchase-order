<?php if($proveedor->count() > 0): ?>
    <?php $__currentLoopData = $proveedor; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr>
        <td><?php echo e($item->id_proveedor); ?></td>
        <td><?php echo e($item->nombre); ?></td>
        <td><?php echo e($item->rif); ?></td>
        <td><?php echo e($item->correo ?? 'N/A'); ?></td>
        <td><?php echo e($item->telefono ?? 'N/A'); ?></td>
        <td>
            <button type="button" class="btn btn-info btn-sm btn-ver-proveedor mr-1" 
                    data-id="<?php echo e($item->id_proveedor); ?>">
                <i class="fas fa-eye"></i> Ver
            </button>
            <button type="button" class="btn btn-primary btn-sm btn-editar-proveedor" 
                    data-id="<?php echo e($item->id_proveedor); ?>">
                <i class="fas fa-edit"></i> Editar
            </button>
        </td>
    </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php else: ?>
    <tr>
        <td colspan="6" class="text-center">No hay proveedores registrados</td>
    </tr>
<?php endif; ?><?php /**PATH /var/www/html/resources/views/proveedor/partials/tabla.blade.php ENDPATH**/ ?>