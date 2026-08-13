<div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-1">Dashboard Analitik Ergonomi</h4>
        <p class="text-muted small mb-0">Overview Nordic Body Map & Risk Monitoring Sistem AI-ERGO</p>
    </div>
    <a href="<?= base_url('assessments/create') ?>" class="btn btn-primary rounded-pill shadow-sm btn-mobile-full">
        <i class="fa-solid fa-plus me-1"></i> Assessment Baru
    </a>
</div>

<!-- KPI Cards -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-lg-3">
        <div class="card stat-card bg-white p-3">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small fw-semibold">Total Assessment</span>
                    <h3 class="fw-bold text-dark my-1"><?= $totalAssessments ?></h3>
                    <span class="text-success small"><i class="fa-solid fa-file-check me-1"></i>Terekam</span>
                </div>
                <div class="card-icon bg-primary-subtle text-primary">
                    <i class="fa-solid fa-clipboard-list"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card stat-card bg-white p-3">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small fw-semibold">Total Pekerja</span>
                    <h3 class="fw-bold text-dark my-1"><?= $totalEmployees ?></h3>
                    <span class="text-info small"><i class="fa-solid fa-user-group me-1"></i>Terdaftar</span>
                </div>
                <div class="card-icon bg-info-subtle text-info">
                    <i class="fa-solid fa-users"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card stat-card bg-white p-3">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small fw-semibold">Risiko Tinggi / Sangat Tinggi</span>
                    <h3 class="fw-bold text-danger my-1"><?= ($riskStats['Tinggi'] + $riskStats['Sangat Tinggi']) ?></h3>
                    <span class="text-danger small"><i class="fa-solid fa-triangle-exclamation me-1"></i>Butuh Tindakan</span>
                </div>
                <div class="card-icon bg-danger-subtle text-danger">
                    <i class="fa-solid fa-radiation"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card stat-card bg-white p-3">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small fw-semibold">Risiko Rendah / Sedang</span>
                    <h3 class="fw-bold text-success my-1"><?= ($riskStats['Rendah'] + $riskStats['Sedang']) ?></h3>
                    <span class="text-success small"><i class="fa-solid fa-shield-check me-1"></i>Kondisi Aman</span>
                </div>
                <div class="card-icon bg-success-subtle text-success">
                    <i class="fa-solid fa-heart-pulse"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Section -->
<div class="row g-4 mb-4">
    <div class="col-md-5">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                <h6 class="fw-bold text-dark mb-0"><i class="fa-solid fa-chart-pie text-primary me-2"></i>Distribusi Tingkat Risiko</h6>
            </div>
            <div class="card-body p-4 d-flex align-items-center justify-content-center">
                <canvas id="riskPieChart" style="max-height: 260px;"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-7">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                <h6 class="fw-bold text-dark mb-0"><i class="fa-solid fa-chart-simple text-primary me-2"></i>Top Keluhan Bagian Tubuh</h6>
            </div>
            <div class="card-body p-4">
                <canvas id="bodyComplaintsBarChart" style="max-height: 260px;"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Recent Assessments Table -->
<div class="card border-0 shadow-sm rounded-4">
    <div class="card-header bg-white border-0 pt-4 px-3 px-md-4 pb-0 d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-2">
            <h6 class="fw-bold text-dark mb-0"><i class="fa-solid fa-clock-rotate-left text-primary me-2"></i>Assessment Terbaru</h6>
            <div class="d-flex align-items-center gap-1 d-md-none ms-1">
                <button type="button" class="btn btn-sm btn-outline-secondary rounded-circle px-2 py-1 scroll-left-btn" title="Geser Kiri"><i class="fa-solid fa-chevron-left fs-7"></i></button>
                <button type="button" class="btn btn-sm btn-primary rounded-circle px-2 py-1 scroll-right-btn" title="Geser Kanan"><i class="fa-solid fa-chevron-right fs-7"></i></button>
            </div>
        </div>
        <a href="<?= base_url('assessments') ?>" class="btn btn-sm btn-light rounded-pill">Lihat Semua</a>
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
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($recentAssessments)): ?>
                        <tr><td colspan="8" class="text-center text-muted py-3">Belum ada data assessment.</td></tr>
                    <?php else: ?>
                        <?php $no = 1; foreach ($recentAssessments as $a): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= date('d M Y', strtotime($a['assessment_date'])) ?></td>
                                <td><code><?= sanitize($a['employee_number']) ?></code></td>
                                <td class="fw-semibold text-dark"><?= sanitize($a['employee_name']) ?></td>
                                <td><?= sanitize($a['department_name']) ?></td>
                                <td><span class="badge bg-light text-dark border px-2 py-1"><?= $a['total_score'] ?> / 84</span></td>
                                <td><?= risk_badge($a['risk_level']) ?></td>
                                <td class="text-end text-nowrap">
                                    <div class="table-action-group justify-content-end">
                                        <a href="<?= base_url("assessments/show/{$a['id']}") ?>" class="btn btn-sm btn-outline-primary rounded-pill px-2 py-1">
                                            <i class="fa-solid fa-eye me-1"></i>Detail & AI
                                        </a>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Risk Pie Chart
    const ctxPie = document.getElementById('riskPieChart').getContext('2d');
    new Chart(ctxPie, {
        type: 'doughnut',
        data: {
            labels: ['Rendah', 'Sedang', 'Tinggi', 'Sangat Tinggi'],
            datasets: [{
                data: [
                    <?= $riskStats['Rendah'] ?>,
                    <?= $riskStats['Sedang'] ?>,
                    <?= $riskStats['Tinggi'] ?>,
                    <?= $riskStats['Sangat Tinggi'] ?>
                ],
                backgroundColor: ['#10b981', '#f59e0b', '#f97316', '#ef4444']
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });

    // Body Complaints Bar Chart
    const ctxBar = document.getElementById('bodyComplaintsBarChart').getContext('2d');
    const complaintLabels = <?= json_encode(array_column($topComplaints, 'body_part_name')) ?>;
    const complaintData = <?= json_encode(array_column($topComplaints, 'total_score')) ?>;

    new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: complaintLabels.length > 0 ? complaintLabels : ['Leher Atas', 'Punggung', 'Pinggang', 'Pergelangan Tangan'],
            datasets: [{
                label: 'Akumulasi Skor Keluhan',
                data: complaintData.length > 0 ? complaintData : [12, 10, 8, 7],
                backgroundColor: '#4f46e5',
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
});
</script>
