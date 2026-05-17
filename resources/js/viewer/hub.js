document.querySelectorAll('[data-toggle-target]').forEach((button) => {
    button.addEventListener('click', () => {
        const id = button.getAttribute('data-toggle-target');
        const card = document.getElementById(id);
        if (card) card.classList.toggle('open');
    });
});

const clockEl = document.getElementById('topbar-clock');
if (clockEl) {
    const updateClock = () => {
        clockEl.textContent = new Date().toLocaleTimeString('ar-SA', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
    };
    updateClock();
    setInterval(updateClock, 1000);
}

const langBtn = document.getElementById('lang-en-btn');
if (langBtn) {
    langBtn.addEventListener('click', () => {
        window.alert('النسخة الإنجليزية مؤجلة حالياً.');
    });
}
