    const toggleBtn = document.getElementById('mode-toggle');
    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

    // Cargar preferencia guardada o usar la del sistema
    const savedMode = localStorage.getItem('theme');
    if (savedMode === 'dark' || (!savedMode && prefersDark)) {
        document.body.classList.add('dark-mode');
        toggleBtn.textContent = '☀️';
    }

    toggleBtn.addEventListener('click', () => {
        document.body.classList.toggle('dark-mode');
        const isDark = document.body.classList.contains('dark-mode');
        toggleBtn.textContent = isDark ? '☀️' : '🌙';
        localStorage.setItem('theme', isDark ? 'dark' : 'light');
    });

