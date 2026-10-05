<?php
// Hascol OMC Operations Command Center - Assign Sales Invoice Cart
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hascol OMC - Assign Sales Invoice Cart</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- jQuery UI for Date Picker -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <!-- DataTables CSS & JS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">

      <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        (function () {
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
            --filter-bg: #f8fafc;
            --selected-item-bg: #f1f5f9;
            --order-detail-border: #e2e8f0;
            --checkbox-accent: #1d4ed8;
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
            --filter-bg: #0a121c;
            --selected-item-bg: #060b13;
            --order-detail-border: #1a2635;
            --checkbox-accent: #1d4ed8;
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
            text-align: left;
            padding: 8px 10px;
            border-bottom: 1px solid var(--border-color);
            white-space: nowrap;
            text-transform: uppercase;
            letter-spacing: 0.3px;
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

        .custom-checkbox {
            width: 16px;
            height: 16px;
            accent-color: var(--checkbox-accent);
            cursor: pointer;
            background-color: var(--input-bg);
            border: 1px solid var(--border-color);
            border-radius: 3px;
        }

        /* DataTables Controls - Enhanced Search */

        /* Search Container */
        #searchContainer .dataTables_filter {
            display: flex !important;
            align-items: center !important;
            justify-content: flex-end !important;
        }

        #searchContainer .dataTables_filter label {
            display: flex !important;
            align-items: center !important;
            gap: 8px !important;
            font-size: 11px !important;
            font-weight: 500 !important;
            color: var(--text-muted) !important;
            margin: 0 !important;
        }

        /* Search Input - Professional Styling */
        #searchContainer .dataTables_filter input {
            width: 220px !important;
            height: 32px !important;
            padding: 6px 14px !important;
            padding-left: 34px !important;
            border: 1.5px solid var(--border-color) !important;
            border-radius: 6px !important;
            background-color: var(--input-bg) !important;
            color: var(--text-body) !important;
            font-size: 12px !important;
            font-family: 'Inter', sans-serif !important;
            transition: all 0.3s ease !important;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2364748b'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z'/%3E%3C/svg%3E") !important;
            background-repeat: no-repeat !important;
            background-position: 10px center !important;
            background-size: 16px !important;
        }

        #searchContainer .dataTables_filter input:focus {
            border-color: #1d4ed8 !important;
            box-shadow: 0 0 0 3px rgba(29, 78, 216, 0.1) !important;
            outline: none !important;
        }

        #searchContainer .dataTables_filter input::placeholder {
            color: var(--text-muted) !important;
            opacity: 0.5 !important;
            font-size: 11px !important;
        }

        /* Dark Mode Search */
        html.dark-mode #searchContainer .dataTables_filter input {
            border-color: #1a2635 !important;
            background-color: #0d1520 !important;
            color: #e5e7eb !important;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2394a3b8'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z'/%3E%3C/svg%3E") !important;
        }

        html.dark-mode #searchContainer .dataTables_filter input:focus {
            border-color: #3b82f6 !important;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15) !important;
        }

        /* Responsive Search */
        @media (max-width: 768px) {
            #searchContainer .dataTables_filter input {
                width: 160px !important;
                font-size: 11px !important;
                padding-left: 30px !important;
                height: 30px !important;
            }
        }

        /* DataTables Length */
        .dataTables_wrapper .dataTables_length {
            float: left !important;
        }

        .dataTables_wrapper .dataTables_length label {
            display: flex !important;
            align-items: center !important;
            gap: 6px !important;
            font-size: 11px !important;
            color: var(--text-muted) !important;
        }

        .dataTables_wrapper .dataTables_length select {
            padding: 4px 8px !important;
            border: 1px solid var(--border-color) !important;
            border-radius: 0.25rem !important;
            background-color: var(--input-bg) !important;
            color: var(--text-body) !important;
            font-size: 11px !important;
            height: 30px !important;
            box-sizing: border-box !important;
        }

        .dataTables_wrapper .dataTables_info {
            color: var(--text-muted) !important;
            font-size: 11px !important;
            padding-top: 12px !important;
            clear: both !important;
            float: left !important;
        }

        /* DataTables Buttons */
        .dt-buttons {
            display: flex !important;
            gap: 6px !important;
            flex-wrap: wrap !important;
            float: left !important;
            margin-right: 15px !important;
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

        /* Badges */
        .badge {
            padding: 2px 8px;
            border-radius: 9999px;
            font-size: 8px;
            font-weight: 600;
            display: inline-block;
        }

        .badge-so {
            background: #10b98120;
            color: #10b981;
            border: 1px solid #10b98140;
        }

        .badge-h3 {
            background: #f59e0b20;
            color: #f59e0b;
            border: 1px solid #f59e0b40;
        }

        .badge-coco {
            background: #3b82f620;
            color: #3b82f6;
            border: 1px solid #3b82f640;
        }

        /* Date Picker Fields */
        .date-input {
            background-color: var(--input-bg);
            border: 1px solid var(--border-color);
            border-radius: 6px;
            color: var(--text-body);
            padding: 6px 12px;
            font-size: 12px;
            min-width: 140px;
            outline: none;
            height: 32px;
            box-sizing: border-box;
            cursor: pointer;
            transition: all 0.2s;
        }

        .date-input:focus {
            border-color: #1d4ed8;
            box-shadow: 0 0 0 3px rgba(29, 78, 216, 0.1);
        }

        .date-input::placeholder {
            color: var(--text-muted);
            opacity: 0.6;
        }

        /* jQuery UI Date Picker */
        .ui-datepicker {
            background: var(--bg-panel) !important;
            border: 1px solid var(--border-color) !important;
            border-radius: 10px !important;
            padding: 12px !important;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15) !important;
            font-family: 'Inter', sans-serif !important;
            width: auto !important;
        }

        .ui-datepicker .ui-datepicker-header {
            background: var(--bg-panel) !important;
            border: none !important;
            padding: 5px 0 10px 0 !important;
            color: var(--text-heading) !important;
        }

        .ui-datepicker .ui-datepicker-title {
            color: var(--text-heading) !important;
            font-weight: 600 !important;
            font-size: 14px !important;
        }

        .ui-datepicker .ui-datepicker-prev,
        .ui-datepicker .ui-datepicker-next {
            border: none !important;
            background: var(--bg-panel) !important;
            cursor: pointer !important;
            color: var(--text-muted) !important;
            border-radius: 6px !important;
            padding: 4px 8px !important;
            transition: all 0.2s !important;
        }

        .ui-datepicker .ui-datepicker-prev:hover,
        .ui-datepicker .ui-datepicker-next:hover {
            background: var(--hover-bg) !important;
            color: var(--text-heading) !important;
        }

        .ui-datepicker .ui-datepicker-calendar {
            border-collapse: collapse !important;
        }

        .ui-datepicker .ui-datepicker-calendar th {
            color: var(--text-muted) !important;
            font-weight: 600 !important;
            font-size: 11px !important;
            padding: 6px 0 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.5px !important;
        }

        .ui-datepicker .ui-datepicker-calendar td {
            padding: 2px !important;
        }

        .ui-datepicker .ui-datepicker-calendar td a {
            color: var(--text-body) !important;
            border: none !important;
            border-radius: 6px !important;
            padding: 6px 10px !important;
            text-align: center !important;
            font-size: 13px !important;
            transition: all 0.2s !important;
            background: transparent !important;
            text-decoration: none !important;
        }

        .ui-datepicker .ui-datepicker-calendar td a:hover {
            background: var(--hover-bg) !important;
            color: var(--text-heading) !important;
        }

        .ui-datepicker .ui-datepicker-calendar td a.ui-state-active {
            background: #1d4ed8 !important;
            color: #ffffff !important;
        }

        .ui-datepicker .ui-datepicker-calendar td a.ui-state-highlight {
            background: var(--hover-bg) !important;
            color: var(--text-heading) !important;
        }

        .ui-datepicker .ui-datepicker-current-day a {
            background: #1d4ed8 !important;
            color: #ffffff !important;
        }

        .ui-datepicker .ui-datepicker-calendar td a.ui-state-disabled {
            color: var(--text-muted) !important;
            opacity: 0.3 !important;
        }

        /* Dark Mode Date Picker */
        html.dark-mode .ui-datepicker {
            background: #0d1520 !important;
            border: 1px solid #1a2635 !important;
            border-radius: 10px !important;
            padding: 12px !important;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.6) !important;
            font-family: 'Inter', sans-serif !important;
        }

        html.dark-mode .ui-datepicker .ui-datepicker-header {
            background: #0d1520 !important;
            border: none !important;
            padding: 5px 0 10px 0 !important;
        }

        html.dark-mode .ui-datepicker .ui-datepicker-title {
            color: #ffffff !important;
            font-weight: 600 !important;
            font-size: 14px !important;
        }

        html.dark-mode .ui-datepicker .ui-datepicker-prev,
        html.dark-mode .ui-datepicker .ui-datepicker-next {
            border: none !important;
            background: transparent !important;
            cursor: pointer !important;
            color: #94a3b8 !important;
            border-radius: 6px !important;
            padding: 4px 8px !important;
            transition: all 0.2s !important;
        }

        html.dark-mode .ui-datepicker .ui-datepicker-prev:hover,
        html.dark-mode .ui-datepicker .ui-datepicker-next:hover {
            background: #1a2635 !important;
            color: #ffffff !important;
        }

        html.dark-mode .ui-datepicker .ui-datepicker-calendar {
            border-collapse: collapse !important;
        }

        html.dark-mode .ui-datepicker .ui-datepicker-calendar th {
            color: #94a3b8 !important;
            font-weight: 600 !important;
            font-size: 11px !important;
            padding: 6px 0 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.5px !important;
        }

        html.dark-mode .ui-datepicker .ui-datepicker-calendar td {
            padding: 2px !important;
        }

        html.dark-mode .ui-datepicker .ui-datepicker-calendar td a {
            color: #e5e7eb !important;
            border: none !important;
            border-radius: 6px !important;
            padding: 6px 10px !important;
            text-align: center !important;
            font-size: 13px !important;
            transition: all 0.2s !important;
            background: transparent !important;
            text-decoration: none !important;
        }

        html.dark-mode .ui-datepicker .ui-datepicker-calendar td a:hover {
            background: #1a2635 !important;
            color: #ffffff !important;
        }

        html.dark-mode .ui-datepicker .ui-datepicker-calendar td a.ui-state-active {
            background: #1d4ed8 !important;
            color: #ffffff !important;
        }

        html.dark-mode .ui-datepicker .ui-datepicker-calendar td a.ui-state-highlight {
            background: #1a2635 !important;
            color: #ffffff !important;
        }

        html.dark-mode .ui-datepicker .ui-datepicker-current-day a {
            background: #1d4ed8 !important;
            color: #ffffff !important;
        }

        html.dark-mode .ui-datepicker .ui-datepicker-calendar td a.ui-state-disabled {
            color: #64748b !important;
            opacity: 0.4 !important;
        }

        html.dark-mode .ui-datepicker .ui-datepicker-calendar td a.ui-state-default {
            color: #94a3b8 !important;
        }

        html.dark-mode .ui-datepicker .ui-datepicker-calendar td a.ui-state-default:hover {
            color: #ffffff !important;
        }

        /* Dark Mode - Date Input Fields */
        html.dark-mode .date-input {
            background-color: #060b13 !important;
            border: 1px solid #1a2635 !important;
            color: #e5e7eb !important;
        }

        html.dark-mode .date-input:focus {
            border-color: #3b82f6 !important;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15) !important;
        }

        html.dark-mode .date-input::placeholder {
            color: #64748b !important;
            opacity: 0.6 !important;
        }

        /* Dark Mode - Date Picker Dropdown (Month/Year) */
        html.dark-mode .ui-datepicker select.ui-datepicker-month,
        html.dark-mode .ui-datepicker select.ui-datepicker-year {
            background: #0d1520 !important;
            color: #e5e7eb !important;
            border: 1px solid #1a2635 !important;
            border-radius: 4px !important;
            padding: 2px 4px !important;
        }

        html.dark-mode .ui-datepicker select.ui-datepicker-month option,
        html.dark-mode .ui-datepicker select.ui-datepicker-year option {
            background: #0d1520 !important;
            color: #e5e7eb !important;
        }


        /* Filter Section */
        .filter-section {
            background-color: var(--filter-bg);
            border-bottom: 1px solid var(--border-color);
            padding: 10px 16px;
            width: 100%;
            flex-shrink: 0;
            transition: background-color .25s ease, border-color .25s ease;
        }

        .filter-container {
            display: flex;
            flex-wrap: wrap;
            align-items: flex-end;
            gap: 12px;
            width: 100%;
        }

        .filter-item {
            flex: 0 0 auto;
        }

        .filter-label {
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
            padding: 6px 18px;
            border-radius: 6px;
            border: none;
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s;
            height: 32px;
        }

        .btn-get:hover {
            background-color: #2563eb;
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

        .form-label {
            color: var(--text-muted);
            font-size: 10px;
            font-weight: 500;
            margin-bottom: 3px;
            display: block;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        #assignModal {
            background: var(--modal-overlay);
            backdrop-filter: blur(8px);
        }

        #assignModalWrapper {
            background-color: var(--bg-panel) !important;
            border-color: var(--border-color) !important;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35);
        }

        html.dark-mode #assignModalWrapper {
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.8);
        }

        #assignModalWrapper .border-b {
            border-color: var(--border-color) !important;
        }

        #assignModalWrapper .border-t {
            border-color: var(--border-color) !important;
        }

        #selectedOrdersDisplay {
            background-color: var(--input-bg);
            border-color: var(--border-color);
            min-height: 60px;
            border-radius: 0.25rem;
            padding: 8px;
            display: flex;
            flex-wrap: wrap;
            gap: 4px;
        }

        .selected-order-item {
            background: var(--selected-item-bg);
            border: 1px solid var(--border-color);
            border-radius: 0.25rem;
            padding: 4px 8px;
            font-size: 10px;
            color: var(--text-body);
            display: inline-block;
        }

        #orderDetailsSummary {
            background-color: var(--input-bg);
            border: 1px solid var(--border-color);
            border-radius: 0.25rem;
            padding: 8px 10px;
            max-height: 150px;
            overflow-y: auto;
        }

        #orderDetailsSummary .order-detail-item {
            border-bottom: 1px solid var(--order-detail-border);
            padding: 4px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 11px;
        }

        #orderDetailsSummary .order-detail-item:last-child {
            border-bottom: none;
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

        .datatables-toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
        }

        .datatables-toolbar-left {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }

        .datatables-toolbar-right {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
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

        @media (max-width: 1024px) {
            .toolbar-row {
                flex-wrap: wrap;
            }

            .toolbar-right {
                flex-wrap: wrap;
            }
        }

        @media (max-width: 768px) {
            .filter-item {
                width: 100% !important;
            }

            .date-input {
                width: 100% !important;
                min-width: unset !important;
            }
        }
    </style>
</head>

<body class="flex h-screen overflow-hidden text-xs">

    <?php include 'includes/sidebar.php'; ?>

    <main id="mainContent" class="flex-1 flex flex-col overflow-hidden">

        <?php include 'includes/topbar.php'; ?>

        <!-- Filter Section -->
        <div class="filter-section">
            <div class="filter-container">
                <div class="filter-item">
                    <label class="filter-label">From</label>
                    <input type="text" id="filterDateFrom" class="date-input" placeholder="Select Date" readonly>
                </div>
                <div class="filter-item">
                    <label class="filter-label">To</label>
                    <input type="text" id="filterDateTo" class="date-input" placeholder="Select Date" readonly>
                </div>
                <div class="filter-item">
                    <button id="getBtn" class="btn-get" onclick="fetchSalesInvoices()">
                        <i class="fa-solid fa-arrow-right mr-1"></i> Get
                    </button>
                </div>
            </div>
        </div>

        <div class="flex-1 overflow-y-auto p-4" id="pageContent">

            <div class="flex justify-between items-center mb-4">
                <div>
                    <h2 class="text-heading font-semibold text-base tracking-wide uppercase">Assign Sales Invoice Cart
                    </h2>
                    <p class="text-[10px] text-gray-500">Manage sales invoices and assign to cart users</p>
                </div>
                <button onclick="openAssignModal()"
                    class="bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 rounded text-xs font-medium transition flex items-center gap-2">
                    <i class="fa-solid fa-cart-plus"></i> Assign to Cart User
                </button>
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
                        <div id="searchContainer">
                            <!-- DataTables Search will be placed here -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sales Invoice Cart Table -->
            <div class="panel-card overflow-hidden">
                <div class="table-container">
                    <table id="salesInvoiceTable" class="display" style="width:100%;">
                        <thead>
                            <tr>
                                <th style="width:30px;">
                                    <input type="checkbox" id="selectAll" class="custom-checkbox"
                                        onchange="toggleAllCheckboxes()">
                                </th>
                                <th>S.No</th>
                                <th>Date</th>
                                <th>Site Name</th>
                                <th>JD Code</th>
                                <th>Category Desc</th>
                                <th>Order #</th>
                                <th>Order Type</th>
                                <th>Invoice #</th>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Rate</th>
                                <th>Total Amount</th>
                                <th>Unit</th>
                                <th>Hold Code</th>
                                <th>Order Date</th>
                                <th>Order Time</th>
                            </tr>
                        </thead>
                        <tbody id="salesInvoiceTableBody">
                            <tr>
                                <td colspan="17" class="text-center py-8 text-gray-500">
                                    <i class="fa-solid fa-spinner fa-spin text-blue-400 mr-2"></i>
                                    Loading invoices...
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>

    <!-- ASSIGN MODAL -->
    <div id="assignModal"
        class="fixed inset-0 z-50 hidden backdrop-blur-sm flex items-center justify-center transition-opacity duration-300 opacity-0">
        <div class="border rounded-lg shadow-2xl w-full max-w-2xl flex flex-col max-h-[85vh] transform scale-95 transition-transform duration-300"
            id="assignModalWrapper">
            <div class="flex justify-between items-center p-4 border-b" style="border-color: var(--border-color);">
                <h3 class="text-heading font-semibold text-sm tracking-wide">Assign Orders</h3>
                <button onclick="closeAssignModal()" class="text-gray-400 hover:text-red-500 transition">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>
            <div class="p-4 overflow-y-auto flex-1">
                <form id="assignForm" onsubmit="confirmAssign(event)">
                    <div class="mb-4">
                        <label class="form-label">Select Cart User</label>
                        <select id="cartUser" class="form-select" required>
                            <option value="">Select</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Selected Orders</label>
                        <div id="selectedOrdersDisplay">
                            <span class="text-gray-500 text-xs">No orders selected</span>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Order Details</label>
                        <div id="orderDetailsSummary">
                            <span class="text-gray-500 text-xs">No orders selected</span>
                        </div>
                    </div>

                    <div class="flex gap-3 mt-4 pt-3 border-t" style="border-color: var(--border-color);">
                        <button type="submit" class="btn-success flex-1">Assign</button>
                        <button type="button" onclick="closeAssignModal()" class="btn-secondary">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- TOAST -->
    <div id="toast" class="toast">
        <i class="fa-solid fa-check-circle mr-2"></i>
        <span id="toastMessage">Success!</span>
    </div>

    <script>
        $(document).ready(function () {
            $('#sidebarToggle').on('click', function () {
                $('#sidebar').toggleClass('collapsed');
                const isCollapsed = $('#sidebar').hasClass('collapsed');
                localStorage.setItem('sidebarCollapsed', isCollapsed);
            });

            const savedState = localStorage.getItem('sidebarCollapsed');
            if (savedState === 'true') {
                $('#sidebar').addClass('collapsed');
            }

            // Initialize Date Pickers
            $('#filterDateFrom').datepicker({
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true,
                showButtonPanel: true,
                onSelect: function (selectedDate) {
                    $('#filterDateTo').datepicker('option', 'minDate', selectedDate);
                }
            });

            $('#filterDateTo').datepicker({
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true,
                showButtonPanel: true,
                onSelect: function (selectedDate) {
                    $('#filterDateFrom').datepicker('option', 'maxDate', selectedDate);
                }
            });

            // Set default dates
            const today = new Date();
            const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
            $('#filterDateFrom').datepicker('setDate', firstDay);
            $('#filterDateTo').datepicker('setDate', today);

            // Load cart users
            loadCartUsers();

            // Fetch initial data
            fetchSalesInvoices();

            // Close dropdown on outside click
            $(document).on('click', function (e) {
                if (!$(e.target).closest('.column-visibility-dropdown').length) {
                    closeColumnDropdown();
                }
            });
        });

        let dataTable = null;
        let selectedOrders = [];
        let salesInvoiceData = [];
        const API_BASE_URL = 'api/';

        // Column Visibility Configuration
        const columnConfig = [
            { idx: 0, label: 'Checkbox' },
            { idx: 1, label: 'S.No' },
            { idx: 2, label: 'Date' },
            { idx: 3, label: 'Site Name' },
            { idx: 4, label: 'JD Code' },
            { idx: 5, label: 'Category Desc' },
            { idx: 6, label: 'Order #' },
            { idx: 7, label: 'Order Type' },
            { idx: 8, label: 'Invoice #' },
            { idx: 9, label: 'Product' },
            { idx: 10, label: 'Quantity' },
            { idx: 11, label: 'Rate' },
            { idx: 12, label: 'Total Amount' },
            { idx: 13, label: 'Unit' },
            { idx: 14, label: 'Hold Code' },
            { idx: 15, label: 'Order Date' },
            { idx: 16, label: 'Order Time' }
        ];

        function formatDate(date) {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }

        // Load Cart Users
        function loadCartUsers() {
            $.ajax({
                url: API_BASE_URL + 'get/get_cart_users.php?key=03201232927&pre=Admin&user_id=1',
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    const select = $('#cartUser');
                    select.empty().append('<option value="">Select</option>');
                    if (response && Array.isArray(response)) {
                        $.each(response, function (index, user) {
                            select.append($('<option>', {
                                value: user.id,
                                text: user.name
                            }));
                        });
                    }
                },
                error: function () {
                    console.log('Failed to load cart users');
                }
            });
        }

        // Fetch Sales Invoices from API
        function fetchSalesInvoices() {
            const fromDate = $('#filterDateFrom').val();
            const toDate = $('#filterDateTo').val();

            if (!fromDate || !toDate) {
                showToast('Please select both From and To dates.', 'error');
                return;
            }

            $('#salesInvoiceTableBody').html(`
                <tr>
                    <td colspan="17" class="text-center py-8 text-gray-500">
                        <i class="fa-solid fa-spinner fa-spin text-blue-400 mr-2"></i>
                        Loading invoices...
                    </td>
                </tr>
            `);

            const url = API_BASE_URL + 'get/get_all_sales_invoices.php?key=03201232927&pre=Admin&user_id=1&from=' + fromDate + '&to=' + toDate + '&rettype=CO%20';

            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                timeout: 30000,
                success: function (response) {
                    if (response && Array.isArray(response)) {
                        salesInvoiceData = response;
                        initializeDataTable();
                    } else {
                        showToast('No invoices found.', 'error');
                        salesInvoiceData = [];
                        initializeDataTable();
                    }
                },
                error: function (xhr, status, error) {
                    console.error('API Error:', status, error);
                    showToast('Failed to load invoices.', 'error');
                    salesInvoiceData = [];
                    initializeDataTable();
                }
            });
        }

        // Populate Column Visibility Dropdown
        function populateColumnDropdown() {
            const container = $('#columnListItems');
            container.empty();

            columnConfig.forEach(function (col) {
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

        // Column Visibility Functions
        function toggleColumnVisibility(colIdx) {
            if (!dataTable) return;
            try {
                const isVisible = dataTable.column(colIdx).visible();
                dataTable.column(colIdx).visible(!isVisible);
                const checkbox = $(`#col-checkbox-${colIdx}`);
                checkbox.prop('checked', !isVisible);
            } catch (e) {
                console.warn('Column visibility toggle error:', e);
            }
        }

        function selectAllColumns() {
            if (!dataTable) return;
            try {
                columnConfig.forEach(function (col) {
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
                columnConfig.forEach(function (col) {
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

        // Dropdown Toggle Functions
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

        // Initialize DataTable
        function initializeDataTable() {
            if ($.fn.DataTable.isDataTable('#salesInvoiceTable')) {
                $('#salesInvoiceTable').DataTable().destroy();
            }

            const tableData = salesInvoiceData.map((item, index) => {
                let typeBadge = '';
                if (item.order_type === 'SO') typeBadge = 'badge-so';
                else if (item.order_type === 'H3') typeBadge = 'badge-h3';

                return [
                    `<input type="checkbox" class="custom-checkbox row-checkbox" data-id="${item.id}" onchange="updateSelectedOrders()">`,
                    index + 1,
                    item.created_at || '-',
                    item.dealer_name || '-',
                    item.customer_id || '-',
                    item.cat7desc || '-',
                    item.order_no || '-',
                    `<span class="badge ${typeBadge}">${item.order_type || '-'}</span>`,
                    item.invoice_no || '-',
                    item.product_name || '-',
                    item.quantity ? parseFloat(item.quantity).toLocaleString() : '-',
                    item.rate || '-',
                    item.total_amount ? parseFloat(item.total_amount).toLocaleString() : '-',
                    item.unit_measure || '-',
                    item.hold_code || '-',
                    item.order_date || '-',
                    item.datetime || '-'
                ];
            });

            dataTable = $('#salesInvoiceTable').DataTable({
                data: tableData,
                columns: [
                    { title: '', orderable: false, searchable: false },
                    { title: 'S.No' },
                    { title: 'Date' },
                    { title: 'Site Name' },
                    { title: 'JD Code' },
                    { title: 'Category Desc' },
                    { title: 'Order #' },
                    { title: 'Order Type' },
                    { title: 'Invoice #' },
                    { title: 'Product' },
                    { title: 'Quantity' },
                    { title: 'Rate' },
                    { title: 'Total Amount' },
                    { title: 'Unit' },
                    { title: 'Hold Code' },
                    { title: 'Order Date' },
                    { title: 'Order Time' }
                ],
                dom: 'Bfrtip',
                buttons: [
                    { extend: 'copy', text: '<i class="fa-regular fa-copy"></i> Copy', className: 'toolbar-btn', exportOptions: { columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16] } },
                    { extend: 'excelHtml5', text: '<i class="fa-regular fa-file-excel"></i> Excel', className: 'toolbar-btn', exportOptions: { columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16] }, title: 'Sales_Invoice_Cart' },
                    { extend: 'csvHtml5', text: '<i class="fa-regular fa-file-csv"></i> CSV', className: 'toolbar-btn', exportOptions: { columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16] }, title: 'Sales_Invoice_Cart' },
                    {
                        extend: 'pdfHtml5', text: '<i class="fa-regular fa-file-pdf"></i> PDF', className: 'toolbar-btn', exportOptions: { columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16] }, title: 'Sales Invoice Cart Report', orientation: 'landscape', pageSize: 'A4', customize: function (doc) {
                            doc.defaultStyle.fontSize = 7;
                            doc.styles.tableHeader.fontSize = 8;
                            doc.styles.tableHeader.fillColor = '#0a121c';
                            doc.styles.tableHeader.color = '#ffffff';
                        }
                    },
                    { extend: 'print', text: '<i class="fa-solid fa-print"></i> Print', className: 'toolbar-btn', exportOptions: { columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16] } }
                ],
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100],
                ordering: true,
                order: [[1, 'asc']],
                language: {
                    emptyTable: '<div class="text-center py-8 text-gray-500"><i class="fa-solid fa-file-invoice text-2xl block mb-2"></i>No data available in table</div>',
                    info: 'Showing _START_ to _END_ of _TOTAL_ items',
                    infoEmpty: 'Showing 0 to 0 of 0 items',
                    infoFiltered: '(filtered from _MAX_ total items)',
                    search: 'Search:'
                },
                drawCallback: function () {
                    $('.dt-buttons .dt-button').each(function () {
                        $(this).addClass('toolbar-btn');
                    });
                    $('.row-checkbox').each(function () {
                        const id = parseInt($(this).data('id'));
                        if (selectedOrders.includes(id)) {
                            $(this).prop('checked', true);
                        }
                    });
                },
                initComplete: function () {
                    // Move buttons to left container
                    const buttonsContainer = $('#exportButtonsContainer');
                    buttonsContainer.empty();
                    $('.dt-buttons').appendTo(buttonsContainer);

                    // Move search to right container
                    const searchContainer = $('#searchContainer');
                    searchContainer.empty();

                    // Get the search filter and append to container
                    const searchFilter = $('.dataTables_filter');
                    if (searchFilter.length > 0) {
                        searchContainer.append(searchFilter);
                    } else {
                        // If search filter doesn't exist, create one
                        searchContainer.html(`
                            <div class="dataTables_filter">
                                <label>
                                    Search:
                                    <input type="search" class="dataTables_filter_input" placeholder="Search orders..." 
                                           style="display:inline-block;width:220px;padding:6px 14px;padding-left:34px;
                                           border:1.5px solid var(--border-color);border-radius:6px;
                                           background-color:var(--input-bg);color:var(--text-body);
                                           font-size:12px;font-family:'Inter',sans-serif;outline:none;height:32px;
                                           transition:all 0.3s ease;
                                           background-image:url('data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' fill=\'none\' viewBox=\'0 0 24 24\' stroke=\'%2364748b\'%3E%3Cpath stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z\'/%3E%3C/svg%3E');
                                           background-repeat:no-repeat;background-position:10px center;background-size:16px;">
                                </label>
                            </div>
                        `);

                        // Bind search event to custom input
                        $('.dataTables_filter_input').on('keyup', function () {
                            dataTable.search(this.value).draw();
                        });
                    }
                }
            });
        }

        // Select All Checkboxes
        function toggleAllCheckboxes() {
            const isChecked = $('#selectAll').prop('checked');
            $('.row-checkbox').prop('checked', isChecked);
            updateSelectedOrders();
        }

        // Update Selected Orders
        function updateSelectedOrders() {
            selectedOrders = [];
            $('.row-checkbox:checked').each(function () {
                selectedOrders.push(parseInt($(this).data('id')));
            });

            const totalCheckboxes = $('.row-checkbox').length;
            const checkedCheckboxes = $('.row-checkbox:checked').length;
            if (totalCheckboxes > 0 && checkedCheckboxes === totalCheckboxes) {
                $('#selectAll').prop('checked', true);
            } else {
                $('#selectAll').prop('checked', false);
            }
        }

        // Open Assign Modal
        function openAssignModal() {
            if (selectedOrders.length === 0) {
                showToast('Please select at least one order to assign.', 'error');
                return;
            }

            const displayDiv = $('#selectedOrdersDisplay');
            const detailsDiv = $('#orderDetailsSummary');

            let displayHtml = '';
            let detailsHtml = '';

            selectedOrders.forEach(id => {
                const item = salesInvoiceData.find(d => d.id == id);
                if (item) {
                    displayHtml += `
                        <span class="selected-order-item">
                            ${item.order_no} - ${item.product_name} - ${item.quantity}
                        </span>
                    `;
                    detailsHtml += `
                        <div class="order-detail-item">
                            <span class="text-gray-400">${item.order_no}</span>
                            <span class="text-blue-400">${item.product_name}</span>
                            <span class="text-emerald-400">${item.quantity}</span>
                            <span class="text-gray-500">${item.dealer_name}</span>
                        </div>
                    `;
                }
            });

            displayDiv.html(displayHtml || '<span class="text-gray-500 text-xs">No orders selected</span>');
            detailsDiv.html(detailsHtml || '<span class="text-gray-500 text-xs">No orders selected</span>');

            $('#cartUser').val('');

            const modal = $('#assignModal');
            modal.removeClass('hidden').addClass('flex');
            setTimeout(function () {
                modal.removeClass('opacity-0');
                $('#assignModalWrapper').removeClass('scale-95').addClass('scale-100');
            }, 10);
        }

        function closeAssignModal() {
            const modal = $('#assignModal');
            modal.addClass('opacity-0');
            $('#assignModalWrapper').removeClass('scale-100').addClass('scale-95');
            setTimeout(function () {
                modal.addClass('hidden').removeClass('flex');
            }, 300);
        }

        // Confirm Assign - API Call
        function confirmAssign(event) {
            event.preventDefault();

            const cartUserId = $('#cartUser').val();

            if (!cartUserId) {
                showToast('Please select a cart user.', 'error');
                return;
            }

            const submitBtn = $('#assignForm button[type="submit"]');
            submitBtn.prop('disabled', true);
            submitBtn.html('<i class="fa-solid fa-spinner fa-spin mr-1"></i> Assigning...');

            $.ajax({
                url: API_BASE_URL + 'create/assign_orders.php',
                type: 'POST',
                data: JSON.stringify({
                    orders: selectedOrders,
                    cart_user_id: cartUserId
                }),
                contentType: 'application/json',
                dataType: 'json',
                timeout: 30000,
                success: function (response) {
                    submitBtn.prop('disabled', false);
                    submitBtn.html('Assign');

                    console.log('Server response:', response);

                    if (response.status == 1) {
                        let message = response.message || 'Orders assigned successfully!';
                        if (response.skipped > 0) {
                            message += ' (' + response.skipped + ' orders were already assigned)';
                        }
                        showToast(message, 'success');
                        closeAssignModal();
                        selectedOrders = [];
                        $('.row-checkbox').prop('checked', false);
                        $('#selectAll').prop('checked', false);
                        fetchSalesInvoices();
                    } else {
                        showToast('Error: ' + (response.message || 'Failed to assign orders'), 'error');
                    }
                },
                error: function (xhr, status, error) {
                    submitBtn.prop('disabled', false);
                    submitBtn.html('Assign');

                    console.error('Assign Error - Status:', status);
                    console.error('Assign Error - Response Text:', xhr.responseText);
                    console.error('Assign Error - Status Code:', xhr.status);

                    if (xhr.responseText) {
                        try {
                            const errorResponse = JSON.parse(xhr.responseText);
                            showToast('Error: ' + (errorResponse.message || 'Failed to assign orders'), 'error');
                        } catch (e) {
                            const errorMsg = xhr.responseText.substring(0, 200);
                            showToast('Server Error: ' + errorMsg, 'error');
                        }
                    } else {
                        showToast('Network error. Please try again.', 'error');
                    }
                }
            });
        }

        // Toast Notification
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

        $(document).on('click', '#assignModal', function (e) {
            if (e.target === this) closeAssignModal();
        });

        $(document).on('keydown', function (e) {
            if (e.key === 'Escape') {
                if (!$('#assignModal').hasClass('hidden')) {
                    closeAssignModal();
                }
                closeColumnDropdown();
            }
        });
    </script>

</body>

</html>