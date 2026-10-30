@extends('authkit::layouts.dashboard')
@section('page_title', 'داشبورد')

@section('content')

    <div class="mb-4">
        <h1 class="fs-20 fw-bold text-body mb-2">تنظیمات حساب</h1>
        <p class="fs-14 text-secondary m-0">امنیت حساب و نشست‌های فعال خود را مدیریت کنید.</p>
    </div>



    <div class="bg-body rounded-4 px-3 px-md-4">

        <!-- ------------------------------------- -->
        <!-- Edit Account -->
        <!-- ------------------------------------- -->
        @if (config('authkit.features.update_profile_information', true))
            <div class="d-flex flex-wrap flex-md-nowrap align-items-center gap-3 py-4 border-bottom">
                <div class="d-flex align-items-center justify-content-center flex-shrink-0 rounded-4 bg-light border border-secondary" style="width: 50px; height: 50px;">
                    <x-authkit::icons.user-icon3 color="var(--secondary)" />
                </div>

                <div class="flex-grow-1 min-w-0">
                    <h2 class="fs-15 fw-semibold text-body mb-2">ویرایش حساب</h2>
                    <p class="fs-13 text-secondary lh-lg mb-0">اطلاعات حساب کاربری خود را مشاهده و ویرایش کنید.</p>
                </div>

                <a href="{{ route('profile.edit') }}" class="btn btn-outline-dark rounded-3 fs-13 fw-medium px-20 py-12 py-md-2 col-12 col-md-auto flex-shrink-0">
                    ویرایش حساب
                </a>
            </div>
        @endif



        <!-- ------------------------------------- -->
        <!-- Change Password -->
        <!-- ------------------------------------- -->
        @if (config('authkit.features.change_password', true))
            <div class="d-flex flex-wrap flex-md-nowrap align-items-center gap-3 py-4 border-bottom">
                <div class="d-flex align-items-center justify-content-center flex-shrink-0 rounded-4 bg-light border border-secondary" style="width: 50px; height: 50px;">
                    <x-authkit::icons.lock-icon color="var(--secondary)" />
                </div>

                <div class="flex-grow-1 min-w-0">
                    <h2 class="fs-15 fw-semibold text-body mb-2">گذرواژه</h2>
                    <p class="fs-13 text-secondary lh-lg mb-0">گذرواژه حساب خود را تغییر دهید و از رمز عبور قوی و غیرتکراری استفاده کنید.</p>
                </div>

                <a href="{{ route('password.edit') }}" class="btn btn-outline-dark rounded-3 fs-13 fw-medium px-20 py-12 py-md-2 col-12 col-md-auto flex-shrink-0">
                    تغییر گذرواژه
                </a>
            </div>
        @endif


        <!-- ------------------------------------- -->
        <!-- Browser Sessions -->
        <!-- ------------------------------------- -->
        <div class="d-flex flex-wrap flex-md-nowrap align-items-center gap-3 py-4 border-bottom">
            <div class="d-flex align-items-center justify-content-center flex-shrink-0 rounded-4 bg-light border border-secondary" style="width: 50px; height: 50px;">
                <x-authkit::icons.monitor-mobbile-icon :width="28" :height="28" color="var(--secondary)" />
            </div>

            <div class="flex-grow-1 min-w-0">
                <h2 class="fs-15 fw-semibold text-body mb-2">نشست‌های مرورگر</h2>
                <p class="fs-13 text-secondary lh-lg mb-0">نشست‌های فعال حساب را بررسی کنید و در صورت مشاهده دستگاه ناشناس، آن را خاتمه دهید.</p>
            </div>

            <a href="{{ route('dashboard.sessions.index') }}" class="btn btn-outline-dark rounded-3 fs-13 fw-medium px-20 py-12 py-md-2 col-12 col-md-auto flex-shrink-0">
                مدیریت نشست‌ها
            </a>
        </div>



        <!-- ------------------------------------- -->
        <!-- Security Activities -->
        <!-- ------------------------------------- -->
        @if (config('authkit.features.security_activities', true))
            <div class="d-flex flex-wrap flex-md-nowrap align-items-center gap-3 py-4 border-bottom">
                <div class="d-flex align-items-center justify-content-center flex-shrink-0 rounded-4 bg-light border border-secondary" style="width: 50px; height: 50px;">
                    <x-authkit::icons.security-safe-icon :width="28" :height="28" color="var(--secondary)" />
                </div>

                <div class="flex-grow-1 min-w-0">
                    <h2 class="fs-15 fw-semibold text-body mb-2">فعالیت‌های امنیتی</h2>
                    <p class="fs-13 text-secondary lh-lg mb-0">سوابق ورود به حساب، تغییر رمز عبور و سایر فعالیت‌های امنیتی را مشاهده کنید.</p>
                </div>

                <a href="{{ route('dashboard.security-activities.index') }}" class="btn btn-outline-dark rounded-3 fs-13 fw-medium px-20 py-12 py-md-2 col-12 col-md-auto flex-shrink-0">
                    مشاهده فعالیت‌ها
                </a>
            </div>
        @endif


        <!-- ------------------------------------- -->
        <!-- Two Factor Authentication -->
        <!-- ------------------------------------- -->
        @if (config('authkit.features.two_factor_authentication', true))
            <div class="d-flex flex-wrap flex-md-nowrap align-items-center gap-3 py-4 border-bottom">
                <div class="d-flex align-items-center justify-content-center flex-shrink-0 rounded-4 bg-light border border-secondary" style="width: 50px; height: 50px;">
                    <x-authkit::icons.key-icon color="var(--secondary)" />
                </div>

                <div class="flex-grow-1 min-w-0">
                    <h2 class="fs-15 fw-semibold text-body mb-2">احراز هویت دو مرحله‌ای</h2>
                    <p class="fs-13 text-secondary lh-lg mb-0">برای محافظت بیشتر، هنگام ورود از کد موقت اپلیکیشن احراز هویت استفاده کنید.</p>
                </div>

                <a href="{{ route('two-factor.index') }}" class="btn btn-outline-dark rounded-3 fs-13 fw-medium px-20 py-12 py-md-2 col-12 col-md-auto flex-shrink-0">
                    {{ auth()->user()->hasEnabledTwoFactorAuthentication() ? 'مدیریت' : 'فعال‌سازی' }}
                </a>
            </div>
        @endif



        <!-- ------------------------------------- -->
        <!-- Logout -->
        <!-- ------------------------------------- -->
        <div class="d-flex flex-wrap flex-md-nowrap align-items-center gap-3 py-4">
            <div class="d-flex align-items-center justify-content-center flex-shrink-0 rounded-4 bg-danger-subtle" style="width: 50px; height: 50px;">
                <x-authkit::icons.logout-icon :width="28" :height="28" color="var(--bs-danger)" />
            </div>

            <div class="flex-grow-1 min-w-0">
                <h2 class="fs-15 fw-semibold text-body mb-2">خروج از حساب کاربری</h2>
                <p class="fs-13 text-secondary lh-lg mb-0">از حساب کاربری خود خارج شوید و برای دسترسی مجدد، دوباره وارد شوید.</p>
            </div>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="col-12 col-md-auto flex-shrink-0">
                @csrf
                <button type="submit" class="btn btn-outline-danger rounded-3 fs-13 fw-medium px-20 py-12 py-md-2 w-100">خروج از حساب</button>
            </form>
        </div>

    </div>

@endsection
