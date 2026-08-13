<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-1">Matriks Role & Hak Akses (RBAC)</h4>
        <p class="text-muted small mb-0">Daftar role sistem dan hak akses permission masing-masing peran</p>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
        <h6 class="fw-bold text-dark mb-0"><i class="fa-solid fa-shield-halved text-primary me-2"></i>Daftar Role Sistem</h6>
    </div>
    <div class="card-body p-4">
        <div class="row g-3">
            <?php foreach ($roles as $r): ?>
                <div class="col-md-4">
                    <div class="p-3 border rounded-3 bg-light">
                        <h6 class="fw-bold text-primary mb-1"><?= sanitize($r['name']) ?></h6>
                        <p class="small text-muted mb-0"><?= sanitize($r['description']) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
        <h6 class="fw-bold text-dark mb-0"><i class="fa-solid fa-key text-primary me-2"></i>Daftar Permissions Sistem</h6>
    </div>
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Modul</th>
                        <th>Nama Permission</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($permissions as $p): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><span class="badge bg-secondary-subtle text-secondary border"><?= sanitize($p['module']) ?></span></td>
                            <td><code><?= sanitize($p['name']) ?></code></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
