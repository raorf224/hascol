<?php
// Hascol OMC Operations Command Center - Dealer Location Request
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hascol OMC - Dealer Location Request</title>
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
            --modal-footer-bg: #f8fafc;
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
            --modal-footer-bg: #0a121c;
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

        .action-icon.delete:hover {
            background: #ef444420;
            color: #ef4444;
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

        /* View Modal */
        #viewModal {
            background: var(--modal-overlay);
            backdrop-filter: blur(8px);
        }

        #viewModalWrapper {
            background-color: var(--bg-panel) !important;
            border-color: var(--border-color) !important;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35);
        }

        html.dark-mode #viewModalWrapper {
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.8);
        }

        #viewModalWrapper .border-b {
            border-color: var(--border-color) !important;
        }

        #viewModalWrapper .border-t {
            border-color: var(--border-color) !important;
        }

        #viewModalWrapper .bg-\[\#09101a\] {
            background-color: var(--modal-footer-bg) !important;
        }

        /* Delete Modal */
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

        /* Badge styles */
        .badge {
            padding: 2px 8px;
            border-radius: 9999px;
            font-size: 8px;
            font-weight: 600;
            display: inline-block;
        }

        .badge-request {
            background: #3b82f620;
            color: #3b82f6;
            border: 1px solid #3b82f640;
        }
    </style>
</head>

