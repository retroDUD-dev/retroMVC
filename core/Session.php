<?php

namespace app\core;

class Session
{
  protected const FLASH_KEY = 'flash_messages';

  public function __construct()
  {
    session_start();
    $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
    foreach ($flashMessages as $key => &$flashMessage) {
      $flashMessage['remove'] = true;
    }
    $_SESSION[self::FLASH_KEY] = $flashMessages;
  }

  public function __destruct()
  {
    $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
    foreach ($flashMessages as $key => &$flashMessage) {
      if ($flashMessage['remove']) {
        unset($flashMessages[$key]);
      }
    }
    $_SESSION[self::FLASH_KEY] = $flashMessages;
  }

  public function setFlash(string|int $key, string $message): void
  {
    $_SESSION[self::FLASH_KEY][$key] = [
      'remove' => false,
      'value' => $message
    ];
  }

  public function getFlash(string|int $key): string|false
  {
    return $_SESSION[self::FLASH_KEY][$key]['value'] ?? false;
  }

  public function set(string|int $key, mixed $value): void
  {
    $_SESSION[$key] = $value;
  }

  public function get(string|int $key): mixed
  {
    return isset($_SESSION[$key]) ? $_SESSION[$key] : false;
  }

  public function remove(string|int $key): void
  {
    $_SESSION[$key] = null;
    unset($_SESSION[$key]);
  }
}
