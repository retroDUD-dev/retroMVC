<?php

namespace app\core\middlewares;

abstract class BaseMiddleware
{
    public function __construct()
    {
    }

    abstract public function execute(): void;
}
