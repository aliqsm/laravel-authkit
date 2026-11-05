import api from '../utils/api.js';
import notify from '../utils/notify.js';

// ------------------------------------------
// Get Elements
// ------------------------------------------
const form = document.getElementById('regenerate-recovery-codes-form');
const submitBtn = document.getElementById('submit-regenerate-recovery-codes');
const recoveryCodes = document.getElementById('recovery-codes');
const copyBtn = document.getElementById('copy-recovery-codes');

if (form && submitBtn && recoveryCodes && copyBtn) {

    let originalHtml = '';
    let copyTimeout;

    // ------------------------------------------
    // Get Recovery Codes
    // ------------------------------------------
    const getRecoveryCodes = () => {
        return [...recoveryCodes.querySelectorAll('[dir="ltr"]')]
            .map(element => element.textContent.trim());
    };


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

                    (data.data?.recovery_codes || []).forEach(code => {
                        const row = document.createElement('div');
                        row.className = 'd-flex align-items-center justify-content-center py-1';

                        const span = document.createElement('span');
                        span.className = 'fw-medium font-monospace text-center';
                        span.dir = 'ltr';
                        span.textContent = code;

                        row.appendChild(span);
                        recoveryCodes.appendChild(row);
                    });

                    copyBtn.classList.remove('d-none');
                    resetCopyIcon();
                },

                onError: (data) => {
                    notify.error(data?.message || 'خطا در تولید کدهای بازیابی');
                },
            });

        } finally {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalHtml;
        }
    });


    // ------------------------------------------
    // Reset Copy Icon
    // ------------------------------------------
    function resetCopyIcon() {
        clearTimeout(copyTimeout);

        copyBtn.querySelector('.copy-icon').classList.remove('d-none');
        copyBtn.querySelector('.tick-icon').classList.add('d-none');
    }


    // ------------------------------------------
    // Copy All Recovery Codes
    // ------------------------------------------
    copyBtn.addEventListener('click', async () => {
        const codes = getRecoveryCodes();

        if (!codes.length) return;

        try {
            const text = codes.join('\n');

            if (navigator.clipboard && window.isSecureContext) {
                await navigator.clipboard.writeText(text);
            } else {
                const textarea = document.createElement('textarea');

                textarea.value = text;
                textarea.style.position = 'fixed';
                textarea.style.opacity = '0';

                document.body.appendChild(textarea);
                textarea.select();

                const copied = document.execCommand('copy');
                textarea.remove();

                if (!copied) throw new Error('Copy failed');
            }

            copyBtn.querySelector('.copy-icon').classList.add('d-none');
            copyBtn.querySelector('.tick-icon').classList.remove('d-none');

            clearTimeout(copyTimeout);
            copyTimeout = setTimeout(resetCopyIcon, 2000);

        } catch {
            notify.error('کپی کدهای بازیابی انجام نشد');
        }
    });
}