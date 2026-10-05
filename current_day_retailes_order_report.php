<?php
// Hascol OMC - Current Day Retailers Order Report
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Current Day Retailers Order Report</title>

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

    <!-- Flatpickr CSS & JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <!-- Dark Mode Init -->
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

        .text-heading {
            color: var(--text-heading) !important;
        }

        .panel-card {
            background-color: var(--bg-panel);
            border: 1px solid var(--border-color);
            border-radius: 0.375rem;
        }

        /* Dynamic Heading Style (Inside DataTable) */
        .dt-report-heading {
            font-size: 16px;
            font-weight: 600;
            color: #1d4ed8;
            /* Blue color like screenshot */
            padding: 20px 15px;
            background-color: var(--bg-panel);
            border-bottom: 1px solid var(--border-color);
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

        .table-container table tbody tr:hover {
            background-color: var(--table-row-hover);
        }

        /* Loader & Empty State */
        .table-loader {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 0;
            width: 100%;
        }

        .loader-text {
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

        .dt-buttons .dt-button:hover {
            background-color: var(--hover-bg) !important;
            color: var(--text-heading) !important;
        }

        /* Heading Black Color */
        .heading-black {
            color: #000000 !important;
        }

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

        #dataTableSearchContainer .dataTables_filter input::placeholder {
            color: var(--text-muted);
        }

        #dataTableSearchContainer .dataTables_filter input:focus {
            border-color: #1d4ed8;
            box-shadow: 0 0 0 2px rgba(29, 78, 216, 0.2);
        }

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

        .column-visibility-dropdown .dropdown-btn:hover {
            background-color: var(--hover-bg);
            color: var(--text-heading);
        }

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

        .column-visibility-dropdown .dropdown-menu.show {
            display: block;
        }

        .column-visibility-dropdown .dropdown-menu .dropdown-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 6px 14px;
            cursor: pointer;
            font-size: 11px;
            color: var(--text-body);
        }

        .column-visibility-dropdown .dropdown-menu .dropdown-item:hover {
            background-color: var(--hover-bg);
        }

        .column-visibility-dropdown .dropdown-menu .dropdown-item input[type="checkbox"] {
            width: 14px;
            height: 14px;
            accent-color: #1d4ed8;
        }

        .dropdown-divider {
            height: 1px;
            background-color: var(--border-color);
            margin: 4px 8px;
        }

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

        .dropdown-actions button:hover {
            background: var(--hover-bg);
            color: var(--text-heading);
        }

        .dropdown-actions button.select-all-btn {
            border-color: #10b981;
            color: #10b981;
        }

        .dropdown-actions button.deselect-all-btn {
            border-color: #ef4444;
            color: #ef4444;
        }

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

        .form-input:focus {
            outline: none;
            border-color: #1d4ed8;
            box-shadow: 0 0 0 2px rgba(29, 78, 216, 0.2);
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
    </style>
</head>

<body class="flex h-screen overflow-hidden text-xs">

    <?php include 'includes/sidebar.php'; ?>

    <main id="mainContent" class="flex-1 flex flex-col overflow-hidden">

        <?php include 'includes/topbar.php'; ?>

        <div class="flex-1 overflow-y-auto p-4" id="pageContent">

            <div class="flex justify-between items-center mb-4">
                <div>
                    <h2 class="text-heading font-semibold text-base tracking-wide">Current Day Retailers Order Report
                    </h2>
                    <p class="text-[10px] text-gray-500">View and manage all retailers current day orders</p>
                </div>
            </div>

            <!-- Date Filter -->
            <div class="panel-card p-3 mb-4">
                <div class="flex flex-wrap items-end gap-3">
                    <div>
                        <label class="form-label text-[10px]">Date</label>
                        <input type="text" id="fromdate" class="form-input text-xs datepicker" placeholder="Select Date"
                            style="width:180px;">
                    </div>
                    <button onclick="fetchtable()" class="btn-primary text-xs px-4 py-2">
                        <i class="fa-solid fa-rotate-right mr-1"></i> Get
                    </button>
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
                <!-- Dynamic Heading Inside DataTable Panel -->
                <div class="dt-report-heading">
                    <span class="heading-black">Orders Current Day of</span> <span id="report_date"></span>
                </div>
                <div class="table-container">
                    <table id="myTable" class="display" style="width:100%;">
                        <thead>
                            <tr>
                                <th>JD Code</th>
                                <th>Region</th>
                                <th>Site Name</th>
                                <th>Depot</th>
                                <th>PMG</th>
                                <th>HSD</th>
                                <th>HASRON</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

        </div>

        <?php include 'includes/footer.php'; ?>

    </main>

    <script>
        // Live API URLs
        const API_BASE_URL = 'api/';

        let table;

        // Column Config
        const columnConfig = [
            { idx: 0, label: 'JD Code' },
            { idx: 1, label: 'Region' },
            { idx: 2, label: 'Site Name' },
            { idx: 3, label: 'Depot' },
            { idx: 4, label: 'PMG' },
            { idx: 5, label: 'HSD' },
            { idx: 6, label: 'HASRON' }
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
                const isVisible = table.column(colIdx).visible();
                table.column(colIdx).visible(!isVisible);
                $(`#col-checkbox-${colIdx}`).prop('checked', !isVisible);
            } catch (e) {
                console.warn('Column visibility toggle error:', e);
            }
        }

        function selectAllColumns() {
            if (!table) return;
            try {
                columnConfig.forEach(function (col) {
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
                columnConfig.forEach(function (col) {
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

        $(document).ready(function () {
            // Dynamic Date Logic
            const today = new Date();
            const currentDate = today.getFullYear() + '-' +
                String(today.getMonth() + 1).padStart(2, '0') + '-' +
                String(today.getDate()).padStart(2, '0');

            // Set Heading & Date Picker Default
            $('#report_date').text(currentDate);
            flatpickr("#fromdate", {
                dateFormat: "Y-m-d",
                defaultDate: currentDate
            });

            // Initialize DataTable
            table = $('#myTable').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    { extend: 'copyHtml5', title: function () { return 'Orders Current Day of ' + $('#report_date').text(); } },
                    { extend: 'excelHtml5', title: function () { return 'Orders Current Day of ' + $('#report_date').text(); } },
                    { extend: 'csvHtml5', title: function () { return 'Orders Current Day of ' + $('#report_date').text(); } },
                    { extend: 'pdfHtml5', title: function () { return 'Orders Current Day of ' + $('#report_date').text(); }, orientation: 'landscape', pageSize: 'A4' },
                    { extend: 'print', title: function () { return 'Orders Current Day of ' + $('#report_date').text(); } }
                ],
                paging: false,
                ordering: false,
                language: {
                    search: '',
                    searchPlaceholder: 'Search orders...',
                    emptyTable: '<div class="empty-state">No data available.</div>'
                },
                initComplete: function () {
                    const buttonsContainer = $('#exportButtonsContainer');
                    $('.dt-buttons').appendTo(buttonsContainer);
                    $('#dataTableSearchContainer').empty().append($('.dataTables_filter'));
                }
            });

            // Close dropdown on outside click
            $(document).on('click', function (e) {
                if (!$(e.target).closest('.column-visibility-dropdown').length) {
                    closeColumnDropdown();
                }
            });

            // Fetch Initial Data
            fetchtable();
        });

        function fetchtable() {
            let fromdate = $('#fromdate').val();
            let rettypes = "RT";

            // Update Heading
            $('#report_date').text(fromdate);

            // Destroy old table and show loader
            if ($.fn.DataTable.isDataTable('#myTable')) {
                table.destroy();
            }

            $('#myTable').hide();
            $('.table-container').html('<div class="table-loader"><i class="fa-solid fa-spinner fa-spin text-blue-500 text-2xl"></i><span class="loader-text">Loading data...</span></div>');

            fetch(API_BASE_URL + 'get/current_data_coco_orders.php?key=03201232927&id=1&from=' + fromdate + '&rettype=' + rettypes)
                .then(response => response.json())
                .then(data => {
                    // Remove loader and show table
                    $('.table-container').html('<table id="myTable" class="display" style="width:100%;"><thead><tr><th>JD Code</th><th>Region</th><th>Site Name</th><th>Depot</th><th>PMG</th><th>HSD</th><th>HASRON</th></tr></thead><tbody></tbody></table>');
                    $('#myTable').show();

                    // Reinitialize DataTable
                    table = $('#myTable').DataTable({
                        dom: 'Bfrtip',
                        buttons: [
                            { extend: 'copyHtml5', title: function () { return 'Orders Current Day of ' + $('#report_date').text(); } },
                            { extend: 'excelHtml5', title: function () { return 'Orders Current Day of ' + $('#report_date').text(); } },
                            { extend: 'csvHtml5', title: function () { return 'Orders Current Day of ' + $('#report_date').text(); } },
                            { extend: 'pdfHtml5', title: function () { return 'Orders Current Day of ' + $('#report_date').text(); }, orientation: 'landscape', pageSize: 'A4' },
                            { extend: 'print', title: function () { return 'Orders Current Day of ' + $('#report_date').text(); } }
                        ],
                        paging: false,
                        ordering: false,
                        language: {
                            search: '',
                            searchPlaceholder: 'Search orders...',
                            emptyTable: '<div class="empty-state">No data available.</div>'
                        },
                        initComplete: function () {
                            const buttonsContainer = $('#exportButtonsContainer');
                            $('.dt-buttons').appendTo(buttonsContainer);
                            $('#dataTableSearchContainer').empty().append($('.dataTables_filter'));
                        }
                    });

                    // Render Data
                    if (data && data.length > 0) {
                        $.each(data, function (index, item) {
                            table.row.add([
                                item.dealer_sap,
                                item.dealer_region,
                                item.dealer_name,
                                item.dealers_depots,
                                (item.PMG / 1000),
                                (item.HSD / 1000),
                                (item.HASRON / 1000)
                            ]).draw(false);
                        });
                    }
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                    $('.table-container').html('<div class="empty-state">Error loading data. Please try again.</div>');
                });
        }
    </script>

</body>

</html>