<?php
// Hascol OMC Operations Command Center - Dealers Accounts
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hascol OMC - Dealers Accounts</title>
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
    
    <!-- ============================================ -->
    <!-- CRYPTOJS - For AES Encryption                -->
    <!-- ============================================ -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/crypto-js.js"></script>

    <script>
        // Yeh code sab se pehle run hoga - flash effect nahi aayega
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
        /* ============================================ */
        /* THEME VARIABLES                               */
        /* ============================================ */
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
            --modal-overlay: rgba(6, 11, 19, 0.85);
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

        /* Sidebar Collapsed State */
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

        /* Table Styles */
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

        /* DataTables Custom Styles */
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

        /* DataTables Buttons */
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
        }

        .dt-buttons .dt-button:hover {
            background-color: var(--hover-bg) !important;
            color: var(--text-heading) !important;
        }

        .dataTables_filter {
            display: none !important;
        }

        /* Search Input */
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

        .search-input:focus {
            border-color: #1d4ed8;
            box-shadow: 0 0 0 2px rgba(29, 78, 216, 0.2);
        }

        .search-input::placeholder {
            color: var(--text-muted);
        }

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

        /* Badge styles */
        .badge {
            padding: 2px 8px;
            border-radius: 9999px;
            font-size: 8px;
            font-weight: 600;
            display: inline-block;
        }

        .badge-active {
            background: #10b98120;
            color: #10b981;
            border: 1px solid #10b98140;
        }

        .badge-inactive {
            background: #ef444420;
            color: #ef4444;
            border: 1px solid #ef444440;
        }

        /* Modal Styles */
        .modal-overlay {
            background: var(--modal-overlay);
            backdrop-filter: blur(4px);
        }

        .modal-panel {
            background-color: var(--bg-panel);
            border: 1px solid var(--border-color);
            border-radius: 0.375rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35);
        }

        .modal-panel .modal-header {
            border-bottom: 1px solid var(--border-color);
            padding: 12px 20px;
        }

        .modal-panel .modal-body {
            padding: 20px;
        }

        .modal-panel .modal-footer {
            border-top: 1px solid var(--border-color);
            padding: 12px 20px;
            background-color: var(--modal-footer-bg);
        }

        /* Action Icon */
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

        .action-icon.view:hover {
            background: #3b82f620;
            color: #3b82f6;
        }

        /* View Button Style - Matches Live */
        .btn-view {
            background-color: #f59e0b20;
            color: #f59e0b;
            padding: 4px 10px;
            border-radius: 0.25rem;
            border: 1px solid #f59e0b40;
            font-size: 10px;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            text-decoration: none;
        }

        .btn-view:hover {
            background-color: #f59e0b;
            color: #ffffff;
        }
    </style>
</head>

