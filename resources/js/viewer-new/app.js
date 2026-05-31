import { initPropertiesTableAdvanced } from './properties-table.js';

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

        document.body.classList.add('vn-properties-report-page');

        reportRoot.querySelectorAll(':is(.stats-grid,.vn-report-kpi-grid,.vn-report-metrics)').forEach((el) => {
            if (!el.closest('.vn-report-hero')) el.remove();
        });

        reportRoot.classList.add('vn-report-focus-target');

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
        const tableEl = reportRoot.querySelector('.vn-properties-table table');
        const tableScroller = reportRoot.querySelector('.vn-properties-table');
        const toolbarEl = reportRoot.querySelector('.vn-report-toolbar');
        const fullscreenBtn = reportRoot.querySelector('[data-properties-fullscreen]');

        const safeGet = (k) => { try { return localStorage.getItem(k); } catch (_) { return null; } };
        const safeSet = (k, v) => { try { localStorage.setItem(k, v); } catch (_) {} };
        const hasActiveFilters = reportRoot.querySelectorAll('.vn-active-filter-chip').length > 0;

        let floatingHost = null;
        let floatingTable = null;
        let floatingRaf = 0;
        let tblNavPill = null;
        let tableAdvancedApi = null;

        const syncToolbarActiveState = (open) => {
            toggleBtn?.classList.toggle('vn-report-toolbar-button--active', !!open);
            toggleBtn?.classList.toggle('vn-report-toolbar-button--primary', !!open);
        };

        const setPanelOpen = (open, persist = true) => {
            if (!panel) return;
            panel.classList.toggle('is-open', !!open);
            toggleBtn?.setAttribute('aria-expanded', open ? 'true' : 'false');
            syncToolbarActiveState(open);
            if (persist) safeSet(GEN_KEY, open ? '1' : '0');
            requestAnimationFrame(updateStickyOffset);
        };

        const requestFloatingHeadSync = () => {
            if (floatingRaf) return;
            floatingRaf = window.requestAnimationFrame(() => {
                floatingRaf = 0;
                updateFloatingTableHead();
            });
        };

        const applyColumns = (columns) => {
            if (!tableEl) return;
            const selected = new Set(columns);
            const visibleDataCols = columns.filter((key) => key !== 'actions');
            tableEl.classList.toggle('vn-id-only-compact', visibleDataCols.length === 1 && visibleDataCols[0] === 'id');
            tableEl.querySelectorAll('[data-column-key]').forEach((cell) => {
                cell.style.display = selected.has(cell.getAttribute('data-column-key') || '') ? '' : 'none';
            });
            tableAdvancedApi?.onColumnsVisibilityChange(columns);
            requestFloatingHeadSync();
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

        toggleBtn?.addEventListener('click', () => {
            setPanelOpen(!panel?.classList.contains('is-open'));
        });
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
            filterTableRowsClient('');
        });

        const getMainDataRows = () => {
            if (!tableEl) return [];
            return [...tableEl.querySelectorAll('tbody > tr')].filter((row) => (
                !row.hasAttribute('data-property-operations-row')
                && !row.hasAttribute('data-property-signals-row')
                && !row.hasAttribute('data-property-files-row')
                && !row.hasAttribute('data-property-installments-row')
                && !row.hasAttribute('data-property-notes-row')
                && row.querySelector('td[data-column-key]')
            ));
        };

        const updateTblNavPill = () => {
            if (!tblNavPill || !tableScroller) return;

            const canScroll = tableScroller.scrollWidth > tableScroller.clientWidth + 2;
            const hasVisibleRows = getMainDataRows().some((row) => !row.classList.contains('vn-row-hidden'));
            tblNavPill.classList.toggle('is-visible', canScroll && hasVisibleRows);
        };

        window.updateTblNavPill = updateTblNavPill;

        const filterTableRowsClient = (query) => {
            const q = (query || '').trim().toLowerCase();
            getMainDataRows().forEach((row) => {
                const hay = (row.textContent || '').toLowerCase();
                row.classList.toggle('vn-row-hidden', q !== '' && !hay.includes(q));
            });
            updateTblNavPill();
        };

        let searchDebounce = 0;
        searchInput?.addEventListener('input', () => {
            window.clearTimeout(searchDebounce);
            searchDebounce = window.setTimeout(() => filterTableRowsClient(searchInput.value), 120);
        });
        searchInput?.addEventListener('keydown', (event) => {
            if (event.key === 'Enter' && form) {
                event.preventDefault();
                form.submit();
            }
        });

        if ((searchInput?.value || '').trim() !== '') {
            filterTableRowsClient(searchInput.value);
        }

        document.addEventListener('keydown', (event) => {
            if (event.key !== 'Escape') return;
            const activeEl = document.activeElement;
            if (activeEl instanceof HTMLInputElement || activeEl instanceof HTMLSelectElement || activeEl instanceof HTMLTextAreaElement) { activeEl.blur(); return; }
            if (panel?.classList.contains('is-open')) setPanelOpen(false);
        });


        const escapeDomId = (id) => {
            if (typeof CSS !== 'undefined' && typeof CSS.escape === 'function') {
                return CSS.escape(id);
            }
            return String(id).replace(/([ !"#$%&'()*+,./:;<=>?@[\\\]^`{|}~])/g, '\\$1');
        };

        const findNotesRow = (targetId) => {
            if (!targetId) return null;
            const selector = `#${escapeDomId(targetId)}`;
            return tableEl?.querySelector(selector) || reportRoot.querySelector(selector);
        };

        const bindPropertyNotesToggle = () => {
            if (window.__vnPropertyNotesReady) return;

            const showCaret = '▾';
            const hideCaret = '▴';

            const toggleNotesRow = (toggle) => {
                const targetId = toggle.getAttribute('data-target');
                const row = findNotesRow(targetId);
                if (!row) return;

                const isOpen = row.classList.toggle('open');
                toggle.classList.toggle('open', isOpen);
                toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');

                const caret = toggle.querySelector('span:last-child');
                if (caret) caret.textContent = isOpen ? hideCaret : showCaret;

                requestFloatingHeadSync();
            };

            tableEl?.addEventListener('click', (event) => {
                const toggle = event.target instanceof Element
                    ? event.target.closest('[data-property-notes-toggle]')
                    : null;
                if (!toggle || !reportRoot.contains(toggle)) return;

                event.preventDefault();
                event.stopPropagation();
                toggleNotesRow(toggle);
            });

            window.__vnPropertyNotesReady = true;
        };

        const bindExpandableRows = (toggleSelector, defaults = {}) => {
            const toggles = [...reportRoot.querySelectorAll(toggleSelector)];
            toggles.forEach((toggle) => {
                const showLabel = toggle.getAttribute('data-show-label') || defaults.showLabel || '▾';
                const hideLabel = toggle.getAttribute('data-hide-label') || defaults.hideLabel || '▴';

                toggle.addEventListener('click', (event) => {
                    event.preventDefault();
                    const targetId = toggle.getAttribute('data-target');
                    if (!targetId) return;

                    const row = findNotesRow(targetId) || reportRoot.querySelector(`#${escapeDomId(targetId)}`);
                    if (!row) return;

                    const isHidden = row.hasAttribute('hidden');
                    if (isHidden) {
                        row.removeAttribute('hidden');
                        toggle.setAttribute('aria-expanded', 'true');
                        toggle.classList.add('is-open');
                        toggle.textContent = hideLabel;
                    } else {
                        row.setAttribute('hidden', 'hidden');
                        toggle.setAttribute('aria-expanded', 'false');
                        toggle.classList.remove('is-open');
                        toggle.textContent = showLabel;
                    }
                    requestFloatingHeadSync();
                });
            });
        };

        bindPropertyNotesToggle();
        bindExpandableRows('[data-property-operations-toggle]');
        bindExpandableRows('[data-property-signals-toggle]');
        bindExpandableRows('[data-property-files-toggle]');
        bindExpandableRows('[data-property-installments-toggle]');

        const tblNavScroll = (direction) => {
            if (!tableScroller) return;
            const smooth = !window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            const huge = 999999;
            tableScroller.scrollBy({
                left: direction === 'end' ? huge : -huge,
                behavior: smooth ? 'smooth' : 'auto',
            });
            requestFloatingHeadSync();
        };

        if (tableScroller && !reportRoot.querySelector('.vn-tbl-nav-pill')) {
            let wrap = tableScroller.closest('.vn-table-with-scroll');
            if (!wrap) {
                wrap = document.createElement('div');
                wrap.className = 'vn-table-with-scroll';
                tableScroller.parentNode?.insertBefore(wrap, tableScroller);
                wrap.appendChild(tableScroller);
            }
            tblNavPill = document.createElement('div');
            tblNavPill.className = 'vn-tbl-nav-pill vn-table-nav-pill';
            tblNavPill.setAttribute('data-table-nav-pill', '');
            tblNavPill.setAttribute('role', 'navigation');
            tblNavPill.setAttribute('aria-label', 'التنقل في الجدول');
            tblNavPill.innerHTML = '<div class="vn-tbl-nav-pill-inner"><button type="button" class="vn-tbl-nav-pill-btn" data-tbl-nav="start">⟪ بداية الجدول</button><div class="vn-tbl-nav-pill-sep"></div><button type="button" class="vn-tbl-nav-pill-btn" data-tbl-nav="end">نهاية الجدول ⟫</button></div>';
            wrap.appendChild(tblNavPill);
            tblNavPill.querySelector('[data-tbl-nav="start"]')?.addEventListener('click', () => tblNavScroll('start'));
            tblNavPill.querySelector('[data-tbl-nav="end"]')?.addEventListener('click', () => tblNavScroll('end'));
        } else {
            tblNavPill = reportRoot.querySelector('.vn-tbl-nav-pill');
        }

        tableScroller?.addEventListener('scroll', () => {
            requestFloatingHeadSync();
            updateTblNavPill();
        }, { passive: true });

        const ensureFloatingHost = () => {
            if (floatingHost) return;
            floatingHost = document.createElement('div');
            floatingHost.className = 'vn-pr-floating-table-head';
            floatingHost.setAttribute('aria-hidden', 'true');
            floatingTable = document.createElement('table');
            floatingHost.appendChild(floatingTable);
            document.body.appendChild(floatingHost);
        };

        const hideFloatingHead = () => {
            if (!floatingHost) return;
            floatingHost.style.display = 'none';
            floatingHost.style.width = '';
            floatingHost.style.left = '';
            if (floatingTable) {
                floatingTable.style.transform = '';
                floatingTable.innerHTML = '';
            }
        };

        const updateFloatingTableHead = () => {
            if (!tableEl || !tableScroller) {
                hideFloatingHead();
                return;
            }

            const thead = tableEl.querySelector('thead');
            if (!thead) {
                hideFloatingHead();
                return;
            }

            const firstHeaderCell = thead.querySelector('th');
            if (firstHeaderCell && getComputedStyle(firstHeaderCell).position === 'sticky') {
                hideFloatingHead();
                return;
            }

            const stickyTop = parseFloat(getComputedStyle(reportRoot).getPropertyValue('--vn-pr-table-sticky-offset')) || 96;
            const rect = tableEl.getBoundingClientRect();
            const headRect = thead.getBoundingClientRect();
            const headerH = Math.max(28, Math.ceil(headRect.height || 32));
            const shouldPin = headRect.top <= stickyTop - 18 && rect.bottom > stickyTop + headerH + 2;

            if (!shouldPin || document.fullscreenElement === reportRoot) {
                hideFloatingHead();
                return;
            }

            ensureFloatingHost();
            const boxRect = tableScroller.getBoundingClientRect();
            if (boxRect.width < 30) {
                hideFloatingHead();
                return;
            }

            const toolbarRect = toolbarEl?.getBoundingClientRect() || boxRect;
            const viewportWidth = document.documentElement.clientWidth || window.innerWidth || 0;
            const safeInset = 8;
            const rawHostLeft = Math.min(boxRect.left, toolbarRect.left);
            const rawHostRight = Math.max(boxRect.right, toolbarRect.right);
            const hostLeft = Math.round(Math.max(safeInset, rawHostLeft));
            const hostRight = Math.round(Math.min(Math.max(hostLeft + 30, rawHostRight), Math.max(hostLeft + 30, viewportWidth - safeInset)));
            const hostWidth = Math.max(30, hostRight - hostLeft);
            const offsetInside = Math.round(boxRect.left - hostLeft);

            const headClone = thead.cloneNode(true);
            headClone.querySelectorAll('[id]').forEach((el) => el.removeAttribute('id'));
            headClone.querySelectorAll('input, button, select, textarea, a').forEach((el) => {
                el.setAttribute('tabindex', '-1');
                el.setAttribute('aria-hidden', 'true');
                if ('disabled' in el) el.disabled = true;
            });

            const sourceThs = [...thead.querySelectorAll('th')];
            [...headClone.querySelectorAll('th')].forEach((th, i) => {
                const src = sourceThs[i];
                if (!src) return;
                const w = Math.ceil(src.getBoundingClientRect().width);
                th.style.display = getComputedStyle(src).display === 'none' ? 'none' : '';
                th.style.width = `${w}px`;
                th.style.minWidth = `${w}px`;
                th.style.maxWidth = `${w}px`;
                th.style.position = 'static';
                th.style.top = 'auto';
            });

            floatingTable.className = tableEl.className;
            floatingTable.innerHTML = `<thead>${headClone.innerHTML}</thead>`;
            floatingHost.style.display = 'block';
            floatingHost.style.top = `${stickyTop}px`;
            floatingHost.style.left = `${hostLeft}px`;
            floatingHost.style.width = `${hostWidth}px`;
            floatingTable.style.width = `${Math.round(tableEl.scrollWidth)}px`;
            floatingTable.style.minWidth = `${Math.round(tableEl.scrollWidth)}px`;
            floatingTable.style.transform = `translateX(${offsetInside - tableScroller.scrollLeft}px)`;
        };

        const updateStickyOffset = () => {
            const header = document.querySelector('.vn-app-header');
            const breadcrumb = document.querySelector('.vn-app-breadcrumb-row');
            let pin = 72;
            if (header) pin = Math.max(pin, Math.ceil(header.getBoundingClientRect().height) + 6);
            if (breadcrumb) pin += Math.ceil(breadcrumb.getBoundingClientRect().height);

            if (toolbarEl) {
                const cs = getComputedStyle(toolbarEl);
                if (cs.display !== 'none' && cs.visibility !== 'hidden') {
                    const tTop = Number.isFinite(parseFloat(cs.top)) ? parseFloat(cs.top) : 0;
                    pin = Math.max(pin, Math.ceil(tTop + toolbarEl.getBoundingClientRect().height + 8));
                }
            }

            reportRoot.style.setProperty('--vn-pr-table-sticky-offset', `${pin}px`);
            requestFloatingHeadSync();
        };

        const syncFullscreenUi = () => {
            const activeEl = document.fullscreenElement || document.webkitFullscreenElement || null;
            const isReportFs = activeEl === reportRoot;
            document.body.classList.toggle('vn-report-fullscreen-active', isReportFs);
            if (isReportFs) hideFloatingHead();
            if (fullscreenBtn) {
                fullscreenBtn.textContent = isReportFs ? '⤫ إغلاق الشاشة الكاملة' : '⛶ ملء الشاشة';
            }
        };

        fullscreenBtn?.addEventListener('click', () => {
            const activeEl = document.fullscreenElement || document.webkitFullscreenElement || null;
            if (activeEl === reportRoot) {
                (document.exitFullscreen || document.webkitExitFullscreen)?.call(document);
                return;
            }
            const request = reportRoot.requestFullscreen || reportRoot.webkitRequestFullscreen;
            request?.call(reportRoot);
        });

        document.addEventListener('fullscreenchange', syncFullscreenUi);
        document.addEventListener('webkitfullscreenchange', syncFullscreenUi);

        window.addEventListener('scroll', requestFloatingHeadSync, { passive: true });
        window.addEventListener('resize', () => {
            updateStickyOffset();
            updateTblNavPill();
        });

        tableAdvancedApi = initPropertiesTableAdvanced({
            reportRoot,
            tableEl,
            tableScroller,
            onLayoutChange: () => {
                requestFloatingHeadSync();
                updateTblNavPill();
                tableAdvancedApi?.syncTopScrollWidth();
            },
        });

        setPanelOpen(initialOpen, false);
        updateStickyOffset();
        updateTblNavPill();
        requestFloatingHeadSync();
        syncFullscreenUi();
    };

    updateClock();
    if (clockEl || dateEl) setInterval(updateClock, 1000);
    bindQuickSearchShortcut();
    bindFullscreenToggle();
    bindPropertiesReportInteractions();
})();
