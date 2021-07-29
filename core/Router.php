<?php

namespace app\core;

use app\core\exception\NotFoundException;

class Router
{
    protected array $routes = array();

    public function __construct(
        public Request $request,
        public Response $response
    ) {
    }

    public function get($path, $callback): void
    {
        $this->routes['get'][$path] = $callback;
    }

    public function post($path, $callback): void
    {
        $this->routes['post'][$path] = $callback;
    }

    public function resolve(): mixed
    {

        $path = $this->request->getPath();
        $method = $this->request->method();
        $callback = $this->routes[$method][$path] ?? false;

        if (!$callback) {
            throw new NotFoundException();
        }

        if (is_string($callback)) {
            return Application::$APP->view->renderView($callback);
        }

        if (is_array($callback)) {
            $controller = Application::$APP->controller = new $callback[0];
            $controller->action = $callback[1];
            $callback[0] = $controller;

            foreach ($controller->getMiddlewares() as $key => $middleware) {
                $middleware->execute();
            }
        }
        return call_user_func($callback, $this->request);
    }
}
