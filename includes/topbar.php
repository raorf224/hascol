<!-- includes/topbar.php -->
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

        <span class="text-[11px] hidden sm:inline-block" style="color: var(--text-muted);">Welcome back,</span>
        <span class="text-[11px] font-medium" style="color: var(--text-heading);">Abdul Basit</span>
        <img src="https://ui-avatars.com/api/?name=Abdul+Basit&background=334155&color=fff&rounded=true&size=32" 
             alt="User" class="w-8 h-8 rounded-full border" style="border-color: var(--border-color);">
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

/* ===== RESPONSIVE ===== */
@media (max-width: 640px) {
    .theme-dropdown-btn {
        padding: 4px 10px;
        font-size: 10px;
    }
    
    .theme-dropdown-btn i {
        font-size: 11px;
    }
    
    .theme-dropdown-menu {
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
    
    .theme-dropdown-menu {
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
<div id="themeDropdownOverlay" class="theme-dropdown-overlay" onclick="closeThemeDropdown()"></div>

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

// Toggle dropdown
function toggleThemeDropdown() {
    const menu = document.getElementById('themeDropdownMenu');
    const overlay = document.getElementById('themeDropdownOverlay');
    
    if (menu.classList.contains('open')) {
        closeThemeDropdown();
    } else {
        menu.classList.add('open');
        overlay.classList.add('active');
    }
}

// Close dropdown
function closeThemeDropdown() {
    const menu = document.getElementById('themeDropdownMenu');
    const overlay = document.getElementById('themeDropdownOverlay');
    
    menu.classList.remove('open');
    overlay.classList.remove('active');
}

// Select theme
function selectTheme(theme) {
    // Close dropdown
    closeThemeDropdown();
    
    // Update active state in dropdown
    document.querySelectorAll('.theme-option').forEach(option => {
        option.classList.remove('active');
        if (option.dataset.theme === theme) {
            option.classList.add('active');
        }
    });
    
    // Apply theme
    if (theme === 'system') {
        // Check system preference
        const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
        applyThemeMode(prefersDark);
        localStorage.removeItem('themeMode'); // Remove manual preference
        localStorage.setItem('darkMode', prefersDark ? 'true' : 'false'); // Sync with users.php
        updateDropdownIcon('system');
    } else if (theme === 'dark') {
        applyThemeMode(true);
        localStorage.setItem('themeMode', 'dark');
        localStorage.setItem('darkMode', 'true'); // Sync with users.php
        updateDropdownIcon('dark');
    } else {
        applyThemeMode(false);
        localStorage.setItem('themeMode', 'light');
        localStorage.setItem('darkMode', 'false'); // Sync with users.php
        updateDropdownIcon('light');
    }
}

// Update dropdown button icon and text
function updateDropdownIcon(theme) {
    const icon = document.getElementById('themeDropdownIcon');
    const text = document.getElementById('themeDropdownText');
    
    if (theme === 'dark' || (theme === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        icon.className = 'fa-solid fa-moon text-[12px]';
        text.textContent = 'Dark';
    } else if (theme === 'light' || (theme === 'system' && !window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        icon.className = 'fa-solid fa-sun text-[12px]';
        text.textContent = 'Light';
    } else if (theme === 'system') {
        const isDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        icon.className = isDark ? 'fa-solid fa-moon text-[12px]' : 'fa-solid fa-sun text-[12px]';
        text.textContent = isDark ? 'Dark' : 'Light';
    }
}

// ============================================
// DARK / LIGHT MODE TOGGLE CORE
// ============================================

function applyThemeMode(isDark) {
    const html = document.documentElement;
    const moonIcon = document.getElementById('themeIconMoon');
    const sunIcon = document.getElementById('themeIconSun');

    // Add no-transition class to prevent flash
    html.classList.add('no-transition');
    setTimeout(function() {
        html.classList.remove('no-transition');
    }, 50);

    html.classList.toggle('dark-mode', isDark);

    // Update icons (if they exist - for backward compatibility)
    if (moonIcon && sunIcon) {
        moonIcon.classList.toggle('hidden', isDark);
        sunIcon.classList.toggle('hidden', !isDark);
    }

    // Update dropdown button
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

function toggleThemeMode() {
    const isCurrentlyDark = document.documentElement.classList.contains('dark-mode');
    const newTheme = !isCurrentlyDark;
    applyThemeMode(newTheme);
    localStorage.setItem('themeMode', newTheme ? 'dark' : 'light');
    localStorage.setItem('darkMode', newTheme ? 'true' : 'false'); // Sync with users.php
    
    // Update dropdown active state
    document.querySelectorAll('.theme-option').forEach(option => {
        option.classList.remove('active');
        if (option.dataset.theme === (newTheme ? 'dark' : 'light')) {
            option.classList.add('active');
        }
    });
}

// ============================================
// RESTORE SAVED PREFERENCE
// ============================================

function getStoredTheme() {
    try {
        return localStorage.getItem('themeMode');
    } catch (e) {
        return null;
    }
}

// ============================================
// INITIALIZE THEME - EARLY EXECUTION
// ============================================

// IMPORTANT: Yeh function DOMContentLoaded se pehle run hoga
(function initThemeEarly() {
    // Check localStorage
    let saved = localStorage.getItem('themeMode');
    let darkMode = localStorage.getItem('darkMode');
    
    // If darkMode exists in localStorage, use it (for users.php compatibility)
    if (darkMode !== null) {
        const isDark = darkMode === 'true';
        applyThemeMode(isDark);
        return;
    }
    
    // Otherwise use themeMode
    if (saved === 'dark') {
        applyThemeMode(true);
        localStorage.setItem('darkMode', 'true');
    } else if (saved === 'light') {
        applyThemeMode(false);
        localStorage.setItem('darkMode', 'false');
    } else {
        // System preference
        const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
        applyThemeMode(prefersDark);
        localStorage.setItem('darkMode', prefersDark ? 'true' : 'false');
    }
})();

document.addEventListener('DOMContentLoaded', function() {
    // Remove no-transition after initial render
    setTimeout(function() {
        document.documentElement.classList.remove('no-transition');
    }, 100);
    
    // Set active theme in dropdown
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
    
    // Update dropdown button
    updateDropdownIcon(activeTheme);

    // Listen for system theme changes (only if no manual preference set)
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

// Close dropdown on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeThemeDropdown();
    }
});
</script>