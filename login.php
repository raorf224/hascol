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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            min-height: 100vh;
        }

        .login-input {
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 0.375rem;
            color: #1e293b;
            padding: 10px 12px;
            width: 100%;
            font-size: 13px;
            transition: border-color 0.2s, box-shadow 0.2s;
            box-sizing: border-box;
        }

        .login-input:focus {
            outline: none;
            border-color: #f97316;
            box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.15);
        }

        .login-btn {
            background-color: #f97316;
            color: #ffffff;
            padding: 10px;
            border-radius: 0.375rem;
            border: none;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.2s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .login-btn:hover {
            background-color: #ea580c;
        }

        .login-btn:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }

        .eye-toggle {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            cursor: pointer;
            font-size: 13px;
        }

        .eye-toggle:hover {
            color: #f97316;
        }
    </style>
</head>

<body>

    <div class="flex flex-col md:flex-row min-h-screen">

        <!-- LEFT: Image (wider now) -->
        <div class="w-full md:w-[80%] h-64 md:h-screen relative">
            <img src="logo/hasco.png" alt="Hascol" class="w-full h-full object-cover object-center">
            <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
        </div>

        <!-- RIGHT: Login Card (narrower now) -->
        <div class="w-full md:w-[20%] flex items-center justify-center bg-white p-6 md:p-8">

            <div class="w-full max-w-sm">

                <!-- Logo / Title -->
                <div class="text-center mb-6">
                    <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-orange-50 mb-3">
                        <i class="fa-solid fa-gas-pump text-orange-500 text-lg"></i>
                    </div>
                    <h1 class="text-xl font-bold text-slate-800">P2P Track</h1>
                    <p class="text-xs text-slate-500 mt-1">Sign in to your account</p>
                </div>

                <!-- OMC Icons strip -->
                <div class="flex justify-center gap-5 mb-5 text-slate-300">
                    <i class="fa-solid fa-gas-pump text-base"></i>
                    <i class="fa-solid fa-oil-can text-base"></i>
                    <i class="fa-solid fa-truck text-base"></i>
                    <i class="fa-solid fa-fire-flame-simple text-base"></i>
                </div>

                <!-- Form -->
                <form id="loginForm" autocomplete="off">

                    <div class="mb-3">
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Username</label>
                        <input type="text" id="login" name="login" class="login-input"
                            placeholder="Enter your username" required autocomplete="off">
                    </div>

                    <div class="mb-5">
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Password</label>
                        <div class="relative">
                            <input type="password" id="password" name="password" class="login-input"
                                placeholder="Enter your password" required autocomplete="off" style="padding-right:40px;">
                            <i class="fa-regular fa-eye eye-toggle" id="togglePassword"></i>
                        </div>
                    </div>

                    <button type="submit" class="login-btn" id="loginBtn">
                        <i class="fa-solid fa-right-to-bracket"></i> Login
                    </button>

                </form>

                <!-- Footer -->
                <p class="text-center text-[11px] text-slate-400 mt-6">
                    &copy; <?php echo date('Y'); ?> SaleBridge 3.0. All rights reserved.
                </p>

            </div>

        </div>

    </div>

    <script>
        const API_BASE = 'api/auth/';
        const API_KEY = '03201232927';

        $(document).ready(function () {

            // Show / hide password
            $('#togglePassword').on('click', function () {
                const input = $('#password');
                const type = input.attr('type') === 'password' ? 'text' : 'password';
                input.attr('type', type);
                $(this).toggleClass('fa-eye fa-eye-slash');
            });

            // Submit login
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