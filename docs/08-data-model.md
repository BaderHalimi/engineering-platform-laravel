# Data Model Draft

هذا نموذج اولي يساعد في تحويل الوثائق إلى migrations في Laravel.

## users

- id
- name
- email
- phone
- password
- role
- status
- last_login_at
- timestamps

## clients

- id
- name
- phone
- email
- type: individual/company/contractor/developer/government/other
- city
- notes
- timestamps

## services

- id
- slug
- title JSON
- summary JSON
- body JSON
- audience JSON
- includes JSON
- steps JSON
- required_documents JSON
- benefits JSON
- status
- sort_order
- meta_title JSON
- meta_description JSON
- timestamps

## projects

- id
- service_id nullable
- slug
- title JSON
- summary JSON
- body JSON nullable
- city
- location_label
- status
- completed_at nullable
- sort_order
- meta_title JSON
- meta_description JSON
- timestamps

## articles

- id
- author_id
- category_id nullable
- slug
- title JSON
- excerpt JSON
- body JSON
- cover_image_id nullable
- status: draft/published
- published_at
- meta_title JSON
- meta_description JSON
- timestamps

## article_categories

- id
- slug
- name JSON
- description JSON nullable
- sort_order
- timestamps

## faqs

- id
- question JSON
- answer JSON
- category nullable
- status
- sort_order
- timestamps

## service_requests

- id
- client_id nullable
- name
- phone
- email nullable
- client_type
- service_id nullable
- service_name_snapshot
- city
- description
- preferred_contact_method: phone/whatsapp/email
- status: new/reviewing/contacted/qualified/closed
- priority: low/normal/high
- source: website/whatsapp/admin/other
- assigned_to nullable
- ai_summary nullable
- timestamps

## service_request_files

- id
- service_request_id
- media_id
- original_name
- timestamps

## contact_messages

- id
- name
- phone nullable
- email nullable
- subject nullable
- message
- status: new/read/replied/archived
- source
- timestamps

## media

- id
- disk
- path
- original_name
- mime_type
- size
- visibility: public/private
- uploaded_by nullable
- mediable_type nullable
- mediable_id nullable
- timestamps

## settings

- id
- key
- value JSON
- group
- is_public
- timestamps

## ai_suggestions

- id
- suggestible_type
- suggestible_id
- provider nullable
- feature: request_summary/service_recommendation/document_suggestions/seo_draft
- input_hash
- output JSON
- status: generated/accepted/rejected/failed
- reviewed_by nullable
- reviewed_at nullable
- timestamps

## audit_logs

- id
- user_id nullable
- action
- auditable_type nullable
- auditable_id nullable
- old_values JSON nullable
- new_values JSON nullable
- ip_address nullable
- user_agent nullable
- timestamps

## علاقات مهمة

- Service has many Projects.
- Service has many ServiceRequests.
- Client has many ServiceRequests.
- ServiceRequest has many Files.
- User can be assigned to many ServiceRequests.
- Article belongs to Category.
- Media can be polymorphic.
- AiSuggestion is polymorphic.

## ملاحظات تصميم

- استخدم JSON للترجمات في MVP لتسريع التنفيذ.
- ابق `service_name_snapshot` في الطلب حتى لا يتغير سجل الطلب عند تعديل اسم الخدمة.
- افصل ملفات العملاء private عن صور المحتوى public.
- لا تخزن مخرجات AI فوق البيانات الاصلية دون مراجعة.
