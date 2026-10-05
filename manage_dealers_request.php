<?php
// Hascol OMC Operations Command Center - Manage Dealers Request
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hascol OMC - Manage Dealers Request</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

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
            --device-auth-color: #1d4ed8;
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
            --device-auth-color: #60a5fa;
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

        #sidebar,
        #mainContent {
            transition: all 0.3s ease-in-out;
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
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table-container table tbody td {
            padding: 10px 12px;
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

        .action-icon.verify:hover {
            background: #10b98120;
            color: #10b981;
        }

        .action-icon.delete:hover {
            background: #ef444420;
            color: #ef4444;
        }

        .device-auth {
            color: var(--device-auth-color) !important;
        }

        /* DataTables Controls Styling */
        .dataTables_wrapper .dataTables_filter {
            float: none !important;
            text-align: left !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .dataTables_wrapper .dataTables_filter label {
            display: flex !important;
            align-items: center !important;
            gap: 8px !important;
            margin: 0 !important;
            padding: 0 !important;
            font-size: 11px !important;
            color: var(--text-muted) !important;
            font-weight: 500 !important;
        }

        .dataTables_wrapper .dataTables_filter input {
            display: inline-block !important;
            width: 220px !important;
            padding: 6px 12px !important;
            border: 1px solid var(--border-color) !important;
            border-radius: 0.25rem !important;
            background-color: var(--input-bg) !important;
            color: var(--text-body) !important;
            font-size: 11px !important;
            outline: none !important;
            height: 30px !important;
            box-sizing: border-box !important;
            transition: border-color 0.2s ease, box-shadow 0.2s ease !important;
        }

        .dataTables_wrapper .dataTables_filter input:focus {
            border-color: #1d4ed8 !important;
            box-shadow: 0 0 0 2px rgba(29, 78, 216, 0.2) !important;
        }

        .dataTables_wrapper .dataTables_filter input::placeholder {
            color: var(--text-muted) !important;
        }

        .dataTables_wrapper .dataTables_length {
            float: left !important;
            margin-right: 15px !important;
        }

        .dataTables_wrapper .dataTables_length label {
            display: flex !important;
            align-items: center !important;
            gap: 6px !important;
            font-size: 11px !important;
            color: var(--text-muted) !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .dataTables_wrapper .dataTables_length select {
            padding: 4px 8px !important;
            border: 1px solid var(--border-color) !important;
            border-radius: 0.25rem !important;
            background-color: var(--input-bg) !important;
            color: var(--text-body) !important;
            font-size: 11px !important;
            height: 30px !important;
            box-sizing: border-box !important;
        }

        .dataTables_wrapper .dataTables_info {
            color: var(--text-muted) !important;
            font-size: 11px !important;
            padding-top: 12px !important;
            clear: both !important;
            float: left !important;
        }

        /* DataTables Buttons */
        .dt-buttons {
            display: flex !important;
            gap: 6px !important;
            flex-wrap: wrap !important;
            float: left !important;
            margin-right: 15px !important;
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

        /* Column Visibility Dropdown Styles */
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

        .column-visibility-dropdown .dropdown-btn i {
            font-size: 11px;
        }

        .column-visibility-dropdown .dropdown-menu {
            position: absolute;
            top: calc(100% + 4px);
            right: 0;
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

        .badge {
            padding: 2px 10px;
            border-radius: 9999px;
            font-size: 8px;
            font-weight: 600;
            display: inline-block;
        }

        .badge-verified {
            background: #10b98120;
            color: #10b981;
            border: 1px solid #10b98140;
        }

        .badge-pending {
            background: #f59e0b20;
            color: #f59e0b;
            border: 1px solid #f59e0b40;
        }

        .badge-rejected {
            background: #ef444420;
            color: #ef4444;
            border: 1px solid #ef444440;
        }

        /* Toolbar wrapper for DataTables controls */
        .datatables-toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
        }

        .datatables-toolbar-left {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }

        .datatables-toolbar-right {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }

        /* Modal Styles */
        #verifyModal {
            background: var(--modal-overlay);
            backdrop-filter: blur(8px);
        }

        #verifyModalWrapper {
            background-color: var(--bg-panel) !important;
            border-color: var(--border-color) !important;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35);
        }

        html.dark-mode #verifyModalWrapper {
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.8);
        }

        #verifyModalWrapper .border-b {
            border-color: var(--border-color) !important;
        }

        #verifyModalWrapper .border-t {
            border-color: var(--border-color) !important;
        }

        #deleteModal {
            background: var(--modal-overlay);
            backdrop-filter: blur(8px);
        }

        #deleteModalWrapper {
            background-color: var(--bg-panel) !important;
            border-color: var(--border-color) !important;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35);
        }

        html.dark-mode #deleteModalWrapper {
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.8);
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

        .btn-success {
            background-color: #10b981;
            color: #ffffff;
            padding: 8px 20px;
            border-radius: 0.25rem;
            border: none;
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .btn-success:hover {
            background-color: #059669;
        }

        .btn-danger {
            background-color: #dc2626;
            color: #ffffff;
            padding: 8px 20px;
            border-radius: 0.25rem;
            border: none;
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .btn-danger:hover {
            background-color: #ef4444;
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

        .form-select option {
            background-color: var(--bg-panel);
            color: var(--text-body);
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
    </style>
</head>

<body class="flex h-screen overflow-hidden text-xs">

    <?php include 'includes/sidebar.php'; ?>

    <main id="mainContent" class="flex-1 flex flex-col overflow-hidden">

        <?php include 'includes/topbar.php'; ?>

        <div class="flex-1 overflow-y-auto p-4" id="pageContent">

            <div class="flex justify-between items-center mb-4">
                <div>
                    <h2 class="text-heading font-semibold text-base tracking-wide uppercase">Verification Request</h2>
                    <p class="text-[10px] text-gray-500">Manage dealer verification requests and authentication</p>
                </div>
            </div>

            <!-- Toolbar Panel - DataTables controls will be placed here -->
            <div class="panel-card p-3 mb-4">
                <div class="datatables-toolbar">
                    <div class="datatables-toolbar-left" id="exportButtonsContainer">
                        <!-- DataTables Buttons will be placed here -->
                    </div>
                    <div class="datatables-toolbar-right">
                        <!-- Column Visibility Dropdown -->
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
                        <!-- Search Container -->
                        <div id="searchContainer">
                            <!-- DataTables Search will be placed here -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel-card overflow-hidden">
                <div class="table-container">
                    <table id="verificationRequestsTable" class="display" style="width:100%;">
                        <thead>
                            <tr>
                                <th style="width:50px;">S.No</th>
                                <th style="min-width:120px;">User Name</th>
                                <th style="width:100px;">Contact</th>
                                <th style="min-width:250px;">Device Authentication</th>
                                <th style="width:100px;">Is-Verify</th>
                                <th style="min-width:150px;">Verify Time</th>
                                <th style="min-width:150px;">Request Time</th>
                                <th style="width:80px; text-align:center;">Action</th>
                                <th style="width:60px; text-align:center;">Delete</th>
                            </tr>
                        </thead>
                        <tbody id="verificationRequestsTableBody">
                            <tr>
                                <td colspan="9" class="text-center py-8 text-gray-500">
                                    <i class="fa-solid fa-spinner fa-spin text-blue-400 mr-2"></i>
                                    Loading requests...
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>

    <!-- VERIFY MODAL -->
    <div id="verifyModal"
        class="fixed inset-0 z-50 hidden backdrop-blur-sm flex items-center justify-center transition-opacity duration-300 opacity-0">
        <div class="border rounded-lg shadow-2xl w-full max-w-md transform scale-95 transition-transform duration-300"
            id="verifyModalWrapper">
            <div class="flex justify-between items-center p-4 border-b" style="border-color: var(--border-color);">
                <h3 class="text-heading font-semibold text-sm">Verify Request</h3>
                <button onclick="closeVerifyModal()" class="text-gray-400 hover:text-red-500 transition">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>
            <div class="p-6">
                <form id="verifyForm" onsubmit="confirmVerify(event)">
                    <input type="hidden" id="verifyRequestId" value="">
                    <input type="hidden" id="verifyDealerSap" value="">
                    <input type="hidden" id="verifyImei" value="">
                    <input type="hidden" id="verifyUserId" value="1">
                    
                    <div class="mb-4">
                        <label class="form-label">User Name</label>
                        <p class="text-heading text-sm" id="verifyUserName">-</p>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label">Device Authentication</label>
                        <p class="device-auth font-mono text-xs break-all" id="verifyDeviceAuth">-</p>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label">Status</label>
                        <select id="verifyStatus" class="form-select">
                            <option value="1">Verified</option>
                            <option value="0">Not Verified</option>
                            <option value="2">Reject</option>
                        </select>
                    </div>

                    <div class="flex gap-3 mt-4 pt-3 border-t" style="border-color: var(--border-color);">
                        <button type="submit" class="btn-success flex-1">Save</button>
                        <button type="button" onclick="closeVerifyModal()" class="btn-secondary">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- DELETE CONFIRMATION MODAL -->
    <div id="deleteModal"
        class="fixed inset-0 z-50 hidden backdrop-blur-sm flex items-center justify-center transition-opacity duration-300 opacity-0">
        <div class="border rounded-lg shadow-2xl w-full max-w-sm transform scale-95 transition-transform duration-300"
            id="deleteModalWrapper">
            <div class="p-6 text-center">
                <div class="w-14 h-14 bg-red-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid fa-trash-can text-red-500 text-2xl"></i>
                </div>
                <h3 class="text-heading font-semibold text-base mb-2">Delete Request</h3>
                <p class="text-gray-400 text-sm mb-6">Are you sure you want to delete this verification request? This action cannot be undone.</p>
                <input type="hidden" id="deleteRequestId">
                <div class="flex gap-3">
                    <button onclick="confirmDelete()" class="btn-danger flex-1">Delete</button>
                    <button onclick="closeDeleteModal()" class="btn-secondary flex-1">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <!-- TOAST NOTIFICATION -->
    <div id="toast" class="toast">
        <i class="fa-solid fa-check-circle mr-2"></i>
        <span id="toastMessage">Success!</span>
    </div>

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

            fetchVerificationRequests();

            // Close dropdown on outside click
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.column-visibility-dropdown').length) {
                    closeColumnDropdown();
                }
            });
        });

        let dataTable = null;
        const API_BASE_URL = 'api/';

        // ============================================
        // Column Visibility Configuration
        // ============================================
        const columnConfig = [
            { idx: 0, label: 'S.No' },
            { idx: 1, label: 'User Name' },
            { idx: 2, label: 'Contact' },
            { idx: 3, label: 'Device Authentication' },
            { idx: 4, label: 'Is-Verify' },
            { idx: 5, label: 'Verify Time' },
            { idx: 6, label: 'Request Time' },
            { idx: 7, label: 'Action' },
            { idx: 8, label: 'Delete' }
        ];

        // ============================================
        // Dropdown Functions
        // ============================================
        function toggleColumnDropdown() {
            const menu = $('#columnDropdownMenu');
            menu.toggleClass('show');
            if (menu.hasClass('show')) {
                populateColumnDropdown();
            }
        }

        function closeColumnDropdown() {
            const menu = $('#columnDropdownMenu');
            menu.removeClass('show');
        }

        // ============================================
        // Populate Column Visibility Dropdown
        // ============================================
        function populateColumnDropdown() {
            const container = $('#columnListItems');
            container.empty();

            columnConfig.forEach(function(col) {
                let isVisible = true;
                try {
                    isVisible = dataTable.column(col.idx).visible();
                } catch(e) {
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

        // ============================================
        // Column Visibility Functions
        // ============================================
        function toggleColumnVisibility(colIdx) {
            if (!dataTable) return;
            try {
                const isVisible = dataTable.column(colIdx).visible();
                dataTable.column(colIdx).visible(!isVisible);
                const checkbox = $(`#col-checkbox-${colIdx}`);
                checkbox.prop('checked', !isVisible);
            } catch(e) {
                console.warn('Column visibility toggle error:', e);
            }
        }

        function selectAllColumns() {
            if (!dataTable) return;
            try {
                columnConfig.forEach(function(col) {
                    if (!dataTable.column(col.idx).visible()) {
                        dataTable.column(col.idx).visible(true);
                    }
                    $(`#col-checkbox-${col.idx}`).prop('checked', true);
                });
                showToast('All columns selected!', 'success');
            } catch(e) {
                console.warn('Select all columns error:', e);
                showToast('Error selecting columns', 'error');
            }
        }

        function deselectAllColumns() {
            if (!dataTable) return;
            try {
                columnConfig.forEach(function(col) {
                    if (dataTable.column(col.idx).visible()) {
                        dataTable.column(col.idx).visible(false);
                    }
                    $(`#col-checkbox-${col.idx}`).prop('checked', false);
                });
                showToast('All columns deselected!', 'success');
            } catch(e) {
                console.warn('Deselect all columns error:', e);
                showToast('Error deselecting columns', 'error');
            }
        }

        function formatDateTime(dateStr) {
            if (!dateStr || dateStr === '0000-00-00 00:00:00') return '-';
            const date = new Date(dateStr);
            return date.toLocaleString('en-US', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: false
            }).replace(/\//g, '-');
        }

        function getBadgeClass(status) {
            if (status == 1) return 'badge-verified';
            if (status == 0) return 'badge-pending';
            if (status == 2) return 'badge-rejected';
            return 'badge-pending';
        }

        function getStatusText(status) {
            if (status == 1) return 'Verified';
            if (status == 0) return 'Not-verified';
            if (status == 2) return 'Reject';
            return 'Unknown';
        }

        function fetchVerificationRequests() {
            $('#verificationRequestsTableBody').html(`
                <tr>
                    <td colspan="9" class="text-center py-8 text-gray-500">
                        <i class="fa-solid fa-spinner fa-spin text-blue-400 mr-2"></i>
                        Loading requests...
                    </td>
                </tr>
            `);

            $.ajax({
                url: API_BASE_URL + 'get/get_dealer_verification.php?key=03201232927&id=1',
                type: 'GET',
                dataType: 'json',
                timeout: 30000,
                success: function(response) {
                    if (response && Array.isArray(response)) {
                        initializeDataTable(response);
                    } else {
                        showToast('No verification requests found.', 'error');
                        initializeDataTable([]);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('API Error:', status, error);
                    showToast('Failed to load verification requests.', 'error');
                    initializeDataTable([]);
                }
            });
        }

        function initializeDataTable(data) {
            if ($.fn.DataTable.isDataTable('#verificationRequestsTable')) {
                $('#verificationRequestsTable').DataTable().destroy();
            }

            const tableData = data.map((request, index) => {
                const badgeClass = getBadgeClass(request.is_verify);
                const statusText = getStatusText(request.is_verify);
                
                let actionHtml = '';
                if (request.is_verify == 1) {
                    actionHtml = '<span class="text-green-500 text-xs font-semibold">Verified</span>';
                } else {
                    actionHtml = `<span class="action-icon verify" title="Verify" onclick="openVerifyModal(${request.id})">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </span>`;
                }

                return [
                    index + 1,
                    request.user_name || 'N/A',
                    request.contact || 'N/A',
                    `<span class="font-mono device-auth text-[9px] break-all">${request.imei || 'N/A'}</span>`,
                    `<span class="badge ${badgeClass}">${statusText}</span>`,
                    formatDateTime(request.verify_time),
                    formatDateTime(request.created_at),
                    actionHtml,
                    `<span class="action-icon delete" title="Delete" onclick="openDeleteModal(${request.id})">
                        <i class="fa-regular fa-trash-can"></i>
                    </span>`
                ];
            });

            dataTable = $('#verificationRequestsTable').DataTable({
                data: tableData,
                columns: [
                    { title: 'S.No' },
                    { title: 'User Name' },
                    { title: 'Contact' },
                    { title: 'Device Authentication' },
                    { title: 'Is-Verify' },
                    { title: 'Verify Time' },
                    { title: 'Request Time' },
                    { title: 'Action', orderable: false, searchable: false },
                    { title: 'Delete', orderable: false, searchable: false }
                ],
                dom: 'Bfrtip',
                buttons: [
                    { extend: 'copy', text: '<i class="fa-regular fa-copy"></i> Copy', className: 'toolbar-btn', exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6] } },
                    { extend: 'excelHtml5', text: '<i class="fa-regular fa-file-excel"></i> Excel', className: 'toolbar-btn', exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6] }, title: 'Verification_Requests' },
                    { extend: 'csvHtml5', text: '<i class="fa-regular fa-file-csv"></i> CSV', className: 'toolbar-btn', exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6] }, title: 'Verification_Requests' },
                    { extend: 'pdfHtml5', text: '<i class="fa-regular fa-file-pdf"></i> PDF', className: 'toolbar-btn', exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6] }, title: 'Verification Requests Report', orientation: 'landscape', pageSize: 'A4', customize: function(doc) {
                        doc.defaultStyle.fontSize = 8;
                        doc.styles.tableHeader.fontSize = 9;
                        doc.styles.tableHeader.fillColor = '#0a121c';
                        doc.styles.tableHeader.color = '#ffffff';
                    }},
                    { extend: 'print', text: '<i class="fa-solid fa-print"></i> Print', className: 'toolbar-btn', exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6] } }
                ],
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100],
                ordering: true,
                order: [[0, 'asc']],
                language: {
                    emptyTable: '<div class="text-center py-8 text-gray-500"><i class="fa-solid fa-shield-halved text-2xl block mb-2"></i>No verification requests found</div>',
                    info: 'Showing _START_ to _END_ of _TOTAL_ entries',
                    infoEmpty: 'Showing 0 to 0 of 0 entries',
                    infoFiltered: '(filtered from _MAX_ total entries)',
                    search: 'Search:'
                },
                drawCallback: function() {
                    $('.dt-buttons .dt-button').each(function() {
                        $(this).addClass('toolbar-btn');
                    });
                },
                initComplete: function() {
                    // Move Buttons to left container
                    const buttonsContainer = $('#exportButtonsContainer');
                    $('.dt-buttons').appendTo(buttonsContainer);

                    // Move Search to right container
                    const searchContainer = $('#searchContainer');
                    const searchFilter = $('.dataTables_filter');
                    searchFilter.appendTo(searchContainer);
                    
                    // Apply proper styling to search filter
                    searchFilter.css({
                        'float': 'none',
                        'text-align': 'left',
                        'margin': '0',
                        'padding': '0'
                    });
                    
                    // Style the search label
                    searchFilter.find('label').css({
                        'display': 'flex',
                        'align-items': 'center',
                        'gap': '8px',
                        'margin': '0',
                        'padding': '0',
                        'font-size': '11px',
                        'color': 'var(--text-muted)',
                        'font-weight': '500'
                    });
                    
                    // Style the search input
                    searchFilter.find('input').css({
                        'display': 'inline-block',
                        'padding': '6px 12px',
                        'border': '1px solid var(--border-color)',
                        'border-radius': '0.25rem',
                        'background-color': 'var(--input-bg)',
                        'color': 'var(--text-body)',
                        'font-size': '11px',
                        'outline': 'none',
                        'height': '30px',
                        'box-sizing': 'border-box'
                    });

                    // Populate column dropdown
                    populateColumnDropdown();
                }
            });
        }

        function openVerifyModal(id) {
            $.ajax({
                url: API_BASE_URL + 'get/get_verify_request_by_id.php?key=03201232927&id=' + id,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response && response.length > 0) {
                        const data = response[0];
                        $('#verifyRequestId').val(data.id);
                        $('#verifyDealerSap').val(data.user_id || '');
                        $('#verifyImei').val(data.imei || '');
                        $('#verifyUserName').text(data.user_name || 'N/A');
                        $('#verifyDeviceAuth').text(data.imei || 'N/A');
                        $('#verifyStatus').val(data.is_verify !== undefined ? data.is_verify : 0);

                        const modal = $('#verifyModal');
                        modal.removeClass('hidden').addClass('flex');
                        setTimeout(function() {
                            modal.removeClass('opacity-0');
                            $('#verifyModalWrapper').removeClass('scale-95').addClass('scale-100');
                        }, 10);
                    } else {
                        showToast('Request not found.', 'error');
                    }
                },
                error: function() {
                    showToast('Error loading request details.', 'error');
                }
            });
        }

        function closeVerifyModal() {
            const modal = $('#verifyModal');
            modal.addClass('opacity-0');
            $('#verifyModalWrapper').removeClass('scale-100').addClass('scale-95');
            setTimeout(function() {
                modal.addClass('hidden').removeClass('flex');
            }, 300);
        }

        function confirmVerify(event) {
            event.preventDefault();

            const formData = new FormData();
            formData.append('row_id', $('#verifyRequestId').val());
            formData.append('dealer_sap', $('#verifyDealerSap').val());
            formData.append('imei', $('#verifyImei').val());
            formData.append('user_id', $('#verifyUserId').val());
            formData.append('name', $('#verifyStatus').val());

            const submitBtn = $('#verifyForm button[type="submit"]');
            submitBtn.prop('disabled', true);
            submitBtn.html('<i class="fa-solid fa-spinner fa-spin mr-1"></i> Saving...');

            $.ajax({
                url: API_BASE_URL + 'update/verify_dealer_request.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(response) {
                    submitBtn.prop('disabled', false);
                    submitBtn.html('Save');

                    if (response == 1) {
                        showToast('Request verified successfully!', 'success');
                        closeVerifyModal();
                        fetchVerificationRequests();
                    } else {
                        showToast('Failed to update request. Please try again.', 'error');
                    }
                },
                error: function(xhr, status, error) {
                    submitBtn.prop('disabled', false);
                    submitBtn.html('Save');
                    console.error('Verify Error:', status, error);
                    showToast('Error updating request: ' + status, 'error');
                }
            });
        }

        function openDeleteModal(id) {
            $('#deleteRequestId').val(id);
            const modal = $('#deleteModal');
            modal.removeClass('hidden').addClass('flex');
            setTimeout(function() {
                modal.removeClass('opacity-0');
                $('#deleteModalWrapper').removeClass('scale-95').addClass('scale-100');
            }, 10);
        }

        function closeDeleteModal() {
            const modal = $('#deleteModal');
            modal.addClass('opacity-0');
            $('#deleteModalWrapper').removeClass('scale-100').addClass('scale-95');
            setTimeout(function() {
                modal.addClass('hidden').removeClass('flex');
            }, 300);
        }

        function confirmDelete() {
            const id = $('#deleteRequestId').val();

            const deleteBtn = $('#deleteModal .btn-danger');
            deleteBtn.prop('disabled', true);
            deleteBtn.html('<i class="fa-solid fa-spinner fa-spin mr-1"></i> Deleting...');

            $.ajax({
                url: API_BASE_URL + 'delete/delete_verify_request.php?key=03201232927&id=' + id,
                type: 'GET',
                timeout: 30000,
                success: function(response) {
                    deleteBtn.prop('disabled', false);
                    deleteBtn.html('Delete');

                    if (response == 1) {
                        showToast('Request deleted successfully!', 'success');
                        closeDeleteModal();
                        fetchVerificationRequests();
                    } else {
                        showToast('Failed to delete request. Please try again.', 'error');
                    }
                },
                error: function(xhr, status, error) {
                    deleteBtn.prop('disabled', false);
                    deleteBtn.html('Delete');
                    console.error('Delete Error:', status, error);
                    showToast('Error deleting request: ' + status, 'error');
                }
            });
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

        // Close dropdown on ESC key
        $(document).on('keydown', function(e) {
            if (e.key === 'Escape') {
                if (!$('#verifyModal').hasClass('hidden')) {
                    closeVerifyModal();
                }
                if (!$('#deleteModal').hasClass('hidden')) {
                    closeDeleteModal();
                }
                closeColumnDropdown();
            }
        });

        $(document).on('click', '#verifyModal', function(e) {
            if (e.target === this) closeVerifyModal();
        });

        $(document).on('click', '#deleteModal', function(e) {
            if (e.target === this) closeDeleteModal();
        });
    </script>

</body>

</html>