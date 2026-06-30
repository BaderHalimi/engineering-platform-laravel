<?php

return [
    'sections' => [
        'message_info' => 'معلومات الرسالة',
        'attachments'  => 'المرفقات',
        'read_status'  => 'حالة القراءة',
        'dates'        => 'التواريخ',
    ],

    'fields' => [
        'email'      => 'البريد الإلكتروني',
        'title'      => 'العنوان',
        'content'    => 'محتوى الرسالة',
        'read_at'    => 'تاريخ القراءة',
        'reader'     => 'قرأها',
        'created_at' => 'تاريخ الإنشاء',
        'updated_at' => 'آخر تحديث',
        'is_read'    => 'تم القراءة',
    ],

    'placeholders' => [
        'not_read'   => 'لم يتم قراءتها بعد',
        'no_reader'  => 'لم يتم تحديد القارئ',
    ],

    'attachments' => [
        'image'               => 'صورة',
        'video'               => 'فيديو',
        'pdf'                 => 'ملف PDF',
        'file'                => 'ملف',
        'video_not_supported' => 'متصفحك لا يدعم تشغيل الفيديو.',
        'download_pdf'        => 'تحميل الملف PDF',
    ],


    'filters' => [
        'read_by' => 'قرأها',
        'status'  => 'الحالة',
    ],

    'status' => [
        'read'    => 'مقروءة',
        'unread'  => 'غير مقروءة',
    ],
];
