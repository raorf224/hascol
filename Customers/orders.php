<?php
require_once __DIR__ . '/../session/session.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <?php include '../includes/head.php'; ?>
    <title>Orders | Hascol Customer</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        (function () {
            const isDarkMode = localStorage.getItem('darkMode') === 'true';
            if (isDarkMode) document.documentElement.classList.add('dark-mode');
        })();
    </script>

    <script>
        tailwind.config = {
            theme: { extend: { fontFamily: { sans: ['Inter', 'sans-serif'] } } }
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
            --btn-secondary-bg: #e2e8f0;
            --btn-secondary-text: #334155;
            --btn-secondary-hover-bg: #cbd5e1;
            --btn-secondary-hover-text: #0f2440;
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
            --scrollbar-track: #060b13;
            --scrollbar-thumb: #1a2635;
            --btn-secondary-bg: #1a2635;
            --btn-secondary-text: #94a3b8;
            --btn-secondary-hover-bg: #1f2a3d;
            --btn-secondary-hover-text: #ffffff;
            --toolbar-btn-bg: #060b13;
        }

        body {
            background-color: var(--bg-body);
            color: var(--text-muted);
            font-family: 'Inter', sans-serif;
        }

        .text-heading {
            color: var(--text-heading) !important;
        }

        .panel-card {
            background-color: var(--bg-panel);
            border: 1px solid var(--border-color);
            border-radius: 0.375rem;
        }

        .form-input {
            background-color: var(--input-bg);
            border: 1px solid var(--border-color);
            border-radius: 0.25rem;
            color: var(--text-body);
            padding: 6px 10px;
            width: 100%;
            font-size: 12px;
            box-sizing: border-box;
            transition: border-color .15s, box-shadow .15s;
        }

        .form-input:focus {
            outline: none;
            border-color: #1d4ed8;
            box-shadow: 0 0 0 2px rgba(29, 78, 216, .2);
        }

        .form-input::placeholder {
            color: var(--text-muted);
        }

        select.form-input {
            appearance: none;
            -webkit-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 10px center;
            padding-right: 30px;
            cursor: pointer;
        }

        select.form-input option {
            background: var(--bg-panel);
            color: var(--text-body);
        }

        .form-label {
            color: var(--text-muted);
            font-size: 11px;
            font-weight: 500;
            margin-bottom: 4px;
            display: block;
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
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all .15s;
        }

        .btn-secondary:hover {
            background-color: var(--btn-secondary-hover-bg);
            color: var(--btn-secondary-hover-text);
        }

        .btn-primary {
            background-color: #1d4ed8;
            color: #fff;
            padding: 8px 20px;
            border-radius: 0.25rem;
            border: none;
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: background-color .15s;
        }

        .btn-primary:hover {
            background-color: #2563eb;
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
            padding: 4px 10px;
            font-size: 10px;
            font-weight: 500;
            border-radius: 4px;
            border: 1px solid transparent;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
        }

        .btn-view {
            background: rgba(139, 92, 246, .1);
            color: #8b5cf6;
            border-color: rgba(139, 92, 246, .25);
        }

        .btn-view:hover {
            background: #8b5cf6;
            color: #fff;
        }

        .table-container {
            position: relative;
            overflow-x: auto;
            min-height: 120px;
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
            letter-spacing: .5px;
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

        .table-loading-overlay {
            position: absolute;
            inset: 0;
            background-color: var(--bg-panel);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-size: 12px;
            color: var(--text-muted);
            z-index: 5;
        }

        .table-loading-overlay.hidden {
            display: none;
        }

        .dataTables_wrapper .dt-buttons {
            display: flex !important;
            gap: 6px !important;
            flex-wrap: wrap !important;
            margin: 0 0 10px 0 !important;
            float: left;
        }

        .dataTables_wrapper .dt-buttons .dt-button {
            padding: 6px 12px !important;
            background-color: var(--toolbar-btn-bg) !important;
            border: 1px solid var(--border-color) !important;
            border-radius: .25rem !important;
            color: var(--text-muted) !important;
            font-size: 10px !important;
            cursor: pointer !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 4px !important;
            height: 30px !important;
            box-sizing: border-box !important;
            font-family: 'Inter', sans-serif !important;
            transition: all .15s !important;
        }

        .dataTables_wrapper .dt-buttons .dt-button:hover {
            background-color: var(--hover-bg) !important;
            color: var(--text-heading) !important;
            box-shadow: none !important;
        }

        .dataTables_filter {
            margin: 0 !important;
            display: flex;
            align-items: center;
            gap: 6px;
            position: relative;
        }

        .dataTables_filter label {
            color: var(--text-muted) !important;
            font-size: 11px !important;
            font-weight: 500 !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 6px !important;
            margin: 0 !important;
            position: relative;
        }

        .dataTables_filter label::before {
            content: "\f002";
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 11px;
            color: var(--text-muted);
            pointer-events: none;
            z-index: 2;
        }

        .dataTables_filter input {
            background-color: var(--input-bg) !important;
            border: 1px solid var(--border-color) !important;
            border-radius: 0.25rem !important;
            color: var(--text-body) !important;
            padding: 6px 12px 6px 30px !important;
            font-size: 12px !important;
            height: 32px !important;
            width: 220px !important;
            outline: none !important;
            font-family: 'Inter', sans-serif !important;
            margin: 0 !important;
            box-sizing: border-box !important;
            transition: border-color .15s, box-shadow .15s !important;
        }

        .dataTables_filter input:focus {
            outline: none !important;
            border-color: #1d4ed8 !important;
            box-shadow: 0 0 0 2px rgba(29, 78, 216, 0.2) !important;
        }

        .dataTables_filter input::placeholder {
            color: var(--text-muted) !important;
            font-size: 11px !important;
        }

        .dataTables_wrapper .dataTables_info {
            color: var(--text-muted) !important;
            font-size: 11px !important;
            padding-top: 12px !important;
            clear: both;
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

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #1d4ed8 !important;
            color: #fff !important;
            border-color: #1d4ed8 !important;
        }

        .dataTables_wrapper::after {
            content: "";
            display: table;
            clear: both;
        }

        .table-toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 12px;
            padding: 0 4px;
        }

        .table-toolbar-left {
            display: flex;
            align-items: center;
            gap: 6px;
            flex-wrap: wrap;
        }

        .table-toolbar-right {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-shrink: 0;
        }

        .toast {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: var(--bg-panel);
            border: 1px solid var(--border-color);
            border-radius: .375rem;
            padding: 12px 20px;
            color: var(--text-body);
            font-size: 12px;
            z-index: 9999;
            transform: translateY(100px);
            opacity: 0;
            transition: all .3s ease-in-out;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .25);
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

        .order-number {
            font-family: 'Courier New', monospace;
            font-weight: 700;
            font-size: 11px;
            color: var(--text-heading);
            background: var(--hover-bg);
            padding: 3px 8px;
            border-radius: 4px;
            display: inline-block;
            letter-spacing: .3px;
        }

        .st-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 3px 9px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: 600;
            white-space: nowrap;
        }

        .st-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: currentColor;
        }

        .st-pending {
            background: rgba(234, 179, 8, .12);
            color: #eab308;
            border: 1px solid rgba(234, 179, 8, .3);
        }

        .st-completed {
            background: rgba(16, 185, 129, .12);
            color: #10b981;
            border: 1px solid rgba(16, 185, 129, .25);
        }

        .st-refunded {
            background: rgba(148, 163, 184, .15);
            color: #94a3b8;
            border: 1px solid rgba(148, 163, 184, .3);
        }

        .pay-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: 600;
        }

        .pay-paid {
            background: rgba(16, 185, 129, .12);
            color: #10b981;
        }

        .pay-unpaid {
            background: rgba(234, 179, 8, .15);
            color: #eab308;
        }

        .pay-refunded {
            background: rgba(148, 163, 184, .15);
            color: #94a3b8;
        }

        .del-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: 600;
        }

        .del-pickup {
            background: rgba(29, 78, 216, .1);
            color: #1d4ed8;
        }

        .del-delivery {
            background: rgba(139, 92, 246, .1);
            color: #8b5cf6;
        }

        .money-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: 600;
            white-space: nowrap;
        }

        .money-amount {
            background: rgba(148, 163, 184, .15);
            color: #64748b;
        }

        .money-discount {
            background: rgba(234, 179, 8, .12);
            color: #eab308;
        }

        .money-final {
            background: rgba(16, 185, 129, .12);
            color: #10b981;
        }

        .cell-name {
            font-weight: 600;
            color: var(--text-heading);
            font-size: 11px;
        }

        .cell-sub {
            font-size: 9px;
            color: var(--text-muted);
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 10px;
            margin-bottom: 12px;
        }

        .summary-card {
            background: var(--bg-panel);
            border: 1px solid var(--border-color);
            border-radius: 6px;
            padding: 12px 14px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .summary-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }

        .summary-icon.blue {
            background: rgba(29, 78, 216, .12);
            color: #1d4ed8;
        }

        .summary-icon.green {
            background: rgba(16, 185, 129, .12);
            color: #10b981;
        }

        .summary-icon.yellow {
            background: rgba(234, 179, 8, .12);
            color: #eab308;
        }

        .summary-icon.purple {
            background: rgba(139, 92, 246, .12);
            color: #8b5cf6;
        }

        .summary-label {
            font-size: 10px;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: .5px;
            font-weight: 500;
        }

        .summary-value {
            font-size: 16px;
            font-weight: 700;
            color: var(--text-heading);
            margin-top: 2px;
        }

        .select2-container--default .select2-selection--single {
            background-color: var(--input-bg) !important;
            border: 1px solid var(--border-color) !important;
            border-radius: 0.25rem !important;
            height: 32px !important;
            transition: border-color .15s, box-shadow .15s;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: var(--text-body) !important;
            line-height: 30px !important;
            padding-left: 10px !important;
            padding-right: 30px !important;
            font-size: 12px !important;
            font-family: 'Inter', sans-serif !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__placeholder {
            color: var(--text-muted) !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 30px !important;
            width: 26px !important;
            right: 2px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow b {
            border-color: var(--text-muted) transparent transparent transparent !important;
            border-width: 5px 4px 0 4px !important;
        }

        .select2-container--default.select2-container--focus .select2-selection--single,
        .select2-container--default.select2-container--open .select2-selection--single {
            border-color: #1d4ed8 !important;
            box-shadow: 0 0 0 2px rgba(29, 78, 216, 0.2) !important;
        }

        .select2-container--default .select2-dropdown {
            background-color: var(--bg-panel) !important;
            border: 1px solid var(--border-color) !important;
            border-radius: 0.25rem !important;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25) !important;
            z-index: 9999 !important;
        }

        .select2-container--default .select2-search--dropdown .select2-search__field {
            background-color: var(--input-bg) !important;
            border: 1px solid var(--border-color) !important;
            border-radius: 0.25rem !important;
            color: var(--text-body) !important;
            padding: 6px 10px !important;
            font-size: 12px !important;
            outline: none !important;
            height: 32px !important;
            box-sizing: border-box !important;
        }

        .select2-container--default .select2-search--dropdown .select2-search__field:focus {
            border-color: #1d4ed8 !important;
            box-shadow: 0 0 0 2px rgba(29, 78, 216, 0.2) !important;
        }

        .select2-container--default .select2-results__option {
            font-size: 12px !important;
            color: var(--text-body) !important;
            padding: 6px 10px !important;
        }

        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #1d4ed8 !important;
            color: #ffffff !important;
        }

        .select2-container--default .select2-results__option[aria-selected=true] {
            background-color: var(--hover-bg) !important;
            color: var(--text-heading) !important;
        }

        .select2-results__options {
            max-height: 280px !important;
        }

        /* Order Details Offcanvas */
        #offcanvasOrderDetails {
            position: fixed;
            top: 0;
            bottom: 0;
            right: 0;
            width: 780px;
            max-width: 96vw;
            background: var(--bg-panel);
            border-left: 1px solid var(--border-color);
            box-shadow: -20px 0 60px rgba(15, 23, 42, .18);
            transform: translateX(100%);
            transition: transform .35s cubic-bezier(.4, 0, .2, 1);
            visibility: hidden;
            z-index: 99999;
            display: flex;
            flex-direction: column;
        }

        #offcanvasOrderDetails.show {
            transform: translateX(0);
            visibility: visible;
        }

        .od-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.55);
            backdrop-filter: blur(3px);
            opacity: 0;
            pointer-events: none;
            transition: opacity .3s;
            z-index: 99998;
        }

        .od-backdrop.show {
            opacity: 1;
            pointer-events: auto;
        }

        .od-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 24px;
            flex-shrink: 0;
            background: linear-gradient(135deg, #1d4ed8 0%, #4f46e5 100%);
            color: #ffffff;
            border-bottom: 1px solid rgba(255, 255, 255, .1);
        }

        .od-header-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .od-header-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: rgba(255, 255, 255, .18);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            backdrop-filter: blur(6px);
        }

        .od-header-title {
            font-size: 15px;
            font-weight: 700;
            letter-spacing: .3px;
            color: #ffffff;
            margin: 0;
        }

        .od-close {
            width: 32px;
            height: 32px;
            border: none;
            background: rgba(255, 255, 255, .12);
            color: #ffffff;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            padding: 0;
            font-size: 18px;
            line-height: 1;
            transition: all .15s;
        }

        .od-close:hover {
            background: rgba(255, 255, 255, .25);
            transform: rotate(90deg);
        }

        .od-body {
            flex: 1 1 auto;
            padding: 20px 24px 24px;
            overflow-y: auto;
            background: var(--bg-body);
        }

        .od-section {
            background: var(--bg-panel);
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 16px 18px;
            margin-bottom: 14px;
            box-shadow: 0 1px 3px rgba(15, 23, 42, .04);
            transition: box-shadow .2s;
        }

        .od-section:hover {
            box-shadow: 0 4px 14px rgba(15, 23, 42, .06);
        }

        .od-section-title {
            font-size: 11px;
            font-weight: 700;
            color: var(--text-heading);
            text-transform: uppercase;
            letter-spacing: .7px;
            margin-bottom: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
            padding-bottom: 10px;
            border-bottom: 1px dashed var(--border-color);
        }

        .od-section-title i {
            color: #1d4ed8;
            font-size: 12px;
        }

        .od-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 14px 20px;
        }

        .od-item {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .od-item-label {
            font-size: 9px;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: .5px;
            font-weight: 600;
        }

        .od-item-value {
            font-size: 12.5px;
            color: var(--text-heading);
            font-weight: 500;
            word-break: break-word;
            line-height: 1.45;
        }

        .od-info-hero {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 14px 16px;
            border-radius: 10px;
            background: linear-gradient(135deg, rgba(29, 78, 216, .06) 0%, rgba(79, 70, 229, .06) 100%);
            border: 1px solid rgba(29, 78, 216, .15);
            margin-bottom: 14px;
        }

        .od-info-hero-left {
            display: flex;
            flex-direction: column;
            gap: 3px;
        }

        .od-info-hero-label {
            font-size: 9px;
            font-weight: 600;
            color: var(--text-muted);
            letter-spacing: .6px;
            text-transform: uppercase;
        }

        .od-info-hero-value {
            font-size: 16px;
            font-weight: 700;
            color: var(--text-heading);
            font-family: 'Courier New', monospace;
            letter-spacing: .5px;
        }

        .od-info-hero-right {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
            justify-content: flex-end;
        }

        .od-items-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            font-size: 11.5px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            overflow: hidden;
        }

        .od-items-table thead th {
            background: var(--table-head-bg);
            color: var(--table-head-text);
            font-weight: 600;
            text-align: left;
            padding: 10px 12px;
            font-size: 9.5px;
            text-transform: uppercase;
            letter-spacing: .5px;
            border-bottom: 1px solid var(--border-color);
            white-space: nowrap;
        }

        .od-items-table tbody td {
            padding: 12px;
            border-bottom: 1px solid var(--border-color);
            color: var(--table-row-text);
            vertical-align: middle;
            background: var(--bg-panel);
        }

        .od-items-table tbody tr:last-child td {
            border-bottom: none;
        }

        .od-items-table tbody tr:hover td {
            background: var(--hover-bg);
        }

        .od-product-name {
            font-weight: 600;
            color: var(--text-heading);
            font-size: 12px;
            line-height: 1.3;
        }

        .od-product-meta {
            font-size: 10px;
            color: var(--text-muted);
            margin-top: 3px;
            letter-spacing: .2px;
        }

        .od-qty-pill {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 28px;
            height: 24px;
            padding: 0 8px;
            border-radius: 6px;
            background: rgba(29, 78, 216, .08);
            color: #1d4ed8;
            font-weight: 700;
            font-size: 11px;
        }

        .od-disc-pill {
            display: inline-flex;
            align-items: center;
            padding: 2px 8px;
            border-radius: 4px;
            background: rgba(234, 179, 8, .12);
            color: #eab308;
            font-weight: 700;
            font-size: 10.5px;
        }

        .od-item-total {
            margin-top: 16px;
            padding: 14px 16px;
            border-radius: 8px;
            background: var(--bg-body);
            border: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .od-total-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 12px;
            color: var(--text-body);
        }

        .od-total-row .od-total-label {
            font-weight: 500;
            color: var(--text-muted);
        }

        .od-total-row .od-total-value {
            font-weight: 600;
            color: var(--text-heading);
            font-variant-numeric: tabular-nums;
        }

        .od-total-row.discount-row .od-total-value {
            color: #eab308;
        }

        .od-total-row.grand {
            font-size: 15px;
            font-weight: 700;
            color: var(--text-heading);
            padding-top: 10px;
            margin-top: 4px;
            border-top: 2px solid var(--border-color);
        }

        .od-total-row.grand .od-total-label {
            color: var(--text-heading);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .5px;
            font-size: 11px;
        }

        .od-total-row.grand .od-total-value {
            color: #10b981;
            font-size: 17px;
            font-weight: 800;
        }

        .od-coupon-card {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 16px;
            border-radius: 10px;
            background: linear-gradient(135deg, rgba(234, 179, 8, .08) 0%, rgba(234, 179, 8, .02) 100%);
            border: 1px dashed rgba(234, 179, 8, .45);
        }

        .od-coupon-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: rgba(234, 179, 8, .15);
            color: #eab308;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }

        .od-coupon-info {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 3px;
        }

        .od-coupon-code {
            font-family: 'Courier New', monospace;
            font-weight: 700;
            color: var(--text-heading);
            font-size: 13px;
            letter-spacing: .5px;
        }

        .od-coupon-label {
            font-size: 10px;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: .5px;
            font-weight: 600;
        }

        .od-coupon-amount {
            font-size: 16px;
            font-weight: 800;
            color: #eab308;
            font-variant-numeric: tabular-nums;
        }

        .od-notes-card {
            font-size: 12.5px;
            color: var(--text-body);
            line-height: 1.6;
            padding: 12px 14px;
            border-radius: 8px;
            background: var(--bg-body);
            border-left: 3px solid #1d4ed8;
        }

        .od-body::-webkit-scrollbar {
            width: 8px;
        }

        .od-body::-webkit-scrollbar-track {
            background: transparent;
        }

        .od-body::-webkit-scrollbar-thumb {
            background: var(--scrollbar-thumb);
            border-radius: 4px;
        }

        @media (max-width: 640px) {
            #offcanvasOrderDetails {
                width: 100vw;
                max-width: 100vw;
            }

            .od-grid {
                grid-template-columns: 1fr;
            }

            .od-info-hero {
                flex-direction: column;
                align-items: flex-start;
            }

            .od-info-hero-right {
                justify-content: flex-start;
            }

            .od-items-table thead th,
            .od-items-table tbody td {
                padding: 8px 8px;
                font-size: 10.5px;
            }
        }

        .hidden {
            display: none !important;
        }
    </style>
