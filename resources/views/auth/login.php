<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - <?= sanitize(get_setting('APP_NAME', 'AI-ERGO System')) ?></title>
    <!-- Favicon -->
    <?php $appFavicon = get_setting('APP_FAVICON'); ?>
    <?php if (upload_exists($appFavicon)): ?>
        <link rel="shortcut icon" href="<?= upload_url($appFavicon) ?>">
    <?php else: ?>
        <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🏃</text></svg>">
    <?php endif; ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="<?= assets('css/style.css') ?>" rel="stylesheet">
    <style>
        body {
            background-color: #f8fafc;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', sans-serif;
        }
        .login-card {
            background: #ffffff;
            border-radius: 1.5rem;
            box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.07), 0 0 15px rgba(0, 0, 0, 0.03);
            border: 1px solid #e2e8f0;
            overflow: hidden;
        }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-9 col-lg-6 col-xl-5">
            <div class="login-card p-4 p-md-5">
                <!-- Horizontal Professional Brand Header (Enlarged & Clean) -->
                <div class="d-flex align-items-center justify-content-center gap-3 gap-md-4 mb-4 py-2 border-bottom pb-4">
                    <?php $appLogo = get_setting('APP_LOGO'); ?>
                    <?php if (upload_exists($appLogo)): ?>
                        <img src="<?= upload_url($appLogo) ?>" alt="Logo" style="max-height: 75px; width: auto;" class="rounded-3 flex-shrink-0">
                    <?php else: ?>
                        <div class="d-inline-flex align-items-center justify-content-center bg-primary text-white rounded-3 shadow-sm" style="width: 70px; height: 70px; flex-shrink: 0;">
                            <i class="fa-solid fa-person-walking-luggage fa-2x"></i>
                        </div>
                    <?php endif; ?>
                    <div class="text-start">
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <h2 class="fw-bold text-dark mb-0 lh-1" style="font-size: 2rem; letter-spacing: -0.5px;"><?= sanitize(get_setting('APP_NAME', 'AI-ERGO')) ?></h2>
                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-2.5 py-1 fs-7">v1.0</span>
                        </div>
                        <p class="text-muted mb-0 fw-medium" style="font-size: 0.95rem; line-height: 1.3;">AI-Assisted Ergonomic Risk Assessment System</p>
                    </div>
                </div>

                <?php if ($msg = flash('login_error')): ?>
                    <div class="alert alert-danger rounded-3 py-2 small" role="alert">
                        <i class="fa-solid fa-circle-exclamation me-2"></i><?= sanitize($msg['message']) ?>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('auth/login') ?>" method="POST">
                    <?= csrf_field() ?>
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark small">Alamat Email</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fa-solid fa-envelope text-muted"></i></span>
                            <input type="email" name="email" class="form-control bg-light" placeholder="Gunakan username atau email" value="<?= sanitize($email ?? '') ?>" required autofocus>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold text-dark small">Kata Sandi (Password)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fa-solid fa-lock text-muted"></i></span>
                            <input type="password" name="password" class="form-control bg-light" placeholder="••••••••" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2.5 fw-bold rounded-3 shadow-sm mb-3">
                        <i class="fa-solid fa-right-to-bracket me-2"></i> Masuk ke Sistem
                    </button>
                </form>

                <div class="text-center pt-3 border-top mt-3">
                    <span class="text-muted small">Belum memiliki akun?</span>
                    <a href="<?= base_url('auth/register') ?>" class="fw-bold text-primary text-decoration-none small ms-1">Daftar Akun Baru</a>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
