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
        const defaultColumns = [
            'id',
            'property_name',
            'property_country',
            'card_governorate',
            'card_region_name',
            'card_subdivision',
            'card_record_number',
            'card_property_number',
            'card_total_area',
            'card_area_unit',
            'total_property_value_usd',
            'owned_property_value_usd',
            'actual_price_usd',
            'estimated_price_usd',
            'card_status',
            'card_investment_type',
            'card_purchase_method',
            'card_sale_date',
            'final_balance',
            'card_google_maps_url',
            'owners_count',
            'operations_count',
            'signals_count',
            'files_count',
            'installments_count',
            'updated_at',
            'card_property_details',
            'actions',
        ];
        const validColumnKeys = [...defaultColumns];
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
        const normalizeColumns = (columns) => {
            const input = Array.isArray(columns) ? columns : [];
            const filtered = [...new Set(input.filter((key) => validColumnKeys.includes(key)))];
            const hasDataColumn = filtered.some((key) => key !== 'actions');
            return hasDataColumn ? filtered : defaultColumns;
        };

        const visibleFromStorage = (() => {
            try {
                const parsed = JSON.parse(safeGet(COL_KEY) || 'null');
                return normalizeColumns(parsed);
            } catch (_) {
                return defaultColumns;
            }
        })();
        syncCheckboxes(visibleFromStorage); applyColumns(visibleFromStorage);

        const initialOpen = safeGet(GEN_KEY) === '1' || (hasActiveFilters && safeGet(GEN_KEY) === null);
        setPanelOpen(initialOpen, false);

        toggleBtn?.addEventListener('click', () => setPanelOpen(!panel?.classList.contains('is-open')));
        genBtn?.addEventListener('click', () => {
            let cols = normalizeColumns(getChecked());
            syncCheckboxes(cols);
            applyColumns(cols);
            safeSet(COL_KEY, JSON.stringify(cols));
            setPanelOpen(false);
        });
        checkboxes.forEach((checkbox) => {
            checkbox.addEventListener('change', () => {
                const cols = normalizeColumns(getChecked());
                syncCheckboxes(cols);
                applyColumns(cols);
                safeSet(COL_KEY, JSON.stringify(cols));
            });
        });
        resetBtn?.addEventListener('click', () => {
            syncCheckboxes(defaultColumns); applyColumns(defaultColumns); safeSet(COL_KEY, JSON.stringify(defaultColumns));
        });

        clearSearchBtn?.addEventListener('click', () => {
            if (!searchInput || !form) return;
            const qHadValue = (searchInput.value || '').trim() !== '';
            searchInput.value = '';
            const fields = form.querySelectorAll('input[name], select[name], textarea[name]');
            let hasOtherFilters = false;
            fields.forEach((field) => {
                const name = field.getAttribute('name');
                if (!name || name === 'q' || field.disabled || hasOtherFilters) return;
                if (field instanceof HTMLInputElement && (field.type === 'checkbox' || field.type === 'radio')) {
                    if (field.checked) hasOtherFilters = true;
                    return;
                }
                if ((field.value || '').trim() !== '') hasOtherFilters = true;
            });

            if (hasOtherFilters) {
                form.submit();
                return;
            }

            if (qHadValue) {
                const actionUrl = form.getAttribute('action') || window.location.pathname;
                window.location.assign(actionUrl);
            }
        });

        document.addEventListener('keydown', (event) => {
            if (event.key !== 'Escape') return;
            const activeEl = document.activeElement;
            if (activeEl instanceof HTMLInputElement || activeEl instanceof HTMLSelectElement || activeEl instanceof HTMLTextAreaElement) { activeEl.blur(); return; }
            if (panel?.classList.contains('is-open')) setPanelOpen(false);
        });


        const bindExpandableRows = (toggleSelector, defaults = {}) => {
            const toggles = [...reportRoot.querySelectorAll(toggleSelector)];
            toggles.forEach((toggle) => {
                const showLabel = toggle.getAttribute('data-show-label') || defaults.showLabel || 'عرض';
                const hideLabel = toggle.getAttribute('data-hide-label') || defaults.hideLabel || 'إخفاء';

                toggle.addEventListener('click', () => {
                    const targetId = toggle.getAttribute('data-target');
                    if (!targetId) return;

                    const row = reportRoot.querySelector(`#${CSS.escape(targetId)}`);
                    if (!row) return;

                    const isHidden = row.hasAttribute('hidden');
                    if (isHidden) {
                        row.removeAttribute('hidden');
                        toggle.setAttribute('aria-expanded', 'true');
                        toggle.textContent = hideLabel;
                    } else {
                        row.setAttribute('hidden', 'hidden');
                        toggle.setAttribute('aria-expanded', 'false');
                        toggle.textContent = showLabel;
                    }
                });
            });
        };

        bindExpandableRows('[data-property-operations-toggle]', { showLabel: 'عرض العمليات', hideLabel: 'إخفاء العمليات' });
        bindExpandableRows('[data-property-signals-toggle]', { showLabel: 'عرض الإشارات', hideLabel: 'إخفاء الإشارات' });
        bindExpandableRows('[data-property-files-toggle]', { showLabel: 'عرض الملفات', hideLabel: 'إخفاء الملفات' });
        bindExpandableRows('[data-property-installments-toggle]', { showLabel: 'عرض الدفعات', hideLabel: 'إخفاء الدفعات' });

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
