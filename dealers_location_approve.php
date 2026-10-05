<?php
// Hascol OMC Operations Command Center - Dealer Location Approve
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hascol OMC - Dealer Location Approve</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Google Maps API -->
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBNyJWb04pByaU1CTmimoWNl3b86VV6qZ8&callback=initMap&libraries=drawing&v=weekly"
        defer>
        </script>

    <script>
        // Dark mode detection
        (function () {
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
        /* THEME VARIABLES */
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

        /* Map Container */
        #map-canvas {
            width: 100%;
            height: 75vh;
            min-height: 500px;
            border-radius: 0.375rem;
        }

        .gm-ui-hover-effect {
            display: none !important;
        }

        /* Info Window Styles */
        .info-window-content {
            padding: 10px 6px;
            font-size: 13px;
            line-height: 1.6;
            min-width: 220px;
        }

        .info-window-content .detail-label {
            font-weight: 600;
            color: #64748b;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-window-content .detail-value {
            color: #0f2440;
            font-weight: 500;
            margin-bottom: 2px;
        }

        html.dark-mode .info-window-content .detail-value {
            color: #e5e7eb;
        }

        .info-window-content .btn-update {
            background-color: #1d4ed8;
            color: #ffffff;
            padding: 6px 16px;
            border-radius: 4px;
            border: none;
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s;
            width: 100%;
            margin-top: 6px;
        }

        .info-window-content .btn-update:hover {
            background-color: #2563eb;
        }

        .info-window-content .btn-update:disabled {
            opacity: 0.6;
            cursor: not-allowed;
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

        /* Loading Spinner */
        .spinner {
            display: inline-block;
            width: 16px;
            height: 16px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-top: 2px solid #ffffff;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
            margin-right: 6px;
            vertical-align: middle;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Badge */
        .badge-request {
            background: #3b82f620;
            color: #3b82f6;
            padding: 2px 8px;
            border-radius: 9999px;
            font-size: 10px;
            font-weight: 600;
            display: inline-block;
        }

        /* Back button styling */
        .back-btn {
            background-color: var(--btn-secondary-bg);
            color: var(--btn-secondary-text);
            padding: 8px 16px;
            border-radius: 0.25rem;
            border: none;
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s, color 0.2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .back-btn:hover {
            background-color: var(--btn-secondary-hover-bg);
            color: var(--btn-secondary-hover-text);
        }
    </style>
</head>

<body class="flex h-screen overflow-hidden text-xs">

    <!-- SIDEBAR - Included from includes/sidebar.php  -->
    <?php include 'includes/sidebar.php'; ?>

    <!-- MAIN CONTENT -->
    <main id="mainContent" class="flex-1 flex flex-col overflow-hidden">

        <!-- TOPBAR - Included from includes/topbar.php -->
        <?php include 'includes/topbar.php'; ?>

        <!-- PAGE CONTENT -->
        <div class="flex-1 overflow-y-auto p-4" id="pageContent">

            <!-- Page Header -->
            <div class="flex justify-between items-center mb-4">
                <div>
                    <h2 class="text-heading font-semibold text-base tracking-wide uppercase">Dealer Location Approve
                    </h2>
                    <p class="text-[10px] text-gray-500">Review and approve dealer location requests</p>
                </div>
                <div>
                    <a href="dealer_location_request.php" class="back-btn">
                        <i class="fa-solid fa-arrow-left"></i> Back to Requests
                    </a>
                </div>
            </div>

            <!-- Request Details Card -->
            <div class="panel-card p-4 mb-4" id="requestDetails">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="text-gray-500 text-[10px] uppercase tracking-wide">Dealer Name</label>
                        <p class="text-heading font-medium text-sm" id="dealerName">Loading...</p>
                    </div>
                    <div>
                        <label class="text-gray-500 text-[10px] uppercase tracking-wide">Request By</label>
                        <p class="text-heading font-medium text-sm" id="requestBy">Loading...</p>
                    </div>
                    <div>
                        <label class="text-gray-500 text-[10px] uppercase tracking-wide">Coordinates</label>
                        <p class="text-blue-400 font-mono text-sm" id="coordinates">Loading...</p>
                    </div>
                    <div>
                        <label class="text-gray-500 text-[10px] uppercase tracking-wide">Request At</label>
                        <p class="text-heading font-medium text-sm" id="requestAt">Loading...</p>
                    </div>
                </div>
            </div>

            <!-- Map Container -->
            <div class="panel-card overflow-hidden">
                <div id="map-canvas"></div>
            </div>

        </div>
    </main>

    <!-- TOAST NOTIFICATION -->
    <div id="toast" class="toast">
        <i class="fa-solid fa-check-circle mr-2"></i>
        <span id="toastMessage">Success!</span>
    </div>

    <!-- JAVASCRIPT -->
    <script>
        $(document).ready(function () {
            // Sidebar Toggle
            $('#sidebarToggle').on('click', function () {
                $('#sidebar').toggleClass('collapsed');
                const isCollapsed = $('#sidebar').hasClass('collapsed');
                localStorage.setItem('sidebarCollapsed', isCollapsed);
            });

            const savedState = localStorage.getItem('sidebarCollapsed');
            if (savedState === 'true') {
                $('#sidebar').addClass('collapsed');
            }

            // Get ID from URL
            const urlParams = new URLSearchParams(window.location.search);
            const requestId = urlParams.get('id');

            if (!requestId) {
                showToast('No request ID provided', 'error');
                document.getElementById('dealerName').textContent = 'Error: No ID provided';
                document.getElementById('requestBy').textContent = 'N/A';
                document.getElementById('coordinates').textContent = 'N/A';
                document.getElementById('requestAt').textContent = 'N/A';
            } else {
                // Store ID for later use
                window.requestId = requestId;
                // Load request details via API
                loadRequestDetails(requestId);
            }
        });

        // API Configuration
        const API_BASE_URL = 'api/';
        const API_KEY = '03201232927';
        const USER_ID = '1';

        // Global variables for map
        let map, currentMarker = null, currentInfoWindow = null;
        let currentRequestData = null;
        let isUpdating = false;

        // Load Request Details - API Integration
        function loadRequestDetails(id) {
            const url = `${API_BASE_URL}/get/get_dealer_location_request.php?key=${API_KEY}&id=${id}`;

            $.ajax({
                url: url,
                method: 'GET',
                dataType: 'json',
                success: function (response) {
                    console.log('Request Details Response:', response);

                    if (response && Array.isArray(response) && response.length > 0) {
                        const data = response[0];
                        currentRequestData = data;

                        // Update details card
                        document.getElementById('dealerName').textContent = data.name || 'N/A';
                        document.getElementById('requestBy').textContent = data.username || 'N/A';
                        document.getElementById('coordinates').textContent = data.coordinates || 'N/A';
                        document.getElementById('requestAt').textContent = formatDateTime(data.created_at);

                        // Initialize map with coordinates
                        if (data.coordinates && data.coordinates !== 'null') {
                            const coords = data.coordinates.split(',');
                            if (coords.length === 2) {
                                const lat = parseFloat(coords[0].trim());
                                const lng = parseFloat(coords[1].trim());
                                if (!isNaN(lat) && !isNaN(lng)) {
                                    initMapWithMarker(lat, lng, data);
                                }
                            }
                        }
                    } else {
                        showToast('No request data found', 'error');
                        document.getElementById('dealerName').textContent = 'No data found';
                    }
                },
                error: function (xhr, status, error) {
                    console.error('API Error:', error);
                    showToast('Failed to load request details', 'error');
                    document.getElementById('dealerName').textContent = 'Error loading data';
                }
            });
        }

        // Format Date
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

        // Google Maps - Initialize Map with Marker
        function initMapWithMarker(lat, lng, data) {
            const position = new google.maps.LatLng(lat, lng);

            map = new google.maps.Map(document.getElementById("map-canvas"), {
                center: position,
                zoom: 15,
                mapTypeId: google.maps.MapTypeId.HYBRID
            });

            const image = "https://www.freeiconspng.com/uploads/fuel-pump-icon-23.png";

            currentMarker = new google.maps.Marker({
                position: position,
                map: map,
                icon: {
                    url: image,
                    scaledSize: new google.maps.Size(40, 40)
                },
                animation: google.maps.Animation.DROP
            });

            // Create info window content with Update button inside
            const content = createInfoWindowContent(data);

            currentInfoWindow = new google.maps.InfoWindow({
                content: content,
                maxWidth: 280
            });

            // Open info window
            currentInfoWindow.open(map, currentMarker);

            // Keep info window open on map click
            google.maps.event.addListener(map, 'click', function () {
                if (currentInfoWindow) {
                    currentInfoWindow.open(map, currentMarker);
                }
            });

            // Re-open info window if marker is clicked
            google.maps.event.addListener(currentMarker, 'click', function () {
                if (currentInfoWindow) {
                    currentInfoWindow.open(map, currentMarker);
                }
            });
        }

        // Create Info Window Content with Update Button
        function createInfoWindowContent(data) {
            return `
                <div class="info-window-content">
                    <div class="detail-label">Consignee</div>
                    <div class="detail-value">${data.name || 'N/A'}</div>
                    
                    <div class="detail-label mt-2">Request By</div>
                    <div class="detail-value">${data.username || 'N/A'}</div>
                    
                    <div class="detail-label mt-2">Request At</div>
                    <div class="detail-value">${formatDateTime(data.created_at)}</div>
                    
                    <div class="detail-label mt-2">Coordinates</div>
                    <div class="detail-value font-mono" style="color: #3b82f6; font-size: 12px;">${data.coordinates || 'N/A'}</div>
                    
                    <div class="mt-3 pt-2 border-t" style="border-color: var(--border-color, #e2e8f0);">
                        <span class="badge-request">Pending Approval</span>
                    </div>
                    
                    <button onclick="updateLocation()" class="btn-update" id="updateBtnInfo">
                        <i class="fa-solid fa-check mr-1"></i> Update Location
                    </button>
                </div>
            `;
        }

        // Google Maps - Callback (if map loads before data)
        function initMap() {
            // Default map (will be updated when data loads)
            map = new google.maps.Map(document.getElementById("map-canvas"), {
                center: { lat: 24.8607, lng: 67.0011 },
                zoom: 6,
                mapTypeId: google.maps.MapTypeId.HYBRID
            });
        }

        // Update Location 
        function updateLocation() {
            // Prevent multiple clicks
            if (isUpdating) return;

            const id = window.requestId;

            if (!id) {
                Swal.fire('Error!', 'No request ID found.', 'error');
                return;
            }

            // Confirm with user
            Swal.fire({
                title: 'Are you sure?',
                text: "This will approve the location and update the dealer's coordinates.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#1d4ed8',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Update!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    isUpdating = true;

                    // Disable the update button in info window
                    const updateBtn = document.getElementById('updateBtnInfo');
                    if (updateBtn) {
                        updateBtn.disabled = true;
                        updateBtn.innerHTML = '<span class="spinner"></span> Updating...';
                    }

                    const url = `${API_BASE_URL}/update/update_dealer_location.php?id=${id}&user_id=${USER_ID}`;

                    $.ajax({
                        url: url,
                        method: 'GET',
                        dataType: 'json',
                        success: function (response) {
                            console.log('Update Response:', response);
                            console.log('Response Type:', typeof response);
                            console.log('Response Value:', JSON.stringify(response));

                            isUpdating = false;

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
                                // Close info window
                                if (currentInfoWindow) {
                                    currentInfoWindow.close();
                                }

                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success!',
                                    text: 'Location updated successfully!',
                                    timer: 2000,
                                    showConfirmButton: true
                                }).then(() => {
                                    // Redirect back to requests list
                                    window.location.href = 'dealer_location_request.php';
                                });
                            } else {
                                // Check if there's an error message in response
                                let errorMsg = 'Record Not Updated';
                                if (response && response.message) {
                                    errorMsg = response.message;
                                } else if (response && response.error) {
                                    errorMsg = response.error;
                                }

                                Swal.fire('Server Error!', errorMsg, 'error');
                                // Re-enable button
                                if (updateBtn) {
                                    updateBtn.disabled = false;
                                    updateBtn.innerHTML = '<i class="fa-solid fa-check mr-1"></i> Update Location';
                                }
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error('Update Error:', error);
                            console.error('XHR Response:', xhr.responseText);
                            console.error('Status:', status);

                            isUpdating = false;

                            let errorMsg = 'Something went wrong while updating the location.';

                            // Try to parse error response
                            try {
                                const errorResponse = JSON.parse(xhr.responseText);
                                if (errorResponse && errorResponse.message) {
                                    errorMsg = errorResponse.message;
                                }
                            } catch (e) {
                                // If response is plain text
                                if (xhr.responseText) {
                                    errorMsg = xhr.responseText;
                                }
                            }

                            Swal.fire('Error!', errorMsg, 'error');

                            // Re-enable button
                            const updateBtn = document.getElementById('updateBtnInfo');
                            if (updateBtn) {
                                updateBtn.disabled = false;
                                updateBtn.innerHTML = '<i class="fa-solid fa-check mr-1"></i> Update Location';
                            }
                        }
                    });
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
    </script>

</body>

</html>