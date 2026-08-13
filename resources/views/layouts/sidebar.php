<!-- Sidebar Backdrop Overlay for Mobile -->
<div id="sidebarBackdrop" class="sidebar-backdrop no-print"></div>

<!-- Sidebar Navigation -->
<nav class="col-md-3 col-lg-2 d-md-block sidebar collapse px-0 no-print" id="sidebarMenu">
    <div class="position-sticky pt-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link <?= strpos($_SERVER['REQUEST_URI'], '/dashboard') !== false || $_SERVER['REQUEST_URI'] === '/' || strpos($_SERVER['REQUEST_URI'], '/ergonomi') !== false && strlen($_SERVER['REQUEST_URI']) < 15 ? 'active' : '' ?>" href="<?= base_url('dashboard') ?>">
                    <i class="fa-solid fa-chart-pie"></i> Dashboard
                </a>
            </li>

            <div class="sidebar-heading">Assessment Ergonomi</div>
            <li class="nav-item">
                <a class="nav-link <?= strpos($_SERVER['REQUEST_URI'], '/assessments/create') !== false ? 'active' : '' ?>" href="<?= base_url('assessments/create') ?>">
                    <i class="fa-solid fa-file-signature"></i> Assessment Baru (NBM)
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= strpos($_SERVER['REQUEST_URI'], '/assessments') !== false && strpos($_SERVER['REQUEST_URI'], '/create') === false ? 'active' : '' ?>" href="<?= base_url('assessments') ?>">
                    <i class="fa-solid fa-list-check"></i> Histori Assessment
                </a>
            </li>

            <div class="sidebar-heading">AI & Rekomendasi</div>
            <li class="nav-item">
                <a class="nav-link <?= strpos($_SERVER['REQUEST_URI'], '/ai/history') !== false ? 'active' : '' ?>" href="<?= base_url('ai/history') ?>">
                    <i class="fa-solid fa-robot"></i> Rekomendasi AI
                </a>
            </li>

            <div class="sidebar-heading">Laporan & Analitik</div>
            <li class="nav-item">
                <a class="nav-link <?= strpos($_SERVER['REQUEST_URI'], '/reports/organization') !== false ? 'active' : '' ?>" href="<?= base_url('reports/organization') ?>">
                    <i class="fa-solid fa-chart-line"></i> Laporan Organisasi
                </a>
            </li>

            <div class="sidebar-heading">Master Data</div>
            <?php if (has_role('Super Admin')): ?>
            <li class="nav-item">
                <a class="nav-link <?= strpos($_SERVER['REQUEST_URI'], '/companies') !== false ? 'active' : '' ?>" href="<?= base_url('companies') ?>">
                    <i class="fa-solid fa-building"></i> Perusahaan
                </a>
            </li>
            <?php endif; ?>
            <li class="nav-item">
                <a class="nav-link <?= strpos($_SERVER['REQUEST_URI'], '/departments') !== false ? 'active' : '' ?>" href="<?= base_url('departments') ?>">
                    <i class="fa-solid fa-sitemap"></i> Departemen
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= strpos($_SERVER['REQUEST_URI'], '/positions') !== false ? 'active' : '' ?>" href="<?= base_url('positions') ?>">
                    <i class="fa-solid fa-briefcase"></i> Jabatan
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= strpos($_SERVER['REQUEST_URI'], '/employees') !== false ? 'active' : '' ?>" href="<?= base_url('employees') ?>">
                    <i class="fa-solid fa-users"></i> Data Pekerja
                </a>
            </li>

            <?php if (has_role('Super Admin') || has_role('Admin K3') || has_role('HRD')): ?>
            <div class="sidebar-heading">Administrasi Sistem</div>
            <li class="nav-item">
                <a class="nav-link <?= strpos($_SERVER['REQUEST_URI'], '/admin/users') !== false ? 'active' : '' ?>" href="<?= base_url('admin/users') ?>">
                    <i class="fa-solid fa-user-gear"></i> Manajemen User
                </a>
            </li>
            <?php endif; ?>
            <?php if (has_role('Super Admin')): ?>
            <li class="nav-item">
                <a class="nav-link <?= strpos($_SERVER['REQUEST_URI'], '/admin/roles') !== false ? 'active' : '' ?>" href="<?= base_url('admin/roles') ?>">
                    <i class="fa-solid fa-shield-halved"></i> Role & Permissions
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= strpos($_SERVER['REQUEST_URI'], '/admin/settings') !== false ? 'active' : '' ?>" href="<?= base_url('admin/settings') ?>">
                    <i class="fa-solid fa-sliders"></i> Konfigurasi AI & Sistem
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= strpos($_SERVER['REQUEST_URI'], '/admin/audit-logs') !== false ? 'active' : '' ?>" href="<?= base_url('admin/audit-logs') ?>">
                    <i class="fa-solid fa-clock-rotate-left"></i> Audit Log Aktivitas
                </a>
            </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
<?php
// Display flash messages
$flashTypes = [
    'success' => ['class' => 'success', 'icon' => 'fa-circle-check'],
    'error'   => ['class' => 'danger',  'icon' => 'fa-triangle-exclamation'],
    'danger'  => ['class' => 'danger',  'icon' => 'fa-circle-exclamation'],
    'warning' => ['class' => 'warning', 'icon' => 'fa-exclamation-triangle'],
    'info'    => ['class' => 'info',    'icon' => 'fa-info-circle']
];

foreach ($flashTypes as $key => $config) {
    if ($msg = flash($key)) {
        echo '<div class="alert alert-' . $config['class'] . ' alert-dismissible fade show rounded-3 shadow-sm" role="alert">
                <i class="fa-solid ' . $config['icon'] . ' me-2"></i>' . sanitize($msg['message']) . '
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>';
    }
}
?>
