<?php
// Hascol OMC - Order Retailers Shortage
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Retailers Shortage</title>

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
            --toolbar-btn-bg: #060b13;
        }

        body {
            background-color: var(--bg-body);
            color: var(--text-muted);
            font-family: 'Inter', sans-serif;
            font-size: 12px;
        }

        .text-heading { color: var(--text-heading) !important; }

        .panel-card {
            background-color: var(--bg-panel);
            border: 1px solid var(--border-color);
            border-radius: 0.375rem;
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
            padding: 10px 12px;
            border-bottom: 1px solid var(--border-color);
            text-align: left;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table-container table tbody td {
            padding: 10px 12px;
            border-bottom: 1px solid var(--border-color);
            color: var(--table-row-text);
        }

        .table-container table tbody tr:hover { background-color: var(--table-row-hover); }

        .link-btn {
            color: #1d4ed8;
            /* text-decoration: underline; */
            cursor: pointer;
        }

        /* Toolbar */
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
            height: 30px;
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
            font-size: 11px;
            color: var(--text-body);
        }
        .column-visibility-dropdown .dropdown-menu .dropdown-item:hover { background-color: var(--hover-bg); }
        .column-visibility-dropdown .dropdown-menu .dropdown-item input[type="checkbox"] {
            width: 14px;
            height: 14px;
            accent-color: #1d4ed8;
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
        }
        .dropdown-actions button:hover { background: var(--hover-bg); color: var(--text-heading); }
        .dropdown-actions button.select-all-btn { border-color: #10b981; color: #10b981; }
        .dropdown-actions button.deselect-all-btn { border-color: #ef4444; color: #ef4444; }

        /* Forms & Buttons */
        .form-label {
            color: var(--text-muted);
            font-size: 11px;
            font-weight: 500;
            margin-bottom: 4px;
            display: block;
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
        .form-input:focus { outline: none; border-color: #1d4ed8; box-shadow: 0 0 0 2px rgba(29, 78, 216, 0.2); }
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
        .btn-primary:hover { background-color: #2563eb; }

        /* Modal */
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
            max-width: 500px;
            width: 92%;
            max-height: 90vh;
            overflow-y: auto;
            transform: scale(0.95);
            transition: transform 0.3s ease;
        }
        .modal-overlay.active .modal-content { transform: scale(1); }

        /* Table Loading/Empty State */
        .table-state-loader {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 0;
            width: 100%;
        }
        .state-text {
            font-size: 14px;
            font-weight: 500;
            color: var(--text-muted);
            margin-left: 10px;
        }
        .empty-state {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 0;
            width: 100%;
            font-size: 14px;
            font-weight: 500;
            color: var(--text-muted);
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
                    <h2 class="text-heading font-semibold text-base tracking-wide">Order Retailers Shortage</h2>
                    <p class="text-[10px] text-gray-500">View and manage all retailers order shortages</p>
                </div>
            </div>

            <!-- Add Button -->
            <div class="panel-card p-3 mb-4">
                <button class="btn-primary text-xs" onclick="openCreateModal()">
                    <i class="fa-solid fa-plus mr-1"></i> Add Size
                </button>
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
                        <tbody></tbody>
                    </table>
                </div>
            </div>

        </div>

        <?php include 'includes/footer.php'; ?>

    </main>

    <!-- Create Size Modal -->
    <div id="createSizeModal" class="modal-overlay">
        <div class="modal-content p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-heading font-semibold text-sm">Add Size</h3>
                <button type="button" class="text-gray-400 hover:text-red-500" onclick="closeCreateModal()">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>
            <form id="insert_form" enctype="multipart/form-data">
                <div class="space-y-4">
                    <div>
                        <label class="form-label">Size</label>
                        <input type="number" class="form-input" id="name" name="name" placeholder="Enter Size" required>
                    </div>
                    <input type="hidden" name="row_id" id="row_id" value="0">
                    <input type="hidden" name="user_id" id="user_id" value="1">
                </div>
                <div class="flex gap-3 mt-4">
                    <button type="button" class="btn-primary flex-1 text-center" onclick="closeCreateModal()">Close</button>
                    <input type="submit" class="btn-primary flex-1 text-center" value="Save">
                </div>
            </form>
        </div>
    </div>

    <script>
        const API_BASE_URL = 'api/';

        let table;

        // Column Config
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
                        <span>${col.label}</span>
                    </div>
                `;
                container.append(item);
            });
        }

        function toggleColumnVisibility(colIdx) {
            if (!table) return;
            try {
                const isVisible = table.column(col.idx).visible();
                table.column(col.idx).visible(!isVisible);
                $(`#col-checkbox-${col.idx}`).prop('checked', !isVisible);
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
            } catch (e) {
                console.warn('Select all columns error:', e);
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
            } catch (e) {
                console.warn('Deselect all columns error:', e);
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

        // Modal Functions
        function openCreateModal() {
            $('#row_id').val('0');
            $('#name').val('');
            $('#createSizeModal').addClass('active');
        }

        function closeCreateModal() {
            $('#createSizeModal').removeClass('active');
        }

        $(document).ready(function() {
            // Initialize DataTable
            table = $('#myTable').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    { extend: 'copy', text: '<i class="fa-regular fa-copy"></i> Copy', className: 'toolbar-btn', exportOptions: { columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14] } },
                    { extend: 'excelHtml5', text: '<i class="fa-regular fa-file-excel"></i> Excel', className: 'toolbar-btn', exportOptions: { columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14] }, title: 'Order_Retailers_Shortage' },
                    { extend: 'csvHtml5', text: '<i class="fa-regular fa-file-csv"></i> CSV', className: 'toolbar-btn', exportOptions: { columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14] }, title: 'Order_Retailers_Shortage' },
                    { extend: 'pdfHtml5', text: '<i class="fa-regular fa-file-pdf"></i> PDF', className: 'toolbar-btn', exportOptions: { columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14] }, title: 'Order Retailers Shortage', orientation: 'landscape', pageSize: 'A4' },
                    { extend: 'print', text: '<i class="fa-solid fa-print"></i> Print', className: 'toolbar-btn', exportOptions: { columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14] } }
                ],
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100],
                language: {
                    search: '',
                    searchPlaceholder: 'Search shortages...',
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

            // Submit Create Size Form
            $('#insert_form').on("submit", function(event) {
                event.preventDefault();
                let update_id = $('#row_id').val();
                let data = new FormData(this);

                let url = update_id == '0' ? 
                    'create/create_containers_sizes.php' : 
                    'update/container_size.php';

                $.ajax({
                    url: API_BASE_URL + url,
                    cache: false,
                    contentType: false,
                    processData: false,
                    method: "POST",
                    data: data,
                    beforeSend: function() {
                        $('#insert').val("Saving");
                        document.getElementById("insert").disabled = true;
                    },
                    success: function(data) {
                        console.log(data);
                        if (data != 1) {
                            Swal.fire('Server Error!', 'Record Not Saved', 'error');
                            $('#insert').val("Save");
                            document.getElementById("insert").disabled = false;
                        } else {
                            Swal.fire('Success!', 'Record Saved Successfully', 'success');
                            $('#insert_form')[0].reset();
                            closeCreateModal();
                            fetchtable();
                            $('#insert').val("Save");
                            document.getElementById("insert").disabled = false;
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                        Swal.fire('Error!', 'Something went wrong.', 'error');
                        $('#insert').val("Save");
                        document.getElementById("insert").disabled = false;
                    }
                });
            });

            // Fetch Initial Data
            fetchtable();
        });

        // Fetch Table Data (With Loader)
        function fetchtable() {
            let rettypes = "RT";

            // Destroy old table and show loader
            if ($.fn.DataTable.isDataTable('#myTable')) {
                table.destroy();
            }

            // Show Loader Inside Table Area
            $('.table-container').html(`
                <div class="table-state-loader">
                    <i class="fa-solid fa-spinner fa-spin text-blue-500 text-2xl"></i>
                    <span class="state-text">Loading shortages...</span>
                </div>
            `);

            fetch(API_BASE_URL + 'get/get_all_orders_shortage.php?key=03201232927&id=1&rettype=' + rettypes)
                .then(response => response.json())
                .then(response => {
                    // Remove loader and reinitialize DataTable
                    $('.table-container').html(`
                        <table id="myTable" class="display" style="width:100%;">
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
                            <tbody></tbody>
                        </table>
                    `);

                    // Reinitialize DataTable
                    table = $('#myTable').DataTable({
                        dom: 'Bfrtip',
                        buttons: [
                            { extend: 'copy', text: '<i class="fa-regular fa-copy"></i> Copy', className: 'toolbar-btn', exportOptions: { columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14] } },
                            { extend: 'excelHtml5', text: '<i class="fa-regular fa-file-excel"></i> Excel', className: 'toolbar-btn', exportOptions: { columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14] }, title: 'Order_Retailers_Shortage' },
                            { extend: 'csvHtml5', text: '<i class="fa-regular fa-file-csv"></i> CSV', className: 'toolbar-btn', exportOptions: { columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14] }, title: 'Order_Retailers_Shortage' },
                            { extend: 'pdfHtml5', text: '<i class="fa-regular fa-file-pdf"></i> PDF', className: 'toolbar-btn', exportOptions: { columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14] }, title: 'Order Retailers Shortage', orientation: 'landscape', pageSize: 'A4' },
                            { extend: 'print', text: '<i class="fa-solid fa-print"></i> Print', className: 'toolbar-btn', exportOptions: { columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14] } }
                        ],
                        pageLength: 10,
                        lengthMenu: [10, 25, 50, 100],
                        language: {
                            search: '',
                            searchPlaceholder: 'Search shortages...',
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

                    // Render Data
                    if (response && response.length > 0) {
                        $.each(response, function(index, data) {
                            let product_name = '';
                            let Density = '';
                            let quantity = '';
                            let quantity_less_L = '';
                            let quantity_rec_L = '';
                            let temperature = '';

                            try {
                                const jsonData = JSON.parse(data.product_json);
                                if (jsonData.length > 0) {
                                    product_name = jsonData[0].product_name || '';
                                    Density = jsonData[0].Density || '';
                                    quantity = jsonData[0].quantity || '';
                                    quantity_less_L = jsonData[0].quantity_less_L || '';
                                    quantity_rec_L = jsonData[0].quantity_rec_L || '';
                                    temperature = jsonData[0].temperature || '';
                                }
                            } catch (e) {
                                console.error('JSON parse error:', e);
                            }

                            table.row.add([
                                index + 1,
                                data.created_at,
                                data.customer_name,
                                data.customer_id,
                                data.order_id,
                                data.invoice_no,
                                product_name,
                                parseFloat(quantity).toLocaleString(),
                                parseFloat(quantity_rec_L).toLocaleString(),
                                parseFloat(quantity_less_L).toLocaleString(),
                                temperature,
                                Density,
                                `<a href="api/uploads/${data.file}" target="_blank" class="link-btn">View File</a>`,
                                `<a href="api/uploads/${data.sign}" target="_blank" class="link-btn">View File</a>`,
                                `<a href="api/uploads/${data.dealer_sign}" target="_blank" class="link-btn">View File</a>`
                            ]).draw(false);
                        });
                    }
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                    $('.table-container').html(`
                        <div class="empty-state">Error loading data. Please try again.</div>
                    `);
                });
        }
    </script>

</body>
</html>