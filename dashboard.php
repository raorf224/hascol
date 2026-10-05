<?php
// Hascol OMC Operations Command Center - Dynamic Dashboard
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hascol OMC Operations Command Center</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

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
        /* Default = LIGHT theme.                        */
        /* html.dark-mode (set by topbar toggle) = DARK   */
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
            --filter-bg: #f8fafc;
            --map-bg: #eef1f6;
            --ai-bg: #f8fafc;
            --ai-border: #bfdbfe;
            --scrollbar-track: #eef1f6;
            --scrollbar-thumb: #cbd5e1;
            --modal-overlay: rgba(15, 23, 42, 0.45);
            --btn-secondary-bg: #e2e8f0;
            --btn-secondary-text: #334155;
            --btn-secondary-hover-bg: #cbd5e1;
            --btn-secondary-hover-text: #0f2440;
            --toolbar-btn-bg: #ffffff;
            --select-bg: #ffffff;
            --select-text: #1e293b;
            --select-border: #e2e8f0;
            --select-option-bg: #ffffff;
            --select-option-hover: #f1f5f9;
            --select-option-selected: #1d4ed8;
            --leaflet-tile-filter: none;
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
            --filter-bg: #0d1520;
            --map-bg: #04080e;
            --ai-bg: #07111c;
            --ai-border: #1e3a5f;
            --scrollbar-track: #060b13;
            --scrollbar-thumb: #1a2635;
            --modal-overlay: rgba(6, 11, 19, 0.85);
            --btn-secondary-bg: #1a2635;
            --btn-secondary-text: #94a3b8;
            --btn-secondary-hover-bg: #1f2a3d;
            --btn-secondary-hover-text: #ffffff;
            --toolbar-btn-bg: #060b13;
            --select-bg: #060b13;
            --select-text: #e5e7eb;
            --select-border: #1a2635;
            --select-option-bg: #0d1520;
            --select-option-hover: #1a2635;
            --select-option-selected: #1d4ed8;
            --leaflet-tile-filter: invert(100%) hue-rotate(180deg) brightness(95%) contrast(90%);
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

        /* Filter Section Styles - Scrollable */
        .filter-section {
            background-color: var(--filter-bg);
            border-bottom: 1px solid var(--border-color);
            padding: 8px 16px;
            width: 100%;
            flex-shrink: 0;
            transition: background-color .25s ease, border-color .25s ease;
        }

        .filter-section .filter-container {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 6px;
            width: 100%;
        }

        .filter-section .filter-container .filter-item {
            flex: 0 0 auto;
        }

        .filter-item.bg-\[\#060b13\] {
            background-color: var(--input-bg) !important;
            border-color: var(--border-color) !important;
        }

        .filter-item .text-gray-200 {
            color: var(--text-body) !important;
        }

        .filter-item .text-gray-500 {
            color: var(--text-muted) !important;
        }

        /* Leaflet Map Styles */
        .leaflet-container {
            background: var(--map-bg) !important;
            font-family: 'Inter', sans-serif;
        }

        /* Dark mode map tiles */
        html.dark-mode .leaflet-tile {
            filter: var(--leaflet-tile-filter) !important;
        }

        /* Modal Styles */
        #globalModal {
            background: var(--modal-overlay);
            backdrop-filter: blur(8px);
        }

        #modalContentWrapper {
            background-color: var(--bg-panel) !important;
            border-color: var(--border-color) !important;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35);
        }

        html.dark-mode #modalContentWrapper {
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.8);
        }

        #modalContentWrapper .border-b {
            border-color: var(--border-color) !important;
        }

        #modalContentWrapper .border-t {
            border-color: var(--border-color) !important;
        }

        #modalContentWrapper .bg-\[\#09101a\] {
            background-color: var(--filter-bg) !important;
        }

        /* Select2 Custom Styles */
        .select2-container--default .select2-selection--single {
            background-color: var(--select-bg) !important;
            border: 1px solid var(--select-border) !important;
            border-radius: 0.25rem !important;
            height: 28px !important;
            padding: 2px 8px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: var(--select-text) !important;
            font-size: 10px !important;
            line-height: 24px !important;
            padding-left: 4px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 26px !important;
            right: 4px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow b {
            border-color: var(--text-muted) transparent transparent transparent !important;
        }

        .select2-dropdown {
            background-color: var(--select-option-bg) !important;
            border: 1px solid var(--border-color) !important;
            border-radius: 4px !important;
        }

        .select2-search--dropdown {
            padding: 6px !important;
            background: var(--input-bg) !important;
        }

        .select2-search__field {
            background-color: var(--input-bg) !important;
            border: 1px solid var(--border-color) !important;
            border-radius: 4px !important;
            color: var(--text-body) !important;
            font-size: 10px !important;
            padding: 4px 8px !important;
            width: 100% !important;
        }

        .select2-search__field::placeholder {
            color: var(--text-muted) !important;
        }

        .select2-results {
            background: var(--select-option-bg) !important;
        }

        .select2-results__option {
            color: var(--text-muted) !important;
            font-size: 10px !important;
            padding: 6px 12px !important;
        }

        .select2-results__option--highlighted {
            background-color: var(--select-option-hover) !important;
            color: var(--text-heading) !important;
        }

        .select2-container--default .select2-results__option--selected {
            background-color: var(--select-option-selected) !important;
            color: #ffffff !important;
        }

        .select2-container--default .select2-results__option[aria-selected=true] {
            background-color: var(--select-option-selected) !important;
            color: #ffffff !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__clear {
            color: var(--text-muted) !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__placeholder {
            color: var(--text-muted) !important;
        }

        .filter-container .select2 {
            min-width: 100px !important;
        }

        .filter-container .select2-container--default .select2-selection--single {
            height: 26px !important;
            min-height: 26px !important;
            padding: 0 6px !important;
        }

        .filter-container .select2-container--default .select2-selection--single .select2-selection__rendered {
            font-size: 9px !important;
            line-height: 22px !important;
        }

        .filter-container .select2-container {
            width: 100% !important;
            min-width: 90px !important;
        }

        .filter-container .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 24px !important;
        }

        input[type="date"]::-webkit-calendar-picker-indicator {
            filter: invert(0.6);
            cursor: pointer;
        }

        html.dark-mode input[type="date"]::-webkit-calendar-picker-indicator {
            filter: invert(0.6);
        }

        input[type="date"]::-webkit-datetime-edit {
            color: var(--text-body);
        }

        input[type="date"] {
            color-scheme: dark;
        }

        .filter-label {
            font-size: 7px !important;
            line-height: 1 !important;
            margin-bottom: 1px !important;
        }

        /* Custom Info Window for Map */
        .custom-popup .leaflet-popup-content-wrapper {
            background: var(--bg-panel) !important;
            border: 1px solid var(--border-color) !important;
            border-radius: 0.375rem !important;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.25) !important;
            color: var(--text-muted) !important;
        }

        html.dark-mode .custom-popup .leaflet-popup-content-wrapper {
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5) !important;
        }

        .custom-popup .leaflet-popup-tip {
            background: var(--bg-panel) !important;
            border: 1px solid var(--border-color) !important;
        }

        .custom-popup .leaflet-popup-content {
            font-size: 11px !important;
            font-family: 'Inter', sans-serif !important;
            padding: 8px 12px !important;
            min-width: 150px !important;
        }

        .custom-popup .popup-title {
            color: var(--text-heading) !important;
            font-weight: 600 !important;
            font-size: 13px !important;
        }

        .custom-popup .popup-detail {
            color: var(--text-muted) !important;
            font-size: 10px !important;
            margin-top: 2px !important;
        }

        .custom-popup .popup-status {
            display: inline-block !important;
            padding: 1px 8px !important;
            border-radius: 9999px !important;
            font-size: 9px !important;
            font-weight: 600 !important;
            margin-top: 4px !important;
        }

        .popup-status-green {
            background: #10b98120 !important;
            color: #10b981 !important;
            border: 1px solid #10b98140 !important;
        }

        .popup-status-yellow {
            background: #f59e0b20 !important;
            color: #f59e0b !important;
            border: 1px solid #f59e0b40 !important;
        }

        .popup-status-red {
            background: #ef444420 !important;
            color: #ef4444 !important;
            border: 1px solid #ef444440 !important;
        }

        .popup-status-gray {
            background: #6b728020 !important;
            color: #6b7280 !important;
            border: 1px solid #6b728040 !important;
        }

        /* Loading shimmer effect */
        .loading-shimmer {
            background: linear-gradient(90deg, var(--bg-panel) 25%, var(--border-color) 50%, var(--bg-panel) 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
        }

        @keyframes shimmer {
            0% {
                background-position: -200% 0;
            }

            100% {
                background-position: 200% 0;
            }
        }

        /* AI Insights */
        #aiInsights {
            background-color: var(--ai-bg) !important;
            border-color: var(--ai-border) !important;
            transition: background-color .25s ease, border-color .25s ease;
        }

        /* Map Markers - Fixed for dark mode */
        .leaflet-div-icon {
            background: transparent !important;
            border: none !important;
        }

        .map-marker {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            position: relative;
        }

        .marker-green {
            background-color: #10b981;
            box-shadow: 0 0 10px #10b981, 0 0 20px #10b981;
        }

        .marker-yellow {
            background-color: #f59e0b;
            box-shadow: 0 0 10px #f59e0b, 0 0 20px #f59e0b;
        }

        .marker-red {
            background-color: #ef4444;
            box-shadow: 0 0 10px #ef4444, 0 0 20px #ef4444;
        }

        .marker-gray {
            background-color: #6b7280;
            box-shadow: 0 0 10px #6b7280, 0 0 20px #6b7280;
        }

        .map-marker::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            border-radius: 50%;
            animation: pulse-glow 1.8s infinite ease-in-out;
            opacity: 0.6;
        }

        .marker-green::after {
            border: 2px solid #10b981;
        }

        .marker-yellow::after {
            border: 2px solid #f59e0b;
        }

        .marker-red::after {
            border: 2px solid #ef4444;
        }

        .marker-gray::after {
            border: 2px solid #6b7280;
            animation: none;
        }

        @keyframes pulse-glow {
            0% {
                transform: scale(1);
                opacity: 0.9;
            }

            100% {
                transform: scale(3);
                opacity: 0;
            }
        }

        /* KPI Card Border Fixes */
        .panel-card.border-red-900\/50 {
            border-color: rgba(239, 68, 68, 0.3) !important;
        }

        .panel-card.border-emerald-900\/30 {
            border-color: rgba(16, 185, 129, 0.2) !important;
        }

        .panel-card.border-amber-900\/30 {
            border-color: rgba(245, 158, 11, 0.2) !important;
        }

        .panel-card.border-indigo-900\/30 {
            border-color: rgba(99, 102, 241, 0.2) !important;
        }

        .bg-gradient-to-br.from-\[\#0d1520\] {
            background: var(--bg-panel) !important;
        }

        .bg-red-950\/20 {
            background: rgba(239, 68, 68, 0.1) !important;
        }

        .bg-amber-950\/10 {
            background: rgba(245, 158, 11, 0.08) !important;
        }

        .bg-indigo-950\/10 {
            background: rgba(99, 102, 241, 0.08) !important;
        }

        /* Map container */
        .leaflet-container {
            background: var(--map-bg) !important;
        }

        /* Make sure markers are visible in dark mode */
        html.dark-mode .map-marker {
            filter: brightness(1.2) !important;
        }

        html.dark-mode .marker-green {
            box-shadow: 0 0 15px #10b981, 0 0 30px #10b981 !important;
        }

        html.dark-mode .marker-yellow {
            box-shadow: 0 0 15px #f59e0b, 0 0 30px #f59e0b !important;
        }

        html.dark-mode .marker-red {
            box-shadow: 0 0 15px #ef4444, 0 0 30px #ef4444 !important;
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
        <!-- DASHBOARD CONTENT (Scrollable)               -->
        <!-- ============================================ -->
        <div class="flex-1 overflow-y-auto" id="dashboardContent">

            <!-- ============================================ -->
            <!-- FILTER SECTION - Scrollable                  -->
            <!-- ============================================ -->
            <div class="filter-section">
                <div class="filter-container">
                    <!-- Date Range - Date Picker -->
                    <div class="filter-item bg-[#060b13] border border-[#1a2635] px-2 py-1 rounded flex items-center gap-1" style="background-color: var(--input-bg) !important; border-color: var(--border-color) !important;">
                        <span class="text-gray-500 text-[8px] leading-none" style="color: var(--text-muted) !important;">From</span>
                        <input type="date" id="filterDateFrom"
                            class="bg-transparent text-gray-200 text-[10px] focus:outline-none cursor-pointer"
                            style="min-width:90px; color-scheme: dark; color: var(--text-body) !important;" value="">
                        <span class="text-gray-500 text-[8px] leading-none mx-0.5" style="color: var(--text-muted) !important;">To</span>
                        <input type="date" id="filterDateTo"
                            class="bg-transparent text-gray-200 text-[10px] focus:outline-none cursor-pointer"
                            style="min-width:90px; color-scheme: dark; color: var(--text-body) !important;" value="">
                    </div>

                    <!-- Region -->
                    <div class="filter-item bg-[#060b13] border border-[#1a2635] px-2 py-1 rounded flex flex-col justify-center min-w-[100px]" style="background-color: var(--input-bg) !important; border-color: var(--border-color) !important;">
                        <span class="text-gray-500 text-[7px] leading-none mb-0.5 filter-label" style="color: var(--text-muted) !important;">Region</span>
                        <select id="filterRegion"
                            class="bg-transparent text-gray-200 font-medium leading-none text-[10px] focus:outline-none cursor-pointer region-select w-full"
                            style="min-width:80px; color: var(--text-body) !important;">
                            <option value="all">All Regions</option>
                        </select>
                    </div>

                    <!-- Territory -->
                    <div class="filter-item bg-[#060b13] border border-[#1a2635] px-2 py-1 rounded flex flex-col justify-center min-w-[100px]" style="background-color: var(--input-bg) !important; border-color: var(--border-color) !important;">
                        <span class="text-gray-500 text-[7px] leading-none mb-0.5 filter-label" style="color: var(--text-muted) !important;">Territory</span>
                        <select id="filterTerritory"
                            class="bg-transparent text-gray-200 font-medium leading-none text-[10px] focus:outline-none cursor-pointer w-full"
                            style="min-width:80px; color: var(--text-body) !important;">
                            <option value="all">All Territories</option>
                        </select>
                    </div>

                    <!-- TM -->
                    <div class="filter-item bg-[#060b13] border border-[#1a2635] px-2 py-1 rounded flex flex-col justify-center min-w-[100px]" style="background-color: var(--input-bg) !important; border-color: var(--border-color) !important;">
                        <span class="text-gray-500 text-[7px] leading-none mb-0.5 filter-label" style="color: var(--text-muted) !important;">TM</span>
                        <select id="filterTM"
                            class="bg-transparent text-gray-200 font-medium leading-none text-[10px] focus:outline-none cursor-pointer tm-select w-full"
                            style="min-width:80px; color: var(--text-body) !important;">
                            <option value="all">All TMs</option>
                        </select>
                    </div>

                    <!-- Site -->
                    <div class="filter-item bg-[#060b13] border border-[#1a2635] px-2 py-1 rounded flex flex-col justify-center min-w-[100px]" style="background-color: var(--input-bg) !important; border-color: var(--border-color) !important;">
                        <span class="text-gray-500 text-[7px] leading-none mb-0.5 filter-label" style="color: var(--text-muted) !important;">Site</span>
                        <select id="filterSite"
                            class="bg-transparent text-gray-200 font-medium leading-none text-[10px] focus:outline-none cursor-pointer site-select w-full"
                            style="min-width:80px; color: var(--text-body) !important;">
                            <option value="all">All Sites</option>
                        </select>
                    </div>

                    <!-- Product -->
                    <div class="filter-item bg-[#060b13] border border-[#1a2635] px-2 py-1 rounded flex flex-col justify-center min-w-[100px]" style="background-color: var(--input-bg) !important; border-color: var(--border-color) !important;">
                        <span class="text-gray-500 text-[7px] leading-none mb-0.5 filter-label" style="color: var(--text-muted) !important;">Product</span>
                        <select id="filterProduct"
                            class="bg-transparent text-gray-200 font-medium leading-none text-[10px] focus:outline-none cursor-pointer w-full"
                            style="min-width:80px; color: var(--text-body) !important;">
                            <option value="all">All Products</option>
                        </select>
                    </div>

                    <div class="filter-item h-6 border-l border-[#1a2635] mx-1" style="border-color: var(--border-color) !important;"></div>

                    <!-- Action Buttons -->
                    <div class="filter-item flex items-center gap-1.5">
                        <button id="refreshBtn"
                            class="px-2.5 py-1.5 bg-[#060b13] border border-[#1a2635] hover:bg-slate-800 text-gray-200 rounded transition flex flex-col items-center justify-center"
                            style="background-color: var(--input-bg) !important; border-color: var(--border-color) !important; color: var(--text-body) !important;">
                            <i class="fa-solid fa-arrows-rotate text-[10px] mb-0.5"></i><span class="text-[8px]">Refresh</span>
                        </button>
                        <button
                            class="px-2.5 py-1.5 bg-blue-600 hover:bg-blue-500 text-white rounded transition flex flex-col items-center justify-center">
                            <i class="fa-solid fa-file-export text-[10px] mb-0.5"></i><span class="text-[8px]">Export</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- ============================================ -->
            <!-- DASHBOARD WIDGETS                            -->
            <!-- ============================================ -->
            <div class="p-3 space-y-3">

                <!-- KPI Cards -->
                <div class="grid grid-cols-9 gap-2" id="kpiCards">
                    <!-- Will be populated by AJAX -->
                </div>

                <!-- Middle Section -->
                <div class="grid grid-cols-12 gap-3">
                    <!-- Network Overview -->
                    <div class="col-span-3 panel-card p-3 flex flex-col" id="networkOverview">
                        <div class="text-[11px] text-heading font-semibold uppercase tracking-wider mb-0">Network Overview
                        </div>
                        <div class="relative flex items-center justify-center flex-1 mt-2">
                            <div id="networkSpeedometer" class="w-full relative top-2"></div>
                            <div class="absolute bottom-6 flex flex-col items-center">
                                <span class="text-2xl font-bold text-heading leading-none" id="speedoValue">--</span>
                                <span class="text-[10px] text-muted" style="color: var(--text-muted) !important;">/100</span>
                                <span class="text-[9px] uppercase font-bold px-3 py-0.5 rounded-full mt-1"
                                    id="speedoStatus">Loading...</span>
                            </div>
                        </div>
                        <div class="space-y-2 text-[10px] border-t pt-3" style="border-color: var(--border-color) !important;" id="healthDistribution">
                            <!-- Will be populated by AJAX -->
                        </div>
                        <div class="text-center mt-2 pt-2 border-t" style="border-color: var(--border-color) !important;">
                            <a href="#" onclick="openModal('siteHealth')"
                                class="text-blue-400 text-[10px] hover:underline">View Site Health Analysis <i
                                    class="fa-solid fa-arrow-right ml-1"></i></a>
                        </div>
                    </div>

                    <!-- Map -->
                    <div class="col-span-6 panel-card flex flex-col relative overflow-hidden" style="background-color: var(--map-bg) !important;">
                        <div
                            class="p-3 flex justify-between items-center z-10 relative bg-gradient-to-b from-[#0d1520] to-transparent" style="background: linear-gradient(to bottom, var(--bg-panel), transparent) !important;">
                            <div class="text-[11px] text-heading font-semibold uppercase tracking-wider">Site Coverage Map
                            </div>
                            <div class="flex space-x-3 text-[9px] text-gray-300" style="color: var(--text-muted) !important;">
                                <span class="flex items-center"><i
                                        class="fa-solid fa-circle text-emerald-500 text-[8px] mr-1 shadow-[0_0_5px_#10b981]"></i>
                                    Healthy</span>
                                <span class="flex items-center"><i
                                        class="fa-solid fa-circle text-amber-500 text-[8px] mr-1 shadow-[0_0_5px_#f59e0b]"></i>
                                    Warning</span>
                                <span class="flex items-center"><i
                                        class="fa-solid fa-circle text-red-500 text-[8px] mr-1 shadow-[0_0_5px_#ef4444]"></i>
                                    Critical</span>
                                <span class="flex items-center"><i
                                        class="fa-solid fa-circle text-gray-500 text-[8px] mr-1"></i> Not Visited</span>
                            </div>
                        </div>
                        <div class="flex-1 w-full relative min-h-[260px] z-0">
                            <div id="coverageMap" class="w-full h-full absolute inset-0"></div>
                        </div>
                    </div>

                    <!-- Alerts Center -->
                    <div class="col-span-3 panel-card p-3 flex flex-col">
                        <div class="flex justify-between items-center mb-3">
                            <div class="text-[11px] text-heading font-semibold uppercase tracking-wider">Alerts Center</div>
                            <a href="#" class="text-blue-400 text-[9px] hover:underline">View All <i
                                    class="fa-solid fa-arrow-right"></i></a>
                        </div>
                        <div class="space-y-2 flex-1 overflow-y-auto pr-1" id="alertsContainer">
                            <!-- Will be populated by AJAX -->
                        </div>
                    </div>
                </div>

                <!-- Bottom Section -->
                <div class="grid grid-cols-12 gap-3">
                    <!-- Uplift vs Dumping Trend -->
                    <div class="col-span-4 panel-card p-3 flex flex-col">
                        <div class="flex justify-between items-center mb-1">
                            <div class="text-[11px] text-heading font-semibold uppercase tracking-wider">Uplift vs Dumping
                                Trend (KL)</div>
                            <div class="flex space-x-2 text-[9px]"><span class="text-blue-400"><i
                                        class="fa-solid fa-minus"></i> Uplift</span><span class="text-amber-400"><i
                                        class="fa-solid fa-minus"></i> Dumping</span></div>
                        </div>
                        <div id="trendLineChart" class="w-full h-32 mb-1"></div>
                        <div class="grid grid-cols-3 gap-2 border-t pt-2 text-center" style="border-color: var(--border-color) !important;" id="trendTotals">
                            <!-- Will be populated by AJAX -->
                        </div>
                    </div>

                    <!-- Variance Analysis -->
                    <div class="col-span-4 panel-card p-3 flex flex-col" id="varianceAnalysis">
                        <div class="text-[11px] text-heading font-semibold uppercase tracking-wider mb-2">Variance Analysis
                        </div>
                        <div class="grid grid-cols-3 gap-2 mb-3 text-center border-b pb-2" style="border-color: var(--border-color) !important;"
                            id="varianceStats">
                            <!-- Will be populated by AJAX -->
                        </div>
                        <div class="grid grid-cols-12 gap-3 items-center flex-1">
                            <div class="col-span-5 relative">
                                <p class="text-[9px] text-gray-400 font-semibold mb-2 uppercase text-center" style="color: var(--text-muted) !important;">Variance % Dist
                                </p>
                                <div id="varianceDonutChart" class="flex justify-center"></div>
                                <div
                                    class="absolute right-0 top-1/2 -translate-y-1/2 flex flex-col space-y-1 text-[8px] text-gray-300" style="color: var(--text-muted) !important;">
                                    <span class="flex items-center"><i class="fa-solid fa-square text-[#10b981] mr-1"></i>
                                        0-1%</span>
                                    <span class="flex items-center"><i class="fa-solid fa-square text-[#3b82f6] mr-1"></i>
                                        1-2%</span>
                                    <span class="flex items-center"><i class="fa-solid fa-square text-[#f59e0b] mr-1"></i>
                                        2-5%</span>
                                    <span class="flex items-center"><i class="fa-solid fa-square text-[#ef4444] mr-1"></i>
                                        >5%</span>
                                </div>
                            </div>
                            <div class="col-span-7">
                                <p class="text-[9px] text-gray-400 font-semibold mb-1 uppercase" style="color: var(--text-muted) !important;">Top 5 High Variance Sites
                                </p>
                                <table class="w-full text-[10px] text-left">
                                    <thead class="text-gray-500 border-b text-[9px]" style="border-color: var(--border-color) !important; color: var(--text-muted) !important;">
                                        <tr>
                                            <th class="pb-1 font-medium">Site</th>
                                            <th class="pb-1 font-medium text-center">Variance %</th>
                                            <th class="pb-1 font-medium text-right">Stock Loss (KL)</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-gray-300 divide-y divide-[#1a2635]/30" style="color: var(--text-body) !important;" id="varianceTopSites">
                                        <!-- Will be populated by AJAX -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Recon Cycle Efficiency -->
                    <div class="col-span-4 panel-card p-3 flex flex-col" id="reconEfficiency">
                        <div class="text-[11px] text-heading font-semibold uppercase tracking-wider mb-2">Recon Cycle
                            Efficiency</div>
                        <div class="grid grid-cols-4 gap-2 mb-3 text-center border-b pb-2" style="border-color: var(--border-color) !important;" id="reconStats">
                            <!-- Will be populated by AJAX -->
                        </div>
                        <div class="grid grid-cols-2 gap-3 flex-1 items-center">
                            <div>
                                <p class="text-[9px] text-gray-400 font-semibold mb-2 uppercase" style="color: var(--text-muted) !important;">Recon Pipeline</p>
                                <div class="flex items-center w-full mt-1">
                                    <div class="flex flex-col items-center w-[45%]" id="pipelineBars">
                                        <!-- Will be populated by AJAX -->
                                    </div>
                                    <div class="flex flex-col justify-center space-y-[4px] w-[55%] pl-2 text-[9px]"
                                        id="pipelineLabels" style="color: var(--text-body) !important;">
                                        <!-- Will be populated by AJAX -->
                                    </div>
                                </div>
                            </div>
                            <div>
                                <p class="text-[9px] text-gray-400 font-semibold mb-1 uppercase" style="color: var(--text-muted) !important;">Recon Backlog Trend</p>
                                <div id="backlogTrendChart" class="w-full h-24"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bottom Section 2 -->
                <div class="grid grid-cols-12 gap-3">
                    <!-- TM Performance -->
                    <div class="col-span-4 panel-card p-3">
                        <div class="flex justify-between items-center mb-2">
                            <div class="text-[11px] text-heading font-semibold uppercase tracking-wider">TM Performance
                                Leaderboard</div>
                            <a href="#" class="text-blue-400 text-[9px] hover:underline">View All <i
                                    class="fa-solid fa-arrow-right"></i></a>
                        </div>
                        <table class="w-full text-left text-[10px]">
                            <thead>
                                <tr class="text-gray-400 border-b text-[9px]" style="border-color: var(--border-color) !important; color: var(--text-muted) !important;">
                                    <th class="pb-1.5 font-medium">Rank</th>
                                    <th class="pb-1.5 font-medium">TM Name</th>
                                    <th class="pb-1.5 font-medium text-center">Coverage %</th>
                                    <th class="pb-1.5 font-medium text-center">Recons</th>
                                    <th class="pb-1.5 font-medium text-center">Variance Caught</th>
                                    <th class="pb-1.5 font-medium text-right">TM Score</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-200 divide-y divide-[#1a2635]/40" style="color: var(--text-body) !important;" id="tmLeaderboard">
                                <!-- Will be populated by AJAX -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Site Health Score Distribution -->
                    <div class="col-span-3 panel-card p-3 flex flex-col justify-between">
                        <div class="text-[11px] text-heading font-semibold uppercase tracking-wider mb-2">Site Health Score
                            Distribution</div>
                        <div id="healthScoreDonutChart" class="flex-1 flex items-center justify-center"></div>
                    </div>

                    <!-- Top Sites -->
                    <div class="col-span-5 grid grid-cols-2 gap-3">
                        <div class="panel-card p-3" id="bestSites">
                            <div class="text-[10px] text-emerald-400 font-bold uppercase tracking-wider mb-2"><i
                                    class="fa-solid fa-circle-arrow-up mr-1"></i> Top 5 Best Performing Sites</div>
                            <table class="w-full text-left text-[10px] tracking-tight">
                                <thead class="text-gray-500 border-b text-[9px]" style="border-color: var(--border-color) !important; color: var(--text-muted) !important;">
                                    <tr>
                                        <th class="pb-1 font-medium">Site</th>
                                        <th class="pb-1 font-medium text-center">Health Score</th>
                                        <th class="pb-1 font-medium text-center">Variance %</th>
                                        <th class="pb-1 font-medium text-right">Uplift Regularity</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-300 divide-y divide-[#1a2635]/30" style="color: var(--text-body) !important;" id="bestSitesBody">
                                    <!-- Will be populated by AJAX -->
                                </tbody>
                            </table>
                        </div>

                        <div class="panel-card p-3" id="riskySites">
                            <div class="text-[10px] text-red-400 font-bold uppercase tracking-wider mb-2"><i
                                    class="fa-solid fa-circle-arrow-down mr-1"></i> Top 5 Risky Sites</div>
                            <table class="w-full text-left text-[10px] tracking-tight">
                                <thead class="text-gray-500 border-b text-[9px]" style="border-color: var(--border-color) !important; color: var(--text-muted) !important;">
                                    <tr>
                                        <th class="pb-1 font-medium">Site</th>
                                        <th class="pb-1 font-medium text-center">Health Score</th>
                                        <th class="pb-1 font-medium text-center">Variance %</th>
                                        <th class="pb-1 font-medium text-right">Last Visit</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-300 divide-y divide-[#1a2635]/30" style="color: var(--text-body) !important;" id="riskySitesBody">
                                    <!-- Will be populated by AJAX -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- AI Insights -->
                <div class="panel-card p-2.5 flex items-center justify-between text-[10px] border border-blue-900/30 shadow-[0_0_15px_rgba(29,78,216,0.15)]"
                    id="aiInsights" style="background-color: var(--ai-bg) !important; border-color: var(--ai-border) !important;">
                    <div class="flex items-center text-heading font-bold tracking-wider space-x-2 flex-shrink-0 w-24">
                        <i class="fa-solid fa-wand-magic-sparkles text-blue-400 text-lg"></i>
                        <span class="text-[11px]">AI INSIGHTS</span>
                    </div>
                    <div class="grid grid-cols-5 gap-3 px-4 border-l border-r border-[#1a2635] mx-2 flex-1" style="border-color: var(--border-color) !important;"
                        id="aiInsightsContent">
                        <!-- Will be populated by AJAX -->
                    </div>
                    <div class="text-right text-gray-500 text-[9px] leading-none flex-shrink-0 w-28" style="color: var(--text-muted) !important;">
                        Data as of<br>
                        <strong class="text-heading text-[10px] mt-1 inline-block" id="dataTimestamp">Loading...</strong>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <!-- Global Modal -->
    <div id="globalModal"
        class="fixed inset-0 z-50 hidden backdrop-blur-sm flex items-center justify-center transition-opacity duration-300 opacity-0">
        <div class="border rounded-lg shadow-2xl w-11/12 max-w-4xl flex flex-col max-h-[85vh] transform scale-95 transition-transform duration-300"
            id="modalContentWrapper">
            <div class="flex justify-between items-center p-4 border-b" style="border-color: var(--border-color) !important;">
                <h3 id="modalTitle" class="text-heading font-semibold tracking-wide uppercase text-sm">Modal Title</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-red-500 transition"><i
                        class="fa-solid fa-xmark text-lg"></i></button>
            </div>
            <div id="modalBody" class="p-4 overflow-y-auto text-sm text-gray-300 flex-1" style="color: var(--text-body) !important;">
                <div class="flex items-center justify-center h-32">
                    <i class="fa-solid fa-spinner fa-spin text-2xl text-blue-400"></i>
                    <span class="ml-3">Loading data...</span>
                </div>
            </div>
            <div class="p-3 border-t text-right rounded-b-lg" style="border-color: var(--border-color) !important; background-color: var(--filter-bg) !important;">
                <button onclick="closeModal()"
                    class="px-4 py-1.5 bg-slate-800 hover:bg-slate-700 text-white rounded text-xs transition">Close</button>
            </div>
        </div>
    </div>

    <!-- ============================================ -->
    <!-- SIDEBAR TOGGLE JAVASCRIPT                    -->
    <!-- ============================================ -->
    <script>
        $(document).ready(function() {
            // Sidebar Toggle
            $('#sidebarToggle').on('click', function() {
                $('#sidebar').toggleClass('collapsed');
                const isCollapsed = $('#sidebar').hasClass('collapsed');
                localStorage.setItem('sidebarCollapsed', isCollapsed);
            });

            // Restore sidebar state from localStorage
            const savedState = localStorage.getItem('sidebarCollapsed');
            if (savedState === 'true') {
                $('#sidebar').addClass('collapsed');
            }
        });
    </script>

    <!-- ============================================ -->
    <!-- DASHBOARD JAVASCRIPT                          -->
    <!-- ============================================ -->
    <script>
        // ============================================
        // Global Variables for Charts
        // ============================================
        let speedoChart, trendChart, varianceChart, backlogChart, healthChart;
        let mapInstance = null;
        let mapMarkers = [];
        let currentFilterParams = {};
        let isLoading = false;

        // Loading flags to prevent duplicate calls
        var loadingFlags = {
            kpi: false,
            network: false,
            map: false,
            alerts: false,
            trends: false,
            variance: false,
            recon: false,
            tm: false,
            health: false,
            topsites: false,
            ai: false
        };

        // ============================================
        // Utility Functions
        // ============================================
        function formatNumber(num) {
            if (num >= 1000000) return (num / 1000000).toFixed(1) + 'M';
            if (num >= 1000) return (num / 1000).toFixed(1) + 'K';
            return num.toString();
        }

        function getStatusText(score) {
            if (score >= 80) return { text: 'Excellent', color: 'emerald' };
            if (score >= 60) return { text: 'Good', color: 'emerald' };
            if (score >= 40) return { text: 'Warning', color: 'amber' };
            return { text: 'Critical', color: 'red' };
        }

        function getStatusClass(status) {
            var map = {
                'healthy': 'popup-status-green',
                'warning': 'popup-status-yellow',
                'critical': 'popup-status-red',
                'not_visited': 'popup-status-gray'
            };
            return map[status] || 'popup-status-gray';
        }

        // ============================================
        // Cache Loader - FAST!
        // ============================================
        function loadFromCache(apiName, callback, params) {
            // Get current filter params
            var filterParams = params || getFilterParams();

            // First try: Read from cache with filters
            $.ajax({
                url: 'api/cache_manager.php',
                type: 'GET',
                data: {
                    action: 'read',
                    file: apiName,
                    date_from: filterParams.date_from,
                    date_to: filterParams.date_to,
                    region: filterParams.region,
                    territory: filterParams.territory,
                    tm: filterParams.tm,
                    site: filterParams.site,
                    product: filterParams.product
                },
                dataType: 'json',
                timeout: 10000,
                success: function(response) {
                    if (response.success && response.data && response.data.success) {
                        if (callback) callback(response.data);
                        if (response.stale) {
                            console.log('Cache is stale, updating in background...');
                        }
                    } else {
                        console.log('Cache failed, calling API directly...');
                        callDirectAPI(apiName, callback, filterParams);
                    }
                },
                error: function(xhr, status, error) {
                    console.log('Cache error: ' + status + ' - ' + error);
                    callDirectAPI(apiName, callback, filterParams);
                }
            });
        }

        function callDirectAPI(apiName, callback, params) {
            $.ajax({
                url: 'api/' + apiName + '.php',
                type: 'GET',
                data: params || getFilterParams(),
                dataType: 'json',
                timeout: 30000,
                success: function(response) {
                    if (callback) callback(response);
                },
                error: function(xhr, status, error) {
                    console.log('Error loading ' + apiName + ': ' + status + ' - ' + error);
                }
            });
        }

        // ============================================
        // Initialize Charts
        // ============================================
        function initCharts() {
            // 1. Speedometer
            speedoChart = new ApexCharts(document.querySelector("#networkSpeedometer"), {
                series: [0],
                chart: { type: 'radialBar', height: 160, offsetY: -10, sparkline: { enabled: true } },
                plotOptions: {
                    radialBar: {
                        startAngle: -90,
                        endAngle: 90,
                        hollow: { size: '60%' },
                        track: {
                            background: "#1a2635",
                            strokeWidth: '100%',
                            margin: 5,
                            dropShadow: { enabled: true, top: 0, left: 0, blur: 3, opacity: 0.5 }
                        },
                        dataLabels: { show: false }
                    }
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shade: 'dark',
                        type: 'horizontal',
                        gradientToColors: ['#10b981'],
                        colorStops: [
                            { offset: 0, color: '#ef4444' },
                            { offset: 50, color: '#f59e0b' },
                            { offset: 100, color: '#10b981' }
                        ]
                    }
                },
                stroke: { lineCap: "round" }
            });
            speedoChart.render();

            // 2. Trend Chart
            trendChart = new ApexCharts(document.querySelector("#trendLineChart"), {
                series: [{ name: 'Uplift (KL)', data: [] }, { name: 'Dumping (KL)', data: [] }],
                chart: { type: 'line', height: 120, toolbar: { show: false }, parentHeightOffset: 0 },
                colors: ['#3b82f6', '#f59e0b'],
                stroke: { curve: 'smooth', width: 2 },
                markers: { size: 3 },
                xaxis: {
                    categories: [],
                    labels: { style: { colors: '#64748b', fontSize: '9px' } },
                    axisBorder: { show: false },
                    axisTicks: { show: false }
                },
                yaxis: { labels: { show: false } },
                grid: {
                    borderColor: '#1a2635',
                    strokeDashArray: 3,
                    xaxis: { lines: { show: true } },
                    yaxis: { lines: { show: false } }
                },
                legend: { show: false },
                dataLabels: { enabled: false }
            });
            trendChart.render();

            // 3. Variance Donut Chart
            varianceChart = new ApexCharts(document.querySelector("#varianceDonutChart"), {
                series: [0, 0, 0, 0],
                chart: { type: 'donut', height: 110, parentHeightOffset: 0 },
                colors: ['#10b981', '#3b82f6', '#f59e0b', '#ef4444'],
                plotOptions: { pie: { donut: { size: '65%' }, expandOnClick: false } },
                dataLabels: { enabled: false },
                legend: { show: false },
                stroke: { show: true, colors: '#0d1520', width: 2 }
            });
            varianceChart.render();

            // 4. Backlog Trend Chart
            backlogChart = new ApexCharts(document.querySelector("#backlogTrendChart"), {
                series: [{ name: 'Backlog Trend', data: [] }],
                chart: { type: 'line', height: 90, toolbar: { show: false }, parentHeightOffset: 0 },
                colors: ['#0ea5e9'],
                stroke: { curve: 'straight', width: 2 },
                markers: { size: 4, colors: ['#0ea5e9'], strokeColors: '#0d1520', strokeWidth: 2 },
                xaxis: {
                    categories: [],
                    labels: { style: { colors: '#64748b', fontSize: '8px' } },
                    axisBorder: { show: false },
                    axisTicks: { show: false }
                },
                yaxis: { labels: { show: false } },
                grid: { show: false },
                dataLabels: {
                    enabled: true,
                    offsetY: -10,
                    style: { fontSize: '8px', colors: ['#94a3b8'] },
                    background: { enabled: false }
                }
            });
            backlogChart.render();

            // 5. Health Score Donut Chart
            healthChart = new ApexCharts(document.querySelector("#healthScoreDonutChart"), {
                series: [0, 0, 0, 0],
                chart: { type: 'donut', height: 140 },
                labels: ['80-100 (Excellent)', '60-80 (Good)', '40-60 (Warning)', '0-40 (Critical)'],
                colors: ['#10b981', '#f59e0b', '#f97316', '#ef4444'],
                plotOptions: {
                    pie: {
                        donut: {
                            size: '70%',
                            labels: {
                                show: true,
                                name: { show: false },
                                value: {
                                    show: true,
                                    fontSize: '20px',
                                    fontWeight: 'bold',
                                    color: '#fff',
                                    formatter: function() { return "0" }
                                },
                                total: {
                                    show: true,
                                    showAlways: true,
                                    label: 'Total Sites',
                                    color: '#64748b',
                                    fontSize: '9px'
                                }
                            }
                        }
                    }
                },
                dataLabels: { enabled: false },
                legend: {
                    position: 'right',
                    fontSize: '9px',
                    labels: { colors: '#94a3b8' },
                    markers: { width: 8, height: 8, radius: 2 }
                },
                stroke: { show: true, colors: '#0d1520', width: 2 }
            });
            healthChart.render();
        }

        // ============================================
        // Initialize Map
        // ============================================
        function initMap() {
            mapInstance = L.map('coverageMap', {
                center: [29.5, 69.5],
                zoom: 4.8,
                zoomControl: true,
                attributionControl: false
            });
            L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
                subdomains: 'abcd',
                maxZoom: 10
            }).addTo(mapInstance);
        }

        function addMapMarker(site) {
            var statusClass = getStatusClass(site.status);
            var popupContent = `
                <div>
                    <div class="popup-title">${site.name}</div>
                    <div class="popup-detail"><i class="fa-solid fa-location-dot mr-1"></i> ${site.city || 'N/A'}</div>
                    <div class="popup-detail"><i class="fa-solid fa-tag mr-1"></i> Variance: ${site.variance !== null ? site.variance.toFixed(2) + '%' : 'N/A'}</div>
                    <div class="popup-detail"><i class="fa-regular fa-clock mr-1"></i> ${site.last_visit || 'Never'}</div>
                    <span class="popup-status ${statusClass}">${site.status.replace('_', ' ').toUpperCase()}</span>
                </div>
            `;

            var colorClass = 'marker-' + site.color;

            var icon = L.divIcon({
                className: 'custom-leaflet-marker',
                html: `<div class="map-marker ${colorClass}"></div>`,
                iconSize: [10, 10],
                iconAnchor: [5, 5]
            });

            var marker = L.marker([site.lat, site.lng], { icon: icon })
                .bindPopup(popupContent, {
                    className: 'custom-popup',
                    maxWidth: 220,
                    minWidth: 160
                })
                .addTo(mapInstance);

            mapMarkers.push(marker);
            return marker;
        }

        function clearMapMarkers() {
            mapMarkers.forEach(function(marker) {
                mapInstance.removeLayer(marker);
            });
            mapMarkers = [];
        }

        // ============================================
        // Initialize Select2
        // ============================================
        function initSelect2() {
            if ($('#filterRegion').data('select2')) { $('#filterRegion').select2('destroy'); }
            if ($('#filterTM').data('select2')) { $('#filterTM').select2('destroy'); }
            if ($('#filterSite').data('select2')) { $('#filterSite').select2('destroy'); }
            if ($('#filterTerritory').data('select2')) { $('#filterTerritory').select2('destroy'); }
            if ($('#filterProduct').data('select2')) { $('#filterProduct').select2('destroy'); }

            $('#filterRegion, #filterTerritory, #filterTM, #filterSite, #filterProduct').each(function() {
                var placeholder = $(this).find('option:selected').text() || 'Select...';
                $(this).select2({
                    placeholder: placeholder,
                    allowClear: false,
                    width: '100%',
                    dropdownAutoWidth: true,
                    minimumResultsForSearch: 5,
                    theme: 'default'
                });
            });
        }

        // ============================================
        // Filter Functions
        // ============================================
        function loadFilterOptions() {
            loadFromCache('filter_options', function(response) {
                if (response.success) {
                    // Regions
                    var regionHtml = '<option value="all">All Regions</option>';
                    if (response.data.regions && response.data.regions.length > 0) {
                        response.data.regions.forEach(function(region) {
                            regionHtml += `<option value="${region}">${region}</option>`;
                        });
                    }
                    $('#filterRegion').html(regionHtml);

                    // Territories
                    var territoryHtml = '<option value="all">All Territories</option>';
                    if (response.data.territories && response.data.territories.length > 0) {
                        response.data.territories.forEach(function(territory) {
                            territoryHtml += `<option value="${territory}">${territory}</option>`;
                        });
                    }
                    $('#filterTerritory').html(territoryHtml);

                    // TMs
                    var tmHtml = '<option value="all">All TMs</option>';
                    if (response.data.tms && response.data.tms.length > 0) {
                        response.data.tms.forEach(function(tm) {
                            tmHtml += `<option value="${tm.id}">${tm.name}</option>`;
                        });
                    }
                    $('#filterTM').html(tmHtml);

                    // Sites
                    var siteHtml = '<option value="all">All Sites</option>';
                    if (response.data.sites && response.data.sites.length > 0) {
                        response.data.sites.forEach(function(site) {
                            siteHtml += `<option value="${site.id}">${site.name}</option>`;
                        });
                    }
                    $('#filterSite').html(siteHtml);

                    // Products
                    var productHtml = '<option value="all">All Products</option>';
                    if (response.data.products && response.data.products.length > 0) {
                        response.data.products.forEach(function(product) {
                            productHtml += `<option value="${product}">${product}</option>`;
                        });
                    }
                    $('#filterProduct').html(productHtml);

                    setTimeout(function() { initSelect2(); }, 100);
                }
            });
        }

        function getFilterParams() {
            var dateFrom = $('#filterDateFrom').val();
            var dateTo = $('#filterDateTo').val();

            // Set default dates if not set (current month)
            if (!dateFrom) {
                var today = new Date();
                var firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
                dateFrom = firstDay.toISOString().split('T')[0];
                $('#filterDateFrom').val(dateFrom);
            }
            if (!dateTo) {
                var today = new Date();
                dateTo = today.toISOString().split('T')[0];
                $('#filterDateTo').val(dateTo);
            }

            return {
                date_from: dateFrom,
                date_to: dateTo,
                region: $('#filterRegion').val() || 'all',
                territory: $('#filterTerritory').val() || 'all',
                tm: $('#filterTM').val() || 'all',
                site: $('#filterSite').val() || 'all',
                product: $('#filterProduct').val() || 'all'
            };
        }

        // ============================================
        // Render Functions
        // ============================================
        function renderKPICards(response) {
            if (response.success) {
                var data = response.data;
                var html = '';
                var kpis = [
                    { label: 'Total Sites', value: data.total_sites, icon: 'fa-building', color: 'blue', change: data.changes.coverage },
                    { label: 'Site Coverage', value: data.site_coverage + '%', icon: 'fa-crosshairs', color: 'emerald', change: data.changes.coverage },
                    { label: 'Total Recons', value: data.total_recons_all ? data.total_recons_all.toLocaleString() : '0', icon: 'fa-list-check', color: 'indigo', change: data.changes.recons },
                    { label: 'Completed Recon', value: data.recons_completed ? data.recons_completed.toLocaleString() : '0', icon: 'fa-check-circle', color: 'emerald', change: data.changes.recons },
                    { label: 'Pending Recon', value: data.recons_pending ? data.recons_pending.toLocaleString() : '0', icon: 'fa-clock', color: 'amber', change: 0 },
                    { label: 'Total Uplift (KL)', value: data.total_uplift || '0', icon: 'fa-arrow-trend-up', color: 'sky', change: data.changes.uplift },
                    { label: 'Total Dumping (KL)', value: data.total_dumping || '0', icon: 'fa-arrow-trend-down', color: 'amber', change: data.changes.dumping },
                    { label: 'Stock Loss (KL)', value: data.stock_loss ? data.stock_loss + ' KL' : '0 KL', icon: 'fa-circle-exclamation', color: 'red', change: data.changes.loss, isLoss: true },
                    { label: 'Avg Health Score', value: data.avg_health_score ? data.avg_health_score + '/100' : '0/100', icon: 'fa-heart-pulse', color: 'emerald', change: data.changes.health }
                ];

                $('#kpiCards').removeClass().addClass('grid grid-cols-9 gap-2');

                kpis.forEach(function(kpi, index) {
                    var changeClass = kpi.isLoss ? 'text-red-500' : 'text-emerald-500';
                    var changeIcon = kpi.isLoss ? 'fa-caret-down' : 'fa-caret-up';

                    html += `
                        <div class="panel-card p-2 flex flex-col justify-between relative overflow-hidden">
                            <div class="flex items-center space-x-1.5 mb-1 z-10">
                                <i class="fa-solid ${kpi.icon} text-${kpi.color}-500 bg-${kpi.color}-500/10 p-1.5 rounded-full text-xs"></i>
                                <div class="text-[9px] text-gray-400 uppercase tracking-wider font-semibold" style="color: var(--text-muted) !important;">${kpi.label}</div>
                            </div>
                            <div class="flex items-baseline justify-between z-10">
                                <span class="text-xl font-bold text-heading tracking-tight">${kpi.value}</span>
                                <div class="text-right">
                                    ${kpi.change !== undefined && kpi.change !== 0 ? `
                                        <span class="text-[10px] ${changeClass} font-semibold">
                                            <i class="fa-solid ${changeIcon}"></i> ${Math.abs(kpi.change)}%
                                        </span>
                                        <p class="text-[8px] text-gray-600 mt-0.5" style="color: var(--text-muted) !important;">vs Mar 2024</p>
                                    ` : `
                                        <span class="text-[10px] text-gray-500 font-semibold" style="color: var(--text-muted) !important;">
                                            <i class="fa-solid fa-minus"></i>
                                        </span>
                                        <p class="text-[8px] text-gray-600 mt-0.5" style="color: var(--text-muted) !important;">Pending Tasks</p>
                                    `}
                                </div>
                            </div>
                        </div>
                    `;
                });

                $('#kpiCards').html(html);
            }
        }

        function renderNetworkOverview(response) {
            if (response.success) {
                var data = response.data;
                var healthDist = data.health_distribution || { healthy: 0, warning: 0, critical: 0, not_visited: 0 };
                var totalSites = data.total_sites || 1;

                var score = data.avg_health_score || 0;
                $('#speedoValue').text(score);
                var status = getStatusText(score);
                $('#speedoStatus').text(status.text).removeClass('text-emerald-400 text-amber-400 text-red-400')
                    .addClass('text-' + status.color + '-400 bg-' + status.color + '-500/10 border border-' + status.color + '-500/20');

                if (speedoChart) {
                    speedoChart.updateSeries([score]);
                }

                var healthyPct = Math.round((healthDist.healthy / totalSites) * 100);
                var warningPct = Math.round((healthDist.warning / totalSites) * 100);
                var criticalPct = Math.round((healthDist.critical / totalSites) * 100);
                var notVisitedPct = Math.round((healthDist.not_visited / totalSites) * 100);

                var html = `
                    <div class="flex justify-between items-center">
                        <span class="text-gray-300" style="color: var(--text-body) !important;"><i class="fa-solid fa-circle text-[8px] text-emerald-500 mr-2 shadow-[0_0_8px_#10b981]"></i>Healthy Sites</span>
                        <span class="text-heading font-medium">${healthDist.healthy} <span class="text-emerald-500/70 text-[9px] ml-1">(${healthyPct}%)</span></span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-300" style="color: var(--text-body) !important;"><i class="fa-solid fa-circle text-[8px] text-amber-500 mr-2 shadow-[0_0_8px_#f59e0b]"></i>Warning Sites</span>
                        <span class="text-heading font-medium">${healthDist.warning} <span class="text-amber-500/70 text-[9px] ml-1">(${warningPct}%)</span></span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-300" style="color: var(--text-body) !important;"><i class="fa-solid fa-circle text-[8px] text-red-500 mr-2 shadow-[0_0_8px_#ef4444]"></i>Critical Sites</span>
                        <span class="text-heading font-medium">${healthDist.critical} <span class="text-red-500/70 text-[9px] ml-1">(${criticalPct}%)</span></span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-400" style="color: var(--text-muted) !important;"><i class="fa-solid fa-circle text-[8px] text-gray-600 mr-2"></i>Not Visited</span>
                        <span class="text-gray-400 font-medium" style="color: var(--text-muted) !important;">${healthDist.not_visited} <span class="text-gray-600 text-[9px] ml-1">(${notVisitedPct}%)</span></span>
                    </div>
                `;
                $('#healthDistribution').html(html);
            }
        }

        function renderAlerts(response) {
            if (!response.success) return;
            var html = '';
            var severityColors = { 'critical': 'red', 'warning': 'amber', 'orange': 'orange' };

            if (response.data && response.data.length > 0) {
                response.data.forEach(function(alert) {
                    var color = severityColors[alert.severity] || 'gray';
                    html += `
                        <div class="flex justify-between items-center bg-${color}-950/20 border border-${color}-900/40 p-2 rounded hover:bg-${color}-950/40 transition cursor-pointer" onclick="openModal('alertDetail', '${alert.id}')">
                            <div class="flex items-center space-x-2.5">
                                <div class="w-6 h-6 rounded bg-${color}-500/10 flex items-center justify-center">
                                    <i class="fa-solid ${alert.icon} text-${color}-500 text-[10px]"></i>
                                </div>
                                <div>
                                    <p class="text-heading font-medium text-[10px] leading-tight">${alert.title}</p>
                                    <p class="text-[8px] text-gray-500" style="color: var(--text-muted) !important;">${alert.description}</p>
                                </div>
                            </div>
                            <span class="text-${color}-500 font-bold text-sm">${alert.count} <i class="fa-solid fa-angle-right text-[10px] text-${color}-500/50 ml-1"></i></span>
                        </div>
                    `;
                });
            } else {
                html = '<div class="text-center text-gray-500 py-4" style="color: var(--text-muted) !important;">No alerts found</div>';
            }

            $('#alertsContainer').html(html);
        }

        function renderTrends(response) {
            if (!response.success) return;
            var data = response.data;
            if (trendChart && data.months && data.uplift && data.dumping) {
                trendChart.updateOptions({ xaxis: { categories: data.months } });
                trendChart.updateSeries([
                    { name: 'Uplift (KL)', data: data.uplift },
                    { name: 'Dumping (KL)', data: data.dumping }
                ]);
            }

            var gap = (data.total_uplift || 0) - (data.total_dumping || 0);
            var html = `
                <div>
                    <p class="text-gray-500 text-[9px] font-semibold uppercase" style="color: var(--text-muted) !important;">Total Uplift</p>
                    <p class="text-emerald-400 font-bold text-sm mt-0.5">${(data.total_uplift || 0).toFixed(1)}M KL</p>
                </div>
                <div>
                    <p class="text-gray-500 text-[9px] font-semibold uppercase" style="color: var(--text-muted) !important;">Total Dumping</p>
                    <p class="text-amber-400 font-bold text-sm mt-0.5">${(data.total_dumping || 0).toFixed(1)}M KL</p>
                </div>
                <div class="bg-red-950/20 border border-red-900/30 rounded py-0.5">
                    <p class="text-red-400 text-[9px] font-semibold uppercase">Uplift - Dumping Gap</p>
                    <p class="text-red-500 font-bold text-sm mt-0.5">${gap.toFixed(1)} KL</p>
                </div>
            `;
            $('#trendTotals').html(html);
        }

        function renderVariance(response) {
            if (!response.success) return;
            var data = response.data;

            if (varianceChart && data.distribution && data.distribution.length === 4) {
                varianceChart.updateSeries(data.distribution);
            }

            var statsHtml = `
                <div>
                    <p class="text-[9px] text-gray-400 uppercase font-medium" style="color: var(--text-muted) !important;">Total Stock Loss</p>
                    <p class="text-red-500 font-bold text-sm mt-0.5">${data.total_stock_loss || 0} KL</p>
                </div>
                <div>
                    <p class="text-[9px] text-gray-400 uppercase font-medium" style="color: var(--text-muted) !important;">Variance Sites</p>
                    <p class="text-amber-500 font-bold text-sm mt-0.5">${data.variance_sites || 0}</p>
                </div>
                <div>
                    <p class="text-[9px] text-gray-400 uppercase font-medium" style="color: var(--text-muted) !important;">Critical Sites</p>
                    <p class="text-red-500 font-bold text-sm mt-0.5">${data.critical_sites || 0}</p>
                </div>
            `;
            $('#varianceStats').html(statsHtml);

            var sitesHtml = '';
            if (data.top_sites && data.top_sites.length > 0) {
                data.top_sites.forEach(function(site) {
                    var color = site.variance > 4 ? 'red' : (site.variance > 3 ? 'orange' : 'gray');
                    sitesHtml += `
                        <tr>
                            <td class="py-1 text-${color}-400 font-medium">${site.site}</td>
                            <td class="text-center text-${color}-400">${site.variance.toFixed(2)}%</td>
                            <td class="text-right text-${color}-400">${site.stock_loss.toFixed(1)}</td>
                        </tr>
                    `;
                });
            } else {
                sitesHtml = `<tr><td colspan="3" class="py-2 text-center text-gray-500" style="color: var(--text-muted) !important;">No variance data available</td></tr>`;
            }
            $('#varianceTopSites').html(sitesHtml);
        }

        function renderReconEfficiency(response) {
            if (!response.success) return;
            var data = response.data;

            var statsHtml = `
                <div>
                    <p class="text-gray-400 text-[8px] uppercase font-medium" style="color: var(--text-muted) !important;">Avg Cycle Duration</p>
                    <p class="text-emerald-400 font-bold text-sm mt-0.5">${data.avg_duration || 0} Days</p>
                </div>
                <div>
                    <p class="text-gray-400 text-[8px] uppercase font-medium" style="color: var(--text-muted) !important;">Overdue Recons</p>
                    <p class="text-red-500 font-bold text-sm mt-0.5">${data.overdue || 0}</p>
                </div>
                <div>
                    <p class="text-gray-400 text-[8px] uppercase font-medium" style="color: var(--text-muted) !important;">Completion Rate</p>
                    <p class="text-emerald-400 font-bold text-sm mt-0.5">${data.completion_rate || 0}%</p>
                </div>
                <div>
                    <p class="text-gray-400 text-[8px] uppercase font-medium" style="color: var(--text-muted) !important;">Same Day Completion</p>
                    <p class="text-emerald-400 font-bold text-sm mt-0.5">${data.same_day_completion || 0}%</p>
                </div>
            `;
            $('#reconStats').html(statsHtml);

            var pipeline = data.pipeline || { initiated: 0, under_review: 0, rm_approved: 0, completed: 0 };
            var maxPipeline = Math.max(pipeline.initiated, pipeline.under_review, pipeline.rm_approved, pipeline.completed, 1);

            var barHtml = `
                <div class="bg-[#2563eb] h-[18px] w-[${Math.round((pipeline.initiated / maxPipeline) * 100)}%]" style="clip-path: polygon(0 0, 100% 0, 85% 100%, 15% 100%);"></div>
                <div class="bg-[#0ea5e9] h-[18px] w-[${Math.round((pipeline.under_review / maxPipeline) * 100)}%]" style="clip-path: polygon(0 0, 100% 0, 80% 100%, 20% 100%); margin-top: 2px;"></div>
                <div class="bg-[#eab308] h-[18px] w-[${Math.round((pipeline.rm_approved / maxPipeline) * 100)}%]" style="clip-path: polygon(0 0, 100% 0, 80% 100%, 20% 100%); margin-top: 2px;"></div>
                <div class="bg-[#22c55e] h-[18px] w-[${Math.round((pipeline.completed / maxPipeline) * 100)}%]" style="clip-path: polygon(0 0, 100% 0, 80% 100%, 20% 100%); margin-top: 2px;"></div>
            `;
            $('#pipelineBars').html(barHtml);

            var labelHtml = `
                <div class="flex justify-between text-gray-300" style="color: var(--text-body) !important;"><span>Initiated</span> <span class="text-blue-400 font-bold">${pipeline.initiated.toLocaleString()}</span></div>
                <div class="flex justify-between text-gray-300" style="color: var(--text-body) !important;"><span>Under Review</span> <span class="text-sky-400 font-bold">${pipeline.under_review.toLocaleString()}</span></div>
                <div class="flex justify-between text-gray-300" style="color: var(--text-body) !important;"><span>RM Approved</span> <span class="text-amber-400 font-bold">${pipeline.rm_approved.toLocaleString()}</span></div>
                <div class="flex justify-between text-gray-300" style="color: var(--text-body) !important;"><span>Completed</span> <span class="text-emerald-400 font-bold">${pipeline.completed.toLocaleString()}</span></div>
            `;
            $('#pipelineLabels').html(labelHtml);

            if (backlogChart && data.backlog_trend && data.backlog_trend.length === 4) {
                backlogChart.updateSeries([{ name: 'Backlog Trend', data: data.backlog_trend }]);
                backlogChart.updateOptions({
                    xaxis: { categories: ['Jan 24', 'Feb 24', 'Mar 24', 'Apr 24'] }
                });
            }
        }

        function renderTMPerformance(response) {
            if (!response.success) return;
            var html = '';
            var scoreColors = ['emerald', 'emerald', 'amber', 'orange', 'red'];

            if (response.data && response.data.length > 0) {
                response.data.forEach(function(tm, index) {
                    var color = scoreColors[index] || 'gray';
                    var barColor = color + (index < 2 ? '-500' : '-400');
                    html += `
                        <tr>
                            <td class="py-1.5 font-bold text-gray-500" style="color: var(--text-muted) !important;">${tm.rank}</td>
                            <td class="font-medium text-heading">${tm.name}</td>
                            <td class="text-center">${tm.coverage}%</td>
                            <td class="text-center">${tm.recons}</td>
                            <td class="text-center">${tm.variance_caught}</td>
                            <td class="text-right">
                                <div class="w-12 ml-auto bg-slate-800 h-1.5 rounded-full overflow-hidden" style="background-color: var(--input-bg) !important;">
                                    <div class="bg-${barColor} h-full w-[${tm.score}%]"></div>
                                </div>
                            </td>
                        </tr>
                    `;
                });
            } else {
                html = '<tr><td colspan="6" class="py-2 text-center text-gray-500" style="color: var(--text-muted) !important;">No TM data available</td></tr>';
            }

            $('#tmLeaderboard').html(html);
        }

        function renderHealthDistribution(response) {
            if (!response.success) return;
            var data = response.data;
            var healthDist = data.health_distribution || { healthy: 0, warning: 0, critical: 0, not_visited: 0 };

            if (healthChart) {
                var series = [healthDist.healthy || 0, healthDist.warning || 0, healthDist.critical || 0, healthDist.not_visited || 0];
                healthChart.updateSeries(series);
                healthChart.updateOptions({
                    plotOptions: {
                        pie: {
                            donut: {
                                labels: {
                                    value: { formatter: function() { return data.total_sites || 0; } }
                                }
                            }
                        }
                    }
                });
            }
        }

        function renderTopSites(response) {
            if (!response.success) return;

            var bestHtml = '';
            if (response.data.best_sites && response.data.best_sites.length > 0) {
                response.data.best_sites.forEach(function(site) {
                    bestHtml += `
                        <tr>
                            <td class="py-1.5 text-emerald-400 font-medium">${site.site}</td>
                            <td class="text-center text-heading font-semibold">${site.health_score}</td>
                            <td class="text-center text-emerald-400">${site.variance}%</td>
                            <td class="text-right text-emerald-400">${site.regularity}</td>
                        </tr>
                    `;
                });
            } else {
                bestHtml = '<tr><td colspan="4" class="py-2 text-center text-gray-500" style="color: var(--text-muted) !important;">No data available</td></tr>';
            }
            $('#bestSitesBody').html(bestHtml);

            var riskyHtml = '';
            if (response.data.risky_sites && response.data.risky_sites.length > 0) {
                response.data.risky_sites.forEach(function(site) {
                    var color = site.health_score < 30 ? 'red' : (site.health_score < 50 ? 'orange' : 'gray');
                    riskyHtml += `
                        <tr>
                            <td class="py-1.5 text-${color}-400 font-medium">${site.site}</td>
                            <td class="text-center text-${color}-500 font-semibold">${site.health_score}</td>
                            <td class="text-center text-${color}-500">${site.variance}%</td>
                            <td class="text-right text-${color}-500">${site.last_visit}</td>
                        </tr>
                    `;
                });
            } else {
                riskyHtml = '<tr><td colspan="4" class="py-2 text-center text-gray-500" style="color: var(--text-muted) !important;">No data available</td></tr>';
            }
            $('#riskySitesBody').html(riskyHtml);
        }

        function renderAIInsights(response) {
            if (!response.success) return;
            var data = response.data;
            var healthDist = data.health_distribution || { healthy: 0, warning: 0, critical: 0, not_visited: 0 };
            var totalSites = data.total_sites || 1;
            var healthyPct = Math.round((healthDist.healthy / totalSites) * 100);

            var html = `
                <div>
                    <span class="text-blue-400 font-semibold flex items-center mb-0.5"><i class="fa-solid fa-arrow-trend-up mr-1.5"></i> Coverage improved by ${data.changes?.coverage || 0}%</span>
                    <p class="text-gray-500 text-[9px] leading-snug" style="color: var(--text-muted) !important;">Total site coverage increased to ${data.site_coverage}% compared to last month.</p>
                </div>
                <div>
                    <span class="text-amber-400 font-semibold flex items-center mb-0.5"><i class="fa-solid fa-triangle-exclamation mr-1.5"></i> ${healthDist.critical} sites need attention</span>
                    <p class="text-gray-500 text-[9px] leading-snug" style="color: var(--text-muted) !important;">${healthDist.critical} sites have variance more than 5% requiring immediate action.</p>
                </div>
                <div>
                    <span class="text-emerald-400 font-semibold flex items-center mb-0.5"><i class="fa-solid fa-arrow-down mr-1.5"></i> Stock losses monitored</span>
                    <p class="text-gray-500 text-[9px] leading-snug" style="color: var(--text-muted) !important;">Current stock loss is ${data.stock_loss} KL. ${data.changes?.loss < 0 ? 'Reduced by ' + Math.abs(data.changes.loss) + '%' : 'Increased by ' + data.changes?.loss + '%'} compared to last month.</p>
                </div>
                <div>
                    <span class="text-emerald-400 font-semibold flex items-center mb-0.5"><i class="fa-solid fa-check-circle mr-1.5"></i> ${healthyPct}% sites healthy</span>
                    <p class="text-gray-500 text-[9px] leading-snug" style="color: var(--text-muted) !important;">${healthDist.healthy} sites are performing well with variance less than 1%.</p>
                </div>
                <div>
                    <span class="text-emerald-400 font-semibold flex items-center mb-0.5"><i class="fa-solid fa-trophy mr-1.5 text-yellow-400"></i> ${data.recons_completed?.toLocaleString() || 0} recons completed</span>
                    <p class="text-gray-500 text-[9px] leading-snug" style="color: var(--text-muted) !important;">Total recons completed showing ${data.changes?.recons > 0 ? 'increase of ' + data.changes.recons + '%' : 'decrease of ' + Math.abs(data.changes?.recons || 0) + '%'} from last month.</p>
                </div>
            `;
            $('#aiInsightsContent').html(html);
        }

        // ============================================
        // Load Functions (Using Cache - FAST!)
        // ============================================
        function loadKPIData() {
            if (loadingFlags.kpi) return;
            loadingFlags.kpi = true;
            loadFromCache('dashboard_data', function(response) {
                loadingFlags.kpi = false;
                if (response && response.success) {
                    renderKPICards(response);
                } else {
                    callDirectAPI('dashboard_data', function(res) {
                        if (res && res.success) renderKPICards(res);
                    }, getFilterParams());
                }
            }, getFilterParams());
        }

        function loadNetworkOverview() {
            if (loadingFlags.network) return;
            loadingFlags.network = true;
            loadFromCache('dashboard_data', function(response) {
                loadingFlags.network = false;
                if (response && response.success) {
                    renderNetworkOverview(response);
                } else {
                    callDirectAPI('dashboard_data', function(res) {
                        if (res && res.success) renderNetworkOverview(res);
                    }, getFilterParams());
                }
            }, getFilterParams());
        }

        function loadHealthDistribution() {
            if (loadingFlags.health) return;
            loadingFlags.health = true;
            loadFromCache('dashboard_data', function(response) {
                loadingFlags.health = false;
                if (response && response.success) {
                    renderHealthDistribution(response);
                } else {
                    callDirectAPI('dashboard_data', function(res) {
                        if (res && res.success) renderHealthDistribution(res);
                    }, getFilterParams());
                }
            }, getFilterParams());
        }

        function loadAIInsights() {
            if (loadingFlags.ai) return;
            loadingFlags.ai = true;
            loadFromCache('dashboard_data', function(response) {
                loadingFlags.ai = false;
                if (response && response.success) {
                    renderAIInsights(response);
                } else {
                    callDirectAPI('dashboard_data', function(res) {
                        if (res && res.success) renderAIInsights(res);
                    }, getFilterParams());
                }
            }, getFilterParams());
        }

        function loadMapData() {
            if (loadingFlags.map) return;
            loadingFlags.map = true;
            loadFromCache('map_data', function(response) {
                loadingFlags.map = false;
                if (response && response.success && response.data && response.data.length > 0) {
                    clearMapMarkers();
                    response.data.forEach(function(site) {
                        addMapMarker(site);
                    });
                }
            }, getFilterParams());
        }

        function loadAlerts() {
            if (loadingFlags.alerts) return;
            loadingFlags.alerts = true;
            loadFromCache('alerts_data', function(response) {
                loadingFlags.alerts = false;
                if (response && response.success) {
                    renderAlerts(response);
                } else {
                    callDirectAPI('alerts_data', function(res) {
                        if (res && res.success) renderAlerts(res);
                    }, getFilterParams());
                }
            }, getFilterParams());
        }

        function loadTrends() {
            if (loadingFlags.trends) return;
            loadingFlags.trends = true;
            loadFromCache('trends_data', function(response) {
                loadingFlags.trends = false;
                if (response && response.success) {
                    renderTrends(response);
                } else {
                    callDirectAPI('trends_data', function(res) {
                        if (res && res.success) renderTrends(res);
                    }, getFilterParams());
                }
            }, getFilterParams());
        }

        function loadVariance() {
            if (loadingFlags.variance) return;
            loadingFlags.variance = true;
            loadFromCache('variance_data', function(response) {
                loadingFlags.variance = false;
                if (response && response.success) {
                    renderVariance(response);
                } else {
                    callDirectAPI('variance_data', function(res) {
                        if (res && res.success) renderVariance(res);
                    }, getFilterParams());
                }
            }, getFilterParams());
        }

        function loadReconEfficiency() {
            if (loadingFlags.recon) return;
            loadingFlags.recon = true;
            loadFromCache('recon_efficiency', function(response) {
                loadingFlags.recon = false;
                if (response && response.success) {
                    renderReconEfficiency(response);
                } else {
                    callDirectAPI('recon_efficiency', function(res) {
                        if (res && res.success) renderReconEfficiency(res);
                    }, getFilterParams());
                }
            }, getFilterParams());
        }

        function loadTMPerformance() {
            if (loadingFlags.tm) return;
            loadingFlags.tm = true;
            loadFromCache('tm_performance', function(response) {
                loadingFlags.tm = false;
                if (response && response.success) {
                    renderTMPerformance(response);
                } else {
                    callDirectAPI('tm_performance', function(res) {
                        if (res && res.success) renderTMPerformance(res);
                    }, getFilterParams());
                }
            }, getFilterParams());
        }

        function loadTopSites() {
            if (loadingFlags.topsites) return;
            loadingFlags.topsites = true;
            loadFromCache('top_sites', function(response) {
                loadingFlags.topsites = false;
                if (response && response.success) {
                    renderTopSites(response);
                } else {
                    callDirectAPI('top_sites', function(res) {
                        if (res && res.success) renderTopSites(res);
                    }, getFilterParams());
                }
            }, getFilterParams());
        }

        function loadDashboard() {
            if (isLoading) return;
            isLoading = true;

            // Load all data simultaneously - FAST!
            loadKPIData();
            loadNetworkOverview();
            loadMapData();
            loadAlerts();
            loadTrends();
            loadVariance();
            loadReconEfficiency();
            loadTMPerformance();
            loadHealthDistribution();
            loadTopSites();
            loadAIInsights();
            updateTimestamp();

            setTimeout(function() {
                isLoading = false;
            }, 1000);
        }

        function updateTimestamp() {
            var now = new Date();
            var dateStr = now.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });
            var timeStr = now.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: true });
            $('#dataTimestamp').text(dateStr + ' ' + timeStr);
            $('#lastSyncTime').text('Last Sync: ' + dateStr + ' ' + timeStr);
        }

        // ============================================
        // Modal Functions
        // ============================================
        function openModal(type, id) {
            var modal = $('#globalModal');
            var title = $('#modalTitle');
            var body = $('#modalBody');

            modal.removeClass('hidden').addClass('flex');
            setTimeout(function() {
                modal.removeClass('opacity-0');
                $('#modalContentWrapper').removeClass('scale-95').addClass('scale-100');
            }, 10);

            if (type === 'siteHealth') {
                title.text('Site Health Analysis');
                body.html('<div class="flex items-center justify-center h-32"><i class="fa-solid fa-spinner fa-spin text-2xl text-blue-400"></i><span class="ml-3">Loading site health data...</span></div>');
                loadSiteHealthModal(body);
            } else if (type === 'alertDetail') {
                title.text('Alert Details');
                body.html('<div class="flex items-center justify-center h-32"><i class="fa-solid fa-spinner fa-spin text-2xl text-blue-400"></i><span class="ml-3">Loading alert details...</span></div>');
                loadAlertDetailModal(body, id);
            }
        }

        function closeModal() {
            var modal = $('#globalModal');
            modal.addClass('opacity-0');
            $('#modalContentWrapper').removeClass('scale-100').addClass('scale-95');
            setTimeout(function() {
                modal.addClass('hidden').removeClass('flex');
            }, 300);
        }

        function loadSiteHealthModal(body) {
            loadFromCache('site_details', function(response) {
                if (response.success) {
                    var data = response.data;
                    var html = `
                        <div class="grid grid-cols-3 gap-4 mb-6">
                            <div class="panel-card p-4 text-center">
                                <p class="text-gray-400 text-sm" style="color: var(--text-muted) !important;">Total Sites</p>
                                <p class="text-heading text-2xl font-bold">${data.total_sites || 0}</p>
                            </div>
                            <div class="panel-card p-4 text-center">
                                <p class="text-gray-400 text-sm" style="color: var(--text-muted) !important;">Visited Sites</p>
                                <p class="text-heading text-2xl font-bold">${data.visited_sites || 0}</p>
                            </div>
                            <div class="panel-card p-4 text-center">
                                <p class="text-gray-400 text-sm" style="color: var(--text-muted) !important;">Avg Health Score</p>
                                <p class="text-emerald-400 text-2xl font-bold">${data.avg_health_score || 0}/100</p>
                            </div>
                        </div>
                        <div class="panel-card p-4 mb-6">
                            <h3 class="text-heading font-semibold mb-3">Health Distribution</h3>
                            <div class="grid grid-cols-4 gap-4">
                                ${data.health_distribution && data.health_distribution.length > 0 ?
                                    data.health_distribution.map(function(item) {
                                        var colors = { 'Excellent': 'emerald', 'Good': 'blue', 'Warning': 'amber', 'Critical': 'red' };
                                        var color = colors[item.status] || 'gray';
                                        return `
                                            <div class="text-center">
                                                <div class="text-${color}-400 font-bold text-lg">${item.count}</div>
                                                <div class="text-gray-400 text-sm" style="color: var(--text-muted) !important;">${item.status}</div>
                                            </div>
                                        `;
                                    }).join('') : '<div class="col-span-4 text-center text-gray-500" style="color: var(--text-muted) !important;">No data available</div>'}
                            </div>
                        </div>
                        <div class="panel-card p-4">
                            <h3 class="text-heading font-semibold mb-3">Recent Visits</h3>
                            <div class="overflow-x-auto">
                                <table class="w-full text-left text-sm">
                                    <thead class="text-gray-400 border-b" style="border-color: var(--border-color) !important; color: var(--text-muted) !important;">
                                        <tr>
                                            <th class="pb-2">Site</th>
                                            <th class="pb-2">TM</th>
                                            <th class="pb-2">Date</th>
                                            <th class="pb-2 text-right">Variance</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-gray-300 divide-y divide-[#1a2635]/30" style="color: var(--text-body) !important;">
                                        ${data.recent_visits && data.recent_visits.length > 0 ?
                                            data.recent_visits.map(function(visit) {
                                                var color = Math.abs(visit.variance) > 2 ? 'text-red-400' : 'text-emerald-400';
                                                return `
                                                    <tr>
                                                        <td class="py-2">${visit.site}</td>
                                                        <td class="py-2">${visit.tm}</td>
                                                        <td class="py-2">${visit.date}</td>
                                                        <td class="py-2 text-right ${color}">${visit.variance}%</td>
                                                    </tr>
                                                `;
                                            }).join('') : '<tr><td colspan="4" class="py-2 text-center text-gray-500" style="color: var(--text-muted) !important;">No recent visits</td></tr>'}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    `;
                    body.html(html);
                } else {
                    body.html('<div class="text-center text-red-400 py-8">Failed to load site health data</div>');
                }
            }, getFilterParams());
        }

        function loadAlertDetailModal(body, alertId) {
            loadFromCache('alerts_data', function(response) {
                if (response.success) {
                    var alert = response.data.find(function(a) { return a.id === alertId; });
                    if (alert) {
                        var html = `
                            <div class="panel-card p-4">
                                <div class="flex items-center space-x-3 mb-4">
                                    <div class="w-10 h-10 rounded-full bg-${alert.severity}-500/20 flex items-center justify-center">
                                        <i class="fa-solid ${alert.icon} text-${alert.severity}-500 text-lg"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-heading font-semibold text-base">${alert.title}</h4>
                                        <p class="text-gray-400 text-sm" style="color: var(--text-muted) !important;">${alert.description}</p>
                                    </div>
                                </div>
                                <div class="bg-[#060b13] p-3 rounded" style="background-color: var(--input-bg) !important;">
                                    <p class="text-gray-300" style="color: var(--text-body) !important;"><strong class="text-heading">Total Count:</strong> ${alert.count}</p>
                                    <p class="text-gray-300 mt-2" style="color: var(--text-body) !important;"><strong class="text-heading">Severity:</strong> <span class="text-${alert.severity}-400 uppercase">${alert.severity}</span></p>
                                </div>
                            </div>
                        `;
                        body.html(html);
                    } else {
                        body.html('<div class="text-center text-gray-400 py-8" style="color: var(--text-muted) !important;">Alert not found</div>');
                    }
                }
            }, getFilterParams());
        }

        // ============================================
        // Initialize Everything
        // ============================================
        $(document).ready(function() {
            // Initialize map
            initMap();

            // Initialize charts
            initCharts();

            // Set default date range (current month)
            var today = new Date();
            var firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
            var dateFrom = firstDay.toISOString().split('T')[0];
            var dateTo = today.toISOString().split('T')[0];
            $('#filterDateFrom').val(dateFrom);
            $('#filterDateTo').val(dateTo);

            // Load filter options
            loadFilterOptions();

            // Load all data after filters are ready
            setTimeout(function() {
                loadDashboard();
            }, 500);

            // Filter change events
            $(document).on('change', '#filterDateFrom, #filterDateTo', function() {
                loadDashboard();
            });

            $(document).on('change', '#filterRegion, #filterTerritory, #filterTM, #filterSite, #filterProduct', function() {
                loadDashboard();
            });

            // Refresh button
            $('#refreshBtn').on('click', function(e) {
                e.preventDefault();
                var icon = $(this).find('i');
                var btnText = $(this).find('span');
                icon.addClass('fa-spin');
                btnText.text('Updating...');

                // Get current filters
                var params = getFilterParams();

                // Force refresh cache with current filters
                $.ajax({
                    url: 'api/cache_manager.php',
                    type: 'GET',
                    data: {
                        action: 'update_all',
                        date_from: params.date_from,
                        date_to: params.date_to,
                        region: params.region,
                        territory: params.territory,
                        tm: params.tm,
                        site: params.site,
                        product: params.product
                    },
                    dataType: 'json',
                    success: function(response) {
                        console.log('Cache updated:', response);
                        loadDashboard();
                        setTimeout(function() {
                            icon.removeClass('fa-spin');
                            btnText.text('Refresh');
                        }, 500);
                    },
                    error: function() {
                        loadDashboard();
                        setTimeout(function() {
                            icon.removeClass('fa-spin');
                            btnText.text('Refresh');
                        }, 500);
                    }
                });
            });
        });
    </script>
</body>

</html>