<?php if (is_logged_in()): ?>
</main>
</div>
</div>
<?php endif; ?>

<!-- Bootstrap 5 Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- Custom JS -->
<script src="<?= assets('js/nbm-interactive.js') ?>"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const sidebarMenu = document.getElementById('sidebarMenu');
    const backdrop = document.getElementById('sidebarBackdrop');

    if (sidebarMenu) {
        sidebarMenu.addEventListener('show.bs.collapse', function() {
            if (backdrop) {
                backdrop.classList.add('show');
            }
        });

        sidebarMenu.addEventListener('hide.bs.collapse', function() {
            if (backdrop) {
                backdrop.classList.remove('show');
            }
        });

        if (backdrop) {
            backdrop.addEventListener('click', function() {
                const bsCollapse = bootstrap.Collapse.getInstance(sidebarMenu) || new bootstrap.Collapse(sidebarMenu, { toggle: false });
                bsCollapse.hide();
            });
        }

        // Close sidebar when clicking links inside on mobile
        const sidebarLinks = sidebarMenu.querySelectorAll('.nav-link');
        sidebarLinks.forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth < 768) {
                    const bsCollapse = bootstrap.Collapse.getInstance(sidebarMenu);
                    if (bsCollapse) {
                        bsCollapse.hide();
                    }
                }
            });
        });

        // Close sidebar when clicking anywhere outside on mobile
        document.addEventListener('click', function(e) {
            if (window.innerWidth < 768 && sidebarMenu.classList.contains('show')) {
                const isClickInsideSidebar = sidebarMenu.contains(e.target);
                const isClickOnToggle = e.target.closest('[data-bs-target="#sidebarMenu"]');
                
                if (!isClickInsideSidebar && !isClickOnToggle) {
                    const bsCollapse = bootstrap.Collapse.getInstance(sidebarMenu);
                    if (bsCollapse) {
                        bsCollapse.hide();
                    }
                }
            }
        });
        // Mobile Table Scroll Buttons Event Handlers
        document.querySelectorAll('.scroll-left-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const card = this.closest('.card');
                const tableRes = card ? card.querySelector('.table-responsive') : null;
                if (tableRes) {
                    tableRes.scrollBy({ left: -200, behavior: 'smooth' });
                }
            });
        });

        document.querySelectorAll('.scroll-right-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const card = this.closest('.card');
                const tableRes = card ? card.querySelector('.table-responsive') : null;
                if (tableRes) {
                    tableRes.scrollBy({ left: 200, behavior: 'smooth' });
                }
            });
        });
    }
});
</script>
</body>
</html>
