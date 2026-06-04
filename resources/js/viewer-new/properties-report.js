/**
 * properties-report.js — viewer-new
 * Unified footer row: nav pill + rows-per-page + pagination in one line.
 */

(function () {
  'use strict';

  function qs(sel, ctx)  { return (ctx || document).querySelector(sel); }
  function qsa(sel, ctx) { return Array.from((ctx || document).querySelectorAll(sel)); }

  /* ── Column toggles ── */
  var propertiesTable = document.getElementById('vn-properties-table');
  var columnToggles   = qsa('[data-column-toggle]');

  function setColumnVisibility(key, visible) {
    if (!propertiesTable) return;
    qsa('[data-column-key="' + key + '"]', propertiesTable).forEach(function (el) {
      el.style.display = visible ? '' : 'none';
    });
    var colEl = propertiesTable.querySelector('col[data-col-key="' + key + '"]');
    if (colEl) colEl.style.visibility = visible ? '' : 'collapse';
  }

  columnToggles.forEach(function (cb) {
    cb.addEventListener('change', function () { setColumnVisibility(cb.value, cb.checked); });
  });

  var resetColsBtn = qs('[data-reset-columns]');
  if (resetColsBtn) {
    resetColsBtn.addEventListener('click', function () {
      columnToggles.forEach(function (cb) { cb.checked = true; setColumnVisibility(cb.value, true); });
    });
  }

  /* ══════════════════════════════════════════════════════════════════
     UNIFIED FOOTER — single flex row with all pagination elements
     ══════════════════════════════════════════════════════════════════ */

  var PER_PAGE_KEY = 'vn_properties_per_page';

  function getStoredPerPage() {
    try { return parseInt(localStorage.getItem(PER_PAGE_KEY)) || 15; } catch (_) { return 15; }
  }
  function storePerPage(n) {
    try { localStorage.setItem(PER_PAGE_KEY, String(n)); } catch (_) {}
  }

  /* ── 1. Fix pagination.next / pagination.previous raw text keys ──
     HIDE them — the > < arrows in the numbered pagination are enough */
  function fixPaginationText(container) {
    (container || document).querySelectorAll('a, span, button').forEach(function (el) {
      var txt = (el.textContent || '').trim();
      if (txt === 'pagination.next' || txt === 'pagination.previous') {
        el.style.display = 'none';
        el.setAttribute('aria-hidden', 'true');
      }
    });
  }

  /* ── 2. Rows per page (client-side) ── */
  function applyRowsPerPage(n, countEl) {
    if (!propertiesTable) return;
    var allRows = qsa('tbody > tr', propertiesTable).filter(function (row) {
      return !row.hasAttribute('data-property-operations-row')
          && !row.hasAttribute('data-property-signals-row')
          && !row.hasAttribute('data-property-files-row')
          && !row.hasAttribute('data-property-installments-row')
          && !row.hasAttribute('data-property-notes-row')
          && row.querySelector('td[data-column-key]');
    });

    var total   = allRows.length;
    var perPage = n > total ? total : n;

    allRows.forEach(function (row, i) {
      var show = i < perPage;
      row.style.display = show ? '' : 'none';
      /* hide/restore associated child-expand rows */
      var next = row.nextElementSibling;
      while (next && (
        next.hasAttribute('data-property-operations-row')  ||
        next.hasAttribute('data-property-signals-row')     ||
        next.hasAttribute('data-property-files-row')       ||
        next.hasAttribute('data-property-installments-row')||
        next.hasAttribute('data-property-notes-row')
      )) {
        if (!show) next.style.display = 'none';
        next = next.nextElementSibling;
      }
    });

    if (countEl) {
      countEl.textContent = 'يُعرض ' + Math.min(perPage, total) + ' من ' + total + ' نتيجة';
    }
    if (typeof window.updateTblNavPill === 'function') window.updateTblNavPill();
  }

  /* ── 3. Build the unified footer ── */
  function buildUnifiedFooter() {
    var paginationWrap = qs('.vn-properties-report .vn-pagination-wrap');
    if (!paginationWrap) return;

    /* ─ Hide the existing floating nav pill (we replicate its buttons in-footer) ─ */
    var floatingPill = qs('.vn-properties-report .vn-tbl-nav-pill');
    if (floatingPill) floatingPill.style.display = 'none';

    /* ─ Remove my old toolbar if it already exists from a previous run ─ */
    var oldBar = qs('.vn-prop-footer');
    if (oldBar) oldBar.remove();

    /* ─ Build footer wrapper ─ */
    var footer = document.createElement('div');
    footer.className = 'vn-prop-footer';

    /* Section 1: nav buttons (بداية / نهاية الجدول) */
    var navInner = document.createElement('div');
    navInner.className = 'vn-tbl-nav-pill-inner vn-prop-footer__nav';

    var btnStart = document.createElement('button');
    btnStart.type = 'button';
    btnStart.className = 'vn-tbl-nav-pill-btn';
    btnStart.setAttribute('aria-label', 'بداية الجدول');
    btnStart.innerHTML = '<svg width="12" height="12" viewBox="0 0 12 12" fill="currentColor" aria-hidden="true"><path d="M10 1l-5 5 5 5"/><path d="M5 1l-5 5 5 5" opacity=".45"/></svg> بداية الجدول';
    btnStart.addEventListener('click', function () {
      var scroller = qs('.vn-properties-report .vn-properties-table');
      if (scroller) scroller.scrollBy({ left: 999999, behavior: 'smooth' });
    });

    var sep = document.createElement('div');
    sep.className = 'vn-tbl-nav-pill-sep';
    sep.setAttribute('aria-hidden', 'true');

    var btnEnd = document.createElement('button');
    btnEnd.type = 'button';
    btnEnd.className = 'vn-tbl-nav-pill-btn';
    btnEnd.setAttribute('aria-label', 'نهاية الجدول');
    btnEnd.innerHTML = 'نهاية الجدول <svg width="12" height="12" viewBox="0 0 12 12" fill="currentColor" aria-hidden="true"><path d="M2 1l5 5-5 5"/><path d="M7 1l5 5-5 5" opacity=".45"/></svg>';
    btnEnd.addEventListener('click', function () {
      var scroller = qs('.vn-properties-report .vn-properties-table');
      if (scroller) scroller.scrollBy({ left: -999999, behavior: 'smooth' });
    });

    navInner.append(btnStart, sep, btnEnd);

    /* Section 2: rows-per-page selector */
    var rowsGroup = document.createElement('div');
    rowsGroup.className = 'vn-rows-per-page';

    var label = document.createElement('label');
    label.className = 'vn-rows-per-page__label';
    label.htmlFor = 'vn-per-page-select';
    label.textContent = 'عدد الصفوف:';

    var select = document.createElement('select');
    select.className = 'vn-rows-per-page__select';
    select.id = 'vn-per-page-select';
    select.setAttribute('aria-label', 'عدد الصفوف في الصفحة');
    [5, 10, 15, 25, 50].forEach(function (n) {
      var opt = document.createElement('option');
      opt.value = String(n);
      opt.textContent = String(n);
      select.appendChild(opt);
    });

    /* Section 3: count text */
    var countEl = document.createElement('span');
    countEl.className = 'vn-pg-client-count';

    rowsGroup.append(label, select, countEl);

    /* Section 4: pagination numbers (move existing nav from paginationWrap) */
    var pager = document.createElement('div');
    pager.className = 'vn-prop-footer__pager';
    while (paginationWrap.firstChild) {
      pager.appendChild(paginationWrap.firstChild);
    }
    fixPaginationText(pager);   /* hide raw key text */

    /* Assemble all sections into footer */
    footer.append(navInner, rowsGroup, pager);

    /* Put the footer inside the now-empty pagination wrap */
    paginationWrap.appendChild(footer);

    /* ─ Wire rows-per-page select ─ */
    var stored = getStoredPerPage();
    select.value = String(stored);
    applyRowsPerPage(stored, countEl);

    select.addEventListener('change', function () {
      var n = parseInt(this.value) || 15;
      storePerPage(n);
      applyRowsPerPage(n, countEl);
    });
  }

  buildUnifiedFooter();

  window.__vnPropertiesReportReady = true;
})();
