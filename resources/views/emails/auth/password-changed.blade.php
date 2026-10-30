@extends('authkit::layouts.email')
@section('title', 'هشدار امنیتی - تغییر رمز عبور')

@section('content')
    <div>
        <p class="title">کاربر گرامی {{ $user->name ?? '' }}، سلام</p>
        <p class="text">
            هشدار امنیتی: رمز عبور حساب کاربری شما با تغییر داده شد.
            اگر این عملیات را خودتان انجام داده‌اید، نیازی به اقدام دیگری نیست.
        </p>


        <div style="margin:15px 0; padding:1rem; background:#222; border-radius:1rem;">
            <p class="text" style="margin:0;"><strong>آی‌پی:</strong> {{ $data['ip'] ?? '-' }}</p>
            <p class="text" style="margin:0.5rem 0 0 0;"><strong>دستگاه:</strong> {{ $data['user_agent'] ?? '-' }}</p>
            <p class="text" style="margin:0.5rem 0 0 0;"><strong>زمان:</strong> {{ $data['time'] ?? now() }}</p>
        </div>

        <p class="text" style="margin-top:20px;">اگر این تغییر توسط شما انجام نشده است، فوراً اقدامات زیر را انجام دهید:</p>

        <ul class="text">
            <li>تغییر فوری رمز عبور (Reset Password)</li>
            <li>بررسی نشست‌های فعال (Devices)</li>
            <li>بررسی فعالیت‌های اخیر حساب</li>
        </ul>
    </div>
@endsection
