<?php
// Hascol OMC Operations Command Center - User Setup
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hascol OMC - User Setup</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- CryptoJS for encryption/decryption -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/crypto-js.js"></script>

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

    <!-- Select2 CSS & JS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

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
        /* ============================================ */
        /* THEME VARIABLES                               */
        /* Default = LIGHT theme.                        */
        /* html.dark-mode (set by topbar toggle) = DARK   */
        /* ============================================ */
        :root {
            --bg-body: #f4f6fa;
            --bg-panel: #ffffff;
            --border-color: #e2e8f0;
            --text-heading: #0f2440;
            --text-body: #334155;
            --text-muted: #64748b;
            --input-bg: #ffffff;
            --hover-bg: #f1f5f9;
            --table-head-bg: #f8fafc;
            --table-head-text: #475569;
            --table-row-text: #1e293b;
            --table-row-hover: #f1f5f9;
            --scrollbar-track: #eef1f6;
            --scrollbar-thumb: #cbd5e1;
            --modal-overlay: rgba(15, 23, 42, 0.5);
            --btn-secondary-bg: #e2e8f0;
            --btn-secondary-text: #334155;
            --btn-secondary-hover-bg: #cbd5e1;
            --btn-secondary-hover-text: #0f2440;
            --toolbar-btn-bg: #ffffff;
            --modal-bg: #ffffff;
            --modal-border: #e2e8f0;
            --dropdown-bg: #ffffff;
            --dropdown-hover: #f1f5f9;
            --tab-bg: #ffffff;
            --tab-border: #e2e8f0;
            --tab-active: #1d4ed8;
            --tab-inactive: #64748b;
        }

        html.dark-mode {
            --bg-body: #060b13;
            --bg-panel: #0d1520;
            --border-color: #1a2635;
            --text-heading: #ffffff;
            --text-body: #e5e7eb;
            --text-muted: #94a3b8;
            --input-bg: #060b13;
            --hover-bg: #1a2635;
            --table-head-bg: #0a121c;
            --table-head-text: #94a3b8;
            --table-row-text: #e5e7eb;
            --table-row-hover: #0d1a2a;
            --scrollbar-track: #060b13;
            --scrollbar-thumb: #1a2635;
            --modal-overlay: rgba(6, 11, 19, 0.8);
            --btn-secondary-bg: #1a2635;
            --btn-secondary-text: #94a3b8;
            --btn-secondary-hover-bg: #1f2a3d;
            --btn-secondary-hover-text: #ffffff;
            --toolbar-btn-bg: #060b13;
            --modal-bg: #0d1520;
            --modal-border: #1a2635;
            --dropdown-bg: #0d1520;
            --dropdown-hover: #1a2635;
            --tab-bg: #0a121c;
            --tab-border: #1a2635;
            --tab-active: #3b82f6;
            --tab-inactive: #94a3b8;
        }

        body {
            background-color: var(--bg-body);
            color: var(--text-muted);
            font-family: 'Inter', sans-serif;
            transition: background-color .25s ease, color .25s ease;
        }

        .text-heading {
            color: var(--text-heading) !important;
        }

        .panel-card {
            background-color: var(--bg-panel);
            border: 1px solid var(--border-color);
            border-radius: 0.375rem;
            transition: background-color .25s ease, border-color .25s ease;
        }

        ::-webkit-scrollbar {
            width: 5px;
            height: 5px;
        }

        ::-webkit-scrollbar-track {
            background: var(--scrollbar-track);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--scrollbar-thumb);
            border-radius: 4px;
        }

        /* Sidebar Collapsed State */
        #sidebar.collapsed {
            width: 60px;
        }

        #sidebar.collapsed .sidebar-text {
            display: none;
        }

        #sidebar.collapsed .p-4 {
            padding: 12px 8px;
        }

        #sidebar.collapsed .p-4 .fa-fire-fluid {
            font-size: 1.5rem;
        }

        #sidebar.collapsed nav a {
            justify-content: center;
            padding: 8px 4px;
        }

        #sidebar.collapsed nav a i {
            font-size: 1.1rem;
            margin: 0;
        }

        #sidebar.collapsed .p-3 .sidebar-text {
            display: none;
        }

        #sidebar.collapsed .p-3 .flex.items-center {
            justify-content: center;
        }

        #sidebar.collapsed .p-3 img {
            width: 32px;
            height: 32px;
        }

        #sidebar,
        #mainContent {
            transition: all 0.3s ease-in-out;
        }

        /* ===== NAV TABS - PILL BACKED SEGMENTED CONTAINER ===== */
        .nav-tabs-custom {
            display: flex;
            flex-wrap: wrap;
            gap: 4px;
            padding: 6px;
            background: var(--bg-body);
            border: 1px solid var(--border-color);
            border-radius: 14px;
            width: 100%;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
            transition: background-color .25s ease, border-color .25s ease;
        }

        .nav-tabs-custom .nav-item {
            margin: 0;
            flex: 1 1 auto;
            min-width: 0;
        }

        .nav-tabs-custom .nav-link {
            border: none;
            border-radius: 10px;
            padding: 10px 18px;
            font-size: 11px;
            font-weight: 600;
            color: var(--tab-inactive);
            background: transparent;
            transition: all 0.25s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            cursor: pointer;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            width: 100%;
            white-space: nowrap;
            font-family: var(--body);
        }

        .nav-tabs-custom .nav-link i {
            font-size: 12px;
            opacity: 0.7;
            transition: opacity 0.2s;
        }

        .nav-tabs-custom .nav-link:hover:not(.active) {
            background: var(--hover-bg);
            color: var(--text-heading);
        }

        .nav-tabs-custom .nav-link:hover:not(.active) i {
            opacity: 1;
        }

        .nav-tabs-custom .nav-link.active {
            background: var(--bg-panel);
            color: var(--tab-active);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08), 0 1px 3px rgba(0, 0, 0, 0.05);
            font-weight: 700;
        }

        html.dark-mode .nav-tabs-custom .nav-link.active {
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.4), 0 1px 3px rgba(255, 255, 255, 0.04);
        }

        .nav-tabs-custom .nav-link.active i {
            opacity: 1;
        }

        /* Responsive adjustments */
        @media (max-width: 1024px) {
            .nav-tabs-custom .nav-link {
                font-size: 10px;
                padding: 8px 12px;
                letter-spacing: 0.3px;
            }

            .nav-tabs-custom .nav-link i {
                font-size: 10px;
            }
        }

        @media (max-width: 768px) {
            .nav-tabs-custom {
                padding: 4px;
                gap: 3px;
                border-radius: 10px;
                flex-wrap: nowrap;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
                scrollbar-width: none;
            }

            .nav-tabs-custom::-webkit-scrollbar {
                display: none;
            }

            .nav-tabs-custom .nav-item {
                flex: 0 0 auto;
            }

            .nav-tabs-custom .nav-link {
                font-size: 9px;
                padding: 6px 12px;
                letter-spacing: 0.2px;
                white-space: nowrap;
                border-radius: 8px;
            }

            .nav-tabs-custom .nav-link i {
                font-size: 9px;
            }
        }

        @media (max-width: 480px) {
            .nav-tabs-custom .nav-link {
                font-size: 8px;
                padding: 5px 10px;
                letter-spacing: 0;
            }

            .nav-tabs-custom .nav-link i {
                font-size: 8px;
            }
        }

        .nav-tabs-custom .nav-link.active {
            background: var(--tab-active);
            color: #ffffff;
            box-shadow: 0 2px 8px rgba(29, 78, 216, 0.25);
        }

        html.dark-mode .nav-tabs-custom .nav-link.active {
            box-shadow: 0 2px 8px rgba(59, 130, 246, 0.25);
        }

        /* Table Styles */
        .table-container {
            overflow-x: auto;
        }

        .table-container table {
            width: 100% !important;
            border-collapse: collapse;
            font-size: 11px;
        }

        .table-container table thead th {
            background-color: var(--table-head-bg) !important;
            color: var(--table-head-text) !important;
            font-weight: 500;
            text-align: left;
            padding: 8px 10px;
            border-bottom: 1px solid var(--border-color);
            white-space: nowrap;
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table-container table tbody td {
            padding: 8px 10px;
            border-bottom: 1px solid var(--border-color);
            color: var(--table-row-text);
            vertical-align: middle;
            font-size: 10px;
        }

        .table-container table tbody tr:hover {
            background-color: var(--table-row-hover);
        }

        .action-icon {
            color: var(--text-muted);
            cursor: pointer;
            transition: all 0.2s;
            padding: 4px 6px;
            border-radius: 4px;
            display: inline-block;
        }

        .action-icon:hover {
            background: var(--hover-bg);
            color: var(--text-heading);
        }

        .action-icon.edit:hover {
            background: #f59e0b20;
            color: #f59e0b;
        }

        .action-icon.delete:hover {
            background: #ef444420;
            color: #ef4444;
        }

        .action-icon.view:hover {
            background: #3b82f620;
            color: #3b82f6;
        }

        /* DataTables Custom Styles */
        .dataTables_wrapper .dataTables_filter {
            display: none !important;
        }

        .dataTables_wrapper .dataTables_length {
            display: none !important;
        }

        .dataTables_wrapper .dataTables_info {
            color: var(--text-muted) !important;
            font-size: 11px !important;
            padding-top: 12px !important;
        }

        .dataTables_wrapper .dataTables_paginate {
            padding-top: 12px !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 4px 10px !important;
            margin: 0 2px !important;
            border-radius: 4px !important;
            background: var(--toolbar-btn-bg) !important;
            border: 1px solid var(--border-color) !important;
            color: var(--text-muted) !important;
            font-size: 11px !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: var(--hover-bg) !important;
            color: var(--text-heading) !important;
            border-color: var(--border-color) !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #1d4ed8 !important;
            color: #ffffff !important;
            border-color: #1d4ed8 !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
            opacity: 0.5 !important;
            cursor: not-allowed !important;
        }

        .dt-buttons {
            display: flex !important;
            gap: 6px !important;
            flex-wrap: wrap !important;
        }

        .dt-buttons .dt-button {
            padding: 6px 12px !important;
            background-color: var(--toolbar-btn-bg) !important;
            border: 1px solid var(--border-color) !important;
            border-radius: 0.25rem !important;
            color: var(--text-muted) !important;
            font-size: 10px !important;
            cursor: pointer !important;
            transition: all 0.2s !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 4px !important;
            font-family: 'Inter', sans-serif !important;
        }

        .dt-buttons .dt-button:hover {
            background-color: var(--hover-bg) !important;
            color: var(--text-heading) !important;
        }

        .search-input {
            background-color: var(--input-bg);
            border: 1px solid var(--border-color);
            border-radius: 0.25rem;
            color: var(--text-body);
            padding: 6px 12px;
            font-size: 11px;
            min-width: 200px;
            outline: none;
        }

        .search-input:focus {
            border-color: #1d4ed8;
            box-shadow: 0 0 0 2px rgba(29, 78, 216, 0.2);
        }

        .search-input::placeholder {
            color: var(--text-muted);
        }

        .btn-primary {
            background-color: #1d4ed8;
            color: #ffffff;
            padding: 6px 16px;
            border-radius: 0.25rem;
            border: none;
            font-size: 11px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-primary:hover {
            background-color: #2563eb;
        }

        .btn-secondary {
            background-color: var(--btn-secondary-bg);
            color: var(--btn-secondary-text);
            padding: 8px 20px;
            border-radius: 0.25rem;
            border: none;
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s, color 0.2s;
        }

        .btn-secondary:hover {
            background-color: var(--btn-secondary-hover-bg);
            color: var(--btn-secondary-hover-text);
        }

        .btn-danger {
            background-color: #ef4444;
            color: #ffffff;
            padding: 6px 16px;
            border-radius: 0.25rem;
            border: none;
            font-size: 11px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .btn-danger:hover {
            background-color: #dc2626;
        }

        /* Badge */
        .badge {
            padding: 2px 8px;
            border-radius: 9999px;
            font-size: 8px;
            font-weight: 600;
            display: inline-block;
        }

        .badge-success {
            background: #10b98120;
            color: #10b981;
            border: 1px solid #10b98140;
        }

        .badge-danger {
            background: #ef444420;
            color: #ef4444;
            border: 1px solid #ef444440;
        }

        .badge-warning {
            background: #f59e0b20;
            color: #f59e0b;
            border: 1px solid #f59e0b40;
        }

        .badge-info {
            background: #3b82f620;
            color: #3b82f6;
            border: 1px solid #3b82f640;
        }

        /* ===== MODAL STYLES ===== */
        #modalOverlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--modal-overlay);
            backdrop-filter: blur(6px);
            z-index: 9998;
            display: none;
            justify-content: center;
            align-items: center;
        }

        #modalOverlay.active {
            display: flex;
        }

        #editModal {
            position: relative;
            width: 820px;
            max-width: 95vw;
            max-height: 90vh;
            background: var(--modal-bg);
            border: 1px solid var(--modal-border);
            border-radius: 12px;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.3);
            z-index: 9999;
            overflow-y: auto;
            transform: scale(0.95);
            transition: transform 0.25s ease, opacity 0.25s ease;
            opacity: 0;
        }

        #modalOverlay.active #editModal {
            transform: scale(1);
            opacity: 1;
        }

        #editModal .modal-header {
            padding: 16px 24px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: var(--table-head-bg);
            position: sticky;
            top: 0;
            z-index: 10;
            border-radius: 12px 12px 0 0;
        }

        #editModal .modal-body {
            padding: 20px 24px;
        }

        #editModal .modal-footer {
            padding: 12px 24px;
            border-top: 1px solid var(--border-color);
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            background: var(--table-head-bg);
            border-radius: 0 0 12px 12px;
            position: sticky;
            bottom: 0;
            z-index: 10;
        }

        .modal-close-btn {
            background: none;
            border: none;
            color: var(--text-muted);
            font-size: 24px;
            cursor: pointer;
            transition: color 0.2s;
            padding: 0 8px;
        }

        .modal-close-btn:hover {
            color: #ef4444;
        }

        /* Select2 Styles */
        .select2-container--default .select2-selection--multiple {
            background-color: var(--input-bg) !important;
            border: 1px solid var(--border-color) !important;
            border-radius: 0.25rem !important;
            min-height: 34px !important;
            padding: 2px 4px !important;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #3b82f6 !important;
            color: #ffffff !important;
            border: none !important;
            border-radius: 0.25rem !important;
            padding: 2px 8px !important;
            font-size: 11px !important;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: #ffffff !important;
            margin-right: 4px !important;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
            color: #ff6b6b !important;
        }

        .select2-dropdown {
            background-color: var(--dropdown-bg) !important;
            border: 1px solid var(--border-color) !important;
        }

        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #3b82f6 !important;
            color: #ffffff !important;
        }

        .select2-container--default .select2-results__option {
            color: var(--text-body) !important;
            font-size: 12px !important;
        }

        /* Form Styles */
        .form-input {
            background-color: var(--input-bg);
            border: 1px solid var(--border-color);
            border-radius: 0.25rem;
            color: var(--text-body);
            padding: 6px 10px;
            width: 100%;
            font-size: 12px;
            transition: border-color 0.2s;
        }

        .form-input:focus {
            outline: none;
            border-color: #1d4ed8;
            box-shadow: 0 0 0 2px rgba(29, 78, 216, 0.2);
        }

        .form-input::placeholder {
            color: var(--text-muted);
        }

        .form-label {
            color: var(--text-muted);
            font-size: 10px;
            font-weight: 500;
            margin-bottom: 3px;
            display: block;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-select {
            background-color: var(--input-bg);
            border: 1px solid var(--border-color);
            border-radius: 0.25rem;
            color: var(--text-body);
            padding: 6px 10px;
            width: 100%;
            font-size: 12px;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3E%3Cpath stroke='%2364748b' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3E%3C/svg%3E");
            background-position: right 8px center;
            background-repeat: no-repeat;
            background-size: 16px;
            padding-right: 32px;
            cursor: pointer;
        }

        .form-select:focus {
            outline: none;
            border-color: #1d4ed8;
            box-shadow: 0 0 0 2px rgba(29, 78, 216, 0.2);
        }
    </style>
</head>

<body class="flex h-screen overflow-hidden text-xs">

    <!-- ============================================ -->
    <!-- SIDEBAR - Included from includes/sidebar.php  -->
    <!-- ============================================ -->
    <?php include 'includes/sidebar.php'; ?>

    <!-- ============================================ -->
    <!-- MAIN CONTENT                                  -->
    <!-- ============================================ -->
    <main id="mainContent" class="flex-1 flex flex-col overflow-hidden">

        <!-- ============================================ -->
        <!-- TOPBAR - Included from includes/topbar.php   -->
        <!-- ============================================ -->
        <?php include 'includes/topbar.php'; ?>

        <!-- ============================================ -->
        <!-- PAGE CONTENT                                 -->
        <!-- ============================================ -->
        <div class="flex-1 overflow-y-auto p-4" id="pageContent">

            <!-- Page Header -->
            <div class="flex justify-between items-center mb-4">
                <div>
                    <h2 class="text-heading font-semibold text-base tracking-wide uppercase">Sukhekii North</h2>
                    <p class="text-[10px] text-gray-500">Manage facilities, products, tanks, dispensers, nozzles and
                        users</p>
                </div>
            </div>
            <!-- NAV TABS - PILL BACKED SEGMENTED CONTAINER  -->
            <div class="panel-card overflow-hidden mb-4">
                <div class="p-3">
                    <ul class="nav-tabs-custom" id="setupTabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-target="facilities" role="tab">
                                Facilities
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-target="products" role="tab">
                                Products
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-target="tanks" role="tab">
                                Tanks
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-target="dispenser" role="tab">
                                Dispenser
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-target="nozzle" role="tab">
                                Nozzle
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-target="users" role="tab">
                                Users
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-target="last_recon" role="tab">
                                Update Last Recon
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- ============================================ -->
            <!-- TAB CONTENT                                   -->
            <!-- ============================================ -->
            <div class="tab-content">

                <!-- ========================================== -->
                <!-- FACILITIES TAB                             -->
                <!-- ========================================== -->
                <div class="tab-pane active" id="facilities">
                    <div class="panel-card overflow-hidden">
                        <div class="p-3 border-b flex justify-between items-center"
                            style="border-color: var(--border-color);">
                            <h3 class="text-heading font-semibold text-xs tracking-wide uppercase">Facilities</h3>
                            <button class="btn-primary" onclick="openModal('facility')">
                                <i class="fa-solid fa-plus"></i> Add
                            </button>
                        </div>
                        <div class="p-3">
                            <div class="flex justify-between items-center mb-3">
                                <div id="facilityButtons"></div>
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-magnifying-glass text-gray-500 text-xs"></i>
                                    <input type="text" id="facilitySearch" placeholder="Search..." class="search-input">
                                </div>
                            </div>
                            <div class="table-container">
                                <table id="facilityTable" class="display" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Facility</th>
                                            <th>Created At</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="facilityTableBody">
                                        <tr>
                                            <td colspan="4" class="text-center py-8 text-gray-500">
                                                <i class="fa-solid fa-spinner fa-spin text-blue-400 mr-2"></i>
                                                Loading...
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ========================================== -->
                <!-- PRODUCTS TAB                               -->
                <!-- ========================================== -->
                <div class="tab-pane hidden" id="products">
                    <div class="panel-card overflow-hidden">
                        <div class="p-3 border-b flex justify-between items-center"
                            style="border-color: var(--border-color);">
                            <h3 class="text-heading font-semibold text-xs tracking-wide uppercase">Products</h3>
                            <button class="btn-primary" onclick="openModal('product')">
                                <i class="fa-solid fa-plus"></i> Add
                            </button>
                        </div>
                        <div class="p-3">
                            <div class="flex justify-between items-center mb-3">
                                <div id="productButtons"></div>
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-magnifying-glass text-gray-500 text-xs"></i>
                                    <input type="text" id="productSearch" placeholder="Search..." class="search-input">
                                </div>
                            </div>
                            <div class="table-container">
                                <table id="productTable" class="display" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Name</th>
                                            <th>From</th>
                                            <th>To</th>
                                            <th>Indent Price</th>
                                            <th>Nozzle Price</th>
                                            <th>Update Time</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="productTableBody">
                                        <tr>
                                            <td colspan="8" class="text-center py-8 text-gray-500">
                                                <i class="fa-solid fa-spinner fa-spin text-blue-400 mr-2"></i>
                                                Loading...
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ========================================== -->
                <!-- TANKS TAB                                  -->
                <!-- ========================================== -->
                <div class="tab-pane hidden" id="tanks">
                    <div class="panel-card overflow-hidden">
                        <div class="p-3 border-b flex justify-between items-center"
                            style="border-color: var(--border-color);">
                            <h3 class="text-heading font-semibold text-xs tracking-wide uppercase">Tanks</h3>
                            <button class="btn-primary" onclick="openModal('tank')">
                                <i class="fa-solid fa-plus"></i> Add
                            </button>
                        </div>
                        <div class="p-3">
                            <div class="flex justify-between items-center mb-3">
                                <div id="tankButtons"></div>
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-magnifying-glass text-gray-500 text-xs"></i>
                                    <input type="text" id="tankSearch" placeholder="Search..." class="search-input">
                                </div>
                            </div>
                            <div class="table-container">
                                <table id="tankTable" class="display" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Tank #</th>
                                            <th>Product</th>
                                            <th>Capacity</th>
                                            <th>Current Dip</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tankTableBody">
                                        <tr>
                                            <td colspan="6" class="text-center py-8 text-gray-500">
                                                <i class="fa-solid fa-spinner fa-spin text-blue-400 mr-2"></i>
                                                Loading...
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ========================================== -->
                <!-- DISPENSER TAB                              -->
                <!-- ========================================== -->
                <div class="tab-pane hidden" id="dispenser">
                    <div class="panel-card overflow-hidden">
                        <div class="p-3 border-b flex justify-between items-center"
                            style="border-color: var(--border-color);">
                            <h3 class="text-heading font-semibold text-xs tracking-wide uppercase">Dispenser</h3>
                            <button class="btn-primary" onclick="openModal('dispenser')">
                                <i class="fa-solid fa-plus"></i> Add
                            </button>
                        </div>
                        <div class="p-3">
                            <div class="flex justify-between items-center mb-3">
                                <div id="dispenserButtons"></div>
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-magnifying-glass text-gray-500 text-xs"></i>
                                    <input type="text" id="dispenserSearch" placeholder="Search..."
                                        class="search-input">
                                </div>
                            </div>
                            <div class="table-container">
                                <table id="dispenserTable" class="display" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Dispenser</th>
                                            <th>Description</th>
                                            <th>Created At</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="dispenserTableBody">
                                        <tr>
                                            <td colspan="5" class="text-center py-8 text-gray-500">
                                                <i class="fa-solid fa-spinner fa-spin text-blue-400 mr-2"></i>
                                                Loading...
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ========================================== -->
                <!-- NOZZLE TAB                                 -->
                <!-- ========================================== -->
                <div class="tab-pane hidden" id="nozzle">
                    <div class="panel-card overflow-hidden">
                        <div class="p-3 border-b flex justify-between items-center"
                            style="border-color: var(--border-color);">
                            <h3 class="text-heading font-semibold text-xs tracking-wide uppercase">Nozzle</h3>
                            <button class="btn-primary" onclick="openModal('nozzle')">
                                <i class="fa-solid fa-plus"></i> Add
                            </button>
                        </div>
                        <div class="p-3">
                            <div class="flex justify-between items-center mb-3">
                                <div id="nozzleButtons"></div>
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-magnifying-glass text-gray-500 text-xs"></i>
                                    <input type="text" id="nozzleSearch" placeholder="Search..." class="search-input">
                                </div>
                            </div>
                            <div class="table-container">
                                <table id="nozzleTable" class="display" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Nozzle</th>
                                            <th>Product</th>
                                            <th>Tank</th>
                                            <th>Dispenser</th>
                                            <th>Last Reading</th>
                                            <th>Created At</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="nozzleTableBody">
                                        <tr>
                                            <td colspan="8" class="text-center py-8 text-gray-500">
                                                <i class="fa-solid fa-spinner fa-spin text-blue-400 mr-2"></i>
                                                Loading...
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ========================================== -->
                <!-- USERS TAB                                 -->
                <!-- ========================================== -->
                <div class="tab-pane hidden" id="users">
                    <div class="panel-card overflow-hidden">
                        <div class="p-3 border-b flex justify-between items-center"
                            style="border-color: var(--border-color);">
                            <h3 class="text-heading font-semibold text-xs tracking-wide uppercase">Users</h3>
                            <button class="btn-primary" onclick="openModal('user')">
                                <i class="fa-solid fa-plus"></i> Add
                            </button>
                        </div>
                        <div class="p-3">
                            <div class="flex justify-between items-center mb-3">
                                <div id="userButtons"></div>
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-magnifying-glass text-gray-500 text-xs"></i>
                                    <input type="text" id="userSearch" placeholder="Search..." class="search-input">
                                </div>
                            </div>
                            <div class="table-container">
                                <table id="userTable" class="display" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Role</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="userTableBody">
                                        <tr>
                                            <td colspan="7" class="text-center py-8 text-gray-500">
                                                <i class="fa-solid fa-spinner fa-spin text-blue-400 mr-2"></i>
                                                Loading...
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ========================================== -->
                <!-- UPDATE LAST RECON TAB                      -->
                <!-- ========================================== -->
                <div class="tab-pane hidden" id="last_recon">
                    <div class="panel-card overflow-hidden">
                        <div class="p-3 border-b" style="border-color: var(--border-color);">
                            <h3 class="text-heading font-semibold text-xs tracking-wide uppercase">Update Last Recon
                            </h3>
                        </div>
                        <div class="p-3">
                            <div class="flex justify-between items-center mb-3">
                                <div id="reconButtons"></div>
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-magnifying-glass text-gray-500 text-xs"></i>
                                    <input type="text" id="reconSearch" placeholder="Search..." class="search-input">
                                </div>
                            </div>
                            <div class="table-container">
                                <table id="reconTable" class="display" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Planned Date</th>
                                            <th>Site Name</th>
                                            <th>Product</th>
                                            <th>Total Days</th>
                                            <th>From</th>
                                            <th>To</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="reconTableBody">
                                        <tr>
                                            <td colspan="8" class="text-center py-8 text-gray-500">
                                                <i class="fa-solid fa-spinner fa-spin text-blue-400 mr-2"></i>
                                                Loading...
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div><!-- end tab-content -->

        </div><!-- end pageContent -->
    </main>

    <!-- ============================================ -->
    <!-- MODAL OVERLAY                               -->
    <!-- ============================================ -->
    <div id="modalOverlay">
        <div id="editModal">
            <div class="modal-header">
                <h3 class="text-heading font-semibold text-sm tracking-wide" id="modalTitle">Add Record</h3>
                <button class="modal-close-btn" onclick="closeModal()">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="setupForm" onsubmit="saveRecord(event)">
                    <input type="hidden" id="recordId" value="">
                    <input type="hidden" id="recordType" value="">
                    <input type="hidden" id="dealerId" value="">

                    <div id="formFields">
                        <!-- Dynamic form fields will be loaded here -->
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="closeModal()" class="btn-secondary">Close</button>
                <button type="submit" form="setupForm" class="btn-primary">Save</button>
            </div>
        </div>
    </div>

    <!-- ============================================ -->
    <!-- TOAST NOTIFICATION                           -->
    <!-- ============================================ -->
    <div id="toast"
        class="fixed bottom-6 right-6 bg-panel border border-border rounded-md px-5 py-3 shadow-lg z-[9999] transform translate-y-24 opacity-0 transition-all duration-300"
        style="background: var(--bg-panel); border-color: var(--border-color);">
        <i class="fa-solid fa-check-circle mr-2 text-green-500"></i>
        <span id="toastMessage" style="color: var(--text-body);">Success!</span>
    </div>

    <!-- ============================================ -->
    <!-- JAVASCRIPT                                   -->
    <!-- ============================================ -->
    <script>
        // ============================================
        // Encryption Function
        // ============================================
        function encryptId(originalId) {
            const key = 'Hamza Ansari';
            const iv = CryptoJS.lib.WordArray.random(16);
            const cipher = CryptoJS.AES.encrypt(originalId.toString(), key, { iv: iv });
            return cipher.toString();
        }

        function decryptId(encryptedId) {
            try {
                const key = 'Hamza Ansari';
                const bytes = CryptoJS.AES.decrypt(decodeURIComponent(encryptedId), key);
                const decrypted = bytes.toString(CryptoJS.enc.Utf8);
                return parseInt(decrypted) || 0;
            } catch (e) {
                console.error('Decryption error:', e);
                return 0;
            }
        }

        function getUrlParameter(name) {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(name);
        }

        // ============================================
        // API Configuration
        // ============================================
        const API_BASE_URL = 'api/';
        const PRE = 'Admin';
        const USER_ID = '1';

        // ============================================
        // Get Dealer ID from URL
        // ============================================
        const encryptedId = getUrlParameter('id');
        const dealerId = encryptedId ? decryptId(encryptedId) : 0;

        // ============================================
        // Data Stores
        // ============================================
        let dataTables = {};

        // ============================================
        // Modal Functions
        // ============================================
        function openModal(type, id = null) {
            $('#recordId').val(id || '');
            $('#recordType').val(type);
            $('#modalTitle').text(id ? 'Edit ' + type.charAt(0).toUpperCase() + type.slice(1) : 'Add ' + type.charAt(0)
                .toUpperCase() + type.slice(1));

            // Build form based on type
            let html = '';
            switch (type) {
                case 'facility':
                    html = `
                        <div class="mb-3">
                            <label class="form-label">Facility Name</label>
                            <input type="text" id="facilityName" class="form-input" placeholder="Enter facility name" required>
                        </div>
                    `;
                    break;
                case 'product':
                    html = `
                        <div class="grid grid-cols-2 gap-3 mb-3">
                            <div>
                                <label class="form-label">Product Name</label>
                                <input type="text" id="productName" class="form-input" placeholder="Enter product name" required>
                            </div>
                            <div>
                                <label class="form-label">Product ID</label>
                                <input type="text" id="productId" class="form-input" placeholder="Enter product ID" required>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-3 mb-3">
                            <div>
                                <label class="form-label">From Date</label>
                                <input type="datetime-local" id="productFrom" class="form-input" required>
                            </div>
                            <div>
                                <label class="form-label">To Date</label>
                                <input type="datetime-local" id="productTo" class="form-input" required>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-3 mb-3">
                            <div>
                                <label class="form-label">Indent Price</label>
                                <input type="number" id="productIndent" class="form-input" placeholder="Enter indent price" step="any" required>
                            </div>
                            <div>
                                <label class="form-label">Nozzle Price</label>
                                <input type="number" id="productNozzle" class="form-input" placeholder="Enter nozzle price" step="any" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea id="productDesc" class="form-input" rows="3" placeholder="Enter description"></textarea>
                        </div>
                    `;
                    break;
                case 'tank':
                    html = `
                        <div class="mb-3">
                            <label class="form-label">Tank #</label>
                            <input type="text" id="tankNo" class="form-input" placeholder="Enter tank number" required>
                        </div>
                        <div class="grid grid-cols-2 gap-3 mb-3">
                            <div>
                                <label class="form-label">Product</label>
                                <select id="tankProduct" class="form-select" required>
                                    <option value="">Select Product</option>
                                </select>
                            </div>
                            <div>
                                <label class="form-label">Capacity</label>
                                <input type="number" id="tankCapacity" class="form-input" placeholder="Enter capacity" required>
                            </div>
                        </div>
                    `;
                    break;
                case 'dispenser':
                    html = `
                        <div class="mb-3">
                            <label class="form-label">Dispenser Name</label>
                            <input type="text" id="dispenserName" class="form-input" placeholder="Enter dispenser name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea id="dispenserDesc" class="form-input" rows="3" placeholder="Enter description"></textarea>
                        </div>
                    `;
                    break;
                case 'nozzle':
                    html = `
                        <div class="mb-3">
                            <label class="form-label">Nozzle Name</label>
                            <input type="text" id="nozzleName" class="form-input" placeholder="Enter nozzle name" required>
                        </div>
                        <div class="grid grid-cols-2 gap-3 mb-3">
                            <div>
                                <label class="form-label">Product</label>
                                <select id="nozzleProduct" class="form-select" required>
                                    <option value="">Select Product</option>
                                </select>
                            </div>
                            <div>
                                <label class="form-label">Tank</label>
                                <select id="nozzleTank" class="form-select" required>
                                    <option value="">Select Tank</option>
                                </select>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-3 mb-3">
                            <div>
                                <label class="form-label">Dispenser</label>
                                <select id="nozzleDispenser" class="form-select" required>
                                    <option value="">Select Dispenser</option>
                                </select>
                            </div>
                            <div>
                                <label class="form-label">Last Reading</label>
                                <input type="number" id="nozzleReading" class="form-input" placeholder="Enter last reading" step="any" required>
                            </div>
                        </div>
                    `;
                    break;
                case 'user':
                    html = `
                        <div class="grid grid-cols-2 gap-3 mb-3">
                            <div>
                                <label class="form-label">Full Name</label>
                                <input type="text" id="userName" class="form-input" placeholder="Enter name" required>
                            </div>
                            <div>
                                <label class="form-label">Email</label>
                                <input type="email" id="userEmail" class="form-input" placeholder="Enter email" required>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-3 mb-3">
                            <div>
                                <label class="form-label">Password</label>
                                <input type="text" id="userPassword" class="form-input" placeholder="Enter password">
                            </div>
                            <div>
                                <label class="form-label">Phone</label>
                                <input type="text" id="userPhone" class="form-input" placeholder="Enter phone" required>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-3 mb-3">
                            <div>
                                <label class="form-label">Role</label>
                                <select id="userRole" class="form-select" required>
                                    <option value="">Select Role</option>
                                    <option value="Admin">Admin</option>
                                    <option value="ZM">ZM</option>
                                    <option value="TM">TM</option>
                                    <option value="ASM">ASM</option>
                                    <option value="BSM">BSM</option>
                                    <option value="Order">Order</option>
                                    <option value="Reporting">Reporting</option>
                                    <option value="BSO">BSO</option>
                                </select>
                            </div>
                            <div>
                                <label class="form-label">Status</label>
                                <select id="userStatus" class="form-select" required>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                    `;
                    break;
                case 'recon':
                    html = `
                        <div class="mb-3">
                            <label class="form-label">This is for Update Last Recon</label>
                            <p class="text-xs text-gray-500">Click Edit to update recon records</p>
                        </div>
                    `;
                    break;
                default:
                    html = '<p class="text-gray-500">Form not available</p>';
            }

            $('#formFields').html(html);
            $('#modalOverlay').addClass('active');
        }

        function closeModal() {
            $('#modalOverlay').removeClass('active');
        }

        // Close modal on overlay click
        $('#modalOverlay').on('click', function (e) {
            if (e.target === this) {
                closeModal();
            }
        });

        // Close modal on ESC key
        $(document).on('keydown', function (e) {
            if (e.key === 'Escape') {
                if ($('#modalOverlay').hasClass('active')) {
                    closeModal();
                }
            }
        });

        // ============================================
        // Tabs
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

            // Tab switching
            $('.nav-tabs-custom .nav-link').on('click', function () {
                $('.nav-tabs-custom .nav-link').removeClass('active');
                $(this).addClass('active');

                const target = $(this).data('target');
                $('.tab-pane').addClass('hidden');
                $('#' + target).removeClass('hidden');

                // Load data for the selected tab
                loadTabData(target);
            });

            // Load initial tab
            loadTabData('facilities');
        });

        // ============================================
        // Load Tab Data
        // ============================================
        function loadTabData(tab) {
            switch (tab) {
                case 'facilities':
                    loadFacilities();
                    break;
                case 'products':
                    loadProducts();
                    break;
                case 'tanks':
                    loadTanks();
                    break;
                case 'dispenser':
                    loadDispensers();
                    break;
                case 'nozzle':
                    loadNozzles();
                    break;
                case 'users':
                    loadUsers();
                    break;
                case 'last_recon':
                    loadLastRecon();
                    break;
            }
        }

        // ============================================
        // Load Facilities
        // ============================================
        function loadFacilities() {
            $('#facilityTableBody').html(`
                <tr><td colspan="4" class="text-center py-8 text-gray-500">
                    <i class="fa-solid fa-spinner fa-spin text-blue-400 mr-2"></i> Loading...
                </td></tr>
            `);

            $.ajax({
                url: API_BASE_URL + 'get/facilities_get.php?key=03201232927&dealer_id=' + dealerId,
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (dataTables.facility) {
                        dataTables.facility.destroy();
                    }

                    const tableData = response.map((item, index) => [
                        index + 1,
                        item.name || 'N/A',
                        item.created_at || 'N/A',
                        `<span class="action-icon delete" onclick="deleteRecord('facility', ${item.id})">
                            <i class="fa-regular fa-trash-can"></i>
                        </span>`
                    ]);

                    if (tableData.length === 0) {
                        tableData.push(['No data available', '', '', '']);
                    }

                    dataTables.facility = $('#facilityTable').DataTable({
                        data: tableData,
                        columns: [
                            { title: 'S.No' },
                            { title: 'Facility' },
                            { title: 'Created At' },
                            { title: 'Action', orderable: false, searchable: false }
                        ],
                        dom: 'Bfrtip',
                        buttons: [
                            { extend: 'copy', text: '<i class="fa-regular fa-copy"></i> Copy', className: 'toolbar-btn', exportOptions: { columns: [0, 1, 2] } },
                            { extend: 'excelHtml5', text: '<i class="fa-regular fa-file-excel"></i> Excel', className: 'toolbar-btn', exportOptions: { columns: [0, 1, 2] }, title: 'Facilities' },
                            { extend: 'csvHtml5', text: '<i class="fa-regular fa-file-csv"></i> CSV', className: 'toolbar-btn', exportOptions: { columns: [0, 1, 2] }, title: 'Facilities' },
                            { extend: 'pdfHtml5', text: '<i class="fa-regular fa-file-pdf"></i> PDF', className: 'toolbar-btn', exportOptions: { columns: [0, 1, 2] }, title: 'Facilities Report' },
                            { extend: 'print', text: '<i class="fa-solid fa-print"></i> Print', className: 'toolbar-btn', exportOptions: { columns: [0, 1, 2] } }
                        ],
                        pageLength: 10,
                        lengthMenu: [10, 25, 50, 100],
                        language: {
                            emptyTable: '<div class="text-center py-8 text-gray-500"><i class="fa-solid fa-building text-2xl block mb-2"></i>No facilities found</div>',
                            info: 'Showing _START_ to _END_ of _TOTAL_ entries',
                            infoEmpty: 'Showing 0 to 0 of 0 entries',
                            infoFiltered: '(filtered from _MAX_ total entries)'
                        },
                        initComplete: function () {
                            const $btns = $(this.api().table().container()).find('> .dt-buttons');
                            $btns.addClass('toolbar-btn-group');
                            $('#facilityButtons').empty().append($btns);
                            $btns.css('display', 'flex');
                        }
                    });

                    $('#facilitySearch').off('keyup').on('keyup', function () {
                        dataTables.facility.search(this.value).draw();
                    });
                },
                error: function () {
                    showToast('Failed to load facilities.', 'error');
                }
            });
        }

        // ============================================
        // Load Products
        // ============================================
        function loadProducts() {
            $('#productTableBody').html(`
                <tr><td colspan="8" class="text-center py-8 text-gray-500">
                    <i class="fa-solid fa-spinner fa-spin text-blue-400 mr-2"></i> Loading...
                </td></tr>
            `);

            $.ajax({
                url: API_BASE_URL + 'get/dealers_products.php?key=03201232927&dealer_id=' + dealerId,
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (dataTables.product) {
                        dataTables.product.destroy();
                    }

                    const tableData = response.map((item, index) => [
                        index + 1,
                        item.name || 'N/A',
                        item.from || 'N/A',
                        item.to || 'N/A',
                        item.indent_price || 'N/A',
                        item.nozel_price || 'N/A',
                        item.update_time || 'N/A',
                        `<span class="action-icon edit" onclick="editRecord('product', ${item.id})">
                            <i class="fa-regular fa-pen-to-square"></i>
                        </span>
                        <span class="action-icon delete" onclick="deleteRecord('product', ${item.id})">
                            <i class="fa-regular fa-trash-can"></i>
                        </span>`
                    ]);

                    if (tableData.length === 0) {
                        tableData.push(['No data available', '', '', '', '', '', '', '']);
                    }

                    dataTables.product = $('#productTable').DataTable({
                        data: tableData,
                        columns: [
                            { title: 'S.No' },
                            { title: 'Name' },
                            { title: 'From' },
                            { title: 'To' },
                            { title: 'Indent Price' },
                            { title: 'Nozzle Price' },
                            { title: 'Update Time' },
                            { title: 'Action', orderable: false, searchable: false }
                        ],
                        dom: 'Bfrtip',
                        buttons: [
                            { extend: 'copy', text: '<i class="fa-regular fa-copy"></i> Copy', className: 'toolbar-btn', exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6] } },
                            { extend: 'excelHtml5', text: '<i class="fa-regular fa-file-excel"></i> Excel', className: 'toolbar-btn', exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6] }, title: 'Products' },
                            { extend: 'csvHtml5', text: '<i class="fa-regular fa-file-csv"></i> CSV', className: 'toolbar-btn', exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6] }, title: 'Products' },
                            { extend: 'pdfHtml5', text: '<i class="fa-regular fa-file-pdf"></i> PDF', className: 'toolbar-btn', exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6] }, title: 'Products Report' },
                            { extend: 'print', text: '<i class="fa-solid fa-print"></i> Print', className: 'toolbar-btn', exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6] } }
                        ],
                        pageLength: 10,
                        lengthMenu: [10, 25, 50, 100],
                        language: {
                            emptyTable: '<div class="text-center py-8 text-gray-500"><i class="fa-solid fa-box text-2xl block mb-2"></i>No products found</div>',
                            info: 'Showing _START_ to _END_ of _TOTAL_ entries',
                            infoEmpty: 'Showing 0 to 0 of 0 entries',
                            infoFiltered: '(filtered from _MAX_ total entries)'
                        },
                        initComplete: function () {
                            const $btns = $(this.api().table().container()).find('> .dt-buttons');
                            $btns.addClass('toolbar-btn-group');
                            $('#productButtons').empty().append($btns);
                            $btns.css('display', 'flex');
                        }
                    });

                    $('#productSearch').off('keyup').on('keyup', function () {
                        dataTables.product.search(this.value).draw();
                    });
                },
                error: function () {
                    showToast('Failed to load products.', 'error');
                }
            });
        }

        // ============================================
        // Load Tanks
        // ============================================
        function loadTanks() {
            $('#tankTableBody').html(`
                <tr><td colspan="6" class="text-center py-8 text-gray-500">
                    <i class="fa-solid fa-spinner fa-spin text-blue-400 mr-2"></i> Loading...
                </td></tr>
            `);

            $.ajax({
                url: API_BASE_URL + 'get/get_dealers_tanks.php?key=03201232927&dealer_id=' + dealerId,
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (dataTables.tank) {
                        dataTables.tank.destroy();
                    }

                    const tableData = response.map((item, index) => [
                        index + 1,
                        item.lorry_no || 'N/A',
                        item.name || 'N/A',
                        item.max_limit || 'N/A',
                        item.current_dip || 'N/A',
                        `<span class="action-icon edit" onclick="editRecord('tank', ${item.id})">
                            <i class="fa-regular fa-pen-to-square"></i>
                        </span>
                        <span class="action-icon delete" onclick="deleteRecord('tank', ${item.id})">
                            <i class="fa-regular fa-trash-can"></i>
                        </span>`
                    ]);

                    if (tableData.length === 0) {
                        tableData.push(['No data available', '', '', '', '', '']);
                    }

                    dataTables.tank = $('#tankTable').DataTable({
                        data: tableData,
                        columns: [
                            { title: 'S.No' },
                            { title: 'Tank #' },
                            { title: 'Product' },
                            { title: 'Capacity' },
                            { title: 'Current Dip' },
                            { title: 'Action', orderable: false, searchable: false }
                        ],
                        dom: 'Bfrtip',
                        buttons: [
                            { extend: 'copy', text: '<i class="fa-regular fa-copy"></i> Copy', className: 'toolbar-btn', exportOptions: { columns: [0, 1, 2, 3, 4] } },
                            { extend: 'excelHtml5', text: '<i class="fa-regular fa-file-excel"></i> Excel', className: 'toolbar-btn', exportOptions: { columns: [0, 1, 2, 3, 4] }, title: 'Tanks' },
                            { extend: 'csvHtml5', text: '<i class="fa-regular fa-file-csv"></i> CSV', className: 'toolbar-btn', exportOptions: { columns: [0, 1, 2, 3, 4] }, title: 'Tanks' },
                            { extend: 'pdfHtml5', text: '<i class="fa-regular fa-file-pdf"></i> PDF', className: 'toolbar-btn', exportOptions: { columns: [0, 1, 2, 3, 4] }, title: 'Tanks Report' },
                            { extend: 'print', text: '<i class="fa-solid fa-print"></i> Print', className: 'toolbar-btn', exportOptions: { columns: [0, 1, 2, 3, 4] } }
                        ],
                        pageLength: 10,
                        lengthMenu: [10, 25, 50, 100],
                        language: {
                            emptyTable: '<div class="text-center py-8 text-gray-500"><i class="fa-solid fa-oil-can text-2xl block mb-2"></i>No tanks found</div>',
                            info: 'Showing _START_ to _END_ of _TOTAL_ entries',
                            infoEmpty: 'Showing 0 to 0 of 0 entries',
                            infoFiltered: '(filtered from _MAX_ total entries)'
                        },
                        initComplete: function () {
                            const $btns = $(this.api().table().container()).find('> .dt-buttons');
                            $btns.addClass('toolbar-btn-group');
                            $('#tankButtons').empty().append($btns);
                            $btns.css('display', 'flex');
                        }
                    });

                    $('#tankSearch').off('keyup').on('keyup', function () {
                        dataTables.tank.search(this.value).draw();
                    });
                },
                error: function () {
                    showToast('Failed to load tanks.', 'error');
                }
            });
        }

        // ============================================
        // Load Dispensers
        // ============================================
        function loadDispensers() {
            $('#dispenserTableBody').html(`
                <tr><td colspan="5" class="text-center py-8 text-gray-500">
                    <i class="fa-solid fa-spinner fa-spin text-blue-400 mr-2"></i> Loading...
                </td></tr>
            `);

            $.ajax({
                url: API_BASE_URL + 'get/get_dealers_dispenser.php?key=03201232927&dealer_id=' + dealerId,
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (dataTables.dispenser) {
                        dataTables.dispenser.destroy();
                    }

                    const tableData = response.map((item, index) => [
                        index + 1,
                        item.name || 'N/A',
                        item.description || 'N/A',
                        item.created_at || 'N/A',
                        `<span class="action-icon edit" onclick="editRecord('dispenser', ${item.id})">
                            <i class="fa-regular fa-pen-to-square"></i>
                        </span>
                        <span class="action-icon delete" onclick="deleteRecord('dispenser', ${item.id})">
                            <i class="fa-regular fa-trash-can"></i>
                        </span>`
                    ]);

                    if (tableData.length === 0) {
                        tableData.push(['No data available', '', '', '', '']);
                    }

                    dataTables.dispenser = $('#dispenserTable').DataTable({
                        data: tableData,
                        columns: [
                            { title: 'S.No' },
                            { title: 'Dispenser' },
                            { title: 'Description' },
                            { title: 'Created At' },
                            { title: 'Action', orderable: false, searchable: false }
                        ],
                        dom: 'Bfrtip',
                        buttons: [
                            { extend: 'copy', text: '<i class="fa-regular fa-copy"></i> Copy', className: 'toolbar-btn', exportOptions: { columns: [0, 1, 2, 3] } },
                            { extend: 'excelHtml5', text: '<i class="fa-regular fa-file-excel"></i> Excel', className: 'toolbar-btn', exportOptions: { columns: [0, 1, 2, 3] }, title: 'Dispensers' },
                            { extend: 'csvHtml5', text: '<i class="fa-regular fa-file-csv"></i> CSV', className: 'toolbar-btn', exportOptions: { columns: [0, 1, 2, 3] }, title: 'Dispensers' },
                            { extend: 'pdfHtml5', text: '<i class="fa-regular fa-file-pdf"></i> PDF', className: 'toolbar-btn', exportOptions: { columns: [0, 1, 2, 3] }, title: 'Dispensers Report' },
                            { extend: 'print', text: '<i class="fa-solid fa-print"></i> Print', className: 'toolbar-btn', exportOptions: { columns: [0, 1, 2, 3] } }
                        ],
                        pageLength: 10,
                        lengthMenu: [10, 25, 50, 100],
                        language: {
                            emptyTable: '<div class="text-center py-8 text-gray-500"><i class="fa-solid fa-oil-can text-2xl block mb-2"></i>No dispensers found</div>',
                            info: 'Showing _START_ to _END_ of _TOTAL_ entries',
                            infoEmpty: 'Showing 0 to 0 of 0 entries',
                            infoFiltered: '(filtered from _MAX_ total entries)'
                        },
                        initComplete: function () {
                            const $btns = $(this.api().table().container()).find('> .dt-buttons');
                            $btns.addClass('toolbar-btn-group');
                            $('#dispenserButtons').empty().append($btns);
                            $btns.css('display', 'flex');
                        }
                    });

                    $('#dispenserSearch').off('keyup').on('keyup', function () {
                        dataTables.dispenser.search(this.value).draw();
                    });
                },
                error: function () {
                    showToast('Failed to load dispensers.', 'error');
                }
            });
        }

        // ============================================
        // Load Nozzles
        // ============================================
        function loadNozzles() {
            $('#nozzleTableBody').html(`
                <tr><td colspan="8" class="text-center py-8 text-gray-500">
                    <i class="fa-solid fa-spinner fa-spin text-blue-400 mr-2"></i> Loading...
                </td></tr>
            `);

            $.ajax({
                url: API_BASE_URL + 'get/get_dealers_nozels.php?key=03201232927&dealer_id=' + dealerId,
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (dataTables.nozzle) {
                        dataTables.nozzle.destroy();
                    }

                    const tableData = response.map((item, index) => [
                        index + 1,
                        item.name || 'N/A',
                        item.product_name || 'N/A',
                        item.tank_name || 'N/A',
                        item.dispenser_name || 'N/A',
                        item.last_reading || 'N/A',
                        item.created_at || 'N/A',
                        `<span class="action-icon edit" onclick="editRecord('nozzle', ${item.id})">
                            <i class="fa-regular fa-pen-to-square"></i>
                        </span>
                        <span class="action-icon delete" onclick="deleteRecord('nozzle', ${item.id})">
                            <i class="fa-regular fa-trash-can"></i>
                        </span>`
                    ]);

                    if (tableData.length === 0) {
                        tableData.push(['No data available', '', '', '', '', '', '', '']);
                    }

                    dataTables.nozzle = $('#nozzleTable').DataTable({
                        data: tableData,
                        columns: [
                            { title: 'S.No' },
                            { title: 'Nozzle' },
                            { title: 'Product' },
                            { title: 'Tank' },
                            { title: 'Dispenser' },
                            { title: 'Last Reading' },
                            { title: 'Created At' },
                            { title: 'Action', orderable: false, searchable: false }
                        ],
                        dom: 'Bfrtip',
                        buttons: [
                            { extend: 'copy', text: '<i class="fa-regular fa-copy"></i> Copy', className: 'toolbar-btn', exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6] } },
                            { extend: 'excelHtml5', text: '<i class="fa-regular fa-file-excel"></i> Excel', className: 'toolbar-btn', exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6] }, title: 'Nozzles' },
                            { extend: 'csvHtml5', text: '<i class="fa-regular fa-file-csv"></i> CSV', className: 'toolbar-btn', exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6] }, title: 'Nozzles' },
                            { extend: 'pdfHtml5', text: '<i class="fa-regular fa-file-pdf"></i> PDF', className: 'toolbar-btn', exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6] }, title: 'Nozzles Report' },
                            { extend: 'print', text: '<i class="fa-solid fa-print"></i> Print', className: 'toolbar-btn', exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6] } }
                        ],
                        pageLength: 10,
                        lengthMenu: [10, 25, 50, 100],
                        language: {
                            emptyTable: '<div class="text-center py-8 text-gray-500"><i class="fa-solid fa-gas-pump text-2xl block mb-2"></i>No nozzles found</div>',
                            info: 'Showing _START_ to _END_ of _TOTAL_ entries',
                            infoEmpty: 'Showing 0 to 0 of 0 entries',
                            infoFiltered: '(filtered from _MAX_ total entries)'
                        },
                        initComplete: function () {
                            const $btns = $(this.api().table().container()).find('> .dt-buttons');
                            $btns.addClass('toolbar-btn-group');
                            $('#nozzleButtons').empty().append($btns);
                            $btns.css('display', 'flex');
                        }
                    });

                    $('#nozzleSearch').off('keyup').on('keyup', function () {
                        dataTables.nozzle.search(this.value).draw();
                    });
                },
                error: function () {
                    showToast('Failed to load nozzles.', 'error');
                }
            });
        }

        // ============================================
        // Load Users
        // ============================================
        function loadUsers() {
            $('#userTableBody').html(`
                <tr><td colspan="7" class="text-center py-8 text-gray-500">
                    <i class="fa-solid fa-spinner fa-spin text-blue-400 mr-2"></i> Loading...
                </td></tr>
            `);

            $.ajax({
                url: API_BASE_URL + 'get/dealer_users.php?key=03201232927&dealer_id=' + dealerId,
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (dataTables.user) {
                        dataTables.user.destroy();
                    }

                    const tableData = response.map((item, index) => [
                        index + 1,
                        item.name || 'N/A',
                        item.email || 'N/A',
                        item.contact || 'N/A',
                        item.role || 'N/A',
                        `<span class="badge ${item.active == 1 ? 'badge-success' : 'badge-danger'}">${item.active == 1 ? 'Active' : 'Inactive'}</span>`,
                        `<span class="action-icon edit" onclick="editRecord('user', ${item.id})">
                            <i class="fa-regular fa-pen-to-square"></i>
                        </span>
                        <span class="action-icon delete" onclick="deleteRecord('user', ${item.id})">
                            <i class="fa-regular fa-trash-can"></i>
                        </span>`
                    ]);

                    if (tableData.length === 0) {
                        tableData.push(['No data available', '', '', '', '', '', '']);
                    }

                    dataTables.user = $('#userTable').DataTable({
                        data: tableData,
                        columns: [
                            { title: 'S.No' },
                            { title: 'Name' },
                            { title: 'Email' },
                            { title: 'Phone' },
                            { title: 'Role' },
                            { title: 'Status' },
                            { title: 'Action', orderable: false, searchable: false }
                        ],
                        dom: 'Bfrtip',
                        buttons: [
                            { extend: 'copy', text: '<i class="fa-regular fa-copy"></i> Copy', className: 'toolbar-btn', exportOptions: { columns: [0, 1, 2, 3, 4, 5] } },
                            { extend: 'excelHtml5', text: '<i class="fa-regular fa-file-excel"></i> Excel', className: 'toolbar-btn', exportOptions: { columns: [0, 1, 2, 3, 4, 5] }, title: 'Users' },
                            { extend: 'csvHtml5', text: '<i class="fa-regular fa-file-csv"></i> CSV', className: 'toolbar-btn', exportOptions: { columns: [0, 1, 2, 3, 4, 5] }, title: 'Users' },
                            { extend: 'pdfHtml5', text: '<i class="fa-regular fa-file-pdf"></i> PDF', className: 'toolbar-btn', exportOptions: { columns: [0, 1, 2, 3, 4, 5] }, title: 'Users Report' },
                            { extend: 'print', text: '<i class="fa-solid fa-print"></i> Print', className: 'toolbar-btn', exportOptions: { columns: [0, 1, 2, 3, 4, 5] } }
                        ],
                        pageLength: 10,
                        lengthMenu: [10, 25, 50, 100],
                        language: {
                            emptyTable: '<div class="text-center py-8 text-gray-500"><i class="fa-solid fa-users text-2xl block mb-2"></i>No users found</div>',
                            info: 'Showing _START_ to _END_ of _TOTAL_ entries',
                            infoEmpty: 'Showing 0 to 0 of 0 entries',
                            infoFiltered: '(filtered from _MAX_ total entries)'
                        },
                        initComplete: function () {
                            const $btns = $(this.api().table().container()).find('> .dt-buttons');
                            $btns.addClass('toolbar-btn-group');
                            $('#userButtons').empty().append($btns);
                            $btns.css('display', 'flex');
                        }
                    });

                    $('#userSearch').off('keyup').on('keyup', function () {
                        dataTables.user.search(this.value).draw();
                    });
                },
                error: function () {
                    showToast('Failed to load users.', 'error');
                }
            });
        }

        // ============================================
        // Load Last Recon
        // ============================================
        function loadLastRecon() {
            $('#reconTableBody').html(`
                <tr><td colspan="8" class="text-center py-8 text-gray-500">
                    <i class="fa-solid fa-spinner fa-spin text-blue-400 mr-2"></i> Loading...
                </td></tr>
            `);

            $.ajax({
                url: API_BASE_URL + 'get/get_dealer_last_recons.php?key=03201232927&dealer_id=' + dealerId,
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (dataTables.recon) {
                        dataTables.recon.destroy();
                    }

                    const tableData = response.map((item, index) => [
                        index + 1,
                        item.created_at || 'N/A',
                        item.dealer_name || 'N/A',
                        item.product_name || 'N/A',
                        item.total_days || 'N/A',
                        item.last_recon_date || 'N/A',
                        item.created_at || 'N/A',
                        `<span class="action-icon edit" onclick="editRecord('recon', ${item.id})">
                            <i class="fa-regular fa-pen-to-square"></i>
                        </span>`
                    ]);

                    if (tableData.length === 0) {
                        tableData.push(['No data available', '', '', '', '', '', '', '']);
                    }

                    dataTables.recon = $('#reconTable').DataTable({
                        data: tableData,
                        columns: [
                            { title: 'S.No' },
                            { title: 'Planned Date' },
                            { title: 'Site Name' },
                            { title: 'Product' },
                            { title: 'Total Days' },
                            { title: 'From' },
                            { title: 'To' },
                            { title: 'Action', orderable: false, searchable: false }
                        ],
                        dom: 'Bfrtip',
                        buttons: [
                            { extend: 'copy', text: '<i class="fa-regular fa-copy"></i> Copy', className: 'toolbar-btn', exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6] } },
                            { extend: 'excelHtml5', text: '<i class="fa-regular fa-file-excel"></i> Excel', className: 'toolbar-btn', exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6] }, title: 'Last_Recon' },
                            { extend: 'csvHtml5', text: '<i class="fa-regular fa-file-csv"></i> CSV', className: 'toolbar-btn', exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6] }, title: 'Last_Recon' },
                            { extend: 'pdfHtml5', text: '<i class="fa-regular fa-file-pdf"></i> PDF', className: 'toolbar-btn', exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6] }, title: 'Last Recon Report' },
                            { extend: 'print', text: '<i class="fa-solid fa-print"></i> Print', className: 'toolbar-btn', exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6] } }
                        ],
                        pageLength: 10,
                        lengthMenu: [10, 25, 50, 100],
                        language: {
                            emptyTable: '<div class="text-center py-8 text-gray-500"><i class="fa-solid fa-clock-rotate-left text-2xl block mb-2"></i>No recon records found</div>',
                            info: 'Showing _START_ to _END_ of _TOTAL_ entries',
                            infoEmpty: 'Showing 0 to 0 of 0 entries',
                            infoFiltered: '(filtered from _MAX_ total entries)'
                        },
                        initComplete: function () {
                            const $btns = $(this.api().table().container()).find('> .dt-buttons');
                            $btns.addClass('toolbar-btn-group');
                            $('#reconButtons').empty().append($btns);
                            $btns.css('display', 'flex');
                        }
                    });

                    $('#reconSearch').off('keyup').on('keyup', function () {
                        dataTables.recon.search(this.value).draw();
                    });
                },
                error: function () {
                    showToast('Failed to load last recon records.', 'error');
                }
            });
        }

        // ============================================
        // Edit Record
        // ============================================
        function editRecord(type, id) {
            openModal(type, id);
            // Load data based on type - would require additional API calls
            showToast('Edit functionality for ' + type + ' - ID: ' + id, 'info');
        }

        // ============================================
        // Delete Record
        // ============================================
        function deleteRecord(type, id) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'This action cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Yes, delete it!',
                background: document.documentElement.classList.contains('dark-mode') ? '#0d1520' : '#ffffff',
                color: document.documentElement.classList.contains('dark-mode') ? '#e5e7eb' : '#334155'
            }).then((result) => {
                if (result.isConfirmed) {
                    let url = '';
                    switch (type) {
                        case 'facility':
                            url = API_BASE_URL + 'delete/delete_facility.php?key=03201232927&id=' + id;
                            break;
                        case 'product':
                            url = API_BASE_URL + 'delete/delete_dealer_product.php?key=03201232927&id=' + id;
                            break;
                        case 'tank':
                            url = API_BASE_URL + 'delete/delete_tank.php?key=03201232927&id=' + id;
                            break;
                        case 'dispenser':
                            url = API_BASE_URL + 'delete/delete_despensor.php?key=03201232927&id=' + id;
                            break;
                        case 'nozzle':
                            url = API_BASE_URL + 'delete/delete_nozzels.php?key=03201232927&id=' + id;
                            break;
                        case 'user':
                            url = API_BASE_URL + 'delete/delete_user.php?key=03201232927&id=' + id;
                            break;
                        default:
                            showToast('Invalid type.', 'error');
                            return;
                    }

                    $.ajax({
                        url: url,
                        type: 'GET',
                        dataType: 'json',
                        success: function (response) {
                            if (response === 1) {
                                showToast('Record deleted successfully!', 'success');
                                loadTabData(type);
                            } else {
                                showToast('Failed to delete record.', 'error');
                            }
                        },
                        error: function () {
                            showToast('Error deleting record.', 'error');
                        }
                    });
                }
            });
        }

        // ============================================
        // Save Record
        // ============================================
        function saveRecord(event) {
            event.preventDefault();
            const type = $('#recordType').val();
            const id = $('#recordId').val();

            let formData = new FormData();
            formData.append('user_id', USER_ID);
            formData.append('dealer_id', dealerId);
            if (id) formData.append('row_id', id);

            switch (type) {
                case 'facility':
                    formData.append('name', $('#facilityName').val());
                    break;
                case 'product':
                    formData.append('products_name', $('#productName').val());
                    formData.append('product_id', $('#productId').val());
                    formData.append('from_date', $('#productFrom').val());
                    formData.append('to_date', $('#productTo').val());
                    formData.append('indent_price', $('#productIndent').val());
                    formData.append('nozel_price', $('#productNozzle').val());
                    formData.append('products_description', $('#productDesc').val());
                    break;
                case 'tank':
                    formData.append('lorry_no', $('#tankNo').val());
                    formData.append('products', $('#tankProduct').val());
                    formData.append('max_limit', $('#tankCapacity').val());
                    formData.append('min_limit', '0');
                    break;
                case 'dispenser':
                    formData.append('dispenser_name', $('#dispenserName').val());
                    formData.append('dispenser_description', $('#dispenserDesc').val());
                    break;
                case 'nozzle':
                    formData.append('name', $('#nozzleName').val());
                    formData.append('nozzels_products', $('#nozzleProduct').val());
                    formData.append('product_tank', $('#nozzleTank').val());
                    formData.append('product_dispenser', $('#nozzleDispenser').val());
                    formData.append('last_reading', $('#nozzleReading').val());
                    break;
                case 'user':
                    formData.append('usernames', $('#userName').val());
                    formData.append('user_email', $('#userEmail').val());
                    formData.append('user_password', $('#userPassword').val());
                    formData.append('user_phone', $('#userPhone').val());
                    formData.append('user_role', $('#userRole').val());
                    formData.append('user_status', $('#userStatus').val());
                    break;
                default:
                    showToast('Invalid type.', 'error');
                    return;
            }

            let url = '';
            switch (type) {
                case 'facility':
                    url = id ? API_BASE_URL + 'update/update_facility.php' : API_BASE_URL + 'create/dealer_facitlities.php';
                    break;
                case 'product':
                    url = id ? API_BASE_URL + 'update/update_dealers_products.php' : API_BASE_URL + 'create/create_dealers_products.php';
                    break;
                case 'tank':
                    url = id ? API_BASE_URL + 'update/update_dealers_tanks.php' : API_BASE_URL + 'create/create_dealers_tanks.php';
                    break;
                case 'dispenser':
                    url = id ? API_BASE_URL + 'update/update_dispenser.php' : API_BASE_URL + 'create/create_dispenser.php';
                    break;
                case 'nozzle':
                    url = id ? API_BASE_URL + 'update/update_nozzels.php' : API_BASE_URL + 'create/nozzels.php';
                    break;
                case 'user':
                    url = id ? API_BASE_URL + 'update/update_user.php' : API_BASE_URL + 'create/users.php';
                    break;
                default:
                    showToast('Invalid type.', 'error');
                    return;
            }

            const submitBtn = $('#setupForm button[type="submit"]');
            submitBtn.prop('disabled', true);
            submitBtn.html('<i class="fa-solid fa-spinner fa-spin mr-1"></i> Saving...');

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function (response) {
                    submitBtn.prop('disabled', false);
                    submitBtn.html('Save');

                    if (response === 1) {
                        showToast(id ? 'Record updated successfully!' : 'Record created successfully!', 'success');
                        closeModal();
                        loadTabData(type);
                    } else {
                        showToast('Failed to save record. Please try again.', 'error');
                    }
                },
                error: function (xhr, status, error) {
                    submitBtn.prop('disabled', false);
                    submitBtn.html('Save');
                    console.error('Save Error:', status, error);
                    showToast('Error saving record: ' + status, 'error');
                }
            });
        }

        // ============================================
        // Toast Notification
        // ============================================
        function showToast(message, type = 'success') {
            const toast = $('#toast');
            const toastMessage = $('#toastMessage');
            toastMessage.text(message);

            toast.removeClass('border-green-500 border-red-500 border-yellow-500');
            if (type === 'success') {
                toast.addClass('border-green-500');
                toast.find('i').removeClass('text-red-500 text-yellow-500').addClass('text-green-500');
            } else if (type === 'error') {
                toast.addClass('border-red-500');
                toast.find('i').removeClass('text-green-500 text-yellow-500').addClass('text-red-500');
            } else {
                toast.addClass('border-yellow-500');
                toast.find('i').removeClass('text-green-500 text-red-500').addClass('text-yellow-500');
            }

            toast.removeClass('translate-y-24 opacity-0').addClass('translate-y-0 opacity-100');

            clearTimeout(window.toastTimeout);
            window.toastTimeout = setTimeout(() => {
                toast.removeClass('translate-y-0 opacity-100').addClass('translate-y-24 opacity-0');
            }, 3000);
        }
    </script>

</body>

</html>