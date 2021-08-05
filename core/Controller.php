<?php

namespace app\core;

use app\core\middlewares\BaseMiddleware;

class Controller
{
    public string $action = '';

    protected array $middlewares = array();
    protected string $layout = 'main';

    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }

    public function setMiddlewares($middlewares): void
    {
        $this->middlewares = $middlewares;
    }

    public function getLayout(): string
    {
        return $this->layout;
    }

    public function setLayout($layout): void
    {
        $this->layout = $layout;
    }

    public function render($view, $params = array(), $data = array()): string
    {
        return Application::$APP->view->renderView($view, $params, $data);
    }

    public function registerMiddleware(BaseMiddleware $middleware): void
    {
        array_push($this->middlewares, $middleware);
    }
}
