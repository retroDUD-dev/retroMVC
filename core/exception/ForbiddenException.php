<?php

namespace app\core\exception;

use \Exception;

class ForbiddenException extends Exception
{
    public function __construct(
        protected $code = 403,
        protected $message = 'Access denied'
        ) {
        }

}
