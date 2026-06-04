/**
 * properties-report.js — viewer-new
 * Handles: column toggles, pagination text fix, rows-per-page selector,
 *          pagination light-mode theming, table-nav light-mode theming.
 */

(function () {
  'use strict';

  function qs(sel, ctx) { return (ctx || document).querySelector(sel); }
  function qsa(sel, ctx) { return Array.from((ctx || document).querySelectorAll(sel)); }

  /* ── Column toggles (owned here, not in app.js) ── */
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

  /* ══════════════════════════════════════════════════════════════
     1.  FIX "pagination.next" / "pagination.previous" raw text
         Laravel's built-in pagination outputs the translation key
         when the locale file is missing. Replace text with arrows.
     ══════════════════════════════════════════════════════════════ */
  function fixPaginationText() {
    var wrap = qs('.vn-pagination-wrap');
    if (!wrap) return;

    /* Find anchor / span elements whose visible text is the raw key */
    wrap.querySelectorAll('a, span, button').forEach(function (el) {
      var txt = (el.textContent || '').trim();
      if (txt === 'pagination.next') {
        /* Keep the element functional but show only an arrow */
        el.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="16" height="16" aria-hidden="true"><path fill-rule="evenodd" d="M12.293 4.293a1 1 0 011.414 0l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414-1.414L15.586 11H3a1 1 0 110-2h12.586l-3.293-3.293a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>';
        el.setAttribute('aria-label', 'الصفحة التالية');
        el.classList.add('vn-pg-arrow', 'vn-pg-next');
      } else if (txt === 'pagination.previous') {
        el.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="16" height="16" aria-hidden="true"><path fill-rule="evenodd" d="M7.707 4.293a1 1 0 010 1.414L4.414 9H17a1 1 0 110 2H4.414l3.293 3.293a1 1 0 01-1.414 1.414l-5-5a1 1 0 010-1.414l5-5a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>';
        el.setAttribute('aria-label', 'الصفحة السابقة');
        el.classList.add('vn-pg-arrow', 'vn-pg-prev');
      }
    });
  }

  /* ══════════════════════════════════════════════════════════════
     2.  ROWS-PER-PAGE CLIENT-SIDE SELECTOR
         Backend is hardcoded to 15; we slice rows client-side.
         Options ≤ 15 work fully; > 15 shows all available.
     ══════════════════════════════════════════════════════════════ */
  var PER_PAGE_KEY = 'vn_properties_per_page';

  function getStoredPerPage() {
    try { return parseInt(localStorage.getItem(PER_PAGE_KEY)) || 15; } catch (_) { return 15; }
  }
  function storePerPage(n) {
    try { localStorage.setItem(PER_PAGE_KEY, String(n)); } catch (_) {}
  }

  function buildRowsPerPageUI() {
    var paginationWrap = qs('.vn-pagination-wrap');
    if (!paginationWrap) return;

    /* Build the selector */
    var selectorHtml = [
      '<div class="vn-rows-per-page" id="vn-rows-per-page-wrap">',
        '<label class="vn-rows-per-page__label" for="vn-per-page-select">عدد الصفوف:</label>',
        '<select class="vn-rows-per-page__select" id="vn-per-page-select" aria-label="عدد الصفوف في الصفحة">',
          '<option value="5">5</option>',
          '<option value="10">10</option>',
          '<option value="15">15</option>',
          '<option value="25">25</option>',
          '<option value="50">50</option>',
        '</select>',
      '</div>',
    ].join('');

    /* Inject before the pagination wrap */
    var container = paginationWrap.parentElement;
    var rowsWrap  = document.createElement('div');
    rowsWrap.className = 'vn-pagination-toolbar';
    rowsWrap.innerHTML = selectorHtml;
    container.insertBefore(rowsWrap, paginationWrap);

    /* Set stored value */
    var select = document.getElementById('vn-per-page-select');
    if (!select) return;

    var stored = getStoredPerPage();
    select.value = String(stored);
    applyRowsPerPage(stored);

    select.addEventListener('change', function () {
      var n = parseInt(this.value) || 15;
      storePerPage(n);
      applyRowsPerPage(n);
    });
  }

  function applyRowsPerPage(n) {
    if (!propertiesTable) return;

    /* Get all main data rows (not child-expand rows) */
    var allRows = qsa('tbody > tr', propertiesTable).filter(function (row) {
      return !row.hasAttribute('data-property-operations-row')
          && !row.hasAttribute('data-property-signals-row')
          && !row.hasAttribute('data-property-files-row')
          && !row.hasAttribute('data-property-installments-row')
          && !row.hasAttribute('data-property-notes-row')
          && row.querySelector('td[data-column-key]');
    });

    var total = allRows.length;
    var perPage = n > total ? total : n;  /* can't show more than we have */

    allRows.forEach(function (row, i) {
      var shouldShow = i < perPage;
      row.style.display = shouldShow ? '' : 'none';
      /* Also hide any related child rows after this row */
      var next = row.nextElementSibling;
      while (next && (
        next.hasAttribute('data-property-operations-row') ||
        next.hasAttribute('data-property-signals-row')    ||
        next.hasAttribute('data-property-files-row')      ||
        next.hasAttribute('data-property-installments-row')||
        next.hasAttribute('data-property-notes-row')
      )) {
        next.style.display = shouldShow ? next.style.display : 'none';
        next = next.nextElementSibling;
      }
    });

    /* Update the counter text in summary if present */
    updateShownCount(Math.min(perPage, total), total);

    /* Notify app.js to sync nav pill visibility */
    if (typeof window.updateTblNavPill === 'function') window.updateTblNavPill();
  }

  function updateShownCount(shown, total) {
    /* Update "Showing X to Y of Z results" in the pagination area */
    var wrap = qs('.vn-pagination-wrap');
    if (!wrap) return;
    var countEl = qs('.vn-pg-client-count');
    if (!countEl) {
      countEl = document.createElement('p');
      countEl.className = 'vn-pg-client-count';
      wrap.insertBefore(countEl, wrap.firstChild);
    }
    countEl.textContent = 'يُعرض ' + shown + ' من ' + total + ' نتيجة في هذه الصفحة';
  }

  /* ══════════════════════════════════════════════════════════════
     3.  PAGINATION CONTAINER THEME (light-mode dark bg fix done
         via CSS in quick-settings.css, see § PAGINATION section)
     ══════════════════════════════════════════════════════════════ */

  /* ── Init ── */
  fixPaginationText();
  buildRowsPerPageUI();

  window.__vnPropertiesReportReady = true;
})();
