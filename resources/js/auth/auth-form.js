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
    redirectDelay = 500,
    successMessage = 'موفق'
} = {}) {

    const form = document.getElementById(formId);
    if (!form) return;

    let submitBtn;
    let originalHtml = '';

    submitBtnId
        ? submitBtn = document.querySelector(`#${submitBtnId}`)
        : submitBtn = form.querySelector('button[type="submit"]')


    // ------------------------------------------
    // Handle Form Submission and Loading
    // ------------------------------------------
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        clearErrors(form);

        if (loading) {
            submitBtn.disabled = true;
            originalHtml = submitBtn.innerHTML;
            submitBtn.innerHTML = `<span class="spinner-border spinner-border-sm" style="color:${loadingColor}; height:${loadingSize}; width:${loadingSize}; border-width: 2px !important;"></span>`;
        }


        // ------------------------------------------
        // Send Request and Handle Response
        // ------------------------------------------
        try {
            const res = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: new FormData(form)
            });

            const data = await res.json();
            console.log(data);

            if (!res.ok) {
                handleError(res.status, data, form);
                return;
            }

            notify.success(data.message || successMessage);


            if (data.data?.redirect) {
                setTimeout(() => { window.location.href = data.data.redirect; }, redirectDelay);
            }

            if (data.data?.refresh) {
                setTimeout(() => { window.location.reload() }, redirectDelay);
            }

        } catch (err) {
            console.error(err);
            notify.error('خطا در اتصال به سرور');

        } finally {
            if (loading) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalHtml;
            }
        }
    });
}



// ------------------------------------------
// Handle Errors
// ------------------------------------------
function handleError(status, data, form) {
    switch (status) {
        case 422:
            if (data.errors && Object.keys(data.errors).length > 0) {
                showFieldErrors(data.errors, form);
            } else {
                notify.error(data.message || 'اطلاعات وارد شده معتبر نمی‌یاشد');
            }
            break;
        case 404:
            notify.error(data.message || 'متاسفانه موردی یافت نشد');
            break
        case 429:
            notify.error(data.message || 'تعداد تلاش بیش از حد مجاز');
            break;
        case 500:
            notify.error(data.message || 'خطای داخلی سرور');
            break;
        default:
            notify.error(data.message || 'خطای ناشناخته');
    }
}



// ------------------------------------------
// Field Errors
// ------------------------------------------
function showFieldErrors(errors, form) {
    for (let field in errors) {
        const input = form.querySelector(`[name="${field}"]`);
        input?.closest('.form-group')?.classList.add('is-invalid');

        const el = form.querySelector('#' + field + '_error');
        if (el) {
            el.innerText = errors[field][0];
            el.classList.remove('d-none');
        }
    }
}



// ------------------------------------------
// Clear Errors
// ------------------------------------------
function clearErrors(form) {
    form.querySelectorAll('.is-invalid')
        .forEach(el => {
            el.classList.remove('is-invalid')
        });

    form.querySelectorAll('[id$="_error"]')
        .forEach(el => {
            el.innerText = '';
            el.classList.add('d-none');
        });
}