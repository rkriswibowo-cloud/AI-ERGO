<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-1">Histori Rekomendasi AI Ergonomi</h4>
        <p class="text-muted small mb-0">Daftar rekomendasi perbaikan ergonomi berbasis LLM yang telah di-generate</p>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Tanggal Generate</th>
                        <th>Pekerja</th>
                        <th>Perusahaan</th>
                        <th>Skor NBM & Risiko</th>
                        <th>Provider AI</th>
                        <th>Model AI</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($recommendations)): ?>
                        <tr><td colspan="8" class="text-center text-muted py-3">Belum ada histori rekomendasi AI.</td></tr>
                    <?php else: ?>
                        <?php $no = 1; foreach ($recommendations as $r): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= date('d M Y H:i', strtotime($r['generated_at'])) ?></td>
                                <td class="fw-semibold text-dark"><?= sanitize($r['employee_name']) ?></td>
                                <td><?= sanitize($r['company_name']) ?></td>
                                <td>
                                    <span class="badge bg-light text-dark border me-1"><?= $r['total_score'] ?> / 84</span>
                                    <?= risk_badge($r['risk_level']) ?>
                                </td>
                                <td><span class="badge bg-primary-subtle text-primary border border-primary-subtle"><?= sanitize($r['ai_provider']) ?></span></td>
                                <td><code><?= sanitize($r['ai_model']) ?></code></td>
                                <td class="text-end text-nowrap">
                                    <div class="table-action-group justify-content-end">
                                        <a href="<?= base_url("assessments/show/{$r['assessment_id']}") ?>" class="btn btn-sm btn-outline-primary rounded-pill px-2 py-1"><i class="fa-solid fa-eye me-1"></i>Lihat Detail</a>
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
