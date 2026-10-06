<?php
// Hascol OMC - Login Screen
session_start();
if (isset($_SESSION['user_id'])) {
    header('Location: users.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Login | Hascol OMC</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        body {
            margin: 0;
            min-height: 100vh;
            overflow: hidden;
        }

        /* ============ ANIMATED BACKGROUND GLOW ============ */
        .glow-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.4;
            animation: floatOrb 12s ease-in-out infinite;
            pointer-events: none;
        }

        .glow-orb.orange {
            background: radial-gradient(circle, #f97316 0%, transparent 70%);
            width: 400px;
            height: 400px;
            top: -100px;
            right: -100px;
        }

        .glow-orb.blue {
            background: radial-gradient(circle, #3b82f6 0%, transparent 70%);
            width: 350px;
            height: 350px;
            bottom: -120px;
            left: -80px;
            animation-delay: 3s;
        }

        @keyframes floatOrb {
            0%, 100% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(30px, -30px) scale(1.1); }
        }

        /* ============ FLOATING PARTICLES ============ */
        .particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: rgba(249, 115, 22, 0.6);
            border-radius: 50%;
            animation: floatUp linear infinite;
            pointer-events: none;
        }

        @keyframes floatUp {
            0% { transform: translateY(100vh) scale(0); opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { transform: translateY(-10vh) scale(1); opacity: 0; }
        }

        /* ============ LOGO PULSE RING ============ */
        .logo-ring {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .logo-ring::before,
        .logo-ring::after {
            content: '';
            position: absolute;
            inset: -6px;
            border-radius: 50%;
            border: 2px solid rgba(249, 115, 22, 0.3);
            animation: pulseRing 2.5s ease-out infinite;
        }

        .logo-ring::after {
            animation-delay: 1.25s;
        }

        @keyframes pulseRing {
            0% { transform: scale(0.9); opacity: 1; }
            100% { transform: scale(1.6); opacity: 0; }
        }

        /* ============ FADE-IN ANIMATIONS ============ */
        .fade-up {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeUp 0.7s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .fade-up-1 { animation-delay: 0.1s; }
        .fade-up-2 { animation-delay: 0.2s; }
        .fade-up-3 { animation-delay: 0.3s; }
        .fade-up-4 { animation-delay: 0.4s; }
        .fade-up-5 { animation-delay: 0.5s; }
        .fade-up-6 { animation-delay: 0.6s; }
        .fade-up-7 { animation-delay: 0.7s; }

        @keyframes fadeUp {
            to { opacity: 1; transform: translateY(0); }
        }

        /* ============ GRADIENT TEXT ============ */
        .gradient-text {
            background: linear-gradient(135deg, #f97316 0%, #ea580c 50%, #dc2626 100%);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            background-size: 200% auto;
            animation: gradientShift 4s ease infinite;
        }

        @keyframes gradientShift {
            0%, 100% { background-position: 0% center; }
            50% { background-position: 100% center; }
        }

        /* ============ INPUT WRAPPER ============ */
        .input-wrapper {
            position: relative;
        }

        .input-wrapper .input-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 13px;
            transition: color 0.25s ease, transform 0.25s ease;
            pointer-events: none;
            z-index: 2;
        }

        .input-wrapper.focused .input-icon {
            color: #f97316;
            transform: translateY(-50%) scale(1.15);
        }

        .login-input {
            background-color: #ffffff;
            border: 1.5px solid #e2e8f0;
            border-radius: 0.5rem;
            color: #1e293b;
            padding: 12px 14px 12px 38px;
            width: 100%;
            font-size: 13px;
            transition: all 0.25s ease;
            box-sizing: border-box;
        }

        .login-input:focus {
            outline: none;
            border-color: #f97316;
            box-shadow: 0 0 0 4px rgba(249, 115, 22, 0.12);
            background-color: #fffbf7;
        }

        .login-input::placeholder {
            color: #cbd5e1;
            transition: opacity 0.2s ease;
        }

        .login-input:focus::placeholder {
            opacity: 0.5;
        }

        /* ============ PASSWORD TOGGLE ============ */
        .eye-toggle {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            cursor: pointer;
            font-size: 13px;
            transition: color 0.2s ease, transform 0.2s ease;
            z-index: 2;
        }

        .eye-toggle:hover {
            color: #f97316;
            transform: translateY(-50%) scale(1.15);
        }

        /* ============ LOGIN BUTTON ============ */
        .login-btn {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 12px 24px;
            width: 100%;
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
            color: #ffffff;
            font-size: 13px;
            font-weight: 600;
            border-radius: 0.5rem;
            border: none;
            cursor: pointer;
            box-shadow: 0 10px 30px -10px rgba(249, 115, 22, 0.5);
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            overflow: hidden;
            letter-spacing: 0.02em;
        }

        .login-btn:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 20px 40px -12px rgba(249, 115, 22, 0.7);
        }

        .login-btn:active:not(:disabled) {
            transform: translateY(0);
        }

        .login-btn:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }

        .login-btn::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.6s ease;
        }

        .login-btn:hover:not(:disabled)::after {
            left: 100%;
        }

        .login-btn i {
            transition: transform 0.3s ease;
        }

        .login-btn:hover:not(:disabled) i {
            transform: translateX(4px);
        }

        /* ============ IMAGE SIDE OVERLAY ============ */
        .image-side::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.5) 0%, rgba(0, 0, 0, 0.15) 50%, rgba(0, 0, 0, 0.6) 100%);
            pointer-events: none;
        }

        /* ============ CAPS LOCK WARNING ============ */
        .caps-warning {
            display: none;
            align-items: center;
            gap: 6px;
            font-size: 11px;
            color: #f59e0b;
            margin-top: 6px;
        }

        .caps-warning.show {
            display: flex;
        }

        /* ============ DIVIDER ============ */
        .divider-text {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 20px 0;
        }

        .divider-text span:first-child,
        .divider-text span:last-child {
            flex: 1;
            height: 1px;
            background: #e2e8f0;
        }

        .divider-text span:nth-child(2) {
            font-size: 10px;
            color: #94a3b8;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            white-space: nowrap;
        }

        /* ============ RESPONSIVE ============ */
        @media (max-width: 768px) {
            .glow-orb { opacity: 0.3; }
        }
    </style>