<body class="flex h-screen overflow-hidden text-xs">

    <!-- SIDEBAR - Included from includes/sidebar.php  -->
    <?php include 'includes/sidebar.php'; ?>

    <!-- MAIN CONTENT -->
    <main id="mainContent" class="flex-1 flex flex-col overflow-hidden">

        <!-- TOPBAR - Included from includes/topbar.php   -->
        <?php include 'includes/topbar.php'; ?>

        <!-- PAGE CONTENT -->
        <div class="flex-1 overflow-y-auto p-4" id="pageContent">

            <!-- Page Header -->
            <div class="flex justify-between items-center mb-4">
                <div>
                    <h2 class="text-heading font-semibold text-base tracking-wide uppercase">Dealer Location Request</h2>
                    <p class="text-[10px] text-gray-500">Manage dealer location requests and coordinates</p>
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
                        <input type="text" id="customSearchInput" placeholder="Search requests..." class="search-input">
                    </div>
                </div>
            </div>

            <!-- Location Requests Table -->
            <div class="panel-card overflow-hidden">
                <div class="table-container">
                    <table id="locationRequestsTable" class="display" style="width:100%;">
                        <thead>
                            <tr>
                                <th style="width:50px;">S.No</th>
                                <th style="min-width:150px;">Dealer Name</th>
                                <th style="min-width:120px;">Request By</th>
                                <th style="min-width:180px;">Coordinates</th>
                                <th style="min-width:150px;">Request At</th>
                                <th style="width:60px; text-align:center;">View</th>
                                <th style="width:60px; text-align:center;">Delete</th>
                            </tr>
                        </thead>
                        <tbody id="locationRequestsTableBody">
                            <tr>
                                <td colspan="7" class="text-center py-8 text-gray-500">
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

    <!-- VIEW MODAL -->
    <div id="viewModal"
        class="fixed inset-0 z-50 hidden backdrop-blur-sm flex items-center justify-center transition-opacity duration-300 opacity-0">
        <div class="border rounded-lg shadow-2xl w-full max-w-lg transform scale-95 transition-transform duration-300"
            id="viewModalWrapper">
            <div class="flex justify-between items-center p-4 border-b" style="border-color: var(--border-color);">
                <h3 class="text-heading font-semibold text-sm">Location Request Details</h3>
                <button onclick="closeViewModal()" class="text-gray-400 hover:text-red-500 transition">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>
            <div class="p-6" id="viewModalBody">
                <!-- Content will be populated dynamically -->
            </div>
            <div class="p-3 border-t text-right rounded-b-lg" style="border-color: var(--border-color); background-color: var(--modal-footer-bg);">
                <button onclick="closeViewModal()" class="btn-secondary">Close</button>
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
                <p class="text-gray-400 text-sm mb-6">Are you sure you want to delete this location request? This action cannot be undone.</p>
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

    <!-- JAVASCRIPT -->
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
                if ($.fn.DataTable.isDataTable('#locationRequestsTable')) {
                    $('#locationRequestsTable').DataTable().search(searchTerm).draw();
                }
            });

            loadLocationRequests();
        });

        const API_BASE_URL = 'api/';
        const API_KEY = '03201232927';
        const USER_ID = '1';

        let locationRequestsData = [];
        let dataTable = null;

        // Format Date for Display
        function formatDateTime(dateStr) {
            if (!dateStr) return '';
            const date = new Date(dateStr);
            return date.toLocaleString('en-US', {
                year: 'numeric',
                month: 'short',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: true
            });
        }

        // Load Location Requests - API Integration
        function loadLocationRequests() {
            const url = `${API_BASE_URL}/get/get_dealers_location_request.php?key=${API_KEY}&id=${USER_ID}`;

            // Show loading state
            $('#locationRequestsTableBody').html(`
                <tr>
                    <td colspan="7" class="text-center py-8 text-gray-500">
                        <i class="fa-solid fa-spinner fa-spin text-blue-400 mr-2"></i>
                        Loading requests...
                    </td>
                </tr>
            `);

            $.ajax({
                url: url,
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    console.log('API Response:', response);
                    
                    if (response && Array.isArray(response)) {
                        locationRequestsData = response.map((item, index) => {
                            return {
                                id: item.id,
                                dealerName: item.dealer_name || 'N/A',
                                requestBy: item.username || 'N/A',
                                coordinates: (item.coordinates && item.coordinates !== 'null') 
                                    ? item.coordinates 
                                    : 'Error',
                                requestAt: item.created_at || '',
                                index: index + 1
                            };
                        });
                        
                        initializeDataTable();
                    } else {
                        // Handle empty or invalid response
                        locationRequestsData = [];
                        initializeDataTable();
                        showToast('No location requests found', 'error');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('API Error:', error);
                    $('#locationRequestsTableBody').html(`
                        <tr>
                            <td colspan="7" class="text-center py-8 text-red-500">
                                <i class="fa-solid fa-circle-exclamation mr-2"></i>
                                Failed to load requests. Please try again.
                            </td>
                        </tr>
                    `);
                    showToast('Failed to load location requests', 'error');
                }
            });
        }

        // Initialize DataTable with Export Buttons
        function initializeDataTable() {
            if ($.fn.DataTable.isDataTable('#locationRequestsTable')) {
                $('#locationRequestsTable').DataTable().destroy();
            }

            const tableData = locationRequestsData.map((request) => {
                return [
                    request.index,
                    request.dealerName,
                    request.requestBy,
                    request.coordinates,
                    formatDateTime(request.requestAt),
                    `<span class="action-icon view" title="View/Approve" onclick="openViewModal(${request.id})">
                        <i class="fa-regular fa-eye"></i>
                     </span>`,
                    `<span class="action-icon delete" title="Delete" onclick="openDeleteModal(${request.id})">
                        <i class="fa-regular fa-trash-can"></i>
                     </span>`
                ];
            });

            dataTable = $('#locationRequestsTable').DataTable({
                data: tableData,
                columns: [
                    { title: 'S.No' },
                    { title: 'Dealer Name' },
                    { title: 'Request By' },
                    { title: 'Coordinates' },
                    { title: 'Request At' },
                    { title: 'View', orderable: false, searchable: false },
                    { title: 'Delete', orderable: false, searchable: false }
                ],
                dom: 'Bfrtip',
                buttons: [
                    { extend: 'copy', text: '<i class="fa-regular fa-copy"></i> Copy', className: 'toolbar-btn', exportOptions: { columns: [0,1,2,3,4] } },
                    { extend: 'excelHtml5', text: '<i class="fa-regular fa-file-excel"></i> Excel', className: 'toolbar-btn', exportOptions: { columns: [0,1,2,3,4] }, title: 'Dealer_Location_Requests' },
                    { extend: 'csvHtml5', text: '<i class="fa-regular fa-file-csv"></i> CSV', className: 'toolbar-btn', exportOptions: { columns: [0,1,2,3,4] }, title: 'Dealer_Location_Requests' },
                    { extend: 'pdfHtml5', text: '<i class="fa-regular fa-file-pdf"></i> PDF', className: 'toolbar-btn', exportOptions: { columns: [0,1,2,3,4] }, title: 'Dealer Location Requests Report', orientation: 'landscape', pageSize: 'A4', customize: function(doc) { doc.defaultStyle.fontSize = 9; doc.styles.tableHeader.fontSize = 10; doc.styles.tableHeader.fillColor = '#0a121c'; doc.styles.tableHeader.color = '#ffffff'; } },
                    { extend: 'print', text: '<i class="fa-solid fa-print"></i> Print', className: 'toolbar-btn', exportOptions: { columns: [0,1,2,3,4] } }
                ],
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100],
                ordering: true,
                order: [[0, 'asc']],
                language: {
                    emptyTable: '<div class="text-center py-8 text-gray-500"><i class="fa-solid fa-location-dot text-2xl block mb-2"></i>No location requests found</div>',
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

        // View Modal - Redirect to Approval Page
        function openViewModal(id) {
            // Redirect to approval page - matches live version behavior
            window.open(`dealers_location_approve.php?id=${id}`, '_blank');
        }

        function closeViewModal() {
            const modal = $('#viewModal');
            modal.addClass('opacity-0');
            $('#viewModalWrapper').removeClass('scale-100').addClass('scale-95');
            setTimeout(function() {
                modal.addClass('hidden').removeClass('flex');
            }, 300);
        }

        // Delete Modal
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

        // Confirm Delete - API Integration
    function confirmDelete() {
    const id = parseInt($('#deleteRequestId').val());
    
    if (!id) {
        showToast('Invalid request ID', 'error');
        return;
    }

    const url = `${API_BASE_URL}/delete/delete_extra_location_req.php?key=${API_KEY}&id=${id}`;

    // Show loading state on button
    const deleteBtn = document.querySelector('.btn-danger');
    const originalText = deleteBtn.textContent;
    deleteBtn.textContent = 'Deleting...';
    deleteBtn.disabled = true;

    $.ajax({
        url: url,
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            console.log('Delete Response:', response);
            console.log('Response Type:', typeof response);
            console.log('Response Value:', JSON.stringify(response));
            
            const isSuccess = (
                response === 1 || 
                response === '1' || 
                (typeof response === 'string' && response.trim() === '1') ||
                (typeof response === 'number' && response === 1) ||
                (response && response.status === 'success') ||
                (response && response.success === true)
            );
            
            console.log('Is Success:', isSuccess);
            
            if (isSuccess) {
                closeDeleteModal();
                showToast('Location request deleted successfully!', 'success');
                // Reload the table data
                loadLocationRequests();
            } else {
                // Check if there's an error message in response
                let errorMsg = 'Failed to delete location request';
                if (response && response.message) {
                    errorMsg = response.message;
                } else if (response && response.error) {
                    errorMsg = response.error;
                }
                showToast(errorMsg, 'error');
            }
        },
        error: function(xhr, status, error) {
            console.error('Delete Error:', error);
            console.error('XHR Response:', xhr.responseText);
            console.error('Status:', status);
            
            let errorMsg = 'Server error: Failed to delete request';
            
            // Try to parse error response
            try {
                const errorResponse = JSON.parse(xhr.responseText);
                if (errorResponse && errorResponse.message) {
                    errorMsg = errorResponse.message;
                }
            } catch(e) {
                if (xhr.responseText) {
                    errorMsg = xhr.responseText;
                }
            }
            
            showToast(errorMsg, 'error');
        },
        complete: function() {
            // Reset button state
            deleteBtn.textContent = originalText;
            deleteBtn.disabled = false;
        }
    });
}


        // Toast Notification
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
        $(document).on('click', '#viewModal', function(e) {
            if (e.target === this) closeViewModal();
        });

        $(document).on('click', '#deleteModal', function(e) {
            if (e.target === this) closeDeleteModal();
        });

        // Close modal on ESC key
        $(document).on('keydown', function(e) {
            if (e.key === 'Escape') {
                if (!$('#viewModal').hasClass('hidden')) {
                    closeViewModal();
                }
                if (!$('#deleteModal').hasClass('hidden')) {
                    closeDeleteModal();
                }
            }
        });
    </script>

</body>

</html>