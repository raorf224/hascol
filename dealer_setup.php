<?php
require_once __DIR__ . '/session/session.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <?php include 'includes/head.php'; ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hascol OMC - User Setup</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- CryptoJS for encryption/decryption -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/crypto-js.js"></script>

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

    <!-- Select2 CSS & JS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        dash: {
                            bg: '#f4f6fa',
                            panel: '#ffffff',
                            border: '#e2e8f0',
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
            --modal-overlay: rgba(15, 23, 42, 0.5);
            --btn-secondary-bg: #e2e8f0;
            --btn-secondary-text: #334155;
            --modal-bg: #ffffff;
            --modal-border: #e2e8f0;
            --dropdown-bg: #ffffff;
            --tab-active: #1d4ed8;
            --tab-inactive: #64748b;
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
            --modal-overlay: rgba(6, 11, 19, 0.8);
            --btn-secondary-bg: #1a2635;
            --btn-secondary-text: #94a3b8;
            --modal-bg: #0d1520;
            --modal-border: #1a2635;
            --dropdown-bg: #0d1520;
            --tab-active: #3b82f6;
            --tab-inactive: #94a3b8;
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

        #sidebar,
        #mainContent {
            transition: all 0.3s ease-in-out;
        }

        .nav-tabs-custom {
            display: flex;
            flex-wrap: wrap;
            gap: 4px;
            padding: 6px;
            background: var(--bg-body);
            border: 1px solid var(--border-color);
            border-radius: 14px;
            width: 100%;
            transition: background-color .25s ease, border-color .25s ease;
        }

        .nav-tabs-custom .nav-item {
            margin: 0;
            flex: 1 1 auto;
            min-width: 0;
        }

        .nav-tabs-custom .nav-link {
            border: none;
            border-radius: 10px;
            padding: 10px 18px;
            font-size: 11px;
            font-weight: 600;
            color: var(--tab-inactive);
            background: transparent;
            transition: all 0.25s ease;
            cursor: pointer;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            width: 100%;
            white-space: nowrap;
        }

        .nav-tabs-custom .nav-link:hover:not(.active) {
            background: var(--hover-bg);
            color: var(--text-heading);
        }

        .nav-tabs-custom .nav-link.active {
            background: var(--tab-active);
            color: #ffffff;
            font-weight: 700;
        }

        @media (max-width: 768px) {
            .nav-tabs-custom {
                padding: 4px;
                gap: 3px;
                flex-wrap: nowrap;
                overflow-x: auto;
                scrollbar-width: none;
            }

            .nav-tabs-custom::-webkit-scrollbar {
                display: none;
            }

            .nav-tabs-custom .nav-item {
                flex: 0 0 auto;
            }

            .nav-tabs-custom .nav-link {
                font-size: 9px;
                padding: 6px 12px;
            }
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
            padding: 8px 10px;
            border-bottom: 1px solid var(--border-color);
            white-space: nowrap;
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table-container table tbody td {
            padding: 8px 10px;
            border-bottom: 1px solid var(--border-color);
            color: var(--table-row-text);
            vertical-align: middle;
            font-size: 10px;
        }

        .table-container table tbody tr:hover {
            background-color: var(--table-row-hover);
        }

        .action-icon {
            color: var(--text-muted);
            cursor: pointer;
            transition: all 0.2s;
            padding: 4px 6px;
            border-radius: 4px;
            display: inline-block;
        }

        .action-icon:hover {
            background: var(--hover-bg);
            color: var(--text-heading);
        }

        .action-icon.edit:hover {
            background: #f59e0b20;
            color: #f59e0b;
        }

        .action-icon.delete:hover {
            background: #ef444420;
            color: #ef4444;
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
            background: var(--bg-panel) !important;
            border: 1px solid var(--border-color) !important;
            color: var(--text-muted) !important;
            font-size: 11px !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #1d4ed8 !important;
            color: #ffffff !important;
        }

        .dt-buttons {
            display: flex !important;
            gap: 6px !important;
            flex-wrap: wrap !important;
        }

        .dt-buttons .dt-button {
            padding: 6px 12px !important;
            background-color: var(--bg-panel) !important;
            border: 1px solid var(--border-color) !important;
            border-radius: 0.25rem !important;
            color: var(--text-muted) !important;
            font-size: 10px !important;
            cursor: pointer !important;
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

        .btn-primary {
            background-color: #1d4ed8;
            color: #ffffff;
            padding: 6px 16px;
            border-radius: 0.25rem;
            border: none;
            font-size: 11px;
            font-weight: 500;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
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
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: 1px solid var(--border-color);
            background: var(--bg-panel);
            color: var(--text-body);
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 11.5px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
        }

        .badge {
            padding: 2px 8px;
            border-radius: 9999px;
            font-size: 8px;
            font-weight: 600;
            display: inline-block;
        }

        .badge-success {
            background: #10b98120;
            color: #10b981;
            border: 1px solid #10b98140;
        }

        .badge-danger {
            background: #ef444420;
            color: #ef4444;
            border: 1px solid #ef444440;
        }

        #modalOverlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--modal-overlay);
            backdrop-filter: blur(6px);
            z-index: 9998;
            display: none;
            justify-content: center;
            align-items: center;
        }

        #modalOverlay.active {
            display: flex;
        }

        #editModal {
            position: relative;
            width: 820px;
            max-width: 95vw;
            max-height: 90vh;
            background: var(--modal-bg);
            border: 1px solid var(--modal-border);
            border-radius: 12px;
            overflow-y: auto;
            transform: scale(0.95);
            opacity: 0;
            transition: transform 0.25s ease, opacity 0.25s ease;
        }

        #modalOverlay.active #editModal {
            transform: scale(1);
            opacity: 1;
        }

        #editModal .modal-header {
            padding: 16px 24px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: var(--table-head-bg);
            position: sticky;
            top: 0;
            z-index: 10;
        }

        #editModal .modal-body {
            padding: 20px 24px;
        }

        #editModal .modal-footer {
            padding: 12px 24px;
            border-top: 1px solid var(--border-color);
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            background: var(--table-head-bg);
            position: sticky;
            bottom: 0;
            z-index: 10;
        }

        .modal-close-btn {
            background: none;
            border: none;
            color: var(--text-muted);
            font-size: 24px;
            cursor: pointer;
        }

        .form-input {
            background-color: var(--input-bg);
            border: 1px solid var(--border-color);
            border-radius: 0.25rem;
            color: var(--text-body);
            padding: 6px 10px;
            width: 100%;
            font-size: 12px;
        }

        .form-label {
            color: var(--text-muted);
            font-size: 10px;
            font-weight: 500;
            margin-bottom: 3px;
            display: block;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-select {
            background-color: var(--input-bg);
            border: 1px solid var(--border-color);
            border-radius: 0.25rem;
            color: var(--text-body);
            padding: 6px 10px;
            width: 100%;
            font-size: 12px;
        }

        .disabled-delete {
            opacity: 0.4;
            cursor: not-allowed !important;
        }

        .disabled-delete:hover {
            background: transparent !important;
            color: var(--text-muted) !important;
        }

        /* ============ Dip Backlog Timeline ============ */
.timeline-wrapper {
    position: relative;
    padding-left: 55px;
    padding-top: 5px;
    padding-bottom: 5px;
}

/* Vertical line */
.timeline-wrapper::before {
    content: '';
    position: absolute;
    left: 21px;
    top: 25px;
    bottom: 25px;
    width: 2px;
    background: #3b82f6;
}

.tl-row {
    position: relative;
    margin-bottom: 14px;
    display: flex;
    align-items: flex-start;
}

.tl-row:last-child {
    margin-bottom: 0;
}

/* Marker column (circle) */
.tl-marker {
    position: absolute;
    left: -55px;
    top: 0;
    width: 44px;
    display: flex;
    justify-content: center;
}

.tl-circle {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 0 0 4px #fff;
    z-index: 2;
}

.tl-start,
.tl-end {
    background: #2563eb;
    color: #fff;
    font-size: 8px;
    font-weight: 700;
    letter-spacing: 0.5px;
}

.tl-icon {
    background: #fff;
    border: 2px solid #3b82f6;
    color: #3b82f6;
    font-size: 14px;
}

/* Content column */
.tl-content {
    flex: 1;
    min-height: 20px;
    padding-top: 4px;
}

.tl-start ~ .tl-content,
.tl-end ~ .tl-content {
    min-height: 36px;
}

/* Card */
.tl-card {
    background: #f1f5f9;
    border-radius: 8px;
    padding: 12px 14px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 12px;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04);
}

