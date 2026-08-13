<?php

namespace App\Controllers;

use Core\Controller;
use App\Middleware\RoleMiddleware;
use App\Models\ActivityLog;

class AuditLogController extends Controller {

    public function index() {
        RoleMiddleware::check(['Super Admin']);
        $logModel = new ActivityLog();
        $logs = $logModel->getWithUser(100);
        $this->view('admin/audit_logs/index', ['logs' => $logs]);
    }

    public function clear() {
        RoleMiddleware::check(['Super Admin']);
        $logModel = new ActivityLog();
        $logModel->clearAll();

        // Create initial log entry after clear
        $logModel->log('audit_logs', 'clear', 'Super Admin telah mereset/membersihkan seluruh catatan audit log sistem.');

        flash('success', 'Seluruh data audit log aktivitas berhasil dibersihkan.');
        redirect('admin/audit-logs');
    }
}
