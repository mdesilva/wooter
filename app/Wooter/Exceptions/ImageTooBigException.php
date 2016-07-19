<?php

namespace Wooter\Wooter\Exceptions;

use Exception;

class ImageTooBigException extends Exception
{
    protected $message = 'The size of the image is too big';
}