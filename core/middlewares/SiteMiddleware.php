<?php

namespace app\core\middlewares;

use app\core\Application;
use app\core\exception\ConflictException;
use app\core\middlewares\BaseMiddleware;

class SiteMiddleware extends BaseMiddleware
{
    public function __construct(
        public array $actions = array()
    ) {
    }

    public function execute(): void
    {
        if (!Application::$APP->session->get('newCharacter')) {
            if (empty($this->actions) || in_array(Application::$APP->controller->action, $this->actions)) {
                throw new ConflictException();
            }
        }
    }
}
