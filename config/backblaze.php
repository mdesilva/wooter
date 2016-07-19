<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Back Blaze configurations
    |--------------------------------------------------------------------------
    |
    | This file is for storing information that is needed regarding back blaze cloud storage
    */

        'account_id' => '102fa9a5809c',
        'application_key' => '001591de2492e988e33b2e431b98aef0e41dc979b5',
        'bucket_id' => 'a1a0c2affa394a555850091c',
        'image' => [
            'upload_path' => 'images/', // keep the images folder inside bucket
            'image_src'  => 'https://f001.backblaze.com/file/wooter/images/',
        ],

        'video' => [
             'upload_path' => 'videos/', // keep the videos folder inside bucket
             'thumbnail_path' =>'videos/thumbnails/', // store all video thumbnails inside videos foler
             'video_src'  => 'https://f001.backblaze.com/file/wooter/videos/',
            'video_thumb_src'  => 'https://f001.backblaze.com/file/wooter/videos/thumbnails/'

        ],



];
