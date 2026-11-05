import api from '../utils/api.js';
import notify from '../utils/notify.js';

// ------------------------------------------
// Get Form and Elements
// ------------------------------------------
const form = document.getElementById('regenerate-recovery-codes-form');
const submitBtn = document.getElementById('submit-regenerate-recovery-codes');
const recoveryCodes = document.getElementById('recovery-codes');
const recoveryCodeTemplate = document.getElementById('recovery-code-template');

if (form && submitBtn && recoveryCodes && recoveryCodeTemplate) {

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

                    (data.data?.recovery_codes || []).forEach(code => {
                        const element = recoveryCodeTemplate.content.firstElementChild.cloneNode(true);

                        element.querySelector('[dir="ltr"]').textContent = code;
                        element.querySelector('button').dataset.code = code;

                        recoveryCodes.appendChild(element);
                    });
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
    // Copy Recovery Code
    // ------------------------------------------
    recoveryCodes.addEventListener('click', async (e) => {
        const button = e.target.closest('button[data-code]');
        if (!button) return;

        try {
            const code = button.dataset.code;

            // ----------------------------------
            // Copy to Clipboard
            // ----------------------------------
            if (navigator.clipboard && window.isSecureContext) {
                await navigator.clipboard.writeText(code);
            } else {
                const textarea = document.createElement('textarea');

                textarea.value = code;
                textarea.style.position = 'fixed';
                textarea.style.opacity = '0';

                document.body.appendChild(textarea);
                textarea.select();

                const copied = document.execCommand('copy');
                textarea.remove();

                if (!copied) throw new Error('Copy failed');
            }

            // ----------------------------------
            // Show Tick Icon
            // ----------------------------------
            const copyIcon = button.querySelector('.copy-icon');
            const tickIcon = button.querySelector('.tick-icon');

            copyIcon.classList.add('d-none');
            tickIcon.classList.remove('d-none');

            clearTimeout(button.copyTimeout);

            button.copyTimeout = setTimeout(() => {
                copyIcon.classList.remove('d-none');
                tickIcon.classList.add('d-none');
            }, 2000);

        } catch {
            notify.error('کپی کد انجام نشد');
        }
    });
}