.tl-details {
    font-size: 11px;
    line-height: 1.8;
    color: #64748b;
    flex: 1;
}

.tl-details b {
    color: #1e293b;
    font-weight: 600;
}

/* Date Badge */
.tl-badge {
    background: #2563eb;
    color: #fff;
    min-width: 42px;
    padding: 6px 4px 10px 4px;
    border-radius: 6px;
    text-align: center;
    clip-path: polygon(0 0, 100% 0, 100% 100%, 50% 85%, 0 100%);
    flex-shrink: 0;
}

.tl-badge-day {
    font-size: 13px;
    font-weight: 700;
    line-height: 1.1;
}

.tl-badge-month {
    font-size: 9px;
    opacity: 0.9;
    margin-top: 1px;
}
    </style>
</head>

<body class="flex h-screen overflow-hidden text-xs">

    <main id="mainContent" class="flex-1 flex flex-col overflow-hidden">

        <?php include 'includes/topbar.php'; ?>

        <div class="flex-1 overflow-y-auto p-4" id="pageContent">

            <!-- Page Header -->
            <div class="flex justify-between items-center mb-4">
                <div>
                    <h2 class="text-heading font-semibold text-base tracking-wide uppercase" id="dealerName">Dealer
                        Setup</h2>
                    <p class="text-[10px] text-gray-500">Manage facilities, products, tanks, dispensers, nozzles and
                        users</p>
                </div>
                <button type="button" class="back-btn" onclick="closeTabAndRedirect()">
                    <i class="fa-solid fa-arrow-left"></i>
                    Back to Dealers
                </button>
            </div>

            <!-- NAV TABS -->
            <div class="panel-card overflow-hidden mb-4">
                <div class="p-3">
                    <ul class="nav-tabs-custom" id="setupTabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-target="facilities" role="tab">Facilities</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-target="products" role="tab">Products</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-target="tanks" role="tab">Tanks</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-target="dispenser" role="tab">Dispenser</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-target="nozzle" role="tab">Nozzle</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-target="users" role="tab">Users</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-target="last_recon" role="tab">Update Last Recon</a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- TAB CONTENT -->
            <div class="tab-content">

                <!-- FACILITIES TAB -->
                <div class="tab-pane active" id="facilities">
                    <div class="panel-card overflow-hidden">
                        <div class="p-3 border-b flex justify-between items-center"
                            style="border-color: var(--border-color);">
                            <h3 class="text-heading font-semibold text-xs tracking-wide uppercase">Facilities</h3>
                            <button class="btn-primary" onclick="openModal('facility')">
                                <i class="fa-solid fa-plus"></i> Add
                            </button>
                        </div>
                        <div class="p-3">
                            <div class="flex justify-between items-center mb-3">
                                <div id="facilityButtons"></div>
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-magnifying-glass text-gray-500 text-xs"></i>
                                    <input type="text" id="facilitySearch" placeholder="Search..." class="search-input">
                                </div>
                            </div>
                            <div class="table-container">
                                <table id="facilityTable" class="display" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Facility</th>
                                            <th>Created At</th>
                                            <th>Action</th>
                                            // Hello
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- PRODUCTS TAB -->
                <div class="tab-pane hidden" id="products">
                    <div class="panel-card overflow-hidden">
                        <div class="p-3 border-b flex justify-between items-center"
                            style="border-color: var(--border-color);">
                            <h3 class="text-heading font-semibold text-xs tracking-wide uppercase">Products</h3>
                            <button class="btn-primary" onclick="openModal('product')">
                                <i class="fa-solid fa-plus"></i> Add
                            </button>
                        </div>
                        <div class="p-3">
                            <div class="flex justify-between items-center mb-3">
                                <div id="productButtons"></div>
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-magnifying-glass text-gray-500 text-xs"></i>
                                    <input type="text" id="productSearch" placeholder="Search..." class="search-input">
                                </div>
                            </div>
                            <div class="table-container">
                                <table id="productTable" class="display" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Name</th>
                                            <th>From</th>
                                            <th>To</th>
                                            <th>Indent Price</th>
                                            <th>Nozzle Price</th>
                                            <th>Update Time</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TANKS TAB -->
                <div class="tab-pane hidden" id="tanks">
                    <div class="panel-card overflow-hidden">
                        <div class="p-3 border-b flex justify-between items-center"
                            style="border-color: var(--border-color);">
                            <h3 class="text-heading font-semibold text-xs tracking-wide uppercase">Tanks</h3>
                            <button class="btn-primary" onclick="openModal('tank')">
                                <i class="fa-solid fa-plus"></i> Add
                            </button>
                        </div>
                        <div class="p-3">
                            <div class="flex justify-between items-center mb-3">
                                <div id="tankButtons"></div>
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-magnifying-glass text-gray-500 text-xs"></i>
                                    <input type="text" id="tankSearch" placeholder="Search..." class="search-input">
                                </div>
                            </div>
                            <div class="table-container">
                             <table id="tankTable" class="display" style="width:100%;">
    <thead>
        <tr>
            <th>S.No</th>
            <th>Tank #</th>
            <th>Product</th>
            <th>Capacity</th>
            <th>Current Dip</th>
            <th>Dip Backlog</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- DISPENSER TAB -->
                <div class="tab-pane hidden" id="dispenser">
                    <div class="panel-card overflow-hidden">
                        <div class="p-3 border-b flex justify-between items-center"
                            style="border-color: var(--border-color);">
                            <h3 class="text-heading font-semibold text-xs tracking-wide uppercase">Dispenser</h3>
                            <button class="btn-primary" onclick="openModal('dispenser')">
                                <i class="fa-solid fa-plus"></i> Add
                            </button>
                        </div>
                        <div class="p-3">
                            <div class="flex justify-between items-center mb-3">
                                <div id="dispenserButtons"></div>
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-magnifying-glass text-gray-500 text-xs"></i>
                                    <input type="text" id="dispenserSearch" placeholder="Search..."
                                        class="search-input">
                                </div>
                            </div>
                            <div class="table-container">
                                <table id="dispenserTable" class="display" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Dispenser</th>
                                            <th>Description</th>
                                            <th>Created At</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- NOZZLE TAB -->
                <div class="tab-pane hidden" id="nozzle">
                    <div class="panel-card overflow-hidden">
                        <div class="p-3 border-b flex justify-between items-center"
                            style="border-color: var(--border-color);">
                            <h3 class="text-heading font-semibold text-xs tracking-wide uppercase">Nozzle</h3>
                            <button class="btn-primary" onclick="openModal('nozzle')">
                                <i class="fa-solid fa-plus"></i> Add
                            </button>
                        </div>
                        <div class="p-3">
                            <div class="flex justify-between items-center mb-3">
                                <div id="nozzleButtons"></div>
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-magnifying-glass text-gray-500 text-xs"></i>
                                    <input type="text" id="nozzleSearch" placeholder="Search..." class="search-input">
                                </div>
                            </div>
                            <div class="table-container">
                                <table id="nozzleTable" class="display" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Nozzle</th>
                                            <th>Product</th>
                                            <th>Tank</th>
                                            <th>Dispenser</th>
                                            <th>Last Reading</th>
                                            <th>Created At</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- USERS TAB -->
                <div class="tab-pane hidden" id="users">
                    <div class="panel-card overflow-hidden">
                        <div class="p-3 border-b flex justify-between items-center"
                            style="border-color: var(--border-color);">
                            <h3 class="text-heading font-semibold text-xs tracking-wide uppercase">Users</h3>
                            <button class="btn-primary" onclick="openModal('user')">
                                <i class="fa-solid fa-plus"></i> Add
                            </button>
                        </div>
                        <div class="p-3">
                            <div class="flex justify-between items-center mb-3">
                                <div id="userButtons"></div>
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-magnifying-glass text-gray-500 text-xs"></i>
                                    <input type="text" id="userSearch" placeholder="Search..." class="search-input">
                                </div>
                            </div>
                            <div class="table-container">
                                <table id="userTable" class="display" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Role</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- UPDATE LAST RECON TAB -->
                <div class="tab-pane hidden" id="last_recon">
                    <div class="panel-card overflow-hidden">
                        <div class="p-3 border-b" style="border-color: var(--border-color);">
                            <h3 class="text-heading font-semibold text-xs tracking-wide uppercase">Update Last Recon
                            </h3>
                        </div>
                        <div class="p-3">
                            <div class="flex justify-between items-center mb-3">
                                <div id="reconButtons"></div>
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-magnifying-glass text-gray-500 text-xs"></i>
                                    <input type="text" id="reconSearch" placeholder="Search..." class="search-input">
                                </div>
                            </div>
                            <div class="table-container">
                                <table id="reconTable" class="display" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Planned Date</th>
                                            <th>Site Name</th>
                                            <th>Product</th>
                                            <th>Total Days</th>
                                            <th>From</th>
                                            <th>To</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div><!-- end tab-content -->

        </div><!-- end pageContent -->
    </main>

    <!-- MODAL OVERLAY -->
    <div id="modalOverlay">
        <div id="editModal">
            <div class="modal-header">
                <h3 class="text-heading font-semibold text-sm tracking-wide" id="modalTitle">Add Record</h3>
                <button class="modal-close-btn" onclick="closeModal()">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="setupForm" onsubmit="saveRecord(event)">
                    <input type="hidden" id="recordId" value="">
                    <input type="hidden" id="recordType" value="">
                    <div id="formFields"></div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="closeModal()" class="btn-secondary">Close</button>
                <button type="submit" form="setupForm" class="btn-primary">Save</button>
            </div>
        </div>
    </div>

      <div id="dipBacklogModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; 
         background:rgba(15,23,42,0.6); backdrop-filter:blur(6px); z-index:10000; 
         justify-content:center; align-items:center;">

     <div style="background:#fff; border-radius:12px; width:560px; max-width:95vw; 
            max-height:85vh; display:flex; flex-direction:column; overflow:hidden;">

            <!-- HEADER -->
            <div style="padding:16px 20px; border-bottom:1px solid #e2e8f0; 
                        display:flex; justify-content:space-between; align-items:center;
                        background:#f8fafc;">
                <h3 style="font-weight:600; font-size:14px; color:#0f2440; margin:0;">
                    Dip Backlog
                </h3>
                <button onclick="closeDipBacklogModal()" 
                        style="background:none; border:none; font-size:22px; cursor:pointer; color:#64748b;">
                    &times;
                </button>
            </div>

            <!-- BODY -->
           <div style="padding:20px 24px 20px 30px; overflow-y:auto; flex:1; background:#f4f6fa; min-height:200px;"
     id="dipBacklogContent">
    <!-- Timeline will be injected here -->
