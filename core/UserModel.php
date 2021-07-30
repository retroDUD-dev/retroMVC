<?php

namespace app\core;

use app\core\db\DbModel;

abstract class UserModel extends DbModel
{
    const STATUS_ACTIVE = 0;
    const STATUS_INACTIVE = 1;
    const STATUS_DELETED = 2;

    const TYPE_ADMIN = 0;
    const TYPE_USER = 1;

    public int $id;
    public int $status = self::STATUS_INACTIVE;
    public int $type = self::TYPE_USER;

    abstract public function getDisplayName(): string;

    public function isActive(): bool
    {
        return !$this->status;
    }

    public function isAdmin(): bool
    {
        return !$this->type;
    }
}
