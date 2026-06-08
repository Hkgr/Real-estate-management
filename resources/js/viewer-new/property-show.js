function qs(selector, context = document) {
    return context.querySelector(selector);
}

function qsa(selector, context = document) {
    return Array.from(context.querySelectorAll(selector));
}

function cleanText(value) {
    return String(value || '')
        .replace(/\u00a0/g, ' ')
        .replace(/[ \t\r\f\v]+/g, ' ')
        .replace(/\n\s*/g, ' ')
        .trim();
}

function escapeHtml(value) {
    return cleanText(value)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
}

function collectDiagnostics(root) {
    const tableCount = qsa('.vn-property-show-table', root).length;
    const hasTableFor = (label) => qsa('.vn-property-show-card', root).some((card) => cleanText(qs('h2', card)?.textContent) === label && !!qs('.vn-property-show-table', card));

    return {
        format: 'property-card-pdf-print-client',
        propertyId: root?.dataset?.propertyId || null,
        recordNumber: root?.dataset?.propertyRecordNumber || null,
        tableCount,
        hasOwnersTable: hasTableFor('الملاك وحصص الملكية'),
        hasOperationsTable: hasTableFor('العمليات المرتبطة'),
        hasSignalsTable: hasTableFor('الإشارات المرتبطة'),
        hasAttachmentsTable: hasTableFor('المرفقات'),
    };
}

function normalizePrintClone(root) {
    const clone = root.cloneNode(true);

    qsa('[data-print-exclude], button, script, style, input, select, textarea', clone).forEach((el) => el.remove());
    qsa('.vn-property-show__hero', clone).forEach((el) => el.remove());

    qsa('a', clone).forEach((anchor) => {
        const span = document.createElement('span');
        span.textContent = cleanText(anchor.textContent);
        anchor.replaceWith(span);
    });

    qsa('.vn-property-show-table-wrap', clone).forEach((wrap) => {
        wrap.removeAttribute('style');
    });

    return clone;
}

function buildPrintHtml(root) {
    const generatedAt = new Date().toLocaleString('ar');
    const recordNumber = root?.dataset?.propertyRecordNumber || '—';
    const propertyId = root?.dataset?.propertyId || '—';
    const propertyName = cleanText(qs('.vn-property-show__subtitle', root)?.textContent || '');
    const bodyClone = normalizePrintClone(root);

    return `<!doctype html>
<html lang="ar" dir="rtl">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>بطاقة العقار</title>
<style>
@page { size: A4 landscape; margin: 12mm; }
* { box-sizing: border-box; }
html, body { direction: rtl; background: #fff; color: #111827; font-family: Arial, Tahoma, sans-serif; }
body { margin: 0; font-size: 12px; line-height: 1.65; }
.report-shell { width: 100%; }
.report-header { border-bottom: 3px solid #8b6914; margin-bottom: 14px; padding-bottom: 10px; }
h1 { margin: 0 0 8px; color: #111827; font-size: 26px; font-weight: 800; }
.report-meta { display: flex; flex-wrap: wrap; gap: 8px; margin: 0; padding: 0; list-style: none; color: #374151; }
.report-meta li { border: 1px solid #ead89b; background: #fffbeb; border-radius: 8px; padding: 5px 9px; }
.vn-property-show { display: block; max-width: none; margin: 0; overflow: visible; }
.vn-property-show-card { margin: 0 0 12px; padding: 0; border: 1px solid #d1d5db; border-radius: 0; background: #fff; box-shadow: none; break-inside: avoid; page-break-inside: avoid; overflow: visible; }
.vn-property-show-card__head { display: flex; align-items: center; justify-content: space-between; gap: 8px; margin: 0; padding: 7px 10px; border-bottom: 1px solid #8b6914; background: #111827; color: #fff; }
.vn-property-show-card__head h2 { margin: 0; color: #fff; font-size: 15px; }
.vn-property-show-count { color: #f8e6a0; font-size: 11px; }
.vn-property-show-grid { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 0; }
.vn-property-show-field { padding: 8px 10px; border: 1px solid #e5e7eb; border-width: 0 0 1px 1px; background: #fff; }
.vn-property-show-field span { display: block; color: #6b7280; font-size: 10px; margin-bottom: 2px; }
.vn-property-show-field strong { display: block; color: #111827; font-size: 12px; font-weight: 700; overflow-wrap: anywhere; }
.vn-property-show-table-wrap { width: 100%; overflow: visible; border: 0; border-radius: 0; background: #fff; }
table, .vn-property-show-table { width: 100%; min-width: 0 !important; border-collapse: collapse; table-layout: auto; direction: rtl; }
th, td, .vn-property-show-table th, .vn-property-show-table td { border: 1px solid #d1d5db; padding: 6px 7px; text-align: right; vertical-align: top; color: #111827; word-break: break-word; overflow-wrap: anywhere; }
thead th, .vn-property-show-table thead th { background: #8b6914; color: #fff; font-weight: 700; }
tbody tr:nth-child(even) td { background: #fffbeb; }
tbody tr:nth-child(odd) td { background: #fff; }
thead { display: table-header-group; }
tr { break-inside: avoid; page-break-inside: avoid; }
.vn-property-show-note { margin: 0; padding: 10px; color: #111827; background: #fff; border: 0; white-space: pre-wrap; overflow-wrap: anywhere; }
@media print {
  body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
  thead { display: table-header-group; }
  tr, .vn-property-show-card { break-inside: avoid; page-break-inside: avoid; }
}
</style>
</head>
<body>
  <main class="report-shell">
    <header class="report-header">
      <h1>بطاقة العقار</h1>
      <ul class="report-meta">
        <li>رقم المحضر: ${escapeHtml(recordNumber)}</li>
        <li>رقم العقار الداخلي: ${escapeHtml(propertyId)}</li>
        ${propertyName ? `<li>اسم العقار: ${escapeHtml(propertyName)}</li>` : ''}
        <li>تاريخ الإنشاء: ${escapeHtml(generatedAt)}</li>
      </ul>
    </header>
    ${bodyClone.innerHTML}
  </main>
</body>
</html>`;
}

