@extends('layouts.email')
@section('title', 'هشدار امنیتی - تغییر رمز عبور')


@section('content')

    <h1 class="title">تغییر رمز عبور</h1>

    <p style="margin-top:20px;">
        سلام {{ $user->name ?? 'کاربر گرامی' }}،<br>
        رمز عبور حساب کاربری شما با موفقیت تغییر داده شد.
        از این پس برای ورود باید از رمز عبور جدید استفاده کنید.
        اگر این عملیات توسط شما انجام شده است، نیازی به اقدام دیگری نیست.
    </p>

    <div class="details">
        <div class="detail">
            <span class="detail-label">آدرس IP:</span>
            <span class="detail-value" dir="ltr">{{ $data['ip'] ?? '-' }}</span>
        </div>

        <div class="detail">
            <span class="detail-label">دستگاه و مرورگر:</span>
            <span class="detail-value" dir="ltr">{{ $data['user_agent'] ?? '-' }}</span>
        </div>

        <div class="detail">
            <span class="detail-label">زمان تغییر:</span>
            <span class="detail-value" dir="ltr">{{ \Carbon\Carbon::parse($data['time'] ?? now())->format('Y/m/d H:i') }}</span>
        </div>
    </div>

    <p>
        اگر این تغییر توسط شما انجام نشده است، ممکن است شخص دیگری به حساب شما دسترسی پیدا کرده باشد.
        برای محافظت از حساب خود اقدامات زیر را انجام دهید:
    </p>

    <ul class="actions">
        <li>رمز عبور حساب خود را فوراً تغییر دهید.</li>
        <li>نشست‌ها و دستگاه‌های فعال را بررسی و خاتمه دهید.</li>
        <li>فعالیت‌های اخیر حساب خود را بررسی کنید.</li>
    </ul>

@endsection