</head>

<body class="flex h-screen overflow-hidden text-xs">

    <?php include __DIR__ . '/../includes/sidebar.php'; ?>

    <main id="mainContent" class="flex-1 flex flex-col overflow-hidden">

        <?php include __DIR__ . '/../includes/topbar.php'; ?>

        <div class="flex-1 overflow-y-auto p-4" id="pageContent">

            <div class="flex flex-wrap justify-between items-center mb-4 gap-2">
                <div>
                    <h2 class="text-heading font-semibold text-base tracking-wide uppercase">
                        <i class="fa-solid fa-shopping-bag mr-2 text-blue-500"></i>Orders
                    </h2>
                    <p class="text-[10px] text-gray-500">View all orders and their items</p>
                </div>
            </div>

            <div class="summary-grid">
                <div class="summary-card">
                    <div class="summary-icon blue"><i class="fa-solid fa-list"></i></div>
                    <div>
                        <div class="summary-label">Total Orders</div>
                        <div class="summary-value" id="sumTotal">0</div>
                    </div>
                </div>
                <div class="summary-card">
                    <div class="summary-icon purple"><i class="fa-solid fa-money-bill-wave"></i></div>
                    <div>
                        <div class="summary-label">Subtotal</div>
                        <div class="summary-value" id="sumSubtotal">0.00</div>
                    </div>
                </div>
                <div class="summary-card">
                    <div class="summary-icon yellow"><i class="fa-solid fa-percent"></i></div>
                    <div>
                        <div class="summary-label">Discount</div>
                        <div class="summary-value" id="sumDiscount">0.00</div>
                    </div>
                </div>
                <div class="summary-card">
                    <div class="summary-icon green"><i class="fa-solid fa-circle-check"></i></div>
                    <div>
                        <div class="summary-label">Total Amount</div>
                        <div class="summary-value" id="sumFinal">0.00</div>
                    </div>
                </div>
            </div>

            <div class="panel-card p-3 mb-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3">
                    <div class="lg:col-span-2">
                        <label class="form-label">Customer</label>
                        <select id="filterCustomer" class="form-input text-xs" style="width:100%;">
                            <option value="">All Customers</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Order Status</label>
                        <select id="filterStatus" class="form-input text-xs" style="height:32px;">
                            <option value="">All Status</option>
                            <option value="completed">Completed</option>
                            <option value="pending">Pending</option>
                            <option value="refunded">Refunded</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Delivery Type</label>
                        <select id="filterDelivery" class="form-input text-xs" style="height:32px;">
                            <option value="">All</option>
                            <option value="pickup">Pickup</option>
                            <option value="delivery">Delivery</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Date From</label>
                        <input type="date" id="filterDateFrom" class="form-input text-xs" style="height:32px;">
                    </div>
                    <div>
                        <label class="form-label">Date To</label>
                        <input type="date" id="filterDateTo" class="form-input text-xs" style="height:32px;">
                    </div>
                    <div style="display:flex;gap:8px;align-items:flex-end;">
                        <button type="button" onclick="loadOrders()" class="btn-primary flex items-center gap-2"
                            style="height:32px;padding:0 16px;flex:1;">
                            <i class="fa-solid fa-filter"></i> Apply
                        </button>
                        <button type="button" onclick="resetFilters()" class="btn-secondary flex items-center gap-2"
                            style="height:32px;padding:0 14px;" title="Reset all filters">
                            <i class="fa-solid fa-rotate-left"></i> Reset
                        </button>
                    </div>
                </div>
            </div>

            <div class="panel-card overflow-hidden p-3">
                <div class="table-toolbar">
                    <div class="table-toolbar-left" id="exportButtonsContainer"></div>
                    <div class="table-toolbar-right" id="searchContainer"></div>
                </div>

                <div class="table-container">
                    <div class="table-loading-overlay" id="tableLoadingOverlay">
                        <i class="fa-solid fa-spinner fa-spin text-blue-400"></i> Loading orders...
                    </div>
                    <table id="ordTable" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Order #</th>
                                <th>Customer</th>
                                <th>Dealer</th>
                                <th>Amount</th>
                                <th>Discount</th>
                                <th>Total</th>
                                <th>Coupon</th>
                                <th>Order Status</th>
                                <th>Payment</th>
                                <th>Delivery</th>
                                <th>Date</th>
                                <th style="width:80px;">Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>

    <div id="toast" class="toast">
        <i class="fa-solid fa-check-circle mr-2"></i>
        <span id="toastMessage">Data loaded successfully!</span>
    </div>

    <div id="odBackdrop" class="od-backdrop" onclick="closeOrderDetails()"></div>
    <div id="offcanvasOrderDetails">
        <div class="od-header">
            <div class="od-header-left">
                <div class="od-header-icon">
                    <i class="fa-solid fa-receipt"></i>
                </div>
                <div>
                    <h5 class="od-header-title">Order Details</h5>
                </div>
            </div>
            <button class="od-close" onclick="closeOrderDetails()" title="Close">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="od-body" id="odBody">
        </div>
    </div>

    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

    <script>
        const API_BASE = '/hascol_dashboard/hascol_customer/api/orders/';

        let dataTable = null;
        window.ordStore = {};

        const exportButtons = [
            { extend: 'copy', text: '<i class="fa-regular fa-copy"></i> Copy', className: 'dt-button' },
            { extend: 'excelHtml5', text: '<i class="fa-regular fa-file-excel"></i> Excel', className: 'dt-button', title: 'Orders_Export' },
            { extend: 'csvHtml5', text: '<i class="fa-regular fa-file-csv"></i> CSV', className: 'dt-button', title: 'Orders_Export' },
            { extend: 'pdfHtml5', text: '<i class="fa-regular fa-file-pdf"></i> PDF', className: 'dt-button', orientation: 'landscape', pageSize: 'A4', title: 'Orders' },
            { extend: 'print', text: '<i class="fa-solid fa-print"></i> Print', className: 'dt-button' }
        ];

        $(document).ready(function () {
            initCustomerSelect2();

            dataTable = $('#ordTable').DataTable({
                dom: 'Bfrtip',
                buttons: exportButtons,
                pageLength: 10,
                order: [],
                columnDefs: [{ orderable: false, targets: '_all' }],
                language: {
                    emptyTable: 'No orders found',
                    info: 'Showing _START_ to _END_ of _TOTAL_',
                    infoEmpty: '0 entries',
                    infoFiltered: '(filtered from _MAX_)',
                    search: '',
                    searchPlaceholder: 'Search in table...'
                },
                initComplete: function () {
                    this.api().buttons().container().appendTo('#exportButtonsContainer');
                    const searchBox = $('#ordTable_wrapper .dataTables_filter');
                    searchBox.appendTo('#searchContainer');
                }
            });

            $('#filterStatus, #filterDelivery').on('change', function () { loadOrders(); });
            $('#filterCustomer').on('change', function () { loadOrders(); });

            loadCustomersForFilter();
            loadOrders();

            $(document).on('keydown', function (e) {
                if (e.key === 'Escape') closeOrderDetails();
            });
        });

        function initCustomerSelect2() {
            if ($('#filterCustomer').hasClass('select2-hidden-accessible')) {
                $('#filterCustomer').select2('destroy');
            }

            $('#filterCustomer').select2({
                placeholder: 'All Customers',
                allowClear: true,
                width: '100%',
                dropdownParent: $('body'),
                language: {
                    noResults: function () { return 'No customers found'; },
                    searching: function () { return 'Searching...'; }
                },
                minimumResultsForSearch: 0
            });
        }

        function escapeHtml(text) {
            if (text === null || text === undefined) return '';
            return String(text).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#039;');
        }
        function showToast(message, type = 'success') {
            const toast = $('#toast');
            toast.removeClass('success error').addClass(type);
            $('#toastMessage').text(message);
            toast.addClass('show');
            clearTimeout(window._toastT);
            window._toastT = setTimeout(() => toast.removeClass('show'), 3000);
        }
        function formatDate(dt, withTime) {
            if (!dt) return '—';
            const d = new Date(dt.replace(' ', 'T'));
            if (isNaN(d.getTime())) return dt;
            const dateStr = d.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });
            if (withTime) {
                const timeStr = d.toLocaleTimeString('en-GB', { hour: '2-digit', minute: '2-digit' });
                return dateStr + ' ' + timeStr;
            }
            return dateStr;
        }
        function formatMoney(n) {
            return 'Rs ' + Number(n || 0).toLocaleString('en-PK', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        }

        function deriveOrderStatus(paymentStatus) {
            if (paymentStatus === 'paid') return 'completed';
            if (paymentStatus === 'refunded') return 'refunded';
            return 'pending';
        }

        function renderOrderStatusBadge(paymentStatus) {
            const derived = deriveOrderStatus(paymentStatus);
            if (derived === 'completed') return '<span class="st-badge st-completed"><span class="st-dot"></span>Completed</span>';
            if (derived === 'refunded') return '<span class="st-badge st-refunded"><span class="st-dot"></span>Refunded</span>';
            return '<span class="st-badge st-pending"><span class="st-dot"></span>Pending</span>';
        }

        function loadCustomersForFilter() {
            $.ajax({
                url: API_BASE + 'get-order-customers.php',
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({}),
                dataType: 'json',
                success: function (res) {
                    let customers = [];
                    if (res && Array.isArray(res.hascol_customer)) {
                        customers = res.hascol_customer;
                    } else if (res && Array.isArray(res.customers)) {
                        customers = res.customers;
                    }

                    if ($('#filterCustomer').hasClass('select2-hidden-accessible')) {
                        $('#filterCustomer').select2('destroy');
                    }

                    const sel = $('#filterCustomer');
                    sel.empty();
                    sel.append('<option value="">All Customers</option>');

                    if (customers.length) {
                        customers.forEach(function (c) {
                            const label = (c.name || '') + (c.mobile ? ' — ' + c.mobile : '');
                            sel.append('<option value="' + c.id + '">' + escapeHtml(label) + '</option>');
                        });
                    }

                    initCustomerSelect2();
                },
                error: function (xhr, s, e) {
                    console.error('Failed to load customers:', e, xhr.responseText);
                }
            });
        }

        function resetFilters() {
            $('#filterCustomer').val('').trigger('change.select2');
            $('#filterStatus').val('');
            $('#filterDelivery').val('');
            $('#filterDateFrom').val('');
            $('#filterDateTo').val('');

            dataTable.search('').draw();
            dataTable.page(0).draw(false);

            loadOrders();
            showToast('Filters reset — showing all orders', 'success');
        }

        function loadOrders() {
            const payload = {};
            const customer_id = $('#filterCustomer').val();
            const status = $('#filterStatus').val();
            const delivery_type = $('#filterDelivery').val();
            const dateFrom = $('#filterDateFrom').val();
            const dateTo = $('#filterDateTo').val();

            if (customer_id) payload.customer_id = parseInt(customer_id);
            if (status) payload.status = status;
            if (delivery_type) payload.delivery_type = delivery_type;
            if (dateFrom) payload.date_from = dateFrom;
            if (dateTo) payload.date_to = dateTo;

            $('#tableLoadingOverlay').removeClass('hidden');

            $.ajax({
                url: API_BASE + 'get-orders.php',
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(payload),
                dataType: 'json',
                success: function (res) {
                    dataTable.clear().draw();
                    window.ordStore = {};

                    if (res && res.status === 'success') {
                        $('#sumTotal').text(res.total || 0);
                        $('#sumSubtotal').text(Number(res.total_subtotal || 0).toFixed(2));
                        $('#sumDiscount').text(Number(res.total_discount || 0).toFixed(2));
                        $('#sumFinal').text(Number(res.total_final || 0).toFixed(2));

                        if (Array.isArray(res.orders) && res.orders.length) {
                            $.each(res.orders, function (i, o) {
                                window.ordStore[o.id] = o;

                                const orderNumCell = '<span class="order-number">' + escapeHtml(o.order_number) + '</span>';

                                const customerCell = '<div>' +
                                    '<div class="cell-name">' + escapeHtml(o.customer_name) + '</div>' +
                                    '<div class="cell-sub">' + escapeHtml(o.customer_mobile || '—') + '</div>' +
                                    '</div>';

                                const dealerCell = '<div>' +
                                    '<div class="cell-name">' + escapeHtml(o.dealer_name) + '</div>' +
                                    '<div class="cell-sub">' + escapeHtml(o.dealer_station || '—') + '</div>' +
                                    '</div>';

                                const amtBadge = '<span class="money-badge money-amount">' + formatMoney(o.subtotal) + '</span>';
                                const discBadge = o.discount > 0
                                    ? '<span class="money-badge money-discount">-' + formatMoney(o.discount) + '</span>'
                                    : '<span style="color:var(--text-muted);">—</span>';
                                const finalBadge = '<span class="money-badge money-final">' + formatMoney(o.total_amount) + '</span>';

                                const couponCell = o.coupon_code
                                    ? '<span style="font-family:monospace;font-size:10px;background:var(--hover-bg);padding:2px 6px;border-radius:4px;">' + escapeHtml(o.coupon_code) + '</span>'
                                    : '<span style="color:var(--text-muted);">—</span>';

                                const statusHtml = renderOrderStatusBadge(o.payment_status);

                                let payHtml;
                                if (o.payment_status === 'paid') payHtml = '<span class="pay-badge pay-paid"><i class="fa-solid fa-circle-check"></i> Paid</span>';
                                else if (o.payment_status === 'refunded') payHtml = '<span class="pay-badge pay-refunded"><i class="fa-solid fa-rotate-left"></i> Refunded</span>';
                                else payHtml = '<span class="pay-badge pay-unpaid"><i class="fa-solid fa-clock"></i> Unpaid</span>';

                                const delHtml = o.delivery_type === 'delivery'
                                    ? '<span class="del-badge del-delivery"><i class="fa-solid fa-truck"></i> Delivery</span>'
                                    : '<span class="del-badge del-pickup"><i class="fa-solid fa-store"></i> Pickup</span>';

                                const action = '<button class="btn-action btn-view" onclick="viewOrder(' + o.id + ')" title="View Details">' +
                                    '<i class="fa-solid fa-eye"></i> View' +
                                    '</button>';

                                dataTable.row.add([
                                    i + 1,
                                    orderNumCell,
                                    customerCell,
                                    dealerCell,
                                    amtBadge,
                                    discBadge,
                                    finalBadge,
                                    couponCell,
                                    statusHtml,
                                    payHtml,
                                    delHtml,
                                    formatDate(o.created_at, true),
                                    action
                                ]);
                            });
                            showToast('Loaded ' + res.total + ' orders', 'success');
                        } else {
                            dataTable.row.add([
                                '<span style="color:var(--text-muted);">No orders found</span>',
                                '', '', '', '', '', '', '', '', '', '', '', ''
                            ]);
                        }
                    } else {
                        dataTable.row.add([
                            '<span style="color:#ef4444;">Error loading orders</span>',
                            '', '', '', '', '', '', '', '', '', '', '', ''
                        ]);
                    }

                    dataTable.draw(false);
                    $('#tableLoadingOverlay').addClass('hidden');
                },
                error: function (xhr, s, e) {
                    console.error('Load orders error:', e, xhr.responseText);
                    dataTable.clear().draw();
                    dataTable.row.add([
                        '<span style="color:#ef4444;">Error loading orders</span>',
                        '', '', '', '', '', '', '', '', '', '', '', ''
                    ]).draw(false);
                    $('#tableLoadingOverlay').addClass('hidden');
                    showToast('Failed to load orders', 'error');
                }
            });
        }

        function viewOrder(orderId) {
            const o = window.ordStore[orderId];
            if (!o) return;

            const body = $('#odBody');
            body.html('<div style="text-align:center;padding:60px 0;color:var(--text-muted);"><i class="fa-solid fa-spinner fa-spin text-blue-400" style="font-size:28px;"></i><div style="margin-top:14px;font-size:12px;letter-spacing:.3px;">Loading order details...</div></div>');

            $('#odBackdrop').addClass('show');
            $('#offcanvasOrderDetails').addClass('show');
            document.body.style.overflow = 'hidden';

            $.ajax({
                url: API_BASE + 'get-order-items.php',
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({ order_id: orderId }),
                dataType: 'json',
                success: function (res) {
                    const items = (res && res.items) ? res.items : [];
                    const grandTotal = (res && res.grand_total) ? res.grand_total : 0;
                    renderOrderDetails(o, items, grandTotal);
                },
                error: function (xhr, s, e) {
                    console.error('Failed to load order items:', e);
                    renderOrderDetails(o, [], 0);
                }
            });
        }

        function renderOrderDetails(o, items, grandTotal) {
            const body = $('#odBody');

            let payHtml;
            if (o.payment_status === 'paid') payHtml = '<span class="pay-badge pay-paid"><i class="fa-solid fa-circle-check"></i> Paid</span>';
            else if (o.payment_status === 'refunded') payHtml = '<span class="pay-badge pay-refunded"><i class="fa-solid fa-rotate-left"></i> Refunded</span>';
            else payHtml = '<span class="pay-badge pay-unpaid"><i class="fa-solid fa-clock"></i> Unpaid</span>';

            const delHtml = o.delivery_type === 'delivery'
                ? '<span class="del-badge del-delivery"><i class="fa-solid fa-truck"></i> Delivery</span>'
                : '<span class="del-badge del-pickup"><i class="fa-solid fa-store"></i> Pickup</span>';

            let itemsHtml = '';
            if (items.length === 0) {
                itemsHtml = '<div style="text-align:center;padding:30px 20px;color:var(--text-muted);font-size:12px;">' +
                    '<i class="fa-solid fa-inbox" style="font-size:24px;opacity:.4;display:block;margin-bottom:10px;"></i>' +
                    'No items found for this order.</div>';
            } else {
                itemsHtml = '<table class="od-items-table"><thead><tr>' +
                    '<th style="width:44px;">#</th>' +
                    '<th>Product</th>' +
                    '<th style="width:60px;text-align:center;">Qty</th>' +
                    '<th style="width:100px;text-align:right;">Price</th>' +
                    '<th style="width:70px;text-align:right;">Disc%</th>' +
                    '<th style="width:110px;text-align:right;">Subtotal</th>' +
                    '</tr></thead><tbody>';

                items.forEach(function (it, idx) {
                    itemsHtml += '<tr>' +
                        '<td style="color:var(--text-muted);font-weight:600;">' + (idx + 1) + '</td>' +
                        '<td>' +
                        '<div class="od-product-name">' + escapeHtml(it.product_name) + '</div>' +
                        '<div class="od-product-meta">' +
                        (it.product_sku ? 'SKU: ' + escapeHtml(it.product_sku) : '') +
                        (it.product_brand ? (it.product_sku ? ' • ' : '') + escapeHtml(it.product_brand) : '') +
                        '</div>' +
                        '</td>' +
                        '<td style="text-align:center;"><span class="od-qty-pill">' + it.quantity + '</span></td>' +
                        '<td style="text-align:right;font-variant-numeric:tabular-nums;">' + formatMoney(it.price) + '</td>' +
                        '<td style="text-align:right;">' + (it.discount_percent > 0 ? '<span class="od-disc-pill">' + Number(it.discount_percent).toFixed(2) + '%</span>' : '<span style="color:var(--text-muted);">—</span>') + '</td>' +
                        '<td style="text-align:right;font-weight:700;color:#10b981;font-variant-numeric:tabular-nums;">' + formatMoney(it.subtotal) + '</td>' +
                        '</tr>';
                });

                itemsHtml += '</tbody></table>';

                const subtotalSum = items.reduce((sum, it) => sum + parseFloat(it.subtotal || 0), 0);
                itemsHtml += '<div class="od-item-total">';
                itemsHtml += '<div class="od-total-row"><span class="od-total-label">Items Subtotal</span><span class="od-total-value">' + formatMoney(subtotalSum) + '</span></div>';
                if (o.discount > 0) {
                    itemsHtml += '<div class="od-total-row discount-row"><span class="od-total-label">Order Discount</span><span class="od-total-value">- ' + formatMoney(o.discount) + '</span></div>';
                }
                itemsHtml += '<div class="od-total-row grand"><span class="od-total-label">Total Amount</span><span class="od-total-value">' + formatMoney(o.total_amount) + '</span></div>';
                itemsHtml += '</div>';
            }

            let html = '';

            html += '<div class="od-info-hero">' +
                '<div class="od-info-hero-left">' +
                '<span class="od-info-hero-label">Order Number</span>' +
                '<span class="od-info-hero-value">' + escapeHtml(o.order_number) + '</span>' +
                '</div>' +
                '<div class="od-info-hero-right">' +
                payHtml +
                '</div>' +
                '</div>';

            html += '<div class="od-section">' +
                '<div class="od-section-title"><i class="fa-solid fa-circle-info"></i> Order Information</div>' +
                '<div class="od-grid">' +
                '<div class="od-item"><span class="od-item-label">Station</span><span class="od-item-value">' + (o.station_name ? escapeHtml(o.station_name) : '—') + '</span></div>' +
                '<div class="od-item"><span class="od-item-label">Delivery Type</span><span class="od-item-value">' + delHtml + '</span></div>' +
                '<div class="od-item"><span class="od-item-label">Placed On</span><span class="od-item-value">' + formatDate(o.created_at, true) + '</span></div>' +
                '<div class="od-item"><span class="od-item-label">Coupon Code</span><span class="od-item-value">' + (o.coupon_code ? '<span style="font-family:monospace;">' + escapeHtml(o.coupon_code) + '</span>' : '—') + '</span></div>' +
                '</div>' +
                '</div>';

            html += '<div class="od-section">' +
                '<div class="od-section-title"><i class="fa-solid fa-user"></i> Customer Information</div>' +
                '<div class="od-grid">' +
                '<div class="od-item"><span class="od-item-label">Name</span><span class="od-item-value">' + escapeHtml(o.customer_name) + '</span></div>' +
                '<div class="od-item"><span class="od-item-label">Mobile</span><span class="od-item-value">' + escapeHtml(o.customer_mobile || '—') + '</span></div>' +
                '</div>' +
                '</div>';

            html += '<div class="od-section">' +
                '<div class="od-section-title"><i class="fa-solid fa-store"></i> Dealer Information</div>' +
                '<div class="od-grid">' +
                '<div class="od-item"><span class="od-item-label">Dealer</span><span class="od-item-value">' + escapeHtml(o.dealer_name) + '</span></div>' +
                '<div class="od-item"><span class="od-item-label">Mobile</span><span class="od-item-value">' + escapeHtml(o.dealer_mobile || '—') + '</span></div>' +
                '<div class="od-item"><span class="od-item-label">Station</span><span class="od-item-value">' + escapeHtml(o.dealer_station || '—') + '</span></div>' +
                '<div class="od-item"><span class="od-item-label">Delivery Address</span><span class="od-item-value">' + (o.delivery_address ? escapeHtml(o.delivery_address) : '—') + '</span></div>' +
                '</div>' +
                '</div>';

            if (o.coupon_code) {
                html += '<div class="od-section">' +
                    '<div class="od-section-title"><i class="fa-solid fa-ticket"></i> Coupon Applied</div>' +
                    '<div class="od-coupon-card">' +
                    '<div class="od-coupon-icon"><i class="fa-solid fa-ticket"></i></div>' +
                    '<div class="od-coupon-info">' +
                    '<span class="od-coupon-label">Coupon Code</span>' +
                    '<span class="od-coupon-code">' + escapeHtml(o.coupon_code) + '</span>' +
                    '</div>' +
                    '<div style="text-align:right;">' +
                    '<span class="od-coupon-label" style="display:block;">Discount</span>' +
                    '<span class="od-coupon-amount">- ' + formatMoney(o.discount) + '</span>' +
                    '</div>' +
                    '</div>' +
                    '</div>';
            }

            html += '<div class="od-section">' +
                '<div class="od-section-title"><i class="fa-solid fa-box-open"></i> Order Items <span style="color:var(--text-muted);font-weight:500;">(' + items.length + ')</span></div>' +
                itemsHtml +
                '</div>';

            if (o.notes) {
                html += '<div class="od-section">' +
                    '<div class="od-section-title"><i class="fa-solid fa-note-sticky"></i> Notes</div>' +
                    '<div class="od-notes-card">' + escapeHtml(o.notes) + '</div>' +
                    '</div>';
            }

            body.html(html);
        }

        function closeOrderDetails() {
            $('#offcanvasOrderDetails').removeClass('show');
            $('#odBackdrop').removeClass('show');
            document.body.style.overflow = '';
        }
    </script>

</body>

</html>