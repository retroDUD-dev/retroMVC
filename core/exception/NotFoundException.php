<?php

namespace app\core\exception;

use \Exception;

class NotFoundException extends Exception
{
    public function __construct(
        protected $code = 404,
        protected $message = 'Page not found'
    ) {}
}
