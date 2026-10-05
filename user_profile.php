<?php
// Hascol OMC Operations Command Center - Dealer Profile
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hascol OMC - Dealer Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- CryptoJS for encryption/decryption -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/crypto-js.js"></script>

    <!-- Leaflet CSS & JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <!-- DataTables CSS & JS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        dash: {
                            bg: '#f4f6fa',
                            panel: '#ffffff',
                            border: '#e2e8f0',
                            textMuted: '#64748b',
                            accentBlue: '#1d4ed8'
                        }
                    }
                }
            }
        }
    </script>

    <style>
        /* THEME VARIABLES                               */
        :root {
            --paper: #f4f6fa;
            --card: #ffffff;
            --ink: #17181b;
            --tx: #1d1d1f;
            --tx-2: #62646b;
            --tx-3: #8a8d95;
            --line: rgba(0, 0, 0, .085);
            --line-soft: rgba(0, 0, 0, .055);
            --blue: #0a84ff;
            --blue-2: #0060df;
            --blue-soft: rgba(10, 132, 255, .10);
            --green: #34c759;
            --green-soft: rgba(52, 199, 89, .12);
            --amber: #ff9f0a;
            --amber-soft: rgba(255, 159, 10, .13);
            --red: #ff3b30;
            --red-soft: rgba(255, 59, 48, .11);
            --purple: #7a4fb5;
            --shadow: 0 1px 3px rgba(0, 0, 0, .055);
            --shadow-lg: 0 10px 30px rgba(16, 24, 40, .07);
            --radius: 16px;
            --radius-sm: 10px;
            --display: -apple-system, "SF Pro Display", "Space Grotesk", "Inter", sans-serif;
            --body: -apple-system, "SF Pro Text", "Inter", sans-serif;
            --mono: "SF Mono", "JetBrains Mono", monospace;
            --tank-bg: #f8fafc;
            --tank-border: #e2e8f0;
            --dataTables-bg: #ffffff;
            --dataTables-header: #f8fafc;
            --workspace-bg: #ffffff;
            --section-tab-bg: #f1f5f9;
            --section-tab-hover: #e2e8f0;
            --section-tab-active: #ffffff;
            --nozzle-card-bg: #ffffff;
            --toast-bg: #ffffff;
            --toast-border: #e2e8f0;
            --toast-text: #1e293b;
            --cover-overlay: rgba(0, 0, 0, 0.18);
            --badge-bg: rgba(120, 120, 128, .10);
            --badge-text: #62646b;
        }

        html.dark-mode {
            --paper: #060b13;
            --card: #0d1520;
            --ink: #ffffff;
            --tx: #e5e7eb;
            --tx-2: #94a3b8;
            --tx-3: #64748b;
            --line: rgba(255, 255, 255, .08);
            --line-soft: rgba(255, 255, 255, .05);
            --blue: #60a5fa;
            --blue-2: #3b82f6;
            --blue-soft: rgba(96, 165, 250, .15);
            --green: #34d399;
            --green-soft: rgba(52, 211, 153, .15);
            --amber: #fbbf24;
            --amber-soft: rgba(251, 191, 36, .15);
            --red: #f87171;
            --red-soft: rgba(248, 113, 113, .15);
            --shadow: 0 1px 3px rgba(0, 0, 0, .3);
            --shadow-lg: 0 10px 30px rgba(0, 0, 0, .5);
            --tank-bg: #0a121c;
            --tank-border: #1a2635;
            --dataTables-bg: #0d1520;
            --dataTables-header: #0a121c;
            --workspace-bg: #0d1520;
            --section-tab-bg: #0a121c;
            --section-tab-hover: #1a2635;
            --section-tab-active: #0d1520;
            --nozzle-card-bg: #0a121c;
            --toast-bg: #0d1520;
            --toast-border: #1a2635;
            --toast-text: #e5e7eb;
            --cover-overlay: rgba(0, 0, 0, .35);
            --badge-bg: rgba(255, 255, 255, .08);
            --badge-text: #94a3b8;
        }

        * {
            box-sizing: border-box
        }

        html {
            scroll-behavior: smooth
        }

        body {
            background: var(--paper) !important;
            color: var(--tx) !important;
            font-family: var(--body) !important;
            -webkit-font-smoothing: antialiased;
            transition: background-color .25s ease, color .25s ease;
        }

        #pageContent {
            position: relative;
            z-index: 1;
            min-height: 0;
            overflow-x: hidden !important;
            overflow-y: auto !important;
            scroll-padding-top: 24px;
        }

        .premium-page {
            max-width: 1500px;
            width: 100%;
            margin: 0 auto;
            padding: 28px 28px 70px;
            position: relative;
            z-index: 2;
        }

        .page-heading {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 18px;
            margin-bottom: 18px;
        }

        .eyebrow {
            display: flex;
            align-items: center;
            gap: 7px;
            color: var(--tx-3);
            font-size: 10px;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
            margin-bottom: 6px;
        }

        .eyebrow .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--green);
            box-shadow: 0 0 0 4px var(--green-soft);
        }

        .page-heading h1 {
            margin: 0;
            color: var(--ink);
            font-family: var(--display);
            font-size: 25px;
            font-weight: 750;
            letter-spacing: -.035em;
            line-height: 1.05;
        }

        .page-heading p {
            margin: 5px 0 0;
            color: var(--tx-3);
            font-size: 11.5px;
            font-weight: 500;
        }

        .text-heading {
            color: var(--ink) !important;
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: 1px solid var(--line);
            background: var(--card);
            color: var(--tx);
            padding: 9px 14px;
            border-radius: 9px;
            font-size: 11.5px;
            font-weight: 650;
            text-decoration: none;
            box-shadow: var(--shadow);
            transition: .15s ease;
        }

        .back-btn:hover {
            transform: translateY(-1px);
            border-color: rgba(0, 0, 0, .16);
            box-shadow: var(--shadow-lg)
        }

        /* ===== Dealer identity / hero ===== */
        .dealer-profile-card {
            position: relative;
            overflow: hidden;
            background: var(--card);
            border: 1px solid var(--line-soft);
            border-radius: 20px;
            box-shadow: var(--shadow);
            margin-bottom: 18px;
            transition: background-color .25s ease, border-color .25s ease;
        }

        .dealer-cover {
            height: 220px;
            position: relative;
            overflow: hidden;
            background: #dfe5ec;
            isolation: isolate;
        }

        .dealer-cover::before {
            content: "";
            position: absolute;
            inset: -22px;
            background-image: url("assets/images/banner.png");
            background-size: cover;
            background-position: center;
            filter: blur(16px);
            transform: scale(1.08);
            opacity: .42;
            z-index: -2;
        }

        .dealer-cover::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(255, 255, 255, .03), var(--cover-overlay));
            z-index: 1;
            pointer-events: none;
        }

        html.dark-mode .dealer-cover::after {
            background: linear-gradient(180deg, rgba(0, 0, 0, .03), rgba(0, 0, 0, .35));
        }

        .dealer-cover img {
            position: relative;
            z-index: 0;
            width: 100%;
            height: 100%;
            object-fit: contain;
            object-position: center;
            display: block;
            filter: blur(.15px) contrast(1.01) saturate(1.02);
        }

        .cover-chip {
            position: absolute;
            z-index: 2;
            left: 20px;
            top: 18px;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 6px 9px;
            border: 1px solid rgba(255, 255, 255, .24);
            border-radius: 8px;
            background: rgba(0, 0, 0, .22);
            color: #fff;
            backdrop-filter: blur(12px);
            font-size: 9.5px;
            font-weight: 700;
            letter-spacing: .04em;
            text-transform: uppercase;
        }

        .cover-chip i {
            color: #7cf29a;
            font-size: 7px
        }

        .dealer-identity {
            display: grid;
            grid-template-columns: auto 1fr auto;
            align-items: center;
            gap: 18px;
            padding: 0 22px 20px;
            margin-top: -34px;
            position: relative;
            z-index: 3;
        }

        .dealer-logo {
            width: 92px;
            height: 92px;
            border-radius: 50%;
            background: #fff;
            border: 5px solid #fff;
            box-shadow: 0 8px 22px rgba(0, 0, 0, .18);
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .dealer-logo img {
            width: 100%;
            height: 100%;
            border-radius: 50%
        }

        .dealer-title {
            padding-top: 39px;
            min-width: 0;
        }

        .dealer-title h2 {
            margin: 0;
            color: var(--ink);
            font-family: var(--display);
            font-size: 20px;
            font-weight: 750;
            letter-spacing: -.025em;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .dealer-title .meta {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 8px;
            margin-top: 7px;
        }

        .status-pill,
        .meta-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 9px;
            border-radius: 999px;
            font-size: 10px;
            font-weight: 700;
        }

        .status-pill {
            background: var(--green-soft);
            color: #16883b
        }

        html.dark-mode .status-pill {
            color: #34d399
        }

        .status-pill i {
            font-size: 6px
        }

        .meta-pill {
            background: var(--badge-bg);
            color: var(--badge-text)
        }

        .dealer-actions {
            padding-top: 39px;
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .mini-action {
            width: 34px;
            height: 34px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--line);
            background: var(--card);
            color: var(--tx-2);
            border-radius: 9px;
            cursor: pointer;
            transition: all .2s ease;
        }

        .mini-action:hover {
            color: var(--blue);
            border-color: rgba(10, 132, 255, .28);
            background: var(--blue-soft)
        }

        /* ===== KPI strip ===== */
        .kpi-strip {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            margin-bottom: 18px;
        }

        .kpi-card {
            background: var(--card);
            border: 1px solid var(--line-soft);
            border-radius: 14px;
            box-shadow: var(--shadow);
            padding: 14px 16px;
            min-width: 0;
            transition: background-color .25s ease, border-color .25s ease;
        }

        .kpi-label {
            display: flex;
            align-items: center;
            gap: 7px;
            color: var(--tx-3);
            font-size: 10.5px;
            font-weight: 650;
        }

        .kpi-icon {
            width: 25px;
            height: 25px;
            border-radius: 7px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--blue-soft);
            color: var(--blue);
            font-size: 11px;
            transition: background-color .25s ease, color .25s ease;
        }

        .kpi-value {
            margin-top: 8px;
            color: var(--ink);
            font-family: var(--display);
            font-size: 22px;
            font-weight: 750;
            letter-spacing: -.03em;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            transition: color .25s ease;
        }

        .kpi-sub {
            margin-top: 3px;
            color: var(--tx-3);
            font-family: var(--mono);
            font-size: 9px;
        }

        .kpi-danger .kpi-icon {
            background: var(--red-soft);
            color: var(--red)
        }

        .kpi-success .kpi-icon {
            background: var(--green-soft);
            color: #169447
        }

        html.dark-mode .kpi-success .kpi-icon {
            color: #34d399
        }

        /* ===== Cards / sections ===== */
        .section-grid {
            display: grid;
            grid-template-columns: 1.05fr .95fr;
            gap: 18px;
            margin-bottom: 18px;
        }

        .premium-card {
            background: var(--card);
            border: 1px solid var(--line-soft);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            overflow: hidden;
            transition: background-color .25s ease, border-color .25s ease;
        }

        .card-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 15px 18px;
            border-bottom: 1px solid var(--line-soft);
            transition: border-color .25s ease;
        }

        .card-title {
            display: flex;
            align-items: center;
            gap: 9px;
            color: var(--ink);
            font-family: var(--display);
            font-size: 13.5px;
            font-weight: 720;
            letter-spacing: -.01em;
        }

        .card-title-icon {
            width: 28px;
            height: 28px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--blue);
            background: var(--blue-soft);
            font-size: 11px;
            transition: background-color .25s ease, color .25s ease;
        }

        .card-note {
            color: var(--tx-3);
            font-size: 9.5px;
            font-weight: 600;
        }

        .detail-list {
            padding: 4px 18px 9px
        }

        .detail-row {
            display: grid;
            grid-template-columns: 130px 1fr;
            gap: 15px;
            padding: 11px 0;
            border-bottom: 1px solid var(--line-soft);
            transition: border-color .25s ease;
        }

        .detail-row:last-child {
            border-bottom: 0
        }

        .detail-label {
            color: var(--tx-3);
            font-size: 10.5px;
            font-weight: 600;
        }

        .detail-value {
            color: var(--tx);
            font-size: 11.5px;
            font-weight: 650;
            text-align: right;
            overflow-wrap: anywhere;
            transition: color .25s ease;
        }

        .balance-negative {
            color: var(--red) !important
        }

        .grm-pill {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 3px 8px;
            border-radius: 6px;
            background: var(--blue-soft);
            color: var(--blue-2);
            font-size: 9.5px;
            font-weight: 700;
        }

        .map-card-body {
            padding: 14px
        }

        #map-container {
            min-height: 280px;
            height: 280px;
            border-radius: 12px;
            overflow: hidden;
            background: #edf0f3;
            border: 1px solid var(--line-soft);
            transition: border-color .25s ease;
        }

        html.dark-mode #map-container {
            background: #0a121c;
        }

        .coordinates {
            display: flex;
            align-items: center;
            gap: 7px;
            margin-top: 8px;
            color: var(--tx-3);
            font-family: var(--mono);
            font-size: 9px;
        }

        .coordinates i {
            color: var(--blue)
        }

        /* ===== Operational panels ===== */
        .ops-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
            margin-bottom: 18px;
        }

        .ops-body {
            padding: 13px 18px 16px
        }

        /* Nozzle cards */
        .nozzle-card {
            margin: 0 0 8px !important;
            padding: 11px 12px !important;
            border: 1px solid var(--line-soft) !important;
            border-radius: 11px !important;
            background: var(--nozzle-card-bg) !important;
            transition: background-color .25s ease, border-color .25s ease;
        }

        .nozzle-card .product-name {
            font-family: var(--display) !important;
            font-size: 12.5px !important;
            color: var(--ink) !important
        }

        .nozzle-card .price-label {
            font-size: 8.5px !important;
            color: var(--tx-3) !important
        }

        .nozzle-card .price-value {
            font-size: 10.5px !important;
            color: var(--tx) !important;
            font-weight: 650 !important
        }

        .badge-active {
            background: var(--green-soft) !important;
            color: #16883b !important;
            border: 0 !important;
            padding: 3px 8px !important;
            border-radius: 999px !important;
            font-size: 8.5px !important;
            font-weight: 700 !important;
        }

        html.dark-mode .badge-active {
            color: #34d399 !important
        }

        /* ===== TANK READINGS ===== */
        .tank-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .tank-item {
            display: grid;
            grid-template-columns: 40px 1fr auto;
            align-items: center;
            gap: 14px;
            padding: 12px 14px;
            background: var(--tank-bg);
            border: 1px solid var(--tank-border);
            border-radius: 12px;
            min-height: 64px;
            transition: background-color .25s ease, border-color .25s ease;
        }

        .tank-item .tank-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--blue-soft);
            color: var(--blue);
            font-size: 13px;
            flex-shrink: 0;
            transition: background-color .25s ease, color .25s ease;
        }

        .tank-item .tank-info {
            display: flex;
            flex-direction: column;
            gap: 2px;
            min-width: 0;
        }

        .tank-item .tank-name {
            font-size: 13px;
            font-weight: 700;
            color: var(--tx);
            font-family: var(--display);
            letter-spacing: -0.01em;
        }

        .tank-item .tank-time {
            font-size: 10px;
            color: var(--tx-3);
            font-weight: 500;
        }

        .tank-item .tank-time i {
            margin-right: 4px;
            font-size: 9px;
        }

        .tank-item .tank-level {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 1px;
            padding: 6px 14px;
            background: var(--blue-soft);
            border-radius: 8px;
            min-width: 80px;
            text-align: right;
            transition: background-color .25s ease;
        }

        .tank-item .tank-level .level-value {
            font-size: 16px;
            font-weight: 700;
            color: var(--blue-2);
            font-family: var(--mono);
            line-height: 1.2;
        }

        .tank-item .tank-level .level-label {
            font-size: 7px;
            font-weight: 700;
            color: var(--tx-3);
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }

        .tank-empty {
            padding: 32px 16px;
            text-align: center;
            border: 1px dashed var(--line);
            border-radius: 12px;
            color: var(--tx-3);
            background: var(--tank-bg);
            font-size: 10px;
            transition: background-color .25s ease, border-color .25s ease;
        }

        /* ===== RESPONSIVE TANK ===== */
        @media (max-width:768px) {
            .tank-item {
                grid-template-columns: 34px 1fr auto;
                gap: 10px;
                padding: 10px 12px;
            }

            .tank-item .tank-name {
                font-size: 12px
            }

            .tank-item .tank-time {
                font-size: 9px
            }

            .tank-item .tank-level .level-value {
                font-size: 14px
            }

            .tank-item .tank-level {
                min-width: 70px;
                padding: 4px 10px
            }
        }

        @media (max-width:480px) {
            .tank-item {
                grid-template-columns: 34px 1fr;
                gap: 8px;
                padding: 10px;
            }

            .tank-item .tank-level {
                grid-column: 1 / -1;
                flex-direction: row;
                align-items: center;
                justify-content: space-between;
                width: 100%;
                padding: 6px 12px;
                min-width: unset;
            }

            .tank-item .tank-level .level-label {
                font-size: 8px;
            }

            .tank-item .tank-level .level-value {
                font-size: 14px;
            }
        }

        /* ===== Workspace / Tabs ===== */
        .workspace {
            background: var(--workspace-bg);
            border: 1px solid var(--line-soft);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            overflow: visible;
            position: relative;
            z-index: 3;
            margin-top: 2px;
            transition: background-color .25s ease, border-color .25s ease;
        }

        #ordersSection,
        #salesSection {
            position: relative;
            z-index: 4;
            overflow: visible;
        }

        #ordersSection .panel-card {
            position: relative;
            z-index: 4;
        }

        .workspace-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            padding: 14px 16px;
            border-bottom: 1px solid var(--line-soft);
            position: relative;
            z-index: 5;
            background: var(--workspace-bg);
            transition: background-color .25s ease, border-color .25s ease;
        }

        .section-tabs {
            display: inline-flex;
            align-items: center;
            gap: 2px;
            padding: 4px;
            background: var(--section-tab-bg);
            border: 1px solid rgba(0, 0, 0, .055);
            border-radius: 10px;
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, .025);
            transition: background-color .25s ease;
        }

        .section-tab {
            flex: initial !important;
            display: inline-flex !important;
            align-items: center;
            justify-content: center;
            gap: 7px;
            min-width: 118px;
            padding: 8px 14px !important;
            border: 0 !important;
            border-radius: 7px !important;
            background: transparent !important;
            color: #85878e !important;
            font-size: 10.5px !important;
            font-weight: 650 !important;
            line-height: 1 !important;
            cursor: pointer;
            transition: all .16s ease;
            box-shadow: none !important;
            white-space: nowrap;
        }

        html.dark-mode .section-tab {
            color: #94a3b8 !important;
        }

        .section-tab i {
            font-size: 9.5px;
        }

        .section-tab:hover:not(.active) {
            color: #50535a !important;
            background: rgba(255, 255, 255, .55) !important;
        }

        html.dark-mode .section-tab:hover:not(.active) {
            color: #e5e7eb !important;
            background: rgba(255, 255, 255, .06) !important;
        }

        .section-tab.active {
            color: #2b2d32 !important;
            background: var(--section-tab-active) !important;
            box-shadow: 0 1px 3px rgba(0, 0, 0, .10), 0 0 0 1px rgba(0, 0, 0, .035) !important;
        }

        html.dark-mode .section-tab.active {
            color: #ffffff !important;
            background: #0d1520 !important;
            box-shadow: 0 1px 3px rgba(0, 0, 0, .3), 0 0 0 1px rgba(255, 255, 255, .06) !important;
        }

        .workspace-note {
            color: var(--tx-3);
            font-size: 9.5px;
            padding-bottom: 10px;
        }

        #ordersSection,
        #salesSection {
            padding: 18px;
            overflow: visible;
            min-height: 80px;
        }

        #ordersSection .panel-card>div:last-child {
            overflow: visible;
        }

        #ordersTable_wrapper {
            width: 100%;
            overflow: visible;
        }

        #ordersSection .panel-card,
        #salesSection .panel-card {
            border: 0 !important;
            box-shadow: none !important;
            border-radius: 0 !important;
            background: transparent !important;
        }

        #ordersSection .panel-card>div:first-child {
            display: none;
        }

        #ordersSection .panel-card>div:last-child {
            padding: 0 !important
        }

        #ordersTable {
            width: 100% !important;
        }

        .table-container table,
        .dataTables_wrapper table {
            font-size: 11px !important;
        }

        .dataTables_wrapper {
            color: var(--tx-2) !important;
        }

        .dataTables_wrapper .dataTables_info {
            font-size: 10px !important;
            color: var(--tx-3) !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            border-radius: 7px !important;
            border: 1px solid var(--line) !important;
            background: var(--card) !important;
            color: var(--tx-2) !important;
            font-size: 10px !important;
            padding: 4px 9px !important;
            transition: background-color .25s ease, border-color .25s ease, color .25s ease;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: var(--blue) !important;
            border-color: var(--blue) !important;
            color: #fff !important;
        }

        .dt-buttons {
            gap: 6px !important
        }

        .dt-buttons .dt-button {
            border: 1px solid var(--line) !important;
            background: var(--card) !important;
            color: var(--tx-2) !important;
            border-radius: 8px !important;
            padding: 6px 9px !important;
            font-size: 9.5px !important;
            box-shadow: none !important;
            transition: background-color .25s ease, border-color .25s ease, color .25s ease;
        }

        .dt-buttons .dt-button:hover {
            background: var(--blue-soft) !important;
            color: var(--blue) !important;
        }

        #ordersTable thead th {
            background: var(--dataTables-header) !important;
            color: var(--tx-3) !important;
            border-bottom: 1px solid var(--line) !important;
            padding: 10px 11px !important;
            font-size: 8.5px !important;
            letter-spacing: .06em !important;
            text-transform: uppercase !important;
            font-weight: 700 !important;
            transition: background-color .25s ease, border-color .25s ease, color .25s ease;
        }

        #ordersTable tbody td {
            padding: 10px 11px !important;
            border-bottom: 1px solid var(--line-soft) !important;
            color: var(--tx) !important;
            font-size: 10.5px !important;
            transition: border-color .25s ease, color .25s ease;
        }

        #ordersTable tbody tr:hover {
            background: var(--dataTables-header) !important;
        }

        #ordersTable .badge {
            display: inline-flex !important;
            align-items: center;
            border-radius: 999px !important;
            font-size: 8.5px !important;
            font-weight: 700 !important;
            padding: 3px 8px !important;
        }

        .badge-success {
            background: var(--green-soft) !important;
            color: var(--green) !important
        }

        .badge-warning {
            background: var(--amber-soft) !important;
            color: var(--amber) !important
        }

        .badge-danger {
            background: var(--red-soft) !important;
            color: var(--red) !important
        }

        .badge-info {
            background: var(--blue-soft) !important;
            color: var(--blue) !important
        }

        /* Sales Performance Table Styles */
        #salesTable thead th {
            background: var(--dataTables-header) !important;
            color: var(--tx-3) !important;
            border-bottom: 1px solid var(--line) !important;
            padding: 10px 11px !important;
            font-size: 8.5px !important;
            letter-spacing: .06em !important;
            text-transform: uppercase !important;
            font-weight: 700 !important;
            transition: background-color .25s ease, border-color .25s ease, color .25s ease;
        }

        #salesTable tbody td {
            padding: 10px 11px !important;
            border-bottom: 1px solid var(--line-soft) !important;
            color: var(--tx) !important;
            font-size: 10.5px !important;
            transition: border-color .25s ease, color .25s ease;
        }

        #salesTable tbody tr:hover {
            background: var(--dataTables-header) !important;
        }

        /* ===== Responsive ===== */
        @media (max-width:1100px) {
            .kpi-strip {
                grid-template-columns: repeat(2, 1fr)
            }

            .section-grid,
            .ops-grid {
                grid-template-columns: 1fr
            }

            .dealer-identity {
                grid-template-columns: auto 1fr
            }

            .dealer-actions {
                display: none
            }
        }

        @media (max-width:760px) {
            .premium-page {
                padding: 17px 14px 40px
            }

            .page-heading {
                align-items: flex-start;
                flex-direction: column
            }

            .page-heading h1 {
                font-size: 22px
            }

            .back-btn {
                width: 100%;
                justify-content: center
            }

            .dealer-cover {
                height: 180px
            }

            .dealer-identity {
                grid-template-columns: 1fr;
                text-align: center;
                padding: 0 16px 17px;
                margin-top: -42px
            }

            .dealer-logo {
                margin: 0 auto
            }

            .dealer-title {
                padding-top: 0
            }

            .dealer-title h2 {
                font-size: 17px
            }

            .dealer-title .meta {
                justify-content: center
            }

            .kpi-strip {
                grid-template-columns: 1fr 1fr
            }

            .detail-row {
                grid-template-columns: 1fr;
                gap: 4px
            }

            .detail-value {
                text-align: left
            }

            .workspace-top {
                padding-left: 10px;
                padding-right: 10px;
                overflow-x: auto
            }

            .workspace-note {
                display: none
            }

            #ordersSection,
            #salesSection {
                padding: 10px
            }
        }

        @media (max-width:480px) {
            .kpi-strip {
                grid-template-columns: 1fr
            }

            .dealer-cover {
                height: 160px
            }

            .dealer-title h2 {
                white-space: normal
            }
        }

        /* ===== SWEETALERT THEME FIX ===== */
        html.dark-mode .swal2-popup {
            background: var(--card) !important;
            color: var(--tx) !important;
            border: 1px solid var(--line) !important;
        }

        html.dark-mode .swal2-title {
            color: var(--ink) !important;
        }

        html.dark-mode .swal2-html-container {
            color: var(--tx) !important;
        }

        html.dark-mode .swal2-confirm {
            background-color: var(--blue) !important;
        }

        html.dark-mode .swal2-close {
            color: var(--tx) !important;
        }

        /* ============================================ */
        /* SETUP TOOLTIP - FIXED VISIBILITY             */
        /* ============================================ */
        .setup-tooltip-wrapper {
            position: relative;
            display: inline-block;
            z-index: 9999;
        }

        /* Ensure parent containers don't clip the tooltip */
        .detail-list {
            overflow: visible !important;
        }

        .detail-row {
            overflow: visible !important;
        }

        .premium-card {
            overflow: visible !important;
        }

        .card-head {
            overflow: visible !important;
        }

        .setup-tooltip-wrapper .setup-tooltip {
            visibility: hidden;
            opacity: 0;
            width: auto;
            white-space: nowrap;
            background: #1e293b;
            color: #f8fafc;
            text-align: center;
            padding: 6px 14px;
            border-radius: 8px;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.02em;
            position: fixed;
            pointer-events: none;
            z-index: 99999;
            font-family: var(--body);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.25), 0 2px 8px rgba(0, 0, 0, 0.1);
            transform: translateX(-50%) translateY(-8px);
            transition: opacity 0.2s ease, transform 0.2s ease, visibility 0.2s ease;
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .setup-tooltip-wrapper .setup-tooltip::after {
            content: "";
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            border: 6px solid transparent;
            border-top-color: #1e293b;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
        }

        .setup-tooltip-wrapper:hover .setup-tooltip {
            visibility: visible;
            opacity: 1;
            transform: translateX(-50%) translateY(0);
        }

        /* Dark mode override */
        html.dark-mode .setup-tooltip-wrapper .setup-tooltip {
            background: #334155;
            color: #f1f5f9;
            border-color: rgba(255, 255, 255, 0.06);
        }

        html.dark-mode .setup-tooltip-wrapper .setup-tooltip::after {
            border-top-color: #334155;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .setup-tooltip-wrapper .setup-tooltip {
                font-size: 10px;
                padding: 5px 12px;
            }
        }

        @media (max-width: 480px) {
            .setup-tooltip-wrapper .setup-tooltip {
                font-size: 9px;
                padding: 4px 10px;
                white-space: normal;
                max-width: 180px;
                text-align: center;
            }
        }

        /* ============================================ */
        /* CUSTOMER LEDGER HISTORY MODAL                 */
        /* Premium enterprise vertical timeline           */
        /* ============================================ */
        #ledger_backlog_modal .cl-modal-box {
            background: var(--card);
            border-radius: 16px;
            width: 94%;
            max-width: 660px;
            max-height: 88vh;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            box-shadow: 0 30px 80px rgba(16, 24, 40, .38);
            border: 1px solid var(--line-soft);
        }

        /* ---- Header ---- */
        #ledger_backlog_modal .cl-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            padding: 18px 22px;
            border-bottom: 1px solid var(--line-soft);
            background: var(--card);
            flex-shrink: 0;
        }

        #ledger_backlog_modal .cl-header-left {
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 0;
        }

        #ledger_backlog_modal .cl-header-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--blue-soft);
            color: var(--blue);
            font-size: 15px;
            flex-shrink: 0;
        }

        #ledger_backlog_modal .cl-header-text h5 {
            margin: 0;
            color: var(--ink);
            font-family: var(--display);
            font-size: 15.5px;
            font-weight: 750;
            letter-spacing: -.015em;
            line-height: 1.2;
        }

        #ledger_backlog_modal .cl-header-text span {
            display: block;
            margin-top: 2px;
            color: var(--tx-3);
            font-size: 10.5px;
            font-weight: 550;
        }

        #ledger_backlog_modal .cl-modal-close {
            background: none;
            border: none;
            font-size: 17px;
            color: var(--tx-3);
            cursor: pointer;
            padding: 6px 9px;
            border-radius: 8px;
            flex-shrink: 0;
            transition: color .15s ease, background-color .15s ease;
        }

        #ledger_backlog_modal .cl-modal-close:hover {
            color: var(--red);
            background: var(--red-soft);
        }

        /* ---- Scroll body ---- */
        #ledgerLogsContainer {
            padding: 24px 26px 20px;
            overflow-y: auto;
            flex: 1;
            background: var(--paper);
        }

        #ledgerLogsContainer::-webkit-scrollbar {
            width: 6px;
        }

        #ledgerLogsContainer::-webkit-scrollbar-thumb {
            background: var(--line);
            border-radius: 4px;
        }

        /* ---- Timeline shell ---- */
        .cl-timeline {
            position: relative;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .cl-timeline::before {
            content: "";
            position: absolute;
            top: 32px;
            bottom: 10px;
            left: 26px;
            width: 2px;
            background: var(--line);
            z-index: 0;
        }

        /* ---- Start endpoint (big circular badge centered on the line) ---- */
        .cl-start-row {
            display: flex;
            justify-content: flex-start;
            padding-bottom: 18px;
        }

        .cl-start-badge {
            position: relative;
            z-index: 1;
            width: 58px;
            height: 58px;
            margin-left: -3px;
            border-radius: 50%;
            background: linear-gradient(180deg, var(--blue), var(--blue-2));
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10.5px;
            font-weight: 800;
            letter-spacing: .06em;
            text-transform: uppercase;
            box-shadow: 0 8px 18px rgba(10, 132, 255, .32), 0 0 0 5px var(--card);
        }

        /* ---- End endpoint ---- */
        .cl-end-row {
            display: flex;
            justify-content: flex-start;
            padding-top: 4px;
        }

        .cl-end-badge {
            position: relative;
            z-index: 1;
            width: 52px;
            height: 52px;
            margin-left: 0;
            border-radius: 50%;
            /* background: var(--card); */
            background: linear-gradient(180deg, var(--blue), var(--blue-2));
            border: 2px solid var(--line);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 9.5px;
            font-weight: 800;
            letter-spacing: .06em;
            text-transform: uppercase;
            box-shadow: 0 0 0 5px var(--card);
        }

        /* ---- Single event row: icon | dot-on-line | card+ribbon ---- */
        .cl-event {
            position: relative;
            display: flex;
            align-items: flex-start;
            gap: 14px;
            padding-bottom: 20px;
        }

        .cl-event:last-of-type {
            padding-bottom: 0;
        }

        .cl-event-icon {
            position: relative;
            z-index: 1;
            flex-shrink: 0;
            width: 30px;
            height: 30px;
            border-radius: 8px;
            background: var(--card);
            border: 1.5px solid var(--blue);
            color: var(--blue);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            margin-top: 6px;
            box-shadow: 0 0 0 4px var(--paper);
        }

        .cl-event-dot {
            position: absolute;
            top: 20px;
            left: 26px;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: var(--blue);
            border: 2px solid var(--card);
            box-shadow: 0 0 0 3px var(--blue-soft);
            transform: translateX(-50%);
            z-index: 1;
        }

        /* ---- Card + ribbon wrapper ---- */
        .cl-content {
            position: relative;
            flex: 1;
            min-width: 0;
            padding-right: 46px;
        }

        .cl-card {
            background: var(--tank-bg);
            border: 1px solid var(--line-soft);
            border-radius: 10px;
            padding: 12px 16px;
            transition: box-shadow .18s ease, border-color .18s ease, transform .18s ease;
        }

        .cl-card:hover {
            box-shadow: var(--shadow-lg);
            border-color: rgba(10, 132, 255, .25);
            transform: translateY(-1px);
        }

        .cl-card p {
            margin: 0 0 7px;
            font-size: 11.5px;
            color: var(--tx-2);
            line-height: 1.5;
        }

        .cl-card p:last-child {
            margin-bottom: 0;
        }

        .cl-card p.cl-amount {
            font-weight: 700;
            color: var(--tx);
            font-size: 12px;
        }

        .cl-card p.cl-amount span {
            color: var(--blue-2);
            font-family: var(--mono);
            font-weight: 750;
        }

        html.dark-mode .cl-card p.cl-amount span {
            color: var(--blue);
        }

        .cl-card p i {
            width: 13px;
            margin-right: 6px;
            color: var(--tx-3);
            font-size: 10px;
            text-align: center;
        }

        .cl-card .cl-note-text {
            margin-top: 9px;
            padding-top: 9px;
            border-top: 1px dashed var(--line-soft);
        }

        /* ---- Ribbon-style date badge (pointed bottom) ---- */
        .cl-ribbon {
            position: absolute;
            top: -6px;
            right: 0;
            z-index: 1;
            width: 44px;
            padding: 8px 4px 14px;
            background: linear-gradient(180deg, var(--blue), var(--blue-2));
            color: #fff;
            text-align: center;
            clip-path: polygon(0 0, 100% 0, 100% 82%, 50% 100%, 0 82%);
            box-shadow: 0 6px 14px rgba(10, 132, 255, .3);
        }

        .cl-ribbon .cl-ribbon-day {
            display: block;
            font-family: var(--display);
            font-size: 16px;
            font-weight: 800;
            line-height: 1.1;
        }

        .cl-ribbon .cl-ribbon-mon {
            display: block;
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .03em;
            opacity: .9;
            margin-top: 1px;
        }

        /* ---- Empty / error states ---- */
        .cl-empty-state,
        .cl-error-state {
            text-align: center;
            padding: 54px 16px;
            color: var(--tx-3);
        }

        .cl-empty-state i,
        .cl-error-state i {
            font-size: 36px;
            display: block;
            margin-bottom: 14px;
            opacity: .3;
        }

        .cl-error-state i {
            color: var(--red);
            opacity: .75;
        }

        .cl-empty-state p,
        .cl-error-state p {
            margin: 0;
            font-size: 12px;
            font-weight: 600;
        }

        /* ---- Responsive ---- */
        @media (max-width: 640px) {
            #ledger_backlog_modal .cl-modal-box {
                max-width: 96%;
                max-height: 92vh;
            }

            #ledgerLogsContainer {
                padding: 18px 14px 16px;
            }

            .cl-timeline::before {
                left: 22px;
            }

            .cl-event-dot {
                left: 22px;
            }

            .cl-event-icon {
                width: 26px;
                height: 26px;
                font-size: 10px;
            }

            .cl-content {
                padding-right: 40px;
            }

            .cl-ribbon {
                width: 38px;
                padding: 6px 3px 11px;
            }

            .cl-ribbon .cl-ribbon-day {
                font-size: 14px;
            }

            .cl-start-badge {
                width: 48px;
                height: 48px;
                font-size: 9px;
            }

            .cl-end-badge {
                width: 42px;
                height: 42px;
                font-size: 8px;
            }
        }

        @media (max-width: 400px) {
            #ledger_backlog_modal .cl-header {
                padding: 14px 16px;
            }

            #ledger_backlog_modal .cl-header-text h5 {
                font-size: 13.5px;
            }
        }
    </style>

