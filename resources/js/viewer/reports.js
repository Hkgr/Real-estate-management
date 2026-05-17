// TODO: Replace mock data with Laravel payload in next phase.
const mockData = {
  cities: ['الرياض', 'جدة', 'الدمام'],
  stats: [
    { label: 'إجمالي العقارات', value: 128 },
    { label: 'متوسط الإشغال', value: '87%' },
    { label: 'إجمالي الإيراد', value: '2.4M' },
    { label: 'صافي النمو', value: '+9.8%' },
  ],
  chart: [45, 52, 61, 58, 70, 76, 80],
  rows: [
    ['برج النخبة', 'الرياض', '92%', '320,000', '+6%'],
    ['روابي بلازا', 'جدة', '81%', '210,000', '+3%'],
    ['مارينا سويت', 'الدمام', '85%', '185,000', '+4%'],
  ],
};

const root = document.getElementById('viewerReportsPage');
if (root) {
  const city = document.getElementById('reportCity');
  mockData.cities.forEach((name) => city?.insertAdjacentHTML('beforeend', `<option value="${name}">${name}</option>`));

  const stats = document.getElementById('reportsStats');
  stats.innerHTML = mockData.stats.map((x) => `<article class="reports-stat"><p>${x.label}</p><strong>${x.value}</strong></article>`).join('');

  const chart = document.getElementById('reportsChartBars');
  chart.innerHTML = mockData.chart.map((v) => `<div class="reports-bar" style="height:${v}%"></div>`).join('');

  const tbody = document.querySelector('#reportsTable tbody');
  tbody.innerHTML = mockData.rows.map((row) => `<tr>${row.map((cell) => `<td>${cell}</td>`).join('')}</tr>`).join('');

  const quick = document.getElementById('reportsQuickSettings');
  document.querySelector('[data-open-quick-settings]')?.addEventListener('click', () => quick.hidden = false);
  document.querySelector('[data-close-quick-settings]')?.addEventListener('click', () => quick.hidden = true);

  const modal = document.getElementById('reportsInfoModal');
  setTimeout(() => { modal.hidden = false; }, 300);
  document.querySelector('[data-close-modal]')?.addEventListener('click', () => modal.hidden = true);

  document.getElementById('compactMode')?.addEventListener('change', (e) => {
    root.classList.toggle('compact', e.target.checked);
  });
}
