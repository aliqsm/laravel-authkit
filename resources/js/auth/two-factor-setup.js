import initAuthForm from './auth-form.js';
import notify from '../utils/notify.js';

initAuthForm({
    formId: 'two-factor-enable-form',
    submitBtnId: 'submit-two-factor-enable-form'
});


// ------------------------------------------
// Copy Secret Key
// ------------------------------------------
const copyBtn = document.getElementById('copy-2fa-secret');

if (copyBtn) {

    let copyTimeout;

    copyBtn.addEventListener('click', async function () {
        try {
            const value = this.dataset.secret;

            if (navigator.clipboard && window.isSecureContext) {
                await navigator.clipboard.writeText(value);
            } else {
                const textarea = document.createElement('textarea');

                textarea.value = value;
                textarea.style.position = 'fixed';
                textarea.style.opacity = '0';

                document.body.appendChild(textarea);
                textarea.select();

                const copied = document.execCommand('copy');
                textarea.remove();

                if (!copied) throw new Error('Copy failed');
            }

            const copyIcon = this.querySelector('.copy-icon');
            const tickIcon = this.querySelector('.tick-icon');

            copyIcon.classList.add('d-none');
            tickIcon.classList.remove('d-none');

            clearTimeout(copyTimeout);

            copyTimeout = setTimeout(() => {
                copyIcon.classList.remove('d-none');
                tickIcon.classList.add('d-none');
            }, 2000);

        } catch {
            notify.error('کپی کلید راه‌اندازی انجام نشد');
        }
    });
}