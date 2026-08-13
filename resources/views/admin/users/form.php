<div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4">
    <h4 class="fw-bold text-dark mb-0"><?= sanitize($title) ?></h4>
    <a href="<?= base_url('admin/users') ?>" class="btn btn-light rounded-pill btn-mobile-full"><i class="fa-solid fa-arrow-left me-1"></i> Kembali</a>
</div>

<div class="card border-0 shadow-sm rounded-4 col-lg-8 mx-auto">
    <div class="card-body p-4">
        <form action="" method="POST">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label fw-semibold text-dark">Nama Lengkap *</label>
                <input type="text" name="name" class="form-control" value="<?= sanitize($user['name'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold text-dark">Alamat Email *</label>
                <input type="email" name="email" class="form-control" value="<?= sanitize($user['email'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold text-dark">Kata Sandi (Password) <?= isset($user) ? '<small class="text-muted fw-normal">(Kosongkan jika tidak ingin diubah)</small>' : '*' ?></label>
                <input type="password" name="password" class="form-control" <?= isset($user) ? '' : 'required' ?>>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold text-dark">Role Pengguna *</label>
                    <select name="role_id" class="form-select" required>
                        <?php foreach ($roles as $r): ?>
                            <?php if (!has_role('Super Admin') && ($r['name'] === 'Super Admin' || $r['id'] == 1)) continue; ?>
                            <option value="<?= $r['id'] ?>" <?= isset($currentRoles) && in_array($r['name'], $currentRoles) ? 'selected' : '' ?>>
                                <?= sanitize($r['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold text-dark">Perusahaan / Organisasi</label>
                    <select name="company_id" class="form-select">
                        <option value="">-- Global / Seluruh Perusahaan --</option>
                        <?php foreach ($companies as $c): ?>
                            <option value="<?= $c['id'] ?>" <?= ($user['company_id'] ?? '') == $c['id'] ? 'selected' : '' ?>>
                                <?= sanitize($c['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold text-dark">Status Akun</label>
                <select name="status" class="form-select">
                    <option value="active" <?= ($user['status'] ?? '') == 'active' ? 'selected' : '' ?>>Aktif</option>
                    <option value="inactive" <?= ($user['status'] ?? '') == 'inactive' ? 'selected' : '' ?>>Non-Aktif</option>
                </select>
            </div>
            <div class="d-flex flex-column-reverse flex-sm-row justify-content-end gap-2">
                <a href="<?= base_url('admin/users') ?>" class="btn btn-light rounded-pill btn-mobile-full">Batal</a>
                <button type="submit" class="btn btn-primary rounded-pill px-4 btn-mobile-full"><i class="fa-solid fa-floppy-disk me-1"></i> Simpan User</button>
            </div>
        </form>
    </div>
</div>
