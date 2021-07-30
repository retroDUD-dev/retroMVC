<?php

namespace app\core;

class Request
{
    public function getPath(): string
    {
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        $position = strpos($path, '?');
        if (!$position) {
            return $path;
        }
        return $path = substr($path, 0, $position);
    }

    public function method(): string
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function isGet(): bool
    {
        return $this->method() === 'get';
    }

    public function isPost(): bool
    {
        return $this->method() === 'post';
    }

    public function getBody(): array
    {
        $body = array();
        if ($this->method() === 'post') {
            foreach ($_POST as $key => $value) {
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        if ($this->method() === 'get') {
            foreach ($_GET as $key => $value) {
                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        return $body;
    }

    public function readFile(string $file): string|false
    {
        if ($this->method() === 'post' || isset($_FILES[$file])) {
            return Functions::fileInput($_FILES[$file]['tmp_name']);
        }
        return false;
    }

    public function checkValue(mixed $value): bool
    {
        return in_array($value, $_REQUEST);
    }

    public function getValue(mixed $needle): mixed
    {
        $array = array_keys($_REQUEST);
        foreach ($array as $haystack) {
            if (str_contains($haystack, $needle)) {
                return $haystack;
            }
        }
        return null;
    }
}
