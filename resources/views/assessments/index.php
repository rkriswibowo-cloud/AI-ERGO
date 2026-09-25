<div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-1">Histori Assessment Nordic Body Map</h4>
        <?php if (!empty($isEmployee) && !empty($currentEmployee)): ?>
            <p class="text-muted small mb-0">Riwayat penilaian mandiri keluhan tubuh untuk: <strong class="text-primary"><?= sanitize($currentEmployee['name']) ?></strong> (<?= sanitize($currentEmployee['employee_number']) ?>)</p>
        <?php else: ?>
            <p class="text-muted small mb-0">Daftar riwayat evaluasi risiko ergonomi seluruh pekerja</p>
        <?php endif; ?>
    </div>
    <a href="<?= base_url('assessments/create') ?>" class="btn btn-primary rounded-pill shadow-sm btn-mobile-full">
        <i class="fa-solid fa-plus me-1"></i> Assessment Baru
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-header bg-white border-0 pt-3 px-3 px-md-4 pb-0 d-flex justify-content-between align-items-center">
        <h6 class="fw-bold text-dark mb-0"><i class="fa-solid fa-list-check text-primary me-2"></i>Daftar Assessment NBM</h6>
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
                        <th>Tanggal</th>
                        <th>NIK</th>
                        <th>Nama Pekerja</th>
                        <th>Departemen</th>
                        <th>Total Skor NBM</th>
                        <th>Tingkat Risiko</th>
                        <th>Rekomendasi AI</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($assessments)): ?>
                        <tr><td colspan="9" class="text-center text-muted py-3">Belum ada data assessment NBM.</td></tr>
                    <?php else: ?>
                        <?php $no = 1; foreach ($assessments as $a): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= date('d M Y', strtotime($a['assessment_date'])) ?></td>
                                <td><code><?= sanitize($a['employee_number']) ?></code></td>
                                <td>
                                    <div class="fw-semibold text-dark"><?= sanitize($a['employee_name']) ?></div>
                                    <div class="small text-muted"><?= sanitize($a['position_name']) ?></div>
                                </td>
                                <td><?= sanitize($a['department_name']) ?></td>
                                <td><span class="badge bg-light text-dark border px-2 py-1"><?= $a['total_score'] ?> / 84</span></td>
                                <td><?= risk_badge($a['risk_level']) ?></td>
                                <td>
                                    <?php if (!empty($a['ai_rec_id'])): ?>
                                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle"><i class="fa-solid fa-robot me-1"></i>Tersedia</span>
                                    <?php else: ?>
                                        <span class="badge bg-light text-muted border">Belum</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end text-nowrap">
                                    <div class="table-action-group justify-content-end">
                                        <a href="<?= base_url("assessments/show/{$a['id']}") ?>" class="btn btn-sm btn-outline-primary rounded-pill px-2 py-1" title="Detail"><i class="fa-solid fa-eye me-1"></i>Detail</a>
                                        <a href="<?= base_url("reports/individual/{$a['id']}") ?>" target="_blank" class="btn btn-sm btn-outline-secondary btn-icon" title="Cetak Laporan"><i class="fa-solid fa-print"></i></a>
                                        <?php if (has_role('Super Admin') || has_role('Admin K3')): ?>
                                            <a href="<?= base_url("assessments/delete/{$a['id']}") ?>" class="btn btn-sm btn-outline-danger btn-icon" onclick="return confirm('Hapus assessment ini?');" title="Hapus"><i class="fa-solid fa-trash"></i></a>
                                        <?php endif; ?>
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
