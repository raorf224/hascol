<?php
require_once __DIR__ . '/../session/session.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
     <?php include '../includes/head.php'; ?>
    <title>Customers | Hascol Customer</title>
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

        .form-input[readonly] {
            background-color: var(--hover-bg);
            color: var(--text-muted);
            cursor: not-allowed;
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
        }

        .btn-secondary:hover {
            background-color: var(--btn-secondary-hover-bg);
            color: var(--btn-secondary-hover-text);
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
            padding: 4px 10px;
            font-size: 10px;
            font-weight: 500;
            border-radius: 4px;
            border: 1px solid transparent;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
        }

        .btn-edit {
            background: rgba(29, 78, 216, .1);
            color: #1d4ed8;
            border-color: rgba(29, 78, 216, .25);
        }

        .btn-edit:hover {
            background: #1d4ed8;
            color: #fff;
        }

        .btn-delete {
            background: rgba(239, 68, 68, .1);
            color: #ef4444;
            border-color: rgba(239, 68, 68, .25);
        }

        .btn-delete:hover {
            background: #ef4444;
            color: #fff;
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

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #1d4ed8 !important;
            color: #fff !important;
            border-color: #1d4ed8 !important;
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
            border-radius: .25rem !important;
            color: var(--text-muted) !important;
            font-size: 10px !important;
            cursor: pointer !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 4px !important;
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
            flex-shrink: 0;
        }

        .offcanvas {
            position: fixed;
            top: 0;
            bottom: 0;
            width: 480px;
            max-width: 90vw;
            max-height: 100vh;
            display: flex;
            flex-direction: column;
            background-color: var(--bg-panel);
            box-shadow: -10px 0 30px rgba(0, 0, 0, .25);
            transform: translateX(100%);
            transition: transform .3s ease-in-out;
            visibility: hidden;
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
            transition: opacity .15s linear;
            z-index: 99998;
        }

        .offcanvas-backdrop.show {
            opacity: 1;
        }

        .offcanvas-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 20px;
            flex-shrink: 0;
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
        }

        .btn-close::before {
            content: "\00d7";
            font-size: 20px;
            line-height: 1;
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

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 3px 9px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: 600;
        }

        .status-active {
            background: rgba(16, 185, 129, .12);
            color: #10b981;
            border: 1px solid rgba(16, 185, 129, .25);
        }

        .status-inactive {
            background: rgba(148, 163, 184, .15);
            color: #94a3b8;
            border: 1px solid rgba(148, 163, 184, .3);
        }

        .status-banned {
            background: rgba(239, 68, 68, .12);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, .25);
        }

        .status-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: currentColor;
        }

        .type-new {
            background: rgba(16, 185, 129, .12);
            color: #10b981;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: 600;
        }

        .type-ref {
            background: rgba(139, 92, 246, .12);
            color: #8b5cf6;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: 600;
        }

        .verified-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: 600;
        }

        .verified-yes {
            background: rgba(29, 78, 216, .12);
            color: #1d4ed8;
        }

        .verified-no {
            background: rgba(234, 179, 8, .15);
            color: #eab308;
        }

        /* Customer name cell */
        .cust-name {
            font-weight: 600;
            color: var(--text-heading);
        }

        .cust-id {
            font-size: 9px;
            color: var(--text-muted);
            margin-top: 2px;
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

    <?php include __DIR__ . '/../includes/sidebar.php'; ?>

    <main id="mainContent" class="flex-1 flex flex-col overflow-hidden">

        <?php include __DIR__ . '/../includes/topbar.php'; ?>

        <div class="flex-1 overflow-y-auto p-4" id="pageContent">

            <div class="flex flex-wrap justify-between items-center mb-4 gap-2">
                <div>
                    <h2 class="text-heading font-semibold text-base tracking-wide uppercase">
                        <i class="fa-solid fa-users mr-2 text-blue-500"></i>Customers
                    </h2>
                    <p class="text-[10px] text-gray-500">Manage app customers</p>
                </div>
                <button onclick="openAddCustomer()" class="btn-primary flex items-center gap-2">
                    <i class="fa-solid fa-plus"></i> Add Customer
                </button>
            </div>

            <div class="panel-card p-3 mb-4">
                <div class="toolbar-row">
                    <div class="toolbar-left" id="exportButtonsContainer"></div>
                    <div class="toolbar-right">
                        <select id="filterStatus" class="form-input text-xs"
                            style="height:30px;padding:4px 30px 4px 10px;width:120px;">
                            <option value="">All Status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                            <option value="banned">Banned</option>
                        </select>
                        <select id="filterType" class="form-input text-xs"
                            style="height:30px;padding:4px 30px 4px 10px;width:130px;">
                            <option value="">All Types</option>
                            <option value="new_customer">New Customer</option>
                            <option value="referred_customer">Referred</option>
                        </select>
                        <select id="filterVerified" class="form-input text-xs"
                            style="height:30px;padding:4px 30px 4px 10px;width:110px;">
                            <option value="">All</option>
                            <option value="1">Verified</option>
                            <option value="0">Unverified</option>
                        </select>
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-magnifying-glass text-gray-500 text-xs"></i>
                            <input type="text" id="customSearchInput" placeholder="Search" class="form-input text-xs"
                                style="height:30px;padding:4px 10px;width:180px;">
                        </div>
                        <button type="button" onclick="loadCustomers()" class="btn-secondary flex items-center gap-2"
                            style="height:30px;padding:4px 12px;">
                            <i class="fa-solid fa-rotate"></i> Refresh
                        </button>
                    </div>
                </div>
            </div>

            <div class="panel-card overflow-hidden">
                <div class="table-container">
                    <div class="table-loading-overlay" id="tableLoadingOverlay">
                        <i class="fa-solid fa-spinner fa-spin text-blue-400"></i> Loading customers...
                    </div>
                    <table id="customerTable" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Customer</th>
                                <th>Mobile</th>
                                <th>Email</th>
                                <th>CNIC</th>
                                <th>Type</th>
                                <th>Coupons</th>
                                <th>Verified</th>
                                <th>Status</th>
                                <th>Joined</th>
                                <th style="width:110px;">Action</th>
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

    <!-- Add/Edit Customer Offcanvas -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasCustomer">
        <div class="offcanvas-header">
            <h5 id="customerOffcanvasTitle" class="text-heading text-sm font-semibold offcanvas-title">
                <i class="fa-solid fa-plus-circle mr-2 text-blue-500"></i>Add Customer
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <form id="customerForm">

                <div class="form-group mb-4">
                    <label class="form-label">Player ID <span class="text-red-500">*</span></label>
                    <input type="text" class="form-input" id="c_player_id" placeholder="Original app ID" required>
                    <small id="playerIdHint" style="color:var(--text-muted);font-size:10px;display:none;">Player ID
                        cannot be changed</small>
                </div>

                <div class="form-group mb-4">
                    <label class="form-label">Full Name <span class="text-red-500">*</span></label>
                    <input type="text" class="form-input" id="c_name" placeholder="Enter customer name" required>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div class="form-group mb-4">
                        <label class="form-label">Mobile <span class="text-red-500">*</span></label>
                        <input type="text" class="form-input" id="c_mobile" placeholder="03001234567" required>
                    </div>
                    <div class="form-group mb-4">
                        <label class="form-label">CNIC</label>
                        <input type="text" class="form-input" id="c_cnic" placeholder="42101-1234567-1">
                    </div>
                </div>

                <div class="form-group mb-4">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-input" id="c_email" placeholder="customer@example.com">
                </div>

                <div class="form-group mb-4">
                    <label class="form-label">Password <span class="text-red-500" id="cPwdRequired">*</span></label>
                    <input type="text" class="form-input" id="c_password" placeholder="Min 6 characters">
                    <small id="cPwdHint" style="color:var(--text-muted);font-size:10px;display:none;">Leave empty to
                        keep current password</small>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div class="form-group mb-4">
                        <label class="form-label">IMEI</label>
                        <input type="text" class="form-input" id="c_imei" placeholder="Device IMEI">
                        <small id="imeiHint" style="color:var(--text-muted);font-size:10px;display:none;">IMEI cannot be
                            changed</small>
                    </div>
                    <div class="form-group mb-4">
                        <label class="form-label">Coupon No</label>
                        <input type="text" class="form-input" id="c_coupon_no" placeholder="Referral coupon">
                        <small id="couponHint" style="color:var(--text-muted);font-size:10px;display:none;">Coupon No
                            cannot be changed</small>
                    </div>
                </div>

                <div class="form-group mb-4">
                    <label class="form-label">Address</label>
                    <textarea class="form-input" id="c_address" rows="2" placeholder="Full address"></textarea>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div class="form-group mb-4">
                        <label class="form-label">Customer Type <span class="text-red-500">*</span></label>
                        <select class="form-input" id="c_customer_type">
                            <option value="new_customer" selected>New Customer</option>
                            <option value="referred_customer">Referred Customer</option>
                        </select>
                    </div>
                    <div class="form-group mb-4">
                        <label class="form-label">Status <span class="text-red-500">*</span></label>
                        <select class="form-input" id="c_status">
                            <option value="active" selected>Active</option>
                            <option value="inactive">Inactive</option>
                            <option value="banned">Banned</option>
                        </select>
                    </div>
                </div>

                <div class="form-group mb-4">
                    <label class="form-label">Verified</label>
                    <select class="form-input" id="c_verified">
                        <option value="0" selected>Unverified</option>
                        <option value="1">Verified</option>
                    </select>
                </div>

                <input type="hidden" id="c_row_id" value="">

                <div class="flex gap-3 mt-4">
                    <button type="submit" class="btn-primary flex-1" id="c_submitBtn">
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
        // ============================================
        // CONFIG
        // ============================================
        const API_BASE = '/hascol_dashboard/hascol_customer/api/customers/';

        let dataTable = null;
        window.customerStore = {};

        const exportButtons = [
            { extend: 'copy', text: '<i class="fa-regular fa-copy"></i> Copy', className: 'dt-button' },
            { extend: 'excelHtml5', text: '<i class="fa-regular fa-file-excel"></i> Excel', className: 'dt-button', title: 'Customers_Export' },
            { extend: 'csvHtml5', text: '<i class="fa-regular fa-file-csv"></i> CSV', className: 'dt-button', title: 'Customers_Export' },
            { extend: 'pdfHtml5', text: '<i class="fa-regular fa-file-pdf"></i> PDF', className: 'dt-button', orientation: 'landscape', pageSize: 'A4', title: 'Customers' },
            { extend: 'print', text: '<i class="fa-solid fa-print"></i> Print', className: 'dt-button' }
        ];

        // ============================================
        // INIT
        // ============================================
        $(document).ready(function () {
            dataTable = $('#customerTable').DataTable({
                dom: 'Bfrtip',
                buttons: exportButtons,
                pageLength: 10,
                order: [],
                columnDefs: [{ orderable: false, targets: '_all' }],
                language: {
                    emptyTable: 'No customers found',
                    info: 'Showing _START_ to _END_ of _TOTAL_',
                    infoEmpty: '0 entries',
                    infoFiltered: '(filtered from _MAX_)'
                },
                initComplete: function () {
                    this.api().buttons().container().appendTo('#exportButtonsContainer');
                }
            });

            $('#customSearchInput').on('keyup', function () {
                dataTable.search(this.value).draw();
            });

            $('#filterStatus, #filterType, #filterVerified').on('change', function () {
                loadCustomers();
            });

            $('#customerForm').on('submit', function (e) {
                e.preventDefault();
                saveCustomer();
            });

            loadCustomers();
        });

        // ============================================
        // HELPERS
        // ============================================
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
        function formatDate(dt) {
            if (!dt) return '—';
            const d = new Date(dt.replace(' ', 'T'));
            if (isNaN(d.getTime())) return dt;
            return d.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });
        }

        // ============================================
        // LOAD
        // ============================================
        function loadCustomers() {
            const status = $('#filterStatus').val() || '';
            const type = $('#filterType').val() || '';
            const verified = $('#filterVerified').val() || '';

            const payload = {};
            if (status) payload.status = status;
            if (type) payload.customer_type = type;
            if (verified !== '') payload.verified = parseInt(verified);

            $('#tableLoadingOverlay').removeClass('hidden');

            $.ajax({
                url: API_BASE + 'get-customers.php',
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(payload),
                dataType: 'json',

                success: function (res) {
                    console.log('RAW RESPONSE:', res);
                    console.log('KEYS:', Object.keys(res));

                    dataTable.clear();
                    window.customerStore = {};

                    let list = [];
                    if (res) {
                        if (Array.isArray(res.hascol_customer)) list = res.hascol_customer;
                        else if (Array.isArray(res.hascol_customer)) list = res.hascol_customer;
                        else if (Array.isArray(res.customers)) list = res.customers;
                        else if (Array.isArray(res.data)) list = res.data;
                        else if (Array.isArray(res.result)) list = res.result;
                        else if (Array.isArray(res.customers_list)) list = res.customers_list;
                        else if (Array.isArray(res)) list = res;
                    }

                    console.log('LIST LENGTH:', list.length);
                    console.log('FIRST ITEM:', list[0]);

                    if (res && res.status === 'success' && list.length > 0) {
                        $.each(list, function (i, c) {
                            window.customerStore[c.id] = c;

                            const customerCell =
                                '<div class="cust-name">' + escapeHtml(c.name || '-') + '</div>' +
                                '<div class="cust-id">ID: #' + (c.id || '') + '</div>';

                            let stBadge = '';
                            const st = (c.status || '').toLowerCase();
                            if (st === 'active') stBadge = '<span class="status-badge status-active"><span class="status-dot"></span>Active</span>';
                            else if (st === 'banned') stBadge = '<span class="status-badge status-banned"><span class="status-dot"></span>Banned</span>';
                            else stBadge = '<span class="status-badge status-inactive"><span class="status-dot"></span>Inactive</span>';

                            const typeBadge = c.customer_type === 'referred_customer'
                                ? '<span class="type-ref">Referred</span>'
                                : '<span class="type-new">New</span>';

                            const verBadge = (c.verified == 1)
                                ? '<span class="verified-badge verified-yes">Yes</span>'
                                : '<span class="verified-badge verified-no">No</span>';

                            const coupons = '<div style="font-size:10px;">' +
                                '<b style="color:#10b981;">' + (c.remaining_coupons || 0) + '</b> rem<br>' +
                                '<span style="color:var(--text-muted);">' + (c.used_coupons || 0) + ' used</span>' +
                                '</div>';

                            const safeName = escapeHtml(c.name || '').replace(/'/g, "\\'");
                            const action =
                                '<div style="display:flex;gap:5px;">' +
                                '<button class="btn-action btn-edit" onclick="editCustomer(' + c.id + ')"><i class="fa-solid fa-pen"></i></button>' +
                                '<button class="btn-action btn-delete" onclick="deleteCustomer(' + c.id + ', \'' + safeName + '\')"><i class="fa-solid fa-trash"></i></button>' +
                                '</div>';

                            dataTable.row.add([
                                i + 1,
                                customerCell,
                                c.mobile || '-',
                                c.email || '-',
                                c.cnic || '-',
                                typeBadge,
                                coupons,
                                verBadge,
                                stBadge,
                                formatDate(c.created_at),
                                action
                            ]);
                        });

                        showToast('Loaded ' + list.length + ' customers', 'success');
                    } else {
                        console.warn('List empty. Full response:', res);
                        showToast('No customers found', 'error');
                    }

                    dataTable.draw();
                    $('#tableLoadingOverlay').addClass('hidden');
                },

                error: function (xhr, s, e) {
                    console.error('AJAX ERROR:', xhr.status, xhr.responseText);
                    dataTable.clear().draw();
                    $('#tableLoadingOverlay').addClass('hidden');
                    showToast('API Error: ' + xhr.status, 'error');
                }
            });
        }

        // ============================================
        // ADD / EDIT
        // ============================================
        function openAddCustomer() {
            resetCustomerForm();
            $('#cPwdRequired').show();
            $('#cPwdHint').hide();
            $('#playerIdHint').hide();
            $('#imeiHint').hide();
            $('#couponHint').hide();
            $('#c_player_id').prop('readonly', false);
            $('#c_imei').prop('readonly', false);
            $('#c_coupon_no').prop('readonly', false);
            $('#c_password').attr('placeholder', 'Min 6 characters');
            $('#customerOffcanvasTitle').html('<i class="fa-solid fa-plus-circle mr-2 text-blue-500"></i>Add Customer');
            $('#c_submitBtn').html('<i class="fa-regular fa-floppy-disk mr-1"></i> Save');
            bootstrap.Offcanvas.getOrCreateInstance(document.getElementById('offcanvasCustomer')).show();
        }

        function editCustomer(id) {
            const c = window.customerStore[id]; if (!c) return;
            resetCustomerForm();

            $('#c_row_id').val(c.id);
            $('#c_player_id').val(c.player_id || '').prop('readonly', true);
            $('#playerIdHint').show();
            $('#c_name').val(c.name || '');
            $('#c_mobile').val(c.mobile || '');
            $('#c_cnic').val(c.cnic || '');
            $('#c_email').val(c.email || '');

            // ✅ IMEI readonly in edit mode
            $('#c_imei').val(c.imei || '').prop('readonly', true);
            $('#imeiHint').show();

            // ✅ Coupon No readonly in edit mode
            $('#c_coupon_no').val(c.coupon_no || '').prop('readonly', true);
            $('#couponHint').show();

            $('#c_address').val(c.address || '');
            $('#c_customer_type').val(c.customer_type || 'new_customer');
            $('#c_status').val(c.status || 'active');
            $('#c_verified').val(String(c.verified || 0));

            $('#cPwdRequired').hide();
            $('#cPwdHint').show();
            $('#c_password').attr('placeholder', 'Leave empty to keep current password').val('');

            $('#customerOffcanvasTitle').html('<i class="fa-solid fa-pen-to-square mr-2 text-blue-500"></i>Edit Customer');
            $('#c_submitBtn').html('<i class="fa-regular fa-floppy-disk mr-1"></i> Update');

            bootstrap.Offcanvas.getOrCreateInstance(document.getElementById('offcanvasCustomer')).show();
        }

        function resetCustomerForm() {
            $('#customerForm')[0].reset();
            $('#c_row_id').val('');
            $('#c_customer_type').val('new_customer');
            $('#c_status').val('active');
            $('#c_verified').val('0');
            $('#c_player_id').prop('readonly', false);
            $('#c_imei').prop('readonly', false);
            $('#c_coupon_no').prop('readonly', false);
            $('#playerIdHint').hide();
            $('#imeiHint').hide();
            $('#couponHint').hide();
        }

        // ============================================
        // SAVE
        // ============================================
        function saveCustomer() {
            const id = $('#c_row_id').val();
            const isEdit = id && id !== '';

            const data = {
                player_id: ($('#c_player_id').val() || '').trim(),
                name: ($('#c_name').val() || '').trim(),
                mobile: ($('#c_mobile').val() || '').trim(),
                cnic: ($('#c_cnic').val() || '').trim(),
                email: ($('#c_email').val() || '').trim(),
                password: ($('#c_password').val() || '').trim(),
                imei: ($('#c_imei').val() || '').trim(),
                coupon_no: ($('#c_coupon_no').val() || '').trim(),
                address: ($('#c_address').val() || '').trim(),
                customer_type: ($('#c_customer_type').val() || 'new_customer').trim(),
                status: ($('#c_status').val() || 'active').trim(),
                verified: $('#c_verified').val() || '0'
            };

            // Validation
            if (!data.player_id) { Swal.fire({ icon: 'warning', title: 'Validation', text: 'Player ID required', confirmButtonColor: '#1d4ed8' }); $('#c_player_id').focus(); return; }
            if (!data.name) { Swal.fire({ icon: 'warning', title: 'Validation', text: 'Name required', confirmButtonColor: '#1d4ed8' }); $('#c_name').focus(); return; }
            if (!data.mobile) { Swal.fire({ icon: 'warning', title: 'Validation', text: 'Mobile required', confirmButtonColor: '#1d4ed8' }); $('#c_mobile').focus(); return; }
            if (!/^[0-9+\-\s]{7,20}$/.test(data.mobile)) { Swal.fire({ icon: 'warning', title: 'Validation', text: 'Invalid mobile', confirmButtonColor: '#1d4ed8' }); $('#c_mobile').focus(); return; }
            if (data.email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(data.email)) { Swal.fire({ icon: 'warning', title: 'Validation', text: 'Invalid email', confirmButtonColor: '#1d4ed8' }); $('#c_email').focus(); return; }
            if (!isEdit && !data.password) { Swal.fire({ icon: 'warning', title: 'Validation', text: 'Password required for new customer', confirmButtonColor: '#1d4ed8' }); $('#c_password').focus(); return; }
            if (data.password && data.password.length < 6) { Swal.fire({ icon: 'warning', title: 'Validation', text: 'Password min 6 chars', confirmButtonColor: '#1d4ed8' }); $('#c_password').focus(); return; }

            const fd = new FormData();
            Object.keys(data).forEach(k => fd.append(k, data[k]));
            if (isEdit) fd.append('id', parseInt(id));

            const url = API_BASE + (isEdit ? 'update-customer.php' : 'create-customer.php');
            const btn = $('#c_submitBtn');
            btn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin mr-1"></i> Saving...');

            $.ajax({
                url: url, method: 'POST', data: fd, processData: false, contentType: false, dataType: 'json',
                success: function (res) {
                    console.log('Save customer:', res);
                    btn.prop('disabled', false).html('<i class="fa-regular fa-floppy-disk mr-1"></i> ' + (isEdit ? 'Update' : 'Save'));

                    if (res && res.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: isEdit ? 'Updated!' : 'Created!',
                            text: res.message,
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#1d4ed8'
                        }).then(r => {
                            if (r.isConfirmed) {
                                bootstrap.Offcanvas.getInstance(document.getElementById('offcanvasCustomer')).hide();
                                resetCustomerForm();
                                loadCustomers();
                            }
                        });
                    } else {
                        let errMsg = res.message || 'Failed';
                        if (res.errors) errMsg = Object.values(res.errors).join('\n');
                        Swal.fire({ icon: 'error', title: 'Error!', text: errMsg, confirmButtonText: 'OK', confirmButtonColor: '#1d4ed8' });
                    }
                },
                error: function (xhr, s, e) {
                    console.error('Save error:', e, xhr.responseText);
                    btn.prop('disabled', false).html('<i class="fa-regular fa-floppy-disk mr-1"></i> ' + (isEdit ? 'Update' : 'Save'));
                    Swal.fire({ icon: 'error', title: 'Server Error', text: 'Request failed', confirmButtonText: 'OK', confirmButtonColor: '#1d4ed8' });
                }
            });
        }

        // ============================================
        // DELETE
        // ============================================
        function deleteCustomer(id, name) {
            Swal.fire({
                icon: 'warning',
                title: 'Delete Customer?',
                html: 'Delete <b>' + escapeHtml(name) + '</b>?<br><small style="color:#94a3b8;">This action cannot be undone.</small>',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: '<i class="fa-solid fa-trash"></i> Yes, Delete',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then(r => {
                if (!r.isConfirmed) return;
                $.ajax({
                    url: API_BASE + 'delete-customer.php',
                    method: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({ id: id }),
                    dataType: 'json',
                    success: function (res) {
                        if (res && res.status === 'success') {
                            Swal.fire({ icon: 'success', title: 'Deleted!', text: res.message, confirmButtonText: 'OK', confirmButtonColor: '#1d4ed8' });
                            loadCustomers();
                        } else {
                            Swal.fire({ icon: 'error', title: 'Error', text: res.message || 'Delete failed', confirmButtonText: 'OK', confirmButtonColor: '#1d4ed8' });
                        }
                    },
                    error: function () {
                        Swal.fire({ icon: 'error', title: 'Server Error', text: 'Delete failed', confirmButtonText: 'OK', confirmButtonColor: '#1d4ed8' });
                    }
                });
            });
        }
    </script>

</body>

</html>