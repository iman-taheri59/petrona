# فاز ۱ اصلاحات قالب Petrona — گزارش تغییرات

**شاخه:** `fix/audit-phase-1` · **کامیت‌ها:** `7670162` (کد) + `6d2fb21` (این سند) · **۴۲ فایل تغییر یافته، ۹۸۹ خط افزوده، ۱٬۰۹۷ خط حذف‌شده**
**اعتبارسنجی:** `php -l` روی هر ۱۹۰ فایل PHP → بدون خطا · `node --check` روی JSهای تغییریافته → بدون خطا · PHPCS دوباره اجرا شد

> ⚠️ **تصحیح گزارش قبلی — مهم:** در گزارش اولیه نوشتم که `Techt_Download_Handler::hook()` شیء برمی‌گرداند و روی هر درخواست `TypeError` می‌دهد. **این اشتباه بود.** کد واقعی در `main` این است:
> ```php
> public function hook() { return $this->hook; }
> ```
> آنچه من تست کرده بودم، نقل‌قول نادرست خودم از کد بود (من `self::$instance` نوشتم، در حالی که آن خط در `get_instance()` است). الان دوباره از `git show main:` تست کردم: **هیچ TypeError وجود ندارد.** عذرخواهی می‌کنم — این یک خطای من بود، نه باگ قالب. اما **مسئلهٔ امنیتی این کلاس کاملاً واقعی بود** (هیچ کنترل دسترسی‌ای نداشت) و اصلاح شد.

---

## ۱) چه چیزی اصلاح شد

### 🔴 حذف کد مشفر (بحرانی)
| فایل | اقدام |
|---|---|
| `inc/admin/RTL_License_a8a91f9370d0e954.php` | **حذف کامل** (۷۹۰ خط payload مشفر ionCube) |
| `inc/modules/includes/ion-checker.php` | **حذف** (نیروی ionCube Loader برای کار کردن قالب) |
| `inc/admin/settings.php` | حذف بلوک کامنت‌شدهٔ لایسنس؛ ثبت Customizer و Settings اکنون بی‌قید اجرا می‌شود |
| `inc/modules/techt-core.php` | حذف کامنت‌های ion-checker |

نتیجه: قالب دیگر به افزونهٔ تجاری `ionCube Loader` نیاز ندارد و هیچ کد غیرقابل‌بازبینی ندارد.

### 🔴 Privilege Escalation در ثبت‌نام / ورود سوشال
`inc/modules/includes/login-register.php`

مشکل: نقش کاربر از `$_POST['page_id']`/`$_POST['widget_id']` → تنظیمات ویجت المنتور خوانده می‌شد و لیست نقش‌ها شامل `administrator` بود.

اصلاح — سه لایهٔ دفاع:
1. **`techt_sanitize_self_registration_role()`** (تابع جدید): هر نقشی خارج از whitelist `[default_role, subscriber]` (قابل تغییر با فیلتر `petrona_allowed_self_registration_roles`) به نقش پیش‌فرض تنزل می‌یابد.
2. **`techt_get_registration_role_from_widget()`** (تابع جدید): قبل از خواندن تنظیمات ویجت بررسی می‌کند که پست وجود دارد، `publish` است، `is_post_publicly_viewable()` است، `get_post()` برمی‌گردد، `widgetType === 'techt-login-register'` است. نقش فراتر از whitelist فقط اگر **درخواست‌دهنده خودش `current_user_can('promote_users')` داشته باشد** پذیرفته می‌شود.
3. **`nopriv` شدن endpoint** دیگر مسیر سوءاستفاده ندارد و نقش در هر دو مسیر (ثبت‌نام عادی + سوشال) از همین تابع می‌آید.

`inc/modules/public/elementor/class-techt-element-base.php`
- `ox_lr_user_role()` دیگر نقش‌های پرمجوز (`administrator`, `editor`, …) را در dropdown ویجت **نمایش نمی‌دهد**.

