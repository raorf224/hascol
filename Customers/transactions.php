<?php
require_once __DIR__ . '/../session/session.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Transactions | Hascol Customer</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

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
            if (isDarkMode) document.documentElement.classList.add('dark-mode');
        })();
    </script>

    <script>
        tailwind.config = {
            theme: { extend: { fontFamily: { sans: ['Inter', 'sans-serif'] } } }
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
            --modal-overlay: rgba(6, 11, 19, .85);
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
        }

        .text-heading {
            color: var(--text-heading) !important;
        }

        .panel-card {
            background-color: var(--bg-panel);
            border: 1px solid var(--border-color);
            border-radius: 0.375rem;
        }

        .form-input {
            background-color: var(--input-bg);
            border: 1px solid var(--border-color);
            border-radius: 0.25rem;
            color: var(--text-body);
            padding: 6px 10px;
            width: 100%;
            font-size: 12px;
            box-sizing: border-box;
        }

        .form-input:focus {
            outline: none;
            border-color: #1d4ed8;
            box-shadow: 0 0 0 2px rgba(29, 78, 216, .2);
        }

        .form-input::placeholder {
            color: var(--text-muted);
        }

        select.form-input {
            appearance: none;
            -webkit-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 10px center;
            padding-right: 30px;
            cursor: pointer;
        }

        select.form-input option {
            background: var(--bg-panel);
            color: var(--text-body);
        }

        .form-label {
            color: var(--text-muted);
            font-size: 11px;
            font-weight: 500;
            margin-bottom: 4px;
            display: block;
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
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all .15s;
        }

        .btn-secondary:hover {
            background-color: var(--btn-secondary-hover-bg);
            color: var(--btn-secondary-hover-text);
        }

        .btn-secondary:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .btn-primary {
            background-color: #1d4ed8;
            color: #fff;
            padding: 8px 20px;
            border-radius: 0.25rem;
            border: none;
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: background-color .15s;
        }

        .btn-primary:hover {
            background-color: #2563eb;
        }

        .btn-primary:disabled {
            opacity: 0.6;
            cursor: not-allowed;
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
            letter-spacing: .5px;
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

        /* ============================================
           DataTables Wrapper Styling
           ============================================ */

        .dataTables_wrapper .dt-buttons {
            display: flex !important;
            gap: 6px !important;
            flex-wrap: wrap !important;
            margin: 0 0 10px 0 !important;
            float: left;
        }

        .dataTables_wrapper .dt-buttons .dt-button {
            padding: 6px 12px !important;
            background-color: var(--toolbar-btn-bg) !important;
            border: 1px solid var(--border-color) !important;
            border-radius: .25rem !important;
            color: var(--text-muted) !important;
            font-size: 10px !important;
            cursor: pointer !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 4px !important;
            height: 30px !important;
            box-sizing: border-box !important;
            font-family: 'Inter', sans-serif !important;
        }

        .dataTables_wrapper .dt-buttons .dt-button:hover {
            background-color: var(--hover-bg) !important;
            color: var(--text-heading) !important;
            box-shadow: none !important;
        }

        .dataTables_filter {
            margin: 0 !important;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .dataTables_filter label {
            color: var(--text-muted) !important;
            font-size: 11px !important;
            font-weight: 500 !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 6px !important;
            margin: 0 !important;
        }

        .dataTables_filter input {
            background-color: var(--input-bg) !important;
            border: 1px solid var(--border-color) !important;
            border-radius: 4px !important;
            color: var(--text-body) !important;
            padding: 5px 10px !important;
            font-size: 12px !important;
            height: 30px !important;
            width: 200px !important;
            outline: none !important;
            font-family: 'Inter', sans-serif !important;
            margin: 0 !important;
        }

        .dataTables_filter input:focus {
            border-color: #1d4ed8 !important;
            box-shadow: 0 0 0 2px rgba(29, 78, 216, .2) !important;
        }

        .dataTables_filter input::placeholder {
            color: var(--text-muted) !important;
        }

        .dataTables_wrapper .dataTables_info {
            color: var(--text-muted) !important;
            font-size: 11px !important;
            padding-top: 12px !important;
            clear: both;
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
            color: #fff !important;
            border-color: #1d4ed8 !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
            opacity: 0.5 !important;
            cursor: not-allowed !important;
        }

        .dataTables_wrapper::after {
            content: "";
            display: table;
            clear: both;
        }

        .table-toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 12px;
            padding: 0 4px;
        }

        .table-toolbar-left {
            display: flex;
            align-items: center;
            gap: 6px;
            flex-wrap: wrap;
        }

        .table-toolbar-right {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-shrink: 0;
        }

        .toast {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: var(--bg-panel);
            border: 1px solid var(--border-color);
            border-radius: .375rem;
            padding: 12px 20px;
            color: var(--text-body);
            font-size: 12px;
            z-index: 9999;
            transform: translateY(100px);
            opacity: 0;
            transition: all .3s ease-in-out;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .25);
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

        .tx-status {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 3px 9px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: 600;
        }

        .tx-successful {
            background: rgba(16, 185, 129, .12);
            color: #10b981;
            border: 1px solid rgba(16, 185, 129, .25);
        }

        .tx-pending {
            background: rgba(234, 179, 8, .15);
            color: #eab308;
            border: 1px solid rgba(234, 179, 8, .3);
        }

        .tx-failed {
            background: rgba(239, 68, 68, .12);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, .25);
        }

        .tx-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: currentColor;
        }

        .money-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: 600;
        }

        .money-amount {
            background: rgba(148, 163, 184, .15);
            color: #64748b;
        }

        .money-discount {
            background: rgba(234, 179, 8, .12);
            color: #eab308;
        }

        .money-final {
            background: rgba(16, 185, 129, .12);
            color: #10b981;
        }

        .cell-name {
            font-weight: 600;
            color: var(--text-heading);
            font-size: 11px;
        }

        .cell-sub {
            font-size: 9px;
            color: var(--text-muted);
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 10px;
            margin-bottom: 12px;
        }

        .summary-card {
            background: var(--bg-panel);
            border: 1px solid var(--border-color);
            border-radius: 6px;
            padding: 12px 14px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .summary-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }

        .summary-icon.blue {
            background: rgba(29, 78, 216, .12);
            color: #1d4ed8;
        }

        .summary-icon.green {
            background: rgba(16, 185, 129, .12);
            color: #10b981;
        }

        .summary-icon.yellow {
            background: rgba(234, 179, 8, .12);
            color: #eab308;
        }

        .summary-icon.purple {
            background: rgba(139, 92, 246, .12);
            color: #8b5cf6;
        }

        .summary-label {
            font-size: 10px;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: .5px;
            font-weight: 500;
        }

        .summary-value {
            font-size: 16px;
            font-weight: 700;
            color: var(--text-heading);
            margin-top: 2px;
        }

        .hidden {
            display: none !important;
        }

        @media (max-width: 768px) {
            .dataTables_filter input {
                width: 140px !important;
            }

            .dataTables_wrapper .dt-buttons {
                float: none;
                margin-bottom: 8px !important;
            }

            .dataTables_filter {
                justify-content: flex-start;
            }
        }
    </style>
