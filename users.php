<?php
require_once __DIR__ . '/session/session.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hascol OMC - Users Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

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

        .table-container table tbody tr {
            cursor: pointer;
        }

        .table-container table tbody tr:hover {
            background-color: var(--table-row-hover);
        }

        .table-container table tbody td .badge {
            padding: 2px 10px;
            border-radius: 9999px;
            font-size: 9px;
            font-weight: 600;
            display: inline-block;
        }

        .badge-active {
            background: #10b98120;
            color: #10b981;
            border: 1px solid #10b98140;
        }

        .badge-inactive {
            background: #ef444420;
            color: #ef4444;
            border: 1px solid #ef444440;
        }

        .badge-planner {
            background: #3b82f620;
            color: #3b82f6;
            border: 1px solid #3b82f640;
        }

        .badge-tm {
            background: #8b5cf620;
            color: #8b5cf6;
            border: 1px solid #8b5cf640;
        }

        .badge-rm {
            background: #f59e0b20;
            color: #f59e0b;
            border: 1px solid #f59e0b40;
        }

        .badge-carriage {
            background: #06b6d420;
            color: #06b6d4;
            border: 1px solid #06b6d440;
        }

        .badge-depot {
            background: #ec489920;
            color: #ec4899;
            border: 1px solid #ec489940;
        }

        .action-btn {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 11px;
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

        .action-btn.delete:hover {
            background: #ef444420;
            color: #ef4444;
        }

        .action-btn.edit:hover {
            background: #3b82f620;
            color: #3b82f6;
        }

        .toggle-switch {
            position: relative;
            width: 38px;
            height: 20px;
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
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ef4444;
            border-radius: 9999px;
            transition: background-color 0.3s ease;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.2);
        }

        .toggle-slider::before {
            content: "";
            position: absolute;
            height: 14px;
            width: 14px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            border-radius: 9999px;
            transition: transform 0.3s ease;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
        }

        .toggle-switch input:checked+.toggle-slider {
            background-color: #1d4ed8;
        }

        .toggle-switch input:checked+.toggle-slider::before {
            transform: translateX(18px);
        }

        .toggle-switch input:disabled+.toggle-slider {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .toggle-switch .toggle-label {
            position: absolute;
            font-size: 7px;
            font-weight: 700;
            color: white;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .toggle-switch .toggle-label-off {
            left: 5px;
        }

        .toggle-switch .toggle-label-on {
            right: 5px;
        }

        .toggle-switch input:not(:checked)+.toggle-slider .toggle-label-on {
            display: none;
        }

        .toggle-switch input:checked+.toggle-slider .toggle-label-off {
            display: none;
        }

        #offcanvasOverlay {
            position: fixed;
            inset: 0;
            z-index: 50;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }

        #offcanvasOverlay.active {
            opacity: 1;
            visibility: visible;
        }

        #offcanvasForm {
            position: fixed;
            top: 0;
            right: -100%;
            width: 480px;
            max-width: 92vw;
            height: 100vh;
            z-index: 60;
            background-color: var(--bg-panel);
            border-left: 1px solid var(--border-color);
            box-shadow: -10px 0 30px rgba(0, 0, 0, 0.25);
            transition: right 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
        }

        #offcanvasForm.active {
            right: 0;
        }

        #deleteModal {
            background: var(--modal-overlay);
            backdrop-filter: blur(8px);
        }

        #deleteModalWrapper {
            background-color: var(--bg-panel) !important;
            border-color: var(--border-color) !important;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35);
        }

        html.dark-mode #deleteModalWrapper {
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.8);
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

        .form-input:read-only,
        .form-input:disabled,
        .form-select:disabled {
            background-color: var(--hover-bg);
            cursor: not-allowed;
            opacity: 0.85;
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

        .btn-danger {
            background-color: #dc2626;
            color: #ffffff;
            padding: 8px 20px;
            border-radius: 0.25rem;
            border: none;
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .btn-danger:hover {
            background-color: #ef4444;
        }

        .dataTables_wrapper .dataTables_filter,
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
            height: 30px !important;
            box-sizing: border-box !important;
        }

        .dt-buttons .dt-button:hover {
            background-color: var(--hover-bg) !important;
            color: var(--text-heading) !important;
        }

        .dt-buttons .dt-button.dt-button-active {
            background-color: #1d4ed8 !important;
            color: #ffffff !important;
            border-color: #1d4ed8 !important;
        }

        .dt-buttons .dt-button .dt-button-icon {
            font-size: 12px !important;
        }

        .dataTables_filter {
            display: none !important;
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

        .search-input::placeholder {
            color: var(--text-muted);
        }

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

        .offcanvas-open {
            overflow: hidden !important;
        }

        .form-group {
            margin-bottom: 14px;
        }

        .form-group:last-of-type {
            margin-bottom: 0;
        }

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

        .toolbar-right .form-select {
            height: 30px;
            padding: 4px 28px 4px 10px;
            box-sizing: border-box;
            min-width: 130px;
        }

        @media (max-width: 1024px) {
            .toolbar-row {
                flex-wrap: wrap;
            }
            .toolbar-right {
                flex-wrap: wrap;
            }
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

        .column-visibility-dropdown .dropdown-btn i {
            font-size: 11px;
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

        .column-visibility-dropdown .dropdown-menu .dropdown-actions button.select-all-btn:hover {
            background: #10b98115;
        }

        .column-visibility-dropdown .dropdown-menu .dropdown-actions button.deselect-all-btn {
            border-color: #ef4444;
            color: #ef4444;
        }

        .column-visibility-dropdown .dropdown-menu .dropdown-actions button.deselect-all-btn:hover {
            background: #ef444415;
        }

        .column-visibility-dropdown .dropdown-menu::-webkit-scrollbar {
            width: 4px;
        }

        .column-visibility-dropdown .dropdown-menu::-webkit-scrollbar-track {
            background: var(--scrollbar-track);
        }

        .column-visibility-dropdown .dropdown-menu::-webkit-scrollbar-thumb {
            background: var(--scrollbar-thumb);
            border-radius: 4px;
        }

        .edit-confirmation-box {
            background: var(--hover-bg);
            border: 1px solid var(--border-color);
            border-radius: 0.375rem;
            padding: 12px 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .edit-confirmation-box .confirm-text {
            font-size: 13px;
            font-weight: 500;
            color: var(--text-heading);
        }

        .edit-confirmation-box .confirm-subtext {
            font-size: 10px;
            color: var(--text-muted);
            margin-top: 2px;
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
                    <h2 class="text-heading font-semibold text-base tracking-wide uppercase">Users Management</h2>
                    <p class="text-[10px] text-gray-500">Manage system users, roles and permissions</p>
                </div>
                <button onclick="openCreateOffcanvas()"
                    class="bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 rounded text-xs font-medium transition flex items-center gap-2">
                    <i class="fa-solid fa-plus"></i> Create User
                </button>
            </div>

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
                            <input type="text" id="customSearchInput" placeholder="Search users..." class="search-input">
                        </div>
                        <select id="statusFilter" class="form-select text-xs">
                            <option value="all">All Status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Non-Active</option>
                        </select>
                        <select id="roleFilter" class="form-select text-xs">
                            <option value="all">All Roles</option>
                            <option value="Admin">Admin</option>
                            <option value="Sales">Sales</option>
                            <option value="Order">Order</option>
                            <option value="Logistics">Logistics</option>
                            <option value="Cartraige">Cartraige</option>
                            <option value="Eng">Engineering</option>
                            <option value="tracker">Tracker</option>
                            <option value="Forward_order">Forward Order</option>
                            <option value="App_order">App Order</option>
                            <option value="Back_orders">Back Order</option>
                            <option value="Reporting">Reporting</option>
                            <option value="Finance">Finance</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="panel-card overflow-hidden">
                <div class="table-container">
                    <table id="usersTable" class="display" style="width:100%;">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>User-ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Password</th>
                                <th>Privilege</th>
                                <th>Contact No</th>
                                <th>Status</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody id="usersTableBody">
                            <tr>
                                <td colspan="9" class="text-center py-8 text-gray-500">
                                    <i class="fa-solid fa-spinner fa-spin text-blue-400 mr-2"></i>
                                    Loading users...
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>

    <div id="toast" class="toast">
        <i class="fa-solid fa-check-circle mr-2"></i>
        <span id="toastMessage">Data exported successfully!</span>
    </div>

    <div id="offcanvasOverlay" onclick="closeOffcanvas()"></div>

    <div id="offcanvasForm">
        <div class="flex justify-between items-center p-4 border-b flex-shrink-0" style="border-color: var(--border-color);">
            <h3 id="offcanvasTitle" class="text-heading font-semibold tracking-wide text-sm">
                <i class="fa-solid fa-user-plus mr-2 text-blue-500"></i>Create User
            </h3>
            <button onclick="closeOffcanvas()" class="text-gray-400 hover:text-red-500 transition">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>

        <div class="flex-1 overflow-y-auto p-4">
            <form id="userForm" onsubmit="saveUser(event)">
                <input type="hidden" id="userId" value="">
                <input type="hidden" id="zm_hide" value="">
                <input type="hidden" id="tm_hide" value="">

                <div class="form-group">
                    <label class="form-label">Username</label>
                    <input type="text" id="username" class="form-input" placeholder="Enter Username" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" id="email" class="form-input" placeholder="Enter Email" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Password</label>
                    <input type="password" id="password" class="form-input" placeholder="Enter Password (leave blank to keep current)">
                </div>

                <div class="form-group">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" id="confirmPassword" class="form-input" placeholder="Confirm Password">
                    <p id="passwordMessage" class="text-xs mt-1"></p>
                </div>

                <div class="form-group">
                    <label class="form-label">Contact No</label>
                    <input type="number" id="contactNo" class="form-input" placeholder="Enter Contact No" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Role</label>
                    <select id="role" class="form-select" required onchange="handleRoleChange()">
                        <option value="">Select Role</option>
                        <option value="Admin">Admin</option>
                        <option value="Sales">Sales</option>
                        <option value="Order">Order</option>
                        <option value="Logistics">Logistics</option>
                        <option value="Cartraige">Cartraige</option>
                        <option value="Eng">Engineering</option>
                        <option value="tracker">Tracker</option>
                        <option value="Forward_order">Forward Order</option>
                        <option value="App_order">App Order</option>
                        <option value="Back_orders">Back Order</option>
                        <option value="Reporting">Reporting</option>
                        <option value="Finance">Finance</option>
                    </select>
                </div>

                <div class="form-group" id="salesRoleWrapper" style="display:none;">
                    <label class="form-label">Sales Role</label>
                    <select id="salesRole" class="form-select" onchange="handleSalesRoleChange()">
                        <option value="">Select Sales Role</option>
                        <option value="Admin">Admin</option>
                        <option value="ZM">GRM</option>
                        <option value="TM">RM</option>
                        <option value="ASM">TM</option>
                        <option value="BSO">BSO</option>
                    </select>
                </div>

                <div class="form-group" id="zmRoleWrapper" style="display:none;">
                    <label class="form-label">GRM</label>
                    <select id="zmRole" class="form-select">
                        <option value="">Select GRM</option>
                    </select>
                </div>

                <div class="form-group" id="tmRoleWrapper" style="display:none;">
                    <label class="form-label">RM</label>
                    <select id="tmRole" class="form-select">
                        <option value="">Select RM</option>
                    </select>
                </div>

                <div class="form-group" id="logisticsRoleWrapper" style="display:none;">
                    <label class="form-label">Logistics Role</label>
                    <select id="logisticsRole" class="form-select">
                        <option value="">Select Logistics Role</option>
                        <option value="Admin">Admin</option>
                        <option value="Carriage">Carriage</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select id="status" class="form-select">
                        <option value="active">Active</option>
                        <option value="inactive">Non-Active</option>
                    </select>
                </div>
            </form>
        </div>

        <div class="flex flex-col gap-3 p-4 border-t flex-shrink-0" style="border-color: var(--border-color);">
            <!-- Edit Confirmation Section -->
            <div id="editConfirmationSection" class="edit-confirmation-box" style="display: none;">
                <div>
                    <div class="confirm-text">Do you want to edit?</div>
                    <div class="confirm-subtext">Click Yes to enable editing</div>
                </div>
                <button type="button" onclick="enableEditMode()" class="btn-primary" style="padding: 6px 20px;">
                    <i class="fa-regular fa-pen-to-square mr-1"></i> Yes
                </button>
            </div>

            <!-- Save/Cancel Section -->
            <div id="saveCancelSection" class="flex gap-3" style="display: none;">
                <button type="submit" form="userForm" class="btn-primary flex-1">
                    <i class="fa-regular fa-floppy-disk mr-1"></i> Save
                </button>
                <button type="button" onclick="closeOffcanvas()" class="btn-secondary">
                    <i class="fa-regular fa-xmark mr-1"></i> Cancel
                </button>
            </div>
        </div>
    </div>

    <div id="deleteModal"
        class="fixed inset-0 z-50 hidden backdrop-blur-sm flex items-center justify-center transition-opacity duration-300 opacity-0">
        <div class="border rounded-lg shadow-2xl w-full max-w-sm transform scale-95 transition-transform duration-300"
            id="deleteModalWrapper">
            <div class="p-6 text-center">
                <div class="w-14 h-14 bg-red-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid fa-trash-can text-red-500 text-2xl"></i>
                </div>
                <h3 class="text-heading font-semibold text-base mb-2">Delete User</h3>
                <p class="text-gray-400 text-sm mb-6">Are you sure you want to delete this user? This action cannot be undone.</p>
                <input type="hidden" id="deleteUserId">
                <div class="flex gap-3">
                    <button onclick="confirmDelete()" class="btn-danger flex-1">Delete</button>
                    <button onclick="closeDeleteModal()" class="btn-secondary flex-1">Cancel</button>
                </div>
            </div>
        </div>
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

        $(document).ready(function() {
            $('#sidebarToggle').on('click', function() {
                $('#sidebar').toggleClass('collapsed');
                localStorage.setItem('sidebarCollapsed', $('#sidebar').hasClass('collapsed'));
            });

            if (localStorage.getItem('sidebarCollapsed') === 'true') {
                $('#sidebar').addClass('collapsed');
            }

            $('#password, #confirmPassword').on('input', validatePassword);

            $('#customSearchInput').on('keyup', function() {
                if ($.fn.DataTable.isDataTable('#usersTable')) {
                    $('#usersTable').DataTable().search($(this).val()).draw();
                }
            });

            $('#statusFilter, #roleFilter').on('change', applyFilters);

            loadZMList();
            loadTMList();
            loadUsers();

            $(document).on('click', function(e) {
                if (!$(e.target).closest('.column-visibility-dropdown').length) {
                    closeColumnDropdown();
                }
            });

            const isDarkMode = localStorage.getItem('darkMode') === 'true';
            const icon = document.querySelector('.dark-mode-toggle i');
            if (icon) {
                icon.className = isDarkMode ? 'fa-solid fa-sun' : 'fa-solid fa-moon';
            }
        });
        
        const API_BASE_URL = 'api/';

        let usersData = [];
        let dataTable = null;

        const columnConfig = [
            { idx: 0, label: 'S.No' },
            { idx: 1, label: 'User-ID' },
            { idx: 2, label: 'Name' },
            { idx: 3, label: 'Email' },
            { idx: 4, label: 'Password' },
            { idx: 5, label: 'Privilege' },
            { idx: 6, label: 'Contact No' },
            { idx: 7, label: 'Status' },
            { idx: 8, label: 'Delete' }
        ];

        function validatePassword() {
            var password = $('#password').val();
            var confirmPassword = $('#confirmPassword').val();
            var messageEl = $('#passwordMessage');

            if (password !== confirmPassword) {
                messageEl.html('Passwords do not match!').css('color', 'red');
                return false;
            } else if (password.length > 0 && confirmPassword.length > 0) {
                messageEl.html('Passwords match.').css('color', 'green');
                return true;
            } else {
                messageEl.html('');
                return true;
            }
        }

        function handleRoleChange() {
            var role = $('#role').val();
            $('#salesRoleWrapper, #zmRoleWrapper, #tmRoleWrapper, #logisticsRoleWrapper').hide();

            if (role === 'Sales') {
                $('#salesRoleWrapper').show();
            } else if (role === 'Logistics') {
                $('#logisticsRoleWrapper').show();
            }
        }

        function handleSalesRoleChange() {
            var salesRole = $('#salesRole').val();
            $('#zmRoleWrapper, #tmRoleWrapper').hide();

            if (salesRole === 'TM') {
                $('#zmRoleWrapper').show();
            } else if (salesRole === 'ASM' || salesRole === 'BSO') {
                $('#tmRoleWrapper').show();
            }
        }

        function loadZMList() {
            $.ajax({
                url: API_BASE_URL + 'get/get_zm.php?key=03201232927',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    var select = $('#zmRole');
                    select.empty().append('<option value="">Select GRM</option>');
                    $.each(data, function(index, item) {
                        select.append($('<option>', { value: item.id, text: item.name }));
                    });
                },
                error: function() {
                    console.log('Failed to load ZM list');
                }
            });
        }

        function loadTMList() {
            $.ajax({
                url: API_BASE_URL + 'get/get_tm.php?key=03201232927',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    var select = $('#tmRole');
                    select.empty().append('<option value="">Select RM</option>');
                    $.each(data, function(index, item) {
                        select.append($('<option>', { value: item.id, text: item.name }));
                    });
                },
                error: function() {
                    console.log('Failed to load TM list');
                }
            });
        }

        function loadUsers() {
            $('#usersTableBody').html(`
                <tr>
                    <td colspan="9" class="text-center py-8 text-gray-500">
                        <i class="fa-solid fa-spinner fa-spin text-blue-400 mr-2"></i>
                        Loading users...
                    </td>
                </tr>
            `);

            $.ajax({
                url: API_BASE_URL + 'get/all_users.php?key=03201232927',
                type: 'GET',
                dataType: 'json',
                timeout: 30000,
                success: function(response) {
                    if (response && Array.isArray(response)) {
                        usersData = response.map(function(user) {
                            var privilege = user.privilege || 'N/A';
                            if (privilege == 'ZM') privilege = 'GRM';
                            else if (privilege == 'TM') privilege = 'RM';
                            else if (privilege == 'ASM') privilege = 'TM';
                            
                            return {
                                id: parseInt(user.id) || 0,
                                username: user.name || 'N/A',
                                email: user.login || user.email || 'N/A',
                                password: '*********',
                                role: privilege,
                                contact: user.telephone || 'N/A',
                                status: user.status == 1 ? 'active' : 'inactive'
                            };
                        });
                        initializeDataTable();
                    } else {
                        showToast('No users found or invalid response format.', 'error');
                        usersData = [];
                        initializeDataTable();
                    }
                },
                error: function(xhr, status, error) {
                    console.error('API Error:', status, error);
                    showToast('Failed to load users. Please refresh the page.', 'error');
                    usersData = [];
                    initializeDataTable();
                }
            });
        }

        function toggleUserStatus(userId, currentStatus) {
            const newStatus = currentStatus === 'active' ? 'inactive' : 'active';
            const statusText = newStatus === 'active' ? 'Active' : 'Non-Active';

            const toggleInput = $(`#toggle-${userId}`);
            toggleInput.prop('disabled', true);

            $.ajax({
                url: API_BASE_URL + 'update/user_active_inactive.php',
                type: 'POST',
                data: {
                    id: userId,
                    checkboxValue: newStatus === 'active' ? 1 : 0
                },
                dataType: 'json',
                success: function(response) {
                    toggleInput.prop('disabled', false);
                    if (response === 1) {
                        const user = usersData.find(u => u.id === userId);
                        if (user) user.status = newStatus;
                        showToast(`User status updated to ${statusText}!`, 'success');
                        loadUsers();
                    } else {
                        toggleInput.prop('checked', currentStatus === 'active');
                        showToast('Failed to update status. Please try again.', 'error');
                    }
                },
                error: function(xhr, status, error) {
                    toggleInput.prop('disabled', false);
                    toggleInput.prop('checked', currentStatus === 'active');
                    console.error('Status Update Error:', status, error);
                    showToast('Error updating status: ' + status, 'error');
                }
            });
        }

        function getRoleBadgeClass(role) {
            if (role === 'Admin') return 'badge-active';
            if (role === 'Sales') return 'badge-tm';
            if (role === 'Order') return 'badge-rm';
            if (role === 'Logistics') return 'badge-carriage';
            if (role === 'Cartraige') return 'badge-carriage';
            if (role === 'Engineering') return 'badge-depot';
            if (role === 'tracker') return 'badge-planner';
            if (role === 'Forward_order') return 'badge-rm';
            if (role === 'App_order') return 'badge-tm';
            if (role === 'Back_orders') return 'badge-depot';
            if (role === 'Reporting') return 'badge-planner';
            if (role === 'Finance') return 'badge-tm';
            if (role === 'GRM') return 'badge-tm';
            if (role === 'RM') return 'badge-rm';
            if (role === 'TM') return 'badge-tm';
            return 'badge-planner';
        }

        function buildTableRow(user, index) {
            const isActive = user.status === 'active';
            const roleClass = getRoleBadgeClass(user.role);

            const toggleHtml = `
                <label class="toggle-switch" title="Toggle status" onclick="event.stopPropagation();">
                    <input type="checkbox" id="toggle-${user.id}" 
                           ${isActive ? 'checked' : ''} 
                           onchange="toggleUserStatus(${user.id}, '${user.status}')">
                    <span class="toggle-slider">
                        <span class="toggle-label toggle-label-on">On</span>
                        <span class="toggle-label toggle-label-off">Off</span>
                    </span>
                </label>
            `;

            return [
                index + 1,
                user.id,
                user.username,
                user.email,
                user.password,
                `<span class="badge ${roleClass}">${user.role}</span>`,
                user.contact,
                toggleHtml,
                `<button onclick="event.stopPropagation(); openDeleteModal(${user.id})" class="action-btn delete"><i class="fa-solid fa-trash-can"></i></button>`
            ];
        }

        function initializeDataTable() {
            if ($.fn.DataTable.isDataTable('#usersTable')) {
                $('#usersTable').DataTable().destroy();
            }

            const tableData = usersData.map(buildTableRow);

            dataTable = $('#usersTable').DataTable({
                data: tableData,
                columns: [
                    { title: 'S.No' },
                    { title: 'User-ID' },
                    { title: 'Name' },
                    { title: 'Email' },
                    { title: 'Password' },
                    { title: 'Privilege' },
                    { title: 'Contact No' },
                    { title: 'Status', orderable: false, searchable: false },
                    { title: 'Delete', orderable: false, searchable: false }
                ],
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'copy',
                        text: '<i class="fa-regular fa-copy"></i> Copy',
                        className: 'toolbar-btn',
                        exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7] }
                    },
                    {
                        extend: 'excelHtml5',
                        text: '<i class="fa-regular fa-file-excel"></i> Excel',
                        className: 'toolbar-btn',
                        exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7] },
                        title: 'Users_Export'
                    },
                    {
                        extend: 'csvHtml5',
                        text: '<i class="fa-regular fa-file-csv"></i> CSV',
                        className: 'toolbar-btn',
                        exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7] },
                        title: 'Users_Export'
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<i class="fa-regular fa-file-pdf"></i> PDF',
                        className: 'toolbar-btn',
                        exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7] },
                        title: 'Users Management',
                        orientation: 'landscape',
                        pageSize: 'A4',
                        customize: function(doc) {
                            doc.defaultStyle.fontSize = 9;
                            doc.styles.tableHeader.fontSize = 10;
                            doc.styles.tableHeader.fillColor = '#0a121c';
                            doc.styles.tableHeader.color = '#ffffff';
                        }
                    },
                    {
                        extend: 'print',
                        text: '<i class="fa-solid fa-print"></i> Print',
                        className: 'toolbar-btn',
                        exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7] }
                    }
                ],
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100],
                ordering: true,
                order: [[0, 'asc']],
                language: {
                    emptyTable: '<div class="text-center py-8 text-gray-500"><i class="fa-solid fa-users-slash text-2xl block mb-2"></i>No users found</div>',
                    info: 'Showing _START_ to _END_ of _TOTAL_ entries',
                    infoEmpty: 'Showing 0 to 0 of 0 entries',
                    infoFiltered: '(filtered from _MAX_ total entries)'
                },
                drawCallback: function() {
                    $('.dt-buttons .dt-button').addClass('toolbar-btn');
                    
                    // Bind row click event
                    $('#usersTable tbody tr').off('click').on('click', function(e) {
                        // Delete button ya toggle pe click ho to ignore karo
                        if ($(e.target).closest('.action-btn.delete').length || 
                            $(e.target).closest('.toggle-switch').length) {
                            return;
                        }
                        
                        var rowData = dataTable.row(this).data();
                        if (rowData && rowData[1]) {
                            var userId = rowData[1];
                            openEditOffcanvas(userId);
                        }
                    });
                },
                initComplete: function() {
                    $('.dt-buttons').appendTo('#exportButtonsContainer');
                    populateColumnDropdown();
                }
            });

            applyFilters();
        }

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
                
                container.append(`
                    <div class="dropdown-item" onclick="toggleColumnVisibility(${col.idx})">
                        <input type="checkbox" id="col-checkbox-${col.idx}" 
                               ${isVisible ? 'checked' : ''} 
                               onclick="event.stopPropagation(); toggleColumnVisibility(${col.idx})">
                        <span class="column-label">${col.label}</span>
                    </div>
                `);
            });
        }

        function toggleColumnVisibility(colIdx) {
            if (!dataTable) return;
            try {
                const isVisible = dataTable.column(colIdx).visible();
                dataTable.column(colIdx).visible(!isVisible);
                $(`#col-checkbox-${colIdx}`).prop('checked', !isVisible);
            } catch(e) {
                console.warn('Column visibility toggle error:', e);
            }
        }

        function selectAllColumns() {
            if (!dataTable) return;
            try {
                columnConfig.forEach(function(col) {
                    dataTable.column(col.idx).visible(true);
                    $(`#col-checkbox-${col.idx}`).prop('checked', true);
                });
                showToast('All columns selected!', 'success');
            } catch(e) {
                showToast('Error selecting columns', 'error');
            }
        }

        function deselectAllColumns() {
            if (!dataTable) return;
            try {
                columnConfig.forEach(function(col) {
                    dataTable.column(col.idx).visible(false);
                    $(`#col-checkbox-${col.idx}`).prop('checked', false);
                });
                showToast('All columns deselected!', 'success');
            } catch(e) {
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
            $('#columnDropdownMenu').removeClass('show');
        }

        function applyFilters() {
            const status = $('#statusFilter').val();
            const role = $('#roleFilter').val();

            const filteredData = usersData.filter(user => {
                const matchStatus = status === 'all' || user.status === status;
                const matchRole = role === 'all' || user.role === role;
                return matchStatus && matchRole;
            });

            const tableData = filteredData.map(buildTableRow);

            if (dataTable) {
                dataTable.clear();
                dataTable.rows.add(tableData);
                dataTable.draw();
            }
        }

        function showToast(message, type = 'success') {
            const toast = $('#toast');
            const toastMessage = $('#toastMessage');
            
            toast.removeClass('success error').addClass(type);
            toastMessage.text(message);
            toast.addClass('show');
            
            clearTimeout(window.toastTimeout);
            window.toastTimeout = setTimeout(() => {
                toast.removeClass('show');
            }, 3000);
        }

        function openOffcanvas() {
            $('#offcanvasOverlay').addClass('active');
            $('#offcanvasForm').addClass('active');
            $('body').addClass('offcanvas-open');
        }

        function closeOffcanvas() {
            $('#offcanvasOverlay').removeClass('active');
            $('#offcanvasForm').removeClass('active');
            $('body').removeClass('offcanvas-open');
            $('#zmRoleWrapper, #tmRoleWrapper, #salesRoleWrapper, #logisticsRoleWrapper').hide();
            
            // Reset edit/save sections
            $('#editConfirmationSection').hide();
            $('#saveCancelSection').hide();
            
            // Reset form
            $('#userForm')[0].reset();
            setFormReadOnly(false);
        }

        // Set form fields read-only or editable
        function setFormReadOnly(isReadOnly) {
            $('#userForm input, #userForm select').each(function() {
                if (isReadOnly) {
                    $(this).prop('disabled', true).prop('readonly', true);
                } else {
                    $(this).prop('disabled', false).prop('readonly', false);
                }
            });
        }

        // Enable edit mode - fields become editable and Save button shows
        function enableEditMode() {
            setFormReadOnly(false);
            
            // Hide confirmation, show save/cancel
            $('#editConfirmationSection').hide();
            $('#saveCancelSection').show();
            
            // Update title
            $('#offcanvasTitle').html('<i class="fa-solid fa-user-pen mr-2 text-blue-500"></i>Edit User');
            
            // Clear password fields so user can enter new password
            $('#password').val('');
            $('#confirmPassword').val('');
            $('#passwordMessage').html('');
        }

        function openCreateOffcanvas() {
            $('#offcanvasTitle').html('<i class="fa-solid fa-user-plus mr-2 text-blue-500"></i>Create User');
            $('#userId').val('');
            $('#username').val('');
            $('#email').val('');
            $('#password').val('');
            $('#confirmPassword').val('');
            $('#contactNo').val('');
            $('#role').val('');
            $('#salesRole').val('');
            $('#zmRole').val('');
            $('#tmRole').val('');
            $('#logisticsRole').val('');
            $('#status').val('active');
            $('#zm_hide').val('');
            $('#tm_hide').val('');
            $('#salesRoleWrapper, #zmRoleWrapper, #tmRoleWrapper, #logisticsRoleWrapper').hide();
            $('#passwordMessage').html('');
            $('#userForm')[0].reset();
            
            // Create mode: fields editable, save button shown
            setFormReadOnly(false);
            $('#editConfirmationSection').hide();
            $('#saveCancelSection').show();
            
            openOffcanvas();
        }

        function openEditOffcanvas(userId) {
            $.ajax({
                url: API_BASE_URL + 'get/view_user.php?key=03201232927&id=' + userId,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response && response.length > 0) {
                        var user = response[0];
                        
                        $('#offcanvasTitle').html('<i class="fa-solid fa-user-eye mr-2 text-blue-500"></i>View User');
                        $('#userId').val(user.id);
                        $('#username').val(user.name || '');
                        $('#email').val(user.email || '');
                        $('#password').val('');
                        $('#confirmPassword').val('');
                        $('#contactNo').val(user.telephone || '');
                        $('#role').val('Sales');
                        $('#status').val(user.status == 1 ? 'active' : 'inactive');
                        
                        $('#salesRoleWrapper, #zmRoleWrapper, #tmRoleWrapper, #logisticsRoleWrapper').hide();
                        
                        var privilege = user.privilege || '';
                        
                        if (privilege == 'ZM') {
                            $('#salesRoleWrapper').show();
                            $('#salesRole').val('ZM');
                            $.ajax({
                                url: API_BASE_URL + 'get/get_zm_tm.php?key=03201232927&id=' + userId,
                                type: 'GET',
                                dataType: 'json',
                                success: function(zmData) {
                                    if (zmData && zmData.length > 0) {
                                        $('#zmRoleWrapper').show();
                                        $('#zmRole').val(zmData[0].zm_id || '');
                                        $('#zm_hide').val(zmData[0].zm_id || '');
                                    }
                                }
                            });
                        } else if (privilege == 'TM') {
                            $('#salesRoleWrapper').show();
                            $('#salesRole').val('TM');
                            $('#zmRoleWrapper').show();
                            $.ajax({
                                url: API_BASE_URL + 'get/get_zm_tm.php?key=03201232927&id=' + userId,
                                type: 'GET',
                                dataType: 'json',
                                success: function(zmData) {
                                    if (zmData && zmData.length > 0) {
                                        $('#zmRole').val(zmData[0].zm_id || '');
                                        $('#zm_hide').val(zmData[0].zm_id || '');
                                    }
                                }
                            });
                        } else if (privilege == 'ASM' || privilege == 'BSO') {
                            $('#salesRoleWrapper').show();
                            $('#salesRole').val(privilege);
                            $('#tmRoleWrapper').show();
                            $.ajax({
                                url: API_BASE_URL + 'get/get_asm_tm.php?key=03201232927&id=' + userId,
                                type: 'GET',
                                dataType: 'json',
                                success: function(tmData) {
                                    if (tmData && tmData.length > 0) {
                                        $('#tmRole').val(tmData[0].tm_id || '');
                                        $('#tm_hide').val(tmData[0].tm_id || '');
                                    }
                                }
                            });
                        }
                        
                        // Set all fields read-only initially
                        setFormReadOnly(true);
                        
                        // Show confirmation, hide save button
                        $('#editConfirmationSection').show();
                        $('#saveCancelSection').hide();
                        
                        openOffcanvas();
                    } else {
                        showToast('User not found.', 'error');
                    }
                },
                error: function() {
                    showToast('Error loading user details.', 'error');
                }
            });
        }

        function openDeleteModal(userId) {
            $('#deleteUserId').val(userId);
            const modal = $('#deleteModal');
            modal.removeClass('hidden').addClass('flex');
            setTimeout(function() {
                modal.removeClass('opacity-0');
                $('#deleteModalWrapper').removeClass('scale-95').addClass('scale-100');
            }, 10);
        }

        function closeDeleteModal() {
            const modal = $('#deleteModal');
            modal.addClass('opacity-0');
            $('#deleteModalWrapper').removeClass('scale-100').addClass('scale-95');
            setTimeout(function() {
                modal.addClass('hidden').removeClass('flex');
            }, 300);
        }

        function saveUser(event) {
            event.preventDefault();

            if (!validatePassword()) {
                showToast('Passwords do not match.', 'error');
                return;
            }

            const userId = $('#userId').val();
            const username = $('#username').val().trim();
            const email = $('#email').val().trim();
            const password = $('#password').val();
            const contactNo = $('#contactNo').val().trim();
            const role = $('#role').val();
            const status = $('#status').val();
            const salesRole = $('#salesRole').val();
            const zmId = $('#zmRole').val();
            const tmId = $('#tmRole').val();
            const logisticsRole = $('#logisticsRole').val();

            if (!username || !email || !contactNo || !role) {
                showToast('Please fill in all required fields.', 'error');
                return;
            }

            const submitBtn = $('#userForm button[type="submit"]');
            submitBtn.prop('disabled', true);
            submitBtn.html('<i class="fa-solid fa-spinner fa-spin mr-1"></i> Saving...');

            var privilege = role;
            if (role === 'Sales') {
                privilege = salesRole || 'Sales';
            } else if (role === 'Logistics') {
                privilege = logisticsRole || 'Logistics';
            }

            if (userId) {
                const formData = new FormData();
                formData.append('row_id', userId);
                formData.append('name', username);
                formData.append('email', email);
                formData.append('user_id', userId);
                formData.append('confirm_password', password || '');
                formData.append('number', contactNo);
                formData.append('sales_role', privilege);
                formData.append('sales_role_hide', privilege);
                formData.append('status', status === 'active' ? 1 : 0);
                formData.append('zm_hide', zmId || '');
                formData.append('tm_hide', tmId || '');

                $.ajax({
                    url: API_BASE_URL + 'update/update_user.php',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(response) {
                        submitBtn.prop('disabled', false);
                        submitBtn.html('<i class="fa-regular fa-floppy-disk mr-1"></i> Save');
                        
                        if (response === 1) {
                            showToast('User updated successfully!', 'success');
                            closeOffcanvas();
                            loadUsers();
                        } else {
                            showToast('Failed to update user. Please try again.', 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        submitBtn.prop('disabled', false);
                        submitBtn.html('<i class="fa-regular fa-floppy-disk mr-1"></i> Save');
                        console.error('Update Error:', status, error);
                        showToast('Error updating user: ' + status, 'error');
                    }
                });
            } else {
                const formData = new FormData();
                formData.append('name', username);
                formData.append('email', email);
                formData.append('confirm_password', password || '12345678');
                formData.append('number', contactNo);
                formData.append('role', privilege);
                formData.append('sales_role', privilege);
                formData.append('user_id', '0');
                formData.append('zm_hide', zmId || '');
                formData.append('tm_hide', tmId || '');

                $.ajax({
                    url: API_BASE_URL + 'create/users.php',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json',   // ← 'text' se 'json' karein
                    success: function(response) {
                        submitBtn.prop('disabled', false);
                        submitBtn.html('<i class="fa-regular fa-floppy-disk mr-1"></i> Save');
                        
                        // JSON response check
                        if (response.status === 1) {
                            showToast(response.message || 'User created successfully!', 'success');
                            closeOffcanvas();
                            loadUsers();
                        } else {
                            showToast(response.message || 'Failed to create user.', 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        submitBtn.prop('disabled', false);
                        submitBtn.html('<i class="fa-regular fa-floppy-disk mr-1"></i> Save');
                        console.error('Create Error:', status, error);
                        console.error('Raw response:', xhr.responseText);
                        showToast('Error creating user: ' + status, 'error');
                    }
                });
            }
        }

        // Delete User
        function confirmDelete() {
            const userId = parseInt($('#deleteUserId').val());

            if (!userId) {
                showToast('Invalid user ID.', 'error');
                return;
            }

            const deleteBtn = $('#deleteModal .btn-danger');
            deleteBtn.prop('disabled', true);
            deleteBtn.html('<i class="fa-solid fa-spinner fa-spin mr-1"></i> Deleting...');

            $.ajax({
                url: API_BASE_URL + 'delete/delete_users.php?key=03201232927&id=' + userId,
                type: 'DELETE',
                timeout: 30000,
                success: function(response) {
                    deleteBtn.prop('disabled', false);
                    deleteBtn.html('Delete');
                    
                    if (response === 1) {
                        showToast('User deleted successfully!', 'success');
                        closeDeleteModal();
                        loadUsers();
                    } else {
                        showToast('Failed to delete user. Please try again.', 'error');
                    }
                },
                error: function(xhr, status, error) {
                    deleteBtn.prop('disabled', false);
                    deleteBtn.html('Delete');
                    console.error('Delete Error:', status, error);
                    showToast('Error deleting user: ' + status, 'error');
                }
            });
        }

        $(document).on('keydown', function(e) {
            if (e.key === 'Escape') {
                if ($('#offcanvasForm').hasClass('active')) {
                    closeOffcanvas();
                }
                if (!$('#deleteModal').hasClass('hidden')) {
                    closeDeleteModal();
                }
                closeColumnDropdown();
            }
        });

        $(document).on('click', '#deleteModal', function(e) {
            if (e.target === this) closeDeleteModal();
        });
    </script>

</body>

</html>