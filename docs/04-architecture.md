# Architecture

## النظرة العامة

المشروع يعمل كتطبيقين منفصلين:

- Laravel backend مسؤول عن البيانات، الادارة، الملفات، الصلاحيات، والـ API.
- Nuxt frontend مسؤول عن تجربة المستخدم العامة، SEO، i18n، وواجهة العملاء.

هذا الفصل مناسب لأن الموقع يحتاج SEO وتجربة عامة سريعة، بينما العمليات الادارية والبيانات تحتاج Backend منظم وقابل للتوسع.

## Frontend: Nuxt

المسؤوليات:

- عرض الصفحات العامة.
- دعم i18n وRTL/LTR.
- SEO metadata.
- نماذج طلب الخدمة والتواصل.
- واجهة Portal لاحقا.
- استهلاك API من Laravel.

اقتراحات تنظيم:

- `app/pages`: routes العامة.
- `app/components`: مكونات مشتركة.
- `app/composables`: API clients وhelpers.
- `app/i18n/locales`: ملفات الترجمة.
- `app/assets/css`: tokens واتجاهات RTL/LTR.

## Backend: Laravel

المسؤوليات:

- API.
- Authentication.
- Authorization.
- Content management.
- Leads وService requests.
- Contact messages.
- File uploads.
- AI logs and suggestions.
- Settings.

اقتراحات تنظيم:

- `app/Models`: الكيانات.
- `app/Http/Controllers/Api/V1`: API controllers.
- `app/Http/Requests`: validation.
- `app/Actions`: منطق عمليات مثل CreateServiceRequest.
- `app/Policies`: صلاحيات.
- `database/migrations`: الجداول.
- `database/seeders`: محتوى اولي للخدمات والمقالات.

## API Modules

- Auth.
- Settings.
- Services.
- Projects.
- Articles.
- FAQs.
- Service Requests.
- Contact Messages.
- Clients.
- Media.
- AI Suggestions.

## API naming

استخدم versioning:

```text
/api/v1/services
/api/v1/projects
/api/v1/articles
/api/v1/service-requests
/api/v1/contact-messages
```

## Authentication

للوحة التحكم:

- Laravel Sanctum مناسب كبداية.
- Roles واضحة: super_admin, admin, employee, client.
- لا تسمح لأي role اداري بالدخول إلى كل شيء افتراضيا دون Policy.

## Media uploads

- حدد الانواع المسموحة حسب الاعدادات.
- افحص الحجم والامتداد وMIME.
- خزّن الملفات في storage خاص، وليس public، اذا كانت ملفات عملاء.
- الصور التسويقية يمكن نشرها public بعد المعالجة.

## Content strategy

للمحتوى القابل للترجمة يوجد خياران:

- JSON columns مثل `title: {"ar": "...", "en": "..."}`.
- جداول translations منفصلة مثل `service_translations`.

الاقتراح للبدء: JSON columns لسرعة MVP، مع ضبط API يرجع النص حسب locale. اذا زاد المحتوى والتدقيق التحريري، يمكن الانتقال لجداول translations.

## Security baseline

- Rate limit للنماذج العامة.
- CAPTCHA او بديل عند كثرة spam.
- Validation صارم لارقام الجوال والبريد والملفات.
- Audit log للعمليات الادارية المهمة.
- عدم اظهار تفاصيل اخطاء API للمستخدم.
- فصل صلاحيات الموظفين عن super admin.

## Observability

- سجل service request lifecycle.
- سجل AI suggestions.
- سجل رفع الملفات.
- metrics بسيطة: عدد الطلبات، مصادرها، اكثر الخدمات طلبا، المدن الاعلى.
