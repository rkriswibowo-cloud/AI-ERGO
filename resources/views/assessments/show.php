<div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-1">Detail Assessment & Rekomendasi AI</h4>
        <p class="text-muted small mb-0">Assessment #<?= $assessment['id'] ?> - <?= date('d F Y', strtotime($assessment['assessment_date'])) ?></p>
    </div>
    <div class="d-flex flex-column flex-sm-row gap-2 w-100 w-sm-auto">
        <a href="<?= base_url('assessments') ?>" class="btn btn-light rounded-pill btn-mobile-full"><i class="fa-solid fa-arrow-left me-1"></i> Kembali</a>
        <a href="<?= base_url("reports/individual/{$assessment['id']}") ?>" target="_blank" class="btn btn-outline-secondary rounded-pill btn-mobile-full"><i class="fa-solid fa-print me-1"></i> Cetak Laporan</a>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Worker Profile Summary -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                <h6 class="fw-bold text-dark mb-0"><i class="fa-solid fa-user-circle text-primary me-2"></i>Profil Pekerja</h6>
            </div>
            <div class="card-body p-4">
                <h5 class="fw-bold text-dark mb-1"><?= sanitize($assessment['employee_name']) ?></h5>
                <p class="text-muted small mb-3">NIK: <code><?= sanitize($assessment['employee_number']) ?></code></p>

                <div class="p-3 bg-light rounded-3 mb-3">
                    <div class="row g-2 text-center">
                        <div class="col-4">
                            <span class="text-muted small d-block">Usia</span>
                            <span class="fw-bold text-dark"><?= $assessment['age'] ?> Th</span>
                        </div>
                        <div class="col-4">
                            <span class="text-muted small d-block">Tinggi</span>
                            <span class="fw-bold text-dark"><?= $assessment['height'] ?> cm</span>
                        </div>
                        <div class="col-4">
                            <span class="text-muted small d-block">Berat</span>
                            <span class="fw-bold text-dark"><?= $assessment['weight'] ?> kg</span>
                        </div>
                    </div>
                </div>

                <div class="mb-2"><strong class="text-dark">Departemen:</strong> <?= sanitize($assessment['department_name']) ?></div>
                <div class="mb-2"><strong class="text-dark">Jabatan:</strong> <?= sanitize($assessment['position_name']) ?></div>
                <div class="mb-2"><strong class="text-dark">Perusahaan:</strong> <?= sanitize($assessment['company_name']) ?></div>
                <hr>
                <div class="mb-2"><strong class="text-dark">Jenis Pekerjaan:</strong> <?= sanitize($assessment['job_type'] ?? 'Pekerja Kantor') ?></div>
                <div class="mb-2"><strong class="text-dark">Durasi Duduk:</strong> <?= $assessment['sitting_hours'] ?? 0 ?> jam/hari</div>
                <div class="mb-2"><strong class="text-dark">Penggunaan Komputer:</strong> <?= $assessment['computer_hours'] ?? 0 ?> jam/hari</div>
            </div>
        </div>
    </div>

    <!-- Assessment Score & Dominant Complaint Summary -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-white border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                <h6 class="fw-bold text-dark mb-0"><i class="fa-solid fa-square-poll-vertical text-primary me-2"></i>Hasil Evaluation Nordic Body Map</h6>
                <?= risk_badge($assessment['risk_level']) ?>
            </div>
            <div class="card-body p-4">
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="p-3 border rounded-3 bg-light text-center">
                            <span class="text-muted small d-block fw-semibold">SKOR TOTAL NBM</span>
                            <h2 class="fw-bold text-primary mb-0"><?= $assessment['total_score'] ?> <small class="fs-6 text-muted">/ 84</small></h2>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 border rounded-3 bg-light text-center">
                            <span class="text-muted small d-block fw-semibold">TINGKAT RISIKO ERGONOMI</span>
                            <h3 class="fw-bold text-dark mb-0"><?= sanitize($assessment['risk_level']) ?></h3>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <h6 class="fw-semibold text-dark mb-2"><i class="fa-solid fa-triangle-exclamation text-warning me-1"></i> Area Tubuh Keluhan Dominan (Skor ≥ 2):</h6>
                    <div class="p-3 bg-warning-subtle text-dark border border-warning-subtle rounded-3">
                        <?= sanitize($assessment['dominant_body_area'] ?? 'Tidak ada keluhan signifikan') ?>
                    </div>
                </div>

                <?php if (!empty($assessment['notes'])): ?>
                    <div>
                        <h6 class="fw-semibold text-dark mb-1">Catatan Assessor:</h6>
                        <p class="text-muted mb-0"><?= sanitize($assessment['notes']) ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- 28 Body Parts Rincian Grid -->
