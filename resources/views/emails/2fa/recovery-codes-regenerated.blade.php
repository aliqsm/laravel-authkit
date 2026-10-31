@extends('authkit::layouts.email')
@section('title', 'هشدار امنیتی - تولید مجدد کدهای بازیابی')

@section('content')
    <div>
        <p class="title">کاربر گرامی {{ $user->name ?? '' }}، سلام</p>
        <p class="text">کدهای بازیابی تأیید دو مرحله‌ای (2FA) حساب کاربری شما مجدداً تولید شدند.</p>
        <p class="text">با انجام این عملیات، تمام کدهای بازیابی قبلی باطل شده‌اند و دیگر قابل استفاده نیستند.</p>

        <div style="margin:15px 0; padding:1rem; background:#222; border-radius:1rem;">
            <p class="text" style="margin:0;"><strong>آی‌پی:</strong> {{ $data['ip'] ?? '-' }}</p>
            <p class="text" style="margin:0.5rem 0 0 0;"><strong>دستگاه:</strong> {{ $data['user_agent'] ?? '-' }}</p>
            <p class="text" style="margin:0.5rem 0 0 0;"><strong>زمان:</strong> {{ $data['time'] ?? now() }}</p>
        </div>

        <p class="text" style="margin-top:20px;">اگر این عملیات توسط شما انجام نشده است، فوراً اقدامات زیر را انجام دهید:</p>

        <ul class="text">
            <li>تغییر رمز عبور حساب کاربری</li>
            <li>بررسی نشست‌های فعال (Devices)</li>
            <li>بررسی وضعیت تأیید دو مرحله‌ای حساب</li>
            <li>تماس با پشتیبانی در صورت نیاز</li>
        </ul>
    </div>
@endsection