### 🔴 کلاس دانلود بدون کنترل دسترسی
`inc/modules/includes/class-techt-download-handler.php`

| مورد | قبل | بعد |
|---|---|---|
| Nonce | ❌ | ✅ `wp_verify_nonce( ..., 'petrona_download_' . $id )` |
| لینک دانلود | بدون nonce | `get_download_link()` اکنون `_wpnonce` تولید می‌کند |
| فایل ضمیمه به پست خصوصی/پیش‌نویس | دانلود آزاد با شمارش ID | ✅ بررسی وضعیت پست والد (`publish` / `private` + `read_post`) |
| پست محافظت‌شده با رمز | باز | ✅ `post_password_required()` → 403 |
| رسانهٔ بدون والد | باز | ✅ فقط `upload_files` |
| MIME | `application/force-download` | `get_post_mime_type()` + allow-list |
| Header Injection در نام فایل | `basename()` خام | `sanitize_file_name()` + حذف CR/LF و `"` + `X-Content-Type-Options: nosniff` |
| بررسی وجود پست | `$post->post_type` روی `null` | `! $post` بررسی می‌شود |

### 🟠 متاباکس‌ها: nonce، capability، whitelist
`inc/modules/admin/metaboxes/metaboxes.php` (+ ۵ فایل `views/*.php`)

قبل:
```php
foreach($_POST as $key => $value)              // هیچ nonce، هیچ capability
  if(strstr($key,'techt_')) update_post_meta( $post_id, $new_key, $value );  // بدون sanitize
```
بعد:
- `wp_nonce_field()`/`wp_verify_nonce()` با action `petrona_save_meta`
- `current_user_can( 'edit_post', $post_id )` + محدود کردن به post typeهای مجاز
- رد کردن revision/autosave
- **whitelist دقیق ۶۵ کلید متا** (`get_allowed_meta_keys()`) که از فیلدهای واقعی `views/*.php` استخراج شده — هر کلید دیگری در `$_POST` نادیده گرفته می‌شود
- sanitize بر اساس نوع فیلد: `key` / `int` / `url` / `color` / `background` / `ids` / `post` (`wp_kses_post`) / `repeater`
- فیلتر `petrona_allowed_meta_keys` برای توسعه

### 🟠 AJAX بدون مجوز
`inc/modules/public/elementor/class-techt-elementor.php`

| Endpoint | اصلاح |
|---|---|
| `get_posts_title_by_id` | `check_ajax_referer('techt-addons')` + `current_user_can('edit_posts')` + `post_status => publish` + `read_post` + `absint` روی IDها |
| `get_posts_by_query` | nonce + capability + `sanitize_key` روی post_type |
| `get_techt_template_content` | **حذف `nopriv`** + nonce + capability + بررسی `read_post` روی template |
| `admin_scripts()` (روی `wp_head`) | دیگر nonce را برای **همهٔ بازدیدکنندگان** چاپ نمی‌کند؛ فقط برای کاربری که `edit_posts` دارد و با `wp_json_encode` |

سمت JS هم هماهنگ شد تا چیزی نشکند:
- `assets/js/query-post.js` → ارسال `nonce: window.techt_nonce`
- `assets/js/front-end-widget.js` → ارسال `nonce: ...addonsNonce`
- `widgets/hamburger-panel.php` → افزودن `addonsNonce` به داده‌های localize

### 🟠 مسیر مطلق هاردکدشده (بحرانی‌ترین باگ نصب)
`inc/modules/techt-core.php`
```php
- define( 'TECHT_MADULES_PATH', ABSPATH . 'wp-content/themes/petrona/inc/modules' );
+ define( 'TECHT_MADULES_PATH', get_template_directory() . '/inc/modules' );
```
همچنین هر چهار ثابت با `if ( ! defined() )` محافظت شدند. **الان قالب در پوشهٔ `petrona-main`، در child-theme و با `WP_CONTENT_DIR` سفارشی هم کار می‌کند.**

