<?php

namespace app\core;

class View
{
    public function __construct(
        public $title = 'retroDUD'
    ) {
    }

    public function renderView($view, $params = array()): string
    {
        $viewContent = $this->renderOnlyView($view, $params);
        $layoutContent = $this->layoutContent();
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    protected function layoutContent(): string|false
    {
        $layout = Application::$APP?->controller?->getLayout() ?? Application::$LAYOUT_MAIN;
        ob_start();
        include_once Application::$ROOT_DIR . "/views/layouts/$layout.php";
        return ob_get_clean();
    }

    protected function renderOnlyView($view, $params): string|false
    {
        foreach ($params as $key => $value) {
            $$key = $value;
        }
        ob_start();
        include_once Application::$ROOT_DIR . "/views/$view.php";
        return ob_get_clean();
    }
}
