/**
 * Advanced properties table mechanics (FRONT/index.html parity).
 * Column pin, resize, top scroll mirror, col visibility sync.
 */

const VN_TABLE_ID = 'vn-properties-table';
const VN_COLGROUP_ID = 'vn-properties-colgroup';
const VN_PIN_KEY = 'viewer_new_properties_pinned_cols';
const VN_WIDTH_KEY = 'viewer_new_properties_col_widths';
const LOCKED_RESIZE_KEYS = new Set(['id']);
const EXPORT_EXCLUDED_COLUMN_KEYS = new Set(['actions']);
const DEFAULT_COL_MIN_WIDTHS = {
    id: 96,
    property_name: 200,
    property_country: 100,
    card_governorate: 110,
    card_region_name: 110,
    card_subdivision: 100,
    card_record_number: 100,
    card_property_number: 100,
    card_total_area: 88,
    card_area_unit: 72,
    total_property_value_usd: 120,
    owned_property_value_usd: 120,
    actual_price_usd: 110,
    estimated_price_usd: 110,
    card_status: 96,
    card_investment_type: 110,
    card_purchase_method: 100,
    card_sale_date: 100,
    final_balance: 110,
    card_google_maps_url: 88,
    owners_count: 220,
    operations_count: 108,
    signals_count: 96,
    files_count: 88,
    installments_count: 96,
    updated_at: 120,
    card_property_details: 92,
    actions: 88,
};
const VN_PIN_SVG = `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
  <line x1="12" y1="17" x2="12" y2="22"/>
  <path d="M5 17h14v-1.76a2 2 0 0 0-1.11-1.79l-1.78-.9A2 2 0 0 1 15 10.76V6h1a2 2 0 0 0 0-4H8a2 2 0 0 0 0 4h1v4.76a2 2 0 0 1-1.11 1.79l-1.78.9A2 2 0 0 0 5 15.24Z"/>
</svg>`;

const safeGet = (k) => { try { return localStorage.getItem(k); } catch (_) { return null; } };
const safeSet = (k, v) => { try { localStorage.setItem(k, v); } catch (_) {} };

