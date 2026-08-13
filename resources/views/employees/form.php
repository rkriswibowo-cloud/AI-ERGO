<div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4">
    <h4 class="fw-bold text-dark mb-0"><?= sanitize($title) ?></h4>
    <a href="<?= base_url('employees') ?>" class="btn btn-light rounded-pill btn-mobile-full"><i class="fa-solid fa-arrow-left me-1"></i> Kembali</a>
</div>

<form action="" method="POST">
    <?= csrf_field() ?>
    <div class="row g-4">
        <!-- Bio Demographics Section -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                    <h6 class="fw-bold text-dark mb-0"><i class="fa-solid fa-id-card text-primary me-2"></i>Informasi Bio-Demografis Pekerja</h6>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark">Perusahaan *</label>
                        <select name="company_id" class="form-select" required>
                            <?php foreach ($companies as $c): ?>
                                <option value="<?= $c['id'] ?>" <?= ($employee['company_id'] ?? '') == $c['id'] ? 'selected' : '' ?>>
                                    <?= sanitize($c['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold text-dark">Departemen *</label>
                            <select name="department_id" class="form-select" required>
                                <?php foreach ($departments as $d): ?>
                                    <option value="<?= $d['id'] ?>" <?= ($employee['department_id'] ?? '') == $d['id'] ? 'selected' : '' ?>>
                                        <?= sanitize($d['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold text-dark">Jabatan *</label>
                            <select name="position_id" class="form-select" required>
                                <?php foreach ($positions as $p): ?>
                                    <option value="<?= $p['id'] ?>" <?= ($employee['position_id'] ?? '') == $p['id'] ? 'selected' : '' ?>>
                                        <?= sanitize($p['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold text-dark">NIK / NIP Pekerja *</label>
                            <input type="text" name="employee_number" class="form-control" value="<?= sanitize($employee['employee_number'] ?? 'EMP-' . rand(100,999)) ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold text-dark">Nama Lengkap *</label>
                            <input type="text" name="name" class="form-control" value="<?= sanitize($employee['name'] ?? '') ?>" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold text-dark">Jenis Kelamin</label>
                            <select name="gender" class="form-select">
                                <option value="L" <?= ($employee['gender'] ?? 'L') == 'L' ? 'selected' : '' ?>>Laki-laki</option>
                                <option value="P" <?= ($employee['gender'] ?? '') == 'P' ? 'selected' : '' ?>>Perempuan</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold text-dark">Usia (Tahun)</label>
                            <input type="number" name="age" class="form-control" value="<?= $employee['age'] ?? 30 ?>" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold text-dark">Tinggi (cm)</label>
                            <input type="number" step="0.1" name="height" class="form-control" value="<?= $employee['height'] ?? 168.0 ?>" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold text-dark">Berat (kg)</label>
                            <input type="number" step="0.1" name="weight" class="form-control" value="<?= $employee['weight'] ?? 65.0 ?>" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold text-dark">Masa Kerja (Th)</label>
                            <input type="number" name="years_of_service" class="form-control" value="<?= $employee['years_of_service'] ?? 3 ?>" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Job Profile Section -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                    <h6 class="fw-bold text-dark mb-0"><i class="fa-solid fa-briefcase text-primary me-2"></i>Profil & Karakteristik Pekerjaan</h6>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark">Deskripsi Pekerjaan / Job Type</label>
                        <input type="text" name="job_type" class="form-control" value="<?= sanitize($employee['job_type'] ?? 'Operator / Desk Worker') ?>" placeholder="e.g. Desk Worker / Assembly Operator">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold text-dark">Durasi Duduk (Jam/Hari)</label>
                            <input type="number" step="0.5" name="sitting_hours" class="form-control" value="<?= $employee['sitting_hours'] ?? 5.0 ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold text-dark">Durasi Berdiri (Jam/Hari)</label>
                            <input type="number" step="0.5" name="standing_hours" class="form-control" value="<?= $employee['standing_hours'] ?? 3.0 ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold text-dark">Durasi Komputer (Jam/Hari)</label>
                            <input type="number" step="0.5" name="computer_hours" class="form-control" value="<?= $employee['computer_hours'] ?? 4.0 ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold text-dark">Tipe Shift</label>
                            <select name="shift_type" class="form-select">
                                <option value="Non-Shift" <?= ($employee['shift_type'] ?? '') == 'Non-Shift' ? 'selected' : '' ?>>Non-Shift (Regular)</option>
                                <option value="Shift 1" <?= ($employee['shift_type'] ?? '') == 'Shift 1' ? 'selected' : '' ?>>Shift 1 (Pagi)</option>
                                <option value="Shift 2" <?= ($employee['shift_type'] ?? '') == 'Shift 2' ? 'selected' : '' ?>>Shift 2 (Sore)</option>
                                <option value="Shift 3" <?= ($employee['shift_type'] ?? '') == 'Shift 3' ? 'selected' : '' ?>>Shift 3 (Malam)</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold text-dark">No. HP / Whatsapp</label>
                            <input type="text" name="phone" class="form-control" value="<?= sanitize($employee['phone'] ?? '') ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold text-dark">Email Pekerja</label>
                            <input type="email" name="email" class="form-control" value="<?= sanitize($employee['email'] ?? '') ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="d-flex flex-column-reverse flex-sm-row justify-content-end gap-2">
                <a href="<?= base_url('employees') ?>" class="btn btn-light rounded-pill btn-mobile-full">Batal</a>
                <button type="submit" class="btn btn-primary rounded-pill px-4 btn-mobile-full"><i class="fa-solid fa-floppy-disk me-1"></i> Simpan Data Pekerja</button>
            </div>
        </div>
    </div>
</form>
