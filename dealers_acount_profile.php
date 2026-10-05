<?php
// Hascol OMC Operations Command Center - Dealer Account Profile
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hascol OMC - Dealer Profile</title>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/crypto-js.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Leaflet CSS & JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        // Dark mode detection
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
            --modal-overlay: rgba(15, 23, 42, 0.45);
            --btn-secondary-bg: #e2e8f0;
            --btn-secondary-text: #334155;
            --btn-secondary-hover-bg: #cbd5e1;
            --btn-secondary-hover-text: #0f2440;
            --toolbar-btn-bg: #ffffff;
            --modal-footer-bg: #f8fafc;
            --banner-gradient: linear-gradient(135deg, #0c1a3a 0%, #1a2a4a 50%, #2a3a5a 100%);
            --cover-overlay: rgba(0, 0, 0, 0.18);
            --chart-grid-color: rgba(0, 0, 0, 0.06);
            --chart-text-color: #64748b;
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
            --modal-overlay: rgba(6, 11, 19, 0.85);
            --btn-secondary-bg: #1a2635;
            --btn-secondary-text: #94a3b8;
            --btn-secondary-hover-bg: #1f2a3d;
            --btn-secondary-hover-text: #ffffff;
            --toolbar-btn-bg: #060b13;
            --modal-footer-bg: #0a121c;
            --banner-gradient: linear-gradient(135deg, #060b13 0%, #0d1a2a 50%, #1a2635 100%);
            --cover-overlay: rgba(0, 0, 0, 0.35);
            --chart-grid-color: rgba(255, 255, 255, 0.06);
            --chart-text-color: #94a3b8;
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
            border-radius: 0.75rem;
            transition: background-color .25s ease, border-color .25s ease;
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

        /* ===== Dealer Cover / Banner ===== */
        .dealer-cover {
            height: 220px;
            position: relative;
            overflow: hidden;
            background: #dfe5ec;
            isolation: isolate;
        }

        .dealer-cover::before {
            content: "";
            position: absolute;
            inset: -22px;
            background-image: url("assets/images/banner.png");
            background-size: cover;
            background-position: center;
            filter: blur(16px);
            transform: scale(1.08);
            opacity: .42;
            z-index: -2;
        }

        .dealer-cover::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(255, 255, 255, .03), var(--cover-overlay));
            z-index: 1;
            pointer-events: none;
        }

        html.dark-mode .dealer-cover::after {
            background: linear-gradient(180deg, rgba(0, 0, 0, .03), rgba(0, 0, 0, .35));
        }

        .dealer-cover img {
            position: relative;
            z-index: 0;
            width: 100%;
            height: 100%;
            object-fit: contain;
            object-position: center;
            display: block;
            filter: blur(.15px) contrast(1.01) saturate(1.02);
        }

        .cover-chip {
            position: absolute;
            z-index: 2;
            left: 20px;
            top: 18px;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 6px 9px;
            border: 1px solid rgba(255, 255, 255, .24);
            border-radius: 8px;
            background: rgba(0, 0, 0, .22);
            color: #fff;
            backdrop-filter: blur(12px);
            font-size: 9.5px;
            font-weight: 700;
            letter-spacing: .04em;
            text-transform: uppercase;
        }

        .cover-chip i {
            color: #7cf29a;
            font-size: 7px
        }

        /* Profile Avatar */
        .profile-avatar-wrapper {
            position: relative;
            margin-top: -65px;
            padding: 0 32px;
            display: flex;
            align-items: flex-end;
            gap: 28px;
            min-height: 120px;
        }

        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 5px solid var(--bg-panel);
            flex-shrink: 0;
            background: var(--bg-panel);
            box-shadow: 0 4px 25px rgba(0, 0, 0, 0.25);
        }

        .profile-name-section {
            flex: 1;
            padding-bottom: 12px;
        }

        .profile-name-section h3 {
            font-size: 18px;
            font-weight: 700;
            color: var(--text-heading);
            letter-spacing: 0.5px;
        }

        .profile-name-section .location {
            font-size: 12px;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 4px;
        }

        .profile-name-section .location i {
            font-size: 15px;
            color: #1d4ed8;
        }

        /* Details Sidebar */
        .details-sidebar {
            padding: 16px 20px;
        }

        .details-sidebar .detail-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid var(--border-color);
            transition: background-color 0.2s;
        }

        .details-sidebar .detail-item:last-child {
            border-bottom: none;
        }

        .details-sidebar .detail-item:hover {
            background-color: var(--hover-bg);
            margin: 0 -8px;
            padding: 10px 8px;
            border-radius: 6px;
        }

        .details-sidebar .detail-item .detail-label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: var(--text-muted);
            font-weight: 600;
        }

        .details-sidebar .detail-item .detail-label i {
            font-size: 13px;
            width: 18px;
            color: #1d4ed8;
        }

        .details-sidebar .detail-item .value {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-heading);
            text-align: right;
        }

        .details-sidebar .detail-item .value.ledger {
            color: #1d4ed8;
        }

        .details-sidebar .detail-item .value.payable {
            color: #dc2626;
        }

        .backlog-icon {
            cursor: pointer;
            font-size: 16px;
            color: #1d4ed8;
            transition: color 0.2s;
            margin-left: 6px;
            flex-shrink: 0;
        }

        .backlog-icon:hover {
            color: #2563eb;
        }

        .update-ledger-icon {
            cursor: pointer;
            font-size: 16px;
            color: #1d4ed8;
            transition: color 0.2s;
            margin-left: 8px;
            flex-shrink: 0;
        }

        .update-ledger-icon:hover {
            color: #2563eb;
        }

        /* Map Container */
        #map-container {
            width: 100%;
            height: 340px;
            border-radius: 0 0 0.75rem 0.75rem;
        }

        /* Chart Container - Premium */
        #transactionChart {
            width: 100% !important;
            height: 280px !important;
            max-height: 280px;
        }

        .chart-wrapper {
            position: relative;
            padding: 8px 4px 4px 4px;
        }

        /* Buttons */
        .btn-primary {
            background-color: #1d4ed8;
            color: #ffffff;
            padding: 6px 16px;
            border-radius: 0.25rem;
            border: none;
            font-size: 11px;
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
            padding: 6px 16px;
            border-radius: 0.25rem;
            border: none;
            font-size: 11px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s, color 0.2s;
        }

        .btn-secondary:hover {
            background-color: var(--btn-secondary-hover-bg);
            color: var(--btn-secondary-hover-text);
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

        /* Badge */
        .badge {
            padding: 2px 10px;
            border-radius: 9999px;
            font-size: 9px;
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

        /* DataTables Override */
        .dataTables_wrapper .dataTables_filter {
            float: right;
            margin-bottom: 12px;
        }

        .dataTables_wrapper .dataTables_filter input {
            background-color: var(--input-bg);
            border: 1px solid var(--border-color);
            border-radius: 0.25rem;
            color: var(--text-body);
            padding: 6px 12px;
            font-size: 11px;
            margin-left: 6px;
            outline: none;
            min-width: 200px;
        }

        .dataTables_wrapper .dataTables_filter input:focus {
            border-color: #1d4ed8;
            box-shadow: 0 0 0 2px rgba(29, 78, 216, 0.2);
        }

        .dataTables_wrapper .dataTables_filter input::placeholder {
            color: var(--text-muted);
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

        .dt-buttons {
            float: left;
            margin-bottom: 12px;
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
        }

        .dt-buttons .dt-button {
            background: var(--btn-secondary-bg) !important;
            color: var(--btn-secondary-text) !important;
            padding: 4px 12px !important;
            border-radius: 4px !important;
            border: 1px solid var(--border-color) !important;
            font-size: 10px !important;
            font-weight: 500 !important;
            cursor: pointer !important;
            transition: all 0.2s !important;
        }

        .dt-buttons .dt-button:hover {
            background: var(--btn-secondary-hover-bg) !important;
            color: var(--btn-secondary-hover-text) !important;
        }

        /* Section Title */
        .section-title {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-heading);
            margin-bottom: 8px;
        }

        .section-title i {
            margin-right: 6px;
            color: #1d4ed8;
        }

        /* ===== MODAL FORM STYLES ===== */
        .modal-form-label {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-muted);
            font-weight: 600;
            display: block;
            margin-bottom: 4px;
        }

        .modal-form-input {
            background-color: var(--input-bg);
            border: 1px solid var(--border-color);
            border-radius: 0.25rem;
            color: var(--text-body);
            padding: 8px 12px;
            font-size: 12px;
            width: 100%;
            outline: none;
            transition: border-color 0.2s;
        }

        .modal-form-input:focus {
            border-color: #1d4ed8;
            box-shadow: 0 0 0 2px rgba(29, 78, 216, 0.2);
        }

        .modal-form-input::placeholder {
            color: var(--text-muted);
        }

        /* ============================================ */
        /* LEDGER BACKLOG MODAL - Premium Timeline      */
        /* ============================================ */
        #ledger_backlog_modal {
            position: fixed !important;
            z-index: 99999 !important;
            inset: 0 !important;
            background: rgba(15, 23, 42, 0.55) !important;
            backdrop-filter: blur(4px) !important;
            display: none;
            align-items: center !important;
            justify-content: center !important;
        }

        #ledger_backlog_modal.visible {
            display: flex !important;
        }

        .cl-modal-box {
            background: var(--bg-panel);
            border-radius: 16px;
            width: 94%;
            max-width: 660px;
            max-height: 88vh;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            box-shadow: 0 30px 80px rgba(16, 24, 40, .38);
            border: 1px solid var(--border-color);
            position: relative;
            z-index: 100000;
        }

        .cl-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            padding: 18px 22px;
            border-bottom: 1px solid var(--border-color);
            background: var(--bg-panel);
            flex-shrink: 0;
        }

        .cl-header-left {
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 0;
        }

        .cl-header-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--hover-bg);
            color: #1d4ed8;
            font-size: 15px;
            flex-shrink: 0;
        }

        .cl-header-text h5 {
            margin: 0;
            color: var(--text-heading);
            font-family: 'Inter', sans-serif;
            font-size: 15.5px;
            font-weight: 750;
            letter-spacing: -.015em;
            line-height: 1.2;
        }

        .cl-header-text span {
            display: block;
            margin-top: 2px;
            color: var(--text-muted);
            font-size: 10.5px;
            font-weight: 550;
        }

        .cl-modal-close {
            background: none;
            border: none;
            font-size: 17px;
            color: var(--text-muted);
            cursor: pointer;
            padding: 6px 9px;
            border-radius: 8px;
            flex-shrink: 0;
            transition: color .15s ease, background-color .15s ease;
        }

        .cl-modal-close:hover {
            color: #ef4444;
            background: #ef444420;
        }

        #ledgerLogsContainer {
            padding: 24px 26px 20px;
            overflow-y: auto;
            flex: 1;
            background: var(--bg-body);
            max-height: 60vh;
        }

        #ledgerLogsContainer::-webkit-scrollbar {
            width: 6px;
        }

        #ledgerLogsContainer::-webkit-scrollbar-thumb {
            background: var(--border-color);
            border-radius: 4px;
        }

        .cl-timeline {
            position: relative;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .cl-timeline::before {
            content: "";
            position: absolute;
            top: 32px;
            bottom: 10px;
            left: 26px;
            width: 2px;
            background: var(--border-color);
            z-index: 0;
        }

        .cl-start-row {
            display: flex;
            justify-content: flex-start;
            padding-bottom: 18px;
        }

        .cl-start-badge {
            position: relative;
            z-index: 1;
            width: 58px;
            height: 58px;
            margin-left: -3px;
            border-radius: 50%;
            background: linear-gradient(180deg, #1d4ed8, #2563eb);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10.5px;
            font-weight: 800;
            letter-spacing: .06em;
            text-transform: uppercase;
            box-shadow: 0 8px 18px rgba(29, 78, 216, .32), 0 0 0 5px var(--bg-panel);
        }

        .cl-end-row {
            display: flex;
            justify-content: flex-start;
            padding-top: 4px;
        }

        .cl-end-badge {
            position: relative;
            z-index: 1;
            width: 52px;
            height: 52px;
            margin-left: 0;
            border-radius: 50%;
            background: linear-gradient(180deg, #1d4ed8, #2563eb);
            border: 2px solid var(--border-color);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 9.5px;
            font-weight: 800;
            letter-spacing: .06em;
            text-transform: uppercase;
            box-shadow: 0 0 0 5px var(--bg-panel);
        }

        .cl-event {
            position: relative;
            display: flex;
            align-items: flex-start;
            gap: 14px;
            padding-bottom: 20px;
        }

        .cl-event:last-of-type {
            padding-bottom: 0;
        }

        .cl-event-icon {
            position: relative;
            z-index: 1;
            flex-shrink: 0;
            width: 30px;
            height: 30px;
            border-radius: 8px;
            background: var(--bg-panel);
            border: 1.5px solid #1d4ed8;
            color: #1d4ed8;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            margin-top: 6px;
            box-shadow: 0 0 0 4px var(--bg-body);
        }

        .cl-event-dot {
            position: absolute;
            top: 20px;
            left: 26px;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #1d4ed8;
            border: 2px solid var(--bg-panel);
            box-shadow: 0 0 0 3px rgba(29, 78, 216, .2);
            transform: translateX(-50%);
            z-index: 1;
        }

        .cl-content {
            position: relative;
            flex: 1;
            min-width: 0;
            padding-right: 46px;
        }

        .cl-card {
            background: var(--bg-body);
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 12px 16px;
            transition: box-shadow .18s ease, border-color .18s ease, transform .18s ease;
        }

        .cl-card:hover {
            box-shadow: 0 10px 30px rgba(0, 0, 0, .07);
            border-color: rgba(29, 78, 216, .25);
            transform: translateY(-1px);
        }

        .cl-card p {
            margin: 0 0 7px;
            font-size: 11.5px;
            color: var(--text-muted);
            line-height: 1.5;
        }

        .cl-card p:last-child {
            margin-bottom: 0;
        }

        .cl-card p.cl-amount {
            font-weight: 700;
            color: var(--text-heading);
            font-size: 12px;
        }

        .cl-card p.cl-amount span {
            color: #1d4ed8;
            font-weight: 750;
        }

        .cl-card p i {
            width: 13px;
            margin-right: 6px;
            color: var(--text-muted);
            font-size: 10px;
            text-align: center;
        }

        .cl-card .cl-note-text {
            margin-top: 9px;
            padding-top: 9px;
            border-top: 1px dashed var(--border-color);
        }

        .cl-ribbon {
            position: absolute;
            top: -6px;
            right: 0;
            z-index: 1;
            width: 44px;
            padding: 8px 4px 14px;
            background: linear-gradient(180deg, #1d4ed8, #2563eb);
            color: #fff;
            text-align: center;
            clip-path: polygon(0 0, 100% 0, 100% 82%, 50% 100%, 0 82%);
            box-shadow: 0 6px 14px rgba(29, 78, 216, .3);
        }

        .cl-ribbon .cl-ribbon-day {
            display: block;
            font-family: 'Inter', sans-serif;
            font-size: 16px;
            font-weight: 800;
            line-height: 1.1;
        }

        .cl-ribbon .cl-ribbon-mon {
            display: block;
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .03em;
            opacity: .9;
            margin-top: 1px;
        }

        .cl-empty-state,
        .cl-error-state {
            text-align: center;
            padding: 54px 16px;
            color: var(--text-muted);
        }

        .cl-empty-state i,
        .cl-error-state i {
            font-size: 36px;
            display: block;
            margin-bottom: 14px;
            opacity: .3;
        }

        .cl-error-state i {
            color: #ef4444;
            opacity: .75;
        }

        .cl-empty-state p,
        .cl-error-state p {
            margin: 0;
            font-size: 12px;
            font-weight: 600;
        }

        /* UPDATE LEDGER MODAL - Fixed Position */
        #updateLedgerModal {
            position: fixed !important;
            z-index: 99999 !important;
            inset: 0 !important;
            background: rgba(15, 23, 42, 0.55) !important;
            backdrop-filter: blur(4px) !important;
            display: none;
            align-items: center !important;
            justify-content: center !important;
        }

        #updateLedgerModal.visible {
            display: flex !important;
        }

        #updateLedgerModal .modal-panel {
            background: var(--bg-panel);
            border-radius: 16px;
            width: 94%;
            max-width: 500px;
            max-height: 90vh;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            box-shadow: 0 30px 80px rgba(16, 24, 40, .38);
            border: 1px solid var(--border-color);
            position: relative;
            z-index: 100000;
        }

        #updateLedgerModal .modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            padding: 18px 22px;
            border-bottom: 1px solid var(--border-color);
            background: var(--bg-panel);
            flex-shrink: 0;
        }

        #updateLedgerModal .modal-body {
            padding: 20px 22px;
            overflow-y: auto;
            flex: 1;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .dealer-cover {
                height: 150px;
            }

            .profile-avatar-wrapper {
                flex-direction: column;
                align-items: center;
                padding: 0 16px;
                margin-top: -50px;
                min-height: auto;
            }

            .profile-avatar {
                width: 90px;
                height: 90px;
            }

            .profile-name-section {
                text-align: center;
            }

            .profile-name-section h3 {
                font-size: 20px;
            }

            .profile-name-section .location {
                justify-content: center;
                font-size: 13px;
            }

            #map-container {
                height: 250px;
                border-radius: 0 0 0.75rem 0.75rem;
            }

            #transactionChart {
                height: 220px !important;
                max-height: 220px;
            }

            .details-sidebar .detail-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 2px;
            }

            .details-sidebar .detail-item .value {
                text-align: left;
            }

            .dt-buttons {
                float: none;
                justify-content: center;
            }

            .dataTables_wrapper .dataTables_filter {
                float: none;
                text-align: center;
            }
        }

        @media (max-width: 640px) {
            .cl-modal-box {
                max-width: 96%;
                max-height: 92vh;
            }

            #ledgerLogsContainer {
                padding: 18px 14px 16px;
            }

            .cl-timeline::before {
                left: 22px;
            }

            .cl-event-dot {
                left: 22px;
            }

            .cl-event-icon {
                width: 26px;
                height: 26px;
                font-size: 10px;
            }

            .cl-content {
                padding-right: 40px;
            }

            .cl-ribbon {
                width: 38px;
                padding: 6px 3px 11px;
            }

            .cl-ribbon .cl-ribbon-day {
                font-size: 14px;
            }

            .cl-start-badge {
                width: 48px;
                height: 48px;
                font-size: 9px;
            }

            .cl-end-badge {
                width: 42px;
                height: 42px;
                font-size: 8px;
            }

            #updateLedgerModal .modal-panel {
                max-width: 96%;
            }
        }

        @media (max-width: 480px) {
            .dealer-cover {
                height: 120px;
            }

            .profile-avatar {
                width: 75px;
                height: 75px;
            }

            .profile-name-section h3 {
                font-size: 17px;
            }

            .profile-name-section .location {
                font-size: 11px;
            }

            .cover-chip {
                font-size: 8px;
                padding: 4px 7px;
                left: 12px;
                top: 12px;
            }

            #transactionChart {
                height: 180px !important;
                max-height: 180px;
            }
        }
    </style>
