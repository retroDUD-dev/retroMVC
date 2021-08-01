<?php

namespace app\core\db;

use \PDO;
use app\core\Application;
use app\core\Model;

abstract class DbModel extends Model
{
    abstract public static function tableName(): string;

    abstract public function attributes(): array;
    abstract public function primaryKey(): string;

    public function save(): void
    {
        $tableName = $this->tableName();
        $attributes = $this->attributes();
        $params = array_map(fn ($attr) => ":$attr", $attributes);
        $statement = self::prepare("INSERT INTO $tableName (" . implode(",", $attributes) . ") VALUES (" . implode(",", $params) . ")");
        foreach ($attributes as $attribute) {
            $statement->bindValue(":$attribute", $this->{$attribute});
        }
        $statement->execute();
    }

    public function update(array $values, array $where): void
    {
        $tableName = $this->tableName();
        $attributes = array_keys($values);
        $sql = '';
        foreach ($where as $key => $value) {
            $sql .= "$key = '" . $value . "' AND";
        }
        $sql = substr($sql, 0, -4);
        foreach ($attributes as $attribute) {
            $statement = self::prepare("UPDATE $tableName SET " . $attribute . "  =  '" . $values[$attribute] . "' WHERE $sql");
            $statement->execute();
        }
    }

    public function delete(array $where): void
    {
        $tableName = $this->tableName();
        $sql = '';
        foreach ($where as $key => $value) {
            $sql .= "$key = '" . $value . "' AND";
        }
        $sql = substr($sql, 0, -4);
        $statement = self::prepare("DELETE FROM $tableName WHERE $sql");
        $statement->execute();
    }

    public function verifyPasswords(array $where, string $password, string $columnName = 'password'): bool
    {
        $tableName = static::tableName();
        $attributes = array_keys($where);
        $sql = implode(" AND ", array_map(fn ($attr) => "$attr = :$attr", $attributes));
        $statement = self::prepare("SELECT * FROM $tableName WHERE $sql");
        foreach ($where as $key => $value) {
            $statement->bindValue(":$key", $value);
        }
        $statement->execute();
        $confirmPassword = $statement->fetchObject(static::class)->{$columnName};
        return password_verify($password, $confirmPassword);
    }

    public function findOne(array $where): object|false
    {
        $tableName = static::tableName();
        $attributes = array_keys($where);
        $sql = implode(" AND ", array_map(fn ($attr) => "$attr = :$attr", $attributes));
        $statement = self::prepare("SELECT * FROM $tableName WHERE $sql");
        foreach ($where as $key => $value) {
            $statement->bindValue(":$key", $value);
        }
        $statement->execute();
        $to= $statement->fetchObject(static::class);
        return $to;
    }

    public function findAll(array $where = array()): array|false
    {
        $tableName = static::tableName();
        if (empty($where)) {
            $statement = self::prepare("SELECT * FROM $tableName");
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_CLASS, static::class);
        } else {
            $attributes = array_keys($where);
            $sql = implode(" AND ", array_map(fn ($attr) => "$attr = :$attr", $attributes));
            $statement = self::prepare("SELECT * FROM $tableName WHERE $sql");

            foreach ($where as $key => $value) {
                $statement->bindValue(":$key", $value);
            }
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_CLASS, static::class);
        }
        return false;
    }

    public static function prepare($sql): object
    {
        return Application::$APP->db->pdo->prepare($sql);
    }
}
