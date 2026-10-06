<?php
require_once __DIR__ . '/session/session.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>User Permissions | Hascol OMC</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
        }

        body {
            background-color: var(--bg-body);
            color: var(--text-body);
            font-family: 'Inter', sans-serif;
        }

        .panel-card {
            background-color: var(--bg-panel);
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
        }

        .text-heading {
            color: var(--text-heading) !important;
        }

        .form-select {
            background-color: var(--input-bg);
            border: 1px solid var(--border-color);
            border-radius: 0.375rem;
            color: var(--text-body);
            padding: 10px 14px;
            width: 100%;
            font-size: 13px;
            cursor: pointer;
        }

        .form-select:focus {
            outline: none;
            border-color: #f97316;
            box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.15);
        }

        .perm-card {
            background-color: var(--bg-panel);
            border: 1.5px solid var(--border-color);
            border-radius: 0.5rem;
            padding: 12px 14px;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .perm-card:hover {
            border-color: #f97316;
            background-color: var(--hover-bg);
        }

        .perm-card.selected {
            border-color: #f97316;
            background-color: rgba(249, 115, 22, 0.08);
        }

        .perm-card input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: #f97316;
            cursor: pointer;
            flex-shrink: 0;
        }

        .perm-card label {
            cursor: pointer;
            font-size: 12px;
            font-weight: 500;
            color: var(--text-body);
            flex: 1;
            margin: 0;
        }

        .btn-primary {
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
            color: #ffffff;
            padding: 10px 24px;
            border-radius: 0.5rem;
            border: none;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.25s ease;
            box-shadow: 0 8px 20px -8px rgba(249, 115, 22, 0.5);
        }

        .btn-primary:hover:not(:disabled) {
            transform: translateY(-1px);
            box-shadow: 0 12px 24px -8px rgba(249, 115, 22, 0.7);
        }

        .btn-primary:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .action-chip {
            padding: 6px 12px;
            border-radius: 0.375rem;
            font-size: 11px;
            font-weight: 600;
            cursor: pointer;
            border: 1px solid var(--border-color);
            background: var(--bg-panel);
            color: var(--text-body);
            transition: all 0.2s;
        }

        .action-chip:hover {
            border-color: #f97316;
            color: #f97316;
        }

        .page-section {
            margin-bottom: 20px;
        }

        .page-section-title {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-muted);
            margin-bottom: 10px;
            padding-bottom: 6px;
            border-bottom: 1px dashed var(--border-color);
        }
    </style>
</head>

