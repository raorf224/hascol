<?php
// Hascol OMC Operations Command Center - TM Monthly Targets
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hascol OMC - TM Monthly Targets</title>
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

        html.no-transition * {
            transition: none !important;
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

        .table-container table tbody tr:hover {
            background-color: var(--table-row-hover);
        }

        /* ============================================ */
        /* COLUMN VISIBILITY DROPDOWN STYLES           */
        /* ============================================ */
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

        #targetModal {
            background: var(--modal-overlay);
            backdrop-filter: blur(8px);
        }

        #modalContentWrapper {
            background-color: var(--bg-panel) !important;
            border-color: var(--border-color) !important;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35);
        }

        html.dark-mode #modalContentWrapper {
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

        .dt-buttons .dt-button.dt-button-active {
            background-color: #1d4ed8 !important;
            color: #ffffff !important;
            border-color: #1d4ed8 !important;
        }

        .dataTables_filter {
            display: none !important;
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
                    <h2 class="text-heading font-semibold text-base tracking-wide uppercase">TM Monthly Targets</h2>
                    <p class="text-[10px] text-gray-500">Manage TM monthly targets and performance goals</p>
                </div>
                <button onclick="openCreateModal()"
                    class="bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 rounded text-xs font-medium transition flex items-center gap-2">
                    <i class="fa-solid fa-plus"></i> Set Targets
                </button>
            </div>

            <!-- Toolbar -->
            <div class="panel-card p-3 mb-4 flex flex-wrap items-center justify-between gap-2">
                <div class="flex items-center gap-2 flex-wrap" id="exportButtonsContainer">
                    <!-- DataTables Buttons will be placed here -->
                </div>
                <div class="flex items-center gap-2">
                    <!-- ============================================ -->
                    <!-- COLUMN VISIBILITY DROPDOWN                  -->
                    <!-- ============================================ -->
                    <div class="column-visibility-dropdown" id="columnVisibilityDropdown">
                        <button class="dropdown-btn" onclick="toggleColumnDropdown()">
                            <i class="fa-regular fa-eye"></i> Columns
                            <i class="fa-solid fa-chevron-down text-[8px]"></i>
                        </button>
                        <div class="dropdown-menu" id="columnDropdownMenu">
                            <div class="dropdown-header">
                                <i class="fa-regular fa-eye mr-1"></i> Column Visibility
                            </div>
                            <div id="columnListItems">
                                <!-- Column items will be populated by JavaScript -->
                            </div>
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
                        <input type="text" id="customSearchInput" placeholder="Search targets..." class="search-input">
                    </div>
                </div>
            </div>

            <!-- Targets Table -->
            <div class="panel-card overflow-hidden">
                <div class="table-container">
                    <table id="targetsTable" class="display" style="width:100%;">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>TM</th>
                                <th>Product</th>
                                <th>Month</th>
                                <th>Target (Ltr)</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody id="targetsTableBody">
                            <tr>
                                <td colspan="6" class="text-center py-8 text-gray-500">
                                    <i class="fa-solid fa-spinner fa-spin text-blue-400 mr-2"></i>
                                    Loading targets...
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>

    <!-- ============================================ -->
    <!-- TOAST NOTIFICATION                           -->
    <!-- ============================================ -->
    <div id="toast" class="toast">
        <i class="fa-solid fa-check-circle mr-2"></i>
        <span id="toastMessage">Data exported successfully!</span>
    </div>

    <!-- ============================================ -->
    <!-- TARGET MODAL (Create Only)                   -->
    <!-- ============================================ -->
    <div id="targetModal"
        class="fixed inset-0 z-50 hidden backdrop-blur-sm flex items-center justify-center transition-opacity duration-300 opacity-0">
        <div class="border rounded-lg shadow-2xl w-full max-w-md flex flex-col max-h-[90vh] transform scale-95 transition-transform duration-300"
            id="modalContentWrapper">
            <div class="flex justify-between items-center p-4 border-b" style="border-color: var(--border-color);">
                <h3 id="modalTitle" class="text-heading font-semibold tracking-wide text-sm">Set Targets</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-red-500 transition">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>
            <div class="p-4 overflow-y-auto flex-1">
                <form id="targetForm" onsubmit="saveTarget(event)">
                    <input type="hidden" id="targetId" value="">
                    <input type="hidden" id="userId" value="1">

                    <!-- TM -->
                    <div class="mb-3">
                        <label class="form-label">TM</label>
                        <select id="tm" class="form-select" required>
                            <option value="">Select TM</option>
                        </select>
                    </div>

                    <!-- Month -->
                    <div class="mb-3">
                        <label class="form-label">Month</label>
                        <input type="month" id="month" class="form-input" required>
                    </div>

                    <!-- Target (Ltr) -->
                    <div class="mb-3">
                        <label class="form-label">Target (Ltr)</label>
                        <input type="number" id="target" class="form-input" placeholder="Enter target in liters" required>
                    </div>

                    <!-- Product -->
                    <div class="mb-3">
                        <label class="form-label">Product</label>
                        <select id="product" class="form-select" required>
                            <option value="">Select Product</option>
                        </select>
                    </div>

                    <!-- Description -->
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea id="description" class="form-input" rows="2" placeholder="Enter description (optional)"></textarea>
                    </div>

                    <div class="flex gap-3 mt-4 pt-3 border-t" style="border-color: var(--border-color);">
                        <button type="submit" class="btn-primary flex-1">Save</button>
                        <button type="button" onclick="closeModal()" class="btn-secondary">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ============================================ -->
    <!-- JAVASCRIPT                                   -->
    <!-- ============================================ -->
    <script>
        // ============================================
        // API Configuration - LOCALHOST
        // ============================================
        const API_BASE_URL = 'api/';

        // ============================================
        // Data Store
        // ============================================
        let targetsData = [];
        let dataTable = null;

        // ============================================
        // Column Visibility Configuration
        // ============================================
        const columnConfig = [
            { idx: 0, label: 'S.No' },
            { idx: 1, label: 'TM' },
            { idx: 2, label: 'Product' },
            { idx: 3, label: 'Month' },
            { idx: 4, label: 'Target (Ltr)' },
            { idx: 5, label: 'Description' }
        ];

        $(document).ready(function() {
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
                if ($.fn.DataTable.isDataTable('#targetsTable')) {
                    $('#targetsTable').DataTable().search(searchTerm).draw();
                }
            });

            // Load dropdowns
            loadTMList();
            loadProductsList();

            // Load targets
            loadTargets();

            // Close dropdown on outside click
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.column-visibility-dropdown').length) {
                    closeColumnDropdown();
                }
            });
        });

        // ============================================
        // Load TM List - FIXED with pre and user_id
        // ============================================
        function loadTMList() {
            const url = API_BASE_URL + 'get/get_asm.php?key=03201232927&pre=Admin&user_id=1';
            
            $.ajax({
                url: url,
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
                        console.log('TM List loaded successfully:', data.length);
                    } else {
                        loadTMListFallback();
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Failed to load TM list:', status, error);
                    loadTMListFallback();
                }
            });
        }

        // ============================================
        // Fallback: Load TM List from get_tm.php
        // ============================================
        function loadTMListFallback() {
            $.ajax({
                url: API_BASE_URL + 'get/get_tm.php?key=03201232927',
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
                        console.log('TM List loaded from fallback API');
                    } else {
                        showToast('No TM found. Please add TMs first.', 'error');
                    }
                },
                error: function() {
                    console.error('Fallback API also failed');
                    showToast('Failed to load TM list. Please refresh.', 'error');
                }
            });
        }

        // ============================================
        // Load Products List
        // ============================================
        function loadProductsList() {
            $.ajax({
                url: API_BASE_URL + 'get/get_all_products.php?key=03201232927',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    var select = $('#product');
                    select.empty().append('<option value="">Select Product</option>');
                    if (data && data.length > 0) {
                        $.each(data, function(index, item) {
                            select.append($('<option>', {
                                value: item.name,
                                text: item.name
                            }));
                        });
                    } else {
                        select.append('<option value="PMG">PMG</option>');
                        select.append('<option value="HSD">HSD</option>');
                        select.append('<option value="HASRON">HASRON</option>');
                        select.append('<option value="LUBES">LUBES</option>');
                    }
                },
                error: function() {
                    console.error('Failed to load products list');
                    var select = $('#product');
                    select.empty().append('<option value="">Select Product</option>');
                    select.append('<option value="PMG">PMG</option>');
                    select.append('<option value="HSD">HSD</option>');
                    select.append('<option value="HASRON">HASRON</option>');
                    select.append('<option value="LUBES">LUBES</option>');
                    showToast('Failed to load products list', 'error');
                }
            });
        }

        // ============================================
        // Load Targets
        // ============================================
        function loadTargets() {
            $('#targetsTableBody').html(`
                <tr>
                    <td colspan="6" class="text-center py-8 text-gray-500">
                        <i class="fa-solid fa-spinner fa-spin text-blue-400 mr-2"></i>
                        Loading targets...
                    </td>
                </tr>
            `);

            $.ajax({
                url: API_BASE_URL + 'get/get_tm_monthly_target.php?key=03201232927&id=1',
                type: 'GET',
                dataType: 'json',
                timeout: 30000,
                success: function(response) {
                    console.log('API Response:', response);
                    
                    if (response && Array.isArray(response) && response.length > 0) {
                        targetsData = response.map(function(item, index) {
                            return {
                                id: parseInt(item.id) || index + 1,
                                tm: item.name || 'N/A',
                                product: item.product_id || 'N/A',
                                month: item.date_month || '',
                                target: parseFloat(item.target_amount) || 0,
                                description: item.description || '-'
                            };
                        });
                        
                        console.log('Mapped Data:', targetsData);
                        initializeDataTable();
                        showToast('Targets loaded successfully!', 'success');
                    } else {
                        showToast('No targets found.', 'error');
                        targetsData = [];
                        initializeDataTable();
                    }
                },
                error: function(xhr, status, error) {
                    console.error('API Error:', status, error);
                    showToast('Failed to load targets. Please refresh.', 'error');
                    targetsData = [];
                    initializeDataTable();
                }
            });
        }

        // ============================================
        // Format Month for Display
        // ============================================
        function formatMonth(monthStr) {
            if (!monthStr) return '';
            const parts = monthStr.split('-');
            if (parts.length !== 2) return monthStr;
            const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            return months[parseInt(parts[1]) - 1] + ' ' + parts[0];
        }

        // ============================================
        // Format Target - Show RAW integer value
        // ============================================
        function formatTarget(value) {
            return value.toLocaleString();
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

        // ============================================
        // Dropdown Toggle Functions
        // ============================================
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
            if ($.fn.DataTable.isDataTable('#targetsTable')) {
                $('#targetsTable').DataTable().destroy();
                $('#targetsTable tbody').empty();
            }

            const tableData = targetsData.map((target, index) => {
                return [
                    index + 1,
                    target.tm,
                    target.product,
                    formatMonth(target.month),
                    formatTarget(target.target),
                    target.description || '-'
                ];
            });

            dataTable = $('#targetsTable').DataTable({
                data: tableData,
                columns: [
                    { title: 'S.No' },
                    { title: 'TM' },
                    { title: 'Product' },
                    { title: 'Month' },
                    { title: 'Target (Ltr)' },
                    { title: 'Description' }
                ],
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'copy',
                        text: '<i class="fa-regular fa-copy"></i> Copy',
                        className: 'toolbar-btn',
                        exportOptions: { columns: [0, 1, 2, 3, 4, 5] }
                    },
                    {
                        extend: 'excelHtml5',
                        text: '<i class="fa-regular fa-file-excel"></i> Excel',
                        className: 'toolbar-btn',
                        exportOptions: { columns: [0, 1, 2, 3, 4, 5] },
                        title: 'TM_Monthly_Targets'
                    },
                    {
                        extend: 'csvHtml5',
                        text: '<i class="fa-regular fa-file-csv"></i> CSV',
                        className: 'toolbar-btn',
                        exportOptions: { columns: [0, 1, 2, 3, 4, 5] },
                        title: 'TM_Monthly_Targets'
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<i class="fa-regular fa-file-pdf"></i> PDF',
                        className: 'toolbar-btn',
                        exportOptions: { columns: [0, 1, 2, 3, 4, 5] },
                        title: 'TM Monthly Targets Report',
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
                        exportOptions: { columns: [0, 1, 2, 3, 4, 5] }
                    }
                ],
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100],
                ordering: true,
                order: [[0, 'asc']],
                language: {
                    emptyTable: '<div class="text-center py-8 text-gray-500"><i class="fa-solid fa-chart-simple text-2xl block mb-2"></i>No targets found</div>',
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

        // ============================================
        // Modal Functions
        // ============================================
        function openCreateModal() {
            $('#modalTitle').text('Set Targets');
            $('#targetId').val('');
            $('#tm').val('');
            $('#month').val('');
            $('#target').val('');
            $('#product').val('');
            $('#description').val('');
            openModal();
        }

        function openModal() {
            const modal = $('#targetModal');
            modal.removeClass('hidden').addClass('flex');
            setTimeout(function() {
                modal.removeClass('opacity-0');
                $('#modalContentWrapper').removeClass('scale-95').addClass('scale-100');
            }, 10);
        }

        function closeModal() {
            const modal = $('#targetModal');
            modal.addClass('opacity-0');
            $('#modalContentWrapper').removeClass('scale-100').addClass('scale-95');
            setTimeout(function() {
                modal.addClass('hidden').removeClass('flex');
            }, 300);
        }

        // ============================================
        // Save Target
        // ============================================
        function saveTarget(event) {
            event.preventDefault();

            const tm = $('#tm').val();
            const month = $('#month').val();
            const target = parseFloat($('#target').val());
            const product = $('#product').val();
            const description = $('#description').val().trim();
            const userId = $('#userId').val();

            if (!tm || !month || !target || !product) {
                showToast('Please fill in all required fields.', 'error');
                return;
            }

            const submitBtn = $('#targetForm button[type="submit"]');
            submitBtn.prop('disabled', true);
            submitBtn.html('<i class="fa-solid fa-spinner fa-spin mr-1"></i> Saving...');

            const formData = new FormData();
            formData.append('asm', tm);
            formData.append('month_name', month);
            formData.append('targeted_amount', target);
            formData.append('targeted_product', product);
            formData.append('products_description', description || 'target');
            formData.append('user_id', userId);

            $.ajax({
                url: API_BASE_URL + 'create/create_monthly_target_for_tm.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(response) {
                    submitBtn.prop('disabled', false);
                    submitBtn.html('Save');
                    
                    if (response === 1) {
                        showToast('Target created successfully!', 'success');
                        closeModal();
                        loadTargets();
                    } else {
                        showToast('Failed to create target. Please try again.', 'error');
                    }
                },
                error: function(xhr, status, error) {
                    submitBtn.prop('disabled', false);
                    submitBtn.html('Save');
                    console.error('Create Error:', status, error);
                    showToast('Error creating target. Please try again.', 'error');
                }
            });
        }

        // Close modal on outside click
        $(document).on('click', '#targetModal', function(e) {
            if (e.target === this) closeModal();
        });
    </script>

</body>

</html>