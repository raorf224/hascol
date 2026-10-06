<?php
// Hascol OMC - Logout Confirmation Screen
session_start();

if (isset($_SESSION['user_id'])) {
    $_SESSION = [];
    session_unset();
    session_destroy();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Logged Out | Hascol OMC</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

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
        }

        @keyframes floatUp {
            0% {
                transform: translateY(100vh) scale(0);
                opacity: 0;
            }
            10% {
                opacity: 1;
            }
            90% {
                opacity: 1;
            }
            100% {
                transform: translateY(-10vh) scale(1);
                opacity: 0;
            }
        }

        /* ============ ICON PULSE RING ============ */
        .icon-ring {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .icon-ring::before,
        .icon-ring::after {
            content: '';
            position: absolute;
            inset: -8px;
            border-radius: 50%;
            border: 2px solid rgba(249, 115, 22, 0.3);
            animation: pulseRing 2.5s ease-out infinite;
        }

        .icon-ring::after {
            animation-delay: 1.25s;
        }

        @keyframes pulseRing {
            0% {
                transform: scale(0.8);
                opacity: 1;
            }
            100% {
                transform: scale(1.6);
                opacity: 0;
            }
        }

        /* ============ FADE-IN ANIMATIONS ============ */
        .fade-up {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeUp 0.7s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .fade-up-1 { animation-delay: 0.1s; }
        .fade-up-2 { animation-delay: 0.25s; }
        .fade-up-3 { animation-delay: 0.4s; }
        .fade-up-4 { animation-delay: 0.55s; }
        .fade-up-5 { animation-delay: 0.7s; }

        @keyframes fadeUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
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

        /* ============ LOGIN AGAIN BUTTON ============ */
        .btn-login-again {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 14px 32px;
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
            color: #ffffff;
            font-size: 14px;
            font-weight: 600;
            border-radius: 9999px;
            border: none;
            cursor: pointer;
            text-decoration: none;
            box-shadow: 0 10px 30px -10px rgba(249, 115, 22, 0.5);
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            overflow: hidden;
        }

        .btn-login-again::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, #ea580c 0%, #dc2626 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: -1;
        }

        .btn-login-again:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 40px -12px rgba(249, 115, 22, 0.7);
        }

        .btn-login-again:hover::before {
            opacity: 1;
        }

        .btn-login-again:active {
            transform: translateY(0);
        }

        .btn-login-again i {
            transition: transform 0.3s ease;
        }

        .btn-login-again:hover i {
            transform: translateX(4px);
        }

        /* ============ SHIMMER EFFECT ============ */
        .btn-login-again::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.6s ease;
        }

        .btn-login-again:hover::after {
            left: 100%;
        }

        /* ============ INFO CHIP ============ */
        .info-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            background: #f1f5f9;
            color: #64748b;
            font-size: 11px;
            font-weight: 500;
            border-radius: 9999px;
        }

        .info-chip i {
            color: #10b981;
            font-size: 10px;
        }

        /* ============ IMAGE SIDE OVERLAY ============ */
        .image-side::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.5) 0%, rgba(0, 0, 0, 0.2) 50%, rgba(0, 0, 0, 0.6) 100%);
        }

        /* ============ RESPONSIVE ============ */
        @media (max-width: 768px) {
            .glow-orb { opacity: 0.3; }
        }
    </style>
</head>

<body>

    <div class="flex flex-col md:flex-row min-h-screen">

        <!-- LEFT: Image with gradient overlay -->
        <div class="w-full md:w-[80%] h-64 md:h-screen relative overflow-hidden image-side">
            <img src="logo/hasco.png" alt="Hascol" class="w-full h-full object-cover object-center">

            <!-- Floating particles on image -->
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div class="particle" style="left: 15%; animation-duration: 8s; animation-delay: 0s;"></div>
                <div class="particle" style="left: 35%; animation-duration: 12s; animation-delay: 2s;"></div>
                <div class="particle" style="left: 55%; animation-duration: 10s; animation-delay: 4s;"></div>
                <div class="particle" style="left: 75%; animation-duration: 9s; animation-delay: 1s;"></div>
                <div class="particle" style="left: 90%; animation-duration: 11s; animation-delay: 3s;"></div>
            </div>

        </div>

        <!-- RIGHT: Logout Card -->
        <div class="w-full md:w-[20%] flex items-center justify-center bg-white p-6 md:p-8 relative overflow-hidden">

            <!-- Background glow orbs -->
            <div class="glow-orb orange"></div>
            <div class="glow-orb blue"></div>

            <div class="w-full max-w-sm text-center relative z-10">

                <!-- Icon with pulse rings -->
                <div class="fade-up fade-up-1 mb-6">
                    <div class="icon-ring inline-flex items-center justify-center w-16 h-16 rounded-full bg-gradient-to-br from-orange-500 to-red-500 shadow-lg shadow-orange-500/30">
                        <i class="fa-solid fa-check text-white text-2xl"></i>
                    </div>
                </div>

    

                <!-- Heading -->
                <h1 class="fade-up fade-up-3 text-3xl font-extrabold text-slate-800 mb-3 leading-tight">
                    You're <span class="gradient-text">Logged Out</span>
                </h1>

                <!-- Subtext -->
                <!-- <p class="fade-up fade-up-4 text-sm text-slate-500 mb-1 leading-relaxed">
                    Your session has been closed successfully.
                </p> -->
                <p class="fade-up fade-up-4 text-xs text-slate-400 mb-8">
                    Thank you for using <span class="font-semibold text-slate-600">SaleBridge 3.0</span>
                </p>

                <!-- Login Again Button -->
                <div class="fade-up fade-up-5">
                    <a href="login.php" class="btn-login-again">
                        <i class="fa-solid fa-right-to-bracket"></i>
                        Login Again
                    </a>
                </div>

                <!-- Divider -->
                <div class="fade-up fade-up-5 flex items-center justify-center gap-3 my-8">
                    <span class="h-px w-12 bg-slate-200"></span>
                    <span class="text-[10px] text-slate-400 tracking-widest uppercase">Secure Connection</span>
                    <span class="h-px w-12 bg-slate-200"></span>
                </div>

                <!-- Footer -->
                <p class="fade-up fade-up-5 text-[11px] text-slate-400">
                    &copy; <?php echo date('Y'); ?> SaleBridge 3.0. All rights reserved.
                </p>

            </div>

        </div>

    </div>

</body>

</html>