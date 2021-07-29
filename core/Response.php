<?php

namespace app\core;

class Response
{
    public function setStatusCode(mixed $code): void
    {
        if (!is_integer($code)) {
            http_response_code(500);
        } else {
            http_response_code($code);
        }
    }

    public function redirect(string $url): void
    {
        header('Location: ' . $url);
    }

    public function download($file)
    {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($file) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        readfile($file);
    }
}
