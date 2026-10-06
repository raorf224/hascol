<?php
require_once __DIR__ . '/../session/session.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Products | Hascol Customer</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        (function() {
            const isDarkMode = localStorage.getItem('darkMode') === 'true';
            if (isDarkMode) document.documentElement.classList.add('dark-mode');
        })();
    </script>

    <script>
        tailwind.config = {
            theme: { extend: { fontFamily: { sans: ['Inter','sans-serif'] } } }
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
            --modal-overlay: rgba(6,11,19,.85);
            --btn-secondary-bg: #1a2635;
            --btn-secondary-text: #94a3b8;
            --btn-secondary-hover-bg: #1f2a3d;
            --btn-secondary-hover-text: #ffffff;
            --toolbar-btn-bg: #060b13;
        }

        body { background-color: var(--bg-body); color: var(--text-muted); font-family: 'Inter', sans-serif; }
        .text-heading { color: var(--text-heading) !important; }

        .panel-card {
            background-color: var(--bg-panel);
            border: 1px solid var(--border-color);
            border-radius: 0.375rem;
        }

        /* Tabs */
        .tabs-header {
            display: flex;
            gap: 4px;
            border-bottom: 1px solid var(--border-color);
            margin-bottom: 16px;
            flex-wrap: wrap;
        }
        .tab-btn {
            padding: 10px 18px;
            font-size: 12px;
            font-weight: 600;
            color: var(--text-muted);
            background: transparent;
            border: none;
            border-bottom: 2px solid transparent;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-family: 'Inter', sans-serif;
            margin-bottom: -1px;
        }
        .tab-btn:hover {
            color: var(--text-heading);
            background: var(--hover-bg);
            border-top-left-radius: 6px;
            border-top-right-radius: 6px;
        }
        .tab-btn.active {
            color: #1d4ed8;
            border-bottom-color: #1d4ed8;
        }
        html.dark-mode .tab-btn.active { color: #60a5fa; border-bottom-color: #60a5fa; }

        .tab-pane { display: none; }
        .tab-pane.active { display: block; }

        .form-input {
            background-color: var(--input-bg);
            border: 1px solid var(--border-color);
            border-radius: 0.25rem;
            color: var(--text-body);
            padding: 6px 10px;
            width: 100%;
            font-size: 12px;
            box-sizing: border-box;
        }
        .form-input:focus {
            outline: none;
            border-color: #1d4ed8;
            box-shadow: 0 0 0 2px rgba(29,78,216,.2);
        }
        .form-input::placeholder { color: var(--text-muted); }

        select.form-input {
            appearance: none;
            -webkit-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 10px center;
            padding-right: 30px;
            cursor: pointer;
        }
        select.form-input option { background: var(--bg-panel); color: var(--text-body); }

        .form-label {
            color: var(--text-muted);
            font-size: 11px;
            font-weight: 500;
            margin-bottom: 4px;
            display: block;
        }
        .form-group { margin-bottom: 1rem; width: 100%; }

        .btn-primary {
            background-color: #1d4ed8; color: #ffffff;
            padding: 8px 20px; border-radius: 0.25rem; border: none;
            font-size: 12px; font-weight: 500; cursor: pointer;
            transition: background-color 0.2s;
        }
        .btn-primary:hover { background-color: #2563eb; }
        .btn-primary:disabled { opacity: 0.6; cursor: not-allowed; }

        .btn-secondary {
            background-color: var(--btn-secondary-bg); color: var(--btn-secondary-text);
            padding: 8px 20px; border-radius: 0.25rem; border: none;
            font-size: 12px; font-weight: 500; cursor: pointer;
        }
        .btn-secondary:hover {
            background-color: var(--btn-secondary-hover-bg);
            color: var(--btn-secondary-hover-text);
        }

        .btn-action {
            display: inline-flex; align-items: center; justify-content: center;
            gap: 4px; padding: 4px 10px; font-size: 10px; font-weight: 500;
            border-radius: 4px; border: 1px solid transparent; cursor: pointer;
            font-family: 'Inter', sans-serif;
        }
        .btn-edit {
            background: rgba(29,78,216,.1); color: #1d4ed8;
            border-color: rgba(29,78,216,.25);
        }
        .btn-edit:hover { background: #1d4ed8; color: #fff; }
        .btn-delete {
            background: rgba(239,68,68,.1); color: #ef4444;
            border-color: rgba(239,68,68,.25);
        }
        .btn-delete:hover { background: #ef4444; color: #fff; }

        .table-container { position: relative; overflow-x: auto; min-height: 120px; }
        .table-container table {
            width: 100% !important; border-collapse: collapse; font-size: 11px;
        }
        .table-container table thead th {
            background-color: var(--table-head-bg) !important;
            color: var(--table-head-text) !important;
            font-weight: 500; text-align: left; padding: 10px 12px;
            border-bottom: 1px solid var(--border-color);
            white-space: nowrap; font-size: 10px;
            text-transform: uppercase; letter-spacing: .5px;
        }
        .table-container table tbody td {
            padding: 10px 12px; border-bottom: 1px solid var(--border-color);
            color: var(--table-row-text); vertical-align: middle;
        }
        .table-container table tbody tr:hover { background-color: var(--table-row-hover); }

        .table-loading-overlay {
            position: absolute; inset: 0; background-color: var(--bg-panel);
            display: flex; align-items: center; justify-content: center;
            gap: 8px; font-size: 12px; color: var(--text-muted); z-index: 5;
        }
        .table-loading-overlay.hidden { display: none; }

        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_length { display: none !important; }
        .dataTables_wrapper .dataTables_info {
            color: var(--text-muted) !important; font-size: 11px !important;
            padding-top: 12px !important;
        }
        .dataTables_wrapper .dataTables_paginate { padding-top: 12px !important; }
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 4px 10px !important; margin: 0 2px !important;
            border-radius: 4px !important; background: var(--toolbar-btn-bg) !important;
            border: 1px solid var(--border-color) !important;
            color: var(--text-muted) !important; font-size: 11px !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #1d4ed8 !important; color: #fff !important;
            border-color: #1d4ed8 !important;
        }

        .dt-buttons { display: flex !important; gap: 6px !important; flex-wrap: wrap !important; }
        .dt-buttons .dt-button {
            padding: 6px 12px !important;
            background-color: var(--toolbar-btn-bg) !important;
            border: 1px solid var(--border-color) !important;
            border-radius: .25rem !important;
            color: var(--text-muted) !important;
            font-size: 10px !important; cursor: pointer !important;
            display: inline-flex !important; align-items: center !important;
            gap: 4px !important; height: 30px !important;
            box-sizing: border-box !important;
        }
        .dt-buttons .dt-button:hover {
            background-color: var(--hover-bg) !important;
            color: var(--text-heading) !important;
        }

        .toolbar-row {
            display: flex; align-items: center; justify-content: space-between;
            gap: 10px; flex-wrap: nowrap; width: 100%;
        }
        .toolbar-left { display: flex; align-items: center; gap: 6px; flex-wrap: wrap; min-width: 0; }
        .toolbar-right { display: flex; align-items: center; gap: 8px; flex-shrink: 0; }

        .offcanvas {
            position: fixed; top: 0; bottom: 0; width: 420px; max-width: 90vw;
            max-height: 100vh; display: flex; flex-direction: column;
            background-color: var(--bg-panel);
            box-shadow: -10px 0 30px rgba(0,0,0,.25);
            transform: translateX(100%);
            transition: transform .3s ease-in-out;
            visibility: hidden; z-index: 99999;
        }
        .offcanvas.offcanvas-end { right: 0; border-left: 1px solid var(--border-color); }
        .offcanvas.showing, .offcanvas.show { transform: translateX(0); visibility: visible; }
        .offcanvas-backdrop {
            position: fixed; inset: 0; background-color: var(--modal-overlay);
            opacity: 0; transition: opacity .15s linear; z-index: 99998;
        }
        .offcanvas-backdrop.show { opacity: 1; }
        .offcanvas-header {
            display: flex; align-items: center; justify-content: space-between;
            padding: 16px 20px; flex-shrink: 0;
            border-bottom: 1px solid var(--border-color);
        }
        .offcanvas-title { margin: 0; }
        .offcanvas-body { flex: 1 1 auto; padding: 20px; overflow-y: auto; }
        .btn-close {
            width: 26px; height: 26px; border: none; background: transparent;
            color: var(--text-muted); cursor: pointer; display: inline-flex;
            align-items: center; justify-content: center;
            border-radius: 4px; padding: 0;
        }
        .btn-close::before { content: "\00d7"; font-size: 20px; line-height: 1; }

        .img-upload-box {
            border: 2px dashed var(--border-color); border-radius: 6px;
            padding: 16px; text-align: center; cursor: pointer;
            background: var(--input-bg); transition: all .2s;
        }
        .img-upload-box:hover { border-color: #1d4ed8; background: var(--hover-bg); }
        .img-upload-box i { font-size: 22px; color: var(--text-muted); margin-bottom: 6px; display: block; }
        .img-upload-box .upload-label { color: var(--text-muted); font-size: 11px; }
        .img-preview-wrap { margin-top: 10px; position: relative; display: inline-block; }
        .img-preview-wrap img {
            max-width: 100%; max-height: 120px; border-radius: 6px;
            border: 1px solid var(--border-color); display: block;
        }
        .img-remove-btn {
            position: absolute; top: -8px; right: -8px; width: 22px; height: 22px;
            border-radius: 50%; background: #ef4444; color: #fff;
            border: 2px solid var(--bg-panel); cursor: pointer; font-size: 11px;
            display: flex; align-items: center; justify-content: center; padding: 0;
        }

        .toast {
            position: fixed; bottom: 30px; right: 30px;
            background: var(--bg-panel); border: 1px solid var(--border-color);
            border-radius: .375rem; padding: 12px 20px;
            color: var(--text-body); font-size: 12px; z-index: 9999;
            transform: translateY(100px); opacity: 0;
            transition: all .3s ease-in-out;
            box-shadow: 0 10px 30px rgba(0,0,0,.25);
        }
        .toast.show { transform: translateY(0); opacity: 1; }
        .toast.success { border-color: #10b981; }
        .toast.success i { color: #10b981; }
        .toast.error { border-color: #ef4444; }
        .toast.error i { color: #ef4444; }

        .cat-badge {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 3px 8px; border-radius: 4px; font-size: 10px;
            font-weight: 500; background: rgba(29,78,216,.1); color: #1d4ed8;
            border: 1px solid rgba(29,78,216,.2);
        }
        html.dark-mode .cat-badge {
            background: rgba(29,78,216,.15); color: #60a5fa;
            border-color: rgba(29,78,216,.35);
        }

        .subcat-badge {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 3px 8px; border-radius: 4px; font-size: 10px;
            font-weight: 500; background: rgba(139,92,246,.1); color: #8b5cf6;
            border: 1px solid rgba(139,92,246,.2);
        }
        html.dark-mode .subcat-badge {
            background: rgba(139,92,246,.15); color: #a78bfa;
            border-color: rgba(139,92,246,.35);
        }

        .status-badge {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 3px 9px; border-radius: 12px; font-size: 10px; font-weight: 600;
        }
        .status-active {
            background: rgba(16,185,129,.12); color: #10b981;
            border: 1px solid rgba(16,185,129,.25);
        }
        .status-inactive {
            background: rgba(148,163,184,.15); color: #94a3b8;
            border: 1px solid rgba(148,163,184,.3);
        }
        .status-dot { width: 6px; height: 6px; border-radius: 50%; background: currentColor; }

        .price-badge {
            display: inline-flex; align-items: center; gap: 4px;
            padding: 2px 8px; border-radius: 4px; font-size: 10px;
            font-weight: 600; background: rgba(16,185,129,.12); color: #10b981;
        }
        .stock-badge {
            display: inline-flex; align-items: center; gap: 4px;
            padding: 2px 8px; border-radius: 4px; font-size: 10px;
            font-weight: 600;
        }
        .stock-in { background: rgba(29,78,216,.12); color: #1d4ed8; }
        .stock-low { background: rgba(234,179,8,.15); color: #eab308; }
        .stock-out { background: rgba(239,68,68,.12); color: #ef4444; }
        html.dark-mode .stock-in { color: #60a5fa; }
        html.dark-mode .stock-low { color: #facc15; }
        html.dark-mode .stock-out { color: #f87171; }

        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: var(--scrollbar-track); }
        ::-webkit-scrollbar-thumb { background: var(--scrollbar-thumb); border-radius: 4px; }

        .hidden { display: none !important; }
    </style>
</head>

<body class="flex h-screen overflow-hidden text-xs">

    <?php include __DIR__ . '/../includes/sidebar.php'; ?>

    <main id="mainContent" class="flex-1 flex flex-col overflow-hidden">

        <?php include __DIR__ . '/../includes/topbar.php'; ?>

        <div class="flex-1 overflow-y-auto p-4" id="pageContent">

            <!-- Page Header -->
            <div class="flex flex-wrap justify-between items-center mb-4 gap-2">
                <div>
                    <h2 class="text-heading font-semibold text-base tracking-wide uppercase">
                        <i class="fa-solid fa-boxes-stacked mr-2 text-blue-500"></i>Product Management
                    </h2>
                    <p class="text-[10px] text-gray-500">Manage categories, sub-categories & lube products</p>
                </div>
                <button onclick="openAddCurrentTab()" class="btn-primary flex items-center gap-2">
                    <i class="fa-solid fa-plus"></i> <span id="addBtnLabel">Add Category</span>
                </button>
            </div>

            <!-- Tabs Header -->
            <div class="tabs-header">
                <button class="tab-btn active" data-tab="category" onclick="switchTab('category')">
                    <i class="fa-solid fa-layer-group"></i> Category
                </button>
                <button class="tab-btn" data-tab="subcategory" onclick="switchTab('subcategory')">
                    <i class="fa-solid fa-sitemap"></i> Sub Category
                </button>
                <button class="tab-btn" data-tab="products" onclick="switchTab('products')">
                    <i class="fa-solid fa-oil-can"></i> Lube Products
                </button>
            </div>

            <!-- ================= TAB 1: CATEGORY ================= -->
            <div class="tab-pane active" id="tab-category">
                <div class="panel-card p-3 mb-4">
                    <div class="toolbar-row">
                        <div class="toolbar-left" id="cat-exportButtons"></div>
                        <div class="toolbar-right">
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-magnifying-glass text-gray-500 text-xs"></i>
                                <input type="text" id="catSearchInput" placeholder="Search categories..." class="form-input text-xs" style="height:30px;padding:4px 10px;width:150px;">
                            </div>
                            <button type="button" onclick="loadCategories()" class="btn-secondary flex items-center gap-2" style="height:30px;padding:4px 12px;">
                                <i class="fa-solid fa-rotate"></i> Refresh
                            </button>
                        </div>
                    </div>
                </div>

                <div class="panel-card overflow-hidden">
                    <div class="table-container">
                        <div class="table-loading-overlay" id="catLoadingOverlay">
                            <i class="fa-solid fa-spinner fa-spin text-blue-400"></i> Loading categories...
                        </div>
                        <table id="catTable" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Category Name</th>
                                    <th>Description</th>
                                    <th>Image</th>
                                    <th>Status</th>
                                    <th style="width:120px;">Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- ================= TAB 2: SUB CATEGORY ================= -->
            <div class="tab-pane" id="tab-subcategory">
                <div class="panel-card p-3 mb-4">
                    <div class="toolbar-row">
                        <div class="toolbar-left" id="subcat-exportButtons"></div>
                        <div class="toolbar-right">
                            <select id="subcatFilterCategory" class="form-input text-xs" style="height:30px;padding:4px 30px 4px 10px;width:180px;">
                                <option value="">All Categories</option>
                            </select>
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-magnifying-glass text-gray-500 text-xs"></i>
                                <input type="text" id="subcatSearchInput" placeholder="Search..." class="form-input text-xs" style="height:30px;padding:4px 10px;width:130px;">
                            </div>
                            <button type="button" onclick="loadSubCategories()" class="btn-secondary flex items-center gap-2" style="height:30px;padding:4px 12px;">
                                <i class="fa-solid fa-rotate"></i> Refresh
                            </button>
                        </div>
                    </div>
                </div>

                <div class="panel-card overflow-hidden">
                    <div class="table-container">
                        <div class="table-loading-overlay" id="subcatLoadingOverlay">
                            <i class="fa-solid fa-spinner fa-spin text-blue-400"></i> Loading sub-categories...
                        </div>
                        <table id="subcatTable" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Sub Category</th>
                                    <th>Category</th>
                                    <th>Description</th>
                                    <th>Image</th>
                                    <th>Status</th>
                                    <th style="width:120px;">Action</th>
                                    <!-- Hello world! -->
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- ================= TAB 3: LUBE PRODUCTS ================= -->
            <div class="tab-pane" id="tab-products">
                <div class="panel-card p-3 mb-4">
                    <div class="toolbar-row">
                        <div class="toolbar-left" id="prod-exportButtons"></div>
                        <div class="toolbar-right">
                            <select id="prodFilterSubcat" class="form-input text-xs" style="height:30px;padding:4px 30px 4px 10px;width:180px;">
                                <option value="">All Sub Categories</option>
                            </select>
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-magnifying-glass text-gray-500 text-xs"></i>
                                <input type="text" id="prodSearchInput" placeholder="Search..." class="form-input text-xs" style="height:30px;padding:4px 10px;width:130px;">
                            </div>
                            <button type="button" onclick="loadProducts()" class="btn-secondary flex items-center gap-2" style="height:30px;padding:4px 12px;">
                                <i class="fa-solid fa-rotate"></i> Refresh
                            </button>
                        </div>
                    </div>
                </div>

                <div class="panel-card overflow-hidden">
                    <div class="table-container">
                        <div class="table-loading-overlay" id="prodLoadingOverlay">
                            <i class="fa-solid fa-spinner fa-spin text-blue-400"></i> Loading products...
                        </div>
                        <table id="prodTable" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Product</th>
                                    <th>SKU</th>
                                    <th>Sub Category</th>
                                    <th>Brand</th>
                                    <th>Price</th>
                                    <th>Discount</th>
                                    <th>Stock</th>
                                    <th>Image</th>
                                    <th>Status</th>
                                    <th style="width:120px;">Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <div id="toast" class="toast">
        <i class="fa-solid fa-check-circle mr-2"></i>
        <span id="toastMessage">Data loaded successfully!</span>
    </div>

    <!-- ================= CATEGORY OFF-CANVAS ================= -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasCategory">
        <div class="offcanvas-header">
            <h5 id="catOffcanvasTitle" class="text-heading text-sm font-semibold offcanvas-title">
                <i class="fa-solid fa-plus-circle mr-2 text-blue-500"></i>Add Category
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <form id="categoryForm" enctype="multipart/form-data">
                <div class="form-group mb-4">
                    <label class="form-label">Category Name <span class="text-red-500">*</span></label>
                    <input type="text" class="form-input" id="cat_name" placeholder="Enter Category Name" required>
                </div>
                <div class="form-group mb-4">
                    <label class="form-label">Description</label>
                    <textarea class="form-input" id="cat_description" rows="3" placeholder="Enter description (optional)"></textarea>
                </div>
                <div class="form-group mb-4">
                    <label class="form-label">Category Image</label>
                    <div class="img-upload-box" onclick="document.getElementById('cat_image_file').click();">
                        <i class="fa-solid fa-cloud-arrow-up"></i>
                        <div class="upload-label">Click to upload image</div>
                        <div class="upload-label" style="font-size:9px;">JPG, PNG, GIF, WEBP • Max 2MB</div>
                    </div>
                    <input type="file" id="cat_image_file" accept="image/*" style="display:none;">
                    <input type="hidden" id="cat_remove_image" value="0">
                    <div class="img-preview-wrap" id="catImgPreviewWrap" style="display:none;">
                        <img id="catImgPreview" src="" alt="">
                        <button type="button" class="img-remove-btn" onclick="removeCatImage()">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                </div>
                <div class="form-group mb-4">
                    <label class="form-label">Status <span class="text-red-500">*</span></label>
                    <select class="form-input" id="cat_status">
                        <option value="active" selected>Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
                <input type="hidden" id="cat_row_id" value="">
                <div class="flex gap-3 mt-4">
                    <button type="submit" class="btn-primary flex-1" id="cat_submitBtn">
                        <i class="fa-regular fa-floppy-disk mr-1"></i> Save
                    </button>
                    <button type="button" class="btn-secondary" data-bs-dismiss="offcanvas">
                        <i class="fa-regular fa-xmark mr-1"></i> Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ================= SUB-CATEGORY OFF-CANVAS ================= -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasSubcat">
        <div class="offcanvas-header">
            <h5 id="subcatOffcanvasTitle" class="text-heading text-sm font-semibold offcanvas-title">
                <i class="fa-solid fa-plus-circle mr-2 text-blue-500"></i>Add Sub Category
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <form id="subcatForm" enctype="multipart/form-data">
                <div class="form-group mb-4">
                    <label class="form-label">Parent Category <span class="text-red-500">*</span></label>
                    <select class="form-input" id="subcat_category_id" required>
                        <option value="">Select Category</option>
                    </select>
                </div>
                <div class="form-group mb-4">
                    <label class="form-label">Sub Category Name <span class="text-red-500">*</span></label>
                    <input type="text" class="form-input" id="subcat_name" placeholder="Enter Sub Category Name" required>
                </div>
                <div class="form-group mb-4">
                    <label class="form-label">Description</label>
                    <textarea class="form-input" id="subcat_description" rows="3" placeholder="Enter description (optional)"></textarea>
                </div>
                <div class="form-group mb-4">
                    <label class="form-label">Sub Category Image</label>
                    <div class="img-upload-box" onclick="document.getElementById('subcat_image_file').click();">
                        <i class="fa-solid fa-cloud-arrow-up"></i>
                        <div class="upload-label">Click to upload image</div>
                        <div class="upload-label" style="font-size:9px;">JPG, PNG, GIF, WEBP • Max 2MB</div>
                    </div>
                    <input type="file" id="subcat_image_file" accept="image/*" style="display:none;">
                    <input type="hidden" id="subcat_remove_image" value="0">
                    <div class="img-preview-wrap" id="subcatImgPreviewWrap" style="display:none;">
                        <img id="subcatImgPreview" src="" alt="">
                        <button type="button" class="img-remove-btn" onclick="removeSubcatImage()">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                </div>
                <div class="form-group mb-4">
                    <label class="form-label">Status <span class="text-red-500">*</span></label>
                    <select class="form-input" id="subcat_status">
                        <option value="active" selected>Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
                <input type="hidden" id="subcat_row_id" value="">
                <div class="flex gap-3 mt-4">
                    <button type="submit" class="btn-primary flex-1" id="subcat_submitBtn">
                        <i class="fa-regular fa-floppy-disk mr-1"></i> Save
                    </button>
                    <button type="button" class="btn-secondary" data-bs-dismiss="offcanvas">
                        <i class="fa-regular fa-xmark mr-1"></i> Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ================= PRODUCT OFF-CANVAS ================= -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasProduct">
        <div class="offcanvas-header">
            <h5 id="prodOffcanvasTitle" class="text-heading text-sm font-semibold offcanvas-title">
                <i class="fa-solid fa-plus-circle mr-2 text-blue-500"></i>Add Lube Product
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <form id="productForm" enctype="multipart/form-data">
                <div class="form-group mb-4">
                    <label class="form-label">Sub Category <span class="text-red-500">*</span></label>
                    <select class="form-input" id="prod_sub_category_id" required>
                        <option value="">Select Sub Category</option>
                    </select>
                </div>
                <div class="form-group mb-4">
                    <label class="form-label">Product Name <span class="text-red-500">*</span></label>
                    <input type="text" class="form-input" id="prod_name" placeholder="Enter Product Name" required>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div class="form-group mb-4">
                        <label class="form-label">Brand</label>
                        <input type="text" class="form-input" id="prod_brand" placeholder="Brand">
                    </div>
                    <div class="form-group mb-4">
                        <label class="form-label">SKU</label>
                        <input type="text" class="form-input" id="prod_sku" placeholder="SKU">
                    </div>
                </div>
                <div class="form-group mb-4">
                    <label class="form-label">Description</label>
                    <textarea class="form-input" id="prod_description" rows="3" placeholder="Description"></textarea>
                </div>
                <div class="grid grid-cols-3 gap-3">
                    <div class="form-group mb-4">
                        <label class="form-label">Price <span class="text-red-500">*</span></label>
                        <input type="number" step="0.01" min="0" class="form-input" id="prod_price" value="0" required>
                    </div>
                    <div class="form-group mb-4">
                        <label class="form-label">Discount %</label>
                        <input type="number" step="0.01" min="0" max="100" class="form-input" id="prod_discount" value="0">
                    </div>
                    <div class="form-group mb-4">
                        <label class="form-label">Stock</label>
                        <input type="number" min="0" class="form-input" id="prod_stock" value="0">
                    </div>
                </div>
                <div class="form-group mb-4">
                    <label class="form-label">Product Image</label>
                    <div class="img-upload-box" onclick="document.getElementById('prod_image_file').click();">
                        <i class="fa-solid fa-cloud-arrow-up"></i>
                        <div class="upload-label">Click to upload image</div>
                        <div class="upload-label" style="font-size:9px;">JPG, PNG, GIF, WEBP • Max 2MB</div>
                    </div>
                    <input type="file" id="prod_image_file" accept="image/*" style="display:none;">
                    <input type="hidden" id="prod_remove_image" value="0">
                    <div class="img-preview-wrap" id="prodImgPreviewWrap" style="display:none;">
                        <img id="prodImgPreview" src="" alt="">
                        <button type="button" class="img-remove-btn" onclick="removeProdImage()">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                </div>
                <div class="form-group mb-4">
                    <label class="form-label">Status <span class="text-red-500">*</span></label>
                    <select class="form-input" id="prod_status">
                        <option value="active" selected>Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
                <input type="hidden" id="prod_row_id" value="">
                <div class="flex gap-3 mt-4">
                    <button type="submit" class="btn-primary flex-1" id="prod_submitBtn">
                        <i class="fa-regular fa-floppy-disk mr-1"></i> Save
                    </button>
                    <button type="button" class="btn-secondary" data-bs-dismiss="offcanvas">
                        <i class="fa-regular fa-xmark mr-1"></i> Cancel
                    </button>
                </div>
            </form>
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
        // ============================================
        // CONFIG & GLOBALS
        // ============================================
        const API_BASE = '/hascol_dashboard/hascol_customer/api/products/';
        let activeTab = 'category';
        let catTable = null, subcatTable = null, prodTable = null;
        window.catStore = {};
        window.subcatStore = {};
        window.prodStore = {};
        window.categoriesList = [];
        window.subcatsList = [];

        // DataTables export buttons config
        const exportButtons = [
            { extend: 'copy', text: '<i class="fa-regular fa-copy"></i> Copy', className: 'dt-button' },
            { extend: 'excelHtml5', text: '<i class="fa-regular fa-file-excel"></i> Excel', className: 'dt-button' },
            { extend: 'csvHtml5', text: '<i class="fa-regular fa-file-csv"></i> CSV', className: 'dt-button' },
            { extend: 'pdfHtml5', text: '<i class="fa-regular fa-file-pdf"></i> PDF', className: 'dt-button', orientation: 'landscape', pageSize: 'A4' },
            { extend: 'print', text: '<i class="fa-solid fa-print"></i> Print', className: 'dt-button' }
        ];

        // ============================================
        // INIT
        // ============================================
        $(document).ready(function() {
            initCatTable();
            initSubcatTable();
            initProdTable();

            $('#catSearchInput').on('keyup', function() {
                if (catTable) catTable.search(this.value).draw();
            });
            $('#subcatSearchInput').on('keyup', function() {
                if (subcatTable) subcatTable.search(this.value).draw();
            });
            $('#prodSearchInput').on('keyup', function() {
                if (prodTable) prodTable.search(this.value).draw();
            });

            $('#subcatFilterCategory').on('change', function() { loadSubCategories(); });
            $('#prodFilterSubcat').on('change', function() { loadProducts(); });

            // File inputs
            $('#cat_image_file').on('change', function() { previewImage(this, 'catImgPreview', 'catImgPreviewWrap', 'cat_remove_image'); });
            $('#subcat_image_file').on('change', function() { previewImage(this, 'subcatImgPreview', 'subcatImgPreviewWrap', 'subcat_remove_image'); });
            $('#prod_image_file').on('change', function() { previewImage(this, 'prodImgPreview', 'prodImgPreviewWrap', 'prod_remove_image'); });

            // Forms
            $('#categoryForm').on('submit', function(e) { e.preventDefault(); saveCategory(); });
            $('#subcatForm').on('submit', function(e) { e.preventDefault(); saveSubcategory(); });
            $('#productForm').on('submit', function(e) { e.preventDefault(); saveProduct(); });

            // Initial loads
            loadCategories(true);
        });

        // ============================================
        // TAB SWITCHING
        // ============================================
        function switchTab(tab) {
            activeTab = tab;
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.toggle('active', b.dataset.tab === tab));
            document.querySelectorAll('.tab-pane').forEach(p => p.classList.toggle('active', p.id === 'tab-' + tab));

            const labels = { category: 'Add Category', subcategory: 'Add Sub Category', products: 'Add Lube Product' };
            document.getElementById('addBtnLabel').textContent = labels[tab];

            if (tab === 'subcategory') { loadCategories(); loadSubCategories(); }
            else if (tab === 'products') { loadCategories(); loadSubCategories(); loadProducts(); }
        }

        function openAddCurrentTab() {
            if (activeTab === 'category') openAddCategory();
            else if (activeTab === 'subcategory') openAddSubcategory();
            else if (activeTab === 'products') openAddProduct();
        }

        // ============================================
        // HELPERS
        // ============================================
        function escapeHtml(text) {
            if (text === null || text === undefined) return '';
            return String(text).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;').replace(/'/g,'&#039;');
        }
        function showToast(message, type = 'success') {
            const toast = $('#toast');
            toast.removeClass('success error').addClass(type);
            $('#toastMessage').text(message);
            toast.addClass('show');
            clearTimeout(window._toastT);
            window._toastT = setTimeout(() => toast.removeClass('show'), 3000);
        }
        function previewImage(input, previewId, wrapId, removeFieldId) {
            const file = input.files && input.files[0];
            if (!file) return;
            if (file.size > 2 * 1024 * 1024) {
                Swal.fire({ icon:'warning', title:'File Too Large', text:'Image must not exceed 2 MB', confirmButtonColor:'#1d4ed8' });
                input.value = ''; return;
            }
            if (!/^image\//.test(file.type)) {
                Swal.fire({ icon:'warning', title:'Invalid File', text:'Please select an image', confirmButtonColor:'#1d4ed8' });
                input.value = ''; return;
            }
            const reader = new FileReader();
            reader.onload = e => {
                $('#' + previewId).attr('src', e.target.result);
                $('#' + wrapId).show();
                $('#' + removeFieldId).val('0');
            };
            reader.readAsDataURL(file);
        }

        // ============================================
        // DATA TABLES INIT  — Fixed: only own buttons move
        // ============================================
        function initCatTable() {
            catTable = $('#catTable').DataTable({
                dom: 'Bfrtip',
                buttons: exportButtons,
                pageLength: 10,
                order: [],
                columnDefs: [{ orderable: false, targets: [0, 2, 3, 4, 5] }],
                language: {
                    emptyTable: 'No categories',
                    info: 'Showing _START_ to _END_ of _TOTAL_',
                    infoEmpty: '0 entries',
                    infoFiltered: '(filtered from _MAX_)'
                },
                initComplete: function () {
                    // ✅ Only THIS table's buttons
                    this.api().buttons().container().appendTo('#cat-exportButtons');
                }
            });
        }

        function initSubcatTable() {
            subcatTable = $('#subcatTable').DataTable({
                dom: 'Bfrtip',
                buttons: exportButtons,
                pageLength: 10,
                order: [],
                columnDefs: [{ orderable: false, targets: [0, 1, 2, 3, 4, 5, 6] }],
                language: {
                    emptyTable: 'No sub-categories',
                    info: 'Showing _START_ to _END_ of _TOTAL_',
                    infoEmpty: '0 entries',
                    infoFiltered: '(filtered from _MAX_)'
                },
                initComplete: function () {
                    // ✅ Only THIS table's buttons
                    this.api().buttons().container().appendTo('#subcat-exportButtons');
                }
            });
        }

        function initProdTable() {
            prodTable = $('#prodTable').DataTable({
                dom: 'Bfrtip',
                buttons: exportButtons,
                pageLength: 10,
                order: [],
                columnDefs: [{ orderable: false, targets: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10] }],
                language: {
                    emptyTable: 'No products',
                    info: 'Showing _START_ to _END_ of _TOTAL_',
                    infoEmpty: '0 entries',
                    infoFiltered: '(filtered from _MAX_)'
                },
                initComplete: function () {
                    // ✅ Only THIS table's buttons
                    this.api().buttons().container().appendTo('#prod-exportButtons');
                }
            });
        }

        // ============================================
        // LOAD CATEGORIES
        // ============================================
        function loadCategories(fillDropdowns) {
            $('#catLoadingOverlay').removeClass('hidden');
            $.ajax({
                url: API_BASE + 'get-categories.php', method: 'POST',
                contentType: 'application/json', data: JSON.stringify({}), dataType: 'json',
                success: function(res) {
                    catTable.clear();
                    window.catStore = {};
                    window.categoriesList = [];

                    if (res && res.status === 'success' && res.categories && res.categories.length) {
                        $.each(res.categories, function(i, d) {
                            window.catStore[d.id] = d;
                            window.categoriesList.push(d);

                            const img = d.image && d.image.trim() !== ''
                                ? '<img src="' + d.image + '" style="width:36px;height:36px;object-fit:cover;border-radius:4px;border:1px solid var(--border-color);" onerror="this.style.display=\'none\'">'
                                : '<span style="color:var(--text-muted);">—</span>';
                            const desc = d.description && d.description.trim() !== ''
                                ? escapeHtml(d.description)
                                : '<span style="color:var(--text-muted);">—</span>';
                            const status = (d.status || 'active').toLowerCase();
                            const stBadge = status === 'active'
                                ? '<span class="status-badge status-active"><span class="status-dot"></span>Active</span>'
                                : '<span class="status-badge status-inactive"><span class="status-dot"></span>Inactive</span>';
                            const action =
                                '<div style="display:flex;gap:6px;">' +
                                '<button class="btn-action btn-edit" onclick="editCategory(' + d.id + ')"><i class="fa-solid fa-pen"></i> Edit</button>' +
                                '<button class="btn-action btn-delete" onclick="deleteCategory(' + d.id + ', \'' + escapeHtml(d.name).replace(/'/g, "\\'") + '\')"><i class="fa-solid fa-trash"></i> Delete</button>' +
                                '</div>';

                            catTable.row.add([
                                i + 1,
                                '<span class="cat-badge"><i class="fa-solid fa-tag"></i> ' + escapeHtml(d.name) + '</span>',
                                desc, img, stBadge, action
                            ]);
                        });
                    } else {
                        catTable.row.add(['<span style="color:var(--text-muted);">No categories</span>', '', '', '', '', '']);
                    }
                    catTable.draw(false);
                    $('#catLoadingOverlay').addClass('hidden');

                    if (fillDropdowns) fillCategoryDropdowns();
                },
                error: function(xhr, s, e) {
                    console.error('Load categories error:', e);
                    catTable.clear().draw();
                    $('#catLoadingOverlay').addClass('hidden');
                    showToast('Failed to load categories', 'error');
                }
            });
        }

        function fillCategoryDropdowns() {
            const filterSubcat = $('#subcatFilterCategory');
            const filterProdSubcat = $('#prodFilterSubcat');
            const subcatFormCat = $('#subcat_category_id');

            const curFilterSubcat = filterSubcat.val();
            const curFilterProdSubcat = filterProdSubcat.val();

            let html = '<option value="">All Categories</option>';
            let formHtml = '<option value="">Select Category</option>';
            window.categoriesList.forEach(c => {
                html += '<option value="' + c.id + '">' + escapeHtml(c.name) + '</option>';
                formHtml += '<option value="' + c.id + '">' + escapeHtml(c.name) + '</option>';
            });
            filterSubcat.html(html).val(curFilterSubcat);
            filterProdSubcat.html(html).val(curFilterProdSubcat);
            subcatFormCat.html(formHtml);
        }

        // ============================================
        // LOAD SUB-CATEGORIES
        // ============================================
        function loadSubCategories() {
            const catId = $('#subcatFilterCategory').val() || '';
            $('#subcatLoadingOverlay').removeClass('hidden');

            $.ajax({
                url: API_BASE + 'get-sub-categories.php', method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(catId ? { category_id: parseInt(catId) } : {}),
                dataType: 'json',
                success: function(res) {
                    subcatTable.clear();
                    window.subcatStore = {};
                    window.subcatsList = [];

                    const list = (res && res.sub_categories) ? res.sub_categories : [];
                    if (list.length) {
                        $.each(list, function(i, d) {
                            window.subcatStore[d.id] = d;
                            window.subcatsList.push(d);

                            const img = d.image && d.image.trim() !== ''
                                ? '<img src="' + d.image + '" style="width:36px;height:36px;object-fit:cover;border-radius:4px;border:1px solid var(--border-color);" onerror="this.style.display=\'none\'">'
                                : '<span style="color:var(--text-muted);">—</span>';
                            const desc = d.description && d.description.trim() !== ''
                                ? escapeHtml(d.description)
                                : '<span style="color:var(--text-muted);">—</span>';
                            const status = (d.status || 'active').toLowerCase();
                            const stBadge = status === 'active'
                                ? '<span class="status-badge status-active"><span class="status-dot"></span>Active</span>'
                                : '<span class="status-badge status-inactive"><span class="status-dot"></span>Inactive</span>';
                            const action =
                                '<div style="display:flex;gap:6px;">' +
                                '<button class="btn-action btn-edit" onclick="editSubcategory(' + d.id + ')"><i class="fa-solid fa-pen"></i> Edit</button>' +
                                '<button class="btn-action btn-delete" onclick="deleteSubcategory(' + d.id + ', \'' + escapeHtml(d.name).replace(/'/g, "\\'") + '\')"><i class="fa-solid fa-trash"></i> Delete</button>' +
                                '</div>';

                            subcatTable.row.add([
                                i + 1,
                                '<span class="subcat-badge"><i class="fa-solid fa-sitemap"></i> ' + escapeHtml(d.name) + '</span>',
                                escapeHtml(d.category_name || '—'),
                                desc, img, stBadge, action
                            ]);
                        });
                    } else {
                        subcatTable.row.add(['<span style="color:var(--text-muted);">No sub-categories</span>','','','','','','']);
                    }
                    subcatTable.draw(false);
                    $('#subcatLoadingOverlay').addClass('hidden');

                    fillSubcatDropdowns();
                },
                error: function(xhr, s, e) {
                    console.error('Load subcats error:', e, xhr.responseText);
                    subcatTable.clear().draw();
                    $('#subcatLoadingOverlay').addClass('hidden');
                    showToast('Failed to load sub-categories', 'error');
                }
            });
        }

        function fillSubcatDropdowns() {
            const filterProd = $('#prodFilterSubcat');
            const formSubcat = $('#prod_sub_category_id');

            const curFilterProd = filterProd.val();

            let filterHtml = '<option value="">All Sub Categories</option>';
            let formHtml = '<option value="">Select Sub Category</option>';

            window.subcatsList.forEach(s => {
                const label = s.name + (s.category_name ? ' (' + s.category_name + ')' : '');
                filterHtml += '<option value="' + s.id + '">' + escapeHtml(label) + '</option>';
                formHtml += '<option value="' + s.id + '">' + escapeHtml(label) + '</option>';
            });

            filterProd.html(filterHtml).val(curFilterProd);
            formSubcat.html(formHtml);
        }

        // ============================================
        // LOAD PRODUCTS
        // ============================================
        function loadProducts() {
            const subcatId = $('#prodFilterSubcat').val() || '';
            $('#prodLoadingOverlay').removeClass('hidden');

            $.ajax({
                url: API_BASE + 'get-lube-products.php', method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(subcatId ? { sub_category_id: parseInt(subcatId) } : {}),
                dataType: 'json',
                success: function(res) {
                    prodTable.clear();
                    window.prodStore = {};

                    const list = (res && res.products) ? res.products : [];
                    if (list.length) {
                        $.each(list, function(i, d) {
                            window.prodStore[d.id] = d;

                            const img = d.image && d.image.trim() !== ''
                                ? '<img src="' + d.image + '" style="width:36px;height:36px;object-fit:cover;border-radius:4px;border:1px solid var(--border-color);" onerror="this.style.display=\'none\'">'
                                : '<span style="color:var(--text-muted);">—</span>';

                            const status = (d.status || 'active').toLowerCase();
                            const stBadge = status === 'active'
                                ? '<span class="status-badge status-active"><span class="status-dot"></span>Active</span>'
                                : '<span class="status-badge status-inactive"><span class="status-dot"></span>Inactive</span>';

                            const price = '<span class="price-badge"><i class="fa-solid fa-tag"></i> ' + Number(d.price).toFixed(2) + '</span>';
                            const discount = d.discount_percent > 0
                                ? '<span style="color:#10b981;font-weight:600;">' + Number(d.discount_percent).toFixed(2) + '%</span>'
                                : '<span style="color:var(--text-muted);">0%</span>';

                            let stockCls = 'stock-in';
                            if (d.stock === 0) stockCls = 'stock-out';
                            else if (d.stock < 10) stockCls = 'stock-low';
                            const stock = '<span class="stock-badge ' + stockCls + '">' + d.stock + '</span>';

                            const action =
                                '<div style="display:flex;gap:6px;">' +
                                '<button class="btn-action btn-edit" onclick="editProduct(' + d.id + ')"><i class="fa-solid fa-pen"></i> Edit</button>' +
                                '<button class="btn-action btn-delete" onclick="deleteProduct(' + d.id + ', \'' + escapeHtml(d.name).replace(/'/g, "\\'") + '\')"><i class="fa-solid fa-trash"></i> Delete</button>' +
                                '</div>';

                            prodTable.row.add([
                                i + 1,
                                '<span style="font-weight:600;color:var(--text-heading);">' + escapeHtml(d.name) + '</span>',
                                d.sku ? escapeHtml(d.sku) : '<span style="color:var(--text-muted);">—</span>',
                                escapeHtml(d.sub_category_name || '—'),
                                d.brand ? escapeHtml(d.brand) : '<span style="color:var(--text-muted);">—</span>',
                                price, discount, stock, img, stBadge, action
                            ]);
                        });
                    } else {
                        prodTable.row.add(['<span style="color:var(--text-muted);">No products</span>','','','','','','','','','','']);
                    }
                    prodTable.draw(false);
                    $('#prodLoadingOverlay').addClass('hidden');
                },
                error: function(xhr, s, e) {
                    console.error('Load products error:', e, xhr.responseText);
                    prodTable.clear().draw();
                    $('#prodLoadingOverlay').addClass('hidden');
                    showToast('Failed to load products', 'error');
                }
            });
        }

        // ============================================
        // CATEGORY CRUD
        // ============================================
        function openAddCategory() {
            resetCatForm();
            $('#catOffcanvasTitle').html('<i class="fa-solid fa-plus-circle mr-2 text-blue-500"></i>Add Category');
            $('#cat_submitBtn').html('<i class="fa-regular fa-floppy-disk mr-1"></i> Save');
            bootstrap.Offcanvas.getOrCreateInstance(document.getElementById('offcanvasCategory')).show();
        }
        function editCategory(id) {
            const d = window.catStore[id]; if (!d) return;
            resetCatForm();
            $('#cat_row_id').val(d.id);
            $('#cat_name').val(d.name || '');
            $('#cat_description').val(d.description || '');
            $('#cat_status').val((d.status || 'active').toLowerCase());
            if (d.image && d.image.trim() !== '') {
                $('#catImgPreview').attr('src', d.image);
                $('#catImgPreviewWrap').show();
            }
            $('#catOffcanvasTitle').html('<i class="fa-solid fa-pen-to-square mr-2 text-blue-500"></i>Edit Category');
            $('#cat_submitBtn').html('<i class="fa-regular fa-floppy-disk mr-1"></i> Update');
            bootstrap.Offcanvas.getOrCreateInstance(document.getElementById('offcanvasCategory')).show();
        }
        function resetCatForm() {
            $('#categoryForm')[0].reset();
            $('#cat_row_id').val('');
            $('#cat_remove_image').val('0');
            $('#cat_status').val('active');
            $('#catImgPreview').attr('src', '');
            $('#catImgPreviewWrap').hide();
        }
        function removeCatImage() {
            $('#catImgPreview').attr('src','').parent().hide();
            $('#cat_image_file').val('');
            $('#cat_remove_image').val('1');
        }
        function saveCategory() {
            const id = $('#cat_row_id').val();
            const isEdit = id && id !== '';
            const name = ($('#cat_name').val() || '').trim();
            const description = ($('#cat_description').val() || '').trim();
            const status = ($('#cat_status').val() || 'active').trim();

            if (!name) { Swal.fire({ icon:'warning', title:'Validation', text:'Category name required', confirmButtonColor:'#1d4ed8' }); return; }
            if (name.length > 100) { Swal.fire({ icon:'warning', title:'Validation', text:'Name max 100 chars', confirmButtonColor:'#1d4ed8' }); return; }

            const fd = new FormData();
            fd.append('name', name);
            fd.append('description', description);
            fd.append('status', status);
            fd.append('remove_image', $('#cat_remove_image').val() || '0');
            fd.append('sort_order', '0');
            if (isEdit) fd.append('id', parseInt(id));
            const f = document.getElementById('cat_image_file');
            if (f.files && f.files[0]) fd.append('image_file', f.files[0]);

            const url = API_BASE + (isEdit ? 'update-category.php' : 'create-category.php');
            const btn = $('#cat_submitBtn');
            btn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin mr-1"></i> Saving...');

            $.ajax({
                url: url, method: 'POST', data: fd, processData: false, contentType: false, dataType: 'json',
                success: function(res) {
                    btn.prop('disabled', false).html('<i class="fa-regular fa-floppy-disk mr-1"></i> ' + (isEdit ? 'Update' : 'Save'));
                    if (res && res.status === 'success') {
                        Swal.fire({ icon:'success', title: isEdit ? 'Updated!' : 'Created!', text: res.message,
                            confirmButtonText:'OK', confirmButtonColor:'#1d4ed8' }).then(r => {
                            if (r.isConfirmed) {
                                bootstrap.Offcanvas.getInstance(document.getElementById('offcanvasCategory')).hide();
                                resetCatForm();
                                loadCategories(true);
                                loadSubCategories();
                            }
                        });
                    } else {
                        Swal.fire({ icon:'error', title:'Error!', text: res.message || 'Failed', confirmButtonText:'OK', confirmButtonColor:'#1d4ed8' });
                    }
                },
                error: function() {
                    btn.prop('disabled', false).html('<i class="fa-regular fa-floppy-disk mr-1"></i> ' + (isEdit ? 'Update' : 'Save'));
                    Swal.fire({ icon:'error', title:'Server Error', text:'Request failed', confirmButtonText:'OK', confirmButtonColor:'#1d4ed8' });
                }
            });
        }
        function deleteCategory(id, name) {
            Swal.fire({
                icon:'warning', title:'Delete Category?',
                html:'Delete <b>' + escapeHtml(name) + '</b>?<br><small style="color:#94a3b8;">This cannot be undone.</small>',
                showCancelButton:true, confirmButtonColor:'#ef4444', cancelButtonColor:'#64748b',
                confirmButtonText:'<i class="fa-solid fa-trash"></i> Yes, Delete', cancelButtonText:'Cancel', reverseButtons:true
            }).then(r => {
                if (!r.isConfirmed) return;
                $.ajax({
                    url: API_BASE + 'delete-category.php', method:'POST',
                    contentType:'application/json', data: JSON.stringify({ id: id }), dataType:'json',
                    success: function(res) {
                        if (res && res.status === 'success') {
                            Swal.fire({ icon:'success', title:'Deleted!', text: res.message, confirmButtonText:'OK', confirmButtonColor:'#1d4ed8' });
                            loadCategories(true);
                            loadSubCategories();
                        } else {
                            Swal.fire({ icon:'error', title:'Error', text: res.message || 'Delete failed', confirmButtonText:'OK', confirmButtonColor:'#1d4ed8' });
                        }
                    },
                    error: function() { Swal.fire({ icon:'error', title:'Server Error', text:'Delete failed', confirmButtonText:'OK', confirmButtonColor:'#1d4ed8' }); }
                });
            });
        }

        // ============================================
        // SUB-CATEGORY CRUD
        // ============================================
        function openAddSubcategory() {
            resetSubcatForm();
            loadCategories(true);
            $('#subcatOffcanvasTitle').html('<i class="fa-solid fa-plus-circle mr-2 text-blue-500"></i>Add Sub Category');
            $('#subcat_submitBtn').html('<i class="fa-regular fa-floppy-disk mr-1"></i> Save');
            bootstrap.Offcanvas.getOrCreateInstance(document.getElementById('offcanvasSubcat')).show();
        }
        function editSubcategory(id) {
            const d = window.subcatStore[id]; if (!d) return;
            resetSubcatForm();
            fillCategoryDropdowns();
            $('#subcat_row_id').val(d.id);
            $('#subcat_category_id').val(d.category_id);
            $('#subcat_name').val(d.name || '');
            $('#subcat_description').val(d.description || '');
            $('#subcat_status').val((d.status || 'active').toLowerCase());
            if (d.image && d.image.trim() !== '') {
                $('#subcatImgPreview').attr('src', d.image);
                $('#subcatImgPreviewWrap').show();
            }
            $('#subcatOffcanvasTitle').html('<i class="fa-solid fa-pen-to-square mr-2 text-blue-500"></i>Edit Sub Category');
            $('#subcat_submitBtn').html('<i class="fa-regular fa-floppy-disk mr-1"></i> Update');
            bootstrap.Offcanvas.getOrCreateInstance(document.getElementById('offcanvasSubcat')).show();
        }
        function resetSubcatForm() {
            $('#subcatForm')[0].reset();
            $('#subcat_row_id').val('');
            $('#subcat_remove_image').val('0');
            $('#subcat_status').val('active');
            $('#subcatImgPreview').attr('src', '');
            $('#subcatImgPreviewWrap').hide();
        }
        function removeSubcatImage() {
            $('#subcatImgPreview').attr('src','').parent().hide();
            $('#subcat_image_file').val('');
            $('#subcat_remove_image').val('1');
        }
        function saveSubcategory() {
            const id = $('#subcat_row_id').val();
            const isEdit = id && id !== '';
            const catId = parseInt($('#subcat_category_id').val() || 0);
            const name = ($('#subcat_name').val() || '').trim();
            const description = ($('#subcat_description').val() || '').trim();
            const status = ($('#subcat_status').val() || 'active').trim();

            if (!catId) { Swal.fire({ icon:'warning', title:'Validation', text:'Please select a category', confirmButtonColor:'#1d4ed8' }); return; }
            if (!name) { Swal.fire({ icon:'warning', title:'Validation', text:'Sub-category name required', confirmButtonColor:'#1d4ed8' }); return; }

            const fd = new FormData();
            fd.append('category_id', catId);
            fd.append('name', name);
            fd.append('description', description);
            fd.append('status', status);
            fd.append('remove_image', $('#subcat_remove_image').val() || '0');
            fd.append('sort_order', '0');
            if (isEdit) fd.append('id', parseInt(id));
            const f = document.getElementById('subcat_image_file');
            if (f.files && f.files[0]) fd.append('image_file', f.files[0]);

            const url = API_BASE + (isEdit ? 'update-sub-category.php' : 'create-sub-category.php');
            const btn = $('#subcat_submitBtn');
            btn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin mr-1"></i> Saving...');

            $.ajax({
                url: url, method:'POST', data: fd, processData:false, contentType:false, dataType:'json',
                success: function(res) {
                    btn.prop('disabled', false).html('<i class="fa-regular fa-floppy-disk mr-1"></i> ' + (isEdit ? 'Update' : 'Save'));
                    if (res && res.status === 'success') {
                        Swal.fire({ icon:'success', title: isEdit ? 'Updated!' : 'Created!', text: res.message,
                            confirmButtonText:'OK', confirmButtonColor:'#1d4ed8' }).then(r => {
                            if (r.isConfirmed) {
                                bootstrap.Offcanvas.getInstance(document.getElementById('offcanvasSubcat')).hide();
                                resetSubcatForm();
                                loadSubCategories();
                            }
                        });
                    } else {
                        Swal.fire({ icon:'error', title:'Error!', text: res.message || 'Failed', confirmButtonText:'OK', confirmButtonColor:'#1d4ed8' });
                    }
                },
                error: function() {
                    btn.prop('disabled', false).html('<i class="fa-regular fa-floppy-disk mr-1"></i> ' + (isEdit ? 'Update' : 'Save'));
                    Swal.fire({ icon:'error', title:'Server Error', text:'Request failed', confirmButtonText:'OK', confirmButtonColor:'#1d4ed8' });
                }
            });
        }
        function deleteSubcategory(id, name) {
            Swal.fire({
                icon:'warning', title:'Delete Sub Category?',
                html:'Delete <b>' + escapeHtml(name) + '</b>?',
                showCancelButton:true, confirmButtonColor:'#ef4444', cancelButtonColor:'#64748b',
                confirmButtonText:'<i class="fa-solid fa-trash"></i> Yes, Delete', cancelButtonText:'Cancel', reverseButtons:true
            }).then(r => {
                if (!r.isConfirmed) return;
                $.ajax({
                    url: API_BASE + 'delete-sub-category.php', method:'POST',
                    contentType:'application/json', data: JSON.stringify({ id: id }), dataType:'json',
                    success: function(res) {
                        if (res && res.status === 'success') {
                            Swal.fire({ icon:'success', title:'Deleted!', text: res.message, confirmButtonText:'OK', confirmButtonColor:'#1d4ed8' });
                            loadSubCategories();
                        } else {
                            Swal.fire({ icon:'error', title:'Error', text: res.message || 'Delete failed', confirmButtonText:'OK', confirmButtonColor:'#1d4ed8' });
                        }
                    },
                    error: function() { Swal.fire({ icon:'error', title:'Server Error', text:'Delete failed', confirmButtonText:'OK', confirmButtonColor:'#1d4ed8' }); }
                });
            });
        }

        // ============================================
        // PRODUCT CRUD
        // ============================================
        function openAddProduct() {
            resetProdForm();
            loadCategories(true);
            loadSubCategories();
            setTimeout(fillSubcatDropdowns, 300);
            $('#prodOffcanvasTitle').html('<i class="fa-solid fa-plus-circle mr-2 text-blue-500"></i>Add Lube Product');
            $('#prod_submitBtn').html('<i class="fa-regular fa-floppy-disk mr-1"></i> Save');
            bootstrap.Offcanvas.getOrCreateInstance(document.getElementById('offcanvasProduct')).show();
        }
        function editProduct(id) {
            const d = window.prodStore[id]; if (!d) return;
            resetProdForm();
            fillSubcatDropdowns();
            $('#prod_row_id').val(d.id);
            $('#prod_sub_category_id').val(d.sub_category_id);
            $('#prod_name').val(d.name || '');
            $('#prod_brand').val(d.brand || '');
            $('#prod_sku').val(d.sku || '');
            $('#prod_description').val(d.description || '');
            $('#prod_price').val(d.price || 0);
            $('#prod_discount').val(d.discount_percent || 0);
            $('#prod_stock').val(d.stock || 0);
            $('#prod_status').val((d.status || 'active').toLowerCase());
            if (d.image && d.image.trim() !== '') {
                $('#prodImgPreview').attr('src', d.image);
                $('#prodImgPreviewWrap').show();
            }
            $('#prodOffcanvasTitle').html('<i class="fa-solid fa-pen-to-square mr-2 text-blue-500"></i>Edit Lube Product');
            $('#prod_submitBtn').html('<i class="fa-regular fa-floppy-disk mr-1"></i> Update');
            bootstrap.Offcanvas.getOrCreateInstance(document.getElementById('offcanvasProduct')).show();
        }
        function resetProdForm() {
            $('#productForm')[0].reset();
            $('#prod_row_id').val('');
            $('#prod_remove_image').val('0');
            $('#prod_status').val('active');
            $('#prod_price').val(0);
            $('#prod_discount').val(0);
            $('#prod_stock').val(0);
            $('#prodImgPreview').attr('src', '');
            $('#prodImgPreviewWrap').hide();
        }
        function removeProdImage() {
            $('#prodImgPreview').attr('src','').parent().hide();
            $('#prod_image_file').val('');
            $('#prod_remove_image').val('1');
        }
        function saveProduct() {
            const id = $('#prod_row_id').val();
            const isEdit = id && id !== '';
            const subcatId = parseInt($('#prod_sub_category_id').val() || 0);
            const name = ($('#prod_name').val() || '').trim();
            const brand = ($('#prod_brand').val() || '').trim();
            const sku = ($('#prod_sku').val() || '').trim();
            const description = ($('#prod_description').val() || '').trim();
            const price = parseFloat($('#prod_price').val() || 0);
            const discount = parseFloat($('#prod_discount').val() || 0);
            const stock = parseInt($('#prod_stock').val() || 0);
            const status = ($('#prod_status').val() || 'active').trim();

            if (!subcatId) { Swal.fire({ icon:'warning', title:'Validation', text:'Please select a sub-category', confirmButtonColor:'#1d4ed8' }); return; }
            if (!name) { Swal.fire({ icon:'warning', title:'Validation', text:'Product name required', confirmButtonColor:'#1d4ed8' }); return; }
            if (price < 0) { Swal.fire({ icon:'warning', title:'Validation', text:'Price cannot be negative', confirmButtonColor:'#1d4ed8' }); return; }
            if (discount < 0 || discount > 100) { Swal.fire({ icon:'warning', title:'Validation', text:'Discount must be 0-100', confirmButtonColor:'#1d4ed8' }); return; }
            if (stock < 0) { Swal.fire({ icon:'warning', title:'Validation', text:'Stock cannot be negative', confirmButtonColor:'#1d4ed8' }); return; }

            const fd = new FormData();
            fd.append('sub_category_id', subcatId);
            fd.append('name', name);
            fd.append('brand', brand);
            fd.append('sku', sku);
            fd.append('description', description);
            fd.append('price', price);
            fd.append('discount_percent', discount);
            fd.append('stock', stock);
            fd.append('status', status);
            fd.append('remove_image', $('#prod_remove_image').val() || '0');
            if (isEdit) fd.append('id', parseInt(id));
            const f = document.getElementById('prod_image_file');
            if (f.files && f.files[0]) fd.append('image_file', f.files[0]);

            const url = API_BASE + (isEdit ? 'update-lube-product.php' : 'create-lube-product.php');
            const btn = $('#prod_submitBtn');
            btn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin mr-1"></i> Saving...');

            $.ajax({
                url: url, method:'POST', data: fd, processData:false, contentType:false, dataType:'json',
                success: function(res) {
                    btn.prop('disabled', false).html('<i class="fa-regular fa-floppy-disk mr-1"></i> ' + (isEdit ? 'Update' : 'Save'));
                    if (res && res.status === 'success') {
                        Swal.fire({ icon:'success', title: isEdit ? 'Updated!' : 'Created!', text: res.message,
                            confirmButtonText:'OK', confirmButtonColor:'#1d4ed8' }).then(r => {
                            if (r.isConfirmed) {
                                bootstrap.Offcanvas.getInstance(document.getElementById('offcanvasProduct')).hide();
                                resetProdForm();
                                loadProducts();
                            }
                        });
                    } else {
                        Swal.fire({ icon:'error', title:'Error!', text: res.message || 'Failed', confirmButtonText:'OK', confirmButtonColor:'#1d4ed8' });
                    }
                },
                error: function() {
                    btn.prop('disabled', false).html('<i class="fa-regular fa-floppy-disk mr-1"></i> ' + (isEdit ? 'Update' : 'Save'));
                    Swal.fire({ icon:'error', title:'Server Error', text:'Request failed', confirmButtonText:'OK', confirmButtonColor:'#1d4ed8' });
                }
            });
        }
        function deleteProduct(id, name) {
            Swal.fire({
                icon:'warning', title:'Delete Product?',
                html:'Delete <b>' + escapeHtml(name) + '</b>?',
                showCancelButton:true, confirmButtonColor:'#ef4444', cancelButtonColor:'#64748b',
                confirmButtonText:'<i class="fa-solid fa-trash"></i> Yes, Delete', cancelButtonText:'Cancel', reverseButtons:true
            }).then(r => {
                if (!r.isConfirmed) return;
                $.ajax({
                    url: API_BASE + 'delete-lube-product.php', method:'POST',
                    contentType:'application/json', data: JSON.stringify({ id: id }), dataType:'json',
                    success: function(res) {
                        if (res && res.status === 'success') {
                            Swal.fire({ icon:'success', title:'Deleted!', text: res.message, confirmButtonText:'OK', confirmButtonColor:'#1d4ed8' });
                            loadProducts();
                        } else {
                            Swal.fire({ icon:'error', title:'Error', text: res.message || 'Delete failed', confirmButtonText:'OK', confirmButtonColor:'#1d4ed8' });
                        }
                    },
                    error: function() { Swal.fire({ icon:'error', title:'Server Error', text:'Delete failed', confirmButtonText:'OK', confirmButtonColor:'#1d4ed8' }); }
                });
            });
        }
    </script>

</body>
</html>