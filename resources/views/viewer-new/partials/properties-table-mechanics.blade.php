{{-- Table pin/resize/top-scroll — always loaded (Vite bundle may lag). Matches FRONT/index.html. --}}
@php $propertiesTableMechanicsVersion = '7'; @endphp
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

    let pinned = [];
    try { pinned = JSON.parse(localStorage.getItem(PIN_KEY) || '[]') || []; } catch (_) { pinned = []; }

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

    const applyPin = () => {
        table.classList.remove('vn-has-pinned-cols', 'has-pinned-cols');
        table.querySelectorAll('.vn-col-pinned,.vn-col-pin-edge,.col-pinned,.col-pin-edge').forEach((el) => {
            el.classList.remove('vn-col-pinned', 'vn-col-pin-edge', 'col-pinned', 'col-pin-edge');
            el.style.removeProperty('right');
            el.style.removeProperty('inset-inline-end');
            el.style.removeProperty('left');
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
        let off = 0;
        visible.forEach((k) => {
            const th = table.querySelector('thead th.' + colClass(k));
            const w = th ? th.offsetWidth : 100;
            table.querySelectorAll('th.' + colClass(k) + ',td.' + colClass(k)).forEach((el) => {
                if (getComputedStyle(el).display === 'none') return;
                el.classList.add('vn-col-pinned', 'col-pinned');
                el.style.insetInlineEnd = off + 'px';
                el.style.right = off + 'px';
                el.style.left = 'auto';
            });
            const btn = th?.querySelector('.vn-col-pin-btn');
            if (btn) {
                btn.classList.add('active');
                btn.title = 'إلغاء التثبيت';
                btn.setAttribute('aria-pressed', 'true');
            }
            off += w;
        });
        const last = visible[visible.length - 1];
        table.querySelectorAll('th.' + colClass(last) + ',td.' + colClass(last)).forEach((el) => {
            if (el.classList.contains('vn-col-pinned')) el.classList.add('vn-col-pin-edge', 'col-pin-edge');
        });
        pinBar?.classList.add('is-visible');
        const cnt = report.querySelector('[data-properties-pin-count]');
        if (cnt) cnt.textContent = visible.length + ' مثبت';
    };

    table.querySelectorAll('[data-column-key]').forEach((el) => {
        const key = el.getAttribute('data-column-key');
        if (key && !el.classList.contains(colClass(key))) el.classList.add(colClass(key));
    });

    restoreWidths();

    const togglePin = (key) => {
        if (!key) return;
        const i = pinned.indexOf(key);
        if (i === -1) pinned.push(key);
        else pinned.splice(i, 1);
        try { localStorage.setItem(PIN_KEY, JSON.stringify(pinned)); } catch (_) {}
        applyPin();
    };

    table.querySelectorAll('[data-col-pin]').forEach((btn) => {
        if (btn.dataset.pinBound === '1') return;
        btn.dataset.pinBound = '1';
        btn.addEventListener('click', (e) => {
            e.stopPropagation();
            e.preventDefault();
            togglePin(btn.getAttribute('data-col-pin'));
        });
    });

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

    report.querySelector('[data-properties-unpin-all]')?.addEventListener('click', (e) => {
        e.preventDefault();
        pinned = [];
        try { localStorage.setItem(PIN_KEY, '[]'); } catch (_) {}
        applyPin();
    });

    let top = scroller.parentElement?.querySelector('.vn-tbl-top-scroll');
    if (!top) {
        top = document.createElement('div');
        top.className = 'vn-tbl-top-scroll';
        top.setAttribute('aria-hidden', 'true');
        top.innerHTML = '<div class="vn-tbl-top-scroll-inner"></div>';
        scroller.parentElement?.insertBefore(top, scroller);
    }
    const syncTop = () => {
        const inner = top.querySelector('.vn-tbl-top-scroll-inner');
        if (inner) inner.style.width = table.scrollWidth + 'px';
        top.classList.toggle('is-visible', scroller.scrollWidth > scroller.clientWidth + 4);
    };
    if (top.dataset.wired !== '1') {
        top.dataset.wired = '1';
        top.addEventListener('scroll', () => { scroller.scrollLeft = top.scrollLeft; applyPin(); }, { passive: true });
        scroller.addEventListener('scroll', () => { top.scrollLeft = scroller.scrollLeft; syncTop(); applyPin(); }, { passive: true });
    }

    applyPin();
    syncTop();
    window.addEventListener('resize', () => { applyPin(); syncTop(); });

    window.__vnPropertiesTableMechanicsApi = { applyPin, syncTop, restoreWidths };
})();
</script>
