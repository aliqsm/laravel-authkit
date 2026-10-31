@extends('authkit::layouts.email')
@section('title', 'هشدار امنیتی - تولید مجدد کدهای بازیابی')

@section('content')

    <h1 class="title">تولید مجدد کدهای بازیابی</h1>

    <p style="margin-top:20px;">
        سلام {{ $user->name ?? 'کاربر گرامی' }}،<br>
        کدهای بازیابی تأیید دومرحله‌ای (2FA) حساب کاربری شما با موفقیت مجدداً تولید شدند.
        با انجام این عملیات، تمام کدهای قبلی باطل شده‌اند و دیگر قابل استفاده نیستند.
    </p>

    <p style="margin-top:16px;">
        توصیه می‌کنیم کدهای جدید را در مکانی امن نگهداری کنید و از در اختیار قرار دادن آن‌ها به دیگران خودداری کنید.
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
            <span class="detail-label">زمان عملیات:</span>
            <span class="detail-value" dir="ltr">{{ \Carbon\Carbon::parse($data['time'] ?? now())->format('Y/m/d H:i') }}</span>
        </div>
    </div>

    <p>
        اگر این عملیات توسط شما انجام نشده است، برای محافظت از حساب خود رمز عبور را تغییر دهید،
        نشست‌های فعال را بررسی کنید و در صورت نیاز با پشتیبانی تماس بگیرید.
    </p>

@endsection