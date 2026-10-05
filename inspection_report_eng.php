<?php
// Hascol OMC - Inspection Report (Eng) - Standalone
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Inspection Report (Eng) | Hascol OMC</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.70/jquery.blockUI.min.js"></script>

    <script>
        (function() {
            const isDarkMode = localStorage.getItem('darkMode') === 'true';
            document.documentElement.classList.toggle('dark-mode', isDarkMode);
        })();
    </script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        dash: {
                            bg: '#060b13',
                            panel: '#0d1520',
                            border: '#1a2635',
                            textMuted: '#64748b',
                            accentBlue: '#1d4ed8'
                        }
                    }
                }
            }
        }
    </script>

    <style>
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
            --modal-overlay: rgba(15, 23, 42, 0.45);
            --btn-secondary-bg: #e2e8f0;
            --btn-secondary-text: #334155;
            --btn-secondary-hover-bg: #cbd5e1;
            --btn-secondary-hover-text: #0f2440;
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
            --modal-overlay: rgba(6, 11, 19, 0.85);
            --btn-secondary-bg: #1a2635;
            --btn-secondary-text: #94a3b8;
            --btn-secondary-hover-bg: #1f2a3d;
            --btn-secondary-hover-text: #ffffff;
        }

        body {
            background-color: var(--bg-body);
            color: var(--text-muted);
            font-family: 'Inter', sans-serif;
            transition: background-color .25s ease, color .25s ease;
            min-height: 100vh;
        }

        .text-heading { color: var(--text-heading) !important; }

        .panel-card {
            background-color: var(--bg-panel);
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            transition: background-color .25s ease, border-color .25s ease;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        #sidebar.collapsed { width: 60px; }
        #sidebar.collapsed .sidebar-text { display: none; }
        #sidebar.collapsed nav a { justify-content: center; padding: 8px 4px; }
        #sidebar.collapsed .p-3 img { width: 32px; height: 32px; }
        #sidebar, #mainContent { transition: all 0.3s ease-in-out; }

        .form-input {
            background-color: var(--input-bg);
            border: 1px solid var(--border-color);
            border-radius: 0.25rem;
            color: var(--text-body);
            padding: 8px 12px;
            width: 100%;
            font-size: 13px;
            transition: border-color 0.2s;
            box-sizing: border-box;
        }
        .form-input:focus {
            outline: none;
            border-color: #1d4ed8;
            box-shadow: 0 0 0 2px rgba(29, 78, 216, 0.2);
        }
        .form-label {
            color: var(--text-muted);
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 6px;
            display: block;
        }

        input[type="date"].form-input {
            cursor: pointer;
            color-scheme: light;
            position: relative;
        }
        html.dark-mode input[type="date"].form-input {
            color-scheme: dark;
        }
        input[type="date"].form-input::-webkit-calendar-picker-indicator {
            cursor: pointer;
            opacity: 0.65;
            filter: invert(0.35);
            border-radius: 3px;
            padding: 2px;
            transition: opacity 0.2s, background-color 0.2s;
        }
        input[type="date"].form-input::-webkit-calendar-picker-indicator:hover {
            opacity: 1;
            background-color: var(--hover-bg);
        }
        html.dark-mode input[type="date"].form-input::-webkit-calendar-picker-indicator {
            filter: invert(0.85);
        }

        .btn-primary {
            background-color: #1d4ed8;
            color: #ffffff;
            padding: 8px 20px;
            border-radius: 0.375rem;
            border: none;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .btn-primary:hover { background-color: #2563eb; transform: translateY(-1px); }

        .btn-secondary {
            background-color: var(--btn-secondary-bg);
            color: var(--btn-secondary-text);
            padding: 8px 20px;
            border-radius: 0.375rem;
            border: 1px solid var(--border-color);
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .btn-secondary:hover {
            background-color: var(--btn-secondary-hover-bg);
            color: var(--btn-secondary-hover-text);
        }

        .btn-info {
            background: linear-gradient(135deg, #0ea5e9, #0284c7);
            color: #ffffff;
            padding: 8px 16px;
            border-radius: 0.375rem;
            border: none;
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .btn-info:hover { transform: translateY(-1px); box-shadow: 0 4px 16px rgba(14, 165, 233, 0.35); }

        .kpi-card {
            background-color: var(--bg-panel);
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            padding: 20px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .kpi-card:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08); }
        .kpi-icon {
            width: 48px; height: 48px;
            border-radius: 0.5rem;
            display: flex; align-items: center; justify-content: center;
            font-size: 22px; flex-shrink: 0;
        }
        .kpi-icon.blue { background: rgba(59, 130, 246, 0.12); color: #3b82f6; }
        .kpi-icon.yellow { background: rgba(245, 158, 11, 0.12); color: #f59e0b; }
        .kpi-icon.green { background: rgba(16, 185, 129, 0.12); color: #10b981; }

        .kpi-label {
            font-size: 11px; color: var(--text-muted);
            text-transform: uppercase; letter-spacing: 0.5px;
            font-weight: 600; margin-bottom: 2px;
        }
        .kpi-value { font-size: 24px; font-weight: 700; color: var(--text-heading); }

        .table-container { position: relative; overflow-x: auto; min-height: 200px; }
        .table-container table { width: 100% !important; border-collapse: collapse; font-size: 12px; }
        .table-container table thead th {
            background-color: var(--table-head-bg) !important;
            color: var(--table-head-text) !important;
            font-weight: 600; text-align: left; padding: 12px 14px;
            border-bottom: 2px solid var(--border-color);
            white-space: nowrap; font-size: 11px;
            text-transform: uppercase; letter-spacing: 0.5px;
        }
        .table-container table tbody td {
            padding: 10px 14px;
            border-bottom: 1px solid var(--border-color);
            color: var(--table-row-text);
            vertical-align: middle; font-size: 12px;
        }
        .table-container table tbody tr:hover { background-color: var(--table-row-hover); }

        .dataTables_wrapper .dataTables_info { color: var(--text-muted) !important; font-size: 12px !important; padding-top: 12px !important; }
        .dataTables_wrapper .dataTables_paginate { padding-top: 12px !important; }
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 4px 12px !important; margin: 0 2px !important;
            border-radius: 4px !important; background: var(--bg-panel) !important;
            border: 1px solid var(--border-color) !important;
            color: var(--text-muted) !important; font-size: 12px !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: var(--hover-bg) !important; color: var(--text-heading) !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #1d4ed8 !important; color: #ffffff !important; border-color: #1d4ed8 !important;
        }

        .dt-buttons { display: flex !important; gap: 6px !important; flex-wrap: wrap !important; }
        .dt-buttons .dt-button {
            padding: 6px 14px !important;
            background-color: var(--bg-panel) !important;
            border: 1px solid var(--border-color) !important;
            border-radius: 0.25rem !important;
            color: var(--text-muted) !important;
            font-size: 11px !important; cursor: pointer !important;
            transition: all 0.2s !important;
            display: inline-flex !important; align-items: center !important; gap: 6px !important;
            font-family: 'Inter', sans-serif !important;
            height: 32px !important; box-sizing: border-box !important;
        }
        .dt-buttons .dt-button:hover {
            background-color: var(--hover-bg) !important; color: var(--text-heading) !important;
        }

        .dataTables_wrapper .dataTables_filter {
            color: var(--text-muted) !important;
            font-size: 12px !important;
            padding-bottom: 8px;
            text-align: right;
            float: right;
            margin-bottom: 10px;
        }

        .dataTables_wrapper .dataTables_filter label {
            color: var(--text-muted) !important;
            font-size: 12px !important;
            font-weight: 500 !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 6px !important;
        }

        .dataTables_wrapper .dataTables_filter input {
            background-color: var(--input-bg) !important;
            border: 1px solid var(--border-color) !important;
            border-radius: 0.25rem !important;
            color: var(--text-body) !important;
            padding: 6px 12px !important;
            font-size: 12px !important;
            outline: none !important;
            transition: border-color 0.2s, box-shadow 0.2s !important;
            min-width: 200px !important;
            margin-left: 4px !important;
        }

        .dataTables_wrapper .dataTables_filter input:focus {
            border-color: #1d4ed8 !important;
            box-shadow: 0 0 0 2px rgba(29, 78, 216, 0.2) !important;
            outline: none !important;
        }

        .dataTables_wrapper .dataTables_filter input::placeholder {
            color: var(--text-muted) !important;
        }

        .dataTables_wrapper .dt-buttons {
            float: left;
            margin-bottom: 10px;
        }

        .dataTables_wrapper::after {
            content: "";
            display: table;
            clear: both;
        }

        .toolbar-row {
            display: flex; align-items: center; justify-content: space-between;
            gap: 12px; flex-wrap: wrap; width: 100%;
        }
        .toolbar-left { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; min-width: 0; }
        .toolbar-right { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; flex-shrink: 0; }

        .filter-row {
            display: flex; align-items: flex-end; gap: 12px;
            flex-wrap: wrap; padding: 6px 0;
        }
        .filter-row .filter-group {
            display: flex; flex-direction: column; gap: 4px; min-width: 160px;
        }
        .filter-row .filter-group label {
            font-size: 11px; font-weight: 600; color: var(--text-muted);
        }

        .modal {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: var(--modal-overlay); z-index: 99999;
            display: none; align-items: flex-start; justify-content: center;
            padding: 20px; overflow-y: auto;
        }
        .modal.show { display: flex; }
        .modal-dialog {
            background-color: var(--bg-panel);
            border-radius: 0.5rem; width: 100%; max-width: 1100px;
            max-height: calc(100vh - 40px);
            display: flex; flex-direction: column;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            margin: auto;
        }
        .modal-dialog.modal-xl { max-width: 1300px; }
        .modal-header {
            display: flex; align-items: center; justify-content: space-between;
            padding: 16px 20px; border-bottom: 1px solid var(--border-color); flex-shrink: 0;
        }
        .modal-title { margin: 0; font-size: 16px; font-weight: 600; color: var(--text-heading); }
        .modal-body { flex: 1 1 auto; overflow-y: auto; padding: 20px; }
        .btn-close-modal {
            width: 28px; height: 28px; border: none; background: transparent;
            color: var(--text-muted); cursor: pointer;
            display: inline-flex; align-items: center; justify-content: center;
            border-radius: 4px; padding: 0; font-size: 20px;
            transition: background-color 0.2s, color 0.2s;
        }
        .btn-close-modal::before { content: "\00d7"; font-size: 22px; line-height: 1; }
        .btn-close-modal:hover { background-color: var(--hover-bg); color: var(--text-heading); }

        /* ============================================ */
        /* DYNAMIC TABLES (Inside Modals) */
        /* ============================================ */
        .dynamic_table {
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 20px; 
            font-size: 12px;
            table-layout: fixed;
        }

        .dynamic_table th, 
        .dynamic_table td {
            border: 1px solid var(--border-color);
            padding: 10px 12px;
            color: var(--text-body);
            vertical-align: top;
            word-wrap: break-word;
            overflow-wrap: break-word;
            word-break: break-word;
            white-space: normal;
            line-height: 1.7;
        }

        .dynamic_table th {
            background-color: var(--table-head-bg);
            color: var(--text-heading);
            font-weight: 600; 
            font-size: 11px; 
            text-transform: uppercase;
            text-align: left;
            vertical-align: middle;
        }

        .dynamic_table td {
            text-align: left;
        }

        .dynamic_table td:nth-child(2) {
            text-align: justify;
            text-justify: inter-word;
            hyphens: auto;
            -webkit-hyphens: auto;
            -ms-hyphens: auto;
            letter-spacing: 0.1px;
        }

        .dynamic_table td:nth-child(3),
        .dynamic_table td:nth-child(4),
        .dynamic_table td:nth-child(5) {
            text-align: center;
            vertical-align: middle;
        }

        .dynamic_table th:nth-child(3),
        .dynamic_table th:nth-child(4),
        .dynamic_table th:nth-child(5) {
            text-align: center;
        }

        .dynamic_table td:nth-child(6) {
            text-align: left;
        }

        .dynamic_table td:nth-child(7),
        .dynamic_table th:nth-child(7) {
            text-align: center;
            vertical-align: middle;
        }

        .dynamic_table th:nth-child(1),
        .dynamic_table td:nth-child(1) {
            width: 50px;
            text-align: center;
            vertical-align: middle;
        }

        .dynamic_table th:nth-child(7),
        .dynamic_table td:nth-child(7) {
            width: 70px;
        }

        .dynamic_table th:nth-child(3),
        .dynamic_table td:nth-child(3),
        .dynamic_table th:nth-child(4),
        .dynamic_table td:nth-child(4),
        .dynamic_table th:nth-child(5),
        .dynamic_table td:nth-child(5) {
            width: 60px;
        }

        .dynamic_table th:nth-child(6),
        .dynamic_table td:nth-child(6) {
            width: 150px;
        }

        .dynamic_table.summary_table {
            table-layout: auto;
        }

        .dynamic_table.summary_table th,
        .dynamic_table.summary_table td {
            width: auto !important;
            white-space: nowrap;
            text-align: center;
            vertical-align: middle;
            text-align-last: auto;
        }

        .dynamic_table.summary_table th:first-child,
        .dynamic_table.summary_table td:first-child {
            text-align: left;
            white-space: normal;
            min-width: 120px;
        }

        .dynamic_table.summary_table td:nth-child(2) {
            text-align: center;
        }

        /* ============================================ */
        /* SECTION IMAGE GALLERY */
        /* ============================================ */
        .section-images-gallery {
            margin-top: -20px;
            margin-bottom: 25px;
            padding: 14px 16px;
            background: var(--hover-bg);
            border: 1px solid var(--border-color);
            border-top: none;
            border-radius: 0 0 6px 6px;
        }

        .section-images-gallery .gallery-title {
            font-size: 11px;
            font-weight: 700;
            color: var(--text-heading);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .section-images-gallery .gallery-title i {
            color: #1d4ed8;
            font-size: 13px;
        }

        .section-images-gallery .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(170px, 1fr));
            gap: 14px;
        }

        .section-images-gallery .gallery-item {
            background: var(--bg-panel);
            border: 1px solid var(--border-color);
            border-radius: 6px;
            overflow: hidden;
            cursor: default;
            display: flex;
            flex-direction: column;
        }

        .section-images-gallery .gallery-item .gallery-img-wrapper {
            width: 100%;
            height: 140px;
            background: var(--bg-body);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            flex-shrink: 0;
        }

        .section-images-gallery .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .section-images-gallery .gallery-item .gallery-caption {
            padding: 8px 10px;
            font-size: 10px;
            color: var(--text-muted);
            line-height: 1.4;
            border-top: 1px solid var(--border-color);
            background: var(--bg-panel);
            flex: 1;
        }

        .section-images-gallery .gallery-item .gallery-caption .q-label {
            font-weight: 600;
            color: var(--text-heading);
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            font-size: 10px;
        }

        .modal-img { max-width: 150px; max-height: 130px; border-radius: 0.25rem; border: 1px solid var(--border-color); }

        @media (max-width: 1024px) {
            .toolbar-row { flex-direction: column; align-items: stretch; }
            .toolbar-left, .toolbar-right { width: 100%; }
            .filter-row { flex-direction: column; align-items: stretch; }
            .filter-row .filter-group { width: 100%; }
        }
        @media (max-width: 640px) {
            .dt-buttons .dt-button { font-size: 10px !important; padding: 4px 10px !important; height: 28px !important; }
            .modal-dialog { max-width: 100%; }
            .kpi-card { padding: 14px; }
            .kpi-icon { width: 40px; height: 40px; font-size: 18px; }
            .kpi-value { font-size: 20px; }
            .dataTables_wrapper .dataTables_filter input { min-width: 140px !important; }
            .section-images-gallery .gallery-grid { grid-template-columns: repeat(auto-fill, minmax(130px, 1fr)); gap: 10px; }
            .section-images-gallery .gallery-item .gallery-img-wrapper { height: 110px; }
        }

        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: var(--scrollbar-track); }
        ::-webkit-scrollbar-thumb { background: var(--scrollbar-thumb); border-radius: 4px; }
    </style>
</head>

<body class="flex h-screen overflow-hidden text-sm">

    <?php include 'includes/sidebar.php'; ?>

    <main id="mainContent" class="flex-1 flex flex-col overflow-hidden">

        <?php include 'includes/topbar.php'; ?>

        <div class="flex-1 overflow-y-auto p-4 md:p-6" id="pageContent">

            <div class="flex flex-wrap justify-between items-center mb-4 gap-3">
                <div>
                    <h2 class="text-heading font-semibold text-lg tracking-wide uppercase">
                        <i class="fa-solid fa-clipboard-check mr-2 text-blue-500"></i>Inspection Report (Eng)
                        <span id="filteredUserName" class="text-blue-500 text-sm normal-case ml-2"></span>
                    </h2>
                    <p class="text-xs text-gray-500 mt-0.5">View complete inspection reports</p>
                </div>
            </div>

            <div class="panel-card p-3 mb-3">
                <div class="filter-row">
                    <div class="filter-group">
                        <label><i class="fa-regular fa-calendar mr-1"></i> From</label>
                        <input type="date" id="fromdate" value="2026-09-01" class="form-input">
                    </div>
                    <div class="filter-group">
                        <label><i class="fa-regular fa-calendar-check mr-1"></i> To</label>
                        <input type="date" id="todate" value="2026-10-01" class="form-input">
                    </div>
                    <button onclick="fetchtable()" class="btn-primary" style="height:36px;">
                        <i class="fa-solid fa-magnifying-glass"></i> Get
                    </button>
                </div>
            </div>

            <!-- KPI Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <div class="kpi-card">
                    <div class="kpi-icon blue"><i class="fa-solid fa-clipboard-list"></i></div>
                    <div>
                        <div class="kpi-label">Total Visits</div>
                        <div class="kpi-value" id="total_visits">0</div>
                    </div>
                </div>
                <div class="kpi-card">
                    <div class="kpi-icon yellow"><i class="fa-solid fa-hourglass-half"></i></div>
                    <div>
                        <div class="kpi-label">Pending Visits</div>
                        <div class="kpi-value" id="total_p_visits">0</div>
                    </div>
                </div>
                <div class="kpi-card">
                    <div class="kpi-icon green"><i class="fa-solid fa-circle-check"></i></div>
                    <div>
                        <div class="kpi-label">Complete Visits</div>
                        <div class="kpi-value" id="total_c_visits">0</div>
                    </div>
                </div>
            </div>

            <div class="panel-card overflow-hidden">
                <div class="p-3 border-b" style="border-color: var(--border-color);">
                    <h5 class="text-heading font-semibold text-sm">
                        <i class="fa-solid fa-table mr-2 text-blue-500"></i>Inspection Data
                    </h5>
                </div>
                <div class="p-3">
                    <div class="table-container">
                        <table id="myTable" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Date</th>
                                    <th>Complete Time</th>
                                    <th>Dealer Sign</th>
                                    <th>User</th>
                                    <th>Dealer</th>
                                    <th>Mode</th>
                                    <th>Status</th>
                                    <th>Inspection</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <!-- ===================== SURVEY MODAL ===================== -->
    <div id="survey_modal" class="modal">
        <div class="modal-dialog modal-xl">
            <div class="modal-header">
                <h5 class="modal-title" id="labelc">Survey Response</h5>
                <button type="button" class="btn-close-modal" onclick="closeModal('survey_modal')"></button>
            </div>
            <div class="modal-body">
                <div class="flex justify-end mb-3">
                    <button class="btn-info" id="exportBtn">
                        <i class="fa-solid fa-file-pdf"></i> Export to PDF
                    </button>
                </div>
                <div id="exporting">
                    <div class="mb-3">
                        <img src="http://151.106.17.246:8080/hascolBridge_files/uploads/system_logo.png" alt="Logo" style="width: 100px;">
                    </div>
                    <div class="text-xs mb-1">Planned Date: <span id="survey_time" class="text-heading font-medium"></span></div>
                    <div id="last_recon" class="text-xs mb-1"></div>
                    <div class="text-xs mb-1">Site Name: <span id="survey_dealer_name" class="text-heading font-medium"></span></div>
                    <div class="text-xs mb-1">TM Name: <span id="survey_ispector_name" class="text-heading font-medium"></span></div>
                    <div class="text-xs mb-1 hidden">Planned Type: <span id="survey_type"></span></div>
                    <div class="mt-3" id="survey-container"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- ===================== SALES PERFORMANCE MODAL ===================== -->
    <div id="sales_performance" class="modal">
        <div class="modal-dialog modal-xl">
            <div class="modal-header">
                <h5 class="modal-title">Sales Performance</h5>
                <button type="button" class="btn-close-modal" onclick="closeModal('sales_performance')"></button>
            </div>
            <div class="modal-body">
                <div class="table-container">
                    <table class="display" style="width:100%" id="sale_table">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Product</th>
                                <th>Monthly Target (L)</th>
                                <th>Target Achieved (L)</th>
                                <th>Difference (L)</th>
                                <th>Reason</th>
                                <th>Time</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- ===================== WET STOCK MODAL ===================== -->
    <div id="wet_stock_modal" class="modal">
        <div class="modal-dialog modal-xl">
            <div class="modal-header">
                <h5 class="modal-title">Wet Stock Management</h5>
                <button type="button" class="btn-close-modal" onclick="closeModal('wet_stock_modal')"></button>
            </div>
            <div class="modal-body">
                <div class="table-container">
                    <table class="display" style="width:100%" id="wet_stock">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Product</th>
                                <th>Tank #</th>
                                <th>Old Dip</th>
                                <th>New Dip</th>
                                <th>Time</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- ===================== DISPENSING UNIT MODAL ===================== -->
    <div id="despensing_unit_modal" class="modal">
        <div class="modal-dialog modal-xl">
            <div class="modal-header">
                <h5 class="modal-title">Dispensing Unit Meter Reading</h5>
                <button type="button" class="btn-close-modal" onclick="closeModal('despensing_unit_modal')"></button>
            </div>
            <div class="modal-body">
                <div class="table-container">
                    <table class="display" style="width:100%" id="despensing_unit_table">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Product</th>
                                <th>Nozzle #</th>
                                <th>Old Dip</th>
                                <th>New Dip</th>
                                <th>Time</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- ===================== STOCK VARIATIONS MODAL ===================== -->
    <div id="stock_variations_modal" class="modal">
        <div class="modal-dialog modal-xl">
            <div class="modal-header">
                <h5 class="modal-title">Stock Variations</h5>
                <button type="button" class="btn-close-modal" onclick="closeModal('stock_variations_modal')"></button>
            </div>
            <div class="modal-body">
                <div class="table-container">
                    <table class="display" style="width:100%" id="stock_variations_table">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Product</th>
                                <th>Opening Stock</th>
                                <th>Purchase During Inspection</th>
                                <th>Total Available for Sale</th>
                                <th>Sales as per Meter</th>
                                <th>Book Stock</th>
                                <th>Current Physical Stock</th>
                                <th>Gain/Loss</th>
                                <th>Time</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- ===================== MEASUREMENT & PRICE MODAL ===================== -->
    <div id="m_p_modal" class="modal">
        <div class="modal-dialog modal-xl">
            <div class="modal-header">
                <h5 class="modal-title">Measurement & Price</h5>
                <button type="button" class="btn-close-modal" onclick="closeModal('m_p_modal')"></button>
            </div>
            <div class="modal-body">
                <div class="flex justify-end mb-3">
                    <button class="btn-info" id="expoert_measure_price">
                        <i class="fa-solid fa-file-pdf"></i> Export to PDF
                    </button>
                </div>
                <div id="maesurement_price_div">
                    <div class="mb-4">
                        <table class="dynamic_table" id="main_data">
                            <thead>
                                <tr>
                                    <th>Appreciation of Dealer</th>
                                    <th>Measure Taken</th>
                                    <th>Warning</th>
                                    <th>PMG OGRA Price</th>
                                    <th>PMG Pump Price</th>
                                    <th>PMG Variance</th>
                                    <th>HSD OGRA Price</th>
                                    <th>HSD Pump Price</th>
                                    <th>HSD Variance</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <div>
                        <table class="dynamic_table" id="sub_data">
                            <thead>
                                <tr>
                                    <th>S#</th>
                                    <th>Dispenser</th>
                                    <th>PMG Accurate</th>
                                    <th>PMG Shortage (%)</th>
                                    <th>HSD Accurate</th>
                                    <th>HSD Shortage (%)</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

    <script>
        function toggleDarkMode() {
            const html = document.documentElement;  
            const isDark = html.classList.toggle('dark-mode');
            localStorage.setItem('darkMode', isDark);
            const icon = document.querySelector('.dark-mode-toggle i');
            if (icon) icon.className = isDark ? 'fa-solid fa-sun' : 'fa-solid fa-moon';
        }

        // ✅ API base
        const API_BASE = 'http://151.106.17.246:8080/hascolBridgeApis/';

        // ✅ Images ke liye base
        const IMAGE_BASE = 'http://151.106.17.246:8080/hascolBridge_files/uploads/';

        const API_KEY = '03201232927';

        let lubes_table = null;
        let sale_table = null;
        let wet_stock = null;
        let despensing_unit_table = null;
        let stock_variations_table = null;

        $(document).ready(function () {
            $('#sidebarToggle').on('click', function () {
                $('#sidebar').toggleClass('collapsed');
                localStorage.setItem('sidebarCollapsed', $('#sidebar').hasClass('collapsed'));
            });

            if (localStorage.getItem('sidebarCollapsed') === 'true') {
                $('#sidebar').addClass('collapsed');
            }

            const isDarkMode = localStorage.getItem('darkMode') === 'true';
            const icon = document.querySelector('.dark-mode-toggle i');
            if (icon) icon.className = isDarkMode ? 'fa-solid fa-sun' : 'fa-solid fa-moon';

            sale_table = $('#sale_table').DataTable({ dom: 'Bftip', buttons: ['copy', 'excel', 'csv', 'pdf', 'print'] });
            wet_stock = $('#wet_stock').DataTable({ dom: 'Bftip', buttons: ['copy', 'excel', 'csv', 'pdf', 'print'] });
            despensing_unit_table = $('#despensing_unit_table').DataTable({ dom: 'Bftip', buttons: ['copy', 'excel', 'csv', 'pdf', 'print'] });
            stock_variations_table = $('#stock_variations_table').DataTable({ dom: 'Bftip', buttons: ['copy', 'excel', 'csv', 'pdf', 'print'] });

            lubes_table = $('#myTable').DataTable({
                dom: 'Bfrtip',
                buttons: ['copy', 'excel', 'csv', 'pdf', 'print'],
                pageLength: 10,
                language: {
                    emptyTable: 'No inspection reports found',
                    info: 'Showing _START_ to _END_ of _TOTAL_ entries',
                    infoEmpty: 'Showing 0 to 0 of 0 entries',
                    infoFiltered: '(filtered from _MAX_ total entries)',
                    search: 'Search:',
                    searchPlaceholder: 'Search reports...'
                }
            });

            fetchtable();
        });

        function openModal(id) { $('#' + id).addClass('show'); }
        function closeModal(id) { $('#' + id).removeClass('show'); }

        $(document).on('click', '.modal', function (e) {
            if (e.target === this) $(this).removeClass('show');
        });

        function fetchtable() {
            blocking();

            var fromdate = $('#fromdate').val();
            var todate = $('#todate').val();

            var apiUrl = API_BASE + "get/eng/get_all_dealers_inspection_report_data.php";
            var queryParams = `?key=${API_KEY}&pre=Admin&id=1&from=${fromdate}&to=${todate}`;

            fetch(apiUrl + queryParams, { method: 'GET', redirect: 'follow' })
                .then(response => response.json())
                .then(response => {
                    if (response.length > 0) {
                        var t_visit = 0, p_visit = 0, c_visit = 0;
                        lubes_table.clear().draw();

                        $.each(response, function (index, data) {
                            var inspection_btn = `<button type="button" onclick="displaySurvey(${data.id}, ${data.id}, ${data.dealer_id}, '${(data.dealer_name || '').replace(/'/g, "\\'")}', '${data.time}', '${data.visit_close_time}', '${data.name}', '${data.type}', ${data.last_visit_id}, '${data.privilege}')" class="text-red-500 hover:text-red-700" title="View Inspection">
                                <i class="fas fa-align-justify font-size-16"></i>
                            </button>`;
                            var inspection = (data.inspection == 1) ? inspection_btn : '---';

                            var current_status = (data.privilege == 'RM' && data.inspection == 1) ? 'Complete' : data.current_status;

                            if (current_status === 'Pending') p_visit++;
                            else if (current_status === 'Complete') c_visit++;
                            t_visit++;

                            var dealer_sign = (data.dealer_sign != null)
                                ? `<a href="${IMAGE_BASE}${data.dealer_sign}" target="_blank"><i class="fas fa-file-image text-green-500" style="font-size:18px;"></i></a>`
                                : '---';

                            var statusBadge = current_status === 'Complete'
                                ? `<span class="inline-block px-3 py-1 rounded-full text-[10px] font-semibold" style="background:rgba(16,185,129,0.15);color:#10b981;">${current_status}</span>`
                                : `<span class="inline-block px-3 py-1 rounded-full text-[10px] font-semibold" style="background:rgba(245,158,11,0.15);color:#f59e0b;">${current_status}</span>`;

                            lubes_table.row.add([
                                index + 1,
                                data.time || 'N/A',
                                data.visit_close_time || 'N/A',
                                dealer_sign,
                                data.name || 'N/A',
                                data.dealer_name || 'N/A',
                                data.type || 'N/A',
                                statusBadge,
                                inspection
                            ]).draw(false);
                        });

                        $('#total_visits').text(t_visit);
                        $('#total_p_visits').text(p_visit);
                        $('#total_c_visits').text(c_visit);

                        const urlParams = new URLSearchParams(window.location.search);
                        const userNameFromUrl = urlParams.get('name');

                        if (userNameFromUrl) {
                            $('.dataTables_filter input').val(userNameFromUrl);
                            lubes_table.search(userNameFromUrl).draw();
                            $('#filteredUserName').text('— ' + userNameFromUrl);
                        }
                    }
                })
                .catch(error => console.error('Error:', error))
                .finally(() => $.unblockUI());
        }

        function displaySurvey(id, inspection_id, dealer_id, dealer_name, isp_date, comp_date, username, type, last_visit_id, privilege) {
            $('#labelc').text('Inspection');
            $('#survey_time').text(isp_date);
            $('#survey_dealer_name').text(dealer_name);
            $('#survey_ispector_name').text(username);
            $('#survey_type').text(type);

            $('#survey-container').empty();

            var url = API_BASE + "get/eng/get_dealer_survey_response.php?key=" + API_KEY +
                "&inspection_id=" + inspection_id +
                "&task_id=" + id +
                "&dealer_id=" + dealer_id;

            fetch(url, { method: 'GET', redirect: 'follow' })
                .then(response => response.json())
                .then(result => {
                    create_div(result, id);
                })
                .catch(error => console.log('error', error));
        }

        function create_div(response, inspection_id) {
            var total_ques = 0, r_yes = 0, r_no = 0, r_n_a = 0;

            var $sectionDiv = $('<div></div>');

            // Summary table
            var summaryTable = $('<table class="dynamic_table summary_table" style="margin-bottom:20px;">');
            var sumHead = $('<thead><tr><th>Total Questions</th><th>Yes</th><th>No</th><th>N/A</th><th>%</th></tr></thead>');
            var sumBody = $('<tbody></tbody>');

            response.forEach(function (section) {
                section.Questions.forEach(function (question) {
                    total_ques++;
                    if (question.response == 'Yes') r_yes++;
                    else if (question.response == 'No') r_no++;
                    else if (question.response == 'N/A') r_n_a++;
                });
            });

            var percentage = total_ques - r_n_a > 0 ? (r_yes / (total_ques - r_n_a)) * 100 : 0;
            var row1 = $('<tr>');
            row1.append($('<td>').text(total_ques));
            row1.append($('<td>').text(r_yes));
            row1.append($('<td>').text(r_no));
            row1.append($('<td>').text(r_n_a));
            row1.append($('<td>').text(Math.round(percentage) + '%'));
            sumBody.append(row1);
            summaryTable.append(sumHead).append(sumBody);
            $sectionDiv.append(summaryTable);

            response.forEach(function (section, idx) {
                var table = $('<table class="dynamic_table" style="margin-bottom:20px;">');
                var tableHead = $('<thead>');
                var tableBody = $('<tbody>');

                var headerRow = $('<tr>');
                headerRow.append($('<th>').text('SNo'));
                headerRow.append($('<th>').text(section.name || 'Section'));
                headerRow.append($('<th>').text('Yes'));
                headerRow.append($('<th>').text('No'));
                headerRow.append($('<th>').text('N/A'));
                headerRow.append($('<th>').text('Comments'));
                headerRow.append($('<th>').text('File'));
                tableHead.append(headerRow);
                table.append(tableHead);

                // Section ki saari images collect karne ke liye array
                var sectionImages = [];

                var j = 1;
                section.Questions.forEach(function (question) {
                    var row = $('<tr>');
                    row.append($('<td>').text(j));
                    row.append($('<td>').text(question.question || 'N/A'));
                    row.append($('<td>').html(question.response === 'Yes' ? '<i class="fas fa-check text-green-500" style="font-size:16px;"></i>' : ''));
                    row.append($('<td>').html(question.response === 'No' ? '<i class="fas fa-check text-green-500" style="font-size:16px;"></i>' : ''));
                    row.append($('<td>').html(question.response === 'N/A' ? '<i class="fas fa-check text-green-500" style="font-size:16px;"></i>' : ''));
                    row.append($('<td>').text(question.comment || '---'));

                    // File icon — IMAGE_BASE use karo
                    var imageCellHtml = '---';
                    if (question.cancel_file != null && question.cancel_file != '') {
                        var imgUrl = IMAGE_BASE + question.cancel_file;
                        imageCellHtml = '<a href="' + imgUrl + '" target="_blank" title="Open image in new tab">' +
                                        '<i class="fas fa-file-image text-green-500" style="font-size:18px;"></i></a>';

                        // Image ko section gallery ke liye collect karo
                        sectionImages.push({
                            url: imgUrl,
                            question: question.question || 'Image',
                            index: j
                        });
                    }
                    row.append($('<td>').html(imageCellHtml));

                    tableBody.append(row);
                    j++;
                });
                table.append(tableBody);
                $sectionDiv.append(table);

                // ✅ Section ke NEECHE images gallery
                if (sectionImages.length > 0) {
                    var galleryHtml = '<div class="section-images-gallery">';
                    galleryHtml += '<div class="gallery-title">';
                    galleryHtml += '<i class="fas fa-images"></i> ' + (section.name || 'Section') + ' — Attached Images (' + sectionImages.length + ')';
                    galleryHtml += '</div>';
                    galleryHtml += '<div class="gallery-grid">';

                    sectionImages.forEach(function (img) {
                        var safeQuestion = img.question.replace(/</g, '&lt;').replace(/>/g, '&gt;');
                        galleryHtml += '<div class="gallery-item">';
                        galleryHtml += '<div class="gallery-img-wrapper">';
                        galleryHtml += '<img src="' + img.url + '" alt="Inspection Image" ';
                        galleryHtml += 'onerror="this.onerror=null; this.style.display=\'none\'; this.parentElement.innerHTML=\'<i class=&quot;fas fa-image&quot; style=&quot;color:#94a3b8;font-size:32px;&quot;></i>\';">';
                        galleryHtml += '</div>';
                        galleryHtml += '<div class="gallery-caption">';
                        galleryHtml += '<span class="q-label">Q' + img.index + ': ' + safeQuestion + '</span>';
                        galleryHtml += '</div>';
                        galleryHtml += '</div>';
                    });

                    galleryHtml += '</div>';
                    galleryHtml += '</div>';

                    $sectionDiv.append(galleryHtml);
                }
            });

            $('#survey-container').append($sectionDiv);
            openModal('survey_modal');
        }

        // ============================================
        // Image Preview — SweetAlert Style Popup
        // ============================================
        function showImagePreview(imageUrl, questionText) {
            if (!imageUrl) return;

            Swal.fire({
                title: questionText ? questionText : 'Image Preview',
                imageUrl: imageUrl,
                imageAlt: 'Inspection Image',
                imageWidth: 'auto',
                imageHeight: 'auto',
                width: '800px',
                padding: '1rem',
                showCloseButton: true,
                showConfirmButton: false,
                showCancelButton: true,
                cancelButtonText: '<i class="fas fa-times"></i> Close',
                cancelButtonColor: '#ef4444',
                customClass: {
                    popup: 'swal2-image-popup',
                    title: 'swal2-image-title',
                    image: 'swal2-image-preview'
                },
                background: document.documentElement.classList.contains('dark-mode') ? '#0d1520' : '#ffffff',
                color: document.documentElement.classList.contains('dark-mode') ? '#e5e7eb' : '#334155',
                backdrop: 'rgba(15, 23, 42, 0.75)'
            });
        }

        function measure_price(id, inspection_id, dealer_id, dealer_name, isp_date, comp_date, username, type, last_visit_id) {
            $('#labelc').text('Measurement & Price');
            $('#survey_time').text(isp_date);
            $('#survey_complete_time').text(comp_date);
            $('#survey_dealer_name').text(dealer_name);
            $('#survey_ispector_name').text(username);
            $('#survey_type').text(type);

            var url = API_BASE + "get/get_dealers_measurement_price_inspection.php?key=" + API_KEY +
                "&inspection_id=" + inspection_id +
                "&task_id=" + id +
                "&dealer_id=" + dealer_id;

            fetch(url, { method: 'GET', redirect: 'follow' })
                .then(response => response.json())
                .then(result => {
                    var main_data = result[0].main_data;
                    var sub_data = result[0].sub_data;

                    $('#main_data tbody').empty();
                    $('#sub_data tbody').empty();

                    var mainRow = '<tr><td>' + (main_data.appreation || '---') + '</td><td>' + (main_data.measure_taken || '---') + '</td><td>' +
                        (main_data.warning || '---') + '</td><td>' + (main_data.pmg_ogra_price || '---') + '</td><td>' + (main_data.pmg_pump_price || '---') + '</td><td>' +
                        (main_data.pmg_variance || '---') + '</td><td>' + (main_data.hsd_ogra_price || '---') + '</td><td>' + (main_data.hsd_pump_price || '---') +
                        '</td><td>' + (main_data.hsd_variance || '---') + '</td></tr>';
                    $('#main_data tbody').append(mainRow);

                    var ii = 1;
                    $.each(sub_data, function (index, item) {
                        var subRow = '<tr><td>' + ii + '</td><td>' + (item.dispensor_name || '---') + '</td><td>' + (item.pmg_accurate || '---') +
                            '</td><td>' + (item.shortage_pmg || '---') + '</td><td>' + (item.hsd_accurate || '---') + '</td><td>' + (item.shortage_hsd || '---') + '</td></tr>';
                        $('#sub_data tbody').append(subRow);
                        ii++;
                    });

                    openModal('m_p_modal');
                })
                .catch(error => console.log('error', error));
        }

        // ============================================
        // ✅ Export to PDF — Simple (Live jaisa)
        // ============================================
        $('#exportBtn').on('click', function () {
            $(this).prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Downloading...');

            var element = document.getElementById('exporting');
            var currentDate = new Date().toLocaleString().replace(/[\/,:\s]+/g, '-');
            var opt = {
                margin: 0.5,
                filename: 'Inspection-Result-' + currentDate + '.pdf',
                image: { type: 'text', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'in', format: 'A4', orientation: 'landscape' }
            };

            html2pdf().from(element).set(opt).save();

            var self = this;
            setTimeout(function () {
                $(self).prop('disabled', false).html('<i class="fa-solid fa-file-pdf"></i> Export to PDF');
            }, 2000);
        });

        $('#expoert_measure_price').on('click', function () {
            $(this).prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Downloading...');

            var element = document.getElementById('maesurement_price_div');
            var opt = {
                margin: 1,
                filename: 'Measurement & Price Result.pdf',
                image: { type: 'text', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
            };

            html2pdf().from(element).set(opt).save();

            var self = this;
            setTimeout(function () {
                $(self).prop('disabled', false).html('<i class="fa-solid fa-file-pdf"></i> Export to PDF');
            }, 2000);
        });

        function blocking() {
            $.blockUI({
                message: '<h1>Please Wait...</h1>',
                css: {
                    border: 'none',
                    padding: '15px',
                    backgroundColor: '#000',
                    '-webkit-border-radius': '10px',
                    '-moz-border-radius': '10px',
                    opacity: .5,
                    color: '#fff'
                }
            });
        }
    </script>

</body>
</html>