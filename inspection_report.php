<?php
require_once __DIR__ . '/session/session.php';
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Inspection Report | Admin</title>
    <meta name="viewport" content="width=device-width,   initial-scale=1.0">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

    <!-- PDF Export -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.3/jspdf.min.js"></script>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>

    <!-- DARK MODE INIT -->
    <script>
        (function() {
            const isDarkMode = localStorage.getItem('darkMode') === 'true';
            if (isDarkMode) document.documentElement.classList.add('dark-mode');
        })();
    </script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        dash: {
                            bg: '#060b13', panel: '#0d1520', border: '#1a2635',
                            textMuted: '#64748b', accentBlue: '#1d4ed8'
                        }
                    }
                }
            }
        }
    </script>

    <style>
        :root {
            --bg-body: #f4f6fa; --bg-panel: #ffffff; --border-color: #e2e8f0;
            --text-heading: #0f2440; --text-body: #334155; --text-muted: #64748b;
            --input-bg: #ffffff; --hover-bg: #f1f5f9; --table-head-bg: #f8fafc;
            --table-head-text: #475569; --table-row-text: #1e293b; --table-row-hover: #f1f5f9;
            --scrollbar-track: #eef1f6; --scrollbar-thumb: #cbd5e1;
            --modal-overlay: rgba(15, 23, 42, 0.45);
            --btn-secondary-bg: #e2e8f0; --btn-secondary-text: #334155;
            --btn-secondary-hover-bg: #cbd5e1; --btn-secondary-hover-text: #0f2440;
            --toolbar-btn-bg: #ffffff; --dropdown-bg: #ffffff; --dropdown-hover: #f1f5f9;
            --focus-border: #1d4ed8;
            --focus-ring: rgba(29, 78, 216, 0.2);
        }
        html.dark-mode {
            --bg-body: #060b13; --bg-panel: #0d1520; --border-color: #1a2635;
            --text-heading: #ffffff; --text-body: #e5e7eb; --text-muted: #94a3b8;
            --input-bg: #060b13; --hover-bg: #1a2635; --table-head-bg: #0a121c;
            --table-head-text: #94a3b8; --table-row-text: #e5e7eb; --table-row-hover: #0d1a2a;
            --scrollbar-track: #060b13; --scrollbar-thumb: #1a2635;
            --modal-overlay: rgba(6, 11, 19, 0.85);
            --btn-secondary-bg: #1a2635; --btn-secondary-text: #94a3b8;
            --btn-secondary-hover-bg: #1f2a3d; --btn-secondary-hover-text: #ffffff;
            --toolbar-btn-bg: #060b13; --dropdown-bg: #0d1520; --dropdown-hover: #1a2635;
            --focus-border: #1d4ed8;
            --focus-ring: rgba(29, 78, 216, 0.35);
        }
        * { box-sizing: border-box; }
        body {
            background-color: var(--bg-body); color: var(--text-muted);
            font-family: 'Inter', sans-serif; margin: 0; font-size: 12px;
            transition: background-color .25s ease, color .25s ease;
        }
        .text-heading { color: var(--text-heading) !important; }
        .panel-card {
            background-color: var(--bg-panel); border: 1px solid var(--border-color);
            border-radius: 0.375rem;
        }

        /* TABLE STYLES */
        .table-container { overflow-x: auto; width: 100%; }
        #myTable {
            width: 100% !important;
            border-collapse: collapse !important;
            font-size: 11px;
            margin: 0;
        }
        #myTable thead th {
            background-color: var(--table-head-bg) !important;
            color: var(--table-head-text) !important;
            font-weight: 600;
            text-align: left;
            padding: 10px 12px;
            border-bottom: 1px solid var(--border-color);
            white-space: nowrap;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        #myTable tbody td {
            padding: 10px 12px;
            border-bottom: 1px solid var(--border-color);
            color: var(--table-row-text);
            vertical-align: middle;
            font-size: 11px;
        }
        #myTable tbody tr:hover {
            background-color: var(--table-row-hover);
        }

        .dataTables_wrapper { width: 100% !important; padding: 0 !important; }
        .dataTables_wrapper .dataTables_filter { display: none !important; }
        .dataTables_wrapper .dataTables_length { display: none !important; }
        .dataTables_wrapper .dataTables_info {
            color: var(--text-muted) !important;
            font-size: 11px !important;
            padding: 12px !important;
        }
        .dataTables_wrapper .dataTables_paginate { padding: 12px !important; }
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 4px 10px !important;
            margin: 0 2px !important;
            border-radius: 4px !important;
            background: var(--toolbar-btn-bg) !important;
            border: 1px solid var(--border-color) !important;
            color: var(--text-muted) !important;
            font-size: 11px !important;
            cursor: pointer !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: var(--hover-bg) !important;
            color: var(--text-heading) !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #1d4ed8 !important;
            color: #ffffff !important;
            border-color: #1d4ed8 !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
            opacity: 0.5 !important; cursor: not-allowed !important;
        }

        /* Exporter Buttons Spacing */
        .dt-buttons {
            display: flex !important;
            gap: 8px !important;
            flex-wrap: wrap !important;
            padding: 12px 14px !important;
            margin: 0 !important;
            width: 100% !important;
            box-sizing: border-box !important;
            border-bottom: 1px solid var(--border-color) !important;
        }
        .dt-buttons .dt-button {
            padding: 6px 12px !important;
            margin: 0 !important;
            background-color: var(--toolbar-btn-bg) !important;
            border: 1px solid var(--border-color) !important;
            border-radius: 0.25rem !important;
            color: var(--text-muted) !important;
            font-size: 10px !important;
            cursor: pointer !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 4px !important;
            height: 30px !important;
            font-family: 'Inter', sans-serif !important;
        }
        .dt-buttons .dt-button:hover {
            background-color: var(--hover-bg) !important;
            color: var(--text-heading) !important;
        }

        .form-input {
            background-color: var(--input-bg); border: 1px solid var(--border-color);
            border-radius: 0.25rem; color: var(--text-body);
            padding: 6px 10px; width: 100%; font-size: 12px;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .form-input:focus {
            outline: none; border-color: var(--focus-border);
            box-shadow: 0 0 0 2px var(--focus-ring);
        }

        .btn-primary {
            background-color: #1d4ed8; color: #fff; padding: 8px 20px;
            border-radius: 0.25rem; border: none; font-size: 12px;
            font-weight: 500; cursor: pointer;
        }
        .btn-primary:hover { background-color: #2563eb; }
        .btn-primary:disabled { opacity: 0.6; cursor: not-allowed; }

        .search-input {
            background-color: var(--input-bg); border: 1px solid var(--border-color);
            border-radius: 0.25rem; color: var(--text-body);
            padding: 6px 10px; font-size: 12px; outline: none; height: 30px;
        }
        .search-input:focus {
            border-color: #1d4ed8;
            box-shadow: 0 0 0 2px rgba(29, 78, 216, 0.2);
        }

        .toolbar-row {
            display: flex; align-items: center; justify-content: space-between;
            gap: 10px; flex-wrap: wrap; width: 100%;
        }
        .toolbar-left, .toolbar-right {
            display: flex; align-items: center; gap: 6px; flex-wrap: wrap;
        }

        .column-visibility-dropdown { position: relative; display: inline-block; }
        .column-visibility-dropdown .dropdown-btn {
            background-color: var(--toolbar-btn-bg);
            border: 1px solid var(--border-color);
            border-radius: 0.25rem; color: var(--text-muted);
            padding: 6px 12px; font-size: 10px; cursor: pointer;
            display: inline-flex; align-items: center; gap: 6px;
            height: 30px; white-space: nowrap;
        }
        .column-visibility-dropdown .dropdown-btn:hover {
            background-color: var(--hover-bg); color: var(--text-heading);
        }
        .column-visibility-dropdown .dropdown-menu {
            position: absolute; top: calc(100% + 4px); left: 0;
            min-width: 210px; background-color: var(--dropdown-bg);
            border: 1px solid var(--border-color);
            border-radius: 0.375rem; padding: 6px 0;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
            z-index: 1000; display: none;
            max-height: 380px; overflow-y: auto;
        }
        .column-visibility-dropdown .dropdown-menu.show { display: block; }
        .column-visibility-dropdown .dropdown-menu .dropdown-header {
            padding: 6px 14px 8px; font-size: 9px; font-weight: 600;
            text-transform: uppercase; color: var(--text-muted);
            border-bottom: 1px solid var(--border-color);
        }
        .column-visibility-dropdown .dropdown-menu .dropdown-item {
            display: flex; align-items: center; gap: 10px;
            padding: 6px 14px; cursor: pointer;
            font-size: 11px; color: var(--text-body);
        }
        .column-visibility-dropdown .dropdown-menu .dropdown-item:hover {
            background-color: var(--dropdown-hover);
        }
        .column-visibility-dropdown .dropdown-menu .dropdown-item input[type="checkbox"] {
            width: 14px; height: 14px; cursor: pointer;
            accent-color: #1d4ed8; flex-shrink: 0;
        }
        .column-visibility-dropdown .dropdown-menu .dropdown-actions {
            display: flex; gap: 6px; padding: 8px 14px 4px;
            border-top: 1px solid var(--border-color); margin-top: 4px;
        }
        .column-visibility-dropdown .dropdown-menu .dropdown-actions button {
            flex: 1; padding: 4px 8px; border-radius: 0.25rem;
            border: 1px solid var(--border-color);
            background: var(--toolbar-btn-bg); color: var(--text-muted);
            font-size: 9px; cursor: pointer;
        }
        .column-visibility-dropdown .dropdown-menu .dropdown-actions button:hover {
            background: var(--hover-bg); color: var(--text-heading);
        }
        .column-visibility-dropdown .dropdown-menu .dropdown-actions button.select-all-btn {
            border-color: #10b981; color: #10b981;
        }
        .column-visibility-dropdown .dropdown-menu .dropdown-actions button.deselect-all-btn {
            border-color: #ef4444; color: #ef4444;
        }

        .action-btn {
            padding: 4px 8px; border-radius: 4px; font-size: 11px;
            cursor: pointer; border: none; background: transparent;
            color: var(--text-muted);
        }
        .action-btn:hover { background: var(--hover-bg); color: var(--text-heading); }
        .action-btn.edit:hover { background: #3b82f620; color: #3b82f6; }

        /* Green Icons (Table + Modal) */
        #myTable tbody td .fa-file-image,
        #myTable tbody td a .fa-file-image {
            color: #10b981 !important;
        }

        .action-btn.edit .fa-align-justify {
            color: var(--text-muted);
            transition: color 0.2s ease;
        }
        .action-btn.edit:hover .fa-align-justify {
            color: #10b981 !important;
        }

        .dynamic_table thead th i.fa-arrow-right,
        .dynamic_table thead th i.fa-angle-right,
        .dynamic_table thead th i.fa-chevron-right,
        .dynamic_table thead th i.fa-caret-right,
        .dynamic_table thead th i.fa-arrow-circle-right,
        .dynamic_table thead th .fa-align-justify,
        .dynamic_table thead th .fa-file-image {
            color: #10b981 !important;
        }

        #survey-container h6 i,
        #survey-container .fa-arrow-right,
        #survey-container .fa-angle-right,
        #survey-container .fa-chevron-right {
            color: #10b981 !important;
        }

        .action-btn .fa-align-justify {
            color: var(--text-muted);
            transition: color 0.2s ease;
        }

        /* Tick/Check icon GREEN */
        .dynamic_table td .fa-check,
        .dynamic_table td .fa-check-circle,
        .dynamic_table td .fa-check-square,
        .dynamic_table td .fa-circle-check,
        .dynamic_table td .text-success {
            color: #10b981 !important;
        }
        .dynamic_table td i.text-success,
        .dynamic_table td i.fas.fa-check.text-success {
            color: #10b981 !important;
        }

        /* Thumbnail Border Color on Focus */
        .file-thumb-box {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            overflow: hidden;
            cursor: pointer;
            background: #f9fafb;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
            position: relative;
            vertical-align: middle;
            outline: none;
        }
        .file-thumb-box:focus,
        .file-thumb-box:focus-visible,
        .file-thumb-box:active,
        .file-thumb-box.thumb-active {
            border-color: #1d4ed8 !important;
            box-shadow: 0 0 0 2px rgba(29, 78, 216, 0.2) !important;
            outline: none !important;
        }
        .file-thumb-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
        .file-thumb-box .file-icon-fallback {
            color: #10b981;
            font-size: 18px;
            font-weight: bold;
        }
        html.dark-mode .file-thumb-box {
            background: #0a121c;
        }
        html.dark-mode .file-thumb-box:focus,
        html.dark-mode .file-thumb-box:focus-visible,
        html.dark-mode .file-thumb-box:active,
        html.dark-mode .file-thumb-box.thumb-active {
            border-color: #1d4ed8 !important;
            box-shadow: 0 0 0 2px rgba(29, 78, 216, 0.35) !important;
        }

        .modal-content-themed {
            background-color: var(--bg-panel);
            border: 1px solid var(--border-color);
            border-radius: 0.5rem; color: var(--text-body);
        }
        .modal-header-themed {
            border-bottom: 1px solid var(--border-color);
            padding: 12px 16px;
        }
        .modal-body-themed {
            padding: 16px; max-height: 75vh; overflow-y: auto;
        }
        .modal-backdrop-themed {
            background: var(--modal-overlay); backdrop-filter: blur(6px);
        }

        /* DYNAMIC TABLES */
        .dynamic_table {
            border: 1px solid var(--border-color) !important;
            border-collapse: collapse; margin-bottom: 20px; width: 100%;
            table-layout: fixed;
        }
        .dynamic_table th {
            border: 1px solid var(--border-color) !important;
            padding: 8px; text-align: left;
            background-color: var(--table-head-bg) !important;
            color: var(--table-head-text) !important;
            font-size: 10px; text-transform: uppercase;
            font-weight: 600;
            vertical-align: middle;
        }
        .dynamic_table td {
            border: 1px solid var(--border-color) !important;
            padding: 8px; text-align: left;
            color: var(--table-row-text) !important;
            font-size: 11px;
            vertical-align: middle;
            word-wrap: break-word;
            word-break: break-word;
        }
        .dynamic_table td.justify-text {
            text-align: justify;
            text-justify: inter-word;
            hyphens: auto;
        }

        /* Column widths */
        .dynamic_table th.col-sno { width: 50px; text-align: center; }
        .dynamic_table td.col-sno { width: 50px; text-align: center; }
        .dynamic_table th.col-yes, .dynamic_table th.col-no, .dynamic_table th.col-na {
            width: 55px; text-align: center;
        }
        .dynamic_table td.col-yes, .dynamic_table td.col-no, .dynamic_table td.col-na {
            width: 55px; text-align: center;
        }
        .dynamic_table th.col-comments { width: 180px; }
        .dynamic_table th.col-file { width: 70px; text-align: center; }
        .dynamic_table td.col-file { width: 70px; text-align: center; }

        .toast {
            position: fixed; bottom: 30px; right: 30px;
            background: var(--bg-panel); border: 1px solid var(--border-color);
            border-radius: 0.375rem; padding: 12px 20px;
            color: var(--text-body); font-size: 12px; z-index: 9999;
            transform: translateY(100px); opacity: 0;
            transition: all 0.3s ease-in-out;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
        }
        .toast.show { transform: translateY(0); opacity: 1; }
        .toast.success { border-color: #10b981; }
        .toast.success i { color: #10b981; }
        .toast.error { border-color: #ef4444; }
        .toast.error i { color: #ef4444; }

        .footer-themed {
            padding: 12px 16px; border-top: 1px solid var(--border-color);
            background-color: var(--bg-panel); color: var(--text-muted);
            font-size: 11px;
        }

        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: var(--scrollbar-track); }
        ::-webkit-scrollbar-thumb { background: var(--scrollbar-thumb); border-radius: 3px; }

        .loading-row td {
            text-align: center !important;
            padding: 30px !important;
            color: var(--text-muted) !important;
        }

        /* SweetAlert2 Image Popup Custom */
        .swal2-image-popup {
            max-width: 90vw !important;
            width: auto !important;
        }
        .swal2-image-popup .swal2-image {
            width: 100% !important;
            max-height: 80vh !important;
            object-fit: contain !important;
            margin: 0 auto !important;
        }

        /* PDF EXPORT PRINT-SAFE RULES */
        .pdf-export-mode .dynamic_table,
        .pdf-export-mode .dynamic_table tr,
        .pdf-export-mode .dynamic_table th,
        .pdf-export-mode .dynamic_table td {
            page-break-inside: avoid;
            break-inside: avoid;
        }
        .pdf-export-mode h6 {
            page-break-after: avoid;
            break-after: avoid;
        }

        /* Failed image placeholder (agar image convert na ho sake) */
        .pdf-export-mode img[data-failed="true"] {
            border: 1px dashed #ef4444;
            padding: 2px;
            background: #fef2f2;
        }
        html.dark-mode .pdf-export-mode img[data-failed="true"] {
            background: #450a0a;
            border-color: #ef4444;
        }
    </style>
</head>

<body class="flex h-screen overflow-hidden text-xs">

    <!-- SIDEBAR -->
    <?php include 'includes/sidebar.php'; ?>

    <!-- MAIN CONTENT -->
    <main id="mainContent" class="flex-1 flex flex-col overflow-hidden">

        <!-- TOPBAR -->
        <?php include 'includes/topbar.php'; ?>

        <!-- PAGE CONTENT -->
        <div class="flex-1 overflow-y-auto p-4" id="pageContent">

            <!-- Page Header -->
            <div class="flex justify-between items-center mb-4">
                <div>
                    <h2 class="text-heading font-semibold text-base tracking-wide uppercase">Inspection Report</h2>
                    <p class="text-[10px] text-gray-500">View and manage dealer inspection reports</p>
                </div>
            </div>

            <!-- Filters Toolbar -->
            <div class="panel-card p-3 mb-4">
                <div class="toolbar-row">
                    <div class="toolbar-left">
                        <div class="flex items-center gap-2">
                            <label class="text-[10px] text-gray-500 uppercase font-medium">From</label>
                            <input type="date" class="form-input" name="fromdate" id="fromdate" value="2026-09-01" style="width:140px;">
                        </div>
                        <div class="flex items-center gap-2">
                            <label class="text-[10px] text-gray-500 uppercase font-medium">To</label>
                            <input type="date" class="form-input" name="todate" id="todate" value="2026-10-01" style="width:140px;">
                        </div>
                        <button class="btn-primary" id="btn_get" onclick="fetchtable()" style="height:30px;padding:0 16px;">
                            <i class="fa-solid fa-magnifying-glass mr-1"></i> Get
                        </button>
                    </div>
                    <div class="toolbar-right">
                        <div class="column-visibility-dropdown" id="columnVisibilityDropdown">
                            <button class="dropdown-btn" onclick="toggleColumnDropdown()">
                                <i class="fa-regular fa-eye"></i> Columns
                                <i class="fa-solid fa-chevron-down text-[8px]"></i>
                            </button>
                            <div class="dropdown-menu" id="columnDropdownMenu">
                                <div class="dropdown-header">
                                    <i class="fa-regular fa-eye mr-1"></i> Column Visibility
                                </div>
                                <div id="columnListItems"></div>
                                <div class="dropdown-actions">
                                    <button class="select-all-btn" onclick="selectAllColumns()">
                                        <i class="fa-regular fa-check-circle mr-1"></i> All
                                    </button>
                                    <button class="deselect-all-btn" onclick="deselectAllColumns()">
                                        <i class="fa-regular fa-circle mr-1"></i> None
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-magnifying-glass text-gray-500 text-xs"></i>
                            <input type="text" id="customSearchInput" placeholder="Search..." class="search-input" style="width:180px;">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Inspection Report Table -->
            <div class="panel-card overflow-hidden">
                <div class="table-container">
                    <table id="myTable" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Date</th>
                                <th>Complete Time</th>
                                <th>Dealer Sign</th>
                                <th>User</th>
                                <th>JD Code</th>
                                <th>Dealer</th>
                                <th>Mode</th>
                                <th>Status</th>
                                <th>Inspection</th>
                                <th>Stock Reconciliation</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="loading-row">
                                <td colspan="11"><i class="fa-solid fa-spinner fa-spin mr-2"></i>Loading data...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <!-- FOOTER -->
        <footer class="footer-themed">
            <div class="flex justify-between items-center">
                <div>
                    <script>document.write(new Date().getFullYear())</script> © <span id="projectname">P2P Track</span>.
                </div>
                <div></div>
            </div>
        </footer>

    </main>

    <!-- TOAST -->
    <div id="toast" class="toast">
        <i class="fa-solid fa-check-circle mr-2"></i>
        <span id="toastMessage">Operation successful!</span>
    </div>

    <!-- SURVEY MODAL -->
    <div id="survey_modal" class="fixed inset-0 z-50 hidden items-center justify-center modal-backdrop-themed">
        <div class="modal-content-themed w-full max-w-6xl max-h-[90vh] flex flex-col">
            <div class="modal-header-themed flex justify-between items-center">
                <h5 id="labelc" class="text-heading font-semibold text-sm">Survey Response</h5>
                <button onclick="closeSurveyModal()" class="text-gray-400 hover:text-red-500 transition">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>
            <div class="modal-body-themed flex-1">
                <div class="flex justify-end mb-3">
                    <button class="btn-primary" id="exportBtn" style="font-size:11px;padding:6px 14px;">
                        <i class="fa-solid fa-file-pdf mr-1"></i> Export to PDF
                    </button>
                </div>
                <div id="exporting" style="background:var(--bg-panel);padding:12px;border-radius:6px;">
                    <div class="flex flex-wrap gap-3 mb-3">
                        <div class="w-full">
                            <img src="http://151.106.17.246:8080/hascolBridge_files/uploads/system_logo.png" alt="Logo" style="width:100px;">
                        </div>
                        <div class="w-full text-[11px] text-gray-500">
                            Planned Date : <span id="survey_time" class="text-heading font-medium"></span>
                        </div>
                        <div class="w-full text-[11px] text-gray-500">
                            Completion Date : <span id="survey_complete_time" class="text-heading font-medium"></span>
                        </div>
                        <div class="w-full text-[11px] text-gray-500">
                            Site Name : <span id="survey_dealer_name" class="text-heading font-medium"></span>
                        </div>
                        <div class="w-full text-[11px] text-gray-500">
                            TM Name : <span id="survey_ispector_name" class="text-heading font-medium"></span>
                        </div>
                        <div class="w-full text-[11px] text-gray-500" style="display:none;">
                            Planned Type : <span id="survey_type"></span>
                        </div>
                    </div>
                    <div id="survey-container" class="w-full"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- JAVASCRIPT -->
    <script>
        // ============================================
        // API Base URLs
        // ============================================
        var API_BASE = "http://151.106.17.246:8080/hascolbridgeApis/";
        var FILES_BASE = "http://151.106.17.246:8080/hascolBridge_files/";
        var API_KEY = "2170";

        var dataTable = null;

        // ============================================
        // Toast
        // ============================================
        function showToast(message, type) {
            type = type || 'success';
            var toast = $('#toast');
            var toastMessage = $('#toastMessage');
            toast.removeClass('success error').addClass(type);
            toastMessage.text(message);
            toast.addClass('show');
            clearTimeout(window.toastTimeout);
            window.toastTimeout = setTimeout(function() { toast.removeClass('show'); }, 3000);
        }

        // ============================================
        // Image Popup (SweetAlert2)
        // ============================================
        function showImagePopup(imageUrl) {
            Swal.fire({
                imageUrl: imageUrl,
                imageAlt: 'Inspection Image',
                imageWidth: '100%',
                width: '80%',
                showConfirmButton: true,
                confirmButtonText: 'Close',
                confirmButtonColor: '#1d4ed8',
                background: document.documentElement.classList.contains('dark-mode') ? '#0d1520' : '#ffffff',
                color: document.documentElement.classList.contains('dark-mode') ? '#e5e7eb' : '#334155',
                customClass: {
                    popup: 'swal2-image-popup'
                },
                didOpen: function() {
                    var popup = Swal.getPopup();
                    var img = popup.querySelector('.swal2-image');
                    if (!img) return;

                    var viewer = document.createElement('div');
                    viewer.className = 'img-zoom-viewer';
                    viewer.style.position = 'relative';
                    viewer.style.width = '100%';
                    viewer.style.maxWidth = '100%';
                    viewer.style.height = '70vh';
                    viewer.style.maxHeight = '70vh';
                    viewer.style.overflow = 'auto';
                    viewer.style.border = '1px solid var(--border-color)';
                    viewer.style.borderRadius = '6px';
                    viewer.style.background = 'rgba(0,0,0,0.03)';
                    viewer.style.display = 'flex';
                    viewer.style.alignItems = 'center';
                    viewer.style.justifyContent = 'center';
                    viewer.style.boxSizing = 'border-box';

                    var parent = img.parentNode;
                    parent.insertBefore(viewer, img);
                    viewer.appendChild(img);

                    img.style.transition = 'transform 0.12s ease-out';
                    img.style.transformOrigin = '0 0';
                    img.style.cursor = 'zoom-in';
                    img.style.userSelect = 'none';
                    img.style.willChange = 'transform';
                    img.style.maxWidth = 'none';
                    img.style.maxHeight = 'none';
                    img.style.flexShrink = '0';
                    img.style.display = 'block';

                    var scale = 1.0;
                    var MIN_SCALE = 0.5;
                    var MAX_SCALE = 5.0;
                    var STEP = 0.15;

                    img.style.transform = 'scale(1)';

                    function applyTransform() {
                        img.style.transform = 'scale(' + scale + ')';
                    }

                    function handleWheel(e) {
                        e.preventDefault();
                        e.stopPropagation();

                        var rect = img.getBoundingClientRect();
                        var cursorX = e.clientX - rect.left;
                        var cursorY = e.clientY - rect.top;

                        var oldScale = scale;
                        if (e.deltaY < 0) {
                            scale = Math.min(scale + STEP, MAX_SCALE);
                            img.style.cursor = 'zoom-out';
                        } else {
                            scale = Math.max(scale - STEP, MIN_SCALE);
                            if (scale <= 1.0) img.style.cursor = 'zoom-in';
                        }

                        var ratio = scale / oldScale;
                        var newScrollLeft = (viewer.scrollLeft + cursorX) * ratio - cursorX;
                        var newScrollTop  = (viewer.scrollTop + cursorY) * ratio - cursorY;

                        applyTransform();

                        requestAnimationFrame(function() {
                            viewer.scrollLeft = newScrollLeft;
                            viewer.scrollTop = newScrollTop;
                        });
                    }

                    viewer.addEventListener('wheel', handleWheel, { passive: false });
                    img.addEventListener('wheel', handleWheel, { passive: false });

                    img.addEventListener('dblclick', function() {
                        scale = 1.0;
                        applyTransform();
                        img.style.cursor = 'zoom-in';
                        viewer.scrollLeft = 0;
                        viewer.scrollTop = 0;
                    });

                    var isDragging = false;
                    var dragStartX = 0, dragStartY = 0;
                    var dragStartSL = 0, dragStartST = 0;

                    function startDrag(e) {
                        isDragging = true;
                        dragStartX = e.clientX;
                        dragStartY = e.clientY;
                        dragStartSL = viewer.scrollLeft;
                        dragStartST = viewer.scrollTop;
                        img.style.cursor = 'grabbing';
                        img.style.transition = 'none';
                        e.preventDefault();
                    }
                    function doDrag(e) {
                        if (!isDragging) return;
                        viewer.scrollLeft = dragStartSL - (e.clientX - dragStartX);
                        viewer.scrollTop = dragStartST - (e.clientY - dragStartY);
                    }
                    function endDrag() {
                        if (!isDragging) return;
                        isDragging = false;
                        img.style.cursor = scale > 1.0 ? 'zoom-out' : 'zoom-in';
                        img.style.transition = 'transform 0.12s ease-out';
                    }

                    img.addEventListener('mousedown', startDrag);
                    document.addEventListener('mousemove', doDrag);
                    document.addEventListener('mouseup', endDrag);

                    window.__swalImgCleanup = function() {
                        try {
                            viewer.removeEventListener('wheel', handleWheel);
                            img.removeEventListener('wheel', handleWheel);
                            img.removeEventListener('dblclick', null);
                            img.removeEventListener('mousedown', startDrag);
                            document.removeEventListener('mousemove', doDrag);
                            document.removeEventListener('mouseup', endDrag);
                        } catch(e) {}
                        window.__swalImgCleanup = null;
                    };
                },
                willClose: function() {
                    if (typeof window.__swalImgCleanup === 'function') {
                        window.__swalImgCleanup();
                    }
                }
            });
        }

        // ============================================
        // Thumbnail Loader
        // ============================================
        function loadThumbnail(imgEl, imageUrl) {
            var img = new Image();
            img.onload = function() {
                $(imgEl).attr('src', imageUrl).show();
                $(imgEl).siblings('.file-icon-fallback').hide();
            };
            img.onerror = function() {
                $(imgEl).hide();
                $(imgEl).siblings('.file-icon-fallback').show();
            };
            img.src = imageUrl;
        }

        // ============================================
        // Modal Helpers
        // ============================================
        function openSurveyModal() {
            $('#survey_modal').removeClass('hidden').addClass('flex');
            $('body').css('overflow', 'hidden');
        }
        function closeSurveyModal() {
            $('#survey_modal').addClass('hidden').removeClass('flex');
            $('body').css('overflow', '');
        }

        // ============================================
        // Dark Mode Toggle
        // ============================================
        function toggleDarkMode() {
            var html = document.documentElement;
            var isDark = html.classList.toggle('dark-mode');
            localStorage.setItem('darkMode', isDark);
            var icon = document.querySelector('.dark-mode-toggle i');
            if (icon) icon.className = isDark ? 'fa-solid fa-sun' : 'fa-solid fa-moon';
        }

        // ============================================
        // Column Visibility Config
        // ============================================
        var columnConfig = [
            { idx: 0, label: 'S.No' },
            { idx: 1, label: 'Date' },
            { idx: 2, label: 'Complete Time' },
            { idx: 3, label: 'Dealer Sign' },
            { idx: 4, label: 'User' },
            { idx: 5, label: 'JD Code' },
            { idx: 6, label: 'Dealer' },
            { idx: 7, label: 'Mode' },
            { idx: 8, label: 'Status' },
            { idx: 9, label: 'Inspection' },
            { idx: 10, label: 'Stock Reconciliation' }
        ];

        // ============================================
        // Document Ready
        // ============================================
        $(document).ready(function() {
            $(document).on('click', '#sidebarToggle', function() {
                $('#sidebar').toggleClass('collapsed');
                localStorage.setItem('sidebarCollapsed', $('#sidebar').hasClass('collapsed'));
            });
            if (localStorage.getItem('sidebarCollapsed') === 'true') {
                $('#sidebar').addClass('collapsed');
            }

            $('#customSearchInput').on('keyup', function() {
                if (dataTable) dataTable.search($(this).val()).draw();
            });

            $(document).on('click', function(e) {
                if (!$(e.target).closest('.column-visibility-dropdown').length) {
                    closeColumnDropdown();
                }
                if (!$(e.target).closest('.file-thumb-box').length) {
                    $('.file-thumb-box').removeClass('thumb-active');
                }
            });

            $(document).on('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeSurveyModal();
                    closeColumnDropdown();
                }
            });

            initializeDataTable();
            fetchtable();
        });

        // ============================================
        // Initialize DataTable
        // ============================================
        function initializeDataTable() {
            if ($.fn.DataTable.isDataTable('#myTable')) {
                $('#myTable').DataTable().destroy();
            }
            $('#myTable tbody').empty();

            dataTable = $('#myTable').DataTable({
                data: [],
                columns: [
                    { title: 'S.No' }, { title: 'Date' }, { title: 'Complete Time' },
                    { title: 'Dealer Sign' }, { title: 'User' }, { title: 'JD Code' },
                    { title: 'Dealer' }, { title: 'Mode' }, { title: 'Status' },
                    { title: 'Inspection' }, { title: 'Stock Reconciliation' }
                ],
                dom: 'Bfrtip',
                buttons: [
                    { extend: 'copy', text: '<i class="fa-regular fa-copy"></i> Copy', className: 'toolbar-btn' },
                    { extend: 'excel', text: '<i class="fa-regular fa-file-excel"></i> Excel', className: 'toolbar-btn', title: 'Inspection_Report' },
                    { extend: 'csv', text: '<i class="fa-regular fa-file-csv"></i> CSV', className: 'toolbar-btn', title: 'Inspection_Report' },
                    { extend: 'pdf', text: '<i class="fa-regular fa-file-pdf"></i> PDF', className: 'toolbar-btn', title: 'Inspection Report', orientation: 'landscape', pageSize: 'A4' },
                    { extend: 'print', text: '<i class="fa-solid fa-print"></i> Print', className: 'toolbar-btn' }
                ],
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100],
                ordering: true,
                order: [[0, 'asc']],
                responsive: false,
                autoWidth: false,
                language: {
                    emptyTable: '<div class="text-center py-8 text-gray-500"><i class="fa-solid fa-clipboard-list text-2xl block mb-2"></i>No inspection data found</div>',
                    info: 'Showing _START_ to _END_ of _TOTAL_ entries',
                    infoEmpty: 'Showing 0 to 0 of 0 entries',
                    infoFiltered: '(filtered from _MAX_ total entries)',
                    zeroRecords: '<div class="text-center py-8 text-gray-500">No matching records found</div>'
                },
                initComplete: function() { populateColumnDropdown(); }
            });
        }

        // ============================================
        // Column Visibility Functions
        // ============================================
        function populateColumnDropdown() {
            var container = $('#columnListItems');
            container.empty();
            columnConfig.forEach(function(col) {
                var isVisible = true;
                try { isVisible = dataTable.column(col.idx).visible(); } catch(e) {}
                var item = '<div class="dropdown-item" onclick="toggleColumnVisibility(' + col.idx + ')">' +
                    '<input type="checkbox" id="col-checkbox-' + col.idx + '" ' + (isVisible ? 'checked' : '') +
                    ' onclick="event.stopPropagation(); toggleColumnVisibility(' + col.idx + ')">' +
                    '<span class="column-label">' + col.label + '</span></div>';
                container.append(item);
            });
        }

        function toggleColumnVisibility(colIdx) {
            if (!dataTable) return;
            try {
                var isVisible = dataTable.column(colIdx).visible();
                dataTable.column(colIdx).visible(!isVisible);
                $('#col-checkbox-' + colIdx).prop('checked', !isVisible);
            } catch(e) {}
        }

        function selectAllColumns() {
            if (!dataTable) return;
            columnConfig.forEach(function(col) {
                try { dataTable.column(col.idx).visible(true); } catch(e) {}
                $('#col-checkbox-' + col.idx).prop('checked', true);
            });
            showToast('All columns selected!', 'success');
        }

        function deselectAllColumns() {
            if (!dataTable) return;
            columnConfig.forEach(function(col) {
                try { dataTable.column(col.idx).visible(false); } catch(e) {}
                $('#col-checkbox-' + col.idx).prop('checked', false);
            });
            showToast('All columns deselected!', 'success');
        }

        function toggleColumnDropdown() {
            var menu = $('#columnDropdownMenu');
            menu.toggleClass('show');
            if (menu.hasClass('show')) populateColumnDropdown();
        }

        function closeColumnDropdown() { $('#columnDropdownMenu').removeClass('show'); }

        // ============================================
        // fetchtable()
        // ============================================
        function fetchtable() {
            var fromdate = $('#fromdate').val(), todate = $('#todate').val();
            if (dataTable) {
                dataTable.clear().draw();
                $('#myTable tbody').html('<tr class="loading-row"><td colspan="11"><i class="fa-solid fa-spinner fa-spin mr-2"></i>Loading data...</td></tr>');
            }

            var url = API_BASE + "get/get_all_dealers_inspection_report_data.php?key=" + API_KEY +
                      "&pre=Admin&id=1&from=" + fromdate + "&to=" + todate;

            fetch(url)
                .then(function(response) {
                    if (!response.ok) throw new Error('HTTP ' + response.status);
                    return response.json();
                })
                .then(function(response) {
                    $('#myTable tbody').empty();
                    if (!dataTable) initializeDataTable();
                    dataTable.clear();

                    if (!response || response.length === 0) {
                        dataTable.draw();
                        showToast('No data found.', 'error');
                        return;
                    }

                    var rowsToAdd = [];
                    $.each(response, function(index, data) {
                        // Inspection button
                        var inspection_btn = '<button type="button" onclick="displaySurvey(' + data.id + ',' +
                            data.id + ',' + data.dealer_id + ', \'' + String(data.dealer_name).replace(/'/g, "\\'") +
                            '\',\'' + data.time + '\',\'' + data.visit_close_time + '\',\'' + data.name +
                            '\',\'' + data.type + '\',' + data.last_visit_id +
                            ')" class="action-btn edit"><i class="fas fa-align-justify"></i></button>';
                        var inpection = (data.inspection == 1) ? inspection_btn : "---";

                        // Dealer sign
                        var dealer_sign = (data.dealer_sign != null) ?
                            '<a href="' + FILES_BASE + 'uploads/' + data.dealer_sign +
                            '" target="_blank"><i class="fas fa-file-image" style="color:#10b981;font-size:20px;font-weight:bold;"></i></a>' :
                            "---";

                        // Stock reconciliation button
                        var stock_recon_btn = '<button type="button" onclick="get_recon_stock(' + data.id +
                            ',' + data.dealer_id + ', \'' + String(data.dealer_name).replace(/'/g, "\\'") + '\',\'' +
                            data.time + '\',\'' + data.visit_close_time + '\',\'' + data.name + '\',\'' + data.type +
                            '\',' + data.last_visit_id +
                            ')" class="action-btn edit"><i class="fas fa-align-justify"></i></button>';
                        var stock_recon = (data.stock_recon == 1) ? stock_recon_btn : "---";

                        rowsToAdd.push([
                            index + 1,
                            data.time ? data.time.split(' ')[0] : '---',
                            data.visit_close_time || '---',
                            dealer_sign,
                            data.name || '---',
                            data.dealer_sap || '---',
                            data.dealer_name || '---',
                            (data.type === "Inpection" ? "Inspection" : (data.type || '---')),
                            data.current_status || '---',
                            inpection,
                            stock_recon
                        ]);
                    });

                    dataTable.rows.add(rowsToAdd);
                    dataTable.draw();
                    showToast('Data loaded: ' + response.length + ' records', 'success');
                })
                .catch(function(error) {
                    $('#myTable tbody').html('<tr class="loading-row"><td colspan="11" style="color:#ef4444;">Error: ' + error.message + '</td></tr>');
                    showToast('Failed to load data.', 'error');
                });
        }

        // ============================================
        // displaySurvey() — INSPECTION REPORT MODAL
        // ============================================
        function displaySurvey(id, inspection_id, dealer_id, dealer_name, isp_date, comp_date, username, type, last_visit_id) {
            $('#labelc').text('Inspection');
            $('#survey_time').text(isp_date);
            $('#survey_complete_time').text(comp_date);
            $('#survey_dealer_name').text(dealer_name);
            $('#survey_ispector_name').text(username);
            $('#survey_type').text(type);
            $('#survey-container').empty();

            fetch(API_BASE + "get/get_dealer_survey_response.php?key=" + API_KEY + "&inspection_id=" +
                    inspection_id + "&task_id=" + id + "&dealer_id=" + dealer_id)
                .then(function(response) { return response.json(); })
                .then(function(result) { create_div(result); })
                .catch(function(error) { console.log('error', error); });
        }

        // ============================================
        // create_div() — INSPECTION REPORT
        // ============================================
        function create_div(response) {
            var total_ques = 0, r_yes = 0, r_no = 0, r_n_a = 0;
            var $sectionDiv = $('<div class="w-full"></div>');

            // Summary table
            var table1 = $('<table class="dynamic_table">');
            var tableHead1 = $('<thead>');
            var tableBody1 = $('<tbody>');
            var headerRow1 = $('<tr>');
            headerRow1.append($('<th>').text('Total Questions'));
            headerRow1.append($('<th>').text('Yes'));
            headerRow1.append($('<th>').text('No'));
            headerRow1.append($('<th>').text('N/A'));
            headerRow1.append($('<th>').text('%'));
            tableHead1.append(headerRow1);
            table1.append(tableHead1);

            response.forEach(function(section) {
                section.Questions.forEach(function(question) {
                    total_ques++;
                    if (question.response == 'Yes') r_yes++;
                    else if (question.response == 'No') r_no++;
                    else if (question.response == 'N/A') r_n_a++;
                });
            });

            var percentage = total_ques > 0 ? ((total_ques - r_n_a) / total_ques) * 100 : 0;
            var row1 = $('<tr>');
            row1.append($('<td>').text(total_ques));
            row1.append($('<td>').text(r_yes));
            row1.append($('<td>').text(r_no));
            row1.append($('<td>').text(r_n_a));
            row1.append($('<td>').text(Math.round(percentage)));
            tableBody1.append(row1);
            table1.append(tableBody1);
            $sectionDiv.append(table1);

            // Question tables
            response.forEach(function(section) {
                var table = $('<table class="dynamic_table">');
                var tableHead = $('<thead>');
                var tableBody = $('<tbody>');
                var headerRow = $('<tr>');

                var sectionTitleHtml = section.name;
                var thQuestion = $('<th>').html(sectionTitleHtml);

                var thSno = $('<th>').addClass('col-sno').text('SNo');
                var thYes = $('<th>').addClass('col-yes').text('Yes');
                var thNo = $('<th>').addClass('col-no').text('No');
                var thNa = $('<th>').addClass('col-na').text('N/A');
                var thComments = $('<th>').addClass('col-comments').text('Comments');
                var thFile = $('<th>').addClass('col-file').text('File');

                headerRow.append(thSno, thQuestion, thYes, thNo, thNa, thComments, thFile);
                tableHead.append(headerRow);
                table.append(tableHead);

                var j = 1;
                section.Questions.forEach(function(question) {
                    var row = $('<tr>');
                    row.append($('<td>').addClass('col-sno').text(j));

                    row.append($('<td>').addClass('justify-text').text(question.question || ''));

                    row.append($('<td>').addClass('col-yes').html(
                        question.response === 'Yes' ? '<i class="fas fa-check" style="color:#10b981;font-size:16px;font-weight:bold;"></i>' : ''
                    ));
                    row.append($('<td>').addClass('col-no').html(
                        question.response === 'No' ? '<i class="fas fa-check" style="color:#10b981;font-size:16px;font-weight:bold;"></i>' : ''
                    ));
                    row.append($('<td>').addClass('col-na').html(
                        question.response === 'N/A' ? '<i class="fas fa-check" style="color:#10b981;font-size:16px;font-weight:bold;"></i>' : ''
                    ));
                    row.append($('<td>').addClass('col-comments').text(question.comment || ''));

                    if (question.cancel_file === null || question.cancel_file === '' || question.cancel_file === undefined) {
                        row.append($('<td>').addClass('col-file').html('---'));
                    } else {
                        var imageUrl = FILES_BASE + 'uploads/' + question.cancel_file;
                        var thumbHtml = '<div class="file-thumb-box" tabindex="0" data-img-src="' + imageUrl + '" onclick="showImagePopup(\'' + imageUrl.replace(/'/g, "\\'") + '\'); $(this).addClass(\'thumb-active\'); setTimeout(function(){ $(\'.file-thumb-box\').removeClass(\'thumb-active\'); }, 800);">' +
                            '<img src="" alt="preview" style="display:none;" />' +
                            '<i class="fas fa-file-image file-icon-fallback"></i>' +
                            '</div>';
                        var $fileCell = $('<td>').addClass('col-file').html(thumbHtml);
                        var $img = $fileCell.find('img');
                        loadThumbnail($img[0], imageUrl);
                        row.append($fileCell);
                    }

                    tableBody.append(row);
                    j++;
                });
                table.append(tableBody);
                $sectionDiv.append(table);
            });

            $('#survey-container').append($sectionDiv);
            openSurveyModal();
        }

        // ============================================
        // get_recon_stock() — STOCK RECONCILIATION MODAL
        // ============================================
        function get_recon_stock(task_id, dealer_id, dealer_name, isp_date, comp_date, username, type, last_visit_id) {
            $('#labelc').text('Stock Reconciliation');
            $('#survey_time').text(isp_date);
            $('#survey_complete_time').text(comp_date);
            $('#survey_dealer_name').text(dealer_name);
            $('#survey_ispector_name').text(username);
            $('#survey_type').text(type);
            $('#survey-container').empty();

            fetch(API_BASE + "get/get_dealer_stock_recon_new.php?key=" + API_KEY + "&task_id=" + task_id +
                    "&dealer_id=" + dealer_id)
                .then(function(response) { return response.json(); })
                .then(function(result) { stock_reco_new(result); })
                .catch(function(error) { console.log('error', error); });
        }

        // ============================================
        // stock_reco_new() — STOCK RECONCILIATION
        // ============================================
        function stock_reco_new(data) {
            data.forEach(function(resp) {
                var tank_dip = JSON.parse(resp.tanks);
                var nozzless = JSON.parse(resp.nozzel);
                var is_totalizer_data = resp.is_totalizer_data ? JSON.parse(resp.is_totalizer_data) : [];

                var html = '<div class="w-full my-3">' +
                    '<h6 style="text-align:center;padding:3px 11px;background:var(--table-head-bg);color:var(--text-heading);">Stock Reconciliation ' + resp.product_name + '</h6>' +
                    '<div class="grid grid-cols-2 gap-3 mb-3">' +
                    '<div class="flex gap-2"><span class="text-gray-500">Site Name :</span><span class="text-heading border-b border-gray-300 flex-1">' + resp.dealer_name + '</span></div>' +
                    '<div class="flex gap-2"><span class="text-gray-500">Date :</span><span class="text-heading border-b border-gray-300 flex-1">' + resp.created_at + '</span></div>' +
                    '<div class="flex gap-2"><span class="text-gray-500">Product :</span><span class="text-heading border-b border-gray-300 flex-1">' + resp.product_name + '</span></div>' +
                    '<div class="flex gap-2"><span class="text-gray-500">Total Days :</span><span class="text-heading border-b border-gray-300 flex-1">' + resp.total_days + '</span></div>' +
                    '<div class="flex gap-2"><span class="text-gray-500">From:</span><span class="text-heading border-b border-gray-300 flex-1">' + resp.last_recon_date + '</span></div>' +
                    '<div class="flex gap-2"><span class="text-gray-500">To :</span><span class="text-heading border-b border-gray-300 flex-1">' + resp.created_at + '</span></div>' +
                    '</div>' +
                    '<h6 style="text-align:center;padding:3px 11px;background:var(--table-head-bg);color:var(--text-heading);">Opening and Closing Dips</h6>' +
                    '<table class="dynamic_table" style="width:100%">' +
                    '<tr><th></th><th colspan="2" style="text-align:center;">Opening</th><th></th><th colspan="2" style="text-align:center;">Closing</th></tr>' +
                    '<tr><th>Tanks</th><th>Dip mm</th><th>Qty in Ltrs</th><td></td><th>Dip mm</th><th>Qty in Ltrs</th></tr>';

                tank_dip.forEach(function(item) {
                    html += '<tr><th>' + item.name + '</th><td>' + item.opening_dip + '</td><td>' + item.opening + '</td><td></td><td>' + item.closing_dip + '</td><td>' + item.closing + '</td></tr>';
                });

                html += '<tr><th colspan="2">Opening Stock</th><td>' + resp.sum_of_opening + '</td><th colspan="2">Physical Stock</th><td>' + resp.sum_of_closing + '</td></tr></table>' +
                    '<h6 style="text-align:center;padding:3px 11px;background:var(--table-head-bg);color:var(--text-heading);">Opening and Closing Meter Readings</h6>' +
                    '<table class="dynamic_table" style="width:100%">' +
                    '<tr><th></th><th></th><th></th><th>Opening (A)</th><th>Closing (B)</th><th>Sales (B-A)</th><th style="text-align:center;width:70px;">Images</th></tr>';

                nozzless.forEach(function(item) {
                    var thumbHtml = '<div class="file-thumb-box" tabindex="0" data-nozzle-id="' + item.id + '" data-task-id="' + resp.task_id + '" onclick="openReconImage(' + item.id + ',' + resp.task_id + '); $(this).addClass(\'thumb-active\'); setTimeout(function(){ $(\'.file-thumb-box\').removeClass(\'thumb-active\'); }, 800);">' +
                        '<i class="fas fa-file-image file-icon-fallback"></i>' +
                        '</div>';

                    html += '<tr><th>' + item.name + '</th><td></td><td></td><td>' + item.opening + '</td><td>' + item.closing + '</td><td>' + (parseFloat(item.closing) - parseFloat(item.opening)) + '</td>' +
                        '<td style="text-align:center;">' + thumbHtml + '</td></tr>';
                });

                is_totalizer_data.forEach(function(item) {
                    var thumbHtml = '<div class="file-thumb-box" tabindex="0" data-nozzle-id="' + item.id + '" data-task-id="' + resp.task_id + '" onclick="openReconImage(' + item.id + ',' + resp.task_id + '); $(this).addClass(\'thumb-active\'); setTimeout(function(){ $(\'.file-thumb-box\').removeClass(\'thumb-active\'); }, 800);">' +
                        '<i class="fas fa-file-image file-icon-fallback"></i>' +
                        '</div>';

                    html += '<tr><th>Change Totalizer of ' + item.name + ' - ' + item.dispenser_name + '</th><td></td><td></td><td>' + item.opening + '</td><td>' + item.closing + '</td><td>' + (parseFloat(item.closing) - parseFloat(item.opening)) + '</td>' +
                        '<td style="text-align:center;">' + thumbHtml + '</td></tr>';
                });

                html += '<tr><td></td><td></td><td></td><th colspan="2">Total Sales for the Period</th><td>' + resp.total_sales + '</td><td></td></tr></table>' +
                    '<table class="dynamic_table" style="width:100%"><tr><th>Total Reciepts</th><td>' + resp.total_recipt + ' (IN LTRS)</td></tr></table>' +
                    '<h6 style="text-align:center;padding:3px 11px;background:var(--table-head-bg);color:var(--text-heading);">Final Analysis</h6>' +
                    '<table class="dynamic_table" style="width:100%">' +
                    '<tr><th>(C) Opening Stock</th><th>(D) Receipts</th><th>(E) Sales</th><th>(C+D-E) Equals to</th><th>Book Value</th></tr>' +
                    '<tr><td>' + resp.sum_of_opening + '</td><td>' + resp.total_recipt + '</td><td>' + resp.total_sales + '</td><td style="text-align:center;">=</td><td>' + resp.book_value + '</td></tr></table>' +
                    '<table class="dynamic_table" style="width:100%">' +
                    '<tr><th>(F) Physical Stock</th><th>(G) Book Stock</th><th>(F-G) Equals to</th><th>Variance</th></tr>' +
                    '<tr><td>' + resp.sum_of_closing + '</td><td>' + resp.book_value + '</td><td style="text-align:center;">=</td><td>' + resp.variance + '</td></tr></table>' +
                    '<table class="dynamic_table" style="width:100%"><tr><th class="w-1/2">Remarks</th><td class="w-1/2 justify-text">' + (resp.remark || '') + '</td></tr></table>' +
                    '<table class="dynamic_table" style="width:100%"><tr><th class="w-1/2">Shortage Claim for the period</th><td class="w-1/2 justify-text">' + (resp.shortage_claim || '') + '</td></tr></table>' +
                    '<table class="dynamic_table" style="width:100%"><tr><th class="w-1/2">Net Gain or Loss</th><td class="w-1/2">' + resp.variance + '</td></tr></table>' +
                    '<table class="dynamic_table" style="width:100%"><tr><th class="w-1/2">Variance as % of Sales</th><td class="w-1/2">' + resp.variance_of_sales + '</td></tr></table>' +
                    '<table class="dynamic_table" style="width:100%"><tr><th class="w-1/2">Average Daily sales</th><td class="w-1/2">' + parseFloat(resp.average_daily_sales).toFixed(2) + '</td></tr></table>' +
                    '</div>';

                $('#survey-container').append(html);
            });

            lazyLoadReconThumbnails();
            openSurveyModal();
        }

        // ============================================
        // Lazy-load thumbnails for recon images
        // ============================================
        function lazyLoadReconThumbnails() {
            $('#survey-container .file-thumb-box[data-nozzle-id]').each(function() {
                var $box = $(this);
                if ($box.data('loaded')) return;
                var nozel_id = $box.data('nozzle-id');
                var task_id = $box.data('task-id');

                fetch(API_BASE + "get/get_dealer_stock_recon_new_files.php?key=" + API_KEY +
                        "&nozel_id=" + nozel_id + "&task_id=" + task_id)
                    .then(function(response) { return response.json(); })
                    .then(function(result) {
                        if (result && result.length > 0 && result[0].file) {
                            var imageUrl = FILES_BASE + "uploads/" + result[0].file;
                            $box.data('image-url', imageUrl);
                            $box.data('loaded', true);
                            var $img = $('<img src="' + imageUrl + '" alt="preview" />');
                            $img.on('error', function() {
                                $(this).remove();
                                $box.find('.file-icon-fallback').show();
                            });
                            $img.on('load', function() {
                                $box.find('.file-icon-fallback').hide();
                            });
                            $box.prepend($img);
                        }
                    })
                    .catch(function(err) { console.log('thumb load error', err); });
            });
        }

        // ============================================
        // openReconImage()
        // ============================================
        function openReconImage(nozel_id, task_id) {
            var $box = $('#survey-container .file-thumb-box[data-nozzle-id="' + nozel_id + '"][data-task-id="' + task_id + '"]').first();
            var cachedUrl = $box.data('image-url');

            if (cachedUrl) {
                showImagePopup(cachedUrl);
                return;
            }

            fetch(API_BASE + "get/get_dealer_stock_recon_new_files.php?key=" + API_KEY +
                    "&nozel_id=" + nozel_id + "&task_id=" + task_id)
                .then(function(response) { return response.json(); })
                .then(function(result) {
                    if (result && result.length > 0) {
                        var imageUrl = FILES_BASE + "uploads/" + result[0].file;
                        $box.data('image-url', imageUrl);
                        showImagePopup(imageUrl);
                    } else {
                        showToast('No image found', 'error');
                    }
                })
                .catch(function(error) {
                    console.log('error', error);
                    showToast('Failed to load image', 'error');
                });
        }

        // ============================================
        // get_recon_pictures() — legacy
        // ============================================
        function get_recon_pictures(nozel_id, task_id) {
            openReconImage(nozel_id, task_id);
        }

        // ============================================================
        // PDF EXPORT — CORS-SAFE IMAGE HANDLING
        // ============================================================

        function blobToDataURL(blob) {
            return new Promise(function(resolve, reject) {
                var reader = new FileReader();
                reader.onload = function() { resolve(reader.result); };
                reader.onerror = reject;
                reader.readAsDataURL(blob);
            });
        }

        function urlToDataURL(url) {
            return new Promise(function(resolve) {
                if (!url || url.startsWith('data:')) {
                    resolve(url);
                    return;
                }

                fetch(url, { mode: 'cors', credentials: 'omit' })
                    .then(function(res) {
                        if (!res.ok) throw new Error('HTTP ' + res.status);
                        return res.blob();
                    })
                    .then(blobToDataURL)
                    .then(resolve)
                    .catch(function() {
                        tryImgElement();
                    });

                function tryImgElement() {
                    var img = new Image();
                    img.crossOrigin = 'anonymous';
                    img.onload = function() {
                        try {
                            var canvas = document.createElement('canvas');
                            canvas.width = img.naturalWidth || 1;
                            canvas.height = img.naturalHeight || 1;
                            var ctx = canvas.getContext('2d');
                            ctx.drawImage(img, 0, 0);
                            resolve(canvas.toDataURL('image/png'));
                        } catch (e) {
                            console.warn('Image CORS failed (skipped):', url);
                            resolve(null);
                        }
                    };
                    img.onerror = function() {
                        console.warn('Image load failed (skipped):', url);
                        resolve(null);
                    };
                    img.src = url;
                }
            });
        }

        function preloadAllImagesAsDataURL(container) {
            var promises = [];
            var processed = new WeakSet();

            var imgs = container.querySelectorAll('img');
            imgs.forEach(function(img) {
                if (processed.has(img)) return;
                processed.add(img);

                var src = img.getAttribute('src');
                if (!src || src.startsWith('data:')) return;

                img.setAttribute('data-original-src', src);

                var p = urlToDataURL(src).then(function(dataUrl) {
                    if (dataUrl) {
                        img.setAttribute('src', dataUrl);
                        img.removeAttribute('crossorigin');
                    } else {
                        img.setAttribute('data-failed', 'true');
                    }
                });
                promises.push(p);
            });

            return Promise.all(promises);
        }

        function waitForImages(container) {
            var promises = [];
            var imgs = container.querySelectorAll('img');
            imgs.forEach(function(img) {
                if (img.complete && img.naturalWidth > 0) return;
                var p = new Promise(function(resolve) {
                    img.addEventListener('load', resolve, { once: true });
                    img.addEventListener('error', resolve, { once: true });
                });
                promises.push(p);
            });
            return Promise.all(promises);
        }

        function getPDF() {
            var currentDate = new Date();
            var formattedDate = currentDate.toLocaleString().replace(/[/:, ]/g, '-');
            var element = document.getElementById('exporting');

            var reportLabel = ($('#labelc').text() || 'Report').trim().replace(/\s+/g, '-');
            var filename = reportLabel + '-Result-' + formattedDate + '.pdf';

            var $btn = $('#exportBtn');
            $btn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin mr-1"></i> Preparing images...');

            element.classList.add('pdf-export-mode');

            preloadAllImagesAsDataURL(element)
                .then(function() {
                    return waitForImages(element);
                })
                .then(function() {
                    return new Promise(function(r) { setTimeout(r, 300); });
                })
                .then(function() {
                    $btn.html('<i class="fa-solid fa-spinner fa-spin mr-1"></i> Generating PDF...');

                    var opt = {
                        margin: [10, 8, 10, 8],
                        filename: filename,
                        image: { type: 'jpeg', quality: 0.98 },
                        html2canvas: {
                            scale: 2,
                            useCORS: true,
                            allowTaint: false,
                            logging: false,
                            backgroundColor: '#ffffff',
                            windowWidth: element.scrollWidth,
                            scrollX: 0,
                            scrollY: 0,
                            imageTimeout: 30000
                        },
                        jsPDF: { unit: 'mm', format: 'a4', orientation: 'landscape' },
                        pagebreak: {
                            mode: ['css', 'legacy'],
                            avoid: ['tr', 'table', 'h6', '.dynamic_table']
                        }
                    };

                    return html2pdf().set(opt).from(element).save();
                })
                .then(function() {
                    element.classList.remove('pdf-export-mode');
                    $btn.prop('disabled', false).html('<i class="fa-solid fa-file-pdf mr-1"></i> Export to PDF');
                    showToast('PDF generated successfully!', 'success');
                })
                .catch(function(error) {
                    element.classList.remove('pdf-export-mode');
                    console.error('PDF Export Error:', error);
                    showToast('Failed to generate PDF.', 'error');
                    $btn.prop('disabled', false).html('<i class="fa-solid fa-file-pdf mr-1"></i> Export to PDF');
                });
        }

        $(document).on('click', '#exportBtn', function() {
            getPDF();
        });
    </script>

</body>
</html>