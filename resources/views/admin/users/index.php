<div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-1">Manajemen User System</h4>
        <p class="text-muted small mb-0">Kelola akun pengguna, penetapan role, dan akses login</p>
    </div>
    <a href="<?= base_url('admin/users/create') ?>" class="btn btn-primary rounded-pill shadow-sm btn-mobile-full">
        <i class="fa-solid fa-user-plus me-1"></i> Tambah User
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Nama User</th>
                        <th>Email</th>
                        <th>Perusahaan</th>
                        <th>Role Akses</th>
                        <th>Status</th>
                        <th>Login Terakhir</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($users as $u): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td class="fw-semibold text-dark"><?= sanitize($u['name']) ?></td>
                            <td><?= sanitize($u['email']) ?></td>
                            <td><?= sanitize($u['company_name'] ?? 'Global System') ?></td>
                            <td><span class="badge bg-primary-subtle text-primary border border-primary-subtle"><?= sanitize($u['role_names'] ?? 'Employee') ?></span></td>
                            <td><span class="badge bg-<?= $u['status'] == 'active' ? 'success' : 'secondary' ?>"><?= ucfirst($u['status']) ?></span></td>
                            <td class="small text-muted"><?= $u['last_login'] ? date('d M Y H:i', strtotime($u['last_login'])) : '-' ?></td>
                            <td class="text-end text-nowrap">
                                <div class="table-action-group justify-content-end">
                                    <?php if (has_role('Super Admin') && $u['id'] != (auth_user()['id'] ?? 0)): ?>
                                        <a href="<?= base_url("admin/users/impersonate/{$u['id']}") ?>" class="btn btn-sm btn-outline-info btn-icon" title="Login sebagai user ini (Impersonate)"><i class="fa-solid fa-user-ninja"></i></a>
                                    <?php endif; ?>
                                    <a href="<?= base_url("admin/users/edit/{$u['id']}") ?>" class="btn btn-sm btn-outline-warning btn-icon" title="Edit User"><i class="fa-solid fa-pen"></i></a>
                                    <?php if ($u['id'] != 1): ?>
                                        <a href="<?= base_url("admin/users/delete/{$u['id']}") ?>" class="btn btn-sm btn-outline-danger btn-icon" onclick="return confirm('Hapus user ini?');" title="Hapus User"><i class="fa-solid fa-trash"></i></a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
