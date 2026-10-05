<?php
// Hascol OMC - All Retail Pending App Orders
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Pending Retailers App Orders</title>

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

    <!-- Dark Mode Init -->
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
            --modal-overlay: rgba(15, 23, 42, 0.45);
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
            --modal-overlay: rgba(6, 11, 19, 0.85);
            --toolbar-btn-bg: #060b13;
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
            cursor: pointer;
        }
        .badge.bg-primary { background: #1d4ed8; color: #ffffff; }
        .badge.bg-info { background: #06b6d4; color: #ffffff; }
        .badge.bg-danger { background: #ef4444; color: #ffffff; }
        .badge.bg-dark { background: #1f2937; color: #ffffff; }
        .badge.bg-warning { background: #f59e0b; color: #000000; }
        .badge.bg-success { background: #10b981; color: #ffffff; }

        .button-soft-danger {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            border: none;
            padding: 4px 8px;
            border-radius: 0.25rem;
            cursor: pointer;
            transition: all 0.2s;
        }
        .button-soft-danger:hover { background: rgba(239, 68, 68, 0.2); }

        /* Toolbar Styling */
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
        .dt-buttons .dt-button:hover { background-color: var(--hover-bg) !important; color: var(--text-heading) !important; }

        /* DataTable Search */
        #dataTableSearchContainer {
            display: inline-flex;
            align-items: center;
        }
        #dataTableSearchContainer .dataTables_filter {
            margin: 0 !important;
            float: none !important;
        }
        #dataTableSearchContainer .dataTables_filter label {
            display: flex !important;
            align-items: center !important;
            gap: 8px;
            margin: 0 !important;
            color: var(--text-muted);
            font-size: 11px;
            font-weight: 500;
            white-space: nowrap;
        }
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
            transition: all 0.2s;
            margin-left: 0 !important;
        }
        #dataTableSearchContainer .dataTables_filter input::placeholder { color: var(--text-muted); }
        #dataTableSearchContainer .dataTables_filter input:focus { border-color: #1d4ed8; box-shadow: 0 0 0 2px rgba(29, 78, 216, 0.2); }

        /* Column Visibility Dropdown */
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
            background-color: var(--toolbar-btn-bg);
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
        .column-visibility-dropdown .dropdown-menu .dropdown-item:hover { background-color: var(--hover-bg); }
        .column-visibility-dropdown .dropdown-menu .dropdown-item input[type="checkbox"] {
            width: 14px;
            height: 14px;
            cursor: pointer;
            accent-color: #1d4ed8;
            flex-shrink: 0;
        }
        .dropdown-divider { height: 1px; background-color: var(--border-color); margin: 4px 8px; }
        .dropdown-actions {
            display: flex;
            gap: 6px;
            padding: 6px 14px 4px 14px;
            border-top: 1px solid var(--border-color);
            margin-top: 4px;
            padding-top: 8px;
        }
        .dropdown-actions button {
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
        .dropdown-actions button:hover { background: var(--hover-bg); color: var(--text-heading); }
        .dropdown-actions button.select-all-btn { border-color: #10b981; color: #10b981; }
        .dropdown-actions button.select-all-btn:hover { background: #10b98115; }
        .dropdown-actions button.deselect-all-btn { border-color: #ef4444; color: #ef4444; }
        .dropdown-actions button.deselect-all-btn:hover { background: #ef444415; }

        /* Forms & Buttons */
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

        /* Modal Styling */
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
        .form-select:focus { outline: none; border-color: #1d4ed8; box-shadow: 0 0 0 2px rgba(29, 78, 216, 0.2); }
        .form-input {
            background-color: var(--input-bg);
            border: 1px solid var(--border-color);
            border-radius: 0.25rem;
            color: var(--text-body);
            padding: 6px 10px;
            width: 100%;
            font-size: 12px;
        }
        .form-input:focus { outline: none; border-color: #1d4ed8; box-shadow: 0 0 0 2px rgba(29, 78, 216, 0.2); }

        /* Toast */
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
    </style>
</head>

<body class="flex h-screen overflow-hidden text-xs">

    <?php include 'includes/sidebar.php'; ?>

    <main id="mainContent" class="flex-1 flex flex-col overflow-hidden">

        <?php include 'includes/topbar.php'; ?>

        <div class="flex-1 overflow-y-auto p-4" id="pageContent">

            <div class="flex justify-between items-center mb-4">
                <div>
                    <h2 class="text-heading font-semibold text-base tracking-wide">All Pending Retailers App Orders</h2>
                    <p class="text-[10px] text-gray-500">View and manage all pending retailers orders</p>
                </div>
            </div>

            <!-- DataTable Toolbar (Search, Export, Columns) -->
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
                    </div>
                </div>
            </div>

            <!-- DataTable -->
            <div class="panel-card overflow-hidden">
                <div class="table-container">
                    <table id="myTable" class="display" style="width:100%;">
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
                        <tbody></tbody>
                    </table>
                </div>
            </div>

        </div>

        <?php include 'includes/footer.php'; ?>

    </main>

    <!-- Toast Notification -->
    <div id="toast" class="toast">
        <i class="fa-solid fa-check-circle mr-2"></i>
        <span id="toastMessage">Operation successful!</span>
    </div>

    <!-- Approved Order Modal -->
    <div id="approved_order_modal" class="modal-overlay">
        <div class="modal-content p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-heading font-semibold text-sm">Approved Orders</h3>
                <button type="button" class="text-gray-400 hover:text-red-500" onclick="closeModal('approved_order_modal')">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>
            <form id="approved_orders">
                <div class="space-y-4">
                    <div>
                        <label class="form-label">Name</label>
                        <select id="approved_order_status" name="approved_order_status" class="form-select" required>
                            <option value="">Choose...</option>
                            <option value="5">Forward</option>
                            <option value="2">Cancel</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Depot</label>
                        <select id="s_depot" name="s_depot" class="form-select" required>
                            <option value="">Choose...</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Description</label>
                        <textarea id="approved_order_description" name="approved_order_description" rows="4" class="form-input"></textarea>
                    </div>
                </div>
                <div class="flex gap-3 mt-4">
                    <input type="hidden" name="order_approval" id="order_approval">
                    <input type="hidden" name="user_id" id="user_id" value="1">
                    <button type="button" class="btn-primary flex-1 text-center" onclick="closeModal('approved_order_modal')">Close</button>
                    <input type="submit" class="btn-primary flex-1 text-center" value="Save changes">
                </div>
            </form>
        </div>
    </div>

    <!-- Insufficient Balance Modal -->
    <div id="in_balanced_order_modal" class="modal-overlay">
        <div class="modal-content p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-heading font-semibold text-sm">Insufficient Balance</h3>
                <button type="button" class="text-gray-400 hover:text-red-500" onclick="closeModal('in_balanced_order_modal')">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>
            <form id="ins_orders_update">
                <div class="space-y-4">
                    <div>
                        <label class="form-label">Action</label>
                        <select id="in_balanced_order" name="in_balanced_order" class="form-select" required>
                            <option value="">Choose...</option>
                            <option value="2">Block Order</option>
                            <option value="3">Special Approval</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Description</label>
                        <textarea id="in_balanced_description" name="in_balanced_description" rows="4" class="form-input"></textarea>
                    </div>
                </div>
                <div class="flex gap-3 mt-4">
                    <input type="hidden" name="spe_approval" id="spe_approval">
                    <input type="hidden" name="user_id" id="user_id" value="1">
                    <button type="button" class="btn-primary flex-1 text-center" onclick="closeModal('in_balanced_order_modal')">Close</button>
                    <input type="submit" class="btn-primary flex-1 text-center" value="Save changes">
                </div>
            </form>
        </div>
    </div>

    <!-- Order Backlog Modal -->
    <div id="order_backlog_modal" class="modal-overlay">
        <div class="modal-content p-6" style="max-width: 800px;">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-heading font-semibold text-sm">Order Backlog</h3>
                <button type="button" class="text-gray-400 hover:text-red-500" onclick="closeModal('order_backlog_modal')">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>
            <div id="order_logs" class="space-y-3"></div>
        </div>
    </div>

    <script>
        // Live API URLs
        const API_BASE_URL = 'api/';

        let table;
        let product_price_backlog;

        // Column Config
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

        function closeModal(id) {
            $('#' + id).removeClass('active');
        }

        function openModal(id) {
            $('#' + id).addClass('active');
        }

        // Column Visibility Functions
        function populateColumnDropdown() {
            const container = $('#columnListItems');
            container.empty();

            columnConfig.forEach(function (col) {
                let isVisible = true;
                try {
                    isVisible = table.column(col.idx).visible();
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
            if (!table) return;
            try {
                const isVisible = table.column(colIdx).visible();
                table.column(colIdx).visible(!isVisible);
                const checkbox = $(`#col-checkbox-${colIdx}`);
                checkbox.prop('checked', !isVisible);
            } catch (e) {
                console.warn('Column visibility toggle error:', e);
            }
        }

        function selectAllColumns() {
            if (!table) return;
            try {
                columnConfig.forEach(function(col) {
                    if (!table.column(col.idx).visible()) {
                        table.column(col.idx).visible(true);
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
            if (!table) return;
            try {
                columnConfig.forEach(function(col) {
                    if (table.column(col.idx).visible()) {
                        table.column(col.idx).visible(false);
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

        $(document).ready(function() {
            // Load Depots for Approved Modal
            fetch(API_BASE_URL + 'get/geo_depot.php?key=03201232927')
                .then(response => response.json())
                .then(response => {
                    $('#s_depot').empty().append('<option value="">Choose...</option>');
                    $.each(response, function(i, item) {
                        $('#s_depot').append('<option value="' + item.consignee_name + '">' + item.consignee_name + '</option>');
                    });
                })
                .catch(error => console.log('Error loading depots:', error));

            // Initialize Main DataTable
            table = $('#myTable').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    { extend: 'copy', text: '<i class="fa-regular fa-copy"></i> Copy', className: 'toolbar-btn', exportOptions: { columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14] } },
                    { extend: 'excelHtml5', text: '<i class="fa-regular fa-file-excel"></i> Excel', className: 'toolbar-btn', exportOptions: { columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14] }, title: 'All_Pending_Retailers_Orders' },
                    { extend: 'csvHtml5', text: '<i class="fa-regular fa-file-csv"></i> CSV', className: 'toolbar-btn', exportOptions: { columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14] }, title: 'All_Pending_Retailers_Orders' },
                    { extend: 'pdfHtml5', text: '<i class="fa-regular fa-file-pdf"></i> PDF', className: 'toolbar-btn', exportOptions: { columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14] }, title: 'All Pending Retailers Orders', orientation: 'landscape', pageSize: 'A4' },
                    { extend: 'print', text: '<i class="fa-solid fa-print"></i> Print', className: 'toolbar-btn', exportOptions: { columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14] } }
                ],
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100],
                language: {
                    search: '',
                    searchPlaceholder: 'Search orders...',
                    info: 'Showing _START_ to _END_ of _TOTAL_ entries',
                    infoEmpty: 'Showing 0 to 0 of 0 entries',
                    infoFiltered: '(filtered from _MAX_ total entries)'
                },
                initComplete: function () {
                    const buttonsContainer = $('#exportButtonsContainer');
                    $('.dt-buttons').appendTo(buttonsContainer);
                    $('#dataTableSearchContainer').empty().append($('.dataTables_filter'));
                }
            });

            // Close dropdown on outside click
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.column-visibility-dropdown').length) {
                    closeColumnDropdown();
                }
            });

            // Submit Approved Order
            $('#approved_orders').on("submit", function(event) {
                event.preventDefault();
                let data = new FormData(this);
                $.ajax({
                    url: API_BASE_URL + 'update/approved_orders.php',
                    cache: false,
                    contentType: false,
                    processData: false,
                    method: "POST",
                    data: data,
                    success: function(response) {
                        if (response != 1) {
                            Swal.fire('Server Error!', 'Record Not Updated', 'error');
                        } else {
                            Swal.fire('Success!', 'Record Updated Successfully', 'success');
                            $('#approved_orders')[0].reset();
                            closeModal('approved_order_modal');
                            fetchtable();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                        Swal.fire('Error!', 'There was an error processing your request', 'error');
                    }
                });
            });

            // Submit Insufficient Balance Order
            $('#ins_orders_update').on("submit", function(event) {
                event.preventDefault();
                let data = new FormData(this);
                $.ajax({
                    url: API_BASE_URL + 'update/send_special_approval.php',
                    cache: false,
                    contentType: false,
                    processData: false,
                    method: "POST",
                    data: data,
                    success: function(response) {
                        if (response != 1) {
                            Swal.fire('Server Error!', 'Record Not Updated', 'error');
                        } else {
                            Swal.fire('Success!', 'Record Updated Successfully', 'success');
                            $('#ins_orders_update')[0].reset();
                            closeModal('in_balanced_order_modal');
                            fetchtable();
                        }
                    },
                    error: function() {
                        Swal.fire('Error!', 'There was an error processing your request', 'error');
                    }
                });
            });

            // Open Approved Order Modal
            $(document).on('click', '.approved_check', function() {
                $('#order_approval').val($(this).attr("id"));
                openModal('approved_order_modal');
            });

            // Open Insufficient Balance Modal
            $(document).on('click', '.insuficient_check', function() {
                $('#spe_approval').val($(this).attr("id"));
                openModal('in_balanced_order_modal');
            });

            // Fetch Initial Data
            fetchtable();
        });

        function fetchtable() {
            let rettypes = "RT";

            fetch(API_BASE_URL + 'get/get_all_pending_app_orders.php?key=03201232927&pre=Admin&user_id=1&rettype=' + rettypes)
                .then(response => response.json())
                .then(response => {
                    table.clear().draw();
                    $.each(response, function(index, data) {
                        let status = data.status;
                        let status_value = '';
                        let ledger_balance = '';

                        if ($.trim(data.rettype_desc) == 'COCO site') {
                            ledger_balance = '---';
                            status_value = '---';
                        } else {
                            ledger_balance = parseFloat(data.legder_balance).toLocaleString();
                        }

                        if (status == 0) {
                            status_value = '<span id="' + data.id + '" class="badge bg-primary">Pending</span>';
                        } else if (status == 1) {
                            status_value = '<span id="' + data.id + '" class="badge bg-info">Approved</span>';
                        } else if (status == 2) {
                            status_value = '<span id="' + data.id + '" class="badge bg-danger">Blocked</span>';
                        } else if (status == 3) {
                            status_value = '<span id="' + data.id + '" class="badge bg-dark">Special Approval</span>';
                        } else if (status == 4) {
                            status_value = '<span id="' + data.id + '" class="badge bg-warning">Released</span>';
                        } else if (status == 5) {
                            status_value = '<span id="' + data.id + '" class="badge bg-success">Forwarded</span>';
                        } else if (status == 6) {
                            status_value = '<span id="' + data.id + '" class="badge bg-success">Processed</span>';
                        }

                        let push_status = '';
                        if (data.status != '6') {
                            push_status = data.status_value;
                        } else {
                            push_status = '<button type="button" id="' + data.id + '" class="button-soft-danger approved_check"><i class="fas fa-align-justify"></i></button>';
                        }

                        table.row.add([
                            index + 1,
                            data.created_at,
                            data.sap_no,
                            data.name,
                            data.dealers_depots,
                            data.depot,
                            data.type,
                            parseFloat(data.total_amount).toLocaleString(),
                            ledger_balance,
                            status_value,
                            push_status,
                            '',
                            '',
                            '',
                            '',
                        ]).draw(false);

                        // Fetch Sub Orders for Product Details
                        fetch(API_BASE_URL + 'get/get_main_sub_orders.php?key=03201232927&id=' + data.id)
                            .then(response => response.json())
                            .then(subOrders => {
                                if (subOrders.length > 0) {
                                    subOrders.forEach(subOrder => {
                                        table.row.add([
                                            '',
                                            subOrder.date,
                                            subOrder.sap_no,
                                            subOrder.name,
                                            '',
                                            '',
                                            '',
                                            '',
                                            '',
                                            '',
                                            '',
                                            subOrder.product_name,
                                            subOrder.rate,
                                            parseFloat(subOrder.quantity).toLocaleString(),
                                            parseFloat(subOrder.amount).toLocaleString(),
                                        ]).draw(false);
                                    });
                                }
                            })
                            .catch(error => console.log('Error fetching sub-orders:', error));
                    });
                })
                .catch(error => console.log('Error fetching data:', error));
        }

        function get_orders_log(id) {
            fetch(API_BASE_URL + 'get/get_order_backlog.php?key=03201232927&order_id=' + id)
                .then(response => response.json())
                .then(response => {
                    $('#order_logs').empty();
                    $.each(response, function(index, data) {
                        let status_value = data.status_value;
                        let dateObj = new Date(data.created_at);
                        let day = dateObj.getDate();
                        let month = dateObj.toLocaleString('en-US', { month: 'short' });

                        $('#order_logs').append(
                            '<div class="p-4 border rounded bg-light">' +
                                '<div class="flex justify-between items-center mb-2">' +
                                    '<h4 class="font-semibold text-sm">' + status_value + '</h4>' +
                                    '<span class="badge bg-primary">' + day + ' ' + month + '</span>' +
                                '</div>' +
                                '<p class="text-xs text-muted">Action By : ' + data.name + '</p>' +
                                '<p class="text-xs text-muted">Action Time : ' + data.created_at + '</p>' +
                            '</div>'
                        );
                    });
                    openModal('order_backlog_modal');
                })
                .catch(error => console.log('Error fetching logs:', error));
        }
    </script>

</body>
</html>