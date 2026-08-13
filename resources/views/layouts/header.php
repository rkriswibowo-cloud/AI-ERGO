<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= sanitize($title ?? (get_setting('APP_NAME', 'AI-ERGO') . ' - Ergonomic Risk Assessment System')) ?></title>
    <!-- Favicon -->
    <?php $appFavicon = get_setting('APP_FAVICON'); ?>
    <?php if (upload_exists($appFavicon)): ?>
        <link rel="shortcut icon" href="<?= upload_url($appFavicon) ?>">
    <?php else: ?>
        <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🏃</text></svg>">
    <?php endif; ?>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome 6 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?= assets('css/style.css') ?>?v=<?= time() ?>" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<?php if (is_logged_in()): ?>
<?php if (isset($_SESSION['impersonator_user'])): ?>
    <div class="bg-warning text-dark py-2 px-3 shadow-sm border-bottom border-warning d-flex align-items-center justify-content-between flex-wrap gap-2 sticky-top" style="z-index: 1040;">
        <div class="small fw-semibold d-flex align-items-center gap-2">
            <span class="badge bg-dark text-white rounded-pill px-2 py-1"><i class="fa-solid fa-user-ninja me-1"></i> Mode Login As User</span>
            <span>Anda sedang bertindak sebagai <strong><?= sanitize(auth_user()['name']) ?></strong> (<?= sanitize(auth_user()['email']) ?>)</span>
        </div>
        <a href="<?= base_url('admin/users/revert') ?>" class="btn btn-sm btn-dark rounded-pill px-3 py-1 fw-bold text-decoration-none shadow-sm">
            <i class="fa-solid fa-right-from-bracket me-1"></i> Kembali ke Super Admin (<?= sanitize($_SESSION['impersonator_user']['name']) ?>)
        </a>
    </div>
<?php endif; ?>
<nav class="navbar app-header sticky-top px-2 px-md-4 py-2">
    <div class="container-fluid d-flex flex-nowrap align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-2">
            <button class="btn btn-light d-md-none border-0 px-2 py-1" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa-solid fa-bars fa-lg text-dark"></i>
            </button>
            <a class="navbar-brand d-flex align-items-center gap-1 gap-sm-2 fw-bold text-primary mb-0 me-0" href="<?= base_url('dashboard') ?>">
                <?php $appLogo = get_setting('APP_LOGO'); ?>
                <?php if (upload_exists($appLogo)): ?>
                    <img src="<?= upload_url($appLogo) ?>" alt="Logo" style="max-height: 32px; width: auto;" class="d-inline-block align-text-top me-1">
                <?php else: ?>
                    <i class="fa-solid fa-person-walking-luggage fa-lg text-primary"></i>
                <?php endif; ?>
                <span><?= sanitize(get_setting('APP_NAME', 'AI-ERGO')) ?></span>
                <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill fs-7">v1.0</span>
            </a>
        </div>

        <div class="d-flex align-items-center ms-auto">
            <div class="dropdown">
                <button class="btn dropdown-toggle d-flex align-items-center gap-2 user-profile-btn" type="button" data-bs-toggle="dropdown">
                    <i class="fa-solid fa-circle-user text-primary fa-lg"></i>
                    <span class="fw-semibold text-dark d-none d-md-inline"><?= sanitize(auth_user()['name'] ?? 'User') ?></span>
                    <span class="badge bg-secondary rounded-pill d-none d-md-inline"><?= sanitize(auth_user()['roles'][0] ?? 'User') ?></span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                    <li><h6 class="dropdown-header mb-0"><?= sanitize(auth_user()['name'] ?? 'User') ?></h6></li>
                    <li><small class="dropdown-item-text text-muted py-1"><?= sanitize(auth_user()['email'] ?? '') ?></small></li>
                    <?php if (isset($_SESSION['impersonator_user'])): ?>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-warning fw-semibold" href="<?= base_url('admin/users/revert') ?>"><i class="fa-solid fa-user-ninja me-2"></i>Kembali ke Super Admin</a></li>
                    <?php endif; ?>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="<?= base_url('auth/logout') ?>"><i class="fa-solid fa-right-from-bracket me-2"></i>Keluar (Logout)</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
<?php endif; ?>
