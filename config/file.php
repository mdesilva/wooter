<?php

return [

    /*
    |--------------------------------------------------------------------------
    | File
    |--------------------------------------------------------------------------
    |
    | This file is for storing information that is needed regarding all the files
    | that our app will support.
    |
    */

    'megabyte' => 1048576, //1024*1024

    'image' => [
        'max_size' => env('IMAGE_MAX_SIZE', 2), // Expressed in MB
        'allowed_mime_types' => ['jpg', 'jpeg', 'png', 'gif'],
        'upload_path' => env('IMAGE_UPLOAD_PATH', 'public/upload/images/'),
        'visible_path' => env('IMAGE_VISIBLE_PATH', 'upload/images/'),
        'thumbnail_width' => env('IMAGE_THUMBNAIL_WIDTH', 320),
        'thumbnail_height' => env('IMAGE_THUMBNAIL_HEIGHT', 280),
    ],

    'video' => [
        'max_size' => env('VIDEO_MAX_SIZE', 100), // Expressed in MB
        'allowed_mime_types' => ['mp4', 'mpg', '3gp', 'avi', 'mov'],
        'upload_path' => env('VIDEO_UPLOAD_PATH', 'public/upload/videos/'),
        'visible_path' => env('VIDEO_VISIBLE_PATH', 'upload/videos/'),
        'temporary_path' => env('VIDEO_UPLOAD_TEMP', 'public/upload/videos/temp/'),
    ],
];
