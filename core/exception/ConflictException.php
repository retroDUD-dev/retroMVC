<?php

namespace app\core\exception;

use \Exception;

class ConflictException extends Exception
{
    public function __construct(
        protected $code = 409,
        protected $message = 'Don\'t skip steps! You\'ll break my page!'
        ){
            
        }
}