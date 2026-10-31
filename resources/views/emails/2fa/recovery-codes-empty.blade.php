@extends('authkit::layouts.email')

@section('title', 'هشدار امنیتی - اتمام کدهای بازیابی')

@section('content')
    <div>
        <p class="title">کاربر گرامی {{ $user->name ?? '' }}، سلام</p>

        <p class="text">تمام کدهای بازیابی تأیید دومرحله‌ای حساب کاربری شما مصرف شده‌اند.</p>

        <p class="text">از این پس، برای ورود با تأیید دومرحله‌ای باید از برنامه احراز هویت خود استفاده کنید؛ مگر اینکه کدهای بازیابی جدیدی تولید کنید.</p>

        <div style="margin:15px 0; padding:1rem; background:#222; border-radius:1rem;">
            <p class="text" style="margin:0;"><strong>آی‌پی:</strong> {{ $data['ip'] ?? '-' }}</p>
            <p class="text" style="margin:0.5rem 0 0 0;"><strong>زمان:</strong> {{ $data['time'] ?? now() }}</p>
        </div>

        <p class="text" style="margin-top:20px;">برای حفظ امنیت حساب خود، توصیه می‌شود وارد تنظیمات امنیتی شوید و کدهای بازیابی جدید تولید کنید.</p>

        <p class="text">اگر آخرین کد بازیابی را خودتان مصرف نکرده‌اید، رمز عبور خود را تغییر دهید و نشست‌های فعال حساب را بررسی کنید.</p>
    </div>
@endsection