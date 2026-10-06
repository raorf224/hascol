<!-- includes/topbar.php -->

<?php
// Session se user data fetch karo (agar session already include nahi hua)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$topbar_user_name      = $_SESSION['user_name']  ?? 'User';
$topbar_user_privilege = $_SESSION['privilege']  ?? '';
$topbar_user_initial   = strtoupper(substr($topbar_user_name, 0, 1));
?>

<header class="h-auto flex flex-wrap items-center justify-between px-4 py-3 border-b flex-shrink-0 gap-2" 
        style="background-color: var(--topbar-bg); border-color: var(--border-color);">
    
    <!-- Left Side: Toggle Button + Title -->
    <div class="flex items-center gap-3">
        <!-- Sidebar Toggle Button -->
        <button id="sidebarToggle" class="transition-colors duration-200 focus:outline-none" 
                style="color: var(--text-muted);" 
                onmouseover="this.style.color='var(--text-heading)'" 
                onmouseout="this.style.color='var(--text-muted)'" 
                onclick="handleSidebarToggle()">
            <i class="fa-solid fa-bars text-lg"></i>
        </button>
        
        <div>
            <h2 class="font-semibold text-[14px] tracking-wide uppercase" style="color: var(--text-heading);">
                HASCOL OMC OPERATIONS COMMAND CENTER
            </h2>
            <p class="text-[11px]" style="color: var(--text-muted);">Real-time Performance & Intelligence Dashboard</p>
        </div>
    </div>

    <!-- Right Side: User Info / Actions -->
    <div class="flex items-center gap-3">

        <!-- ===== THEME DROPDOWN ===== -->
        <div class="theme-dropdown relative">
            <button id="themeDropdownBtn" 
                onclick="toggleThemeDropdown()"
                class="theme-dropdown-btn flex items-center gap-1.5 px-2.5 py-1.5 rounded-md border transition-all duration-200 focus:outline-none"
                style="background-color: var(--input-bg); border-color: var(--border-color); color: var(--text-body);">
                <i id="themeDropdownIcon" class="fa-solid fa-moon text-[12px]"></i>
                <span id="themeDropdownText" class="text-[11px] font-medium">Dark</span>
                <i class="fa-solid fa-chevron-down text-[9px] ml-0.5" style="color: var(--text-muted);"></i>
            </button>

            <!-- Dropdown Menu -->
            <div id="themeDropdownMenu" 
                class="theme-dropdown-menu absolute right-0 mt-1.5 min-w-[140px] rounded-lg border shadow-lg overflow-hidden opacity-0 invisible transition-all duration-200 z-50"
                style="background-color: var(--bg-panel); border-color: var(--border-color); transform: translateY(-8px) scale(0.98);">
                
                <!-- Light Mode Option -->
                <div class="theme-option flex items-center gap-2.5 px-3.5 py-2.5 cursor-pointer transition-colors duration-150"
                    data-theme="light"
                    onclick="selectTheme('light')"
                    style="color: var(--text-body);">
                    <i class="fa-solid fa-sun text-[13px]"></i>
                    <span class="text-[12px] font-medium">Light</span>
                    <i class="fa-solid fa-check text-[10px] ml-auto theme-check" style="color: var(--text-muted); opacity: 0;"></i>
                </div>

                <!-- Dark Mode Option -->
                <div class="theme-option flex items-center gap-2.5 px-3.5 py-2.5 cursor-pointer transition-colors duration-150 border-t"
                    data-theme="dark"
                    onclick="selectTheme('dark')"
                    style="color: var(--text-body); border-color: var(--border-color);">
                    <i class="fa-solid fa-moon text-[13px]"></i>
                    <span class="text-[12px] font-medium">Dark</span>
                    <i class="fa-solid fa-check text-[10px] ml-auto theme-check" style="color: var(--text-muted); opacity: 0;"></i>
                </div>

                <!-- System Preference Option -->
                <div class="theme-option flex items-center gap-2.5 px-3.5 py-2.5 cursor-pointer transition-colors duration-150 border-t"
                    data-theme="system"
                    onclick="selectTheme('system')"
                    style="color: var(--text-body); border-color: var(--border-color);">
                    <i class="fa-solid fa-desktop text-[13px]"></i>
                    <span class="text-[12px] font-medium">System</span>
                    <i class="fa-solid fa-check text-[10px] ml-auto theme-check" style="color: var(--text-muted); opacity: 0;"></i>
                </div>
            </div>
        </div>

        <span class="w-px h-8" style="background-color: var(--border-color);"></span>

        <!-- ===== USER DROPDOWN ===== -->
        <div class="user-dropdown relative">
            <button id="userDropdownBtn" 
                onclick="toggleUserDropdown()"
                class="user-dropdown-btn flex items-center gap-2 px-2 py-1.5 rounded-md transition-all duration-200 focus:outline-none"
                style="color: var(--text-body);">
                <span class="text-[11px] hidden sm:inline-block" style="color: var(--text-muted);">Welcome back,</span>
                <span class="text-[11px] font-medium" style="color: var(--text-heading);"><?php echo htmlspecialchars($topbar_user_name); ?></span>
                <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($topbar_user_name); ?>&background=334155&color=fff&rounded=true&size=32" 
                     alt="User" class="w-8 h-8 rounded-full border" style="border-color: var(--border-color);">
                <i class="fa-solid fa-chevron-down text-[9px]" style="color: var(--text-muted);"></i>
            </button>

            <!-- User Dropdown Menu -->
            <div id="userDropdownMenu" 
                class="user-dropdown-menu absolute right-0 mt-1.5 min-w-[200px] rounded-lg border shadow-lg overflow-hidden opacity-0 invisible transition-all duration-200 z-50"
                style="background-color: var(--bg-panel); border-color: var(--border-color); transform: translateY(-8px) scale(0.98);">
                
                <!-- User Info Header -->
                <div class="px-4 py-3 border-b" style="border-color: var(--border-color);">
                    <p class="text-[12px] font-semibold" style="color: var(--text-heading);"><?php echo htmlspecialchars($topbar_user_name); ?></p>
                    <?php if (!empty($topbar_user_privilege)): ?>
                        <p class="text-[10px] mt-0.5" style="color: var(--text-muted);"><?php echo htmlspecialchars($topbar_user_privilege); ?></p>
                    <?php endif; ?>
                </div>

                <!-- Logout -->
                <a href="api/auth/logout.php" 
                   class="flex items-center gap-2.5 px-4 py-2.5 transition-colors duration-150"
                   style="color: #ef4444;"
                   onmouseover="this.style.backgroundColor='var(--hover-bg)'"
                   onmouseout="this.style.backgroundColor='transparent'">
                    <i class="fa-solid fa-right-from-bracket text-[13px]"></i>
                    <span class="text-[12px] font-medium">Logout</span>
                </a>
            </div>
        </div>
    </div>
