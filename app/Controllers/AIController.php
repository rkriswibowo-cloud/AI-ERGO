<?php

namespace App\Controllers;

use Core\Controller;
use App\Middleware\RoleMiddleware;
use App\Models\Assessment;
use App\Models\AssessmentDetail;
use App\Models\AiRecommendation;
use App\Services\AIService;
use App\Models\ActivityLog;

class AIController extends Controller {

    public function generate($assessmentId) {
        RoleMiddleware::check(['Super Admin', 'Admin K3', 'Ergonomist']);

        $assessmentModel = new Assessment();
        $assessment = $assessmentModel->findWithDetails($assessmentId);

        if (!$assessment) {
            flash('error', 'Data assessment tidak ditemukan.', 'danger');
            redirect('assessments');
            return;
        }

        $detailModel = new AssessmentDetail();
        $details = $detailModel->getByAssessmentId($assessmentId);

        // Generate AI Recommendation
        $aiResult = AIService::generateRecommendation($assessment, $details);

        $aiModel = new AiRecommendation();
        $aiModel->create([
            'assessment_id' => $assessmentId,
            'ai_provider' => $aiResult['provider'],
            'ai_model' => $aiResult['model'],
            'prompt_text' => $aiResult['prompt'],
            'recommendation_text' => $aiResult['recommendation']
        ]);

        (new ActivityLog())->log('ai', 'generate', "Generate rekomendasi AI untuk Assessment ID {$assessmentId}");
        flash('success', 'Rekomendasi AI Ergonomi berhasil dibuat.');
        redirect("assessments/show/{$assessmentId}");
    }

    public function history() {
        RoleMiddleware::check(['Super Admin', 'Admin K3', 'HRD', 'Ergonomist']);
        $aiModel = new AiRecommendation();
        $sql = "SELECT air.*, a.assessment_date, a.risk_level, a.total_score, e.name as employee_name, c.name as company_name
                FROM ai_recommendations air
                JOIN assessments a ON air.assessment_id = a.id
                JOIN employees e ON a.employee_id = e.id
                LEFT JOIN companies c ON e.company_id = c.id
                ORDER BY air.id DESC";
        $recommendations = $aiModel->rawQuery($sql);
        $this->view('ai/history', ['recommendations' => $recommendations]);
    }
}
