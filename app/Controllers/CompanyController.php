<?php

namespace App\Controllers;

use Core\Controller;
use App\Middleware\RoleMiddleware;
use App\Models\Company;
use App\Models\ActivityLog;

class CompanyController extends Controller {

    public function index() {
        RoleMiddleware::check(['Super Admin']);
        $companyModel = new Company();
        $companies = $companyModel->all();
        $this->view('companies/index', ['companies' => $companies]);
    }

    public function create() {
        RoleMiddleware::check(['Super Admin']);
        if ($this->isPost()) {
            verify_csrf();
            $data = [
                'name' => $this->input('name'),
                'address' => $this->input('address'),
                'phone' => $this->input('phone'),
                'email' => $this->input('email'),
                'status' => $this->input('status', 'active')
            ];
            $companyModel = new Company();
            $id = $companyModel->create($data);
            
            (new ActivityLog())->log('companies', 'create', "Menambah organisasi {$data['name']}");
            flash('success', 'Perusahaan berhasil ditambahkan.');
            redirect('companies');
            return;
        }
        $this->view('companies/form', ['company' => null, 'title' => 'Tambah Perusahaan']);
    }

    public function edit($id) {
        RoleMiddleware::check(['Super Admin']);
        $companyModel = new Company();
        $company = $companyModel->find($id);

        if (!$company) {
            flash('error', 'Data tidak ditemukan.', 'danger');
            redirect('companies');
            return;
        }

        if ($this->isPost()) {
            verify_csrf();
            $data = [
                'name' => $this->input('name'),
                'address' => $this->input('address'),
                'phone' => $this->input('phone'),
                'email' => $this->input('email'),
                'status' => $this->input('status', 'active')
            ];
            $companyModel->update($id, $data);

            (new ActivityLog())->log('companies', 'update', "Mengubah organisasi {$data['name']}");
            flash('success', 'Perusahaan berhasil diperbarui.');
            redirect('companies');
            return;
        }

        $this->view('companies/form', ['company' => $company, 'title' => 'Edit Perusahaan']);
    }

    public function delete($id) {
        RoleMiddleware::check(['Super Admin']);
        $companyModel = new Company();
        $company = $companyModel->find($id);
        if ($company) {
            $companyModel->delete($id);
            (new ActivityLog())->log('companies', 'delete', "Menghapus organisasi {$company['name']}");
            flash('success', 'Perusahaan berhasil dihapus.');
        }
        redirect('companies');
    }
}