</header>

<style>
/* ===== Dark / Light theme variables ===== */
:root {
    --topbar-bg: #ffffff;
    --border-color: #e2e8f0;
    --text-heading: #0F2440;
    --text-body: #334155;
    --text-muted: #64748b;
    --hover-bg: #f1f5f9;
    --bg-panel: #ffffff;
    --input-bg: #ffffff;
}

html.dark-mode {
    --topbar-bg: #0d1520;
    --border-color: #1a2635;
    --text-heading: #ffffff;
    --text-body: #e5e7eb;
    --text-muted: #94a3b8;
    --hover-bg: #1a2635;
    --bg-panel: #0d1520;
    --input-bg: #060b13;
}

/* No transition for initial load - prevent flash */
html.no-transition * {
    transition: none !important;
}

header {
    background-color: var(--topbar-bg);
    border-color: var(--border-color);
    transition: background-color .4s ease, border-color .4s ease;
}

/* ===== THEME DROPDOWN STYLES ===== */
.theme-dropdown {
    position: relative;
}

.theme-dropdown-btn {
    transition: all 0.2s ease;
    cursor: pointer;
}

.theme-dropdown-btn:hover {
    background-color: var(--hover-bg) !important;
    border-color: var(--border-color) !important;
}

.theme-dropdown-btn:active {
    transform: scale(0.97);
}

/* Dropdown Menu */
.theme-dropdown-menu {
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.12), 0 4px 12px rgba(0, 0, 0, 0.06);
    backdrop-filter: blur(8px);
    transform-origin: top right;
}

html.dark-mode .theme-dropdown-menu {
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.5), 0 4px 12px rgba(0, 0, 0, 0.3);
}

