<div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-1">Form Assessment Nordic Body Map (NBM)</h4>
        <p class="text-muted small mb-0">Penilaian 28 area keluhan tubuh pekerja untuk identifikasi risiko ergonomi MSDs</p>
    </div>
    <a href="<?= base_url('assessments') ?>" class="btn btn-light rounded-pill btn-mobile-full"><i class="fa-solid fa-arrow-left me-1"></i> Kembali</a>
</div>

<form action="" method="POST">
    <?= csrf_field() ?>
    
    <!-- Top Configuration Card -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
            <div class="row g-3 align-items-end">
                <div class="col-md-5">
                    <label class="form-label fw-semibold text-dark">Pilih Pekerja *</label>
                    <select name="employee_id" class="form-select form-select-lg" required>
                        <option value="">-- Pilih Pekerja --</option>
                        <?php foreach ($employees as $e): ?>
                            <option value="<?= $e['id'] ?>" <?= ($selectedEmpId == $e['id']) ? 'selected' : '' ?>>
                                <?= sanitize($e['employee_number']) ?> - <?= sanitize($e['name']) ?> (<?= sanitize($e['department_name']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold text-dark">Tanggal Assessment</label>
                    <input type="date" name="assessment_date" class="form-control form-control-lg" value="<?= date('Y-m-d') ?>" required>
                </div>
                <div class="col-md-4">
                    <div class="p-3 bg-light rounded-3 border d-flex align-items-center justify-content-between">
                        <div>
                            <div class="small text-muted fw-semibold">SKOR TOTAL NBM LIVE</div>
                            <h2 class="fw-bold text-primary mb-0" id="nbm-total-score">0</h2>
                        </div>
                        <div class="text-end">
                            <div class="small text-muted fw-semibold">TINGKAT RISIKO</div>
                            <span id="nbm-risk-badge" class="badge bg-success px-3 py-2 fs-6">Rendah</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main NBM Assessment Body -->
    <div class="row g-4 mb-4">
        <!-- Interactive Body Diagram Visualizer Column -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 80px;">
                <div class="card-header bg-white border-0 pt-4 px-4 pb-0 text-center">
                    <h6 class="fw-bold text-dark mb-1"><i class="fa-solid fa-child-body text-primary me-2"></i>Visual Peta Tubuh Ergonomi</h6>
                    <p class="text-muted small">Warna area tubuh otomatis berubah berdasarkan skala keluhan</p>
                </div>
                <div class="card-body p-4 text-center">
                    <!-- SVG Human Body Diagram -->
                    <div class="nbm-svg-wrapper border rounded-3 p-3 bg-light mb-3">
                        <svg viewBox="0 0 200 400" width="100%" height="340" xmlns="http://www.w3.org/2000/svg">
                            <!-- Body Outline Backdrop -->
                            <!-- Head & Neck -->
                            <circle cx="100" cy="40" r="22" fill="#cbd5e1" />
                            <rect id="svg-part-neck_upper" cx="90" x="90" y="64" width="20" height="12" rx="4" fill="#10b981" />
                            <rect id="svg-part-neck_lower" x="88" y="78" width="24" height="12" rx="4" fill="#10b981" />
                            
                            <!-- Shoulders & Upper Body -->
                            <rect id="svg-part-shoulder_left" x="48" y="92" width="36" height="20" rx="6" fill="#10b981" />
                            <rect id="svg-part-shoulder_right" x="116" y="92" width="36" height="20" rx="6" fill="#10b981" />
                            <rect id="svg-part-back_upper" x="86" y="94" width="28" height="45" rx="6" fill="#10b981" />
                            
                            <!-- Arms Left -->
                            <rect id="svg-part-arm_upper_left" x="32" y="114" width="18" height="35" rx="5" fill="#10b981" />
                            <circle id="svg-part-elbow_left" cx="41" cy="155" r="8" fill="#10b981" />
                            <rect id="svg-part-forearm_left" x="33" y="165" width="16" height="35" rx="4" fill="#10b981" />
                            <circle id="svg-part-wrist_left" cx="41" cy="205" r="7" fill="#10b981" />
                            <rect id="svg-part-hand_left" x="33" y="214" width="16" height="20" rx="4" fill="#10b981" />

                            <!-- Arms Right -->
                            <rect id="svg-part-arm_upper_right" x="150" y="114" width="18" height="35" rx="5" fill="#10b981" />
                            <circle id="svg-part-elbow_right" cx="159" cy="155" r="8" fill="#10b981" />
                            <rect id="svg-part-forearm_right" x="151" y="165" width="16" height="35" rx="4" fill="#10b981" />
                            <circle id="svg-part-wrist_right" cx="159" cy="205" r="7" fill="#10b981" />
                            <rect id="svg-part-hand_right" x="151" y="214" width="16" height="20" rx="4" fill="#10b981" />

                            <!-- Waist & Hips -->
                            <rect id="svg-part-waist" x="82" y="142" width="36" height="25" rx="6" fill="#10b981" />
                            <rect id="svg-part-hips" x="78" y="170" width="44" height="20" rx="6" fill="#10b981" />
                            <rect id="svg-part-bottom" x="78" y="193" width="44" height="25" rx="6" fill="#10b981" />

                            <!-- Legs Left -->
                            <rect id="svg-part-thigh_left" x="78" y="222" width="20" height="55" rx="6" fill="#10b981" />
                            <circle id="svg-part-knee_left" cx="88" cy="282" r="9" fill="#10b981" />
                            <rect id="svg-part-calf_left" x="80" y="294" width="16" height="50" rx="5" fill="#10b981" />
                            <circle id="svg-part-ankle_left" cx="88" cy="349" r="7" fill="#10b981" />
                            <rect id="svg-part-foot_left" x="72" y="358" width="22" height="15" rx="4" fill="#10b981" />

                            <!-- Legs Right -->
                            <rect id="svg-part-thigh_right" x="102" y="222" width="20" height="55" rx="6" fill="#10b981" />
                            <circle id="svg-part-knee_right" cx="112" cy="282" r="9" fill="#10b981" />
                            <rect id="svg-part-calf_right" x="104" y="294" width="16" height="50" rx="5" fill="#10b981" />
                            <circle id="svg-part-ankle_right" cx="112" cy="349" r="7" fill="#10b981" />
                            <rect id="svg-part-foot_right" x="106" y="358" width="22" height="15" rx="4" fill="#10b981" />
                        </svg>
                    </div>

                    <!-- Legend -->
                    <div class="d-flex justify-content-center gap-2 small flex-wrap">
                        <span class="badge bg-success">0: Tidak Sakit</span>
                        <span class="badge bg-warning text-dark">1: Agak Sakit</span>
                        <span class="badge bg-orange text-white" style="background-color: #f97316;">2: Sakit</span>
                        <span class="badge bg-danger">3: Sangat Sakit</span>
                    </div>

                    <div class="mt-3 p-2 bg-light rounded text-start small">
                        <div class="fw-bold text-dark mb-1">Keluhan Dominan:</div>
                        <div id="nbm-dominant-area" class="text-muted fst-italic">Tidak ada keluhan signifikan</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 28 Body Parts Form Column -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                    <h6 class="fw-bold text-dark mb-1"><i class="fa-solid fa-list-ol text-primary me-2"></i>Kuesioner 28 Bagian Tubuh</h6>
                    <p class="text-muted small">Pilih skala rasa sakit (0 - 3) pada masing-masing bagian tubuh pekerja</p>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <?php $index = 1; foreach ($bodyParts as $code => $name): 
                            $cleanName = explode(' (', $name)[0];
                            $engName = isset(explode(' (', $name)[1]) ? rtrim(explode(' (', $name)[1], ')') : '';
                        ?>
                            <div class="col-md-6">
                                <div class="body-part-item">
                                    <div class="d-flex align-items-center justify-content-between mb-1">
                                        <span class="fw-semibold text-dark small"><?= $index ?>. <?= $cleanName ?> <small class="text-muted">(<?= $engName ?>)</small></span>
                                    </div>
                                    <div class="score-selector">
                                        <input type="radio" class="nbm-radio" name="scores[<?= $code ?>]" id="s_<?= $code ?>_0" value="0" data-part-code="<?= $code ?>" data-part-name="<?= $cleanName ?>" checked>
                                        <label for="s_<?= $code ?>_0">0</label>

                                        <input type="radio" class="nbm-radio" name="scores[<?= $code ?>]" id="s_<?= $code ?>_1" value="1" data-part-code="<?= $code ?>" data-part-name="<?= $cleanName ?>">
                                        <label for="s_<?= $code ?>_1">1</label>

                                        <input type="radio" class="nbm-radio" name="scores[<?= $code ?>]" id="s_<?= $code ?>_2" value="2" data-part-code="<?= $code ?>" data-part-name="<?= $cleanName ?>">
                                        <label for="s_<?= $code ?>_2">2</label>

                                        <input type="radio" class="nbm-radio" name="scores[<?= $code ?>]" id="s_<?= $code ?>_3" value="3" data-part-code="<?= $code ?>" data-part-name="<?= $cleanName ?>">
                                        <label for="s_<?= $code ?>_3">3</label>
                                    </div>
                                </div>
                            </div>
                        <?php $index++; endforeach; ?>
                    </div>

                    <div class="mb-3 mt-4">
                        <label class="form-label fw-semibold text-dark">Catatan / Keterangan Tambahan Assessor</label>
                        <textarea name="notes" class="form-control" rows="2" placeholder="Catatan kondisi postur, stasiun kerja, atau keluhan khusus..."></textarea>
                    </div>

                    <div class="form-check form-switch mb-4">
                        <input class="form-check-input" type="checkbox" name="auto_generate_ai" id="auto_generate_ai" value="1" checked>
                        <label class="form-check-label fw-semibold text-dark" for="auto_generate_ai">
                            <i class="fa-solid fa-robot text-primary me-1"></i> Langsung Generate Rekomendasi Ergonomi berbasis AI setelah disimpan
                        </label>
                    </div>

                    <div class="d-flex flex-column-reverse flex-sm-row justify-content-end gap-2">
                        <a href="<?= base_url('assessments') ?>" class="btn btn-light rounded-pill btn-mobile-full">Batal</a>
                        <button type="submit" class="btn btn-primary rounded-pill px-4 btn-mobile-full"><i class="fa-solid fa-floppy-disk me-1"></i> Simpan Assessment</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