</head>

<body class="flex h-screen overflow-hidden text-xs">

    <!-- SIDEBAR - Included from includes/sidebar.php -->
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
                    <h2 class="text-heading font-semibold text-base tracking-wide uppercase">Dealer Account Profile</h2>
                    <p class="text-[10px] text-gray-500">View dealer account details</p>
                </div>
                <div>
                </div>
            </div>

            <!-- PROFILE CARD -->
            <div class="panel-card overflow-hidden mb-4">
                <!-- Banner -->
                <div class="dealer-cover">
                    <img src="assets/images/banner.png" alt="Station" id="bannerImg">
                    <div class="cover-chip"><i class="fa-solid fa-circle"></i> Station profile</div>
                </div>

                <!-- Profile Info -->
                <div class="profile-avatar-wrapper">
                    <img src="assets/images/system.png" class="profile-avatar" alt="Logo">
                    <div class="profile-name-section">
                        <div class="flex items-center gap-3 flex-wrap">
                            <h3 id="dealerName">Loading...</h3>
                        </div>
                        <p class="location">
                            <i class="fa-solid fa-location-dot"></i>
                            <span id="dealerLocation">Loading...</span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- MAP & DETAILS SIDEBY SIDE -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <!-- Map -->
                <div class="md:col-span-2 panel-card overflow-hidden">
                    <div class="p-3 border-b" style="border-color: var(--border-color);">
                        <h4 class="section-title"><i class="fa-solid fa-map-location-dot"></i> Location Map</h4>
                    </div>
                    <div id="map-container"></div>
                </div>

                <!-- Details Sidebar -->
                <div class="md:col-span-1 panel-card overflow-hidden">
                    <div class="p-3 border-b" style="border-color: var(--border-color);">
                        <h4 class="section-title"><i class="fa-solid fa-circle-info"></i> Dealer Details</h4>
                    </div>
                    <div class="details-sidebar">
                        <div class="detail-item">
                            <span class="detail-label">
                                <i class="fa-solid fa-phone"></i> Phone
                            </span>
                            <span class="value" id="dealerPhone">-</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">
                                <i class="fa-solid fa-envelope"></i> Email
                            </span>
                            <span class="value" id="dealerEmail">-</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">
                                <i class="fa-solid fa-barcode"></i> JD Code
                            </span>
                            <span class="value" id="dealerSapNo">-</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">
                                <i class="fa-solid fa-wallet"></i> Ledger Balance
                            </span>
                            <span style="display: flex; align-items: center; gap: 6px;">
                                <span class="value ledger" id="dealerLedger" style="font-size: 14px; font-weight: 600; color: #1d4ed8;">-</span>
                                <i class="fa-solid fa-history backlog-icon" onclick="get_ledger_backlog()" title="View Ledger History"></i>
                                <i class="fas fa-undo update-ledger-icon" onclick="openUpdateLedgerModal()" title="Update Ledger"></i>
                            </span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">
                                <i class="fa-solid fa-circle-dollar"></i> Payable
                            </span>
                            <span class="value payable" id="dealerPayable">-</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CHART - Premium Area Chart -->
            <div class="panel-card overflow-hidden mb-4">
                <div class="p-3 border-b" style="border-color: var(--border-color);">
                    <h4 class="section-title"><i class="fa-solid fa-chart-area"></i> Transaction Overview</h4>
                </div>
                <div class="p-3">
                    <div class="chart-wrapper">
                        <canvas id="transactionChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- TRANSACTIONS TABLE - Full Width -->
            <div class="panel-card overflow-hidden">
                <div class="p-3 border-b" style="border-color: var(--border-color);">
                    <h4 class="section-title"><i class="fa-solid fa-clock-rotate-left"></i> Transaction History</h4>
                </div>
                <div class="p-3">
                    <table id="transactionsTable" class="display" style="width:100%;">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Date</th>
                                <th>Site Name</th>
                                <th>Transaction By</th>
                                <th>Type</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody id="transactionsBody">
                            <!-- Data will be populated by DataTables -->
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>

    <!-- TOAST NOTIFICATION -->
    <div id="toast" class="toast">
        <i class="fa-solid fa-check-circle mr-2"></i>
        <span id="toastMessage">Success!</span>
    </div>

    <!-- LEDGER BACKLOG MODAL -->
    <div id="ledger_backlog_modal" class="modal-overlay">
        <div class="cl-modal-box">
            <div class="cl-header">
                <div class="cl-header-left">
                    <span class="cl-header-icon"><i class="fa-solid fa-clock-rotate-left"></i></span>
                    <div class="cl-header-text">
                        <h5>Customer Ledger History</h5>
                        <span>Chronological record of ledger balance updates</span>
                    </div>
                </div>
                <button onclick="closeLedgerModal()" class="cl-modal-close" aria-label="Close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div id="ledgerLogsContainer">
                <ul class="cl-timeline" id="ledger_logs">
                    <li class="cl-empty-state" style="list-style:none;">
                        <i class="fa-solid fa-spinner fa-spin"></i>
                        <p>Loading ledger history...</p>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- UPDATE LEDGER MODAL - Fixed Position -->
    <div id="updateLedgerModal">
        <div class="modal-panel">
            <div class="modal-header">
                <h3 class="text-heading font-semibold text-sm">Update Ledger</h3>
                <button onclick="closeUpdateLedgerModal()" class="text-gray-400 hover:text-red-500 transition" style="background:none; border:none; font-size:20px; cursor:pointer;">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="ledgerForm">
                    <div class="mb-3">
                        <label class="modal-form-label">Ledger Amount</label>
                        <input type="number" id="ledgerAmount" class="modal-form-input" placeholder="Enter ledger amount" step="any" required>
                    </div>
                    <div class="mb-3">
                        <label class="modal-form-label">Date &amp; Time</label>
                        <input type="datetime-local" id="ledgerDateTime" class="modal-form-input" required>
                    </div>
                    <div class="mb-3">
                        <label class="modal-form-label">Description</label>
                        <textarea id="ledgerDescription" class="modal-form-input" rows="3" placeholder="Enter description" required></textarea>
                    </div>
                    <input type="hidden" id="ledgerOldValue">
                    <div class="flex justify-end gap-2 mt-4">
                        <button type="button" onclick="closeUpdateLedgerModal()" class="btn-secondary">Cancel</button>
                        <button type="submit" class="btn-primary" id="saveLedgerBtn">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

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

            // Get ID from URL and decrypt
            const urlParams = new URLSearchParams(window.location.search);
            const encryptedId = urlParams.get('id');

            if (encryptedId) {
                const key = 'Hamza Ansari';
                const iv = CryptoJS.lib.WordArray.random(16);
                const decryptedId = decryptId(encryptedId, key, iv);
                window.dealerId = decryptedId;

                // Load all data
                loadProfile(decryptedId);
                loadTransactions(decryptedId);
            } else {
                showToast('No dealer ID provided', 'error');
            }

            // Ledger Form Submit
            $('#ledgerForm').on('submit', function(e) {
                e.preventDefault();
                updateLedger();
            });
        });

        // API Configuration
        const API_BASE_URL = 'api/';
        const API_KEY = '03201232927';
        const USER_ID = '1';

        function decryptId(encryptedId, key, iv) {
            try {
                var decrypted = CryptoJS.AES.decrypt(encryptedId, key, { iv: iv });
                return decrypted.toString(CryptoJS.enc.Utf8);
            } catch(e) {
                return encryptedId;
            }
        }

        // Format Functions
        function formatCurrency(value) {
            if (!value) return '0';
            return parseFloat(value).toLocaleString();
        }

        function formatCurrencyShort(value) {
            if (!value) return '0';
            const num = parseFloat(value);
            if (num >= 1000000) return (num / 1000000).toFixed(1) + 'M';
            if (num >= 1000) return (num / 1000).toFixed(1) + 'K';
            return num.toLocaleString();
        }

        function formatDateTime(dateStr) {
            if (!dateStr) return '-';
            const date = new Date(dateStr);
            return date.toLocaleString('en-US', {
                year: 'numeric',
                month: 'short',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit',
                hour12: true
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

        // LEDGER BACKLOG MODAL FUNCTION
        function openLedgerModalBacklog() {
            const modal = $('#ledger_backlog_modal');
            modal.addClass('visible');
            modal.css('display', 'flex');
            setTimeout(function() {
                modal.css('opacity', '1');
            }, 10);
        }

        function closeLedgerModal() {
            const modal = $('#ledger_backlog_modal');
            modal.css('opacity', '0');
            setTimeout(function() {
                modal.removeClass('visible');
                modal.css('display', 'none');
            }, 300);
        }

        // Close backlog modal on outside click
        $(document).on('click', '#ledger_backlog_modal', function(e) {
            if (e.target === this) {
                closeLedgerModal();
            }
        });

        // Close backlog modal on ESC key
        $(document).on('keydown', function(e) {
            if (e.key === 'Escape') {
                const modal = $('#ledger_backlog_modal');
                if (modal.hasClass('visible')) {
                    closeLedgerModal();
                }
                if ($('#updateLedgerModal').hasClass('visible')) {
                    closeUpdateLedgerModal();
                }
            }
        });

        // UPDATE LEDGER MODAL FUNCTIONS
        function openUpdateLedgerModal() {
            const currentLedger = $('#dealerLedger').text().replace(/,/g, '') || '0';
            $('#ledgerOldValue').val(currentLedger);
            $('#ledgerAmount').val(currentLedger);
            
            // Set default datetime to now
            const now = new Date();
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const day = String(now.getDate()).padStart(2, '0');
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            $('#ledgerDateTime').val(`${year}-${month}-${day}T${hours}:${minutes}`);
            
            $('#ledgerDescription').val('');

            const modal = $('#updateLedgerModal');
            modal.addClass('visible');
            modal.css('display', 'flex');
            setTimeout(function() {
                modal.css('opacity', '1');
            }, 10);
        }

        function closeUpdateLedgerModal() {
            const modal = $('#updateLedgerModal');
            modal.css('opacity', '0');
            setTimeout(function() {
                modal.removeClass('visible');
                modal.css('display', 'none');
            }, 300);
        }

        // Close update ledger modal on outside click
        $(document).on('click', '#updateLedgerModal', function(e) {
            if (e.target === this) {
                closeUpdateLedgerModal();
            }
        });

        // Get Ledger Backlog 
        function get_ledger_backlog() {
            openLedgerModalBacklog();
            $('#ledger_logs').html(`
                <li class="cl-empty-state" style="list-style:none;">
                    <i class="fa-solid fa-spinner fa-spin"></i>
                    <p>Loading ledger history...</p>
                </li>
            `);

            const url = `${API_BASE_URL}/get/get_dealer_ledger_log.php?key=${API_KEY}&dealer_id=${window.dealerId}`;

            $.ajax({
                url: url,
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    console.log('Ledger Log Response:', response);
                    $('#ledger_logs').empty();

                    if (response && Array.isArray(response) && response.length > 0) {
                        $('#ledger_logs').append(`
                            <li class="cl-start-row">
                                <span class="cl-start-badge">Start</span>
                            </li>
                        `);

                        $.each(response, function(index, data) {
                            var originalDate = data.datetime || data.created_at;
                            var dateObject = new Date(originalDate);
                            var dayNum = isNaN(dateObject) ? '--' : dateObject.getDate();
                            var monShort = isNaN(dateObject) ? '' : dateObject.toLocaleString('en-US', { month: 'short' });

                            var ledgerValue = parseFloat(data.new_ledger || 0).toLocaleString('en-US', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });

                            var dateTime = data.datetime || 'N/A';
                            var recordTime = data.created_at || 'N/A';

                            $('#ledger_logs').append(`
                                <li class="cl-event">
                                    <span class="cl-event-dot"></span>
                                    <span class="cl-event-icon"><i class="fa-solid fa-briefcase"></i></span>
                                    <div class="cl-content">
                                        <div class="cl-card">
                                            <p class="cl-amount">Update Ledger : <span>${ledgerValue}</span></p>
                                            <p><i class="fa-regular fa-calendar"></i>Date : ${dateTime}</p>
                                            <p><i class="fa-regular fa-clock"></i>Record Time : ${recordTime}</p>
                                            ${data.type ? `<p><i class="fa-regular fa-tag"></i>Transaction Type : ${data.type}</p>` : ''}
                                            ${data.description ? `<p class="cl-note-text"><i class="fa-regular fa-comment"></i>${data.description}</p>` : ''}
                                        </div>
                                        <div class="cl-ribbon">
                                            <span class="cl-ribbon-day">${dayNum}</span>
                                            <span class="cl-ribbon-mon">${monShort}</span>
                                        </div>
                                    </div>
                                </li>
                            `);
                        });

                        $('#ledger_logs').append(`
                            <li class="cl-end-row">
                                <span class="cl-end-badge">End</span>
                            </li>
                        `);
                    } else {
                        $('#ledger_logs').html(`
                            <li class="cl-empty-state" style="list-style:none;">
                                <i class="fa-solid fa-clock-rotate-left"></i>
                                <p>No ledger history found</p>
                            </li>
                        `);
                    }
                },
                error: function(error) {
                    console.error('Error loading ledger history:', error);
                    $('#ledger_logs').html(`
                        <li class="cl-error-state" style="list-style:none;">
                            <i class="fa-solid fa-circle-exclamation"></i>
                            <p>Failed to load ledger history</p>
                        </li>
                    `);
                }
            });
        }

        // UPDATE LEDGER 
        function updateLedger() {
            const ledgerAmount = $('#ledgerAmount').val();
            const dateTime = $('#ledgerDateTime').val();
            const description = $('#ledgerDescription').val();
            const oldValue = $('#ledgerOldValue').val();

            if (!ledgerAmount || ledgerAmount.trim() === '') {
                showToast('Please enter ledger amount', 'error');
                return;
            }

            if (!dateTime) {
                showToast('Please select date and time', 'error');
                return;
            }

            if (!description || description.trim() === '') {
                showToast('Please enter description', 'error');
                return;
            }

            const url = `${API_BASE_URL}/update/update_dealers_ledger.php`;
            
            const saveBtn = $('#saveLedgerBtn');
            saveBtn.text('Saving...').prop('disabled', true);

            // IMPORTANT: FormData fields MUST match API expectations
            var formData = new FormData();
            formData.append('user_id', USER_ID);
            formData.append('ledger_amount', ledgerAmount);
            formData.append('ledger_old_value', oldValue);
            formData.append('dealer_id', window.dealerId);
            formData.append('ledger_description', description);
            formData.append('actione_time', dateTime);
            // NOTE: row_id is NOT used by the API - do NOT send it

            // Debug: Check what's being sent
            for (var pair of formData.entries()) {
                console.log(pair[0] + ': ' + pair[1]);
            }

            $.ajax({
                url: url,
                method: 'POST',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    console.log('Ledger Update Response:', response);
                    
                    if (response && response == 1) {
                        closeUpdateLedgerModal();
                        showToast('Ledger updated successfully!', 'success');
                        // Refresh profile data
                        loadProfile(window.dealerId);
                        // Refresh transactions
                        loadTransactions(window.dealerId);
                    } else {
                        showToast('Failed to update ledger: ' + response, 'error');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Ledger Update Error:', error);
                    console.error('Response Text:', xhr.responseText);
                    showToast('Server error: ' + error, 'error');
                },
                complete: function() {
                    saveBtn.text('Save').prop('disabled', false);
                }
            });
        }

        // Load Profile
        let map, marker;

        function loadProfile(id) {
            const url = `${API_BASE_URL}/get/dealer_profile.php?id=${id}&key=${API_KEY}`;

            $.ajax({
                url: url,
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    console.log('Profile Response:', response);

                    if (response && Array.isArray(response) && response.length > 0) {
                        const data = response[0];

                        const dealerName = data.name || 'N/A';
                        const location = data.location || 'N/A';

                        $('#dealerName').text(dealerName);
                        $('#dealerLocation').text(location);

                        $('#dealerPhone').text(data.contact || '-');
                        $('#dealerEmail').text(data.email || '-');
                        $('#dealerSapNo').text(data.sap_no || '-');
                        $('#dealerLedger').text(formatCurrency(data.acount));

                        const payable = data.acount < 0 ? data.acount : 0;
                        $('#dealerPayable').text(formatCurrency(payable));

                        if (data['co-ordinates']) {
                            const coords = data['co-ordinates'].split(',');
                            if (coords.length === 2) {
                                const lat = parseFloat(coords[0].trim());
                                const lng = parseFloat(coords[1].trim());
                                if (!isNaN(lat) && !isNaN(lng)) {
                                    initLeafletMap(lat, lng, dealerName);
                                }
                            }
                        }
                    }
                },
                error: function(error) {
                    console.error('Error loading profile:', error);
                    showToast('Failed to load profile', 'error');
                }
            });
        }

        // Leaflet Map
        function initLeafletMap(lat, lng, name) {
            const mapContainer = document.getElementById('map-container');

            if (map) {
                map.remove();
            }

            map = L.map('map-container').setView([lat, lng], 15);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap'
            }).addTo(map);

            const customIcon = L.divIcon({
                className: 'custom-marker',
                html: `<div style="background:#1d4ed8;width:18px;height:18px;border-radius:50%;border:3px solid white;box-shadow:0 2px 10px rgba(29,78,216,0.4);"></div>`,
                iconSize: [18, 18],
                iconAnchor: [9, 9]
            });

            marker = L.marker([lat, lng], { icon: customIcon }).addTo(map);
            marker.bindPopup(`<div class="text-sm font-medium">${name || 'Dealer Location'}</div>`).openPopup();

            setTimeout(() => {
                map.invalidateSize();
            }, 300);
        }

        // Load Transactions with DataTable
        let transactionsDataTable = null;

        function loadTransactions(id) {
            const url = `${API_BASE_URL}/get/get_dealer_ledger_log.php?key=${API_KEY}&dealer_id=${id}`;

            $.ajax({
                url: url,
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    console.log('Transactions Response:', response);

                    if (transactionsDataTable) {
                        transactionsDataTable.destroy();
                        transactionsDataTable = null;
                    }

                    $('#transactionsBody').empty();

                    let tableData = [];
                    const labels = [];
                    const amounts = [];

                    if (response && Array.isArray(response) && response.length > 0) {
                        $.each(response, function(index, data) {
                            const amount = parseFloat(data.new_ledger) || 0;
                            const row = [
                                (index + 1).toString(),
                                formatDateTime(data.datetime) || '-',
                                data.dealer_name || '-',
                                data.name || '-',
                                data.type || '-',
                                formatCurrency(amount)
                            ];
                            tableData.push(row);

                            labels.push(formatDateTime(data.datetime));
                            amounts.push(amount);
                        });

                        initPremiumChart(labels, amounts);
                    }

                    transactionsDataTable = $('#transactionsTable').DataTable({
                        data: tableData.length > 0 ? tableData : [],
                        columns: [
                            { title: 'S.No' },
                            { title: 'Date' },
                            { title: 'Site Name' },
                            { title: 'Transaction By' },
                            { title: 'Type' },
                            { title: 'Amount' }
                        ],
                        dom: 'Bfrtip',
                        buttons: [
                            {
                                extend: 'copy',
                                text: '<i class="fa-regular fa-copy"></i> Copy',
                                className: 'btn-secondary text-xs'
                            },
                            {
                                extend: 'csv',
                                text: '<i class="fa-solid fa-file-csv"></i> CSV',
                                className: 'btn-secondary text-xs',
                                title: 'Transaction History'
                            },
                            {
                                extend: 'excel',
                                text: '<i class="fa-solid fa-file-excel"></i> Excel',
                                className: 'btn-secondary text-xs',
                                title: 'Transaction History'
                            },
                            {
                                extend: 'pdf',
                                text: '<i class="fa-solid fa-file-pdf"></i> PDF',
                                className: 'btn-secondary text-xs',
                                title: 'Transaction History'
                            },
                            {
                                extend: 'print',
                                text: '<i class="fa-solid fa-print"></i> Print',
                                className: 'btn-secondary text-xs'
                            }
                        ],
                        pageLength: 10,
                        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, 'All']],
                        order: [[1, 'desc']],
                        responsive: true,
                        language: {
                            emptyTable: '<div class="text-center py-8" style="color: var(--text-muted);"><i class="fa-solid fa-clock-rotate-left text-2xl block mb-2"></i>No transactions found</div>',
                            search: 'Search:',
                            searchPlaceholder: 'Search transactions...',
                            info: 'Showing _START_ to _END_ of _TOTAL_ entries',
                            infoEmpty: 'Showing 0 to 0 of 0 entries',
                            infoFiltered: '(filtered from _MAX_ total entries)',
                            zeroRecords: 'No matching records found'
                        },
                        drawCallback: function() {
                            $('.dt-buttons .dt-button').each(function() {
                                $(this).addClass('btn-secondary text-xs');
                            });
                        }
                    });
                },
                error: function(error) {
                    console.error('Error loading transactions:', error);

                    if (transactionsDataTable) {
                        transactionsDataTable.destroy();
                        transactionsDataTable = null;
                    }

                    $('#transactionsBody').empty();

                    transactionsDataTable = $('#transactionsTable').DataTable({
                        data: [],
                        columns: [
                            { title: 'S.No' },
                            { title: 'Date' },
                            { title: 'Site Name' },
                            { title: 'Transaction By' },
                            { title: 'Type' },
                            { title: 'Amount' }
                        ],
                        dom: 'Bfrtip',
                        buttons: [
                            {
                                extend: 'copy',
                                text: '<i class="fa-regular fa-copy"></i> Copy',
                                className: 'btn-secondary text-xs'
                            },
                            {
                                extend: 'csv',
                                text: '<i class="fa-solid fa-file-csv"></i> CSV',
                                className: 'btn-secondary text-xs',
                                title: 'Transaction History'
                            },
                            {
                                extend: 'excel',
                                text: '<i class="fa-solid fa-file-excel"></i> Excel',
                                className: 'btn-secondary text-xs',
                                title: 'Transaction History'
                            },
                            {
                                extend: 'pdf',
                                text: '<i class="fa-solid fa-file-pdf"></i> PDF',
                                className: 'btn-secondary text-xs',
                                title: 'Transaction History'
                            },
                            {
                                extend: 'print',
                                text: '<i class="fa-solid fa-print"></i> Print',
                                className: 'btn-secondary text-xs'
                            }
                        ],
                        pageLength: 10,
                        language: {
                            emptyTable: '<div class="text-center py-8 text-red-500"><i class="fa-solid fa-circle-exclamation text-2xl block mb-2"></i>Failed to load transactions</div>',
                            search: 'Search:',
                            searchPlaceholder: 'Search transactions...'
                        },
                        drawCallback: function() {
                            $('.dt-buttons .dt-button').each(function() {
                                $(this).addClass('btn-secondary text-xs');
                            });
                        }
                    });
                }
            });
        }

        // Area Chart
        let chartInstance = null;

        function initPremiumChart(labels, data) {
            const ctx = document.getElementById('transactionChart').getContext('2d');

            if (chartInstance) {
                chartInstance.destroy();
            }

            let displayLabels = labels;
            let displayData = data;
            if (labels.length > 30) {
                const step = Math.ceil(labels.length / 30);
                displayLabels = labels.filter((_, i) => i % step === 0);
                displayData = data.filter((_, i) => i % step === 0);
            }

            const isDark = document.documentElement.classList.contains('dark-mode');
            const textColor = isDark ? '#94a3b8' : '#64748b';
            const gridColor = isDark ? 'rgba(255,255,255,0.06)' : 'rgba(0,0,0,0.06)';
            const lineColor = '#1d4ed8';
            const gradientFrom = 'rgba(29,78,216,0.25)';
            const gradientTo = 'rgba(29,78,216,0.02)';

            chartInstance = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: displayLabels,
                    datasets: [{
                        label: 'Transaction Amount',
                        data: displayData,
                        borderColor: lineColor,
                        backgroundColor: function(context) {
                            const chart = context.chart;
                            const { ctx, chartArea } = chart;
                            if (!chartArea) return gradientFrom;
                            const gradient = ctx.createLinearGradient(0, chartArea.top, 0, chartArea.bottom);
                            gradient.addColorStop(0, gradientFrom);
                            gradient.addColorStop(1, gradientTo);
                            return gradient;
                        },
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: lineColor,
                        pointBorderColor: isDark ? '#0d1520' : '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: displayData.length > 30 ? 2 : 4,
                        pointHoverRadius: 7,
                        pointHoverBackgroundColor: '#ffffff',
                        pointHoverBorderColor: lineColor,
                        pointHoverBorderWidth: 3,
                        borderWidth: 2.5
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: isDark ? '#0d1520' : '#ffffff',
                            titleColor: isDark ? '#e5e7eb' : '#0f2440',
                            bodyColor: isDark ? '#94a3b8' : '#64748b',
                            borderColor: isDark ? '#1a2635' : '#e2e8f0',
                            borderWidth: 1,
                            padding: 12,
                            cornerRadius: 8,
                            boxShadow: '0 4px 20px rgba(0,0,0,0.15)',
                            callbacks: {
                                label: function(context) {
                                    return 'Amount: ' + formatCurrency(context.parsed.y);
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            display: true,
                            grid: {
                                display: false,
                                color: gridColor
                            },
                            ticks: {
                                color: textColor,
                                font: {
                                    size: 9,
                                    family: 'Inter, sans-serif'
                                },
                                maxTicksLimit: 15,
                                maxRotation: 45,
                                minRotation: 30,
                                autoSkip: true
                            },
                            border: {
                                display: false
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: gridColor,
                                drawBorder: false
                            },
                            ticks: {
                                color: textColor,
                                font: {
                                    size: 9,
                                    family: 'Inter, sans-serif'
                                },
                                callback: function(value) {
                                    return formatCurrencyShort(value);
                                },
                                maxTicksLimit: 8
                            },
                            border: {
                                display: false
                            }
                        }
                    },
                    animation: {
                        duration: 1200,
                        easing: 'easeOutQuart'
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    },
                    elements: {
                        line: {
                            borderJoinStyle: 'round'
                        }
                    }
                }
            });

            const resizeObserver = new ResizeObserver(() => {
                if (chartInstance) {
                    chartInstance.resize();
                }
            });
            resizeObserver.observe(document.getElementById('transactionChart'));
        }

        // Resize handler for map
        $(window).on('resize', function() {
            if (map) {
                setTimeout(() => {
                    map.invalidateSize();
                }, 300);
            }
        });
    </script>

</body>

</html>