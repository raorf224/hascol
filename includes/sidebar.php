<?php
/**
 * sidebar.php - Fixed version
 * 
 * Yeh file har page par include hoti hai.
 * Base URL dynamically calculate hota hai taake links hamesha sahi jagah jayein.
 */

// ============================================================
// STEP 1: Base URL calculate karo (project root tak)
// ============================================================
// Yeh file khud include/ folder mein hai, isliye project root
// include/ se ek level upar hai.

// __DIR__ = .../hascol_dashboard/include
// dirname(__DIR__) = .../hascol_dashboard
$project_root_fs = dirname(__DIR__);

// Document root (jaise C:/xampp/htdocs ya /var/www/html)
$doc_root_fs = str_replace('\\', '/', realpath($_SERVER['DOCUMENT_ROOT']));

// Project root ko bhi normalize karo
$project_root_fs = str_replace('\\', '/', realpath($project_root_fs));

// Base URL = project root ka web path (e.g. /hascol_dashboard)
$base_url = str_replace($doc_root_fs, '', $project_root_fs);
$base_url = rtrim($base_url, '/'); // trailing slash hatao

// Agar kisi wajah se base_url khali reh gaya, to '/' set karo
if ($base_url === '') {
    $base_url = '';
}

// ============================================================
// STEP 2: Current page ka pura path nikalo (active state ke liye)
// ============================================================
$current_script = str_replace('\\', '/', $_SERVER['SCRIPT_NAME']); // e.g. /hascol_dashboard/Customers/coupons.php

// Base URL ko current script se hata do taake sirf relative path bache
$current_page = $current_script;
if ($base_url !== '' && strpos($current_script, $base_url) === 0) {
    $current_page = substr($current_script, strlen($base_url));
}
$current_page = ltrim($current_page, '/'); // e.g. Customers/coupons.php  ya  users.php

// ============================================================
// STEP 3: Active state check karne wala function
// ============================================================
function isActive($page)
{
    global $current_page;
    // Dono ko normalize karke compare karo (case-insensitive)
    $a = strtolower(trim($current_page, '/'));
    $b = strtolower(trim($page, '/'));
    return $a === $b ? 'active' : '';
}

// ============================================================
// STEP 4: URL banane wala helper function
// ============================================================
/**
 * Yeh function har link ke liye sahi absolute URL banata hai.
 * 
 * @param string $path  Project root se relative path
 *                      (e.g. 'users.php' ya 'Customers/coupons.php')
 * @return string       Absolute web path
 */
