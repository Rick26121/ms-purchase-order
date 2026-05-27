

<?php $__env->startSection('title', 'Mi Panel'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1>Dashboard</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('home', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?> 
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/principal.blade.php ENDPATH**/ ?>