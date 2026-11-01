# Laravel AuthKit

پکیج احراز هویت لاراول با پشتیبانی از Web و API و امکاناتی مانند ثبت‌نام، ورود با Google، احراز هویت دومرحله‌ای، بازیابی رمز عبور و مدیریت حساب کاربری.

## پیش‌نیازها

- PHP 8.2+
- Laravel 12 یا 13
- Bootstrap 5.3+

## نصب و راه‌اندازی

نصب پکیج:

```bash
composer require aliqsm/laravel-authkit
```

نصب Bootstrap در صورت نیاز:

```bash
npm install bootstrap
```

Trait پکیج را به مدل `User` اضافه کنید:

```php
use HasAuthKit;
```

سپس Migrationها را اجرا کنید:

```bash
php artisan migrate
```

در صورت نبودن جدول Notifications:

```bash
php artisan make:notifications-table
php artisan migrate
```

## انتشار تنظیمات

برای انتشار فایل تنظیمات:

```bash
php artisan vendor:publish --tag=authkit-config
```

فایل تنظیمات در `config/authkit.php` قرار می‌گیرد.

## تنظیمات اصلی

در فایل `config/authkit.php` می‌توانید موارد زیر را مدیریت کنید:

| گزینه | توضیحات |
|---|---|
| `app_mode` | تعیین حالت اجرا: `web` یا `api` |
| `frontend_url` | آدرس Frontend در حالت API |
| `features` | فعال یا غیرفعال کردن قابلیت‌ها |
| `two_factor` | تنظیمات احراز هویت دومرحله‌ای |
| `font` | تنظیم فونت و وزن‌های آن |

برای فعال یا غیرفعال کردن قابلیت‌ها، مقدار مربوطه را در بخش `features` تغییر دهید.

## ورود با Google (OAuth)

ابتدا در پنل توسعه‌دهندگان Google یک OAuth Client ایجاد کنید.

سپس تنظیمات زیر را به `config/services.php` اضافه کنید:

```php
'google' => [
    'client_id' => env('GOOGLE_CLIENT_ID'),
    'client_secret' => env('GOOGLE_CLIENT_SECRET'),
    'redirect' => env('GOOGLE_REDIRECT_URI'),
],
```

مقادیر دریافتی را در فایل `.env` قرار دهید:

```env
GOOGLE_CLIENT_ID=
GOOGLE_CLIENT_SECRET=
GOOGLE_REDIRECT_URI=
```

آدرس Redirect باید با آدرس ثبت‌شده در پنل Google یکسان باشد.

## فایل‌ها و شخصی‌سازی

پکیج امکان انتشار فایل‌های مختلف را فراهم می‌کند:

| مورد | دستور انتشار |
|---|---|
| Viewها | `--tag=authkit-views` |
| فایل‌های خام CSS و JS | `--tag=authkit-assets` |
| فایل‌های Build شده | `--tag=authkit-build` |
| فونت‌ها | `--tag=authkit-fonts` |
| Migrationها | `--tag=authkit-migrations` |

برای مثال:

```bash
php artisan vendor:publish --tag=authkit-build
```

**استفاده از فایل‌های آماده:** پس از انتشار فایل‌های Build شده، در Blade از مسیر زیر استفاده کنید:

```blade
@vite(['resources/js/auth/two-factor-challenge.js'], 'vendor/authkit/build')
```

آرگومان دوم مسیر Build Directory نسبت به پوشه `public` است. فایل Manifest نیز از همان مسیر خوانده می‌شود.

**شخصی‌سازی فایل‌ها:** ابتدا فایل‌های خام را با `authkit-assets` منتشر کنید، تغییرات خود را اعمال کنید و سپس ورودی‌ها را در Vite پروژه تعریف و Build کنید.

برای تغییر Viewها نیز پس از انتشار، فایل‌ها را در مسیر `resources/views/vendor/authkit` ویرایش کنید.

## Rate Limiting

پکیج برای محافظت از عملیات حساس مانند ورود، ثبت‌نام، بازیابی رمز عبور و 2FA از Rate Limiter لاراول استفاده می‌کند.

محدودیت‌ها بر اساس IP و شناسه کاربر یا ایمیل اعمال می‌شوند و به‌صورت پیش‌فرض در Service Provider پکیج تعریف شده‌اند.

## مجوز

این پکیج تحت مجوز MIT منتشر شده است.
