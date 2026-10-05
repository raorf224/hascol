<?php
// Hascol OMC - Plan Task Management (Standalone)
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Plan Task | Hascol OMC</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta content="Hascol OMC Management Dashboard" name="description" />

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

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
            min-height: 100vh;
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

        .form-input::placeholder {
            color: var(--text-muted);
        }

        .form-label {
            color: var(--text-muted);
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 6px;
            display: block;
        }

        .form-group {
            margin-bottom: 1rem;
            width: 100%;
        }

        .btn-primary {
            background-color: #1d4ed8;
            color: #ffffff;
            padding: 8px 20px;
            border-radius: 0.25rem;
            border: none;
            font-size: 13px;
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

        .btn-primary:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .btn-secondary {
            background-color: var(--btn-secondary-bg);
            color: var(--btn-secondary-text);
            padding: 8px 20px;
            border-radius: 0.25rem;
            border: none;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s, color 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-secondary:hover {
            background-color: var(--btn-secondary-hover-bg);
            color: var(--btn-secondary-hover-text);
        }

        .table-container {
            position: relative;
            overflow-x: auto;
            min-height: 200px;
        }

        .table-container table {
            width: 100% !important;
            border-collapse: collapse;
            font-size: 12px;
        }

        .table-container table thead th {
            background-color: var(--table-head-bg) !important;
            color: var(--table-head-text) !important;
            font-weight: 600;
            text-align: left;
            padding: 12px 14px;
            border-bottom: 2px solid var(--border-color);
            white-space: nowrap;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table-container table tbody td {
            padding: 10px 14px;
            border-bottom: 1px solid var(--border-color);
            color: var(--table-row-text);
            vertical-align: middle;
            font-size: 12px;
        }

        .table-container table tbody tr:hover {
            background-color: var(--table-row-hover);
        }

        .table-loading-overlay {
            position: absolute;
            inset: 0;
            background-color: var(--bg-panel);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-size: 13px;
            color: var(--text-muted);
            z-index: 5;
            border-radius: 0.375rem;
        }

        .table-loading-overlay.hidden {
            display: none;
        }

        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_length {
            display: none !important;
        }

        .dataTables_wrapper .dataTables_info {
            color: var(--text-muted) !important;
            font-size: 12px !important;
            padding-top: 12px !important;
        }

        .dataTables_wrapper .dataTables_paginate {
            padding-top: 12px !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 4px 12px !important;
            margin: 0 2px !important;
            border-radius: 4px !important;
            background: var(--toolbar-btn-bg) !important;
            border: 1px solid var(--border-color) !important;
            color: var(--text-muted) !important;
            font-size: 12px !important;
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
            padding: 6px 14px !important;
            background-color: var(--toolbar-btn-bg) !important;
            border: 1px solid var(--border-color) !important;
            border-radius: 0.25rem !important;
            color: var(--text-muted) !important;
            font-size: 11px !important;
            cursor: pointer !important;
            transition: all 0.2s !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 6px !important;
            font-family: 'Inter', sans-serif !important;
            height: 32px !important;
            box-sizing: border-box !important;
        }

        .dt-buttons .dt-button:hover {
            background-color: var(--hover-bg) !important;
            color: var(--text-heading) !important;
        }

        .toolbar-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
            width: 100%;
        }

        .toolbar-left {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
            min-width: 0;
        }

        .toolbar-right {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
            flex-shrink: 0;
        }

        .offcanvas {
            position: fixed;
            top: 0;
            bottom: 0;
            width: 550px;
            max-width: 92vw;
            max-height: 100vh;
            display: flex;
            flex-direction: column;
            background-color: var(--bg-panel);
            box-shadow: -10px 0 30px rgba(0, 0, 0, 0.25);
            transform: translateX(100%);
            transition: transform 0.3s ease-in-out;
            visibility: hidden;
            outline: 0;
            z-index: 99999;
        }

        .offcanvas.offcanvas-end {
            right: 0;
            border-left: 1px solid var(--border-color);
        }

        .offcanvas.showing,
        .offcanvas.show {
            transform: translateX(0);
            visibility: visible;
        }

        .offcanvas-backdrop {
            position: fixed;
            inset: 0;
            background-color: var(--modal-overlay);
            opacity: 0;
            transition: opacity 0.15s linear;
            z-index: 99998;
        }

        .offcanvas-backdrop.show {
            opacity: 1;
        }

        .offcanvas-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            padding: 16px 20px;
            flex-shrink: 0;
        }

        .offcanvas-header.border-bottom {
            border-bottom: 1px solid var(--border-color);
        }

        .offcanvas-title {
            margin: 0;
            font-size: 16px;
        }

        .offcanvas-body {
            flex: 1 1 auto;
            padding: 24px;
            overflow-y: auto;
        }

        .btn-close {
            width: 28px;
            height: 28px;
            border: none;
            background: transparent;
            color: var(--text-muted);
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 4px;
            padding: 0;
            flex-shrink: 0;
            transition: background-color 0.2s, color 0.2s;
            font-size: 20px;
        }

        .btn-close::before {
            content: "\00d7";
            font-size: 22px;
            line-height: 1;
        }

        .btn-close:hover {
            background-color: var(--hover-bg);
            color: var(--text-heading);
        }

        .form-select {
            background-color: var(--input-bg);
            border: 1px solid var(--border-color);
            border-radius: 0.25rem;
            color: var(--text-body);
            padding: 8px 12px;
            width: 100%;
            font-size: 13px;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3E%3Cpath stroke='%2364748b' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3E%3C/svg%3E");
            background-position: right 10px center;
            background-repeat: no-repeat;
            background-size: 16px;
            padding-right: 36px;
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

        .dealer-checkbox-card {
            background-color: var(--bg-panel);
            border: 1px solid var(--border-color);
            border-radius: 0.375rem;
            padding: 12px 16px;
            margin-bottom: 10px;
            transition: border-color 0.2s;
        }

        .dealer-checkbox-card:hover {
            border-color: #1d4ed8;
        }

        .badge-status {
            padding: 4px 12px;
            border-radius: 9999px;
            font-size: 11px;
            font-weight: 600;
        }

        .badge-status.pending {
            background: #f59e0b20;
            color: #f59e0b;
        }

        .badge-status.completed {
            background: #10b98120;
            color: #10b981;
        }

        .badge-status.inprogress {
            background: #3b82f620;
            color: #3b82f6;
        }

        .filter-row {
            display: flex;
            align-items: flex-end;
            gap: 12px;
            flex-wrap: wrap;
            padding: 10px 0 6px 0;
        }

        .filter-row .filter-group {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .filter-row .filter-group label {
            font-size: 11px;
            font-weight: 600;
            color: var(--text-muted);
        }

        .filter-row .filter-group input {
            height: 32px;
            padding: 4px 10px;
            width: 140px;
        }

        @media (max-width: 1024px) {
            .toolbar-row {
                flex-direction: column;
                align-items: stretch;
            }

            .toolbar-left,
            .toolbar-right {
                width: 100%;
            }

            .toolbar-right {
                justify-content: flex-start;
            }

            .filter-row {
                flex-direction: column;
                align-items: stretch;
            }
        }

        @media (max-width: 640px) {
            .dt-buttons .dt-button {
                font-size: 10px !important;
                padding: 4px 10px !important;
                height: 28px !important;
            }

            .offcanvas {
                width: 100%;
                max-width: 100%;
            }

            .dealer-checkbox-card .grid {
                grid-template-columns: 1fr !important;
                gap: 8px;
            }

            .filter-row .filter-group input {
                width: 100%;
            }
        }

        @media (max-width: 480px) {
            .offcanvas {
                width: 100%;
                max-width: 100%;
            }

            .offcanvas-body {
                padding: 16px;
            }
        }

        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: var(--scrollbar-track);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--scrollbar-thumb);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--scrollbar-thumb);
        }

        .flatpickr-calendar {
            background: var(--bg-panel);
            border: 1px solid var(--border-color);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
            border-radius: 0.375rem;
        }

        .flatpickr-calendar.arrowTop:before,
        .flatpickr-calendar.arrowTop:after {
            border-bottom-color: var(--bg-panel);
        }

        .flatpickr-months .flatpickr-month {
            background: var(--bg-panel);
            color: var(--text-heading);
            fill: var(--text-heading);
        }

        .flatpickr-current-month .flatpickr-monthDropdown-months {
            background: var(--bg-panel);
            color: var(--text-heading);
        }

        .flatpickr-current-month input.cur-year {
            color: var(--text-heading);
        }

        .flatpickr-weekdays {
            background: var(--bg-panel);
        }

        span.flatpickr-weekday {
            background: var(--bg-panel);
            color: var(--text-muted);
        }

        .flatpickr-day {
            color: var(--table-row-text);
        }

        .flatpickr-day.flatpickr-disabled,
        .flatpickr-day.flatpickr-disabled:hover {
            color: var(--text-muted);
        }

        .flatpickr-day:hover {
            background: var(--hover-bg);
            border-color: var(--hover-bg);
        }

        .flatpickr-day.today {
            border-color: #1d4ed8;
        }

        .flatpickr-day.selected,
        .flatpickr-day.selected:hover {
            background: #1d4ed8;
            border-color: #1d4ed8;
            color: #ffffff;
        }

        .flatpickr-prev-month svg,
        .flatpickr-next-month svg {
            fill: var(--text-muted);
        }

        .flatpickr-prev-month:hover svg,
        .flatpickr-next-month:hover svg {
            fill: var(--text-heading);
        }

        .numInputWrapper span.arrowUp:after {
            border-bottom-color: var(--text-muted);
        }

        .numInputWrapper span.arrowDown:after {
            border-top-color: var(--text-muted);
        }
    </style>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>

