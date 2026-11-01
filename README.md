# Laravel AuthKit

پکیج **Laravel AuthKit** مجموعه‌ای از قابلیت‌های احراز هویت برای پروژه‌های Laravel است که با هدف استفاده مجدد از منطق احراز هویت و کاهش کدنویسی تکراری توسعه داده شده است.

این پکیج از دو حالت Web و API پشتیبانی می‌کند و امکاناتی مانند ثبت‌نام، ورود، ورود با Google، احراز هویت دومرحله‌ای، بازیابی رمز عبور و مدیریت اطلاعات حساب کاربری را فراهم می‌کند.

---

## 1. پیش‌نیازها

پیش از نصب پکیج، موارد زیر باید در پروژه فراهم باشند:

- PHP 8.2 یا بالاتر
- Laravel 12 یا 13
- Bootstrap 5.3
- Node.js و NPM برای شخصی‌سازی و Build فایل‌های CSS و JavaScript

وابستگی‌های اصلی پکیج به‌صورت خودکار توسط Composer نصب می‌شوند.

---

## 2. نصب

برای نصب پکیج، دستور زیر را در ترمینال پروژه اجرا کنید:

```bash
composer require aliqsm/laravel-authkit
```

پس از نصب، Service Provider پکیج به‌صورت خودکار توسط Laravel شناسایی می‌شود.

برای استفاده از Bootstrap نیز در صورت نصب نبودن آن، دستور زیر را اجرا کنید:

```bash
npm install bootstrap
```

### آماده‌سازی مدل User

برای فعال شدن قابلیت‌های موردنیاز پکیج، Trait مربوط به AuthKit را به مدل User اضافه کنید:

```php
use HasAuthKit;
```

> Trait را از Namespace مربوط به پکیج وارد کنید.

### آماده‌سازی جدول Notifications

پکیج برای ذخیره برخی اعلان‌ها از سیستم Notification لاراول استفاده می‌کند.

در صورت نبودن جدول Notifications، دستور زیر را اجرا کنید:

```bash
php artisan make:notifications-table
php artisan migrate
```

---

## 3. انتشار فایل‌ها

پکیج فایل‌های مختلفی دارد که در صورت نیاز می‌توانید آن‌ها را در پروژه خود منتشر کنید.

### تنظیمات

برای انتشار فایل تنظیمات:

```bash
php artisan vendor:publish --tag=authkit-config
```

فایل تنظیمات در مسیر زیر قرار می‌گیرد:

```text
config/authkit.php
```

### فایل‌های خام CSS و JavaScript

برای انتشار فایل‌های خام و قابل ویرایش:

```bash
php artisan vendor:publish --tag=authkit-assets
```

فایل‌ها در مسیرهای زیر قرار می‌گیرند:

```text
resources/vendor/authkit/css
resources/vendor/authkit/js
```

### فایل‌های Build شده

برای انتشار فایل‌های آماده استفاده در مرورگر:

```bash
php artisan vendor:publish --tag=authkit-build
```

فایل‌ها در مسیر زیر قرار می‌گیرند:

```text
public/vendor/authkit/build
```

### فونت‌ها

برای انتشار فونت‌های پکیج:

```bash
php artisan vendor:publish --tag=authkit-fonts
```

فایل‌ها در مسیر زیر قرار می‌گیرند:

```text
public/vendor/authkit/fonts
```

### Viewها

برای انتشار Viewهای پکیج و امکان ویرایش آن‌ها:

```bash
php artisan vendor:publish --tag=authkit-views
```

فایل‌ها در مسیر زیر قرار می‌گیرند:

```text
resources/views/vendor/authkit
```

در صورت انتشار Viewها، نسخه موجود در پروژه جایگزین نسخه داخلی پکیج برای نمایش می‌شود.

---

## 4. تنظیمات پکیج

تمام تنظیمات اصلی پکیج در فایل زیر قرار دارند:

```text
config/authkit.php
```

### حالت اجرا

گزینه `app_mode` مشخص می‌کند پکیج در چه حالتی اجرا شود.

```php
'app_mode' => 'web',
```

دو مقدار قابل استفاده:

