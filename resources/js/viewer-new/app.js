(() => {
    const shell = document.querySelector('.viewer-new__shell');
    const toggleSidebarBtn = document.querySelector('[data-toggle-sidebar]');
    const openSettingsBtn = document.querySelector('[data-open-settings]');
    const closeSettingsBtn = document.querySelector('[data-close-settings]');
    const quickSettings = document.getElementById('vnQuickSettings');
    const clockEl = document.getElementById('vnTopbarClock');
    const dateEl = document.getElementById('vnTopbarDate');
    const quickSearchEl = document.getElementById('vnQuickSearch');
    const fullscreenBtn = document.getElementById('vnToggleFullscreen');

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

    const rtlMark = '\u200F';
    const timeFormatter = new Intl.DateTimeFormat('ar-SY-u-ca-gregory', {
        hour: '2-digit',
        minute: '2-digit',
        hour12: false,
    });
    const dateFormatter = new Intl.DateTimeFormat('ar-SY-u-ca-gregory', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    });

    const updateClock = () => {
        const now = new Date();

        if (clockEl) {
            clockEl.textContent = `${rtlMark}${timeFormatter.format(now)}${rtlMark}`;
        }

        if (dateEl) {
            dateEl.textContent = `${rtlMark}${dateFormatter.format(now)}${rtlMark}`;
        }
    };

    const bindQuickSearchShortcut = () => {
        if (!quickSearchEl) return;

        document.addEventListener('keydown', (event) => {
            const isShortcut = (event.ctrlKey || event.metaKey) && event.key.toLowerCase() === 'k';
            if (!isShortcut) return;

            event.preventDefault();
            quickSearchEl.focus();
            quickSearchEl.select();
        });
    };

    const bindFullscreenToggle = () => {
        fullscreenBtn?.addEventListener('click', () => {
            if (!document.fullscreenElement && document.documentElement.requestFullscreen) {
                document.documentElement.requestFullscreen().catch(() => {});
                return;
            }

            if (document.fullscreenElement && document.exitFullscreen) {
                document.exitFullscreen().catch(() => {});
            }
        });
    };

    const bindPropertiesReportInteractions = () => {
        const reportRoot = document.querySelector('.vn-properties-report');
        if (!reportRoot) return;

        const FILTER_PANEL_KEY = 'viewer_new_properties_filters_open';
        const form = reportRoot.querySelector('[data-properties-filter-form]');
        const panel = reportRoot.querySelector('[data-properties-filter-panel]');
        const toggleBtn = reportRoot.querySelector('[data-properties-filter-toggle]');
        const searchInput = reportRoot.querySelector('#filter-q');
        const clearSearchBtn = reportRoot.querySelector('[data-properties-clear-search]');
        const hasActiveFilters = reportRoot.querySelectorAll('.vn-active-filter-chip').length > 0;

        let currentOpenState = true;

        const readStoredState = () => {
            try {
                return localStorage.getItem(FILTER_PANEL_KEY);
            } catch (_) {
                return null;
            }
        };

        const writeStoredState = (isOpen) => {
            try {
                localStorage.setItem(FILTER_PANEL_KEY, isOpen ? '1' : '0');
            } catch (_) {}
        };

        const updatePanelState = (isOpen, persist = true) => {
            currentOpenState = !!isOpen;

            if (panel) {
                panel.hidden = !currentOpenState;
                panel.setAttribute('aria-hidden', currentOpenState ? 'false' : 'true');
            }

            if (toggleBtn) {
                toggleBtn.setAttribute('aria-expanded', currentOpenState ? 'true' : 'false');
                toggleBtn.textContent = currentOpenState ? 'إخفاء الفلاتر' : 'إظهار الفلاتر';
            }

            if (persist) writeStoredState(currentOpenState);
        };

        const getActiveFilterFieldCount = () => {
            if (!form) return 0;
            const fields = form.querySelectorAll('input[name], select[name], textarea[name]');
            let count = 0;
            fields.forEach((field) => {
                const name = field.getAttribute('name') || '';
                if (!name || field.disabled) return;

                if ((field instanceof HTMLInputElement) && (field.type === 'checkbox' || field.type === 'radio')) {
                    if (!field.checked) return;
                }

                const value = (field.value || '').trim();
                if (value !== '') count += 1;
            });
            return count;
        };

        const initState = () => {
            const stored = readStoredState();
            if (hasActiveFilters && stored === null) {
                updatePanelState(true, false);
                return;
            }

            if (stored === '0') {
                updatePanelState(false, false);
                return;
            }

            updatePanelState(true, false);
        };

        toggleBtn?.addEventListener('click', () => {
            updatePanelState(!currentOpenState, true);
        });

        clearSearchBtn?.addEventListener('click', () => {
            if (!searchInput) return;
            searchInput.value = '';

            const activeFilterCount = getActiveFilterFieldCount();
            if (activeFilterCount > 0 && form) {
                form.submit();
                return;
            }

            const actionUrl = form?.getAttribute('action') || window.location.pathname;
            window.location.assign(actionUrl);
        });

        form?.querySelectorAll('[data-auto-submit="true"]').forEach((el) => {
            const eventName = el.tagName === 'SELECT' ? 'change' : 'input';
            el.addEventListener(eventName, () => form.submit());
        });

        document.addEventListener('keydown', (event) => {
            if (event.key !== 'Escape') return;

            const activeEl = document.activeElement;
            const isInputLike = activeEl instanceof HTMLInputElement
                || activeEl instanceof HTMLSelectElement
                || activeEl instanceof HTMLTextAreaElement;

            if (isInputLike && form?.contains(activeEl)) {
                activeEl.blur();
                return;
            }

            if (currentOpenState) {
                updatePanelState(false, true);
            }
        });

        initState();
    };

    updateClock();
    if (clockEl || dateEl) setInterval(updateClock, 1000);
    bindQuickSearchShortcut();
    bindFullscreenToggle();
    bindPropertiesReportInteractions();
})();
