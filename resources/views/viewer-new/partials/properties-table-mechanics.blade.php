{{-- Table pin/resize/top-scroll — always loaded (Vite bundle may lag). Matches FRONT/index.html. --}}
@php $propertiesTableMechanicsVersion = '11'; @endphp
<script>
(function () {
    if (window.__vnPropertiesTableMechanics === '{{ $propertiesTableMechanicsVersion }}') return;
    window.__vnPropertiesTableMechanics = '{{ $propertiesTableMechanicsVersion }}';

    const report = document.querySelector('.vn-properties-report');
    const table = document.getElementById('vn-properties-table');
    const scroller = document.getElementById('vn-properties-overflow') || report?.querySelector('.vn-properties-table');
    const colgroup = document.getElementById('vn-properties-colgroup');
    if (!report || !table || !scroller || !colgroup) return;

    report.querySelectorAll('.stats-grid,.vn-report-kpi-grid,.vn-report-metrics').forEach((el) => {
        if (!el.closest('.vn-report-hero')) el.remove();
    });

    const PIN_KEY = 'viewer_new_properties_pinned_cols';
    const WIDTH_KEY = 'viewer_new_properties_col_widths';
    const colClass = (k) => 'vn-col-' + k;
    const minWidthFor = (k) => ({ id: 72, property_name: 120, owners_count: 160 }[k] || 72);

    const loadPinned = () => {
        try {
            const parsed = JSON.parse(localStorage.getItem(PIN_KEY) || '[]');
            return Array.isArray(parsed) ? parsed.filter((k) => typeof k === 'string') : [];
        } catch (_) {
            return [];
        }
    };

    let pinned = loadPinned();

    const persistWidth = (key, px) => {
        let widths = {};
        try { widths = JSON.parse(localStorage.getItem(WIDTH_KEY) || '{}') || {}; } catch (_) {}
        widths[key] = Math.round(px);
        try { localStorage.setItem(WIDTH_KEY, JSON.stringify(widths)); } catch (_) {}
    };

    const restoreWidths = () => {
        let widths = {};
        try { widths = JSON.parse(localStorage.getItem(WIDTH_KEY) || '{}') || {}; } catch (_) {}
        Object.entries(widths).forEach(([key, w]) => {
            const col = colgroup.querySelector('col.' + colClass(key));
            if (col && Number(w) >= 72) col.style.width = Math.round(w) + 'px';
        });
    };

    const getAnchor = () => {
        const anchorTh = table.querySelector('thead th[data-column-key="id"]') || table.querySelector('thead th[data-column-key]');
        if (!anchorTh || getComputedStyle(anchorTh).display === 'none') return null;
        const key = anchorTh.getAttribute('data-column-key');
        return key ? { key, th: anchorTh } : null;
    };

    const sortPinned = (keys) => keys
        .map((k) => {
            const th = table.querySelector('thead th.' + colClass(k));
            return { k, i: th ? th.cellIndex : 9999 };
        })
        .sort((a, b) => a.i - b.i)
        .map((e) => e.k);

    const applyPinLegacy = () => {
        pinned = loadPinned();
        table.classList.remove('vn-has-pinned-cols', 'has-pinned-cols');
        table.querySelectorAll('.vn-col-pinned,.vn-col-pin-edge,.vn-col-anchor,.col-pinned,.col-pin-edge,.col-anchor').forEach((el) => {
            el.classList.remove('vn-col-pinned', 'vn-col-pin-edge', 'vn-col-anchor', 'col-pinned', 'col-pin-edge', 'col-anchor');
            el.style.removeProperty('right');
        });
        table.querySelectorAll('.vn-col-pin-btn,.col-pin-btn').forEach((b) => {
            b.classList.remove('active');
            b.title = 'تثبيت العمود';
            b.setAttribute('aria-pressed', 'false');
        });
        const visible = pinned.filter((k) => {
            const th = table.querySelector('thead th[data-column-key="' + k + '"]');
            return th && getComputedStyle(th).display !== 'none';
        });
        const pinBar = report.querySelector('[data-properties-pin-bar]');
        if (!visible.length) {
            pinBar?.classList.remove('is-visible');
            return;
        }
        table.classList.add('vn-has-pinned-cols', 'has-pinned-cols');
        const anchor = getAnchor();
        let off = 0;
        const pinCells = (k, px, isAnchor) => {
            table.querySelectorAll('th.' + colClass(k) + ',td.' + colClass(k)).forEach((el) => {
                if (getComputedStyle(el).display === 'none') return;
                el.classList.add('vn-col-pinned', 'col-pinned');
                if (isAnchor) el.classList.add('vn-col-anchor', 'col-anchor');
                el.style.right = px + 'px';
            });
        };
        if (anchor) {
            pinCells(anchor.key, 0, true);
            off = anchor.th.offsetWidth;
        }
        sortPinned(visible).forEach((k) => {
            if (anchor && k === anchor.key) {
                const btn = anchor.th.querySelector('.vn-col-pin-btn');
                if (btn) {
                    btn.classList.add('active');
                    btn.title = 'إلغاء التثبيت';
                    btn.setAttribute('aria-pressed', 'true');
                }
                return;
            }
            const th = table.querySelector('thead th.' + colClass(k));
            const w = th ? th.offsetWidth : 100;
            pinCells(k, off, false);
            const btn = th?.querySelector('.vn-col-pin-btn');
            if (btn) {
                btn.classList.add('active');
                btn.title = 'إلغاء التثبيت';
                btn.setAttribute('aria-pressed', 'true');
            }
            off += w;
        });
        const ordered = sortPinned(visible);
        const last = ordered[ordered.length - 1];
        table.querySelectorAll('th.' + colClass(last) + ',td.' + colClass(last)).forEach((el) => {
            if (el.classList.contains('vn-col-pinned')) el.classList.add('vn-col-pin-edge', 'col-pin-edge');
        });
        pinBar?.classList.add('is-visible');
        const cnt = report.querySelector('[data-properties-pin-count]');
        if (cnt) cnt.textContent = visible.length + ' مثبت';
    };

    let isApplyingPin = false;
    const applyPin = () => {
        if (isApplyingPin) return;

        isApplyingPin = true;
        try {
            applyPinLegacy();
        } finally {
            isApplyingPin = false;
        }
    };

    table.querySelectorAll('[data-column-key]').forEach((el) => {
        const key = el.getAttribute('data-column-key');
        if (key && !el.classList.contains(colClass(key))) el.classList.add(colClass(key));
    });

    restoreWidths();

    table.querySelectorAll('[data-col-resize]').forEach((handle) => {
        if (handle.dataset.resizeBound === '1') return;
        handle.dataset.resizeBound = '1';
        handle.addEventListener('click', (e) => { e.preventDefault(); e.stopPropagation(); });
        handle.addEventListener('pointerdown', (e) => {
            e.preventDefault();
            e.stopPropagation();
            const key = handle.getAttribute('data-col-resize');
            const th = handle.closest('th[data-column-key]');
            const col = key ? colgroup.querySelector('col.' + colClass(key)) : null;
            if (!th || !col || !key) return;
            const startX = e.clientX;
            const startWidth = Math.max(th.getBoundingClientRect().width, minWidthFor(key));
            const minW = minWidthFor(key);
            let moved = false;
            document.body.classList.add('vn-is-col-resizing', 'is-col-resizing');
            col.style.minWidth = '0';
            try { handle.setPointerCapture(e.pointerId); } catch (_) {}
            const onMove = (ev) => {
                const delta = ev.clientX - startX;
                if (!moved && Math.abs(delta) > 2) moved = true;
                const next = Math.max(minW, startWidth + delta);
                col.style.width = next + 'px';
            };
            const onUp = () => {
                window.removeEventListener('pointermove', onMove);
                window.removeEventListener('pointerup', onUp);
                window.removeEventListener('pointercancel', onUp);
                document.body.classList.remove('vn-is-col-resizing', 'is-col-resizing');
                if (moved) {
                    persistWidth(key, th.getBoundingClientRect().width);
                    applyPin();
                }
            };
            window.addEventListener('pointermove', onMove);
            window.addEventListener('pointerup', onUp);
            window.addEventListener('pointercancel', onUp);
        });
    });

    const wrapper = scroller.closest('.vn-table-with-scroll') || scroller.parentElement;
    const card = wrapper?.closest('.vn-property-table-card, .vn-table-card');

    const syncCardFlowHeight = () => {
        if (!card || !wrapper) return;

        const wrapperHeight = wrapper.getBoundingClientRect().height;
        if (!Number.isFinite(wrapperHeight) || wrapperHeight <= 0) return;

        const styles = getComputedStyle(card);
        const verticalExtras = ['paddingTop', 'paddingBottom', 'borderTopWidth', 'borderBottomWidth']
            .reduce((sum, key) => sum + (parseFloat(styles[key]) || 0), 0);
        const minHeight = Math.ceil(wrapperHeight + verticalExtras);

        card.style.setProperty('height', 'auto', 'important');
        card.style.setProperty('min-height', minHeight + 'px', 'important');
        card.style.setProperty('max-height', 'none', 'important');
        card.style.setProperty('overflow', 'visible', 'important');
    };

    let cardFlowRaf = 0;
    const requestCardFlowHeightSync = () => {
        if (cardFlowRaf) window.cancelAnimationFrame(cardFlowRaf);
        cardFlowRaf = window.requestAnimationFrame(() => {
            cardFlowRaf = 0;
            syncCardFlowHeight();
        });
    };

    let top = wrapper?.querySelector('.vn-tbl-top-scroll');
    if (!top) {
        top = document.createElement('div');
        top.className = 'vn-tbl-top-scroll';
        top.setAttribute('aria-hidden', 'true');
        top.innerHTML = '<div class="vn-tbl-top-scroll-inner"></div>';
        wrapper?.insertBefore(top, scroller);
    }
    const syncTop = () => {
        const inner = top.querySelector('.vn-tbl-top-scroll-inner');
        if (inner) inner.style.width = table.scrollWidth + 'px';
        top.classList.toggle('is-visible', scroller.scrollWidth > scroller.clientWidth + 4);
        requestCardFlowHeightSync();
    };
    if (top.dataset.wired !== '1') {
        top.dataset.wired = '1';
        top.addEventListener('scroll', () => { scroller.scrollLeft = top.scrollLeft; applyPin(); }, { passive: true });
        scroller.addEventListener('scroll', () => { top.scrollLeft = scroller.scrollLeft; syncTop(); applyPin(); }, { passive: true });
    }

    applyPin();
    syncTop();
    requestCardFlowHeightSync();

    if ('ResizeObserver' in window && wrapper && card) {
        const cardFlowObserver = new ResizeObserver(requestCardFlowHeightSync);
        cardFlowObserver.observe(wrapper);
        cardFlowObserver.observe(scroller);
        cardFlowObserver.observe(table);
    }

    window.addEventListener('resize', () => { applyPin(); syncTop(); requestCardFlowHeightSync(); });

    window.__vnPropertiesTableMechanicsApi = {
        applyPin,
        applyPinLegacy,
        syncTop,
        syncCardFlowHeight,
        restoreWidths,
    };
})();
</script>
