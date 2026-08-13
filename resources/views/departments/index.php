<div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-1">Manajemen Departemen</h4>
        <p class="text-muted small mb-0">Daftar unit kerja / departemen organisasi</p>
    </div>
    <a href="<?= base_url('departments/create') ?>" class="btn btn-primary rounded-pill shadow-sm btn-mobile-full">
        <i class="fa-solid fa-plus me-1"></i> Tambah Departemen
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Perusahaan</th>
                        <th>Nama Departemen</th>
                        <th>Deskripsi</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($departments)): ?>
                        <tr><td colspan="5" class="text-center text-muted py-3">Belum ada data departemen.</td></tr>
                    <?php else: ?>
                        <?php $no = 1; foreach ($departments as $d): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><span class="badge bg-light text-dark border"><?= sanitize($d['company_name']) ?></span></td>
                                <td class="fw-semibold text-dark"><?= sanitize($d['name']) ?></td>
                                <td><?= sanitize($d['description']) ?></td>
                                <td class="text-end text-nowrap">
                                    <div class="table-action-group justify-content-end">
                                        <a href="<?= base_url("departments/edit/{$d['id']}") ?>" class="btn btn-sm btn-outline-warning btn-icon" title="Edit Departemen"><i class="fa-solid fa-pen"></i></a>
                                        <a href="<?= base_url("departments/delete/{$d['id']}") ?>" class="btn btn-sm btn-outline-danger btn-icon" onclick="return confirm('Hapus departemen ini?');" title="Hapus"><i class="fa-solid fa-trash"></i></a>
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
