<div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-1">Laporan Profil Ergonomi Organisasi</h4>
        <p class="text-muted small mb-0">Analisis agregat risiko ergonomi dan distribusi keluhan pekerja</p>
    </div>
    <a href="<?= base_url('reports/export-csv') ?>" class="btn btn-success rounded-pill shadow-sm btn-mobile-full">
        <i class="fa-solid fa-file-excel me-1"></i> Export Data CSV
    </a>
</div>

<!-- Company Filter Card -->
<?php if (has_role('Super Admin') && !empty($companies)): ?>
<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-body p-3">
        <form action="" method="GET" class="row g-2 align-items-center">
            <div class="col-auto">
                <label class="col-form-label fw-semibold text-dark">Filter Perusahaan:</label>
            </div>
            <div class="col-md-4">
                <select name="company_id" class="form-select" onchange="this.form.submit()">
                    <option value="">-- Seluruh Perusahaan --</option>
                    <?php foreach ($companies as $c): ?>
                        <option value="<?= $c['id'] ?>" <?= $selectedCompanyId == $c['id'] ? 'selected' : '' ?>>
                            <?= sanitize($c['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>

<!-- Metrics Row -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-primary text-white">
            <div class="small fw-semibold text-white-50">TOTAL PEKERJA ASSESSMENT</div>
            <h2 class="fw-bold my-1"><?= count($assessments) ?></h2>
            <span class="small text-white-50">Dari total <?= $totalEmployees ?> pekerja</span>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-danger text-white">
            <div class="small fw-semibold text-white-50">RISIKO SANGAT TINGGI</div>
            <h2 class="fw-bold my-1"><?= $riskStats['Sangat Tinggi'] ?></h2>
            <span class="small text-white-50">Butuh intervensi segera</span>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-warning text-dark">
            <div class="small fw-semibold text-dark-50">RISIKO TINGGI & SEDANG</div>
            <h2 class="fw-bold my-1"><?= ($riskStats['Tinggi'] + $riskStats['Sedang']) ?></h2>
            <span class="small text-dark-50">Perlu evaluasi stasiun kerja</span>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-success text-white">
            <div class="small fw-semibold text-white-50">RISIKO RENDAH</div>
            <h2 class="fw-bold my-1"><?= $riskStats['Rendah'] ?></h2>
            <span class="small text-white-50">Kondisi postur aman</span>
        </div>
    </div>
</div>

<!-- Table Assessments List -->
<div class="card border-0 shadow-sm rounded-4">
    <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
        <h6 class="fw-bold text-dark mb-0"><i class="fa-solid fa-list-check text-primary me-2"></i>Rekapitulasi Assessment Organisasi</h6>
    </div>
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Tanggal</th>
                        <th>NIK</th>
                        <th>Nama Pekerja</th>
                        <th>Departemen / Jabatan</th>
                        <th>Total Skor NBM</th>
                        <th>Tingkat Risiko</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($assessments)): ?>
                        <tr><td colspan="8" class="text-center text-muted py-3">Belum ada data assessment.</td></tr>
                    <?php else: ?>
                        <?php $no = 1; foreach ($assessments as $a): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= date('d M Y', strtotime($a['assessment_date'])) ?></td>
                                <td><code><?= sanitize($a['employee_number']) ?></code></td>
                                <td class="fw-semibold text-dark"><?= sanitize($a['employee_name']) ?></td>
                                <td>
                                    <div class="fw-semibold text-dark"><?= sanitize($a['department_name']) ?></div>
                                    <div class="small text-muted"><?= sanitize($a['position_name']) ?></div>
                                </td>
                                <td><span class="badge bg-light text-dark border px-2 py-1"><?= $a['total_score'] ?> / 84</span></td>
                                <td><?= risk_badge($a['risk_level']) ?></td>
                                <td class="text-end text-nowrap">
                                    <div class="table-action-group justify-content-end">
                                        <a href="<?= base_url("reports/individual/{$a['id']}") ?>" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill px-2 py-1"><i class="fa-solid fa-print me-1"></i>Laporan</a>
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