</head>

<body class="flex h-screen overflow-hidden text-xs">

    <?php include __DIR__ . '/../includes/sidebar.php'; ?>

    <main id="mainContent" class="flex-1 flex flex-col overflow-hidden">

        <?php include __DIR__ . '/../includes/topbar.php'; ?>

        <div class="flex-1 overflow-y-auto p-4" id="pageContent">

            <div class="flex flex-wrap justify-between items-center mb-4 gap-2">
                <div>
                    <h2 class="text-heading font-semibold text-base tracking-wide uppercase">
                        <i class="fa-solid fa-receipt mr-2 text-blue-500"></i>Transactions
                    </h2>
                    <p class="text-[10px] text-gray-500">View transactions by dealer & customer</p>
                </div>
            </div>

            <div class="summary-grid">
                <div class="summary-card">
                    <div class="summary-icon blue"><i class="fa-solid fa-list"></i></div>
                    <div>
                        <div class="summary-label">Total Transactions</div>
                        <div class="summary-value" id="sumTotal">0</div>
                    </div>
                </div>
                <div class="summary-card">
                    <div class="summary-icon purple"><i class="fa-solid fa-money-bill-wave"></i></div>
                    <div>
                        <div class="summary-label">Total Amount</div>
                        <div class="summary-value" id="sumAmount">0.00</div>
                    </div>
                </div>
                <div class="summary-card">
                    <div class="summary-icon yellow"><i class="fa-solid fa-percent"></i></div>
                    <div>
                        <div class="summary-label">Total Discount</div>
                        <div class="summary-value" id="sumDiscount">0.00</div>
                    </div>
                </div>
                <div class="summary-card">
                    <div class="summary-icon green"><i class="fa-solid fa-circle-check"></i></div>
                    <div>
                        <div class="summary-label">Final Amount</div>
                        <div class="summary-value" id="sumFinal">0.00</div>
                    </div>
                </div>
            </div>

            <div class="panel-card p-3 mb-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3">
                    <div>
                        <label class="form-label">Dealer</label>
                        <select id="filterDealer" class="form-input text-xs" style="height:32px;">
                            <option value="">All Dealers</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Customer</label>
                        <select id="filterCustomer" class="form-input text-xs" style="height:32px;">
                            <option value="">All Customers</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Date From</label>
                        <input type="date" id="filterDateFrom" class="form-input text-xs" style="height:32px;">
                    </div>
                    <div>
                        <label class="form-label">Date To</label>
                        <input type="date" id="filterDateTo" class="form-input text-xs" style="height:32px;">
                    </div>
                    <div style="display:flex;gap:8px;align-items:flex-end;">
                        <button type="button" onclick="loadTransactions()" class="btn-primary flex items-center gap-2"
                            style="height:32px;padding:0 16px;flex:1;">
                            <i class="fa-solid fa-filter"></i> Apply
                        </button>
                        <button type="button" onclick="resetFilters()" class="btn-secondary flex items-center gap-2"
                            style="height:32px;padding:0 14px;" title="Reset all filters">
                            <i class="fa-solid fa-rotate-left"></i> Reset
                        </button>
                    </div>
                </div>
            </div>

            <div class="panel-card overflow-hidden p-3">
                <div class="table-toolbar">
                    <div class="table-toolbar-left" id="exportButtonsContainer"></div>
                    <div class="table-toolbar-right" id="searchContainer"></div>
                </div>

                <div class="table-container">
                    <div class="table-loading-overlay" id="tableLoadingOverlay">
                        <i class="fa-solid fa-spinner fa-spin text-blue-400"></i> Loading transactions...
                    </div>
                    <table id="txTable" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Customer</th>
                                <th>Dealer</th>
                                <th>Station</th>
                                <th>Amount</th>
                                <th>Discount</th>
                                <th>Final</th>
                                <th>Coupon</th>
                                <th>Ref</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>

    <div id="toast" class="toast">
        <i class="fa-solid fa-check-circle mr-2"></i>
        <span id="toastMessage">Data loaded successfully!</span>
    </div>

    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

    <script>
        const API_BASE = '/hascol_dashboard/hascol_customer/api/transactions/';

        let dataTable = null;
        window.txStore = {};

        const exportButtons = [
            { extend: 'copy', text: '<i class="fa-regular fa-copy"></i> Copy', className: 'dt-button' },
            { extend: 'excelHtml5', text: '<i class="fa-regular fa-file-excel"></i> Excel', className: 'dt-button', title: 'Transactions_Export' },
            { extend: 'csvHtml5', text: '<i class="fa-regular fa-file-csv"></i> CSV', className: 'dt-button', title: 'Transactions_Export' },
            { extend: 'pdfHtml5', text: '<i class="fa-regular fa-file-pdf"></i> PDF', className: 'dt-button', orientation: 'landscape', pageSize: 'A4', title: 'Transactions' },
            { extend: 'print', text: '<i class="fa-solid fa-print"></i> Print', className: 'dt-button' }
        ];

        $(document).ready(function () {
            dataTable = $('#txTable').DataTable({
                dom: 'Bfrtip',
                buttons: exportButtons,
                pageLength: 10,
                order: [],
                columnDefs: [{ orderable: false, targets: '_all' }],
                language: {
                    emptyTable: 'No transactions found',
                    info: 'Showing _START_ to _END_ of _TOTAL_',
                    infoEmpty: '0 entries',
                    infoFiltered: '(filtered from _MAX_)',
                    search: '',
                    searchPlaceholder: 'Search in table...'
                },
                initComplete: function () {
                    this.api().buttons().container().appendTo('#exportButtonsContainer');
                    const searchBox = $('#txTable_wrapper .dataTables_filter');
                    searchBox.appendTo('#searchContainer');
                }
            });

            $('#filterDealer').on('change', function () {
                loadCustomersForFilter($(this).val());
                loadTransactions();
            });
            $('#filterCustomer').on('change', function () { loadTransactions(); });

            loadDealersForFilter();
            loadCustomersForFilter();
            loadTransactions();
        });

        function escapeHtml(text) {
            if (text === null || text === undefined) return '';
            return String(text).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#039;');
        }
        function showToast(message, type = 'success') {
            const toast = $('#toast');
            toast.removeClass('success error').addClass(type);
            $('#toastMessage').text(message);
            toast.addClass('show');
            clearTimeout(window._toastT);
            window._toastT = setTimeout(() => toast.removeClass('show'), 3000);
        }
        function formatDate(dt, withTime) {
            if (!dt) return '—';
            const d = new Date(dt.replace(' ', 'T'));
            if (isNaN(d.getTime())) return dt;
            const dateStr = d.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });
            if (withTime) {
                const timeStr = d.toLocaleTimeString('en-GB', { hour: '2-digit', minute: '2-digit' });
                return dateStr + ' ' + timeStr;
            }
            return dateStr;
        }
        function formatMoney(n) {
            return 'Rs ' + Number(n || 0).toLocaleString('en-PK', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        }

        function loadDealersForFilter() {
            $.ajax({
                url: API_BASE + 'get-transaction-dealers.php',
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({}),
                dataType: 'json',
                success: function (res) {
                    const sel = $('#filterDealer');
                    const currentVal = sel.val();
                    sel.html('<option value="">All Dealers</option>');
                    if (res && res.hascol_dealers && res.hascol_dealers.length) {
                        res.hascol_dealers.forEach(d => {
                            sel.append('<option value="' + d.id + '">' + escapeHtml(d.name) + ' — ' + escapeHtml(d.station_name) + '</option>');
                        });
                    }
                    if (currentVal) sel.val(currentVal);
                },
                error: function () { console.warn('Failed to load dealers for filter'); }
            });
        }

        function loadCustomersForFilter(dealerId) {
            const payload = {};
            if (dealerId) payload.dealer_id = parseInt(dealerId);

            $.ajax({
                url: API_BASE + 'get-filter-customers.php',
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(payload),
                dataType: 'json',
                success: function (res) {
                    const sel = $('#filterCustomer');
                    const currentVal = sel.val();
                    sel.html('<option value="">All Customers</option>');
                    if (res && res.hascol_customer && res.hascol_customer.length) {
                        res.hascol_customer.forEach(c => {
                            sel.append('<option value="' + c.id + '">' + escapeHtml(c.name) + ' — ' + escapeHtml(c.mobile) + '</option>');
                        });
                    }
                    if (currentVal && sel.find('option[value="' + currentVal + '"]').length) {
                        sel.val(currentVal);
                    }
                },
                error: function () { console.warn('Failed to load customers for filter'); }
            });
        }

        function resetFilters() {
            $('#filterDealer').val('');
            $('#filterCustomer').val('');
            $('#filterDateFrom').val('');
            $('#filterDateTo').val('');

            dataTable.search('').draw();
            dataTable.page(0).draw(false);

            loadCustomersForFilter();
            loadTransactions();

            showToast('Filters reset — showing all transactions', 'success');
        }

        function loadTransactions() {
            const payload = {};
            const dealer_id = $('#filterDealer').val();
            const customer_id = $('#filterCustomer').val();
            const dateFrom = $('#filterDateFrom').val();
            const dateTo = $('#filterDateTo').val();

            if (dealer_id) payload.dealer_id = parseInt(dealer_id);
            if (customer_id) payload.customer_id = parseInt(customer_id);
            if (dateFrom) payload.date_from = dateFrom;
            if (dateTo) payload.date_to = dateTo;

            $('#tableLoadingOverlay').removeClass('hidden');

            $.ajax({
                url: API_BASE + 'get-transactions.php',
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(payload),
                dataType: 'json',
                success: function (res) {
                    console.log('Transactions Response:', res);
                    dataTable.clear().draw();
                    window.txStore = {};

                    if (res && res.status === 'success') {
                        $('#sumTotal').text(res.total || 0);
                        $('#sumAmount').text(Number(res.total_amount || 0).toFixed(2));
                        $('#sumDiscount').text(Number(res.total_discount || 0).toFixed(2));
                        $('#sumFinal').text(Number(res.total_final || 0).toFixed(2));

                        if (Array.isArray(res.transactions) && res.transactions.length) {
                            $.each(res.transactions, function (i, t) {
                                window.txStore[t.id] = t;

                                const customerCell = '<div>' +
                                    '<div class="cell-name">' + escapeHtml(t.customer_name) + '</div>' +
                                    '<div class="cell-sub">' + escapeHtml(t.customer_mobile || '—') + '</div>' +
                                    '</div>';

                                const dealerCell = '<div>' +
                                    '<div class="cell-name">' + escapeHtml(t.dealer_name) + '</div>' +
                                    '<div class="cell-sub">' + escapeHtml(t.dealer_station || '—') + '</div>' +
                                    '</div>';

                                let statusHtml;
                                if (t.status === 'successful') statusHtml = '<span class="tx-status tx-successful"><span class="tx-dot"></span>Successful</span>';
                                else if (t.status === 'pending') statusHtml = '<span class="tx-status tx-pending"><span class="tx-dot"></span>Pending</span>';
                                else statusHtml = '<span class="tx-status tx-failed"><span class="tx-dot"></span>Failed</span>';

                                const amtBadge = '<span class="money-badge money-amount">' + formatMoney(t.amount) + '</span>';
                                const discBadge = t.discount > 0
                                    ? '<span class="money-badge money-discount">-' + formatMoney(t.discount) + '</span>'
                                    : '<span style="color:var(--text-muted);">—</span>';
                                const finalBadge = '<span class="money-badge money-final">' + formatMoney(t.final_amount) + '</span>';

                                const couponCell = t.coupon_code
                                    ? '<span style="font-family:monospace;font-size:10px;background:var(--hover-bg);padding:2px 6px;border-radius:4px;">' + escapeHtml(t.coupon_code) + '</span>'
                                    : '<span style="color:var(--text-muted);">—</span>';

                                const refCell = t.transaction_ref
                                    ? '<span style="font-family:monospace;font-size:10px;color:var(--text-muted);">' + escapeHtml(t.transaction_ref) + '</span>'
                                    : '<span style="color:var(--text-muted);">—</span>';

                                dataTable.row.add([
                                    i + 1,
                                    customerCell,
                                    dealerCell,
                                    escapeHtml(t.station_name || '—'),
                                    amtBadge,
                                    discBadge,
                                    finalBadge,
                                    couponCell,
                                    refCell,
                                    statusHtml,
                                    formatDate(t.created_at, true)
                                ]);
                            });
                            showToast('Loaded ' + res.total + ' transactions', 'success');
                        } else {
                            dataTable.row.add([
                                '<span style="color:var(--text-muted);">No transactions found</span>',
                                '', '', '', '', '', '', '', '', '', ''
                            ]);
                        }
                    } else {
                        dataTable.row.add([
                            '<span style="color:#ef4444;">Error loading transactions</span>',
                            '', '', '', '', '', '', '', '', '', ''
                        ]).draw(false);
                    }

                    dataTable.draw(false);
                    $('#tableLoadingOverlay').addClass('hidden');
                },
                error: function (xhr, s, e) {
                    console.error('Load transactions error:', e, xhr.responseText);
                    dataTable.clear().draw();
                    dataTable.row.add([
                        '<span style="color:#ef4444;">Error loading transactions</span>',
                        '', '', '', '', '', '', '', '', '', ''
                    ]).draw(false);
                    $('#tableLoadingOverlay').addClass('hidden');
                    showToast('Failed to load transactions', 'error');
                }
            });
        }
    </script>

</body>

</html>