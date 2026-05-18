(() => {
    const shell = document.querySelector('.viewer-new__shell');
    const toggleSidebarBtn = document.querySelector('[data-toggle-sidebar]');
    const openSettingsBtn = document.querySelector('[data-open-settings]');
    const closeSettingsBtn = document.querySelector('[data-close-settings]');
    const quickSettings = document.getElementById('vnQuickSettings');
    const clockEl = document.getElementById('vnTopbarClock');
    const dateEl = document.getElementById('vnTopbarDate');

    const SIDEBAR_KEY = 'viewer_new_sidebar_collapsed';

    const applySidebarState = (collapsed) => {
        if (!shell) return;
        shell.classList.toggle('is-collapsed', !!collapsed);
    };

    try {
        applySidebarState(localStorage.getItem(SIDEBAR_KEY) === '1');
    } catch (_) {}

    toggleSidebarBtn?.addEventListener('click', () => {
        if (!shell) return;
        const collapsed = !shell.classList.contains('is-collapsed');
        applySidebarState(collapsed);
        try { localStorage.setItem(SIDEBAR_KEY, collapsed ? '1' : '0'); } catch (_) {}
    });

    openSettingsBtn?.addEventListener('click', () => quickSettings?.removeAttribute('hidden'));
    closeSettingsBtn?.addEventListener('click', () => quickSettings?.setAttribute('hidden', 'hidden'));

    const updateClock = () => {
        const now = new Date();

        if (clockEl) {
            clockEl.textContent = now.toLocaleTimeString('ar-SA', { hour12: false });
        }

        if (dateEl) {
            dateEl.textContent = now.toLocaleDateString('ar-SA', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
        }
    };

    updateClock();
    if (clockEl || dateEl) setInterval(updateClock, 1000);
})();
