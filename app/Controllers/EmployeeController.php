<?php

namespace App\Controllers;

use Core\Controller;
use App\Middleware\RoleMiddleware;
use App\Models\Employee;
use App\Models\JobProfile;
use App\Models\Company;
use App\Models\Department;
use App\Models\Position;
use App\Models\ActivityLog;

class EmployeeController extends Controller {

    public function index() {
        RoleMiddleware::check(['Super Admin', 'Admin K3', 'HRD', 'Ergonomist']);
        $user = auth_user();
        $companyId = $user['company_id'] ?? null;

        $employeeModel = new Employee();
        $employees = $employeeModel->getWithDetails($companyId);
        $this->view('employees/index', ['employees' => $employees]);
    }

    public function create() {
        RoleMiddleware::check(['Super Admin', 'Admin K3']);
        $user = auth_user();
        $companyId = $user['company_id'] ?? null;

        $companyModel = new Company();
        $departmentModel = new Department();
        $positionModel = new Position();

        $companies = $companyModel->all();
        $departments = $departmentModel->getWithCompany();
        $positions = $positionModel->getWithCompany();

        if ($this->isPost()) {
            verify_csrf();

            $empData = [
                'company_id' => $this->input('company_id', $companyId),
                'department_id' => $this->input('department_id'),
                'position_id' => $this->input('position_id'),
                'employee_number' => $this->input('employee_number'),
                'name' => $this->input('name'),
                'gender' => $this->input('gender', 'L'),
                'birth_date' => $this->input('birth_date'),
                'age' => (int)$this->input('age', 30),
                'height' => (float)$this->input('height', 170.0),
                'weight' => (float)$this->input('weight', 65.0),
                'years_of_service' => (int)$this->input('years_of_service', 1),
                'phone' => $this->input('phone'),
                'email' => $this->input('email'),
                'status' => $this->input('status', 'active')
            ];

            $employeeModel = new Employee();
            $empId = $employeeModel->create($empData);

            // Job Profile Data
            $jobData = [
                'employee_id' => $empId,
                'job_type' => $this->input('job_type', 'Pekerja Kantor'),
                'sitting_hours' => (float)$this->input('sitting_hours', 4.0),
                'standing_hours' => (float)$this->input('standing_hours', 3.0),
                'computer_hours' => (float)$this->input('computer_hours', 4.0),
                'shift_type' => $this->input('shift_type', 'Non-Shift'),
                'work_duration' => (float)$this->input('work_duration', 8.0)
            ];
            $jobProfileModel = new JobProfile();
            $jobProfileModel->create($jobData);

            (new ActivityLog())->log('employees', 'create', "Menambah pekerja {$empData['name']}");
            flash('success', 'Data pekerja berhasil ditambahkan.');
            redirect('employees');
            return;
        }

        $this->view('employees/form', [
            'employee' => null,
            'companies' => $companies,
            'departments' => $departments,
            'positions' => $positions,
            'title' => 'Tambah Pekerja'
        ]);
    }

    public function edit($id) {
        RoleMiddleware::check(['Super Admin', 'Admin K3']);
        $employeeModel = new Employee();
        $employee = $employeeModel->findWithDetails($id);

        if (!$employee) {
            flash('error', 'Data pekerja tidak ditemukan.', 'danger');
            redirect('employees');
            return;
        }

        $companyModel = new Company();
        $departmentModel = new Department();
        $positionModel = new Position();

        $companies = $companyModel->all();
        $departments = $departmentModel->getWithCompany();
        $positions = $positionModel->getWithCompany();

        if ($this->isPost()) {
            verify_csrf();

            $empData = [
                'company_id' => $this->input('company_id'),
                'department_id' => $this->input('department_id'),
                'position_id' => $this->input('position_id'),
                'employee_number' => $this->input('employee_number'),
                'name' => $this->input('name'),
                'gender' => $this->input('gender', 'L'),
                'birth_date' => $this->input('birth_date'),
                'age' => (int)$this->input('age', 30),
                'height' => (float)$this->input('height', 170.0),
                'weight' => (float)$this->input('weight', 65.0),
                'years_of_service' => (int)$this->input('years_of_service', 1),
                'phone' => $this->input('phone'),
                'email' => $this->input('email'),
                'status' => $this->input('status', 'active')
            ];

            $employeeModel->update($id, $empData);

            // Update/Create Job Profile
            $jobProfileModel = new JobProfile();
            $existingJob = $jobProfileModel->findByEmployee($id);

            $jobData = [
                'employee_id' => $id,
                'job_type' => $this->input('job_type', 'Pekerja Kantor'),
                'sitting_hours' => (float)$this->input('sitting_hours', 4.0),
                'standing_hours' => (float)$this->input('standing_hours', 3.0),
                'computer_hours' => (float)$this->input('computer_hours', 4.0),
                'shift_type' => $this->input('shift_type', 'Non-Shift'),
                'work_duration' => (float)$this->input('work_duration', 8.0)
            ];

            if ($existingJob) {
                $jobProfileModel->update($existingJob['id'], $jobData);
            } else {
                $jobProfileModel->create($jobData);
            }

            (new ActivityLog())->log('employees', 'update', "Mengubah data pekerja {$empData['name']}");
            flash('success', 'Data pekerja berhasil diperbarui.');
            redirect('employees');
            return;
        }

        $this->view('employees/form', [
            'employee' => $employee,
            'companies' => $companies,
            'departments' => $departments,
            'positions' => $positions,
            'title' => 'Edit Data Pekerja'
        ]);
    }

    public function delete($id) {
        RoleMiddleware::check(['Super Admin', 'Admin K3']);
        $employeeModel = new Employee();
        $emp = $employeeModel->find($id);
        if ($emp) {
            $employeeModel->delete($id);
            (new ActivityLog())->log('employees', 'delete', "Menghapus data pekerja {$emp['name']}");
            flash('success', 'Data pekerja berhasil dihapus.');
        }
        redirect('employees');
    }
}
