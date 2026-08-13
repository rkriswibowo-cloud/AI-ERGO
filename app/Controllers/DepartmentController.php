<?php

namespace App\Controllers;

use Core\Controller;
use App\Middleware\RoleMiddleware;
use App\Models\Department;
use App\Models\Company;
use App\Models\ActivityLog;

class DepartmentController extends Controller {

    public function index() {
        RoleMiddleware::check(['Super Admin', 'Admin K3']);
        $departmentModel = new Department();
        $departments = $departmentModel->getWithCompany();
        $this->view('departments/index', ['departments' => $departments]);
    }

    public function create() {
        RoleMiddleware::check(['Super Admin', 'Admin K3']);
        $companyModel = new Company();
        $companies = $companyModel->all();

        if ($this->isPost()) {
            verify_csrf();
            $data = [
                'company_id' => $this->input('company_id'),
                'name' => $this->input('name'),
                'description' => $this->input('description')
            ];
            $deptModel = new Department();
            $deptModel->create($data);

            (new ActivityLog())->log('departments', 'create', "Menambah departemen {$data['name']}");
            flash('success', 'Departemen berhasil ditambahkan.');
            redirect('departments');
            return;
        }

        $this->view('departments/form', ['department' => null, 'companies' => $companies, 'title' => 'Tambah Departemen']);
    }

    public function edit($id) {
        RoleMiddleware::check(['Super Admin', 'Admin K3']);
        $deptModel = new Department();
        $department = $deptModel->find($id);

        if (!$department) {
            flash('error', 'Departemen tidak ditemukan.', 'danger');
            redirect('departments');
            return;
        }

        $companyModel = new Company();
        $companies = $companyModel->all();

        if ($this->isPost()) {
            verify_csrf();
            $data = [
                'company_id' => $this->input('company_id'),
                'name' => $this->input('name'),
                'description' => $this->input('description')
            ];
            $deptModel->update($id, $data);

            (new ActivityLog())->log('departments', 'update', "Mengubah departemen {$data['name']}");
            flash('success', 'Departemen berhasil diperbarui.');
            redirect('departments');
            return;
        }

        $this->view('departments/form', ['department' => $department, 'companies' => $companies, 'title' => 'Edit Departemen']);
    }

    public function delete($id) {
        RoleMiddleware::check(['Super Admin', 'Admin K3']);
        $deptModel = new Department();
        $department = $deptModel->find($id);
        if ($department) {
            $deptModel->delete($id);
            (new ActivityLog())->log('departments', 'delete', "Menghapus departemen {$department['name']}");
            flash('success', 'Departemen berhasil dihapus.');
        }
        redirect('departments');
    }
}
