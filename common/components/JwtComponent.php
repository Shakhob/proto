<?php
namespace common\components;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use yii\base\Component;

class JwtComponent extends Component
{
    public static string $key = "itmed"; // Изменено на статическое свойство

    public static function generateToken($userId, $key = null) // Добавлен аргумент $algorithm и $key
    {
        if ($key === null) {
            $key = self::$key; // Используем статическое свойство напрямую
        }

        $payload = [
            "iss" => "itmed",
            "sub" => "auth",
            "iat" => time(),
            "user" => $userId
        ];
        return JWT::encode($payload, $key, 'HS256'); // Передаем третий аргумент, алгоритм
    }

    public static function decodeToken($token)
    {
        $key = self::$key;
        return JWT::decode($token, new Key($key, 'HS256') );
    }
}
