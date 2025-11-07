<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title>Login - <?php echo e(config('app.name', 'Stockify')); ?></title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        :root {
            --primary-color: #374151; /* Professional Gray */
            --secondary-color: #ffffff; /* Pure white */
            --dark-color: #1f2937;
            --light-bg: #f8fafc;
            --white: #ffffff;
            --text-gray: #6b7280;
            --border-color: #e5e7eb;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--white);
            color: var(--dark-color);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-container {
            background: var(--white);
            border-radius: 16px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
            max-width: 900px;
            width: 100%;
            display: flex;
            min-height: 500px;
        }

        .login-left {
            flex: 1;
            background: var(--light-bg);
            color: var(--dark-color);
            padding: 60px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
        }

        .login-left::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(0,0,0,0.05)"/><circle cx="75" cy="75" r="1" fill="rgba(0,0,0,0.05)"/><circle cx="50" cy="10" r="0.5" fill="rgba(0,0,0,0.05)"/><circle cx="10" cy="50" r="0.5" fill="rgba(0,0,0,0.05)"/><circle cx="90" cy="30" r="0.5" fill="rgba(0,0,0,0.05)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
        }

        .login-left h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            position: relative;
            z-index: 1;
            color: var(--dark-color);
        }

        .login-left p {
            font-size: 1.1rem;
            opacity: 0.8;
            margin-bottom: 2rem;
            position: relative;
            z-index: 1;
            color: var(--text-gray);
        }

        .login-left .logo {
            position: absolute;
            top: 40px;
            left: 40px;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-color);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            z-index: 1;
        }

        .login-left .logo i {
            font-size: 2rem;
        }

        .login-right {
            flex: 1;
            padding: 60px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-form h2 {
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--dark-color);
        }

        .login-form p {
            color: var(--text-gray);
            margin-bottom: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: var(--dark-color);
        }

        .form-group input[type="email"],
        .form-group input[type="password"] {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid var(--border-color);
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .form-group input[type="email"]:focus,
        .form-group input[type="password"]:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(55, 65, 81, 0.1);
        }

        .form-group .error {
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .checkbox-group input[type="checkbox"] {
            margin-right: 0.5rem;
        }

        .checkbox-group label {
            font-size: 0.875rem;
            color: var(--text-gray);
        }

        .btn-login {
            width: 100%;
            background: var(--primary-color);
            color: var(--white);
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
        }

        .btn-login:hover {
            background: #1f2937;
            transform: translateY(-1px);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .forgot-password {
            text-align: center;
            margin-top: 1rem;
        }

        .forgot-password a {
            color: var(--primary-color);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .forgot-password a:hover {
            text-decoration: underline;
        }

        .register-link {
            text-align: center;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid var(--border-color);
        }

        .register-link a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
                max-width: 400px;
            }

            .login-left {
                padding: 40px 30px;
                text-align: center;
            }

            .login-left .logo {
                position: static;
                margin-bottom: 2rem;
            }

            .login-right {
                padding: 40px 30px;
            }

            .login-left h1 {
                font-size: 2rem;
            }
        }

        /* Animation */
        .fade-in {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeIn 0.6s ease-out forwards;
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <div class="login-container fade-in">
        <!-- Left Side -->
        <div class="login-left">
            <div class="logo">
                <i class="bi bi-box-seam-fill"></i> Stockify
            </div>
            <h1>Selamat Datang Kembali</h1>
            <p>Kelola stok barang Anda dengan mudah dan efisien. Masuk ke akun Anda untuk melanjutkan.</p>
        </div>

        <!-- Right Side -->
        <div class="login-right">
            <div class="login-form">
                <h2>Masuk ke Akun</h2>
                <p>Masukkan kredensial Anda untuk melanjutkan</p>

                <!-- Session Status -->
                <?php if(session('status')): ?>
                    <div class="alert alert-success" style="padding: 12px 16px; border-radius: 8px; background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; margin-bottom: 1rem;">
                        <?php echo e(session('status')); ?>

                    </div>
                <?php endif; ?>

                <form method="POST" action="<?php echo e(route('login')); ?>">
                    <?php echo csrf_field(); ?>

                    <!-- Email Address -->
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input id="email" type="email" name="email" value="<?php echo e(old('email')); ?>" required autofocus autocomplete="username">
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="error"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input id="password" type="password" name="password" required autocomplete="current-password">
                        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="error"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Remember Me -->
                    <div class="checkbox-group">
                        <input id="remember_me" type="checkbox" name="remember">
                        <label for="remember_me">Ingat saya</label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-login">
                        Masuk
                    </button>
                </form>

                <!-- Forgot Password -->
                <?php if(Route::has('password.request')): ?>
                    <div class="forgot-password">
                        <a href="<?php echo e(route('password.request')); ?>">Lupa password?</a>
                    </div>
                <?php endif; ?>

                <!-- Register Link -->
                <div class="register-link">
                    Belum punya akun? <a href="<?php echo e(route('register')); ?>">Daftar sekarang</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\laragon\www\stockify\resources\views/auth/login.blade.php ENDPATH**/ ?>