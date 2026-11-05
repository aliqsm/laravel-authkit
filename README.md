
# Laravel AuthKit

یک پکیج احراز هویت برای Laravel که مجموعه‌ای از قابلیت‌های موردنیاز برای مدیریت حساب‌های کاربری و امنیت آن‌ها را در اختیار پروژه قرار می‌دهد.

پکیج AuthKit از دو حالت **Web** و **API** پشتیبانی می‌کند:

- در حالت **Web:** شامل صفحات آماده مبتنی بر Blade برای ثبت‌نام، ورود و مدیریت حساب کاربری است.
- در حالت **API:** شامل Endpointهای موردنیاز برای پیاده‌سازی احراز هویت در Frontendهای مستقل است. احراز هویت در این حالت با استفاده از **Laravel Sanctum** و مبتنی بر **Session و Cookie** انجام می‌شود؛ بنابراین از Access Token یا Bearer Token برای احراز هویت درخواست‌ها استفاده نمی‌شود.

منطق احراز هویت، کنترلرها، Middlewareها و سایر اجزای اصلی داخل پکیج قرار دارند؛ بنابراین بدون نیاز به انتقال فایل‌های داخلی به پروژه میزبان، می‌توانید از قابلیت‌های AuthKit استفاده کنید و آن را به‌روزرسانی کنید.

### قابلیت‌ها

- ثبت‌نام، ورود و خروج از حساب کاربری
- ورود و ثبت‌نام با Google
- تأیید آدرس ایمیل
- فراموشی، بازیابی و تغییر رمز عبور
- احراز هویت دومرحله‌ای و کدهای بازیابی
- مدیریت نشست‌های فعال و خروج از دستگاه‌های دیگر
- مشاهده فعالیت‌های امنیتی حساب
- ویرایش اطلاعات حساب کاربری
- محدودسازی درخواست‌ها (Rate Limiting)

### پیش‌نیازها

- PHP 8.2 یا بالاتر
- Laravel 12 یا 13
- Composer





<br>





## نصب و راه‌اندازی

### ۱. نصب پکیج

```bash
composer require aliqsm/laravel-authkit
```

### ۲. افزودن Trait به مدل User

در فایل `app/Models/User.php`، Trait زیر را اضافه کنید:

```php
use Aliqsm\LaravelAuthkit\Traits\HasAuthKit;

class User extends Authenticatable
{
    use HasAuthKit;

    // ...
}
```

این Trait تنظیمات موردنیاز AuthKit، از جمله Cast فیلدها، فیلدهای مخفی و متدهای ارسال اعلان‌های تأیید ایمیل و بازیابی رمز عبور را به مدل User اضافه می‌کند.

### ۳. انتشار فایل‌های Build

برای استفاده از صفحات آماده AuthKit در حالت Web، باید فایل‌های CSS و JavaScript پکیج را در مسیر عمومی پروژه منتشر کنید. این فایل‌ها شامل استایل‌ها و اسکریپت‌های موردنیاز صفحات هستند.

```bash
php artisan vendor:publish --tag=authkit-build
```

### ۴. اجرای Migrationها

برای ایجاد جداول موردنیاز AuthKit در دیتابیس، دستور زیر را اجرا کنید:

```bash
php artisan migrate
```

**نکته:** AuthKit برای ذخیره اعلان‌های کاربران به جدول `notifications` لاراول نیاز دارد. اگر این جدول در دیتابیس پروژه وجود ندارد، با اجرای دستورات زیر آن را ایجاد کنید:

```bash
php artisan make:notifications-table
php artisan migrate
```






<br>






## تنظیمات و سفارشی‌سازی

برای دسترسی به تنظیمات AuthKit، ابتدا فایل Config پکیج را منتشر کنید:

```bash
php artisan vendor:publish --tag=authkit-config
```

فایل تنظیمات در مسیر `config/authkit.php` قرار می‌گیرد.

### حالت اجرا

در گزینه `app_mode` باید مشخص کنید که قصد دارید از کدام حالت AuthKit استفاده کنید:

```php
'app_mode' => 'web',
```

- `web`: فعال‌سازی صفحات Blade و مسیرهای وب
- `api`: فعال‌سازی مسیرهای API برای اتصال به Frontend مستقل

با انتخاب هر حالت، فقط مسیرهای مربوط به همان حالت فعال می‌شوند و مسیرهای حالت دیگر غیرفعال خواهند بود.

