<div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-1">Data Pekerja</h4>
        <p class="text-muted small mb-0">Manajemen profil bio-demografis dan karakteristik kerja pekerja</p>
    </div>
    <a href="<?= base_url('employees/create') ?>" class="btn btn-primary rounded-pill shadow-sm btn-mobile-full">
        <i class="fa-solid fa-user-plus me-1"></i> Tambah Pekerja
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-header bg-white border-0 pt-3 px-3 px-md-4 pb-0 d-flex justify-content-between align-items-center">
        <h6 class="fw-bold text-dark mb-0"><i class="fa-solid fa-users text-primary me-2"></i>Daftar Pekerja</h6>
        <div class="d-flex align-items-center gap-1 d-md-none">
            <span class="small text-muted me-1 fs-7">Geser:</span>
            <button type="button" class="btn btn-sm btn-outline-secondary rounded-circle px-2 py-1 scroll-left-btn" title="Geser Kiri"><i class="fa-solid fa-chevron-left fs-7"></i></button>
            <button type="button" class="btn btn-sm btn-primary rounded-circle px-2 py-1 scroll-right-btn" title="Geser Kanan"><i class="fa-solid fa-chevron-right fs-7"></i></button>
        </div>
    </div>
    <div class="card-body p-3 p-md-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>NIK/NIP</th>
                        <th>Nama Pekerja</th>
                        <th>Departemen / Jabatan</th>
                        <th>Bio-Demografis</th>
                        <th>Karakteristik Kerja</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($employees)): ?>
                        <tr><td colspan="7" class="text-center text-muted py-3">Belum ada data pekerja.</td></tr>
                    <?php else: ?>
                        <?php $no = 1; foreach ($employees as $e): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><code><?= sanitize($e['employee_number']) ?></code></td>
                                <td>
                                    <div class="fw-semibold text-dark"><?= sanitize($e['name']) ?></div>
                                    <div class="small text-muted"><?= sanitize($e['email']) ?></div>
                                </td>
                                <td>
                                    <div class="fw-semibold text-dark"><?= sanitize($e['department_name']) ?></div>
                                    <div class="small text-muted"><?= sanitize($e['position_name']) ?></div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border me-1"><?= $e['gender'] == 'L' ? 'Laki-laki' : 'Perempuan' ?>, <?= $e['age'] ?> th</span>
                                    <span class="badge bg-light text-dark border"><?= $e['height'] ?>cm / <?= $e['weight'] ?>kg</span>
                                </td>
                                <td>
                                    <span class="badge bg-info-subtle text-info border border-info-subtle">
                                        <i class="fa-solid fa-chair me-1"></i>Duduk: <?= $e['sitting_hours'] ?? 0 ?>j | Komputer: <?= $e['computer_hours'] ?? 0 ?>j
                                    </span>
                                </td>
                                <td class="text-end text-nowrap">
                                    <div class="table-action-group justify-content-end">
                                        <a href="<?= base_url("assessments/create?employee_id={$e['id']}") ?>" class="btn btn-sm btn-outline-success rounded-pill px-2 py-1" title="Assessment NBM Baru"><i class="fa-solid fa-file-signature me-1"></i>Assess</a>
                                        <a href="<?= base_url("employees/edit/{$e['id']}") ?>" class="btn btn-sm btn-outline-warning btn-icon" title="Edit Data"><i class="fa-solid fa-pen"></i></a>
                                        <a href="<?= base_url("employees/delete/{$e['id']}") ?>" class="btn btn-sm btn-outline-danger btn-icon" onclick="return confirm('Hapus data pekerja ini?');" title="Hapus"><i class="fa-solid fa-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
