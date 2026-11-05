import api from '../utils/api.js';
import notify from '../utils/notify.js';


// ------------------------------------------
// Initialize Form and Submit Button
// ------------------------------------------
export default function initAuthForm({
    formId = '',
    submitBtnId = '',
    loading = true,
    loadingColor = '#fff',
    loadingSize = '14px',
    actionDelay = 600,
    successMessage = 'موفق',
} = {}) {

    // ------------------------------------------
    // Get Form and Submit Button
    // ------------------------------------------
    const form = document.getElementById(formId);
    if (!form) return;

    const submitBtn = submitBtnId ? document.querySelector(`#${submitBtnId}`) : form.querySelector('button[type="submit"]');
    if (!submitBtn) return;

    let originalHtml = '';


    // ------------------------------------------
    // Handle Form Submission and Loading
    // ------------------------------------------
    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        // ------------------------------------------
        // Clear Errors
        // ------------------------------------------
        form.querySelectorAll('.is-invalid').forEach(el => {
            el.classList.remove('is-invalid');
        });

        form.querySelectorAll('[id$="_error"]').forEach(el => {
            el.innerText = '';
            el.classList.add('d-none');
        });


        if (loading) {
            submitBtn.disabled = true;
            originalHtml = submitBtn.innerHTML;
            submitBtn.innerHTML = `<span class="spinner-border spinner-border-sm" style="color:${loadingColor}; height:${loadingSize}; width:${loadingSize}; border-width:2px !important;"></span>`;
        }


        // ------------------------------------------
        // Send Request and Handle Response
        // ------------------------------------------
        try {
            await api({
                endpoint: form.action,
                method: form.method || 'POST',
                data: new FormData(form),

                callback: (data, response) => {
                    notify.success(data.message || successMessage);

                    if (data.data?.redirect) {
                        setTimeout(() => {
                            window.location.href = data.data.redirect;
                        }, actionDelay);
                    }

                    if (data.data?.refresh) {
                        setTimeout(() => {
                            window.location.reload();
                        }, actionDelay);
                    }
                },

                onError: (data, response) => {
                    switch (response?.status) {
                        case 422:
                            if (data.errors && Object.keys(data.errors).length > 0) {
                                showFieldErrors(data.errors, form);
                            } else {
                                notify.error(data.message || 'اطلاعات وارد شده معتبر نیست');
                            }
                            break;

                        case 401:
                            notify.error(data.message || 'احراز هویت انجام نشده است');
                            break;

                        case 403:
                            notify.error(data.message || 'شما مجوز انجام این عملیات را ندارید');
                            break;

                        case 404:
                            notify.error(data.message || 'متأسفانه موردی یافت نشد');
                            break;

                        case 419:
                            notify.error(data.message || 'نشست شما منقضی شده است');
                            break;

                        case 423:
                            notify.error(data?.message || 'ابتدا باید رمز عبور خود را تأیید کنید');
                            setTimeout(() => {
                                window.location.href = data?.data?.redirect || '/password/confirm';
                            }, actionDelay);
                            break;

                        case 429:
                            notify.error(data.message || 'تعداد تلاش بیش از حد مجاز');
                            break;

                        case 500:
                            notify.error(data.message || 'خطای داخلی سرور');
                            break;

                        default:
                            notify.error(data.message || 'خطای ناشناخته');
                    }
                },
            });

        } finally {
            if (loading) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalHtml;
            }
        }
    });
}



// ------------------------------------------
// Field Errors
// ------------------------------------------
function showFieldErrors(errors, form) {
    for (const field in errors) {
        const input = form.querySelector(`[name="${field}"]`);
        input?.closest('.form-group')?.classList.add('is-invalid');

        const el = form.querySelector('#' + field + '_error');

        if (el) {
            el.innerText = errors[field][0];
            el.classList.remove('d-none');
        }
    }
}