اگر مقدار این گزینه را `null` قرار دهید، مسیرهای AuthKit به‌طور کامل غیرفعال می‌شوند.

### آدرس Frontend

در حالت API، آدرس Frontend را در گزینه `frontend_url` مشخص کنید. این آدرس برای هدایت کاربر به Frontend استفاده می‌شود:

```php
'frontend_url' => 'https://app.example.com',
```

### فعال‌سازی قابلیت‌ها

با گزینه `features` می‌توانید قابلیت‌های مختلف AuthKit را به‌صورت مستقل فعال یا غیرفعال کنید:

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

برای غیرفعال کردن هر قابلیت، مقدار مربوط به آن را `false` قرار دهید.

### تنظیمات احراز هویت دومرحله‌ای

در بخش `two_factor` می‌توانید تنظیمات زیر را تغییر دهید:

- `challenge_expire_minutes`: مدت اعتبار مرحله تأیید دومرحله‌ای
- `setup_expire_minutes`: مدت اعتبار فرایند فعال‌سازی
- `recovery_code_length`: طول هر کد بازیابی
- `recovery_codes_count`: تعداد کدهای بازیابی
### تنظیم فونت

از آنجا که هر پروژه ممکن است از فونت متفاوتی استفاده کند، AuthKit فونت مشخصی را به‌صورت پیش‌فرض ارائه نمی‌دهد. برای هماهنگی ظاهر صفحات با پروژه، باید مشخصات فونت موردنظر خود را در بخش `font` تنظیم کنید:

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

فایل‌های فونت باید در مسیرهای مشخص‌شده داخل پوشه `public` پروژه قرار بگیرند.

### محدودیت درخواست‌ها

در بخش `rate_limits` می‌توانید تعداد درخواست‌های مجاز هر عملیات و مدت زمان محدودیت را تغییر دهید:

- `max_attempts`: حداکثر تعداد درخواست مجاز
- `decay_minutes`: مدت زمان محدودیت بر حسب دقیقه

### انتشار فایل‌ها

در صورت نیاز به سفارشی‌سازی رابط کاربری AuthKit، می‌توانید فایل‌های موردنظر را با استفاده از دستورات زیر در پروژه منتشر کنید.

**قالب‌های Blade**

برای تغییر ساختار یا ظاهر صفحات آماده AuthKit، قالب‌های Blade را منتشر کنید:

```bash
php artisan vendor:publish --tag=authkit-views
````

قالب‌ها در مسیر `resources/views/vendor/authkit` قرار می‌گیرند و امکان ویرایش و سفارشی‌سازی آن‌ها را فراهم می‌کنند.


**فایل‌های منبع CSS و JavaScript**


برای سفارشی‌سازی استایل‌ها و اسکریپت‌های AuthKit، می‌توانید فایل‌های منبع را با دستور زیر منتشر کنید:

```bash
php artisan vendor:publish --tag=authkit-assets
````

فایل‌ها در مسیر `resources/vendor/authkit` قرار می‌گیرند.

نکته: پس از اعمال تغییرات، برای تولید فایل‌های خروجی جدید باید مجدداً از Vite برای Build استفاده کنید.








<br>







## راه‌اندازی سرویس‌های جانبی


### ورود با حساب Google

