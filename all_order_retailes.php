<?php
// Hascol OMC - Retailers Orders Management
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Retailers Orders Management</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Google Fonts -->
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

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Select2 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <!-- CryptoJS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/crypto-js.js"></script>

    <!-- Flatpickr -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <!-- Dark mode init -->
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

    <style>
        /* Theme variables */
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
            font-size: 12px;
        }

        .text-heading { color: var(--text-heading) !important; }

        .panel-card {
            background-color: var(--bg-panel);
            border: 1px solid var(--border-color);
            border-radius: 0.375rem;
            transition: background-color .25s ease, border-color .25s ease;
        }

        .table-container { overflow-x: auto; }

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

        .table-container table tbody tr:hover { background-color: var(--table-row-hover); }

        .badge {
            padding: 2px 10px;
            border-radius: 9999px;
            font-size: 9px;
            font-weight: 600;
            display: inline-block;
        }

        .badge-pending { background: #3b82f620; color: #3b82f6; border: 1px solid #3b82f640; }
        .badge-approved { background: #10b98120; color: #10b981; border: 1px solid #10b98140; }
        .badge-blocked { background: #ef444420; color: #ef4444; border: 1px solid #ef444440; }
        .badge-special { background: #8b5cf620; color: #8b5cf6; border: 1px solid #8b5cf640; }
        .badge-released { background: #f59e0b20; color: #f59e0b; border: 1px solid #f59e0b40; }
        .badge-forwarded { background: #06b6d420; color: #06b6d4; border: 1px solid #06b6d440; }
        .badge-processed { background: #ec489920; color: #ec4899; border: 1px solid #ec489940; }

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

        .form-input::placeholder { color: var(--text-muted); }

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

        .form-select option { background-color: var(--bg-panel); color: var(--text-body); }

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

        .btn-primary:hover { background-color: #2563eb; }

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

        /* DataTables Search Input Styling */
        #dataTableSearchContainer { display: inline-flex; align-items: center; }
        #dataTableSearchContainer .dataTables_filter { margin: 0 !important; float: none !important; }
        #dataTableSearchContainer .dataTables_filter label { display: flex !important; align-items: center !important; margin: 0 !important; color: var(--text-muted); font-size: 11px; font-weight: 500; white-space: nowrap; }
        #dataTableSearchContainer .dataTables_filter input {
            background-color: var(--input-bg);
            border: 1px solid var(--border-color);
            border-radius: 0.25rem;
            color: var(--text-body);
            padding: 6px 10px;
            font-size: 12px;
            outline: none;
            height: 30px;
            width: 180px;
            margin-left: 0 !important;
        }
        #dataTableSearchContainer .dataTables_filter input::placeholder { color: var(--text-muted); }
        #dataTableSearchContainer .dataTables_filter input:focus { border-color: #1d4ed8; box-shadow: 0 0 0 2px rgba(29, 78, 216, 0.2); }

        /* DataTables Buttons */
        .dt-buttons { display: flex !important; gap: 6px !important; flex-wrap: wrap !important; }
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
        .dt-buttons .dt-button:hover { background-color: var(--hover-bg) !important; color: var(--text-heading) !important; }

        /* Toolbar Layout */
        .toolbar-row { display: flex; align-items: center; justify-content: space-between; gap: 10px; flex-wrap: nowrap; width: 100%; }
        .toolbar-left { display: flex; align-items: center; gap: 6px; flex-wrap: wrap; min-width: 0; }
        .toolbar-right { display: flex; align-items: center; gap: 8px; flex-wrap: nowrap; flex-shrink: 0; }
        .toolbar-right .form-select { height: 30px; padding: 4px 28px 4px 10px; box-sizing: border-box; min-width: 120px; }

        /* Modal Styles */
        .modal-overlay {
            position: fixed;
            inset: 0;
            z-index: 50;
            background: var(--modal-overlay);
            backdrop-filter: blur(4px);
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .modal-overlay.active { opacity: 1; visibility: visible; }
        .modal-content {
            background-color: var(--bg-panel);
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35);
            max-width: 600px;
            width: 92%;
            max-height: 90vh;
            overflow-y: auto;
            transform: scale(0.95);
            transition: transform 0.3s ease;
        }
        .modal-overlay.active .modal-content { transform: scale(1); }

        /* Column Visibility Dropdown */
        .column-visibility-dropdown { position: relative; display: inline-block; flex-shrink: 0; }
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
            height: 30px;
            box-sizing: border-box;
            white-space: nowrap;
        }
        .column-visibility-dropdown .dropdown-btn:hover { background-color: var(--hover-bg); color: var(--text-heading); }
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
        .column-visibility-dropdown .dropdown-menu.show { display: block; }
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
        .column-visibility-dropdown .dropdown-menu .dropdown-item:hover { background-color: var(--dropdown-hover); }
        .column-visibility-dropdown .dropdown-menu .dropdown-item input[type="checkbox"] { width: 14px; height: 14px; cursor: pointer; accent-color: #1d4ed8; flex-shrink: 0; }
        .column-visibility-dropdown .dropdown-menu .dropdown-divider { height: 1px; background-color: var(--border-color); margin: 4px 8px; }
        .column-visibility-dropdown .dropdown-menu .dropdown-actions { display: flex; gap: 6px; padding: 6px 14px 4px 14px; border-top: 1px solid var(--border-color); margin-top: 4px; padding-top: 8px; }
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
        .column-visibility-dropdown .dropdown-menu .dropdown-actions button:hover { background: var(--hover-bg); color: var(--text-heading); }

        /* Toast Notification */
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
        .toast.show { transform: translateY(0); opacity: 1; }
        .toast.success { border-color: #10b981; }
        .toast.error { border-color: #ef4444; }

        /* Flatpickr Input Styling */
        .flatpickr-input-wrapper { position: relative; }
        .flatpickr-input-wrapper .form-input { padding-right: 32px; }
        .flatpickr-input-wrapper .flatpickr-icon { position: absolute; right: 10px; top: 50%; transform: translateY(-50%); color: var(--text-muted); pointer-events: none; font-size: 14px; }
        html.dark-mode .flatpickr-input-wrapper .flatpickr-icon { color: #94a3b8; }
    </style>
</head>

<body class="flex h-screen overflow-hidden text-xs">

    <?php include 'includes/sidebar.php'; ?>

    <main id="mainContent" class="flex-1 flex flex-col overflow-hidden">

        <?php include 'includes/topbar.php'; ?>

        <div class="flex-1 overflow-y-auto p-4" id="pageContent">

            <div class="flex justify-between items-center mb-4">
                <div>
                    <h2 class="text-heading font-semibold text-base tracking-wide">Retailers Orders Management</h2>
                    <p class="text-[10px] text-gray-500">View and manage all retailers orders</p>
                </div>
            </div>

            <div class="panel-card p-3 mb-4">
                <div class="flex flex-wrap items-end gap-3">
                    <div>
                        <label class="form-label text-[10px]">From Date</label>
                        <div class="flatpickr-input-wrapper">
                            <input type="text" id="fromdate" class="form-input text-xs datepicker"
                                placeholder="Select From Date" style="width:180px;">
                            <i class="fa-regular fa-calendar flatpickr-icon"></i>
                        </div>
                    </div>
                    <div>
                        <label class="form-label text-[10px]">To Date</label>
                        <div class="flatpickr-input-wrapper">
                            <input type="text" id="todate" class="form-input text-xs datepicker"
                                placeholder="Select To Date" style="width:180px;">
                            <i class="fa-regular fa-calendar flatpickr-icon"></i>
                        </div>
                    </div>
                    <button onclick="fetchOrders()" class="btn-primary text-xs px-4 py-2">
                        <i class="fa-solid fa-rotate-right mr-1"></i> Get
                    </button>
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
                        <div id="dataTableSearchContainer"></div>
                        <select id="statusFilter" class="form-select text-xs">
                            <option value="all">All Status</option>
                            <option value="0">Pending</option>
                            <option value="1">Approved</option>
                            <option value="2">Blocked</option>
                            <option value="3">Special Approval</option>
                            <option value="4">Released</option>
                            <option value="5">Forwarded</option>
                            <option value="6">Processed</option>
                        </select>
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
                                <th>Vehicle</th>
                                <th>Total Amount</th>
                                <th>Ledger Amount</th>
                                <th>Status</th>
                                <th>Push Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="12" class="text-center py-8 text-gray-500">
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
        <span id="toastMessage">Operation successful!</span>
    </div>

    <div id="approvedOrdersModal" class="fixed inset-0 z-50 hidden backdrop-blur-sm flex items-center justify-center transition-opacity duration-300 opacity-0">
        <div class="panel-card border rounded-lg shadow-2xl w-full max-w-md transform scale-95 transition-transform duration-300">
            <div class="flex justify-between items-center p-4 border-b" style="border-color: var(--border-color);">
                <h3 class="text-heading font-semibold text-sm">Approved Orders</h3>
                <button onclick="closeApprovedOrdersModal()" class="text-gray-400 hover:text-red-500 transition">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>
            <form id="approvedOrdersForm" onsubmit="saveApprovedOrders(event)">
                <div class="p-4 space-y-4">
                    <input type="hidden" id="approvedOrderId" name="order_id">
                    
                    <div>
                        <label class="form-label">Name</label>
                        <select id="approvedName" name="name" class="form-select" required>
                            <option value="">Choose...</option>
                        </select>
                    </div>

                    <div>
                        <label class="form-label">Depot</label>
                        <select id="approvedDepot" name="depot" class="form-select" required>
                            <option value="">Choose...</option>
                        </select>
                    </div>

                    <div>
                        <label class="form-label">Description</label>
                        <textarea id="approvedDescription" name="description" rows="4" class="form-input" placeholder="" required></textarea>
                    </div>
                </div>
                <div class="flex gap-3 p-4 border-t" style="border-color: var(--border-color);">
                    <button type="button" onclick="closeApprovedOrdersModal()" class="btn-secondary flex-1">Close</button>
                    <button type="submit" class="btn-primary flex-1">Save changes</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleDarkMode() {
            const html = document.documentElement;
            const isDark = html.classList.toggle('dark-mode');
            localStorage.setItem('darkMode', isDark);
        }

        const API_BASE_URL = 'api/';

        let ordersData = [];
        let dataTable = null;
        let orderDetailTable = null;

        const columnConfig = [
            { idx: 0, label: 'S.No' },
            { idx: 1, label: 'Date' },
            { idx: 2, label: 'JD Code' },
            { idx: 3, label: 'Site Name' },
            { idx: 4, label: 'Site Depots' },
            { idx: 5, label: 'Depot' },
            { idx: 6, label: 'Type' },
            { idx: 7, label: 'Vehicle' },
            { idx: 8, label: 'Total Amount' },
            { idx: 9, label: 'Ledger Amount' },
            { idx: 10, label: 'Status' },
            { idx: 11, label: 'Push Status' }
        ];

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

        function loadDepots() {
            $.ajax({
                url: API_BASE_URL + 'get/geo_depot.php?key=03201232927',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    const nameSelect = $('#approvedName');
                    const depotSelect = $('#approvedDepot');
                    
                    nameSelect.empty().append('<option value="">Choose...</option>');
                    nameSelect.append($('<option>', { value: '5', text: 'Forward' }));
                    nameSelect.append($('<option>', { value: '2', text: 'Cancel' }));

                    depotSelect.empty().append('<option value="">Choose...</option>');
                    $.each(data, function(i, item) {
                        depotSelect.append($('<option>', { value: item.consignee_name, text: item.consignee_name }));
                    });
                },
                error: function() {
                    console.log('Failed to load depots');
                }
            });
        }

        function fetchOrders() {
            var fromdate = $('#fromdate').val();
            var todate = $('#todate').val();
            var rettypes = "RT";

            $('#ordersTable tbody').html(`
                <tr>
                    <td colspan="12" class="text-center py-8 text-gray-500">
                        <i class="fa-solid fa-spinner fa-spin text-blue-400 mr-2"></i>
                        Loading orders...
                    </td>
                </tr>
            `);

            var url = API_BASE_URL + 'get/get_all_app_orders.php?key=03201232927&pre=Admin&user_id=1&from=' + fromdate + '&to=' + todate + '&rettype=' + rettypes;

            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                timeout: 30000,
                success: function (response) {
                    if (response && Array.isArray(response)) {
                        ordersData = response;
                        initializeDataTable();
                    } else {
                        showToast('No orders found.', 'error');
                        ordersData = [];
                        initializeDataTable();
                    }
                },
                error: function (xhr, status, error) {
                    console.error('API Error:', status, error);
                    showToast('Failed to load orders. Please refresh the page.', 'error');
                    ordersData = [];
                    initializeDataTable();
                }
            });
        }

        function initializeDataTable() {
            if ($.fn.DataTable.isDataTable('#ordersTable')) {
                $('#ordersTable').DataTable().destroy();
            }

            var tableData = [];

            $.each(ordersData, function (index, order) {
                var statusValue = getStatusBadge(order);
                var pushStatus = getPushStatus(order);

                tableData.push([
                    index + 1,
                    order.created_at || '',
                    order.sap_no || '',
                    order.name || '',
                    order.dealers_depots || '',
                    order.depot || '',
                    order.type || '',
                    order.tl_no || '',
                    parseFloat(order.total_amount || 0).toLocaleString(),
                    getLedgerAmount(order),
                    statusValue,
                    pushStatus
                ]);
            });

            dataTable = $('#ordersTable').DataTable({
                data: tableData,
                columns: [
                    { title: 'S.No' },
                    { title: 'Date' },
                    { title: 'JD Code' },
                    { title: 'Site Name' },
                    { title: 'Site Depots' },
                    { title: 'Depot' },
                    { title: 'Type' },
                    { title: 'Vehicle' },
                    { title: 'Total Amount' },
                    { title: 'Ledger Amount' },
                    { title: 'Status', orderable: false, searchable: false },
                    { title: 'Push Status', orderable: false, searchable: false }
                ],
                dom: 'Bfrtip',
                buttons: [
                    { extend: 'copy', text: '<i class="fa-regular fa-copy"></i> Copy', className: 'toolbar-btn', exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11] } },
                    { extend: 'excelHtml5', text: '<i class="fa-regular fa-file-excel"></i> Excel', className: 'toolbar-btn', exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11] }, title: 'Retailers_Orders' },
                    { extend: 'csvHtml5', text: '<i class="fa-regular fa-file-csv"></i> CSV', className: 'toolbar-btn', exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11] }, title: 'Retailers_Orders' },
                    { extend: 'pdfHtml5', text: '<i class="fa-regular fa-file-pdf"></i> PDF', className: 'toolbar-btn', exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11] }, title: 'Retailers Orders', orientation: 'landscape', pageSize: 'A4' },
                    { extend: 'print', text: '<i class="fa-solid fa-print"></i> Print', className: 'toolbar-btn', exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11] } }
                ],
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100],
                ordering: true,
                order: [[0, 'asc']],
                language: {
                    emptyTable: '<div class="text-center py-8 text-gray-500"><i class="fa-solid fa-box-open text-2xl block mb-2"></i>No orders found</div>',
                    info: 'Showing _START_ to _END_ of _TOTAL_ entries',
                    infoEmpty: 'Showing 0 to 0 of 0 entries',
                    infoFiltered: '(filtered from _MAX_ total entries)',
                    search: '',
                    searchPlaceholder: 'Search orders...'
                },
                drawCallback: function () {
                    $('.dt-buttons .dt-button').each(function () {
                        $(this).addClass('toolbar-btn');
                    });
                },
                initComplete: function () {
                    const buttonsContainer = $('#exportButtonsContainer');
                    $('.dt-buttons').appendTo(buttonsContainer);
                    $('#dataTableSearchContainer').empty().append($('.dataTables_filter'));
                    populateColumnDropdown();
                }
            });

            applyFilters();
        }

        function getStatusBadge(order) {
            var status = parseInt(order.status);
            var statusValue = '';

            if (status == 0) {
                statusValue = '<span class="badge badge-pending">Pending</span>';
            } else if (status == 1) {
                statusValue = '<span class="badge badge-approved">Approved</span>';
            } else if (status == 2) {
                statusValue = '<span class="badge badge-blocked">Blocked</span>';
            } else if (status == 3) {
                statusValue = '<span class="badge badge-special">Special Approval</span>';
            } else if (status == 4) {
                statusValue = '<span class="badge badge-released">Released</span>';
            } else if (status == 5) {
                statusValue = '<span class="badge badge-forwarded">Forwarded</span>';
            } else if (status == 6) {
                statusValue = '<span class="badge badge-processed">Processed</span>';
            }
            return statusValue;
        }

        function getLedgerAmount(order) {
            var rettypeDesc = $.trim(order.rettype_desc || '');
            if (rettypeDesc == 'COCO site') {
                return '---';
            } else {
                return parseFloat(order.legder_balance || 0).toLocaleString();
            }
        }

        function getPushStatus(order) {
            if (parseInt(order.status) == 6) {
                return '<button type="button" onclick="openApprovedOrdersModal(' + order.id + ')"><i class="fa-solid fa-align-justify"></i></button>';
            } else {
                return order.status_value || '';
            }
        }

        function openApprovedOrdersModal(orderId) {
            $('#approvedOrderId').val(orderId);
            $('#approvedDescription').val('');
            
            $('#approvedOrdersModal').removeClass('hidden').addClass('flex');
            setTimeout(function() {
                $('#approvedOrdersModal').removeClass('opacity-0');
                $('#approvedOrdersModal .transform').removeClass('scale-95').addClass('scale-100');
            }, 10);
        }

        function closeApprovedOrdersModal() {
            $('#approvedOrdersModal').addClass('opacity-0');
            $('#approvedOrdersModal .transform').removeClass('scale-100').addClass('scale-95');
            setTimeout(function() {
                $('#approvedOrdersModal').addClass('hidden').removeClass('flex');
            }, 300);
        }

        function saveApprovedOrders(event) {
            event.preventDefault();
            const formData = new FormData(document.getElementById('approvedOrdersForm'));
            
            console.log("Data Saving:", Object.fromEntries(formData));
            
            showToast('Saved successfully!', 'success');
            closeApprovedOrdersModal();
        }

        $(document).on('click', '#approvedOrdersModal', function(e) {
            if (e.target === this) {
                closeApprovedOrdersModal();
            }
        });

        $(document).on('keydown', function(e) {
            if (e.key === 'Escape') {
                closeApprovedOrdersModal();
                closeColumnDropdown();
            }
        });

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
                showToast('Error selecting columns', 'error');
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
                showToast('Error deselecting columns', 'error');
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
            $('#columnDropdownMenu').removeClass('show');
        }

        function applyFilters() {
            const status = $('#statusFilter').val();

            if (status !== 'all') {
                dataTable.column(10).search('').draw();

                var statusText = '';
                if (status == '0') statusText = 'Pending';
                else if (status == '1') statusText = 'Approved';
                else if (status == '2') statusText = 'Blocked';
                else if (status == '3') statusText = 'Special Approval';
                else if (status == '4') statusText = 'Released';
                else if (status == '5') statusText = 'Forwarded';
                else if (status == '6') statusText = 'Processed';

                if (statusText) {
                    dataTable.column(10).search(statusText).draw();
                }
            } else {
                dataTable.column(10).search('').draw();
            }
        }

        $(document).on('click', function (e) {
            if (!$(e.target).closest('.column-visibility-dropdown').length) {
                closeColumnDropdown();
            }
        });

        $(document).ready(function () {
            const today = new Date();
            
            const fromDateStr = today.getFullYear() + '-' + 
                                String(today.getMonth() + 1).padStart(2, '0') + '-' + 
                                String(today.getDate()).padStart(2, '0');
            
            const nextMonth = new Date(today.getFullYear(), today.getMonth() + 1, 1);
            const toDateStr = nextMonth.getFullYear() + '-' + 
                              String(nextMonth.getMonth() + 1).padStart(2, '0') + '-' + 
                              String(nextMonth.getDate()).padStart(2, '0');

            const datePickerConfig = {
                dateFormat: "Y-m-d",
                allowInput: true,
                altInput: true,
                altFormat: "F j, Y",
                disableMobile: true,
                locale: { firstDayOfWeek: 1 }
            };

            const fromPicker = flatpickr("#fromdate", {
                ...datePickerConfig,
                defaultDate: fromDateStr,
                onChange: function (selectedDates, dateStr, instance) {
                    if (dateStr) { toPicker.set('minDate', dateStr); }
                }
            });

            const toPicker = flatpickr("#todate", {
                ...datePickerConfig,
                defaultDate: toDateStr,
                onChange: function (selectedDates, dateStr, instance) {
                    if (dateStr) { fromPicker.set('maxDate', dateStr); }
                }
            });

            window.fromPicker = fromPicker;
            window.toPicker = toPicker;

            fromPicker.set('maxDate', toDateStr);
            toPicker.set('minDate', fromDateStr);

            $('#statusFilter').on('change', function () {
                applyFilters();
            });

            loadDepots();
            fetchOrders();
        });
    </script>

</body>

</html>