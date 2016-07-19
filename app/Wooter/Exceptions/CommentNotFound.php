<?php
namespace Wooter\Wooter\Exceptions;

use Exception;

class CommentNotFound extends Exception
{
    protected $message = 'The comment does not exist';
}