function navUrl($path)
{
    global $base_url;
    $path = ltrim($path, '/');
    return $base_url . '/' . $path;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sidebar</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
    :root {
        --rail-bg-1: rgba(255, 255, 255, .95);
        --rail-bg-2: rgba(242, 244, 248, .94);
        --rail-bg-3: rgba(238, 241, 246, .96);
        --rail-bg-solid: #EEF1F6;
        --rail-border: rgba(15, 36, 64, .08);
        --rail-shadow: rgba(15, 36, 64, .2);
        --rail-text: #334660;
        --rail-text-muted: rgba(15, 36, 64, .45);
        --rail-text-hover: rgba(15, 36, 64, .7);
        --rail-icon-bg: rgba(120, 120, 128, .12);
        --rail-icon-bg-hover: rgba(120, 120, 128, .18);
        --rail-icon-stroke: #5A6B84;
        --rail-hover-bg: rgba(15, 36, 64, .05);
        --rail-active-bg: #ffffff;
        --rail-active-text: #0F2440;
        --rail-active-shadow: 0 1px 4px rgba(15, 36, 64, .1), 0 0 0 1px rgba(15, 36, 64, .05);
        --rail-active-icon-bg: #0F2440;
        --rail-active-bar: #D11F2A;
        --rail-close-border: rgba(15, 36, 64, .12);
        --rail-close-stroke: rgba(15, 36, 64, .6);
        --rail-scrim: rgba(11, 18, 32, .5);
        --rail-scrollbar-thumb: rgba(15, 36, 64, .15);
        --rail-scrollbar-thumb-hover: rgba(15, 36, 64, .25);
        --rail-logo-bg: #ffffff;
    }

    html.dark-mode {
        --rail-bg-1: rgba(13, 21, 32, .97);
        --rail-bg-2: rgba(10, 17, 27, .96);
        --rail-bg-3: rgba(6, 11, 19, .98);
        --rail-bg-solid: #0d1520;
        --rail-border: #1a2635;
        --rail-shadow: rgba(0, 0, 0, .4);
        --rail-text: #94a3b8;
        --rail-text-muted: #64748b;
        --rail-text-hover: #e5e7eb;
        --rail-icon-bg: rgba(148, 163, 184, .12);
        --rail-icon-bg-hover: rgba(148, 163, 184, .18);
        --rail-icon-stroke: #94a3b8;
        --rail-hover-bg: #1a2635;
        --rail-active-bg: #060b13;
        --rail-active-text: #ffffff;
        --rail-active-shadow: 0 1px 4px rgba(0, 0, 0, .4), 0 0 0 1px #1a2635;
        --rail-active-icon-bg: #1d4ed8;
        --rail-active-bar: #ef4444;
        --rail-close-border: #1a2635;
        --rail-close-stroke: #94a3b8;
        --rail-scrim: rgba(0, 0, 0, .6);
        --rail-scrollbar-thumb: #1a2635;
        --rail-scrollbar-thumb-hover: #26364a;
        --rail-logo-bg: #0d1520;
    }

    .rail {
        background: linear-gradient(180deg, var(--rail-bg-1), var(--rail-bg-2) 20%, var(--rail-bg-3)),
            repeating-linear-gradient(45deg, rgba(15, 36, 64, .02) 0 1px, transparent 1px 8px),
            repeating-linear-gradient(-45deg, rgba(15, 36, 64, .012) 0 1px, transparent 1px 8px),
            var(--rail-bg-solid);
        border-right: 1px solid var(--rail-border);
        box-shadow: inset -6px 0 20px -18px var(--rail-shadow);
        width: 230px;
        min-width: 230px;
        display: flex;
        flex-direction: column;
        height: 100vh;
        max-height: 100vh;
        position: sticky;
        top: 0;
        overflow: hidden;
        transition: width .25s cubic-bezier(.2, .8, .3, 1), transform .3s cubic-bezier(.4, 0, .2, 1),
            background .25s ease, border-color .25s ease;
    }

    .rail .logo {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 16px 8px 16px;
        border-bottom: 1px solid var(--rail-border);
        min-height: 60px;
        flex-shrink: 0;
        position: sticky;
        top: 0;
        z-index: 10;
        background: var(--rail-logo-bg, #ffffff);
        box-sizing: border-box;
    }

    .rail .scroll-wrapper {
        flex: 1;
        overflow-y: auto;
        overflow-x: hidden;
        padding: 4px 16px 20px 16px;
        scroll-behavior: smooth;
        scrollbar-width: thin;
        scrollbar-color: var(--rail-scrollbar-thumb) transparent;
    }

    .rail .scroll-wrapper::-webkit-scrollbar { width: 5px; }
    .rail .scroll-wrapper::-webkit-scrollbar-track { background: transparent; }
    .rail .scroll-wrapper::-webkit-scrollbar-thumb {
        background: var(--rail-scrollbar-thumb);
        border-radius: 3px;
    }
    .rail .scroll-wrapper::-webkit-scrollbar-thumb:hover {
        background: var(--rail-scrollbar-thumb-hover);
    }

    .rail .brandchip {
        display: flex;
        align-items: center;
        padding: 0;
    }

    .rail .brandchip .logo-img {
        max-width: 130px;
        max-height: 40px;
        width: auto;
        height: auto;
        object-fit: contain;
        mix-blend-mode: multiply;
    }

    html.dark-mode .rail .brandchip .logo-img { mix-blend-mode: normal; }

    .rail .brandchip-slim {
        display: none;
        align-items: center;
        justify-content: center;
    }

    .rail .brandchip-slim .logo-img-slim {
        max-width: 32px;
        max-height: 32px;
        width: auto;
        height: auto;
        object-fit: contain;
        mix-blend-mode: multiply;
    }

    html.dark-mode .rail .brandchip-slim .logo-img-slim { mix-blend-mode: normal; }

    .rail .railclose {
        display: none;
        flex-shrink: 0;
        background: transparent;
        border: 1px solid var(--rail-close-border);
        border-radius: 4px;
        width: 28px;
        height: 28px;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }

    .rail .railclose svg {
        width: 13px;
        height: 13px;
        stroke: var(--rail-close-stroke);
        fill: none;
        stroke-width: 2.2;
    }

    .rail .grp,
    .rail .grp-tog {
        font-size: 12px;
        font-weight: 600;
        letter-spacing: .4px;
        text-transform: none;
        color: var(--rail-text);
        padding: 8px 4px 3px 4px;
        background: none;
        border: none;
        cursor: pointer;
        text-align: left;
        width: 100%;
        display: flex;
        align-items: center;
        gap: 8px;
        flex-shrink: 0;
        font-family: inherit;
    }

    .rail .grp-tog { padding: 6px 4px 2px 4px; }
    .rail .grp-tog:hover { color: var(--rail-text-hover); }

    .rail .grp-tog .caret {
        font-size: 10px;
        font-weight: 600;
        color: var(--rail-text-muted);
        transition: transform .15s;
        width: 14px;
        display: inline-block;
    }

    .rail .grp-tog .grp-icon {
        font-size: 16px;
        flex-shrink: 0;
        color: var(--rail-icon-stroke);
        width: 20px;
        text-align: center;
    }

    .rail .nav {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 5px 8px 5px 6px;
        margin: 1px 4px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 500;
        color: var(--rail-text);
        text-decoration: none;
        cursor: pointer;
        transition: background .15s, transform .12s, color .15s;
        position: relative;
        background: transparent;
        border: none;
        width: calc(100% - 8px);
        flex-shrink: 0;
        font-family: inherit;
    }

    .rail .nav .ic {
        width: 22px;
        height: 22px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 4px;
        background: var(--rail-icon-bg);
        transition: background .15s;
    }

    .rail .nav .ic svg {
        width: 13px;
        height: 13px;
        stroke: var(--rail-icon-stroke);
        stroke-width: 1.8;
        fill: none;
        stroke-linecap: round;
        stroke-linejoin: round;
        transition: stroke .15s;
    }

    .rail .nav:hover {
        background: var(--rail-hover-bg);
        transform: translateX(3px);
    }

    .rail .nav:hover .ic { background: var(--rail-icon-bg-hover); }

    .rail .nav.active {
        background: var(--rail-active-bg);
        color: var(--rail-active-text);
        font-weight: 600;
        box-shadow: var(--rail-active-shadow);
    }

    .rail .nav.active .ic { background: var(--rail-active-icon-bg); }
    .rail .nav.active .ic svg { stroke: #ffffff; }

    .rail .nav.active::before {
        content: '';
        position: absolute;
        left: -4px;
        top: 20%;
        bottom: 20%;
        width: 3px;
        border-radius: 0 3px 3px 0;
        background: var(--rail-active-bar);
    }

    .navsec {
        overflow: hidden;
        transition: max-height .25s ease;
        max-height: 1000px;
        flex-shrink: 0;
    }

    .navsec.collapsed { max-height: 0; }

    .rail .spacer { flex: 0; min-height: 4px; }

    /* Slim Mode */
    .rail.slim {
        width: 60px;
        min-width: 60px;
    }

    .rail.slim .brandchip { display: none !important; }
    .rail.slim .brandchip-slim { display: flex !important; }

    .rail.slim .grp,
    .rail.slim .grp-tog {
        display: flex !important;
        justify-content: center;
        padding: 8px 4px;
        font-size: 0;
        gap: 0;
    }

    .rail.slim .grp-tog .caret { display: none !important; }
    .rail.slim .grp-tog .grp-label { display: none !important; }
    .rail.slim .grp-tog .grp-icon { font-size: 18px; width: 20px; }

    .rail.slim .logo {
        justify-content: center;
        padding: 8px 16px;
        border-bottom: none;
        gap: 0;
        min-height: 50px;
        background: var(--rail-logo-bg, #ffffff);
    }

    .rail.slim .nav {
        justify-content: center;
        padding: 5px 4px;
        font-size: 0;
        gap: 0;
        width: auto;
        margin: 1px 6px;
    }

    .rail.slim .nav.active::before { left: -6px; }

    /* Mobile Overlay */
    .railScrim {
        display: none;
        position: fixed;
        inset: 0;
        background: var(--rail-scrim);
        backdrop-filter: blur(1px);
        z-index: 75;
        opacity: 0;
        pointer-events: none;
        transition: opacity .25s ease;
    }

    .railScrim.on {
        opacity: 1;
        pointer-events: auto;
    }

    /* Responsive */
    @media(max-width:820px) {
        .railScrim { display: block; }

        .rail {
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            width: 280px;
            min-width: 280px;
            z-index: 80;
            transform: translateX(-100%);
            box-shadow: 8px 0 30px rgba(0, 0, 0, .25);
        }

        .rail.open { transform: translateX(0); }

        .rail .railclose { display: flex !important; }
        .rail .brandchip { display: flex !important; }
        .rail .brandchip-slim { display: none !important; }

        .rail .logo {
            background: var(--rail-logo-bg, #ffffff) !important;
            padding: 12px 16px 8px 16px !important;
            min-height: 60px !important;
            border-bottom: 1px solid var(--rail-border) !important;
        }

        .rail.slim {
            width: 280px;
            min-width: 280px;
        }

        .rail.slim .brandchip { display: flex !important; }
        .rail.slim .brandchip-slim { display: none !important; }

        .rail.slim .grp,
        .rail.slim .grp-tog {
            font-size: 12px !important;
            gap: 8px !important;
            justify-content: flex-start !important;
        }

        .rail.slim .grp-tog .grp-label { display: inline !important; }
        .rail.slim .grp-tog .caret { display: inline-block !important; }

        .rail.slim .nav {
            font-size: 12px !important;
            gap: 8px !important;
            width: calc(100% - 8px) !important;
            justify-content: flex-start !important;
            padding: 5px 8px 5px 6px !important;
        }

        .rail.slim .logo {
            gap: 8px !important;
            border-bottom: 1px solid var(--rail-border) !important;
            justify-content: space-between !important;
            padding: 12px 16px 8px 16px !important;
            min-height: 60px !important;
            background: var(--rail-logo-bg, #ffffff) !important;
        }
    }

    @media(min-width:821px) {
        .railScrim { display: none !important; }
        .rail .railclose { display: none !important; }
    }
</style>
</head>
<body>

<!-- Mobile Overlay -->
<div class="railScrim" id="railScrim" onclick="closeMobileRail()"></div>

<aside class="rail" id="rail">
    <!-- Logo -->
    <div class="logo">
        <div class="brandchip">
            <img src="<?php echo navUrl('assets/images/abc.png'); ?>" alt="Hascol Limited" class="logo-img">
        </div>
        <div class="brandchip-slim">
            <img src="<?php echo navUrl('assets/images/abc.png'); ?>" alt="Hascol Limited" class="logo-img-slim">
        </div>
        <button class="railclose" onclick="closeMobileRail()" title="Close navigation" aria-label="Close navigation">
            <svg viewBox="0 0 24 24">
                <path d="M18 6L6 18M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- Scrollable Content -->
    <div class="scroll-wrapper">

        <!-- ========================================== -->
        <!-- ADMIN MODULE (Parent) -->
        <!-- ========================================== -->
        <button class="grp grp-tog" data-sec="admin" onclick="toggleSec('admin')">
            <span class="caret">−</span>
            <i class="fas fa-user-cog grp-icon"></i>
            <span class="grp-label">Admin</span>
        </button>
        <div class="navsec" id="sec-admin">

            <a href="<?php echo navUrl('dashboard.php'); ?>" class="nav <?php echo isActive('dashboard.php'); ?>">
                <span class="ic">
                    <svg viewBox="0 0 24 24">
                        <rect x="3" y="3" width="7" height="9" />
                        <rect x="14" y="3" width="7" height="5" />
                        <rect x="14" y="12" width="7" height="9" />
                        <rect x="3" y="16" width="7" height="5" />
                    </svg>
                </span>
                Dashboard
            </a>

            <a href="<?php echo navUrl('users.php'); ?>" class="nav <?php echo isActive('users.php'); ?>">
                <span class="ic">
                    <svg viewBox="0 0 24 24">
                        <path d="M12 2a4 4 0 0 0-4 4 4 4 0 0 0 4 4 4 4 0 0 0 4-4 4 4 0 0 0-4-4z" />
                        <path d="M4 22v-2a4 4 0 0 1 4-4h8a4 4 0 0 1 4 4v2" />
                    </svg>
                </span>
                Users
            </a>

            <a href="<?php echo navUrl('tm_monthly_targets.php'); ?>" class="nav <?php echo isActive('tm_monthly_targets.php'); ?>">
                <span class="ic">
                    <svg viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10" />
                        <path d="M12 6v6l4 2" />
                    </svg>
                </span>
                Set TM Targets
            </a>

            <a href="<?php echo navUrl('dealers.php'); ?>" class="nav <?php echo isActive('dealers.php'); ?>">
                <span class="ic">
                    <svg viewBox="0 0 24 24">
                        <rect x="2" y="7" width="20" height="14" rx="2" />
                        <path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2" />
                    </svg>
                </span>
                Dealers
            </a>

            <a href="<?php echo navUrl('dealer_location_request.php'); ?>" class="nav <?php echo isActive('dealer_location_request.php'); ?>">
                <span class="ic">
                    <svg viewBox="0 0 24 24">
                        <path d="M12 2a8 8 0 0 0-8 8c0 6 8 12 8 12s8-6 8-12a8 8 0 0 0-8-8z" />
                        <circle cx="12" cy="10" r="3" />
                    </svg>
                </span>
                Stations Location Request
            </a>

            <a href="<?php echo navUrl('dealer_location_request_corrected.php'); ?>" class="nav <?php echo isActive('dealer_location_request_corrected.php'); ?>">
                <span class="ic">
                    <svg viewBox="0 0 24 24">
                        <path d="M12 2a8 8 0 0 0-8 8c0 6 8 12 8 12s8-6 8-12a8 8 0 0 0-8-8z" />
                        <circle cx="12" cy="10" r="3" />
                        <path d="M9 9l2 2 4-4" />
                    </svg>
                </span>
                Stations Error Location Approved
            </a>

            <a href="<?php echo navUrl('dealers_accounts.php'); ?>" class="nav <?php echo isActive('dealers_accounts.php'); ?>">
                <span class="ic">
                    <svg viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="9" />
                        <path d="M14.5 9a2.5 2.5 0 0 0-2.5-1.5c-1.5 0-2.5.8-2.5 2s1 1.7 2.5 2 2.5.9 2.5 2-1 2-2.5 2a2.5 2.5 0 0 1-2.5-1.5" />
                        <path d="M12 6v1.5M12 16.5V18" />
                    </svg>
                </span>
                Stations Accounts
            </a>

            <a href="<?php echo navUrl('manage_dealers_request.php'); ?>" class="nav <?php echo isActive('manage_dealers_request.php'); ?>">
                <span class="ic">
                    <svg viewBox="0 0 24 24">
                        <path d="M12 2a4 4 0 0 0-4 4 4 4 0 0 0 4 4 4 4 0 0 0 4-4 4 4 0 0 0-4-4z" />
                        <path d="M4 22v-2a4 4 0 0 1 4-4h8a4 4 0 0 1 4 4v2" />
                        <path d="M9 12l2 2 4-4" />
                    </svg>
                </span>
                Users request for app login
            </a>

            <a href="<?php echo navUrl('assign_salesinvoice_cart.php'); ?>" class="nav <?php echo isActive('assign_salesinvoice_cart.php'); ?>">
                <span class="ic">
                    <svg viewBox="0 0 24 24">
                        <rect x="2" y="3" width="20" height="18" rx="2" />
                        <path d="M8 7h8M8 11h6M8 15h4" />
                    </svg>
                </span>
                Assign Orders Invoices to Cartraige Users
            </a>

            <a href="<?php echo navUrl('get_cart_orders_list.php'); ?>" class="nav <?php echo isActive('get_cart_orders_list.php'); ?>">
                <span class="ic">
                    <svg viewBox="0 0 24 24">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                        <path d="M14 2v6h6" />
                        <path d="M8 13h8M8 17h5" />
                    </svg>
                </span>
                Order Sales Invoices
            </a>

            <a href="<?php echo navUrl('trip_board.php'); ?>" class="nav <?php echo isActive('trip_board.php'); ?>">
                <span class="ic">
                    <svg viewBox="0 0 24 24">
                        <path d="M12 2C7.58 2 4 5.58 4 10c0 4.42 8 12 8 12s8-7.58 8-12c0-4.42-3.58-8-8-8z" />
                        <circle cx="12" cy="10" r="3" />
                        <path d="M9 10l2 2 4-4" />
                    </svg>
                </span>
                Trip Board
            </a>

            <!-- MANAGE COCO ORDERS (Child) -->
            <button class="grp grp-tog" data-sec="coco" onclick="toggleSec('coco')">
                <span class="caret">+</span>
                <span class="grp-label">Manage COCO Orders</span>
            </button>
            <div class="navsec collapsed" id="sec-coco">

                <a href="<?php echo navUrl('jd_order_dashboard.php'); ?>" class="nav <?php echo isActive('jd_order_dashboard.php'); ?>">
                    <span class="ic">
                        <svg viewBox="0 0 24 24">
                            <rect x="2" y="4" width="20" height="16" rx="2" />
                            <path d="M8 8h8" />
                            <path d="M8 12h6" />
                            <path d="M8 16h4" />
                        </svg>
                    </span>
                    JD Order Dashboard
                </a>

                <a href="<?php echo navUrl('all_order.php'); ?>" class="nav <?php echo isActive('all_order.php'); ?>">
                    <span class="ic">
                        <svg viewBox="0 0 24 24">
                            <path d="M4 4h16v16H4z" />
                            <path d="M4 10h16" />
                            <path d="M8 4v16" />
                        </svg>
                    </span>
                    All APP Orders
                </a>

                <a href="<?php echo navUrl('all_order_current_status.php'); ?>" class="nav <?php echo isActive('all_order_current_status.php'); ?>">
                    <span class="ic">
                        <svg viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10" />
                            <path d="M12 6v6l4 2" />
                        </svg>
                    </span>
                    Current Day Orders Status
                </a>

                <a href="<?php echo navUrl('all_pending_app_orders.php'); ?>" class="nav <?php echo isActive('all_pending_app_orders.php'); ?>">
                    <span class="ic">
                        <svg viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10" />
                            <path d="M12 8v4l3 3" />
                            <path d="M12 2v2" />
                            <path d="M12 20v2" />
                            <path d="M4.93 4.93l1.41 1.41" />
                            <path d="M17.66 17.66l1.41 1.41" />
                            <path d="M2 12h2" />
                            <path d="M20 12h2" />
                        </svg>
                    </span>
                    All Pending APP Orders
                </a>

                <a href="<?php echo navUrl('manage_order2.php'); ?>" class="nav <?php echo isActive('manage_order2.php'); ?>">
                    <span class="ic">
                        <svg viewBox="0 0 24 24">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                            <path d="M14 2v6h6" />
                            <path d="M8 13h8" />
                            <path d="M8 17h5" />
                        </svg>
                    </span>
                    Order Report
                </a>

                <a href="<?php echo navUrl('current_day_coco_order_report.php'); ?>" class="nav <?php echo isActive('current_day_coco_order_report.php'); ?>">
                    <span class="ic">
                        <svg viewBox="0 0 24 24">
                            <rect x="2" y="4" width="20" height="16" rx="2" />
                            <path d="M8 12h8" />
                            <path d="M8 8h6" />
                            <path d="M8 16h4" />
                        </svg>
                    </span>
                    Current Day COCO Order Report
                </a>

                <a href="<?php echo navUrl('all_forward_orders.php'); ?>" class="nav <?php echo isActive('all_forward_orders.php'); ?>">
                    <span class="ic">
                        <svg viewBox="0 0 24 24">
                            <path d="M22 12L18 8v3h-6v2h6v3z" />
                            <path d="M2 18h6v2H2z" />
                            <path d="M2 12h10v2H2z" />
                            <path d="M2 6h6v2H2z" />
                        </svg>
                    </span>
                    Forwarded Orders
                </a>

                <a href="<?php echo navUrl('all_sales_invoice.php'); ?>" class="nav <?php echo isActive('all_sales_invoice.php'); ?>">
                    <span class="ic">
                        <svg viewBox="0 0 24 24">
                            <rect x="2" y="4" width="20" height="16" rx="2" />
                            <path d="M8 8h8" />
                            <path d="M8 12h6" />
                            <path d="M8 16h4" />
                            <path d="M17 8l2 2-4 4" />
                        </svg>
                    </span>
                    Sales Orders JD
                </a>

                <a href="<?php echo navUrl('order_shortage.php'); ?>" class="nav <?php echo isActive('order_shortage.php'); ?>">
                    <span class="ic">
                        <svg viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10" />
                            <path d="M12 8v5" />
                            <circle cx="12" cy="16" r="0.5" fill="currentColor" stroke="none" />
                        </svg>
                    </span>
                    Order Shortage
                </a>

            </div>

            <!-- MANAGE RETAILERS ORDERS (Child) -->
            <button class="grp grp-tog" data-sec="retailers" onclick="toggleSec('retailers')">
                <span class="caret">+</span>
                <span class="grp-label">Manage Retailers Orders</span>
            </button>
            <div class="navsec collapsed" id="sec-retailers">

                <a href="<?php echo navUrl('jd_retailers_order_dashborad.php'); ?>" class="nav <?php echo isActive('jd_retailers_order_dashborad.php'); ?>">
                    <span class="ic">
                        <svg viewBox="0 0 24 24">
                            <rect x="2" y="4" width="20" height="16" rx="2" />
                            <path d="M8 8h8" />
                            <path d="M8 12h6" />
                            <path d="M8 16h4" />
                        </svg>
                    </span>
                    JD Order Dashboard
                </a>

                <a href="<?php echo navUrl('all_order_retailes.php'); ?>" class="nav <?php echo isActive('all_order_retailes.php'); ?>">
                    <span class="ic">
                        <svg viewBox="0 0 24 24">
                            <path d="M4 4h16v16H4z" />
                            <path d="M4 10h16" />
                            <path d="M8 4v16" />
                        </svg>
                    </span>
                    All APP Orders
                </a>

                <a href="<?php echo navUrl('all_retail_order_current_status.php'); ?>" class="nav <?php echo isActive('all_retail_order_current_status.php'); ?>">
                    <span class="ic">
                        <svg viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10" />
                            <path d="M12 6v6l4 2" />
                        </svg>
                    </span>
                    Current Day Orders Status
                </a>

                <a href="<?php echo navUrl('all_retail_pending_app_orders.php'); ?>" class="nav <?php echo isActive('all_retail_pending_app_orders.php'); ?>">
                    <span class="ic">
                        <svg viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10" />
                            <path d="M12 8v4l3 3" />
                            <path d="M12 2v2" />
                            <path d="M12 20v2" />
                            <path d="M4.93 4.93l1.41 1.41" />
                            <path d="M17.66 17.66l1.41 1.41" />
                            <path d="M2 12h2" />
                            <path d="M20 12h2" />
                        </svg>
                    </span>
                    All Pending APP Orders
                </a>

                <a href="<?php echo navUrl('manage_retails_order2.php'); ?>" class="nav <?php echo isActive('manage_retails_order2.php'); ?>">
                    <span class="ic">
                        <svg viewBox="0 0 24 24">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                            <path d="M14 2v6h6" />
                            <path d="M8 13h8" />
                            <path d="M8 17h5" />
                        </svg>
                    </span>
                    Order Report
                </a>

                <a href="<?php echo navUrl('current_day_retailes_order_report.php'); ?>" class="nav <?php echo isActive('current_day_retailes_order_report.php'); ?>">
                    <span class="ic">
                        <svg viewBox="0 0 24 24">
                            <rect x="2" y="4" width="20" height="16" rx="2" />
                            <path d="M8 12h8" />
                            <path d="M8 8h6" />
                            <path d="M8 16h4" />
                        </svg>
                    </span>
                    Current Day Retailers Order Report
                </a>

                <a href="<?php echo navUrl('all_retail_forward_orders.php'); ?>" class="nav <?php echo isActive('all_retail_forward_orders.php'); ?>">
                    <span class="ic">
                        <svg viewBox="0 0 24 24">
                            <path d="M22 12L18 8v3h-6v2h6v3z" />
                            <path d="M2 18h6v2H2z" />
                            <path d="M2 12h10v2H2z" />
                            <path d="M2 6h6v2H2z" />
                        </svg>
                    </span>
                    Forwarded Orders
                </a>

                <a href="<?php echo navUrl('all_retailes_sales_invoice.php'); ?>" class="nav <?php echo isActive('all_retailes_sales_invoice.php'); ?>">
                    <span class="ic">
                        <svg viewBox="0 0 24 24">
                            <rect x="2" y="4" width="20" height="16" rx="2" />
                            <path d="M8 8h8" />
                            <path d="M8 12h6" />
                            <path d="M8 16h4" />
                            <path d="M17 8l2 2-4 4" />
                        </svg>
                    </span>
                    Sales Orders JD
                </a>

                <a href="<?php echo navUrl('order_retailers_shortage.php'); ?>" class="nav <?php echo isActive('order_retailers_shortage.php'); ?>">
                    <span class="ic">
                        <svg viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10" />
                            <path d="M12 8v5" />
                            <circle cx="12" cy="16" r="0.5" fill="currentColor" stroke="none" />
                        </svg>
                    </span>
                    Order Shortage
                </a>

            </div>

            <!-- MANAGE INSPECTION (Child) -->
            <button class="grp grp-tog" data-sec="inspection" onclick="toggleSec('inspection')">
                <span class="caret">+</span>
                <span class="grp-label">Manage Inspection</span>
            </button>
            <div class="navsec collapsed" id="sec-inspection">

                <a href="<?php echo navUrl('dashboard_inspecion.php'); ?>" class="nav <?php echo isActive('dashboard_inspecion.php'); ?>">
                    <span class="ic">
                        <svg viewBox="0 0 24 24">
                            <rect x="3" y="3" width="7" height="9" />
                            <rect x="14" y="3" width="7" height="5" />
                            <rect x="14" y="12" width="7" height="9" />
                            <rect x="3" y="16" width="7" height="5" />
                        </svg>
                    </span>
                    Inspection Dashboard
                </a>

                <a href="<?php echo navUrl('containers_sizes.php'); ?>" class="nav <?php echo isActive('containers_sizes.php'); ?>">
                    <span class="ic">
                        <svg viewBox="0 0 24 24">
                            <rect x="2" y="3" width="20" height="18" rx="2" />
                            <path d="M8 7h8M8 11h6M8 15h4" />
                        </svg>
                    </span>
                    Chamber Sizes
                </a>

                <a href="<?php echo navUrl('survey_category.php'); ?>" class="nav <?php echo isActive('survey_category.php'); ?>">
                    <span class="ic">
                        <svg viewBox="0 0 24 24">
                            <path d="M12 2a4 4 0 0 0-4 4 4 4 0 0 0 4 4 4 4 0 0 0 4-4 4 4 0 0 0-4-4z" />
                            <path d="M4 22v-2a4 4 0 0 1 4-4h8a4 4 0 0 1 4 4v2" />
                        </svg>
                    </span>
                    Survey Category
                </a>

                <a href="<?php echo navUrl('survey_questions.php'); ?>" class="nav <?php echo isActive('survey_questions.php'); ?>">
                    <span class="ic">
                        <svg viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10" />
                            <path d="M12 8v4l4 2" />
                            <path d="M12 16v.01" />
                        </svg>
                    </span>
                    Survey Questions
                </a>

                <a href="<?php echo navUrl('multiple_task.php'); ?>" class="nav <?php echo isActive('multiple_task.php'); ?>">
                    <span class="ic">
                        <svg viewBox="0 0 24 24">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                            <path d="M14 2v6h6" />
                            <path d="M8 13h8M8 17h5" />
                        </svg>
                    </span>
                    Plan Task
                </a>

                <a href="<?php echo navUrl('manage_calander.php'); ?>" class="nav <?php echo isActive('manage_calander.php'); ?>">
                    <span class="ic">
                        <svg viewBox="0 0 24 24">
                            <rect x="3" y="4" width="18" height="18" rx="2" />
                            <path d="M3 10h18" />
                            <path d="M8 2v4" />
                            <path d="M16 2v4" />
                            <circle cx="12" cy="14" r="1" />
                            <circle cx="8" cy="14" r="1" />
                            <circle cx="16" cy="14" r="1" />
                        </svg>
                    </span>
                    Task Calendar
                </a>

                <a href="<?php echo navUrl('dealers_heri.php'); ?>" class="nav <?php echo isActive('dealers_heri.php'); ?>">
                    <span class="ic">
                        <svg viewBox="0 0 24 24">
                            <path d="M12 2L2 7l10 5 10-5-10-5z" />
                            <path d="M2 17l10 5 10-5" />
                            <path d="M2 12l10 5 10-5" />
                        </svg>
                    </span>
                    Retail Hierarchy
                </a>

            </div>

            <!-- MANAGE INSPECTION (ENG) (Child) -->
            <button class="grp grp-tog" data-sec="inspection-eng" onclick="toggleSec('inspection-eng')">
                <span class="caret">+</span>
                <span class="grp-label">Manage Inspection (Eng)</span>
            </button>
            <div class="navsec collapsed" id="sec-inspection-eng">

                <a href="<?php echo navUrl('eng_dashboard.php'); ?>" class="nav <?php echo isActive('eng_dashboard.php'); ?>">
                    <span class="ic">
                        <svg viewBox="0 0 24 24">
                            <rect x="3" y="3" width="7" height="9" />
                            <rect x="14" y="3" width="7" height="5" />
                            <rect x="14" y="12" width="7" height="9" />
                            <rect x="3" y="16" width="7" height="5" />
                        </svg>
                    </span>
                    Dashboard
                </a>

                <a href="<?php echo navUrl('dealer_location_request_eng.php'); ?>" class="nav <?php echo isActive('dealer_location_request_eng.php'); ?>">
                    <span class="ic">
                        <svg viewBox="0 0 24 24">
                            <path d="M12 2a8 8 0 0 0-8 8c0 6 8 12 8 12s8-6 8-12a8 8 0 0 0-8-8z" />
                            <circle cx="12" cy="10" r="3" />
                        </svg>
                    </span>
                    Stations Location Request
                </a>

                <a href="<?php echo navUrl('eng_dealers_assign.php'); ?>" class="nav <?php echo isActive('eng_dealers_assign.php'); ?>">
                    <span class="ic">
                        <svg viewBox="0 0 24 24">
                            <path d="M12 2a4 4 0 0 0-4 4 4 4 0 0 0 4 4 4 4 0 0 0 4-4 4 4 0 0 0-4-4z" />
                            <path d="M4 22v-2a4 4 0 0 1 4-4h8a4 4 0 0 1 4 4v2" />
                        </svg>
                    </span>
                    Users Dealers (Eng)
                </a>

                <a href="<?php echo navUrl('servey_category_eng.php'); ?>" class="nav <?php echo isActive('servey_category_eng.php'); ?>">
                    <span class="ic">
                        <svg viewBox="0 0 24 24">
                            <path d="M12 2a4 4 0 0 0-4 4 4 4 0 0 0 4 4 4 4 0 0 0 4-4 4 4 0 0 0-4-4z" />
                            <path d="M4 22v-2a4 4 0 0 1 4-4h8a4 4 0 0 1 4 4v2" />
                        </svg>
                    </span>
                    Survey Category
                </a>

                <a href="<?php echo navUrl('survey_questions_eng.php'); ?>" class="nav <?php echo isActive('survey_questions_eng.php'); ?>">
                    <span class="ic">
                        <svg viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10" />
                            <path d="M12 8v4l4 2" />
                            <path d="M12 16v.01" />
                        </svg>
                    </span>
                    Survey Questions
                </a>

                <a href="<?php echo navUrl('multiple_task_eng.php'); ?>" class="nav <?php echo isActive('multiple_task_eng.php'); ?>">
                    <span class="ic">
                        <svg viewBox="0 0 24 24">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                            <path d="M14 2v6h6" />
                            <path d="M8 13h8M8 17h5" />
                        </svg>
                    </span>
                    Plan Task
                </a>

                <a href="<?php echo navUrl('inspection_report_eng.php'); ?>" class="nav <?php echo isActive('inspection_report_eng.php'); ?>">
                    <span class="ic">
                        <svg viewBox="0 0 24 24">
                            <path d="M9 11l3 3L22 4" />
                            <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11" />
                        </svg>
                    </span>
                    All Inspection
                </a>

            </div>

            <!-- REPORTS (Child) -->
            <button class="grp grp-tog" data-sec="reports" onclick="toggleSec('reports')">
                <span class="caret">+</span>
                <span class="grp-label">Reports</span>
            </button>
            <div class="navsec collapsed" id="sec-reports">

                <a href="<?php echo navUrl('inspection_report.php'); ?>" class="nav <?php echo isActive('inspection_report.php'); ?>">
                    <span class="ic">
                        <svg viewBox="0 0 24 24">
                            <path d="M9 11l3 3L22 4" />
                            <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11" />
                        </svg>
                    </span>
                    All Inspection Report
                </a>

                <a href="<?php echo navUrl('inspection_report_sign.php'); ?>" class="nav <?php echo isActive('inspection_report_sign.php'); ?>">
                    <span class="ic">
                        <svg viewBox="0 0 24 24">
                            <path d="M12 2a8 8 0 0 0-8 8c0 6 8 12 8 12s8-6 8-12a8 8 0 0 0-8-8z" />
                            <circle cx="12" cy="10" r="3" />
                            <path d="M9 10l2 2 4-4" />
                        </svg>
                    </span>
                    Forcefully Visit Complete
                </a>

                <a href="<?php echo navUrl('all_casual_inspection.php'); ?>" class="nav <?php echo isActive('all_casual_inspection.php'); ?>">
                    <span class="ic">
                        <svg viewBox="0 0 24 24">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                            <path d="M14 2v6h6" />
                            <path d="M8 13h8M8 17h5" />
                        </svg>
                    </span>
                    All Casual Inspection
                </a>

                <a href="<?php echo navUrl('visit_history_report.php'); ?>" class="nav <?php echo isActive('visit_history_report.php'); ?>">
                    <span class="ic">
                        <svg viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="9" />
                            <path d="M12 7v5l3 2" />
                        </svg>
                    </span>
                    Visit History Report
                </a>

                <a href="<?php echo navUrl('dealers_reconciliation_report.php'); ?>" class="nav <?php echo isActive('dealers_reconciliation_report.php'); ?>">
                    <span class="ic">
                        <svg viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="9" />
                            <path d="M14.5 9a2.5 2.5 0 0 0-2.5-1.5c-1.5 0-2.5.8-2.5 2s1 1.7 2.5 2 2.5.9 2.5 2-1 2-2.5 2a2.5 2.5 0 0 1-2.5-1.5" />
                            <path d="M12 6v1.5M12 16.5V18" />
                        </svg>
                    </span>
                    Dealers Reconciliation Report
                </a>

                <a href="<?php echo navUrl('visit_calander_report.php'); ?>" class="nav <?php echo isActive('visit_calander_report.php'); ?>">
                    <span class="ic">
                        <svg viewBox="0 0 24 24">
                            <rect x="3" y="4" width="18" height="18" rx="2" />
                            <path d="M3 10h18" />
                            <path d="M8 2v4" />
                            <path d="M16 2v4" />
                            <circle cx="12" cy="14" r="1" />
                            <circle cx="8" cy="14" r="1" />
                            <circle cx="16" cy="14" r="1" />
                        </svg>
                    </span>
                    Visit Calander Report
                </a>

                <a href="<?php echo navUrl('product_wise_tm_reconciliation_report.php'); ?>" class="nav <?php echo isActive('product_wise_tm_reconciliation_report.php'); ?>">
                    <span class="ic">
                        <svg viewBox="0 0 24 24">
                            <path d="M3 3v18h18" />
                            <path d="M7 14l3-3 3 3 4-6" />
                        </svg>
                    </span>
                    Product Wise TM Reconciliation Report
                </a>

                <a href="<?php echo navUrl('reconciliation_analyzing_report.php'); ?>" class="nav <?php echo isActive('reconciliation_analyzing_report.php'); ?>">
                    <span class="ic">
                        <svg viewBox="0 0 24 24">
                            <circle cx="11" cy="11" r="7" />
                            <path d="M21 21l-4.35-4.35" />
                            <path d="M11 8v3l2 2" />
                        </svg>
                    </span>
                    Reconciliation Analyzing Report (0 Sales)
                </a>

                <a href="<?php echo navUrl('tm_tour_report.php'); ?>" class="nav <?php echo isActive('tm_tour_report.php'); ?>">
                    <span class="ic">
                        <svg viewBox="0 0 24 24">
                            <path d="M12 2a8 8 0 0 0-8 8c0 6 8 12 8 12s8-6 8-12a8 8 0 0 0-8-8z" />
                            <circle cx="12" cy="10" r="3" />
                        </svg>
                    </span>
                    TM Tour Report
                </a>

                <a href="<?php echo navUrl('tm_tour_report_month_wise.php'); ?>" class="nav <?php echo isActive('tm_tour_report_month_wise.php'); ?>">
                    <span class="ic">
                        <svg viewBox="0 0 24 24">
                            <rect x="3" y="4" width="18" height="18" rx="2" />
                            <path d="M3 10h18" />
                            <path d="M8 2v4" />
                            <path d="M16 2v4" />
                            <path d="M8 15h8" />
                            <path d="M8 18h5" />
                        </svg>
                    </span>
                    TM Tour Report (Month Wise)
                </a>

                <a href="<?php echo navUrl('site_info_report.php'); ?>" class="nav <?php echo isActive('site_info_report.php'); ?>">
                    <span class="ic">
                        <svg viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="9" />
                            <path d="M12 11v5" />
                            <circle cx="12" cy="8" r="0.5" fill="currentColor" stroke="none" />
                        </svg>
                    </span>
                    Site Info Report
                </a>

                <a href="<?php echo navUrl('tm_attendance_report.php'); ?>" class="nav <?php echo isActive('tm_attendance_report.php'); ?>">
                    <span class="ic">
                        <svg viewBox="0 0 24 24">
                            <rect x="3" y="4" width="18" height="18" rx="2" />
                            <path d="M3 10h18" />
                            <path d="M8 2v4" />
                            <path d="M16 2v4" />
                            <path d="M9 15l2 2 4-4" />
                        </svg>
                    </span>
                    TM Attendance Report
                </a>

            </div>

            <!-- LUBES SETUP (Child) -->
            <button class="grp grp-tog" data-sec="lubes" onclick="toggleSec('lubes')">
                <span class="caret">+</span>
                <span class="grp-label">Lubes Setup</span>
            </button>
            <div class="navsec collapsed" id="sec-lubes">
                <!-- Sub-modules go here -->
            </div>

        </div>
        <!-- End Admin Module -->

        <!-- ========================================== -->
        <!-- CUSTOMER MODULE (Parent) -->
        <!-- ========================================== -->
        <button class="grp grp-tog" data-sec="customer" onclick="toggleSec('customer')">
            <span class="caret">+</span>
            <i class="fas fa-users grp-icon"></i>
            <span class="grp-label">Customer</span>
        </button>
        <div class="navsec collapsed" id="sec-customer">

            <!-- DEALERS (Child) -->
            <a href="<?php echo navUrl('Customers/dealers.php'); ?>" class="nav <?php echo isActive('Customers/dealers.php'); ?>">
                <span class="ic">
                    <svg viewBox="0 0 24 24">
                        <path d="M3 9l1.5-5h15L21 9" />
                        <path d="M3 9v11h18V9" />
                        <path d="M3 9h18" />
                        <path d="M9 13h6" />
                        <path d="M9 17h6" />
                    </svg>
                </span>
                Dealers
            </a>

            <a href="<?php echo navUrl('Customers/customers.php'); ?>" class="nav <?php echo isActive('Customers/customers.php'); ?>">
                <span class="ic">
                    <svg viewBox="0 0 24 24">
                        <path d="M12 2a4 4 0 0 0-4 4 4 4 0 0 0 4 4 4 4 0 0 0 4-4 4 4 0 0 0-4-4z" />
                        <path d="M4 22v-2a4 4 0 0 1 4-4h8a4 4 0 0 1 4 4v2" />
                    </svg>
                </span>
                Customers
            </a>

            <a href="<?php echo navUrl('Customers/orders.php'); ?>" class="nav <?php echo isActive('Customers/orders.php'); ?>">
                <span class="ic">
                    <svg viewBox="0 0 24 24">
                        <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z" />
                        <path d="M3 6h18" />
                        <path d="M16 10a4 4 0 0 1-8 0" />
                    </svg>
                </span>
                Orders
            </a>

            <a href="<?php echo navUrl('Customers/transactions.php'); ?>" class="nav <?php echo isActive('Customers/transactions.php'); ?>">
                <span class="ic">
                    <svg viewBox="0 0 24 24">
                        <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                    </svg>
                </span>
                Transactions
            </a>

            <a href="<?php echo navUrl('Customers/coupons.php'); ?>" class="nav <?php echo isActive('Customers/coupons.php'); ?>">
                <span class="ic">
                    <svg viewBox="0 0 24 24">
                        <path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2z" />
                        <path d="M13 5v2M13 17v2M13 11v2" />
                    </svg>
                </span>
                Coupons
            </a>

            <a href="<?php echo navUrl('Customers/referral_numbers.php'); ?>" class="nav <?php echo isActive('Customers/referral_numbers.php'); ?>">
                <span class="ic">
                    <svg viewBox="0 0 24 24">
                        <path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2z" />
                        <path d="M13 5v2M13 17v2M13 11v2" />
                    </svg>
                </span>
                Referral Numbers
            </a>

                <a href="<?php echo navUrl('Customers/products.php'); ?>" class="nav <?php echo isActive('Customers/products.php'); ?>">
                    <span class="ic">
                        <svg viewBox="0 0 24 24">
                            <rect x="3" y="3" width="7" height="7" rx="1" />
                            <rect x="14" y="3" width="7" height="7" rx="1" />
                            <rect x="3" y="14" width="7" height="7" rx="1" />
                            <rect x="14" y="14" width="7" height="7" rx="1" />
                        </svg>
                    </span>
                    Lube Products
                </a>

        </div>
        <!-- End Customer Module -->

        <div class="spacer"></div>
    </div>
</aside>

<script>
    (function () {
        if (window.__SIDEBAR_INIT__) return;
        window.__SIDEBAR_INIT__ = true;

        function toggleSec(sec) {
            const el = document.getElementById('sec-' + sec);
            if (!el) return;

            el.classList.toggle('collapsed');
            const btn = document.querySelector('.grp-tog[data-sec="' + sec + '"] .caret');
            if (btn) {
                btn.textContent = el.classList.contains('collapsed') ? '+' : '−';
            }
        }

        function openMobileRail() {
            const rail = document.getElementById('rail');
            const scrim = document.getElementById('railScrim');
            if (rail) rail.classList.add('open');
            if (scrim) scrim.classList.add('on');
            document.body.classList.add('rail-mobile-open');
            document.body.style.overflow = 'hidden';
        }

        function closeMobileRail() {
            const rail = document.getElementById('rail');
            const scrim = document.getElementById('railScrim');
            if (rail) rail.classList.remove('open');
            if (scrim) scrim.classList.remove('on');
            document.body.classList.remove('rail-mobile-open');
            document.body.style.overflow = '';
        }

        function toggleMobileRail() {
            const rail = document.getElementById('rail');
            if (!rail) return;
            if (rail.classList.contains('open')) {
                closeMobileRail();
            } else {
                openMobileRail();
            }
        }

        function toggleRailSlim() {
            if (window.innerWidth <= 820) return;
            const rail = document.getElementById('rail');
            if (!rail) return;

            rail.classList.toggle('slim');
            const isSlim = rail.classList.contains('slim');
            document.body.classList.toggle('rail-slim', isSlim);

            try {
                localStorage.setItem('railSlim', isSlim ? '1' : '0');
            } catch (e) { /* ignore */ }
        }

        document.addEventListener('click', function (e) {
            const link = e.target.closest('.rail .nav[href]');
            if (link && window.innerWidth <= 820) {
                closeMobileRail();
            }
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') closeMobileRail();
        });

        window.addEventListener('resize', function () {
            if (window.innerWidth > 820) {
                closeMobileRail();
                document.body.style.overflow = '';
            } else {
                const rail = document.getElementById('rail');
                if (rail) rail.classList.remove('slim');
                document.body.classList.remove('rail-slim');
            }
        });

        document.addEventListener('DOMContentLoaded', function () {
            const rail = document.getElementById('rail');

            if (rail && window.innerWidth > 820) {
                try {
                    if (localStorage.getItem('railSlim') === '1') {
                        rail.classList.add('slim');
                        document.body.classList.add('rail-slim');
                    }
                } catch (e) { /* ignore */ }
            }

            const activeNav = document.querySelector('.nav.active');
            if (activeNav) {
                const parentSec = activeNav.closest('.navsec');
                if (parentSec) {
                    parentSec.classList.remove('collapsed');
                    const secId = parentSec.id.replace('sec-', '');
                    const toggleBtn = document.querySelector('.grp-tog[data-sec="' + secId + '"] .caret');
                    if (toggleBtn) toggleBtn.textContent = '−';
                }
            } else {
                const adminSec = document.getElementById('sec-admin');
                if (adminSec) {
                    adminSec.classList.add('collapsed');
                    const toggleBtn = document.querySelector('.grp-tog[data-sec="admin"] .caret');
                    if (toggleBtn) toggleBtn.textContent = '+';
                }
            }
        });

        window.toggleSec = toggleSec;
        window.openMobileRail = openMobileRail;
        window.closeMobileRail = closeMobileRail;
        window.toggleMobileRail = toggleMobileRail;
        window.toggleRailSlim = toggleRailSlim;

    })();
</script>

</body>
</html>