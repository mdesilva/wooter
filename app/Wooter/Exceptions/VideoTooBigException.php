<?php

namespace Wooter\Wooter\Exceptions;

use Exception;

class VideoTooBigException extends Exception
{
    protected $message = 'The size of the video is too big';
}