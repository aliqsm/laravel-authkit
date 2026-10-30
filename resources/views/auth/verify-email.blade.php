@extends('authkit::layouts.auth')
@section('page_title', 'تأیید حساب کاربری')

@vite(['resources/js/auth/verification-email.js'])



@section('content')
    <form id="send-verification-email-form" action="{{ route('verification.send') }}" method="POST" novalidate class="w-100 position-absolute top-50 start-50 translate-middle w-100 bg-white">
        @csrf

        <h1 class="text-dark fw-bold fs-5 text-center mb-2">تأیید حساب کاربری</h1>
        <p class="fw-light text-secondary fs-14 fs-md-500 lh-lg text-start mt-20 mb-0">
            با سلام<br>
            لحظاتی پیش ایمیل تأیید حساب به آدرس ایمیل شما ارسال شد. چنانچه تا <strong class="fw-medium text-dark">۲ دقیقه</strong> آینده ایمیلی دریافت نکردید، لطفاً مجدداً درخواست ارسال ایمیل تأیید را ثبت کنید.
        </p>

        <button type="submit" class="btn btn-primary w-100 mt-30 py-14 rounded-3 fw-medium fs-14">ارسال مجدد لینک تایید</button>
        <a href="{{ route('home') }}" class="d-block text-secondary text-decoration-none mt-16 text-center fw-medium fs-13">بازگشت به خانه</a>
    </form>
@endsection
