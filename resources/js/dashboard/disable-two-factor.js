import api from '../utils/api.js';
import notify from '../utils/notify.js';

// ------------------------------------------
// Get Form and Button
// ------------------------------------------
const form = document.getElementById('disable-two-factor-form');
const submitBtn = document.getElementById('submit-disable-two-factor');

if (form && submitBtn) {

    let originalHtml = '';

    // ------------------------------------------
    // Handle Form Submission
    // ------------------------------------------
    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        submitBtn.disabled = true;
        originalHtml = submitBtn.innerHTML;

        submitBtn.innerHTML = `
            <span class="spinner-border spinner-border-sm"
                style="height:14px; width:14px; border-width:2px !important;">
            </span>
        `;

        // ------------------------------------------
        // Send Request
        // ------------------------------------------
        try {
            await api({
                endpoint: form.action,
                method: form.method || 'POST',
                data: new FormData(form),

                callback: (data) => {
                    notify.success(data.message || 'تأیید دومرحله‌ای غیرفعال شد.');

                    if (data.data?.redirect) {
                        setTimeout(() => {
                            window.location.href = data.data.redirect;
                        }, 1000);
                    }
                },

                onError: (data) => {
                    notify.error(data?.message || 'خطا در غیرفعال‌سازی تأیید دومرحله‌ای');
                },
            });

        } finally {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalHtml;
        }
    });
}