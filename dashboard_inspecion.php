<?php
// Hascol OMC Operations Command Center - Inspection Dashboard
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hascol OMC - Inspection Dashboard</title>
    
    <!-- ===== REFERENCE THEME CSS ===== -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

    <!-- ===== CHOICES.JS FOR MULTI-SELECT ===== -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

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
            --chart-text-color: #334155;
            --chart-grid-color: rgba(0, 0, 0, 0.05);
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
            --chart-text-color: #e5e7eb;
            --chart-grid-color: rgba(255, 255, 255, 0.05);
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
        #sidebar, #mainContent {
            transition: all 0.3s ease-in-out;
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
            font-size: 11px;
            font-weight: 500;
            margin-bottom: 4px;
            display: block;
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

        .choices {
            margin-bottom: 0 !important;
        }
        .choices__inner {
            background-color: var(--input-bg) !important;
            border: 1px solid var(--border-color) !important;
            border-radius: 0.25rem !important;
            padding: 2px 8px !important;
            min-height: 32px !important;
            max-height: 120px !important;
            overflow-y: auto !important;
            transition: border-color 0.2s !important;
        }
        .choices__inner::-webkit-scrollbar {
            width: 4px !important;
            height: 4px !important;
        }
        .choices__inner::-webkit-scrollbar-track {
            background: var(--scrollbar-track) !important;
            border-radius: 4px !important;
        }
        .choices__inner::-webkit-scrollbar-thumb {
            background: var(--scrollbar-thumb) !important;
            border-radius: 4px !important;
        }
        .choices__inner::-webkit-scrollbar-thumb:hover {
            background: #1d4ed8 !important;
        }

        .choices__inner:focus-within {
            border-color: #1d4ed8 !important;
            box-shadow: 0 0 0 2px rgba(29, 78, 216, 0.2) !important;
        }
        .choices__input {
            background-color: var(--input-bg) !important;
            color: var(--text-body) !important;
            font-size: 12px !important;
            padding: 4px 0 !important;
            margin-bottom: 0 !important;
            font-family: 'Inter', sans-serif !important;
            min-width: 80px !important;
        }
        .choices__input::placeholder {
            color: var(--text-muted) !important;
        }
        .choices__list--multiple .choices__item {
            background-color: #1d4ed8 !important;
            border: 1px solid #1d4ed8 !important;
            border-radius: 0.25rem !important;
            font-size: 10px !important;
            padding: 2px 8px !important;
            margin: 2px 4px 2px 0 !important;
            font-weight: 500 !important;
            display: inline-flex !important;
            align-items: center !important;
            flex-shrink: 0 !important;
        }
        .choices__list--multiple .choices__item.is-highlighted {
            background-color: #2563eb !important;
            border-color: #2563eb !important;
        }
        .choices__list--dropdown {
            background-color: var(--dropdown-bg) !important;
            border: 1px solid var(--border-color) !important;
            border-radius: 0.25rem !important;
            margin-top: 4px !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15) !important;
            max-height: 200px !important;
            overflow-y: auto !important;
        }
        .choices__list--dropdown .choices__item {
            color: var(--text-body) !important;
            font-size: 12px !important;
            padding: 8px 12px !important;
            transition: background-color 0.15s !important;
        }
        .choices__list--dropdown .choices__item.is-selected {
            background-color: var(--hover-bg) !important;
        }
        .choices__list--dropdown .choices__item.is-highlighted {
            background-color: var(--dropdown-hover) !important;
            color: var(--text-heading) !important;
        }
        .choices__list--dropdown .choices__placeholder {
            color: var(--text-muted) !important;
        }
        .choices__placeholder {
            color: var(--text-muted) !important;
            opacity: 0.7 !important;
        }
        .choices__button {
            border-left: 1px solid rgba(255, 255, 255, 0.3) !important;
            margin-left: 6px !important;
            padding-left: 6px !important;
        }
        .choices__button:hover {
            background-color: rgba(255, 255, 255, 0.2) !important;
            border-radius: 0 0.25rem 0.25rem 0 !important;
        }
        .choices__list--dropdown .choices__item--selectable {
            padding-right: 30px !important;
        }

        .choices__item--selectable.is-highlighted::after {
            display: none !important;
            content: '' !important;
        }
        .choices__item--choice .choices__item--selectable::after {
            display: none !important;
            content: '' !important;
        }
        .choices__list--dropdown .choices__item--selectable.is-highlighted::after {
            display: none !important;
            content: '' !important;
        }

        html.dark-mode .choices__inner {
            background-color: var(--input-bg) !important;
            border-color: var(--border-color) !important;
        }
        html.dark-mode .choices__input {
            background-color: var(--input-bg) !important;
            color: var(--text-body) !important;
        }
        html.dark-mode .choices__list--dropdown {
            background-color: var(--dropdown-bg) !important;
            border-color: var(--border-color) !important;
        }
        html.dark-mode .choices__list--dropdown .choices__item {
            color: var(--text-body) !important;
        }
        html.dark-mode .choices__list--dropdown .choices__item.is-highlighted {
            background-color: var(--dropdown-hover) !important;
            color: var(--text-heading) !important;
        }
        html.dark-mode .choices__list--dropdown .choices__item.is-selected {
            background-color: var(--hover-bg) !important;
        }
        html.dark-mode .choices__list--multiple .choices__item {
            background-color: #2563eb !important;
            border-color: #2563eb !important;
        }
        html.dark-mode .choices__inner::-webkit-scrollbar-track {
            background: var(--scrollbar-track) !important;
        }
        html.dark-mode .choices__inner::-webkit-scrollbar-thumb {
            background: var(--scrollbar-thumb) !important;
        }
        html.dark-mode .choices__inner::-webkit-scrollbar-thumb:hover {
            background: #1d4ed8 !important;
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

        .kpi-card {
            background-color: var(--bg-panel);
            border: 1px solid var(--border-color);
            border-radius: 0.375rem;
            padding: 16px;
            transition: all 0.3s ease;
        }
        .kpi-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        }
        .kpi-icon {
            width: 40px;
            height: 40px;
            border-radius: 0.375rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }
        .kpi-icon.blue { background: rgba(29, 78, 216, 0.12); color: #1d4ed8; }
        .kpi-icon.green { background: rgba(16, 185, 129, 0.12); color: #10b981; }
        .kpi-icon.red { background: rgba(239, 68, 68, 0.12); color: #ef4444; }
        .kpi-icon.yellow { background: rgba(245, 158, 11, 0.12); color: #f59e0b; }

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
            padding: 10px 12px;
            border-bottom: 1px solid var(--border-color);
            white-space: nowrap;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .table-container table tbody td {
            padding: 10px 12px;
            border-bottom: 1px solid var(--border-color);
            color: var(--table-row-text);
            vertical-align: middle;
        }
        .table-container table tbody tr:hover {
            background-color: var(--table-row-hover);
        }

        .badge {
            padding: 2px 10px;
            border-radius: 9999px;
            font-size: 9px;
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
        .badge-secondary {
            background: #64748b20;
            color: #64748b;
            border: 1px solid #64748b40;
        }

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
        /* .dataTables_wrapper .dataTables_paginate {
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
        } */

        .dt-buttons {
            display: flex !important;
            gap: 6px !important;
            flex-wrap: wrap !important;
            align-items: center !important;
            margin: 0 !important;
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

        .table-toolbar {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 8px;
            margin-bottom: 12px;
            padding: 0;
            width: 100%;
        }
        .table-toolbar .dt-buttons {
            flex: 0 0 auto;
            margin: 0 !important;
        }
        .table-toolbar .search-box {
            position: relative;
            flex: 1;
            min-width: 150px;
            max-width: 250px;
            margin-left: auto;
        }
        .table-toolbar .search-box input {
            background-color: var(--input-bg);
            border: 1px solid var(--border-color);
            border-radius: 0.25rem;
            color: var(--text-body);
            padding: 5px 10px 5px 30px;
            width: 100%;
            font-size: 11px;
            transition: border-color 0.2s;
            height: 30px;
        }
        .table-toolbar .search-box input:focus {
            outline: none;
            border-color: #1d4ed8;
            box-shadow: 0 0 0 2px rgba(29, 78, 216, 0.2);
        }
        .table-toolbar .search-box input::placeholder {
            color: var(--text-muted);
        }
        .table-toolbar .search-box i {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 11px;
        }
        .table-toolbar .colvis-container {
            position: relative;
            flex: 0 0 auto;
        }
        .table-toolbar .colvis-container .colvis-toggle {
            background-color: var(--toolbar-btn-bg) !important;
            border: 1px solid var(--border-color) !important;
            border-radius: 0.25rem !important;
            color: var(--text-muted) !important;
            padding: 5px 12px !important;
            font-size: 10px !important;
            cursor: pointer !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 4px !important;
            font-family: 'Inter', sans-serif !important;
            height: 30px !important;
            box-sizing: border-box !important;
            transition: all 0.2s !important;
            background: var(--toolbar-btn-bg);
        }
        .table-toolbar .colvis-container .colvis-toggle:hover {
            background-color: var(--hover-bg) !important;
            color: var(--text-heading) !important;
        }

        .colvis-dropdown {
            position: fixed;
            background-color: var(--dropdown-bg);
            border: 1px solid var(--border-color);
            border-radius: 0.375rem;
            padding: 6px 0;
            min-width: 190px;
            max-height: 280px;
            overflow-y: auto;
            overflow-x: hidden;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
            z-index: 99999;
            display: none;
        }

        .colvis-dropdown::-webkit-scrollbar {
            width: 5px;
            height: 5px;
        }
        .colvis-dropdown::-webkit-scrollbar-track {
            background: var(--scrollbar-track);
            border-radius: 4px;
        }
        .colvis-dropdown::-webkit-scrollbar-thumb {
            background: var(--scrollbar-thumb);
            border-radius: 4px;
        }
        .colvis-dropdown::-webkit-scrollbar-thumb:hover {
            background: #1d4ed8;
        }

        html.dark-mode .colvis-dropdown::-webkit-scrollbar-track {
            background: var(--scrollbar-track);
        }
        html.dark-mode .colvis-dropdown::-webkit-scrollbar-thumb {
            background: var(--scrollbar-thumb);
        }
        html.dark-mode .colvis-dropdown::-webkit-scrollbar-thumb:hover {
            background: #1d4ed8;
        }

        .colvis-dropdown.show {
            display: block;
        }
        .colvis-dropdown .colvis-header {
            display: flex;
            gap: 6px;
            padding: 4px 12px 8px 12px;
            border-bottom: 1px solid var(--border-color);
            margin-bottom: 4px;
            flex-wrap: wrap;
        }
        .colvis-dropdown .colvis-header button {
            padding: 3px 10px;
            font-size: 9px;
            border-radius: 0.25rem;
            border: 1px solid var(--border-color);
            background: var(--toolbar-btn-bg);
            color: var(--text-muted);
            cursor: pointer;
            transition: all 0.2s;
            font-family: 'Inter', sans-serif;
        }
        .colvis-dropdown .colvis-header button:hover {
            background: var(--hover-bg);
            color: var(--text-heading);
        }
        .colvis-dropdown .colvis-header button.select-all-btn {
            background: #1d4ed8;
            color: #ffffff;
            border-color: #1d4ed8;
        }
        .colvis-dropdown .colvis-header button.select-all-btn:hover {
            background: #2563eb;
        }
        .colvis-dropdown .colvis-header button.deselect-all-btn {
            background: #ef4444;
            color: #ffffff;
            border-color: #ef4444;
        }
        .colvis-dropdown .colvis-header button.deselect-all-btn:hover {
            background: #dc2626;
        }
        .colvis-dropdown .colvis-item {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 5px 12px;
            color: var(--text-body);
            font-size: 11px;
            cursor: pointer;
            transition: background-color 0.15s;
        }
        .colvis-dropdown .colvis-item:hover {
            background-color: var(--dropdown-hover);
        }
        .colvis-dropdown .colvis-item input[type="checkbox"] {
            width: 14px;
            height: 14px;
            cursor: pointer;
            accent-color: #1d4ed8;
            flex-shrink: 0;
        }
        .colvis-dropdown .colvis-item label {
            cursor: pointer;
            flex: 1;
        }

        .chart-container {
            background-color: var(--bg-panel);
            border: 1px solid var(--border-color);
            border-radius: 0.375rem;
            padding: 16px;
            transition: background-color .25s ease, border-color .25s ease;
            height: 100%;
        }
        .chart-container canvas {
            max-height: 300px;
            max-width: 100%;
        }

        .spinner-overlay {
            position: absolute;
            inset: 0;
            background: rgba(255, 255, 255, 0.7);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 10;
            border-radius: 0.375rem;
        }
        html.dark-mode .spinner-overlay {
            background: rgba(6, 11, 19, 0.7);
        }
        .spinner-overlay.show {
            display: flex;
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
        .toast.show {
            transform: translateY(0);
            opacity: 1;
        }
        .toast.success { border-color: #10b981; }
        .toast.success i { color: #10b981; }
        .toast.error { border-color: #ef4444; }
        .toast.error i { color: #ef4444; }

        @media (max-width: 768px) {
            .kpi-card { padding: 12px; }
            .kpi-card .text-2xl { font-size: 1.3rem; }
            .chart-container { padding: 12px; }
            .chart-container canvas { max-height: 200px; }
            .table-toolbar {
                flex-wrap: wrap;
                gap: 6px;
            }
            .table-toolbar .search-box {
                flex: 1 1 100%;
                max-width: 100%;
                margin-left: 0;
                order: 10;
            }
            .table-toolbar .dt-buttons {
                flex: 0 0 auto;
            }
            .table-toolbar .colvis-container {
                flex: 0 0 auto;
            }
        }
        @media (max-width: 640px) {
            .grid-cols-2 { grid-template-columns: 1fr; }
            .dt-buttons .dt-button { font-size: 8px !important; padding: 4px 8px !important; }
        }

        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: var(--scrollbar-track); }
        ::-webkit-scrollbar-thumb { background: var(--scrollbar-thumb); border-radius: 4px; }
    </style>
</head>

<body class="flex h-screen overflow-hidden text-xs">

    <!-- SIDEBAR - Reference File Style -->
    <?php include 'includes/sidebar.php'; ?>

    <!-- MAIN CONTENT -->
    <main id="mainContent" class="flex-1 flex flex-col overflow-hidden">

        <!-- TOPBAR - Reference File Style -->
        <?php include 'includes/topbar.php'; ?>

        <!-- PAGE CONTENT -->
        <div class="flex-1 overflow-y-auto p-4" id="pageContent">

            <!-- Page Header -->
            <div class="flex flex-wrap justify-between items-center mb-4 gap-2">
                <div>
                    <h2 class="text-heading font-semibold text-base tracking-wide uppercase">
                        <i class="fa-solid fa-clipboard-list mr-2 text-blue-500"></i>Inspection Dashboard
                    </h2>
                    <p class="text-[10px] text-gray-500">Manage inspections, surveys and reports</p>
                </div>
                <button onclick="refreshData()" class="btn-secondary flex items-center gap-2">
                    <i class="fa-solid fa-rotate"></i> Refresh
                </button>
            </div>

            <!-- FILTERS SECTION - Reference Style -->
            <div class="panel-card p-4 mb-4">
                <div class="flex flex-wrap items-center justify-between gap-2 mb-3">
                    <h5 class="text-heading font-semibold text-sm">
                        <i class="fa-solid fa-sliders-h mr-2 text-blue-500"></i> Advanced Filters
                    </h5>
                    <span id="filterIndicator" class="text-[10px] text-gray-500"></span>
                </div>
                
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3">
                    <div>
                        <label class="form-label"><i class="fa-regular fa-calendar mr-1"></i> From Date</label>
                        <input type="date" id="fromDate" class="form-input" value="2026-08-01">
                    </div>
                    <div>
                        <label class="form-label"><i class="fa-regular fa-calendar-check mr-1"></i> To Date</label>
                        <input type="date" id="toDate" class="form-input" value="2026-08-31">
                    </div>
                    <div>
                        <label class="form-label"><i class="fa-solid fa-building mr-1"></i> Dealers</label>
                        <select id="dealerSelect" class="form-select" multiple></select>
                    </div>
                    <div>
                        <label class="form-label"><i class="fa-solid fa-check-circle mr-1"></i> Response</label>
                        <select id="responseFilter" class="form-select">
                            <option value="">All</option>
                            <option value="yes">Yes</option>
                            <option value="no">No</option>
                            <option value="N/A">N/A</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label"><i class="fa-solid fa-tags mr-1"></i> Categories</label>
                        <select id="categoryFilter" class="form-select" multiple></select>
                    </div>
                    <div>
                        <label class="form-label"><i class="fa-solid fa-question-circle mr-1"></i> Questions</label>
                        <select id="questionFilter" class="form-select" multiple></select>
                    </div>
                </div>

                <div class="flex flex-wrap gap-2 mt-3">
                    <button onclick="applyFilters()" class="btn-primary flex items-center gap-2">
                        <i class="fa-solid fa-search"></i> Apply Filters
                    </button>
                    <button onclick="clearFilters()" class="btn-secondary flex items-center gap-2">
                        <i class="fa-solid fa-undo"></i> Clear
                    </button>
                </div>
            </div>

            <!-- KPI CARDS -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                <div class="kpi-card">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[10px] uppercase text-gray-500 font-medium">Total Inspections</p>
                            <p class="text-2xl font-bold text-heading" id="inspectionCount">--</p>
                        </div>
                        <div class="kpi-icon blue"><i class="fa-solid fa-clipboard-check"></i></div>
                    </div>
                </div>
                <div class="kpi-card">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[10px] uppercase text-gray-500 font-medium">Total YES</p>
                            <p class="text-2xl font-bold text-heading" id="yesCount">--</p>
                        </div>
                        <div class="kpi-icon green"><i class="fa-solid fa-check-circle"></i></div>
                    </div>
                </div>
                <div class="kpi-card">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[10px] uppercase text-gray-500 font-medium">Total NO</p>
                            <p class="text-2xl font-bold text-heading" id="noCount">--</p>
                        </div>
                        <div class="kpi-icon red"><i class="fa-solid fa-times-circle"></i></div>
                    </div>
                </div>
                <div class="kpi-card">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[10px] uppercase text-gray-500 font-medium">Total N/A</p>
                            <p class="text-2xl font-bold text-heading" id="naCount">--</p>
                        </div>
                        <div class="kpi-icon yellow"><i class="fa-solid fa-minus-circle"></i></div>
                    </div>
                </div>
            </div>

            <!-- Loading Indicator -->
            <div id="inspectionLoader" class="text-center my-3" style="display: none;">
                <div class="inline-block animate-spin rounded-full h-8 w-8 border-4 border-blue-500 border-t-transparent"></div>
                <p class="mt-2 text-gray-500 text-xs">Loading dashboard data...</p>
            </div>

            <!-- CHARTS ROW - Reference Style -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-4">
                <div class="chart-container">
                    <h6 class="text-heading font-semibold text-sm mb-3">
                        <i class="fa-solid fa-chart-pie mr-2 text-blue-500"></i> Response Distribution
                    </h6>
                    <div style="position:relative; height:300px;">
                        <canvas id="yesNoChart"></canvas>
                    </div>
                </div>
                <div class="chart-container">
                    <h6 class="text-heading font-semibold text-sm mb-3">
                        <i class="fa-solid fa-chart-bar mr-2 text-blue-500"></i> Issues Analysis
                        <span class="text-[10px] text-gray-500 font-normal ml-2">(Click bar for details)</span>
                    </h6>
                    <div style="position:relative; height:300px;">
                        <canvas id="issueChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- FILTERED RESULTS SECTION -->
            <div id="filterResultsSection" class="panel-card p-4 mb-4" style="display:none;">
                <h5 class="text-heading font-semibold text-sm mb-3">
                    <i class="fa-solid fa-filter-circle mr-2 text-blue-500"></i> Filtered Results Analysis
                </h5>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-4">
                    <div class="chart-container">
                        <h6 class="text-heading font-semibold text-xs mb-2">
                            <i class="fa-solid fa-chart-pie mr-1"></i> Category Distribution
                        </h6>
                        <div style="position:relative; height:200px;">
                            <canvas id="filterCategoryChart"></canvas>
                        </div>
                    </div>
                    <div class="chart-container">
                        <h6 class="text-heading font-semibold text-xs mb-2">
                            <i class="fa-solid fa-chart-line mr-1"></i> Timeline Analysis
                        </h6>
                        <div style="position:relative; height:200px;">
                            <canvas id="filterTimelineChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="chart-container">
                    <h6 class="text-heading font-semibold text-xs mb-2">
                        <i class="fa-solid fa-list mr-1"></i> Detailed Response List
                    </h6>
                    <div id="responseList" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2"></div>
                    <div class="flex flex-wrap gap-2 justify-center mt-3">
                        <button class="btn-secondary text-xs" id="loadMoreBtn" onclick="loadMoreResponses()" style="display:none;">
                            <i class="fa-solid fa-arrow-down mr-1"></i> Load More
                        </button>
                        <button class="btn-secondary text-xs" id="loadLessBtn" onclick="loadLessResponses()" style="display:none;">
                            <i class="fa-solid fa-arrow-up mr-1"></i> Load Less
                        </button>
                    </div>
                </div>
            </div>

            <!-- ALL INSPECTIONS TABLE -->
            <div class="panel-card overflow-hidden">
                <div class="p-3 border-b" style="border-color: var(--border-color);">
                    <h5 class="text-heading font-semibold text-sm">
                        <i class="fa-solid fa-table mr-2 text-blue-500"></i> All Inspections
                    </h5>
                </div>
                <div class="p-3 relative">
                    <div class="spinner-overlay" id="tableLoadingOverlay">
                        <div class="inline-block animate-spin rounded-full h-8 w-8 border-4 border-blue-500 border-t-transparent"></div>
                    </div>
                    
                    <div class="table-toolbar" id="tableToolbar">
                        <div class="search-box">
                            <i class="fa-solid fa-search"></i>
                            <input type="text" id="tableSearchInput" placeholder="Search inspections...">
                        </div>
                        <div class="colvis-container">
                            <button class="colvis-toggle" onclick="toggleColvisDropdown()">
                                <i class="fa-solid fa-columns"></i> Columns
                                <i class="fa-solid fa-chevron-down ml-1 text-[8px]"></i>
                            </button>
                            <div id="colvisDropdown" class="colvis-dropdown">
                                <div class="colvis-header">
                                    <button class="select-all-btn" onclick="selectAllColumns()">
                                        <i class="fa-solid fa-check-double"></i> All
                                    </button>
                                    <button class="deselect-all-btn" onclick="deselectAllColumns()">
                                        <i class="fa-solid fa-ban"></i> None
                                    </button>
                                </div>
                                <div id="colvisItems"></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="table-container">
                        <table id="allInspectionsTable" class="display" style="width:100%;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Dealer Name</th>
                                    <th>SAP No</th>
                                    <th>Site</th>
                                    <th>Category</th>
                                    <th>Question</th>
                                    <th>Response</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- CATEGORIES & QUESTIONS TABLES -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mt-4">
                <div class="panel-card overflow-hidden">
                    <div class="p-3 border-b" style="border-color: var(--border-color);">
                        <h5 class="text-heading font-semibold text-sm">
                            <i class="fa-solid fa-tags mr-2 text-blue-500"></i> Approved Categories
                        </h5>
                    </div>
                    <div class="p-3">
                        <div class="table-container">
                            <table id="categoryTable" class="display" style="width:100%;">
                                <thead><tr><th>ID</th><th>Category Name</th></tr></thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="panel-card overflow-hidden">
                    <div class="p-3 border-b" style="border-color: var(--border-color);">
                        <h5 class="text-heading font-semibold text-sm">
                            <i class="fa-solid fa-question-circle mr-2 text-blue-500"></i> Approved Questions
                        </h5>
                    </div>
                    <div class="p-3">
                        <div class="table-container">
                            <table id="questionTable" class="display" style="width:100%;">
                                <thead><tr><th>ID</th><th>Question</th></tr></thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>

  <!-- TOAST NOTIFICATION -->
<div id="toast" class="toast">
    <i class="fa-solid fa-check-circle mr-2"></i>
    <span id="toastMessage"></span>
</div>

    <!-- ISSUE DETAIL MODAL -->
    <div id="issueModal" class="fixed inset-0 z-50 hidden bg-black/50 backdrop-blur-sm flex items-center justify-center transition-opacity duration-300 opacity-0">
        <div class="bg-panel border border-border rounded-lg shadow-2xl w-full max-w-4xl max-h-[90vh] flex flex-col transform scale-95 transition-transform duration-300" id="issueModalWrapper">
            <div class="flex justify-between items-center p-4 border-b" style="border-color: var(--border-color);">
                <h3 class="text-heading font-semibold text-sm">
                    <i class="fa-solid fa-exclamation-triangle mr-2 text-yellow-500"></i> Issue Details
                </h3>
                <button onclick="closeIssueModal()" class="text-gray-400 hover:text-red-500 transition">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>
            <div class="flex-1 overflow-y-auto p-4" id="issueModalBody"></div>
        </div>
    </div>

    <!-- SCRIPTS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

    <script>
        function toggleDarkMode() {
            const html = document.documentElement;
            const isDark = html.classList.toggle('dark-mode');
            localStorage.setItem('darkMode', isDark);
            const icon = document.querySelector('.dark-mode-toggle i');
            if (icon) {
                icon.className = isDark ? 'fa-solid fa-sun' : 'fa-solid fa-moon';
            }
            updateChartColors();
            refreshChoicesStyles();
        }

        $(document).ready(function() {
            $('#sidebarToggle').on('click', function() {
                $('#sidebar').toggleClass('collapsed');
                const isCollapsed = $('#sidebar').hasClass('collapsed');
                localStorage.setItem('sidebarCollapsed', isCollapsed);
            });
            const savedState = localStorage.getItem('sidebarCollapsed');
            if (savedState === 'true') {
                $('#sidebar').addClass('collapsed');
            }c:\Users\P2P\Downloads\containers_sizes.php

            const isDarkMode = localStorage.getItem('darkMode') === 'true';
            const icon = document.querySelector('.dark-mode-toggle i');
            if (icon) {
                icon.className = isDarkMode ? 'fa-solid fa-sun' : 'fa-solid fa-moon';
            }

            initChoices();
            loadCategories();
            loadQuestions();
            loadDealers();
            loadDashboard();

            $('#fromDate, #toDate, #responseFilter').on('change', updateFilterIndicator);

            $(document).on('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeIssueModal();
                }
            });

            $(document).on('click', function(e) {
                if (!$(e.target).closest('#colvisDropdown').length && !$(e.target).closest('.colvis-toggle').length) {
                    $('#colvisDropdown').removeClass('show');
                }
            });

            $(window).on('resize scroll', true, function() {
                if ($('#colvisDropdown').hasClass('show')) {
                    positionColvisDropdown();
                }
            });
        });

        const API_BASE = 'api/';
        let issueChart, yesNoChart, filterCategoryChart, filterTimelineChart;
        let allFilteredResponses = [];
        let displayedResponses = 0;
        const responsesPerPage = 12;
        let allInspectionsTable = null;
        let categoryTable = null;
        let questionTable = null;
        
        let dealerChoices = null;
        let categoryChoices = null;
        let questionChoices = null;

        const columnHeaders = ['#', 'Date', 'Dealer Name', 'SAP No', 'Site', 'Category', 'Question', 'Response', 'Description'];

        function initChoices() {
            if (dealerChoices) dealerChoices.destroy();
            if (categoryChoices) categoryChoices.destroy();
            if (questionChoices) questionChoices.destroy();

            const commonConfig = {
                removeItemButton: true,
                placeholder: true,
                placeholderValue: 'Select options...',
                searchPlaceholderValue: 'Type to search...',
                noResultsText: 'No results found',
                noChoicesText: 'No options available',
                itemSelectText: '',
                shouldSort: false,
                searchFields: ['label'],
                position: 'auto',
                classNames: {
                    containerOuter: 'choices',
                    containerInner: 'choices__inner',
                    input: 'choices__input',
                    inputCloned: 'choices__input--cloned',
                    list: 'choices__list',
                    listItems: 'choices__list--multiple',
                    listSingle: 'choices__list--single',
                    listDropdown: 'choices__list--dropdown',
                    item: 'choices__item',
                    itemSelectable: 'choices__item--selectable',
                    itemDisabled: 'choices__item--disabled',
                    itemChoice: 'choices__item--choice',
                    placeholder: 'choices__placeholder',
                    group: 'choices__group',
                    groupHeading: 'choices__heading',
                    button: 'choices__button',
                    activeState: 'is-active',
                    focusState: 'is-focused',
                    openState: 'is-open',
                    disabledState: 'is-disabled',
                    highlightedState: 'is-highlighted',
                    selectedState: 'is-selected',
                    flippedState: 'is-flipped',
                    loadingState: 'is-loading',
                    noResults: 'has-no-results',
                    noChoices: 'has-no-choices'
                }
            };

            const dealerElement = document.getElementById('dealerSelect');
            if (dealerElement) {
                dealerChoices = new Choices(dealerElement, {
                    ...commonConfig,
                    placeholderValue: 'Select dealers...',
                    searchPlaceholderValue: 'Search dealers...'
                });
                dealerElement.addEventListener('change', function() {
                    updateFilterIndicator();
                });
            }

            const categoryElement = document.getElementById('categoryFilter');
            if (categoryElement) {
                categoryChoices = new Choices(categoryElement, {
                    ...commonConfig,
                    placeholderValue: 'Select categories...',
                    searchPlaceholderValue: 'Search categories...'
                });
                categoryElement.addEventListener('change', function() {
                    updateFilterIndicator();
                });
            }

            const questionElement = document.getElementById('questionFilter');
            if (questionElement) {
                questionChoices = new Choices(questionElement, {
                    ...commonConfig,
                    placeholderValue: 'Select questions...',
                    searchPlaceholderValue: 'Search questions...'
                });
                questionElement.addEventListener('change', function() {
                    updateFilterIndicator();
                });
            }

            refreshChoicesStyles();
        }

        function refreshChoicesStyles() {
            if (dealerChoices) dealerChoices._renderItems();
            if (categoryChoices) categoryChoices._renderItems();
            if (questionChoices) questionChoices._renderItems();
        }

        function loadDealers() {
            $.ajax({
                url: API_BASE + 'get/get_dealers.php',
                type: 'GET',
                dataType: 'json',
                success: function(res) {
                    const options = [];
                    if (Array.isArray(res)) {
                        res.forEach(function(d) {
                            options.push({ value: d.id, label: d.name });
                        });
                    }
                    if (dealerChoices) {
                        dealerChoices.clearChoices();
                        dealerChoices.setChoices(options, 'value', 'label', true);
                    }
                },
                error: function() {
                    console.error('Failed to load dealers');
                }
            });
        }

        function loadCategories() {
            $.ajax({
                url: API_BASE + 'get/get_categories.php',
                type: 'GET',
                dataType: 'json',
                success: function(res) {
                    const options = [];
                    if (Array.isArray(res)) {
                        res.forEach(function(c) {
                            options.push({ value: c.id, label: c.name });
                        });
                    }
                    if (categoryChoices) {
                        categoryChoices.clearChoices();
                        categoryChoices.setChoices(options, 'value', 'label', true);
                    }
                    
                    if (categoryTable) {
                        categoryTable.destroy();
                    }
                    categoryTable = $('#categoryTable').DataTable({
                        data: Array.isArray(res) ? res : [],
                        columns: [
                            { data: 'id', title: 'ID' },
                            { data: 'name', title: 'Category Name' }
                        ],
                        pageLength: 5,
                        ordering: true,
                        dom: 'Bfrtip',
                        buttons: [
                            { extend: 'copy', text: '<i class="fa-regular fa-copy"></i>', className: 'dt-button' },
                            { extend: 'csv', text: '<i class="fa-regular fa-file-csv"></i>', className: 'dt-button' },
                            { extend: 'excel', text: '<i class="fa-regular fa-file-excel"></i>', className: 'dt-button' },
                            { extend: 'pdf', text: '<i class="fa-regular fa-file-pdf"></i>', className: 'dt-button' }
                        ],
                        language: {
                            emptyTable: 'No categories found',
                            info: 'Showing _START_ to _END_ of _TOTAL_',
                            infoEmpty: 'Showing 0 to 0 of 0'
                        }
                    });
                },
                error: function() {
                    console.error('Failed to load categories');
                }
            });
        }

        function loadQuestions() {
            $.ajax({
                url: API_BASE + 'get/get_all_questions.php',
                type: 'GET',
                dataType: 'json',
                success: function(res) {
                    const options = [];
                    if (Array.isArray(res)) {
                        res.forEach(function(q) {
                            options.push({ value: q.id, label: q.question });
                        });
                    }
                    if (questionChoices) {
                        questionChoices.clearChoices();
                        questionChoices.setChoices(options, 'value', 'label', true);
                    }
                    
                    if (questionTable) {
                        questionTable.destroy();
                    }
                    questionTable = $('#questionTable').DataTable({
                        data: Array.isArray(res) ? res : [],
                        columns: [
                            { data: 'id', title: 'ID' },
                            { data: 'question', title: 'Question' }
                        ],
                        pageLength: 5,
                        ordering: true,
                        dom: 'Bfrtip',
                        buttons: [
                            { extend: 'copy', text: '<i class="fa-regular fa-copy"></i>', className: 'dt-button' },
                            { extend: 'csv', text: '<i class="fa-regular fa-file-csv"></i>', className: 'dt-button' },
                            { extend: 'excel', text: '<i class="fa-regular fa-file-excel"></i>', className: 'dt-button' },
                            { extend: 'pdf', text: '<i class="fa-regular fa-file-pdf"></i>', className: 'dt-button' }
                        ],
                        language: {
                            emptyTable: 'No questions found',
                            info: 'Showing _START_ to _END_ of _TOTAL_',
                            infoEmpty: 'Showing 0 to 0 of 0'
                        }
                    });
                },
                error: function() {
                    console.error('Failed to load questions');
                }
            });
        }

        function getFilters() {
            let dealerValues = [];
            let categoryValues = [];
            let questionValues = [];
            
            if (dealerChoices) {
                const selected = dealerChoices.getValue(true);
                dealerValues = Array.isArray(selected) ? selected : (selected ? [selected] : []);
            }
            
            if (categoryChoices) {
                const selected = categoryChoices.getValue(true);
                categoryValues = Array.isArray(selected) ? selected : (selected ? [selected] : []);
            }
            
            if (questionChoices) {
                const selected = questionChoices.getValue(true);
                questionValues = Array.isArray(selected) ? selected : (selected ? [selected] : []);
            }

            return {
                from_date: $('#fromDate').val(),
                to_date: $('#toDate').val(),
                dealers: dealerValues,
                response: $('#responseFilter').val(),
                categories: categoryValues,
                questions: questionValues
            };
        }

        function updateFilterIndicator() {
            const filters = getFilters();
            const hasFilters = filters.from_date || filters.to_date ||
                (filters.dealers && filters.dealers.length > 0) ||
                filters.response ||
                (filters.categories && filters.categories.length > 0) ||
                (filters.questions && filters.questions.length > 0);
            $('#filterIndicator').text(hasFilters ? '🔵 Filters applied' : '');
        }

        function applyFilters() {
            updateFilterIndicator();
            loadDashboard();
            showToast('Filters applied successfully!', 'success');
        }

        function clearFilters() {
            $('#fromDate').val('');
            $('#toDate').val('');
            $('#responseFilter').val('');
            
            if (dealerChoices) dealerChoices.removeActiveItems();
            if (categoryChoices) categoryChoices.removeActiveItems();
            if (questionChoices) questionChoices.removeActiveItems();
            
            updateFilterIndicator();
            $('#filterResultsSection').hide();
            $('#responseList').empty();
            loadDashboard();
            showToast('Filters cleared!', 'success');
        }

        function refreshData() {
            loadDashboard();
            showToast('Data refreshed!', 'success');
        }

        function toggleColvisDropdown() {
            const dropdown = document.getElementById('colvisDropdown');
            if (!dropdown) return;

            const isShown = dropdown.classList.contains('show');

            if (isShown) {
                dropdown.classList.remove('show');
                return;
            }

            if (dropdown.parentElement !== document.body) {
                document.body.appendChild(dropdown);
            }

            populateColvisDropdown();
            dropdown.classList.add('show');
            positionColvisDropdown();
        }

        function positionColvisDropdown() {
            const dropdown = document.getElementById('colvisDropdown');
            const toggleBtn = document.querySelector('.colvis-toggle');
            if (!dropdown || !toggleBtn) return;

            const rect = toggleBtn.getBoundingClientRect();
            const dropdownWidth = dropdown.offsetWidth || 190;

            let left = rect.right - dropdownWidth;
            if (left < 8) left = 8;
            const maxLeft = window.innerWidth - dropdownWidth - 8;
            if (left > maxLeft) left = Math.max(8, maxLeft);

            let top = rect.bottom + 4;

            const dropdownHeight = dropdown.offsetHeight || 280;
            if (top + dropdownHeight > window.innerHeight && (rect.top - dropdownHeight - 4) > 0) {
                top = rect.top - dropdownHeight - 4;
            }

            dropdown.style.left = left + 'px';
            dropdown.style.top = top + 'px';
        }

        function populateColvisDropdown() {
            if (!allInspectionsTable) return;
            
            const container = $('#colvisItems');
            container.empty();
            
            columnHeaders.forEach(function(header, index) {
                const col = allInspectionsTable.column(index);
                if (!col) return;
                
                const isVisible = col.visible();
                const item = $(`
                    <div class="colvis-item">
                        <input type="checkbox" id="colvis_${index}" ${isVisible ? 'checked' : ''}>
                        <label for="colvis_${index}">${header}</label>
                    </div>
                `);
                
                item.find('input').on('change', function() {
                    const visible = $(this).is(':checked');
                    allInspectionsTable.column(index).visible(visible);
                });
                
                container.append(item);
            });
        }

        function selectAllColumns() {
            if (!allInspectionsTable) return;
            columnHeaders.forEach(function(header, index) {
                allInspectionsTable.column(index).visible(true);
            });
            $('#colvisItems input[type="checkbox"]').prop('checked', true);
            showToast('All columns visible', 'success');
        }

        function deselectAllColumns() {
            if (!allInspectionsTable) return;
            columnHeaders.forEach(function(header, index) {
                if (index === 0) {
                    allInspectionsTable.column(index).visible(true);
                } else {
                    allInspectionsTable.column(index).visible(false);
                }
            });
            $('#colvisItems input[type="checkbox"]').each(function(index) {
                $(this).prop('checked', index === 0);
            });
            showToast('All columns hidden (except #)', 'success');
        }

        function loadDashboard() {
            const filters = getFilters();
            $('#inspectionLoader').show();

            $.ajax({
                url: API_BASE + 'get/get_dashboard_cards.php',
                type: 'GET',
                data: filters,
                dataType: 'json',
                success: function(res) {
                    $('#inspectionCount').text(res.inspections || 0);
                    $('#yesCount').text(res.yes || 0);
                    $('#noCount').text(res.no || 0);
                    $('#naCount').text(res.na || 0);
                },
                error: function() {
                    console.error('Failed to load dashboard cards');
                }
            });

            $.ajax({
                url: API_BASE + 'get/get_graph_data.php',
                type: 'GET',
                data: filters,
                dataType: 'json',
                success: function(res) {
                    if (yesNoChart) yesNoChart.destroy();
                    if (issueChart) issueChart.destroy();

                    const ctx = document.getElementById('yesNoChart').getContext('2d');
                    const isDark = document.documentElement.classList.contains('dark-mode');
                    const textColor = isDark ? '#e5e7eb' : '#334155';

                    yesNoChart = new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: ['Yes', 'No', 'N/A'],
                            datasets: [{
                                data: [res.yes || 0, res.no || 0, res.na || 0],
                                backgroundColor: ['#10b981', '#ef4444', '#f59e0b'],
                                borderWidth: 2,
                                borderColor: isDark ? '#0d1520' : '#ffffff'
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                    labels: {
                                        color: textColor,
                                        padding: 15,
                                        usePointStyle: true,
                                        font: { size: 11, family: 'Inter' }
                                    }
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                            const percentage = total > 0 ? ((context.parsed * 100) / total).toFixed(1) : 0;
                                            return `${context.label}: ${context.parsed} (${percentage}%)`;
                                        }
                                    }
                                }
                            }
                        }
                    });

                    const issueCtx = document.getElementById('issueChart').getContext('2d');
                    const issueLabels = res.issues?.labels || [];
                    const issueData = res.issues?.data || [];
                    const issueDetails = res.issues?.details || {};

                    const colors = ['#1d4ed8', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#06b6d4', '#ec4899', '#14b8a6'];

                    issueChart = new Chart(issueCtx, {
                        type: 'bar',
                        data: {
                            labels: issueLabels,
                            datasets: [{
                                label: 'Issues Count',
                                data: issueData,
                                backgroundColor: issueLabels.map((_, i) => colors[i % colors.length]),
                                borderColor: isDark ? '#0d1520' : '#ffffff',
                                borderWidth: 1,
                                borderRadius: 4,
                                barPercentage: 0.6
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { display: false },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            return `Count: ${context.parsed.y}`;
                                        }
                                    }
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    grid: { color: isDark ? 'rgba(255,255,255,0.05)' : 'rgba(0,0,0,0.05)' },
                                    ticks: {
                                        color: textColor,
                                        stepSize: 1,
                                        callback: function(value) {
                                            return Number.isInteger(value) ? value : null;
                                        }
                                    }
                                },
                                x: {
                                    grid: { display: false },
                                    ticks: {
                                        color: textColor,
                                        maxRotation: 45,
                                        minRotation: 30,
                                        font: { size: 10 }
                                    }
                                }
                            },
                            onClick: (evt, elements) => {
                                if (elements.length > 0) {
                                    const index = elements[0].index;
                                    const label = issueLabels[index];
                                    const details = issueDetails[label] || [];
                                    showIssueDetails(label, details);
                                }
                            }
                        }
                    });

                    const hasFilters = filters.from_date || filters.to_date ||
                        (filters.dealers && filters.dealers.length > 0) ||
                        filters.response ||
                        (filters.categories && filters.categories.length > 0) ||
                        (filters.questions && filters.questions.length > 0);

                    if (hasFilters) {
                        loadFilteredResults(filters);
                    } else {
                        $('#filterResultsSection').hide();
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Failed to load graph data:', error);
                },
                complete: function() {
                    $('#inspectionLoader').hide();
                }
            });

            loadInspectionsTable(filters);
        }

        function loadInspectionsTable(filters) {
            $('#tableLoadingOverlay').addClass('show');

            if (allInspectionsTable) {
                allInspectionsTable.destroy();
                allInspectionsTable = null;
                $('#colvisDropdown').removeClass('show');
            }

            allInspectionsTable = $('#allInspectionsTable').DataTable({
                ajax: {
                    url: API_BASE + 'get/get_all_inspections.php',
                    type: 'GET',
                    data: filters,
                    dataType: 'json',
                    dataSrc: function(json) {
                        $('#tableLoadingOverlay').removeClass('show');
                        if (Array.isArray(json)) return json;
                        if (json.data && Array.isArray(json.data)) return json.data;
                        return [];
                    },
                    error: function(xhr, status, error) {
                        $('#tableLoadingOverlay').removeClass('show');
                        console.error('DataTable Ajax Error:', status, error);
                        return [];
                    }
                },
                columns: [
                    { data: 'sr_no', defaultContent: '' },
                    { data: 'date', defaultContent: '' },
                    { data: 'dealer_name', defaultContent: '' },
                    { data: 'sap_no', defaultContent: '' },
                    { data: 'site_name', defaultContent: '' },
                    { data: 'category_name', defaultContent: '' },
                    { data: 'question_text', defaultContent: 'N/A' },
                    {
                        data: 'response',
                        defaultContent: 'N/A',
                        render: function(data) {
                            let cls = 'badge-secondary';
                            if (data === 'Yes') cls = 'badge-success';
                            else if (data === 'No') cls = 'badge-danger';
                            else if (data === 'N/A') cls = 'badge-warning';
                            return `<span class="badge ${cls}">${data || 'N/A'}</span>`;
                        }
                    },
                    { data: 'description', defaultContent: 'N/A' }
                ],
                pageLength: 10,
                order: [[1, 'DESC']],
                dom: 'Bfrtip',
                buttons: [
                    { extend: 'copy', text: '<i class="fa-regular fa-copy"></i> Copy', className: 'dt-button' },
                    { extend: 'csv', text: '<i class="fa-regular fa-file-csv"></i> CSV', className: 'dt-button' },
                    { extend: 'excel', text: '<i class="fa-regular fa-file-excel"></i> Excel', className: 'dt-button' },
                    { extend: 'pdf', text: '<i class="fa-regular fa-file-pdf"></i> PDF', className: 'dt-button' },
                    { extend: 'print', text: '<i class="fa-solid fa-print"></i> Print', className: 'dt-button' }
                ],
                language: {
                    emptyTable: 'No inspection data available',
                    zeroRecords: 'No matching records found',
                    info: 'Showing _START_ to _END_ of _TOTAL_ entries',
                    infoEmpty: 'Showing 0 to 0 of 0 entries',
                    infoFiltered: '(filtered from _MAX_ total entries)',
                    loadingRecords: 'Loading inspections...',
                    processing: 'Processing...'
                },
                drawCallback: function() {
                    if ($('#colvisDropdown').hasClass('show')) {
                        populateColvisDropdown();
                        positionColvisDropdown();
                    }
                },
                initComplete: function() {
                    populateColvisDropdown();
                    
                    $('#tableSearchInput').on('keyup', function() {
                        if (allInspectionsTable) {
                            allInspectionsTable.search(this.value).draw();
                        }
                    });
                    
                    setTimeout(function() {
                        const buttonsContainer = $('#allInspectionsTable_wrapper .dt-buttons');
                        const toolbar = $('#tableToolbar');
                        if (buttonsContainer.length && toolbar.length) {
                            if (!toolbar.find('.dt-buttons').length) {
                                toolbar.prepend(buttonsContainer);
                            }
                        }
                    }, 100);
                }
            });
        }

        function loadFilteredResults(filters) {
            $.ajax({
                url: API_BASE + 'get/get_filtered_details.php',
                type: 'GET',
                data: filters,
                dataType: 'json',
                success: function(res) {
                    allFilteredResponses = res.details || [];
                    displayedResponses = 0;
                    $('#responseList').empty();

                    if (filterCategoryChart) filterCategoryChart.destroy();

                    const isDark = document.documentElement.classList.contains('dark-mode');
                    const textColor = isDark ? '#e5e7eb' : '#334155';
                    const gridColor = isDark ? 'rgba(255,255,255,0.05)' : 'rgba(0,0,0,0.05)';

                    const catCtx = document.getElementById('filterCategoryChart').getContext('2d');
                    const catColors = ['#1d4ed8', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#06b6d4', '#ec4899', '#14b8a6'];

                    filterCategoryChart = new Chart(catCtx, {
                        type: 'doughnut',
                        data: {
                            labels: res.categories?.labels || [],
                            datasets: [{
                                data: res.categories?.data || [],
                                backgroundColor: (res.categories?.labels || []).map((_, i) => catColors[i % catColors.length]),
                                borderWidth: 2,
                                borderColor: isDark ? '#0d1520' : '#ffffff'
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                    labels: {
                                        color: textColor,
                                        boxWidth: 12,
                                        padding: 8,
                                        font: { size: 10, family: 'Inter' }
                                    }
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                            const percentage = total > 0 ? ((context.parsed * 100) / total).toFixed(1) : 0;
                                            return `${context.label}: ${context.parsed} (${percentage}%)`;
                                        }
                                    }
                                }
                            }
                        }
                    });

                    if (filterTimelineChart) filterTimelineChart.destroy();

                    const tlCtx = document.getElementById('filterTimelineChart').getContext('2d');
                    filterTimelineChart = new Chart(tlCtx, {
                        type: 'line',
                        data: res.timeline || { labels: [], datasets: [] },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    grid: { color: gridColor },
                                    ticks: { color: textColor }
                                },
                                x: {
                                    grid: { display: false },
                                    ticks: { color: textColor, font: { size: 9 } }
                                }
                            },
                            plugins: {
                                legend: {
                                    labels: {
                                        color: textColor,
                                        boxWidth: 12,
                                        padding: 8,
                                        font: { size: 10, family: 'Inter' }
                                    }
                                }
                            }
                        }
                    });

                    loadMoreResponses();
                    $('#filterResultsSection').show();
                },
                error: function() {
                    console.error('Failed to load filtered details');
                }
            });
        }

        function loadMoreResponses() {
            const startIndex = displayedResponses;
            const endIndex = Math.min(startIndex + responsesPerPage, allFilteredResponses.length);

            for (let i = startIndex; i < endIndex; i++) {
                const r = allFilteredResponses[i];
                let cls = 'badge-secondary';
                if (r.response === 'Yes') cls = 'badge-success';
                else if (r.response === 'No') cls = 'badge-danger';
                else if (r.response === 'N/A') cls = 'badge-warning';

                const html = `
                    <div class="bg-panel border border-border rounded p-3 hover:shadow-md transition">
                        <div class="flex justify-between items-start mb-1">
                            <span class="text-[10px] text-gray-500">${r.date || ''}</span>
                            <span class="badge ${cls}">${r.response || 'N/A'}</span>
                        </div>
                        <p class="text-heading font-medium text-xs">${r.dealer_name || ''}</p>
                        <p class="text-gray-500 text-[10px]">${r.category_name || ''}</p>
                        <p class="text-blue-500 text-[10px]">${r.question_text || 'N/A'}</p>
                        <p class="text-gray-500 text-[10px] mt-1">Comment: ${r.description || 'No description'}</p>
                    </div>
                `;
                $('#responseList').append(html);
            }

            displayedResponses = endIndex;

            if (displayedResponses >= allFilteredResponses.length) {
                $('#loadMoreBtn').hide();
            } else {
                $('#loadMoreBtn').show();
            }
            if (displayedResponses > responsesPerPage) {
                $('#loadLessBtn').show();
            } else {
                $('#loadLessBtn').hide();
            }
        }

        function loadLessResponses() {
            if (displayedResponses <= responsesPerPage) return;
            displayedResponses -= responsesPerPage;
            $('#responseList').empty();

            for (let i = 0; i < displayedResponses; i++) {
                const r = allFilteredResponses[i];
                let cls = 'badge-secondary';
                if (r.response === 'Yes') cls = 'badge-success';
                else if (r.response === 'No') cls = 'badge-danger';
                else if (r.response === 'N/A') cls = 'badge-warning';

                const html = `
                    <div class="bg-panel border border-border rounded p-3 hover:shadow-md transition">
                        <div class="flex justify-between items-start mb-1">
                            <span class="text-[10px] text-gray-500">${r.date || ''}</span>
                            <span class="badge ${cls}">${r.response || 'N/A'}</span>
                        </div>
                        <p class="text-heading font-medium text-xs">${r.dealer_name || ''}</p>
                        <p class="text-gray-500 text-[10px]">${r.category_name || ''}</p>
                        <p class="text-blue-500 text-[10px]">${r.question_text || 'N/A'}</p>
                        <p class="text-gray-500 text-[10px] mt-1">Comment: ${r.description || 'No description'}</p>
                    </div>
                `;
                $('#responseList').append(html);
            }

            if (displayedResponses <= responsesPerPage) $('#loadLessBtn').hide();
            if (displayedResponses < allFilteredResponses.length) $('#loadMoreBtn').show();
        }

        function showIssueDetails(label, details) {
            let rows = '';
            details.forEach(d => {
                let cls = 'badge-secondary';
                if (d.response === 'Yes') cls = 'badge-success';
                else if (d.response === 'No') cls = 'badge-danger';
                else if (d.response === 'N/A') cls = 'badge-warning';

                rows += `
                    <tr>
                        <td class="text-xs">${d.date || ''}</td>
                        <td class="text-xs">${d.site_name || ''}</td>
                        <td><span class="badge ${cls}">${d.response || 'N/A'}</span></td>
                        <td class="text-xs">${d.description || 'N/A'}</td>
                    </tr>
                `;
            });

            $('#issueModalBody').html(`
                <div class="mb-3">
                    <h6 class="text-heading font-semibold text-sm">Issue: <span class="text-blue-500">${label}</span></h6>
                    <p class="text-gray-500 text-xs">Total occurrences: ${details.length}</p>
                </div>
                <div class="table-container">
                    <table class="display" style="width:100%;" id="issueDetailsTable">
                        <thead>
                            <tr>
                                <th class="text-[10px]">Date</th>
                                <th class="text-[10px]">Site</th>
                                <th class="text-[10px]">Response</th>
                                <th class="text-[10px]">Description</th>
                            </tr>
                        </thead>
                        <tbody>${rows}</tbody>
                    </table>
                </div>
            `);

            const modal = $('#issueModal');
            modal.removeClass('hidden').addClass('flex');
            setTimeout(function() {
                modal.removeClass('opacity-0');
                $('#issueModalWrapper').removeClass('scale-95').addClass('scale-100');
            }, 10);

            setTimeout(function() {
                if ($.fn.DataTable.isDataTable('#issueDetailsTable')) {
                    $('#issueDetailsTable').DataTable().destroy();
                }
                $('#issueDetailsTable').DataTable({
                    pageLength: 10,
                    order: [[0, 'DESC']],
                    dom: 'Bfrtip',
                    buttons: [
                        { extend: 'copy', text: '<i class="fa-regular fa-copy"></i> Copy', className: 'dt-button' },
                        { extend: 'csv', text: '<i class="fa-regular fa-file-csv"></i> CSV', className: 'dt-button' },
                        { extend: 'excel', text: '<i class="fa-regular fa-file-excel"></i> Excel', className: 'dt-button' },
                        { extend: 'pdf', text: '<i class="fa-regular fa-file-pdf"></i> PDF', className: 'dt-button' }
                    ],
                    language: {
                        emptyTable: 'No details available',
                        info: 'Showing _START_ to _END_ of _TOTAL_',
                        infoEmpty: 'Showing 0 to 0 of 0'
                    }
                });
            }, 300);
        }

        function closeIssueModal() {
            const modal = $('#issueModal');
            modal.addClass('opacity-0');
            $('#issueModalWrapper').removeClass('scale-100').addClass('scale-95');
            setTimeout(function() {
                modal.addClass('hidden').removeClass('flex');
            }, 300);
        }

        function updateChartColors() {
            loadDashboard();
        }

        function showToast(message, type = 'success') {
            const toast = $('#toast');
            const toastMessage = $('#toastMessage');
            
            toast.removeClass('success error');
            toast.addClass(type);
            toastMessage.text(message);
            toast.addClass('show');
            
            clearTimeout(window.toastTimeout);
            window.toastTimeout = setTimeout(function() {
                toast.removeClass('show');
            }, 3000);
        }

        $(document).on('click', '#issueModal', function(e) {
            if (e.target === this) closeIssueModal();
        });

        $(document).on('keydown', function(e) {
            if (e.key === 'Escape') {
                closeIssueModal();
            }
        });
    </script>

</body>
</html>