@extends('authkit::layouts.dashboard')
@section('page_title', 'تغییر گذرواژه')

@vite(['resources/js/dashboard/change-password.js'], 'vendor/authkit/build')



@section('content')

    <!-- ----------------------------------- -->
    <!-- Change Password -->
    <!-- ----------------------------------- -->
    <div class="card">

        <div class="card-header py-3 d-flex align-items-center justify-content-between">
            <h3 class="m-0 fw-bold fs-18">تغییر گذرواژه</h3>

            <a href="{{ route('dashboard') }}" class="p-1">
                <x-authkit::icons.arrow-left-icon color="var(--secondary)" />
            </a>
        </div>

        <div class="card-body p-4">
            <div class="row g-3">

                <!-- ----------------------------------- -->
                <!-- Password Information -->
                <!-- ----------------------------------- -->
                <div class="col-12 col-md-6">
                    <h4 class="fw-bold fs-15 text-dark mb-3">نکات امنیتی</h4>

                    <p class="text-secondary fw-light fs-14 mb-3">
                        برای حفظ امنیت حساب خود، یک گذرواژه قوی و منحصربه‌فرد انتخاب کنید.
                    </p>

                    <ul class="text-secondary fw-light fs-14 mb-0 ps-4">
                        <li class="mb-2">گذرواژه باید حداقل ۸ کاراکتر داشته باشد.</li>
                        <li class="mb-2">از ترکیب حروف بزرگ و کوچک، اعداد و نمادها استفاده کنید.</li>
                        <li class="mb-2">از گذرواژه‌های تکراری در حساب‌های دیگر استفاده نکنید.</li>
                        <li>برای حفظ امنیت، پس از تغییر گذرواژه از سایر نشست‌های فعال خارج شوید.</li>
                    </ul>
                </div>

                <!-- ----------------------------------- -->
                <!-- Change Password Form -->
                <!-- ----------------------------------- -->
                <div class="col-12 col-md-6">
                    <form id="change-password-form" action="{{ route('password.change') }}" method="POST" novalidate>
                        @csrf

                        <p class="text-secondary fw-light fs-14 mb-4">گذرواژه جدید را وارد کنید.</p>

                        <div class="position-relative">
                            <label class="form-group rounded-3 fw-light p-14 @error('password') is-invalid @enderror d-flex align-items-center justify-content-between gap-2">
                                <input type="password" name="password" class="form-control rounded-0 border-0 p-0" placeholder=" " required autocomplete="new-password" autofocus>
                                <span class="form-label text-secondary fw-light fs-13">گذرواژه جدید</span>
                                <x-authkit::icons.lock-icon color="var(--secondary)" />
                            </label>
                        </div>
                        <span id="password_error" class="fw-medium text-danger fs-12 ms-1 mt-1 d-none"></span>

                        <div class="position-relative mt-20">
                            <label class="form-group rounded-3 fw-light p-14 @error('password_confirmation') is-invalid @enderror d-flex align-items-center justify-content-between gap-2">
                                <input type="password" name="password_confirmation" class="form-control rounded-0 border-0 p-0" placeholder=" " required autocomplete="new-password">
                                <span class="form-label text-secondary fw-light fs-13">تکرار گذرواژه</span>
                                <x-authkit::icons.lock-icon color="var(--secondary)" />
                            </label>
                        </div>
                        <span id="password_confirmation_error" class="fw-medium text-danger fs-12 ms-1 mt-1 d-none"></span>
                    </form>
                </div>
            </div>
        </div>

        <div class="card-footer py-3 bg-transparent border-0 d-flex justify-content-end gap-2">
            <a href="{{ route('dashboard') }}" class="btn text-secondary border-0 px-30 py-12 rounded-3 fw-medium fs-13">انصراف</a>
            <button type="submit" id="submit-change-password-form" form="change-password-form" class="btn btn-outline-primary px-30 py-12 rounded-3 fw-medium fs-13">تغییر گذرواژه</button>
        </div>
    </div>

@endsection