</div>

        </div>
    </div>

    <!-- TOAST NOTIFICATION -->
    <div id="toast"
        class="fixed bottom-6 right-6 rounded-md px-5 py-3 shadow-lg z-[9999] transform translate-y-24 opacity-0 transition-all duration-300"
        style="background: var(--bg-panel); border: 1px solid var(--border-color);">
        <i class="fa-solid fa-check-circle mr-2 text-green-500"></i>
        <span id="toastMessage" style="color: var(--text-body);">Success!</span>
    </div>

    <script>
        // ============================================
        // Encryption / Decryption
        // ============================================
        function decryptId(encryptedId) {
            try {
                const key = 'Hamza Ansari';
                const bytes = CryptoJS.AES.decrypt(decodeURIComponent(encryptedId), key);
                const decrypted = bytes.toString(CryptoJS.enc.Utf8);
                return parseInt(decrypted) || 0;
            } catch (e) {
                console.error('Decryption error:', e);
                return 0;
            }
        }

        function getUrlParameter(name) {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(name);
        }

        // ============================================
        // Configuration — BASE URL (SAME AS YOUR ORIGINAL WORKING FILE)
        // ============================================
        const API_BASE_URL = 'api/';
        const USER_ID = '1';

        // ============================================
        // Dealer ID
        // ============================================
        const encryptedId = getUrlParameter('id');
        const dealerId = encryptedId ? decryptId(encryptedId) : 0;
        const returnUrl = getUrlParameter('return_url') || getUrlParameter('dealer_url');

        console.log('Dealer ID:', dealerId);
        console.log('API Base:', API_BASE_URL);

        // ============================================
        // Data Stores
        // ============================================
        let dataTables = {};
        let allProductsList = [];

        // ============================================
        // Close Tab
        // ============================================
        function closeTabAndRedirect() {
            try {
                window.open('', '_self', '');
                window.close();
            } catch (e) { }

            setTimeout(function () {
                if (returnUrl) {
                    window.location.href = decodeURIComponent(returnUrl);
                } else if (encryptedId) {
                    window.location.href = 'dealer_profile.php?id=' + encodeURIComponent(encryptedId);
                } else {
                    window.location.href = 'dealers.php';
                }
            }, 100);
        }

        // ============================================
        // Modal
        // ============================================
        function openModal(type, id = null) {
            $('#recordId').val(id || '');
            $('#recordType').val(type);
            $('#modalTitle').text((id ? 'Edit ' : 'Add ') + type.charAt(0).toUpperCase() + type.slice(1));

            let html = '';

            switch (type) {
                case 'facility':
                    html = `
                        <div class="mb-3">
                            <label class="form-label">Facility Name</label>
                            <input type="text" id="facilityName" class="form-input" placeholder="Enter facility name" required>
                        </div>
                    `;
                    break;

                case 'product':
                    html = `
                        <div class="mb-3">
                            <label class="form-label">Product Name</label>
                            <select id="productName" class="form-select" required>
                                <option value="">Select Product</option>
                            </select>
                        </div>
                        <div class="grid grid-cols-2 gap-3 mb-3">
                            <div>
                                <label class="form-label">From Date</label>
                                <input type="datetime-local" id="productFrom" class="form-input" required>
                            </div>
                            <div>
                                <label class="form-label">To Date</label>
                                <input type="datetime-local" id="productTo" class="form-input" required>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-3 mb-3">
                            <div>
                                <label class="form-label">Indent Price</label>
                                <input type="number" id="productIndent" class="form-input" placeholder="Enter indent price" step="any" required>
                            </div>
                            <div>
                                <label class="form-label">Nozzle Price</label>
                                <input type="number" id="productNozzle" class="form-input" placeholder="Enter nozzle price" step="any" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea id="productDesc" class="form-input" rows="3" placeholder="Enter description"></textarea>
                        </div>
                    `;
                    break;

                case 'tank':
                    html = `
                        <div class="mb-3">
                            <label class="form-label">Tank #</label>
                            <input type="text" id="tankNo" class="form-input" placeholder="Enter tank number" required>
                        </div>
                        <div class="grid grid-cols-2 gap-3 mb-3">
                            <div>
                                <label class="form-label">Product</label>
                                <select id="tankProduct" class="form-select" required>
                                    <option value="">Select Product</option>
                                </select>
                            </div>
                            <div>
                                <label class="form-label">Capacity</label>
                                <input type="number" id="tankCapacity" class="form-input" placeholder="Enter capacity" required>
                            </div>
                        </div>
                    `;
                    break;

                case 'dispenser':
                    html = `
                        <div class="mb-3">
                            <label class="form-label">Dispenser Name</label>
                            <input type="text" id="dispenserName" class="form-input" placeholder="Enter dispenser name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea id="dispenserDesc" class="form-input" rows="3" placeholder="Enter description"></textarea>
                        </div>
                    `;
                    break;

                case 'nozzle':
                    html = `
                        <div class="mb-3">
                            <label class="form-label">Nozzle Name</label>
                            <input type="text" id="nozzleName" class="form-input" placeholder="Enter nozzle name" required>
                        </div>
                        <div class="grid grid-cols-2 gap-3 mb-3">
                            <div>
                                <label class="form-label">Product</label>
                                <select id="nozzleProduct" class="form-select" required>
                                    <option value="">Select Product</option>
                                </select>
                            </div>
                            <div>
                                <label class="form-label">Tank</label>
                                <select id="nozzleTank" class="form-select" required>
                                    <option value="">Select Tank</option>
                                </select>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-3 mb-3">
                            <div>
                                <label class="form-label">Dispenser</label>
                                <select id="nozzleDispenser" class="form-select" required>
                                    <option value="">Select Dispenser</option>
                                </select>
                            </div>
                            <div>
                                <label class="form-label">Last Reading</label>
                                <input type="number" id="nozzleReading" class="form-input" placeholder="Enter last reading" step="any" value="0" required>
                            </div>
                        </div>
                    `;
                    break;

                case 'user':
                    html = `
                        <div class="grid grid-cols-2 gap-3 mb-3">
                            <div>
                                <label class="form-label">Full Name</label>
                                <input type="text" id="userName" class="form-input" placeholder="Enter name" required>
                            </div>
                            <div>
                                <label class="form-label">Email</label>
                                <input type="email" id="userEmail" class="form-input" placeholder="Enter email" required>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-3 mb-3">
                            <div>
                                <label class="form-label">Password</label>
                                <input type="text" id="userPassword" class="form-input" placeholder="Enter password" required>
                            </div>
                            <div>
                                <label class="form-label">Phone</label>
                                <input type="text" id="userPhone" class="form-input" placeholder="Enter phone" required>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-3 mb-3">
                            <div>
                                <label class="form-label">Role</label>
                                <select id="userRole" class="form-select" required>
                                    <option value="">Select Role</option>
                                    <option value="Admin">Admin</option>
                                    <option value="ZM">ZM</option>
                                    <option value="TM">TM</option>
                                    <option value="ASM">ASM</option>
                                    <option value="BSM">BSM</option>
                                    <option value="Order">Order</option>
                                    <option value="Reporting">Reporting</option>
                                    <option value="BSO">BSO</option>
                                </select>
                            </div>
                            <div>
                                <label class="form-label">Status</label>
                                <select id="userStatus" class="form-select" required>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                    `;
                    break;

                default:
                    html = '<p class="text-gray-500">Form not available</p>';
            }

            $('#formFields').html(html);
            $('#modalOverlay').addClass('active');

            // After modal opens, load dynamic data
            if (type === 'product') {
                loadProductDropdown();
            }
            if (type === 'tank') {
                loadTankDropdown();
            }
            if (type === 'nozzle') {
                loadNozzleDropdowns();
            }
        }

        function closeModal() {
            $('#modalOverlay').removeClass('active');
        }

        $('#modalOverlay').on('click', function (e) {
            if (e.target === this) closeModal();
        });

        $(document).on('keydown', function (e) {
            if (e.key === 'Escape' && $('#modalOverlay').hasClass('active')) closeModal();
        });

        // ============================================
        // Load Dropdowns
        // ============================================
        function loadProductDropdown() {
            if (allProductsList.length > 0) {
                let opts = '<option value="">Select Product</option>';
                allProductsList.forEach(p => {
                    opts += `<option value="${p.name}">${p.name}</option>`;
                });
                $('#productName').html(opts);
                return;
            }
            $.ajax({
                url: API_BASE_URL + 'get/get_all_products.php?key=2170',
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    allProductsList = response || [];
                    let opts = '<option value="">Select Product</option>';
                    allProductsList.forEach(p => {
                        opts += `<option value="${p.name}">${p.name}</option>`;
                    });
                    $('#productName').html(opts);
                }
            });
        }

        function loadTankDropdown() {
            $.ajax({
                url: API_BASE_URL + 'get/dealers_products.php?key=2170&dealer_id=' + dealerId,
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    let opts = '<option value="">Select Product</option>';
                    (response || []).forEach(p => {
                        opts += `<option value="${p.id}">${p.name}</option>`;
                    });
                    $('#tankProduct').html(opts);
                }
            });
        }

        function loadNozzleDropdowns() {
            $.ajax({
                url: API_BASE_URL + 'get/dealers_products.php?key=2170&dealer_id=' + dealerId,
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    let opts = '<option value="">Select Product</option>';
                    (response || []).forEach(p => {
                        opts += `<option value="${p.id}">${p.name}</option>`;
                    });
                    $('#nozzleProduct').html(opts);
                }
            });
            $.ajax({
                url: API_BASE_URL + 'get/get_dealers_tanks.php?key=2170&dealer_id=' + dealerId,
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    let opts = '<option value="">Select Tank</option>';
                    (response || []).forEach(t => {
                        opts += `<option value="${t.id}">${t.lorry_no}</option>`;
                    });
                    $('#nozzleTank').html(opts);
                }
            });
            $.ajax({
                url: API_BASE_URL + 'get/get_dealers_dispenser.php?key=2170&dealer_id=' + dealerId,
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    let opts = '<option value="">Select Dispenser</option>';
                    (response || []).forEach(d => {
                        opts += `<option value="${d.id}">${d.name}</option>`;
                    });
                    $('#nozzleDispenser').html(opts);
                }
            });
        }

        // ============================================
        // Tabs
        // ============================================
        $(document).ready(function () {

            // ✅ Facilities delete icon click block (API nahi hai)
            $(document).on('click', '.disabled-delete', function (e) {
                e.preventDefault();
                e.stopPropagation();
                showToast('Delete API not available for Facilities', 'error');
                return false;
            });

            console.log('Document ready — loading facilities');

            $('.nav-tabs-custom .nav-link').on('click', function () {
                $('.nav-tabs-custom .nav-link').removeClass('active');
                $(this).addClass('active');
                const target = $(this).data('target');
                $('.tab-pane').addClass('hidden');
                $('#' + target).removeClass('hidden');
                loadTabData(target);
            });

            // Load facilities by default
            loadTabData('facilities');
        });

        function loadTabData(tab) {
            switch (tab) {
                case 'facilities': loadFacilities(); break;
                case 'products': loadProducts(); break;
                case 'tanks': loadTanks(); break;
                case 'dispenser': loadDispensers(); break;
                case 'nozzle': loadNozzles(); break;
                case 'users': loadUsers(); break;
                case 'last_recon': loadLastRecon(); break;
            }
        }

        // ============================================
        // Load Facilities
        // ============================================
        function loadFacilities() {
            const url = API_BASE_URL + 'get/facilities_get.php?key=2170&dealer_id=' + dealerId;
            console.log('Loading facilities:', url);

            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    console.log('Facilities response:', response);
                    if (dataTables.facility) dataTables.facility.destroy();

                    const tableData = (response || []).map((item, index) => [
                        index + 1,
                        item.name || 'N/A',
                        item.created_at || 'N/A',
                        `<span class="action-icon delete disabled-delete" 
           style="opacity: 0.4; cursor: not-allowed; pointer-events: auto;"
           title="Delete API not available for Facilities">
        <i class="fa-regular fa-trash-can"></i>
    </span>`
                    ]);
                    if (tableData.length === 0) tableData.push(['No data available', '', '', '']);

                    dataTables.facility = $('#facilityTable').DataTable({
                        data: tableData,
                        columns: [
                            { title: 'S.No' },
                            { title: 'Facility' },
                            { title: 'Created At' },
                            { title: 'Action', orderable: false, searchable: false }
                        ],
                        dom: 'Bfrtip',
                        buttons: ['copy', 'excel', 'csv', 'pdf', 'print'],
                        pageLength: 10,
                        initComplete: function () {
                            const $btns = $(this.api().table().container()).find('> .dt-buttons');
                            $('#facilityButtons').empty().append($btns);
                        }
                    });

                    $('#facilitySearch').off('keyup').on('keyup', function () {
                        dataTables.facility.search(this.value).draw();
                    });
                },
                error: function (xhr, status, error) {
                    console.error('Facilities error:', error, xhr.responseText);
                    showToast('Failed to load facilities', 'error');
                }
            });
        }

        // ============================================
        // Load Products
        // ============================================
        function loadProducts() {
            $.ajax({
                url: API_BASE_URL + 'get/dealers_products.php?key=2170&dealer_id=' + dealerId,
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (dataTables.product) dataTables.product.destroy();

                    const tableData = (response || []).map((item, index) => [
                        index + 1,
                        item.name || 'N/A',
                        item.from || 'N/A',
                        item.to || 'N/A',
                        item.indent_price || 'N/A',
                        item.nozel_price || 'N/A',
                        item.update_time || 'N/A',
                        `<span class="action-icon edit disabled-edit" 
       style="opacity: 0.4; cursor: not-allowed;"
       title="Edit API not available for Products">
    <i class="fa-regular fa-pen-to-square"></i>
</span>
<span class="action-icon delete" onclick="deleteProduct(${item.id})">
    <i class="fa-regular fa-trash-can"></i>
</span>`
                    ]);

                    if (tableData.length === 0) tableData.push(['No data available', '', '', '', '', '', '', '']);

                    dataTables.product = $('#productTable').DataTable({
                        data: tableData,
                        columns: [
                            { title: 'S.No' },
                            { title: 'Name' },
                            { title: 'From' },
                            { title: 'To' },
                            { title: 'Indent Price' },
                            { title: 'Nozzle Price' },
                            { title: 'Update Time' },
                            { title: 'Action', orderable: false, searchable: false }
                        ],
                        dom: 'Bfrtip',
                        buttons: ['copy', 'excel', 'csv', 'pdf', 'print'],
                        pageLength: 10,
                        initComplete: function () {
                            const $btns = $(this.api().table().container()).find('> .dt-buttons');
                            $('#productButtons').empty().append($btns);
                        }
                    });

                    $('#productSearch').off('keyup').on('keyup', function () {
                        dataTables.product.search(this.value).draw();
                    });
                }
            });
        }

        // ============================================
        // Load Tanks
        // ============================================
        function loadTanks() {
            $.ajax({
                url: API_BASE_URL + 'get/get_dealers_tanks.php?key=2170&dealer_id=' + dealerId,
                type: 'GET',
                dataType: 'json',
                cache: false,
                success: function (response) {
                    if (dataTables.tank) dataTables.tank.destroy();

                 const tableData = (response || []).map((item, index) => [
    index + 1,
    item.lorry_no || 'N/A',
    item.name || 'N/A',
    item.max_limit || 'N/A',
    item.current_dip || 'N/A',
    `<span class="action-icon" onclick="openDipBacklog(${item.id})" title="View Dip Backlog">
        <i class="fas fa-align-justify font-size-16 align-middle"></i>
    </span>`,
    `${'' /* <span class="action-icon edit" onclick="editRecord('tank', ${item.id})">
        <i class="fa-regular fa-pen-to-square"></i>
    </span> */}
    <span class="action-icon delete" onclick="deleteTank(${item.id})">
        <i class="fa-regular fa-trash-can"></i>
    </span>`
]);

                    if (tableData.length === 0) tableData.push(['No data available', '', '', '', '', '', '']);

                    dataTables.tank = $('#tankTable').DataTable({
                        data: tableData,
                     columns: [
    { title: 'S.No' },
    { title: 'Tank #' },
    { title: 'Product' },
    { title: 'Capacity' },
    { title: 'Current Dip' },
    { title: 'Dip Backlog', orderable: false, searchable: false },
    { title: 'Action', orderable: false, searchable: false }
],
                        dom: 'Bfrtip',
                        buttons: ['copy', 'excel', 'csv', 'pdf', 'print'],
                        pageLength: 10,
                        initComplete: function () {
                            const $btns = $(this.api().table().container()).find('> .dt-buttons');
                            $('#tankButtons').empty().append($btns);
                        }
                    });

                    $('#tankSearch').off('keyup').on('keyup', function () {
                        dataTables.tank.search(this.value).draw();
                    });
                }
            });
        }

        // ============================================
