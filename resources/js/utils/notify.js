const notify = {

    // -------------------------------------
    // 1. Container
    // -------------------------------------
    show(type, title, text = '', duration = 40000) {
        let container = document.querySelector('.app-alerts');

        if (!container) {
            container = document.createElement('div');
            container.className = 'app-alerts position-fixed top-0 start-0 p-3 d-flex flex-column align-items-start';
            container.style.cssText = 'z-index:1090;width:min(390px,100%);pointer-events:none;';
            document.body.appendChild(container);
        }


        // -------------------------------------
        // Alert HTML
        // -------------------------------------
        const alert = document.createElement('div');

        alert.className = 'alert d-flex align-items-center gap-3 p-3 rounded-4 mb-2 w-100 shadow-sm';
        alert.style.cssText = `direction:rtl;text-align:right;background:#fff;border:1px solid ${type === 'success' ? '#c5dfcc' : '#e8caca'};box-shadow:0 4px 16px rgba(0,0,0,.04)!important;opacity:0;transform:translateY(-12px);transition:opacity .3s ease,transform .3s ease;pointer-events:auto`;

        alert.innerHTML = `
            <div class="d-flex align-items-center justify-content-center flex-shrink-0 rounded-circle" style="width:40px;height:40px;background:${type === 'success' ? '#eaf4ed' : '#f8eded'};color:${type === 'success' ? '#39845b' : '#c16b6b'}">
                ${type === 'success'
                ? `<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m5 12 4 4L19 6"/>
                    </svg>`
                : `<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                        <path d="M12 8v4m0 4h.01"/><circle cx="12" cy="12" r="10"/>
                    </svg>`
            }
            </div>

            <div class="flex-grow-1 text-start" dir="rtl">
                <div class="fw-semibold small mb-1 text-dark">${title}</div>
                <div class="small text-secondary" style="line-height:1.8">${text}</div>
            </div>
        `;

        container.appendChild(alert);
        requestAnimationFrame(() => {
            alert.style.opacity = '1';
            alert.style.transform = 'translateY(0)';
        });


        // -------------------------------------
        // Auto Remove
        // -------------------------------------
        const timeout = setTimeout(() => {
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-10px)';

            setTimeout(() => {
                alert.remove()
            }, 300);
        }, duration);
    },


    // -------------------------------------
    // Success
    // -------------------------------------
    success(text = '') {
        return this.show('success', 'عملیات موفق', text);
    },


    // -------------------------------------
    // Error
    // -------------------------------------
    error(text = '') {
        return this.show('danger', 'عملیات ناموفق', text);
    },


    // -------------------------------------
    // Warning
    // -------------------------------------
    async warning(text = '') {
        return confirm(`آیا مطمئن هستید؟\n\n${text}`);
    }
};

export default notify;
