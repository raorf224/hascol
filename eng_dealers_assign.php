<?php
// Hascol OMC - Users Dealers (Eng) - Standalone
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Users Dealers | Hascol OMC</title>
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

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

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
            border-radius: 0.5rem;
            transition: background-color .25s ease, border-color .25s ease;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
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

        .btn-primary {
            background: linear-gradient(135deg, #1d4ed8, #2563eb);
            color: #ffffff;
            padding: 8px 20px;
            border-radius: 0.375rem;
            border: none;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 2px 8px rgba(29, 78, 216, 0.25);
        }
        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 16px rgba(29, 78, 216, 0.35);
        }

        .btn-danger {
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            color: #ffffff;
            padding: 8px 20px;
            border-radius: 0.375rem;
            border: none;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 2px 8px rgba(220, 38, 38, 0.25);
        }
        .btn-danger:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 16px rgba(220, 38, 38, 0.35);
        }

        .btn-secondary {
            background-color: var(--btn-secondary-bg);
            color: var(--btn-secondary-text);
            padding: 8px 20px;
            border-radius: 0.375rem;
            border: 1px solid var(--border-color);
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .btn-secondary:hover {
            background-color: var(--btn-secondary-hover-bg);
            color: var(--btn-secondary-hover-text);
        }

        .btn-success {
            background: linear-gradient(135deg, #10b981, #059669);
            color: #ffffff;
            padding: 8px 20px;
            border-radius: 0.375rem;
            border: none;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            justify-content: center;
        }
        .btn-success:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 16px rgba(16, 185, 129, 0.35);
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
            width: 500px;
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

        .select2-container {
            width: 100% !important;
        }
        .select2-container--default .select2-selection--multiple {
            background-color: var(--input-bg) !important;
            border: 1px solid var(--border-color) !important;
            border-radius: 0.25rem !important;
            padding: 4px 8px !important;
            min-height: 42px !important;
            width: 100% !important;
            display: block !important;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__rendered {
            display: flex !important;
            flex-wrap: wrap !important;
            gap: 4px !important;
            padding: 0 !important;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #1d4ed8 !important;
            color: #ffffff !important;
            border: none !important;
            border-radius: 0.25rem !important;
            padding: 2px 10px !important;
            font-size: 12px !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 4px !important;
            margin: 2px !important;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: #ffffff !important;
            margin-right: 4px !important;
            font-weight: 700 !important;
            cursor: pointer !important;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
            color: #ff6b6b !important;
            background: transparent !important;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__placeholder {
            color: var(--text-muted) !important;
            font-size: 13px !important;
        }
        .select2-container--default .select2-search--inline .select2-search__field {
            color: var(--text-body) !important;
            font-size: 13px !important;
            padding: 4px 0 !important;
            margin: 0 !important;
            min-height: 30px !important;
            background: transparent !important;
            border: none !important;
            outline: none !important;
        }
        .select2-dropdown {
            background-color: var(--bg-panel) !important;
            border: 1px solid var(--border-color) !important;
            border-radius: 0.25rem !important;
            z-index: 999999 !important;
        }
        .select2-container--default .select2-results__option {
            color: var(--text-body) !important;
            padding: 8px 12px !important;
            font-size: 13px !important;
        }
        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #1d4ed8 !important;
            color: #ffffff !important;
        }
        .select2-container--default .select2-results__option[aria-selected=true] {
            background-color: rgba(29, 78, 216, 0.15) !important;
        }
        .select2-container--default .select2-results__option[aria-selected=true]:hover {
            background-color: #1d4ed8 !important;
            color: #ffffff !important;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__clear {
            display: none !important;
        }

        .custom-checkbox {
            width: 16px;
            height: 16px;
            cursor: pointer;
            accent-color: #1d4ed8;
        }

        @media (max-width: 1024px) {
            .toolbar-row {
                flex-direction: column;
                align-items: stretch;
            }
            .toolbar-left, .toolbar-right {
                width: 100%;
            }
            .toolbar-right {
                justify-content: flex-start;
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

        .text-muted-small {
            font-size: 10px;
            color: var(--text-muted);
            font-weight: 400;
        }

        hr {
            border-color: var(--border-color);
        }
    </style>
</head>

<body class="flex h-screen overflow-hidden text-sm">

    <?php include 'includes/sidebar.php'; ?>

    <main id="mainContent" class="flex-1 flex flex-col overflow-hidden">

        <?php include 'includes/topbar.php'; ?>

        <div class="flex-1 overflow-y-auto p-4 md:p-6" id="pageContent">

            <div class="flex flex-wrap justify-between items-center mb-4 gap-3">
                <div>
                    <h2 class="text-heading font-semibold text-lg tracking-wide uppercase">
                        <i class="fa-solid fa-user-tie mr-2 text-blue-500"></i>Users Dealers (Eng)
                    </h2>
                    <p class="text-xs text-gray-500 mt-0.5">Assign dealers to engineering users</p>
                </div>
                <button onclick="openAddOffcanvas()" class="btn-primary">
                    <i class="fa-solid fa-plus"></i> Add
                </button>
            </div>

            <div class="panel-card p-3 mb-4">
                <div class="toolbar-row">
                    <div class="toolbar-left" id="exportButtonsContainer"></div>
                    <div class="toolbar-right">
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-magnifying-glass text-gray-500 text-sm"></i>
                            <input type="text" id="customSearchInput" placeholder="Search..." class="form-input text-sm" style="height:32px;padding:4px 12px;width:180px;">
                        </div>
                        <button onclick="deleteSelected()" class="btn-danger" style="padding:6px 16px;font-size:12px;">
                            <i class="fa-solid fa-trash-can"></i> Delete Selected
                        </button>
                    </div>
                </div>
            </div>

            <div class="panel-card overflow-hidden">
                <div class="table-container">
                    <div class="table-loading-overlay hidden" id="tableLoadingOverlay">
                        <i class="fa-solid fa-spinner fa-spin text-blue-400"></i>
                        Loading users dealers...
                    </div>
                    <table id="myTable" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th style="width:40px;">
                                    <input type="checkbox" id="selectAll" class="custom-checkbox">
                                </th>
                                <th>User</th>
                                <th>Dealer</th>
                                <th style="width:80px;">Delete</th>
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
                <i class="fa-solid fa-plus-circle mr-2 text-blue-500"></i>Assign Dealers to User
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">

            <div class="form-group">
                <label class="form-label">Region <span class="text-muted-small">(Select all dealers under specific region)</span></label>
                <select class="form-select" id="regions" name="regions" onchange="get_regions_dealers(this.value)">
                    <option value="">Select Region</option>
                </select>
            </div>

            <hr>

            <form method="post" id="insert_form" enctype="multipart/form-data">

                <div class="form-group">
                    <label class="form-label">Users <span class="text-red-500">*</span></label>
                    <select class="form-select" id="users" name="users" required>
                        <option value="">Select User</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Dealers <span class="text-red-500">*</span></label>
                    <select class="multiple_select" id="dealers" name="dealers[]" multiple="multiple" style="width:100%;">
                    </select>
                </div>

                <input type="hidden" name="row_id" id="row_id" value="0">
                <input type="hidden" name="user_id" id="user_id" value="1">

                <div class="flex gap-3 mt-6 pt-4 border-t" style="border-color: var(--border-color);">
                    <button type="submit" class="btn-success flex-1" id="insert">
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

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
        const USER_ID = '1';
        const PRIVILEGE = 'Admin';

        let dataTable = null;
        let isDataLoaded = false;

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

            $('.multiple_select').select2({
                dropdownParent: $('#offcanvasRight'),
                placeholder: 'Select Dealers',
                allowClear: true,
                width: '100%'
            });

            initializeDataTable();
            all_dealers();
            load_all_select();

            $('#insert_form').on('submit', function (event) {
                event.preventDefault();
                saveAssignment();
            });

            $('#customSearchInput').on('keyup', function () {
                if ($.fn.DataTable.isDataTable('#myTable')) {
                    $('#myTable').DataTable().search(this.value).draw();
                }
            });

            $('#selectAll').on('change', function () {
                $('.row-checkbox').prop('checked', this.checked);
            });

            $(document).on('change', '.row-checkbox', function () {
                var total = $('.row-checkbox').length;
                var checked = $('.row-checkbox:checked').length;
                $('#selectAll').prop('checked', total === checked && total > 0);
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
                        className: 'dt-button'
                    },
                    {
                        extend: 'excelHtml5',
                        text: '<i class="fa-regular fa-file-excel"></i> Excel',
                        className: 'dt-button',
                        title: 'Eng_Dealers_Assign_Export'
                    },
                    {
                        extend: 'csvHtml5',
                        text: '<i class="fa-regular fa-file-csv"></i> CSV',
                        className: 'dt-button',
                        title: 'Eng_Dealers_Assign_Export'
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<i class="fa-regular fa-file-pdf"></i> PDF',
                        className: 'dt-button',
                        title: 'Eng Dealers Assign',
                        orientation: 'landscape',
                        pageSize: 'A4'
                    },
                    {
                        extend: 'print',
                        text: '<i class="fa-solid fa-print"></i> Print',
                        className: 'dt-button'
                    }
                ],
                pageLength: 10,
                order: [[1, 'asc']],
                columnDefs: [
                    { orderable: false, targets: [0, 3] }
                ],
                language: {
                    emptyTable: 'No assignments found',
                    info: 'Showing _START_ to _END_ of _TOTAL_ entries',
                    infoEmpty: 'Showing 0 to 0 of 0 entries',
                    infoFiltered: '(filtered from _MAX_ total entries)'
                },
                initComplete: function () {
                    const buttonsContainer = $('#exportButtonsContainer');
                    $('.dt-buttons').appendTo(buttonsContainer);
                    if (!isDataLoaded) {
                        fetchTable();
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

        function fetchTable() {
            var url = API_BASE + 'get/eng_dealers_users.php?key=' + API_KEY + '&user_id=' + USER_ID + '&pre=' + PRIVILEGE;

            console.log('Fetching URL:', url);

            showTableLoading();

            fetch(url, {
                method: 'GET',
                redirect: 'follow'
            })
                .then(response => response.json())
                .then(response => {
                    console.log('Fetch Response:', response);

                    dataTable.clear().draw();

                    if (Array.isArray(response) && response.length > 0) {
                        $.each(response, function (index, data) {
                            dataTable.row.add([
                                '<input type="checkbox" class="row-checkbox custom-checkbox" value="' + data.row_id + '">',
                                data.username || 'N/A',
                                data.dealer_name || 'N/A',
                                '<button type="button" onclick="deleteAssign(' + data.row_id +
                                    ')" class="text-red-500 hover:text-red-600" title="Delete">' +
                                    '<i class="fa-solid fa-trash-can"></i></button>'
                            ]).draw(false);
                        });
                    }

                    hideTableLoading();
                })
                .catch(error => {
                    console.error('Fetch Error:', error);
                    dataTable.clear().draw();
                    hideTableLoading();
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to load data. Please refresh.',
                        timer: 3000,
                        showConfirmButton: true
                    });
                });
        }

        function all_dealers() {
            fetch(API_BASE + 'get/dealers.php?key=' + API_KEY + '&pre=' + PRIVILEGE + '&user_id=' + USER_ID)
                .then(response => response.json())
                .then(response => {
                    console.log('Dealers:', response);
                    $('#dealers').empty();
                    if (Array.isArray(response)) {
                        response.forEach(data => {
                            $('#dealers').append(new Option(data.name, data.id)).trigger('change');
                        });
                    }
                })
                .catch(error => console.log('Error fetching dealers:', error));

            fetch(API_BASE + 'get/get_eng_users.php?key=' + API_KEY + '&pre=' + PRIVILEGE + '&user_id=' + USER_ID)
                .then(response => response.json())
                .then(response => {
                    console.log('Eng Users:', response);
                    $('#users').empty();
                    $('#users').append(new Option('Select User', '')).trigger('change');
                    if (Array.isArray(response)) {
                        response.forEach(data => {
                            $('#users').append(new Option(data.name, data.id)).trigger('change');
                        });
                    }
                })
                .catch(error => console.log('Error fetching users:', error));
        }

        function saveAssignment() {
            var formData = new FormData(document.getElementById('insert_form'));

            var submitBtn = $('#insert');
            submitBtn.prop('disabled', true);
            submitBtn.html('<i class="fa-solid fa-spinner fa-spin"></i> Saving...');

            var url = API_BASE + 'create/assign_user_dealers.php';

            $.ajax({
                url: url,
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                data: formData,
                success: function (response) {
                    console.log('Save Response:', response);
                    submitBtn.prop('disabled', false);
                    submitBtn.html('<i class="fa-regular fa-floppy-disk"></i> Save');

                    if (response == '1' || response == 1) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Record Created Successfully',
                            timer: 2000,
                            showConfirmButton: true
                        });

                        document.getElementById('insert_form').reset();
                        $('.multiple_select').val(null).trigger('change');
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
                    submitBtn.prop('disabled', false);
                    submitBtn.html('<i class="fa-regular fa-floppy-disk"></i> Save');
                    Swal.fire({
                        icon: 'error',
                        title: 'Server Error!',
                        text: 'Request Failed: ' + error,
                    });
                }
            });
        }

        function deleteAssign(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    var url = API_BASE + 'delete/delete_eng_dealer.php?key=' + API_KEY + '&id=' + id;

                    $.ajax({
                        url: url,
                        method: 'GET',
                        success: function (response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: 'Record Deleted Successfully',
                                timer: 2000,
                                showConfirmButton: true
                            });
                            setTimeout(function () {
                                fetchTable();
                            }, 1500);
                        },
                        error: function (xhr, textStatus, errorThrown) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Server Error!',
                                text: 'Record Not Deleted',
                            });
                        }
                    });
                }
            });
        }

        function deleteSelected() {
            let selectedIds = [];
            $('.row-checkbox:checked').each(function () {
                selectedIds.push($(this).val());
            });

            if (selectedIds.length === 0) {
                Swal.fire({
                    icon: 'info',
                    title: 'No Selection',
                    text: 'Please select at least one row to delete.',
                    timer: 2000,
                    showConfirmButton: false
                });
                return;
            }

            Swal.fire({
                title: 'Are you sure?',
                text: 'You want to delete ' + selectedIds.length + ' selected assignment(s)?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Yes, delete them!'
            }).then((result) => {
                if (result.isConfirmed) {
                    const idsParam = selectedIds.join(',');
                    var url = API_BASE + 'delete/delete_eng_dealer.php?key=' + API_KEY + '&ids=' + idsParam;

                    fetch(url)
                        .then(response => response.text())
                        .then(result => {
                            console.log('Delete Response:', result);
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: 'Selected records deleted successfully',
                                timer: 2000,
                                showConfirmButton: true
                            });
                            $('#selectAll').prop('checked', false);
                            fetchTable();
                        })
                        .catch(error => {
                            console.log('error', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Server Error!',
                                text: 'Records Not Deleted',
                            });
                        });
                }
            });
        }

        function load_all_select() {
            $.ajax({
                url: API_BASE + 'get/get_dealers_region.php?key=' + API_KEY,
                method: 'GET',
                dataType: 'json',
                success: function (data) {
                    console.log('Regions:', data);
                    $('#regions').empty();
                    $('#regions').append($('<option>', {
                        value: '',
                        text: 'Select Region'
                    }));
                    if (Array.isArray(data)) {
                        $.each(data, function (index, item) {
                            $('#regions').append($('<option>', {
                                value: item.region,
                                text: item.region
                            }));
                        });
                    }
                },
                error: function (error) {
                    console.error('Error fetching regions:', error);
                }
            });
        }

        function get_regions_dealers(id) {
            if (id != "") {
                $.ajax({
                    url: API_BASE + 'get/dealers_region.php?key=' + API_KEY + '&region=' + id,
                    method: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        console.log('Region Dealers:', data);
                        var region = [];
                        if (Array.isArray(data)) {
                            $.each(data, function (index, item) {
                                region.push(parseInt(item.id));
                            });
                        }
                        $('#dealers').val(region).trigger('change');
                    },
                    error: function (error) {
                        console.error('Error fetching region dealers:', error);
                    }
                });
            }
        }

        function openAddOffcanvas() {
            $('#row_id').val('0');
            $('#insert_form')[0].reset();
            $('.multiple_select').val(null).trigger('change');
            $('#offcanvasRightLabel').html('<i class="fa-solid fa-plus-circle mr-2 text-blue-500"></i>Assign Dealers to User');
            $('#insert').html('<i class="fa-regular fa-floppy-disk"></i> Save');
            document.getElementById('insert').disabled = false;

            var offcanvas = new bootstrap.Offcanvas(document.getElementById('offcanvasRight'));
            offcanvas.show();
        }
    </script>

</body>
</html>