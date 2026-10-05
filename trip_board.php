<?php
// Hascol OMC Operations Command Center - Trip Board
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hascol OMC - Trip Board</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        (function() {
            const isDarkMode = localStorage.getItem('darkMode') === 'true';
            if (isDarkMode) document.documentElement.classList.add('dark-mode');
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
            --scrollbar-track: #eef1f6;
            --scrollbar-thumb: #cbd5e1;
            --filter-bg: #f8fafc;
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
            --filter-bg: #0a121c;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            background-color: var(--bg-body);
            color: var(--text-muted);
            font-family: 'Inter', sans-serif;
            transition: background-color .25s ease, color .25s ease;
        }

        .text-heading { color: var(--text-heading) !important; }

        .panel-card {
            background-color: var(--bg-panel);
            border: 1px solid var(--border-color);
            border-radius: 6px;
            transition: background-color .25s ease, border-color .25s ease;
            height: 83vh;
        }

        #sidebar.collapsed { width: 60px; }
        #sidebar.collapsed .sidebar-text { display: none; }
        #sidebar.collapsed .p-4 { padding: 12px 8px; }
        #sidebar.collapsed nav a { justify-content: center; padding: 8px 4px; }
        #sidebar.collapsed .p-3 .sidebar-text { display: none; }
        #sidebar.collapsed .p-3 .flex.items-center { justify-content: center; }
        #sidebar.collapsed .p-3 img { width: 32px; height: 32px; }

        #sidebar, #mainContent { transition: all 0.3s ease-in-out; }

        #map {
            width: 100%;
            height: 80vh;
            border-radius: 6px;
            z-index: 1;
        }

        .leaflet-control-zoom { z-index: 1000 !important; }

        .search-input {
            background-color: var(--input-bg);
            border: 1px solid var(--border-color);
            border-radius: 4px;
            color: var(--text-body);
            padding: 6px 10px;
            font-size: 12px;
            outline: none;
            height: 30px;
            width: 100%;
        }

        .search-input:focus {
            border-color: #1d4ed8;
            box-shadow: 0 0 0 2px rgba(29, 78, 216, 0.2);
        }

        .stat-card {
            background-color: var(--bg-panel);
            border: 1px solid var(--border-color);
            border-radius: 6px;
            padding: 16px;
        }

        .stat-card .stat-icon {
            width: 40px;
            height: 40px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #1d4ed820;
            color: #1d4ed8;
        }

        .stat-card .stat-value {
            font-size: 22px;
            font-weight: 600;
            color: var(--text-heading);
        }

        .stat-card .stat-label {
            font-size: 11px;
            color: var(--text-muted);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .trip-tab {
            background: var(--bg-panel);
            border: 1px solid var(--border-color);
            border-radius: 6px;
            padding: 10px 12px;
            margin-bottom: 6px;
            cursor: pointer;
            transition: all 0.2s;
            color: var(--text-body);
        }

        .trip-tab:hover { border-color: #1d4ed8; background: var(--hover-bg); }
        .trip-tab.active { border-color: #1d4ed8; background: var(--hover-bg); }
        .trip-tab .vehicle-name {
            font-size: 12px;
            font-weight: 600;
            color: var(--text-heading);
        }
        .trip-tab .vehicle-detail { font-size: 10px; color: var(--text-muted); }

        .badge-tracker {
            padding: 2px 8px;
            border-radius: 9999px;
            font-size: 8px;
            font-weight: 600;
        }

        .badge-tracker.with-tracker {
            background: #10b98120;
            color: #10b981;
            border: 1px solid #10b98140;
        }

        .badge-tracker.without-tracker {
            background: #ef444420;
            color: #ef4444;
            border: 1px solid #ef444440;
        }

        .scroll-container {
            height: 70vh;
            overflow-y: auto;
            padding-right: 4px;
        }

        .scroll-container::-webkit-scrollbar { width: 4px; }
        .scroll-container::-webkit-scrollbar-track { background: var(--scrollbar-track); }
        .scroll-container::-webkit-scrollbar-thumb {
            background: var(--scrollbar-thumb);
            border-radius: 4px;
        }

        .date-input {
            background-color: var(--input-bg);
            border: 1px solid var(--border-color);
            border-radius: 4px;
            color: var(--text-body);
            padding: 6px 10px;
            font-size: 12px;
            outline: none;
            height: 32px;
            width: 100%;
        }

        .date-input:focus {
            border-color: #1d4ed8;
            box-shadow: 0 0 0 2px rgba(29, 78, 216, 0.2);
        }

        .btn-get {
            background-color: #1d4ed8;
            color: #ffffff;
            padding: 6px 18px;
            border-radius: 4px;
            border: none;
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s;
            height: 32px;
            margin-top: 24px;
        }

        .btn-get:hover { background-color: #2563eb; }

        .filter-label {
            color: var(--text-muted);
            font-size: 10px;
            font-weight: 500;
            margin-bottom: 4px;
            display: block;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .filter-section {
            background-color: var(--filter-bg);
            border-bottom: 1px solid var(--border-color);
            padding: 10px 16px;
            width: 100%;
            flex-shrink: 0;
        }

        .filter-container {
            display: flex;
            flex-wrap: wrap;
            align-items: flex-end;
            gap: 12px;
            width: 100%;
        }

        .filter-item { flex: 0 0 auto; }

        .toast {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: var(--bg-panel);
            border: 1px solid var(--border-color);
            border-radius: 6px;
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
        .toast.success i { color: #10b981; }
        .toast.error { border-color: #ef4444; }
        .toast.error i { color: #ef4444; }

        .table-container {
            max-height: 400px;
            overflow-x: auto;
            overflow-y: auto;
        }

        .table-container table {
            font-size: 10px;
            min-width: 1200px;
            width: 100%;
        }

        .table-container table thead th {
            position: sticky;
            top: 0;
            background: var(--table-head-bg);
            z-index: 10;
            padding: 8px 6px;
            /* font-size: 9px; */
            text-transform: uppercase;
            letter-spacing: 0.3px;
            color: var(--table-head-text);
            border-bottom: 2px solid var(--border-color);
            white-space: nowrap;
            text-align: center;
        }

        .table-container table tbody td {
            padding: 6px 4px;
            /* font-size: 9px; */
            color: var(--table-row-text);
            border-bottom: 1px solid var(--border-color);
            text-align: center;
            white-space: nowrap;
        }

        .table-container table tbody tr:hover { background-color: var(--table-row-hover); }

        .btn-sm {
            padding: 2px 8px;
            font-size: 9px;
            border-radius: 4px;
            border: 1px solid #3b82f6;
            background: transparent;
            color: #3b82f6;
            cursor: pointer;
            transition: all 0.2s;
            white-space: nowrap;
        }

        .btn-sm:hover { background: #3b82f6; color: #ffffff; }

        .badge-status {
            padding: 2px 8px;
            border-radius: 9999px;
            font-size: 8px;
            font-weight: 600;
        }

        .badge-status.pending {
            background: #f59e0b20;
            color: #f59e0b;
            border: 1px solid #f59e0b40;
        }

        .badge-status.start {
            background: #3b82f620;
            color: #3b82f6;
            border: 1px solid #3b82f640;
        }

        .badge-status.complete {
            background: #10b98120;
            color: #10b981;
            border: 1px solid #10b98140;
        }

        .custom-div-icon { background: transparent; border: none; }

        @media (max-width: 768px) {
            .filter-item { width: 100% !important; }
            .date-input { width: 100% !important; min-width: unset !important; }
            .btn-get { width: 100% !important; margin-top: 0 !important; }
            #map { height: 50vh; }
        }
    </style>
</head>

<body class="flex h-screen overflow-hidden text-xs">

    <?php include 'includes/sidebar.php'; ?>

    <main id="mainContent" class="flex-1 flex flex-col overflow-hidden">

        <?php include 'includes/topbar.php'; ?>

        <div class="filter-section">
            <div class="filter-container">
                <div class="filter-item">
                    <label class="filter-label">From</label>
                    <input type="date" id="filterDateFrom" class="date-input"
                        value="<?php echo isset($_GET['from']) ? $_GET['from'] : date('Y-m-d', strtotime('-7 days')); ?>">
                </div>
                <div class="filter-item">
                    <label class="filter-label">To</label>
                    <input type="date" id="filterDateTo" class="date-input"
                        value="<?php echo isset($_GET['to']) ? $_GET['to'] : date('Y-m-d'); ?>">
                </div>
                <div class="filter-item">
                    <button id="getBtn" class="btn-get" onclick="goRoute()">
                        <i class="fa-solid fa-arrow-right mr-1"></i> Get
                    </button>
                </div>
            </div>
        </div>

        <div class="flex-1 overflow-y-auto p-4" id="pageContent">

            <div class="flex justify-between items-center mb-4">
                <div>
                    <h2 class="text-heading font-semibold text-base tracking-wide uppercase">Trip Board</h2>
                    <p class="text-[10px] text-gray-500">Monitor vehicle trips and routes in real-time</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-4">
                <div class="stat-card">
                    <div class="flex items-center gap-3">
                        <div class="stat-icon"><i class="fa-solid fa-route text-lg"></i></div>
                        <div>
                            <div class="stat-value" id="totalTrips">0</div>
                            <div class="stat-label">Total Trips</div>
                        </div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="flex items-center gap-3">
                        <div class="stat-icon" style="background: #10b98120; color: #10b981;">
                            <i class="fa-solid fa-satellite-dish text-lg"></i>
                        </div>
                        <div>
                            <div class="stat-value" id="withTracker">0</div>
                            <div class="stat-label">With Tracker</div>
                        </div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="flex items-center gap-3">
                        <div class="stat-icon" style="background: #ef444420; color: #ef4444;">
                            <i class="fa-solid fa-satellite text-lg"></i>
                        </div>
                        <div>
                            <div class="stat-value" id="withoutTracker">0</div>
                            <div class="stat-label">Without Tracker</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-col md:flex-row gap-4">
                <div class="w-full md:w-1/3">
                    <div class="panel-card p-3">
                        <input type="text" id="vehicleSearch" class="search-input" placeholder="Search vehicle...">
                        <div class="mt-3 scroll-container" id="tripList">
                            <div class="text-center py-8 text-gray-500 text-xs">
                                <i class="fa-solid fa-spinner fa-spin text-blue-400 mr-2"></i>
                                Loading trips...
                            </div>
                        </div>
                    </div>
                </div>

                <div class="w-full md:w-2/3">
                    <div class="panel-card p-3">
                        <div id="map"></div>
                    </div>
                    <div class="panel-card p-3 mt-3" id="tripDetailsContainer" style="display:none;">
                        <h4 class="text-heading font-semibold text-sm mb-2">Trip Details</h4>
                        <div class="table-container" id="tripDetailsTable">
                            <table class="w-full">
                                <thead>
                                    <tr>
                                        <th>Site Name</th>
                                        <th>JD Code</th>
                                        <th>Material</th>
                                        <th>Vehicle</th>
                                        <th>Order #</th>
                                        <th>Invoice #</th>
                                        <th>Qty</th>
                                        <th>Rate</th>
                                        <th>Driver Sign</th>
                                        <th>Shortage</th>
                                        <th>Status</th>
                                        <th>Map</th>
                                        <th>Distance</th>
                                        <th>Rem. Dist.</th>
                                        <th>Last Update</th>
                                        <th>Active Time</th>
                                        <th>ETA</th>
                                        <th>Close Time</th>
                                    </tr>
                                </thead>
                                <tbody id="tripDetailsBody">
                                    <tr>
                                        <td colspan="18" class="text-center text-gray-500 py-4">Select a trip to view details</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <div id="toast" class="toast">
        <i class="fa-solid fa-check-circle mr-2"></i>
        <span id="toastMessage">Success!</span>
    </div>

    <script>
    function toggleDarkMode() {
        const html = document.documentElement;
        const isDark = html.classList.toggle('dark-mode');
        localStorage.setItem('darkMode', isDark);
        const icon = document.querySelector('.dark-mode-toggle i');
        if (icon) icon.className = isDark ? 'fa-solid fa-sun' : 'fa-solid fa-moon';
    }

    const API_BASE_URL = 'api/get/puma_sap_order';

    let map, markersArray = [], flightPath;

    function initMap() {
        map = L.map('map').setView([30.3753, 69.3451], 6);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);
    }

    $(document).ready(function() {
        $('#sidebarToggle').on('click', function() {
            $('#sidebar').toggleClass('collapsed');
            localStorage.setItem('sidebarCollapsed', $('#sidebar').hasClass('collapsed'));
        });

        if (localStorage.getItem('sidebarCollapsed') === 'true') {
            $('#sidebar').addClass('collapsed');
        }

        initMap();
        loadTripData();

        const isDarkMode = localStorage.getItem('darkMode') === 'true';
        const icon = document.querySelector('.dark-mode-toggle i');
        if (icon) icon.className = isDarkMode ? 'fa-solid fa-sun' : 'fa-solid fa-moon';
    });

    function goRoute() {
        var fromdate = document.getElementById("filterDateFrom").value;
        var todate = document.getElementById("filterDateTo").value;
        if (!fromdate || !todate) {
            showToast('Please select both From and To dates.', 'error');
            return;
        }
        window.location.href = 'trip_board.php?from=' + fromdate + '&to=' + todate;
    }

    function loadTripData() {
        var fromdate = document.getElementById("filterDateFrom").value;
        var todate = document.getElementById("filterDateTo").value;

        if (!fromdate || !todate) {
            showToast('Please select both dates.', 'error');
            return;
        }

        var url = API_BASE_URL + '/get_sap_order_data.php?key=03201232927&from=' + fromdate + '&to=' + todate;
        console.log('Loading trips from:', url);

        $('#tripList').html(`
            <div class="text-center py-8 text-gray-500 text-xs" id="loadingSpinner">
                <i class="fa-solid fa-spinner fa-spin text-blue-400 mr-2"></i>
                Loading trips... (${fromdate} to ${todate})
            </div>
        `);

        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            timeout: 180000,
            success: function(response) {
                console.log('API Response received. Total records:', response ? response.length : 0);
                $('#loadingSpinner').remove();
                
                if (!response) {
                    $('#tripList').html(`<div class="text-center py-8 text-red-500 text-xs">No response from server</div>`);
                    showToast('No response from server.', 'error');
                    return;
                }
                
                if (response.error) {
                    $('#tripList').html(`<div class="text-center py-8 text-red-500 text-xs">${response.error}</div>`);
                    showToast('Error: ' + response.error, 'error');
                    return;
                }
                
                if (Array.isArray(response) && response.length > 0) {
                    updateStats(response);
                    setTimeout(function() {
                        displayTrips(response);
                        showToast('Loaded ' + response.length + ' trips!', 'success');
                    }, 100);
                } else {
                    $('#tripList').html(`<div class="text-center py-8 text-gray-500 text-xs">No trips found</div>`);
                    updateStats([]);
                    showToast('No trips found.', 'error');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', status, error);
                $('#loadingSpinner').remove();
                var errorMsg = status === 'timeout' ? 'Request timed out. Try smaller date range.' : 'Error: ' + status;
                $('#tripList').html(`
                    <div class="text-center py-8 text-red-500 text-xs">
                        ${errorMsg}<br><br>
                        <button onclick="loadTripData()" class="btn-sm">Retry</button>
                    </div>
                `);
                showToast(errorMsg, 'error');
            }
        });
    }

    function displayTrips(data) {
        var container = $('#tripList');
        container.empty();

        if (!data || data.length === 0) {
            container.html(`<div class="text-center py-8 text-gray-500 text-xs">No trips to display</div>`);
            return;
        }

        var htmlParts = [];
        
        for (var i = 0; i < data.length; i++) {
            var item = data[i];
            
            var vehicleName = item.vehicle_name || item.vehicle || 'Unknown Vehicle';
            var catId = item.order_no || '';
            var trackerStatus = item.tracker_status || 'Without-Tracker';
            var orderNo = item.order_no || 'N/A';
            var customerName = item.customer_name || '';
            var trackerClass = trackerStatus === 'With-Tracker' ? 'with-tracker' : 'without-tracker';
            var searchText = (vehicleName + ' ' + orderNo + ' ' + customerName).toLowerCase();

            htmlParts.push(`
                <div class="trip-tab" onclick="loadTripDetails('${catId}', '${trackerStatus}')" 
                     data-search="${searchText}" 
                     data-catid="${catId}"
                     data-tracker="${trackerStatus}">
                    <div class="flex justify-between items-center">
                        <div>
                            <div class="vehicle-name">${vehicleName}</div>
                            <div class="vehicle-detail">Order: ${orderNo} | ${customerName}</div>
                        </div>
                        <div>
                            <span class="badge-tracker ${trackerClass}">${trackerStatus}</span>
                        </div>
                    </div>
                </div>
            `);
        }

        container.html(htmlParts.join(''));

        setTimeout(function() {
            var firstTrip = container.find('.trip-tab').first();
            if (firstTrip.length > 0) {
                firstTrip.addClass('active');
                var catId = firstTrip.data('catid');
                var trackerStatus = firstTrip.data('tracker') || 'Without-Tracker';
                if (catId) loadTripDetails(catId, trackerStatus);
            }
        }, 300);
    }

    function updateStats(data) {
        var total = data && Array.isArray(data) ? data.length : 0;
        var withTracker = 0, withoutTracker = 0;

        if (data && Array.isArray(data)) {
            for (var i = 0; i < data.length; i++) {
                var trackerStatus = data[i].tracker_status || 'Without-Tracker';
                if (trackerStatus === 'With-Tracker') withTracker++;
                else withoutTracker++;
            }
        }

        $('#totalTrips').text(total.toLocaleString());
        $('#withTracker').text(withTracker.toLocaleString());
        $('#withoutTracker').text(withoutTracker.toLocaleString());
    }

    function loadTripDetails(catId, trackerStatus) {
        if (!catId) return;

        $('#tripList .trip-tab').removeClass('active');
        $('#tripList .trip-tab').each(function() {
            if ($(this).data('catid') == catId) $(this).addClass('active');
        });

        $('#tripDetailsContainer').show();

        var url = API_BASE_URL + '/get_sap_order_subtripdata.php?key=03201232927&order_no=' + catId;

        $('#tripDetailsBody').html(`<tr><td colspan="18" class="text-center text-gray-500"><i class="fa-solid fa-spinner fa-spin mr-2"></i> Loading details...</td></tr>`);

        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            timeout: 60000,
            success: function(response) {
                var tbody = $('#tripDetailsBody');
                tbody.empty();

                if (response && Array.isArray(response) && response.length > 0) {
                    var detailRows = [];
                    $.each(response, function(index, product) {
                        var siteName = product.name || product.consignee_name || product.customer_name || '---';
                        var jdCode = product.customer_id || product.dealer_sap || '---';
                        var material = product.product_name || '---';
                        var vehicle = product.vehicle_name || product.vehicle || '---';
                        var orderNo = product.order_no || '---';
                        var invoiceNo = product.invoice || product.invoice_no || '---';
                        var qty = parseFloat(product.quantity) || 0;
                        var rate = parseFloat(product.product_rate) || parseFloat(product.rate) || 0;
                        
                        var driverSign = product.sign ? `<i class="fa-solid fa-check-circle text-green-500"></i>` : '---';
                        
                        var shortage = product.is_shortage;
                        var shortageText = '---';
                        if (shortage == 1) shortageText = `<span class="text-red-500 font-bold">Yes</span>`;
                        else if (shortage == 0) shortageText = `<span class="text-green-500">No</span>`;
                        
                        var status = product.current_status || product.status || '---';
                        var statusClass = '';
                        var statusText = status;
                        if (status == 'Pending' || status == 0) { statusClass = 'pending'; statusText = 'Pending'; }
                        else if (status == 'Start' || status == 1) { statusClass = 'start'; statusText = 'Start'; }
                        else if (status == 'Complete' || status == 2) { statusClass = 'complete'; statusText = 'Complete'; }
                        
                        var mapBtn = trackerStatus === 'With-Tracker' ?
                            `<button class="btn-sm" onclick="showOnMap('${product.id || catId}', '${product.order_no || ''}')">
                                <i class="fa fa-map-marker"></i> Focus
                            </button>` : '---';
                        
                        var distance = product.distance || '---';
                        if (distance && distance != 'NULL' && distance != 0) distance = parseFloat(distance).toFixed(2) + ' km';
                        
                        var remainDist = product.remain_distance || '---';
                        if (remainDist && remainDist != 'NULL' && remainDist != 0) remainDist = parseFloat(remainDist).toFixed(2) + ' km';
                        
                        var lastUpdate = product.last_check || '---';
                        var activeTime = product.start_time || '---';
                        var eta = product.eta || '---';
                        var closeTime = product.close_time || '---';

                        detailRows.push(`
                            <tr>
                                <td>${siteName}</td>
                                <td>${jdCode}</td>
                                <td>${material}</td>
                                <td>${vehicle}</td>
                                <td>${orderNo}</td>
                                <td>${invoiceNo}</td>
                                <td>${qty.toLocaleString()}</td>
                                <td>${rate.toFixed(2)}</td>
                                <td>${driverSign}</td>
                                <td>${shortageText}</td>
                                <td><span class="badge-status ${statusClass}">${statusText}</span></td>
                                <td>${mapBtn}</td>
                                <td>${distance}</td>
                                <td>${remainDist}</td>
                                <td>${lastUpdate}</td>
                                <td>${activeTime}</td>
                                <td>${eta}</td>
                                <td>${closeTime}</td>
                            </tr>
                        `);
                    });
                    tbody.html(detailRows.join(''));

                    if (response.length > 0 && trackerStatus === 'With-Tracker') {
                        var firstProduct = response[0];
                        showOnMap(firstProduct.id || catId, firstProduct.order_no);
                    }
                } else {
                    tbody.html(`<tr><td colspan="18" class="text-center text-gray-500">No details available</td></tr>`);
                }
            },
            error: function(xhr, status, error) {
                $('#tripDetailsBody').html(`<tr><td colspan="18" class="text-center text-red-500">Error loading details: ${status}</td></tr>`);
            }
        });
    }

    $(document).on('keyup', '#vehicleSearch', function() {
        var value = $(this).val().toLowerCase();
        var visibleCount = 0;
        
        $('#tripList .trip-tab').each(function() {
            var searchText = $(this).data('search') || '';
            var isMatch = searchText.indexOf(value) > -1;
            $(this).toggle(isMatch);
            if (isMatch) visibleCount++;
        });
        
        $('#tripList .no-results').remove();
        if (visibleCount === 0 && value.length > 0) {
            $('#tripList').append(`<div class="no-results text-center py-4 text-gray-500 text-xs">No matching trips found</div>`);
        }
    });

    function showOnMap(subId, orderNo) {
        if (!subId) {
            showToast('No valid ID to show on map.', 'error');
            return;
        }

        var url = API_BASE_URL + '/get_order_co.php?key=03201232927&id=' + subId;

        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            timeout: 30000,
            success: function(response) {
                deleteMarkers();

                if (response && Array.isArray(response) && response.length > 0) {
                    var r = response[0];
                    
                    var dealerCoords = r.dealer_co || '';
                    if (dealerCoords && dealerCoords !== '') {
                        var parts = dealerCoords.split(', ');
                        if (parts.length === 2) {
                            var lat = parseFloat(parts[0]);
                            var lng = parseFloat(parts[1]);
                            if (!isNaN(lat) && !isNaN(lng)) setDealerMarker(lat, lng, r.dealer_name || 'Dealer');
                        }
                    }
                    
                    var depotCoords = r.depot_co || '';
                    if (depotCoords && depotCoords !== '') {
                        var parts = depotCoords.split(', ');
                        if (parts.length === 2) {
                            var lat = parseFloat(parts[0]);
                            var lng = parseFloat(parts[1]);
                            if (!isNaN(lat) && !isNaN(lng)) setDepotMarker(lat, lng, r.depot_name || 'Depot');
                        }
                    }
                    
                    var d_lat = parseFloat(r.d_lat);
                    var d_lng = parseFloat(r.d_lng);
                    if (!isNaN(d_lat) && !isNaN(d_lng) && d_lat !== 0 && d_lng !== 0) {
                        setVehicleMarker(d_lat, d_lng, r.vehicle_name || 'Vehicle', r.time || '', subId);
                    }
                    
                    loadTripRoute(r.vehicle_id, orderNo, subId);
                    showToast('Location loaded successfully!', 'success');
                } else {
                    showToast('No location data found.', 'error');
                }
            },
            error: function(xhr, status, error) {
                showToast('Error loading location data: ' + status, 'error');
            }
        });
    }

    function setVehicleMarker(lat, lng, vehicleName, time, tripId) {
        if (isNaN(lat) || isNaN(lng)) return;
        var icon = L.divIcon({
            className: 'custom-div-icon',
            html: `<i class="fa-solid fa-truck" style="font-size:28px;color:#1d4ed8;"></i>`,
            iconSize: [28, 28],
            iconAnchor: [14, 14],
            popupAnchor: [0, -14]
        });
        var marker = L.marker([lat, lng], { icon: icon }).addTo(map);
        marker.bindPopup(`<b>Vehicle</b><br>${vehicleName}<br>Trip: ${tripId}<br>Time: ${time || 'N/A'}`);
        markersArray.push(marker);
        map.setView([lat, lng], 12);
    }

    function setDealerMarker(lat, lng, dealerName) {
        if (isNaN(lat) || isNaN(lng)) return;
        var icon = L.divIcon({
            className: 'custom-div-icon',
            html: `<i class="fa-solid fa-location-dot" style="font-size:28px;color:#ef4444;"></i>`,
            iconSize: [28, 28],
            iconAnchor: [14, 28],
            popupAnchor: [0, -28]
        });
        var marker = L.marker([lat, lng], { icon: icon }).addTo(map);
        marker.bindPopup(`<b>Dealer</b><br>${dealerName}`);
        markersArray.push(marker);
    }

    function setDepotMarker(lat, lng, depotName) {
        if (isNaN(lat) || isNaN(lng)) return;
        var icon = L.divIcon({
            className: 'custom-div-icon',
            html: `<i class="fa-solid fa-warehouse" style="font-size:28px;color:#f59e0b;"></i>`,
            iconSize: [28, 28],
            iconAnchor: [14, 28],
            popupAnchor: [0, -28]
        });
        var marker = L.marker([lat, lng], { icon: icon }).addTo(map);
        marker.bindPopup(`<b>Depot</b><br>${depotName}`);
        markersArray.push(marker);
    }

    function loadTripRoute(vehiId, orderNo, id) {
        if (!vehiId) {
            console.log('No vehicle ID for route');
            return;
        }

        var url = API_BASE_URL + '/get_delivered_trip.php?key=03201232927&salesOrders=' + orderNo + '&id=' + id;

        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            timeout: 30000,
            success: function(response) {
                console.log('Delivered Trip Response:', response);
                
                if (response && Array.isArray(response) && response.length > 0) {
                    var tripData = response[0];
                    var deliveredStatus = tripData.status;
                    var tripStartTime = tripData.trip_start_time;
                    var closeTime = tripData.close_time;

                    if (deliveredStatus !== '0' && tripStartTime) {
                        var endTime = closeTime || getCurrentDateTime();
                        drawRoute(vehiId, tripStartTime, endTime);
                    } else {
                        clearRoute();
                        console.log('Trip not started or no route data');
                    }
                }
            },
            error: function(xhr, status, error) {
                console.log('Error loading trip route:', error);
            }
        });
    }

    function drawRoute(vehiId, startTime, endTime) {
        var url = API_BASE_URL + '/get_trip_routes.php?key=03201232927&vehicle_id=' + vehiId +
            '&start_time=' + startTime + '&end_time=' + endTime;

        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            timeout: 30000,
            success: function(data) {
                clearRoute();

                if (!data || data.length === 0) {
                    console.log('No route data found');
                    return;
                }

                var points = [];

                for (var i = 0; i < data.length; i++) {
                    var obj = data[i];
                    var lat = parseFloat(obj.latitude);
                    var lng = parseFloat(obj.longitude);
                    if (isNaN(lat) || isNaN(lng) || lat === 0 || lng === 0) continue;
                    points.push([lat, lng]);
                }

                if (points.length > 1) {
                    flightPath = L.polyline(points, {
                        color: '#FF0000',
                        weight: 3,
                        opacity: 0.7,
                        lineJoin: 'round'
                    }).addTo(map);
                    map.fitBounds(L.latLngBounds(points));
                    console.log('Route drawn with', points.length, 'points');
                }
            },
            error: function(xhr, status, error) {
                console.log('Error drawing route:', error);
            }
        });
    }

    function clearRoute() {
        if (flightPath) {
            map.removeLayer(flightPath);
            flightPath = null;
        }
    }

    function deleteMarkers() {
        for (var i = 0; i < markersArray.length; i++) {
            map.removeLayer(markersArray[i]);
        }
        markersArray = [];
        clearRoute();
    }

    function getCurrentDateTime() {
        var now = new Date();
        var year = now.getFullYear();
        var month = String(now.getMonth() + 1).padStart(2, '0');
        var day = String(now.getDate()).padStart(2, '0');
        var hours = String(now.getHours()).padStart(2, '0');
        var minutes = String(now.getMinutes()).padStart(2, '0');
        var seconds = String(now.getSeconds()).padStart(2, '0');
        return year + '-' + month + '-' + day + ' ' + hours + ':' + minutes + ':' + seconds;
    }

    function showToast(message, type) {
        var toast = $('#toast');
        var toastMessage = $('#toastMessage');

        toast.removeClass('success error');
        toast.addClass(type);
        toastMessage.text(message);
        toast.addClass('show');

        clearTimeout(window.toastTimeout);
        window.toastTimeout = setTimeout(function() {
            toast.removeClass('show');
        }, 4000);
    }

    $(document).on('change', '#filterDateFrom, #filterDateTo', function() {
        loadTripData();
    });

    window.showOnMap = showOnMap;
    window.loadTripDetails = loadTripDetails;
    window.goRoute = goRoute;
    window.toggleDarkMode = toggleDarkMode;
    </script>

</body>

</html>