برای فعال‌سازی ورود با Google، ابتدا اطلاعات OAuth را از [Google Cloud Console](https://console.cloud.google.com/) دریافت کنید.

در فایل `config/services.php` تنظیمات زیر را اضافه کنید:

```php
'google' => [
    'client_id' => env('GOOGLE_CLIENT_ID'),
    'client_secret' => env('GOOGLE_CLIENT_SECRET'),
    'redirect' => env('GOOGLE_REDIRECT_URI'),
],
```

سپس مقادیر مربوط به آن را در فایل `.env` قرار دهید:

```env
GOOGLE_CLIENT_ID=
GOOGLE_CLIENT_SECRET=
GOOGLE_REDIRECT_URI=
```

آدرس `GOOGLE_REDIRECT_URI` باید با آدرس Callback ثبت‌شده در تنظیمات OAuth گوگل یکسان باشد.








<br>






## مسیرها (Routes)

پکج AuthKit مسیرهای احراز هویت و مدیریت حساب کاربری را به‌صورت خودکار و بر اساس حالت انتخاب‌شده در `app_mode` ثبت می‌کند.

### مسیرهای Web

**احراز هویت**

| متد | مسیر | نام Route |
|---|---|---|
| GET | `/login` | `login.form` |
| POST | `/login` | `login` |
| GET | `/register` | `register.form` |
| POST | `/register` | `register` |
| GET | `/oauth/google/redirect` | `oauth.google.redirect` |
| GET | `/oauth/google/callback` | `oauth.google.callback` |
| GET | `/forgot-password` | `password.request` |
| POST | `/forgot-password` | `password.email` |
| GET | `/reset-password/{token}` | `password.reset` |
| POST | `/reset-password` | `password.update` |
| GET | `/2fa/challenge` | `two-factor.challenge` |
| POST | `/2fa/challenge` | `two-factor.verify` |

**تأیید ایمیل و مدیریت نشست**

| متد | مسیر | نام Route |
|---|---|---|
| GET | `/email/verify` | `verification.notice` |
| POST | `/email/verification-notification` | `verification.send` |
| GET | `/email/verify/{id}/{hash}` | `verification.verify` |
| POST | `/logout` | `logout` |
| POST | `/logout/logout-other-devices` | `sessions.destroy` |

**داشبورد و تنظیمات حساب**

| متد | مسیر | نام Route |
|---|---|---|
| GET | `/dashboard` | `dashboard` |
| GET | `/dashboard/profile` | `profile.edit` |
| PUT | `/dashboard/profile` | `profile.update` |
| GET | `/dashboard/sessions` | `dashboard.sessions.index` |
| GET | `/dashboard/security-activities` | `dashboard.security-activities.index` |
| GET | `/dashboard/change-password` | `password.edit` |
| POST | `/dashboard/change-password` | `password.change` |
| GET | `/confirm-password` | `password.confirm` |
| POST | `/confirm-password` | `password.confirm.verify` |
| POST | `/password/send-reset-link` | `password.send-reset-link` |
| GET | `/2fa` | `two-factor.index` |
| POST | `/2fa/enable` | `two-factor.enable` |
| POST | `/2fa/disable` | `two-factor.disable` |
| POST | `/2fa/regenerate` | `two-factor.recovery-code.regenerate` |

### مسیرهای API

تمام مسیرهای این بخش با پیشوند `/api` در دسترس هستند.

**احراز هویت**

| متد | مسیر | نام Route |
|---|---|---|
| POST | `/api/login` | `api.login` |
| POST | `/api/register` | `api.register` |
| GET | `/api/oauth/google/redirect` | `api.oauth.google.redirect` |
| GET | `/api/oauth/google/callback` | `api.oauth.google.callback` |
| POST | `/api/forgot-password` | `api.password.email` |
| POST | `/api/reset-password` | `api.password.update` |
| GET | `/api/2fa/challenge` | `api.two-factor.challenge` |
| POST | `/api/2fa/challenge` | `api.two-factor.verify` |

**تأیید ایمیل و مدیریت نشست**

| متد | مسیر | نام Route |
|---|---|---|
| GET | `/api/email/verify` | `api.verification.notice` |
| POST | `/api/email/verification-notification` | `api.verification.send` |
| GET | `/api/email/verify/{id}/{hash}` | `api.verification.verify` |
| POST | `/api/logout` | `api.logout` |
| POST | `/api/logout/logout-other-devices` | `api.sessions.destroy` |

**مدیریت حساب کاربری**

| متد | مسیر | نام Route |
|---|---|---|
| GET | `/api/dashboard/profile` | `api.profile.edit` |
| PUT | `/api/dashboard/profile` | `api.profile.update` |
| GET | `/api/dashboard/sessions` | `api.dashboard.sessions.index` |
| GET | `/api/dashboard/security-activities` | `api.dashboard.security-activities.index` |
| PUT | `/api/dashboard/password` | `api.password.update` |
| POST | `/api/confirm-password` | `api.password.confirm.verify` |
| POST | `/api/password/send-reset-link` | `api.password.send-reset-link` |
| GET | `/api/2fa` | `api.two-factor.index` |
| POST | `/api/2fa/enable` | `api.two-factor.enable` |
| POST | `/api/2fa/disable` | `api.two-factor.disable` |
| POST | `/api/2fa/regenerate` | `api.two-factor.recovery-code.regenerate` |



**نکته:** مسیرهای مربوط به قابلیت‌هایی مانند ثبت‌نام، ورود با Google، بازیابی رمز عبور و احراز هویت دومرحله‌ای، به فعال بودن آن‌ها در بخش `features` فایل تنظیمات وابسته است. با غیرفعال کردن هر قابلیت، مسیرهای مربوط به آن نیز ثبت نمی‌شوند.





<br>







## راه‌اندازی API و احراز هویت با Sanctum

پکیج AuthKit در حالت API از احراز هویت مبتنی بر **Session و Cookie** استفاده می‌کند. در این روش، پس از ورود کاربر، Laravel نشست کاربر را ایجاد می‌کند و مرورگر Cookie مربوط به Session را در درخواست‌های بعدی ارسال می‌کند.
بنابراین برای این حالت نیازی به ساخت یا ذخیره Access Token در Frontend نیست. احراز هویت درخواست‌ها با استفاده از Middleware `auth:sanctum` انجام می‌شود.

### ۱. فعال‌سازی حالت API

جهت فعال‌سازی حالت API بایستی در فایل `config/authkit.php` مقدار `app_mode` را روی `api` قرار دهید:

```php
'app_mode' => 'api',
```

### ۲. فعال‌سازی Stateful API در Laravel

سپس در فایل `bootstrap/app.php`، متد `statefulApi()` را به تنظیمات Middleware اضافه کنید:

```php
->withMiddleware(function (Middleware $middleware): void {
    $middleware->statefulApi();
})
```

این Middleware به Sanctum اجازه می‌دهد درخواست‌های ارسال‌شده از Frontendهای مورد اعتماد را به‌صورت Stateful پردازش کند؛ یعنی از Session و Cookie برای احراز هویت استفاده کند.

### ۳. تنظیم متغیرهای محیطی

در فایل `.env` مقادیر زیر را متناسب با دامنه‌های پروژه تنظیم کنید:

```env
SESSION_DRIVER=database
SESSION_DOMAIN=.example.com
SESSION_SECURE_COOKIE=true
SESSION_SAME_SITE=lax

SANCTUM_STATEFUL_DOMAINS=app.example.com
```

- `SESSION_DOMAIN`: دامنه مشترکی که Cookie نشست برای آن معتبر است.
- `SESSION_SECURE_COOKIE`: ارسال Cookie فقط از طریق HTTPS.
- `SESSION_SAME_SITE`: سیاست ارسال Cookie بین درخواست‌ها.
- `SANCTUM_STATEFUL_DOMAINS`: دامنه Frontendهایی که مجاز به استفاده از احراز هویت Stateful هستند.

در این مثال، فرض شده Frontend روی `app.example.com` و API روی `api.example.com` قرار دارد.

### ۴. تنظیم CORS

در فایل `config/cors.php` تنظیمات زیر را اعمال کنید:

```php
'supports_credentials' => true,

'allowed_origins' => [
    'https://app.example.com',
],
```

با فعال بودن `supports_credentials`، مرورگر اجازه ارسال و دریافت Cookie در درخواست‌های Cross-Origin را خواهد داشت.



### ۵. تنظیم Frontend

برای برقراری ارتباط با API و استفاده از احراز هویت مبتنی بر Session و Cookie، باید ارسال Cookie و هدر CSRF را در Axios فعال کنید:

```javascript
axios.defaults.baseURL = 'https://api.example.com';
axios.defaults.withCredentials = true;
axios.defaults.withXSRFToken = true;
````

پیش از ارسال درخواست ورود یا ثبت‌نام، ابتدا Cookie مربوط به CSRF را از Laravel دریافت کنید:

```
await axios.get('/sanctum/csrf-cookie');
```

پس از دریافت این Cookie، می‌توانید درخواست ورود را ارسال کنید:

```
await axios.post('/api/login', {
    email: 'user@example.com',
    password: 'password',
});
```

مرورگر Cookieهای Session و CSRF را در درخواست‌های بعدی به‌صورت خودکار ارسال می‌کند و نیازی به مدیریت دستی آن‌ها در Frontend نیست.

نکته: دریافت CSRF Cookie معمولاً هنگام شروع نشست کاربر یا پیش از اولین درخواست نیازمند محافظت CSRF انجام می‌شود. در صورت منقضی شدن نشست یا دریافت خطای CSRF، باید مجدداً آن را دریافت کنید.
