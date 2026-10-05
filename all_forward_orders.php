<?php
// Hascol OMC Operations Command Center - Local All Forward Orders
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hascol OMC - All Forward Orders</title>
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
            --backlog-timeline-line: #e2e8f0;
            --backlog-card-shadow: 0 1px 2px rgba(15, 23, 42, 0.04);
            --backlog-card-shadow-hover: 0 8px 24px rgba(15, 23, 42, 0.08);
            --backlog-header-gradient: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);
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
            --backlog-timeline-line: #1a2635;
            --backlog-card-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
            --backlog-card-shadow-hover: 0 8px 24px rgba(0, 0, 0, 0.35);
            --backlog-header-gradient: linear-gradient(135deg, #1d4ed8 0%, #0f2b73 100%);
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
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .table-container table tbody td {
            padding: 10px 12px;
            border-bottom: 1px solid var(--border-color);
            color: var(--table-row-text);
            vertical-align: middle;
        }
        .table-container table tbody tr:hover {
            background-color: var(--table-row-hover);
        }

        .dataTables_wrapper .dataTables_length {
            display: none !important;
        }
        .dataTables_wrapper .dataTables_info {
            color: var(--text-muted) !important;
            font-size: 11px !important;
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

        /* Search container in toolbar */
        #tableSearchContainer {
            display: inline-flex;
            align-items: center;
        }

        /* Search wrapper */
        #tableSearchContainer .dataTables_filter {
            margin: 0 !important;
            float: none !important;
        }

        /* Search label - Hide "Search:" text */
        #tableSearchContainer .dataTables_filter label {
            display: flex !important;
            align-items: center !important;
            gap: 8px;
            margin: 0 !important;
            color: var(--text-muted);
            font-size: 11px;
            font-weight: 500;
            white-space: nowrap;
        }

        /* Search input */
        #tableSearchContainer .dataTables_filter input {
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

        #tableSearchContainer .dataTables_filter input::placeholder {
            color: var(--text-muted);
        }
        #tableSearchContainer .dataTables_filter input:focus {
            border-color: #1d4ed8;
            box-shadow: 0 0 0 2px rgba(29, 78, 216, 0.2);
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

        .form-select {
            background-color: var(--input-bg);
            border: 1px solid var(--border-color);
            border-radius: 0.25rem;
            color: var(--text-body);
            padding: 4px 28px 4px 10px;
            font-size: 11px;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3E%3Cpath stroke='%2364748b' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3E%3C/svg%3E");
            background-position: right 8px center;
            background-repeat: no-repeat;
            background-size: 14px;
            padding-right: 32px;
            cursor: pointer;
            height: 30px;
            box-sizing: border-box;
            min-width: 130px;
        }
        .form-select:focus {
            outline: none;
            border-color: #1d4ed8;
            box-shadow: 0 0 0 2px rgba(29, 78, 216, 0.2);
        }

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
        @media (max-width: 1024px) {
            .toolbar-row {
                flex-wrap: wrap;
            }
            .toolbar-right {
                flex-wrap: wrap;
            }
        }

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
        .column-visibility-dropdown .dropdown-menu {
            position: absolute;
            top: calc(100% + 4px);
            left: 0;
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
            height: 32px;
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

        .form-input {
            background-color: var(--input-bg);
            border: 1px solid var(--border-color);
            border-radius: 0.25rem;
            color: var(--text-body);
            padding: 6px 10px;
            width: 100%;
            font-size: 12px;
            transition: border-color 0.2s;
            height: 32px;
        }
        .form-input:focus {
            outline: none;
            border-color: #1d4ed8;
            box-shadow: 0 0 0 2px rgba(29, 78, 216, 0.2);
        }
        .form-input::placeholder {
            color: var(--text-muted);
        }
        .form-label {
            color: var(--text-muted);
            font-size: 11px;
            font-weight: 500;
            margin-bottom: 4px;
            display: block;
        }

        .badge {
            padding: 2px 10px;
            border-radius: 9999px;
            font-size: 9px;
            font-weight: 600;
            display: inline-block;
            color: #fff;
            cursor: pointer;
        }
        .badge.bg-primary { background: #1d4ed8; }
        .badge.bg-info { background: #06b6d4; }
        .badge.bg-danger { background: #ef4444; }
        .badge.bg-dark { background: #1f2937; }
        .badge.bg-warning { background: #f59e0b; color: #000; }
        .badge.bg-success { background: #10b981; }

        .button-soft-danger {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            border: none;
            padding: 4px 8px;
            border-radius: 0.25rem;
            cursor: pointer;
            transition: all 0.2s;
        }
        .button-soft-danger:hover {
            background: rgba(239, 68, 68, 0.2);
        }

        .backlog-modal {
            max-width: 640px;
            width: 100%;
        }

        .backlog-modal .modal-header-custom {
            padding: 20px 24px;
            background: var(--backlog-header-gradient);
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
        }
        .backlog-modal .modal-header-custom::before {
            content: '';
            position: absolute;
            top: -40%;
            right: -6%;
            width: 160px;
            height: 160px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
            pointer-events: none;
        }
        .backlog-modal .modal-header-custom .header-left {
            display: flex;
            align-items: center;
            gap: 12px;
            position: relative;
            z-index: 1;
        }
        .backlog-modal .modal-header-custom .header-icon-wrap {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .backlog-modal .modal-header-custom .header-icon-wrap i {
            color: #ffffff;
            font-size: 16px;
        }
        .backlog-modal .modal-header-custom h3 {
            font-size: 15px;
            font-weight: 600;
            color: #ffffff;
            line-height: 1.3;
        }
        .backlog-modal .modal-header-custom .header-subtitle {
            font-size: 11px;
            color: rgba(255, 255, 255, 0.75);
            margin-top: 2px;
            font-weight: 400;
        }
        .backlog-modal .modal-header-custom .close-btn {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.12);
            color: #ffffff;
            border: none;
            cursor: pointer;
            transition: background-color 0.2s;
            position: relative;
            z-index: 1;
            flex-shrink: 0;
        }
        .backlog-modal .modal-header-custom .close-btn:hover {
            background: rgba(255, 255, 255, 0.25);
        }
        .backlog-modal .modal-header-custom .close-btn i {
            font-size: 15px;
        }

        .backlog-modal .modal-body-custom {
            padding: 20px 24px 24px 24px;
            max-height: 520px;
            overflow-y: auto;
            background-color: var(--bg-panel);
        }
        .backlog-modal .modal-body-custom::-webkit-scrollbar {
            width: 5px;
        }
        .backlog-modal .modal-body-custom::-webkit-scrollbar-track {
            background: var(--scrollbar-track);
            border-radius: 4px;
        }
        .backlog-modal .modal-body-custom::-webkit-scrollbar-thumb {
            background: var(--scrollbar-thumb);
            border-radius: 4px;
        }

        .backlog-progress-strip {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 14px;
            background-color: var(--hover-bg);
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            margin-bottom: 18px;
        }
        .backlog-progress-strip i {
            color: #1d4ed8;
            font-size: 13px;
        }
        .backlog-progress-strip .progress-text {
            font-size: 11px;
            color: var(--text-body);
            font-weight: 500;
        }
        .backlog-progress-strip .progress-text strong {
            color: var(--text-heading);
        }

        .backlog-timeline {
            position: relative;
            padding-left: 8px;
        }

        .backlog-item {
            position: relative;
            display: flex;
            gap: 14px;
            padding-bottom: 22px;
        }
        .backlog-item:last-child {
            padding-bottom: 0;
        }

        .backlog-item:not(:last-child)::after {
            content: '';
            position: absolute;
            left: 17px;
            top: 36px;
            bottom: 0;
            width: 2px;
            background: var(--backlog-timeline-line);
        }
        .backlog-item.completed:not(:last-child)::after {
            background: linear-gradient(180deg, #10b981 0%, var(--backlog-timeline-line) 100%);
        }

        .backlog-item .node-icon {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--hover-bg);
            color: var(--text-muted);
            border: 2px solid var(--bg-panel);
            box-shadow: 0 0 0 2px var(--border-color);
            font-size: 13px;
            position: relative;
            z-index: 1;
            transition: all 0.2s ease;
        }
        .backlog-item.completed .node-icon {
            background: rgba(16, 185, 129, 0.12);
            color: #10b981;
            box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.3);
        }
        .backlog-item.pending .node-icon {
            background: rgba(245, 158, 11, 0.12);
            color: #f59e0b;
            box-shadow: 0 0 0 2px rgba(245, 158, 11, 0.3);
        }
        .backlog-item.cancelled .node-icon {
            background: rgba(239, 68, 68, 0.12);
            color: #ef4444;
            box-shadow: 0 0 0 2px rgba(239, 68, 68, 0.3);
        }

        .backlog-item.is-latest .node-icon {
            width: 40px;
            height: 40px;
            font-size: 15px;
            box-shadow: 0 0 0 4px rgba(29, 78, 216, 0.18);
            background: #1d4ed8;
            color: #ffffff;
        }
        .backlog-item.is-latest.completed .node-icon {
            background: #10b981;
            color: #ffffff;
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.2);
        }
        .backlog-item.is-latest.cancelled .node-icon {
            background: #ef4444;
            color: #ffffff;
            box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.2);
        }
        .backlog-item.is-latest.pending .node-icon {
            background: #f59e0b;
            color: #ffffff;
            box-shadow: 0 0 0 4px rgba(245, 158, 11, 0.2);
        }

        .backlog-item .item-content {
            flex: 1;
            min-width: 0;
            background: var(--bg-panel);
            border: 1px solid var(--border-color);
            border-radius: 0.625rem;
            padding: 12px 14px;
            box-shadow: var(--backlog-card-shadow);
            transition: box-shadow 0.2s ease, border-color 0.2s ease;
        }
        .backlog-item .item-content:hover {
            border-color: #1d4ed8;
            box-shadow: var(--backlog-card-shadow-hover);
        }
        .backlog-item.is-latest .item-content {
            border-color: #1d4ed8;
            box-shadow: var(--backlog-card-shadow-hover);
        }

        .backlog-item .item-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 6px;
        }

        .backlog-item .title-block {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .backlog-item .item-title {
            font-size: 12.5px;
            font-weight: 600;
            color: var(--text-heading);
        }

        .backlog-item .latest-pill {
            font-size: 8.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            color: #ffffff;
            background: #1d4ed8;
            padding: 2px 8px;
            border-radius: 9999px;
        }

        .backlog-item .item-header .status-badge {
            font-size: 9.5px;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 9999px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            letter-spacing: 0.3px;
            white-space: nowrap;
        }
        .backlog-item .item-header .status-badge.status-created {
            background: #e2e8f0;
            color: #475569;
        }
        html.dark-mode .backlog-item .item-header .status-badge.status-created {
            background: #1a2635;
            color: #94a3b8;
        }
        .backlog-item .item-header .status-badge.status-processed {
            background: #dbeafe;
            color: #1d4ed8;
        }
        html.dark-mode .backlog-item .item-header .status-badge.status-processed {
            background: rgba(29, 78, 216, 0.2);
            color: #60a5fa;
        }
        .backlog-item .item-header .status-badge.status-forwarded {
            background: #d1fae5;
            color: #059669;
        }
        html.dark-mode .backlog-item .item-header .status-badge.status-forwarded {
            background: rgba(16, 185, 129, 0.2);
            color: #34d399;
        }
        .backlog-item .item-header .status-badge.status-pushed {
            background: #fef3c7;
            color: #d97706;
        }
        html.dark-mode .backlog-item .item-header .status-badge.status-pushed {
            background: rgba(245, 158, 11, 0.2);
            color: #fbbf24;
        }
        .backlog-item .item-header .status-badge.status-approved {
            background: #dbeafe;
            color: #1d4ed8;
        }
        html.dark-mode .backlog-item .item-header .status-badge.status-approved {
            background: rgba(29, 78, 216, 0.2);
            color: #60a5fa;
        }
        .backlog-item .item-header .status-badge.status-complete {
            background: #d1fae5;
            color: #059669;
        }
        html.dark-mode .backlog-item .item-header .status-badge.status-complete {
            background: rgba(16, 185, 129, 0.2);
            color: #34d399;
        }
        .backlog-item .item-header .status-badge.status-cancel {
            background: #fee2e2;
            color: #dc2626;
        }
        html.dark-mode .backlog-item .item-header .status-badge.status-cancel {
            background: rgba(239, 68, 68, 0.2);
            color: #f87171;
        }
        .backlog-item .item-header .status-badge.status-special {
            background: #e0e7ff;
            color: #4f46e5;
        }
        html.dark-mode .backlog-item .item-header .status-badge.status-special {
            background: rgba(79, 70, 229, 0.2);
            color: #818cf8;
        }
        .backlog-item .item-header .status-badge.status-asm {
            background: #f3e8ff;
            color: #7c3aed;
        }
        html.dark-mode .backlog-item .item-header .status-badge.status-asm {
            background: rgba(124, 58, 237, 0.2);
            color: #a78bfa;
        }

        .backlog-item .item-datetime {
            font-size: 10px;
            color: var(--text-muted);
            display: inline-flex;
            align-items: center;
            gap: 5px;
            white-space: nowrap;
            font-weight: 500;
        }
        .backlog-item .item-datetime i {
            font-size: 10px;
            opacity: 0.7;
        }

        .backlog-item .item-details {
            display: flex;
            flex-wrap: wrap;
            gap: 8px 18px;
            margin-top: 8px;
            padding-top: 8px;
            border-top: 1px dashed var(--border-color);
        }
        .backlog-item .item-details .detail {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 10.5px;
            color: var(--text-muted);
        }
        .backlog-item .item-details .detail i {
            font-size: 11px;
            color: var(--text-muted);
            opacity: 0.65;
            width: 12px;
            text-align: center;
        }
        .backlog-item .item-details .detail .label {
            font-weight: 500;
            color: var(--text-muted);
        }
        .backlog-item .item-details .detail .value {
            color: var(--text-body);
            font-weight: 500;
        }
        .backlog-item .item-details .detail.note-detail {
            width: 100%;
            align-items: flex-start;
        }
        .backlog-item .item-details .detail.note-detail .value {
            font-weight: 400;
            line-height: 1.5;
        }

        .backlog-start-end {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 0 16px 0;
        }
        .backlog-start-end .marker {
            display: flex;
            align-items: center;
            gap: 7px;
            font-size: 10px;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.6px;
        }
        .backlog-start-end .marker .dot {
            width: 9px;
            height: 9px;
            border-radius: 50%;
            display: inline-block;
            box-shadow: 0 0 0 3px transparent;
        }
        .backlog-start-end .marker .dot.start {
            background: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.18);
        }
        .backlog-start-end .marker .dot.end {
            background: #ef4444;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.18);
        }
        .backlog-start-end .line-dashed {
            flex: 1;
            height: 1px;
            border-top: 1.5px dashed var(--border-color);
            margin: 0 12px;
        }

        .backlog-empty {
            text-align: center;
            padding: 48px 20px;
            color: var(--text-muted);
        }
        .backlog-empty .empty-icon-wrap {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: var(--hover-bg);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 14px auto;
        }
        .backlog-empty i {
            font-size: 22px;
            color: var(--text-muted);
            opacity: 0.6;
        }
        .backlog-empty p {
            font-size: 12.5px;
            font-weight: 500;
            color: var(--text-body);
        }
        .backlog-empty span {
            font-size: 11px;
            color: var(--text-muted);
            display: block;
            margin-top: 4px;
        }

        @media (max-width: 640px) {
            .backlog-modal .modal-header-custom {
                padding: 16px 16px;
            }
            .backlog-modal .modal-body-custom {
                padding: 16px 14px 18px 14px;
            }
            .backlog-item {
                gap: 10px;
            }
            .backlog-item .node-icon {
                width: 30px;
                height: 30px;
                font-size: 11px;
            }
            .backlog-item:not(:last-child)::after {
                left: 14px;
                top: 32px;
            }
            .backlog-item .item-header {
                flex-direction: column;
                align-items: flex-start;
            }
            .backlog-item .item-details {
                flex-direction: column;
                gap: 6px;
            }
            .backlog-item .item-details .detail {
                font-size: 10px;
            }
            .backlog-start-end {
                flex-direction: column;
                gap: 8px;
                align-items: stretch;
            }
            .backlog-start-end .line-dashed {
                width: 100%;
                margin: 2px 0;
            }
        }
    </style>
</head>

<body class="flex h-screen overflow-hidden text-xs">

    <?php include 'includes/sidebar.php'; ?>

    <main id="mainContent" class="flex-1 flex flex-col overflow-hidden">

        <?php include 'includes/topbar.php'; ?>

        <div class="flex-1 overflow-y-auto p-4" id="pageContent">

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
                        <div id="tableSearchContainer"></div>
                    </div>
                </div>
            </div>

            <div class="panel-card overflow-hidden">
                <div class="table-container">
                    <table id="ordersTable" class="display" style="width:100%;">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Date</th>
                                <th>JD Code</th>
                                <th>Site Name</th>
                                <th>Type</th>
                                <th>Depot</th>
                                <th>Order Type</th>
                                <th>Total Amount</th>
                                <th>Ledger Amount</th>
                                <th>Status</th>
                                <th>Push Status</th>
                                <th>Product</th>
                                <th>Rate</th>
                                <th>Quantity</th>
                                <th>Bill Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="15" class="text-center py-8 text-gray-500">
                                    <i class="fa-solid fa-spinner fa-spin text-blue-400 mr-2"></i>
                                    Loading orders...
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <?php include 'includes/footer.php'; ?>
    </main>

    <div id="toast" class="toast">
        <i class="fa-solid fa-check-circle mr-2"></i>
        <span id="toastMessage">Action completed successfully!</span>
    </div>

    <!-- Approved Order Modal -->
    <div id="approvedOrderModal" class="fixed inset-0 z-50 hidden backdrop-blur-sm flex items-center justify-center transition-opacity duration-300 opacity-0">
        <div class="panel-card border rounded-lg shadow-2xl w-full max-w-md transform scale-95 transition-transform duration-300">
            <div class="flex justify-between items-center p-4 border-b" style="border-color: var(--border-color);">
                <h3 class="text-heading font-semibold text-sm">Push Order</h3>
                <button onclick="closeApprovedModal()" class="text-gray-400 hover:text-red-500 transition">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>
            <form id="approvedOrderForm" onsubmit="saveApprovedOrder(event)">
                <div class="p-4 space-y-4">
                    <input type="hidden" id="orderApprovalId" name="order_approval">
                    <input type="hidden" name="user_id" value="1">
                    <div>
                        <label class="form-label">Status</label>
                        <select id="approvedOrderStatus" name="approved_order_status" class="form-select">
                            <option value="1">Push</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Description</label>
                        <textarea id="approvedOrderDescription" name="approved_order_description" rows="3" class="form-input" placeholder="Enter description..."></textarea>
                    </div>
                </div>
                <div class="flex gap-3 p-4 border-t" style="border-color: var(--border-color);">
                    <button type="submit" class="btn-primary flex-1">Push Order</button>
                    <button type="button" onclick="closeApprovedModal()" class="btn-secondary">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Insufficient Balance Modal -->
    <div id="insufficientModal" class="fixed inset-0 z-50 hidden backdrop-blur-sm flex items-center justify-center transition-opacity duration-300 opacity-0">
        <div class="panel-card border rounded-lg shadow-2xl w-full max-w-md transform scale-95 transition-transform duration-300">
            <div class="flex justify-between items-center p-4 border-b" style="border-color: var(--border-color);">
                <h3 class="text-heading font-semibold text-sm">Insufficient Balance</h3>
                <button onclick="closeInsufficientModal()" class="text-gray-400 hover:text-red-500 transition">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>
            <form id="insufficientForm" onsubmit="saveInsufficientOrder(event)">
                <div class="p-4 space-y-4">
                    <input type="hidden" id="specialApprovalId" name="spe_approval">
                    <div>
                        <label class="form-label">Action</label>
                        <select id="insufficientAction" name="in_balanced_order" class="form-select">
                            <option value="">Choose...</option>
                            <option value="2">Block Order</option>
                            <option value="3">Special Approval</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Description</label>
                        <textarea id="insufficientDescription" name="in_balanced_description" rows="3" class="form-input" placeholder="Enter description..."></textarea>
                    </div>
                </div>
                <div class="flex gap-3 p-4 border-t" style="border-color: var(--border-color);">
                    <button type="submit" class="btn-primary flex-1">Save Changes</button>
                    <button type="button" onclick="closeInsufficientModal()" class="btn-secondary">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Backlog Modal -->
    <div id="backlogModal" class="fixed inset-0 z-50 hidden backdrop-blur-sm flex items-center justify-center transition-opacity duration-300 opacity-0">
        <div class="panel-card border rounded-lg shadow-2xl backlog-modal transform scale-95 transition-transform duration-300 overflow-hidden">
            <div class="modal-header-custom">
                <div class="header-left">
                    <div class="header-icon-wrap">
                        <i class="fa-solid fa-timeline"></i>
                    </div>
                    <div>
                        <h3>Order Activity Timeline</h3>
                        <div class="header-subtitle" id="backlogHeaderSubtitle">Full history of this order's journey</div>
                    </div>
                </div>
                <button onclick="closeBacklogModal()" class="close-btn">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-body-custom">
                <div id="orderLogsContainer">
                    <div class="backlog-empty">
                        <div class="empty-icon-wrap">
                            <i class="fa-regular fa-hourglass-half"></i>
                        </div>
                        <p>No activity logs available</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Detail Modal -->
    <div id="productDetailModal" class="fixed inset-0 z-50 hidden backdrop-blur-sm flex items-center justify-center transition-opacity duration-300 opacity-0">
        <div class="panel-card border rounded-lg shadow-2xl w-full max-w-5xl max-h-[80vh] transform scale-95 transition-transform duration-300 overflow-hidden">
            <div class="flex justify-between items-center p-4 border-b flex-shrink-0" style="border-color: var(--border-color);">
                <h3 class="text-heading font-semibold text-sm">Order Details</h3>
                <button onclick="closeProductDetailModal()" class="text-gray-400 hover:text-red-500 transition">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>
            <div class="flex-1 overflow-y-auto p-4">
                <div class="table-container">
                    <table id="productDetailTable" class="display" style="width:100%;">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Date</th>
                                <th>JD Code</th>
                                <th>Site Name</th>
                                <th>Product Type</th>
                                <th>Rate</th>
                                <th>Qty</th>
                                <th>Delivered</th>
                                <th>Depot</th>
                                <th>Order Amount</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            loadDepots();
            fetchtable();

            $(document).on('click', function(e) {
                if (!$(e.target).closest('.column-visibility-dropdown').length) {
                    closeColumnDropdown();
                }
            });
        });

        const API_BASE_URL = 'api/';

        let ordersDataTable = null;
        let productDetailDataTable = null;

        const columnConfig = [
            { idx: 0, label: 'S.No' },
            { idx: 1, label: 'Date' },
            { idx: 2, label: 'JD Code' },
            { idx: 3, label: 'Site Name' },
            { idx: 4, label: 'Type' },
            { idx: 5, label: 'Depot' },
            { idx: 6, label: 'Order Type' },
            { idx: 7, label: 'Total Amount' },
            { idx: 8, label: 'Ledger Amount' },
            { idx: 9, label: 'Status' },
            { idx: 10, label: 'Push Status' },
            { idx: 11, label: 'Product' },
            { idx: 12, label: 'Rate' },
            { idx: 13, label: 'Quantity' },
            { idx: 14, label: 'Bill Amount' }
        ];

        function showToast(message, type = 'success') {
            const toast = $('#toast');
            $('#toastMessage').text(message);
            toast.removeClass('success error').addClass(type);
            toast.addClass('show');
            clearTimeout(window.toastTimeout);
            window.toastTimeout = setTimeout(() => toast.removeClass('show'), 3000);
        }

        function loadDepots() {
            $.ajax({
                url: API_BASE_URL + 'get/geo_depot.php?key=03201232927',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    const select = $('#sDepot');
                    select.empty().append('<option value="">Choose...</option>');
                    $.each(data, function(i, item) {
                        select.append($('<option>', { value: item.consignee_name, text: item.consignee_name }));
                    });
                },
                error: function() {
                    console.log('Failed to load depots');
                }
            });
        }

        function fetchtable() {
            var rettypes = "CO ";

            $('#ordersTable tbody').html(`
                <tr>
                    <td colspan="15" class="text-center py-8 text-gray-500">
                        <i class="fa-solid fa-spinner fa-spin text-blue-400 mr-2"></i>
                        Loading orders...
                    </td>
                </tr>
            `);

            $.ajax({
                url: API_BASE_URL + 'get/get_all_retail_forwarded_orders.php?key=03201232927&pre=Admin&user_id=1&rettype=' + rettypes,
                type: 'GET',
                dataType: 'json',
                timeout: 30000,
                success: function(response) {
                    if (response && Array.isArray(response) && response.length > 0) {
                        const allRows = [];
                        var rowIndex = 1;

                        $.each(response, function(index, data) {
                            var statusHtml = '';
                            var approvedClass = '';
                            var st = '';
                            var pushStatusHtml = '';

                            var ledgerDisplay = ($.trim(data.rettype_desc) === 'COCO site') ? '---' : parseFloat(data.legder_balance).toLocaleString();

                            if (data.status == 0) {
                                st = 'Pending';
                                approvedClass = 'bg-primary';
                            } else if (data.status == 1) {
                                st = 'Approved';
                                approvedClass = 'bg-info';
                            } else if (data.status == 2) {
                                st = 'Blocked';
                                approvedClass = 'bg-danger';
                            } else if (data.status == 3) {
                                st = 'Special Approval';
                                approvedClass = 'bg-dark';
                            } else if (data.status == 4) {
                                st = 'Released';
                                approvedClass = 'bg-warning';
                            } else if (data.status == 5) {
                                st = 'Forwarded';
                                approvedClass = 'bg-success';
                            } else if (data.status == 6) {
                                st = 'Processed';
                                approvedClass = 'bg-success';
                            }

                            statusHtml = '<span id="' + data.id + '" class="badge ' + approvedClass + '">' + st + '</span>';

                            if (data.status == 5) {
                                pushStatusHtml = '<button type="button" id="' + data.id + '" class="button-soft-danger approved_check" onclick="openApprovedModalWithId(' + data.id + ')"><i class="fas fa-align-justify font-size-16 align-middle"></i></button>';
                            }

                            var productNames = [];
                            var productRates = [];
                            var productQtys = [];
                            var productAmounts = [];

                            $.ajax({
                                url: API_BASE_URL + 'get/get_main_sub_orders.php?key=03201232927&id=' + data.id,
                                type: 'GET',
                                dataType: 'json',
                                async: false,
                                success: function(products) {
                                    if (products && products.length > 0) {
                                        $.each(products, function(pi, p) {
                                            productNames.push(p.product_name || '');
                                            productRates.push(p.rate ? parseFloat(p.rate).toLocaleString() : '0');
                                            productQtys.push(p.quantity ? parseFloat(p.quantity).toLocaleString() : '0');
                                            productAmounts.push(p.amount ? parseFloat(p.amount).toLocaleString() : '0');
                                        });
                                    }
                                }
                            });

                            var row = [
                                rowIndex++,
                                data.created_at || '',
                                data.sap_no || '',
                                data.name || '',
                                data.type || '',
                                data.depot || '',
                                data.type || '',
                                parseFloat(data.total_amount).toLocaleString(),
                                ledgerDisplay,
                                statusHtml,
                                pushStatusHtml,
                                productNames.join('<br>'),
                                productRates.join('<br>'),
                                productQtys.join('<br>'),
                                productAmounts.join('<br>')
                            ];
                            allRows.push(row);
                        });

                        initializeDataTable(allRows);
                    } else {
                        showToast('No forwarded orders found.', 'error');
                        initializeDataTable([]);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('API Error:', status, error);
                    showToast('Failed to load orders. Please refresh.', 'error');
                    initializeDataTable([]);
                }
            });
        }

        function initializeDataTable(data) {
            if ($.fn.DataTable.isDataTable('#ordersTable')) {
                $('#ordersTable').DataTable().destroy();
            }

            ordersDataTable = $('#ordersTable').DataTable({
                data: data,
                columns: [
                    { title: 'S.No' },
                    { title: 'Date' },
                    { title: 'JD Code' },
                    { title: 'Site Name' },
                    { title: 'Type' },
                    { title: 'Depot' },
                    { title: 'Order Type' },
                    { title: 'Total Amount' },
                    { title: 'Ledger Amount' },
                    { title: 'Status', orderable: false, searchable: false },
                    { title: 'Push Status', orderable: false, searchable: false },
                    { title: 'Product' },
                    { title: 'Rate' },
                    { title: 'Quantity' },
                    { title: 'Bill Amount' }
                ],
                dom: 'Bfrtip',
                buttons: [
                    { extend: 'copy', text: '<i class="fa-regular fa-copy"></i> Copy', className: 'toolbar-btn', exportOptions: { columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14] } },
                    { extend: 'excelHtml5', text: '<i class="fa-regular fa-file-excel"></i> Excel', className: 'toolbar-btn', exportOptions: { columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14] }, title: 'Forwarded_Orders' },
                    { extend: 'csvHtml5', text: '<i class="fa-regular fa-file-csv"></i> CSV', className: 'toolbar-btn', exportOptions: { columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14] }, title: 'Forwarded_Orders' },
                    { extend: 'pdfHtml5', text: '<i class="fa-regular fa-file-pdf"></i> PDF', className: 'toolbar-btn', exportOptions: { columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14] }, title: 'All Forwarded Orders', orientation: 'landscape', pageSize: 'A4' },
                    { extend: 'print', text: '<i class="fa-solid fa-print"></i> Print', className: 'toolbar-btn', exportOptions: { columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14] } }
                ],
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100],
                ordering: true,
                order: [[0, 'asc']],
                language: {
                    search: '',
                    searchPlaceholder: 'Search orders...',
                    emptyTable: '<div class="text-center py-8 text-gray-500"><i class="fa-solid fa-forward text-2xl block mb-2"></i>No forwarded orders found</div>',
                    info: 'Showing _START_ to _END_ of _TOTAL_ entries',
                    infoEmpty: 'Showing 0 to 0 of 0 entries',
                    infoFiltered: '(filtered from _MAX_ total entries)'
                },
                drawCallback: function() {
                    $('.dt-buttons .dt-button').addClass('toolbar-btn');
                    $('#ordersTable tbody').off('click', '.badge').on('click', '.badge', function() {
                        var id = $(this).attr('id');
                        var text = $(this).text().trim();
                        if (text === 'Pending' || text === 'Insuficient Balance') {
                            openApprovedModal(id);
                        }
                    });
                },
                initComplete: function() {
                    const buttonsContainer = $('#exportButtonsContainer');
                    $('.dt-buttons').appendTo(buttonsContainer);
                    $('#ordersTable_filter').appendTo('#tableSearchContainer');
                    populateColumnDropdown();
                }
            });
        }

        function populateColumnDropdown() {
            const container = $('#columnListItems');
            container.empty();
            columnConfig.forEach(function(col) {
                let isVisible = true;
                try { isVisible = ordersDataTable.column(col.idx).visible(); } catch(e) { isVisible = true; }
                const item = `
                    <div class="dropdown-item" onclick="toggleColumnVisibility(${col.idx})">
                        <input type="checkbox" id="col-checkbox-${col.idx}" ${isVisible ? 'checked' : ''} onclick="event.stopPropagation(); toggleColumnVisibility(${col.idx})">
                        <span class="column-label">${col.label}</span>
                    </div>
                `;
                container.append(item);
            });
        }

        function toggleColumnVisibility(colIdx) {
            if (!ordersDataTable) return;
            try {
                const isVisible = ordersDataTable.column(colIdx).visible();
                ordersDataTable.column(colIdx).visible(!isVisible);
                $(`#col-checkbox-${colIdx}`).prop('checked', !isVisible);
            } catch(e) { console.warn('Column visibility error:', e); }
        }

        function selectAllColumns() {
            if (!ordersDataTable) return;
            try {
                columnConfig.forEach(function(col) {
                    if (!ordersDataTable.column(col.idx).visible()) {
                        ordersDataTable.column(col.idx).visible(true);
                    }
                    $(`#col-checkbox-${col.idx}`).prop('checked', true);
                });
                showToast('All columns selected!', 'success');
            } catch(e) { showToast('Error selecting columns', 'error'); }
        }

        function deselectAllColumns() {
            if (!ordersDataTable) return;
            try {
                columnConfig.forEach(function(col) {
                    if (ordersDataTable.column(col.idx).visible()) {
                        ordersDataTable.column(col.idx).visible(false);
                    }
                    $(`#col-checkbox-${col.idx}`).prop('checked', false);
                });
                showToast('All columns deselected!', 'success');
            } catch(e) { showToast('Error deselecting columns', 'error'); }
        }

        function toggleColumnDropdown() {
            const menu = $('#columnDropdownMenu');
            menu.toggleClass('show');
            if (menu.hasClass('show')) { populateColumnDropdown(); }
        }

        function closeColumnDropdown() {
            $('#columnDropdownMenu').removeClass('show');
        }

        function openApprovedModalWithId(id) {
            $('#orderApprovalId').val(id);
            if (confirm("Are you sure you want to Push this order?")) {
                var formData = new FormData();
                formData.append('order_approval', id);
                formData.append('approved_order_status', '1');
                formData.append('user_id', '1');

                $.ajax({
                    url: API_BASE_URL + 'update/pushed_forward_orders.php',
                    cache: false,
                    contentType: false,
                    processData: false,
                    method: "POST",
                    data: formData,
                    beforeSend: function() {
                        showToast('Processing...', 'success');
                    },
                    success: function(data) {
                        console.log(data);
                        if (data != 1) {
                            Swal.fire(
                                'Server Error!',
                                'Record Not Updated',
                                'error'
                            );
                        } else {
                            Swal.fire(
                                'Success!',
                                'Order Pushed Successfully',
                                'success'
                            );
                            location.reload();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log('Error:', error);
                        console.log('Status:', status);
                        console.log('Response:', xhr.responseText);
                        Swal.fire(
                            'Error!',
                            'There was an error processing your request',
                            'error'
                        );
                    }
                });
            }
        }

        function openApprovedModal(id) {
            $('#orderApprovalId').val(id);
            $('#approvedOrderModal').removeClass('hidden').addClass('flex');
            setTimeout(function() {
                $('#approvedOrderModal').removeClass('opacity-0');
                $('#approvedOrderModal .transform').removeClass('scale-95').addClass('scale-100');
            }, 10);
        }

        function closeApprovedModal() {
            $('#approvedOrderModal').addClass('opacity-0');
            $('#approvedOrderModal .transform').removeClass('scale-100').addClass('scale-95');
            setTimeout(function() {
                $('#approvedOrderModal').addClass('hidden').removeClass('flex');
            }, 300);
        }

        function saveApprovedOrder(event) {
            event.preventDefault();
            const formData = new FormData(document.getElementById('approvedOrderForm'));
            $.ajax({
                url: API_BASE_URL + 'update/pushed_forward_orders.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(response) {
                    if (response === 1) {
                        showToast('Order pushed successfully!', 'success');
                        closeApprovedModal();
                        fetchtable();
                    } else {
                        showToast('Failed to push order.', 'error');
                    }
                },
                error: function() {
                    showToast('Error processing request.', 'error');
                }
            });
        }

        function saveInsufficientOrder(event) {
            event.preventDefault();
            const formData = new FormData(document.getElementById('insufficientForm'));
            $.ajax({
                url: API_BASE_URL + 'update/send_special_approval.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(response) {
                    if (response === 1) {
                        showToast('Action completed successfully!', 'success');
                        closeInsufficientModal();
                        fetchtable();
                    } else {
                        showToast('Failed to complete action.', 'error');
                    }
                },
                error: function() {
                    showToast('Error processing request.', 'error');
                }
            });
        }

        function get_orders_log(id) {
            $.ajax({
                url: API_BASE_URL + 'get/get_order_backlog.php?key=03201232927&order_id=' + id,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    const container = $('#orderLogsContainer');
                    container.empty();

                    if (response && response.length > 0) {

                        $('#backlogHeaderSubtitle').text(response.length + ' activity ' + (response.length === 1 ? 'entry' : 'entries') + ' recorded for this order');

                        let html = `
                            <div class="backlog-progress-strip">
                                <i class="fa-solid fa-chart-simple"></i>
                                <span class="progress-text"><strong>${response.length}</strong> ${response.length === 1 ? 'step' : 'steps'} tracked in this order's lifecycle</span>
                            </div>
                            <div class="backlog-start-end">
                                <div class="marker">
                                    <span class="dot start"></span>
                                    START
                                </div>
                                <div class="line-dashed"></div>
                                <div class="marker">
                                    <span class="dot end"></span>
                                    END
                                </div>
                            </div>
                            <div class="backlog-timeline">
                        `;

                        var lastIndex = response.length - 1;
                        $.each(response, function(idx, item) {
                            var statusClass = '';
                            var statusBadgeClass = 'status-created';
                            var statusText = item.status_value || 'Unknown';
                            var isLatest = (idx === lastIndex);

                            if (item.status == 0) {
                                statusClass = 'pending';
                                statusBadgeClass = 'status-created';
                            } else if (item.status == 1) {
                                statusClass = 'completed';
                                statusBadgeClass = 'status-approved';
                            } else if (item.status == 2) {
                                statusClass = 'completed';
                                statusBadgeClass = 'status-complete';
                            } else if (item.status == 3) {
                                statusClass = 'cancelled';
                                statusBadgeClass = 'status-cancel';
                            } else if (item.status == 4) {
                                statusClass = 'pending';
                                statusBadgeClass = 'status-special';
                            } else if (item.status == 5) {
                                statusClass = 'pending';
                                statusBadgeClass = 'status-asm';
                            } else if (item.status == 6) {
                                statusClass = 'completed';
                                statusBadgeClass = 'status-processed';
                            }

                            var displayText = statusText;
                            if (statusText === 'Order created') displayText = 'Order Created';
                            else if (statusText === 'Processed') displayText = 'Processed';
                            else if (statusText === 'Forwarded') displayText = 'Forwarded';
                            else if (statusText === 'Pushed') displayText = 'Pushed';
                            else if (statusText === 'Approved') displayText = 'Approved';
                            else if (statusText === 'Complete') displayText = 'Completed';
                            else if (statusText === 'Cancel') displayText = 'Cancelled';
                            else if (statusText === 'Special Approval') displayText = 'Special Approval';
                            else if (statusText === 'ASM Approved') displayText = 'ASM Approved';

                            var icon = 'fa-regular fa-clock';
                            if (statusText === 'Order created' || statusText === 'Order Created') icon = 'fa-regular fa-file-lines';
                            else if (statusText === 'Processed') icon = 'fa-regular fa-circle-check';
                            else if (statusText === 'Forwarded') icon = 'fa-regular fa-paper-plane';
                            else if (statusText === 'Pushed') icon = 'fa-regular fa-arrow-right';
                            else if (statusText === 'Approved') icon = 'fa-regular fa-thumbs-up';
                            else if (statusText === 'Complete' || statusText === 'Completed') icon = 'fa-regular fa-circle-check';
                            else if (statusText === 'Cancel' || statusText === 'Cancelled') icon = 'fa-regular fa-circle-xmark';
                            else if (statusText === 'Special Approval') icon = 'fa-regular fa-star';
                            else if (statusText === 'ASM Approved') icon = 'fa-regular fa-user-check';

                            html += `
                                <div class="backlog-item ${statusClass}${isLatest ? ' is-latest' : ''}">
                                    <div class="node-icon">
                                        <i class="${icon}"></i>
                                    </div>
                                    <div class="item-content">
                                        <div class="item-header">
                                            <div class="title-block">
                                                <span class="item-title">${displayText}</span>
                                                ${isLatest ? '<span class="latest-pill">Current</span>' : ''}
                                            </div>
                                            <span class="status-badge ${statusBadgeClass}">${displayText}</span>
                                        </div>
                                        ${item.created_at ? `<div class="item-datetime"><i class="fa-regular fa-clock"></i>${item.created_at}</div>` : ''}
                                        <div class="item-details">
                                            <div class="detail">
                                                <i class="fa-regular fa-user"></i>
                                                <span class="label">Action By:</span>
                                                <span class="value">${item.name || 'N/A'}</span>
                                            </div>
                                            ${item.description ? `
                                            <div class="detail note-detail">
                                                <i class="fa-regular fa-message"></i>
                                                <span class="label">Note:</span>
                                                <span class="value">${item.description}</span>
                                            </div>
                                            ` : ''}
                                        </div>
                                    </div>
                                </div>
                            `;
                        });

                        html += `</div>`;
                        container.html(html);
                    } else {
                        $('#backlogHeaderSubtitle').text("Full history of this order's journey");
                        container.html(`
                            <div class="backlog-empty">
                                <div class="empty-icon-wrap">
                                    <i class="fa-regular fa-inbox"></i>
                                </div>
                                <p>No activity logs found</p>
                                <span>This order doesn't have any recorded activity yet</span>
                            </div>
                        `);
                    }

                    openBacklogModal();
                },
                error: function() {
                    showToast('Failed to load backlog.', 'error');
                }
            });
        }

        function openInsufficientModal(id) {
            $('#specialApprovalId').val(id);
            $('#insufficientModal').removeClass('hidden').addClass('flex');
            setTimeout(function() {
                $('#insufficientModal').removeClass('opacity-0');
                $('#insufficientModal .transform').removeClass('scale-95').addClass('scale-100');
            }, 10);
        }

        function closeInsufficientModal() {
            $('#insufficientModal').addClass('opacity-0');
            $('#insufficientModal .transform').removeClass('scale-100').addClass('scale-95');
            setTimeout(function() {
                $('#insufficientModal').addClass('hidden').removeClass('flex');
            }, 300);
        }

        function openBacklogModal() {
            $('#backlogModal').removeClass('hidden').addClass('flex');
            setTimeout(function() {
                $('#backlogModal').removeClass('opacity-0');
                $('#backlogModal .transform').removeClass('scale-95').addClass('scale-100');
            }, 10);
        }

        function closeBacklogModal() {
            $('#backlogModal').addClass('opacity-0');
            $('#backlogModal .transform').removeClass('scale-100').addClass('scale-95');
            setTimeout(function() {
                $('#backlogModal').addClass('hidden').removeClass('flex');
            }, 300);
        }

        function openProductDetailModal() {
            $('#productDetailModal').removeClass('hidden').addClass('flex');
            setTimeout(function() {
                $('#productDetailModal').removeClass('opacity-0');
                $('#productDetailModal .transform').removeClass('scale-95').addClass('scale-100');
            }, 10);
        }

        function closeProductDetailModal() {
            $('#productDetailModal').addClass('opacity-0');
            $('#productDetailModal .transform').removeClass('scale-100').addClass('scale-95');
            setTimeout(function() {
                $('#productDetailModal').addClass('hidden').removeClass('flex');
            }, 300);
        }

        function view_order(id) {
            if (!id) return;
            $.ajax({
                url: API_BASE_URL + 'get/get_main_sub_orders.php?key=03201232927&id=' + id,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response && response.length > 0) {
                        if ($.fn.DataTable.isDataTable('#productDetailTable')) {
                            $('#productDetailTable').DataTable().destroy();
                        }
                        const data = response.map(function(item, idx) {
                            return [
                                idx + 1,
                                item.date || '',
                                item.sap_no || '',
                                item.name || '',
                                item.product_name || '',
                                item.rate || '',
                                parseFloat(item.quantity).toLocaleString(),
                                item.delivery_based || '',
                                item.consignee_name || '',
                                parseFloat(item.amount).toLocaleString()
                            ];
                        });
                        productDetailDataTable = $('#productDetailTable').DataTable({
                            data: data,
                            columns: [
                                { title: 'S.No' },
                                { title: 'Date' },
                                { title: 'JD Code' },
                                { title: 'Site Name' },
                                { title: 'Product Type' },
                                { title: 'Rate' },
                                { title: 'Qty' },
                                { title: 'Delivered' },
                                { title: 'Depot' },
                                { title: 'Order Amount' }
                            ],
                            dom: 'Bfrtip',
                            buttons: [
                                { extend: 'copy', text: '<i class="fa-regular fa-copy"></i> Copy' },
                                { extend: 'excelHtml5', text: '<i class="fa-regular fa-file-excel"></i> Excel' },
                                { extend: 'pdfHtml5', text: '<i class="fa-regular fa-file-pdf"></i> PDF', orientation: 'landscape', pageSize: 'A4' }
                            ],
                            pageLength: 10,
                            language: { emptyTable: 'No products found' }
                        });
                        openProductDetailModal();
                    } else {
                        showToast('No products found for this order.', 'error');
                    }
                },
                error: function() {
                    showToast('Failed to load order details.', 'error');
                }
            });
        }

        $(document).on('keydown', function(e) {
            if (e.key === 'Escape') {
                closeApprovedModal();
                closeInsufficientModal();
                closeBacklogModal();
                closeProductDetailModal();
                closeColumnDropdown();
            }
        });

        $(document).on('click', '#approvedOrderModal, #insufficientModal, #backlogModal, #productDetailModal', function(e) {
            if (e.target === this) {
                if (this.id === 'approvedOrderModal') closeApprovedModal();
                else if (this.id === 'insufficientModal') closeInsufficientModal();
                else if (this.id === 'backlogModal') closeBacklogModal();
                else if (this.id === 'productDetailModal') closeProductDetailModal();
            }
        });
    </script>

</body>

</html>