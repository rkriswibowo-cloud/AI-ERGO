/* Nordic Body Map Interactive JavaScript Engine */

document.addEventListener('DOMContentLoaded', function() {
    const radioInputs = document.querySelectorAll('.nbm-radio');
    const totalScoreEl = document.getElementById('nbm-total-score');
    const riskBadgeEl = document.getElementById('nbm-risk-badge');
    const dominantAreaEl = document.getElementById('nbm-dominant-area');

    function calculateLiveScore() {
        let total = 0;
        let severeParts = [];
        
        const checkedRadios = document.querySelectorAll('.nbm-radio:checked');
        checkedRadios.forEach(radio => {
            const val = parseInt(radio.value, 10) || 0;
            total += val;

            if (val >= 2) {
                const partName = radio.getAttribute('data-part-name') || radio.name;
                severeParts.push(partName);
            }

            // Sync SVG highlight if SVG element exists
            const code = radio.getAttribute('data-part-code');
            if (code) {
                const svgPart = document.getElementById('svg-part-' + code);
                if (svgPart) {
                    if (val === 0) svgPart.setAttribute('fill', '#10b981');
                    else if (val === 1) svgPart.setAttribute('fill', '#f59e0b');
                    else if (val === 2) svgPart.setAttribute('fill', '#f97316');
                    else if (val === 3) svgPart.setAttribute('fill', '#ef4444');
                }
            }
        });

        if (totalScoreEl) totalScoreEl.innerText = total;

        let riskLevel = 'Rendah';
        let badgeClass = 'badge bg-success';
        if (total > 62) {
            riskLevel = 'Sangat Tinggi';
            badgeClass = 'badge bg-dark';
        } else if (total > 41) {
            riskLevel = 'Tinggi';
            badgeClass = 'badge bg-danger';
        } else if (total > 20) {
            riskLevel = 'Sedang';
            badgeClass = 'badge bg-warning text-dark';
        }

        if (riskBadgeEl) {
            riskBadgeEl.className = badgeClass + ' px-3 py-2 fs-6';
            riskBadgeEl.innerText = riskLevel;
        }

        if (dominantAreaEl) {
            dominantAreaEl.innerText = severeParts.length > 0 ? severeParts.join(', ') : 'Tidak ada keluhan signifikan';
        }
    }

    radioInputs.forEach(radio => {
        radio.addEventListener('change', calculateLiveScore);
    });

    // Initial calculation
    calculateLiveScore();
});