// Dip Backlog — Open Modal & Load Timeline
// ============================================
function openDipBacklog(tankId) {
    if (!tankId) {
        showToast('Invalid tank ID', 'error');
        return;
    }

    // Modal open karo
    $('#dipBacklogModal').css('display', 'flex');
    $('#dipBacklogContent').html(
        '<p style="text-align:center; color:#64748b; padding:20px;">Loading...</p>'
    );

    // API hit karo
    $.ajax({
        url: API_BASE_URL + 'get/get_dealers_tanks_dip_log.php?key=2170&tank_id=' + tankId,
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            renderDipBacklogTimeline(response || []);
        },
        error: function (xhr, status, error) {
            console.error('Dip backlog error:', error);
            $('#dipBacklogContent').html(
                '<p style="text-align:center; color:#ef4444; padding:20px;">Failed to load data.</p>'
            );
        }
    });
}

function closeDipBacklogModal() {
    $('#dipBacklogModal').css('display', 'none');
}

// ============================================
// Render Timeline
// ============================================
function renderDipBacklogTimeline(data) {
    if (!data || data.length === 0) {
        $('#dipBacklogContent').html(
            '<p style="text-align:center; color:#64748b; padding:20px;">No dip log records found.</p>'
        );
        return;
    }

    const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                        'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

    let html = `
        <div class="timeline-wrapper">
            
            <!-- START -->
            <div class="tl-row">
                <div class="tl-marker">
                    <div class="tl-circle tl-start">START</div>
                </div>
                <div class="tl-content"></div>
            </div>
    `;

    data.forEach(function (item) {
        const dt = item.datetime ? new Date(item.datetime.replace(' ', 'T')) : null;
        const day   = dt ? String(dt.getDate()).padStart(2, '0') : '--';
        const month = dt ? monthNames[dt.getMonth()] : '--';
        const time  = dt ? dt.toLocaleTimeString('en-GB', {
            hour: '2-digit', minute: '2-digit', second: '2-digit'
        }) : '--';
        const dateOnly = dt ? dt.toISOString().slice(0, 10) : '--';

        html += `
            <div class="tl-row">
                <div class="tl-marker">
                    <div class="tl-circle tl-icon">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                </div>
                <div class="tl-content">
                    <div class="tl-card">
                        <div class="tl-details">
                            <div>Previous Dip : <b>${item.previous_dip ?? '--'}</b></div>
                            <div>Update Dip : <b>${item.current_dip ?? '--'}</b></div>
                            <div>Description : <b>${item.description || '---'}</b></div>
                            <div>Action Time : <b>${dateOnly} ${time}</b></div>
                        </div>
                        <div class="tl-badge">
                            <div class="tl-badge-day">${day}</div>
                            <div class="tl-badge-month">${month}</div>
                        </div>
                    </div>
                </div>
            </div>
        `;
    });

    html += `
            <!-- END -->
            <div class="tl-row">
                <div class="tl-marker">
                    <div class="tl-circle tl-end">END</div>
                </div>
                <div class="tl-content"></div>
            </div>

        </div>
    `;

    $('#dipBacklogContent').html(html);
}