<body class="p-4 md:p-6">

    <!-- Header -->
    <div class="flex flex-wrap justify-between items-center mb-5 gap-3">
        <div>
            <h1 class="text-heading font-bold text-xl tracking-wide">
                <i class="fa-solid fa-shield-halved text-orange-500 mr-2"></i>User Permissions
            </h1>
            <p class="text-xs mt-1" style="color: var(--text-muted);">
                Assign pages to users — they'll only see what you allow
            </p>
        </div>
    </div>

    <!-- User Select Panel -->
    <div class="panel-card p-4 mb-5">
        <label class="block text-xs font-semibold mb-2" style="color: var(--text-muted);">
            Select Privilege
        </label>

        <select class="form-select" id="privilegeSelect">
            <option value="">-- Select a privilege --</option>
            <option value="Admin">Admin</option>
            <option value="App_order">App_order</option>
            <option value="ASM">ASM</option>
            <option value="Back_orders">Back_orders</option>
            <option value="BSO">BSO</option>
            <option value="Cartraige">Cartraige</option>
            <option value="Depot">Depot</option>
            <option value="Eng">Eng</option>
            <option value="Finance">Finance</option>
            <option value="Forward_order">Forward_order</option>
            <option value="Logistics">Logistics</option>
            <option value="Reporting">Reporting</option>
            <option value="Sales">Sales</option>
            <option value="TM">TM</option>
            <option value="tracker">tracker</option>
            <option value="vitol">vitol</option>
            <option value="ZM">ZM</option>
        </select>
    </div>

    <!-- Permissions Panel -->
    <div class="panel-card p-4" id="permissionsPanel" style="display: none;">

        <!-- Toolbar -->
        <div class="flex flex-wrap items-center justify-between gap-3 mb-5">
            <div>
                <h2 class="text-heading font-semibold text-sm">
                    <i class="fa-solid fa-list-check text-orange-500 mr-1"></i>
                    Pages List
                </h2>
                <p class="text-xs mt-0.5" style="color: var(--text-muted);">
                    <span id="selectedCount">0</span> of <span id="totalCount">0</span> pages selected
                </p>
            </div>
            <div class="flex items-center gap-2">
                <button type="button" class="action-chip" onclick="selectAll()">
                    <i class="fa-solid fa-check-double mr-1"></i>Select All
                </button>
                <button type="button" class="action-chip" onclick="deselectAll()">
                    <i class="fa-solid fa-xmark mr-1"></i>Deselect All
                </button>
            </div>
        </div>

        <!-- Pages Grid -->
        <div id="pagesGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2 mb-5"></div>

        <!-- Save Button -->
        <div class="flex justify-end gap-3 pt-4 border-t" style="border-color: var(--border-color);">
            <button type="button" class="btn-primary" id="saveBtn" onclick="savePermissions()">
                <i class="fa-regular fa-floppy-disk"></i> Save Permissions
            </button>
        </div>

    </div>

    <!-- Empty State -->
    <div id="emptyState" class="panel-card p-10 text-center" style="color: var(--text-muted);">
        <i class="fa-solid fa-user-shield text-3xl mb-3 opacity-50"></i>
        <p class="text-sm">Select a privilege to manage its page permissions</p>
    </div>


    <script>
        const API_BASE = 'api/permissions/';
        const API_KEY = '03201232927';

        let allPages = [];
        let currentPrivilege = null;

        $(document).ready(function () {
            loadAllPages();
        });

        // ============ Load All Pages ============
        function loadAllPages() {
            $.ajax({
                url: API_BASE + 'get_all_pages.php?key=' + API_KEY,
                method: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (Array.isArray(response)) {
                        allPages = response;
                        $('#totalCount').text(allPages.length);
                    }
                },
                error: function () {
                    Swal.fire('Error', 'Failed to load pages', 'error');
                }
            });
        }

        // ============ On Privilege Select ============
        $('#privilegeSelect').on('change', function () {
            const privilege = $(this).val();

            if (!privilege) {
                currentPrivilege = null;
                $('#permissionsPanel').hide();
                $('#emptyState').show();
                return;
            }

            currentPrivilege = privilege;
            $('#emptyState').hide();
            $('#permissionsPanel').show();

            renderPages([]);
            loadPrivilegePermissions(privilege);
        });

        // ============ Load Privilege's Existing Permissions ============
        function loadPrivilegePermissions(privilege) {
            $.ajax({
                url: API_BASE + 'get_privilege_permissions.php?key=' + API_KEY + '&privilege=' + encodeURIComponent(privilege),
                method: 'GET',
                dataType: 'json',
                success: function (response) {
                    const allowed = (response && response.page_ids) ? response.page_ids : [];
                    renderPages(allowed);
                },
                error: function () {
                    Swal.fire('Error', 'Failed to load permissions', 'error');
                }
            });
        }

        // ============ Render Page Checkboxes ============
        function renderPages(selectedIds) {
            const grid = $('#pagesGrid');
            grid.empty();

            if (allPages.length === 0) {
                grid.html('<p class="text-xs col-span-full text-center py-4" style="color: var(--text-muted);">No pages available</p>');
                return;
            }

            $.each(allPages, function (i, page) {
                const isChecked = selectedIds.includes(parseInt(page.id));
                const card = `
            <div class="perm-card ${isChecked ? 'selected' : ''}" data-page-id="${page.id}">
                <input type="checkbox" id="page_${page.id}" value="${page.id}" 
                       ${isChecked ? 'checked' : ''}
                       onchange="toggleCard(this)">
                <label for="page_${page.id}">
                    ${page.page_name}
                    <span style="display:block;font-size:10px;color:var(--text-muted);font-weight:400;">
                        ${page.page_url}
                    </span>
                </label>
            </div>
        `;
                grid.append(card);
            });

            updateCount();
        }

        // ============ Toggle Card Style ============
        function toggleCard(checkbox) {
            const card = $(checkbox).closest('.perm-card');
            if ($(checkbox).is(':checked')) {
                card.addClass('selected');
            } else {
                card.removeClass('selected');
            }
            updateCount();
        }

        // ============ Update Selected Count ============
        function updateCount() {
            const count = $('.perm-card input[type="checkbox"]:checked').length;
            $('#selectedCount').text(count);
        }

        // ============ Select All / Deselect All ============
        function selectAll() {
            $('.perm-card input[type="checkbox"]').prop('checked', true);
            $('.perm-card').addClass('selected');
            updateCount();
        }

        function deselectAll() {
            $('.perm-card input[type="checkbox"]').prop('checked', false);
            $('.perm-card').removeClass('selected');
            updateCount();
        }

        // ============ Save Permissions ============
        function savePermissions() {
            if (!currentPrivilege) {
                Swal.fire('Warning', 'Please select a privilege first', 'warning');
                return;
            }

            const selected = [];
            $('.perm-card input[type="checkbox"]:checked').each(function () {
                selected.push($(this).val());
            });

            const btn = $('#saveBtn');
            btn.prop('disabled', true);
            btn.html('<i class="fa-solid fa-spinner fa-spin"></i> Saving...');

            $.ajax({
                url: API_BASE + 'save_permissions.php',
                method: 'POST',
                dataType: 'json',
                data: {
                    key: API_KEY,
                    privilege: currentPrivilege,
                    page_ids: selected.join(',')
                },
                success: function (response) {
                    btn.prop('disabled', false);
                    btn.html('<i class="fa-regular fa-floppy-disk"></i> Save Permissions');

                    if (response.status === 1) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Saved!',
                            text: response.message || 'Permissions saved successfully',
                            timer: 1500,
                            showConfirmButton: false
                        });
                    } else {
                        Swal.fire('Error', response.message || 'Failed to save', 'error');
                    }
                },
                error: function (xhr, status, error) {
                    btn.prop('disabled', false);
                    btn.html('<i class="fa-regular fa-floppy-disk"></i> Save Permissions');
                    Swal.fire('Error', 'Request failed: ' + error, 'error');
                }
            });
        }
    </script>

</body>

</html>