.theme-dropdown-menu.open {
    opacity: 1;
    visibility: visible;
    transform: translateY(0) scale(1);
}

/* Theme Options */
.theme-option {
    transition: all 0.15s ease;
    position: relative;
}

.theme-option:hover {
    background-color: var(--hover-bg) !important;
}

.theme-option:active {
    transform: scale(0.98);
}

.theme-option .theme-check {
    transition: opacity 0.2s ease;
}

.theme-option.active .theme-check {
    opacity: 1 !important;
}

.theme-option.active {
    font-weight: 500;
}

/* ===== USER DROPDOWN STYLES ===== */
.user-dropdown {
    position: relative;
}

.user-dropdown-btn {
    transition: all 0.2s ease;
    cursor: pointer;
}

.user-dropdown-btn:hover {
    background-color: var(--hover-bg) !important;
}

.user-dropdown-btn:active {
    transform: scale(0.98);
}

.user-dropdown-menu {
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.12), 0 4px 12px rgba(0, 0, 0, 0.06);
    backdrop-filter: blur(8px);
    transform-origin: top right;
}

html.dark-mode .user-dropdown-menu {
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.5), 0 4px 12px rgba(0, 0, 0, 0.3);
}

.user-dropdown-menu.open {
    opacity: 1;
    visibility: visible;
    transform: translateY(0) scale(1);
}

/* ===== RESPONSIVE ===== */
@media (max-width: 640px) {
    .theme-dropdown-btn {
        padding: 4px 10px;
        font-size: 10px;
    }
    
    .theme-dropdown-btn i {
        font-size: 11px;
    }
    
    .theme-dropdown-menu,
    .user-dropdown-menu {
        min-width: 120px;
        right: -8px;
    }
    
    .theme-option {
        padding: 8px 12px;
        font-size: 11px;
    }
    
    .theme-option i {
        font-size: 12px;
    }
}

@media (max-width: 480px) {
    .theme-dropdown-btn {
        padding: 3px 8px;
        font-size: 9px;
    }
    
    .theme-dropdown-btn i {
        font-size: 10px;
    }
    
    .theme-dropdown-menu,
    .user-dropdown-menu {
        min-width: 100px;
        right: -4px;
    }
    
    .theme-option {
        padding: 6px 10px;
        font-size: 10px;
    }
    
    .theme-option i {
        font-size: 10px;
    }
}

/* Close dropdown when clicking outside */
.theme-dropdown-overlay {
    position: fixed;
    inset: 0;
    z-index: 40;
    display: none;
}

.theme-dropdown-overlay.active {
    display: block;
}
</style>

<!-- Dropdown Overlay -->
<div id="themeDropdownOverlay" class="theme-dropdown-overlay" onclick="closeThemeDropdown(); closeUserDropdown();"></div>

<script>
// ===== Sidebar toggle handler for Topbar =====
function handleSidebarToggle() {
    if (typeof toggleMobileRail === 'function' && window.innerWidth <= 820) {
        toggleMobileRail();
    } else if (typeof toggleRailSlim === 'function' && window.innerWidth > 820) {
        toggleRailSlim();
    } else {
        if (typeof openMobileRail === 'function') {
            openMobileRail();
        }
    }
}

// Keyboard shortcut: Ctrl+B
document.addEventListener('keydown', function(e) {
    if (e.ctrlKey && e.key === 'b') {
        e.preventDefault();
        handleSidebarToggle();
    }
});

// ============================================
// THEME DROPDOWN FUNCTIONS
// ============================================
function toggleThemeDropdown() {
    const menu = document.getElementById('themeDropdownMenu');
    const overlay = document.getElementById('themeDropdownOverlay');
    closeUserDropdown();
    
    if (menu.classList.contains('open')) {
        closeThemeDropdown();
    } else {
        menu.classList.add('open');
        overlay.classList.add('active');
    }
}

function closeThemeDropdown() {
    const menu = document.getElementById('themeDropdownMenu');
    const overlay = document.getElementById('themeDropdownOverlay');
    if (menu) menu.classList.remove('open');
    if (overlay) overlay.classList.remove('active');
}

