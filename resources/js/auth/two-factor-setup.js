import initAuthForm from './auth-form.js';

initAuthForm({
    formId: 'two-factor-enable-form',
    submitBtnId: 'submit-two-factor-enable-form'
});



// -------------------------------------
// copy secret code to clipboard
// -------------------------------------
const copyBtn = document.getElementById('copy-2fa-secret');
copyBtn.addEventListener('click', function () {
    const value = this.dataset.secret;
    const base = this.dataset.iconBase;

    navigator.clipboard.writeText(value);
    const original = this.innerHTML;

    btn.innerHTML = `
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke="var(--primary)">
            <use href="${base}#tick-circle"></use>
        </svg>
    `;

    setTimeout(() => {
        btn.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke="var(--secondary)">
                <use href="${base}#copy"></use>
            </svg>
        `;
    }, 2500);
});