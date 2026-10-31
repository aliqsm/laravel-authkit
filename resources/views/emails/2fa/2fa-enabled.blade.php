@extends('authkit::layouts.email')
@section('title', 'هشدار امنیتی - فعال شدن تأیید دومرحله‌ای')


@section('content')

    <h1 class="title">فعال شدن تأیید دومرحله‌ای</h1>

    <p style="margin-top:20px;">
        سلام {{ $user->name ?? 'کاربر گرامی' }}،<br>
        قابلیت تأیید دومرحله‌ای (2FA) حساب کاربری شما با موفقیت فعال شد.
        از این پس، علاوه بر رمز عبور، برای ورود به حساب خود باید مرحله دوم تأیید هویت را نیز تکمیل کنید.
        این قابلیت یک لایه امنیتی اضافی برای محافظت از حساب شما در برابر دسترسی‌های غیرمجاز فراهم می‌کند.
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
        اگر این تغییر توسط شما انجام نشده است، ممکن است شخص دیگری به حساب شما دسترسی داشته باشد.
        برای اطمینان از امنیت حساب خود، اقدامات زیر را انجام دهید:
    </p>

    <ul class="actions">
        <li>رمز عبور حساب خود را تغییر دهید.</li>
        <li>نشست‌ها و دستگاه‌های فعال را بررسی و در صورت لزوم خاتمه دهید.</li>
        <li>در صورت مشاهده فعالیت مشکوک، با تیم پشتیبانی تماس بگیرید.</li>
    </ul>

@endsection