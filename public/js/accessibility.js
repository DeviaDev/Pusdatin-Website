// Toolbar Aksesibilitas Pusdatin BNPT — preferensi tersimpan di localStorage
(function () {
    const prefs = JSON.parse(localStorage.getItem('aks') || '{}');
    const root = document.documentElement;

    function apply(p) {
        root.className = root.className.replace(/\b(fs-\d+|kontras|grayscale|underline|readable)\b/g, '').trim();
        if (p.fs) root.classList.add('fs-' + p.fs);
        ['kontras', 'grayscale', 'underline', 'readable'].forEach(k => { if (p[k]) root.classList.add(k); });
        syncButtons(p);
    }

    function set(key, val) {
        prefs[key] = val;
        localStorage.setItem('aks', JSON.stringify(prefs));
        apply(prefs);
    }

    function syncButtons(p) {
        document.querySelectorAll('#aks-panel button[data-k]').forEach(b => {
            const k = b.dataset.k;
            b.classList.toggle('on', k === 'fs' ? p.fs === b.dataset.v : !!p[k]);
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        // Buat tombol & panel
        const btn = document.createElement('button');
        btn.id = 'aks-btn'; btn.title = 'Aksesibilitas'; btn.setAttribute('aria-label', 'Menu aksesibilitas');
        btn.innerHTML = '&#9855;';
        const panel = document.createElement('div');
        panel.id = 'aks-panel';
        panel.innerHTML = `<h4>Aksesibilitas</h4>
            <div class="baris">
                <button data-k="fs" data-v="90">A-</button>
                <button data-k="fs" data-v="110">A</button>
                <button data-k="fs" data-v="125">A+</button>
                <button data-k="fs" data-v="140">A++</button>
            </div>
            <div class="baris">
                <button data-k="kontras">Kontras</button>
                <button data-k="grayscale">Monokrom</button>
            </div>
            <div class="baris">
                <button data-k="underline">Garis Bawah</button>
                <button data-k="readable">Font Ramah</button>
            </div>
            <div class="baris"><button id="aks-reset" style="background:#9c1c28;color:#fff;border-color:#9c1c28">Reset</button></div>`;
        document.body.append(btn, panel);

        btn.addEventListener('click', () => {
            panel.style.display = panel.style.display === 'block' ? 'none' : 'block';
        });
        panel.addEventListener('click', e => {
            const b = e.target.closest('button');
            if (!b) return;
            if (b.id === 'aks-reset') { localStorage.removeItem('aks'); Object.keys(prefs).forEach(k => delete prefs[k]); apply({}); return; }
            if (b.dataset.k === 'fs') set('fs', b.dataset.v);
            else set(b.dataset.k, !prefs[b.dataset.k]);
        });
        apply(prefs);
    });
})();