| مقدار | توضیحات |
|---|---|
| `web` | استفاده از مسیرها و جریان احراز هویت مبتنی بر Web و Blade |
| `api` | استفاده از مسیرهای API |

در حالت `web`، مسیرهای تعریف‌شده در `routes/web.php` و در حالت `api`، مسیرهای `routes/api.php` بارگذاری می‌شوند.

### آدرس Frontend

```php
'frontend_url' => '',
```

آدرس Frontend پروژه که در جریان‌های مربوط به API مورد استفاده قرار می‌گیرد.

### مدیریت قابلیت‌ها

از طریق گزینه `features` می‌توانید قابلیت‌های مختلف پکیج را فعال یا غیرفعال کنید.

```php
'features' => [
    'registration' => true,
    'google_login' => true,
    'two_factor_authentication' => true,
    'update_profile_information' => true,
    'change_password' => true,
    'security_activities' => true,
    'password_reset' => true,
],
```

| گزینه | توضیحات |
|---|---|
| `registration` | ثبت‌نام کاربران |
| `google_login` | ورود با حساب Google |
| `two_factor_authentication` | احراز هویت دومرحله‌ای |
| `update_profile_information` | ویرایش اطلاعات پروفایل |
| `change_password` | تغییر رمز عبور |
| `security_activities` | مشاهده فعالیت‌های امنیتی |
| `password_reset` | بازیابی رمز عبور |

مقدار `true` قابلیت را فعال و مقدار `false` آن را غیرفعال می‌کند.

**نکته:** غیرفعال کردن یک قابلیت لزوماً به معنی حذف مسیرهای آن نیست. به‌خصوص برای قابلیت‌هایی مانند 2FA باید وضعیت کاربران فعلی را در نظر بگیرید.

### تنظیمات احراز هویت دومرحله‌ای

تنظیمات مربوط به 2FA در بخش `two_factor` قرار دارند:

```php
'two_factor' => [
    'challenge_expire_minutes' => 10,
    'setup_expire_minutes' => 10,
    'recovery_code_length' => 12,
    'recovery_codes_count' => 6,
],
```

| گزینه | توضیحات |
|---|---|
| `challenge_expire_minutes` | مدت اعتبار درخواست تأیید دومرحله‌ای |
| `setup_expire_minutes` | مدت اعتبار فرایند راه‌اندازی 2FA |
| `recovery_code_length` | تعداد کاراکترهای هر کد بازیابی |
| `recovery_codes_count` | تعداد کدهای بازیابی تولیدشده |

مقادیر پیش‌فرض این تنظیمات از طریق متغیرهای محیطی نیز قابل تغییر هستند:

```env
TWO_FACTOR_CHALLENGE_EXPIRE_MINUTES=10
TWO_FACTOR_SETUP_EXPIRE_MINUTES=10
TWO_FACTOR_RECOVERY_CODE_LENGTH=12
TWO_FACTOR_RECOVERY_CODES_COUNT=6
```

### تنظیمات فونت

در بخش `font` می‌توانید فونت مورد استفاده در Viewهای پکیج را تغییر دهید.

```php
'font' => [
    'family' => 'ExampleFont',
    'fallback' => 'Tahoma, Arial, sans-serif',
    'weights' => [
        400 => 'fonts/example-font/ExampleFont-Regular.woff2',
        500 => 'fonts/example-font/ExampleFont-Medium.woff2',
        700 => 'fonts/example-font/ExampleFont-Bold.woff2',
    ],
],
```

- `family`: نام فونت اصلی
- `fallback`: فونت‌های جایگزین
- `weights`: مسیر فایل‌های فونت بر اساس وزن آن‌ها

در صورت استفاده از فونت اختصاصی، فایل‌های آن را در مسیر فونت‌های منتشرشده قرار دهید.

---

## 5. تنظیمات OAuth

برای استفاده از ورود با Google، علاوه بر فعال بودن قابلیت `google_login`، باید اطلاعات OAuth را در پروژه تنظیم کنید.

### ایجاد OAuth Application

ابتدا وارد پنل توسعه‌دهندگان Google شوید و یک OAuth Client ایجاد کنید.

سپس اطلاعات زیر را دریافت کنید:

- Client ID
- Client Secret
- Redirect URI

### تنظیم فایل services.php

فایل زیر را باز کنید:

```text
config/services.php
```

تنظیمات Google را به آرایه سرویس‌ها اضافه کنید:

```php
'google' => [
    'client_id' => env('GOOGLE_CLIENT_ID'),
    'client_secret' => env('GOOGLE_CLIENT_SECRET'),
    'redirect' => env('GOOGLE_REDIRECT_URI'),
],
```

### تنظیم فایل .env

مقادیر دریافت‌شده را در فایل `.env` قرار دهید:

```env
GOOGLE_CLIENT_ID=
GOOGLE_CLIENT_SECRET=
GOOGLE_REDIRECT_URI=
```

**نکته:** مقدار Redirect URI باید دقیقاً با آدرسی که در پنل Google ثبت کرده‌اید مطابقت داشته باشد.

---

## 6. فایل‌های CSS و JavaScript و Vite

پکیج برای مدیریت فایل‌های CSS و JavaScript از Vite استفاده می‌کند.

برای استفاده از فایل‌ها دو روش وجود دارد:

### روش اول: استفاده از فایل‌های Build شده

این روش ساده‌ترین راه برای استفاده از فایل‌های پکیج است.

ابتدا فایل‌های Build شده را منتشر کنید:

```bash
php artisan vendor:publish --tag=authkit-build
```

فایل‌ها در مسیر زیر قرار می‌گیرند:

```text
public/vendor/authkit/build
```

سپس در فایل‌های Blade از دستور `@vite` استفاده کنید:

```php
@vite(['resources/js/auth/two-factor-challenge.js'], 'vendor/authkit/build')
```

آرگومان دوم مشخص‌کننده مسیر Build Directory نسبت به پوشه `public` است.

در این مثال، Vite فایل Manifest را از مسیر زیر می‌خواند:

```text
public/vendor/authkit/build/manifest.json
```

**نکته:** نام فایل ورودی در `@vite` باید دقیقاً با کلید متناظر آن در `manifest.json` یکسان باشد.

در این روش نیازی به انتشار فایل‌های خام یا اجرای مجدد Build در پروژه مصرف‌کننده نیست.

### روش دوم: شخصی‌سازی فایل‌ها

اگر قصد دارید فایل‌های CSS یا JavaScript پکیج را تغییر دهید، ابتدا فایل‌های خام را منتشر کنید:

```bash
php artisan vendor:publish --tag=authkit-assets
```

فایل‌ها در مسیرهای زیر قرار می‌گیرند:

```text
resources/vendor/authkit/css
resources/vendor/authkit/js
```

پس از اعمال تغییرات، باید ورودی‌های موردنیاز را در `vite.config.js` پروژه خود معرفی کنید و با Vite عملیات Build را انجام دهید.

برای نمونه، ورودی JavaScript:

```js
'resources/vendor/authkit/js/auth/two-factor-challenge.js'
```

در این حالت، مسیر ورودی در `@vite` نیز باید با کلید ثبت‌شده در Manifest جدید مطابقت داشته باشد.

پس از Build، فایل‌های تولیدشده و Manifest باید در مسیر Build Directory مورد استفاده قرار بگیرند.

**توجه:** در این روش، فایل‌های Build شده قبلی پکیج را با خروجی جدید جایگزین کنید یا Build Directory اختصاصی خود را تنظیم کنید. دو Manifest مستقل را بدون هماهنگی مسیرها با یکدیگر ترکیب نکنید.

---

## 7. Viewها و Layoutها

پکیج Viewهای خود را از طریق Namespace اختصاصی `authkit` بارگذاری می‌کند.

برای مثال، استفاده از Layout داخلی پکیج به شکل زیر است:

```blade
@extends('authkit::layouts.auth')
```

در این ساختار، `authkit` نام Namespace و `layouts.auth` مسیر View نسبت به پوشه Viewهای پکیج است.

### شخصی‌سازی Viewها

برای تغییر Viewهای داخلی پکیج، ابتدا آن‌ها را منتشر کنید:

```bash
php artisan vendor:publish --tag=authkit-views
```

سپس فایل موردنظر را در مسیر زیر ویرایش کنید:

```text
resources/views/vendor/authkit
```

Laravel در صورت وجود نسخه منتشرشده، آن را به‌جای View داخلی پکیج استفاده می‌کند.

