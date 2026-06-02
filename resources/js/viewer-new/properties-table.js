/**
 * Advanced properties table mechanics (FRONT/index.html parity).
 * Column pin, resize, top scroll mirror, col visibility sync.
 */

const VN_TABLE_ID = 'vn-properties-table';
const VN_COLGROUP_ID = 'vn-properties-colgroup';
const VN_PIN_KEY = 'viewer_new_properties_pinned_cols';
const VN_WIDTH_KEY = 'viewer_new_properties_col_widths';
const LOCKED_RESIZE_KEYS = new Set(['id']);
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
            [...colgroupEl.children].forEach((col, i) => {
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
        notifyLayout();
        return normalized;
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
    bindColumnResizeHandlers();
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
        onColumnsVisibilityChange: (visibleKeys) => {
            if (!colgroupEl) return;
            const selected = new Set(visibleKeys);
            colgroupEl.querySelectorAll('col[data-column-key]').forEach((col) => {
                const key = col.getAttribute('data-column-key');
                col.style.display = key && selected.has(key) ? '' : 'none';
            });
            syncTopScrollWidth();
            applyColumnPinning();
            notifyLayout();
        },
        destroy: () => {
            window.removeEventListener('resize', onResize);
        },
    };
}