const escapeDomId = (id) => {
    if (typeof CSS !== 'undefined' && typeof CSS.escape === 'function') {
        return CSS.escape(id);
    }
    return String(id).replace(/([ !"#$%&'()*+,./:;<=>?@[\\\]^`{|}~])/g, '\\$1');
};

const colClassForKey = (key) => `vn-col-${key}`;

export function initPropertiesTableAdvanced(options) {
    const {
        reportRoot,
        tableEl,
        tableScroller,
        onLayoutChange,
        onColumnOrderChange,
        onRowSelectionChange,
    } = options;

    if (!reportRoot || !tableEl || !tableScroller) return () => {};

    const colgroupEl = document.getElementById(VN_COLGROUP_ID) || tableEl.querySelector('colgroup');
    const pinBar = reportRoot.querySelector('[data-properties-pin-bar]');
    const pinCountEl = reportRoot.querySelector('[data-properties-pin-count]');
    const unpinAllBtn = reportRoot.querySelector('[data-properties-unpin-all]');

    let pinnedCols = [];
    try {
        const parsed = JSON.parse(safeGet(VN_PIN_KEY) || '[]');
        pinnedCols = Array.isArray(parsed) ? parsed.filter((k) => typeof k === 'string') : [];
    } catch (_) {
        pinnedCols = [];
    }

    const notifyLayout = () => {
        if (typeof onLayoutChange === 'function') onLayoutChange();
    };

    let rowSelectionMode = false;
    const selectedRowIds = new Set();

    const notifyRowSelection = () => {
        if (typeof onRowSelectionChange === 'function') {
            onRowSelectionChange({ count: selectedRowIds.size, ids: [...selectedRowIds] });
        }
    };

    const getMainRows = () => [...tableEl.querySelectorAll('tbody tr')]
        .filter((row) => row.querySelector(':scope > td[data-column-key]'));

    const getRowId = (row, index = 0) => {
        const explicit = row?.getAttribute('data-property-id') || row?.dataset?.propertyId;
        if (explicit) return String(explicit);
        const idCellText = row?.querySelector(':scope > td[data-column-key="id"]')?.textContent?.trim();
        return idCellText || `row-${index + 1}`;
    };

    const isRowVisible = (row) => {
        if (!row || row.hidden) return false;
        const style = getComputedStyle(row);
        return style.display !== 'none' && style.visibility !== 'hidden';
    };

    const getVisibleMainRows = () => getMainRows().filter(isRowVisible);

    const cleanExportText = (node) => {
        if (!node) return '';
        const clone = node.cloneNode(true);
        clone.querySelectorAll([
            'button',
            'input',
            'select',
            'textarea',
            'script',
            'style',
            '.vn-col-pin-btn',
            '.vn-col-reorder-grip',
            '.vn-col-resize-handle',
            '.vn-row-selection-cell',
            '[aria-hidden="true"]',
        ].join(',')).forEach((el) => el.remove());
        return (clone.textContent || '')
            .replace(/\u00a0/g, ' ')
            .replace(/[ \t\r\f\v]+/g, ' ')
            .replace(/\n\s*/g, ' ')
            .trim();
    };

    const getVisibleColumnDefinitions = () => [...tableEl.querySelectorAll('thead th[data-column-key]')]
        .filter((th) => {
            const key = th.getAttribute('data-column-key') || '';
            return key && !EXPORT_EXCLUDED_COLUMN_KEYS.has(key) && getComputedStyle(th).display !== 'none';
        })
        .map((th) => {
            const key = th.getAttribute('data-column-key') || '';
            const label = cleanExportText(th.querySelector('.vn-th-label')) || cleanExportText(th) || key;
            return { key, header: label };
        });

    const getExportRows = () => {
        const columns = getVisibleColumnDefinitions();
        const allRows = getMainRows();
        const selectedOnly = selectedRowIds.size > 0;
        const rowsToExport = selectedOnly
            ? allRows.filter((row, index) => selectedRowIds.has(getRowId(row, index)))
            : getVisibleMainRows();

        return {
            selectedOnly,
            selectedRowIds: [...selectedRowIds],
            columns,
            rows: rowsToExport.map((row, index) => ({
                id: getRowId(row, index),
                values: columns.map(({ key }) => cleanExportText(row.querySelector(`:scope > td[data-column-key="${key}"]`))),
            })),
        };
    };

    const syncDetailRowColspans = (includeSelectionColumn) => {
        tableEl.querySelectorAll('tbody tr').forEach((row) => {
            if (row.querySelector(':scope > td[data-column-key]')) return;
            row.querySelectorAll(':scope > td[colspan]').forEach((cell) => {
                if (!cell.dataset.originalColspan) cell.dataset.originalColspan = cell.getAttribute('colspan') || '1';
                const base = Math.max(1, parseInt(cell.dataset.originalColspan || '1', 10) || 1);
                cell.setAttribute('colspan', String(includeSelectionColumn ? base + 1 : base));
            });
        });
    };

    const ensureRowSelectionColumn = () => {
        if (!colgroupEl || colgroupEl.querySelector('.vn-row-selection-col')) {
            syncDetailRowColspans(true);
            return;
        }

        const col = document.createElement('col');
        col.className = 'vn-row-selection-col';
        col.style.width = '52px';
        col.style.minWidth = '52px';
        colgroupEl.insertBefore(col, colgroupEl.firstChild);

        tableEl.querySelectorAll('thead tr').forEach((tr) => {
            if (tr.querySelector(':scope > .vn-row-selection-cell')) return;
            const th = document.createElement('th');
            th.className = 'vn-row-selection-cell vn-row-selection-head';
            th.scope = 'col';
            th.innerHTML = '<input type="checkbox" class="vn-row-selection-checkbox vn-row-selection-select-all" aria-label="تحديد كل الصفوف الظاهرة">';
            tr.insertBefore(th, tr.firstChild);
        });

        getMainRows().forEach((row, index) => {
            const rowId = getRowId(row, index);
            row.dataset.propertyId = rowId;
            if (row.querySelector(':scope > .vn-row-selection-cell')) return;
            const td = document.createElement('td');
            td.className = 'vn-row-selection-cell vn-row-selection-body-cell';
            td.innerHTML = `<input type="checkbox" class="vn-row-selection-checkbox vn-row-selection-row-checkbox" data-row-selection-id="${rowId.replace(/"/g, '&quot;')}" aria-label="تحديد العقار رقم ${rowId.replace(/"/g, '&quot;')}">`;
            row.insertBefore(td, row.firstChild);
        });
        syncDetailRowColspans(true);
    };

    const removeRowSelectionColumn = () => {
        colgroupEl?.querySelector('.vn-row-selection-col')?.remove();
        tableEl.querySelectorAll('.vn-row-selection-cell').forEach((cell) => cell.remove());
        document.querySelectorAll('.vn-pr-floating-table-head .vn-row-selection-cell').forEach((cell) => cell.remove());
        syncDetailRowColspans(false);
    };

    const syncRowSelectionInputs = () => {
        getMainRows().forEach((row, index) => {
            const rowId = getRowId(row, index);
            row.dataset.propertyId = rowId;
            row.classList.toggle('vn-row-selected', selectedRowIds.has(rowId));
            row.querySelectorAll('.vn-row-selection-row-checkbox').forEach((checkbox) => {
                checkbox.checked = selectedRowIds.has(rowId);
                checkbox.setAttribute('data-row-selection-id', rowId);
                checkbox.setAttribute('aria-label', `تحديد العقار رقم ${rowId}`);
            });
        });
    };

    const syncRowSelectionHeaderState = () => {
        const visibleRows = getVisibleMainRows();
        const visibleIds = visibleRows.map((row, index) => getRowId(row, index));
        const selectedVisible = visibleIds.filter((id) => selectedRowIds.has(id)).length;
        const checked = visibleIds.length > 0 && selectedVisible === visibleIds.length;
        const indeterminate = selectedVisible > 0 && selectedVisible < visibleIds.length;
        document.querySelectorAll('#vn-properties-table .vn-row-selection-select-all, .vn-pr-floating-table-head .vn-row-selection-select-all').forEach((checkbox) => {
            checkbox.checked = checked;
            checkbox.indeterminate = indeterminate;
            checkbox.disabled = visibleIds.length === 0;
            checkbox.setAttribute('aria-label', 'تحديد كل الصفوف الظاهرة');
        });
    };

    const syncRowSelectionUi = () => {
        if (!rowSelectionMode) return;
        ensureRowSelectionColumn();
        syncRowSelectionInputs();
        syncRowSelectionHeaderState();
        syncTopScrollWidth();
        applyColumnPinning();
        notifyLayout();
    };

    const clearSelectedRows = () => {
        selectedRowIds.clear();
        syncRowSelectionInputs();
        syncRowSelectionHeaderState();
        notifyRowSelection();
    };

    const setAllVisibleRowsSelected = (selected) => {
        getVisibleMainRows().forEach((row, index) => {
            const rowId = getRowId(row, index);
            if (selected) selectedRowIds.add(rowId);
            else selectedRowIds.delete(rowId);
        });
        syncRowSelectionInputs();
        syncRowSelectionHeaderState();
        notifyRowSelection();
    };

    const enableRowSelectionMode = (enabled) => {
        rowSelectionMode = !!enabled;
        reportRoot.classList.toggle('vn-properties-report--row-selection', rowSelectionMode);
        tableEl.classList.toggle('vn-table-row-selection-mode', rowSelectionMode);
        if (rowSelectionMode) {
            ensureRowSelectionColumn();
            syncRowSelectionUi();
            notifyRowSelection();
        } else {
            selectedRowIds.clear();
            removeRowSelectionColumn();
            notifyRowSelection();
            syncTopScrollWidth();
            applyColumnPinning();
            notifyLayout();
        }
    };

    const bindRowSelectionHandlers = () => {
        if (tableEl.dataset.rowSelectionBound === '1') return;
        tableEl.dataset.rowSelectionBound = '1';
        tableEl.addEventListener('change', (e) => {
            if (!rowSelectionMode) return;
            const selectAll = e.target?.closest?.('.vn-row-selection-select-all');
            if (selectAll && tableEl.contains(selectAll)) {
                setAllVisibleRowsSelected(selectAll.checked);
                return;
            }
            const rowCheckbox = e.target?.closest?.('.vn-row-selection-row-checkbox');
            if (!rowCheckbox || !tableEl.contains(rowCheckbox)) return;
            const row = rowCheckbox.closest('tr');
            const rowId = rowCheckbox.getAttribute('data-row-selection-id') || getRowId(row);
            if (rowCheckbox.checked) selectedRowIds.add(rowId);
            else selectedRowIds.delete(rowId);
            syncRowSelectionInputs();
            syncRowSelectionHeaderState();
            notifyRowSelection();
        });
    };

    const ensureThInners = () => {
        tableEl.querySelectorAll('thead th[data-column-key]').forEach((th) => {
            if (th.querySelector('.vn-th-inner')) return;
            const inner = document.createElement('div');
            inner.className = 'vn-th-inner';
            while (th.firstChild) inner.appendChild(th.firstChild);
            th.appendChild(inner);
        });
    };

    const syncColClasses = () => {
        tableEl.querySelectorAll('[data-column-key]').forEach((cell) => {
            const key = cell.getAttribute('data-column-key');
            if (!key) return;
            const cls = colClassForKey(key);
            if (!cell.classList.contains(cls)) cell.classList.add(cls);
        });
        if (colgroupEl) {
            const keyedCols = [...colgroupEl.querySelectorAll('col[data-column-key]')];
            keyedCols.forEach((col, i) => {
                const th = tableEl.querySelectorAll('thead th[data-column-key]')[i];
                const key = th?.getAttribute('data-column-key');
                if (key && !col.classList.contains(colClassForKey(key))) {
                    col.classList.add(colClassForKey(key));
                    col.setAttribute('data-column-key', key);
                }
            });
        }
    };

    const applyDefaultColWidths = () => {
        if (!colgroupEl) return;
        colgroupEl.querySelectorAll('col[data-column-key]').forEach((col) => {
            const key = col.getAttribute('data-column-key');
            if (!key) return;
            const min = DEFAULT_COL_MIN_WIDTHS[key] || 96;
            const current = parseInt(col.style.width || '0', 10);
            if (!current || current < min) col.style.width = `${min}px`;
        });
    };

    const restoreColWidths = () => {
        if (!colgroupEl) return;
        let widths = {};
        try {
            widths = JSON.parse(safeGet(VN_WIDTH_KEY) || '{}') || {};
        } catch (_) {
            widths = {};
        }
        Object.entries(widths).forEach(([key, w]) => {
            const col = colgroupEl.querySelector(`col.${colClassForKey(key)}`) || colgroupEl.querySelector(`col[data-column-key="${key}"]`);
            if (col && Number(w) >= 72) col.style.width = `${Math.round(w)}px`;
        });
        applyDefaultColWidths();
    };

    const persistColWidth = (key, widthPx) => {
        let widths = {};
        try {
            widths = JSON.parse(safeGet(VN_WIDTH_KEY) || '{}') || {};
        } catch (_) {
            widths = {};
        }
        widths[key] = Math.round(widthPx);
        safeSet(VN_WIDTH_KEY, JSON.stringify(widths));
    };

    const syncPinMenuBar = () => {
        const count = pinnedCols.length;
        pinBar?.classList.toggle('is-visible', count > 0);
        if (pinCountEl) pinCountEl.textContent = count > 0 ? `${count} مثبت` : '';
    };

    const getVisualPinnedColumns = () => {
        const visiblePinned = new Set(pinnedCols);
        return [...tableEl.querySelectorAll('thead th[data-column-key]')]
            .map((th) => th.getAttribute('data-column-key') || '')
            .filter((key) => {
                if (!key || !visiblePinned.has(key)) return false;
                const th = tableEl.querySelector(`thead th[data-column-key="${key}"]`);
                return th && getComputedStyle(th).display !== 'none';
            });
    };

    const applyColumnPinning = () => {
        const pinned = getVisualPinnedColumns();

        tableEl.classList.remove('vn-has-pinned-cols');
        tableEl.querySelectorAll('.vn-col-pinned, .vn-col-pin-edge').forEach((el) => {
            el.classList.remove('vn-col-pinned', 'vn-col-pin-edge');
            el.style.removeProperty('right');
        });
        tableEl.querySelectorAll('.vn-col-pin-btn').forEach((btn) => {
            btn.classList.remove('active');
            btn.title = 'تثبيت العمود';
            btn.setAttribute('aria-pressed', 'false');
        });

        if (pinned.length === 0) {
            syncPinMenuBar();
            notifyLayout();
            return;
        }

        tableEl.classList.add('vn-has-pinned-cols');
        let offset = 0;
        pinned.forEach((colKey) => {
            const th = tableEl.querySelector(`thead th.${colClassForKey(colKey)}`);
            const colW = th ? th.offsetWidth : 120;
            tableEl.querySelectorAll(`th.${colClassForKey(colKey)}, td.${colClassForKey(colKey)}`).forEach((el) => {
                if (getComputedStyle(el).display === 'none') return;
                el.classList.add('vn-col-pinned');
                el.style.right = `${offset}px`;
            });
            const btn = th?.querySelector('.vn-col-pin-btn');
            if (btn) {
                btn.classList.add('active');
                btn.title = 'إلغاء التثبيت';
                btn.setAttribute('aria-pressed', 'true');
            }
            offset += colW;
        });

        const lastKey = pinned[pinned.length - 1];
        tableEl.querySelectorAll(`th.${colClassForKey(lastKey)}, td.${colClassForKey(lastKey)}`).forEach((el) => {
            if (el.classList.contains('vn-col-pinned')) el.classList.add('vn-col-pin-edge');
        });

        syncPinMenuBar();
        notifyLayout();
    };

    const togglePinColumn = (colKey) => {
        const idx = pinnedCols.indexOf(colKey);
        if (idx === -1) pinnedCols.push(colKey);
        else pinnedCols.splice(idx, 1);
        safeSet(VN_PIN_KEY, JSON.stringify(pinnedCols));
        applyColumnPinning();
    };

    const unpinAllColumns = () => {
        pinnedCols = [];
        safeSet(VN_PIN_KEY, '[]');
        applyColumnPinning();
    };

    const injectPinButtons = () => {
        tableEl.querySelectorAll('thead th[data-column-key]').forEach((th) => {
            if (th.querySelector('.vn-col-pin-btn')) return;
            const inner = th.querySelector('.vn-th-inner');
            if (!inner) return;
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'vn-col-pin-btn';
            btn.dataset.colPin = th.getAttribute('data-column-key') || '';
            btn.setAttribute('aria-label', 'تثبيت العمود');
            btn.title = 'تثبيت العمود';
            btn.innerHTML = VN_PIN_SVG;
            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                e.preventDefault();
                const key = th.getAttribute('data-column-key');
                if (key) togglePinColumn(key);
            });
            inner.appendChild(btn);
        });
    };

    const ensureColumnResizers = () => {
        tableEl.querySelectorAll('thead th[data-column-key]').forEach((th) => {
            const key = th.getAttribute('data-column-key') || '';
            if (LOCKED_RESIZE_KEYS.has(key)) {
                th.querySelector('.vn-col-resize-handle')?.remove();
                return;
            }
            if (th.querySelector('.vn-col-resize-handle')) return;
            const handle = document.createElement('span');
            handle.className = 'vn-col-resize-handle';
            handle.setAttribute('aria-hidden', 'true');
            th.appendChild(handle);
        });
    };

    const bindColumnResizeHandlers = () => {
        if (!colgroupEl) return;
        tableEl.querySelectorAll('thead th[data-column-key] .vn-col-resize-handle').forEach((handle) => {
            if (handle.dataset.resizeBound === '1') return;
            handle.dataset.resizeBound = '1';
            handle.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
            });
            handle.addEventListener('pointerdown', (e) => {
                e.preventDefault();
                e.stopPropagation();
                const th = handle.closest('th[data-column-key]');
                if (!th) return;
                const key = th.getAttribute('data-column-key') || '';
                if (LOCKED_RESIZE_KEYS.has(key)) return;
                const col = colgroupEl.querySelector(`col.${colClassForKey(key)}`) || colgroupEl.querySelector(`col[data-column-key="${key}"]`);
                if (!col) return;
                const startX = e.clientX;
                const startWidth = Math.max(th.getBoundingClientRect().width, 72);
                const minWidth = DEFAULT_COL_MIN_WIDTHS[key] || 72;
                const rtl = getComputedStyle(document.documentElement).direction === 'rtl';
                let moved = false;
                document.body.classList.add('vn-is-col-resizing');
                if (handle.setPointerCapture) {
                    try { handle.setPointerCapture(e.pointerId); } catch (_) {}
                }
                const onMove = (ev) => {
                    const delta = ev.clientX - startX;
                    if (!moved && Math.abs(delta) > 2) moved = true;
                    const nextWidth = Math.max(minWidth, startWidth + (rtl ? startX - ev.clientX : delta));
                    col.style.width = `${nextWidth}px`;
                };
                const onUp = () => {
                    window.removeEventListener('pointermove', onMove);
                    window.removeEventListener('pointerup', onUp);
                    window.removeEventListener('pointercancel', onUp);
                    document.body.classList.remove('vn-is-col-resizing');
                    if (moved) {
                        th.dataset.recentlyResized = String(Date.now());
                        persistColWidth(key, th.getBoundingClientRect().width);
                        applyColumnPinning();
                        notifyLayout();
                    }
                };
                window.addEventListener('pointermove', onMove);
                window.addEventListener('pointerup', onUp);
                window.addEventListener('pointercancel', onUp);
            });
        });

        if (tableEl.dataset.resizeClickGuardBound !== '1') {
            tableEl.dataset.resizeClickGuardBound = '1';
            tableEl.addEventListener('click', (e) => {
                const th = e.target?.closest?.('th[data-column-key]');
                if (!th) return;
                const ts = Number(th.dataset.recentlyResized || 0);
                if (ts && Date.now() - ts < 250) {
                    e.preventDefault();
                    e.stopPropagation();
                }
            }, true);
        }
    };

    const ensureTopScrollMirror = () => {
        const wrap = tableScroller.closest('.vn-table-with-scroll') || tableScroller.parentElement;
        if (!wrap) return null;
        let topScroll = wrap.querySelector('.vn-tbl-top-scroll');
        if (!topScroll) {
            topScroll = document.createElement('div');
            topScroll.className = 'vn-tbl-top-scroll';
            topScroll.setAttribute('aria-hidden', 'true');
            topScroll.innerHTML = '<div class="vn-tbl-top-scroll-inner"></div>';
            wrap.insertBefore(topScroll, tableScroller);
        }
        return topScroll;
    };

    const syncTopScrollWidth = () => {
        const topScroll = ensureTopScrollMirror();
        if (!topScroll) return;
        const inner = topScroll.querySelector('.vn-tbl-top-scroll-inner');
        if (inner) inner.style.width = `${tableEl.scrollWidth}px`;
        topScroll.classList.toggle('is-visible', tableScroller.scrollWidth > tableScroller.clientWidth + 4);
    };

    let pinScrollRaf = 0;
    const schedulePinSync = () => {
        if (pinScrollRaf) return;
        pinScrollRaf = window.requestAnimationFrame(() => {
            pinScrollRaf = 0;
            applyColumnPinning();
        });
    };

    const reorderElementsByKey = (parent, selector, order) => {
        if (!parent) return;
        const byKey = new Map([...parent.querySelectorAll(selector)].map((el) => [el.getAttribute('data-column-key'), el]));
        order.forEach((key) => {
            const el = byKey.get(key);
            if (el) parent.appendChild(el);
        });
    };

    const applyColumnOrder = (order) => {
        const requested = Array.isArray(order) ? order.filter((key) => typeof key === 'string') : [];
        const existing = [...tableEl.querySelectorAll('thead th[data-column-key]')].map((th) => th.getAttribute('data-column-key')).filter(Boolean);
        const existingSet = new Set(existing);
        const normalized = [...new Set(requested.filter((key) => existingSet.has(key)))];
        existing.forEach((key) => { if (!normalized.includes(key)) normalized.push(key); });
        if (!normalized.length) return existing;

        reorderElementsByKey(colgroupEl, ':scope > col[data-column-key]', normalized);
        tableEl.querySelectorAll('thead tr').forEach((tr) => reorderElementsByKey(tr, ':scope > th[data-column-key]', normalized));
        tableEl.querySelectorAll('tbody tr').forEach((tr) => reorderElementsByKey(tr, ':scope > td[data-column-key]', normalized));

        syncColClasses();
        restoreColWidths();
        ensureColumnResizers();
        syncTopScrollWidth();
        applyColumnPinning();
        syncRowSelectionUi();
        notifyLayout();
        return normalized;
    };

    const getColumnOrder = () => [...tableEl.querySelectorAll('thead th[data-column-key]')]
        .map((th) => th.getAttribute('data-column-key'))
        .filter(Boolean);

    let columnReorderMode = false;
    let columnDrag = null;
    let dropIndicator = null;

    const getDocumentDirection = () => getComputedStyle(tableEl).direction || getComputedStyle(document.documentElement).direction || 'rtl';

    const ensureReorderGrips = () => {
        tableEl.querySelectorAll('thead th[data-column-key]').forEach((th) => {
            const inner = th.querySelector('.vn-th-inner') || th;
            if (inner.querySelector('.vn-col-reorder-grip')) return;
            const grip = document.createElement('span');
            grip.className = 'vn-col-reorder-grip';
            grip.setAttribute('aria-hidden', 'true');
            grip.textContent = '⋮⋮';
            inner.insertBefore(grip, inner.firstChild);
        });
    };

    const ensureDropIndicator = () => {
        if (dropIndicator) return dropIndicator;
        dropIndicator = document.createElement('div');
        dropIndicator.className = 'vn-col-drop-indicator';
        dropIndicator.setAttribute('aria-hidden', 'true');
        document.body.appendChild(dropIndicator);
        return dropIndicator;
    };

    const hideDropIndicator = () => {
        dropIndicator?.classList.remove('is-visible');
    };

    const clearDraggedColumnClasses = () => {
        tableEl.querySelectorAll('.vn-col-dragging, .vn-col-drop-target').forEach((el) => {
            el.classList.remove('vn-col-dragging', 'vn-col-drop-target');
        });
    };

    const setDraggedColumnClasses = (key) => {
        clearDraggedColumnClasses();
        if (!key) return;
        tableEl.querySelectorAll(`th.${colClassForKey(key)}, td.${colClassForKey(key)}`).forEach((el) => {
            if (getComputedStyle(el).display !== 'none') el.classList.add('vn-col-dragging');
        });
    };

    const getHeaderFromPoint = (x, y) => {
        const el = document.elementFromPoint(x, y);
        const th = el?.closest?.('th[data-column-key]');
        const key = th?.getAttribute('data-column-key');
        const realTh = key ? tableEl.querySelector(`thead th[data-column-key="${key}"]`) : th;
        return realTh && tableEl.contains(realTh) && getComputedStyle(realTh).display !== 'none' ? realTh : null;
    };

    const getDropPlacement = (targetTh, clientX) => {
        const targetKey = targetTh?.getAttribute('data-column-key');
        const sourceKey = columnDrag?.sourceKey;
        const order = getColumnOrder();
        const sourceIndex = order.indexOf(sourceKey);
        const targetIndex = order.indexOf(targetKey);
        if (!targetKey || !sourceKey || sourceIndex < 0 || targetIndex < 0) return null;

        const rect = targetTh.getBoundingClientRect();
        const isRtl = getDocumentDirection() === 'rtl';
        const beforeTarget = isRtl ? clientX > rect.left + rect.width / 2 : clientX < rect.left + rect.width / 2;
        const insertionIndex = beforeTarget ? targetIndex : targetIndex + 1;
        let dropIndex = insertionIndex;
        if (sourceIndex < insertionIndex) dropIndex -= 1;
        dropIndex = Math.max(0, Math.min(order.length - 1, dropIndex));
        const indicatorX = beforeTarget
            ? (isRtl ? rect.right : rect.left)
            : (isRtl ? rect.left : rect.right);

        return { targetKey, order, sourceIndex, dropIndex, indicatorX, targetRect: rect };
    };

    const showDropIndicator = (placement) => {
        const indicator = ensureDropIndicator();
        const scrollerRect = tableScroller.getBoundingClientRect();
        const tableRect = tableEl.getBoundingClientRect();
        const top = Math.max(scrollerRect.top, placement.targetRect.top);
        const bottom = Math.min(scrollerRect.bottom, tableRect.bottom, window.innerHeight);
        indicator.style.left = `${Math.round(placement.indicatorX)}px`;
        indicator.style.top = `${Math.round(top)}px`;
        indicator.style.height = `${Math.max(placement.targetRect.height, bottom - top)}px`;
        indicator.classList.add('is-visible');
    };

    const updateDropTarget = (placement) => {
        tableEl.querySelectorAll('.vn-col-drop-target').forEach((el) => el.classList.remove('vn-col-drop-target'));
        if (!placement?.targetKey) return;
        tableEl.querySelectorAll(`th.${colClassForKey(placement.targetKey)}, td.${colClassForKey(placement.targetKey)}`).forEach((el) => {
            if (getComputedStyle(el).display !== 'none') el.classList.add('vn-col-drop-target');
        });
    };

    const finishColumnDrag = (commit) => {
        if (!columnDrag) return;
        const drag = columnDrag;
        columnDrag = null;
        window.removeEventListener('pointermove', onColumnReorderPointerMove);
        window.removeEventListener('pointerup', onColumnReorderPointerUp);
        window.removeEventListener('pointercancel', onColumnReorderPointerCancel);
        document.body.classList.remove('vn-is-column-reordering');
        hideDropIndicator();
        clearDraggedColumnClasses();

        if (commit && drag.active && drag.placement && drag.placement.dropIndex !== drag.placement.sourceIndex) {
            const nextOrder = drag.placement.order.filter((key) => key !== drag.sourceKey);
            nextOrder.splice(drag.placement.dropIndex, 0, drag.sourceKey);
            const applied = applyColumnOrder(nextOrder);
            if (typeof onColumnOrderChange === 'function') onColumnOrderChange(applied);
        } else {
            applyColumnPinning();
            notifyLayout();
        }
    };

    function onColumnReorderPointerMove(e) {
        if (!columnDrag) return;
        const moved = Math.abs(e.clientX - columnDrag.startX) > 5 || Math.abs(e.clientY - columnDrag.startY) > 5;
        if (!columnDrag.active && !moved) return;
        if (!columnDrag.active) {
            columnDrag.active = true;
            document.body.classList.add('vn-is-column-reordering');
            setDraggedColumnClasses(columnDrag.sourceKey);
        }
        e.preventDefault();
        const targetTh = getHeaderFromPoint(e.clientX, e.clientY) || columnDrag.sourceTh;
        const placement = getDropPlacement(targetTh, e.clientX);
        columnDrag.placement = placement;
        if (placement) {
            showDropIndicator(placement);
            updateDropTarget(placement);
        } else {
            hideDropIndicator();
            updateDropTarget(null);
        }
    }

    function onColumnReorderPointerUp(e) {
        if (columnDrag?.active) e.preventDefault();
        finishColumnDrag(true);
    }

    function onColumnReorderPointerCancel() {
        finishColumnDrag(false);
    }

    const shouldIgnoreReorderStart = (target) => !!target?.closest?.([
        '.vn-col-pin-btn',
        '.col-pin-btn',
        '.vn-col-resize-handle',
        '.col-resize-handle',
        '[data-col-resize]',
        'button',
        'a',
        'input',
        'select',
        'textarea',
        '[role="button"]',
    ].join(','));

    const startColumnReorderDrag = (sourceKey, e) => {
        if (!columnReorderMode || !sourceKey || !e || e.button !== 0 || (e.pointerType === 'touch' && e.isPrimary === false)) return false;
        const sourceTh = tableEl.querySelector(`thead th[data-column-key="${sourceKey}"]`);
        if (!sourceTh || getComputedStyle(sourceTh).display === 'none') return false;
        if (columnDrag) finishColumnDrag(false);
        columnDrag = {
            sourceKey,
            sourceTh,
            startX: e.clientX,
            startY: e.clientY,
            active: false,
            placement: null,
        };
        window.addEventListener('pointermove', onColumnReorderPointerMove, { passive: false });
        window.addEventListener('pointerup', onColumnReorderPointerUp, { passive: false });
        window.addEventListener('pointercancel', onColumnReorderPointerCancel, { passive: true });
        return true;
    };

    const bindColumnReorderHandlers = () => {
        if (tableEl.dataset.columnReorderBound === '1') return;
        tableEl.dataset.columnReorderBound = '1';
        tableEl.addEventListener('pointerdown', (e) => {
            if (shouldIgnoreReorderStart(e.target)) return;
            const th = e.target?.closest?.('th[data-column-key]');
            if (!th || !tableEl.contains(th)) return;
            const sourceKey = th.getAttribute('data-column-key');
            if (startColumnReorderDrag(sourceKey, e)) e.preventDefault();
        });
    };

    const enableColumnReorderMode = (enabled) => {
        columnReorderMode = !!enabled;
        reportRoot.classList.toggle('vn-properties-report--column-reorder', columnReorderMode);
        tableEl.classList.toggle('vn-table-column-reorder-mode', columnReorderMode);
        tableEl.querySelectorAll('thead th[data-column-key]').forEach((th) => {
            th.toggleAttribute('data-column-reorder-draggable', columnReorderMode);
        });
        if (!columnReorderMode) finishColumnDrag(false);
    };

    const wireTopScrollSync = () => {
        const topScroll = ensureTopScrollMirror();
        if (!topScroll || topScroll.dataset.wired === '1') return;
        topScroll.dataset.wired = '1';
        topScroll.addEventListener('scroll', () => {
            tableScroller.scrollLeft = topScroll.scrollLeft;
            schedulePinSync();
            notifyLayout();
        }, { passive: true });
        tableScroller.addEventListener('scroll', () => {
            if (topScroll) topScroll.scrollLeft = tableScroller.scrollLeft;
            schedulePinSync();
        }, { passive: true });
    };

    unpinAllBtn?.addEventListener('click', (e) => {
        e.preventDefault();
        unpinAllColumns();
    });

    if (tableEl.dataset.pinDelegationBound !== '1') {
        tableEl.dataset.pinDelegationBound = '1';
        tableEl.addEventListener('click', (e) => {
            const btn = e.target?.closest?.('.vn-col-pin-btn, [data-col-pin]');
            if (!btn || !tableEl.contains(btn)) return;
            e.preventDefault();
            e.stopPropagation();
            const key = btn.getAttribute('data-col-pin') || btn.closest('th[data-column-key]')?.getAttribute('data-column-key');
            if (key) togglePinColumn(key);
        });
    }

    tableScroller.classList.add('vn-table-scrollport');

    ensureThInners();
    syncColClasses();
    applyDefaultColWidths();
    restoreColWidths();
    injectPinButtons();
    ensureColumnResizers();
    ensureReorderGrips();
    bindColumnResizeHandlers();
    bindColumnReorderHandlers();
    bindRowSelectionHandlers();
    wireTopScrollSync();
    syncTopScrollWidth();
    applyColumnPinning();

    const onResize = () => {
        syncTopScrollWidth();
        applyColumnPinning();
        notifyLayout();
    };
    window.addEventListener('resize', onResize);

    return {
        applyColumnPinning,
        syncTopScrollWidth,
        togglePinColumn,
        getPinnedColumns: () => getVisualPinnedColumns(),
        applyColumnOrder,
        getColumnOrder,
        enableColumnReorderMode,
        startColumnReorderDrag,
        enableRowSelectionMode,
        getSelectedRowIds: () => [...selectedRowIds],
        getVisibleColumnKeys: () => getVisibleColumnDefinitions().map(({ key }) => key),
        getExportRows,
        clearSelectedRows,
        syncRowSelectionHeaderState,
        setAllVisibleRowsSelected,
        onColumnsVisibilityChange: (visibleKeys) => {
            if (!colgroupEl) return;
            const selected = new Set(visibleKeys);
            colgroupEl.querySelectorAll('col[data-column-key]').forEach((col) => {
                const key = col.getAttribute('data-column-key');
                col.style.display = key && selected.has(key) ? '' : 'none';
            });
            syncTopScrollWidth();
            applyColumnPinning();
            syncRowSelectionUi();
            notifyLayout();
        },
        destroy: () => {
            window.removeEventListener('resize', onResize);
        },
    };
}