---

## 8. Migrationها

پکیج Migrationهای موردنیاز خود را به‌صورت خودکار بارگذاری می‌کند.

برای اجرای Migrationها:

```bash
php artisan migrate
```

در صورت نیاز به انتشار Migrationها در پروژه، دستور زیر را اجرا کنید:

```bash
php artisan vendor:publish --tag=authkit-migrations
```

پکیج برای قابلیت‌هایی مانند ورود با Google و 2FA، ستون‌های زیر را به جدول `users` اضافه می‌کند:

| ستون | کاربرد |
|---|---|
| `google_id` | شناسه حساب Google کاربر |
| `two_factor_secret` | کلید محرمانه احراز هویت دومرحله‌ای |
| `two_factor_recovery_codes` | کدهای بازیابی 2FA |

**نکته:** اگر Migrationها را منتشر کرده‌اید، از اجرای نسخه منتشرشده و نسخه داخلی پکیج به‌صورت تکراری جلوگیری کنید.

---

## 9. محدودیت درخواست‌ها (Rate Limiting)

پکیج برای محافظت از مسیرهای حساس در برابر درخواست‌های بیش‌ازحد، از Rate Limiter داخلی Laravel استفاده می‌کند.

محدودیت‌ها بر اساس IP، شناسه کاربر یا ایمیل اعمال می‌شوند.

### محدودیت‌های احراز هویت

| عملیات | محدودیت IP | محدودیت کاربر / ایمیل |
|---|---:|---:|
| صفحات احراز هویت | 120 درخواست در 30 دقیقه | — |
| ورود | 60 درخواست در 30 دقیقه | 10 درخواست در 30 دقیقه |
| خروج | 30 درخواست در 30 دقیقه | 15 درخواست در 30 دقیقه |
| ثبت‌نام | 20 درخواست در 30 دقیقه | 5 درخواست در 30 دقیقه |
| تأیید ایمیل | 30 درخواست در 30 دقیقه | 10 درخواست در 30 دقیقه |
| ارسال مجدد ایمیل تأیید | 30 درخواست در 30 دقیقه | 1 درخواست در 2 دقیقه |
| درخواست بازیابی رمز عبور | 30 درخواست در 30 دقیقه | 5 درخواست در 30 دقیقه |
| بازنشانی رمز عبور | 30 درخواست در 30 دقیقه | 10 درخواست در 30 دقیقه |
| تأیید رمز عبور | 30 درخواست در 30 دقیقه | 10 درخواست در 30 دقیقه |

### محدودیت‌های 2FA

| عملیات | محدودیت IP | محدودیت کاربر |
|---|---:|---:|
| فعال‌سازی 2FA | 15 درخواست در 30 دقیقه | 10 درخواست در 30 دقیقه |
| غیرفعال‌سازی 2FA | 15 درخواست در 30 دقیقه | 10 درخواست در 30 دقیقه |
| تولید کد بازیابی | 15 درخواست در 30 دقیقه | 5 درخواست در 30 دقیقه |
| تأیید 2FA | 15 درخواست در 30 دقیقه | 10 درخواست در 30 دقیقه |

### محدودیت‌های داشبورد

| عملیات | محدودیت IP | محدودیت کاربر |
|---|---:|---:|
| ویرایش پروفایل | 30 درخواست در 30 دقیقه | 10 درخواست در 30 دقیقه |
| تغییر رمز عبور | 20 درخواست در 30 دقیقه | 5 درخواست در 30 دقیقه |

**نکات:**

- محدودیت‌ها به‌صورت هم‌زمان بر اساس IP و شناسه کاربر یا ایمیل اعمال می‌شوند.
- با عبور از هر یک از محدودیت‌ها، درخواست تا پایان بازه محدودیت پذیرفته نمی‌شود.
- برای عملکرد صحیح محدودیت‌ها، Cache پروژه باید به‌درستی پیکربندی شده باشد.
- محدودیت‌های تعریف‌شده در Service Provider پکیج ثبت می‌شوند و با نام‌های مشخص در Routeها قابل استفاده هستند.

---

## 10. مجوز استفاده

این پکیج تحت مجوز MIT منتشر شده است.
