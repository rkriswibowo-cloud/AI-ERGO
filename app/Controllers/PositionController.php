<?php

namespace App\Controllers;

use Core\Controller;
use App\Middleware\RoleMiddleware;
use App\Models\Position;
use App\Models\Company;
use App\Models\ActivityLog;

class PositionController extends Controller {

    public function index() {
        RoleMiddleware::check(['Super Admin', 'Admin K3']);
        $positionModel = new Position();
        $positions = $positionModel->getWithCompany();
        $this->view('positions/index', ['positions' => $positions]);
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
            $posModel = new Position();
            $posModel->create($data);

            (new ActivityLog())->log('positions', 'create', "Menambah jabatan {$data['name']}");
            flash('success', 'Jabatan berhasil ditambahkan.');
            redirect('positions');
            return;
        }

        $this->view('positions/form', ['position' => null, 'companies' => $companies, 'title' => 'Tambah Jabatan']);
    }

    public function edit($id) {
        RoleMiddleware::check(['Super Admin', 'Admin K3']);
        $posModel = new Position();
        $position = $posModel->find($id);

        if (!$position) {
            flash('error', 'Jabatan tidak ditemukan.', 'danger');
            redirect('positions');
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
            $posModel->update($id, $data);

            (new ActivityLog())->log('positions', 'update', "Mengubah jabatan {$data['name']}");
            flash('success', 'Jabatan berhasil diperbarui.');
            redirect('positions');
            return;
        }

        $this->view('positions/form', ['position' => $position, 'companies' => $companies, 'title' => 'Edit Jabatan']);
    }

    public function delete($id) {
        RoleMiddleware::check(['Super Admin', 'Admin K3']);
        $posModel = new Position();
        $position = $posModel->find($id);
        if ($position) {
            $posModel->delete($id);
            (new ActivityLog())->log('positions', 'delete', "Menghapus jabatan {$position['name']}");
            flash('success', 'Jabatan berhasil dihapus.');
        }
        redirect('positions');
    }
}
