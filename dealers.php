<?php
// Hascol OMC Operations Command Center - Dealers Management
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hascol OMC - Dealers Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- CryptoJS for Encryption -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/crypto-js.js"></script>

    <!-- Leaflet CSS & JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <!-- Select2 CSS & JS for Multiple Select -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

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

    <!-- ============================================ -->
    <!-- DARK MODE INIT - Page Load Se Pehle Apply   -->
    <!-- ============================================ -->
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
            --modal-overlay: rgba(15, 23, 42, 0.45);
            --btn-secondary-bg: #e2e8f0;
            --btn-secondary-text: #334155;
            --btn-secondary-hover-bg: #cbd5e1;
            --btn-secondary-hover-text: #0f2440;
            --toolbar-btn-bg: #ffffff;
            --offcanvas-bg: #ffffff;
            --offcanvas-border: #e2e8f0;
            --file-upload-bg: #f8fafc;
            --file-upload-border: #cbd5e1;
            --dropdown-bg: #ffffff;
            --dropdown-hover: #f1f5f9;
            --map-tiles-filter: none;
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
            --offcanvas-bg: #0d1520;
            --offcanvas-border: #1a2635;
            --file-upload-bg: #060b13;
            --file-upload-border: #1a2635;
            --dropdown-bg: #0d1520;
            --dropdown-hover: #1a2635;
            --map-tiles-filter: invert(100%) hue-rotate(180deg) brightness(95%) contrast(90%);
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

        /* Toggle Switch Styles - BLUE color */
        .toggle-switch {
            position: relative;
            width: 40px;
            height: 22px;
            display: inline-block;
            cursor: pointer;
        }

        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .toggle-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #cbd5e1;
            transition: 0.3s;
            border-radius: 34px;
        }

        .toggle-slider:before {
            position: absolute;
            content: "";
            height: 16px;
            width: 16px;
            left: 3px;
            bottom: 3px;
            background-color: #ffffff;
            transition: 0.3s;
            border-radius: 50%;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
        }

        .toggle-switch input:checked+.toggle-slider {
            background-color: #3b82f6;
        }

        .toggle-switch input:checked+.toggle-slider:before {
            transform: translateX(18px);
            background-color: #ffffff;
        }

        .toggle-switch input:disabled+.toggle-slider {
            opacity: 0.5;
            cursor: not-allowed;
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

        .action-icon.view:hover {
            background: #3b82f620;
            color: #3b82f6;
        }

        .action-icon.edit:hover {
            background: #f59e0b20;
            color: #f59e0b;
        }

        .action-icon.password:hover {
            background: #8b5cf620;
            color: #8b5cf6;
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

        /* DataTables Buttons */
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

        .dataTables_filter {
            display: none !important;
        }

        /* Search Input */
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

        /* Modal Styles */
        #passwordModal {
            background: var(--modal-overlay);
            backdrop-filter: blur(8px);
        }

        #passwordModalWrapper {
            background-color: var(--bg-panel) !important;
            border-color: var(--border-color) !important;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35);
        }

        html.dark-mode #passwordModalWrapper {
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.8);
        }

        /* Offcanvas Styles - Increased Width */
        #editOffcanvas {
            position: fixed;
            top: 0;
            right: -850px;
            width: 820px;
            max-width: 95vw;
            height: 100vh;
            background: var(--offcanvas-bg);
            border-left: 1px solid var(--offcanvas-border);
            z-index: 9999;
            transition: right 0.35s ease-in-out;
            overflow-y: auto;
            box-shadow: -10px 0 30px rgba(0, 0, 0, 0.25);
        }

        html.dark-mode #editOffcanvas {
            box-shadow: -10px 0 30px rgba(0, 0, 0, 0.5);
        }

        #editOffcanvas.open {
            right: 0;
        }

        #editOffcanvas .offcanvas-header {
            padding: 16px 24px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: var(--table-head-bg);
            position: sticky;
            top: 0;
            z-index: 10;
        }

        #editOffcanvas .offcanvas-body {
            padding: 20px 24px;
        }

        #overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(6, 11, 19, 0.5);
            backdrop-filter: blur(4px);
            z-index: 9998;
            display: none;
        }

        html.dark-mode #overlay {
            background: rgba(6, 11, 19, 0.7);
        }

        #overlay.active {
            display: block;
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

        .form-select option {
            background-color: var(--bg-panel);
            color: var(--text-body);
        }

        /* Select2 Custom Styles */
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

        html.dark-mode .select2-container--default .select2-selection--multiple {
            background-color: #060b13 !important;
            border-color: #1a2635 !important;
        }

        html.dark-mode .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #1d4ed8 !important;
        }

        .btn-primary {
            background-color: #1d4ed8;
            color: #ffffff;
            padding: 8px 20px;
            border-radius: 0.25rem;
            border: none;
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s;
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

        .btn-success {
            background-color: #10b981;
            color: #ffffff;
            padding: 8px 20px;
            border-radius: 0.25rem;
            border: none;
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .btn-success:hover {
            background-color: #059669;
        }

        .badge {
            padding: 2px 8px;
            border-radius: 9999px;
            font-size: 8px;
            font-weight: 600;
            display: inline-block;
        }

        .badge-grm {
            background: #3b82f620;
            color: #3b82f6;
            border: 1px solid #3b82f640;
        }

        .file-upload-box {
            border: 2px dashed var(--file-upload-border);
            border-radius: 0.375rem;
            padding: 16px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
            background: var(--file-upload-bg);
        }

        .file-upload-box:hover {
            border-color: #1d4ed8;
            background: var(--hover-bg);
        }

        .file-upload-box .preview-img {
            max-width: 100%;
            max-height: 80px;
            margin-top: 8px;
            border-radius: 4px;
            display: none;
        }

        .file-upload-box .preview-img.show {
            display: block;
        }

        .section-title {
            color: var(--text-muted);
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
            margin-bottom: 8px;
            padding-bottom: 4px;
            border-bottom: 1px solid var(--border-color);
        }

        /* Map Container */
        #map-canvas {
            width: 100%;
            height: 300px;
            border-radius: 0.375rem;
            border: 1px solid var(--border-color);
            z-index: 1;
            background: #e8e8e8;
        }

        /* Leaflet Dark Mode Filter */
        html.dark-mode .leaflet-tile-pane {
            filter: var(--map-tiles-filter);
        }

        /* Search Input for Map */
        .map-search-container {
            position: relative;
            margin-bottom: 8px;
        }

        .map-search-container .search-results {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background-color: var(--bg-panel);
            border: 1px solid var(--border-color);
            border-radius: 0.375rem;
            max-height: 200px;
            overflow-y: auto;
            z-index: 1000;
            display: none;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
        }

        .map-search-container .search-results.show {
            display: block;
        }

        .map-search-container .search-results .result-item {
            padding: 8px 14px;
            cursor: pointer;
            transition: background-color 0.15s;
            font-size: 12px;
            color: var(--text-body);
            border-bottom: 1px solid var(--border-color);
        }

        .map-search-container .search-results .result-item:hover {
            background-color: var(--hover-bg);
        }

        .map-search-container .search-results .result-item:last-child {
            border-bottom: none;
        }

        .map-search-container .search-results .result-item .result-label {
            font-weight: 500;
        }

        .map-search-container .search-results .result-item .result-address {
            font-size: 10px;
            color: var(--text-muted);
        }

        .map-search-container #mapSearchInput {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid var(--border-color);
            border-radius: 0.375rem;
            font-size: 12px;
            background-color: var(--input-bg);
            color: var(--text-body);
            outline: none;
            transition: border-color 0.2s;
            padding-right: 36px;
        }

        .map-search-container #mapSearchInput:focus {
            border-color: #1d4ed8;
            box-shadow: 0 0 0 2px rgba(29, 78, 216, 0.2);
        }

        .map-search-container #mapSearchInput::placeholder {
            color: var(--text-muted);
        }

        .map-search-container .search-icon {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 13px;
        }

        /* Toast */
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

        .toast.show {
            transform: translateY(0);
            opacity: 1;
        }

        .toast.success {
            border-color: #10b981;
        }

        .toast.success i {
            color: #10b981;
        }

        .toast.error {
            border-color: #ef4444;
        }

        .toast.error i {
            color: #ef4444;
        }

        /* Column Visibility Dropdown */
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

        .column-visibility-dropdown .dropdown-menu.show {
            display: block;
        }

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

        .column-visibility-dropdown .dropdown-menu .dropdown-item .column-label {
            flex: 1;
            user-select: none;
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

        .column-visibility-dropdown .dropdown-menu .dropdown-actions button.select-all-btn {
            border-color: #10b981;
            color: #10b981;
        }

        .column-visibility-dropdown .dropdown-menu .dropdown-actions button.deselect-all-btn {
            border-color: #ef4444;
            color: #ef4444;
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
                    <h2 class="text-heading font-semibold text-base tracking-wide uppercase">Dealers Management</h2>
                    <p class="text-[10px] text-gray-500">Manage all dealers, stations and their details</p>
                </div>
                <button onclick="openCreateModal()"
                    class="bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 rounded text-xs font-medium transition flex items-center gap-2">
                    <i class="fa-solid fa-plus"></i> Add
                </button>
            </div>

            <!-- Toolbar -->
            <div class="panel-card p-3 mb-4 flex flex-wrap items-center justify-between gap-2">
                <div class="flex items-center gap-2 flex-wrap" id="exportButtonsContainer">
                    <!-- DataTables Buttons will be placed here -->
                </div>
                <div class="flex items-center gap-2">
                    <!-- Column Visibility Dropdown -->
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
                        <input type="text" id="customSearchInput" placeholder="Search dealers..." class="search-input">
                    </div>
                </div>
            </div>

            <!-- Dealers Table -->
            <div class="panel-card overflow-hidden">
                <div class="table-container">
                    <table id="dealersTable" class="display" style="width:100%;">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Site Name</th>
                                <th>JD Code</th>
                                <th>Email</th>
                                <th>Contact</th>
                                <th>Password</th>
                                <th>Co-ordinates</th>
                                <th>Ledger Balance</th>
                                <th>GRM</th>
                                <th>RM</th>
                                <th>TM</th>
                                <th>Verify</th>
                                <th>View</th>
                                <th>Edit Password</th>
                                <th>Edit</th>
                            </tr>
                        </thead>
                        <tbody id="dealersTableBody">
                            <tr>
                                <td colspan="15" class="text-center py-8 text-gray-500">
                                    <i class="fa-solid fa-spinner fa-spin text-blue-400 mr-2"></i>
                                    Loading dealers...
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>

    <!-- ============================================ -->
    <!-- OVERLAY (For Offcanvas)                      -->
    <!-- ============================================ -->
    <div id="overlay" onclick="closeOffcanvas()"></div>

    <!-- ============================================ -->
    <!-- EDIT OFFCANVAS (Right Side)                  -->
    <!-- ============================================ -->
    <div id="editOffcanvas">
        <div class="offcanvas-header">
            <h3 class="text-heading font-semibold text-sm tracking-wide" id="offcanvasTitle">Create Stations</h3>
            <button onclick="closeOffcanvas()" class="text-gray-400 hover:text-red-500 transition text-xl">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="offcanvas-body">
            <form id="dealerForm" onsubmit="saveDealer(event)" enctype="multipart/form-data">
                <input type="hidden" id="dealerId" value="">
                <input type="hidden" id="bannerHidden" value="">
                <input type="hidden" id="logoHidden" value="">

                <!-- Row 1: Site Name + Dealer SAP -->
                <div class="grid grid-cols-2 gap-3 mb-3">
                    <div>
                        <label class="form-label">Site Name</label>
                        <input type="text" id="siteName" class="form-input" placeholder="Enter Site Name" required>
                    </div>
                    <div>
                        <label class="form-label">Dealer SAP #</label>
                        <input type="text" id="dealerSap" class="form-input" placeholder="Enter SAP Code" required>
                    </div>
                </div>

                <!-- Row 2: Email + Password -->
                <div class="grid grid-cols-2 gap-3 mb-3">
                    <div>
                        <label class="form-label">Email</label>
                        <input type="email" id="dealerEmail" class="form-input" placeholder="Enter Email" required>
                    </div>
                    <div>
                        <label class="form-label">Password</label>
                        <input type="text" id="dealerPassword" class="form-input" placeholder="Enter Password">
                    </div>
                </div>

                <!-- Row 3: Contact + Account Balance -->
                <div class="grid grid-cols-2 gap-3 mb-3">
                    <div>
                        <label class="form-label">Contact No</label>
                        <input type="text" id="dealerContact" class="form-input" placeholder="Enter Contact" required>
                    </div>
                    <div>
                        <label class="form-label">Account Balance</label>
                        <input type="text" id="accountBalance" class="form-input" placeholder="Enter Balance">
                    </div>
                </div>

                <!-- Row 4: Co-ordinates (Circle) + Co-ordinates (Polygon) -->
                <div class="grid grid-cols-2 gap-3 mb-3">
                    <div>
                        <label class="form-label">Co-Ordinates (Circle)</label>
                        <input type="text" id="coordinatesCircle" class="form-input" placeholder="lat, lng" readonly>
                    </div>
                    <div>
                        <label class="form-label">Co-Ordinates (Polygon)</label>
                        <input type="text" id="coordinatesPolygon" class="form-input" placeholder="Polygon data" readonly>
                    </div>
                </div>

                <!-- Row 5: City + Region -->
                <div class="grid grid-cols-2 gap-3 mb-3">
                    <div>
                        <label class="form-label">City</label>
                        <select id="city" class="form-select">
                            <option value="">Select City</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Region</label>
                        <select id="region" class="form-select">
                            <option value="">Select Region</option>
                        </select>
                    </div>
                </div>

                <!-- Row 6: District + Province -->
                <div class="grid grid-cols-2 gap-3 mb-3">
                    <div>
                        <label class="form-label">District</label>
                        <select id="district" class="form-select">
                            <option value="">Select District</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Province</label>
                        <select id="province" class="form-select">
                            <option value="">Select Province</option>
                        </select>
                    </div>
                </div>

                <!-- Row 7: Subscription + Depot -->
                <div class="grid grid-cols-2 gap-3 mb-3">
                    <div>
                        <label class="form-label">Subscription</label>
                        <select id="subscription" class="form-select">
                            <option value="">Select Subscription</option>
                            <option value="Platinum">Platinum</option>
                            <option value="Gold">Gold</option>
                            <option value="Silver">Silver</option>
                            <option value="Basic">Basic</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Depot</label>
                        <select id="depot" class="form-select" multiple>
                            <option value="">Select Depot</option>
                        </select>
                    </div>
                </div>

                <!-- Row 8: GRM + RM + TM -->
                <div class="grid grid-cols-3 gap-3 mb-3">
                    <div>
                        <label class="form-label">GRM</label>
                        <select id="grm" class="form-select" onchange="loadRM(this.value)">
                            <option value="">Select GRM</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">RM</label>
                        <select id="rm" class="form-select" onchange="loadTM(this.value)">
                            <option value="">Select RM</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">TM</label>
                        <select id="tm" class="form-select">
                            <option value="">Select TM</option>
                        </select>
                    </div>
                </div>

                <!-- ============================================ -->
                <!-- MAP SECTION - Banner & Logo se UPER          -->
                <!-- ============================================ -->
                <div class="section-title mt-4">Location Map</div>
                <div class="mb-4">
                    <div class="map-search-container">
                        <input id="mapSearchInput" type="text" placeholder="Search location..." autocomplete="off">
                        <i class="fa-solid fa-search search-icon"></i>
                        <div class="search-results" id="searchResults"></div>
                    </div>
                    <div id="map-canvas"></div>
                </div>

                <!-- Separator -->
                <div class="section-title mt-4">Banner & Logo</div>

                <!-- Banner Upload -->
                <div class="mb-3">
                    <label class="form-label">Banner (1200x200)</label>
                    <div class="file-upload-box" onclick="document.getElementById('bannerInput').click()">
                        <i class="fa-regular fa-image text-2xl text-gray-500 block mb-2"></i>
                        <p class="text-gray-500 text-xs">Choose file or drag & drop</p>
                        <p class="text-gray-600 text-[9px] mt-1">Image must be 1200x200</p>
                        <input type="file" id="bannerInput" accept="image/*" style="display:none;" onchange="previewImage(this, 'bannerPreview', 'bannerHidden')">
                        <img id="bannerPreview" class="preview-img" src="" alt="Banner Preview">
                        <span id="bannerFileName" class="text-blue-400 text-xs mt-2 block">No file chosen</span>
                    </div>
                </div>

                <!-- Logo Upload -->
                <div class="mb-3">
                    <label class="form-label">Logo (96x96)</label>
                    <div class="file-upload-box" onclick="document.getElementById('logoInput').click()">
                        <i class="fa-regular fa-image text-2xl text-gray-500 block mb-2"></i>
                        <p class="text-gray-500 text-xs">Choose file or drag & drop</p>
                        <p class="text-gray-600 text-[9px] mt-1">Image must be 96x96</p>
                        <input type="file" id="logoInput" accept="image/*" style="display:none;" onchange="previewImage(this, 'logoPreview', 'logoHidden')">
                        <img id="logoPreview" class="preview-img" src="" alt="Logo Preview">
                        <span id="logoFileName" class="text-blue-400 text-xs mt-2 block">No file chosen</span>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex gap-3 mt-4 pt-3 border-t" style="border-color: var(--border-color);">
                    <button type="submit" class="btn-primary flex-1">Save</button>
                    <button type="button" onclick="closeOffcanvas()" class="btn-secondary">Close</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ============================================ -->
    <!-- PASSWORD MODAL                               -->
    <!-- ============================================ -->
    <div id="passwordModal"
        class="fixed inset-0 z-50 hidden backdrop-blur-sm flex items-center justify-center transition-opacity duration-300 opacity-0">
        <div class="border rounded-lg shadow-2xl w-full max-w-sm transform scale-95 transition-transform duration-300"
            id="passwordModalWrapper">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-heading font-semibold text-base">Edit Password</h3>
                    <button onclick="closePasswordModal()" class="text-gray-400 hover:text-red-500 transition">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>
                <form id="passwordForm" onsubmit="savePassword(event)">
                    <input type="hidden" id="passwordDealerId" value="">
                    <div class="mb-4">
                        <label class="form-label">Password</label>
                        <input type="text" id="newPassword" class="form-input" placeholder="Enter new password" required>
                    </div>
                    <div class="flex gap-3">
                        <button type="submit" class="btn-primary flex-1">Save</button>
                        <button type="button" onclick="closePasswordModal()" class="btn-secondary">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ============================================ -->
    <!-- TOAST NOTIFICATION                           -->
    <!-- ============================================ -->
    <div id="toast" class="toast">
        <i class="fa-solid fa-check-circle mr-2"></i>
        <span id="toastMessage">Success!</span>
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
            const cipher = CryptoJS.AES.encrypt(originalId.toString(), key, {
                iv: iv
            });
            return cipher.toString();
        }

        // ============================================
        // API Configuration - LOCALHOST
        // ============================================
        const API_BASE_URL = 'api/';
        const PRE = 'Admin';
        const USER_ID = '1';

        // ============================================
        // Data Store
        // ============================================
        let dealersData = [];
        let dataTable = null;

        // ============================================
        // Column Visibility Configuration
        // ============================================
        const columnConfig = [
            { idx: 0, label: 'S.No' },
            { idx: 1, label: 'Site Name' },
            { idx: 2, label: 'JD Code' },
            { idx: 3, label: 'Email' },
            { idx: 4, label: 'Contact' },
            { idx: 5, label: 'Password' },
            { idx: 6, label: 'Co-ordinates' },
            { idx: 7, label: 'Ledger Balance' },
            { idx: 8, label: 'GRM' },
            { idx: 9, label: 'RM' },
            { idx: 10, label: 'TM' },
            { idx: 11, label: 'Verify' },
            { idx: 12, label: 'View' },
            { idx: 13, label: 'Edit Password' },
            { idx: 14, label: 'Edit' }
        ];

        // ============================================
        // Leaflet Map Variables
        // ============================================
        let map;
        let marker;
        let mapInitialized = false;
        let searchTimeout;

        // ============================================
        // Initialize Leaflet Map
        // ============================================
        function initMap() {
            if (mapInitialized) return;

            // Default center: Pakistan
            const defaultCenter = [30.3753, 69.3451];

            map = L.map('map-canvas').setView(defaultCenter, 5);

            // Use OpenStreetMap tiles
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            // Add click handler to get coordinates
            map.on('click', function(e) {
                const lat = e.latlng.lat.toFixed(6);
                const lng = e.latlng.lng.toFixed(6);
                $('#coordinatesCircle').val(lat + ', ' + lng);

                // Update marker
                if (marker) {
                    marker.setLatLng([lat, lng]);
                } else {
                    marker = L.marker([lat, lng]).addTo(map);
                }

                // Reverse geocode to get location name
                reverseGeocode(lat, lng);
            });

            mapInitialized = true;
        }

        // ============================================
        // Reverse Geocode (Get location from coordinates)
        // ============================================
        function reverseGeocode(lat, lng) {
            const url = `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`;

            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    if (data && data.display_name) {
                        $('#location').val(data.display_name);
                    }
                },
                error: function() {
                    console.log('Reverse geocode failed');
                }
            });
        }

        // ============================================
        // Search Location (Nominatim API)
        // ============================================
        function searchLocation(query) {
            if (!query || query.length < 2) {
                $('#searchResults').removeClass('show').empty();
                return;
            }

            const url = `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&limit=10&addressdetails=1`;

            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    const resultsContainer = $('#searchResults');
                    resultsContainer.empty();

                    if (data && data.length > 0) {
                        $.each(data, function(index, item) {
                            const resultItem = `
                                <div class="result-item" data-lat="${item.lat}" data-lon="${item.lon}" data-name="${item.display_name}">
                                    <div class="result-label">${item.display_name}</div>
                                    <div class="result-address">${item.class || ''} ${item.type || ''}</div>
                                </div>
                            `;
                            resultsContainer.append(resultItem);
                        });

                        // Click handler for results
                        resultsContainer.find('.result-item').on('click', function() {
                            const lat = $(this).data('lat');
                            const lon = $(this).data('lon');
                            const name = $(this).data('name');

                            // Update map
                            const latLng = [parseFloat(lat), parseFloat(lon)];
                            map.setView(latLng, 15);

                            // Update marker
                            if (marker) {
                                marker.setLatLng(latLng);
                            } else {
                                marker = L.marker(latLng).addTo(map);
                            }

                            // Update coordinates
                            $('#coordinatesCircle').val(lat + ', ' + lon);
                            $('#location').val(name);

                            // Close results
                            resultsContainer.removeClass('show').empty();
                            $('#mapSearchInput').val(name);
                        });

                        resultsContainer.addClass('show');
                    } else {
                        resultsContainer.append('<div class="result-item" style="color:var(--text-muted);cursor:default;">No results found</div>');
                        resultsContainer.addClass('show');
                    }
                },
                error: function() {
                    console.log('Search failed');
                }
            });
        }

        $(document).ready(function() {
            // Initialize Select2 for multiple select
            $('#depot').select2({
                placeholder: 'Select Depot(s)',
                allowClear: true,
                width: '100%',
                dropdownParent: $('#editOffcanvas')
            });

            // Sidebar Toggle
            $('#sidebarToggle').on('click', function() {
                $('#sidebar').toggleClass('collapsed');
                const isCollapsed = $('#sidebar').hasClass('collapsed');
                localStorage.setItem('sidebarCollapsed', isCollapsed);
            });

            const savedState = localStorage.getItem('sidebarCollapsed');
            if (savedState === 'true') {
                $('#sidebar').addClass('collapsed');
            }

            // Custom Search
            $('#customSearchInput').on('keyup', function() {
                const searchTerm = $(this).val();
                if ($.fn.DataTable.isDataTable('#dealersTable')) {
                    $('#dealersTable').DataTable().search(searchTerm).draw();
                }
            });

            // Map Search Input with debounce
            $('#mapSearchInput').on('input', function() {
                clearTimeout(searchTimeout);
                const query = $(this).val();
                searchTimeout = setTimeout(function() {
                    searchLocation(query);
                }, 300);
            });

            // Close search results on outside click
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.map-search-container').length) {
                    $('#searchResults').removeClass('show').empty();
                }
            });

            // Load dropdowns
            loadGRMList();
            loadRegionDistrictCityProvince();
            loadDepots();

            // Load dealers
            loadDealers();

            // Close dropdown on outside click
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.column-visibility-dropdown').length) {
                    closeColumnDropdown();
                }
            });

            // Watch for offcanvas open to initialize map
            const observer = new MutationObserver(function() {
                if ($('#editOffcanvas').hasClass('open') && !mapInitialized) {
                    setTimeout(function() {
                        initMap();
                        // Force map resize
                        setTimeout(function() {
                            if (map) {
                                map.invalidateSize();
                            }
                        }, 100);
                    }, 300);
                }
            });
            observer.observe(document.getElementById('editOffcanvas'), {
                attributes: true,
                attributeFilter: ['class']
            });
        });

        // ============================================
        // Load Region, District, City, Province
        // ============================================
        function loadRegionDistrictCityProvince() {
            $.ajax({
                url: API_BASE_URL + 'get/get_region_district_dealers.php?key=03201232927&pre=' + PRE + '&user_id=' + USER_ID,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    if (data && data.length > 0) {
                        try {
                            var districtData = JSON.parse(data[0]['district']);
                            var cityData = JSON.parse(data[0]['city']);
                            var provinceData = JSON.parse(data[0]['province']);
                            var regionData = JSON.parse(data[0]['region']);

                            // District
                            var districtSelect = $('#district');
                            districtSelect.empty().append('<option value="">Select District</option>');
                            $.each(districtData, function(index, item) {
                                districtSelect.append($('<option>', {
                                    value: item.district,
                                    text: item.district
                                }));
                            });

                            // City
                            var citySelect = $('#city');
                            citySelect.empty().append('<option value="">Select City</option>');
                            $.each(cityData, function(index, item) {
                                citySelect.append($('<option>', {
                                    value: item.city,
                                    text: item.city
                                }));
                            });

                            // Province
                            var provinceSelect = $('#province');
                            provinceSelect.empty().append('<option value="">Select Province</option>');
                            $.each(provinceData, function(index, item) {
                                provinceSelect.append($('<option>', {
                                    value: item.province,
                                    text: item.province
                                }));
                            });

                            // Region
                            var regionSelect = $('#region');
                            regionSelect.empty().append('<option value="">Select Region</option>');
                            $.each(regionData, function(index, item) {
                                regionSelect.append($('<option>', {
                                    value: item.region,
                                    text: item.region
                                }));
                            });

                            console.log('Region/District/City/Province loaded successfully');
                        } catch(e) {
                            console.error('Parse error:', e);
                        }
                    }
                },
                error: function() {
                    console.log('Failed to load region/district/city/province');
                }
            });
        }

        // ============================================
        // Load Depots
        // ============================================
        function loadDepots() {
            $.ajax({
                url: API_BASE_URL + 'get/depotes.php?key=03201232927',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    var select = $('#depot');
                    select.empty().append('<option value="">Select Depot</option>');
                    if (data && data.length > 0) {
                        $.each(data, function(index, item) {
                            select.append($('<option>', {
                                value: item.id,
                                text: item.consignee_name || item.name || 'Depot ' + item.id
                            }));
                        });
                        console.log('Depots loaded successfully');
                    }
                    // Refresh Select2
                    $('#depot').trigger('change');
                },
                error: function() {
                    console.log('Failed to load depots');
                }
            });
        }

        // ============================================
        // Load GRM List
        // ============================================
        function loadGRMList() {
            $.ajax({
                url: API_BASE_URL + 'get/get_zm.php?key=03201232927',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    var select = $('#grm');
                    select.empty().append('<option value="">Select GRM</option>');
                    if (data && data.length > 0) {
                        $.each(data, function(index, item) {
                            select.append($('<option>', {
                                value: item.id,
                                text: item.name
                            }));
                        });
                        console.log('GRM list loaded successfully:', data.length);
                    }
                },
                error: function() {
                    console.log('Failed to load GRM list');
                }
            });
        }

        // ============================================
        // Load RM based on GRM
        // ============================================
        function loadRM(grmId) {
            if (!grmId) {
                $('#rm').empty().append('<option value="">Select RM</option>');
                $('#tm').empty().append('<option value="">Select TM</option>');
                return;
            }

            console.log('Loading RM for GRM ID:', grmId);

            $.ajax({
                url: API_BASE_URL + 'get/individual_tm_of_zm.php?key=03201232927&zm_id=' + grmId,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    var select = $('#rm');
                    select.empty().append('<option value="">Select RM</option>');
                    if (data && data.length > 0) {
                        $.each(data, function(index, item) {
                            select.append($('<option>', {
                                value: item.id,
                                text: item.name
                            }));
                        });
                        console.log('RM list loaded successfully:', data.length);
                    } else {
                        console.log('No RM found for this GRM');
                    }
                    // Reset TM dropdown
                    $('#tm').empty().append('<option value="">Select TM</option>');
                },
                error: function(xhr, status, error) {
                    console.error('Failed to load RM list:', status, error);
                    $('#rm').empty().append('<option value="">Select RM</option>');
                    $('#tm').empty().append('<option value="">Select TM</option>');
                }
            });
        }

        // ============================================
        // Load TM based on RM
        // ============================================
        function loadTM(rmId) {
            if (!rmId) {
                $('#tm').empty().append('<option value="">Select TM</option>');
                return;
            }

            console.log('Loading TM for RM ID:', rmId);

            $.ajax({
                url: API_BASE_URL + 'get/individual_asm_of_tm.php?key=03201232927&tm_id=' + rmId,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    var select = $('#tm');
                    select.empty().append('<option value="">Select TM</option>');
                    if (data && data.length > 0) {
                        $.each(data, function(index, item) {
                            select.append($('<option>', {
                                value: item.id,
                                text: item.name
                            }));
                        });
                        console.log('TM list loaded successfully:', data.length);
                    } else {
                        console.log('No TM found for this RM');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Failed to load TM list:', status, error);
                    $('#tm').empty().append('<option value="">Select TM</option>');
                }
            });
        }

        // ============================================
        // Load Dealers from API
        // ============================================
        function loadDealers() {
            $('#dealersTableBody').html(`
                <tr>
                    <td colspan="15" class="text-center py-8 text-gray-500">
                        <i class="fa-solid fa-spinner fa-spin text-blue-400 mr-2"></i>
                        Loading dealers...
                    </td>
                </tr>
            `);

            $.ajax({
                url: API_BASE_URL + 'get/dealers.php?key=03201232927&pre=' + PRE + '&user_id=' + USER_ID,
                type: 'GET',
                dataType: 'json',
                timeout: 30000,
                success: function(response) {
                    console.log('Dealers API Response:', response);

                    if (response && Array.isArray(response) && response.length > 0) {
                        dealersData = response.map(function(item) {
                            return {
                                id: parseInt(item.id) || 0,
                                siteName: item.name || 'N/A',
                                jdCode: item.sap_no || 'N/A',
                                email: item.email || 'N/A',
                                contact: item.contact || 'N/A',
                                password: item.password || '********',
                                coordinates: item.co_ordinates || 'N/A',
                                ledgerBalance: parseFloat(item.acount) || 0,
                                grm: item.zm_name || 'N/A',
                                rm: item.tm_name || 'N/A',
                                tm: item.asm_name || 'N/A',
                                verified: parseInt(item.indent_price) === 1 || false,
                                banner: item.banner || '',
                                logo: item.logo || '',
                                district: item.district || '',
                                city: item.city || '',
                                region: item.region || '',
                                province: item.province || '',
                                location: item.location || '',
                                housekeeping: item.housekeeping || '',
                                zm: item.zm || '',
                                tm_id: item.tm || '',
                                asm: item.asm || '',
                                sap_no: item.sap_no || '',
                                account: item.acount || 0
                            };
                        });
                        initializeDataTable();
                        showToast('Dealers loaded successfully!', 'success');
                    } else {
                        showToast('No dealers found.', 'error');
                        dealersData = [];
                        initializeDataTable();
                    }
                },
                error: function(xhr, status, error) {
                    console.error('API Error:', status, error);
                    showToast('Failed to load dealers. Please refresh.', 'error');
                    dealersData = [];
                    initializeDataTable();
                }
            });
        }

        // ============================================
        // Format Ledger Balance
        // ============================================
        function formatBalance(value) {
            if (value >= 1000000000) return (value / 1000000000).toFixed(2) + 'B';
            if (value >= 1000000) return (value / 1000000).toFixed(2) + 'M';
            if (value >= 1000) return (value / 1000).toFixed(2) + 'K';
            return value.toFixed(2);
        }

        // ============================================
        // Populate Column Visibility Dropdown
        // ============================================
        function populateColumnDropdown() {
            const container = $('#columnListItems');
            container.empty();

            columnConfig.forEach(function(col) {
                let isVisible = true;
                try {
                    isVisible = dataTable.column(col.idx).visible();
                } catch(e) {
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

        // ============================================
        // Column Visibility Functions
        // ============================================
        function toggleColumnVisibility(colIdx) {
            if (!dataTable) return;
            try {
                const isVisible = dataTable.column(colIdx).visible();
                dataTable.column(colIdx).visible(!isVisible);
                const checkbox = $(`#col-checkbox-${colIdx}`);
                checkbox.prop('checked', !isVisible);
            } catch(e) {
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
            } catch(e) {
                console.warn('Select all columns error:', e);
                showToast('Error selecting columns', 'error');
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
            } catch(e) {
                console.warn('Deselect all columns error:', e);
                showToast('Error deselecting columns', 'error');
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
            const menu = $('#columnDropdownMenu');
            menu.removeClass('show');
        }

        // ============================================
        // Initialize DataTable with Export Buttons
        // ============================================
        function initializeDataTable() {
            if ($.fn.DataTable.isDataTable('#dealersTable')) {
                $('#dealersTable').DataTable().destroy();
                $('#dealersTable tbody').empty();
            }

            const tableData = dealersData.map((dealer, index) => {
                const toggleHtml = `
                    <label class="toggle-switch">
                        <input type="checkbox" ${dealer.verified ? 'checked' : ''} 
                               onchange="toggleVerify(${dealer.id}, this.checked)">
                        <span class="toggle-slider"></span>
                    </label>
                `;

                // ✅ Generate encrypted ID for each dealer
                const encId = encryptId(dealer.id);

                return [
                    index + 1,
                    dealer.siteName,
                    dealer.jdCode,
                    dealer.email,
                    dealer.contact,
                    dealer.password,
                    dealer.coordinates,
                    formatBalance(dealer.ledgerBalance),
                    `<span class="badge badge-grm">${dealer.grm}</span>`,
                    dealer.rm,
                    dealer.tm,
                    toggleHtml,
                    // ✅ View button with encrypted ID
                    `<a href="user_profile.php?id=${encodeURIComponent(encId)}" target="_blank" class="action-icon view" title="View">
                        <i class="fa-regular fa-eye"></i>
                     </a>`,
                    `<span class="action-icon password" title="Edit Password" onclick="openPasswordModal(${dealer.id})">
                        <i class="fa-solid fa-key"></i>
                     </span>`,
                    `<span class="action-icon edit" title="Edit" onclick="openEditOffcanvas(${dealer.id})">
                        <i class="fa-regular fa-pen-to-square"></i>
                     </span>`
                ];
            });

            dataTable = $('#dealersTable').DataTable({
                data: tableData,
                columns: [
                    { title: 'S.No' },
                    { title: 'Site Name' },
                    { title: 'JD Code' },
                    { title: 'Email' },
                    { title: 'Contact' },
                    { title: 'Password' },
                    { title: 'Co-ordinates' },
                    { title: 'Ledger Balance' },
                    { title: 'GRM' },
                    { title: 'RM' },
                    { title: 'TM' },
                    { title: 'Verify', orderable: false, searchable: false },
                    { title: 'View', orderable: false, searchable: false },
                    { title: 'Edit Password', orderable: false, searchable: false },
                    { title: 'Edit', orderable: false, searchable: false }
                ],
                dom: 'Bfrtip',
                buttons: [
                    { extend: 'copy', text: '<i class="fa-regular fa-copy"></i> Copy', className: 'toolbar-btn', exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10] } },
                    { extend: 'excelHtml5', text: '<i class="fa-regular fa-file-excel"></i> Excel', className: 'toolbar-btn', exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10] }, title: 'Dealers_Export' },
                    { extend: 'csvHtml5', text: '<i class="fa-regular fa-file-csv"></i> CSV', className: 'toolbar-btn', exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10] }, title: 'Dealers_Export' },
                    { extend: 'pdfHtml5', text: '<i class="fa-regular fa-file-pdf"></i> PDF', className: 'toolbar-btn', exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10] }, title: 'Dealers Report', orientation: 'landscape', pageSize: 'A4', customize: function(doc) { doc.defaultStyle.fontSize = 8; doc.styles.tableHeader.fontSize = 9; doc.styles.tableHeader.fillColor = '#0a121c'; doc.styles.tableHeader.color = '#ffffff'; } },
                    { extend: 'print', text: '<i class="fa-solid fa-print"></i> Print', className: 'toolbar-btn', exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10] } }
                ],
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100],
                ordering: true,
                order: [[0, 'asc']],
                language: {
                    emptyTable: '<div class="text-center py-8 text-gray-500"><i class="fa-solid fa-building text-2xl block mb-2"></i>No dealers found</div>',
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

        // ============================================
        // Verify Toggle
        // ============================================
        function toggleVerify(id, checked) {
            const dealer = dealersData.find(d => d.id === id);
            if (!dealer) return;

            $.ajax({
                url: API_BASE_URL + 'update/verify_dealers.php',
                type: 'POST',
                data: {
                    checkboxValue: checked ? 1 : 0,
                    id: id
                },
                dataType: 'json',
                success: function(response) {
                    if (response === 1) {
                        dealer.verified = checked;
                        showToast(`Dealer ${dealer.siteName} ${checked ? 'verified' : 'unverified'}!`, 'success');
                    } else {
                        showToast('Failed to update verification status.', 'error');
                        initializeDataTable();
                    }
                },
                error: function() {
                    showToast('Error updating verification status.', 'error');
                    initializeDataTable();
                }
            });
        }

        // ============================================
        // View Dealer
        // ============================================
        function viewDealer(id) {
            const dealer = dealersData.find(d => d.id === id);
            if (dealer) {
                Swal.fire({
                    title: dealer.siteName,
                    html: `
                        <table style="width:100%; text-align:left; font-size:12px;">
                            <tr><td><strong>JD Code:</strong></td><td>${dealer.jdCode}</td></tr>
                            <tr><td><strong>Email:</strong></td><td>${dealer.email}</td></tr>
                            <tr><td><strong>Contact:</strong></td><td>${dealer.contact}</td></tr>
                            <tr><td><strong>Coordinates:</strong></td><td>${dealer.coordinates}</td></tr>
                            <tr><td><strong>Balance:</strong></td><td>${formatBalance(dealer.ledgerBalance)}</td></tr>
                            <tr><td><strong>GRM:</strong></td><td>${dealer.grm}</td></tr>
                            <tr><td><strong>RM:</strong></td><td>${dealer.rm}</td></tr>
                            <tr><td><strong>TM:</strong></td><td>${dealer.tm}</td></tr>
                            <tr><td><strong>Verified:</strong></td><td>${dealer.verified ? '✅ Yes' : '❌ No'}</td></tr>
                        </table>
                    `,
                    confirmButtonColor: '#1d4ed8',
                    confirmButtonText: 'Close',
                    background: document.documentElement.classList.contains('dark-mode') ? '#0d1520' : '#ffffff',
                    color: document.documentElement.classList.contains('dark-mode') ? '#e5e7eb' : '#334155'
                });
            }
        }

        // ============================================
        // Password Modal
        // ============================================
        function openPasswordModal(id) {
            $('#passwordDealerId').val(id);
            $('#newPassword').val('');
            const modal = $('#passwordModal');
            modal.removeClass('hidden').addClass('flex');
            setTimeout(function() {
                modal.removeClass('opacity-0');
                $('#passwordModalWrapper').removeClass('scale-95').addClass('scale-100');
            }, 10);
        }

        function closePasswordModal() {
            const modal = $('#passwordModal');
            modal.addClass('opacity-0');
            $('#passwordModalWrapper').removeClass('scale-100').addClass('scale-95');
            setTimeout(function() {
                modal.addClass('hidden').removeClass('flex');
            }, 300);
        }

        function savePassword(event) {
            event.preventDefault();
            const id = parseInt($('#passwordDealerId').val());
            const newPassword = $('#newPassword').val().trim();

            if (!newPassword) {
                showToast('Please enter a password.', 'error');
                return;
            }

            const submitBtn = $('#passwordForm button[type="submit"]');
            submitBtn.prop('disabled', true);
            submitBtn.html('<i class="fa-solid fa-spinner fa-spin mr-1"></i> Saving...');

            $.ajax({
                url: API_BASE_URL + 'update/update_dealers_password.php',
                type: 'POST',
                data: { row_id: id, edit_password: newPassword },
                dataType: 'json',
                success: function(response) {
                    submitBtn.prop('disabled', false);
                    submitBtn.html('Save');

                    if (response === 1) {
                        const dealer = dealersData.find(d => d.id === id);
                        if (dealer) {
                            dealer.password = newPassword;
                        }
                        initializeDataTable();
                        closePasswordModal();
                        showToast('Password updated successfully!', 'success');
                    } else {
                        showToast('Failed to update password.', 'error');
                    }
                },
                error: function() {
                    submitBtn.prop('disabled', false);
                    submitBtn.html('Save');
                    showToast('Error updating password.', 'error');
                }
            });
        }

        // ============================================
        // Load Dealer Profile (For Edit)
        // ============================================
        function loadDealerProfile(dealerId, callback) {
            $.ajax({
                url: API_BASE_URL + 'get/dealer_profile.php?key=03201232927&id=' + dealerId,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response && response.length > 0) {
                        callback(response[0]);
                    } else {
                        showToast('Dealer not found.', 'error');
                    }
                },
                error: function() {
                    showToast('Failed to load dealer details.', 'error');
                }
            });
        }

        // ============================================
        // Load Dealer Depots
        // ============================================
        function loadDealerDepots(dealerId, callback) {
            $.ajax({
                url: API_BASE_URL + 'get/dealer_depot.php?key=03201232927&dealer_id=' + dealerId,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response && response.length > 0) {
                        var defaultValues = [];
                        $.each(response, function(index, item) {
                            defaultValues.push(item.depot_id);
                        });
                        callback(defaultValues);
                    } else {
                        callback([]);
                    }
                },
                error: function() {
                    console.log('Failed to load dealer depots');
                    callback([]);
                }
            });
        }

        // ============================================
        // Edit Offcanvas
        // ============================================
        function openEditOffcanvas(id) {
            $('#overlay').addClass('active');
            $('#editOffcanvas').addClass('open');

            // Initialize map after offcanvas opens
            setTimeout(function() {
                if (!mapInitialized) {
                    initMap();
                }
                // Force map resize
                setTimeout(function() {
                    if (map) {
                        map.invalidateSize();
                    }
                }, 100);
            }, 300);

            loadDealerProfile(id, function(dealer) {
                $('#offcanvasTitle').text('Edit Stations');
                $('#dealerId').val(dealer.id);
                $('#siteName').val(dealer.name || '');
                $('#dealerSap').val(dealer.sap_no || '');
                $('#dealerEmail').val(dealer.email || '');
                $('#dealerPassword').val('');
                $('#dealerContact').val(dealer.contact || '');
                $('#accountBalance').val(dealer.acount || '');
                $('#coordinatesCircle').val(dealer['co-ordinates'] || '');
                $('#coordinatesPolygon').val(dealer['co-ordinates'] || '');
                $('#location').val(dealer.location || '');

                // If coordinates exist, show on map
                if (dealer['co-ordinates'] && dealer['co-ordinates'] !== 'N/A' && dealer['co-ordinates'] !== '0, 0') {
                    const coords = dealer['co-ordinates'].split(',');
                    if (coords.length === 2) {
                        const lat = parseFloat(coords[0].trim());
                        const lng = parseFloat(coords[1].trim());
                        if (!isNaN(lat) && !isNaN(lng)) {
                            setTimeout(function() {
                                if (map) {
                                    const latLng = [lat, lng];
                                    map.setView(latLng, 15);
                                    if (marker) {
                                        marker.setLatLng(latLng);
                                    } else {
                                        marker = L.marker(latLng).addTo(map);
                                    }
                                }
                            }, 500);
                        }
                    }
                }

                // Set dropdowns
                if (dealer.district) $('#district').val(dealer.district);
                if (dealer.city) $('#city').val(dealer.city);
                if (dealer.region) $('#region').val(dealer.region);
                if (dealer.province) $('#province').val(dealer.province);
                if (dealer.housekeeping) $('#subscription').val(dealer.housekeeping);

                // Set hidden values for images
                $('#bannerHidden').val(dealer.banner || '');
                $('#logoHidden').val(dealer.logo || '');

                // Show existing images
                if (dealer.banner) {
                    $('#bannerPreview').attr('src', 'assets/images/banner.png').addClass('show');
                    $('#bannerFileName').text(dealer.banner);
                } else {
                    $('#bannerPreview').removeClass('show');
                    $('#bannerFileName').text('No file chosen');
                }

                if (dealer.logo) {
                    $('#logoPreview').attr('src', 'assets/images/system.png').addClass('show');
                    $('#logoFileName').text(dealer.logo);
                } else {
                    $('#logoPreview').removeClass('show');
                    $('#logoFileName').text('No file chosen');
                }

                // Load GRM -> RM -> TM hierarchy
                if (dealer.zm) {
                    $('#grm').val(dealer.zm);
                    loadRM(dealer.zm);
                    setTimeout(function() {
                        if (dealer.tm) {
                            $('#rm').val(dealer.tm);
                            loadTM(dealer.tm);
                            setTimeout(function() {
                                if (dealer.asm) {
                                    $('#tm').val(dealer.asm);
                                }
                            }, 500);
                        }
                    }, 500);
                }

                // Load dealer depots
                loadDealerDepots(id, function(depots) {
                    if (depots.length > 0) {
                        $('#depot').val(depots).trigger('change');
                    }
                });
            });
        }

        function closeOffcanvas() {
            $('#editOffcanvas').removeClass('open');
            setTimeout(function() {
                $('#overlay').removeClass('active');
            }, 350);
        }

        function openCreateModal() {
            $('#offcanvasTitle').text('Create Stations');
            $('#dealerId').val('');
            $('#siteName').val('');
            $('#dealerSap').val('');
            $('#dealerEmail').val('');
            $('#dealerPassword').val('');
            $('#dealerContact').val('');
            $('#accountBalance').val('');
            $('#coordinatesCircle').val('');
            $('#coordinatesPolygon').val('');
            $('#location').val('');
            $('#district').val('');
            $('#city').val('');
            $('#region').val('');
            $('#province').val('');
            $('#subscription').val('');
            $('#grm').val('');
            $('#rm').empty().append('<option value="">Select RM</option>');
            $('#tm').empty().append('<option value="">Select TM</option>');
            $('#depot').val([]).trigger('change');
            $('#bannerHidden').val('');
            $('#logoHidden').val('');
            $('#bannerPreview').removeClass('show');
            $('#logoPreview').removeClass('show');
            $('#bannerFileName').text('No file chosen');
            $('#logoFileName').text('No file chosen');
            $('#mapSearchInput').val('');
            $('#searchResults').removeClass('show').empty();

            // Reset map to default view
            setTimeout(function() {
                if (map) {
                    map.setView([30.3753, 69.3451], 5);
                    if (marker) {
                        marker.remove();
                        marker = null;
                    }
                }
            }, 300);

            $('#overlay').addClass('active');
            $('#editOffcanvas').addClass('open');

            // Initialize map after offcanvas opens
            setTimeout(function() {
                if (!mapInitialized) {
                    initMap();
                }
                setTimeout(function() {
                    if (map) {
                        map.invalidateSize();
                    }
                }, 100);
            }, 300);
        }

        // ============================================
        // Image Preview
        // ============================================
        function previewImage(input, previewId, hiddenId) {
            const file = input.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function(e) {
                $('#' + previewId).attr('src', e.target.result).addClass('show');
                $('#' + previewId.replace('Preview', 'FileName')).text(file.name);
            };
            reader.readAsDataURL(file);

            // Store file name in hidden field
            $('#' + hiddenId).val(file.name);
        }

        // ============================================
        // Save Dealer (Create/Update)
        // ============================================
        function saveDealer(event) {
            event.preventDefault();

            const id = $('#dealerId').val();
            const siteName = $('#siteName').val().trim();
            const sapNo = $('#dealerSap').val().trim();
            const email = $('#dealerEmail').val().trim();
            const password = $('#dealerPassword').val().trim();
            const contact = $('#dealerContact').val().trim();
            const account = $('#accountBalance').val().trim() || '0';
            const coordinates = $('#coordinatesCircle').val().trim() || '';
            const location = $('#location').val().trim() || '';
            const district = $('#district').val();
            const city = $('#city').val();
            const region = $('#region').val();
            const province = $('#province').val();
            const subscription = $('#subscription').val();
            const grm = $('#grm').val();
            const rm = $('#rm').val();
            const tm = $('#tm').val();
            const bannerFile = $('#bannerInput')[0].files[0];
            const logoFile = $('#logoInput')[0].files[0];
            const bannerHidden = $('#bannerHidden').val();
            const logoHidden = $('#logoHidden').val();

            if (!siteName || !sapNo || !email || !contact) {
                showToast('Please fill in all required fields.', 'error');
                return;
            }

            const submitBtn = $('#dealerForm button[type="submit"]');
            submitBtn.prop('disabled', true);
            submitBtn.html('<i class="fa-solid fa-spinner fa-spin mr-1"></i> Saving...');

            const formData = new FormData();

            if (id) {
                formData.append('row_id', id);
                formData.append('id', id);
            }
            formData.append('dealer_name', siteName);
            formData.append('dealer_sap_no', sapNo);
            formData.append('emails', email);
            if (password) formData.append('password', password);
            formData.append('call_no', contact);
            formData.append('account_balanced', account);
            formData.append('lati', coordinates);
            formData.append('poly', coordinates);
            formData.append('location', location);
            formData.append('district', district);
            formData.append('city', city);
            formData.append('region', region);
            formData.append('province', province);
            formData.append('housekeeping', subscription);
            formData.append('zm', grm);
            formData.append('tm', rm);
            formData.append('asm', tm);
            formData.append('user_id', USER_ID);

            // For update, pass existing images if no new file selected
            if (bannerFile) {
                formData.append('banner_img', bannerFile);
            } else if (bannerHidden) {
                formData.append('banner_img_hidden', bannerHidden);
            }

            if (logoFile) {
                formData.append('logo_img', logoFile);
            } else if (logoHidden) {
                formData.append('logo_img_hidden', logoHidden);
            }

            // For depots (multiple select)
            const depots = $('#depot').val();
            if (depots && depots.length > 0) {
                $.each(depots, function(i, val) {
                    formData.append('depots[]', val);
                });
            }

            const url = id ? API_BASE_URL + 'update/dealer_update.php' : API_BASE_URL + 'create/dealers.php';

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(response) {
                    submitBtn.prop('disabled', false);
                    submitBtn.html('Save');

                    if (response === 1) {
                        showToast(id ? 'Dealer updated successfully!' : 'Dealer created successfully!', 'success');
                        closeOffcanvas();
                        loadDealers();
                    } else {
                        showToast('Failed to save dealer. Please try again.', 'error');
                    }
                },
                error: function(xhr, status, error) {
                    submitBtn.prop('disabled', false);
                    submitBtn.html('Save');
                    console.error('Save Error:', status, error);
                    showToast('Error saving dealer: ' + status, 'error');
                }
            });
        }

        // ============================================
        // Toast Notification
        // ============================================
        function showToast(message, type = 'success') {
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

        // Close modal on outside click
        $(document).on('click', '#passwordModal', function(e) {
            if (e.target === this) closePasswordModal();
        });

        // Close offcanvas on ESC key
        $(document).on('keydown', function(e) {
            if (e.key === 'Escape') {
                if ($('#editOffcanvas').hasClass('open')) {
                    closeOffcanvas();
                }
                if (!$('#passwordModal').hasClass('hidden')) {
                    closePasswordModal();
                }
                closeColumnDropdown();
            }
        });
    </script>

</body>

</html>