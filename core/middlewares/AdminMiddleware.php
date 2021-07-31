<?php

namespace app\core\middlewares;

use app\core\Application;
use app\core\exception\ForbiddenException;
use app\core\middlewares\BaseMiddleware;

class AdminMiddleware extends BaseMiddleware
{
    public function __construct(
        public array $actions = array()
    ) {
    }

    public function execute(): void
    {
        if (!Application::isAdmin()) {
            if (empty($this->actions) || in_array(Application::$APP->controller->action, $this->actions)) {
                throw new ForbiddenException();
            }
        }
    }
}
