<?php

namespace App\Controllers;

use Core\Controller;
use App\Models\User;
use App\Models\ActivityLog;

class AuthController extends Controller {

    public function login() {
        if (is_logged_in()) {
            redirect('dashboard');
        }

        if ($this->isPost()) {
            verify_csrf();

            $email = $this->input('email');
            $password = $_POST['password'] ?? '';

            if (empty($email) || empty($password)) {
                flash('login_error', 'Email dan Password wajib diisi.', 'danger');
                $this->view('auth/login', ['email' => $email], null);
                return;
            }

            $userModel = new User();
            $user = $userModel->findByEmail($email);

            if ($user && password_verify($password, $user['password'])) {
                if ($user['status'] !== 'active') {
                    flash('login_error', 'Akun Anda tidak aktif. Silakan hubungi Super Admin.', 'danger');
                    $this->view('auth/login', ['email' => $email], null);
                    return;
                }

                // Get user roles
                $roles = $userModel->getUserRoles($user['id']);
                $user['roles'] = $roles;

                // Set session
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
                $_SESSION['user'] = $user;

                // Update last login
                $userModel->update($user['id'], ['last_login' => date('Y-m-d H:i:s')]);

                // Audit Log
                $logger = new ActivityLog();
                $logger->log('auth', 'login', "User {$user['email']} berhasil login.");

                flash('success', "Selamat datang kembali, {$user['name']}!");
                redirect('dashboard');
                return;
            } else {
                flash('login_error', 'Email atau Password salah.', 'danger');
                $this->view('auth/login', ['email' => $email], null);
                return;
            }
        }

        $this->view('auth/login', [], null);
    }

    public function register() {
        if (is_logged_in()) {
            redirect('dashboard');
        }

        $companyModel = new \App\Models\Company();
        $companies = $companyModel->all();

        if ($this->isPost()) {
            verify_csrf();

            $name = trim($this->input('name'));
            $email = trim($this->input('email'));
            $password = $_POST['password'] ?? '';
            $companyId = $this->input('company_id') ?: null;

            if (empty($name) || empty($email) || empty($password)) {
                flash('register_error', 'Nama, Email, dan Password wajib diisi.');
                $this->view('auth/register', ['companies' => $companies, 'old' => $_POST], null);
                return;
            }

            $userModel = new User();
            $existing = $userModel->findByEmail($email);
            if ($existing) {
                flash('register_error', 'Email tersebut sudah terdaftar. Silakan gunakan email lain.');
                $this->view('auth/register', ['companies' => $companies, 'old' => $_POST], null);
                return;
            }

            $userId = $userModel->create([
                'company_id' => $companyId,
                'name' => $name,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_BCRYPT),
                'status' => 'active'
            ]);

            // Assign default role Pekerja (ID 5)
            $userModel->assignRole($userId, 5);

            (new ActivityLog())->log('auth', 'register', "User baru mendaftar akun: {$email}");

            flash('success', 'Pendaftaran berhasil! Silakan masuk menggunakan email dan password Anda.');
            redirect('auth/login');
            return;
        }

        $this->view('auth/register', ['companies' => $companies], null);
    }

    public function logout() {
        if (is_logged_in()) {
            $user = auth_user();
            $logger = new ActivityLog();
            $logger->log('auth', 'logout', "User {$user['email']} logout.");

            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            unset($_SESSION['user']);
            session_destroy();
        }

        redirect('auth/login');
    }
}
