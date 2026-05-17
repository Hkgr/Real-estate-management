document.querySelectorAll('.viewer-hub [data-toggle-target]').forEach((button) => {
    button.addEventListener('click', () => {
        const id = button.getAttribute('data-toggle-target');
        const card = document.getElementById(id);
        if (card) {
            card.classList.toggle('open');
        }
    });
});

const clockEl = document.getElementById('topbar-clock');
if (clockEl) {
    const updateClock = () => {
        clockEl.textContent = new Date().toLocaleTimeString('ar-SA', {
            hour: '2-digit', minute: '2-digit', second: '2-digit',
        });
    };
    updateClock();
    setInterval(updateClock, 1000);
}

['lang-en-btn', 'lang-en-btn-2'].forEach((id) => {
    const btn = document.getElementById(id);
    if (btn) {
        btn.addEventListener('click', () => window.alert('خيار الإنجليزية مؤجل حالياً.'));
    }
});

const darkBtn = document.getElementById('theme-dark-btn');
const lightBtn = document.getElementById('theme-light-btn');
if (darkBtn && lightBtn) {
    darkBtn.addEventListener('click', () => {
        darkBtn.classList.add('active');
        lightBtn.classList.remove('active');
    });
    lightBtn.addEventListener('click', () => {
        lightBtn.classList.add('active');
        darkBtn.classList.remove('active');
    });
}
