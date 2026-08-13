<div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4">
    <h4 class="fw-bold text-dark mb-0"><?= sanitize($title) ?></h4>
    <a href="<?= base_url('departments') ?>" class="btn btn-light rounded-pill btn-mobile-full"><i class="fa-solid fa-arrow-left me-1"></i> Kembali</a>
</div>

<div class="card border-0 shadow-sm rounded-4 col-lg-8 mx-auto">
    <div class="card-body p-4">
        <form action="" method="POST">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label fw-semibold text-dark">Perusahaan / Organisasi *</label>
                <select name="company_id" class="form-select" required>
                    <option value="">-- Pilih Perusahaan --</option>
                    <?php foreach ($companies as $c): ?>
                        <option value="<?= $c['id'] ?>" <?= ($department['company_id'] ?? '') == $c['id'] ? 'selected' : '' ?>>
                            <?= sanitize($c['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold text-dark">Nama Departemen *</label>
                <input type="text" name="name" class="form-control" value="<?= sanitize($department['name'] ?? '') ?>" required>
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold text-dark">Deskripsi</label>
                <textarea name="description" class="form-control" rows="3"><?= sanitize($department['description'] ?? '') ?></textarea>
            </div>
            <div class="d-flex flex-column-reverse flex-sm-row justify-content-end gap-2">
                <a href="<?= base_url('departments') ?>" class="btn btn-light rounded-pill btn-mobile-full">Batal</a>
                <button type="submit" class="btn btn-primary rounded-pill px-4 btn-mobile-full"><i class="fa-solid fa-floppy-disk me-1"></i> Simpan</button>
            </div>
        </form>
    </div>
</div>
