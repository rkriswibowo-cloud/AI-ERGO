<?php

namespace App\Controllers;

use Core\Controller;
use App\Middleware\RoleMiddleware;
use App\Models\User;
use App\Models\Company;
use App\Models\Role;
use App\Models\ActivityLog;

class UserController extends Controller {

    public function index() {
        RoleMiddleware::check(['Super Admin', 'Admin K3', 'HRD']);
        $userModel = new User();
        $users = $userModel->getWithDetails();

        // Security: Non-Super Admin users (HRD & Admin K3) CANNOT see Super Admin accounts
        if (!has_role('Super Admin')) {
            $users = array_filter($users, function($u) {
                $roleNames = strtolower($u['role_names'] ?? '');
                return strpos($roleNames, 'super admin') === false && $u['id'] != 1;
            });
            $users = array_values($users);
        }

        $this->view('admin/users/index', ['users' => $users]);
    }

    public function create() {
        RoleMiddleware::check(['Super Admin', 'Admin K3', 'HRD']);
        $companyModel = new Company();
        $roleModel = new Role();

        $companies = $companyModel->all();
        $roles = $roleModel->all();

        if ($this->isPost()) {
            verify_csrf();
            
            $roleId = (int)$this->input('role_id', 5);
            // Security: Non-Super Admin users cannot create a Super Admin account (Role ID 1)
            if (!has_role('Super Admin') && $roleId == 1) {
                flash('error', 'Anda tidak diizinkan membuat akun dengan role Super Admin.');
                redirect('admin/users');
                return;
            }

            $data = [
                'company_id' => $this->input('company_id') ?: null,
                'name' => $this->input('name'),
                'email' => $this->input('email'),
                'password' => password_hash($this->input('password'), PASSWORD_BCRYPT),
                'status' => $this->input('status', 'active')
            ];

            $userModel = new User();
            $userId = $userModel->create($data);
            $userModel->assignRole($userId, $roleId);

            (new ActivityLog())->log('users', 'create', "Menambah user {$data['email']}");
            flash('success', 'User berhasil ditambahkan.');
            redirect('admin/users');
            return;
        }

        $this->view('admin/users/form', [
            'user' => null,
            'companies' => $companies,
            'roles' => $roles,
            'title' => 'Tambah User'
        ]);
    }

    public function edit($id) {
        RoleMiddleware::check(['Super Admin', 'Admin K3', 'HRD']);
        $userModel = new User();
        $u = $userModel->find($id);

        if (!$u) {
            flash('error', 'User tidak ditemukan.');
            redirect('admin/users');
            return;
        }

        $currentRoles = $userModel->getUserRoles($id);

        // Security: Non-Super Admin users CANNOT edit Super Admin accounts
        if (!has_role('Super Admin') && (in_array('Super Admin', $currentRoles) || $id == 1)) {
            flash('error', 'Anda tidak memiliki izin untuk mengedit akun Super Admin.');
            redirect('admin/users');
            return;
        }

        $companyModel = new Company();
        $roleModel = new Role();

        $companies = $companyModel->all();
        $roles = $roleModel->all();

        if ($this->isPost()) {
            verify_csrf();
            
            $roleId = (int)$this->input('role_id');
            // Security: Non-Super Admin users cannot assign Super Admin role (Role ID 1)
            if (!has_role('Super Admin') && $roleId == 1) {
                flash('error', 'Anda tidak diizinkan memberikan role Super Admin.');
                redirect('admin/users');
                return;
            }

            $data = [
                'company_id' => $this->input('company_id') ?: null,
                'name' => $this->input('name'),
                'email' => $this->input('email'),
                'status' => $this->input('status', 'active')
            ];

            if ($pass = $this->input('password')) {
                $data['password'] = password_hash($pass, PASSWORD_BCRYPT);
            }

            $userModel->update($id, $data);

            if ($roleId) {
                $userModel->assignRole($id, $roleId);
            }

            (new ActivityLog())->log('users', 'update', "Mengubah data user {$data['email']}");
            flash('success', 'User berhasil diperbarui.');
            redirect('admin/users');
            return;
        }

        $this->view('admin/users/form', [
            'user' => $u,
            'companies' => $companies,
            'roles' => $roles,
            'currentRoles' => $currentRoles,
            'title' => 'Edit User'
        ]);
    }

    public function delete($id) {
        RoleMiddleware::check(['Super Admin', 'Admin K3', 'HRD']);
        $userModel = new User();
        $u = $userModel->find($id);

        if ($u) {
            $currentRoles = $userModel->getUserRoles($id);

            // Security: Non-Super Admin users CANNOT delete Super Admin accounts, and Super Admin ID 1 cannot be deleted
            if (!has_role('Super Admin') && (in_array('Super Admin', $currentRoles) || $id == 1)) {
                flash('error', 'Anda tidak memiliki izin untuk menghapus akun Super Admin.');
                redirect('admin/users');
                return;
            }

            if ($id == 1) {
                flash('error', 'Akun Utama Super Admin tidak dapat dihapus.');
                redirect('admin/users');
                return;
            }

            $userModel->delete($id);
            (new ActivityLog())->log('users', 'delete', "Menghapus user {$u['email']}");
            flash('success', 'User berhasil dihapus.');
        }
        redirect('admin/users');
    }

    public function impersonate($id) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Check if current user is Super Admin or already impersonating
        $isSuperAdmin = has_role('Super Admin') || isset($_SESSION['impersonator_user']);
        if (!$isSuperAdmin) {
            flash('error', 'Hanya Super Admin yang diizinkan untuk login sebagai user lain.');
            redirect('dashboard');
            return;
        }

        $userModel = new User();
        $targetUser = $userModel->find($id);

        if (!$targetUser) {
            flash('error', 'User tujuan tidak ditemukan.');
            redirect('admin/users');
            return;
        }

        if ($targetUser['status'] !== 'active') {
            flash('error', 'Tidak dapat login sebagai user yang dinonaktifkan.');
            redirect('admin/users');
            return;
        }

        // Save original Super Admin session if not already in impersonation mode
        if (!isset($_SESSION['impersonator_user'])) {
            $_SESSION['impersonator_user'] = $_SESSION['user'];
        }

        if ($_SESSION['user']['id'] == $targetUser['id']) {
            flash('warning', 'Anda sudah menggunakan akun ini.');
            redirect('admin/users');
            return;
        }

        $roles = $userModel->getUserRoles($targetUser['id']);
        $targetUser['roles'] = $roles;

        $_SESSION['user'] = $targetUser;

        (new ActivityLog())->log('auth', 'impersonate', "Super Admin login sebagai user ID #{$targetUser['id']} ({$targetUser['name']})");

        flash('info', "Anda sekarang berhasil login sebagai " . $targetUser['name'] . " (" . ($roles[0] ?? 'User') . ").");
        redirect('dashboard');
    }

    public function revertImpersonation() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['impersonator_user'])) {
            $adminUser = $_SESSION['impersonator_user'];
            $_SESSION['user'] = $adminUser;
            unset($_SESSION['impersonator_user']);

            (new ActivityLog())->log('auth', 'revert_impersonate', "Kembali ke akun Super Admin dari mode impersonation.");
            flash('success', "Anda telah kembali ke akun Super Admin (" . $adminUser['name'] . ").");
        } else {
            flash('warning', 'Anda tidak sedang berada dalam mode Login As User.');
        }

        redirect('admin/users');
    }
}
