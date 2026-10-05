<?php
// Hascol OMC - Dealers Location Approve (Eng) - Standalone
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Dealers Location Approve | Hascol OMC</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta content="Hascol OMC Management Dashboard" name="description" />

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Google Maps API -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBNyJWb04pByaU1CTmimoWNl3b86VV6qZ8&libraries=drawing&v=weekly" defer></script>

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
            --scrollbar-track: #eef1f6;
            --scrollbar-thumb: #cbd5e1;
            --modal-overlay: rgba(15, 23, 42, 0.45);
            --btn-secondary-bg: #e2e8f0;
            --btn-secondary-text: #334155;
            --btn-secondary-hover-bg: #cbd5e1;
            --btn-secondary-hover-text: #0f2440;
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
            --scrollbar-track: #060b13;
            --scrollbar-thumb: #1a2635;
            --modal-overlay: rgba(6, 11, 19, 0.85);
            --btn-secondary-bg: #1a2635;
            --btn-secondary-text: #94a3b8;
            --btn-secondary-hover-bg: #1f2a3d;
            --btn-secondary-hover-text: #ffffff;
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
        #sidebar, #mainContent {
            transition: all 0.3s ease-in-out;
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
            transition: background-color 0.2s, color 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .btn-secondary:hover {
            background-color: var(--btn-secondary-hover-bg);
            color: var(--btn-secondary-hover-text);
        }

        /* Map Container */
        .map-container {
            position: relative;
            width: 100%;
            height: calc(100vh - 180px);
            min-height: 500px;
            border-radius: 0.375rem;
            overflow: hidden;
            border: 1px solid var(--border-color);
            background-color: var(--bg-panel);
        }

        #map-canvas {
            width: 100%;
            height: 100%;
        }

        /* Info Window Custom Styling */
        .gm-style .gm-style-iw-c {
            background-color: var(--bg-panel) !important;
            border-radius: 0.375rem !important;
            padding: 0 !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15) !important;
        }
        .gm-style .gm-style-iw-d {
            overflow: hidden !important;
            padding: 12px 16px !important;
            background-color: var(--bg-panel) !important;
            color: var(--text-body) !important;
        }
        .gm-style .gm-style-iw-t::after {
            background: var(--bg-panel) !important;
        }
        .gm-ui-hover-effect {
            display: none !important;
        }

        /* Info window content */
        .info-window-content p {
            margin: 4px 0;
            font-size: 12px;
            color: var(--text-body);
        }
        .info-window-content p strong {
            color: var(--text-heading);
            font-weight: 600;
        }
        .info-window-content .btn-update {
            margin-top: 8px;
            width: 100%;
            padding: 6px 12px;
            background-color: #1d4ed8;
            color: #ffffff;
            border: none;
            border-radius: 0.25rem;
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }
        .info-window-content .btn-update:hover {
            background-color: #2563eb;
        }
        .info-window-content .btn-update:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        /* Dark mode for Google Maps info window */
        html.dark-mode .gm-style .gm-style-iw-c,
        html.dark-mode .gm-style .gm-style-iw-d,
        html.dark-mode .gm-style .gm-style-iw-t::after {
            background-color: var(--bg-panel) !important;
        }

        @media (max-width: 1024px) {
            .map-container {
                height: calc(100vh - 200px);
            }
        }
        @media (max-width: 640px) {
            .map-container {
                height: calc(100vh - 220px);
                min-height: 400px;
            }
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
    </style>
</head>

<body class="flex h-screen overflow-hidden text-xs">

    <?php include 'includes/sidebar.php'; ?>

    <main id="mainContent" class="flex-1 flex flex-col overflow-hidden">

        <?php include 'includes/topbar.php'; ?>

        <div class="flex-1 overflow-y-auto p-4" id="pageContent">

            <div class="flex flex-wrap justify-between items-center mb-4 gap-2">
                <div>
                    <h2 class="text-heading font-semibold text-base tracking-wide uppercase">
                        <i class="fa-solid fa-map-location-dot mr-2 text-blue-500"></i>Dealers Location Approve
                    </h2>
                    <p class="text-[10px] text-gray-500">Review and approve dealer location requests</p>
                </div>
                <button onclick="location.reload()" class="btn-secondary flex items-center gap-2">
                    <i class="fa-solid fa-rotate"></i> Refresh
                </button>
            </div>

            <div class="panel-card p-3 mb-4">
                <div class="flex flex-wrap items-center gap-3">
                    <div class="flex items-center gap-2 text-[11px] text-gray-500">
                        <i class="fa-solid fa-circle-info text-blue-500"></i>
                        <span>Click on any marker to view details and update the location.</span>
                    </div>
                    <div class="ml-auto flex items-center gap-2">
                        <span id="markerCount" class="text-[11px] text-gray-500">
                            <i class="fa-solid fa-map-pin mr-1"></i>0 locations
                        </span>
                    </div>
                </div>
            </div>

            <div class="map-container">
                <div id="map-canvas"></div>
                <div id="mapLoadingOverlay" style="position:absolute;inset:0;background:var(--bg-panel);display:flex;align-items:center;justify-content:center;gap:10px;font-size:13px;color:var(--text-muted);z-index:5;border-radius:0.375rem;">
                    <i class="fa-solid fa-spinner fa-spin text-blue-400"></i>
                    Loading map data...
                </div>
            </div>

        </div>
    </main>

    <script>
        function toggleDarkMode() {
            const html = document.documentElement;
            const isDark = html.classList.toggle('dark-mode');
            localStorage.setItem('darkMode', isDark);

            const icon = document.querySelector('.dark-mode-toggle i');
            if (icon) {
                icon.className = isDark ? 'fa-solid fa-sun' : 'fa-solid fa-moon';
            }
        }

        const API_BASE = 'api/';
        const API_KEY = '03201232927';
        const USER_ID = '1';

        let map;
        let gmarkers = [];
        let markerData = [];
        let infoWindow;
        let currentInfoWindow = null;

        $(document).ready(function () {
            $('#sidebarToggle').on('click', function () {
                $('#sidebar').toggleClass('collapsed');
                const isCollapsed = $('#sidebar').hasClass('collapsed');
                localStorage.setItem('sidebarCollapsed', isCollapsed);
            });

            const savedState = localStorage.getItem('sidebarCollapsed');
            if (savedState === 'true') {
                $('#sidebar').addClass('collapsed');
            }

            const isDarkMode = localStorage.getItem('darkMode') === 'true';
            const icon = document.querySelector('.dark-mode-toggle i');
            if (icon) {
                icon.className = isDarkMode ? 'fa-solid fa-sun' : 'fa-solid fa-moon';
            }
        });

        // ============================================================
        // Google Maps Initialize
        // ============================================================
        function initMap() {
            map = new google.maps.Map(document.getElementById("map-canvas"), {
                center: { lat: 24.8607, lng: 67.0011 },
                zoom: 6,
                mapTypeControl: true,
                streetViewControl: false,
                fullscreenControl: true,
                zoomControl: true
            });

            infoWindow = new google.maps.InfoWindow();

            fetchLocations();
        }

        // ============================================================
        // Fetch location requests (same API as live)
        // ============================================================
        function fetchLocations() {
            var req_loc = '47';
            var url = API_BASE + 'get/get_dealer_location_request_eng.php?key=' + API_KEY + '&id=' + req_loc;

            console.log('Fetching locations from:', url);

            $('#mapLoadingOverlay').show();

            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                success: function (data) {
                    console.log('API Response:', data);

                    // Clear previous markers
                    gmarkers.forEach(function (m) { m.setMap(null); });
                    gmarkers = [];
                    markerData = [];

                    if (!data || data.length === 0) {
                        console.warn('No location data found');
                        $('#markerCount').html('<i class="fa-solid fa-map-pin mr-1"></i>0 locations');
                        $('#mapLoadingOverlay').hide();
                        return;
                    }

                    // Handle both array and object response
                    var locations = Array.isArray(data) ? data : (data.data || []);

                    $.each(locations, function (index, item) {
                        var id = item.id;
                        var consignee = item.name || item.dealer_name || 'N/A';
                        var coordinates = item.coordinates;
                        var created_by = item.username || 'N/A';
                        var created_at = item.created_at || 'N/A';

                        if (!coordinates || coordinates === 'null' || coordinates === '') {
                            console.warn('Skipping invalid coordinates for id:', id);
                            return;
                        }

                        var coords = coordinates.split(',');
                        if (coords.length < 2) {
                            console.warn('Invalid coordinate format for id:', id);
                            return;
                        }

                        var lat = parseFloat(coords[0].trim());
                        var lng = parseFloat(coords[1].trim());

                        if (isNaN(lat) || isNaN(lng)) {
                            console.warn('Invalid lat/lng for id:', id);
                            return;
                        }

                        createMarker(lat, lng, consignee, created_by, created_at, id);
                    });

                    $('#markerCount').html('<i class="fa-solid fa-map-pin mr-1"></i>' + gmarkers.length + ' locations');

                    // Fit map to show all markers
                    if (gmarkers.length > 0) {
                        var bounds = new google.maps.LatLngBounds();
                        gmarkers.forEach(function (m) {
                            bounds.extend(m.getPosition());
                        });
                        map.fitBounds(bounds);

                        // If only one marker, zoom in
                        if (gmarkers.length === 1) {
                            map.setZoom(15);
                        }
                    }

                    $('#mapLoadingOverlay').hide();
                },
                error: function (xhr, status, error) {
                    console.error('Fetch Error:', status, error);
                    console.error('Response:', xhr.responseText);
                    $('#mapLoadingOverlay').hide();
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to load location data. Please try again.',
                        timer: 3000,
                        showConfirmButton: true
                    });
                }
            });
        }

        // ============================================================
        // Create Marker on Map
        // ============================================================
        function createMarker(lat, lng, consignee, created_by, created_at, id) {
            const image = "https://www.freeiconspng.com/uploads/fuel-pump-icon-23.png";
            var position = new google.maps.LatLng(lat, lng);

            var marker = new google.maps.Marker({
                position: position,
                map: map,
                icon: {
                    url: image,
                    scaledSize: new google.maps.Size(40, 40)
                },
                animation: google.maps.Animation.DROP,
                title: consignee
            });

            gmarkers.push(marker);

            // Build info window content with theme-aware styling
            var infoContent = `
                <div class="info-window-content" style="min-width:220px;">
                    <p><strong>Consignee:</strong> ${consignee}</p>
                    <p><strong>Request By:</strong> ${created_by}</p>
                    <p><strong>Request At:</strong> ${created_at}</p>
                    <button 
                        onclick="updateLocation(${id}, this)" 
                        class="btn-update"
                        id="btn_update_${id}">
                        <i class="fa-solid fa-location-dot"></i> Update Location
                    </button>
                </div>
            `;

            // Click event
            marker.addListener('click', function () {
                // Close previous info window
                if (currentInfoWindow) {
                    currentInfoWindow.close();
                }

                infoWindow.setContent(infoContent);
                infoWindow.open(map, marker);
                currentInfoWindow = infoWindow;

                // Center map on marker
                map.setCenter(position);
                if (map.getZoom() < 12) {
                    map.setZoom(15);
                }
            });

            // Auto-open first marker's info window
            if (gmarkers.length === 1) {
                infoWindow.setContent(infoContent);
                infoWindow.open(map, marker);
                currentInfoWindow = infoWindow;
            }

            return marker;
        }

        // ============================================================
        // Update Location (same API as live)
        // ============================================================
        function updateLocation(id, btnElement) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'Do you want to update this dealer location?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#1d4ed8',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Yes, update it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (!result.isConfirmed) return;

                if (!id) {
                    Swal.fire('Invalid Input', 'The ID provided is empty or invalid.', 'warning');
                    return;
                }

                if (!USER_ID) {
                    Swal.fire('Error!', 'User ID is not available.', 'error');
                    return;
                }

                var updateUrl = API_BASE + 'update/update_dealer_location_eng.php?id=' + id + '&user_id=' + USER_ID;

                console.log('Updating location:', updateUrl);

                // Disable button while updating
                if (btnElement) {
                    btnElement.disabled = true;
                    btnElement.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Saving...';
                }

                $.ajax({
                    url: updateUrl,
                    method: 'GET',
                    cache: false,
                    success: function (data) {
                        console.log('Update Response:', data);

                        if (data != 1 && data != '1') {
                            Swal.fire('Server Error!', 'Record Not Updated', 'error');
                            if (btnElement) {
                                btnElement.disabled = false;
                                btnElement.innerHTML = '<i class="fa-solid fa-location-dot"></i> Update Location';
                            }
                        } else {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: 'Record Updated Successfully',
                                timer: 2000,
                                showConfirmButton: false
                            });

                            setTimeout(function () {
                                window.location.href = 'dealer_location_request_eng.php';
                            }, 2000);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('AJAX Error:', error);
                        console.error('Status:', status);
                        console.error('Response:', xhr.responseText);
                        Swal.fire('Error!', 'Something went wrong while updating the location.', 'error');
                        if (btnElement) {
                            btnElement.disabled = false;
                            btnElement.innerHTML = '<i class="fa-solid fa-location-dot"></i> Update Location';
                        }
                    }
                });
            });
        }

        // ============================================================
        // Load Google Maps
        // ============================================================
        window.addEventListener('load', function () {
            // If Google Maps API already loaded (defer), initMap will be called by callback
            // Otherwise, wait for the script to finish loading
            if (typeof google !== 'undefined' && google.maps) {
                initMap();
            }
        });
    </script>

</body>
</html>