export function exportPropertyCardPdf(root = qs('[data-property-print-root]')) {
    if (!root) return;

    const diagnostics = collectDiagnostics(root);
    console.info('[viewer-new property card export]', diagnostics);

    const printWindow = window.open('', '_blank', 'width=1280,height=900,scrollbars=yes,resizable=yes');
    if (!printWindow) {
        window.alert('تعذر فتح نافذة الطباعة. يرجى السماح بالنوافذ المنبثقة ثم المحاولة مرة أخرى.');
        return;
    }

    printWindow.document.open();
    printWindow.document.write(buildPrintHtml(root));
    printWindow.document.close();
    printWindow.focus();

    window.setTimeout(() => {
        try {
            printWindow.focus();
            printWindow.print();
        } catch (error) {
            console.error('[viewer-new property card export] فشل فتح نافذة الطباعة', error);
            window.alert('تعذر فتح نافذة الطباعة. يرجى السماح بالنوافذ المنبثقة ثم المحاولة مرة أخرى.');
        }
    }, 350);
}

export function initPropertyShowPdfExport() {
    const root = qs('[data-property-print-root]');
    const button = qs('[data-property-pdf-export]');
    if (!root || !button) return;

    const exportPdf = () => exportPropertyCardPdf(root);
    button.addEventListener('click', exportPdf);
    window.vnPropertyShowExport = { exportPdf };
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initPropertyShowPdfExport, { once: true });
} else {
    initPropertyShowPdfExport();
}

/* ── Apply quick-settings (theme + font size) on property-show page ── */
(function applyQuickSettings() {
    const stored = JSON.parse(localStorage.getItem('vn-quick-settings') || '{}');
    const theme    = stored.theme    || localStorage.getItem('themeMode') || 'light';
    const fontSize = stored.fontSize || 'normal';

    const scaleMap = { small: '0.85', normal: '1', large: '1.18', xlarge: '1.38', xxlarge: '1.6' };
    const scale = scaleMap[fontSize] || '1';

    document.documentElement.setAttribute('data-theme', theme);
    document.body.setAttribute('data-theme', theme);
    document.documentElement.style.setProperty('--fs-scale', scale);

    const showEl = document.querySelector('.vn-property-show');
    if (showEl) showEl.style.setProperty('--fs-scale', scale);
})();
