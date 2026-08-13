<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-1">Konfigurasi AI & Sistem</h4>
        <p class="text-muted small mb-0">Pengaturan Identitas Aplikasi (Logo, Favicon, Nama), Provider LLM (Gemini/Groq), dan Threshold Risiko NBM</p>
    </div>
</div>

<form action="" method="POST" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <div class="row g-4 mb-4">

        <!-- Branding Identity: Logo & Favicon Card -->
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                    <h6 class="fw-bold text-dark mb-0"><i class="fa-solid fa-image text-primary me-2"></i>Identitas Visual & Branding (Logo & Favicon)</h6>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">
                        <!-- Application Logo Upload -->
                        <div class="col-md-6">
                            <div class="p-3 border rounded-3 bg-light">
                                <label class="form-label fw-bold text-dark mb-2"><i class="fa-solid fa-icons text-primary me-1"></i> Logo Header & Aplikasi</label>
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <div class="p-2 bg-white border rounded-3 text-center" style="width: 100px; height: 60px; display: flex; align-items: center; justify-content: center;">
                                        <?php if (upload_exists($settings['APP_LOGO'] ?? '')): ?>
                                            <img src="<?= upload_url($settings['APP_LOGO']) ?>" alt="Logo App" style="max-width: 100%; max-height: 45px;">
                                        <?php else: ?>
                                            <div class="text-primary fw-bold small"><i class="fa-solid fa-person-walking-luggage fa-lg me-1"></i>Default</div>
                                        <?php endif; ?>
                                    </div>
                                    <div>
                                        <div class="fw-semibold text-dark small">Logo Utama</div>
                                        <div class="text-muted small">Format: PNG, JPG, SVG, WebP</div>
                                        <?php if (upload_exists($settings['APP_LOGO'] ?? '')): ?>
                                            <div class="form-check mt-1">
                                                <input class="form-check-input" type="checkbox" name="reset_logo" value="1" id="resetLogoCheck">
                                                <label class="form-check-label small text-danger fw-semibold" for="resetLogoCheck">
                                                    Reset ke Logo Default
                                                </label>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <input type="file" name="APP_LOGO" class="form-control form-control-sm" accept=".png,.jpg,.jpeg,.svg,.webp">
                                <div class="form-text small">Disarankan ukuran tinggi 40px - 80px dengan latar transparan.</div>
                            </div>
                        </div>

                        <!-- Favicon Website Upload -->
                        <div class="col-md-6">
                            <div class="p-3 border rounded-3 bg-light">
                                <label class="form-label fw-bold text-dark mb-2"><i class="fa-solid fa-globe text-primary me-1"></i> Favicon Browser Tab</label>
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <div class="p-2 bg-white border rounded-3 text-center" style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                                        <?php if (upload_exists($settings['APP_FAVICON'] ?? '')): ?>
                                            <img src="<?= upload_url($settings['APP_FAVICON']) ?>" alt="Favicon" style="max-width: 100%; max-height: 32px;">
                                        <?php else: ?>
                                            <span class="fs-3">🏃</span>
                                        <?php endif; ?>
                                    </div>
                                    <div>
                                        <div class="fw-semibold text-dark small">Favicon Tab Browser</div>
                                        <div class="text-muted small">Format: ICO, PNG, SVG, WebP</div>
                                        <?php if (upload_exists($settings['APP_FAVICON'] ?? '')): ?>
                                            <div class="form-check mt-1">
                                                <input class="form-check-input" type="checkbox" name="reset_favicon" value="1" id="resetFaviconCheck">
                                                <label class="form-check-label small text-danger fw-semibold" for="resetFaviconCheck">
                                                    Reset ke Favicon Default
                                                </label>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <input type="file" name="APP_FAVICON" class="form-control form-control-sm" accept=".ico,.png,.jpg,.jpeg,.svg,.webp">
                                <div class="form-text small">Disarankan gambar persegi (contoh: 32x32 px atau 64x64 px).</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- AI REST API Configuration Card -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                    <h6 class="fw-bold text-dark mb-0"><i class="fa-solid fa-robot text-primary me-2"></i>Konfigurasi Provider LLM AI</h6>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark">Provider Utama AI</label>
                        <select name="AI_PROVIDER" class="form-select">
                            <option value="gemini" <?= ($settings['AI_PROVIDER'] ?? '') == 'gemini' ? 'selected' : '' ?>>Google Gemini API</option>
                            <option value="groq" <?= ($settings['AI_PROVIDER'] ?? '') == 'groq' ? 'selected' : '' ?>>Groq Cloud API</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark">Gemini API Key</label>
                        <input type="password" name="GEMINI_API_KEY" class="form-control" value="<?= sanitize($settings['GEMINI_API_KEY'] ?? '') ?>" placeholder="AIzaSy...">
                        <div class="form-text small">Dapatkan API Key di Google AI Studio.</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark">Groq API Key</label>
                        <input type="password" name="GROQ_API_KEY" class="form-control" value="<?= sanitize($settings['GROQ_API_KEY'] ?? '') ?>" placeholder="gsk_...">
                        <div class="form-text small">Dapatkan API Key di Console Groq Cloud.</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark">Model AI Default</label>
                        <input type="text" name="AI_MODEL" class="form-control" value="<?= sanitize($settings['AI_MODEL'] ?? 'gemini-1.5-flash') ?>">
                        <div class="form-text small">Contoh: <code>gemini-1.5-flash</code> atau <code>llama-3.3-70b-versatile</code></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Risk Thresholds & App Settings Card -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                    <h6 class="fw-bold text-dark mb-0"><i class="fa-solid fa-sliders text-primary me-2"></i>Pengaturan Aplikasi & Threshold Risiko</h6>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark">Nama Aplikasi / System Name</label>
                        <input type="text" name="APP_NAME" class="form-control" value="<?= sanitize($settings['APP_NAME'] ?? 'AI-ERGO System') ?>">
                    </div>
                    <hr>
                    <h6 class="fw-bold text-dark mb-3">Threshold Kategori Risiko NBM (Total Skor Max 84)</h6>
                    <div class="row g-2">
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold text-success small">Max Risiko Rendah</label>
                            <input type="number" name="RISK_THRESHOLD_LOW" class="form-control" value="<?= $settings['RISK_THRESHOLD_LOW'] ?? 20 ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold text-warning small">Max Risiko Sedang</label>
                            <input type="number" name="RISK_THRESHOLD_MEDIUM" class="form-control" value="<?= $settings['RISK_THRESHOLD_MEDIUM'] ?? 41 ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold text-danger small">Max Risiko Tinggi</label>
                            <input type="number" name="RISK_THRESHOLD_HIGH" class="form-control" value="<?= $settings['RISK_THRESHOLD_HIGH'] ?? 62 ?>">
                        </div>
                    </div>
                    <div class="p-3 bg-light rounded border text-muted small">
                        <i class="fa-solid fa-info-circle me-1 text-primary"></i> Skor di atas threshold tinggi (>62) secara otomatis dikategorikan sebagai <strong>Sangat Tinggi</strong>.
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm btn-mobile-full"><i class="fa-solid fa-floppy-disk me-1"></i> Simpan Konfigurasi</button>
            </div>
        </div>
    </div>
</form>
