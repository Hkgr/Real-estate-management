/**
 * properties-report.js
 * Viewer-New · جدول تقرير العقارات
 * Interactive mechanics for: resources/views/viewer-new/reports/properties.blade.php
 *
 * NOTE: Column resize, pin, and floating-header logic may already be handled
 * by viewer-new.partials.properties-table-mechanics — check before including
 * the resize/pin sections below to avoid duplication.
 *
 * Place at: public/js/viewer-new/properties-report.js
 * Load via: @push('scripts') at the bottom of the layout, AFTER the DOM is ready.
 */

(function () {
  'use strict';

  function qs(sel, ctx) { return (ctx || document).querySelector(sel); }
  function qsa(sel, ctx) { return Array.from((ctx || document).querySelectorAll(sel)); }

  /* Generator toggle, fullscreen, and search clear are owned by app.js — do not duplicate here. */

  var propertiesTable = document.getElementById('vn-properties-table');
  var columnToggles   = qsa('[data-column-toggle]');

  function setColumnVisibility(key, visible) {
    if (!propertiesTable) return;
    qsa('[data-column-key="' + key + '"]', propertiesTable).forEach(function (el) {
      el.style.display = visible ? '' : 'none';
    });
    qsa('[data-col-key="' + key + '"]', propertiesTable).forEach(function (el) {
      el.style.display = visible ? '' : 'none';
    });
    var colEl = propertiesTable.querySelector('col[data-col-key="' + key + '"]');
    if (colEl) colEl.style.visibility = visible ? '' : 'collapse';
  }

  columnToggles.forEach(function (checkbox) {
    checkbox.addEventListener('change', function () {
      setColumnVisibility(checkbox.value, checkbox.checked);
    });
  });

  var resetColsBtn = qs('[data-reset-columns]');
  if (resetColsBtn) {
    resetColsBtn.addEventListener('click', function () {
      columnToggles.forEach(function (checkbox) {
        checkbox.checked = true;
        setColumnVisibility(checkbox.value, true);
      });
    });
  }

  /* Child row expand (عمليات / إشارات / ملفات / دفعات) is owned by app.js — do not duplicate here. */

  window.__vnPropertiesReportReady = true;
})();
