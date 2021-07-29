<?php

namespace app\core\middlewares;

use app\core\Application;
use app\core\exception\ForbiddenException;
use app\core\middlewares\BaseMiddleware;

class AuthMiddleware extends BaseMiddleware
{
    public function __construct(
        public array $actions = array()
    ) {
    }

    public function execute(): void
    {
        if (Application::isGuest()) {
            if (empty($this->actions) || in_array(Application::$APP->controller->action, $this->actions)) {
                Application::$APP->response->redirect('/Login');
            }
        }
    }
}
