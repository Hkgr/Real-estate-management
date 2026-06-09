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
        const COL_ORDER_KEY = 'viewer_new_properties_column_order';
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
        const searchToggleBtn = reportRoot.querySelector('[data-properties-search-toggle]');
        const searchWrapper = reportRoot.querySelector('[data-properties-search-wrapper]');
        const searchInput = reportRoot.querySelector('#filter-q');
        const genBtn = reportRoot.querySelector('[data-generate-report]');
        const resetBtn = reportRoot.querySelector('[data-reset-columns]');
        const columnsMenu = reportRoot.querySelector('[data-report-columns-menu]');
        const columnsToggleBtn = reportRoot.querySelector('[data-report-columns-toggle]');
        const columnsPopover = reportRoot.querySelector('[data-report-columns-popover]');
        const columnOrderToggleBtn = reportRoot.querySelector('[data-column-order-toggle]');
        const columnReorderHint = reportRoot.querySelector('[data-column-reorder-hint]');
        const rowSelectionToggleBtn = reportRoot.querySelector('[data-row-selection-toggle]');
        const rowSelectionCountEl = reportRoot.querySelector('[data-row-selection-count]');
        const checkboxes = [...reportRoot.querySelectorAll('[data-column-toggle]')];
        const tableEl = reportRoot.querySelector('.vn-properties-table table');
        const tableScroller = reportRoot.querySelector('.vn-properties-table');
        const toolbarEl = reportRoot.querySelector('.vn-report-toolbar');
        const fullscreenBtn = reportRoot.querySelector('[data-properties-fullscreen]');
        const exportMenuRoot = reportRoot.querySelector('[data-export-menu-root]');
        const exportToggleBtn = reportRoot.querySelector('[data-export-toggle]');
        const exportMenu = reportRoot.querySelector('[data-export-menu]');
        const exportExcelBtn = reportRoot.querySelector('[data-export-excel]');
        const exportPdfBtn = reportRoot.querySelector('[data-export-pdf]');

        const safeGet = (k) => { try { return localStorage.getItem(k); } catch (_) { return null; } };
        const safeSet = (k, v) => { try { localStorage.setItem(k, v); } catch (_) {} };
        const hasActiveFilters = reportRoot.querySelectorAll('.vn-active-filter-chip').length > 0;

        let floatingHost = null;
        let floatingTable = null;
        let floatingRaf = 0;
        let tblNavPill = null;
        let tableAdvancedApi = null;
        let stickyTopProbe = null;

        const getStickyHeadTop = () => {
            if (!stickyTopProbe) {
                stickyTopProbe = document.createElement('span');
                stickyTopProbe.setAttribute('aria-hidden', 'true');
                stickyTopProbe.style.cssText = 'position:fixed;top:var(--vn-properties-sticky-head-top);width:0;height:0;overflow:hidden;visibility:hidden;pointer-events:none;';
                reportRoot.appendChild(stickyTopProbe);
            }

            const resolvedTop = Number.parseFloat(getComputedStyle(stickyTopProbe).top);
            return Number.isFinite(resolvedTop) ? Math.max(0, resolvedTop) : 64;
        };

        const setExportMenuOpen = (open) => {
            if (!exportMenu || !exportToggleBtn || !exportMenuRoot) return;
            const isOpen = !!open;
            exportMenu.hidden = !isOpen;
            exportMenu.classList.toggle('is-open', isOpen);
            exportMenuRoot.classList.toggle('vn-report-export-menu--open', isOpen);
            exportToggleBtn.classList.toggle('vn-report-toolbar-button--active', isOpen);
            exportToggleBtn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        };

        const isExportMenuOpen = () => exportMenu?.hidden === false;

        const normalizeExcelText = (value) => String(value ?? '')
            .replace(/[\u0000-\u0008\u000B\u000C\u000E-\u001F\u007F]/g, '')
            .trim();

        const getClientExportFilename = () => `properties-report-${new Date().toISOString().slice(0, 10)}.xlsx`;

        const downloadBlob = (blob, filename) => {
            const url = URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.href = url;
            link.download = filename;
            document.body.appendChild(link);
            link.click();
            link.remove();
            window.setTimeout(() => URL.revokeObjectURL(url), 1000);
        };

        const estimateExcelColumnWidth = (header, values) => {
            const textLengths = [header, ...values].map((value) => normalizeExcelText(value).length);
            const maxLength = Math.max(8, ...textLengths);
            return Math.min(44, Math.max(12, Math.ceil(maxLength * 1.15) + 2));
        };

        const loadExcelJs = async () => {
            const ExcelJSModule = await import('exceljs');
            return ExcelJSModule.default || ExcelJSModule;
        };

        const downloadExcelXlsx = async (exportData) => {
            const filename = getClientExportFilename();
            const headerRowNumber = 5;
            const firstDataRowNumber = headerRowNumber + 1;
            const columnCount = exportData.columns.length;
            const generatedAt = new Date();
            const thinBorder = { style: 'thin', color: { argb: 'FFE5E7EB' } };
            const headerBorder = { style: 'thin', color: { argb: 'FFD6B85A' } };

            try {
                const ExcelJS = await loadExcelJs();
                const workbook = new ExcelJS.Workbook();
                workbook.creator = 'Viewer New Properties Report';
                workbook.created = generatedAt;
                workbook.modified = generatedAt;

                const worksheet = workbook.addWorksheet('تقرير العقارات', {
                    views: [{ rightToLeft: true, state: 'frozen', ySplit: headerRowNumber }],
                    properties: { defaultRowHeight: 24 },
                });
                worksheet.views = [{ rightToLeft: true, state: 'frozen', ySplit: headerRowNumber }];

                if (columnCount > 1) {
                    worksheet.mergeCells(1, 1, 1, columnCount);
                    worksheet.mergeCells(2, 1, 2, columnCount);
                    worksheet.mergeCells(3, 1, 3, columnCount);
                }

                worksheet.getCell(1, 1).value = 'تقرير العقارات';
                worksheet.getCell(2, 1).value = `تاريخ الإنشاء: ${generatedAt.toLocaleString('ar')}`;
                worksheet.getCell(3, 1).value = `عدد الصفوف: ${exportData.rows.length}`;

                [1, 2, 3, 4].forEach((rowNumber) => {
                    const row = worksheet.getRow(rowNumber);
                    row.height = rowNumber === 1 ? 30 : 24;
                    for (let columnIndex = 1; columnIndex <= columnCount; columnIndex += 1) {
                        const cell = row.getCell(columnIndex);
                        cell.font = { name: 'Arial', bold: rowNumber === 1, size: rowNumber === 1 ? 16 : 11, color: { argb: rowNumber === 1 ? 'FF1F2937' : 'FF4B5563' } };
                        cell.alignment = { vertical: 'middle', horizontal: rowNumber === 1 ? 'center' : 'right', readingOrder: 'rtl', wrapText: true };
                        cell.fill = { type: 'pattern', pattern: 'solid', fgColor: { argb: rowNumber === 1 ? 'FFF8E7B0' : 'FFFFFBEB' } };
                        cell.numFmt = '@';
                    }
                });

                const headerRow = worksheet.getRow(headerRowNumber);
                headerRow.height = 30;
                exportData.columns.forEach(({ header }, index) => {
                    const cell = headerRow.getCell(index + 1);
                    cell.value = normalizeExcelText(header);
                    cell.font = { name: 'Arial', bold: true, color: { argb: 'FFFFFFFF' } };
                    cell.fill = { type: 'pattern', pattern: 'solid', fgColor: { argb: 'FF7C5A12' } };
                    cell.alignment = { vertical: 'middle', horizontal: 'center', readingOrder: 'rtl', wrapText: true };
                    cell.border = { top: headerBorder, right: headerBorder, bottom: headerBorder, left: headerBorder };
                    cell.numFmt = '@';
                });

                exportData.rows.forEach((exportRow, rowIndex) => {
                    const worksheetRow = worksheet.getRow(firstDataRowNumber + rowIndex);
                    worksheetRow.height = 24;
                    exportData.columns.forEach((_, columnIndex) => {
                        const cell = worksheetRow.getCell(columnIndex + 1);
                        cell.value = normalizeExcelText(exportRow.values[columnIndex]);
                        cell.font = { name: 'Arial', color: { argb: 'FF111827' } };
                        cell.alignment = { vertical: 'middle', horizontal: 'right', readingOrder: 'rtl', wrapText: true };
                        cell.border = { top: thinBorder, right: thinBorder, bottom: thinBorder, left: thinBorder };
                        cell.numFmt = '@';
                        if (rowIndex % 2 === 1) {
                            cell.fill = { type: 'pattern', pattern: 'solid', fgColor: { argb: 'FFFFF8E1' } };
                        }
                    });
                    worksheetRow.commit?.();
                });

                exportData.columns.forEach(({ header }, columnIndex) => {
                    const values = exportData.rows.map((row) => row.values[columnIndex]);
                    worksheet.getColumn(columnIndex + 1).width = estimateExcelColumnWidth(header, values);
                });

                worksheet.autoFilter = {
                    from: { row: headerRowNumber, column: 1 },
                    to: { row: headerRowNumber, column: columnCount },
                };

                const buffer = await workbook.xlsx.writeBuffer();
                const blob = new Blob([buffer], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
                downloadBlob(blob, filename);
                console.info('[viewer-new properties export]', {
                    filename,
                    format: 'xlsx-client',
                    mimeType: blob.type,
                    mode: exportData.selectedOnly ? 'selected-rows' : 'visible-rows',
                    selectedOnly: exportData.selectedOnly,
                    selectedRowIds: exportData.selectedRowIds,
                    visibleColumnKeys: exportData.columns.map(({ key }) => key),
                    rowCount: exportData.rows.length,
                });
            } catch (error) {
                console.error('[viewer-new properties export] فشل إنشاء ملف Excel داخل المتصفح', error);
                window.alert('تعذر إنشاء ملف Excel داخل المتصفح. يرجى تحديث الصفحة والمحاولة مرة أخرى.');
            }
        };

        const escapeHtml = (value) => normalizeExcelText(value)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');

        const buildPropertiesPdfHtml = (exportData) => {
            const generatedAt = new Date();
            const exportMode = exportData.selectedOnly ? 'الصفوف المحددة' : 'الصفوف الظاهرة';
            const headerCells = exportData.columns
                .map(({ header }) => `<th scope="col">${escapeHtml(header)}</th>`)
                .join('');
            const bodyRows = exportData.rows
                .map((row) => `<tr>${exportData.columns.map((_, index) => `<td>${escapeHtml(row.values[index])}</td>`).join('')}</tr>`)
                .join('');

            return `<!doctype html>
<html lang="ar" dir="rtl">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>تقرير العقارات</title>
<style>
@page { size: A4 landscape; margin: 12mm; }
* { box-sizing: border-box; }
html, body { direction: rtl; background: #fff; color: #111827; font-family: Arial, Tahoma, sans-serif; }
body { margin: 0; font-size: 12px; line-height: 1.55; }
.report-shell { width: 100%; }
.report-header { border-bottom: 3px solid #7C5A12; margin-bottom: 14px; padding-bottom: 10px; }
h1 { margin: 0 0 8px; color: #1f2937; font-size: 24px; font-weight: 800; }
.report-meta { display: flex; flex-wrap: wrap; gap: 8px; margin: 0; padding: 0; list-style: none; color: #374151; }
.report-meta li { border: 1px solid #ead89b; background: #fffbeb; border-radius: 8px; padding: 5px 9px; }
.table-wrap { width: 100%; overflow: visible; }
table { width: 100%; border-collapse: collapse; table-layout: auto; }
th, td { border: 1px solid #d6d6d6; padding: 6px 8px; text-align: right; vertical-align: top; white-space: pre-wrap; word-break: break-word; overflow-wrap: anywhere; }
thead th { background: #7C5A12; color: #fff; font-weight: 700; text-align: center; vertical-align: middle; }
tbody tr:nth-child(even) td { background: #fff8e1; }
tbody tr:nth-child(odd) td { background: #fff; }
.print-hint { margin-top: 12px; color: #6b7280; font-size: 10px; }
@media print {
  body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
  .report-header { break-after: avoid; }
  thead { display: table-header-group; }
  tr { break-inside: avoid; page-break-inside: avoid; }
  .print-hint { display: none; }
}
</style>
</head>
<body>
  <main class="report-shell">
    <header class="report-header">
      <h1>تقرير العقارات</h1>
      <ul class="report-meta">
        <li>تاريخ الإنشاء: ${escapeHtml(generatedAt.toLocaleString('ar'))}</li>
        <li>عدد الصفوف: ${escapeHtml(exportData.rows.length)}</li>
        <li>نطاق التصدير: ${escapeHtml(exportMode)}</li>
      </ul>
    </header>
    <section class="table-wrap" aria-label="تقرير العقارات">
      <table>
        <thead><tr>${headerCells}</tr></thead>
        <tbody>${bodyRows}</tbody>
      </table>
    </section>
    <p class="print-hint">يمكن حفظ هذا التقرير كملف PDF من نافذة الطباعة في المتصفح.</p>
  </main>
</body>
</html>`;
        };

        const printPropertiesPdf = (exportData) => {
            const printWindow = window.open('', '_blank', 'width=1280,height=900,scrollbars=yes,resizable=yes');
            if (!printWindow) {
                window.alert('تعذر فتح نافذة الطباعة. يرجى السماح بالنوافذ المنبثقة ثم المحاولة مرة أخرى.');
                return;
            }

            const html = buildPropertiesPdfHtml(exportData);
            printWindow.document.open();
            printWindow.document.write(html);
            printWindow.document.close();
            printWindow.focus();
            window.setTimeout(() => {
                try {
                    printWindow.focus();
                    printWindow.print();
                } catch (error) {
                    console.error('[viewer-new properties export] فشل فتح نافذة طباعة PDF', error);
                    window.alert('تعذر فتح نافذة الطباعة. يرجى المحاولة مرة أخرى.');
                }
            }, 350);

            console.info('[viewer-new properties export]', {
                format: 'pdf-print-client',
                mode: exportData.selectedOnly ? 'selected-rows' : 'visible-rows',
                selectedOnly: exportData.selectedOnly,
                selectedRowIds: exportData.selectedRowIds,
                visibleColumnKeys: exportData.columns.map(({ key }) => key),
                rowCount: exportData.rows.length,
            });
        };

        const exportPropertiesExcel = () => {
            const exportData = tableAdvancedApi?.getExportRows?.();
            if (!exportData || exportData.rows.length === 0 || exportData.columns.length === 0) {
                window.alert('لا توجد صفوف قابلة للتصدير');
                console.info('[viewer-new properties export] لا توجد صفوف قابلة للتصدير', exportData || null);
                return;
            }
            downloadExcelXlsx(exportData);
        };

        const exportPropertiesPdf = () => {
            const exportData = tableAdvancedApi?.getExportRows?.();
            if (!exportData || exportData.rows.length === 0 || exportData.columns.length === 0) {
                window.alert('لا توجد صفوف قابلة للتصدير');
                console.info('[viewer-new properties export] لا توجد صفوف قابلة للتصدير', exportData || null);
                return;
            }
            printPropertiesPdf(exportData);
        };

        const setColumnsPopoverOpen = (open) => {
            if (!columnsPopover || !columnsToggleBtn) return;
            const isOpen = !!open;
            columnsPopover.classList.toggle('vn-report-columns-popover--open', isOpen);
            columnsMenu?.classList.toggle('vn-report-columns-menu--open', isOpen);
            panel?.classList.toggle('vn-report-generator--columns-open', isOpen);
            columnsToggleBtn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        };

        const isColumnsPopoverOpen = () => columnsPopover?.classList.contains('vn-report-columns-popover--open') === true;

        const setColumnReorderMode = (enabled) => {
            const active = !!enabled;
            reportRoot.classList.toggle('vn-properties-report--column-reorder', active);
            document.body.classList.toggle('vn-properties-report-column-reorder', active);
            columnOrderToggleBtn?.classList.toggle('vn-report-toolbar-button--active', active);
            columnOrderToggleBtn?.setAttribute('aria-pressed', active ? 'true' : 'false');
            if (columnReorderHint) columnReorderHint.hidden = !active;
            tableAdvancedApi?.enableColumnReorderMode?.(active);
            if (active) setColumnsPopoverOpen(false);
            requestAnimationFrame(updateStickyOffset);
        };

        const isColumnReorderMode = () => reportRoot.classList.contains('vn-properties-report--column-reorder');

        const updateRowSelectionCount = (count = 0) => {
            if (!rowSelectionCountEl) return;
            rowSelectionCountEl.textContent = `المحدد: ${count}`;
        };

        const setRowSelectionMode = (enabled) => {
            const active = !!enabled;
            reportRoot.classList.toggle('vn-properties-report--row-selection', active);
            rowSelectionToggleBtn?.classList.toggle('vn-report-toolbar-button--active', active);
            rowSelectionToggleBtn?.setAttribute('aria-pressed', active ? 'true' : 'false');
            if (rowSelectionCountEl) rowSelectionCountEl.hidden = !active;
            tableAdvancedApi?.enableRowSelectionMode?.(active);
            if (!active) updateRowSelectionCount(0);
            requestAnimationFrame(updateStickyOffset);
        };

        const isRowSelectionMode = () => reportRoot.classList.contains('vn-properties-report--row-selection');

        const syncToolbarActiveState = (open) => {
            toggleBtn?.classList.toggle('vn-report-toolbar-button--active', !!open);
            toggleBtn?.classList.toggle('vn-report-toolbar-button--primary', !!open);
        };

        const setPanelOpen = (open, persist = true) => {
            if (!panel) return;
            panel.classList.toggle('is-open', !!open);
            if (!open) {
                setColumnsPopoverOpen(false);
                setColumnReorderMode(false);
                setRowSelectionMode(false);
            }
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
        const normalizeColumnOrder = (columns) => {
            const input = Array.isArray(columns) ? columns : [];
            const filtered = [...new Set(input.filter((key) => validColumnKeys.includes(key)))];
            defaultColumns.forEach((key) => { if (!filtered.includes(key)) filtered.push(key); });
            return filtered;
        };

        const applyColumnOrder = (columns, persist = true) => {
            const order = normalizeColumnOrder(columns);
            const applied = tableAdvancedApi?.applyColumnOrder?.(order) || order;
            if (persist) safeSet(COL_ORDER_KEY, JSON.stringify(applied));
            requestFloatingHeadSync();
            updateTblNavPill();
            return applied;
        };

        const normalizeColumns = (columns) => {
            const input = Array.isArray(columns) ? columns : [];
            const filtered = [...new Set(input.filter((key) => validColumnKeys.includes(key)))];
            const hasDataColumn = filtered.some((key) => key !== 'actions');
            return hasDataColumn ? filtered : defaultColumns;
        };

        const orderFromStorage = (() => {
            try {
                return normalizeColumnOrder(JSON.parse(safeGet(COL_ORDER_KEY) || 'null'));
            } catch (_) {
                return defaultColumns;
            }
        })();
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
        const initialSearchOpen = toolbarEl?.classList.contains('vn-report-toolbar--search-open') || (searchInput?.value || '').trim() !== '';

        const setSearchOpen = (open, focus = false) => {
            if (!toolbarEl || !searchInput) return;
            const isOpen = !!open;
            toolbarEl.classList.toggle('vn-report-toolbar--search-open', isOpen);
            searchWrapper?.classList.toggle('active', isOpen);
            searchToggleBtn?.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            searchInput.disabled = !isOpen;
            if (focus && isOpen) {
                window.requestAnimationFrame(() => {
                    searchInput.focus({ preventScroll: true });
                    searchInput.select();
                });
            }
        };

        setSearchOpen(initialSearchOpen, false);

        searchToggleBtn?.addEventListener('click', () => {
            const isOpen = toolbarEl?.classList.contains('vn-report-toolbar--search-open');
            setSearchOpen(!isOpen, true);
        });

        toggleBtn?.addEventListener('click', () => {
            setPanelOpen(!panel?.classList.contains('is-open'));
        });
        exportToggleBtn?.addEventListener('click', () => {
            setExportMenuOpen(!isExportMenuOpen());
            setColumnsPopoverOpen(false);
        });
        exportExcelBtn?.addEventListener('click', () => {
            setExportMenuOpen(false);
            exportPropertiesExcel();
        });
        exportPdfBtn?.addEventListener('click', () => {
            setExportMenuOpen(false);
            exportPropertiesPdf();
        });
        columnsToggleBtn?.addEventListener('click', () => {
            setColumnsPopoverOpen(!isColumnsPopoverOpen());
            if (isColumnsPopoverOpen()) {
                setColumnReorderMode(false);
                setExportMenuOpen(false);
            }
        });
        columnOrderToggleBtn?.addEventListener('click', () => {
            setColumnReorderMode(!isColumnReorderMode());
        });
        rowSelectionToggleBtn?.addEventListener('click', () => {
            setRowSelectionMode(!isRowSelectionMode());
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
            syncCheckboxes(defaultColumns);
            applyColumns(defaultColumns);
            safeSet(COL_KEY, JSON.stringify(defaultColumns));
            applyColumnOrder(defaultColumns, true);
        });

        document.addEventListener('click', (event) => {
            const target = event.target;
            if (!(target instanceof Element)) return;
            if (isExportMenuOpen() && !exportMenuRoot?.contains(target)) setExportMenuOpen(false);
            if (!isColumnsPopoverOpen()) return;
            if (columnsMenu?.contains(target) || columnsPopover?.contains(target)) return;
            setColumnsPopoverOpen(false);
        });

        const clearAndCloseSearch = (submitWhenPersisted = true) => {
            if (!searchInput) return;
            const qHadValue = (searchInput.value || '').trim() !== '';
            const urlHasQuery = new URLSearchParams(window.location.search).has('q');
            searchInput.value = '';
            filterTableRowsClient('');
            setSearchOpen(false);

            if (!form || !submitWhenPersisted) return;

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

            if (hasOtherFilters && (qHadValue || urlHasQuery)) {
                form.submit();
                return;
            }

            if (urlHasQuery) {
                const actionUrl = form.getAttribute('action') || window.location.pathname;
                window.location.assign(actionUrl);
            }
        };

        clearSearchBtn?.addEventListener('click', () => {
            clearAndCloseSearch(true);
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
            tableAdvancedApi?.syncRowSelectionHeaderState?.();
            updateTblNavPill();
        };

        let searchDebounce = 0;
        searchInput?.addEventListener('input', () => {
            window.clearTimeout(searchDebounce);
            searchDebounce = window.setTimeout(() => filterTableRowsClient(searchInput.value), 120);
        });
        searchInput?.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                event.preventDefault();
                event.stopPropagation();
                if ((searchInput.value || '').trim() !== '') {
                    searchInput.value = '';
                    filterTableRowsClient('');
                    return;
                }
                setSearchOpen(false);
                searchToggleBtn?.focus({ preventScroll: true });
                return;
            }

            if (event.key === 'Enter' && form) {
                event.preventDefault();
                searchInput.disabled = false;
                form.submit();
            }
        });

        if ((searchInput?.value || '').trim() !== '') {
            filterTableRowsClient(searchInput.value);
        }

        document.addEventListener('keydown', (event) => {
            if (event.key !== 'Escape') return;
            const activeEl = document.activeElement;
            if (isExportMenuOpen()) { setExportMenuOpen(false); exportToggleBtn?.focus({ preventScroll: true }); return; }
            if (isColumnsPopoverOpen()) { setColumnsPopoverOpen(false); columnsToggleBtn?.focus({ preventScroll: true }); return; }
            if (activeEl === searchInput) return;
            if (activeEl instanceof HTMLInputElement || activeEl instanceof HTMLSelectElement || activeEl instanceof HTMLTextAreaElement) { activeEl.blur(); return; }
            if (toolbarEl?.classList.contains('vn-report-toolbar--search-open') && (searchInput?.value || '').trim() === '') { setSearchOpen(false); return; }
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
            /* RTL tables: +huge scrolls to physical RIGHT edge (= visual start/first columns)
               FRONT/index.html confirms: 'right'→+HUGE for بداية, 'left'→-HUGE for نهاية */
            /* Instant jump — scrollLeft assignment is always instantaneous */
            tableScroller.scrollLeft = direction === 'start' ? huge : -huge;
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
            tblNavPill.innerHTML = '<div class="vn-tbl-nav-pill-inner"><button type="button" class="vn-tbl-nav-pill-btn" data-tbl-nav="start">بداية الجدول ⟫</button><div class="vn-tbl-nav-pill-sep"></div><button type="button" class="vn-tbl-nav-pill-btn" data-tbl-nav="end">⟪ نهاية الجدول</button></div>';
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
            floatingHost.addEventListener('click', (e) => {
                const pinBtn = e.target?.closest?.('.vn-col-pin-btn');
                if (!pinBtn || !floatingHost.contains(pinBtn)) return;
                e.preventDefault();
                e.stopPropagation();
                const key = pinBtn.getAttribute('data-col-pin') || pinBtn.closest('th[data-column-key]')?.getAttribute('data-column-key');
                if (!key) return;
                tableAdvancedApi?.togglePinColumn?.(key);
                requestFloatingHeadSync();
            });
            floatingHost.addEventListener('pointerdown', (e) => {
                if (!isColumnReorderMode()) return;
                if (e.target?.closest?.('.vn-col-pin-btn,.vn-col-resize-handle,button,a,input,select,textarea,[role="button"]')) return;
                const key = e.target?.closest?.('th[data-column-key]')?.getAttribute('data-column-key');
                if (key && tableAdvancedApi?.startColumnReorderDrag?.(key, e)) e.preventDefault();
            });
            floatingHost.addEventListener('change', (e) => {
                const selectAll = e.target?.closest?.('.vn-row-selection-select-all');
                if (!selectAll || !floatingHost.contains(selectAll)) return;
                tableAdvancedApi?.setAllVisibleRowsSelected?.(selectAll.checked);
                requestFloatingHeadSync();
            });
            document.body.appendChild(floatingHost);
        };

        const hideFloatingHead = () => {
            tableEl?.querySelector('thead')?.style.removeProperty('visibility');
            if (!floatingHost) return;
            floatingHost.style.display = 'none';
            floatingHost.style.width = '';
            floatingHost.style.maxWidth = '';
            floatingHost.style.left = '';
            floatingHost.style.right = '';
            floatingHost.style.top = '';
            floatingHost.style.boxSizing = '';
            floatingHost.setAttribute('aria-hidden', 'true');
            if (floatingTable) {
                floatingTable.style.width = '';
                floatingTable.style.minWidth = '';
                floatingTable.style.transform = '';
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

            const stickyTop = getStickyHeadTop();
            const rect = tableEl.getBoundingClientRect();
            const headRect = thead.getBoundingClientRect();
            const bodyRect = (tableEl.querySelector('tbody') || tableEl).getBoundingClientRect();
            const scrollerRect = tableScroller.getBoundingClientRect();
            const viewportWidth = document.documentElement.clientWidth || window.innerWidth || 0;
            const viewportHeight = document.documentElement.clientHeight || window.innerHeight || 0;
            const headerH = Math.max(28, Math.ceil(headRect.height || 32));
            const hostLeft = Math.round(scrollerRect.left);
            const hostWidth = Math.round(Math.min(scrollerRect.width, Math.max(0, viewportWidth - hostLeft)));
            const scrollerVisible = scrollerRect.right > 0
                && scrollerRect.left < viewportWidth
                && scrollerRect.bottom > stickyTop + headerH
                && scrollerRect.top < viewportHeight;
            const shouldPin = headRect.top <= stickyTop
                && bodyRect.bottom > stickyTop + headerH + 2
                && scrollerVisible
                && hostWidth >= 30;

            if (!shouldPin || document.fullscreenElement === reportRoot) {
                hideFloatingHead();
                return;
            }

            ensureFloatingHost();

            const headClone = thead.cloneNode(true);
            headClone.style.visibility = 'visible';
            headClone.style.opacity = '1';
            headClone.querySelectorAll('.vn-col-resize-handle').forEach((el) => el.remove());
            headClone.querySelectorAll('*').forEach((el) => {
                el.style.visibility = 'visible';
                el.style.opacity = '1';
            });
            headClone.querySelectorAll('[id]').forEach((el) => el.removeAttribute('id'));
            headClone.querySelectorAll('input, button, select, textarea, a').forEach((el) => {
                const pinBtn = el.closest?.('.vn-col-pin-btn');
                const rowSelectionControl = el.closest?.('.vn-row-selection-cell');
                if (pinBtn || rowSelectionControl) {
                    el.removeAttribute('tabindex');
                    el.setAttribute('aria-hidden', 'false');
                    if ('disabled' in el) el.disabled = false;
                    return;
                }
                el.setAttribute('tabindex', '-1');
                el.setAttribute('aria-hidden', 'true');
                if ('disabled' in el) el.disabled = true;
            });

            const sourceThs = [...thead.querySelectorAll('th')];
            const pinnedColumns = tableAdvancedApi?.getPinnedColumns?.() || [];
            [...headClone.querySelectorAll('th')].forEach((th, i) => {
                const src = sourceThs[i];
                if (!src) return;
                const key = src.getAttribute('data-column-key') || '';
                const isPinned = pinnedColumns.includes(key);
                const w = Math.ceil(src.getBoundingClientRect().width);
                th.style.display = getComputedStyle(src).display === 'none' ? 'none' : '';
                th.style.width = `${w}px`;
                th.style.minWidth = `${w}px`;
                th.style.maxWidth = `${w}px`;
                th.classList.toggle('vn-col-pinned', isPinned);
                th.classList.toggle('vn-col-pin-edge', isPinned && src.classList.contains('vn-col-pin-edge'));
                th.style.position = isPinned ? 'sticky' : 'static';
                th.style.right = isPinned ? src.style.right : '';
                th.style.top = 'auto';
                th.querySelectorAll('.vn-col-pin-btn').forEach((btn) => {
                    btn.dataset.colPin = key;
                    btn.classList.toggle('active', isPinned);
                    btn.setAttribute('aria-label', isPinned ? 'إلغاء تثبيت العمود' : 'تثبيت العمود');
                    btn.title = isPinned ? 'إلغاء التثبيت' : 'تثبيت العمود';
                    btn.setAttribute('aria-pressed', isPinned ? 'true' : 'false');
                });
            });

            const colgroupClone = tableEl.querySelector('colgroup')?.cloneNode(true) || null;
            colgroupClone?.querySelectorAll('[id]').forEach((el) => el.removeAttribute('id'));
            colgroupClone?.removeAttribute('id');

            floatingTable.className = tableEl.className;
            floatingTable.innerHTML = '';
            if (colgroupClone) floatingTable.appendChild(colgroupClone);
            floatingTable.appendChild(headClone);
            tableAdvancedApi?.syncRowSelectionHeaderState?.();
            thead.style.visibility = 'hidden';
            floatingHost.style.display = 'block';
            floatingHost.setAttribute('aria-hidden', 'false');
            floatingHost.style.top = `${stickyTop}px`;
            floatingHost.style.left = `${hostLeft}px`;
            floatingHost.style.right = 'auto';
            floatingHost.style.width = `${hostWidth}px`;
            floatingHost.style.maxWidth = 'none';
            floatingHost.style.boxSizing = 'border-box';
            floatingTable.style.width = `${Math.round(tableEl.scrollWidth)}px`;
            floatingTable.style.minWidth = `${Math.round(tableEl.scrollWidth)}px`;
            floatingTable.style.transform = '';

            const floatingTableRect = floatingTable.getBoundingClientRect();
            const realTableRect = tableEl.getBoundingClientRect();
            const deltaX = Math.round(realTableRect.left - floatingTableRect.left);
            floatingTable.style.transform = `translateX(${deltaX}px)`;
        };

        const updateStickyOffset = () => {
            const stickyTop = getStickyHeadTop();
            reportRoot.style.setProperty('--vn-pr-table-sticky-offset', `${stickyTop}px`);
            requestFloatingHeadSync();
        };

        const syncFullscreenUi = () => {
            const activeEl = document.fullscreenElement || document.webkitFullscreenElement || null;
            const isReportFs = activeEl === reportRoot;
            document.body.classList.toggle('vn-report-fullscreen-active', isReportFs);
            if (isReportFs) {
                hideFloatingHead();
                const theme = document.documentElement.getAttribute('data-theme') || document.body.getAttribute('data-theme') || 'dark';
                reportRoot.setAttribute('data-theme', theme);
            } else {
                reportRoot.removeAttribute('data-theme');
            }
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
            onColumnOrderChange: (order) => {
                safeSet(COL_ORDER_KEY, JSON.stringify(normalizeColumnOrder(order)));
                requestFloatingHeadSync();
                updateTblNavPill();
            },
            onRowSelectionChange: ({ count } = {}) => {
                updateRowSelectionCount(count || 0);
                requestFloatingHeadSync();
            },
        });

        applyColumnOrder(orderFromStorage, false);

        window.vnPropertiesReportExport = {
            getSelectedRowIds: () => tableAdvancedApi?.getSelectedRowIds?.() || [],
            getVisibleColumnKeys: () => tableAdvancedApi?.getVisibleColumnKeys?.() || [],
            getExportRows: () => tableAdvancedApi?.getExportRows?.() || null,
            exportExcel: exportPropertiesExcel,
            exportPdf: exportPropertiesPdf,
            getExportFormat: () => ({ extension: 'xlsx', mimeType: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', format: 'xlsx-client' }),
            openMenu: () => setExportMenuOpen(true),
            closeMenu: () => setExportMenuOpen(false),
        };

        ensureFloatingHost();
        hideFloatingHead();
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
