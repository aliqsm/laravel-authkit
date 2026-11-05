import initAuthForm from './auth-form.js';

// -------------------------------------
// Confirm Password
// -------------------------------------
initAuthForm({
    formId: 'confirm-password-form',
    successMessage: 'عملیات موفق'
});


// -------------------------------------
// Send Password Reset Link
// -------------------------------------
initAuthForm({
    formId: 'password-reset-link-form',
    loadingColor: '#000',
    redirectDelay:3000
});