// Close on overlay click
$(document).on('click', '#dipBacklogModal', function (e) {
    if (e.target === this) closeDipBacklogModal();
});

// Close on Escape
$(document).on('keydown', function (e) {
    if (e.key === 'Escape' && $('#dipBacklogModal').css('display') === 'flex') {
        closeDipBacklogModal();
    }
});

        // ============================================
        // Load Dispensers
        // ============================================
        function loadDispensers() {
            $.ajax({
                url: API_BASE_URL + 'get/get_dealers_dispenser.php?key=2170&dealer_id=' + dealerId,
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (dataTables.dispenser) dataTables.dispenser.destroy();

                  const tableData = (response || []).map((item, index) => [
    index + 1,
    item.name || 'N/A',
    item.description || 'N/A',
    item.created_at || 'N/A',
    `<span class="action-icon delete" onclick="deleteDispenser(${item.id})">
        <i class="fa-regular fa-trash-can"></i>
    </span>`
]);

                    if (tableData.length === 0) tableData.push(['No data available', '', '', '', '']);

                    dataTables.dispenser = $('#dispenserTable').DataTable({
                        data: tableData,
                        columns: [
                            { title: 'S.No' },
                            { title: 'Dispenser' },
                            { title: 'Description' },
                            { title: 'Created At' },
                            { title: 'Action', orderable: false, searchable: false }
                        ],
                        dom: 'Bfrtip',
                        buttons: ['copy', 'excel', 'csv', 'pdf', 'print'],
                        pageLength: 10,
                        initComplete: function () {
                            const $btns = $(this.api().table().container()).find('> .dt-buttons');
                            $('#dispenserButtons').empty().append($btns);
                        }
                    });

                    $('#dispenserSearch').off('keyup').on('keyup', function () {
                        dataTables.dispenser.search(this.value).draw();
                    });
                }
            });
        }

        // ============================================
        // Load Nozzles
        // ============================================
        function loadNozzles() {
            $.ajax({
                url: API_BASE_URL + 'get/get_dealers_nozels.php?key=2170&dealer_id=' + dealerId,
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (dataTables.nozzle) dataTables.nozzle.destroy();

const tableData = (response || []).map((item, index) => [
    index + 1,
    item.name || 'N/A',
    item.product_name || 'N/A',
    item.tank_name || 'N/A',
    item.dispenser_name || 'N/A',
    item.last_reading || 'N/A',
    item.created_at || 'N/A',
    `<span class="action-icon delete" onclick="deleteNozzle(${item.id})">
        <i class="fa-regular fa-trash-can"></i>
    </span>`
]);

                    if (tableData.length === 0) tableData.push(['No data available', '', '', '', '', '', '', '']);

                    dataTables.nozzle = $('#nozzleTable').DataTable({
                        data: tableData,
                        columns: [
                            { title: 'S.No' },
                            { title: 'Nozzle' },
                            { title: 'Product' },
                            { title: 'Tank' },
                            { title: 'Dispenser' },
                            { title: 'Last Reading' },
                            { title: 'Created At' },
                            { title: 'Action', orderable: false, searchable: false }
                        ],
                        dom: 'Bfrtip',
                        buttons: ['copy', 'excel', 'csv', 'pdf', 'print'],
                        pageLength: 10,
                        initComplete: function () {
                            const $btns = $(this.api().table().container()).find('> .dt-buttons');
                            $('#nozzleButtons').empty().append($btns);
                        }
                    });

                    $('#nozzleSearch').off('keyup').on('keyup', function () {
                        dataTables.nozzle.search(this.value).draw();
                    });
                }
            });
        }

        // ============================================
        // Load Users
        // ============================================
     function loadUsers() {
    $.ajax({
        url: API_BASE_URL + 'get/dealer_users.php?key=2170&dealer_id=' + dealerId,
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            if (dataTables.user) dataTables.user.destroy();

            const tableData = (response || []).map((item, index) => [
                index + 1,
                item.name || 'N/A',
                item.email || 'N/A',
                item.contact || 'N/A',
                item.role || 'N/A',
                `<span class="badge ${item.active == 1 ? 'badge-success' : 'badge-danger'}">${item.active == 1 ? 'Active' : 'Inactive'}</span>`
            ]);

            if (tableData.length === 0) tableData.push(['No data available', '', '', '', '', '']);

            dataTables.user = $('#userTable').DataTable({
                data: tableData,
                columns: [
                    { title: 'S.No' },
                    { title: 'Name' },
                    { title: 'Email' },
                    { title: 'Phone' },
                    { title: 'Role' },
                    { title: 'Status' }
                ],
                dom: 'Bfrtip',
                buttons: ['copy', 'excel', 'csv', 'pdf', 'print'],
                pageLength: 10,
                initComplete: function () {
                    const $btns = $(this.api().table().container()).find('> .dt-buttons');
                    $('#userButtons').empty().append($btns);
                }
            });

            $('#userSearch').off('keyup').on('keyup', function () {
                dataTables.user.search(this.value).draw();
            });
        }
    });
}

        // ============================================
        // Load Last Recon
        // ============================================
        function loadLastRecon() {
            $.ajax({
                url: API_BASE_URL + 'get/get_dealer_last_recons.php?key=2170&dealer_id=' + dealerId,
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (dataTables.recon) dataTables.recon.destroy();

                    const tableData = (response || []).map((item, index) => [
                        index + 1,
                        item.created_at || 'N/A',
                        item.dealer_name || 'N/A',
                        item.product_name || 'N/A',
                        item.total_days || 'N/A',
                        item.last_recon_date || 'N/A',
                        item.created_at || 'N/A',
                        `<span class="action-icon edit" onclick="editRecord('recon', ${item.id})">
                            <i class="fa-regular fa-pen-to-square"></i>
                        </span>`
                    ]);

                    if (tableData.length === 0) tableData.push(['No data available', '', '', '', '', '', '', '']);

                    dataTables.recon = $('#reconTable').DataTable({
                        data: tableData,
                        columns: [
                            { title: 'S.No' },
                            { title: 'Planned Date' },
                            { title: 'Site Name' },
                            { title: 'Product' },
                            { title: 'Total Days' },
                            { title: 'From' },
                            { title: 'To' },
                            { title: 'Action', orderable: false, searchable: false }
                        ],
                        dom: 'Bfrtip',
                        buttons: ['copy', 'excel', 'csv', 'pdf', 'print'],
                        pageLength: 10,
                        initComplete: function () {
                            const $btns = $(this.api().table().container()).find('> .dt-buttons');
                            $('#reconButtons').empty().append($btns);
                        }
                    });

                    $('#reconSearch').off('keyup').on('keyup', function () {
                        dataTables.recon.search(this.value).draw();
                    });
                }
            });
        }

        // ============================================
        // Edit Functions
        // ============================================
        function editProduct(id) {
            // ❌ Update API nahi hai — sirf tooltip show karo
            showToast('Edit API not available for Products', 'error');
            return false;
        }

        function editRecord(type, id) {
            openModal(type, id);
            showToast('Edit ' + type + ' (ID: ' + id + ')', 'info');
        }

        // ============================================
        // Delete Functions (Separate for each type)
        // ============================================

        // Common confirm dialog
        function confirmDelete(callback) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'This action cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    callback();
                }
            });
        }

        // Common AJAX delete handler
        function executeDelete(url, type) {
            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (response === 1 || response == 1) {
                        showToast('Record deleted successfully!', 'success');

                        // ✅ Singular → Plural mapping (loadTabData ke liye)
                        const tabMap = {
                            'facility': 'facilities',
                            'product': 'products',
                            'tank': 'tanks',
                            'dispenser': 'dispenser',
                            'nozzle': 'nozzle',
                            'user': 'users'
                        };

                        loadTabData(tabMap[type] || type);
                    } else {
                        showToast('Failed to delete record.', 'error');
                    }
                },
                error: function () {
                    showToast('Error deleting record.', 'error');
                }
            });
        }

        // ✅ Product Delete
        function deleteProduct(id) {
            confirmDelete(function () {
                const url = API_BASE_URL + 'delete/delete_dealer_product.php?key=2170&id=' + id;
                executeDelete(url, 'product');
            });
        }

        // ✅ Tank Delete
        function deleteTank(id) {
            confirmDelete(function () {
                const url = API_BASE_URL + 'delete/delete_tank.php?key=2170&id=' + id;
                executeDelete(url, 'tank');
            });
        }

        // ✅ Dispenser Delete
        function deleteDispenser(id) {
            confirmDelete(function () {
                const url = API_BASE_URL + 'delete/delete_despensor.php?key=2170&id=' + id;
                executeDelete(url, 'dispenser');
            });
        }

        // ✅ Nozzle Delete
        function deleteNozzle(id) {
            confirmDelete(function () {
                const url = API_BASE_URL + 'delete/delete_nozzels.php?key=2170&id=' + id;
                executeDelete(url, 'nozzle');
            });
        }

        // ✅ User Delete
        function deleteUser(id) {
            confirmDelete(function () {
                const url = API_BASE_URL + 'delete/delete_user.php?key=2170&id=' + id;
                executeDelete(url, 'user');
            });
        }

        // ============================================
        // Save Record
        // ============================================
        // ============================================