</head>

<body>

    <div class="flex flex-col md:flex-row min-h-screen">

        <!-- LEFT: Image -->
        <div class="w-full md:w-[80%] h-64 md:h-screen relative overflow-hidden image-side">
            <img src="logo/hasco.png" alt="Hascol" class="w-full h-full object-cover object-center">

            <!-- Floating particles -->
            <div class="absolute inset-0 overflow-hidden">
                <div class="particle" style="left: 15%; animation-duration: 8s; animation-delay: 0s;"></div>
                <div class="particle" style="left: 35%; animation-duration: 12s; animation-delay: 2s;"></div>
                <div class="particle" style="left: 55%; animation-duration: 10s; animation-delay: 4s;"></div>
                <div class="particle" style="left: 75%; animation-duration: 9s; animation-delay: 1s;"></div>
                <div class="particle" style="left: 90%; animation-duration: 11s; animation-delay: 3s;"></div>
            </div>

            <!-- Text on image -->
            <div class="absolute bottom-10 left-10 z-10 hidden md:block">
                <p class="text-white/70 text-xs tracking-[0.3em] uppercase mb-2">SaleBridge 3.0</p>
                <p class="text-white text-2xl font-bold leading-tight">Fueling the<br>Nation's Progress</p>
            </div>
        </div>

        <!-- RIGHT: Login Card -->
        <div class="w-full md:w-[20%] flex items-center justify-center bg-white p-6 md:p-8 relative overflow-hidden">

            <!-- Background glow orbs -->
            <div class="glow-orb orange"></div>
            <div class="glow-orb blue"></div>

            <div class="w-full max-w-sm relative z-10">

                <!-- Logo / Title -->
                <div class="text-center mb-6">
                    <div class="fade-up fade-up-1 mb-4">
                        <div class="logo-ring inline-flex items-center justify-center w-14 h-14 rounded-full bg-gradient-to-br from-orange-500 to-red-500 shadow-lg shadow-orange-500/30">
                            <i class="fa-solid fa-gas-pump text-white text-lg"></i>
                        </div>
                    </div>
                    <h1 class="fade-up fade-up-2 text-2xl font-extrabold text-slate-800 mb-1">
                        <span class="gradient-text">P2P Track</span>
                    </h1>
                    <p class="fade-up fade-up-2 text-xs text-slate-500">Sign in to your account</p>
                </div>

                <!-- OMC Icons strip -->
                <div class="fade-up fade-up-3 flex justify-center gap-5 mb-6 text-slate-300">
                    <i class="fa-solid fa-gas-pump text-base"></i>
                    <i class="fa-solid fa-oil-can text-base"></i>
                    <i class="fa-solid fa-truck text-base"></i>
                    <i class="fa-solid fa-fire-flame-simple text-base"></i>
                </div>

                <!-- Form -->
                <form id="loginForm" autocomplete="off">

                    <!-- Username -->
                    <div class="fade-up fade-up-4 mb-4">
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Email</label>
                        <div class="input-wrapper" id="userWrapper">
                            <i class="fa-regular fa-user input-icon"></i>
                            <input type="text" id="login" name="login" class="login-input"
                                placeholder="Enter your username" required autocomplete="off">
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="fade-up fade-up-5 mb-5">
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Password</label>
                        <div class="input-wrapper" id="passWrapper">
                            <i class="fa-solid fa-lock input-icon"></i>
                            <input type="password" id="password" name="password" class="login-input"
                                placeholder="Enter your password" required autocomplete="off" style="padding-right:40px;">
                            <i class="fa-regular fa-eye eye-toggle" id="togglePassword"></i>
                        </div>
                        <div class="caps-warning" id="capsWarning">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                            <span>Caps Lock is on</span>
                        </div>
                    </div>

                    <!-- Login Button -->
                    <div class="fade-up fade-up-6">
                        <button type="submit" class="login-btn" id="loginBtn">
                            <i class="fa-solid fa-right-to-bracket"></i> Login
                        </button>
                    </div>

                </form>

                <!-- Divider -->
                <div class="fade-up fade-up-7 divider-text">
                    <span></span>
                    <span>Secure Connection</span>
                    <span></span>
                </div>

                <!-- Footer -->
                <p class="fade-up fade-up-7 text-center text-[11px] text-slate-400">
                    &copy; <?php echo date('Y'); ?> SaleBridge 3.0. All rights reserved.
                </p>

            </div>

        </div>

    </div>

    <script>
        const API_BASE = 'api/auth/';
        const API_KEY = '03201232927';

        $(document).ready(function () {

            // ============ INPUT FOCUS ANIMATIONS ============
            $('.login-input').on('focus', function () {
                $(this).closest('.input-wrapper').addClass('focused');
            }).on('blur', function () {
                $(this).closest('.input-wrapper').removeClass('focused');
            });

            // ============ SHOW / HIDE PASSWORD ============
            $('#togglePassword').on('click', function () {
                const input = $('#password');
                const type = input.attr('type') === 'password' ? 'text' : 'password';
                input.attr('type', type);
                $(this).toggleClass('fa-eye fa-eye-slash');
            });

            // ============ CAPS LOCK DETECTION ============
            $('#password').on('keyup keydown', function (e) {
                const capsOn = e.originalEvent.getModifierState && e.originalEvent.getModifierState('CapsLock');
                if (capsOn) {
                    $('#capsWarning').addClass('show');
                } else {
                    $('#capsWarning').removeClass('show');
                }
            });

            // ============ LOGIN SUBMIT ============
            $('#loginForm').on('submit', function (e) {
                e.preventDefault();

                const login = $('#login').val().trim();
                const password = $('#password').val().trim();

                if (!login || !password) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Required',
                        text: 'Please enter username and password',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    return;
                }

                const btn = $('#loginBtn');
                btn.prop('disabled', true);
                btn.html('<i class="fa-solid fa-spinner fa-spin"></i> Signing in...');

                const url = API_BASE + 'login.php?key=' + API_KEY;

                $.ajax({
                    url: url,
                    method: 'POST',
                    dataType: 'json',
                    data: { login: login, password: password },
                    timeout: 30000,
                    success: function (response) {
                        console.log('Login Response:', response);

                        if (response.status === 1) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Welcome!',
                                text: response.message || 'Login successful',
                                timer: 1200,
                                showConfirmButton: false
                            }).then(function () {
                                window.location.href = response.redirect || 'users.php';
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Login Failed',
                                text: response.message || 'Invalid credentials'
                            });
                            btn.prop('disabled', false);
                            btn.html('<i class="fa-solid fa-right-to-bracket"></i> Login');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('Login Error:', status, error);
                        console.error('Raw response:', xhr.responseText);

                        Swal.fire({
                            icon: 'error',
                            title: 'Server Error',
                            text: 'Request failed: ' + error
                        });

                        btn.prop('disabled', false);
                        btn.html('<i class="fa-solid fa-right-to-bracket"></i> Login');
                    }
                });
            });

        });
    </script>

</body>

</html>