<?php

return [
    'sections' => [
        'message_info' => 'Message Information',
        'attachments'  => 'Attachments',
        'read_status'  => 'Read Status',
        'dates'        => 'Dates',
    ],

    'fields' => [
        'email'      => 'Email Address',
        'title'      => 'Title',
        'content'    => 'Content',
        'read_at'    => 'Read At',
        'reader'     => 'Read By',
        'created_at' => 'Created At',
        'updated_at' => 'Updated At',
        'is_read'    => 'Read',
    ],

    'placeholders' => [
        'not_read'   => 'Not read yet',
        'no_reader'  => 'No reader assigned',
    ],

    'attachments' => [
        'image'               => 'Image',
        'video'               => 'Video',
        'pdf'                 => 'PDF File',
        'file'                => 'File',
        'video_not_supported' => 'Your browser does not support video playback.',
        'download_pdf'        => 'Download PDF',
    ],
    'filters' => [
        'read_by' => 'Read By',
        'status'  => 'Status',
    ],

    'status' => [
        'read'    => 'Read',
        'unread'  => 'Unread',
    ],
];
