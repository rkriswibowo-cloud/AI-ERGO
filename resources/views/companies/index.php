<div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-1">Manajemen Perusahaan / Organisasi</h4>
        <p class="text-muted small mb-0">Kelola daftar organisasi multi-tenant pada sistem AI-ERGO</p>
    </div>
    <a href="<?= base_url('companies/create') ?>" class="btn btn-primary rounded-pill shadow-sm btn-mobile-full">
        <i class="fa-solid fa-plus me-1"></i> Tambah Perusahaan
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Nama Perusahaan</th>
                        <th>Alamat</th>
                        <th>Telepon</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($companies)): ?>
                        <tr><td colspan="7" class="text-center text-muted py-3">Belum ada data perusahaan.</td></tr>
                    <?php else: ?>
                        <?php $no = 1; foreach ($companies as $c): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td class="fw-semibold text-dark"><?= sanitize($c['name']) ?></td>
                                <td><?= sanitize($c['address']) ?></td>
                                <td><?= sanitize($c['phone']) ?></td>
                                <td><?= sanitize($c['email']) ?></td>
                                <td>
                                    <span class="badge bg-<?= $c['status'] == 'active' ? 'success' : 'secondary' ?>">
                                        <?= ucfirst($c['status']) ?>
                                    </span>
                                </td>
                                <td class="text-end text-nowrap">
                                    <div class="table-action-group justify-content-end">
                                        <a href="<?= base_url("companies/edit/{$c['id']}") ?>" class="btn btn-sm btn-outline-warning btn-icon" title="Edit Perusahaan"><i class="fa-solid fa-pen"></i></a>
                                        <a href="<?= base_url("companies/delete/{$c['id']}") ?>" class="btn btn-sm btn-outline-danger btn-icon" onclick="return confirm('Apakah Anda yakin ingin menghapus perusahaan ini?');" title="Hapus"><i class="fa-solid fa-trash"></i></a>
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
