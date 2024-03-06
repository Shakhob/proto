<?php
namespace common\components;

use Fifa\ConnectServiceBus\Sdk\Authentication\CacheStorageInterface;

class CustomCacheStorage implements CacheStorageInterface
{
    public function store($key, $value, $expiration = null)
    {
        // Логика сохранения данных в кэше с указанным ключом и временем жизни
        if ($expiration !== null) {
            $expiration = time() + $expiration; // Вычисляем время истечения кэша
        }
        $this->cache[$key] = ['value' => $value, 'expiration' => $expiration];
    }

    public function fetch($key)
    {
        // Проверяем, есть ли данные с указанным ключом в кэше
        if ($this->isCached($key)) {
            // Если данные есть в кэше, возвращаем их, если время жизни не истекло
            if ($this->isExpired($key)) {
                $this->delete($key); // Удаляем просроченные данные из кэша
                return null;
            } else {
                return $this->getFromCache($key);
            }
        } else {
            // Если данных нет в кэше, возвращаем null или другое значение по умолчанию
            return null;
        }
    }


    public function delete($key)
    {
        // Логика удаления кэшированных данных
    }

    public function put($object, string $cacheId)
    {
        // TODO: Implement put() method.
    }

    public function get(string $cacheId)
    {
        // TODO: Implement get() method.
    }
}
