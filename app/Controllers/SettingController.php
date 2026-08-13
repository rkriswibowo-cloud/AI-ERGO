<?php

namespace App\Controllers;

use Core\Controller;
use App\Middleware\RoleMiddleware;
use App\Models\Setting;
use App\Models\ActivityLog;

class SettingController extends Controller {

    public function index() {
        RoleMiddleware::check(['Super Admin']);

        $settingModel = new Setting();

        if ($this->isPost()) {
            verify_csrf();

            // Handle Reset Logo Action
            if ($this->input('reset_logo') == '1') {
                $settingModel->setKey('APP_LOGO', '', 'branding', 'Path Logo Aplikasi');
            }

            // Handle Reset Favicon Action
            if ($this->input('reset_favicon') == '1') {
                $settingModel->setKey('APP_FAVICON', '', 'branding', 'Path Favicon Website');
            }

            $targetDir = __DIR__ . '/../../public/uploads/settings/';
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            // Handle File Upload: APP_LOGO
            if (isset($_FILES['APP_LOGO']) && $_FILES['APP_LOGO']['error'] === UPLOAD_ERR_OK) {
                $fileTmp = $_FILES['APP_LOGO']['tmp_name'];
                $fileName = $_FILES['APP_LOGO']['name'];
                $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                $allowedExts = ['png', 'jpg', 'jpeg', 'svg', 'webp'];

                if (in_array($fileExt, $allowedExts)) {
                    $newFileName = 'logo_' . time() . '.' . $fileExt;
                    if (move_uploaded_file($fileTmp, $targetDir . $newFileName)) {
                        $settingModel->setKey('APP_LOGO', 'uploads/settings/' . $newFileName, 'branding', 'Path Logo Aplikasi');
                    }
                } else {
                    flash('error', 'Format logo tidak valid. Gunakan PNG, JPG, SVG, atau WebP.');
                }
            }

            // Handle File Upload: APP_FAVICON
            if (isset($_FILES['APP_FAVICON']) && $_FILES['APP_FAVICON']['error'] === UPLOAD_ERR_OK) {
                $fileTmp = $_FILES['APP_FAVICON']['tmp_name'];
                $fileName = $_FILES['APP_FAVICON']['name'];
                $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                $allowedExts = ['ico', 'png', 'jpg', 'jpeg', 'svg', 'webp'];

                if (in_array($fileExt, $allowedExts)) {
                    $newFileName = 'favicon_' . time() . '.' . $fileExt;
                    if (move_uploaded_file($fileTmp, $targetDir . $newFileName)) {
                        $settingModel->setKey('APP_FAVICON', 'uploads/settings/' . $newFileName, 'branding', 'Path Favicon Website');
                    }
                } else {
                    flash('error', 'Format favicon tidak valid. Gunakan ICO, PNG, atau SVG.');
                }
            }

            $settingsData = [
                'APP_NAME' => $this->input('APP_NAME', 'AI-ERGO System'),
                'AI_PROVIDER' => $this->input('AI_PROVIDER', 'gemini'),
                'GEMINI_API_KEY' => $this->input('GEMINI_API_KEY', ''),
                'GROQ_API_KEY' => $this->input('GROQ_API_KEY', ''),
                'AI_MODEL' => $this->input('AI_MODEL', 'gemini-1.5-flash'),
                'RISK_THRESHOLD_LOW' => $this->input('RISK_THRESHOLD_LOW', '20'),
                'RISK_THRESHOLD_MEDIUM' => $this->input('RISK_THRESHOLD_MEDIUM', '41'),
                'RISK_THRESHOLD_HIGH' => $this->input('RISK_THRESHOLD_HIGH', '62')
            ];

            foreach ($settingsData as $key => $val) {
                $settingModel->setKey($key, $val);
            }

            (new ActivityLog())->log('settings', 'update', "Mengubah konfigurasi sistem, logo, favicon, dan API key AI.");
            flash('success', 'Pengaturan sistem, logo, dan favicon berhasil diperbarui.');
            redirect('admin/settings');
            return;
        }

        $settings = $settingModel->getAllAsKeyValue();
        $this->view('admin/settings/index', ['settings' => $settings]);
    }
}