<body class="flex h-screen overflow-hidden text-xs">

    <!-- ============================================ -->
    <!-- SIDEBAR - Included from includes/sidebar.php  -->
    <!-- ============================================ -->
    <?php include 'includes/sidebar.php'; ?>

    <!-- ============================================ -->
    <!-- MAIN CONTENT                                  -->
    <!-- ============================================ -->
    <main id="mainContent" class="flex-1 flex flex-col overflow-hidden">

        <!-- ============================================ -->
        <!-- TOPBAR - Included from includes/topbar.php   -->
        <!-- ============================================ -->
        <?php include 'includes/topbar.php'; ?>

        <!-- ============================================ -->
        <!-- PAGE CONTENT                                 -->
        <!-- ============================================ -->
        <div class="flex-1 overflow-y-auto p-4" id="pageContent">

            <!-- Page Header -->
            <div class="flex justify-between items-center mb-4">
                <div>
                    <h2 class="text-heading font-semibold text-base tracking-wide uppercase">Dealers Accounts</h2>
                    <p class="text-[10px] text-gray-500">Manage dealer accounts and profiles</p>
                </div>
                <div>
                    <button onclick="openAddModal()" class="btn-primary">
                        <i class="fa-solid fa-plus mr-2"></i> Add Dealer
                    </button>
                </div>
            </div>

            <!-- Toolbar -->
            <div class="panel-card p-3 mb-4 flex flex-wrap items-center justify-between gap-2">
                <div class="flex items-center gap-2 flex-wrap" id="exportButtonsContainer">
                    <!-- DataTables Buttons will be placed here -->
                </div>
                <div class="flex items-center gap-2">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-magnifying-glass text-gray-500 text-xs"></i>
                        <input type="text" id="customSearchInput" placeholder="Search dealers..." class="search-input">
                    </div>
                </div>
            </div>

            <!-- Dealers Table -->
            <div class="panel-card overflow-hidden">
                <div class="table-container">
                    <table id="dealersTable" class="display" style="width:100%;">
                        <thead>
                            <tr>
                                <th style="width:50px;">S.No</th>
                                <th style="min-width:180px;">Site Name</th>
                                <th style="min-width:120px;">JD Code</th>
                                <th style="min-width:130px;">Cell No</th>
                                <th style="min-width:130px;">Ledger Balance</th>
                                <th style="min-width:130px;">Payable</th>
                                <th style="min-width:130px;">RM</th>
                                <th style="min-width:130px;">TM</th>
                                <th style="width:80px; text-align:center;">View</th>
                            </tr>
                        </thead>
                        <tbody id="dealersTableBody">
                            <tr>
                                <td colspan="9" class="text-center py-8 text-gray-500">
                                    <i class="fa-solid fa-spinner fa-spin text-blue-400 mr-2"></i>
                                    Loading dealers...
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>

    <!-- ============================================ -->
    <!-- EDIT PASSWORD MODAL                          -->
    <!-- ============================================ -->
    <div id="editPasswordModal" class="fixed inset-0 z-50 hidden modal-overlay flex items-center justify-center opacity-0 transition-opacity duration-300">
        <div class="modal-panel w-full max-w-md transform scale-95 transition-transform duration-300">
            <div class="modal-header flex justify-between items-center">
                <h3 class="text-heading font-semibold text-sm">Edit Password</h3>
                <button onclick="closePasswordModal()" class="text-gray-400 hover:text-red-500 transition">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="passwordForm">
                    <div class="mb-4">
                        <label class="text-gray-500 text-[10px] uppercase tracking-wide">New Password</label>
                        <input type="text" id="editPassword" class="search-input w-full mt-1" placeholder="Enter new password" required>
                    </div>
                    <input type="hidden" id="dealerRowId">
                    <div class="flex justify-end gap-2 mt-4">
                        <button type="button" onclick="closePasswordModal()" class="btn-secondary">Cancel</button>
                        <button type="submit" class="btn-primary" id="updatePassBtn">Update Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ============================================ -->
    <!-- TOAST NOTIFICATION                           -->
    <!-- ============================================ -->
    <div id="toast" class="toast">
        <i class="fa-solid fa-check-circle mr-2"></i>
        <span id="toastMessage">Success!</span>
    </div>

    <!-- ============================================ -->
    <!-- JAVASCRIPT                                   -->
    <!-- ============================================ -->
    <script>
        $(document).ready(function() {
            // Sidebar Toggle
            $('#sidebarToggle').on('click', function() {
                $('#sidebar').toggleClass('collapsed');
                const isCollapsed = $('#sidebar').hasClass('collapsed');
                localStorage.setItem('sidebarCollapsed', isCollapsed);
            });

            const savedState = localStorage.getItem('sidebarCollapsed');
            if (savedState === 'true') {
                $('#sidebar').addClass('collapsed');
            }

            // Custom Search
            $('#customSearchInput').on('keyup', function() {
                const searchTerm = $(this).val();
                if ($.fn.DataTable.isDataTable('#dealersTable')) {
                    $('#dealersTable').DataTable().search(searchTerm).draw();
                }
            });

            // Password Form Submit
            $('#passwordForm').on('submit', function(e) {
                e.preventDefault();
                updatePassword();
            });

            loadDealers();
        });

        // ============================================
        // API Configuration
        // ============================================
        const API_BASE_URL = 'api/';
        const API_KEY = '03201232927';
        const USER_ID = '1';

        // ============================================
        // Encryption Configuration (Matches Live)
        // ============================================
        const ENCRYPTION_KEY = 'Hamza Ansari';

        // ============================================
        // Encryption Functions (Matches Live)
        // ============================================
        function encryptId(originalId, key) {
            var iv = CryptoJS.lib.WordArray.random(16);
            var cipher = CryptoJS.AES.encrypt(originalId.toString(), key, {
                iv: iv
            });
            return cipher.toString();
        }

        function decryptId(encryptedId, key) {
            try {
                var iv = CryptoJS.lib.WordArray.random(16);
                var decrypted = CryptoJS.AES.decrypt(encryptedId, key, {
                    iv: iv
                });
                return decrypted.toString(CryptoJS.enc.Utf8);
            } catch(e) {
                return encryptedId;
            }
        }

        // ============================================
        // Data Store
        // ============================================
        let dealersData = [];
        let dataTable = null;

        // ============================================
        // Format Functions
        // ============================================
        function formatCurrency(value) {
            if (!value) return '0';
            return parseFloat(value).toLocaleString();
        }

        function capitalizeFirstLetter(str) {
            if (!str) return '';
            return str.toLowerCase().replace(/(?:^|\s)\S/g, function(a) { return a.toUpperCase(); });
        }

        // ============================================
        // Load Dealers - API Integration
        // ============================================
        function loadDealers() {
            const url = `${API_BASE_URL}/get/dealers.php?key=${API_KEY}&pre=Admin&user_id=${USER_ID}`;

            // Show loading state
            $('#dealersTableBody').html(`
                <tr>
                    <td colspan="9" class="text-center py-8 text-gray-500">
                        <i class="fa-solid fa-spinner fa-spin text-blue-400 mr-2"></i>
                        Loading dealers...
                    </td>
                </tr>
            `);

            $.ajax({
                url: url,
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    console.log('Dealers Response:', response);
                    
                    if (response && Array.isArray(response) && response.length > 0) {
                        dealersData = response.map((item, index) => {
                            return {
                                id: item.id,
                                name: item.name || 'N/A',
                                sapNo: item.sap_no || 'N/A',
                                contact: item.contact || 'N/A',
                                accountBalance: item.acount || 0,
                                payable: item.acount || 0,
                                tmName: item.tm_name || 'N/A',
                                asmName: item.asm_name || 'N/A',
                                index: index + 1
                            };
                        });
                        
                        initializeDataTable();
                        loadRegionDistrict();
                    } else {
                        dealersData = [];
                        initializeDataTable();
                        showToast('No dealers found', 'error');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('API Error:', error);
                    $('#dealersTableBody').html(`
                        <tr>
                            <td colspan="9" class="text-center py-8 text-red-500">
                                <i class="fa-solid fa-circle-exclamation mr-2"></i>
                                Failed to load dealers. Please try again.
                            </td>
                        </tr>
                    `);
                    showToast('Failed to load dealers', 'error');
                }
            });
        }

        // ============================================
        // Load Region & District Data
        // ============================================
        function loadRegionDistrict() {
            const url = `${API_BASE_URL}/get/get_region_district_dealers.php?key=${API_KEY}`;

            $.ajax({
                url: url,
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    console.log('Region/District Response:', response);
                },
                error: function(error) {
                    console.error('Error loading regions:', error);
                }
            });
        }

        // ============================================
        // Initialize DataTable with Export Buttons
        // ============================================
        function initializeDataTable() {
            if ($.fn.DataTable.isDataTable('#dealersTable')) {
                $('#dealersTable').DataTable().destroy();
            }

            const tableData = dealersData.map((dealer) => {
                // ============================================
                // ENCRYPT ID USING AES (Matches Live Code)
                // ============================================
                const encryptedId = encryptId(dealer.id, ENCRYPTION_KEY);
                
                return [
                    dealer.index,
                    capitalizeFirstLetter(dealer.name),
                    dealer.sapNo,
                    dealer.contact,
                    formatCurrency(dealer.accountBalance),
                    formatCurrency(dealer.payable),
                    dealer.tmName,
                    dealer.asmName,
                    // ============================================
                    // VIEW BUTTON WITH ENCRYPTED ID (Matches Live)
                    // ============================================
                    `<a type="button" id="View" name="view" 
                        href="dealers_acount_profile.php?id=${encodeURIComponent(encryptedId)}" 
                        target="_blank" 
                        class="btn-view">
                        <i class="fas fa-eye font-size-16 align-middle"></i>
                    </a>`
                ];
            });

            dataTable = $('#dealersTable').DataTable({
                data: tableData,
                columns: [
                    { title: 'S.No' },
                    { title: 'Site Name' },
                    { title: 'JD Code' },
                    { title: 'Cell No' },
                    { title: 'Ledger Balance' },
                    { title: 'Payable' },
                    { title: 'RM' },
                    { title: 'TM' },
                    { title: 'View', orderable: false, searchable: false }
                ],
                dom: 'Bfrtip',
                buttons: [
                    { extend: 'copy', text: '<i class="fa-regular fa-copy"></i> Copy', className: 'toolbar-btn', exportOptions: { columns: [0,1,2,3,4,5,6,7] } },
                    { extend: 'excelHtml5', text: '<i class="fa-regular fa-file-excel"></i> Excel', className: 'toolbar-btn', exportOptions: { columns: [0,1,2,3,4,5,6,7] }, title: 'Dealers_Accounts' },
                    { extend: 'csvHtml5', text: '<i class="fa-regular fa-file-csv"></i> CSV', className: 'toolbar-btn', exportOptions: { columns: [0,1,2,3,4,5,6,7] }, title: 'Dealers_Accounts' },
                    { extend: 'pdfHtml5', text: '<i class="fa-regular fa-file-pdf"></i> PDF', className: 'toolbar-btn', exportOptions: { columns: [0,1,2,3,4,5,6,7] }, title: 'Dealers Accounts Report', orientation: 'landscape', pageSize: 'A4', customize: function(doc) { doc.defaultStyle.fontSize = 9; doc.styles.tableHeader.fontSize = 10; doc.styles.tableHeader.fillColor = '#0a121c'; doc.styles.tableHeader.color = '#ffffff'; } },
                    { extend: 'print', text: '<i class="fa-solid fa-print"></i> Print', className: 'toolbar-btn', exportOptions: { columns: [0,1,2,3,4,5,6,7] } }
                ],
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100],
                ordering: true,
                order: [[0, 'asc']],
                language: {
                    emptyTable: '<div class="text-center py-8 text-gray-500"><i class="fa-solid fa-users text-2xl block mb-2"></i>No dealers found</div>',
                    info: 'Showing _START_ to _END_ of _TOTAL_ entries',
                    infoEmpty: 'Showing 0 to 0 of 0 entries',
                    infoFiltered: '(filtered from _MAX_ total entries)'
                },
                drawCallback: function() {
                    $('.dt-buttons .dt-button').each(function() {
                        $(this).addClass('toolbar-btn');
                    });
                },
                initComplete: function() {
                    const buttonsContainer = $('#exportButtonsContainer');
                    $('.dt-buttons').appendTo(buttonsContainer);
                }
            });
        }

        // ============================================
        // Open Add Dealer Modal
        // ============================================
        function openAddModal() {
            Swal.fire({
                icon: 'info',
                title: 'Add Dealer',
                text: 'Dealer creation form is available in the live version. Please use the live system to add dealers.',
                confirmButtonColor: '#1d4ed8'
            });
        }

        // ============================================
        // Open Password Modal
        // ============================================
        function openPasswordModal(id) {
            $('#dealerRowId').val(id);
            $('#editPassword').val('');
            const modal = $('#editPasswordModal');
            modal.removeClass('hidden').addClass('flex');
            setTimeout(function() {
                modal.removeClass('opacity-0');
                $('.modal-panel').removeClass('scale-95').addClass('scale-100');
            }, 10);
        }

        function closePasswordModal() {
            const modal = $('#editPasswordModal');
            modal.addClass('opacity-0');
            $('.modal-panel').removeClass('scale-100').addClass('scale-95');
            setTimeout(function() {
                modal.addClass('hidden').removeClass('flex');
            }, 300);
        }

        // ============================================
        // Update Password - API Integration
        // ============================================
        function updatePassword() {
            const id = $('#dealerRowId').val();
            const password = $('#editPassword').val();

            if (!password || password.trim() === '') {
                showToast('Please enter a password', 'error');
                return;
            }

            const url = `${API_BASE_URL}/update/update_dealers_password.php`;
            
            const updateBtn = $('#updatePassBtn');
            updateBtn.text('Saving...').prop('disabled', true);

            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    row_id: id,
                    edit_password: password
                },
                dataType: 'json',
                success: function(response) {
                    console.log('Password Update Response:', response);
                    
                    if (response && response !== 1) {
                        closePasswordModal();
                        showToast('Password updated successfully!', 'success');
                        loadDealers();
                    } else {
                        showToast('Failed to update password', 'error');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Update Error:', error);
                    showToast('Server error: Failed to update password', 'error');
                },
                complete: function() {
                    updateBtn.text('Update Password').prop('disabled', false);
                }
            });
        }

        // ============================================
        // Toast Notification
        // ============================================
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

        // Close modal on outside click
        $(document).on('click', '#editPasswordModal', function(e) {
            if (e.target === this) closePasswordModal();
        });

        // Close modal on ESC key
        $(document).on('keydown', function(e) {
            if (e.key === 'Escape') {
                if (!$('#editPasswordModal').hasClass('hidden')) {
                    closePasswordModal();
                }
            }
        });
    </script>

</body>

</html>