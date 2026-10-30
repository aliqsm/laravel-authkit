```blade
@extends('authkit::layouts.email')

@section('title', 'هشدار امنیتی - غیرفعال شدن تأیید دومرحله‌ای')

@section('content')
    <div>
        <p class="title">کاربر گرامی {{ $user->name ?? '' }}، سلام</p>

        <p class="text">تأیید دومرحله‌ای (2FA) حساب کاربری شما غیرفعال شد.</p>
        <p class="text">با غیرفعال شدن این قابلیت، یک لایه امنیتی به محافظت از حساب شما کاهش یافته است.</p>

        <div style="margin:15px 0; padding:1rem; background:#222; border-radius:1rem;">
            <p class="text" style="margin:0;"><strong>آی‌پی:</strong> {{ $data['ip'] ?? '-' }}</p>
            <p class="text" style="margin:0.5rem 0 0 0;"><strong>دستگاه:</strong> {{ $data['user_agent'] ?? '-' }}</p>
            <p class="text" style="margin:0.5rem 0 0 0;"><strong>زمان:</strong> {{ $data['time'] ?? now() }}</p>
        </div>

        <p class="text" style="margin-top:20px;">اگر این تغییر را شما انجام نداده‌اید، توصیه می‌کنیم فوراً اقدامات زیر را انجام دهید:</p>

        <ul class="text">
            <li>رمز عبور حساب خود را تغییر دهید.</li>
            <li>نشست‌ها و دستگاه‌های فعال حساب خود را بررسی کنید.</li>
            <li>تأیید دومرحله‌ای را مجدداً فعال کنید.</li>
        </ul>
    </div>
@endsection
```