// Save Record — Common Submit Handler
// ============================================
function submitForm(url, formData, type, id, onSuccess) {
    const submitBtn = $('#setupForm button[type="submit"]');
    submitBtn.prop('disabled', true);
    submitBtn.html('<i class="fa-solid fa-spinner fa-spin mr-1"></i> Saving...');

    $.ajax({
        url: url,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function (response) {
            submitBtn.prop('disabled', false);
            submitBtn.html('Save');

            console.log('Server Response:', response);

            // ✅ Singular → Plural mapping (loadTabData ke liye)
            const tabMap = {
                'facility':  'facilities',
                'product':   'products',
                'tank':      'tanks',
                'dispenser': 'dispenser',
                'nozzle':    'nozzle',
                'user':      'users'
            };

            // ✅ JSON format handle — success ya status dono
            if (response && typeof response === 'object') {

                // ✅ Success: success=true YA status=true/1/'1'
                if (
                    response.success === true ||
                    response.status === true ||
                    response.status === 1 ||
                    response.status === '1'
                ) {
                    showToast(
                        response.message || (id ? 'Record updated successfully!' : 'Record created successfully!'),
                        'success'
                    );
                    closeModal();
                    loadTabData(tabMap[type] || type);
                } else {
                    // ❌ Failure
                    showToast(
                        response.message || 'Failed to save record.',
                        'error'
                    );
                }
                return;
            }

            // ✅ Purana format bhi handle karo (backward compatibility)
            let resp = (typeof response === 'string') ? response.trim() : response;

            if (resp === 1 || resp === '1' || resp === '1\n') {
                showToast(
                    id ? 'Record updated successfully!' : 'Record created successfully!',
                    'success'
                );
                closeModal();
                loadTabData(tabMap[type] || type);
            } else {
                showToast('Unexpected response from server', 'error');
                console.error('Unexpected response:', response);
            }
        },
        error: function (xhr, status, error) {
            submitBtn.prop('disabled', false);
            submitBtn.html('Save');
            showToast('Error saving record: ' + status, 'error');
            console.error('Error:', error, xhr.responseText);
        }
    });
}

        // ✅ Facility Save
        function saveFacility(id) {
            let formData = new FormData();
            formData.append('user_id', USER_ID);
            formData.append('dealer_id', dealerId);
            if (id) formData.append('row_id', id);
            formData.append('name', $('#facilityName').val());

            const url = id
                ? API_BASE_URL + 'update/update_facility.php'
                : API_BASE_URL + 'create/dealer_facitlities.php';

            submitForm(url, formData, 'facility', id);
        }

        // ✅ Product Save — Edit DISABLED (update API nahi hai)
        function saveProduct(id) {
            // ❌ Edit disabled — sirf Add kaam karega
            if (id) {
                showToast('Edit API not available for Products', 'error');
                return;
            }

            let formData = new FormData();
            formData.append('user_id', USER_ID);
            formData.append('dealer_id', dealerId);
            formData.append('products_name', $('#productName').val());
            formData.append('from_date', $('#productFrom').val());
            formData.append('to_date', $('#productTo').val());
            formData.append('indent_price', $('#productIndent').val());
            formData.append('nozel_price', $('#productNozzle').val());
            formData.append('products_description', $('#productDesc').val());

            const url = API_BASE_URL + 'create/create_dealers_products.php';
            submitForm(url, formData, 'product', id);
        }

        // ✅ Tank Save
        function saveTank(id) {
            let formData = new FormData();
            formData.append('user_id', USER_ID);
            formData.append('dealer_id', dealerId);
            if (id) formData.append('row_id', id);
            formData.append('lorry_no', $('#tankNo').val());
            formData.append('products', $('#tankProduct').val());
            formData.append('max_limit', $('#tankCapacity').val());
            formData.append('min_limit', '0');
            formData.append('current_dip', '0');
            formData.append('current_reading', '0');

            const url = id
                ? API_BASE_URL + 'update/update_dealers_tanks.php'
                : API_BASE_URL + 'create/create_dealers_tanks.php';

            submitForm(url, formData, 'tank', id);
        }

        // ✅ Dispenser Save
        function saveDispenser(id) {
            let formData = new FormData();
            formData.append('user_id', USER_ID);
            formData.append('dealer_id', dealerId);
            if (id) formData.append('row_id', id);
            formData.append('dispenser_name', $('#dispenserName').val());
            formData.append('dispenser_description', $('#dispenserDesc').val());

            const url = id
                ? API_BASE_URL + 'update/update_dispenser.php'
                : API_BASE_URL + 'create/create_dispenser.php';

            submitForm(url, formData, 'dispenser', id);
        }

        // ✅ Nozzle Save
        function saveNozzle(id) {
            let formData = new FormData();
            formData.append('user_id', USER_ID);
            formData.append('dealer_id', dealerId);
            if (id) formData.append('row_id', id);
            formData.append('name', $('#nozzleName').val());
            formData.append('nozzels_products', $('#nozzleProduct').val());
            formData.append('product_tank', $('#nozzleTank').val());
            formData.append('product_dispenser', $('#nozzleDispenser').val());
            formData.append('last_reading', $('#nozzleReading').val());

            const url = id
                ? API_BASE_URL + 'update/update_nozzels.php'
                : API_BASE_URL + 'create/nozzels.php';

            submitForm(url, formData, 'nozzle', id);
        }

        // ✅ User Save
      function saveUser(id) {
    let formData = new FormData();
    formData.append('user_id', USER_ID);
    formData.append('dealer_id', dealerId);
    if (id) formData.append('row_id', id);

    const userName     = $('#userName').val();
    const userEmail    = $('#userEmail').val();
    const userPassword = $('#userPassword').val();
    const userPhone    = $('#userPhone').val();
    const userRole     = $('#userRole').val();
    const userStatus   = $('#userStatus').val();

    // ✅ API ke expected field names
    formData.append('name', userName);
    formData.append('email', userEmail);
    formData.append('confirm_password', userPassword);   // password
    formData.append('number', userPhone);
    formData.append('role', userRole);
    formData.append('sales_role', userRole);             // role hi sales_role hai
    formData.append('status', userStatus);

    const url = id
        ? API_BASE_URL + 'update/update_user.php'
        : API_BASE_URL + 'create/users.php';

    submitForm(url, formData, 'user', id);
}

        // ✅ Main Dispatcher — Form submit hone par yahi call hota hai
        function saveRecord(event) {
            event.preventDefault();
            const type = $('#recordType').val();
            const id = $('#recordId').val();

            switch (type) {
                case 'facility': saveFacility(id); break;
                case 'product': saveProduct(id); break;
                case 'tank': saveTank(id); break;
                case 'dispenser': saveDispenser(id); break;
                case 'nozzle': saveNozzle(id); break;
                case 'user': saveUser(id); break;
                default:
                    showToast('Invalid type.', 'error');
            }
        }

        // ============================================
        // Toast
        // ============================================
        function showToast(message, type = 'success') {
            const toast = $('#toast');
            $('#toastMessage').text(message);

            toast.removeClass('border-green-500 border-red-500 border-yellow-500');
            if (type === 'success') {
                toast.addClass('border-green-500');
                toast.find('i').removeClass('text-red-500 text-yellow-500').addClass('text-green-500');
            } else if (type === 'error') {
                toast.addClass('border-red-500');
                toast.find('i').removeClass('text-green-500 text-yellow-500').addClass('text-red-500');
            } else {
                toast.addClass('border-yellow-500');
                toast.find('i').removeClass('text-green-500 text-red-500').addClass('text-yellow-500');
            }

            toast.removeClass('translate-y-24 opacity-0').addClass('translate-y-0 opacity-100');

            clearTimeout(window.toastTimeout);
            window.toastTimeout = setTimeout(() => {
                toast.removeClass('translate-y-0 opacity-100').addClass('translate-y-24 opacity-0');
            }, 3000);
        }
    </script>

</body>

</html>