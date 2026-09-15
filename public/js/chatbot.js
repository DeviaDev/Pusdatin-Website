// Asisten Pusdatin — chatbot FAQ
(function () {
    document.addEventListener('DOMContentLoaded', () => {
        const btn = document.createElement('button');
        btn.id = 'cb-btn'; btn.title = 'Asisten Pusdatin'; btn.setAttribute('aria-label', 'Buka chat asisten');
        btn.innerHTML = '&#128172;';
        const panel = document.createElement('div');
        panel.id = 'cb-panel';
        panel.innerHTML = `
            <div class="cb-head">Asisten Pusdatin</div>
            <div id="cb-body">
                <div class="cb-msg cb-bot">Halo! Saya Asisten Pusdatin. Ada yang bisa saya bantu seputar layanan Pusdatin BNPT? Silakan bertanya.</div>
            </div>
            <form id="cb-form">
                <input type="text" id="cb-input" placeholder="Tulis pertanyaan Anda..." autocomplete="off" required>
                <button type="submit" aria-label="Kirim">&#10148;</button>
            </form>`;
        document.body.append(btn, panel);

        const body = panel.querySelector('#cb-body');
        const form = panel.querySelector('#cb-form');
        const input = panel.querySelector('#cb-input');

        btn.addEventListener('click', () => {
            panel.style.display = panel.style.display === 'flex' ? 'none' : 'flex';
            if (panel.style.display === 'flex') input.focus();
        });

        function bubble(text, who) {
            const d = document.createElement('div');
            d.className = 'cb-msg cb-' + who;
            d.textContent = text;
            body.appendChild(d);
            body.scrollTop = body.scrollHeight;
        }

        form.addEventListener('submit', async e => {
            e.preventDefault();
            const pesan = input.value.trim();
            if (!pesan) return;
            bubble(pesan, 'user');
            input.value = '';
            const loading = document.createElement('div');
            loading.className = 'cb-msg cb-bot'; loading.textContent = 'Mengetik...';
            body.appendChild(loading); body.scrollTop = body.scrollHeight;
            try {
                const res = await fetch('/chatbot', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ pesan }),
                });
                const data = await res.json();
                loading.remove();
                bubble(data.jawaban, 'bot');
            } catch (err) {
                loading.remove();
                bubble('Maaf, terjadi kendala. Silakan coba lagi atau hubungi Helpdesk TI (021) 384-5555 ext. 200.', 'bot');
            }
        });
    });
})();
