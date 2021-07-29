<?php

namespace app\core;

class Functions
{
    public static function arrayToString(array $arr): string
    {
        $str = '';
        foreach ($arr as $key => $$subArr) {
            if (is_array($$subArr)) {
                foreach ($$subArr as $key => $value) {
                    $str .= $key . ": " . $value . ",\n";
                }
            } else {
                $str .= $key . ": " . $$subArr . ",\n";
            }
        }
        if ($str) {
            substr($str, 0, -2);
        }
        return $str;
    }

    public static function fileOutput(string $str, string $fileName)
    {
        //        $txt = openssl_encrypt($str, 'aes-256-ctr', 'NiceKey-MyDude');
        $fileName = trim($fileName . ".chr");
        $handle = fopen($fileName, "w");
        $r = fwrite($handle, $str, strlen($str));
        fclose($handle);
        return $r;
    }

    public static function fileInput(string $file): string|false
    {
        $length = filesize($file);
        if ($handle = fopen($file, "r")) {
            $r = fread($handle, $length);
            fclose($handle);
            if ($r) {
                return $r;
            }
        }
        return false;
    }
}
