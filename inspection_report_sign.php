<?php
require_once __DIR__ . '/session/session.php';
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Incomplete Visits | Admin</title>
    <meta name="viewport" content="width=device-width,   initial-scale=1.0">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

    <!-- PDF Export -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.3/jspdf.min.js"></script>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>

    <!-- DARK MODE INIT -->
    <script>
        (function() {
            const isDarkMode = localStorage.getItem('darkMode') === 'true';
            if (isDarkMode) document.documentElement.classList.add('dark-mode');
        })();
    </script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        dash: {
                            bg: '#060b13', panel: '#0d1520', border: '#1a2635',
                            textMuted: '#64748b', accentBlue: '#1d4ed8'
                        }
                    }
                }
            }
        }
    </script>

    <style>
        :root {
            --bg-body: #f4f6fa; --bg-panel: #ffffff; --border-color: #e2e8f0;
            --text-heading: #0f2440; --text-body: #334155; --text-muted: #64748b;
            --input-bg: #ffffff; --hover-bg: #f1f5f9; --table-head-bg: #f8fafc;
            --table-head-text: #475569; --table-row-text: #1e293b; --table-row-hover: #f1f5f9;
            --modal-overlay: rgba(15, 23, 42, 0.45);
            --toolbar-btn-bg: #ffffff; --dropdown-bg: #ffffff; --dropdown-hover: #f1f5f9;
            --focus-border: #1d4ed8;
            --focus-ring: rgba(29, 78, 216, 0.2);
        }
        html.dark-mode {
            --bg-body: #060b13; --bg-panel: #0d1520; --border-color: #1a2635;
            --text-heading: #ffffff; --text-body: #e5e7eb; --text-muted: #94a3b8;
            --input-bg: #060b13; --hover-bg: #1a2635; --table-head-bg: #0a121c;
            --table-head-text: #94a3b8; --table-row-text: #e5e7eb; --table-row-hover: #0d1a2a;
            --modal-overlay: rgba(6, 11, 19, 0.85);
            --toolbar-btn-bg: #060b13; --dropdown-bg: #0d1520; --dropdown-hover: #1a2635;
            --focus-border: #1d4ed8;
            --focus-ring: rgba(29, 78, 216, 0.35);
        }
        * { box-sizing: border-box; }
        body {
            background-color: var(--bg-body); color: var(--text-muted);
            font-family: 'Inter', sans-serif; margin: 0; font-size: 12px;
            transition: background-color .25s ease, color .25s ease;
        }
        .text-heading { color: var(--text-heading) !important; }
        .panel-card {
            background-color: var(--bg-panel); border: 1px solid var(--border-color);
            border-radius: 0.375rem;
        }

        /* TABLE STYLES */
        .table-container { overflow-x: auto; width: 100%; }
        #myTable {
            width: 100% !important;
            border-collapse: collapse !important;
            font-size: 11px;
            margin: 0;
        }
        #myTable thead th {
            background-color: var(--table-head-bg) !important;
            color: var(--table-head-text) !important;
            font-weight: 600;
            text-align: left;
            padding: 10px 12px;
            border-bottom: 1px solid var(--border-color);
            white-space: nowrap;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        #myTable tbody td {
            padding: 10px 12px;
            border-bottom: 1px solid var(--border-color);
            color: var(--table-row-text);
            vertical-align: middle;
            font-size: 11px;
        }
        #myTable tbody tr:hover {
            background-color: var(--table-row-hover);
        }

        .dataTables_wrapper { width: 100% !important; padding: 0 !important; }
        .dataTables_wrapper .dataTables_length { display: none !important; }
        .dataTables_wrapper .dataTables_info {
            color: var(--text-muted) !important;
            font-size: 11px !important;
            padding: 12px !important;
        }
        .dataTables_wrapper .dataTables_paginate { padding: 12px !important; }
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 4px 10px !important;
            margin: 0 2px !important;
            border-radius: 4px !important;
            background: var(--toolbar-btn-bg) !important;
            border: 1px solid var(--border-color) !important;
            color: var(--text-muted) !important;
            font-size: 11px !important;
            cursor: pointer !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: var(--hover-bg) !important;
            color: var(--text-heading) !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #1d4ed8 !important;
            color: #ffffff !important;
            border-color: #1d4ed8 !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
            opacity: 0.5 !important; cursor: not-allowed !important;
        }

        /* DataTables top bar: exporter buttons + search box in same row */
        .dt-top-bar {
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            gap: 12px !important;
            flex-wrap: wrap !important;
            padding: 12px 14px !important;
            margin: 0 !important;
            width: 100% !important;
            box-sizing: border-box !important;
            border-bottom: 1px solid var(--border-color) !important;
        }
        .dt-top-bar .dt-buttons {
            display: flex !important;
            gap: 8px !important;
            flex-wrap: wrap !important;
            padding: 0 !important;
            margin: 0 !important;
            border: none !important;
            width: auto !important;
        }
        .dt-top-bar .dataTables_filter {
            display: block !important;
            padding: 0 !important;
            margin: 0 !important;
            float: none !important;
            text-align: right !important;
            flex-shrink: 0 !important;
        }
        .dt-top-bar .dataTables_filter label {
            color: var(--text-muted) !important;
            font-size: 11px !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 6px !important;
            margin: 0 !important;
        }
        .dt-top-bar .dataTables_filter input {
            background-color: var(--input-bg) !important;
            border: 1px solid var(--border-color) !important;
            border-radius: 0.25rem !important;
            color: var(--text-body) !important;
            padding: 6px 10px !important;
            font-size: 12px !important;
            outline: none !important;
            height: 30px !important;
            width: 200px !important;
            margin-left: 4px !important;
            transition: border-color 0.2s, box-shadow 0.2s !important;
        }
        .dt-top-bar .dataTables_filter input:focus {
            border-color: #1d4ed8 !important;
            box-shadow: 0 0 0 2px rgba(29, 78, 216, 0.2) !important;
        }

        .dt-buttons .dt-button {
            padding: 6px 12px !important;
            margin: 0 !important;
            background-color: var(--toolbar-btn-bg) !important;
            border: 1px solid var(--border-color) !important;
            border-radius: 0.25rem !important;
            color: var(--text-muted) !important;
            font-size: 10px !important;
            cursor: pointer !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 4px !important;
            height: 30px !important;
            font-family: 'Inter', sans-serif !important;
        }
        .dt-buttons .dt-button:hover {
            background-color: var(--hover-bg) !important;
            color: var(--text-heading) !important;
        }

        .form-input {
            background-color: var(--input-bg); border: 1px solid var(--border-color);
            border-radius: 0.25rem; color: var(--text-body);
            padding: 6px 10px; width: 100%; font-size: 12px;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .form-input:focus {
            outline: none; border-color: var(--focus-border);
            box-shadow: 0 0 0 2px var(--focus-ring);
        }

        .btn-primary {
            background-color: #1d4ed8; color: #fff; padding: 8px 20px;
            border-radius: 0.25rem; border: none; font-size: 12px;
            font-weight: 500; cursor: pointer;
        }
        .btn-primary:hover { background-color: #2563eb; }
        .btn-primary:disabled { opacity: 0.6; cursor: not-allowed; }

        .btn-add {
            background-color: #1d4ed8; color: #fff; padding: 6px 16px;
            border-radius: 0.25rem; border: none; font-size: 11px;
            font-weight: 500; cursor: pointer;
            display: inline-flex; align-items: center; gap: 6px;
            height: 30px; transition: background-color 0.2s;
        }
        .btn-add:hover { background-color: #2563eb; }

        .toolbar-row {
            display: flex; align-items: center; justify-content: space-between;
            gap: 10px; flex-wrap: wrap; width: 100%;
        }
        .toolbar-left, .toolbar-right {
            display: flex; align-items: center; gap: 6px; flex-wrap: wrap;
        }

        .column-visibility-dropdown { position: relative; display: inline-block; }
        .column-visibility-dropdown .dropdown-btn {
            background-color: var(--toolbar-btn-bg);
            border: 1px solid var(--border-color);
            border-radius: 0.25rem; color: var(--text-muted);
            padding: 6px 12px; font-size: 10px; cursor: pointer;
            display: inline-flex; align-items: center; gap: 6px;
            height: 30px; white-space: nowrap;
        }
        .column-visibility-dropdown .dropdown-btn:hover {
            background-color: var(--hover-bg); color: var(--text-heading);
        }
        .column-visibility-dropdown .dropdown-menu {
            position: absolute; top: calc(100% + 4px); right: 0; left: auto;
            min-width: 210px; background-color: var(--dropdown-bg);
            border: 1px solid var(--border-color);
            border-radius: 0.375rem; padding: 6px 0;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
            z-index: 1000; display: none;
            max-height: 380px; overflow-y: auto;
        }
        .column-visibility-dropdown .dropdown-menu.show { display: block; }
        .column-visibility-dropdown .dropdown-menu .dropdown-header {
            padding: 6px 14px 8px; font-size: 9px; font-weight: 600;
            text-transform: uppercase; color: var(--text-muted);
            border-bottom: 1px solid var(--border-color);
        }
        .column-visibility-dropdown .dropdown-menu .dropdown-item {
            display: flex; align-items: center; gap: 10px;
            padding: 6px 14px; cursor: pointer;
            font-size: 11px; color: var(--text-body);
        }
        .column-visibility-dropdown .dropdown-menu .dropdown-item:hover {
            background-color: var(--dropdown-hover);
        }
        .column-visibility-dropdown .dropdown-menu .dropdown-item input[type="checkbox"] {
            width: 14px; height: 14px; cursor: pointer;
            accent-color: #1d4ed8; flex-shrink: 0;
        }
        .column-visibility-dropdown .dropdown-menu .dropdown-actions {
            display: flex; gap: 6px; padding: 8px 14px 4px;
            border-top: 1px solid var(--border-color); margin-top: 4px;
        }
        .column-visibility-dropdown .dropdown-menu .dropdown-actions button {
            flex: 1; padding: 4px 8px; border-radius: 0.25rem;
            border: 1px solid var(--border-color);
            background: var(--toolbar-btn-bg); color: var(--text-muted);
            font-size: 9px; cursor: pointer;
        }
        .column-visibility-dropdown .dropdown-menu .dropdown-actions button:hover {
            background: var(--hover-bg); color: var(--text-heading);
        }
        .column-visibility-dropdown .dropdown-menu .dropdown-actions button.select-all-btn {
            border-color: #10b981; color: #10b981;
        }
        .column-visibility-dropdown .dropdown-menu .dropdown-actions button.deselect-all-btn {
            border-color: #ef4444; color: #ef4444;
        }

        .action-btn {
            padding: 4px 8px; border-radius: 4px; font-size: 11px;
            cursor: pointer; border: none; background: transparent;
            color: var(--text-muted);
        }
        .action-btn:hover { background: var(--hover-bg); color: var(--text-heading); }
        .action-btn.edit:hover { background: #3b82f620; color: #3b82f6; }

        #myTable tbody td .fa-file-image,
        #myTable tbody td a .fa-file-image {
            color: #10b981 !important;
        }

        .action-btn.edit .fa-align-justify {
            color: var(--text-muted);
            transition: color 0.2s ease;
        }
        .action-btn.edit:hover .fa-align-justify {
            color: #10b981 !important;
        }

        .modal-content-themed {
            background-color: var(--bg-panel);
            border: 1px solid var(--border-color);
            border-radius: 0.5rem; color: var(--text-body);
        }
        .modal-header-themed {
            border-bottom: 1px solid var(--border-color);
            padding: 12px 16px;
        }
        .modal-body-themed {
            padding: 16px; max-height: 75vh; overflow-y: auto;
        }

        .toast {
            position: fixed; bottom: 30px; right: 30px;
            background: var(--bg-panel); border: 1px solid var(--border-color);
            border-radius: 0.375rem; padding: 12px 20px;
            color: var(--text-body); font-size: 12px; z-index: 9999;
            transform: translateY(100px); opacity: 0;
            transition: all 0.3s ease-in-out;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
        }
        .toast.show { transform: translateY(0); opacity: 1; }
        .toast.success { border-color: #10b981; }
        .toast.success i { color: #10b981; }
        .toast.error { border-color: #ef4444; }
        .toast.error i { color: #ef4444; }

        .footer-themed {
            padding: 12px 16px; border-top: 1px solid var(--border-color);
            background-color: var(--bg-panel); color: var(--text-muted);
            font-size: 11px;
        }

        .loading-row td {
            text-align: center !important;
            padding: 30px !important;
            color: var(--text-muted) !important;
        }

        /* Offcanvas / Modal for Complete Visit */
        .offcanvas-themed {
            position: fixed; top: 0; right: 0; height: 100%;
            width: 420px; max-width: 100%;
            background: var(--bg-panel); border-left: 1px solid var(--border-color);
            z-index: 60; transform: translateX(100%);
            transition: transform 0.3s ease; display: flex; flex-direction: column;
        }
        .offcanvas-themed.show { transform: translateX(0); }
        .offcanvas-overlay {
            position: fixed; inset: 0; background: var(--modal-overlay);
            backdrop-filter: blur(4px); z-index: 55; display: none;
        }
        .offcanvas-overlay.show { display: block; }

        .form-label-themed {
            display: block; font-size: 10px; text-transform: uppercase;
            color: var(--text-muted); font-weight: 600; margin-bottom: 4px;
            letter-spacing: 0.5px;
        }
    </style>
</head>

<body class="flex h-screen overflow-hidden text-xs">

    <!-- SIDEBAR -->
    <?php include 'includes/sidebar.php'; ?>

    <!-- MAIN CONTENT -->
    <main id="mainContent" class="flex-1 flex flex-col overflow-hidden">

        <!-- TOPBAR -->
        <?php include 'includes/topbar.php'; ?>

        <!-- PAGE CONTENT -->
        <div class="flex-1 overflow-y-auto p-4" id="pageContent">

            <!-- Page Header -->
            <div class="flex justify-between items-center mb-4">
                <div>
                    <h2 class="text-heading font-semibold text-base tracking-wide uppercase">Incomplete Visits</h2>
                    <p class="text-[10px] text-gray-500">View and complete pending dealer visits</p>
                </div>
            </div>

            <!-- Filters Toolbar -->
            <div class="panel-card p-3 mb-4">
                <div class="toolbar-row">
                    <div class="toolbar-left">
                        <div class="flex items-center gap-2">
                            <label class="text-[10px] text-gray-500 uppercase font-medium">From</label>
                            <input type="date" class="form-input" name="fromdate" id="fromdate" value="<?php echo date('Y-m-01') ?>" style="width:140px;">
                        </div>
                        <div class="flex items-center gap-2">
                            <label class="text-[10px] text-gray-500 uppercase font-medium">To</label>
                            <input type="date" class="form-input" name="todate" id="todate" value="<?php echo (new DateTime('last day of this month'))->modify('+1 day')->format('Y-m-d'); ?>" style="width:140px;">
                        </div>
                        <button class="btn-primary" id="btn_get" onclick="fetchtable()" style="height:30px;padding:0 16px;">
                            <i class="fa-solid fa-magnifying-glass mr-1"></i> Get
                        </button>
                    </div>
                    <div class="toolbar-right">
                        <button class="btn-add" id="add_btn" onclick="openAddForm()">
                            <i class="fa-solid fa-plus"></i> Add
                        </button>
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
                                <div class="dropdown-actions">
                                    <button class="select-all-btn" onclick="selectAllColumns()">
                                        <i class="fa-regular fa-check-circle mr-1"></i> All
                                    </button>
                                    <button class="deselect-all-btn" onclick="deselectAllColumns()">
                                        <i class="fa-regular fa-circle mr-1"></i> None
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Incomplete Visits Table -->
            <div class="panel-card overflow-hidden">
                <div class="table-container">
                    <table id="myTable" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Date</th>
                                <th>Complete Time</th>
                                <th>Dealer Sign</th>
                                <th>User</th>
                                <th>JD Code</th>
                                <th>Dealer</th>
                                <th>Mode</th>
                                <th>Status</th>
                                <th>Complete Visit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="loading-row">
                                <td colspan="10"><i class="fa-solid fa-spinner fa-spin mr-2"></i>Loading data...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <!-- FOOTER -->
        <footer class="footer-themed">
            <div class="flex justify-between items-center">
                <div>
                    <script>document.write(new Date().getFullYear())</script> © <span id="projectname">P2P Track</span>.
                </div>
                <div></div>
            </div>
        </footer>

    </main>

    <!-- TOAST -->
    <div id="toast" class="toast">
        <i class="fa-solid fa-check-circle mr-2"></i>
        <span id="toastMessage">Operation successful!</span>
    </div>

    <!-- COMPLETE VISIT OFFCANVAS (Create / Edit) -->
    <div class="offcanvas-overlay" id="offcanvasOverlay" onclick="closeCompleteVisit()"></div>
    <div class="offcanvas-themed" id="completeVisitOffcanvas">
        <div class="modal-header-themed flex justify-between items-center">
            <h5 id="offcanvasTitle" class="text-heading font-semibold text-sm">Complete Visit</h5>
            <button onclick="closeCompleteVisit()" class="text-gray-400 hover:text-red-500 transition">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>
        <div class="modal-body-themed flex-1">
            <form method="post" id="insert_form" enctype="multipart/form-data">

                <div class="mb-4">
                    <label for="dealer_sign" class="form-label-themed">Dealer Sign</label>
                    <input type="file" class="form-input" id="dealer_sign" name="dealer_sign" required>
                </div>
                <div class="mb-4">
                    <label for="description" class="form-label-themed">Description</label>
                    <textarea class="form-input" name="description" id="description" cols="30" rows="8" style="resize:vertical;"></textarea>
                </div>

                <input type="hidden" name="task_id" id="task_id" value="0">
                <input type="hidden" name="status" id="status" value="1">
                <input type="hidden" name="user_id" id="user_id" value="">

                <div class="text-center mt-6">
                    <input class="btn-primary" type="submit" name="insert" id="insert" value="Save">
                </div>
            </form>
        </div>
    </div>

    <!-- JAVASCRIPT -->
    <script>
        // ============================================
        // API Base URLs — LOCALHOST ONLY
        // ============================================
        var API_BASE = "api/";
        var FILES_BASE = "http://localhost/hascolBridge_files/";
        var API_KEY = "2170";
        var PRIVILEGE = "<?php echo isset($_SESSION['privilege']) ? $_SESSION['privilege'] : 'Admin'; ?>";
        var USER_ID = "<?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '1'; ?>";

        var dataTable = null;

        // ============================================
        // Toast
        // ============================================
        function showToast(message, type) {
            type = type || 'success';
            var toast = $('#toast');
            var toastMessage = $('#toastMessage');
            toast.removeClass('success error').addClass(type);
            toastMessage.text(message);
            toast.addClass('show');
            clearTimeout(window.toastTimeout);
            window.toastTimeout = setTimeout(function() { toast.removeClass('show'); }, 3000);
        }

        // ============================================
        // Complete Visit Offcanvas — Open / Close
        // ============================================
        function openCompleteVisit() {
            $('#completeVisitOffcanvas').addClass('show');
            $('#offcanvasOverlay').addClass('show');
            $('body').css('overflow', 'hidden');
        }
        function closeCompleteVisit() {
            $('#completeVisitOffcanvas').removeClass('show');
            $('#offcanvasOverlay').removeClass('show');
            $('body').css('overflow', '');
        }

        // ============================================
        // Open ADD form (create new record)
        // ============================================
        function openAddForm() {
            $('#insert_form')[0].reset();
            $('#task_id').val(0);
            $('#user_id').val('');
            $('#status').val(1);
            $('#offcanvasTitle').text('Add Complete Visit');
            $('#dealer_sign').prop('required', true);
            openCompleteVisit();
        }

        // ============================================
        // Open EDIT form (complete existing visit)
        // ============================================
        function editData(id, tm_id) {
            $('#insert_form')[0].reset();
            $('#task_id').val(id);
            $('#user_id').val(tm_id);
            $('#status').val(1);
            $('#offcanvasTitle').text('Complete Visit');
            $('#dealer_sign').prop('required', true);
            openCompleteVisit();
        }

        // ============================================
        // Dark Mode Toggle
        // ============================================
        function toggleDarkMode() {
            var html = document.documentElement;
            var isDark = html.classList.toggle('dark-mode');
            localStorage.setItem('darkMode', isDark);
            var icon = document.querySelector('.dark-mode-toggle i');
            if (icon) icon.className = isDark ? 'fa-solid fa-sun' : 'fa-solid fa-moon';
        }

        // ============================================
        // Column Visibility Config
        // ============================================
        var columnConfig = [
            { idx: 0, label: 'S.No' },
            { idx: 1, label: 'Date' },
            { idx: 2, label: 'Complete Time' },
            { idx: 3, label: 'Dealer Sign' },
            { idx: 4, label: 'User' },
            { idx: 5, label: 'JD Code' },
            { idx: 6, label: 'Dealer' },
            { idx: 7, label: 'Mode' },
            { idx: 8, label: 'Status' },
            { idx: 9, label: 'Complete Visit' }
        ];

        // ============================================
        // Document Ready
        // ============================================
        $(document).ready(function() {
            $(document).on('click', '#sidebarToggle', function() {
                $('#sidebar').toggleClass('collapsed');
                localStorage.setItem('sidebarCollapsed', $('#sidebar').hasClass('collapsed'));
            });
            if (localStorage.getItem('sidebarCollapsed') === 'true') {
                $('#sidebar').addClass('collapsed');
            }

            $(document).on('click', function(e) {
                if (!$(e.target).closest('.column-visibility-dropdown').length) {
                    closeColumnDropdown();
                }
            });

            $(document).on('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeCompleteVisit();
                    closeColumnDropdown();
                }
            });

            // Insert Form Submit
            $('#insert_form').on("submit", function (event) {
                event.preventDefault();

                var data = new FormData(this);

                $.ajax({
                    url: API_BASE + "update/inspection/task_response.php",
                    cache: false,
                    contentType: false,
                    processData: false,
                    method: "POST",
                    data: data,
                    beforeSend: function () {
                        $('#insert').val("Saving");
                        document.getElementById("insert").disabled = true;
                    },
                    success: function (data) {
                        console.log(data)
                        if (data != 1) {
                            Swal.fire(
                                'Server Error!',
                                'Record Not Updated',
                                'error'
                            )
                            $('#insert').val("Save");
                            document.getElementById("insert").disabled = false;
                        } else {
                            setTimeout(function () {
                                Swal.fire(
                                    'Success!',
                                    'Record Updated Successfully',
                                    'success'
                                )
                                closeCompleteVisit();
                                $('#insert').val("Save");
                                document.getElementById("insert").disabled = false;
                                fetchtable();
                            }, 2000);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', error);
                        Swal.fire('Server Error!', 'Record Not Updated', 'error');
                        $('#insert').val("Save");
                        document.getElementById("insert").disabled = false;
                    }
                });
            });

            initializeDataTable();
            fetchtable();
        });

        // ============================================
        // Initialize DataTable
        // ============================================
        function initializeDataTable() {
            if ($.fn.DataTable.isDataTable('#myTable')) {
                $('#myTable').DataTable().destroy();
            }
            $('#myTable tbody').empty();

            dataTable = $('#myTable').DataTable({
                data: [],
                columns: [
                    { title: 'S.No' }, { title: 'Date' }, { title: 'Complete Time' },
                    { title: 'Dealer Sign' }, { title: 'User' }, { title: 'JD Code' },
                    { title: 'Dealer' }, { title: 'Mode' }, { title: 'Status' },
                    { title: 'Complete Visit' }
                ],
                // Custom dom: top bar contains buttons + search box in same row
                dom: "<'dt-top-bar'<'dt-buttons-wrap'B><'dataTables_filter-wrap'f>>rt<'bottom'<'dataTables_info'i><'dataTables_paginate-wrap'p>>",
                buttons: [
                    { extend: 'copy', text: '<i class="fa-regular fa-copy"></i> Copy', className: 'toolbar-btn' },
                    { extend: 'excel', text: '<i class="fa-regular fa-file-excel"></i> Excel', className: 'toolbar-btn', title: 'Incomplete_Visits' },
                    { extend: 'csv', text: '<i class="fa-regular fa-file-csv"></i> CSV', className: 'toolbar-btn', title: 'Incomplete_Visits' },
                    { extend: 'pdf', text: '<i class="fa-regular fa-file-pdf"></i> PDF', className: 'toolbar-btn', title: 'Incomplete Visits', orientation: 'landscape', pageSize: 'A4' },
                    { extend: 'print', text: '<i class="fa-solid fa-print"></i> Print', className: 'toolbar-btn' }
                ],
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100],
                ordering: true,
                order: [[0, 'asc']],
                responsive: false,
                autoWidth: false,
                language: {
                    emptyTable: '<div class="text-center py-8 text-gray-500"><i class="fa-solid fa-clipboard-list text-2xl block mb-2"></i>No incomplete visits found</div>',
                    info: 'Showing _START_ to _END_ of _TOTAL_ entries',
                    infoEmpty: 'Showing 0 to 0 of 0 entries',
                    infoFiltered: '(filtered from _MAX_ total entries)',
                    zeroRecords: '<div class="text-center py-8 text-gray-500">No matching records found</div>',
                    search: '<i class="fa-solid fa-magnifying-glass" style="margin-right:6px;color:var(--text-muted);"></i>'
                },
                initComplete: function() {
                    populateColumnDropdown();
                    // Place the filter box inside our top bar wrapper
                    var $filter = $('#myTable_wrapper .dataTables_filter');
                    var $wrap = $('#myTable_wrapper .dt-top-bar .dataTables_filter-wrap');
                    if ($wrap.length && $filter.length) {
                        $wrap.append($filter);
                    }
                }
            });
        }

        // ============================================
        // Column Visibility Functions
        // ============================================
        function populateColumnDropdown() {
            var container = $('#columnListItems');
            container.empty();
            columnConfig.forEach(function(col) {
                var isVisible = true;
                try { isVisible = dataTable.column(col.idx).visible(); } catch(e) {}
                var item = '<div class="dropdown-item" onclick="toggleColumnVisibility(' + col.idx + ')">' +
                    '<input type="checkbox" id="col-checkbox-' + col.idx + '" ' + (isVisible ? 'checked' : '') +
                    ' onclick="event.stopPropagation(); toggleColumnVisibility(' + col.idx + ')">' +
                    '<span class="column-label">' + col.label + '</span></div>';
                container.append(item);
            });
        }

        function toggleColumnVisibility(colIdx) {
            if (!dataTable) return;
            try {
                var isVisible = dataTable.column(colIdx).visible();
                dataTable.column(colIdx).visible(!isVisible);
                $('#col-checkbox-' + colIdx).prop('checked', !isVisible);
            } catch(e) {}
        }

        function selectAllColumns() {
            if (!dataTable) return;
            columnConfig.forEach(function(col) {
                try { dataTable.column(col.idx).visible(true); } catch(e) {}
                $('#col-checkbox-' + col.idx).prop('checked', true);
            });
            showToast('All columns selected!', 'success');
        }

        function deselectAllColumns() {
            if (!dataTable) return;
            columnConfig.forEach(function(col) {
                try { dataTable.column(col.idx).visible(false); } catch(e) {}
                $('#col-checkbox-' + col.idx).prop('checked', false);
            });
            showToast('All columns deselected!', 'success');
        }

        function toggleColumnDropdown() {
            var menu = $('#columnDropdownMenu');
            menu.toggleClass('show');
            if (menu.hasClass('show')) populateColumnDropdown();
        }

        function closeColumnDropdown() { $('#columnDropdownMenu').removeClass('show'); }

        // ============================================
        // fetchtable()
        // ============================================
        function fetchtable() {
            var fromdate = $('#fromdate').val();
            var todate = $('#todate').val();

            if (dataTable) {
                dataTable.clear().draw();
                $('#myTable tbody').html('<tr class="loading-row"><td colspan="10"><i class="fa-solid fa-spinner fa-spin mr-2"></i>Loading data...</td></tr>');
            }

            var url = API_BASE + "get/get_incomplete_visits.php?key=" + API_KEY +
                      "&pre=" + encodeURIComponent(PRIVILEGE) + "&id=" + encodeURIComponent(USER_ID) +
                      "&from=" + fromdate + "&to=" + todate;

            fetch(url, { method: 'GET', redirect: 'follow' })
                .then(function(response) {
                    if (!response.ok) throw new Error('HTTP ' + response.status);
                    return response.json();
                })
                .then(function(response) {
                    $('#myTable tbody').empty();
                    if (!dataTable) initializeDataTable();
                    dataTable.clear();

                    if (!response || response.length === 0) {
                        dataTable.draw();
                        showToast('No data found.', 'error');
                        return;
                    }

                    var rowsToAdd = [];
                    $.each(response, function(index, data) {
                        // Complete Visit button
                        var complete_visit_btn = '<button type="button" onclick="editData(' + data.id + ',' + data.user_id +
                            ')" class="action-btn edit"><i class="fas fa-align-justify"></i></button>';

                        // Dealer sign
                        var dealer_sign = (data.dealer_sign != null) ?
                            '<a href="' + FILES_BASE + 'uploads/' + data.dealer_sign +
                            '" target="_blank"><i class="fas fa-file-image" style="color:#10b981;font-size:20px;font-weight:bold;"></i></a>' :
                            "---";

                        // Mode
                        var mode = data.type === "Inpection" ? "Inspection" : (data.type || '---');

                        rowsToAdd.push([
                            index + 1,
                            data.time ? data.time.split(' ')[0] : '---',
                            data.visit_close_time || '---',
                            dealer_sign,
                            data.name || '---',
                            data.dealer_sap || '---',
                            data.dealer_name || '---',
                            mode,
                            data.current_status || '---',
                            complete_visit_btn
                        ]);
                    });

                    dataTable.rows.add(rowsToAdd);
                    dataTable.draw();
                    showToast('Data loaded: ' + response.length + ' records', 'success');
                })
                .catch(function(error) {
                    $('#myTable tbody').html('<tr class="loading-row"><td colspan="10" style="color:#ef4444;">Error: ' + error.message + '</td></tr>');
                    showToast('Failed to load data.', 'error');
                });
        }
    </script>

</body>
</html>