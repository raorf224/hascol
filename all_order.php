<?php
// Hascol OMC Operations Command Center - Local All Orders
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hascol OMC - All Orders</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Flatpickr Date Picker -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

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
        .search-input::placeholder {
            color: var(--text-muted);
        }
        .search-input:focus {
            border-color: #1d4ed8;
            box-shadow: 0 0 0 2px rgba(29, 78, 216, 0.2);
        }

        .form-select {
            background-color: var(--input-bg);
            border: 1px solid var(--border-color);
            border-radius: 0.25rem;
            color: var(--text-body);
            padding: 4px 28px 4px 10px;
            font-size: 11px;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3E%3Cpath stroke='%2364748b' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3E%3C/svg%3E");
            background-position: right 8px center;
            background-repeat: no-repeat;
            background-size: 14px;
            padding-right: 32px;
            cursor: pointer;
            height: 30px;
            box-sizing: border-box;
            min-width: 130px;
        }
        .form-select:focus {
            outline: none;
            border-color: #1d4ed8;
            box-shadow: 0 0 0 2px rgba(29, 78, 216, 0.2);
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

        .date-input-wrapper {
            position: relative;
            display: inline-block;
        }
        .date-input-wrapper .form-input {
            padding-right: 32px;
            width: 180px;
            cursor: pointer;
        }
        .date-input-wrapper .date-icon {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 12px;
            pointer-events: none;
        }

        .flatpickr-calendar {
            background: var(--bg-panel) !important;
            border: 1px solid var(--border-color) !important;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3) !important;
            border-radius: 0.5rem !important;
            font-family: 'Inter', sans-serif !important;
            padding: 4px !important;
        }
        .flatpickr-calendar .flatpickr-months {
            background: var(--bg-panel) !important;
            border-bottom: 1px solid var(--border-color) !important;
            padding: 6px 0 !important;
            border-radius: 0.5rem 0.5rem 0 0 !important;
        }
        .flatpickr-calendar .flatpickr-months .flatpickr-month {
            color: var(--text-heading) !important;
        }
        .flatpickr-calendar .flatpickr-current-month {
            color: var(--text-heading) !important;
            padding: 4px 0 !important;
        }
        .flatpickr-calendar .flatpickr-current-month .flatpickr-monthDropdown-months {
            color: var(--text-heading) !important;
            background: var(--bg-panel) !important;
            font-weight: 600 !important;
            border-radius: 0.25rem !important;
            padding: 2px 4px !important;
        }
        .flatpickr-calendar .flatpickr-current-month .flatpickr-monthDropdown-months:hover {
            background: var(--hover-bg) !important;
        }
        .flatpickr-calendar .flatpickr-current-month input.cur-year {
            color: var(--text-heading) !important;
            font-weight: 600 !important;
        }
        .flatpickr-calendar .flatpickr-current-month input.cur-year:focus {
            border-color: #1d4ed8 !important;
        }
        .flatpickr-calendar .flatpickr-weekdays {
            background: var(--bg-panel) !important;
            padding: 4px 0 !important;
        }
        .flatpickr-calendar .flatpickr-weekday {
            color: var(--text-muted) !important;
            font-weight: 600 !important;
            font-size: 11px !important;
        }
        .flatpickr-calendar .flatpickr-days {
            background: var(--bg-panel) !important;
        }
        .flatpickr-calendar .dayContainer {
            background: var(--bg-panel) !important;
        }
        .flatpickr-calendar .flatpickr-day {
            color: var(--text-body) !important;
            border-radius: 0.25rem !important;
            font-weight: 500 !important;
            transition: all 0.15s ease !important;
        }
        .flatpickr-calendar .flatpickr-day:hover {
            background: var(--hover-bg) !important;
            color: var(--text-heading) !important;
            border-color: transparent !important;
        }
        .flatpickr-calendar .flatpickr-day.selected {
            background: #1d4ed8 !important;
            border-color: #1d4ed8 !important;
            color: #ffffff !important;
            box-shadow: 0 2px 8px rgba(29, 78, 216, 0.3) !important;
        }
        .flatpickr-calendar .flatpickr-day.selected:hover {
            background: #2563eb !important;
            border-color: #2563eb !important;
        }
        .flatpickr-calendar .flatpickr-day.today {
            border-color: var(--border-color) !important;
            color: var(--text-heading) !important;
            font-weight: 700 !important;
        }
        .flatpickr-calendar .flatpickr-day.today.selected {
            border-color: #1d4ed8 !important;
        }
        .flatpickr-calendar .flatpickr-day.inRange {
            background: rgba(29, 78, 216, 0.12) !important;
            border-color: transparent !important;
            color: var(--text-heading) !important;
        }
        .flatpickr-calendar .flatpickr-day.startRange,
        .flatpickr-calendar .flatpickr-day.endRange {
            background: #1d4ed8 !important;
            border-color: #1d4ed8 !important;
            color: #ffffff !important;
            box-shadow: 0 2px 8px rgba(29, 78, 216, 0.3) !important;
        }
        .flatpickr-calendar .flatpickr-day.startRange:hover,
        .flatpickr-calendar .flatpickr-day.endRange:hover {
            background: #2563eb !important;
            border-color: #2563eb !important;
        }
        .flatpickr-calendar .flatpickr-day.flatpickr-disabled {
            color: var(--text-muted) !important;
            opacity: 0.4 !important;
        }
        .flatpickr-calendar .flatpickr-prev-month,
        .flatpickr-calendar .flatpickr-next-month {
            padding: 6px !important;
            border-radius: 0.25rem !important;
        }
        .flatpickr-calendar .flatpickr-prev-month:hover,
        .flatpickr-calendar .flatpickr-next-month:hover {
            background: var(--hover-bg) !important;
        }
        .flatpickr-calendar .flatpickr-prev-month svg,
        .flatpickr-calendar .flatpickr-next-month svg {
            fill: var(--text-muted) !important;
            transition: fill 0.15s ease !important;
            width: 14px !important;
            height: 14px !important;
        }
        .flatpickr-calendar .flatpickr-prev-month:hover svg,
        .flatpickr-calendar .flatpickr-next-month:hover svg {
            fill: var(--text-heading) !important;
        }
        .flatpickr-calendar .numInputWrapper span.arrowUp,
        .flatpickr-calendar .numInputWrapper span.arrowDown {
            border-color: var(--text-muted) !important;
        }
        .flatpickr-calendar .numInputWrapper span.arrowUp:hover,
        .flatpickr-calendar .numInputWrapper span.arrowDown:hover {
            border-color: var(--text-heading) !important;
        }

        .flatpickr-calendar.dark {
            background: #0d1520 !important;
            border-color: #1a2635 !important;
        }
        .flatpickr-calendar.dark .flatpickr-months {
            background: #0d1520 !important;
            border-color: #1a2635 !important;
        }
        .flatpickr-calendar.dark .flatpickr-months .flatpickr-month {
            color: #ffffff !important;
        }
        .flatpickr-calendar.dark .flatpickr-current-month {
            color: #ffffff !important;
        }
        .flatpickr-calendar.dark .flatpickr-current-month .flatpickr-monthDropdown-months {
            color: #ffffff !important;
            background: #0d1520 !important;
        }
        .flatpickr-calendar.dark .flatpickr-current-month input.cur-year {
            color: #ffffff !important;
        }
        .flatpickr-calendar.dark .flatpickr-weekday {
            color: #94a3b8 !important;
        }
        .flatpickr-calendar.dark .flatpickr-day {
            color: #e5e7eb !important;
        }
        .flatpickr-calendar.dark .flatpickr-day:hover {
            background: #1a2635 !important;
            color: #ffffff !important;
        }
        .flatpickr-calendar.dark .flatpickr-day.selected {
            background: #1d4ed8 !important;
            border-color: #1d4ed8 !important;
            color: #ffffff !important;
        }
        .flatpickr-calendar.dark .flatpickr-day.today {
            border-color: #1a2635 !important;
            color: #ffffff !important;
        }
        .flatpickr-calendar.dark .flatpickr-day.inRange {
            background: rgba(29, 78, 216, 0.2) !important;
            color: #ffffff !important;
        }
        .flatpickr-calendar.dark .flatpickr-day.flatpickr-disabled {
            color: #64748b !important;
        }
        .flatpickr-calendar.dark .flatpickr-prev-month svg,
        .flatpickr-calendar.dark .flatpickr-next-month svg {
            fill: #94a3b8 !important;
        }
        .flatpickr-calendar.dark .flatpickr-prev-month:hover svg,
        .flatpickr-calendar.dark .flatpickr-next-month:hover svg {
            fill: #ffffff !important;
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
            height: 32px;
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

        .form-input {
            background-color: var(--input-bg);
            border: 1px solid var(--border-color);
            border-radius: 0.25rem;
            color: var(--text-body);
            padding: 6px 10px;
            width: 100%;
            font-size: 12px;
            transition: border-color 0.2s;
            height: 32px;
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
    </style>
</head>

<body class="flex h-screen overflow-hidden text-xs">

    <?php include 'includes/sidebar.php'; ?>

    <main id="mainContent" class="flex-1 flex flex-col overflow-hidden">

        <?php include 'includes/topbar.php'; ?>

        <div class="flex-1 overflow-y-auto p-4" id="pageContent">

            <div class="panel-card p-4 mb-4">
                <div class="flex flex-wrap items-end gap-4">
                    <div>
                        <label class="form-label">From</label>
                        <div class="date-input-wrapper">
                            <input type="text" id="fromdate" class="form-input" value="2026-08-26" style="width:180px;" readonly>
                            <i class="fa-regular fa-calendar date-icon"></i>
                        </div>
                    </div>
                    <div>
                        <label class="form-label">To</label>
                        <div class="date-input-wrapper">
                            <input type="text" id="todate" class="form-input" value="2026-09-01" style="width:180px;" readonly>
                            <i class="fa-regular fa-calendar date-icon"></i>
                        </div>
                    </div>
                    <div>
                        <button onclick="fetchtable()" class="btn-primary" style="padding:0 24px;">
                            <i class="fa-solid fa-magnifying-glass mr-1"></i> Get
                        </button>
                    </div>
                </div>
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
                            <input type="text" id="customSearchInput" placeholder="Search orders..." class="search-input" style="width:180px;">
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel-card overflow-hidden">
                <div class="table-container">
                    <table id="ordersTable" class="display" style="width:100%;">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Date</th>
                                <th>JD Code</th>
                                <th>Site Name</th>
                                <th>Site Depots</th>
                                <th>Depot</th>
                                <th>Type</th>
                                <th>Total Amount</th>
                                <th>Ledger Amount</th>
                                <th>Status</th>
                                <th>Push Status</th>
                                <th>Product</th>
                                <th>Rate</th>
                                <th>Quantity</th>
                                <th>Bill Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="15" class="text-center py-8 text-gray-500">
                                    <i class="fa-solid fa-spinner fa-spin text-blue-400 mr-2"></i>
                                    Loading orders...
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <?php include 'includes/footer.php'; ?>
    </main>

    <div id="toast" class="toast">
        <i class="fa-solid fa-check-circle mr-2"></i>
        <span id="toastMessage">Action completed successfully!</span>
    </div>

    <div id="approvedOrderModal" class="fixed inset-0 z-50 hidden backdrop-blur-sm flex items-center justify-center transition-opacity duration-300 opacity-0">
        <div class="panel-card border rounded-lg shadow-2xl w-full max-w-md transform scale-95 transition-transform duration-300">
            <div class="flex justify-between items-center p-4 border-b" style="border-color: var(--border-color);">
                <h3 class="text-heading font-semibold text-sm">Approve Order</h3>
                <button onclick="closeApprovedModal()" class="text-gray-400 hover:text-red-500 transition">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>
            <form id="approvedOrderForm" onsubmit="saveApprovedOrder(event)">
                <div class="p-4 space-y-4">
                    <input type="hidden" id="orderApprovalId" name="order_approval">
                    <div>
                        <label class="form-label">Status</label>
                        <select id="approvedOrderStatus" name="approved_order_status" class="form-select">
                            <option value="">Choose...</option>
                            <option value="5">Forward</option>
                            <option value="2">Cancel</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Depot</label>
                        <select id="sDepot" name="s_depot" class="form-select">
                            <option value="">Choose...</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Description</label>
                        <textarea id="approvedOrderDescription" name="approved_order_description" rows="3" class="form-input" placeholder="Enter description..."></textarea>
                    </div>
                </div>
                <div class="flex gap-3 p-4 border-t" style="border-color: var(--border-color);">
                    <button type="submit" class="btn-primary flex-1">Save Changes</button>
                    <button type="button" onclick="closeApprovedModal()" class="btn-secondary">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <div id="insufficientModal" class="fixed inset-0 z-50 hidden backdrop-blur-sm flex items-center justify-center transition-opacity duration-300 opacity-0">
        <div class="panel-card border rounded-lg shadow-2xl w-full max-w-md transform scale-95 transition-transform duration-300">
            <div class="flex justify-between items-center p-4 border-b" style="border-color: var(--border-color);">
                <h3 class="text-heading font-semibold text-sm">Insufficient Balance</h3>
                <button onclick="closeInsufficientModal()" class="text-gray-400 hover:text-red-500 transition">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>
            <form id="insufficientForm" onsubmit="saveInsufficientOrder(event)">
                <div class="p-4 space-y-4">
                    <input type="hidden" id="specialApprovalId" name="spe_approval">
                    <div>
                        <label class="form-label">Action</label>
                        <select id="insufficientAction" name="in_balanced_order" class="form-select">
                            <option value="">Choose...</option>
                            <option value="2">Block Order</option>
                            <option value="3">Special Approval</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Description</label>
                        <textarea id="insufficientDescription" name="in_balanced_description" rows="3" class="form-input" placeholder="Enter description..."></textarea>
                    </div>
                </div>
                <div class="flex gap-3 p-4 border-t" style="border-color: var(--border-color);">
                    <button type="submit" class="btn-primary flex-1">Save Changes</button>
                    <button type="button" onclick="closeInsufficientModal()" class="btn-secondary">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <div id="backlogModal" class="fixed inset-0 z-50 hidden backdrop-blur-sm flex items-center justify-center transition-opacity duration-300 opacity-0">
        <div class="panel-card border rounded-lg shadow-2xl w-full max-w-2xl max-h-[80vh] transform scale-95 transition-transform duration-300 overflow-hidden">
            <div class="flex justify-between items-center p-4 border-b flex-shrink-0" style="border-color: var(--border-color);">
                <h3 class="text-heading font-semibold text-sm">Order Backlog</h3>
                <button onclick="closeBacklogModal()" class="text-gray-400 hover:text-red-500 transition">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>
            <div class="flex-1 overflow-y-auto p-4">
                <div id="orderLogsContainer" class="space-y-4"></div>
            </div>
        </div>
    </div>

    <div id="productDetailModal" class="fixed inset-0 z-50 hidden backdrop-blur-sm flex items-center justify-center transition-opacity duration-300 opacity-0">
        <div class="panel-card border rounded-lg shadow-2xl w-full max-w-5xl max-h-[80vh] transform scale-95 transition-transform duration-300 overflow-hidden">
            <div class="flex justify-between items-center p-4 border-b flex-shrink-0" style="border-color: var(--border-color);">
                <h3 class="text-heading font-semibold text-sm">Order Details</h3>
                <button onclick="closeProductDetailModal()" class="text-gray-400 hover:text-red-500 transition">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>
            <div class="flex-1 overflow-y-auto p-4">
                <div class="table-container">
                    <table id="productDetailTable" class="display" style="width:100%;">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Date</th>
                                <th>JD Code</th>
                                <th>Site Name</th>
                                <th>Product Type</th>
                                <th>Rate</th>
                                <th>Qty</th>
                                <th>Delivered</th>
                                <th>Depot</th>
                                <th>Order Amount</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>

        function updateDatePickerTheme() {
            const isDark = document.documentElement.classList.contains('dark-mode');
            const calendars = document.querySelectorAll('.flatpickr-calendar');
            calendars.forEach(function(cal) {
                if (isDark) {
                    cal.classList.add('dark');
                } else {
                    cal.classList.remove('dark');
                }
            });
        }

        $(document).ready(function() {
            var fromPicker = flatpickr("#fromdate", {
                dateFormat: "Y-m-d",
                maxDate: new Date(),
                onChange: function(selectedDates, dateStr, instance) {
                    if (toPicker) {
                        toPicker.set('minDate', dateStr);
                    }
                }
            });

            var toPicker = flatpickr("#todate", {
                dateFormat: "Y-m-d",
                maxDate: new Date(),
                onChange: function(selectedDates, dateStr, instance) {
                    if (fromPicker) {
                        fromPicker.set('maxDate', dateStr);
                    }
                }
            });

            setTimeout(function() {
                updateDatePickerTheme();
            }, 100);

            var darkModeObserver = new MutationObserver(function() {
                updateDatePickerTheme();
            });
            darkModeObserver.observe(document.documentElement, {
                attributes: true,
                attributeFilter: ['class']
            });

            // Also observe when flatpickr calendar is dynamically created
            var calendarObserver = new MutationObserver(function() {
                updateDatePickerTheme();
            });
            calendarObserver.observe(document.body, {
                childList: true,
                subtree: true,
                attributes: false
            });

            $('#customSearchInput').on('keyup', function() {
                if ($.fn.DataTable.isDataTable('#ordersTable')) {
                    $('#ordersTable').DataTable().search($(this).val()).draw();
                }
            });

            loadDepots();
            fetchtable();

            $(document).on('click', function(e) {
                if (!$(e.target).closest('.column-visibility-dropdown').length) {
                    closeColumnDropdown();
                }
            });
        });

        const API_BASE_URL = 'api/';

        let ordersDataTable = null;
        let productDetailDataTable = null;

        const columnConfig = [
            { idx: 0, label: 'S.No' },
            { idx: 1, label: 'Date' },
            { idx: 2, label: 'JD Code' },
            { idx: 3, label: 'Site Name' },
            { idx: 4, label: 'Site Depots' },
            { idx: 5, label: 'Depot' },
            { idx: 6, label: 'Type' },
            { idx: 7, label: 'Total Amount' },
            { idx: 8, label: 'Ledger Amount' },
            { idx: 9, label: 'Status' },
            { idx: 10, label: 'Push Status' },
            { idx: 11, label: 'Product' },
            { idx: 12, label: 'Rate' },
            { idx: 13, label: 'Quantity' },
            { idx: 14, label: 'Bill Amount' }
        ];

        function showToast(message, type = 'success') {
            const toast = $('#toast');
            $('#toastMessage').text(message);
            toast.removeClass('success error').addClass(type);
            toast.addClass('show');
            clearTimeout(window.toastTimeout);
            window.toastTimeout = setTimeout(() => toast.removeClass('show'), 3000);
        }

        function loadDepots() {
            $.ajax({
                url: API_BASE_URL + 'get/geo_depot.php?key=03201232927',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    const select = $('#sDepot');
                    select.empty().append('<option value="">Choose...</option>');
                    $.each(data, function(i, item) {
                        select.append($('<option>', { value: item.consignee_name, text: item.consignee_name }));
                    });
                },
                error: function() {
                    console.log('Failed to load depots');
                }
            });
        }

        function fetchtable() {
            const fromdate = $('#fromdate').val();
            const todate = $('#todate').val();
            const rettypes = "CO ";

            $('#ordersTable tbody').html(`
                <tr>
                    <td colspan="15" class="text-center py-8 text-gray-500">
                        <i class="fa-solid fa-spinner fa-spin text-blue-400 mr-2"></i>
                        Loading orders...
                    </td>
                </tr>
            `);

            $.ajax({
                url: API_BASE_URL + 'get/get_all_app_orders.php?key=03201232927&pre=Admin&user_id=1&from=' + fromdate + '&to=' + todate + '&rettype=' + rettypes,
                type: 'GET',
                dataType: 'json',
                timeout: 30000,
                success: function(response) {
                    if (response && Array.isArray(response) && response.length > 0) {
                        const allRows = [];
                        $.each(response, function(index, data) {
                            let statusHtml = '';
                            let approvedClass = '';
                            let st = '';

                            const orderAmount = parseFloat(data.total_amount) || 0;
                            const ledgerBalance = parseFloat(data.legder_balance) || 0;

                            if (data.status == 0) {
                                if (ledgerBalance >= orderAmount) {
                                    st = 'Pending';
                                    approvedClass = 'bg-primary';
                                } else {
                                    st = 'Insuficient Balance';
                                    approvedClass = 'bg-warning';
                                }
                                statusHtml = `<span id="${data.id}" class="badge rounded-pill cursor-pointer ${approvedClass}" style="padding:2px 10px;border-radius:9999px;font-size:9px;font-weight:600;color:#fff;">${st}</span>`;
                            } else if (data.status == 1) {
                                statusHtml = `<span id="${data.id}" class="badge rounded-pill cursor-pointer bg-info" style="padding:2px 10px;border-radius:9999px;font-size:9px;font-weight:600;color:#fff;">Approved</span>`;
                            } else if (data.status == 2) {
                                statusHtml = `<span id="${data.id}" class="badge rounded-pill cursor-pointer bg-danger" style="padding:2px 10px;border-radius:9999px;font-size:9px;font-weight:600;color:#fff;">Blocked</span>`;
                            } else if (data.status == 3) {
                                statusHtml = `<span id="${data.id}" class="badge rounded-pill cursor-pointer bg-dark" style="padding:2px 10px;border-radius:9999px;font-size:9px;font-weight:600;color:#fff;">Special Approval</span>`;
                            } else if (data.status == 4) {
                                statusHtml = `<span id="${data.id}" class="badge rounded-pill cursor-pointer bg-warning" style="padding:2px 10px;border-radius:9999px;font-size:9px;font-weight:600;color:#000;">Released</span>`;
                            } else if (data.status == 5) {
                                statusHtml = `<span id="${data.id}" class="badge rounded-pill cursor-pointer bg-success" style="padding:2px 10px;border-radius:9999px;font-size:9px;font-weight:600;color:#fff;">Forwarded</span>`;
                            } else if (data.status == 6) {
                                statusHtml = `<span id="${data.id}" class="badge rounded-pill cursor-pointer bg-success" style="padding:2px 10px;border-radius:9999px;font-size:9px;font-weight:600;color:#fff;">Processed</span>`;
                            }

                            let ledgerDisplay = '---';
                            let statusDisplay = '---';
                            let rettypeDesc = $.trim(data.rettype_desc);
                            if (rettypeDesc !== 'COCO site') {
                                ledgerDisplay = parseFloat(data.legder_balance).toLocaleString();
                                statusDisplay = statusHtml;
                            }

                            let pushStatusHtml = '';
                            if (data.status != '6') {
                                pushStatusHtml = data.status_value || '';
                            } else {
                                pushStatusHtml = `<button type="button" id="${data.id}" class="action-btn edit" onclick="openApprovedModal(${data.id})"><i class="fa-regular fa-pen-to-square"></i></button>`;
                            }

                            const mainRow = [
                                index + 1,
                                data.created_at || '',
                                data.sap_no || '',
                                data.name || '',
                                data.dealers_depots || '',
                                data.depot || '',
                                data.type || '',
                                parseFloat(data.total_amount).toLocaleString(),
                                ledgerDisplay,
                                statusDisplay,
                                pushStatusHtml,
                                '',
                                '',
                                '',
                                ''
                            ];
                            allRows.push(mainRow);

                            $.ajax({
                                url: API_BASE_URL + 'get/get_main_sub_orders.php?key=03201232927&id=' + data.id,
                                type: 'GET',
                                dataType: 'json',
                                async: false,
                                success: function(subData) {
                                    if (subData && subData.length > 0) {
                                        $.each(subData, function(si, sub) {
                                            const subRow = [
                                                (index + 1) + '.' + (si + 1),
                                                sub.date || '',
                                                sub.sap_no || '',
                                                sub.name || '',
                                                '',
                                                '',
                                                '',
                                                '',
                                                '',
                                                '',
                                                '',
                                                sub.product_name || '',
                                                sub.rate || '',
                                                parseFloat(sub.quantity).toLocaleString(),
                                                parseFloat(sub.amount).toLocaleString()
                                            ];
                                            allRows.push(subRow);
                                        });
                                    }
                                }
                            });
                        });

                        initializeDataTable(allRows);
                    } else {
                        showToast('No orders found.', 'error');
                        initializeDataTable([]);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('API Error:', status, error);
                    showToast('Failed to load orders. Please refresh.', 'error');
                    initializeDataTable([]);
                }
            });
        }

        function initializeDataTable(data) {
            if ($.fn.DataTable.isDataTable('#ordersTable')) {
                $('#ordersTable').DataTable().destroy();
            }

            ordersDataTable = $('#ordersTable').DataTable({
                data: data,
                columns: [
                    { title: 'S.No' },
                    { title: 'Date' },
                    { title: 'JD Code' },
                    { title: 'Site Name' },
                    { title: 'Site Depots' },
                    { title: 'Depot' },
                    { title: 'Type' },
                    { title: 'Total Amount' },
                    { title: 'Ledger Amount' },
                    { title: 'Status', orderable: false, searchable: false },
                    { title: 'Push Status', orderable: false, searchable: false },
                    { title: 'Product' },
                    { title: 'Rate' },
                    { title: 'Quantity' },
                    { title: 'Bill Amount' }
                ],
                dom: 'Bfrtip',
                buttons: [
                    { extend: 'copy', text: '<i class="fa-regular fa-copy"></i> Copy', className: 'toolbar-btn', exportOptions: { columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14] } },
                    { extend: 'excelHtml5', text: '<i class="fa-regular fa-file-excel"></i> Excel', className: 'toolbar-btn', exportOptions: { columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14] }, title: 'All_Orders' },
                    { extend: 'csvHtml5', text: '<i class="fa-regular fa-file-csv"></i> CSV', className: 'toolbar-btn', exportOptions: { columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14] }, title: 'All_Orders' },
                    { extend: 'pdfHtml5', text: '<i class="fa-regular fa-file-pdf"></i> PDF', className: 'toolbar-btn', exportOptions: { columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14] }, title: 'All Orders', orientation: 'landscape', pageSize: 'A4' },
                    { extend: 'print', text: '<i class="fa-solid fa-print"></i> Print', className: 'toolbar-btn', exportOptions: { columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14] } }
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
                    $('.dt-buttons .dt-button').addClass('toolbar-btn');
                    $('#ordersTable tbody').off('click', '.badge').on('click', '.badge', function() {
                        const id = $(this).attr('id');
                        const text = $(this).text().trim();
                        if (text === 'Pending') {
                            openApprovedModal(id);
                        } else if (text === 'Insuficient Balance') {
                            openInsufficientModal(id);
                        }
                    });
                },
                initComplete: function() {
                    const buttonsContainer = $('#exportButtonsContainer');
                    $('.dt-buttons').appendTo(buttonsContainer);
                    populateColumnDropdown();
                }
            });
        }

        function populateColumnDropdown() {
            const container = $('#columnListItems');
            container.empty();
            columnConfig.forEach(function(col) {
                let isVisible = true;
                try { isVisible = ordersDataTable.column(col.idx).visible(); } catch(e) { isVisible = true; }
                const item = `
                    <div class="dropdown-item" onclick="toggleColumnVisibility(${col.idx})">
                        <input type="checkbox" id="col-checkbox-${col.idx}" ${isVisible ? 'checked' : ''} onclick="event.stopPropagation(); toggleColumnVisibility(${col.idx})">
                        <span class="column-label">${col.label}</span>
                    </div>
                `;
                container.append(item);
            });
        }

        function toggleColumnVisibility(colIdx) {
            if (!ordersDataTable) return;
            try {
                const isVisible = ordersDataTable.column(colIdx).visible();
                ordersDataTable.column(colIdx).visible(!isVisible);
                $(`#col-checkbox-${colIdx}`).prop('checked', !isVisible);
            } catch(e) { console.warn('Column visibility error:', e); }
        }

        function selectAllColumns() {
            if (!ordersDataTable) return;
            try {
                columnConfig.forEach(function(col) {
                    if (!ordersDataTable.column(col.idx).visible()) {
                        ordersDataTable.column(col.idx).visible(true);
                    }
                    $(`#col-checkbox-${col.idx}`).prop('checked', true);
                });
                showToast('All columns selected!', 'success');
            } catch(e) { showToast('Error selecting columns', 'error'); }
        }

        function deselectAllColumns() {
            if (!ordersDataTable) return;
            try {
                columnConfig.forEach(function(col) {
                    if (ordersDataTable.column(col.idx).visible()) {
                        ordersDataTable.column(col.idx).visible(false);
                    }
                    $(`#col-checkbox-${col.idx}`).prop('checked', false);
                });
                showToast('All columns deselected!', 'success');
            } catch(e) { showToast('Error deselecting columns', 'error'); }
        }

        function toggleColumnDropdown() {
            const menu = $('#columnDropdownMenu');
            menu.toggleClass('show');
            if (menu.hasClass('show')) { populateColumnDropdown(); }
        }

        function closeColumnDropdown() {
            $('#columnDropdownMenu').removeClass('show');
        }

        function viewOrderDetails(id) {
            if (!id) return;
            $.ajax({
                url: API_BASE_URL + 'get/get_main_sub_orders.php?key=03201232927&id=' + id,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response && response.length > 0) {
                        if ($.fn.DataTable.isDataTable('#productDetailTable')) {
                            $('#productDetailTable').DataTable().destroy();
                        }
                        const data = response.map(function(item, idx) {
                            return [
                                idx + 1,
                                item.date || '',
                                item.sap_no || '',
                                item.name || '',
                                item.product_name || '',
                                item.rate || '',
                                parseFloat(item.quantity).toLocaleString(),
                                item.delivery_based || '',
                                item.consignee_name || '',
                                parseFloat(item.amount).toLocaleString()
                            ];
                        });
                        productDetailDataTable = $('#productDetailTable').DataTable({
                            data: data,
                            columns: [
                                { title: 'S.No' },
                                { title: 'Date' },
                                { title: 'JD Code' },
                                { title: 'Site Name' },
                                { title: 'Product Type' },
                                { title: 'Rate' },
                                { title: 'Qty' },
                                { title: 'Delivered' },
                                { title: 'Depot' },
                                { title: 'Order Amount' }
                            ],
                            dom: 'Bfrtip',
                            buttons: [
                                { extend: 'copy', text: '<i class="fa-regular fa-copy"></i> Copy' },
                                { extend: 'excelHtml5', text: '<i class="fa-regular fa-file-excel"></i> Excel' },
                                { extend: 'pdfHtml5', text: '<i class="fa-regular fa-file-pdf"></i> PDF', orientation: 'landscape', pageSize: 'A4' }
                            ],
                            pageLength: 10,
                            language: { emptyTable: 'No products found' }
                        });
                        openProductDetailModal();
                    } else {
                        showToast('No products found for this order.', 'error');
                    }
                },
                error: function() {
                    showToast('Failed to load order details.', 'error');
                }
            });
        }

        function viewOrderBacklog(id) {
            if (!id) return;
            $.ajax({
                url: API_BASE_URL + 'get/get_order_backlog.php?key=03201232927&order_id=' + id,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    const container = $('#orderLogsContainer');
                    container.empty();
                    if (response && response.length > 0) {
                        $.each(response, function(idx, item) {
                            const date = new Date(item.created_at);
                            const day = date.getDate();
                            const month = date.toLocaleString('en-US', { month: 'short' });
                            const statusClass = item.status == 0 ? 'bg-primary' : (item.status == 1 ? 'bg-info' : (item.status == 2 ? 'bg-success' : (item.status == 3 ? 'bg-danger' : (item.status == 4 ? 'bg-warning' : 'bg-dark'))));
                            container.append(`
                                <div class="flex items-start gap-4 p-3 rounded panel-card">
                                    <div class="flex-shrink-0 text-center min-w-[50px]">
                                        <div class="text-heading font-bold text-lg">${day}</div>
                                        <div class="text-gray-500 text-[10px]">${month}</div>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2">
                                            <span class="badge ${statusClass}" style="padding:2px 10px;border-radius:9999px;font-size:9px;font-weight:600;color:#fff;">${item.status_value || 'Unknown'}</span>
                                        </div>
                                        <p class="text-xs text-gray-400 mt-1">Action By: ${item.name || 'N/A'}</p>
                                        <p class="text-xs text-gray-500">${item.created_at || ''}</p>
                                        ${item.description ? `<p class="text-xs text-gray-400 mt-1">${item.description}</p>` : ''}
                                    </div>
                                </div>
                            `);
                        });
                    } else {
                        container.html('<p class="text-center text-gray-500 py-8">No backlog history found.</p>');
                    }
                    openBacklogModal();
                },
                error: function() {
                    showToast('Failed to load backlog.', 'error');
                }
            });
        }

        function openApprovedModal(id) {
            $('#orderApprovalId').val(id);
            $('#approvedOrderModal').removeClass('hidden').addClass('flex');
            setTimeout(() => {
                $('#approvedOrderModal').removeClass('opacity-0');
                $('#approvedOrderModal .transform').removeClass('scale-95').addClass('scale-100');
            }, 10);
        }

        function closeApprovedModal() {
            $('#approvedOrderModal').addClass('opacity-0');
            $('#approvedOrderModal .transform').removeClass('scale-100').addClass('scale-95');
            setTimeout(() => $('#approvedOrderModal').addClass('hidden').removeClass('flex'), 300);
        }

        function saveApprovedOrder(event) {
            event.preventDefault();
            const formData = new FormData(document.getElementById('approvedOrderForm'));
            $.ajax({
                url: API_BASE_URL + 'update/approved_orders.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(response) {
                    if (response === 1) {
                        showToast('Order approved successfully!', 'success');
                        closeApprovedModal();
                        fetchtable();
                    } else {
                        showToast('Failed to approve order.', 'error');
                    }
                },
                error: function() {
                    showToast('Error processing request.', 'error');
                }
            });
        }

        function openInsufficientModal(id) {
            $('#specialApprovalId').val(id);
            $('#insufficientModal').removeClass('hidden').addClass('flex');
            setTimeout(() => {
                $('#insufficientModal').removeClass('opacity-0');
                $('#insufficientModal .transform').removeClass('scale-95').addClass('scale-100');
            }, 10);
        }

        function closeInsufficientModal() {
            $('#insufficientModal').addClass('opacity-0');
            $('#insufficientModal .transform').removeClass('scale-100').addClass('scale-95');
            setTimeout(() => $('#insufficientModal').addClass('hidden').removeClass('flex'), 300);
        }

        function saveInsufficientOrder(event) {
            event.preventDefault();
            const formData = new FormData(document.getElementById('insufficientForm'));
            $.ajax({
                url: API_BASE_URL + 'update/send_special_approval.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(response) {
                    if (response === 1) {
                        showToast('Action completed successfully!', 'success');
                        closeInsufficientModal();
                        fetchtable();
                    } else {
                        showToast('Failed to complete action.', 'error');
                    }
                },
                error: function() {
                    showToast('Error processing request.', 'error');
                }
            });
        }

        function openBacklogModal() {
            $('#backlogModal').removeClass('hidden').addClass('flex');
            setTimeout(() => {
                $('#backlogModal').removeClass('opacity-0');
                $('#backlogModal .transform').removeClass('scale-95').addClass('scale-100');
            }, 10);
        }

        function closeBacklogModal() {
            $('#backlogModal').addClass('opacity-0');
            $('#backlogModal .transform').removeClass('scale-100').addClass('scale-95');
            setTimeout(() => $('#backlogModal').addClass('hidden').removeClass('flex'), 300);
        }

        function openProductDetailModal() {
            $('#productDetailModal').removeClass('hidden').addClass('flex');
            setTimeout(() => {
                $('#productDetailModal').removeClass('opacity-0');
                $('#productDetailModal .transform').removeClass('scale-95').addClass('scale-100');
            }, 10);
        }

        function closeProductDetailModal() {
            $('#productDetailModal').addClass('opacity-0');
            $('#productDetailModal .transform').removeClass('scale-100').addClass('scale-95');
            setTimeout(() => $('#productDetailModal').addClass('hidden').removeClass('flex'), 300);
        }

        $(document).on('keydown', function(e) {
            if (e.key === 'Escape') {
                closeApprovedModal();
                closeInsufficientModal();
                closeBacklogModal();
                closeProductDetailModal();
                closeColumnDropdown();
            }
        });

        $(document).on('click', '#approvedOrderModal, #insufficientModal, #backlogModal, #productDetailModal', function(e) {
            if (e.target === this) {
                if (this.id === 'approvedOrderModal') closeApprovedModal();
                else if (this.id === 'insufficientModal') closeInsufficientModal();
                else if (this.id === 'backlogModal') closeBacklogModal();
                else if (this.id === 'productDetailModal') closeProductDetailModal();
            }
        });
    </script>

</body>

</html>