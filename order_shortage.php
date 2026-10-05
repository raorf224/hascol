<?php
// Hascol OMC Operations Command Center - Local Order Shortage
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hascol - Order Shortage</title>
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

        /* Spacing fix: gap between the Sizes input field and the Save button */
        .form-group {
            margin-bottom: 20px;
        }

        /* Modal Styles */
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
        .offcanvas-open {
            overflow: hidden !important;
        }
    </style>
</head>

<body class="flex h-screen overflow-hidden text-xs">

    <?php include 'includes/sidebar.php'; ?>

    <main id="mainContent" class="flex-1 flex flex-col overflow-hidden">

        <?php include 'includes/topbar.php'; ?>

        <div class="flex-1 overflow-y-auto p-4" id="pageContent">

            <!-- Page Header -->
            <div class="flex justify-between items-center mb-4">
                <div>
                    <h2 class="text-heading font-semibold text-base tracking-wide">Order Shortage</h2>
                    <p class="text-[10px] text-gray-500">Orders with quantity shortage</p>
                </div>
                <button onclick="openCreateOffcanvas()" class="btn-primary flex items-center gap-2">
                    <i class="fa-solid fa-plus"></i> Add
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
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-magnifying-glass text-gray-500 text-xs"></i>
                            <input type="text" id="customSearchInput" placeholder="Search..." class="search-input" style="width:180px;">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Orders Table -->
            <div class="panel-card overflow-hidden">
                <div class="table-container">
                    <table id="ordersTable" class="display" style="width:100%;">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Received at</th>
                                <th>Site Name</th>
                                <th>JD code</th>
                                <th>Order #</th>
                                <th>Invoice #</th>
                                <th>Product</th>
                                <th>Order Quantity</th>
                                <th>Received Quantity</th>
                                <th>Shortage Quantity</th>
                                <th>Temperature</th>
                                <th>Density</th>
                                <th>File</th>
                                <th>Driver Sign</th>
                                <th>Dealer Sign</th>
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

    <!-- ============================================ -->
    <!-- OFFCANVAS OVERLAY                            -->
    <!-- ============================================ -->
    <div id="offcanvasOverlay" onclick="closeOffcanvas()"></div>

    <!-- ============================================ -->
    <!-- OFFCANVAS FORM (Create)                      -->
    <!-- ============================================ -->
    <div id="offcanvasForm">
        <!-- Header -->
        <div class="flex justify-between items-center p-4 border-b flex-shrink-0" style="border-color: var(--border-color);">
            <h3 id="offcanvasTitle" class="text-heading font-semibold tracking-wide text-sm">
                <i class="fa-solid fa-plus-circle mr-2 text-blue-500"></i>Add Sizes
            </h3>
            <button onclick="closeOffcanvas()" class="text-gray-400 hover:text-red-500 transition">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>

        <!-- Body -->
        <div class="flex-1 overflow-y-auto p-4">
            <form id="insert_form" enctype="multipart/form-data">
                <div class="form-group">
                    <label class="form-label">Sizes</label>
                    <input type="number" class="form-input" id="name" name="name" placeholder="Enter Sizes" required>
                </div>
                <div class="col-12">
                    <input type="hidden" name="row_id" id="row_id" value="0">
                    <input type="hidden" name="user_id" id="user_id" value="1">
                    <div class="mb-3 row">
                        <label for="example-text-input" class="col-md-10 col-form-label"></label>
                        <div class="col-md-12 text-center">
                            <input class="btn-primary w-full" type="submit" name="insert" id="insert" value="Save">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#customSearchInput').on('keyup', function() {
                if ($.fn.DataTable.isDataTable('#ordersTable')) {
                    $('#ordersTable').DataTable().search($(this).val()).draw();
                }
            });

            // Offcanvas Form Submit
            $('#insert_form').on("submit", function(event) {
                event.preventDefault();
                var update_id = $('#row_id').val();

                if (update_id == 0) {
                    var data = new FormData(this);
                    $.ajax({
                        url: "api/create/create_containers_sizes.php",
                        cache: false,
                        contentType: false,
                        processData: false,
                        method: "POST",
                        data: data,
                        beforeSend: function() {
                            $('#insert').val("Saving...");
                            document.getElementById("insert").disabled = true;
                        },
                        success: function(data) {
                            console.log(data)
                            if (data != 1) {
                                Swal.fire('Server Error!', 'Record Not Created', 'error');
                                $('#insert').val("Save");
                                document.getElementById("insert").disabled = false;
                            } else {
                                setTimeout(function() {
                                    Swal.fire('Success!', 'Record Created Successfully', 'success');
                                    $('#insert_form')[0].reset();
                                    closeOffcanvas();
                                    fetchtable();
                                    $('#insert').val("Save");
                                    document.getElementById("insert").disabled = false;
                                    location.reload();
                                }, 2000);
                            }
                        }
                    });
                } else {
                    var data = new FormData(this);
                    $.ajax({
                        url: "api/update/container_size.php",
                        cache: false,
                        contentType: false,
                        processData: false,
                        method: "POST",
                        data: data,
                        beforeSend: function() {
                            $('#insert').val("Saving...");
                            document.getElementById("insert").disabled = true;
                        },
                        success: function(data) {
                            console.log(data)
                            if (data != 1) {
                                Swal.fire('Server Error!', 'Record Not Updated', 'error');
                                $('#insert').val("Save");
                                document.getElementById("insert").disabled = false;
                            } else {
                                setTimeout(function() {
                                    Swal.fire('Success!', 'Record Updated Successfully', 'success');
                                    $('#insert_form')[0].reset();
                                    closeOffcanvas();
                                    fetchtable();
                                    $('#insert').val("Save");
                                    document.getElementById("insert").disabled = false;
                                    location.reload();
                                }, 2000);
                            }
                        }
                    });
                }
            });

            fetchtable();

            $(document).on('click', function(e) {
                if (!$(e.target).closest('.column-visibility-dropdown').length) {
                    closeColumnDropdown();
                }
            });
        });

        const API_BASE_URL = 'api/';

        let ordersDataTable = null;

        const columnConfig = [
            { idx: 0, label: 'S.No' },
            { idx: 1, label: 'Received at' },
            { idx: 2, label: 'Site Name' },
            { idx: 3, label: 'JD code' },
            { idx: 4, label: 'Order #' },
            { idx: 5, label: 'Invoice #' },
            { idx: 6, label: 'Product' },
            { idx: 7, label: 'Order Quantity' },
            { idx: 8, label: 'Received Quantity' },
            { idx: 9, label: 'Shortage Quantity' },
            { idx: 10, label: 'Temperature' },
            { idx: 11, label: 'Density' },
            { idx: 12, label: 'File' },
            { idx: 13, label: 'Driver Sign' },
            { idx: 14, label: 'Dealer Sign' }
        ];

        function showToast(message, type = 'success') {
            const toast = $('#toast');
            $('#toastMessage').text(message);
            toast.removeClass('success error').addClass(type);
            toast.addClass('show');
            clearTimeout(window.toastTimeout);
            window.toastTimeout = setTimeout(() => toast.removeClass('show'), 3000);
        }

        function openCreateOffcanvas() {
            $('#row_id').val("0");
            $('#insert_form')[0].reset();
            $('#offcanvasOverlay').addClass('active');
            $('#offcanvasForm').addClass('active');
            $('body').addClass('offcanvas-open');
        }

        function openEditOffcanvas(id) {
            var settings = {
                "url": API_BASE_URL + "get/get_container_sizes.php?key=03201232927&id=" + id + "",
                "method": "GET",
                "timeout": 0,
            };

            $.ajax({
                ...settings,
                statusCode: {
                    200: function(response) {
                        $('#row_id').val(response[0]['id']);
                        $('#name').val(response[0]['sizes']);
                    }
                }
            });

            $('#offcanvasOverlay').addClass('active');
            $('#offcanvasForm').addClass('active');
            $('body').addClass('offcanvas-open');
        }

        function closeOffcanvas() {
            $('#offcanvasOverlay').removeClass('active');
            $('#offcanvasForm').removeClass('active');
            $('body').removeClass('offcanvas-open');
        }

        function deleteData(id) {
            var settings = {
                "url": API_BASE_URL + "delete/delete_container_size.php?key=03201232927&id=" + id + "",
                "method": "GET",
                "timeout": 0,
            };

            $.ajax({
                ...settings,
                statusCode: {
                    200: function(response) {
                        Swal.fire('Success!', 'Record Deleted Successfully', 'success');
                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        Swal.fire('Server Error!', 'Record Not Deleted', 'error');
                    }
                }
            });
        }

        // Safely parse the product_json field returned by the API.
        // Some records come back from the backend with a truncated / malformed
        // JSON string (missing closing quote or bracket), which previously
        // caused "Unterminated string in JSON" to be thrown from JSON.parse.
        // This helper validates the value before parsing and never throws,
        // so a bad record no longer produces a console error - it just falls
        // back to blank/default values for that single row, exactly like before.
        function safeParseProductJson(product_json) {
            if (!product_json) return null;

            // Some API responses may already return an object/array instead of a string.
            if (typeof product_json === 'object') {
                return product_json;
            }

            if (typeof product_json !== 'string') return null;

            var trimmed = product_json.trim();
            if (trimmed.length === 0) return null;

            // Quick sanity check: valid JSON for this field must start with [ or {
            // and end with the matching closing bracket. If it doesn't, the string
            // is truncated/corrupted and attempting to parse it would only throw.
            var startsOk = trimmed.charAt(0) === '[' || trimmed.charAt(0) === '{';
            var endsOk = trimmed.charAt(trimmed.length - 1) === ']' || trimmed.charAt(trimmed.length - 1) === '}';
            if (!startsOk || !endsOk) {
                return null;
            }

            try {
                return JSON.parse(trimmed);
            } catch (e) {
                // Malformed JSON for this particular record - skip quietly and
                // let the row fall back to default/blank values.
                return null;
            }
        }

        function fetchtable() {
            var rettypes = "CO ";

            $('#ordersTable tbody').html(`
                <tr>
                    <td colspan="15" class="text-center py-8 text-gray-500">
                        <i class="fa-solid fa-spinner fa-spin text-blue-400 mr-2"></i>
                        Loading orders...
                    </td>
                </tr>
            `);

            $.ajax({
                url: API_BASE_URL + 'get/get_all_orders_shortage.php?key=03201232927&id=1&rettype=' + rettypes,
                type: 'GET',
                dataType: 'json',
                timeout: 30000,
                success: function(response) {
                    if (response && Array.isArray(response) && response.length > 0) {
                        const allRows = [];
                        $.each(response, function(index, data) {
                            var product_name = '';
                            var Density = '';
                            var quantity = 0;
                            var quantity_less_L = 0;
                            var quantity_rec_L = 0;
                            var temperature = '';

                            var jsonData = safeParseProductJson(data.product_json);
                            if (jsonData && jsonData.length > 0) {
                                product_name = jsonData[0].product_name || '';
                                Density = jsonData[0].Density || '';
                                quantity = jsonData[0].quantity || 0;
                                quantity_less_L = jsonData[0].quantity_less_L || 0;
                                quantity_rec_L = jsonData[0].quantity_rec_L || 0;
                                temperature = jsonData[0].temperature || '';
                            }

                            var fileLink = data.file ? 
                                `<a href="api/uploads/${data.file}" target="_blank" class="text-blue-500 hover:underline text-xs">View File</a>` : 
                                'N/A';
                            
                            var signLink = data.sign ? 
                                `<a href="api/uploads/${data.sign}" target="_blank" class="text-blue-500 hover:underline text-xs">View File</a>` : 
                                'N/A';
                            
                            var dealerSignLink = data.dealer_sign ? 
                                `<a href="api/uploads/${data.dealer_sign}" target="_blank" class="text-blue-500 hover:underline text-xs">View File</a>` : 
                                'N/A';

                            var row = [
                                index + 1,
                                data.created_at || '',
                                data.customer_name || '',
                                data.customer_id || '',
                                data.order_id || '',
                                data.invoice_no || '',
                                product_name,
                                parseFloat(quantity).toLocaleString(),
                                parseFloat(quantity_rec_L).toLocaleString(),
                                parseFloat(quantity_less_L).toLocaleString(),
                                temperature || '',
                                Density || '',
                                fileLink,
                                signLink,
                                dealerSignLink
                            ];
                            allRows.push(row);
                        });

                        initializeDataTable(allRows);
                    } else {
                        showToast('No shortage orders found.', 'error');
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
                    { title: 'Received at' },
                    { title: 'Site Name' },
                    { title: 'JD code' },
                    { title: 'Order #' },
                    { title: 'Invoice #' },
                    { title: 'Product' },
                    { title: 'Order Quantity' },
                    { title: 'Received Quantity' },
                    { title: 'Shortage Quantity' },
                    { title: 'Temperature' },
                    { title: 'Density' },
                    { title: 'File', orderable: false, searchable: false },
                    { title: 'Driver Sign', orderable: false, searchable: false },
                    { title: 'Dealer Sign', orderable: false, searchable: false }
                ],
                dom: 'Bfrtip',
                buttons: [
                    { extend: 'copy', text: '<i class="fa-regular fa-copy"></i> Copy', className: 'toolbar-btn', exportOptions: { columns: [0,1,2,3,4,5,6,7,8,9,10,11] } },
                    { extend: 'excelHtml5', text: '<i class="fa-regular fa-file-excel"></i> Excel', className: 'toolbar-btn', exportOptions: { columns: [0,1,2,3,4,5,6,7,8,9,10,11] }, title: 'Order_Shortage' },
                    { extend: 'csvHtml5', text: '<i class="fa-regular fa-file-csv"></i> CSV', className: 'toolbar-btn', exportOptions: { columns: [0,1,2,3,4,5,6,7,8,9,10,11] }, title: 'Order_Shortage' },
                    { extend: 'pdfHtml5', text: '<i class="fa-regular fa-file-pdf"></i> PDF', className: 'toolbar-btn', exportOptions: { columns: [0,1,2,3,4,5,6,7,8,9,10,11] }, title: 'Order Shortage', orientation: 'landscape', pageSize: 'A4' },
                    { extend: 'print', text: '<i class="fa-solid fa-print"></i> Print', className: 'toolbar-btn', exportOptions: { columns: [0,1,2,3,4,5,6,7,8,9,10,11] } }
                ],
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100],
                ordering: true,
                order: [[0, 'asc']],
                language: {
                    emptyTable: '<div class="text-center py-8 text-gray-500"><i class="fa-solid fa-triangle-exclamation text-2xl block mb-2"></i>No shortage orders found</div>',
                    info: 'Showing _START_ to _END_ of _TOTAL_ entries',
                    infoEmpty: 'Showing 0 to 0 of 0 entries',
                    infoFiltered: '(filtered from _MAX_ total entries)'
                },
                drawCallback: function() {
                    $('.dt-buttons .dt-button').addClass('toolbar-btn');
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

        $(document).on('keydown', function(e) {
            if (e.key === 'Escape') {
                closeOffcanvas();
                closeColumnDropdown();
            }
        });

        $(document).on('click', '#offcanvasOverlay', function(e) {
            if (e.target === this) {
                closeOffcanvas();
            }
        });
    </script>

</body>

</html>