function selectTheme(theme) {
    closeThemeDropdown();
    
    document.querySelectorAll('.theme-option').forEach(option => {
        option.classList.remove('active');
        if (option.dataset.theme === theme) {
            option.classList.add('active');
        }
    });
    
    if (theme === 'system') {
        const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
        applyThemeMode(prefersDark);
        localStorage.removeItem('themeMode');
        localStorage.setItem('darkMode', prefersDark ? 'true' : 'false');
        updateDropdownIcon('system');
    } else if (theme === 'dark') {
        applyThemeMode(true);
        localStorage.setItem('themeMode', 'dark');
        localStorage.setItem('darkMode', 'true');
        updateDropdownIcon('dark');
    } else {
        applyThemeMode(false);
        localStorage.setItem('themeMode', 'light');
        localStorage.setItem('darkMode', 'false');
        updateDropdownIcon('light');
    }
}

function updateDropdownIcon(theme) {
    const icon = document.getElementById('themeDropdownIcon');
    const text = document.getElementById('themeDropdownText');
    if (!icon || !text) return;
    
    if (theme === 'dark' || (theme === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        icon.className = 'fa-solid fa-moon text-[12px]';
        text.textContent = 'Dark';
    } else if (theme === 'light' || (theme === 'system' && !window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        icon.className = 'fa-solid fa-sun text-[12px]';
        text.textContent = 'Light';
    }
}

// ============================================
// USER DROPDOWN FUNCTIONS
// ============================================
function toggleUserDropdown() {
    const menu = document.getElementById('userDropdownMenu');
    const overlay = document.getElementById('themeDropdownOverlay');
    closeThemeDropdown();
    
    if (menu.classList.contains('open')) {
        closeUserDropdown();
    } else {
        menu.classList.add('open');
        overlay.classList.add('active');
    }
}

function closeUserDropdown() {
    const menu = document.getElementById('userDropdownMenu');
    if (menu) menu.classList.remove('open');
}

// ============================================
// DARK / LIGHT MODE TOGGLE CORE
// ============================================
function applyThemeMode(isDark) {
    const html = document.documentElement;
    html.classList.add('no-transition');
    setTimeout(function() {
        html.classList.remove('no-transition');
    }, 50);
    html.classList.toggle('dark-mode', isDark);
    
    const icon = document.getElementById('themeDropdownIcon');
    const text = document.getElementById('themeDropdownText');
    if (icon && text) {
        if (isDark) {
            icon.className = 'fa-solid fa-moon text-[12px]';
            text.textContent = 'Dark';
        } else {
            icon.className = 'fa-solid fa-sun text-[12px]';
            text.textContent = 'Light';
        }
    }
}

// ============================================
// RESTORE SAVED PREFERENCE
// ============================================
(function initThemeEarly() {
    let saved = localStorage.getItem('themeMode');
    let darkMode = localStorage.getItem('darkMode');
    
    if (darkMode !== null) {
        const isDark = darkMode === 'true';
        applyThemeMode(isDark);
        return;
    }
    
    if (saved === 'dark') {
        applyThemeMode(true);
        localStorage.setItem('darkMode', 'true');
    } else if (saved === 'light') {
        applyThemeMode(false);
        localStorage.setItem('darkMode', 'false');
    } else {
        const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
        applyThemeMode(prefersDark);
        localStorage.setItem('darkMode', prefersDark ? 'true' : 'false');
    }
})();

document.addEventListener('DOMContentLoaded', function() {
    setTimeout(function() {
        document.documentElement.classList.remove('no-transition');
    }, 100);
    
    let activeTheme = 'system';
    const saved = localStorage.getItem('themeMode');
    if (saved === 'dark') activeTheme = 'dark';
    else if (saved === 'light') activeTheme = 'light';
    
    document.querySelectorAll('.theme-option').forEach(option => {
        option.classList.remove('active');
        if (option.dataset.theme === activeTheme) {
            option.classList.add('active');
        }
    });
    
    updateDropdownIcon(activeTheme);

    try {
        const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
        mediaQuery.addEventListener('change', function(e) {
            if (!localStorage.getItem('themeMode')) {
                applyThemeMode(e.matches);
                localStorage.setItem('darkMode', e.matches ? 'true' : 'false');
                updateDropdownIcon('system');
            }
        });
    } catch (e) {}
});

// Close dropdowns on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeThemeDropdown();
        closeUserDropdown();
    }
});
</script>