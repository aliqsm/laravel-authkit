@extends('layouts.email')
@section('title', 'هشدار امنیتی ورود')


@section('content')

    <h1 class="title">ورود جدید به حساب شما</h1>

    <p style="margin-top:20px;">
        سلام {{ $user->name ?? 'کاربر گرامی' }}،<br>
        در تاریخ {{ \Carbon\Carbon::parse($data['time'] ?? now())->format('Y/m/d H:i') }}
        یک ورود جدید به حساب کاربری شما شناسایی شده است.
        جزئیات این ورود در ادامه آمده است.
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
            <span class="detail-label">زمان ورود:</span>
            <span class="detail-value" dir="ltr">{{ \Carbon\Carbon::parse($data['time'] ?? now())->format('Y/m/d H:i') }}</span>
        </div>
    </div>

    <p>
        اگر این ورود توسط شما انجام نشده است، ممکن است شخص دیگری به حساب شما دسترسی پیدا کرده باشد.
        برای محافظت از حساب خود اقدامات زیر را انجام دهید:
    </p>

    <ul class="actions">
        <li>رمز عبور حساب خود را تغییر دهید.</li>
        <li>نشست‌ها و دستگاه‌های فعال را بررسی و خاتمه دهید.</li>
        <li>فعالیت‌های اخیر حساب خود را بررسی کنید.</li>
    </ul>

    <a href="{{ $data['security_url'] ?? '#' }}" target="_blank" class="button">بررسی امنیت حساب</a>

@endsection