<body class="flex h-screen overflow-hidden text-sm">

    <?php include 'includes/sidebar.php'; ?>

    <main id="mainContent" class="flex-1 flex flex-col overflow-hidden">

        <?php include 'includes/topbar.php'; ?>

        <div class="flex-1 overflow-y-auto p-4 md:p-6" id="pageContent">

            <div class="flex flex-wrap justify-between items-center mb-4 gap-3">
                <div>
                    <h2 class="text-heading font-semibold text-lg tracking-wide uppercase">
                        <i class="fa-solid fa-tasks mr-2 text-blue-500"></i>Plan Task
                    </h2>
                    <p class="text-xs text-gray-500 mt-0.5">Manage inspection tasks for users</p>
                </div>
                <button onclick="openAddOffcanvas()" class="btn-primary">
                    <i class="fa-solid fa-plus"></i> Add Task
                </button>
            </div>

            <div class="panel-card p-3 mb-3">
                <div class="filter-row">
                    <div class="filter-group">
                        <label>From</label>
                        <input type="text" id="fromdate" value="2026-09-01" class="form-input text-sm"
                            placeholder="Select date" autocomplete="off">
                    </div>
                    <div class="filter-group">
                        <label>To</label>
                        <input type="text" id="todate" value="2026-10-01" class="form-input text-sm"
                            placeholder="Select date" autocomplete="off">
                    </div>
                    <button onclick="fetchTable()" class="btn-primary text-sm" style="height:32px;">
                        <i class="fa-solid fa-magnifying-glass"></i> Get
                    </button>
                    <div class="flex items-center gap-2 ml-auto">
                        <i class="fa-solid fa-magnifying-glass text-gray-500 text-sm"></i>
                        <input type="text" id="customSearchInput" placeholder="Search..." class="form-input text-sm"
                            style="height:32px;padding:4px 12px;width:180px;">
                    </div>
                </div>
            </div>

            <div class="panel-card p-3 mb-4">
                <div class="toolbar-row">
                    <div class="toolbar-left" id="exportButtonsContainer"></div>
                    <div class="toolbar-right"></div>
                </div>
            </div>

            <div class="panel-card overflow-hidden">
                <div class="table-container">
                    <div class="table-loading-overlay hidden" id="tableLoadingOverlay">
                        <i class="fa-solid fa-spinner fa-spin text-blue-400"></i>
                        Loading tasks...
                    </div>
                    <table id="myTable" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>User</th>
                                <th>Site Name</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header border-bottom">
            <h5 id="offcanvasRightLabel" class="text-heading font-semibold offcanvas-title">
                <i class="fa-solid fa-plus-circle mr-2 text-blue-500"></i>Create New Task
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form method="post" id="insert_form" enctype="multipart/form-data">

                <div class="form-group">
                    <label class="form-label">Select User <span class="text-red-500">*</span></label>
                    <select class="form-select" id="dealers" name="dealers" required>
                        <option value="">Select User</option>
                    </select>
                    <input type="hidden" name="c_user_id" id="c_user_id" value="">
                    <input type="hidden" name="user_id" id="user_id" value="1">
                    <input type="hidden" name="row_id" id="row_id" value="">
                </div>

                <div class="form-group">
                    <label class="form-label">Description</label>
                    <textarea id="description" name="description" class="form-input" rows="3"
                        placeholder="Enter task description..."></textarea>
                </div>

                <div class="mt-4">
                    <h6 class="text-heading font-semibold text-sm mb-3">Select Sites for Inspection</h6>
                    <div id="user_pumps"></div>
                </div>

                <div class="flex gap-3 mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <button type="submit" class="btn-primary flex-1 justify-center" id="insert">
                        <i class="fa-regular fa-floppy-disk"></i> Save
                    </button>
                    <button type="button" class="btn-secondary" data-bs-dismiss="offcanvas">
                        <i class="fa-regular fa-xmark"></i> Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

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

        const API_BASE = 'api/';
        const API_KEY = '03201232927';

        let dataTable = null;
        let isDataLoaded = false;
        let isUsersLoaded = false;

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

            const isDarkMode = localStorage.getItem('darkMode') === 'true';
            const icon = document.querySelector('.dark-mode-toggle i');
            if (icon) {
                icon.className = isDarkMode ? 'fa-solid fa-sun' : 'fa-solid fa-moon';
            }

            initializeDataTable();

            flatpickr('#fromdate', {
                dateFormat: 'Y-m-d',
                defaultDate: '2026-09-01',
                allowInput: true
            });
            flatpickr('#todate', {
                dateFormat: 'Y-m-d',
                defaultDate: '2026-10-01',
                allowInput: true
            });

            $('#add_btn').click(function () {
                openAddOffcanvas();
            });

            $('#insert_form').on('submit', function (event) {
                event.preventDefault();
                saveData();
            });

            $('#customSearchInput').on('keyup', function () {
                if ($.fn.DataTable.isDataTable('#myTable')) {
                    $('#myTable').DataTable().search(this.value).draw();
                }
            });

            $('#dealers').on('change', function () {
                var userId = $(this).val();
                if (userId) {
                    getSites(userId);
                } else {
                    $('#user_pumps').empty();
                }
            });

            loadUsers();
        });

        function initializeDataTable() {
            if ($.fn.DataTable.isDataTable('#myTable')) {
                $('#myTable').DataTable().destroy();
            }

            dataTable = $('#myTable').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'copy',
                        text: '<i class="fa-regular fa-copy"></i> Copy',
                        className: 'dt-button',
                        exportOptions: { columns: [0, 1, 2, 3, 4] }
                    },
                    {
                        extend: 'excelHtml5',
                        text: '<i class="fa-regular fa-file-excel"></i> Excel',
                        className: 'dt-button',
                        title: 'Plan_Task_Export',
                        exportOptions: { columns: [0, 1, 2, 3, 4] }
                    },
                    {
                        extend: 'csvHtml5',
                        text: '<i class="fa-regular fa-file-csv"></i> CSV',
                        className: 'dt-button',
                        title: 'Plan_Task_Export',
                        exportOptions: { columns: [0, 1, 2, 3, 4] }
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<i class="fa-regular fa-file-pdf"></i> PDF',
                        className: 'dt-button',
                        title: 'Plan Task',
                        orientation: 'landscape',
                        pageSize: 'A4',
                        exportOptions: { columns: [0, 1, 2, 3, 4] }
                    },
                    {
                        extend: 'print',
                        text: '<i class="fa-solid fa-print"></i> Print',
                        className: 'dt-button',
                        exportOptions: { columns: [0, 1, 2, 3, 4] }
                    }
                ],
                pageLength: 10,
                language: {
                    emptyTable: 'No tasks found',
                    info: 'Showing _START_ to _END_ of _TOTAL_ entries',
                    infoEmpty: 'Showing 0 to 0 of 0 entries',
                    infoFiltered: '(filtered from _MAX_ total entries)'
                },
                initComplete: function () {
                    const buttonsContainer = $('#exportButtonsContainer');
                    $('.dt-buttons').appendTo(buttonsContainer);
                    if (!isDataLoaded) {
                        setTimeout(function () {
                            fetchTable();
                        }, 500);
                        isDataLoaded = true;
                    }
                }
            });
        }

        function showTableLoading() {
            $('#tableLoadingOverlay').removeClass('hidden');
        }

        function hideTableLoading() {
            $('#tableLoadingOverlay').addClass('hidden');
        }

        function loadUsers() {
            if (isUsersLoaded) return;

            var url = API_BASE + 'get/task_users.php?key=' + API_KEY;

            console.log('Loading Users from:', url);

            $.ajax({
                url: url,
                method: 'GET',
                dataType: 'json',
                success: function (data) {
                    console.log('Users Response:', data);
                    var select = $('#dealers');
                    select.empty();
                    select.append($('<option>', {
                        value: '',
                        text: 'Select User'
                    }));
                    if (Array.isArray(data) && data.length > 0) {
                        $.each(data, function (index, item) {
                            var name = item.name + ' - (' + item.privilege + ')';
                            select.append($('<option>', {
                                value: item.id,
                                text: name,
                                'data-id': item.privilege
                            }));
                        });
                        isUsersLoaded = true;
                    } else {
                        console.warn('No users found in response');
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error fetching users. status=', status, 'error=', error);
                    console.error('Raw response text:', xhr.responseText);
                    console.error('HTTP status code:', xhr.status);
                }
            });
        }

        function getSites(userId) {
            var selectedOption = $('#dealers').find('option:selected');
            var privilege = selectedOption.data('id');

            $('#c_user_id').val(userId);

            var url = API_BASE + 'get/inspection/outlet_count.php?key=' + API_KEY + '&id=' + userId + '&pre=' + privilege;

            console.log('Fetching Sites URL:', url);

            showTableLoading();

            $.ajax({
                url: url,
                method: 'GET',
                dataType: 'json',
                success: function (response) {
                    console.log('Sites Response:', response);
                    var container = $('#user_pumps');
                    container.empty();

                    if (Array.isArray(response) && response.length > 0) {
                        var currentDate = new Date().toISOString().split('T')[0];
                        var index = 1;

                        $.each(response, function (i, data) {
                            var dealerDiv = $('<div class="dealer-checkbox-card">');
                            var rowDiv = $('<div class="grid grid-cols-1 md:grid-cols-3 gap-3 items-center">');

                            var checkboxDiv = $('<div class="flex items-center gap-2">');
                            var checkbox = $('<input type="checkbox" class="dealer-checkbox" id="dealer_checkbox_' + index + '" name="dealer_checkbox[]" value="0">');
                            var hiddenInput = $('<input type="hidden" id="text_checkbox_' + index + '" name="text_checkbox[]" value="0">');
                            checkboxDiv.append(checkbox).append(hiddenInput);

                            var nameDiv = $('<div>');
                            nameDiv.html('<p class="text-sm font-medium text-heading mb-0">' + data.name + '</p>');
                            var hiddenDealerId = $('<input type="hidden" id="dealers_id_' + index + '" name="dealers_id[]" value="' + data.id + '">');

                            var dateDiv = $('<div>');
                            var dateInput = $('<input type="date" class="form-input text-sm" id="inspection_date_' + index + '" name="inspection_date[]" required>');
                            dateInput.val(currentDate);
                            dateDiv.append(dateInput);

                            rowDiv.append(checkboxDiv).append(nameDiv).append(dateDiv);
                            dealerDiv.append(rowDiv).append(hiddenDealerId);
                            container.append(dealerDiv);

                            checkbox.on('change', function () {
                                var isChecked = $(this).is(':checked');
                                $(this).val(isChecked ? 1 : 0);
                                hiddenInput.val(isChecked ? 1 : 0);
                            });

                            index++;
                        });
                    } else {
                        container.append('<p class="text-sm text-gray-500">No sites available for this user.</p>');
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error fetching sites. status=', status, 'error=', error);
                    console.error('Raw response text:', xhr.responseText);
                    $('#user_pumps').empty();
                    $('#user_pumps').append('<p class="text-sm text-red-500">Failed to load sites (' + status + ')</p>');
                },
                complete: function () {
                    hideTableLoading();
                }
            });
        }

        function fetchTable() {
            var fromDate = $('#fromdate').val();
            var toDate = $('#todate').val();

            console.log('Selected From Date:', fromDate);
            console.log('Selected To Date:', toDate);

            var url = API_BASE + 'get/get_task_inspection.php?key=' + API_KEY + '&user_id=1&pre=Admin';

            if (fromDate && fromDate !== '') {
                url += '&from_date=' + fromDate;
            }
            if (toDate && toDate !== '') {
                url += '&to_date=' + toDate;
            }

            console.log('Fetching Data URL:', url);

            showTableLoading();

            $.ajax({
                url: url,
                method: 'GET',
                dataType: 'json',
                timeout: 30000,
                success: function (response) {
                    console.log('✅ Data Response:', response);
                    console.log('✅ Response Type:', typeof response);
                    console.log('✅ Is Array:', Array.isArray(response));

                    dataTable.clear().draw();

                    if (Array.isArray(response) && response.length > 0) {
                        $.each(response, function (index, data) {
                            var statusClass = 'pending';
                            var statusText = data.current_status || 'Pending';

                            if (statusText.toLowerCase() === 'completed' || statusText.toLowerCase() === 'complete') {
                                statusClass = 'completed';
                            } else if (statusText.toLowerCase() === 'inprogress' || statusText.toLowerCase() === 'in progress') {
                                statusClass = 'inprogress';
                            }

                            dataTable.row.add([
                                index + 1,
                                data.manager_name || 'N/A',
                                data.dealer_name || 'N/A',
                                data.time || 'N/A',
                                '<span class="badge-status ' + statusClass + '">' + statusText + '</span>'
                            ]);
                        });
                    }

                    dataTable.draw(false);
                },
                error: function (xhr, status, error) {
                    console.error('❌ Fetch Error. status=', status, ' error=', error);
                    console.error('❌ HTTP status code:', xhr.status);
                    console.error('❌ Raw response text:', xhr.responseText);

                    dataTable.clear().draw();

                    var msg = 'Failed to load data';
                    if (xhr.status === 0) {
                        msg = 'Network / CORS error';
                    } else if (status === 'parsererror') {
                        msg = 'Invalid response from server (check API)';
                    } else if (xhr.status === 404) {
                        msg = 'API endpoint not found (404)';
                    } else if (xhr.status === 500) {
                        msg = 'Server error (500) - check PHP logs';
                    }

                    // DataTable ke center mein error message set karein
                    dataTable.settings()[0].oLanguage.sEmptyTable =
                        '<div style="text-align:center;padding:24px;color:#ef4444;font-size:13px;">' +
                        '<i class="fa-solid fa-triangle-exclamation" style="font-size:28px;display:block;margin-bottom:10px;"></i>' +
                        msg +
                        '</div>';

                    dataTable.clear().draw();

                    console.error('Error message:', msg);
                },
                complete: function () {
                    hideTableLoading();
                }
            });
        }

        function saveData() {
            var formData = new FormData(document.getElementById('insert_form'));

            var submitBtn = $('#insert');
            submitBtn.prop('disabled', true);
            submitBtn.html('<i class="fa-solid fa-spinner fa-spin"></i> Saving...');

            var url = API_BASE + 'create/inspection/create_dealers_inspection_task.php';

            console.log('Saving to:', url);

            $.ajax({
                url: url,
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                data: formData,
                timeout: 30000,
                success: function (response) {
                    console.log('Save Response:', response);

                    if (response == '1' || response == 1) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Task Created Successfully',
                            timer: 2000,
                            showConfirmButton: true
                        });

                        document.getElementById('insert_form').reset();
                        $('#user_pumps').empty();
                        var offcanvas = bootstrap.Offcanvas.getInstance(document.getElementById('offcanvasRight'));
                        if (offcanvas) offcanvas.hide();
                        isDataLoaded = false;
                        fetchTable();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Server Error!',
                            text: 'Record Not Created: ' + response,
                        });
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Save Error:', status, error);
                    console.error('Response:', xhr.responseText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Server Error!',
                        text: 'Request Failed: ' + error,
                    });
                },
                complete: function () {
                    submitBtn.prop('disabled', false);
                    submitBtn.html('<i class="fa-regular fa-floppy-disk"></i> Save');
                }
            });
        }

        function openAddOffcanvas() {
            $('#row_id').val('');
            $('#insert_form')[0].reset();
            $('#user_pumps').empty();
            $('#offcanvasRightLabel').html('<i class="fa-solid fa-plus-circle mr-2 text-blue-500"></i>Create New Task');
            $('#insert').html('<i class="fa-regular fa-floppy-disk"></i> Save');
            document.getElementById('insert').disabled = false;

            var offcanvas = new bootstrap.Offcanvas(document.getElementById('offcanvasRight'));
            offcanvas.show();
        }

        function showToast(message, type = 'success') {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: type,
                    title: message,
                    timer: 3000,
                    showConfirmButton: false
                });
            }
        }
    </script>

</body>

</html>