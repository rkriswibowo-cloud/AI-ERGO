<?php

namespace App\Controllers;

use Core\Controller;
use App\Middleware\RoleMiddleware;
use App\Models\Assessment;
use App\Models\AssessmentDetail;
use App\Models\AiRecommendation;
use App\Models\Company;
use App\Models\Employee;

class ReportController extends Controller {

    public function individual($assessmentId) {
        RoleMiddleware::check(['Super Admin', 'Admin K3', 'HRD', 'Ergonomist', 'Employee']);

        $assessmentModel = new Assessment();
        $assessment = $assessmentModel->findWithDetails($assessmentId);

        if (!$assessment) {
            flash('error', 'Assessment tidak ditemukan.', 'danger');
            redirect('assessments');
            return;
        }

        // Restrict employee from viewing other people's individual report
        $isEmployee = has_role('Employee') && !has_role('Super Admin') && !has_role('Admin K3') && !has_role('Ergonomist');
        if ($isEmployee) {
            $user = auth_user();
            $employeeModel = new Employee();
            $currentEmployee = $employeeModel->findByUser($user);
            if (!$currentEmployee || (int)$assessment['employee_id'] !== (int)$currentEmployee['id']) {
                flash('error', 'Akses ditolak: Anda hanya dapat melihat laporan rekam medis/K3 pribadi Anda.', 'danger');
                redirect('assessments');
                return;
            }
        }

        $detailModel = new AssessmentDetail();
        $details = $detailModel->getByAssessmentId($assessmentId);

        $aiModel = new AiRecommendation();
        $aiRecommendation = $aiModel->getLatestByAssessment($assessmentId);

        $this->view('reports/individual', [
            'assessment' => $assessment,
            'details' => $details,
            'aiRecommendation' => $aiRecommendation
        ], null); // Render standalone printable view
    }

    public function organization() {
        RoleMiddleware::check(['Super Admin', 'Admin K3', 'HRD', 'Ergonomist']);
        $user = auth_user();
        $companyId = $user['company_id'] ?? null;

        $companyModel = new Company();
        $employeeModel = new Employee();
        $assessmentModel = new Assessment();
        $detailModel = new AssessmentDetail();

        $companies = $companyModel->all();
        $selectedCompanyId = isset($_GET['company_id']) ? (int)$_GET['company_id'] : $companyId;

        $assessments = $assessmentModel->getWithDetails($selectedCompanyId);
        $riskStats = $assessmentModel->getRiskStats($selectedCompanyId);
        $topComplaints = $detailModel->getTopBodyComplaints($selectedCompanyId, 10);
        $employees = $employeeModel->getWithDetails($selectedCompanyId);

        $this->view('reports/organization', [
            'companies' => $companies,
            'selectedCompanyId' => $selectedCompanyId,
            'assessments' => $assessments,
            'riskStats' => $riskStats,
            'topComplaints' => $topComplaints,
            'totalEmployees' => count($employees)
        ]);
    }

    public function exportCsv() {
        RoleMiddleware::check(['Super Admin', 'Admin K3', 'HRD']);
        $user = auth_user();
        $companyId = isset($_GET['company_id']) && !empty($_GET['company_id']) ? (int)$_GET['company_id'] : ($user['company_id'] ?? null);

        $assessmentModel = new Assessment();
        $assessments = $assessmentModel->getWithDetails($companyId);

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=AI-ERGO_Assessment_Report_' . date('Y-m-d') . '.csv');

        $output = fopen('php://output', 'w');
        fputcsv($output, ['ID Assessment', 'Tanggal', 'NIK', 'Nama Pekerja', 'Departemen', 'Jabatan', 'Total Skor NBM', 'Tingkat Risiko', 'Area Dominan']);

        foreach ($assessments as $a) {
            fputcsv($output, [
                $a['id'],
                $a['assessment_date'],
                $a['employee_number'],
                $a['employee_name'],
                $a['department_name'],
                $a['position_name'],
                $a['total_score'],
                $a['risk_level'],
                $a['dominant_body_area']
            ]);
        }

        fclose($output);
        exit;
    }
}
