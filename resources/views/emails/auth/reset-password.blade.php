@extends('authkit::layouts.email')
@section('title', 'بازیابی رمز عبور')


@section('content')
    <div>
        <p class="title">کاربر گرامی {{ $user->name ?? '' }}، سلام</p>
        <p class="text">
            شما درخواست بازنشانی رمز عبور حساب کاربری خود را ثبت کرده‌اید.
            برای ادامه فرآیند و تعیین رمز عبور جدید، لطفاً از طریق دکمه زیر اقدام نمایید.
        </p>

        <p class="text">این لینک تنها به مدت<strong style="color:#ffffff;">60 دقیقه</strong> معتبر است.</p>

        <a href="{{ $url ?? '' }}" class="link" target="_blank">{{ $url ?? '' }}</a>
        <a href="{{ $url ?? '' }}" class="btn" target="_blank">بازنشانی رمز عبور</a>

        <p class="info">
            اگر این درخواست توسط شما ارسال نشده است، این ایمیل را نادیده بگیرید.
            هیچ تغییری در حساب شما اعمال نخواهد شد.
        </p>
    </div>
@endsection