### 🟡 باگ‌های منطقی
| فایل | اصلاح |
|---|---|
| `template-parts/post/content-post.php` (۳ جا) | `if($page_type = 'archive')` → `=== 'archive'` (انتساب به‌جای مقایسه) |
| `metaboxes.php` `repeater()` | ترمینال `'...' . $x != '' ? ... : '' . '"'` → متغیر میانی؛ مقدار ذخیره‌شده دیگر با `1`/خالی بازنویسی نمی‌شود + `esc_attr`/`esc_textarea` |
| `inc/modules/includes/login-register.php:251` | `FILTER_SANITIZE_STRING` (حذف‌شده در PHP 8.2) → `sanitize_text_field( wp_unslash() )` |
| `.../login-register.php` `techt_redirect_to_custom_password_reset()` | `wp_redirect($_REQUEST['forgoturl'])` → `wp_validate_redirect()` + `wp_safe_redirect()` (رفع Open Redirect) + `rawurlencode` روی پارامترها |
| `action_after_setup_theme.php` | `'default-color' => 'fff'` → `'ffffff'` |
| `class-techt-custom-post.php` | `$_GET['template_type']`/`$_REQUEST` بدون sanitize → `sanitize_key( wp_unslash() )` + مقایسهٔ سخت‌گیرانه |

### 🟡 دسترس‌پذیری و کدهای escape‌نشده
| فایل | اصلاح |
|---|---|
| `header.php` | حذف `maximum-scale=1` → بزرگ‌نمایی موبایل دیگر قفل نیست (WCAG 1.4.4) |
| `searchform.php` / `woocommerce/product-searchform.php` | `get_search_query()` → `esc_attr(...)` |
| `template-parts/blog-parts/blog-home.php` | `echo get_search_query()` → `esc_html()` |
| `template-parts/single/one.php` | `echo get_the_title(...)` → `esc_html()` (۲ مورد) |
| `woocommerce/loop/orderby.php` | `$link`/`$name`/`$active`/`$catalog_orderby_options[...]` → `esc_url`/`esc_html`/`esc_attr` |
| ۱۱ فایل | ۱۶ لینک `target="_blank"` → `rel="noopener noreferrer"` |

### 🟡 دامنهٔ ترجمهٔ نامعتبر
۱٬۰۷ مورد (`powerpack` ۲۲، `elementor-iran-map` ۶۰، `plugin-name` ۱۷، `plugin-domain` ۷، `pixel-gallery` ۱) در ۱۵ فایل → همه `petrona`. **اکنون ۱۰۰٪ رشته‌های قالب با یک text-domain هستند و در `fa_IR.po` قابل ترجمه‌اند.**

---

## ۲) اندازه‌گیری قبل/بعد (PHPCS · WordPress-Extra)

| شاخص | قبل | بعد | تغییر |
|---|---|---|---|
| EscapeOutput (escape نشده) | ۶۲۶ | ۶۱۸ | −۸ |
| NonceVerification — خطا | ۴۸ | **۳۶** | **−۱۲** |
| NonceVerification — هشدار | ۶۷ | **۶۴** | **−۳** |
| unsafe printing | ۴ | ۴ | ۰ |
| دامنهٔ ترجمهٔ نامعتبر | ۱۰۷ | **۰** | **−۱۰۷** |
| کد مشفر | ۱ فایل | **۰** | حذف |
| نیاز به ionCube | بله | **نه** | حذف |

> عدد ۶۱۸ برای escape عمداً کم است — بیشتر آن در ویجت‌های المنتور (`login_register` ۷٬۹۶۹ خط و `woo-products` ۵٬۸۲۴ خط) و `inc/frontend/helpers.php` است که باید در فاز ۳ فایل‌به‌فایل بازنویسی شود، نه با جست‌وجوی کورچشم. escaping کورکورانه در ویجت‌ها می‌تواند HTML مجاز (SVG آیکون‌ها) را بشکند.

