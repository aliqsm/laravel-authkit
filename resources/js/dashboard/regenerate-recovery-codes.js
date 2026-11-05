import api from '../utils/api.js';
import notify from '../utils/notify.js';

// ------------------------------------------
// Get Form and Elements
// ------------------------------------------
const form = document.getElementById('regenerate-recovery-codes-form');
const submitBtn = document.getElementById('submit-regenerate-recovery-codes');
const recoveryCodes = document.getElementById('recovery-codes');

if (form && submitBtn && recoveryCodes) {

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
                    notify.success(data.message || 'کدهای بازیابی با موفقیت تولید شدند.');

                    // ----------------------------------
                    // Update Recovery Codes
                    // ----------------------------------
                    recoveryCodes.replaceChildren();

                    data.data.recovery_codes.forEach(code => {
                        const element = document.createElement('div');

                        element.className = 'py-1 fw-medium font-monospace text-center';
                        element.dir = 'ltr';
                        element.textContent = code;

                        recoveryCodes.appendChild(element);
                    });
                },

                onError: (data, response) => {
                    notify.error(data?.message || 'خطا در تولید کدهای بازیابی');
                },
            });

        } finally {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalHtml;
        }
    });
}