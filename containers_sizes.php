<?php
// Hascol OMC - Container Sizes Management (Standalone)
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Container Sizes | Hascol OMC</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta content="Hascol OMC Management Dashboard" name="description" />

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

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
            font-size: 11px;
            font-weight: 500;
            margin-bottom: 4px;
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
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s;
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

        .table-container {
            position: relative;
            overflow-x: auto;
            min-height: 120px;
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

        .table-loading-overlay {
            position: absolute;
            inset: 0;
            background-color: var(--bg-panel);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-size: 12px;
            color: var(--text-muted);
            z-index: 5;
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

        .offcanvas {
            position: fixed;
            top: 0;
            bottom: 0;
            width: 400px;
            max-width: 90vw;
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
        }
        .offcanvas-body {
            flex: 1 1 auto;
            padding: 20px;
            overflow-y: auto;
        }
        .btn-close {
            width: 26px;
            height: 26px;
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
        }
        .btn-close::before {
            content: "\00d7";
            font-size: 20px;
            line-height: 1;
        }
        .btn-close:hover {
            background-color: var(--hover-bg);
            color: var(--text-heading);
        }

        @media (max-width: 1024px) {
            .toolbar-row {
                flex-wrap: wrap;
            }
            .toolbar-right {
                flex-wrap: wrap;
            }
        }
        @media (max-width: 640px) {
            .dt-buttons .dt-button {
                font-size: 8px !important;
                padding: 4px 8px !important;
            }
        }
        @media (max-width: 480px) {
            .offcanvas {
                width: 100%;
                max-width: 100%;
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
    </style>
</head>

<body class="flex h-screen overflow-hidden text-xs">

    <?php include 'includes/sidebar.php'; ?>

    <main id="mainContent" class="flex-1 flex flex-col overflow-hidden">

        <?php include 'includes/topbar.php'; ?>

        <div class="flex-1 overflow-y-auto p-4" id="pageContent">

            <div class="flex flex-wrap justify-between items-center mb-4 gap-2">
                <div>
                    <h2 class="text-heading font-semibold text-base tracking-wide uppercase">
                        <i class="fa-solid fa-cubes mr-2 text-blue-500"></i>Container Sizes
                    </h2>
                    <p class="text-[10px] text-gray-500">Manage container sizes for inspection</p>
                </div>
                <button onclick="openAddOffcanvas()" class="btn-primary flex items-center gap-2">
                    <i class="fa-solid fa-plus"></i> Add Size
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
                            <input type="text" id="customSearchInput" placeholder="Search sizes..." class="form-input text-xs" style="height:30px;padding:4px 10px;width:150px;">
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel-card overflow-hidden">
                <div class="table-container">
                    <div class="table-loading-overlay" id="tableLoadingOverlay">
                        <i class="fa-solid fa-spinner fa-spin text-blue-400"></i>
                        Loading container sizes...
                    </div>
                    <table id="myTable" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Sizes</th>
                                <th>Edit</th>
                                <th>Delete</th>
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
            <h5 id="offcanvasRightLabel" class="text-heading text-sm font-semibold offcanvas-title">
                <i class="fa-solid fa-cube mr-2 text-blue-500"></i>Container Size
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form method="post" id="insert_form" enctype="multipart/form-data">
                <div class="form-group mb-4">
                    <label class="form-label">Size</label>
                    <input type="number" class="form-input" id="name" name="name" required>
                </div>

                <input type="hidden" name="row_id" id="row_id" value="0">
                <input type="hidden" name="user_id" id="user_id" value="1">

                <div class="flex gap-3 mt-4">
                    <button type="submit" class="btn-primary flex-1" id="insert">
                        <i class="fa-regular fa-floppy-disk mr-1"></i> Save
                    </button>
                    <button type="button" class="btn-secondary" data-bs-dismiss="offcanvas">
                        <i class="fa-regular fa-xmark mr-1"></i> Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>

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
        }

        const API_BASE = 'api/';
        const API_KEY = '03201232927';

        let dataTable = null;

        const columnConfig = [
            { idx: 0, label: 'S.No' },
            { idx: 1, label: 'Sizes' },
            { idx: 2, label: 'Edit' },
            { idx: 3, label: 'Delete' }
        ];

        $(document).ready(function() {
            $('#sidebarToggle').on('click', function() {
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

            $('#add_btn').click(function() {
                openAddOffcanvas();
            });

            $('#insert_form').on('submit', function(event) {
                event.preventDefault();
                saveData();
            });

            $('#customSearchInput').on('keyup', function() {
                if ($.fn.DataTable.isDataTable('#myTable')) {
                    $('#myTable').DataTable().search(this.value).draw();
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
                        exportOptions: { columns: [0, 1] }
                    },
                    {
                        extend: 'excelHtml5',
                        text: '<i class="fa-regular fa-file-excel"></i> Excel',
                        className: 'dt-button',
                        exportOptions: { columns: [0, 1] },
                        title: 'Container_Sizes_Export'
                    },
                    {
                        extend: 'csvHtml5',
                        text: '<i class="fa-regular fa-file-csv"></i> CSV',
                        className: 'dt-button',
                        exportOptions: { columns: [0, 1] },
                        title: 'Container_Sizes_Export'
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<i class="fa-regular fa-file-pdf"></i> PDF',
                        className: 'dt-button',
                        exportOptions: { columns: [0, 1] },
                        title: 'Container Sizes',
                        orientation: 'landscape',
                        pageSize: 'A4'
                    },
                    {
                        extend: 'print',
                        text: '<i class="fa-solid fa-print"></i> Print',
                        className: 'dt-button',
                        exportOptions: { columns: [0, 1] }
                    }
                ],
                pageLength: 10,
                language: {
                    emptyTable: 'No container sizes found',
                    info: 'Showing _START_ to _END_ of _TOTAL_ entries',
                    infoEmpty: 'Showing 0 to 0 of 0 entries',
                    infoFiltered: '(filtered from _MAX_ total entries)'
                },
                initComplete: function() {
                    const buttonsContainer = $('#exportButtonsContainer');
                    $('.dt-buttons').appendTo(buttonsContainer);
                    populateColumnDropdown();
                    fetchTable();
                }
            });
        }

        function showTableLoading() {
            $('#tableLoadingOverlay').removeClass('hidden');
        }

        function hideTableLoading() {
            $('#tableLoadingOverlay').addClass('hidden');
        }

        function fetchTable() {
            var url = API_BASE + 'get/get_containers_sizes.php?key=' + API_KEY + '&id=1';

            showTableLoading();

            $.ajax({
                url: url,
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    console.log('Fetch Response:', response);

                    dataTable.clear().draw();

                    if (Array.isArray(response) && response.length > 0) {
                        $.each(response, function(index, data) {
                            dataTable.row.add([
                                index + 1,
                                parseFloat(data.sizes).toLocaleString(),
                                '<button type="button" onclick="editData(' + data.id +
                                ')" class="action-btn edit text-blue-500 hover:text-blue-600">' +
                                '<i class="fa-solid fa-pen-to-square"></i>' +
                                '</button>',
                                '<button type="button" onclick="deleteData(' + data.id +
                                ')" class="action-btn delete text-red-500 hover:text-red-600">' +
                                '<i class="fa-solid fa-trash-can"></i>' +
                                '</button>'
                            ]).draw(false);
                        });
                    } else {
                        dataTable.row.add([
                            'No data available',
                            '',
                            '',
                            ''
                        ]).draw(false);
                    }

                    hideTableLoading();
                },
                error: function(xhr, status, error) {
                    console.error('Fetch Error:', status, error);
                    dataTable.clear().draw();
                    dataTable.row.add([
                        'Error loading data',
                        '',
                        '',
                        ''
                    ]).draw(false);
                    hideTableLoading();
                    showToast('Failed to load data', 'error');
                }
            });
        }

        function saveData() {
            var update_id = $('#row_id').val();
            var formData = new FormData(document.getElementById('insert_form'));

            var url = '';
            var successMessage = '';

            if (update_id == '0') {
                url = API_BASE + 'create/create_containers_sizes.php';
                successMessage = 'Record Created Successfully';
            } else {
                url = API_BASE + 'update/container_size.php';
                successMessage = 'Record Updated Successfully';
            }

            var submitBtn = $('#insert');
            submitBtn.prop('disabled', true);
            submitBtn.html('<i class="fa-solid fa-spinner fa-spin mr-1"></i> Saving...');

            $.ajax({
                url: url,
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                data: formData,
                success: function(response) {
                    console.log('API Response:', response);
                    submitBtn.prop('disabled', false);
                    submitBtn.html('<i class="fa-regular fa-floppy-disk mr-1"></i> Save');

                    if (response == '1' || response == 1) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: successMessage,
                            timer: 2000,
                            showConfirmButton: true
                        });

                        document.getElementById('insert_form').reset();
                        var offcanvas = bootstrap.Offcanvas.getInstance(document.getElementById('offcanvasRight'));
                        if (offcanvas) offcanvas.hide();
                        fetchTable();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Server Error!',
                            text: 'Record Not Saved',
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                    submitBtn.prop('disabled', false);
                    submitBtn.html('<i class="fa-regular fa-floppy-disk mr-1"></i> Save');
                    Swal.fire({
                        icon: 'error',
                        title: 'Server Error!',
                        text: 'Request Failed: ' + error,
                    });
                }
            });
        }

        function editData(id) {
            var url = API_BASE + 'get/get_container_sizes.php?key=' + API_KEY + '&id=' + id;

            $.ajax({
                url: url,
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    console.log('Edit Response:', response);

                    if (Array.isArray(response) && response.length > 0) {
                        $('#row_id').val(response[0]['id']);
                        $('#name').val(response[0]['sizes']);
                        $('#offcanvasRightLabel').html('<i class="fa-solid fa-pen-to-square mr-2 text-blue-500"></i>Edit Container Size');
                        $('#insert').html('<i class="fa-regular fa-floppy-disk mr-1"></i> Update');

                        var offcanvas = new bootstrap.Offcanvas(document.getElementById('offcanvasRight'));
                        offcanvas.show();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Record not found',
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Edit Error:', status, error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Server Error!',
                        text: 'Failed to fetch record',
                    });
                }
            });
        }

        function openAddOffcanvas() {
            $('#row_id').val('0');
            $('#insert_form')[0].reset();
            $('#offcanvasRightLabel').html('<i class="fa-solid fa-plus-circle mr-2 text-blue-500"></i>Add Container Size');
            $('#insert').html('<i class="fa-regular fa-floppy-disk mr-1"></i> Save');
            document.getElementById('insert').disabled = false;

            var offcanvas = new bootstrap.Offcanvas(document.getElementById('offcanvasRight'));
            offcanvas.show();
        }

        function deleteData(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'You want to delete this record?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    var url = API_BASE + 'delete/delete_container_size.php?key=' + API_KEY + '&id=' + id;

                    $.ajax({
                        url: url,
                        method: 'GET',
                        success: function(response) {
                            console.log('Delete Response:', response);

                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: 'Record deleted successfully',
                                timer: 2000,
                                showConfirmButton: true
                            });

                            fetchTable();
                        },
                        error: function(xhr, status, error) {
                            console.error('Delete Error:', status, error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Server Error!',
                                text: 'Record Not Deleted: ' + error,
                            });
                        }
                    });
                }
            });
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
    </script>

</body>
</html>