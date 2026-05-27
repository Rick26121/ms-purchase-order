<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="<?php echo e(asset('assets/images/icons/favicon.ico')); ?>"/>
	<link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/vendor/bootstrap/css/bootstrap.min.css')); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css')); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/vendor/animate/animate.css')); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/vendor/css-hamburgers/hamburgers.min.css')); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/vendor/select2/select2.min.css')); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/css/util.css')); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/css/main.css')); ?>">
</head>

<body>
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt>
					<img src="<?php echo e(asset('assets/images/favicon.png')); ?>" alt="IMG">
				</div>

				
				<form class="login100-form validate-form" method="POST" action="<?php echo e(route('login')); ?>">
					<?php echo csrf_field(); ?>

					<span class="login100-form-title">
						<?php echo e(__('Member Login')); ?>

					</span>

					
					<?php if($errors->any()): ?>
						<div class="alert alert-danger mt-2">
							<ul class="mb-0">
								<?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<li><?php echo e($error); ?></li>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</ul>
						</div>
					<?php endif; ?>

					
					<div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz">
						<input class="input100" type="email" name="email" value="<?php echo e(old('email')); ?>" placeholder="Correo Electronico" required autofocus>
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div>

					
					<div class="wrap-input100 validate-input" data-validate="Password is required">
						<input class="input100" type="password" name="password" placeholder="Contraseña" required>
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>

					
					<div class="text-start mb-3">
						<label>
							<input type="checkbox" name="remember"> <?php echo e(__('Remember me')); ?>

						</label>
					</div>

					
					<div class="container-login100-form-btn">
						<button type="submit" class="login100-form-btn">
							<?php echo e(__('Login')); ?>

						</button>
					</div>

					
					<div class="text-center p-t-12">
						<?php if(Route::has('password.request')): ?>
							<a class="txt2" href="<?php echo e(route('password.request')); ?>">
								<?php echo e(__('Forgot your password?')); ?>

							</a>
						<?php endif; ?>
					</div>

					<div class="text-center p-t-136">
						<a class="txt2" href="<?php echo e(route('register')); ?>">
							<?php echo e(__('Create your Account')); ?>

							<i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!--===============================================================================================-->	
	<script src="<?php echo e(asset('assets/vendor/jquery/jquery-3.2.1.min.js')); ?>"></script>
	<script src="<?php echo e(asset('assets/vendor/bootstrap/js/popper.js')); ?>"></script>
	<script src="<?php echo e(asset('assets/vendor/bootstrap/js/bootstrap.min.js')); ?>"></script>
	<script src="<?php echo e(asset('assets/vendor/select2/select2.min.js')); ?>"></script>
	<script src="<?php echo e(asset('assets/vendor/tilt/tilt.jquery.min.js')); ?>"></script>
	<script>
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
	<script src="<?php echo e(asset('assets/js/main.js')); ?>"></script>
</body>
</html>
<?php /**PATH /var/www/html/resources/views/auth/login.blade.php ENDPATH**/ ?>