<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
        <h6 class="fw-bold text-dark mb-0"><i class="fa-solid fa-list text-primary me-2"></i>Rincian Skor 28 Bagian Tubuh</h6>
    </div>
    <div class="card-body p-4">
        <div class="row g-2">
            <?php foreach ($details as $d): 
                $badgeClass = 'bg-success';
                $scoreText = '0 - Tidak Sakit';
                if ($d['score'] == 1) { $badgeClass = 'bg-warning text-dark'; $scoreText = '1 - Agak Sakit'; }
                elseif ($d['score'] == 2) { $badgeClass = 'bg-orange text-white'; $scoreText = '2 - Sakit'; }
                elseif ($d['score'] == 3) { $badgeClass = 'bg-danger'; $scoreText = '3 - Sangat Sakit'; }
            ?>
                <div class="col-md-3 col-sm-6">
                    <div class="p-2 border rounded-3 d-flex align-items-center justify-content-between bg-light">
                        <span class="small text-dark fw-semibold"><?= sanitize($d['body_part_name']) ?></span>
                        <span class="badge <?= $badgeClass ?>" style="<?= $d['score'] == 2 ? 'background-color: #f97316;' : '' ?>"><?= $d['score'] ?></span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- AI Recommendation Card -->
<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-header bg-white border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
        <h5 class="fw-bold text-dark mb-0"><i class="fa-solid fa-robot text-primary me-2"></i>Rekomendasi Ergonomi AI</h5>
        <a href="<?= base_url("ai/generate/{$assessment['id']}") ?>" class="btn btn-sm btn-primary rounded-pill shadow-sm">
            <i class="fa-solid fa-arrows-rotate me-1"></i> Re-Generate AI
        </a>
    </div>
    <div class="card-body p-4">
        <?php if (!empty($aiRecommendation)): ?>
            <div class="mb-3 d-flex align-items-center gap-2 text-muted small border-bottom pb-3">
                <span><i class="fa-solid fa-microchip me-1"></i> Provider: <strong><?= sanitize($aiRecommendation['ai_provider']) ?></strong></span>
                <span>•</span>
                <span><i class="fa-solid fa-code-branch me-1"></i> Model: <strong><?= sanitize($aiRecommendation['ai_model']) ?></strong></span>
                <span>•</span>
                <span><i class="fa-solid fa-clock me-1"></i> Dibuat pada: <?= date('d M Y H:i', strtotime($aiRecommendation['generated_at'])) ?></span>
            </div>

            <!-- AI Recommendation Content Rendered in Structured Card -->
            <div class="p-3 bg-light rounded-3 border">
                <div class="markdown-body" style="white-space: pre-wrap; font-family: inherit; line-height: 1.7; color: #1e293b;">
                    <?= sanitize($aiRecommendation['recommendation_text']) ?>
                </div>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="fa-solid fa-robot fa-3x text-muted mb-3"></i>
                <h5 class="fw-bold text-dark">Rekomendasi AI Belum Dibuat</h5>
                <p class="text-muted small mb-3">Klik tombol di bawah untuk menghasilkan rekomendasi perbaikan ergonomi kerja otomatis berbasis LLM.</p>
                <a href="<?= base_url("ai/generate/{$assessment['id']}") ?>" class="btn btn-primary rounded-pill px-4">
                    <i class="fa-solid fa-wand-magic-sparkles me-1"></i> Generate Rekomendasi AI Sekarang
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>
