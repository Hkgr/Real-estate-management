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

        const GEN_KEY = 'viewer_new_properties_generator_open';
        const COL_KEY = 'viewer_new_properties_visible_columns';
        const defaultColumns = ['id','property_name','record_number','location','owners_count','area','value','status','updated_at','details','actions'];
        const panel = reportRoot.querySelector('[data-report-generator-panel]');
        const toggleBtn = reportRoot.querySelector('[data-report-generator-toggle]');
        const form = reportRoot.querySelector('[data-report-generator-form]');
        const clearSearchBtn = reportRoot.querySelector('[data-properties-clear-search]');
        const searchInput = reportRoot.querySelector('#filter-q');
        const genBtn = reportRoot.querySelector('[data-generate-report]');
        const resetBtn = reportRoot.querySelector('[data-reset-columns]');
        const checkboxes = [...reportRoot.querySelectorAll('[data-column-toggle]')];
        const table = reportRoot.querySelector('.vn-properties-table table');
        const fullscreenBtn = reportRoot.querySelector('[data-properties-fullscreen]');

        const safeGet = (k) => { try { return localStorage.getItem(k); } catch (_) { return null; } };
        const safeSet = (k,v) => { try { localStorage.setItem(k,v); } catch (_) {} };
        const hasActiveFilters = reportRoot.querySelectorAll('.vn-active-filter-chip').length > 0;

        const setPanelOpen = (open, persist = true) => {
            if (!panel) return;
            panel.classList.toggle('is-open', !!open);
            toggleBtn?.setAttribute('aria-expanded', open ? 'true' : 'false');
            if (persist) safeSet(GEN_KEY, open ? '1' : '0');
        };

        const applyColumns = (columns) => {
            if (!table) return;
            const selected = new Set(columns);
            table.querySelectorAll('[data-column-key]').forEach((cell) => {
                cell.style.display = selected.has(cell.getAttribute('data-column-key') || '') ? '' : 'none';
            });
        };

        const syncCheckboxes = (columns) => {
            const selected = new Set(columns);
            checkboxes.forEach((cb) => { cb.checked = selected.has(cb.value); });
        };

        const getChecked = () => checkboxes.filter((cb) => cb.checked).map((cb) => cb.value);

        const visibleFromStorage = (() => {
            try { const parsed = JSON.parse(safeGet(COL_KEY) || 'null'); return Array.isArray(parsed) && parsed.length ? parsed : defaultColumns; } catch (_) { return defaultColumns; }
        })();
        syncCheckboxes(visibleFromStorage); applyColumns(visibleFromStorage);

        const initialOpen = safeGet(GEN_KEY) === '1' || (hasActiveFilters && safeGet(GEN_KEY) === null);
        setPanelOpen(initialOpen, false);

        toggleBtn?.addEventListener('click', () => setPanelOpen(!panel?.classList.contains('is-open')));
        genBtn?.addEventListener('click', () => {
            let cols = getChecked();
            const hasData = cols.some((c) => c !== 'actions');
            if (!hasData) {
                cols = defaultColumns;
                syncCheckboxes(cols);
            }
            applyColumns(cols);
            safeSet(COL_KEY, JSON.stringify(cols));
            setPanelOpen(false);
        });
        resetBtn?.addEventListener('click', () => {
            syncCheckboxes(defaultColumns); applyColumns(defaultColumns); safeSet(COL_KEY, JSON.stringify(defaultColumns));
        });

        clearSearchBtn?.addEventListener('click', () => {
            if (!searchInput) return;
            searchInput.value = '';
            const actionUrl = form?.getAttribute('action') || window.location.pathname;
            window.location.assign(actionUrl);
        });

        document.addEventListener('keydown', (event) => {
            if (event.key !== 'Escape') return;
            const activeEl = document.activeElement;
            if (activeEl instanceof HTMLInputElement || activeEl instanceof HTMLSelectElement || activeEl instanceof HTMLTextAreaElement) { activeEl.blur(); return; }
            if (panel?.classList.contains('is-open')) setPanelOpen(false);
        });

        fullscreenBtn?.addEventListener('click', () => {
            const target = reportRoot.querySelector('.vn-properties-table') || reportRoot;
            if (!document.fullscreenElement && target.requestFullscreen) { target.requestFullscreen().catch(() => {}); return; }
            if (document.fullscreenElement && document.exitFullscreen) document.exitFullscreen().catch(() => {});
        });
    };

    updateClock();
    if (clockEl || dateEl) setInterval(updateClock, 1000);
    bindQuickSearchShortcut();
    bindFullscreenToggle();
    bindPropertiesReportInteractions();
})();
