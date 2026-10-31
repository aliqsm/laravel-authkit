@extends('authkit::layouts.email')
@section('title', 'هشدار امنیتی - ورود به حساب کاربری')

@section('content')
    <div>
        <p class="title">کاربر گرامی {{ $user->name ?? '' }}، سلام</p>
        <p class="text">یک ورود جدید به حساب کاربری شما شناسایی شد.</p>
        <p class="text">اگر این ورود توسط شما انجام شده باشد، نیازی به اقدام خاصی نیست.</p>


        <div style="margin:15px 0; padding:1rem; background:#222; border-radius:1rem;">
            <p class="text" style="margin:0;"><strong>آی‌پی:</strong> {{ $data['ip'] ?? '-' }}</p>
            <p class="text" style="margin:0.5rem 0 0 0;"><strong>دستگاه:</strong> {{ $data['user_agent'] ?? '-' }}</p>
            <p class="text" style="margin:0.5rem 0 0 0;"><strong>زمان:</strong> {{ $data['time'] ?? now() }}</p>
        </div>

        <p class="text" style="margin-top:20px;"> اگر این ورود توسط شما نبوده است، فوراً اقدامات زیر را انجام دهید:</p>

        <ul class="text">
            <li>تغییر رمز عبور حساب کاربری</li>
            <li>خروج از همه دستگاه‌های فعال</li>
            <li>بررسی امنیت حساب</li>
        </ul>
    </div>
@endsection
