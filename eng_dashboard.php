<?php
// Hascol OMC - Engineering Dashboard
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eng Dashboard | Hascol OMC</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Dark Mode Init -->
    <script>
        (function() {
            const isDarkMode = localStorage.getItem('darkMode') === 'true';
            document.documentElement.classList.toggle('dark-mode', isDarkMode);
        })();
    </script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] }
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
        }

        body {
            background-color: var(--bg-body);
            color: var(--text-muted);
            font-family: 'Inter', sans-serif;
            transition: background-color .25s ease, color .25s ease;
        }

        .text-heading { color: var(--text-heading) !important; }

        .panel-card {
            background-color: var(--bg-panel);
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            transition: background-color .25s ease, border-color .25s ease;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }

        #sidebar.collapsed { width: 60px; }
        #sidebar.collapsed .sidebar-text { display: none; }
        #sidebar, #mainContent { transition: all 0.3s ease-in-out; }

        /* ============================================ */
        /* FORM INPUTS & NATIVE SELECTS                  */
        /* ============================================ */
        .form-input, .form-select {
            background-color: var(--input-bg);
            border: 1px solid var(--border-color);
            border-radius: 0.25rem;
            color: var(--text-body);
            padding: 6px 10px;
            width: 100%;
            font-size: 12px;
            transition: border-color 0.2s, box-shadow 0.2s;
            outline: none;
        }

        .form-input:focus, .form-select:focus {
            border-color: #1d4ed8;
            box-shadow: 0 0 0 2px rgba(29, 78, 216, 0.2);
        }

        /* ============================================ */
        /* SELECT2 FOCUS BORDER                          */
        /* ============================================ */
        .select2-container--default .select2-selection--multiple,
        .select2-container--default .select2-selection--single {
            background-color: var(--input-bg) !important;
            border: 1px solid var(--border-color) !important;
            border-radius: 0.25rem !important;
            min-height: 34px !important;
            padding: 2px 6px !important;
            transition: border-color 0.2s, box-shadow 0.2s !important;
        }

        .select2-container--default.select2-container--focus .select2-selection--multiple,
        .select2-container--default.select2-container--focus .select2-selection--single {
            border-color: #1d4ed8 !important;
            box-shadow: 0 0 0 2px rgba(29, 78, 216, 0.2) !important;
            outline: none !important;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #1d4ed8 !important;
            color: #ffffff !important;
            border: none !important;
            border-radius: 0.25rem !important;
            padding: 2px 8px !important;
            font-size: 11px !important;
            margin-top: 3px !important;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: #ffffff !important;
            margin-right: 4px !important;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
            color: #ff6b6b !important;
        }

        .select2-dropdown {
            background-color: var(--bg-panel) !important;
            border: 1px solid var(--border-color) !important;
        }

        .select2-container--default .select2-results__option {
            color: var(--text-body) !important;
            font-size: 12px !important;
        }

        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #1d4ed8 !important;
            color: #ffffff !important;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__placeholder,
        .select2-container--default .select2-selection--single .select2-selection__placeholder {
            color: var(--text-muted) !important;
            font-size: 12px !important;
        }

        .select2-container--default .select2-search--inline .select2-search__field {
            color: var(--text-body) !important;
            font-size: 12px !important;
        }

        /* ============================================ */
        /* DATATABLES SEARCH INPUT FOCUS BORDER          */
        /* ============================================ */
        .dataTables_wrapper .dataTables_filter {
            color: var(--text-muted) !important;
            font-size: 11px !important;
        }

        .dataTables_wrapper .dataTables_filter label {
            color: var(--text-muted) !important;
            font-size: 11px !important;
            font-weight: 500 !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 6px !important;
        }

        .dataTables_wrapper .dataTables_filter input {
            background-color: var(--input-bg) !important;
            border: 1px solid var(--border-color) !important;
            border-radius: 0.25rem !important;
            color: var(--text-body) !important;
            padding: 6px 10px !important;
            font-size: 12px !important;
            outline: none !important;
            transition: border-color 0.2s, box-shadow 0.2s !important;
            min-width: 180px !important;
            margin-left: 4px !important;
        }

        .dataTables_wrapper .dataTables_filter input:focus {
            border-color: #1d4ed8 !important;
            box-shadow: 0 0 0 2px rgba(29, 78, 216, 0.2) !important;
            outline: none !important;
        }

        .dataTables_wrapper .dataTables_filter input::placeholder {
            color: var(--text-muted) !important;
        }

        .form-label {
            color: var(--text-muted);
            font-size: 10px;
            font-weight: 600;
            margin-bottom: 4px;
            display: block;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-primary {
            background-color: #1d4ed8;
            color: #fff;
            padding: 7px 18px;
            border-radius: 0.25rem;
            border: none;
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .btn-primary:hover { background-color: #2563eb; }

        /* ============================================ */
        /* KPI CARDS                                     */
        /* ============================================ */
        .kpi-card {
            background-color: var(--bg-panel);
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            padding: 16px;
            transition: all 0.3s ease;
        }
        .kpi-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        }
        .kpi-label {
            font-size: 10px;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
            margin-bottom: 4px;
        }
        .kpi-value {
            font-size: 22px;
            font-weight: 700;
            color: var(--text-heading);
        }

        /* ============================================ */
        /* TABLES                                        */
        /* ============================================ */
        .table-container { overflow-x: visible; }
        .table-container table { width: 100% !important; border-collapse: collapse; font-size: 11px; }
        .table-container table thead th {
            background-color: var(--table-head-bg) !important;
            color: var(--table-head-text) !important;
            font-weight: 600;
            text-align: left;
            padding: 10px 12px;
            border-bottom: 2px solid var(--border-color);
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .table-container table tbody td {
            padding: 8px 12px;
            border-bottom: 1px solid var(--border-color);
            color: var(--table-row-text);
            vertical-align: middle;
            font-size: 11px;
        }
        .table-container table tbody tr:hover { background-color: var(--table-row-hover); }

        .dataTables_wrapper .dataTables_info {
            color: var(--text-muted) !important;
            font-size: 11px !important;
            padding-top: 12px !important;
        }
        .dataTables_wrapper .dataTables_paginate { padding-top: 12px !important; }
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 4px 10px !important;
            margin: 0 2px !important;
            border-radius: 4px !important;
            background: var(--bg-panel) !important;
            border: 1px solid var(--border-color) !important;
            color: var(--text-muted) !important;
            font-size: 11px !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #1d4ed8 !important;
            color: #fff !important;
            border-color: #1d4ed8 !important;
        }

        .dt-buttons { display: flex !important; gap: 6px !important; flex-wrap: wrap !important; margin-bottom: 10px; }
        .dt-buttons .dt-button {
            padding: 5px 12px !important;
            background-color: var(--bg-panel) !important;
            border: 1px solid var(--border-color) !important;
            border-radius: 0.25rem !important;
            color: var(--text-muted) !important;
            font-size: 10px !important;
            cursor: pointer !important;
            transition: all 0.2s !important;
            font-family: 'Inter', sans-serif !important;
            height: 30px !important;
        }
        .dt-buttons .dt-button:hover {
            background-color: var(--hover-bg) !important;
            color: var(--text-heading) !important;
        }

        /* ============================================ */
        /* BADGES                                        */
        /* ============================================ */
        .badge {
            padding: 2px 8px;
            border-radius: 9999px;
            font-size: 9px;
            font-weight: 600;
            display: inline-block;
        }
        .badge-success { background: #10b98120; color: #10b981; border: 1px solid #10b98140; }
        .badge-warning { background: #f59e0b20; color: #f59e0b; border: 1px solid #f59e0b40; }
        .badge-danger { background: #ef444420; color: #ef4444; border: 1px solid #ef444440; }
        .badge-info { background: #3b82f620; color: #3b82f6; border: 1px solid #3b82f640; }

        /* ============================================ */
        /* MODAL                                         */
        /* ============================================ */
        .modal {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.5);
            backdrop-filter: blur(6px);
            z-index: 9999;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .modal.show { display: flex; }
        .modal-content {
            background: var(--bg-panel);
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            width: 100%;
            max-width: 900px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35);
        }
        .modal-header {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            background: var(--bg-panel);
            z-index: 10;
        }
        .modal-body { padding: 20px; }

        @media (max-width: 768px) {
            .kpi-value { font-size: 18px; }
        }
    </style>
</head>

<body class="flex h-screen overflow-hidden text-xs">

    <?php include 'includes/sidebar.php'; ?>

    <main id="mainContent" class="flex-1 flex flex-col overflow-hidden">

        <?php include 'includes/topbar.php'; ?>

        <div class="flex-1 overflow-y-auto p-4 md:p-6" id="pageContent">

            <!-- Page Header -->
            <div class="flex flex-wrap justify-between items-center mb-4 gap-3">
                <div>
                    <h2 class="text-heading font-semibold text-lg tracking-wide uppercase">
                        <i class="fa-solid fa-gauge-high mr-2 text-blue-500"></i>Engineering Dashboard
                    </h2>
                    <p class="text-xs text-gray-500 mt-0.5">Monitor dealers, visits & inspection tasks</p>
                </div>
            </div>

            <!-- Filters -->
            <div class="panel-card p-3 mb-4">
                <div class="grid grid-cols-1 md:grid-cols-4 lg:grid-cols-6 gap-3">
                    <div>
                        <label class="form-label">From</label>
                        <input type="date" id="fromdate" value="2026-09-01" class="form-input">
                    </div>
                    <div>
                        <label class="form-label">To</label>
                        <input type="date" id="todate" value="2026-10-01" class="form-input">
                    </div>
                    <div>
                        <label class="form-label">Region</label>
                        <select id="regions" class="form-select" multiple></select>
                    </div>
                    <div>
                        <label class="form-label">Province</label>
                        <select id="province" class="form-select" multiple></select>
                    </div>
                    <div>
                        <label class="form-label">City</label>
                        <select id="city" class="form-select" multiple></select>
                    </div>
                    <div>
                        <label class="form-label">District</label>
                        <select id="district" class="form-select" multiple></select>
                    </div>
                    <div>
                        <label class="form-label">Eng-Users</label>
                        <select id="asm_users" class="form-select" multiple></select>
                    </div>
                    <div class="flex items-end">
                        <button onclick="fetchAllData()" class="btn-primary w-full justify-center">
                            <i class="fa-solid fa-magnifying-glass"></i> Get
                        </button>
                    </div>
                </div>
            </div>

            <!-- KPI Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                <div class="kpi-card">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="kpi-label">Total Dealers</div>
                            <div class="kpi-value" id="dealers_count">0</div>
                        </div>
                        <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background: #3b82f620;">
                            <i class="fa-solid fa-building text-blue-500 text-lg"></i>
                        </div>
                    </div>
                    <div class="mt-2 flex gap-3 text-[10px]">
                        <span>Verified: <b id="verified_dealers" class="text-green-500">0</b></span>
                        <span>Not-Active: <b id="nonverified_dealers" class="text-red-500">0</b></span>
                        <span>Login: <b id="logined_dealers" class="text-blue-500">0</b></span>
                    </div>
                </div>

                <div class="kpi-card">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="kpi-label">Visit Tasks</div>
                            <div class="kpi-value" id="task_count">0</div>
                        </div>
                        <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background: #f59e0b20;">
                            <i class="fa-solid fa-clipboard-list text-orange-500 text-lg"></i>
                        </div>
                    </div>
                    <div class="mt-2 flex flex-wrap gap-2 text-[10px]">
                        <span>Pending: <b id="Pending_tasks" class="text-yellow-500">0</b></span>
                        <span>Complete: <b id="completed_tasks" class="text-green-500">0</b></span>
                        <span>Overdue: <b id="late_tasks" class="text-red-500">0</b></span>
                        <span>Upcoming: <b id="upcoming_tasks" class="text-blue-500">0</b></span>
                    </div>
                </div>

                <div class="kpi-card">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="kpi-label">Regional Managers</div>
                            <div class="kpi-value" id="rm_counts">0</div>
                        </div>
                        <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background: #10b98120;">
                            <i class="fa-solid fa-user-tie text-green-500 text-lg"></i>
                        </div>
                    </div>
                </div>

                <div class="kpi-card">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="kpi-label">Eng-Users</div>
                            <div class="kpi-value" id="tm_counts">0</div>
                        </div>
                        <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background: #8b5cf620;">
                            <i class="fa-solid fa-users text-purple-500 text-lg"></i>
                        </div>
                    </div>
                    <div class="mt-2 text-[10px]">
                        <span>Visit Users: <b id="vistes_users" class="text-blue-500">0</b></span>
                    </div>
                </div>
            </div>

            <!-- Dealers Table -->
            <div class="panel-card mb-4">
                <div class="p-3 border-b" style="border-color: var(--border-color);">
                    <h5 class="text-heading font-semibold text-sm">
                        <i class="fa-solid fa-building mr-2 text-blue-500"></i>Dealers List
                    </h5>
                </div>
                <div class="p-3">
                    <div class="table-container">
                        <table id="dealersTable" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Site Name</th>
                                    <th>Site Code</th>
                                    <th>Is Verified</th>
                                    <th>Eng-User</th>
                                    <th>Contact</th>
                                    <th>Location</th>
                                    <th>Is-Login</th>
                                    <th>City</th>
                                    <th>Province</th>
                                    <th>Region</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Tasks Table -->
            <div class="panel-card mb-4">
                <div class="p-3 border-b" style="border-color: var(--border-color);">
                    <h5 class="text-heading font-semibold text-sm">
                        <i class="fa-solid fa-clipboard-check mr-2 text-green-500"></i>Visit Tasks
                    </h5>
                </div>
                <div class="p-3">
                    <div class="table-container">
                        <table id="taskTable" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>User</th>
                                    <th>Site Code</th>
                                    <th>Site Name</th>
                                    <th>Planned Date</th>
                                    <th>Dealer Sign</th>
                                    <th>Complete Time</th>
                                    <th>Visit Status</th>
                                    <th>Description</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <!-- RM Approval Modal -->
    <div id="rmApprovalModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="text-heading font-semibold text-sm">Regional Manager Approval Report</h5>
                <button onclick="closeModal('rmApprovalModal')" class="text-gray-400 hover:text-red-500 text-lg">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-body">
                <div id="approvalContent"></div>
            </div>
        </div>
    </div>

    <script>
        // API Configuration
        const API_BASE = 'api/';
        const API_KEY = '03201232927';
        const PRE = 'Admin';
        const USER_ID = '1';

        let dealersData = [];
        let taskData = [];
        let dealersTable = null;
        let taskTable = null;

        $(document).ready(function () {
            $('#sidebarToggle').on('click', function () {
                $('#sidebar').toggleClass('collapsed');
                localStorage.setItem('sidebarCollapsed', $('#sidebar').hasClass('collapsed'));
            });
            if (localStorage.getItem('sidebarCollapsed') === 'true') {
                $('#sidebar').addClass('collapsed');
            }

            dealersTable = $('#dealersTable').DataTable({
                dom: 'Bfrtip',
                buttons: ['copy', 'excel', 'csv', 'pdf', 'print'],
                pageLength: 10,
                language: {
                    emptyTable: 'No dealers found',
                    info: 'Showing _START_ to _END_ of _TOTAL_ entries',
                    infoEmpty: 'Showing 0 to 0 of 0 entries'
                }
            });

            taskTable = $('#taskTable').DataTable({
                dom: 'Bfrtip',
                buttons: ['copy', 'excel', 'csv', 'pdf', 'print'],
                pageLength: 10,
                language: {
                    emptyTable: 'No tasks found',
                    info: 'Showing _START_ to _END_ of _TOTAL_ entries',
                    infoEmpty: 'Showing 0 to 0 of 0 entries'
                }
            });

            $('#regions, #province, #city, #district, #asm_users').select2({
                placeholder: 'Select',
                allowClear: true,
                width: '100%'
            });

            fetchAllData();
        });

        function fetchAllData() {
            const fromdate = $('#fromdate').val();
            const todate = $('#todate').val();

            fetchDealers();
            fetchTasks(fromdate, todate);
            fetchVisitUsers(fromdate, todate);
            fetchFilters();
        }

        function fetchDealers() {
            const url = `${API_BASE}get/eng/eng_users_dealers.php?key=${API_KEY}&pre=${PRE}&user_id=${USER_ID}`;
            console.log('Fetching dealers:', url);

            fetch(url)
                .then(res => res.json())
                .then(response => {
                    console.log('Dealers:', response);
                    dealersData = response || [];
                    dealersTable.clear();

                    let verifiedCount = 0, nonVerifiedCount = 0, loginCount = 0;
                    $('#dealers_count').text(dealersData.length);

                    $.each(dealersData, function (index, data) {
                        dealersTable.row.add([
                            index + 1,
                            data.name || 'N/A',
                            data.sap_no || 'N/A',
                            data.indent_price == '1'
                                ? '<span class="badge badge-success">Verified</span>'
                                : '<span class="badge badge-danger">Not-Active</span>',
                            data.asm_name || 'N/A',
                            data.contact || 'N/A',
                            data.location || 'N/A',
                            data.Nozel_price != '0'
                                ? '<span class="badge badge-info">Logged-In</span>'
                                : '<span class="badge badge-warning">Not-Login</span>',
                            data.city || 'N/A',
                            data.province || 'N/A',
                            data.region || 'N/A'
                        ]).draw(false);

                        if (data.indent_price == '1') verifiedCount++;
                        else nonVerifiedCount++;
                        if (data.Nozel_price != '0') loginCount++;
                    });

                    $('#verified_dealers').text(verifiedCount);
                    $('#nonverified_dealers').text(nonVerifiedCount);
                    $('#logined_dealers').text(loginCount);
                })
                .catch(err => console.error('Dealers fetch error:', err));
        }

        function fetchTasks(fromdate, todate) {
            const url = `${API_BASE}get/eng/all_dealers_inspection.php?key=${API_KEY}&pre=${PRE}&user_id=${USER_ID}&from=${fromdate}&to=${todate}`;
            console.log('Fetching tasks:', url);

            fetch(url)
                .then(res => res.json())
                .then(response => {
                    console.log('Tasks:', response);
                    taskData = response || [];
                    taskTable.clear();

                    $('#task_count').text(taskData.length);

                    $.each(taskData, function (index, data) {
                        const dealerSign = (data.dealer_sign != null)
                            ? `<a href="${API_BASE}uploads/${data.dealer_sign}" target="_blank">
                                 <i class="fas fa-file-image text-green-500 text-lg"></i>
                               </a>`
                            : '---';

                        const statusBadge = getStatusBadge(data.current_status);

                        taskTable.row.add([
                            index + 1,
                            `<a href="inspection_report_eng.php?name=${data.user_name}" target="_blank" class="text-blue-500 hover:underline">${data.user_name || 'N/A'}</a>`,
                            data.sap_no || 'N/A',
                            data.dealer_name || 'N/A',
                            data.time || 'N/A',
                            dealerSign,
                            data.visit_close_time || '---',
                            statusBadge,
                            data.description || '---',
                            data.task_create_time || 'N/A'
                        ]).draw(false);
                    });

                    let pendingCount = 0, completeCount = 0, lateCount = 0, upcomingCount = 0;
                    $.each(taskData, function (i, rec) {
                        if (rec.current_status === 'Pending') pendingCount++;
                        else if (rec.current_status === 'Complete') completeCount++;
                        else if (rec.current_status === 'Overdue') lateCount++;
                        else if (rec.current_status === 'Upcoming') upcomingCount++;
                    });

                    $('#Pending_tasks').text(pendingCount);
                    $('#completed_tasks').text(completeCount);
                    $('#late_tasks').text(lateCount);
                    $('#upcoming_tasks').text(upcomingCount);
                })
                .catch(err => console.error('Tasks fetch error:', err));
        }

        function fetchVisitUsers(fromdate, todate) {
            const url = `${API_BASE}get/eng/get_all_specific_visits_user.php?key=${API_KEY}&pre=${PRE}&user_id=${USER_ID}&from=${fromdate}&to=${todate}`;
            console.log('Fetching visit users:', url);

            fetch(url)
                .then(res => res.json())
                .then(response => {
                    console.log('Visit Users:', response);
                    $('#vistes_users').text((response || []).length);
                })
                .catch(err => console.error('Visit users fetch error:', err));
        }

        function fetchFilters() {
            const url = `${API_BASE}get/eng/get_region_district_dealers.php?key=${API_KEY}`;
            console.log('Fetching filters:', url);

            $.ajax({
                url: url,
                method: 'GET',
                dataType: 'json',
                success: function (data) {
                    if (!data || !data[0]) return;

                    try {
                        const district = JSON.parse(data[0]['district'] || '[]');
                        const city = JSON.parse(data[0]['city'] || '[]');
                        const province = JSON.parse(data[0]['province'] || '[]');
                        const region = JSON.parse(data[0]['region'] || '[]');
                        const tm = JSON.parse(data[0]['tm'] || '[]');
                        const asm = JSON.parse(data[0]['asm'] || '[]');

                        fillSelect('#district', district, 'district');
                        fillSelect('#city', city, 'city');
                        fillSelect('#province', province, 'province');
                        fillSelect('#regions', region, 'region');
                        fillSelect('#asm_users', asm, 'name', 'id');

                        $('#rm_counts').text(tm.length);
                        $('#tm_counts').text(asm.length);
                    } catch (e) {
                        console.error('Filter parse error:', e);
                    }
                },
                error: function (err) {
                    console.error('Filters fetch error:', err);
                }
            });
        }

        function fillSelect(selector, items, textKey, valueKey) {
            const $sel = $(selector);
            $sel.empty();
            $.each(items, function (i, item) {
                $sel.append($('<option>', {
                    value: valueKey ? item[valueKey] : item[textKey],
                    text: item[textKey]
                }));
            });
            $sel.trigger('change.select2');
        }

        function getStatusBadge(status) {
            if (status === 'Complete') return '<span class="badge badge-success">Complete</span>';
            if (status === 'Pending') return '<span class="badge badge-warning">Pending</span>';
            if (status === 'Overdue') return '<span class="badge badge-danger">Overdue</span>';
            if (status === 'Upcoming') return '<span class="badge badge-info">Upcoming</span>';
            return `<span class="badge badge-info">${status || 'N/A'}</span>`;
        }

        function openModal(id) { $('#' + id).addClass('show'); }
        function closeModal(id) { $('#' + id).removeClass('show'); }

        $(document).on('click', '.modal', function (e) {
            if (e.target === this) $(this).removeClass('show');
        });
    </script>

</body>

</html>