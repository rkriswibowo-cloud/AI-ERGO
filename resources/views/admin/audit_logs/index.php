<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h4 class="fw-bold text-dark mb-1">Audit Log Aktivitas Sistem</h4>
        <p class="text-muted small mb-0">Catatan jejak aktivitas user (login, tambah, edit, hapus, generate AI)</p>
    </div>
    <?php if (!empty($logs)): ?>
        <a href="<?= base_url('admin/audit-logs/clear') ?>" class="btn btn-outline-danger rounded-pill px-3 shadow-sm btn-mobile-full" onclick="return confirm('Apakah Anda yakin ingin menghapus SELURUH catatan audit log aktivitas? Tindakan ini tidak dapat dibatalkan.');">
            <i class="fa-solid fa-trash-can me-1"></i> Reset / Bersihkan Audit Log
        </a>
    <?php endif; ?>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-header bg-white border-0 pt-3 px-4 pb-0 d-flex align-items-center justify-content-between">
        <h6 class="fw-bold text-dark mb-0"><i class="fa-solid fa-list-check text-primary me-2"></i>Daftar Aktivitas Terakhir</h6>
        <div class="d-md-none">
            <button type="button" class="btn btn-sm btn-outline-secondary rounded-circle scroll-left-btn me-1" title="Geser Kiri"><i class="fa-solid fa-chevron-left"></i></button>
            <button type="button" class="btn btn-sm btn-outline-secondary rounded-circle scroll-right-btn" title="Geser Kanan"><i class="fa-solid fa-chevron-right"></i></button>
        </div>
    </div>
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Waktu</th>
                        <th>User</th>
                        <th>Modul</th>
                        <th>Aksi</th>
                        <th>Deskripsi Aktivitas</th>
                        <th>IP Address</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($logs)): ?>
                        <tr><td colspan="7" class="text-center text-muted py-3">Belum ada catatan log aktivitas.</td></tr>
                    <?php else: ?>
                        <?php $no = 1; foreach ($logs as $l): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td class="small text-muted text-nowrap"><?= date('d M Y H:i:s', strtotime($l['created_at'])) ?></td>
                                <td>
                                    <div class="fw-semibold text-dark small"><?= sanitize($l['user_name'] ?? 'System') ?></div>
                                    <div class="small text-muted" style="font-size: 0.75rem;"><?= sanitize($l['user_email'] ?? '-') ?></div>
                                </td>
                                <td><span class="badge bg-secondary-subtle text-secondary border"><?= sanitize($l['module']) ?></span></td>
                                <td><span class="badge bg-info-subtle text-info border border-info-subtle"><?= sanitize($l['action']) ?></span></td>
                                <td class="small text-dark"><?= sanitize($l['description']) ?></td>
                                <td><code><?= sanitize($l['ip_address']) ?></code></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
