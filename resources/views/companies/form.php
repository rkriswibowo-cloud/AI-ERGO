<div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4">
    <h4 class="fw-bold text-dark mb-0"><?= sanitize($title) ?></h4>
    <a href="<?= base_url('companies') ?>" class="btn btn-light rounded-pill btn-mobile-full"><i class="fa-solid fa-arrow-left me-1"></i> Kembali</a>
</div>

<div class="card border-0 shadow-sm rounded-4 col-lg-8 mx-auto">
    <div class="card-body p-4">
        <form action="" method="POST">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label fw-semibold text-dark">Nama Perusahaan / Instansi *</label>
                <input type="text" name="name" class="form-control" value="<?= sanitize($company['name'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold text-dark">Alamat</label>
                <textarea name="address" class="form-control" rows="3"><?= sanitize($company['address'] ?? '') ?></textarea>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold text-dark">No. Telepon</label>
                    <input type="text" name="phone" class="form-control" value="<?= sanitize($company['phone'] ?? '') ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold text-dark">Email Organisasi</label>
                    <input type="email" name="email" class="form-control" value="<?= sanitize($company['email'] ?? '') ?>">
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold text-dark">Status Aktivasi</label>
                <select name="status" class="form-select">
                    <option value="active" <?= ($company['status'] ?? '') == 'active' ? 'selected' : '' ?>>Aktif</option>
                    <option value="inactive" <?= ($company['status'] ?? '') == 'inactive' ? 'selected' : '' ?>>Non-Aktif</option>
                </select>
            </div>
            <div class="d-flex flex-column-reverse flex-sm-row justify-content-end gap-2">
                <a href="<?= base_url('companies') ?>" class="btn btn-light rounded-pill btn-mobile-full">Batal</a>
                <button type="submit" class="btn btn-primary rounded-pill px-4 btn-mobile-full"><i class="fa-solid fa-floppy-disk me-1"></i> Simpan</button>
            </div>
        </form>
    </div>
</div>