---

## ۳) آنچه عمداً **دست نخورد**

| مورد | چرا |
|---|---|
| `inc/libs/tgm-plugin-activation/class-tgm-plugin-activation.php` | کتابخانهٔ ثالث (TGM 2.6.1) — بهتر است کل آن با راه‌حل مدرن جایگزین شود، نه ویرایش دستی |
| `inc/modules/public/elementor/widgets/login_register.php` (۷٬۹۶۹ خط) | ناحیهٔ پرخطر؛ نیاز به بازنویسی ماژولار دارد (فاز ۳). فقط سطح سرور آن امن شد |
| `session/src/jquery`-based assets و بهینه‌سازی سرعت | فاز ۳ |
| `inc/customizer/basic-settings.php` (۲٬۴۹۲ خط) | فاز ۲/۳ |

---

## ۴) کارهای باقی‌مانده (فاز ۲ و ۳)

**فاز ۲ — پایداری**
1. `LICENSE` (GPLv2+)، `README.md` واقعی، `CHANGELOG.md`، `.distignore`
2. GitHub Actions: `php -l` + PHPCS + `node --check`
3. `Tested up to` → نسخهٔ واقعاً تست‌شده؛ حذف `post-formats` از Tags یا افزودن `add_theme_support`
4. `wp_remote_post` جای `file_get_contents` برای reCAPTCHA (کار روی هاست با `allow_url_fopen=Off`)
5. `new \Google_Client()` بدون include → ورود با گوگل هنوز Fatal می‌کند (باید Google API Client واقعاً بارگذاری شود یا فیچر حذف شود)
6. `get_option('page_comments')` منسوخ در `comments.php`
7. `esc_attr_e('Save Changes')` بدون text-domain در `inc/admin/settings.php` + `esc_attr` روی `{$value}`
8. ۳۶ خطای باقی‌ماندهٔ NonceVerification در `login-register.php` (۳۳) و `class-techt-element-base.php` (۸)

**فاز ۳ — سرعت و معماری**
9. فقط `woff2` + `font-display: swap` (کاهش ۴٫۷MB فونت)
10. حذف `all-plugin-css.min.css` (۳۰۲KB تکراری)، بارگذاری شرطی Bootstrap/FA/TweenMax/isotope
11. نسخه‌گذاری assets با `filemtime()` به‌جای `false` (کش مرورگر)
12. شکستن ۹ فایل بالای ۲٬۰۰۰ خط؛ حذف `style.min.css`/`main.min.js` صفر بایتی
13. تولید `.pot` و حذف ۷۸۴ مورد کد مرده

---

## ۵) نحوهٔ بازبینی کد

```bash
cd ~/petrona
git log --oneline -2                  # 6d2fb21 (docs) + 7670162 (code)
git show --stat HEAD                  # ۴۱ فایل
git diff main..fix/audit-phase-1 -- inc/modules/includes/login-register.php
```

**تست پیشنهادی قبل از merge (روی یک نصب staging):**
1. نصب در پوشه‌ای با نام دیگر (`petrona-main`) → باید بدون Fatal بالا بیاید *(این تست قبلاً شکست می‌خورد)*
2. ثبت‌نام عمومی → نقش حتماً باید `subscriber` باشد، حتی اگر ویجت روی `administrator` تنظیم شده باشد
3. `/wp-admin/post.php` → ذخیرهٔ متاباکس → مقادیر باید ذخیره شوند (چون nonce اضافه شده)
4. لینک دانلود فایل → باید `?petrona_download=ID&_wpnonce=...` باشد؛ بدون nonce باید ۴۰۳ بدهد
5. Elementor → ادیتور → ویجت پست/تِمپلیت باید بدون خطا لود شود (nonce در JS ارسال می‌شود)
