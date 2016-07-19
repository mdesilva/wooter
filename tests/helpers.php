<?php

use Symfony\Component\HttpFoundation\File\UploadedFile;

if (! function_exists('createImage')) {

    function createImage($name)
    {
        $im = imagecreatetruecolor(120, 20);
        $text_color = imagecolorallocate($im, 233, 14, 91);
        imagestring($im, 1, 5, 5,  'A Simple Text String', $text_color);

        $path = '/tmp/' . $name . '.jpg';

        imagejpeg($im, '/tmp/' .$name . '.jpg');

        return $path;

    }
}

if (! function_exists('prepareFileUpload')) {

    function prepareFileUpload($path, $name = 'test.jpeg')
    {
        TestCase::assertFileExists($path);

        $finfo = finfo_open(FILEINFO_MIME_TYPE);

        $mime = finfo_file($finfo, $path);

        $size = filesize($path);

        return new UploadedFile($path, $name, $mime, $size, null, true);
    }
}

