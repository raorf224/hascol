<?php
// Hascol OMC - Task Calendar Management (Standalone)
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Task Calendar | Hascol OMC</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta content="Hascol OMC Management Dashboard" name="description" />

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

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
            --event-pending: #f59e0b;
            --event-inprogress: #3b82f6;
            --event-completed: #10b981;
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.08);
            --shadow-md: 0 4px 20px rgba(0, 0, 0, 0.10);
            --shadow-lg: 0 8px 40px rgba(0, 0, 0, 0.15);
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
            --event-pending: #f59e0b;
            --event-inprogress: #3b82f6;
            --event-completed: #10b981;
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.3);
            --shadow-md: 0 4px 20px rgba(0, 0, 0, 0.4);
            --shadow-lg: 0 8px 40px rgba(0, 0, 0, 0.5);
        }

        body {
            background-color: var(--bg-body);
            color: var(--text-muted);
            font-family: 'Inter', sans-serif;
            transition: background-color .25s ease, color .25s ease;
            min-height: 100vh;
        }

        .text-heading {
            color: var(--text-heading) !important;
        }

        .panel-card {
            background-color: var(--bg-panel);
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            transition: background-color .25s ease, border-color .25s ease;
            box-shadow: var(--shadow-sm);
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

        .btn-primary {
            background: linear-gradient(135deg, #1d4ed8, #2563eb);
            color: #ffffff;
            padding: 8px 20px;
            border-radius: 0.375rem;
            border: none;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 2px 8px rgba(29, 78, 216, 0.25);
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 16px rgba(29, 78, 216, 0.35);
        }

        .btn-secondary {
            background-color: var(--btn-secondary-bg);
            color: var(--btn-secondary-text);
            padding: 8px 20px;
            border-radius: 0.375rem;
            border: 1px solid var(--border-color);
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-secondary:hover {
            background-color: var(--btn-secondary-hover-bg);
            color: var(--btn-secondary-hover-text);
        }

        .btn-warning {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: #ffffff;
            padding: 6px 16px;
            border-radius: 0.375rem;
            border: none;
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-warning:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
        }

        .btn-warning.active {
            background: linear-gradient(135deg, #b45309, #92400e);
            box-shadow: 0 0 0 2px rgba(245, 158, 11, 0.3);
        }

        .btn-default {
            background-color: var(--btn-secondary-bg);
            color: var(--btn-secondary-text);
            padding: 6px 16px;
            border-radius: 0.375rem;
            border: 1px solid var(--border-color);
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-default:hover {
            background-color: var(--btn-secondary-hover-bg);
            color: var(--btn-secondary-hover-text);
        }

        .btn-group {
            display: inline-flex;
            gap: 4px;
            flex-wrap: wrap;
        }

        .btn-group .btn {
            border-radius: 0.375rem !important;
        }

        .calendar-wrapper {
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 20px;
        }

        .calendar-container {
            background-color: var(--bg-panel);
            border-radius: 0.5rem;
            padding: 24px;
            min-height: 500px;
            border: 1px solid var(--border-color);
        }

        .calendar-container .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 12px;
        }

        .calendar-container .calendar-header h3 {
            color: var(--text-heading);
            font-size: 20px;
            font-weight: 700;
            margin: 0;
            letter-spacing: -0.3px;
        }

        .calendar-container .calendar-header .calendar-nav {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .calendar-container table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 2px;
        }

        .calendar-container table thead th {
            color: var(--text-muted);
            font-weight: 600;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 10px 4px;
            text-align: center;
        }

        .calendar-container table tbody td {
            padding: 4px;
            text-align: center;
            vertical-align: top;
            border-radius: 0.5rem;
            background-color: var(--bg-body);
            transition: all 0.2s ease;
            cursor: pointer;
            height: 80px;
            position: relative;
            border: 2px solid transparent;
        }

        .calendar-container table tbody td:hover {
            transform: scale(1.02);
            z-index: 2;
        }

        .calendar-container table tbody td.has-events {
            cursor: pointer;
        }

        .calendar-container table tbody td.has-events:hover {
            border-color: #1d4ed8;
        }

        .calendar-container table tbody td.selected-date {
            border-color: #1d4ed8;
            background-color: rgba(29, 78, 216, 0.08);
            box-shadow: 0 0 0 2px rgba(29, 78, 216, 0.15);
        }

        .calendar-container table tbody td .day-number {
            font-size: 13px;
            font-weight: 500;
            color: var(--text-body);
            display: block;
            text-align: right;
            padding: 4px 8px 0 0;
        }

        .calendar-container table tbody td .day-number.other-month {
            color: var(--text-muted);
            opacity: 0.4;
        }

        .calendar-container table tbody td .day-number {
            font-size: 13px;
            font-weight: 500;
            color: var(--text-body);
            display: block;
            text-align: center;
            padding: 4px 0 0 0;
        }

        .calendar-container table tbody td .day-number.today {
            background: linear-gradient(135deg, #1d4ed8, #2563eb);
            color: #ffffff;
            border-radius: 50%;
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 2px auto 0 auto;
            padding: 0;
            font-weight: 600;
            font-size: 13px;
            box-sizing: border-box;
            box-shadow: 0 2px 8px rgba(29, 78, 216, 0.3);
        }

        .calendar-event-dot {
            display: inline-block;
            width: 6px;
            height: 6px;
            border-radius: 50%;
            margin: 1px;
        }

        .calendar-event-dot.pending {
            background-color: var(--event-pending);
        }

        .calendar-event-dot.inprogress {
            background-color: var(--event-inprogress);
        }

        .calendar-event-dot.completed {
            background-color: var(--event-completed);
        }

        .calendar-events-preview {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 2px;
            padding: 2px 4px;
        }

        .details-panel {
            background-color: var(--bg-panel);
            border-radius: 0.5rem;
            padding: 24px;
            border: 1px solid var(--border-color);
            min-height: 500px;
            max-height: 600px;
            overflow-y: auto;
        }

        .details-panel .panel-title {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-heading);
            margin-bottom: 16px;
            padding-bottom: 12px;
            border-bottom: 2px solid var(--border-color);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .details-panel .panel-title .date-badge {
            font-size: 12px;
            font-weight: 400;
            color: var(--text-muted);
            background: var(--bg-body);
            padding: 2px 12px;
            border-radius: 20px;
        }

        .details-panel .no-events {
            text-align: center;
            padding: 40px 20px;
            color: var(--text-muted);
        }

        .details-panel .no-events i {
            font-size: 40px;
            margin-bottom: 12px;
            opacity: 0.3;
        }

        .details-panel .no-events p {
            font-size: 14px;
        }

        .inspection-card {
            background: var(--bg-body);
            border-radius: 0.5rem;
            padding: 14px 16px;
            margin-bottom: 10px;
            border-left: 4px solid var(--border-color);
            transition: all 0.2s ease;
        }

        .inspection-card:hover {
            transform: translateX(4px);
        }

        .inspection-card.status-pending {
            border-left-color: var(--event-pending);
        }

        .inspection-card.status-inprogress {
            border-left-color: var(--event-inprogress);
        }

        .inspection-card.status-completed {
            border-left-color: var(--event-completed);
        }

        .inspection-card .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 6px;
            flex-wrap: wrap;
            gap: 6px;
        }

        .inspection-card .card-header .dealer-name {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-heading);
        }

        .inspection-card .card-header .status-badge {
            font-size: 10px;
            font-weight: 600;
            padding: 3px 12px;
            border-radius: 20px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .status-badge.pending {
            background: rgba(245, 158, 11, 0.15);
            color: var(--event-pending);
        }

        .status-badge.inprogress {
            background: rgba(59, 130, 246, 0.15);
            color: var(--event-inprogress);
        }

        .status-badge.completed {
            background: rgba(16, 185, 129, 0.15);
            color: var(--event-completed);
        }

        .inspection-card .card-body {
            font-size: 12px;
            color: var(--text-muted);
        }

        .inspection-card .card-body .info-row {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
        }

        .inspection-card .card-body .info-row .label {
            font-weight: 500;
            color: var(--text-muted);
        }

        .inspection-card .card-body .info-row .value {
            color: var(--text-body);
        }

        .inspection-card .card-body .response-text {
            margin-top: 6px;
            padding-top: 6px;
            border-top: 1px dashed var(--border-color);
            font-size: 12px;
            color: var(--text-body);
            font-style: italic;
        }

        .details-panel::-webkit-scrollbar {
            width: 4px;
        }

        .details-panel::-webkit-scrollbar-track {
            background: var(--scrollbar-track);
            border-radius: 4px;
        }

        .details-panel::-webkit-scrollbar-thumb {
            background: var(--scrollbar-thumb);
            border-radius: 4px;
        }

        .calendar-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
            flex-wrap: wrap;
            gap: 10px;
            padding-top: 16px;
            border-top: 1px solid var(--border-color);
        }

        .calendar-footer .legend {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
        }

        .calendar-footer .legend-item {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 11px;
            color: var(--text-muted);
        }

        .calendar-footer .legend-item .dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            display: inline-block;
        }

        .dot-pending {
            background-color: var(--event-pending);
        }

        .dot-inprogress {
            background-color: var(--event-inprogress);
        }

        .dot-completed {
            background-color: var(--event-completed);
        }

        @media (max-width: 1024px) {
            .calendar-wrapper {
                grid-template-columns: 1fr;
            }

            .details-panel {
                min-height: 200px;
                max-height: 400px;
            }
        }

        @media (max-width: 768px) {
            .calendar-container table tbody td {
                height: 60px;
                font-size: 11px;
            }

            .calendar-container .calendar-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .calendar-container .calendar-header .calendar-nav {
                width: 100%;
            }

            .btn-group {
                width: 100%;
            }

            .btn-group .btn {
                flex: 1;
                text-align: center;
                font-size: 11px;
                padding: 4px 10px;
            }

            .details-panel {
                min-height: 150px;
                max-height: 350px;
            }
        }

        @media (max-width: 480px) {
            .calendar-container table tbody td {
                height: 50px;
                font-size: 10px;
                padding: 2px;
            }

            .calendar-container table tbody td .day-number {
                font-size: 11px;
            }

            .calendar-container .calendar-header h3 {
                font-size: 16px;
            }

            .btn {
                font-size: 10px !important;
                padding: 4px 8px !important;
            }

            .inspection-card .card-header .dealer-name {
                font-size: 12px;
            }

            .inspection-card .card-body {
                font-size: 11px;
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

        ::-webkit-scrollbar-thumb:hover {
            background: var(--scrollbar-thumb);
        }
    </style>
</head>

<body class="flex h-screen overflow-hidden text-sm">

    <?php include 'includes/sidebar.php'; ?>

    <main id="mainContent" class="flex-1 flex flex-col overflow-hidden">

        <?php include 'includes/topbar.php'; ?>

        <div class="flex-1 overflow-y-auto p-4 md:p-6" id="pageContent">

            <div class="flex flex-wrap justify-between items-center mb-4 gap-3">
                <div>
                    <h2 class="text-heading font-semibold text-lg tracking-wide uppercase">
                        <i class="fa-solid fa-calendar-days mr-2 text-blue-500"></i>Task Calendar
                    </h2>
                    <p class="text-xs text-gray-500 mt-0.5">View and manage inspection tasks in calendar view</p>
                </div>
                <button onclick="location.reload()" class="btn-primary">
                    <i class="fa-solid fa-rotate"></i> Refresh
                </button>
            </div>

            <div class="panel-card overflow-hidden p-4">
                <div class="calendar-wrapper">
                    <div class="calendar-container">
                        <div class="calendar-header">
                            <h3 id="calendarTitle">Loading...</h3>
                            <div class="calendar-nav">
                                <div class="btn-group">
                                    <button class="btn btn-primary" onclick="navigateCalendar('prev')">
                                        <i class="fa-solid fa-chevron-left"></i>
                                    </button>
                                    <button class="btn btn-default" onclick="navigateCalendar('today')">Today</button>
                                    <button class="btn btn-primary" onclick="navigateCalendar('next')">
                                        <i class="fa-solid fa-chevron-right"></i>
                                    </button>
                                </div>
                                <div class="btn-group">
                                    <button class="btn btn-warning" data-view="year"
                                        onclick="changeView('year')">Year</button>
                                    <button class="btn btn-warning active" data-view="month"
                                        onclick="changeView('month')">Month</button>
                                    <button class="btn btn-warning" data-view="week"
                                        onclick="changeView('week')">Week</button>
                                    <button class="btn btn-warning" data-view="day"
                                        onclick="changeView('day')">Day</button>
                                </div>
                            </div>
                        </div>
                        <div id="calendarGrid">
                            <div class="text-center py-8 text-gray-500">
                                <i class="fa-solid fa-spinner fa-spin text-blue-400 mr-2"></i>
                                Loading tasks...
                            </div>
                        </div>
                        <div class="calendar-footer">
                            <div class="legend">
                                <span class="legend-item">
                                    <span class="dot dot-pending"></span> Pending
                                </span>
                                <span class="legend-item">
                                    <span class="dot dot-inprogress"></span> In Progress
                                </span>
                                <span class="legend-item">
                                    <span class="dot dot-completed"></span> Completed
                                </span>
                            </div>
                            <div>
                                <span class="text-xs text-muted" id="eventCount">0 tasks</span>
                            </div>
                        </div>
                    </div>

                    <div class="details-panel" id="detailsPanel">
                        <div class="panel-title">
                            <i class="fa-solid fa-clipboard-list text-blue-500"></i>
                            Inspection Details
                            <span class="date-badge" id="selectedDateBadge">Select a date</span>
                        </div>
                        <div id="detailsContent">
                            <div class="no-events">
                                <i class="fa-regular fa-calendar-circle-plus"></i>
                                <p class="text-sm">Click on a date with inspection tasks<br>to view details here</p>
                            </div>
                        </div>
                    </div>
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
        const PRIVILEGE = 'Admin';
        const UTC_OFFSET = -300;

        let calendarData = [];
        let currentDate = new Date();
        let currentView = 'month';
        let isLoading = false;
        let selectedDate = null;
        let retryCount = 0;
        const MAX_RETRIES = 3;

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

            fetchTasks();
        });

        function fetchTasks() {
            if (isLoading) return;
            isLoading = true;

            var year = currentDate.getFullYear();
            var month = currentDate.getMonth();

            var startDate = new Date(year, month, 1);
            var endDate = new Date(year, month + 1, 0, 23, 59, 59);

            var fromTimestamp = startDate.getTime();
            var toTimestamp = endDate.getTime();

            var url = API_BASE + 'get/get_task_calander_data.php?' +
                'key=' + API_KEY +
                '&pre=' + PRIVILEGE +
                '&user_id=' + USER_ID +
                '&from=' + fromTimestamp +
                '&to=' + toTimestamp +
                '&utc_offset_from=' + UTC_OFFSET +
                '&utc_offset_to=' + UTC_OFFSET;

            console.log('Fetching Calendar Data URL:', url);

            $('#calendarGrid').html(
                '<div class="text-center py-8 text-gray-500"><i class="fa-solid fa-spinner fa-spin text-blue-400 mr-2"></i>Loading tasks...</div>'
            );

            $.ajax({
                url: url,
                method: 'GET',
                dataType: 'json',
                timeout: 120000,
                success: function (response) {
                    console.log('API Response:', response);
                    retryCount = 0;

                    var dataArray = [];
                    if (response && typeof response === 'object') {
                        if (response.success === 1 && Array.isArray(response.result)) {
                            dataArray = response.result;
                        } else if (Array.isArray(response)) {
                            dataArray = response;
                        }
                    }

                    processCalendarData(dataArray);
                },
                error: function (xhr, status, error) {
                    console.error('Error fetching calendar data:', status, error);

                    if (status === 'timeout') {
                        if (retryCount < MAX_RETRIES) {
                            retryCount++;
                            isLoading = false;
                            setTimeout(function () {
                                fetchTasks();
                            }, 5000);
                            return;
                        } else {
                            $('#calendarGrid').html(
                                '<div class="text-center py-8 text-yellow-500"><i class="fa-solid fa-clock mr-2"></i>Server is taking too long. Please try again later.</div>'
                            );
                        }
                    } else if (xhr.status === 0) {
                        $('#calendarGrid').html(
                            '<div class="text-center py-8 text-red-500"><i class="fa-solid fa-wifi mr-2"></i>Network error - Please check your internet connection.</div>'
                        );
                    } else if (xhr.status === 404) {
                        $('#calendarGrid').html(
                            '<div class="text-center py-8 text-red-500"><i class="fa-solid fa-file-circle-exclamation mr-2"></i>API endpoint not found.</div>'
                        );
                    } else {
                        $('#calendarGrid').html(
                            '<div class="text-center py-8 text-red-500"><i class="fa-solid fa-exclamation-circle mr-2"></i>Failed to load tasks. Please refresh the page.</div>'
                        );
                    }
                },
                complete: function () {
                    isLoading = false;
                }
            });
        }

        function processCalendarData(dataArray) {
            calendarData = [];

            if (Array.isArray(dataArray) && dataArray.length > 0) {
                dataArray.forEach(function (item) {
                    var startTimestamp = parseInt(item.start);
                    var dateObj = new Date(startTimestamp);

                    var dateStr = dateObj.getFullYear() + '-' +
                        String(dateObj.getMonth() + 1).padStart(2, '0') + '-' +
                        String(dateObj.getDate()).padStart(2, '0');

                    var titleText = item.title || '';
                    var dealerName = 'N/A';
                    var inspectorName = 'N/A';
                    var status = 'Pending';
                    var response = '';

                    if (titleText) {
                        var parts = titleText.split('|');
                        parts.forEach(function (part) {
                            var trimmed = part.trim();
                            if (trimmed.toLowerCase().includes('dealer')) {
                                var dealerParts = trimmed.split(':');
                                if (dealerParts.length > 1) {
                                    dealerName = dealerParts.slice(1).join(':').trim();
                                }
                            } else if (trimmed.toLowerCase().includes('inspector')) {
                                var inspectorParts = trimmed.split(':');
                                if (inspectorParts.length > 1) {
                                    inspectorName = inspectorParts.slice(1).join(':').trim();
                                }
                            } else if (trimmed.toLowerCase().includes('status')) {
                                var statusParts = trimmed.split(':');
                                if (statusParts.length > 1) {
                                    status = statusParts.slice(1).join(':').trim();
                                }
                            } else if (trimmed.toLowerCase().includes('response')) {
                                var responseParts = trimmed.split(':');
                                if (responseParts.length > 1) {
                                    response = responseParts.slice(1).join(':').trim();
                                }
                            }
                        });
                    }

                    calendarData.push({
                        id: item.id || '',
                        title: dealerName,
                        manager: inspectorName,
                        date: dateStr,
                        status: status,
                        description: '',
                        response: response,
                        start: item.start,
                        end: item.end,
                        allDay: item.allDay || false,
                        class: item.class || ''
                    });
                });
            } else {
                calendarData = [];
            }

            renderCalendar();
            updateEventCount();

            var todayStr = getDateStr(new Date());
            if (getEventsForDate(todayStr).length > 0) {
                selectDate(todayStr);
            }
        }

        function getDateStr(date) {
            return date.getFullYear() + '-' + String(date.getMonth() + 1).padStart(2, '0') + '-' + String(date.getDate()).padStart(2, '0');
        }

        function renderCalendar() {
            var year = currentDate.getFullYear();
            var month = currentDate.getMonth();

            if (currentView === 'month') {
                renderMonthView(year, month);
            } else if (currentView === 'week') {
                renderWeekView(year, month);
            } else if (currentView === 'day') {
                renderDayView(year, month);
            } else if (currentView === 'year') {
                renderYearView(year);
            }
        }

        function renderMonthView(year, month) {
            var monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            var dayNames = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];

            $('#calendarTitle').text(monthNames[month] + ' ' + year);

            var firstDay = new Date(year, month, 1).getDay();
            var daysInMonth = new Date(year, month + 1, 0).getDate();
            var daysInPrevMonth = new Date(year, month, 0).getDate();

            var today = new Date();
            var todayStr = getDateStr(today);

            var html = '<table>';
            html += '<thead><tr>';
            dayNames.forEach(function (day) {
                html += '<th>' + day + '</th>';
            });
            html += '</tr></thead><tbody><tr>';

            var startFrom = daysInPrevMonth - firstDay + 1;
            for (var i = 0; i < firstDay; i++) {
                html += '<td><span class="day-number other-month">' + (startFrom + i) + '</span></td>';
            }

            for (var day = 1; day <= daysInMonth; day++) {
                var dateObj = new Date(year, month, day);
                var dateStr = getDateStr(dateObj);
                var isToday = (dateStr === todayStr);
                var dayEvents = getEventsForDate(dateStr);
                var hasEvents = dayEvents.length > 0;
                var isSelected = (selectedDate === dateStr);

                html += '<td class="' + (hasEvents ? 'has-events' : '') + (isSelected ? ' selected-date' : '') + '" onclick="selectDate(\'' + dateStr + '\')">';
                html += '<span class="day-number' + (isToday ? ' today' : '') + (dateObj.getMonth() !== month ? ' other-month' : '') + '">' + day + '</span>';

                if (hasEvents) {
                    html += '<div class="calendar-events-preview">';
                    var dots = [];
                    dayEvents.forEach(function (event) {
                        var statusClass = getStatusClass(event.status);
                        if (!dots.includes(statusClass)) {
                            dots.push(statusClass);
                        }
                    });
                    dots.forEach(function (cls) {
                        html += '<span class="calendar-event-dot ' + cls + '"></span>';
                    });
                    html += '</div>';
                }

                html += '</td>';

                if ((firstDay + day) % 7 === 0 && day < daysInMonth) {
                    html += '</tr><tr>';
                }
            }

            var remainingDays = 7 - ((firstDay + daysInMonth) % 7);
            if (remainingDays < 7) {
                for (var i = 1; i <= remainingDays; i++) {
                    html += '<td><span class="day-number other-month">' + i + '</span></td>';
                }
            }

            html += '</tr></tbody></table>';
            $('#calendarGrid').html(html);
        }

        function renderWeekView(year, month) {
            var dayNames = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
            var monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

            var firstDayOfMonth = new Date(year, month, 1);
            var startDate = new Date(year, month, 1);
            startDate.setDate(1 - firstDayOfMonth.getDay());

            $('#calendarTitle').text('Week of ' + startDate.getDate() + ' ' + monthNames[startDate.getMonth()] + ' ' + startDate.getFullYear());

            var today = new Date();
            var todayStr = getDateStr(today);

            var html = '<table>';
            html += '<thead><tr>';
            dayNames.forEach(function (day) {
                html += '<th>' + day + '</th>';
            });
            html += '</tr></thead><tbody><tr>';

            var currentDateObj = new Date(startDate);
            for (var i = 0; i < 7; i++) {
                var dateStr = getDateStr(currentDateObj);
                var isToday = (dateStr === todayStr);
                var dayEvents = getEventsForDate(dateStr);
                var hasEvents = dayEvents.length > 0;
                var isSelected = (selectedDate === dateStr);

                html += '<td class="' + (hasEvents ? 'has-events' : '') + (isSelected ? ' selected-date' : '') + '" onclick="selectDate(\'' + dateStr + '\')">';
                html += '<span class="day-number' + (isToday ? ' today' : '') + '">' + currentDateObj.getDate() + '</span>';

                if (hasEvents) {
                    html += '<div class="calendar-events-preview">';
                    var dots = [];
                    dayEvents.forEach(function (event) {
                        var statusClass = getStatusClass(event.status);
                        if (!dots.includes(statusClass)) {
                            dots.push(statusClass);
                        }
                    });
                    dots.forEach(function (cls) {
                        html += '<span class="calendar-event-dot ' + cls + '"></span>';
                    });
                    html += '</div>';
                }

                html += '</td>';
                currentDateObj.setDate(currentDateObj.getDate() + 1);
            }

            html += '</tr></tbody></table>';
            $('#calendarGrid').html(html);
        }

        function renderDayView(year, month) {
            var monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            var dayNames = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

            var day = currentDate.getDate();
            var dateStr = getDateStr(currentDate);

            $('#calendarTitle').text(dayNames[currentDate.getDay()] + ', ' + day + ' ' + monthNames[month] + ' ' + year);

            var dayEvents = getEventsForDate(dateStr);

            var html = '<div class="p-4">';
            if (dayEvents.length > 0) {
                html += '<div class="space-y-2">';
                dayEvents.forEach(function (event) {
                    var statusClass = getStatusClass(event.status);
                    html += '<div class="inspection-card status-' + statusClass + '" onclick="selectDate(\'' + dateStr + '\')">';
                    html += '<div class="card-header">';
                    html += '<span class="dealer-name">' + event.title + '</span>';
                    html += '<span class="status-badge ' + statusClass + '">' + event.status + '</span>';
                    html += '</div>';
                    html += '<div class="card-body">';
                    html += '<div class="info-row">';
                    html += '<span><span class="label">Inspector:</span> <span class="value">' + event.manager + '</span></span>';
                    html += '</div>';
                    if (event.response) {
                        html += '<div class="response-text">' + event.response + '</div>';
                    }
                    html += '</div>';
                    html += '</div>';
                });
                html += '</div>';
            } else {
                html += '<div class="text-center py-8 text-gray-500">No tasks for this day</div>';
            }
            html += '</div>';

            $('#calendarGrid').html(html);
        }

        function renderYearView(year) {
            var monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

            $('#calendarTitle').text('Year ' + year);

            var html = '<div class="grid grid-cols-1 md:grid-cols-3 gap-4 p-4">';
            for (var m = 0; m < 12; m++) {
                var daysInMonth = new Date(year, m + 1, 0).getDate();
                var monthEvents = [];
                for (var d = 1; d <= daysInMonth; d++) {
                    var dateObj = new Date(year, m, d);
                    var dateStr = getDateStr(dateObj);
                    var events = getEventsForDate(dateStr);
                    if (events.length > 0) {
                        monthEvents = monthEvents.concat(events);
                    }
                }

                html += '<div class="panel-card p-3 hover:shadow-md transition-shadow cursor-pointer" onclick="changeView(\'month\'); currentDate=new Date(' + year + ',' + m + ',1); renderCalendar();">';
                html += '<h4 class="text-sm font-semibold text-heading mb-2">' + monthNames[m] + ' <span class="text-xs text-muted">(' + monthEvents.length + ' tasks)</span></h4>';
                if (monthEvents.length > 0) {
                    var displayEvents = monthEvents.slice(0, 3);
                    displayEvents.forEach(function (event) {
                        var statusClass = getStatusClass(event.status);
                        html += '<span class="calendar-event event-' + statusClass + ' text-xs block mb-1 rounded px-2 py-0.5" style="background-color:var(--event-' + statusClass + ');color:#fff;">' +
                            event.title.substring(0, 15) + (event.title.length > 15 ? '...' : '') +
                            '</span>';
                    });
                    if (monthEvents.length > 3) {
                        html += '<span class="text-xs text-muted">+' + (monthEvents.length - 3) + ' more</span>';
                    }
                } else {
                    html += '<span class="text-xs text-muted">No tasks</span>';
                }
                html += '</div>';
            }
            html += '</div>';

            $('#calendarGrid').html(html);
        }

        function getEventsForDate(dateStr) {
            return calendarData.filter(function (event) {
                return event.date === dateStr;
            });
        }

        function getStatusClass(status) {
            if (!status) return 'pending';
            var statusLower = status.toLowerCase();
            if (statusLower === 'completed' || statusLower === 'complete') {
                return 'completed';
            } else if (statusLower === 'inprogress' || statusLower === 'in progress') {
                return 'inprogress';
            } else {
                return 'pending';
            }
        }

        function updateEventCount() {
            $('#eventCount').text(calendarData.length + ' tasks');
        }

        function navigateCalendar(direction) {
            if (direction === 'prev') {
                if (currentView === 'month') {
                    currentDate.setMonth(currentDate.getMonth() - 1);
                } else if (currentView === 'week') {
                    currentDate.setDate(currentDate.getDate() - 7);
                } else if (currentView === 'day') {
                    currentDate.setDate(currentDate.getDate() - 1);
                } else if (currentView === 'year') {
                    currentDate.setFullYear(currentDate.getFullYear() - 1);
                }
            } else if (direction === 'next') {
                if (currentView === 'month') {
                    currentDate.setMonth(currentDate.getMonth() + 1);
                } else if (currentView === 'week') {
                    currentDate.setDate(currentDate.getDate() + 7);
                } else if (currentView === 'day') {
                    currentDate.setDate(currentDate.getDate() + 1);
                } else if (currentView === 'year') {
                    currentDate.setFullYear(currentDate.getFullYear() + 1);
                }
            } else if (direction === 'today') {
                currentDate = new Date();
            }
            retryCount = 0;
            fetchTasks();
        }

        function changeView(view) {
            currentView = view;
            $('.btn-warning').removeClass('active');
            $('[data-view="' + view + '"]').addClass('active');
            renderCalendar();
        }

        function selectDate(dateStr) {
            selectedDate = dateStr;
            var events = getEventsForDate(dateStr);

            var dateObj = new Date(dateStr + 'T00:00:00');
            var monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            var dayNames = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
            var formattedDate = dayNames[dateObj.getDay()] + ', ' + dateObj.getDate() + ' ' + monthNames[dateObj.getMonth()] + ' ' + dateObj.getFullYear();
            $('#selectedDateBadge').text(formattedDate);

            var detailsHtml = '';
            if (events.length > 0) {
                detailsHtml += '<div class="space-y-2">';
                events.forEach(function (event) {
                    var statusClass = getStatusClass(event.status);
                    detailsHtml += '<div class="inspection-card status-' + statusClass + '">';
                    detailsHtml += '<div class="card-header">';
                    detailsHtml += '<span class="dealer-name">' + event.title + '</span>';
                    detailsHtml += '<span class="status-badge ' + statusClass + '">' + event.status + '</span>';
                    detailsHtml += '</div>';
                    detailsHtml += '<div class="card-body">';
                    detailsHtml += '<div class="info-row">';
                    detailsHtml += '<span><span class="label">Inspector:</span> <span class="value">' + event.manager + '</span></span>';
                    detailsHtml += '</div>';
                    if (event.response) {
                        detailsHtml += '<div class="response-text"><span class="label">Response:</span> ' + event.response + '</div>';
                    }
                    detailsHtml += '</div>';
                    detailsHtml += '</div>';
                });
                detailsHtml += '</div>';
            } else {
                detailsHtml = '<div class="no-events">' +
                    '<i class="fa-regular fa-calendar-circle-plus"></i>' +
                    '<p class="text-sm">No inspections on this date</p>' +
                    '</div>';
            }

            $('#detailsContent').html(detailsHtml);
            renderCalendar();
        }
    </script>

</body>

</html>