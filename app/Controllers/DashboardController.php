<?php

namespace App\Controllers;

use Core\Controller;
use App\Middleware\AuthMiddleware;
use App\Models\Company;
use App\Models\Employee;
use App\Models\Assessment;
use App\Models\AssessmentDetail;

class DashboardController extends Controller {

    public function index() {
        AuthMiddleware::check();

        $user = auth_user();
        $companyId = $user['company_id'] ?? null;

        // Models
        $companyModel = new Company();
        $employeeModel = new Employee();
        $assessmentModel = new Assessment();
        $detailModel = new AssessmentDetail();

        $totalCompanies = count($companyModel->all());
        $employees = $employeeModel->getWithDetails($companyId);
        $totalEmployees = count($employees);

        $assessments = $assessmentModel->getWithDetails($companyId);
        $totalAssessments = count($assessments);

        $riskStats = $assessmentModel->getRiskStats($companyId);
        $topComplaints = $detailModel->getTopBodyComplaints($companyId, 7);

        // Recent 5 assessments
        $recentAssessments = array_slice($assessments, 0, 5);

        $this->view('dashboard/index', [
            'user' => $user,
            'totalCompanies' => $totalCompanies,
            'totalEmployees' => $totalEmployees,
            'totalAssessments' => $totalAssessments,
            'riskStats' => $riskStats,
            'topComplaints' => $topComplaints,
            'recentAssessments' => $recentAssessments
        ]);
    }
}
