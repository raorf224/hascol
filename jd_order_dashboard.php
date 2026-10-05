<?php
// Hascol OMC Operations Command Center - JD Order Dashboard
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hascol OMC - JD Order Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

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

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Select2 CSS & JS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <script>
        (function() {
            const isDarkMode = localStorage.getItem('darkMode') === 'true';
            if (isDarkMode) {
                document.documentElement.classList.add('dark-mode');
            } else {
                document.documentElement.classList.remove('dark-mode');
            }
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
            --toolbar-btn-bg: #ffffff;
            --dropdown-bg: #ffffff;
            --dropdown-hover: #f1f5f9;
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
            --toolbar-btn-bg: #060b13;
            --dropdown-bg: #0d1520;
            --dropdown-hover: #1a2635;
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

        #sidebar.collapsed {
            width: 60px;
        }

        #sidebar.collapsed .sidebar-text { display: none; }
        #sidebar.collapsed .p-4 { padding: 12px 8px; }
        #sidebar.collapsed nav a { justify-content: center; padding: 8px 4px; }
        #sidebar.collapsed nav a i { font-size: 1.1rem; margin: 0; }
        #sidebar.collapsed .p-3 .sidebar-text { display: none; }
        #sidebar.collapsed .p-3 .flex.items-center { justify-content: center; }
        #sidebar.collapsed .p-3 img { width: 32px; height: 32px; }

        #sidebar, #mainContent { transition: all 0.3s ease-in-out; }

        .table-container { overflow-x: auto; }
        .table-container table { width: 100% !important; border-collapse: collapse; font-size: 10px; }
        .table-container table thead th {
            background-color: var(--table-head-bg) !important;
            color: var(--table-head-text) !important;
            /* font-weight: 500; */
            text-align: left;
            padding: 8px 10px;
            border-bottom: 1px solid var(--border-color);
            white-space: nowrap;
            /* font-size: 9px; */
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        .table-container table tbody td {
            padding: 8px 10px;
            border-bottom: 1px solid var(--border-color);
            color: var(--table-row-text);
            vertical-align: middle;
        }
        .table-container table tbody tr:hover { background-color: var(--table-row-hover); }

        .badge-status {
            padding: 2px 8px;
            border-radius: 9999px;
            font-size: 8px;
            font-weight: 600;
            display: inline-block;
        }
        .badge-status.pending {
            background: #f59e0b20;
            color: #f59e0b;
            border: 1px solid #f59e0b40;
        }
        .badge-status.start {
            background: #3b82f620;
            color: #3b82f6;
            border: 1px solid #3b82f640;
        }
        .badge-status.complete {
            background: #10b98120;
            color: #10b981;
            border: 1px solid #10b98140;
        }

        .badge-shortage {
            padding: 2px 8px;
            border-radius: 9999px;
            font-size: 8px;
            font-weight: 600;
            display: inline-block;
        }
        .badge-shortage.yes {
            background: #ef444420;
            color: #ef4444;
            border: 1px solid #ef444440;
        }
        .badge-shortage.no {
            background: #10b98120;
            color: #10b981;
            border: 1px solid #10b98140;
        }

        .badge-tracker {
            padding: 2px 8px;
            border-radius: 9999px;
            font-size: 8px;
            font-weight: 600;
            display: inline-block;
        }
        .badge-tracker.with-tracker {
            background: #10b98120;
            color: #10b981;
            border: 1px solid #10b98140;
        }
        .badge-tracker.without-tracker {
            background: #ef444420;
            color: #ef4444;
            border: 1px solid #ef444440;
        }

        .stat-card {
            background-color: var(--bg-panel);
            border: 1px solid var(--border-color);
            border-radius: 0.375rem;
            padding: 14px;
            transition: background-color .25s ease, border-color .25s ease;
            cursor: pointer;
        }
        .stat-card:hover {
            border-color: #1d4ed8;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(29, 78, 216, 0.1);
        }
        .stat-card .stat-icon {
            width: 32px;
            height: 32px;
            border-radius: 0.375rem;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #1d4ed820;
            color: #1d4ed8;
        }
        .stat-card .stat-value {
            font-size: 18px;
            font-weight: 600;
            color: var(--text-heading);
        }
        .stat-card .stat-label {
            font-size: 9px;
            color: var(--text-muted);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

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

        .form-label {
            color: var(--text-muted);
            font-size: 10px;
            font-weight: 500;
            margin-bottom: 4px;
            display: block;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-get {
            background-color: #1d4ed8;
            color: #ffffff;
            padding: 8px 24px;
            border-radius: 0.25rem;
            border: none;
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s;
            height: 36px;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .btn-get:hover { background-color: #2563eb; }

        .filter-section {
            background-color: var(--bg-panel);
            border: 1px solid var(--border-color);
            border-radius: 0.375rem;
            padding: 16px;
            transition: background-color .25s ease, border-color .25s ease;
        }

        .filter-container {
            display: flex;
            flex-wrap: wrap;
            align-items: flex-end;
            gap: 16px;
        }

        .filter-item {
            flex: 0 0 auto;
            min-width: 180px;
        }
        .filter-item:last-child { min-width: auto; }

        @media (max-width: 768px) {
            .filter-item { width: 100% !important; min-width: unset !important; }
            .stat-card .stat-value { font-size: 14px; }
        }

        .dataTables_wrapper .dataTables_filter { display: none !important; }
        .dataTables_wrapper .dataTables_length { display: none !important; }
        .dataTables_wrapper .dataTables_info {
            color: var(--text-muted) !important;
            font-size: 11px !important;
            padding-top: 12px !important;
        }
        /* .dataTables_wrapper .dataTables_paginate { padding-top: 12px !important; }
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
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #1d4ed8 !important;
            color: #ffffff !important;
            border-color: #1d4ed8 !important;
        } */

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
            height: 30px !important;
            box-sizing: border-box !important;
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
            padding: 6px 10px;
            font-size: 12px;
            outline: none;
            height: 30px;
            box-sizing: border-box;
        }
        .search-input::placeholder { color: var(--text-muted); }
        .search-input:focus {
            border-color: #1d4ed8;
            box-shadow: 0 0 0 2px rgba(29, 78, 216, 0.2);
        }

        .toast {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: var(--bg-panel);
            border: 1px solid var(--border-color);
            border-radius: 0.375rem;
            padding: 12px 20px;
            color: var(--text-body);
            font-size: 12px;
            z-index: 9999;
            transform: translateY(100px);
            opacity: 0;
            transition: all 0.3s ease-in-out;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
        }
        .toast.show { transform: translateY(0); opacity: 1; }
        .toast.success { border-color: #10b981; }
        .toast.success i { color: #10b981; }
        .toast.error { border-color: #ef4444; }
        .toast.error i { color: #ef4444; }

        .toolbar-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            flex-wrap: nowrap;
            width: 100%;
        }
        .toolbar-left {
            display: flex;
            align-items: center;
            gap: 6px;
            flex-wrap: wrap;
            min-width: 0;
        }
        .toolbar-right {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: nowrap;
            flex-shrink: 0;
        }
        @media (max-width: 1024px) {
            .toolbar-row { flex-wrap: wrap; }
            .toolbar-right { flex-wrap: wrap; }
        }

        .column-visibility-dropdown {
            position: relative;
            display: inline-block;
            flex-shrink: 0;
        }
        .column-visibility-dropdown .dropdown-btn {
            background-color: var(--toolbar-btn-bg);
            border: 1px solid var(--border-color);
            border-radius: 0.25rem;
            color: var(--text-muted);
            padding: 6px 12px;
            font-size: 10px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s;
            font-family: 'Inter', sans-serif;
            min-width: 95px;
            justify-content: center;
            height: 30px;
            box-sizing: border-box;
            white-space: nowrap;
        }
        .column-visibility-dropdown .dropdown-btn:hover {
            background-color: var(--hover-bg);
            color: var(--text-heading);
        }
        .column-visibility-dropdown .dropdown-menu {
            position: absolute;
            top: calc(100% + 4px);
            left: 0;
            min-width: 210px;
            background-color: var(--dropdown-bg);
            border: 1px solid var(--border-color);
            border-radius: 0.375rem;
            padding: 6px 0;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
            z-index: 100;
            display: none;
            max-height: 380px;
            overflow-y: auto;
        }
        .column-visibility-dropdown .dropdown-menu.show { display: block; }
        .column-visibility-dropdown .dropdown-menu .dropdown-header {
            padding: 6px 14px 8px 14px;
            font-size: 9px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-muted);
            border-bottom: 1px solid var(--border-color);
        }
        .column-visibility-dropdown .dropdown-menu .dropdown-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 6px 14px;
            cursor: pointer;
            transition: background-color 0.15s;
            font-size: 11px;
            color: var(--text-body);
        }
        .column-visibility-dropdown .dropdown-menu .dropdown-item:hover {
            background-color: var(--dropdown-hover);
        }
        .column-visibility-dropdown .dropdown-menu .dropdown-item input[type="checkbox"] {
            width: 14px;
            height: 14px;
            cursor: pointer;
            accent-color: #1d4ed8;
            flex-shrink: 0;
        }
        .column-visibility-dropdown .dropdown-menu .dropdown-divider {
            height: 1px;
            background-color: var(--border-color);
            margin: 4px 8px;
        }
        .column-visibility-dropdown .dropdown-menu .dropdown-actions {
            display: flex;
            gap: 6px;
            padding: 6px 14px 4px 14px;
            border-top: 1px solid var(--border-color);
            margin-top: 4px;
            padding-top: 8px;
        }
        .column-visibility-dropdown .dropdown-menu .dropdown-actions button {
            flex: 1;
            padding: 4px 8px;
            border-radius: 0.25rem;
            border: 1px solid var(--border-color);
            background: var(--toolbar-btn-bg);
            color: var(--text-muted);
            font-size: 9px;
            cursor: pointer;
            transition: all 0.2s;
            font-family: 'Inter', sans-serif;
            white-space: nowrap;
        }
        .column-visibility-dropdown .dropdown-menu .dropdown-actions button:hover {
            background: var(--hover-bg);
            color: var(--text-heading);
        }
        .column-visibility-dropdown .dropdown-menu::-webkit-scrollbar { width: 4px; }
        .column-visibility-dropdown .dropdown-menu::-webkit-scrollbar-track { background: var(--scrollbar-track); }
        .column-visibility-dropdown .dropdown-menu::-webkit-scrollbar-thumb {
            background: var(--scrollbar-thumb);
            border-radius: 4px;
        }

        .modal-overlay {
            position: fixed;
            inset: 0;
            background: var(--modal-overlay);
            backdrop-filter: blur(4px);
            z-index: 50;
            display: none;
            align-items: center;
            justify-content: center;
        }
        .modal-overlay.active { display: flex; }

        .modal-content {
            background-color: var(--bg-panel);
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35);
            max-width: 95vw;
            max-height: 90vh;
            overflow: hidden;
            width: 1200px;
        }
        .modal-content .modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 20px;
            border-bottom: 1px solid var(--border-color);
            flex-shrink: 0;
        }
        .modal-content .modal-header h3 {
            color: var(--text-heading);
            font-weight: 600;
            font-size: 14px;
        }
        .modal-content .modal-header button {
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            font-size: 20px;
            transition: color 0.2s;
        }
        .modal-content .modal-header button:hover { color: #ef4444; }

        .modal-content .modal-body {
            padding: 20px;
            overflow-y: auto;
            max-height: 70vh;
        }

        .modal-table-container { overflow-x: auto; }
        .modal-table-container table { width: 100%; border-collapse: collapse; font-size: 10px; }
        .modal-table-container table thead th {
            background-color: var(--table-head-bg);
            color: var(--table-head-text);
            padding: 8px 10px;
            border-bottom: 1px solid var(--border-color);
            text-align: left;
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            white-space: nowrap;
        }
        .modal-table-container table tbody td {
            padding: 6px 10px;
            border-bottom: 1px solid var(--border-color);
            color: var(--table-row-text);
        }

        .action-btn {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 10px;
            cursor: pointer;
            transition: all 0.2s;
            border: none;
            background: transparent;
            color: var(--text-muted);
        }
        .action-btn:hover {
            background: var(--hover-bg);
            color: var(--text-heading);
        }
        .action-btn.view:hover {
            background: #3b82f620;
            color: #3b82f6;
        }

        .chart-container {
            background-color: var(--bg-panel);
            border: 1px solid var(--border-color);
            border-radius: 0.375rem;
            padding: 16px;
            transition: background-color .25s ease, border-color .25s ease;
            height: 320px;
            position: relative;
        }

        .station-list {
            max-height: 320px;
            overflow-y: auto;
        }
        .station-list::-webkit-scrollbar { width: 4px; }
        .station-list::-webkit-scrollbar-track { background: var(--scrollbar-track); }
        .station-list::-webkit-scrollbar-thumb { background: var(--scrollbar-thumb); border-radius: 4px; }

        .station-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 6px 0;
            border-bottom: 1px solid var(--border-color);
            cursor: pointer;
            transition: background-color 0.15s;
        }
        .station-item:hover { background-color: var(--hover-bg); }
        .station-item .station-name { font-size: 11px; color: var(--text-body); flex: 1; }
        .station-item .station-count {
            font-size: 11px;
            font-weight: 600;
            color: var(--text-heading);
            background: var(--hover-bg);
            padding: 2px 10px;
            border-radius: 9999px;
        }

        #loader { display: none; text-align: center; padding: 20px; color: var(--text-muted); font-size: 12px; }

        /* Select2 Custom Styles */
        .select2-container--default .select2-selection--multiple {
            background-color: var(--input-bg) !important;
            border: 1px solid var(--border-color) !important;
            border-radius: 0.25rem !important;
            min-height: 36px !important;
            padding: 2px 4px !important;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: var(--hover-bg) !important;
            border: 1px solid var(--border-color) !important;
            border-radius: 0.25rem !important;
            color: var(--text-body) !important;
            font-size: 10px !important;
            padding: 2px 8px !important;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: #ef4444 !important;
            font-size: 12px !important;
            margin-right: 4px !important;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
            color: #dc2626 !important;
        }
        .select2-dropdown {
            background-color: var(--bg-panel) !important;
            border: 1px solid var(--border-color) !important;
            border-radius: 0.25rem !important;
        }
        .select2-container--default .select2-search--dropdown .select2-search__field {
            background-color: var(--input-bg) !important;
            border: 1px solid var(--border-color) !important;
            border-radius: 0.25rem !important;
            color: var(--text-body) !important;
            padding: 4px 8px !important;
            font-size: 11px !important;
        }
        .select2-container--default .select2-results__option {
            color: var(--text-body) !important;
            font-size: 11px !important;
            padding: 6px 10px !important;
        }
        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: var(--hover-bg) !important;
            color: var(--text-heading) !important;
        }
        .select2-container--default .select2-results__option[aria-selected=true] {
            background-color: #1d4ed820 !important;
            color: var(--text-heading) !important;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__placeholder {
            color: var(--text-muted) !important;
            font-size: 11px !important;
        }
        html.dark-mode .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #1a2635 !important;
            color: #e5e7eb !important;
        }
        html.dark-mode .select2-dropdown { background-color: #0d1520 !important; }
        html.dark-mode .select2-container--default .select2-search--dropdown .select2-search__field {
            background-color: #060b13 !important;
            color: #e5e7eb !important;
        }
        html.dark-mode .select2-container--default .select2-results__option { color: #94a3b8 !important; }
        html.dark-mode .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #1a2635 !important;
            color: #ffffff !important;
        }
    </style>
</head>

<body class="flex h-screen overflow-hidden text-xs">

    <?php include 'includes/sidebar.php'; ?>

    <main id="mainContent" class="flex-1 flex flex-col overflow-hidden">

        <?php include 'includes/topbar.php'; ?>

        <div class="flex-1 overflow-y-auto p-4" id="pageContent">

            <div class="flex justify-between items-center mb-4">
                <div>
                    <h2 class="text-heading font-semibold text-base tracking-wide uppercase">JD Order Dashboard</h2>
                    <p class="text-[10px] text-gray-500">Monitor and manage JD orders in real-time</p>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="filter-section mb-4">
                <div class="filter-container">
                    <div class="filter-item">
                        <label class="form-label">From</label>
                        <input type="date" id="fromDate" class="form-input" value="<?php echo date('Y-m-d', strtotime('first day of this month')); ?>">
                    </div>
                    <div class="filter-item">
                        <label class="form-label">To</label>
                        <input type="date" id="toDate" class="form-input" value="<?php echo date('Y-m-d', strtotime('last day of this month')); ?>">
                    </div>
                    <div class="filter-item" style="min-width: 250px;">
                        <label class="form-label">Select Stations</label>
                        <select id="stationFilter" class="form-input" multiple="multiple" style="width: 100%;">
                        </select>
                    </div>
                    <div class="filter-item">
                        <button class="btn-get" onclick="fetchDashboardData()">
                            <i class="fa-solid fa-arrow-right"></i> Get
                        </button>
                    </div>
                </div>
            </div>

            <!-- Stats Cards - 10 Cards -->
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3 mb-4">
                <div class="stat-card">
                    <div class="flex items-center gap-3">
                        <div class="stat-icon"><i class="fa-solid fa-truck-fast text-lg"></i></div>
                        <div>
                            <div class="stat-value" id="totalOrders">0</div>
                            <div class="stat-label">Total Orders</div>
                        </div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="flex items-center gap-3">
                        <div class="stat-icon" style="background: #3b82f620; color: #3b82f6;"><i class="fa-solid fa-file-invoice text-lg"></i></div>
                        <div>
                            <div class="stat-value" id="invoiceOrders">0</div>
                            <div class="stat-label">Invoices</div>
                        </div>
                    </div>
                </div>
                <div class="stat-card" onclick="filterTableByStatus('Dispatch Order Invoices Not Dispatched')">
                    <div class="flex items-center gap-3">
                        <div class="stat-icon" style="background: #f59e0b20; color: #f59e0b;"><i class="fa-solid fa-clock text-lg"></i></div>
                        <div>
                            <div class="stat-value" id="notDispatched">0</div>
                            <div class="stat-label">Not Dispatched</div>
                        </div>
                    </div>
                </div>
                <div class="stat-card" onclick="filterTableByStatus('Shortage Submitted')">
                    <div class="flex items-center gap-3">
                        <div class="stat-icon" style="background: #10b98120; color: #10b981;"><i class="fa-solid fa-check-circle text-lg"></i></div>
                        <div>
                            <div class="stat-value" id="shortageSubmitted">0</div>
                            <div class="stat-label">Shortage Submitted</div>
                        </div>
                    </div>
                </div>
                <div class="stat-card" onclick="filterTableByStatus('Shortage Not Submit')">
                    <div class="flex items-center gap-3">
                        <div class="stat-icon" style="background: #ef444420; color: #ef4444;"><i class="fa-solid fa-exclamation-triangle text-lg"></i></div>
                        <div>
                            <div class="stat-value" id="shortageNotSubmit">0</div>
                            <div class="stat-label">Shortage Not Submit</div>
                        </div>
                    </div>
                </div>
                <div class="stat-card" onclick="filterTableByStatus('Complete')">
                    <div class="flex items-center gap-3">
                        <div class="stat-icon" style="background: #10b98120; color: #10b981;"><i class="fa-solid fa-flag-checkered text-lg"></i></div>
                        <div>
                            <div class="stat-value" id="completedOrders">0</div>
                            <div class="stat-label">Complete Trips</div>
                        </div>
                    </div>
                </div>
                <div class="stat-card" onclick="filterTableByStatus('Start')">
                    <div class="flex items-center gap-3">
                        <div class="stat-icon" style="background: #3b82f620; color: #3b82f6;"><i class="fa-solid fa-play text-lg"></i></div>
                        <div>
                            <div class="stat-value" id="startOrders">0</div>
                            <div class="stat-label">Start Trips</div>
                        </div>
                    </div>
                </div>
                <div class="stat-card" onclick="filterTableByStatus('Pending')">
                    <div class="flex items-center gap-3">
                        <div class="stat-icon" style="background: #f59e0b20; color: #f59e0b;"><i class="fa-solid fa-hourglass-half text-lg"></i></div>
                        <div>
                            <div class="stat-value" id="pendingOrders">0</div>
                            <div class="stat-label">Pending Trips</div>
                        </div>
                    </div>
                </div>
                <div class="stat-card" onclick="filterTableByStatus('With-Tracker')">
                    <div class="flex items-center gap-3">
                        <div class="stat-icon" style="background: #10b98120; color: #10b981;"><i class="fa-solid fa-satellite-dish text-lg"></i></div>
                        <div>
                            <div class="stat-value" id="withTracker">0</div>
                            <div class="stat-label">With Tracker</div>
                        </div>
                    </div>
                </div>
                <div class="stat-card" onclick="filterTableByStatus('Without-Tracker')">
                    <div class="flex items-center gap-3">
                        <div class="stat-icon" style="background: #ef444420; color: #ef4444;"><i class="fa-solid fa-satellite text-lg"></i></div>
                        <div>
                            <div class="stat-value" id="withoutTracker">0</div>
                            <div class="stat-label">Without Tracker</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chart & Station List Row -->
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-4 mb-4">
                <div class="lg:col-span-3">
                    <div class="chart-container">
                        <canvas id="dashboardChart"></canvas>
                    </div>
                </div>
                <div class="panel-card p-3">
                    <h5 class="text-heading font-semibold text-sm mb-2">
                        <i class="fa-solid fa-store mr-2 text-blue-500"></i> No Stations Order
                    </h5>
                    <div class="station-list" id="stationList">
                        <div class="text-center py-4 text-gray-500 text-xs">Loading stations...</div>
                    </div>
                </div>
            </div>

            <!-- Toolbar -->
            <div class="panel-card p-3 mb-4">
                <div class="toolbar-row">
                    <div class="toolbar-left" id="exportButtonsContainer"></div>
                    <div class="toolbar-right">
                        <div class="column-visibility-dropdown" id="columnVisibilityDropdown">
                            <button class="dropdown-btn" onclick="toggleColumnDropdown()">
                                <i class="fa-regular fa-eye"></i> Columns
                                <i class="fa-solid fa-chevron-down text-[8px]"></i>
                            </button>
                            <div class="dropdown-menu" id="columnDropdownMenu">
                                <div class="dropdown-header"><i class="fa-regular fa-eye mr-1"></i> Column Visibility</div>
                                <div id="columnListItems"></div>
                                <div class="dropdown-divider"></div>
                                <div class="dropdown-actions">
                                    <button class="select-all-btn" onclick="selectAllColumns()">
                                        <i class="fa-regular fa-check-circle mr-1"></i> All Selected
                                    </button>
                                    <button class="deselect-all-btn" onclick="deselectAllColumns()">
                                        <i class="fa-regular fa-circle mr-1"></i> De-Selected
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-magnifying-glass text-gray-500 text-xs"></i>
                            <input type="text" id="customSearchInput" placeholder="Search orders..." class="search-input" style="width: 200px;">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Orders Table (Action Column Removed) -->
            <div class="panel-card overflow-hidden">
                <div class="table-container">
                    <div id="loader"><i class="fa-solid fa-spinner fa-spin mr-2"></i> Loading data...</div>
                    <table id="ordersTable" class="display" style="width:100%;">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Date</th>
                                <th>Site Name</th>
                                <th>JD Code</th>
                                <th>Material</th>
                                <th>Vehicle</th>
                                <th>Tracker Status</th>
                                <th>Order #</th>
                                <th>Invoice #</th>
                                <th>Qty</th>
                                <th>Rate</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Driver Sign</th>
                                <th>Shortage</th>
                                <th>Distance</th>
                                <th>Rem. Dist.</th>
                                <th>Active Time</th>
                                <th>ETA</th>
                                <th>Close Time</th>
                            </tr>
                        </thead>
                        <tbody id="ordersTableBody">
                            <tr>
                                <td colspan="20" class="text-center py-8 text-gray-500">
                                    <i class="fa-solid fa-spinner fa-spin text-blue-400 mr-2"></i>
                                    Loading orders...
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>

    <!-- Toast Notification -->
    <div id="toast" class="toast">
        <i class="fa-solid fa-check-circle mr-2"></i>
        <span id="toastMessage">Data exported successfully!</span>
    </div>

    <script>
        function toggleDarkMode() {
            const html = document.documentElement;
            const isDark = html.classList.toggle('dark-mode');
            localStorage.setItem('darkMode', isDark);
            const icon = document.querySelector('.dark-mode-toggle i');
            if (icon) {
                icon.className = isDark ? 'fa-solid fa-sun' : 'fa-solid fa-moon';
            }
        }

        const API_BASE_URL = 'api/get/';
        const API_KEY = '03201232927';

        let ordersData = [];
        let filteredData = [];
        let dataTable = null;
        let chartInstance = null;

        const columnConfig = [
            { idx: 0, label: 'S.No' },
            { idx: 1, label: 'Date' },
            { idx: 2, label: 'Site Name' },
            { idx: 3, label: 'JD Code' },
            { idx: 4, label: 'Material' },
            { idx: 5, label: 'Vehicle' },
            { idx: 6, label: 'Tracker Status' },
            { idx: 7, label: 'Order #' },
            { idx: 8, label: 'Invoice #' },
            { idx: 9, label: 'Qty' },
            { idx: 10, label: 'Rate' },
            { idx: 11, label: 'Amount' },
            { idx: 12, label: 'Status' },
            { idx: 13, label: 'Driver Sign' },
            { idx: 14, label: 'Shortage' },
            { idx: 15, label: 'Distance' },
            { idx: 16, label: 'Rem. Dist.' },
            { idx: 17, label: 'Active Time' },
            { idx: 18, label: 'ETA' },
            { idx: 19, label: 'Close Time' }
        ];

        $(document).ready(function() {
            $('#sidebarToggle').on('click', function() {
                $('#sidebar').toggleClass('collapsed');
                localStorage.setItem('sidebarCollapsed', $('#sidebar').hasClass('collapsed'));
            });

            if (localStorage.getItem('sidebarCollapsed') === 'true') {
                $('#sidebar').addClass('collapsed');
            }

            $('#stationFilter').select2({
                placeholder: 'All Stations',
                allowClear: true,
                width: '100%'
            });

            $('#stationFilter').on('change', function() {
                applyStationFilter();
            });

            $('#customSearchInput').on('keyup', function() {
                if ($.fn.DataTable.isDataTable('#ordersTable')) {
                    $('#ordersTable').DataTable().search($(this).val()).draw();
                }
            });

            $(document).on('click', function(e) {
                if (!$(e.target).closest('.column-visibility-dropdown').length) {
                    closeColumnDropdown();
                }
            });

            $(document).on('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeColumnDropdown();
                }
            });

            const isDarkMode = localStorage.getItem('darkMode') === 'true';
            const icon = document.querySelector('.dark-mode-toggle i');
            if (icon) {
                icon.className = isDarkMode ? 'fa-solid fa-sun' : 'fa-solid fa-moon';
            }

            fetchDashboardData();
        });

        function showToast(message, type) {
            const toast = $('#toast');
            const toastMessage = $('#toastMessage');
            toast.removeClass('success error');
            toast.addClass(type);
            toastMessage.text(message);
            toast.addClass('show');
            clearTimeout(window.toastTimeout);
            window.toastTimeout = setTimeout(() => {
                toast.removeClass('show');
            }, 3000);
        }

        function fetchDashboardData() {
            const fromDate = $('#fromDate').val();
            const toDate = $('#toDate').val();

            if (!fromDate || !toDate) {
                showToast('Please select both From and To dates.', 'error');
                return;
            }

            const url = API_BASE_URL + '/get_all_jd_dispatches.php?key=' + API_KEY + '&pre=Admin&user_id=1&from=' + fromDate +
                '&to=' + toDate + '&rettype=CO';

            $('#ordersTableBody').html(`
                <tr>
                    <td colspan="20" class="text-center py-8 text-gray-500">
                        <i class="fa-solid fa-spinner fa-spin text-blue-400 mr-2"></i>
                        Loading orders...
                    </td>
                </tr>
            `);

            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                timeout: 60000,
                success: function(response) {
                    console.log('API Response:', response);
                    if (response && Array.isArray(response)) {
                        ordersData = response;
                        populateStationDropdown(response);
                        filteredData = response;
                        updateAll(response);
                    } else {
                        ordersData = [];
                        filteredData = [];
                        updateAll([]);
                        showToast('No orders found for selected dates.', 'error');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('API Error:', status, error);
                    ordersData = [];
                    filteredData = [];
                    updateAll([]);
                    showToast('Failed to load orders. Please try again.', 'error');
                }
            });
        }

        function populateStationDropdown(data) {
            const select = $('#stationFilter');
            select.empty();

            const stationSet = new Set();
            $.each(data, function(index, item) {
                const name = item.name || 'Unknown';
                if (name !== 'Unknown' && name !== '---') {
                    stationSet.add(name);
                }
            });

            const sortedStations = Array.from(stationSet).sort();
            $.each(sortedStations, function(index, station) {
                select.append($('<option>', {
                    value: station,
                    text: station
                }));
            });

            select.trigger('change');
        }

        function applyStationFilter() {
            const selectedStations = $('#stationFilter').val();

            if (!selectedStations || selectedStations.length === 0) {
                filteredData = ordersData;
            } else {
                filteredData = ordersData.filter(function(item) {
                    const name = item.name || '';
                    return selectedStations.includes(name);
                });
            }

            updateAll(filteredData);
        }

        function updateAll(data) {
            updateStats(data);
            updateStations(data);
            updateChart(data);
            initializeDataTable(data);
        }

        function updateStats(data) {
            let total = data.length || 0;
            let completed = 0,
                start = 0,
                pending = 0;
            let withTracker = 0,
                withoutTracker = 0;
            let invoiceOrders = 0,
                notDispatched = 0;
            let shortageSubmitted = 0,
                shortageNotSubmit = 0;

            $.each(data, function(index, item) {
                const status = item.current_status || '';
                if (status === 'Complete') completed++;
                else if (status === 'Start') start++;
                else if (status === 'Pending') pending++;

                const trackerStatus = item.tracker_status || '';
                if (trackerStatus === 'With-Tracker') withTracker++;
                else if (trackerStatus === 'Without-Tracker') withoutTracker++;

                if (item.sub_id != null) invoiceOrders++;
                else notDispatched++;

                const shortage = item.is_shortage || '';
                if (shortage === 'Shortage Submitted') shortageSubmitted++;
                else if (shortage === 'Shortage Not Submit') shortageNotSubmit++;
            });

            $('#totalOrders').text(total.toLocaleString());
            $('#invoiceOrders').text(invoiceOrders.toLocaleString());
            $('#notDispatched').text(notDispatched.toLocaleString());
            $('#shortageSubmitted').text(shortageSubmitted.toLocaleString());
            $('#shortageNotSubmit').text(shortageNotSubmit.toLocaleString());
            $('#completedOrders').text(completed.toLocaleString());
            $('#startOrders').text(start.toLocaleString());
            $('#pendingOrders').text(pending.toLocaleString());
            $('#withTracker').text(withTracker.toLocaleString());
            $('#withoutTracker').text(withoutTracker.toLocaleString());
        }

        function updateStations(data) {
            const container = $('#stationList');
            container.empty();

            if (!data || data.length === 0) {
                container.html('<div class="text-center py-4 text-gray-500 text-xs">No stations data available</div>');
                return;
            }

            const stationCount = {};
            $.each(data, function(index, item) {
                const name = item.name || 'Unknown';
                if (!stationCount[name]) {
                    stationCount[name] = 0;
                }
                stationCount[name]++;
            });

            const sortedStations = Object.entries(stationCount)
                .sort((a, b) => b[1] - a[1])
                .slice(0, 15);

            if (sortedStations.length === 0) {
                container.html('<div class="text-center py-4 text-gray-500 text-xs">No stations data available</div>');
                return;
            }

            $.each(sortedStations, function(index, station) {
                const row = `
                    <div class="station-item" onclick="filterTableByStation('${station[0]}')">
                        <span class="station-name">${station[0]}</span>
                        <span class="station-count">${station[1]}</span>
                    </div>
                `;
                container.append(row);
            });
        }

        function updateChart(data) {
            const canvas = document.getElementById('dashboardChart');
            const ctx = canvas.getContext('2d');

            let total = data.length || 0;
            let invoiceOrders = 0,
                notDispatched = 0;
            let shortageSubmitted = 0,
                shortageNotSubmit = 0;
            let completed = 0;

            $.each(data, function(index, item) {
                if (item.sub_id != null) invoiceOrders++;
                else notDispatched++;

                const shortage = item.is_shortage || '';
                if (shortage === 'Shortage Submitted') shortageSubmitted++;
                else if (shortage === 'Shortage Not Submit') shortageNotSubmit++;

                const status = item.current_status || '';
                if (status === 'Complete') completed++;
            });

            const isDark = localStorage.getItem('darkMode') === 'true';
            const textColor = isDark ? '#94a3b8' : '#64748b';
            const headingColor = isDark ? '#ffffff' : '#0f2440';
            const panelColor = isDark ? '#0d1520' : '#ffffff';
            const tooltipBg = isDark ? '#0a121c' : '#ffffff';
            const tooltipBorder = isDark ? '#1a2635' : '#e2e8f0';

            if (chartInstance) {
                chartInstance.destroy();
            }

            const chartLabels = ['Invoices', 'Not Dispatched', 'Shortage Submitted', 'Shortage Not Submit', 'Complete Trips'];
            const chartValues = [invoiceOrders, notDispatched, shortageSubmitted, shortageNotSubmit, completed];
            const chartColors = ['#3b82f6', '#f59e0b', '#10b981', '#ef4444', '#8b5cf6'];

            const centerTextPlugin = {
                id: 'centerText',
                beforeDraw: function(chart) {
                    const { ctx, chartArea } = chart;
                    if (!chartArea) return;
                    const { left, right, top, bottom } = chartArea;
                    const centerX = (left + right) / 2;
                    const centerY = (top + bottom) / 2;
                    ctx.save();
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'middle';
                    ctx.font = '600 20px Inter, sans-serif';
                    ctx.fillStyle = headingColor;
                    ctx.fillText(total.toLocaleString(), centerX, centerY - 8);
                    ctx.font = '600 8px Inter, sans-serif';
                    ctx.fillStyle = textColor;
                    ctx.fillText('TOTAL ORDERS', centerX, centerY + 10);
                    ctx.restore();
                }
            };

            chartInstance = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: chartLabels,
                    datasets: [{
                        data: chartValues,
                        backgroundColor: chartColors,
                        borderColor: panelColor,
                        borderWidth: 3,
                        hoverOffset: 8,
                        hoverBorderWidth: 3,
                        borderRadius: 4,
                        spacing: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '70%',
                    layout: { padding: 4 },
                    plugins: {
                        legend: {
                            position: 'right',
                            labels: {
                                color: textColor,
                                font: { size: 10, family: 'Inter' },
                                usePointStyle: true,
                                pointStyle: 'circle',
                                padding: 12,
                                boxWidth: 8,
                                boxHeight: 8
                            }
                        },
                        tooltip: {
                            backgroundColor: tooltipBg,
                            titleColor: headingColor,
                            bodyColor: textColor,
                            borderColor: tooltipBorder,
                            borderWidth: 1,
                            padding: 10,
                            titleFont: { size: 11, family: 'Inter', weight: '600' },
                            bodyFont: { size: 10, family: 'Inter' },
                            callbacks: {
                                label: function(context) {
                                    const value = context.raw || 0;
                                    const pct = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                    return ' ' + context.label + ': ' + value.toLocaleString() + ' (' + pct + '%)';
                                }
                            }
                        }
                    },
                    animation: {
                        animateScale: true,
                        animateRotate: true,
                        duration: 700
                    }
                },
                plugins: [centerTextPlugin]
            });
        }

        function initializeDataTable(data) {
            if ($.fn.DataTable.isDataTable('#ordersTable')) {
                $('#ordersTable').DataTable().destroy();
            }

            const tableData = data.map((item, index) => {
                const status = item.current_status || '---';
                let statusClass = '';
                if (status === 'Pending') statusClass = 'pending';
                else if (status === 'Start') statusClass = 'start';
                else if (status === 'Complete') statusClass = 'complete';

                const trackerStatus = item.tracker_status || '---';
                const trackerClass = trackerStatus === 'With-Tracker' ? 'with-tracker' : 'without-tracker';

                const shortage = item.is_shortage || '---';
                const shortageClass = shortage === 'Shortage Submitted' ? 'yes' : (shortage === 'Shortage Not Submit' ?
                    'no' : '');

                const sign = item.sign ?
                    `<a href="api/uploads/signatures/${item.sign}" target="_blank" class="text-blue-500 underline">View</a>` :
                    '---';

                const amount = item.total_dispatched_amount && item.total_dispatched_amount !== '---' ?
                    parseFloat(item.total_dispatched_amount).toLocaleString() : '---';

                return [
                    index + 1,
                    item.order_time || '---',
                    item.name || '---',
                    item.customer_id || '---',
                    item.product_name || '---',
                    item.vehicle_name || '---',
                    `<span class="badge-tracker ${trackerClass}">${trackerStatus}</span>`,
                    item.sale_order_no || '---',
                    item.invoice || '---',
                    item.quantity || '---',
                    item.product_rate || '---',
                    amount,
                    `<span class="badge-status ${statusClass}">${status}</span>`,
                    sign,
                    `<span class="badge-shortage ${shortageClass}">${shortage}</span>`,
                    item.remain_distance || '---',
                    item.distance || '---',
                    item.start_time || '---',
                    item.eta || '---',
                    item.close_time || '---'
                ];
            });

            dataTable = $('#ordersTable').DataTable({
                data: tableData,
                columns: columnConfig.map(col => ({
                    title: col.label,
                    orderable: col.idx !== 0,
                    searchable: col.idx !== 0
                })),
                dom: 'Bfrtip',
                buttons: [
                    { extend: 'copy', text: '<i class="fa-regular fa-copy"></i> Copy', className: 'toolbar-btn',
                        exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17,
                                18, 19
                            ] } },
                    { extend: 'excelHtml5', text: '<i class="fa-regular fa-file-excel"></i> Excel',
                        className: 'toolbar-btn', exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10,
                                11, 12, 13, 14, 15, 16, 17, 18, 19
                            ] }, title: 'JD_Orders' },
                    { extend: 'csvHtml5', text: '<i class="fa-regular fa-file-csv"></i> CSV',
                        className: 'toolbar-btn', exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10,
                                11, 12, 13, 14, 15, 16, 17, 18, 19
                            ] }, title: 'JD_Orders' },
                    { extend: 'pdfHtml5', text: '<i class="fa-regular fa-file-pdf"></i> PDF',
                        className: 'toolbar-btn', exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10,
                                11, 12, 13, 14, 15, 16, 17, 18, 19
                            ] }, title: 'JD Orders Dashboard', orientation: 'landscape', pageSize: 'A4',
                        customize: function(doc) {
                            doc.defaultStyle.fontSize = 8;
                            doc.styles.tableHeader.fontSize = 9;
                            doc.styles.tableHeader.fillColor = '#0a121c';
                            doc.styles.tableHeader.color = '#ffffff';
                        } },
                    { extend: 'print', text: '<i class="fa-solid fa-print"></i> Print', className: 'toolbar-btn',
                        exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16,
                                17, 18, 19
                            ] } }
                ],
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100],
                ordering: true,
                order: [[0, 'asc']],
                language: {
                    emptyTable: '<div class="text-center py-8 text-gray-500"><i class="fa-solid fa-box-open text-2xl block mb-2"></i>No orders found</div>',
                    info: 'Showing _START_ to _END_ of _TOTAL_ entries',
                    infoEmpty: 'Showing 0 to 0 of 0 entries',
                    infoFiltered: '(filtered from _MAX_ total entries)'
                },
                drawCallback: function() {
                    $('.dt-buttons .dt-button').each(function() {
                        $(this).addClass('toolbar-btn');
                    });
                },
                initComplete: function() {
                    const buttonsContainer = $('#exportButtonsContainer');
                    $('.dt-buttons').appendTo(buttonsContainer);
                    populateColumnDropdown();
                }
            });
        }

        function filterTableByStatus(status) {
            if (dataTable) {
                dataTable.search(status).draw();
                $('html, body').animate({
                    scrollTop: $('#ordersTable').offset().top - 100
                }, 500);
            }
        }

        function filterTableByStation(stationName) {
            if (dataTable) {
                dataTable.search(stationName).draw();
                $('html, body').animate({
                    scrollTop: $('#ordersTable').offset().top - 100
                }, 500);
            }
        }

        function populateColumnDropdown() {
            const container = $('#columnListItems');
            container.empty();

            columnConfig.forEach(function(col) {
                let isVisible = true;
                try {
                    isVisible = dataTable.column(col.idx).visible();
                } catch (e) {
                    isVisible = true;
                }
                const item = `
                    <div class="dropdown-item" onclick="toggleColumnVisibility(${col.idx})">
                        <input type="checkbox" id="col-checkbox-${col.idx}" 
                               ${isVisible ? 'checked' : ''} 
                               onclick="event.stopPropagation(); toggleColumnVisibility(${col.idx})">
                        <span class="column-label">${col.label}</span>
                    </div>
                `;
                container.append(item);
            });
        }

        function toggleColumnVisibility(colIdx) {
            if (!dataTable) return;
            try {
                const isVisible = dataTable.column(colIdx).visible();
                dataTable.column(colIdx).visible(!isVisible);
                $(`#col-checkbox-${colIdx}`).prop('checked', !isVisible);
            } catch (e) {
                console.warn('Column visibility toggle error:', e);
            }
        }

        function selectAllColumns() {
            if (!dataTable) return;
            try {
                columnConfig.forEach(function(col) {
                    if (!dataTable.column(col.idx).visible()) {
                        dataTable.column(col.idx).visible(true);
                    }
                    $(`#col-checkbox-${col.idx}`).prop('checked', true);
                });
                showToast('All columns selected!', 'success');
            } catch (e) {
                console.warn('Select all columns error:', e);
            }
        }   

        function deselectAllColumns() {
            if (!dataTable) return;
            try {
                columnConfig.forEach(function(col) {
                    if (dataTable.column(col.idx).visible()) {
                        dataTable.column(col.idx).visible(false);
                    }
                    $(`#col-checkbox-${col.idx}`).prop('checked', false);
                });
                showToast('All columns deselected!', 'success');
            } catch (e) {
                console.warn('Deselect all columns error:', e);
            }
        }

        function toggleColumnDropdown() {
            const menu = $('#columnDropdownMenu');
            menu.toggleClass('show');
            if (menu.hasClass('show')) {
                populateColumnDropdown();
            }
        }

        function closeColumnDropdown() {
            $('#columnDropdownMenu').removeClass('show');
        }
    </script>

</body>

</html>