<?php
// Common head section - favicon aur shared meta tags
if (!isset($base_url)) {
    // Base URL dynamically calculate karo (agar sidebar se pehle include ho)
    $__project_root_fs = str_replace('\\', '/', realpath(dirname(__DIR__)));
    $__doc_root_fs = str_replace('\\', '/', realpath($_SERVER['DOCUMENT_ROOT']));
    $base_url = '';
    if ($__project_root_fs && $__doc_root_fs) {
        $base_url = str_replace($__doc_root_fs, '', $__project_root_fs);
        $base_url = rtrim($base_url, '/');
    }
}
?>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<!-- ✅ Favicon -->
<link rel="icon" type="image/png" href="<?php echo $base_url; ?>/assets/images/abc.png">
<link rel="apple-touch-icon" href="<?php echo $base_url; ?>/assets/images/abc.png">

<!-- ✅ Common meta -->
<meta name="description" content="Hascol OMC Management Dashboard" />