</head>


<body class="flex h-screen overflow-hidden text-xs">

    <?php include 'includes/sidebar.php'; ?>

    <main id="mainContent" class="flex-1 flex flex-col overflow-hidden">
        <?php include 'includes/topbar.php'; ?>

        <div class="flex-1 overflow-y-auto" id="pageContent">
            <div class="premium-page">

                <!-- PAGE HEADER -->
                <div class="page-heading">
                    <div>
                        <h1>Dealer Profile</h1>
                        <p>Operational identity, station configuration, location intelligence and order activity.</p>
                    </div>
                    <a href="dealers.php" class="back-btn">
                        <i class="fa-solid fa-arrow-left"></i>
                        Back to Dealers
                    </a>
                </div>

                <!-- DEALER IDENTITY -->
                <section class="dealer-profile-card">
                    <div class="dealer-cover">
                        <img src="assets/images/banner.png" alt="Station"
                            id="bannerImg">
                        <div class="cover-chip"><i class="fa-solid fa-circle"></i> Station profile</div>
                    </div>

                    <div class="dealer-identity">
                        <div class="dealer-logo">
                            <img src="assets/images/system.png" alt="Hascol"
                                id="profileLogo">
                        </div>

                        <div class="dealer-title">
                            <h2 id="siteNameHero">Loading...</h2>
                            <div class="meta">
                                <span class="status-pill"><i class="fa-solid fa-circle"></i> Operational</span>
                                <span class="meta-pill"><i class="fa-solid fa-building"></i> Hascol OMC</span>
                                <span class="meta-pill"><i class="fa-solid fa-location-dot"></i> Dealer station</span>
                            </div>
                        </div>

                        <div class="dealer-actions">
                            <button class="mini-action" title="Refresh profile"
                                onclick="loadDealerProfile();loadProducts();loadTanks();loadOrders();loadSalesPerformance();">
                                <i class="fa-solid fa-rotate"></i>
                            </button>
                        </div>
                    </div>
                </section>

                <!-- KPI STRIP -->
                <div class="kpi-strip">
                    <div class="kpi-card">
                        <div class="kpi-label"><span class="kpi-icon"><i class="fa-solid fa-credit-card"></i></span>
                            Subscription</div>
                        <div class="kpi-value" id="subscription">0</div>
                        <div class="kpi-sub">ACCOUNT PLAN</div>
                    </div>

                    <div class="kpi-card kpi-danger">
                        <div class="kpi-label"><span class="kpi-icon"><i class="fa-solid fa-wallet"></i></span> Ledger
                            Balance</div>
                        <div class="kpi-value" id="ledgerBalance">0</div>
                        <div class="kpi-sub">CURRENT LEDGER</div>
                    </div>

                    <div class="kpi-card">
                        <div class="kpi-label"><span class="kpi-icon"><i class="fa-solid fa-clock"></i></span> Profile
                            Date</div>
                        <div class="kpi-value" id="dateTime">0</div>
                        <div class="kpi-sub">CREATED / UPDATED</div>
                    </div>
                </div>

                <!-- PROFILE + MAP -->
                <div class="section-grid">
                    <section class="premium-card">
                        <div class="card-head">
                            <div class="card-title">
                                <span class="card-title-icon"><i class="fa-solid fa-id-card"></i></span>
                                Dealer Information
                            </div>
                            <span class="card-note">MASTER PROFILE</span>
                        </div>

                        <div class="detail-list">
                            <div class="detail-row">
                                <span class="detail-label">Address</span>
                                <span class="detail-value" id="address">Loading...</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Phone</span>
                                <span class="detail-value" id="phone">Loading...</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Email</span>
                                <span class="detail-value" id="email">Loading...</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Coordinates</span>
                                <span class="detail-value" id="coordinates">Loading...</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Setups</span>
                                <span class="detail-value">
                                    <a href="user_setup.php?id=U2FsdGVkX1%2B3RayuVEN%2FRew62tyzKRGjN35ECbpUVZY%3D"
                                        id="setup_tag" target="_blank" rel="noopener noreferrer"
                                        class="setup-tooltip-wrapper">
                                        <i class="fas fa-users-cog" style="cursor:pointer;font-size: 20px;"></i>
                                        <span class="setup-tooltip">User Setup Configuration</span>
                                    </a>
                                </span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Ledger Balance</span>

                                <span class="detail-value"
                                    style="display: flex; gap: 8px; justify-content: flex-end; align-items: center;">
                                    <i class="fas fa-history backlog_ledgers"
                                        style="cursor:pointer;font-size: 16px; color: var(--blue);"
                                        onclick="get_ledger_backlog()"></i>
                                </span>
                            </div>
                        </div>
                    </section>

                    <section class="premium-card">
                        <div class="card-head">
                            <div class="card-title">
                                <span class="card-title-icon"><i class="fa-solid fa-map-location-dot"></i></span>
                                Station Location
                            </div>
                            <span class="card-note">LIVE MAP</span>
                        </div>
                        <div class="map-card-body">
                            <div id="map-container"></div>
                            <div class="coordinates">
                                <i class="fa-solid fa-location-crosshairs"></i>
                                <span>GPS: </span><span id="coordinates2">Loading...</span>
                            </div>
                        </div>
                    </section>
                </div>

                <!-- NOZZLES + TANKS -->
                <div class="ops-grid">
                    <section class="premium-card">
                        <div class="card-head">
                            <div class="card-title">
                                <span class="card-title-icon"><i class="fa-solid fa-gas-pump"></i></span>
                                Nozzle & Pricing Status
                            </div>
                            <span class="card-note">PRODUCT CONFIGURATION</span>
                        </div>
                        <div class="ops-body">
                            <div id="nozzleList"></div>
                        </div>
                    </section>

                    <section class="premium-card">
                        <div class="card-head">
                            <div class="card-title">
                                <span class="card-title-icon"><i class="fa-solid fa-oil-can"></i></span>
                                Tank Readings
                            </div>
                            <span class="card-note">LAST UPDATE: <span id="lastUpdateTime">Loading...</span></span>
                        </div>
                        <div class="ops-body">
                            <div id="tankList" class="tank-list"></div>
                        </div>
                    </section>
                </div>

                <!-- ORDERS + SALES WORKSPACE -->
                <section class="workspace">
                    <div class="workspace-top">
                        <div class="section-tabs" id="sectionTabs" role="tablist" aria-label="Dealer activity">
                            <div class="section-tab active" data-target="ordersSection" role="tab" aria-selected="true">
                                <i class="fa-solid fa-file-invoice"></i> Orders
                            </div>
                            <div class="section-tab" data-target="salesSection" role="tab" aria-selected="false">
                                <i class="fa-solid fa-chart-line"></i> Sales Performance
                            </div>
                        </div>
                        <div class="workspace-note">Dealer-level activity workspace</div>
                    </div>

                    <!-- Orders Section -->
                    <div id="ordersSection">
                        <div class="panel-card overflow-hidden">
                            <div class="p-3 border-b" style="border-color: var(--line);">
                                <h3 class="text-heading font-semibold text-xs tracking-wide uppercase">Orders</h3>
                            </div>
                            <div class="p-3">
                                <table id="ordersTable" class="display" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Date</th>
                                            <th>Site Name</th>
                                            <th>Type</th>
                                            <th>Depot</th>
                                            <th>Total Amount</th>
                                            <th>Sales Order</th>
                                            <th>Sap Status</th>
                                            <th>Execution Status</th>
                                            <th>View Orders</th>
                                            <th>Track</th>
                                        </tr>
                                    </thead>
                                    <tbody id="ordersTableBody">
                                        <tr>
                                            <td colspan="11" class="text-center py-8 text-gray-500"
                                                style="color: var(--tx-3);">
                                                <i class="fa-solid fa-spinner fa-spin text-blue-400 mr-2"></i>
                                                Loading orders...
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Sales Performance Section -->
                    <div id="salesSection" class="hidden">
                        <div class="panel-card overflow-hidden">
                            <div class="p-3 border-b" style="border-color: var(--line);">
                                <h3 class="text-heading font-semibold text-xs tracking-wide uppercase">Sales Performance
                                </h3>
                            </div>
                            <div class="p-3">
                                <table id="salesTable" class="display" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Product Name</th>
                                            <th>Month</th>
                                            <th>Target Amount</th>
                                            <th>Description</th>
                                        </tr>
                                    </thead>
                                    <tbody id="salesTableBody">
                                        <tr>
                                            <td colspan="5" class="text-center py-8 text-gray-500"
                                                style="color: var(--tx-3);">
                                                <i class="fa-solid fa-spinner fa-spin text-blue-400 mr-2"></i>
                                                Loading sales performance...
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>

            </div>
        </div>
    </main>

    <!-- ============================================ -->
    <!-- CUSTOMER LEDGER HISTORY MODAL                -->
    <!-- ============================================ -->
    <div id="ledger_backlog_modal" class="modal fade" tabindex="-1" aria-labelledby="ledgerModalLabel"
        aria-hidden="true"
        style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15,23,42,0.55); z-index: 99999; align-items: center; justify-content: center;">
        <div class="cl-modal-box">
            <div class="cl-header">
                <div class="cl-header-left">
                    <span class="cl-header-icon"><i class="fa-solid fa-clock-rotate-left"></i></span>
                    <div class="cl-header-text">
                        <h5>Customer Ledger History</h5>
                        <span>Chronological record of ledger balance updates</span>
                    </div>
                </div>
                <button onclick="closeLedgerModal()" class="cl-modal-close" aria-label="Close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div id="ledgerLogsContainer">
                <ul class="cl-timeline" id="ledger_logs"></ul>
            </div>
        </div>
    </div>

    <script>
        // ============================================
        // API Configuration - LOCALHOST
        // ============================================
        const API_BASE_URL = 'api/';
        const ENCRYPTION_KEY = 'Hamza Ansari';

        // ============================================
        // Encryption/Decryption Functions
        // ============================================
        function decryptId(encryptedId) {
            try {
                const bytes = CryptoJS.AES.decrypt(decodeURIComponent(encryptedId), ENCRYPTION_KEY);
                const decrypted = bytes.toString(CryptoJS.enc.Utf8);
                return parseInt(decrypted) || 0;
            } catch (e) {
                console.error('Decryption error:', e);
                return 0;
            }
        }

        function encryptId(originalId) {
            const iv = CryptoJS.lib.WordArray.random(16);
            const cipher = CryptoJS.AES.encrypt(originalId.toString(), ENCRYPTION_KEY, { iv: iv });
            return cipher.toString();
        }

        function getUrlParameter(name) {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(name);
        }

        // ============================================
        // Get Dealer ID from URL
        // ============================================
        const encryptedId = getUrlParameter('id');
        const dealerId = encryptedId ? decryptId(encryptedId) : 0;

        // ============================================
        // Data Stores
        // ============================================
        let dealerProfile = {};
        let ordersData = [];
        let salesData = [];
        let nozzleData = [];
        let tankData = [];

        // ============================================
        // Load Dealer Profile
        // ============================================
        function loadDealerProfile() {
            $.ajax({
                url: API_BASE_URL + 'get/dealer_profile.php?id=' + dealerId + '&key=03201232927',
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (response && response.length > 0) {
                        dealerProfile = response[0];
                        populateDealerInfo();
                        initMap();
                    } else {
                        showToast('Dealer not found.', 'error');
                    }
                },
                error: function () {
                    showToast('Failed to load dealer profile.', 'error');
                }
            });
        }

        // ============================================
        // Load Products (Nozzle Status)
        // ============================================
        function loadProducts() {
            $.ajax({
                url: API_BASE_URL + 'get/dealers_products.php?key=03201232927&dealer_id=' + dealerId,
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (response && response.length > 0) {
                        nozzleData = response;
                        populateNozzles();
                    } else {
                        nozzleData = [];
                        populateNozzles();
                    }
                },
                error: function () {
                    nozzleData = [];
                    populateNozzles();
                }
            });
        }

        // ============================================
        // Load Tanks
        // ============================================
        function loadTanks() {
            $.ajax({
                url: API_BASE_URL + 'get/get_dealers_tanks.php?key=03201232927&dealer_id=' + dealerId,
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (response && response.length > 0) {
                        tankData = response;
                        populateTanks();
                    } else {
                        tankData = [];
                        populateTanks();
                    }
                },
                error: function () {
                    tankData = [];
                    populateTanks();
                }
            });
        }

        // ============================================
        // Load Orders - API: dealers_syb_orders.php
        // ============================================
        function loadOrders() {
            $('#ordersTableBody').html(`
                <tr>
                    <td colspan="11" class="text-center py-8" style="color: var(--tx-3);">
                        <i class="fa-solid fa-spinner fa-spin text-blue-400 mr-2"></i>
                        Loading orders...
                    </td>
                </tr>
            `);

            $.ajax({
                url: API_BASE_URL + 'get/dealers_syb_orders.php?id=' + dealerId + '&key=03201232927',
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (response && response.length > 0) {
                        ordersData = response;
                        initializeOrdersTable();
                    } else {
                        ordersData = [];
                        initializeOrdersTable();
                    }
                },
                error: function () {
                    ordersData = [];
                    initializeOrdersTable();
                }
            });
        }

        // ============================================
        // Load Sales Performance - API: get_dealers_product_target.php
        // ============================================
        function loadSalesPerformance() {
            $('#salesTableBody').html(`
                <tr>
                    <td colspan="5" class="text-center py-8" style="color: var(--tx-3);">
                        <i class="fa-solid fa-spinner fa-spin text-blue-400 mr-2"></i>
                        Loading sales performance...
                    </td>
                </tr>
            `);

            $.ajax({
                url: API_BASE_URL + 'get/get_dealers_product_target.php?key=03201232927&dealer_id=' + dealerId,
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (response && response.length > 0) {
                        salesData = response;
                        initializeSalesTable();
                    } else {
                        salesData = [];
                        initializeSalesTable();
                    }
                },
                error: function () {
                    salesData = [];
                    initializeSalesTable();
                }
            });
        }

        // ============================================
        // Populate Dealer Info
        // ============================================
        function populateDealerInfo() {
            const data = dealerProfile;

            $('#siteNameHero').text(data.name || 'N/A');
            $('#subscription').text(data.housekeeping || 'N/A');
            $('#dateTime').text(data.created_at || 'N/A');
            $('#address').text(data.location || 'N/A');
            $('#phone').text(data.contact || 'N/A');
            $('#email').text(data.email || 'N/A');
            $('#ledgerBalance').text(parseFloat(data.acount || 0).toLocaleString());
            $('#coordinates').text(data['co-ordinates'] || 'N/A');
            $('#coordinates2').text(data['co-ordinates'] || 'N/A');
        }

        // ============================================
        // Populate Nozzle Status
        // ============================================
        function populateNozzles() {
            let html = '';
            if (nozzleData.length > 0) {
                nozzleData.forEach(function (n) {
                    html += `
                        <div class="nozzle-card">
                            <div class="flex justify-between items-center mb-2">
                                <span class="product-name">${n.name || 'N/A'}</span>
                                <span class="badge-active">Active</span>
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <div class="price-label">Duration</div>
                                    <div class="price-value">${n.from || 'N/A'} - ${n.to || 'N/A'}</div>
                                </div>
                                <div>
                                    <div class="price-label">Indent Price</div>
                                    <div class="price-value">${n.indent_price || 'N/A'}</div>
                                </div>
                                <div>
                                    <div class="price-label">Nozzle Price</div>
                                    <div class="price-value">${n.nozel_price || 'N/A'}</div>
                                </div>
                                <div>
                                    <div class="price-label">Updated</div>
                                    <div class="price-value">${n.update_time || 'N/A'}</div>
                                </div>
                            </div>
                        </div>
                    `;
                });
            } else {
                html = `<div class="text-center py-6 text-gray-400 text-xs" style="color: var(--tx-3);">
                            <i class="fa-solid fa-gas-pump text-xl block mb-2"></i>
                            No nozzle data available
                        </div>`;
            }
            $('#nozzleList').html(html);
        }

        // ============================================
        // Populate Tanks
        // ============================================
        function populateTanks() {
            let html = '';
            if (tankData.length > 0) {
                tankData.forEach(function (t) {
                    let displayTime = t.update_time || 'N/A';

                    html += `
                        <div class="tank-item">
                            <div class="tank-icon">
                                <i class="fa-solid fa-gas-pump"></i>
                            </div>
                            <div class="tank-info">
                                <div class="tank-name">${t.lorry_no || 'N/A'}</div>
                                <div class="tank-time">
                                    <i class="fa-regular fa-clock"></i> ${displayTime}
                                </div>
                            </div>
                            <div class="tank-level">
                                <span class="level-value">${t.current_reading || '0'}</span>
                                <span class="level-label">READING</span>
                            </div>
                        </div>
                    `;
                });
                if (tankData[0] && tankData[0].update_time) {
                    $('#lastUpdateTime').text(tankData[0].update_time);
                } else {
                    $('#lastUpdateTime').text('N/A');
                }
            } else {
                html = `
                    <div class="tank-empty">
                        <i class="fa-solid fa-oil-can text-xl block mb-2"></i>
                        No tank data available
                    </div>
                `;
                $('#lastUpdateTime').text('N/A');
            }
            $('#tankList').html(html);
        }

        // ============================================
        // Initialize Orders DataTable
        // ============================================
        function initializeOrdersTable() {
            if ($.fn.DataTable.isDataTable('#ordersTable')) {
                $('#ordersTable').DataTable().destroy();
                $('#ordersTable tbody').empty();
            }

            const tableData = ordersData.map(function (item, index) {
                let statusValue = item.current_status || item.status || 'Pending';
                let statusClass = 'badge-info';
                if (statusValue === 'Complete' || statusValue === 'Completely Processed') statusClass = 'badge-success';
                else if (statusValue === 'Cancel' || statusValue === 'Cancelled') statusClass = 'badge-danger';
                else if (statusValue === 'Pending' || statusValue === 'pending') statusClass = 'badge-warning';
                else if (statusValue === 'Special Approval') statusClass = 'badge-info';
                else if (statusValue === 'ASM Approved') statusClass = 'badge-success';

                return [
                    index + 1,
                    item.created_at || 'N/A',
                    item.name || 'N/A',
                    item.type || 'N/A',
                    item.consignee_name || 'N/A',
                    parseFloat(item.total_amount || 0).toLocaleString(),
                    item.SaleOrder || 'N/A',
                    `<span class="badge ${statusClass}">${statusValue}</span>`,
                    item.delivered_status == 1 ? 'Delivered' : 'Not-Delivered',
                    `<button class="text-blue-500 hover:text-blue-700" onclick="viewOrder(${item.id})">
                        <i class="fa-regular fa-eye"></i>
                     </button>`,
                    item.is_tracker == 1 ? `<a href="trip_board_salesOrder.php?no=${item.SaleOrder}" target="_blank" class="text-orange-500"><i class="fa-solid fa-location-dot"></i></a>` : '---'
                ];
            });

            if (tableData.length === 0) {
                tableData.push(['No data available', '', '', '', '', '', '', '', '', '', '']);
            }

            $('#ordersTable').DataTable({
                data: tableData,
                columns: [
                    { title: 'S.No' },
                    { title: 'Date' },
                    { title: 'Site Name' },
                    { title: 'Type' },
                    { title: 'Depot' },
                    { title: 'Total Amount' },
                    { title: 'Sales Order' },
                    { title: 'Sap Status' },
                    { title: 'Execution Status' },
                    { title: 'View Orders', orderable: false, searchable: false },
                    { title: 'Track', orderable: false, searchable: false }
                ],
                dom: 'Bfrtip',
                buttons: [
                    { extend: 'copy', text: '<i class="fa-regular fa-copy"></i> Copy', className: 'toolbar-btn' },
                    { extend: 'excelHtml5', text: '<i class="fa-regular fa-file-excel"></i> Excel', className: 'toolbar-btn', title: 'Dealer_Orders' },
                    { extend: 'csvHtml5', text: '<i class="fa-regular fa-file-csv"></i> CSV', className: 'toolbar-btn', title: 'Dealer_Orders' },
                    { extend: 'pdfHtml5', text: '<i class="fa-regular fa-file-pdf"></i> PDF', className: 'toolbar-btn', title: 'Dealer Orders Report', orientation: 'landscape', pageSize: 'A4' },
                    { extend: 'print', text: '<i class="fa-solid fa-print"></i> Print', className: 'toolbar-btn' }
                ],
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100],
                ordering: true,
                order: [[0, 'asc']],
                language: {
                    emptyTable: '<div class="text-center py-8" style="color: var(--tx-3);"><i class="fa-solid fa-file-invoice text-2xl block mb-2"></i>No orders found</div>',
                    info: 'Showing _START_ to _END_ of _TOTAL_ entries',
                    infoEmpty: 'Showing 0 to 0 of 0 entries',
                    infoFiltered: '(filtered from _MAX_ total entries)'
                },
                drawCallback: function () {
                    $('.dt-buttons .dt-button').each(function () {
                        $(this).addClass('toolbar-btn');
                    });
                }
            });

            if (ordersData.length === 0) {
                $('#ordersTable').DataTable().clear().draw();
            }
        }

        // ============================================
        // Initialize Sales Performance DataTable
        // ============================================
        function initializeSalesTable() {
            if ($.fn.DataTable.isDataTable('#salesTable')) {
                $('#salesTable').DataTable().destroy();
                $('#salesTable tbody').empty();
            }

            const tableData = salesData.map(function (item, index) {
                return [
                    index + 1,
                    item.name || item.product_name || 'N/A',
                    item.date_month || 'N/A',
                    parseFloat(item.target_amount || 0).toLocaleString(),
                    item.description || 'N/A'
                ];
            });

            if (tableData.length === 0) {
                tableData.push(['No data available', '', '', '', '']);
            }

            $('#salesTable').DataTable({
                data: tableData,
                columns: [
                    { title: 'S.No' },
                    { title: 'Product Name' },
                    { title: 'Month' },
                    { title: 'Target Amount' },
                    { title: 'Description' }
                ],
                dom: 'Bfrtip',
                buttons: [
                    { extend: 'copy', text: '<i class="fa-regular fa-copy"></i> Copy', className: 'toolbar-btn' },
                    { extend: 'excelHtml5', text: '<i class="fa-regular fa-file-excel"></i> Excel', className: 'toolbar-btn', title: 'Sales_Performance' },
                    { extend: 'csvHtml5', text: '<i class="fa-regular fa-file-csv"></i> CSV', className: 'toolbar-btn', title: 'Sales_Performance' },
                    { extend: 'pdfHtml5', text: '<i class="fa-regular fa-file-pdf"></i> PDF', className: 'toolbar-btn', title: 'Sales Performance Report', orientation: 'landscape', pageSize: 'A4' },
                    { extend: 'print', text: '<i class="fa-solid fa-print"></i> Print', className: 'toolbar-btn' }
                ],
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100],
                ordering: true,
                order: [[0, 'asc']],
                language: {
                    emptyTable: '<div class="text-center py-8" style="color: var(--tx-3);"><i class="fa-solid fa-chart-line text-2xl block mb-2"></i>No sales performance data found</div>',
                    info: 'Showing _START_ to _END_ of _TOTAL_ entries',
                    infoEmpty: 'Showing 0 to 0 of 0 entries',
                    infoFiltered: '(filtered from _MAX_ total entries)'
                },
                drawCallback: function () {
                    $('.dt-buttons .dt-button').each(function () {
                        $(this).addClass('toolbar-btn');
                    });
                }
            });

            if (salesData.length === 0) {
                $('#salesTable').DataTable().clear().draw();
            }
        }

        // ============================================
        // View Order - Sub Orders
        // ============================================
        function viewOrder(orderId) {
            if (!orderId) return;

            Swal.fire({
                title: 'Order Details',
                html: '<div id="subOrderContent">Loading order details...</div>',
                width: 800,
                confirmButtonColor: '#1d4ed8',
                confirmButtonText: 'Close',
                showCloseButton: true,
                background: document.documentElement.classList.contains('dark-mode') ? '#0d1520' : '#ffffff',
                color: document.documentElement.classList.contains('dark-mode') ? '#e5e7eb' : '#1d1d1f'
            });

            $.ajax({
                url: API_BASE_URL + 'get/get_main_sub_orders.php?key=03201232927&id=' + orderId,
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    let html = '<table style="width:100%; border-collapse:collapse; font-size:12px;">';
                    html += `<thead>
                        <tr style="background:${document.documentElement.classList.contains('dark-mode') ? '#0a121c' : '#f8fafc'}; border-bottom:2px solid ${document.documentElement.classList.contains('dark-mode') ? '#1a2635' : '#e2e8f0'};">
                            <th style="padding:8px 10px; text-align:left; color:${document.documentElement.classList.contains('dark-mode') ? '#94a3b8' : '#64748b'};">S.No</th>
                            <th style="padding:8px 10px; text-align:left; color:${document.documentElement.classList.contains('dark-mode') ? '#94a3b8' : '#64748b'};">Date</th>
                            <th style="padding:8px 10px; text-align:left; color:${document.documentElement.classList.contains('dark-mode') ? '#94a3b8' : '#64748b'};">Product</th>
                            <th style="padding:8px 10px; text-align:left; color:${document.documentElement.classList.contains('dark-mode') ? '#94a3b8' : '#64748b'};">Rate</th>
                            <th style="padding:8px 10px; text-align:left; color:${document.documentElement.classList.contains('dark-mode') ? '#94a3b8' : '#64748b'};">Qty (Ltr)</th>
                            <th style="padding:8px 10px; text-align:left; color:${document.documentElement.classList.contains('dark-mode') ? '#94a3b8' : '#64748b'};">Delivered</th>
                            <th style="padding:8px 10px; text-align:left; color:${document.documentElement.classList.contains('dark-mode') ? '#94a3b8' : '#64748b'};">Depot</th>
                            <th style="padding:8px 10px; text-align:left; color:${document.documentElement.classList.contains('dark-mode') ? '#94a3b8' : '#64748b'};">Amount</th>
                        </tr>
                    </thead><tbody>`;

                    if (response && response.length > 0) {
                        response.forEach(function (item, index) {
                            html += `<tr style="border-bottom:1px solid ${document.documentElement.classList.contains('dark-mode') ? '#1a2635' : '#e2e8f0'};">
                                <td style="padding:8px 10px; color:${document.documentElement.classList.contains('dark-mode') ? '#e5e7eb' : '#1d1d1f'};">${index + 1}</td>
                                <td style="padding:8px 10px; color:${document.documentElement.classList.contains('dark-mode') ? '#e5e7eb' : '#1d1d1f'};">${item.date || 'N/A'}</td>
                                <td style="padding:8px 10px; color:${document.documentElement.classList.contains('dark-mode') ? '#e5e7eb' : '#1d1d1f'};">${item.product_name || 'N/A'}</td>
                                <td style="padding:8px 10px; color:${document.documentElement.classList.contains('dark-mode') ? '#e5e7eb' : '#1d1d1f'};">${item.rate || 'N/A'}</td>
                                <td style="padding:8px 10px; color:${document.documentElement.classList.contains('dark-mode') ? '#e5e7eb' : '#1d1d1f'};">${item.quantity || 'N/A'}</td>
                                <td style="padding:8px 10px; color:${document.documentElement.classList.contains('dark-mode') ? '#e5e7eb' : '#1d1d1f'};">${item.delivery_based || 'N/A'}</td>
                                <td style="padding:8px 10px; color:${document.documentElement.classList.contains('dark-mode') ? '#e5e7eb' : '#1d1d1f'};">${item.consignee_name || 'N/A'}</td>
                                <td style="padding:8px 10px; color:${document.documentElement.classList.contains('dark-mode') ? '#e5e7eb' : '#1d1d1f'};">${parseFloat(item.amount || 0).toLocaleString()}</td>
                            </tr>`;
                        });
                    } else {
                        html += `<tr><td colspan="8" style="padding:20px; text-align:center; color:#64748b;">No sub orders found</td></tr>`;
                    }

                    html += '</tbody></table>';
                    $('#subOrderContent').html(html);
                },
                error: function () {
                    $('#subOrderContent').html('<p class="text-red-500">Failed to load order details.</p>');
                }
            });
        }

        // ============================================
        // Initialize Map - Leaflet
        // ============================================
        function initMap() {
            const mapContainer = document.getElementById('map-container');
            if (!mapContainer) return;

            const coords = (dealerProfile['co-ordinates'] || '30.3753, 69.3451').split(',');
            const lat = parseFloat(coords[0].trim());
            const lng = parseFloat(coords[1].trim());

            const map = L.map(mapContainer).setView([lat || 30.3753, lng || 69.3451], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap'
            }).addTo(map);

            L.marker([lat || 30.3753, lng || 69.3451]).addTo(map)
                .bindPopup(dealerProfile.name || 'Dealer')
                .openPopup();

            setTimeout(function () {
                map.invalidateSize();
            }, 100);
        }

        // ============================================
        // Tabs: Orders / Sales Performance
        // ============================================
        function initTabs() {
            $('.section-tab').on('click', function () {
                if ($(this).hasClass('active')) return;

                $('.section-tab').removeClass('active').attr('aria-selected', 'false');
                $(this).addClass('active').attr('aria-selected', 'true');
                const target = $(this).data('target');

                $('#ordersSection, #salesSection').addClass('hidden');
                $('#' + target).removeClass('hidden');
            });
        }

        // ============================================
        // Toast Notification
        // ============================================
        function showToast(message, type = 'success') {
            const bgColor = document.documentElement.classList.contains('dark-mode') ? '#0d1520' : '#ffffff';
            const textColor = document.documentElement.classList.contains('dark-mode') ? '#e5e7eb' : '#1d1d1f';

            Swal.fire({
                icon: type,
                title: message,
                timer: 3000,
                showConfirmButton: false,
                toast: true,
                position: 'top-end',
                background: bgColor,
                color: textColor
            });
        }

        // ============================================
        // Tooltip Positioning
        // ============================================
        function positionTooltip() {
            const wrappers = document.querySelectorAll('.setup-tooltip-wrapper');

            wrappers.forEach(function (wrapper) {
                const tooltip = wrapper.querySelector('.setup-tooltip');
                const icon = wrapper.querySelector('i');

                if (!tooltip || !icon) return;

                wrapper.addEventListener('mouseenter', function (e) {
                    const rect = icon.getBoundingClientRect();
                    const tooltipWidth = tooltip.offsetWidth || 120;

                    let top = rect.top - tooltip.offsetHeight - 12;
                    let left = rect.left + (rect.width / 2) - (tooltipWidth / 2);

                    if (left < 10) {
                        left = 10;
                    } else if (left + tooltipWidth > window.innerWidth - 10) {
                        left = window.innerWidth - tooltipWidth - 10;
                    }

                    if (top < 10) {
                        top = rect.bottom + 12;
                        tooltip.classList.add('tooltip-below');
                    } else {
                        tooltip.classList.remove('tooltip-below');
                    }

                    tooltip.style.top = top + 'px';
                    tooltip.style.left = left + 'px';
                    tooltip.style.transform = 'none';
                });
            });
        }

        // ============================================
        // Get Ledger Backlog - API Call
        // (Only the rendered HTML markup was redesigned;
        //  AJAX URL, params and data source are unchanged)
        // ============================================
        function get_ledger_backlog() {
            // Show modal
            $('#ledger_backlog_modal').css('display', 'flex');
            $('#ledger_logs').html(`
                <li class="cl-empty-state" style="list-style:none;">
                    <i class="fa-solid fa-spinner fa-spin"></i>
                    <p>Loading ledger history...</p>
                </li>
            `);

            $.ajax({
                url: API_BASE_URL + 'get/get_dealer_ledger_log.php?key=03201232927&dealer_id=' + dealerId,
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    console.log('Ledger Log Response:', response);
                    $('#ledger_logs').empty();

                    if (response && response.length > 0) {
                        // ---- Start endpoint (circular badge on the line) ----
                        $('#ledger_logs').append(`
                            <li class="cl-start-row">
                                <span class="cl-start-badge">Start</span>
                            </li>
                        `);

                        $.each(response, function (index, data) {
                            // ============================================
                            // DATE FORMAT: day number + short month (e.g. 16 / May)
                            // ============================================
                            var originalDate = data.datetime || data.created_at;
                            var dateObject = new Date(originalDate);
                            var dayNum = isNaN(dateObject) ? '--' : dateObject.getDate();
                            var monShort = isNaN(dateObject) ? '' : dateObject.toLocaleString('en-US', { month: 'short' });

                            // ============================================
                            // LEDGER VALUE with commas (647,514,744.66)
                            // ============================================
                            var ledgerValue = parseFloat(data.new_ledger || 0).toLocaleString('en-US', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });

                            // ============================================
                            // FORMAT DATES: "2024-05-16 12:12:22"
                            // ============================================
                            var dateTime = data.datetime || 'N/A';
                            var recordTime = data.created_at || 'N/A';

                            // ============================================
                            // TIMELINE EVENT - icon + dot + card + ribbon
                            // ============================================
                            $('#ledger_logs').append(`
                                <li class="cl-event">
                                    <span class="cl-event-dot"></span>
                                    <span class="cl-event-icon"><i class="fa-solid fa-briefcase"></i></span>
                                    <div class="cl-content">
                                        <div class="cl-card">
                                            <p class="cl-amount">Update Ledger : <span>${ledgerValue}</span></p>
                                            <p><i class="fa-regular fa-calendar"></i>Date : ${dateTime}</p>
                                            <p><i class="fa-regular fa-clock"></i>Record Time : ${recordTime}</p>
                                            ${data.description ? `<p class="cl-note-text"><i class="fa-regular fa-comment"></i>${data.description}</p>` : ''}
                                        </div>
                                        <div class="cl-ribbon">
                                            <span class="cl-ribbon-day">${dayNum}</span>
                                            <span class="cl-ribbon-mon">${monShort}</span>
                                        </div>
                                    </div>
                                </li>
                            `);
                        });

                        // ---- End endpoint (circular badge on the line) ----
                        $('#ledger_logs').append(`
                            <li class="cl-end-row">
                                <span class="cl-end-badge">End</span>
                            </li>
                        `);
                    } else {
                        $('#ledger_logs').html(`
                            <li class="cl-empty-state" style="list-style:none;">
                                <i class="fa-solid fa-clock-rotate-left"></i>
                                <p>No ledger history found</p>
                            </li>
                        `);
                    }
                },
                error: function () {
                    $('#ledger_logs').html(`
                        <li class="cl-error-state" style="list-style:none;">
                            <i class="fa-solid fa-circle-exclamation"></i>
                            <p>Failed to load ledger history</p>
                        </li>
                    `);
                }
            });
        }

        // ============================================
        // Close Ledger Modal
        // ============================================
        function closeLedgerModal() {
            $('#ledger_backlog_modal').css('display', 'none');
        }

        // Close modal on outside click
        $(document).on('click', '#ledger_backlog_modal', function (e) {
            if (e.target === this) {
                closeLedgerModal();
            }
        });

        // Close modal on ESC key
        $(document).on('keydown', function (e) {
            if (e.key === 'Escape') {
                if ($('#ledger_backlog_modal').css('display') === 'flex') {
                    closeLedgerModal();
                }
            }
        });

        // ============================================
        // Call after DOM is ready
        // ============================================
        $(document).ready(function () {
            // Initialize tooltip positioning
            setTimeout(positionTooltip, 100);
        });

        // Also reposition on window resize
        $(window).on('resize', function () {
            positionTooltip();
        });

        // ============================================
        // Document Ready
        // ============================================
        $(document).ready(function () {
            // Sidebar Toggle
            $('#sidebarToggle').on('click', function () {
                $('#sidebar').toggleClass('collapsed');
                const isCollapsed = $('#sidebar').hasClass('collapsed');
                localStorage.setItem('sidebarCollapsed', isCollapsed);
            });

            const savedState = localStorage.getItem('sidebarCollapsed');
            if (savedState === 'true') {
                $('#sidebar').addClass('collapsed');
            }

            // Load all data
            loadDealerProfile();
            loadProducts();
            loadTanks();
            loadOrders();
            loadSalesPerformance();
            initTabs();
        });
    </script>

</body>

</html>