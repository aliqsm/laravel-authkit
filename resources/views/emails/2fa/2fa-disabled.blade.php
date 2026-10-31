@extends('layouts.email')
@section('title', 'هشدار امنیتی - غیرفعال شدن تأیید دومرحله‌ای')


@section('content')

    <h1 class="title">غیرفعال شدن تأیید دومرحله‌ای</h1>

    <p style="margin-top:20px;">
        سلام {{ $user->name ?? 'کاربر گرامی' }}،<br>
        قابلیت تأیید دومرحله‌ای (2FA) حساب کاربری شما با موفقیت غیرفعال شد.
        با غیرفعال شدن این قابلیت، یک لایه امنیتی از حساب شما حذف شده و ورود به حساب دیگر به این مرحله تأیید نیاز نخواهد داشت.
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
        برای محافظت از حساب خود، توصیه می‌کنیم اقدامات زیر را در اسرع وقت انجام دهید:
    </p>

    <ul class="actions">
        <li>رمز عبور حساب خود را تغییر دهید.</li>
        <li>نشست‌ها و دستگاه‌های فعال را بررسی و خاتمه دهید.</li>
        <li>تأیید دومرحله‌ای را مجدداً فعال کنید.</li>
    </ul>

@endsection