<?php
// Hascol OMC - Survey Category Management (Standalone)
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Survey Category | Hascol OMC</title>
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
            --toggle-bg: #ccc;
            --toggle-checked-bg: #2196F3;
            --toggle-slider-bg: #fff;
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
            --toggle-bg: #1a2635;
            --toggle-checked-bg: #2196F3;
            --toggle-slider-bg: #0d1520;
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

        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 28px;
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
            background-color: var(--toggle-bg);
            transition: .4s;
            border-radius: 34px;
        }
        .toggle-slider:before {
            position: absolute;
            content: "";
            height: 20px;
            width: 20px;
            left: 4px;
            bottom: 4px;
            background-color: var(--toggle-slider-bg);
            transition: .4s;
            border-radius: 50%;
        }
        .toggle-switch input:checked + .toggle-slider {
            background-color: var(--toggle-checked-bg);
        }
        .toggle-switch input:focus + .toggle-slider {
            box-shadow: 0 0 1px var(--toggle-checked-bg);
        }
        .toggle-switch input:checked + .toggle-slider:before {
            transform: translateX(22px);
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

        .hidden {
            display: none !important;
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
                        <i class="fa-solid fa-list-check mr-2 text-blue-500"></i>Survey Category
                    </h2>
                    <p class="text-[10px] text-gray-500">Manage survey categories for inspection</p>
                </div>
                <button onclick="openAddOffcanvas()" class="btn-primary flex items-center gap-2">
                    <i class="fa-solid fa-plus"></i> Add Category
                </button>
            </div>

            <div class="panel-card p-3 mb-4">
                <div class="toolbar-row">
                    <div class="toolbar-left" id="exportButtonsContainer"></div>
                    <div class="toolbar-right">
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-magnifying-glass text-gray-500 text-xs"></i>
                            <input type="text" id="customSearchInput" placeholder="Search categories..." class="form-input text-xs" style="height:30px;padding:4px 10px;width:150px;">
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel-card overflow-hidden">
                <div class="table-container">
                    <div class="table-loading-overlay" id="tableLoadingOverlay">
                        <i class="fa-solid fa-spinner fa-spin text-blue-400"></i>
                        Loading survey categories...
                    </div>
                    <table id="myTable" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Category</th>
                                <th>Active/Inactive</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>

    <div id="toast" class="toast">
        <i class="fa-solid fa-check-circle mr-2"></i>
        <span id="toastMessage">Data loaded successfully!</span>
    </div>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header border-bottom">
            <h5 id="offcanvasRightLabel" class="text-heading text-sm font-semibold offcanvas-title">
                <i class="fa-solid fa-plus-circle mr-2 text-blue-500"></i>Survey Category
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form method="post" id="insert_form" enctype="multipart/form-data">
                <div class="form-group mb-4">
                    <label class="form-label">Category</label>
                    <input type="text" class="form-input" id="name" name="name" placeholder="Enter Category" required>
                </div>

                <input type="hidden" name="row_id" id="row_id" value="">
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
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

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

            $('#insert_form').on('submit', function(event) {
                event.preventDefault();
                saveData();
            });

            $('#customSearchInput').on('keyup', function() {
                if ($.fn.DataTable.isDataTable('#myTable')) {
                    $('#myTable').DataTable().search(this.value).draw();
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
                        className: 'dt-button'
                    },
                    {
                        extend: 'excelHtml5',
                        text: '<i class="fa-regular fa-file-excel"></i> Excel',
                        className: 'dt-button',
                        title: 'Survey_Category_Export'
                    },
                    {
                        extend: 'csvHtml5',
                        text: '<i class="fa-regular fa-file-csv"></i> CSV',
                        className: 'dt-button',
                        title: 'Survey_Category_Export'
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<i class="fa-regular fa-file-pdf"></i> PDF',
                        className: 'dt-button',
                        title: 'Survey Category',
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
                language: {
                    emptyTable: 'No survey categories found',
                    info: 'Showing _START_ to _END_ of _TOTAL_ entries',
                    infoEmpty: 'Showing 0 to 0 of 0 entries',
                    infoFiltered: '(filtered from _MAX_ total entries)'
                },
                initComplete: function() {
                    const buttonsContainer = $('#exportButtonsContainer');
                    $('.dt-buttons').appendTo(buttonsContainer);
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
            var url = API_BASE + 'get/get_survey_category.php?key=' + API_KEY + '&id=1';

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
                            var statusChecked = (data.status == 1) ? 'checked' : '';
                            var statusText = (data.status == 1) ? 'Active' : 'Inactive';
                            
                            dataTable.row.add([
                                index + 1,
                                data.name,
                                '<label class="toggle-switch">' +
                                    '<input type="checkbox" id="toggle_' + data.id + 
                                    '" onclick="updateStatus(' + data.id + ')" ' + 
                                    statusChecked + '>' +
                                    '<span class="toggle-slider"></span>' +
                                '</label>' +
                                ' <span class="text-xs text-muted ml-1">' + statusText + '</span>'
                            ]).draw(false);
                        });
                    } else {
                        dataTable.row.add([
                            'No data available',
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
                        ''
                    ]).draw(false);
                    hideTableLoading();
                    showToast('Failed to load data', 'error');
                }
            });
        }

        function saveData() {
            var formData = new FormData(document.getElementById('insert_form'));

            var submitBtn = $('#insert');
            submitBtn.prop('disabled', true);
            submitBtn.html('<i class="fa-solid fa-spinner fa-spin mr-1"></i> Saving...');

            var url = API_BASE + 'create/create_survey_category.php';

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
                            text: 'Record Created Successfully',
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
                            text: 'Record Not Created: ' + response,
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

        function updateStatus(id) {
            var checkbox = $('#toggle_' + id);
            var checkboxValue = checkbox.is(':checked') ? 1 : 0;

            var url = API_BASE + 'update/survey_cat_update.php';

            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    checkboxValue: checkboxValue,
                    id: id
                },
                success: function(response) {
                    console.log('Status updated successfully:', response);
                    var statusText = checkboxValue == 1 ? 'Active' : 'Inactive';
                    showToast('Status updated to: ' + statusText, 'success');
                    
                    var parent = checkbox.closest('td');
                    var statusSpan = parent.find('span.text-muted');
                    if (statusSpan.length) {
                        statusSpan.text(statusText);
                    }
                },
                error: function(error) {
                    console.error('Error updating status:', error);
                    checkbox.prop('checked', !checkbox.is(':checked'));
                    showToast('Failed to update status', 'error');
                }
            });
        }

        function openAddOffcanvas() {
            $('#row_id').val('');
            $('#insert_form')[0].reset();
            $('#offcanvasRightLabel').html('<i class="fa-solid fa-plus-circle mr-2 text-blue-500"></i>Add Survey Category');
            $('#insert').html('<i class="fa-regular fa-floppy-disk mr-1"></i> Save');
            document.getElementById('insert').disabled = false;

            var offcanvas = new bootstrap.Offcanvas(document.getElementById('offcanvasRight'));
            offcanvas.show();
        }

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
    </script>

</body>
</html>