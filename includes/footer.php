<?php
?>
<!-- FOOTER -->
<footer class="border-t flex-shrink-0 py-3 px-4"
    style="background-color: var(--footer-bg, var(--bg-panel)); border-color: var(--border-color);">
    <div class="container-fluid">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-2">
            <div class="text-xs" style="color: var(--text-muted);">
                &copy; <?php echo date('Y'); ?>
                <span id="projectname" style="color: var(--text-heading); font-weight: 500;">P2P Track.</span>
            </div>
        </div>
    </div>
</footer>

<style>
    :root {
        --footer-bg: var(--bg-panel);
    }

    html.dark-mode {
        --footer-bg: #0a121c;
    }

    footer {
        background-color: var(--footer-bg);
        border-color: var(--border-color);
        transition: background-color .25s ease, border-color .25s ease;
    }

    @media (max-width: 480px) {
        footer .flex {
            flex-direction: column;
            text-align: center;
        }

        footer .flex .flex {
            flex-wrap: wrap;
            justify-content: center;
        }
    }

    footer strong {
        position: relative;
    }
</style>