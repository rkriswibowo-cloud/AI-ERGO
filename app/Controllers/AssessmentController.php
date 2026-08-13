<?php

namespace App\Controllers;

use Core\Controller;
use App\Middleware\RoleMiddleware;
use App\Models\Assessment;
use App\Models\AssessmentDetail;
use App\Models\Employee;
use App\Models\AiRecommendation;
use App\Services\AssessmentEngine;
use App\Services\AIService;
use App\Models\ActivityLog;

class AssessmentController extends Controller {

    public function index() {
        RoleMiddleware::check(['Super Admin', 'Admin K3', 'HRD', 'Ergonomist', 'Employee']);
        $user = auth_user();
        $companyId = $user['company_id'] ?? null;

        $assessmentModel = new Assessment();
        $assessments = $assessmentModel->getWithDetails($companyId);

        $this->view('assessments/index', ['assessments' => $assessments]);
    }

    public function create() {
        RoleMiddleware::check(['Super Admin', 'Admin K3', 'Ergonomist', 'Employee']);
        $user = auth_user();
        $companyId = $user['company_id'] ?? null;

        $employeeModel = new Employee();
        $employees = $employeeModel->getWithDetails($companyId);
        $bodyParts = AssessmentEngine::getBodyParts();

        if ($this->isPost()) {
            verify_csrf();

            $employeeId = (int)$this->input('employee_id');
            $assessmentDate = $this->input('assessment_date', date('Y-m-d'));
            $notes = $this->input('notes');
            $scoresInput = $_POST['scores'] ?? [];

            if (!$employeeId) {
                flash('error', 'Pilih pekerja terlebih dahulu.', 'danger');
                redirect('assessments/create');
                return;
            }

            // Calculate total score and risk level using AssessmentEngine
            $totalScore = AssessmentEngine::calculateScore($scoresInput);
            $riskLevel = AssessmentEngine::determineRiskLevel($totalScore);
            $dominantArea = AssessmentEngine::getDominantBodyAreas($scoresInput);

            $assessmentModel = new Assessment();
            $assessmentId = $assessmentModel->create([
                'employee_id' => $employeeId,
                'assessor_id' => $user['id'] ?? null,
                'assessment_date' => $assessmentDate,
                'total_score' => $totalScore,
                'risk_level' => $riskLevel,
                'dominant_body_area' => $dominantArea,
                'notes' => $notes
            ]);

            // Save 28 body part details
            $detailModel = new AssessmentDetail();
            foreach ($bodyParts as $code => $fullName) {
                $cleanName = explode(' (', $fullName)[0];
                $score = isset($scoresInput[$code]) ? (int)$scoresInput[$code] : 0;
                $detailModel->create([
                    'assessment_id' => $assessmentId,
                    'body_part_code' => $code,
                    'body_part_name' => $cleanName,
                    'score' => $score
                ]);
            }

            // Auto-trigger AI recommendation if requested
            if (isset($_POST['auto_generate_ai'])) {
                $assessmentFull = $assessmentModel->findWithDetails($assessmentId);
                $detailsFull = $detailModel->getByAssessmentId($assessmentId);
                
                $aiResult = AIService::generateRecommendation($assessmentFull, $detailsFull);
                
                $aiModel = new AiRecommendation();
                $aiModel->create([
                    'assessment_id' => $assessmentId,
                    'ai_provider' => $aiResult['provider'],
                    'ai_model' => $aiResult['model'],
                    'prompt_text' => $aiResult['prompt'],
                    'recommendation_text' => $aiResult['recommendation']
                ]);
            }

            (new ActivityLog())->log('assessments', 'create', "Membuat assessment NBM ID: {$assessmentId} untuk Employee ID: {$employeeId}");
            flash('success', "Assessment Nordic Body Map berhasil disimpan dengan Skor: {$totalScore} ({$riskLevel}).");
            redirect("assessments/show/{$assessmentId}");
            return;
        }

        $this->view('assessments/create', [
            'employees' => $employees,
            'bodyParts' => $bodyParts,
            'selectedEmpId' => $_GET['employee_id'] ?? null
        ]);
    }

    public function show($id) {
        RoleMiddleware::check(['Super Admin', 'Admin K3', 'HRD', 'Ergonomist', 'Employee']);

        $assessmentModel = new Assessment();
        $assessment = $assessmentModel->findWithDetails($id);

        if (!$assessment) {
            flash('error', 'Assessment tidak ditemukan.', 'danger');
            redirect('assessments');
            return;
        }

        $detailModel = new AssessmentDetail();
        $details = $detailModel->getByAssessmentId($id);

        $aiModel = new AiRecommendation();
        $aiRecommendation = $aiModel->getLatestByAssessment($id);

        $this->view('assessments/show', [
            'assessment' => $assessment,
            'details' => $details,
            'aiRecommendation' => $aiRecommendation
        ]);
    }

    public function delete($id) {
        RoleMiddleware::check(['Super Admin', 'Admin K3']);
        $assessmentModel = new Assessment();
        $a = $assessmentModel->find($id);
        if ($a) {
            $assessmentModel->delete($id);
            (new ActivityLog())->log('assessments', 'delete', "Menghapus assessment ID {$id}");
            flash('success', 'Assessment berhasil dihapus.');
        }
        redirect('assessments');
    }
}
